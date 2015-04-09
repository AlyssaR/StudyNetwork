<html>

<head>
	<title>Test Get Groups</title>
</head>

<body>
	<center>
	</center>
<br><br>
<center><div id = "title">GROUPS</div></center><br><br>
<center>

	<script>
		function getGroups() {
			$.ajax({
				type: "GET",
				url: "api/getGroups",
				data: "json",
				success: function(msg){
				console.log(msg)
				if (msg === "success") {
					location.reload();
					}
				}
			});
		}
	</script>

	<?php

		$uid = $_SESSION['uid'];

		echo "<table id = 'groups'>";
		echo "<tr><th>Group Name</th><th>Meeting Time</th><th>Meeting Location</th></tr>";

					$con = mysql_connect("localhost", "web", "wearegeniuses");
					if (!$con)
					{
						die('Could not connect: ' . mysql_error());
					}

					mysql_select_db("StudyNetwork", $con)
						or die("Unable to select database:" . mysql_error());

					$query = "SELECT gname, time1, loc FROM StudyGroups s, GroupEnroll g WHERE s.gid = g.gid AND g.uid = '$uid';";
					$result = mysql_query($query);
					$numResults = mysql_num_rows($result);

					if ($numResults != 0) {

					while($row = mysql_fetch_assoc($result))
						{
						$gname = $row['gname'];
						$time1 = $row['time1'];
						$loc = $row['loc'];

						echo "<tr><td><center>$gname</center></td><td><center>$time1</center></td><td><center>$loc</center></td></tr>";
						}

						echo "</table>";
					}

					else{
						echo "</table>";
						echo "<br><br>You have not joined any groups.<br><br><br><br>";
					}

	?>

