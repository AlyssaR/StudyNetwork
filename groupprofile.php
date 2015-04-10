<DOCUMENT html>
<head>
<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.1min.js"></script>
<script type="text/javascript" src="bin/helper.js"></script>
<script type="text/javascript" src="bin/accounts.js"></script>
<link href="css/navbar.css" rel="stylesheet">
</head>
<body bgcolor = "#000000" />
<?php
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
					   <li><a href="editprofile.html">View Profile</a></li>
				  </ul>
			 </nav>
		</div>

		Group Name:    <?php echo $gname; ?>
		<div value="1" id="optDisp1" style="visibility:hidden">
			<input type = "text" id = "gname" placeholder = "New Group Name">
			<input type = "submit" onclick = "javascript:editGroup('GroupName')" value = "Change"><br />
		</div>
		Time:          <?php echo $time1; ?>
		<div value="1" id="optDisp2" style="visibility:hidden">
			<input type = "text" id = "time1" placeholder = "New Meeting Time">
			<input type = "submit" onclick = "javascript:editGroup('time1')" value = "Change"><br />
		</div>
		Location:      <?php echo $gname; ?>
		<div value="1" id = "optDisp3" style= "visibility:hidden">
			<input type = "text" id = "time1" placeholder = "New Meeting Location">
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