<?php
require 'vendor/autoload.php';

session_set_cookie_params(1800);
session_cache_limiter(false);
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
	//$num_members = $_POST['num_members'];
	$error = "None";
	$success = true;

	$database->query("INSERT INTO StudyGroups (gid, cid, admin, gname, time1, loc, num_members) VALUES (, , , '$gname', '$time1', '$loc', ,);");
		$response = array("success"=>$success, "gname"=>$gname, "errorType"=>$error);
	echo json_encode($response);
});

//allows User to edit the studyGroup
//Quincy Schurr
$app->post('editStudyGroup', function() use ($database){
	$gname = $_POST['gname'];
	$time1 =  $_POST['time1'];
	$loc = $_POST['loc'];
	$success = true;

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

	if($resultEG === NULL || !($gname === $resultEG['gname'] && $time1 === $resultEG['time1'] && $loc === $resultEG['loc']))
		$success = false;
	$response = array("success"=>$success, "gid"=>$gid, "gname"=>$gname, "time1"=>$time1, "loc"=>$loc, "errorType"=>"None");
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

$app->post('/getGroup', function () use ($database) {
	$runQuery = $database->query("SELECT gname, time1, loc FROM StudyGroups WHERE gid = '$gid' LIMIT 1");
	$result = $runQuery->fetch_assoc();

	//some response
	if($result === NULL)
		$response = array("success"=>false, "gname"=>"Not Valid", "time1"=>"Not Valid", "loc"=>"Not Valid", "error"=>"This is not the correct group");
	else
		$response = array("success"=>true, "gname"=>$result['gname'], "time1"=>$result['time1'], "loc"=>$result['loc'], "error"=>"None");
	echo json_encode($response);
});

//
$app->post('/joinStudyGroup', function() use ($database) {
    $gid = $_POST['gid'];
    $role = $_POST['role'];
    $database->query("INSERT INTO GroupEnroll (uid, gid, role) VALUES (" . $_SESSION["loggedin"] . ", " . $gid . ", " . $role . ")");
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
	unset($_SESSION["uid"]);
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

$app->run();
?>
