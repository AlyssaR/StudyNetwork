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
	$gid = 0;
	//Assign incremented ID
	$gidStart = $database->query("SELECT gid FROM StudyGroups ORDER BY gid DESC LIMIT 1;");
	if($gidStart->num_rows > 0) {
		$lastGID = $gidStart->fetch_assoc();
		$gid = $lastGID['gid'] + 1;
	}
	//$num_members = $_POST['num_members'];
	
	$uid = $_SESSION["uid"];
	$role = "admin";
	$error = "None";
	$success = true;
	$database->query("INSERT INTO StudyGroups (gid, admin_id, gname, time1, loc, num_members) VALUES ('$gid', '$uid', '$gname', '$time1', '$loc', 1);");
	$database->query("INSERT INTO GroupEnroll VALUES ('$uid', '$gid', '$role', TRUE);");
	
	$response = array("success"=>$success, "gname"=>$gname, "errorType"=>$error);
	echo json_encode($response);
});

$app->post('/editprofile', function () use ($database) {
	$fName = $_POST['f_name'];
	$lName = $_POST['l_name'];
	$email = $_POST['email'];
	$pass = $_POST['password'];
	$uid = "";
	if(isset($_SESSION["uid"]))
	    $uid = $_SESSION["uid"];
	else {
		echo json_encode(array("success"=>false, "error"=>"Not logged in"));
		return;
	}
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
		$runQuery = $database->query("SELECT COUNT(*) as count FROM Users WHERE email = '$email' LIMIT 1;");
		$checkQuery = $runQuery->fetch_assoc();
		if($checkQuery['count'] > 0) {
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

$app->post('/editStudyGroup', function() use ($database){
	$gname = $_POST['gname'];
	$time1 =  $_POST['time1'];
	$loc = $_POST['loc'];
	$gid = $_POST['gid'];
	$success = true;
	$errorType = "None";

	$runQueryEG = $database->query("SELECT gname, time1, loc FROM StudyGroups WHERE gid = '$gid';");
	$resultEG = $runQueryEG->fetch_assoc();
	if($gname === "ignore")
		$gname = $resultEG['gname'];
	if($time1 === "ignore")
		$time1 = $resultEG['time1'];
	if($loc === "ignore")
		$loc = $resultEG['loc'];

	$database->query("UPDATE StudyGroups SET gname = '$gname', time1 = '$time1', loc = '$loc' WHERE gid = '$gid';");
	$runQueryEG = $database->query("SELECT gname, time1, loc FROM StudyGroups WHERE gid = '$gid';");
	$resultEG = $runQueryEG->fetch_assoc();

	if($resultEG === NULL || !($gname === $resultEG['gname'] && $time1 === $resultEG['time1'] && $loc === $resultEG['loc'])) {
		$success = false;
		$errorType = "Error making your changes. Please try again later.";
	}

	$response = array("success"=>$success, "gid"=>$gid, "gname"=>$gname, "time1"=>$time1, "loc"=>$loc, "errorType"=>$errorType);
	echo json_encode($response);
});

//This is to get groups to redirect to group profile page
$app->post('/getGroupInfo', function () use ($database) {
	if(isset($_POST['gid']))
		$gid = $_POST['gid'];
	else {
		echo json_encode(array("gid"=>$_POST['gid']));
		return;
	}
	$runQuery = $database->query("SELECT gname, time1, loc FROM StudyGroups WHERE gid = '$gid' LIMIT 1;");
	$result = $runQuery->fetch_assoc();

	//some response
	if($result === NULL)
		$response = array("success"=>false, "gname"=>"Not Valid", "time1"=>"Not Valid", "loc"=>"Not Valid", "error"=>"This is not the correct group");
	else
		$response = array("success"=>true, "gname"=>$result['gname'], "time1"=>$result['time1'], "loc"=>$result['loc'], "error"=>"None");
	echo json_encode($response);
});

//This is to get Groups for the user profile page
$app->post('/getGroups', function () use ($database) {
	$uid = "";
	if(isset($_SESSION["uid"]))
	    $uid = $_SESSION["uid"];
	else {
		echo json_encode(array("success"=>false, "error"=>"Not logged in"));
		return;
	}
	$runQuery = $database->query("SELECT gname, time1, loc, g.gid FROM StudyGroups s, GroupEnroll g WHERE s.gid = g.gid AND g.uid = '$uid';");
	
	$response = array();
	if ($runQuery->num_rows != 0) {
		while($row = $runQuery->fetch_assoc()) 
			$response[] = array("success"=>true, "gname"=>$row['gname'], "time1"=>$row['time1'], "loc"=>$row['loc'], "gid"=>$row['gid'], "error"=>"None");

		echo json_encode($response);
	}
	else
		echo json_encode(array("success"=>false, "error"=>"No groups found"));
});

/*$app->post('/getGroups_searchByClass', function () use ($database) {
	$uid = "";
	if(isset($_SESSION["dept"]) AND isset($SESSTION["class_num"]))
		$dept = ($_SESSION["dept"]);
		$class_num = ($SESSTION["class_num"]);
	    $cid = $dept + $class_num;
	else {
		echo json_encode(array("success"=>false, "error"=>"Not logged in"));
		return;
	}
	$runQuery = $database->query("SELECT gname, time1, loc FROM StudyGroups s, WHERE s.cid = '$cid';");
	
	$response = array();
	if ($runQuery->num_rows != 0) {
		while($row = $runQuery->fetch_assoc()) 
			$response[] = array("success"=>true, "gname"=>$row['gname'], "time1"=>$row['time1'], "loc"=>$row['loc'], "error"=>"None");

		echo json_encode($response);
	}
	else
		echo json_encode(array("success"=>false, "error"=>"No groups found"));
});*/

$app->post('/getUserID', function () {
	if(isset($_SESSION["uid"]))
		echo json_encode(array("success"=>true,"uid"=>$_SESSION["uid"]));
	else
		echo json_encode(array("success"=>false));
});

$app->post('/getUserInfo', function () use ($database) {
    $uid = "";
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

//Quincy Schurr - joinStudyGroup branch
$app->post('/joinStudyGroup', function() use ($database) {
	$uid = $_SESSION['uid'];
    $gid = $_POST['gid'];
    $role = "member";
    $database->query("INSERT INTO GroupEnroll VALUES('$uid', '$gid', '$role', TRUE);");
    echo json_encode(array("success"=>true));
});

$app->post('/leaveStudyGroup', function() use ($database) {
	$uid = $_SESSION['uid'];
	$gid = $_POST['gid'];
	$database->query("DELETE FROM GroupEnroll WHERE gid = '$gid' and uid = '$uid';");
	echo json_encode(array("success"=>true));
});

$app->post('/login', function () use ($database) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    //Remove duplicates
    $runQuery = $database->query("SELECT uid, f_name, l_name FROM Users WHERE email = '$email' AND passwd = '$password' LIMIT 1;");
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
	else {
		$database->query("INSERT INTO Users (uid, f_name, l_name, email, passwd) VALUES ('$uid', '$fName', '$lName', '$email', '$password');");
		$_SESSION["uid"] = $uid;
	}

	//Respond
	$response = array("success"=>$success, "f_name"=>$fName, "uid"=>$uid, "errorType"=>$error);
	echo json_encode($response);
});

// expects array of values, returns json array named 'search' of results from first value (for now)
$app->post('/search', function() use ($database) {
  $search = array();
  if (!empty($_POST['search'])) {
    $search = json_decode($_POST['search'], true);
    // perform the search
    $response = $database->query("SELECT * FROM StudyGroups WHERE gid = " . $search[0] . " OR cid = " . $search[0]
    . " OR creator = " . $search[0]
    . " OR gname = " . $search[0]
    . " OR time1 = " . $search[0]
    . " OR loc = " . $search[0]
    . " OR num_members = " . $search[0]);
    echo json_encode($response);
  }
});

/*$app->post('/searchByClass', function() use ($database) {
	$class = array();
	if(!empty($_POST['class'])) {
//		$search = json_decode($_POST['class'], true); 	
  		$class = explode(" ", $_POST['class']); //split search into seperate dept and number
  		$cid = $database->query("SELECT cid FROM Classes WHERE dept = '$class[0]' AND class_num = '$class[1])';"); //get cid
  		if($cid === NULL)
  			$result = "ERROR: No groups exist for that course.";
  		else
    		$response = $database->query("SELECT gname FROM StudyGroups WHERE cid = '$cid';"); //use cid to get list of groups
    	echo json_encode($response);
    }
});*/
// issue: search for classes v2
/*$app->get('/searchForClasses', function() use ($database) {
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
});*/

$app->run();
?>