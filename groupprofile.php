<!DOCTYPE html>
<head>
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>
    <script type="text/javascript" src="bin/helper.js"></script>
    <script type="text/javascript" src="bin/accounts.js"></script>
    <link href="css/navbar.css" rel="stylesheet">
    <link href="css/bootstrap-theme.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <title>Group Profile</title>
</head>
<!-- <select method="post" action = "javascript:searchByClass()">
                            <option value="class" id = "class">Class</option>
                            <option value="prof" id = "prof">Prof</option>
                            <option value="group" id = "group">Group</option>
                        </select>
                        <a href="searchGroups.html"><input type="submit" value="Search"></a>-->
<body bgcolor = "#000000" onload="isLoggedIn(),getGroupInfo('group'), getGroupMembers()"/>

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.html">The Study Network</a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li class="active"><a href="index.html">Home <span class="sr-only">(current)</span></a></li>
                <li><a href="about.html">About</a></li>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" id="navCreate">Create <span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="createClassForm.html">Create Class</a></li>
                        <li><a href="createStudyGroupForm.html">Create Study Group</a></li>
                    </ul>
                </li>
            </ul>
            <form class="navbar-form navbar-left" role="search">
                <div class="form-group">
                    <!-- No functionality currently -->
                    <input type="text" class="form-control" placeholder="Search">
                    <select class="form-control" method="post" action = "javascript:searchByClass()">
                        <option value="class" id = "class">Class</option>
                        <option value="prof" id = "prof">Prof</option>
                        <option value="group" id = "group">Group</option>
                    </select>
                </div>
                <a href="searchGroups.html"><input class="btn btn-default" type="submit" value="Search"></a>
            </form>
            <ul class="nav navbar-nav navbar-right">

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" id="navGreet">Welcome, <label id="sayHello"></label><span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li><a href="profile.html">View Profile</a></li>
                        <li><a href="javascript:void(0)" onclick = "logout();">Logout</a></li><!--do we have a logout route? -->
                    </ul>
                </li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>

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
            <input class="form-control" type = "text" id = "time" placeholder = "New Meeting Time">
            <input class="btn btn-default btn-sm" type = "submit" onclick = "javascript:editGroup('time1')" value = "Change"><br />
        </div>
    </div>
</div>

<div class="container">
    Location:   <label id = "cur_loc">Undefined</label>

    <div value="1" id = "optDisp3" style= "display:none">
        <div class="form-inline">
            <input class="form-control" type = "text" id = "time1" placeholder = "New Meeting Location">
            <input class="btn btn-default btn-sm" type = "submit" onclick = "javascript:editGroup('loc')" value = "Change"><br />
        </div>
    </div>
</div>

<hr>
<h2>Group Members</h2>
<hr>
<table class="table table-hover" id="MemberData" width="500px">
    <tr>
        <th>{{Member}}</th>
        <th>{{Name}}</th>
    </tr>
</table>
<label id="memberResults">There are no members in this group.</label>


<div class="container">

    <button class="btn btn-primary btn-sm center-block"  id="editableButton" type = "button" onclick = "javascript:toggle()"> Edit Profile </button>
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

