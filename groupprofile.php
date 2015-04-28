<!DOCTYPE html>
<head>
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <script type="text/javascript" src="js/create.js"></script>
    <script type="text/javascript" src="js/gui.js"></script>
    <script type="text/javascript" src="js/manage.js"></script>
    <script type="text/javascript" src="js/navbar.js"></script>
    <script type="text/javascript" src="js/redirect.js"></script>
    <script type="text/javascript" src="js/retrieve.js"></script>
    <script type="text/javascript" src="js/search.js"></script>
    <script type="text/javascript" src="js/validate.js"></script>

    <link href="css/navbar.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href = "css/signin.css" rel = "stylesheet">
    <link href = "css/navbar.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
    <title>Group Profile</title>
</head>
<body bgcolor = "#000000" onload="loadCentralNav(),isLoggedIn(),getGroupInfo('group'), getGroupMembers()"/>
<div id="centralNavBar"></div>

<h1>Group Profile</h1>

<div class="container">

    Group Name:    <label id = "cur_gname">Undefined</label>

    <div value="1" id="optDisp1" style="display:none">
        <div class="form-inline">
            <input class="form-control" type = "text" id = "gname" placeholder = "New Group Name">
            <input class="btn btn-default btn-sm" type = "submit" onclick = "javascript:editGroup('GroupName')" value = "Change"><br />
        </div>
    </div>
</div>
<div class="container">


    Time:          <label id = "cur_time1">Undefined</label>

    <div value="1" id="optDisp2" style="display:none">
        <div class="form-inline">
            <input class="form-control" type = "text" id = "time1" placeholder = "New Meeting Time">
            <input class="btn btn-default btn-sm" type = "submit" onclick = "javascript:editGroup('time1')" value = "Change"><br />
        </div>
    </div>
</div>

<div class="container">
    Location:   <label id = "cur_loc">Undefined</label>

    <div value="1" id = "optDisp3" style= "display:none">
        <div class="form-inline">
            <input class="form-control" type = "text" id = "loc" placeholder = "New Meeting Location">
            <input class="btn btn-default btn-sm" type = "submit" onclick = "javascript:editGroup('loc')" value = "Change"><br />
        </div>
    </div>
</div>

<hr>
<h2>Group Members</h2>
<hr>
<table class="table table-hover" id="MemberData" width="500px">
    <tr>
        <th>Member</th>
        <th>Name</th>
    </tr>
</table>
<label id="memberResults">There are no members in this group.</label>


<div class="container">

    <button class="btn btn-primary btn-sm center-block"  id="editableButton" type = "button" onclick = "javascript:toggle()">Edit Profile</button>
	<button class="btn btn-primary btn-sm center-block"  id="deleteStudyGroupButton" type = "button" onclick = "javascript:deleteStudyGroup()">Delete Group</button>
    <br></br>
    <input class="btn btn-primary btn-sm center-block" type = "button" id="leaveButton" style = "display:none" onclick = "javascript:leaveStudyGroup()" value = "Leave Study Group">
    <input class="btn btn-primary btn-sm center-block" type = "button" id="joinButton" style = "display:block" onclick = "javascript:joinStudyGroup()" value = "Join Study Group">

</div>
</div>
</body>
</html>
<footer>
    <hr>
    <p>&copy;Genius Loading</p>
</footer>
<style>
    .container {
        width:500px;
    }
    .table th {
        text-align: center;
    }
</style>

