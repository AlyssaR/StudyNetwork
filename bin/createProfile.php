<?php

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


$app->post('/loginUser', function () {
	$response = array ('status' => "Success", "id"=>$row['uid'], "f_name"=>$row['f_name'], "l_name"=>$row['l_name']);
	$email = $_POST['email'];
	$password = $_POST['passwd'];
	echo json_encode($response);
});
?>