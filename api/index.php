<?php
require 'vendor/autoload.php';

$app = new \Slim\Slim();
$database = new mysqli("localhost", "web", "wearegeniuses", "StudyNetwork");
if ($database->connect_errno)
    die("Connection failed: " . $database->connect_error);

$app->post('/login', function () {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $result = $mysqli->query("SELECT f_name, l_name FROM Users WHERE email = '$email' AND passwd = '$password' LIMIT 1");
    
    if($result === NULL)
    	$response = array("success"=>false, "id"=>0,"f_name"=>"Not Valid","l_name"=>"Not Valid");
	else {
		$response = array ("success"=>true, "f_name"=>$result['f_name'],"l_name"=>$result['l_name']);
	}

    mysqli_free_result($result);
    echo json_encode($response);
});

$app->post('/createUserAccount', function () {
	global $mysqli;
	$fName = $POST['f_name'];
	$lName = $POST['l_name'];
	$email = $_POST['email'];
	$password = $_POST['passwd'];
	$uid = $_POST['uid'];
	if($fName === "" || $lName === "" || $email === "" || $password === "" || uid === "")
		$outputJSON = array ('uid'=>-2);
	else{
		$duplicateCheck = $mysqli->query("SELECT email FROM Users WHERE email = '$email' LIMIT 1");
		$checkResults = $duplicateCheck->fetch_assoc();
		if(!($checkResults === NULL))
			$outputJSON = array ('uid'=>-1);
		else
		{
			$prevUser = $mysqli->query("SELECT uid FROM Users ORDER BY uid DESC LIMIT 1");
			$row = $prevUser->fetch_assoc();
			if($row === NULL){
				$outputJSON = array ('uid' => $uid);
				$insertion = $mysqli->query("INSERT INTO Users (uid, f_name, l_name, email, passwd) VALUES ($uid, $fName, $lName, $email, $password)");
			}
			else{
				$newID = $row['uid']+1;
				$outputJSON = array ('uid'=>$newID);
				$insertion = $mysqli->query("INSERT INTO Users (uid, f_name, l_name, email, passwd) VALUES ($newID, $fName, $lName, $email, $password");
			}
		}
	}
});

$app->run();
?>