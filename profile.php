<html>
<head><title>Profile</title></head>
<body>
	<h2>Profile Information:</h2>
	<?php
		$con = mysql_connect("localhost", "web", "wearegeniuses");
		if(!$con)
			die('Could not connect:'.mysql_error());
		mysql_select_db("StudyNetwork",$con);
		$query = mysql_query("select f_name, l_name, email from Users where uid = '$_SESSION['loggedin']';");
		$result = mysql_fetch_array($query);
		mysql_close($con);

	    echo "User ID: " . $_SESSION['loggedin'] . "<br />";
		echo "First name: " . $result['f_name'] . "<br />";
		echo "Last name: " . $result['l_name'] . "<br />";
		echo "Email: " . $result['email'] . "<br />";
	
	?>
</body>
</html>
