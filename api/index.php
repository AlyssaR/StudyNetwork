<?php
require 'vendor/autoload.php';
session_cache_limiter(false);
$cookieParams = session_get_cookie_params(); // Gets current cookies params.
session_set_cookie_params(30*60, $cookieParams["path"], $cookieParams["domain"], false, true); //Turns on HTTP only (helps mitigate some XSS)
session_name("StudyNetwork");
session_start();

$app = new \Slim\Slim();
$database = new mysqli("localhost", "web", "wearegeniuses", "StudyNetwork");
if ($database->connect_errno)
    die("Connection failed: " . $database->connect_error);

$app->get('/test', function() use ($database) {
  echo "Hello!!!";
});

$app->post('/addClass', function() use ($database){
	$dept = $_POST['dept'];
	$class_num = $_POST['class_num'];
	$time2 = $_POST['time2'];
	$professor = strtolower($_POST['prof_first'] . " " . $_POST['prof_last']);
	$error = "None";
	$success = true;

	$database->query("INSERT INTO Classes (cid, dept, time2, professor) VALUES ('$class_num', '$dept', '$time2', '$professor');");
	$response = array("success"=>$success, "dept"=>$dept, "errorType"=>$error);
	echo json_encode($response);
});

$app->post('/addGroup', function() use ($database){
	$gname = $_POST['gname'];
	$time1= $_POST['time1'];
	$loc = $_POST['loc'];
	//$num_members = $_POST['num_members'];
	$error = "None";
	$success = true;

	$database->query("INSERT INTO Classes (gid, cid, admin, gname, time1, loc, num_members) VALUES (, , , '$gname', '$time1', '$loc', ,);");
		$response = array("success"=>$success, "gname"=>$gname, "errorType"=>$error);
	echo json_encode($response);
});

$app->post('/editprofile', function () use ($database) {
	$fName = $_POST['f_name'];
	$lName = $_POST['l_name'];
	$email = $_POST['email'];
	$pass = $_POST['password'];
	$uid = $_POST['uid'];
	$success = true;

	$runQuery = $database->query("SELECT f_name, l_name, email, passwd FROM Users WHERE uid = '$uid';");
	$result = $runQuery->fetch_assoc();
	if($fName === "ignore")
		$fName = $result['f_name'];
	if($lName === "ignore")
		$lName = $result['l_name'];
	if($email === "ignore")
		$email = $result['email'];
	else { //If email already exists in database
		$runQuery = $database->query("SELECT COUNT(*) FROM Users WHERE email = '$email';");
		if($runQuery->num_rows > 0) {
			$response = array("success"=>false, "uid"=>0, "f_name"=>0, "l_name"=>0, "email"=>0, "errorType"=>"Error: Email is already associated with an account.");
			echo json_encode($response);
			return;
		}
	}
	if($pass === "ignore")
		$pass = $result['passwd'];

	$database->query("UPDATE Users SET f_name = '$fName', l_name = '$lName', email = '$email', passwd = '$pass' WHERE uid = '$uid';");

	$runQuery = $database->query("SELECT f_name, l_name, email FROM Users WHERE uid = '$uid';");
	$result = $runQuery->fetch_assoc();

	if($result === NULL || !($fName === $result['f_name'] && $lName === $result['l_name'] && $email === $result['email']))
		$success = false;
	$response = array("success"=>$success, "uid"=>$uid, "f_name"=>$fName, "l_name"=>$lName, "email"=>$email, "errorType"=>"None");
	echo json_encode($response);
});

