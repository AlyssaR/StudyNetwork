<html>
<head>
	<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="bin/helper.js"></script>
	<script type="text/javascript" src="bin/accounts.js"></script>
	<title> User Profile </title>
</head>
<body onload = "getProfile()" bgcolor="#000000" />
			
		<div id = formData>
		
				<h1>Welcome to the Study Network!</h1>
				
				First name: 	<label id = "cur_f_name"> Undefined </label>
					<input type = "text" id = "f_name" placeholder = "New First Name">
					<input type = "submit" onclick = "javascript:editProfile('first')" value = "Change"><br /> 
				Last name:		<label id = "cur_l_name"> Undefined </label>
					<input type = "text" id = "l_name" placeholder = "New Last Name">
					<input type = "submit" onclick = "javascript:editProfile('last')" value = "Change"><br /> 
				Email: 			<label id = "cur_email"> Undefined </label>
					<input type = "text" id = "email" placeholder = "New Email">
					<input type = "submit" onclick = "javascript:editProfile('email')" value = "Change"><br /> 
				
				Change Password: <input type = "password" id = "password" placeholder = "New Password"/><br />
				Retype Password: <input type = "password" id="password2" onkeyup="validPass(); return false" placeholder = "Re-enter Password"/>
					<input type = "submit" onclick = "javascript:editProfile('password')" value = "Change">
				 <br /><span id="validateMessage"></span>

				 <br /><br />

				 <!--<div id="Groups">
				 <b>You are a member of these groups</b>
				 <table id="GroupData" width="100%" bgcolor="#909090">
				 <tr>
					<th>Group Name</th>
					<th>Meeting Time</th>
					<th>Meeting Location</th>
				</tr>
				</table>
				</div>-->

				<center><div id = "title">Groups You Are A Member Of</div></center><br><br>

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

					session_start();

					$con = mysql_connect("localhost", "web", "wearegeniuses");
					if (!$con)
					{
						die('Could not connect: ' . mysql_error());
					}

					mysql_select_db("StudyNetwork", $con)
						or die("Unable to select database:" . mysql_error());

					$uid = $_SESSION['uid'];

					echo "<table id='groups'>";
					echo "<tr><th>Group Name</th><th>Meeting Time</th><th>Meeting Location</th></tr>";

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


				<br /><br />
				<form>
					<button type = "button" onclick = "javascript:redirectToClass()"> Create A Class</button>
					<button type = "button" onclick = "javascript:redirectToGroup()"> Create A Study Group</button>

					<br /><br /><button type = "button" onclick = "javascript:logout()"> Logout </button>
				</form>
			
		<p> The StudyNetwork is a service to connect classmates and mentors in relevant study groups! </p>
	</div>
</html>

<style>
#formData {
    background-color:black;
    color:lime;
    text-align:center;
    padding:100px;
	font-family:courier;
}
</style>