<html>
<head><title>Create Your Profile</title>
	<script type = "text/javascript" scr = "bin/accounts.js"></script>

</head>
<style>
body {
	background-color: rgb(204, 255, 230);
}
h1 {
	background-color: #00f000;
}
p {
	background-color: rgb(255, 0, 255);
}
</style>
<body>

<?php
$database = new mysqli("localhost", "web", "wearegeniuses", "StudyNetwork");
if ($database->connect_errno)
    die("Connection failed: " . $database->connect_error);

	$fName = $POST['f_name'];
	$lName = $POST['l_name'];
	$email = $_POST['email'];
	$password = $_POST['passwd'];
	$uid = $_POST['uid'];
	if($fName === "" || $lName === "" || $email === "" || $password === "" || uid === ""){
		echo "Please enter data in all of the fields";
		
	}
	else{
		$duplicateCheck = $database->query("SELECT email FROM Users WHERE email = '$email' LIMIT 1");
		$checkResults = $duplicateCheck->fetch_assoc();
		if(!($checkResults === NULL))
			$outputJSON = array ('uid'=>-1);
		else
		{
			$prevUser = $database->query("SELECT uid FROM Users ORDER BY uid DESC LIMIT 1");
			$row = $prevUser->fetch_assoc();
			if($row === NULL){
				$outputJSON = array ('uid' => $uid);
				$insertion = $database->query("INSERT INTO Users (uid, f_name, l_name, email, passwd) VALUES ($uid, $fName, $lName, $email, $password)");
			}
			else{
				$newID = $row['uid']+1;
				$outputJSON = array ('uid'=>$newID);
				$insertion = $database->query("INSERT INTO Users (uid, f_name, l_name, email, passwd) VALUES ($newID, $fName, $lName, $email, $password");
			}
		}
	}
?>


	<h2><font color = rgb(51,102,153)> Please enter the following information </font></h2>
	<form method="post" action="createProfile2.php" id = "createAccount" name = "createAccount">
	First Name: <input type = "text" name = "f_name" /><br />
	Last Name: <input type = "text" name = "l_name" /><br />
	SMU ID: <input type = "text" name = "uid" /><br />
	Email: <input type = "text" name = "email" /><br />
	Password: <input type = "text" name = "passwd" /><br />
	<input type = "submit" class = "button" id = "CreateAccount">
</form>
</body>
</html>
