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

	//$dataInserted = $database->query("SELECT * FROM Users");
	$sqlRes = $database->query("SELECT * FROM Users");
	//$result = mysql_query($sqlRes)

	if($sqlRes === NULL)
		//$response = array("success"=>false, "id"=>0, )
		echo "There is no data";
	else
	{
		echo "There is SOMETHING in the query";
		while($row = $sqlRes->fetch_assoc())
		{
			echo "id: " . $row["uid"]. " -- Name: " . $row["f_name"]. " " . $row["l_name"]. " --Email: " . $row["email"]."
			<br>";
		}
		//$response = array("success"=>true, "f_name"=>$sqlRes['f_name'], "l_name"=>$sqlRes['l_name'], "uid"=>$sqlRes['uid'], "email"=>$sqlRes['email'], "password"=>$sqlRes['passwd']);
		//print_r ($response)
	}

	if($fName === "" || $lName === "" || $email === "" || $password === "" || uid === ""){
		echo "Please enter data in all of the fields";
		
	}
	else{
		$duplicateCheck = $database->query("SELECT email FROM Users WHERE email = '$email' LIMIT 1");
		$checkResults = $duplicateCheck->fetch_assoc();
		if(!($checkResults === NULL))
			echo "You are the only user with this email";
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
	Password: <input type = "password" name = "passwd" /><br />
	<input type = "submit" class = "button" id = "CreateAccount">
</form>
</body>
</html>
