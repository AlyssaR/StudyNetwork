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

	$checkDup = "SELECT * FROM Users WHERE(uid = '$uid' OR email = '$email')";
	$dupraw = mysql_query($checkDup);

	if(mysql_num_rows($dupraw) > 0)
	{
		echo "This user already exists";
	}
	else
	{

		$insertion = "INSERT INTO Users (uid, f_name, l_name, email, passwd) VALUES ('$uid', '$fName', '$lName', '$email', '$password');";
		mysql_query($insertion);
		$newFName = "SELECT f_name FROM Users WHERE (f_name = '$fName')";
		//$newFName = mysql_result($newFName, 0);
		$newLName = "SELECT l_name FROM Users WHERE (l_name = '$lName')";
		//$newLName = mysql_query($newLName);

		//echo $newFName. " ". $newLName. " your account has been created". "<br>";
		echo "<h2>Thank you for your information</h2>";

		$newQuery = "SELECT * FROM Users";
		$results = mysql_query($newQuery);


		//echo "<h1>Users Entered</h1>";
		//while($row = mysql_fetch_array($results, MYSQL_ASSOC))
		//{
			//echo "User: " . $row['f_name']. " ". $row['l_name']. "      Email: " . $row['email']. "     Id #: " . $row['uid']. "  Password: ". $row['passwd'] . "<br>";
		//}
	}

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
