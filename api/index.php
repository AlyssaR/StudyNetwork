<?php
require 'vendor/autoload.php';

$app = new \Slim\Slim();
$database = new mysqli("localhost", "web", "wearegeniuses", "StudyNetwork");
if ($database->connect_errno)
    die("Connection failed: " . $database->connect_error);


$app->post('/addClass', function() use ($database){
	$dept = $_POST['dept'];
	$class_num = $_POST['class_num'];
	$time2 = $_POST['time2'];
	$professor = $_POST['professor'];
	$error = "None";
	$success = true;

	$database->query("INSERT INTO Classes (cid, dept, class_num, time2, professor) VALUES (, '$dept', '$class_num', '$time2', '$professor');");
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
	$uid = $_POST['uid'];
	$success = true;

	$runQuery = $database->query("SELECT f_name, l_name, email FROM Users WHERE uid = '$uid';");
	$result = $runQuery->fetch_assoc();
	if($fName === "ignore")
		$fName = $result['f_name'];
	if($lName === "ignore")
		$lName = $result['l_name'];
	if($email === "ignore")
		$email = $result['email'];

	$database->query("UPDATE Users SET f_name = '$fName' and l_name = '$lName' and email = '$email' WHERE uid = '$uid';");

	$runQuery = $database->query("SELECT f_name, l_name, email FROM Users WHERE uid = '$uid';");
	$result = $runQuery->fetch_assoc();

	if($result === NULL || !($fName === $result['f_name'] && $lName === $result['l_name'] && $email === $result['email']))
		$success = false;
	$response = array("success"=>$success, "uid"=>$uid, "f_name"=>$fName, "l_name"=>$lName, "email"=>$email);
	echo json_encode($response);
});

$app->post('/getUserInfo', function () use ($database) {
    $uid = $_POST['uid'];

    $runQuery = $database->query("SELECT f_name, l_name, email FROM Users WHERE uid = '$uid' LIMIT 1");
    $result = $runQuery->fetch_assoc();

    //Frame response
    if($result === NULL)
    	$response = array("success"=>false, "id"=>0,"f_name"=>"Not Valid","l_name"=>"Not Valid", "error"=>"User ID not valid.");
	else
		$response = array ("success"=>true, "f_name"=>$result['f_name'],"l_name"=>$result['l_name'], "email"=>$result['email'], "error"=>"None");
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
    	$response = array("success"=>false, "uid"=>0,"f_name"=>"Not Valid","l_name"=>"Not Valid");
	else
		$response = array("success"=>true, "uid"=>$result['uid'], "f_name"=>$result['f_name'],"l_name"=>$result['l_name']);
    echo json_encode($response);
});

$app->post('/register', function () use ($database) {
	$fName = $_POST['f_name'];
	$lName = $_POST['l_name'];
	$uid = $_POST['uid'];
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
	$response = array("success"=>$success, "uid"=>$uid, "f_name"=>$fName, "errorType"=>$error);
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

//
$app->post('/joinStudyGroup', function() use ($database) {
    $gid = $_POST['gid'];
    $role = $_POST['role'];
    $database->query("INSERT INTO GroupEnroll (uid, gid, role) VALUES (" . $_SESSION["loggedin"] . ", " . $gid . ", " . $role . ")");
});

$app->run();
?>
