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
    $runQuery = $database->query("SELECT f_name, l_name FROM Users WHERE email = '$email' AND passwd = '$password' LIMIT 1");
    $result = $runQuery->fetch_assoc();

    //Frame response
    if($result === NULL)
    	$response = array("success"=>false, "id"=>0,"f_name"=>"Not Valid","l_name"=>"Not Valid");
	else {
		$response = array ("success"=>true, "f_name"=>$result['f_name'],"l_name"=>$result['l_name']);
	}
    echo json_encode($response);
});

$app->post('/register', function () use ($database) {
	$fName = $_POST['f_name'];
	$lName = $_POST['l_name'];
	$uid = $_POST['uid'];
	$email = $_POST['email'];
	$password = $_POST['passwd'];

	$database->query("INSERT INTO Users (uid, f_name, l_name, email, passwd) VALUES ('$uid', '$fName', '$lName', '$email', '$password');");
});

$app->run();
?>