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

if($_POST){

$con = mysql_connect("localhost", "web", "wearegeniuses");
if (!$con)
    die("Connection failed: " . mysql_error());
mysql_select_db("StudyNetwork", $con);


	$fName = $_POST['f_name'];
	$lName = $_POST['l_name'];
	$uid = $_POST['uid'];
	$email = $_POST['email'];
	$password = $_POST['passwd'];


	$insertion = "INSERT INTO Users (uid, f_name, l_name, email, passwd) VALUES ('$uid', '$fName', '$lName', '$email', '$password');";
	mysql_query($insertion);
	echo "<h2>Thank you for your information</h2>";

	$newQuery = "SELECT * FROM Users";
	$results = mysql_query($newQuery);

	echo "<h1>Users Entered</h1>";
	while($row = mysql_fetch_array($results, MYSQL_ASSOC))
	{
		echo "User: " . $row['f_name']. " ". $row['l_name']. "      Email: " . $row['email']. "     Id #: " . $row['uid']. "  Password: ". $row['passwd'] . "<br>";
	}

	/*$sqlRes = $con->query("SELECT * FROM Users");

	if($sqlRes === NULL)
		echo "There is no data";
	else
	{
		echo "There is SOMETHING in the query";
		while($row = $sqlRes->fetch_assoc())
		{
			echo "id: " . $row["uid"]. " -- Name: " . $row["f_name"]. " " . $row["l_name"]. " --Email: " . $row["email"]."
			<br>";
		}
	}

	if($fName === "" || $lName === "" || $email === "" || $password === "" || uid === ""){
		echo "Please enter data in all of the fields";
		
	}
	else{
		$duplicateCheck = $con->query("SELECT * FROM Users WHERE (uid = '$uid') AND (email = '$email') LIMIT 1");
		$num_rows = mysql_fetch_array($duplicateCheck);
		if($num_rows > 0)
		{
			echo "User Already Exists";
		}
		else
		{
			$insertion = "INSERT INTO Users (uid, f_name, l_name, email, passwd) VALUES ('$newID', '$fName', '$lName', '$email', '$password');";
			//mysql_query($insertion);
			//echo "<h2>Thank you for yor information</h2>";
		}

		/*$duplicateCheck = $database->query("SELECT email, uid FROM Users WHERE email = '$email' AND uid = '$uid' LIMIT 1");
		$checkResults = $duplicateCheck->fetch_assoc();
		if(!($checkResults === NULL))
			echo "You are the only user with this email";
		else
		{
			//$prevUser = $database->query("SELECT uid FROM Users ORDER BY uid DESC LIMIT 1");
			//$row = $prevUser->fetch_assoc();
			//if($row === NULL){
				//$outputJSON = array ('uid' => $uid);
				//$insertion = $database->query("INSERT INTO Users (uid, f_name, l_name, email, passwd) VALUES ($uid, $fName, $lName, $email, $password)");
			}
			else{
				$newID = $row['uid']+1;
				$outputJSON = array ('uid'=>$newID);
				$insertion = $database->query("INSERT INTO Users (uid, f_name, l_name, email, passwd) VALUES ($newID, $fName, $lName, $email, $password");
			}
		}*/
	//}*/

}

?>
	<h2><font color = rgb(51,102,153)> Please enter the following information </font></h2>
	<form method="post" action="createProfile2.php" id = "createAccount" name = "createAccount">
	First Name: <input type = "text" name = "f_name" /><br />
	Last Name: <input type = "text" name = "l_name"/><br />
	SMU ID: <input type = "text" name = "uid"/><br />
	Email: <input type = "text" name = "email"/><br />
	Password: <input type = "password" name = "passwd"/><br />
	<input type = "submit" class = "button" id = "CreateAccount">
</form>
</body>
</html>
