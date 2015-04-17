<DOCUMENT html>
<head>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1.min.js"></script>
<script type="text/javascript" src="bin/helper.js"></script>
<script type="text/javascript" src="bin/accounts.js"></script>
<link href="css/navbar.css" rel="stylesheet">
</head>
<body bgcolor = "#000000" />
<?php
	$gid = $_GET['gid'];
	$gname = $_GET['gname'];
	$time1 = $_GET['time1'];
	$loc = $_GET['loc'];
?>

		<div id = formData>

		<h1>Group Profile</h1>
		<div class="navbar">
			 <nav>
				  <ul>
					   <li><a href="index.html">Home</a></li>
					   <li><a href="about.html">About</a></li>
					   <li><a href="profile.html">View Profile</a></li>
				  </ul>
			 </nav>
		</div>
		Group ID: 		<label id = "gid"><?php echo $gid; ?></label><br /><br />
		
		Group Name:    <label id = "cur_gname"><?php echo $gname; ?></label>
		<div value="1" id="optDisp1" style="visibility:hidden">
			<input type = "text" id = "gname" placeholder = "New Group Name">
			<input type = "submit" onclick = "javascript:editGroup('GroupName')" value = "Change"><br />
		</div>
		Time:          <label id = "cur_time1"><?php echo $time1; ?></label>
		<div value="1" id="optDisp2" style="visibility:hidden">
			<input type = "time" id = "time1" placeholder = "New Meeting Time">
			<input type = "submit" onclick = "javascript:editGroup('time1')" value = "Change"><br />
		</div>
		Location:      <label id = "cur_loc"><?php echo $loc; ?></label>
		<div value="1" id = "optDisp3" style= "visibility:hidden">
			<input type = "text" id = "loc" placeholder = "New Meeting Location">
			<input type = "submit" onclick = "javascript:editGroup('loc')" value = "Change"><br />
		</div>
			<br /><br />

			<input type = "button" onclick = "javascript:leaveStudyGroup()" value = "Leave Study Group"><br />
			
			<div id="editButtonDiv">
					<button  id="editableButton" type = "button" onclick = "javascript:setEditableTrue()"> Toggle Editing </button>
					
					</div>

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