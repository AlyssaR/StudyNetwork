<?php
require 'vendor/autoload.php';

$app = new \Slim\Slim();
$database = new mysqli("localhost", "web", "wearegeniuses", "StudyNetwork");
if ($database->connect_errno)
    die("Connection failed: " . $database->connect_error);

$app->post('/login', function () use ($database) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    //Remove duplicates
    $runQuery = $database->query("SELECT uid, f_name, l_name FROM Users WHERE email = '$email' AND passwd = '$password' LIMIT 1");
    $result = $runQuery->fetch_assoc();

    //Frame response
    if($result === NULL)
    	$response = array("success"=>false, "id"=>0,"f_name"=>"Not Valid","l_name"=>"Not Valid");
	else {
		$response = array ("success"=>true, "f_name"=>$result['f_name'],"l_name"=>$result['l_name']);
		session_start();
		$_SESSION["loggedin"] = $result['uid'];
	}
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
	$results = $database->query("SELECT * FROM Users WHERE uid = '$uid' OR email = '$email';");
	if($results->num_rows > 0) {
		$error = "User already exists";
		$success = false;
	}
	//Add user
	else
		$database->query("INSERT INTO Users (uid, f_name, l_name, email, passwd) VALUES ('$uid', '$fName', '$lName', '$email', '$password');");

	//Respond
	$response = array("success"=>$success, "f_name"=>$fName, "errorType"=>$error);
	echo json_encode($response);
});

$app->post('/addClass', function() use ($database){
	$dept = $_POST['dept'];
	$class_num = $_POST['class_num'];
	$time2 = $_POST['time2'];
	$professor = $_POST['professor'];
	//$cid = $_POST['class_num'];
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
	$num_members = $_POST['num_members'];
	$error = "None";
	$success = true;

	$database->query("INSERT INTO Classes (gid, cid, admin, gname, time1, loc, num_members) VALUES (, , , '$gname', '$time1', '$loc', '$num_members');");
		$response = array("success"=>$success, "gname"=>$gname, "errorType"=>$error);
	echo json_encode($response);
});

$app->run();
?>