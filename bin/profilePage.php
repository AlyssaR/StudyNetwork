<html>
<head><title>Welcome to the Study Network</title>
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


	$dept = $_POST['dept'];
	$class_num = $_POST['class_num'];
	$time2 = $_POST['time2'];
	$professor = $_POST['professor'];
	$cid = $_POST['class_num'];

	$checkDup = "SELECT * FROM Classes WHERE(class_num = '$class_num')";
	$dupraw = mysql_query($checkDup);

	if(mysql_num_rows($dupraw) > 0)
	{
		echo "This class already exists";
	}
	else
	{

		$insertion = "INSERT INTO Classes (cid, dept, class_num, time2, professor) VALUES (, '$dept', '$class_num', '$time2', '$professor');";
		mysql_query($insertion);

		echo "<h2>You have added a class</h2>";

		$newQuery = "SELECT * FROM Users";
		$results = mysql_query($newQuery);


		echo "<h1>Users Entered</h1>";
		while($row = mysql_fetch_array($results, MYSQL_ASSOC))
		{
			echo "Class: " . $row['dept']. " ". $row['class_num']. "  Professor: " . $row['professor']. "<br>";
		}
	}

}

?>
	<h2><font color = rgb(51,102,153)>Add a Class</font></h2>
	<form method="post" action="profilePage.php" id = "addClass" name = "addClass">
	Department: <input type = "text" name = "dept" /><br />
	Class Number: <input type = "text" name = "class_num"/><br />
	Class Time: <input type = "text" name = "time2"/><br />
	Professor: <input type = "text" name = "professor"/><br />
	<input type = "submit" class = "button" id = "CreateAccount">
</form>

	<h2>Form a Study Group</h2>
	<form method="post" action="profilePage.php" id = "newStudyGroup" name = "newStudyGroup">
	Enter a Group Name:
</body>
</html>