$app->post('/getUserInfo', function () use ($database) {
    if(isset($_SESSION["uid"]))
	    $uid = $_SESSION["uid"];
	else {
		echo json_encode(array("success"=>false, "error"=>"Not logged in"));
		return;
	}

    $runQuery = $database->query("SELECT f_name, l_name, email FROM Users WHERE uid = '$uid' LIMIT 1");
    $result = $runQuery->fetch_assoc();

    //Frame response
    if($result === NULL)
    	$response = array("success"=>false, "id"=>0,"f_name"=>"Not Valid","l_name"=>"Not Valid", "error"=>"User ID not valid.");
	else
		$response = array("success"=>true, "f_name"=>$result['f_name'],"l_name"=>$result['l_name'], "email"=>$result['email'], "error"=>"None");
    echo json_encode($response);
});

$app->post('/login', function () use ($database) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    //Remove duplicates
    $runQuery = $database->query("SELECT uid, f_name, l_name FROM Users WHERE email = '$email' AND passwd = '$password' LIMIT 1");
    $result = $runQuery->fetch_assoc();

    //Frame response
    if($result === NULL)
    	$response = array("success"=>false, "uid"=>-1,"f_name"=>"Not Valid","l_name"=>"Not Valid");
	else {
		$response = array("success"=>true, "uid"=>$result['uid'], "f_name"=>$result['f_name'],"l_name"=>$result['l_name']);
		$_SESSION["uid"] = $response["uid"];
	}
    echo json_encode($response);
});

$app->post('/logout', function () {
	$_SESSION = array(); //Unsets all variables
	$params = session_get_cookie_params(); //Expires/Deletes cookie
    setcookie(session_name(), '', time() - 60,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]);
	session_destroy(); //Ends session server side
});

$app->post('/register', function () use ($database) {
	$fName = $_POST['f_name'];
	$lName = $_POST['l_name'];
	$uid = 0; //First user

	//Assign incremented ID
	$uidStart = $database->query("SELECT uid FROM Users ORDER BY uid DESC LIMIT 1;");
	if($uidStart->num_rows > 0) {
		$lastUID = $uidStart->fetch_assoc();
		$uid = $lastUID['uid'] + 1;
	}

	$email = $_POST['email'];
	$password = $_POST['passwd'];
	$error = "None";
	$success = true;

	//Check for duplicates
	$results = $database->query("SELECT * FROM Users WHERE email = '$email';");
	if($results->num_rows > 0) {
		$error = "User already exists";
		$success = false;
	}
	//Add user
	else
		$database->query("INSERT INTO Users (uid, f_name, l_name, email, passwd) VALUES ('$uid', '$fName', '$lName', '$email', '$password');");

	//Respond
	$response = array("success"=>$success, "f_name"=>$fName, "uid"=>$uid, "errorType"=>$error);
	echo json_encode($response);
});

// issue: search for classes v2
$app->get('/searchForClasses', function() use ($database) {
  $json = json_decode($_GET["search"], true);
  // build query string
  $query = "SELECT * FROM Classes WHERE";
  for ($i = 0; $i < count($json); $i++) {
    $query = $query . " dept LIKE " . $json[$i] . " OR class_num LIKE " . $json[$i] . " OR time2 LIKE " . $json[$i] . " OR professor LIKE " . $json[$i] . " ";
    if ($i < count($json) - 1) {
      $query = $query . "OR";
    }
  }
  $query = $query . ";";
  $result = $database->query($query);
  echo json_encode($query);
});

// issue: join study group
$app->get('/joinStudyGroup', function() use ($database) {

});

/***************************************************
*
* Courtney's Section
*
* Search By:
* 	-Class
*	-Professor
*	-
****************************************************/

/*
$app->post('/searchByClass', function() use ($database) {
	$class = array();
	$results = array();
	if(!empty($_POST['search'])) {
		$search = json_decode($_POST['search'], true);
  		$class = explode(" ", $_POST['search']; //split search into seperate dept and number
  		$cid = $database->quary("SELECT cid FROM Classes WHERE dept = '$class[0]' AND class_num= '$class[1])' " //get cid
    	$response = $database->query("SELECT gname FROM StudyGroups WHERE cid = '$cid' " //use cid to get list of groups
    }
});*/


$app->run();
?>
