<html>
<head><title>This is a test</title></head>
<body>
<h2>Users:</h2>
<?php
	$con = mysql_connect("localhost", "web", "wearegeniuses");
	if(!$con) {
		die('Could not connect:'.mysql_error());
	}	

	mysql_select_db("StudyNetwork",$con);

	$result = mysql_query("select * from Users");

	while ($row = mysql_fetch_array($result)) {
		echo $row['id'] . " " . $row['f_name'] . " " . $row['l_name'];
		echo "<br />";
	}

	mysql_close($con);
?>
</body>
</html>
