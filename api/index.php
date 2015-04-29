<?php
require 'vendor/autoload.php';

session_cache_limiter(false);
$cookieParams = session_get_cookie_params(); // Gets current cookies params.
session_set_cookie_params(30*60, $cookieParams["path"], $cookieParams["domain"], false, true); //Turns on HTTP only (helps mitigate some XSS)
session_name("StudyNetwork");
session_start();

$app = new \Slim\Slim();
$database = new mysqli("localhost", "web", "wearegeniuses", "StudyNetwork");
if ($database->connect_errno)
    die("Connection failed: " . $database->connect_error);


$app->post('/addClass', function() use ($database){
	$dept = $_POST['dept'];
	$class_num = $_POST['class_num'];
	$time2 = $_POST['time2'];
	$profFirst = $_POST['profFirst'];
	$profLast = $_POST['profLast'];
	$uid = "";

	$error = "None";
	$success = true;

	if(isset($_SESSION['uid']))
		$uid = $_SESSION["uid"];
	else {
		echo json_encode(array("success"=>false,"errorType"=>"User not logged in."));
		return;
	}

	$checkClass = $database->prepare("SELECT dept, class_num FROM Classes where dept = ? AND class_num = ?;");
	$checkClass->bind_param('si', $dept, $class_num);
	$checkClass->execute();

	if($checkClass->num_rows == 0){
		$checkClass->close();
		$createClass = $database->prepare("INSERT INTO Classes VALUES (?, ?, ?, ?, ?);");
		$createClass->bind_param('sisss', $dept, $class_num, $time2, $profFirst, $profLast);
		$createClass->execute();
		$createClass->close();
	}

	$addIt = $database->prepare("INSERT INTO ClassEnroll VALUES (?, ?, ?);");
	$addIt->bind_param('isi', $uid, $dept, $class_num);
	$addIt->execute();
	$addIt->close();

	$response = array("success"=>$success, "dept"=>$dept, "errorType"=>$error);
	echo json_encode($response);
});

$app->post('/addGroup', function() use ($database){
	$gname = $_POST['gname'];
	$time1= $_POST['time1'];
	$loc = $_POST['loc'];
	$dept = $_POST['dept'];
	$class_num = $_POST['class_num'];
	$uid = 0;
	$gid = 0;
	//Assign incremented ID
	$gidStart = $database->query("SELECT gid FROM StudyGroups ORDER BY gid DESC LIMIT 1;");
	if($gidStart->num_rows > 0) {
		$lastGID = $gidStart->fetch_assoc();
		$gid = $lastGID['gid'] + 1;
	}
	$role = "admin";
	$error = "None";
	$success = true;
	if(isset($_SESSION['uid']))
		$uid = $_SESSION["uid"];
	else {
		echo json_encode(array("success"=>false,"errorType"=>"User not logged in."));
		return;
	}

	$createGroup = $database->prepare("INSERT INTO StudyGroups (gid, dept, class_num, admin_id, gname, time1, loc, num_members, active) VALUES (?, ?, ?, ?, ?, ?, ?, 1, TRUE);");
	$createGroup->bind_param('isiisss', $gid, $dept, $class_num, $uid, $gname, $time1, $loc);
	$createGroup->execute();
	$createGroup->close();
	
	$enroll = $database->prepare("INSERT INTO GroupEnroll VALUES (?, ?, ?, TRUE);");
	$enroll->bind_param('iis', $uid, $gid, $role);
	$enroll->execute();
	$enroll->close();
	
	$response = array("success"=>$success, "gname"=>$gname, "errorType"=>$error);
	echo json_encode($response);
});

$app->post('/addOrganization', function() use ($database) {
	$org_name = $_POST['org_name'];
	$uid = "";

	if(isset($_SESSION["uid"]))
		$uid = $_SESSION["uid"];
	else {
		echo json_encode(array("success"=>false,"errorType"=>"Error: You are not logged in."));
		return;
	}
	
	//must insert into Organizations a name and unique id (just going to have that increment like before)
	//have to check to see if organization exists. Need a validator to compare words...?
	//can you make all capital before sending it to the code, or all lowercase?
	//validator in JS
	$orgid = 0;
	$success = true;
	$error = "None";

	//assign an incremented org ID
	$oidStart = $database->query("SELECT orgid FROM Organizations ORDER BY orgid DESC LIMIT 1;");
	if($oidStart->num_rows > 0) {
		$lastOID = $oidStart->fetch_assoc();
		$orgid = $lastOID['orgid'] + 1;
	}

	$checkForOrg = $database->prepare("SELECT orgid FROM Organizations WHERE org_name = ?;");
	$checkForOrg->bind_param('s', $org_name);
	$checkForOrg->execute();

	//check to see if Organization already exists in database
	if($checkForOrg->num_rows > 0) {
		$result = $checkForOrg->fetch_assoc();
		$checkForOrg->close();
		$orgid = $result['orgid'];
		//check to see if user was ever in org before
		$checkHistory = $database->prepare("SELECT active FROM OrgEnroll WHERE uid = ? AND orgid = ?;");
		$checkHistory->bind_param('ii', $uid, $orgid);
		$checkHistory->execute();
		if($checkHistory->num_rows > 0) {
			$checkHistory->close();
			$updateDB = $database->prepare("UPDATE OrgEnroll SET active = TRUE WHERE uid = ? AND orgid = ?;");
			$updateDB->bind_param('ii', $uid, $orgid);
			$updateDB->execute();
			$updateDB->close();
		}
		else {
			$checkHistory->close();
			$insertDB = $database->prepare("INSERT INTO OrgEnroll VALUES (?, ?, TRUE);");
			$insertDB->bind_param('ii', $uid, $orgid);
			$insertDB->execute();
			$insertDB->close();
		}
		$success = false;
		$error = "[Notice] Organization already exists. You've been added to pre-existing group.";
	}
	else{
		$checkForOrg->close();
		$insertOrg = $database->prepare('INSERT INTO Organizations VALUES (?, ?);');
		$insertOrg->bind_param('is', $orgid, $org_name);
		$insertOrg->execute();
		$insertOrg->close();
		$insertDB = $database->prepare('INSERT INTO OrgEnroll VALUES (?, ?, TRUE);');
		$insertDB->bind_param('ii', $uid, $orgid);
		$insertDB->execute();
		$insertDB->close();
	}

	$response = array("success"=>$success, "org_name"=>$org_name, "errorType"=>$error);
	echo json_encode($response);
});

//Not SQLi protected
$app->post('/deleteGroup', function() use ($database) {
	$gid = 0;
	$num_members = 0;
	if(isset($_POST['gid']))
		$gid = $_POST['gid'];
	else {
		echo json_encode(array("gid"=>$_POST['gid']));
		return;
	}

	$database->query("UPDATE StudyGroups SET active = FALSE, num_members = '$num_members' WHERE gid = '$gid';");
	$database->query("UPDATE GroupEnroll SET active = FALSE WHERE gid = '$gid';");
	echo json_encode(array("success"=>true));
});

$app->post('/editprofile', function () use ($database) {
	$fName = $_POST['f_name'];
	$lName = $_POST['l_name'];
	$email = $_POST['email'];
	$pass = $_POST['password'];
	$uid = "";
	if(isset($_SESSION["uid"]))
	    $uid = $_SESSION["uid"];
	else {
		echo json_encode(array("success"=>false, "errorType"=>"Not logged in"));
		return;
	}
	$success = true;

	$runQuery = $database->query("SELECT f_name, l_name, email, passwd FROM Users WHERE uid = '$uid';");
	$result = $runQuery->fetch_assoc();
	if($fName === "ignore")
		$fName = $result['f_name'];
	if($lName === "ignore")
		$lName = $result['l_name'];
	if($email === "ignore")
		$email = $result['email'];
	else { //If email already exists in database
		$runQuery = $database->prepare("SELECT COUNT(*) as count FROM Users WHERE email = ? LIMIT 1;");
		$runQuery->bind_param('s', $email);
		$runQuery->execute();	
		$checkQuery = $runQuery->fetch_assoc();
		$runQuery->close();
		if($checkQuery['count'] > 0) {
			$response = array("success"=>false, "uid"=>0, "f_name"=>0, "l_name"=>0, "email"=>0, "errorType"=>"Error: Email is already associated with an account.");
			echo json_encode($response);
			return;
		}
	}
	if($pass === "ignore")
		$pass = $result['passwd'];

	$updateTheThing = $database->prepare("UPDATE Users SET f_name = ?, l_name = ?, email = ?, passwd = ? WHERE uid = ?;");
	$updateTheThing->bind_param('ssssi', $fName, $lName, $email, $pass, $uid);
	$updateTheThing->execute();	
	$updateTheThing->close();

	$runQuery = $database->query("SELECT f_name, l_name, email FROM Users WHERE uid = '$uid';");
	$result = $runQuery->fetch_assoc();

	if($result === NULL || !($fName === $result['f_name'] && $lName === $result['l_name'] && $email === $result['email']))
		$success = false;
	$response = array("success"=>$success, "uid"=>$uid, "f_name"=>$fName, "l_name"=>$lName, "email"=>$email, "errorType"=>"None");
	echo json_encode($response);
});

$app->post('/editStudyGroup', function() use ($database){
	$gname = $_POST['gname'];
	$time1 =  $_POST['time1'];
	$loc = $_POST['loc'];
	$gid = $_POST['gid'];
	$success = true;
	$errorType = "None";

	$runQueryEG = $database->query("SELECT gname, time1, loc FROM StudyGroups WHERE gid = '$gid';");
	$resultEG = $runQueryEG->fetch_assoc();
	if($gname === "ignore")
		$gname = $resultEG['gname'];
	if($time1 === "ignore")
		$time1 = $resultEG['time1'];
	if($loc === "ignore")
		$loc = $resultEG['loc'];

	$updateTheThing = $database->prepare("UPDATE StudyGroups SET gname = ?, time1 = ?, loc = ? WHERE gid = ?;");
	$updateTheThing->bind_param('sssi', $gname, $time1, $loc, $gid);
	$updateTheThing->execute();	
	$updateTheThing->close();
	$runQueryEG = $database->query("SELECT gname, time1, loc FROM StudyGroups WHERE gid = '$gid';");
	$resultEG = $runQueryEG->fetch_assoc();

	if($resultEG === NULL || !($gname === $resultEG['gname'] && $time1 === $resultEG['time1'] && $loc === $resultEG['loc'])) {
		$success = false;
		$errorType = "Error making your changes. Please try again later.";
	}

	$response = array("success"=>$success, "gid"=>$gid, "gname"=>$gname, "time1"=>$time1, "loc"=>$loc, "errorType"=>$errorType);
	echo json_encode($response);
});

$app->post('/getClasses', function() use ($database) {
	$uid = "";
	if(isset($_SESSION["uid"]))
	    $uid = $_SESSION["uid"];
	else {
		echo json_encode(array("success"=>false, "errorType"=>"Not logged in"));
		return;
	}

	//returning all classes a User has enrolled in
	$runQuery = $database->query("SELECT c.dept, c.class_num, time2, c.profFirst, c.profLast FROM Classes c, ClassEnroll e WHERE c.dept = e.dept AND c.class_num = e.class_num AND e.uid = '$uid';");
	$response = array();
	if($runQuery->num_rows != 0) {
		while($row = $runQuery->fetch_assoc())
			$response[] = array("success"=>true, "dept"=>$row['dept'], "class_num"=>$row['class_num'], "time2"=>$row['time2'], "profFirst"=>$row['profFirst'], "profLast"=>$row['profLast'], "errorType"=>"None");
		echo json_encode($response);
	}
	else
		echo json_encode(array("success"=>false, "errorType"=> "No classes found"));

});

$app->post('/getClassInfo', function() use ($database) {
	if(isset($_POST['dept']))
	{
		$dept = $_POST['dept'];
		$class_num = $_POST['class_num'];
	}
	else {
		echo json_encode(array("dept"=>$_POST['dept'], "class_num"=>$_POST['class_num']));
		return;
	}

	$runQuery = $database->query("SELECT dept, class_num FROM Classes WHERE dept = '$dept' AND class_num = '$class_num';");
	$result = $runQuery->fetch_assoc();

	if($result === NULL)
		$response = array ("success"=> false, "dept"=>"Not Valid", "class_num"=>"Not Valid", "errorType"=>"This class doesn't exist");
	else
		$response = array ("success"=>true, "dept"=>$result['dept'], "class_num"=>$result['class_num'], "errorType"=>"None");
	echo json_encode($response);

});

//This is to get groups to redirect to group profile page
$app->post('/getGroupInfo', function () use ($database) {
	if(isset($_POST['gid']))
		$gid = $_POST['gid'];
	else {
		echo json_encode(array("gid"=>$_POST['gid']));
		return;
	}
	//only want to pull up groups that are active, hopefully this works
	$runQuery = $database->query("SELECT gname, time1, loc FROM StudyGroups WHERE gid = '$gid' and active = TRUE LIMIT 1;");
	$result = $runQuery->fetch_assoc();

	//some response
	if($result === NULL)
		$response = array("success"=>false, "gname"=>"Not Valid", "time1"=>"Not Valid", "loc"=>"Not Valid", "errorType"=>"This is not the correct group");
	else
		$response = array("success"=>true, "gname"=>$result['gname'], "time1"=>$result['time1'], "loc"=>$result['loc'], "errorType"=>"None");
	echo json_encode($response);
});

$app->post('/getGroupMembers', function() use ($database) {
	if(isset($_POST['gid']))
		$gid = $_POST['gid'];
	else {
		echo json_encode(array("gid"=>$_POST['gid']));
		return;
	}

	$allGroupMembers = $database->query("SELECT f_name, l_name from Users u, GroupEnroll e WHERE e.gid = '$gid' AND u.uid = e.uid AND e.active = TRUE;");

	$response = array();
	if($allGroupMembers->num_rows != 0) {
		while($row = $allGroupMembers->fetch_assoc())
			$response[] = array("success"=>true, "f_name"=>$row['f_name'], "l_name"=>$row['l_name'], "errorType"=>"None");
		echo json_encode($response);
	}
	else
		echo json_encode(array("success"=>false, "errorType"=>"No members found"));
});

//This is to get Groups for the user profile page
//this is causing problems
$app->post('/getGroups', function () use ($database) {
	$uid = "";
	if(isset($_SESSION["uid"]))
	    $uid = $_SESSION["uid"];
	else {
		echo json_encode(array("success"=>false, "errorType"=>"Not logged in"));
		return;
	}
	//again only returning groups that they are still a part of...hopefully 
	$runQuery = $database->query("SELECT gname, time1, loc, g.gid FROM StudyGroups s, GroupEnroll g WHERE s.gid = g.gid AND g.active = TRUE AND g.uid = '$uid';");
	
	$response = array();
	if ($runQuery->num_rows != 0) {
		while($row = $runQuery->fetch_assoc()) 
			$response[] = array("success"=>true, "gname"=>$row['gname'], "time1"=>$row['time1'], "loc"=>$row['loc'], "gid"=>$row['gid'], "errorType"=>"None");

		echo json_encode($response);
	}
	else
		echo json_encode(array("success"=>false, "errorType"=>"No groups found"));
});

$app->post('/getOrganizations', function() use ($database) {
	$uid = "";
	if(isset($_SESSION["uid"]))
	    $uid = $_SESSION["uid"];
	else {
		echo json_encode(array("success"=>false, "errorType"=>"Not logged in"));
		return;
	}

	//returning all Orgs
	$allOrgs = $database->query("SELECT org_name, g.orgid FROM OrgEnroll g, Organizations o WHERE g.uid = '$uid' AND g.orgid = o.orgid AND active = TRUE;");

	$response = array();
	if($allOrgs->num_rows != 0) {
		while($row = $allOrgs->fetch_assoc())
			$response[] = array("success"=>true, "org_name"=>$row['org_name'], "orgid"=>$row['orgid'], "errorType"=>"None");

		echo json_encode($response);
	}
	else 
		echo json_encode(array("success"=>false, "errorType"=>"Not logged in"));

});

//for if we want to pull one organizaiton at a time
$app->post('/getOrganizationInfo', function() use ($database) {
	if(isset($_POST['orgid']))
		$orgid = $_POST['orgid'];
	else {
		echo json_encode(array("orgid"=>$_POST['orgid']));
		return;
	}

	$runQuery = $database->query("SELECT org_name FROM Organizations WHERE orgid = '$orgid';");
	$result = $runQuery->fetch_assoc();

	if($result === NULL)
		$response = array("success"=>false, "org_name"=>"Not Valid", "errorType"=>"This organizaiton doesn't exist");
	else
		$response = array("success"=>true, "org_name"=>$result['org_name'], "errorType"=>"None");
	echo json_encode($response);
});

$app->post('/getUserID', function () {
	if(isset($_SESSION["uid"]))
		echo json_encode(array("success"=>true,"uid"=>$_SESSION["uid"]));
	else
		echo json_encode(array("success"=>false));
});

$app->post('/getUserInfo', function () use ($database) {
    $uid = "";
    if(isset($_SESSION["uid"]))
	    $uid = $_SESSION["uid"];
	else {
		echo json_encode(array("success"=>false, "errorType"=>"Not logged in"));
		return;
	}

    $runQuery = $database->query("SELECT f_name, l_name, email FROM Users WHERE uid = '$uid' LIMIT 1");
    $result = $runQuery->fetch_assoc();

    //Frame response
    if($result === NULL)
    	$response = array("success"=>false, "id"=>0,"f_name"=>"Not Valid","l_name"=>"Not Valid", "errorType"=>"User ID not valid.");
	else
		$response = array("success"=>true, "f_name"=>$result['f_name'],"l_name"=>$result['l_name'], "email"=>$result['email'], "errorType"=>"None");
    echo json_encode($response);
});

$app->post('/groupRole', function() use ($database) {
	$uid = "";
	$gid = "";
	 if(isset($_SESSION["uid"]))
	    $uid = $_SESSION["uid"];
	else {
		echo json_encode(array("success"=>false, "errorType"=>"Not logged in"));
		return;
	}
	if(isset($_POST['gid']))
		$gid = $_POST['gid'];
	else {
		echo json_encode(array("success"=>false, "errorType"=>"No group entered."));
		return;
	}

	$runQuery = $database->query("SELECT role from GroupEnroll WHERE uid = '$uid' AND gid = '$gid';");
	$result = $runQuery->fetch_assoc();

	if($result === NULL)
		$response = array("success"=>false, "role"=>"Not Valid", "errorType"=>"User not in group.");
	else
		$response = array("success"=>true, "role"=>$result['role'], "errorType"=>"None");
	echo json_encode($response);
});

$app->post('/isInGroup', function() use($database) {
	$uid = "";
	$gid = "";
	if(isset($_SESSION["uid"]))
	    $uid = $_SESSION["uid"];
	else {
		echo json_encode(array("success"=>false, "errorType"=>"Not logged in"));
		return;
	}
	if(isset($_POST['gid']))
		$gid = $_POST['gid'];
	else {
		echo json_encode(array("success"=>false,"errorType"=>"No group id provided."));
		return;
	}

	$query = $database->query("SELECT uid FROM GroupEnroll WHERE gid = '$gid' AND uid = '$uid';");
	if($query->num_rows == 0)
		$response = array("success"=>false, "errorType"=>"Not a member of this group");
	else
		$response = array("success"=>true, "errorType"=>"None");
	echo json_encode($response);
});

//Quincy Schurr - joinStudyGroup branch
$app->post('/joinStudyGroup', function() use ($database) {
	$uid = $_SESSION['uid'];
    $gid = $_POST['gid'];
    $role = "member";

    $num_members = 0;
    $error = "None";
    $success = true;
    //assign num members!
    $numMemStart = $database->query("SELECT num_members FROM StudyGroups WHERE gid = 'gid';");
    $numMem = $numMemStart->fetch_assoc();
    $num_members = $numMem['num_members'] + 1;

    $database->query("UPDATE StudyGroups SET num_members = '$num_members' WHERE gid = '$gid';");
    $database->query("INSERT INTO GroupEnroll VALUES('$uid', '$gid', '$role', TRUE);");
    $response = array("success"=>$success, "errorType"=>$error);
    echo json_encode($response);
});

$app->post('/leaveClass', function() use ($database) {
	$uid = "";
	if(isset($_SESSION['uid']))
		$uid = $_SESSION['uid'];
	else {
		echo json_encode(array("success"=>false,"errorType"=>"User not logged in."));
		return;
	}
	$dept = $_POST['dept'];
	$class_num = $_POST['class_num'];

	$error = "None";
	$success = true;

	$database->query("DELETE FROM ClassEnroll WHERE uid = '$uid' AND dept = '$dept' AND class_num = '$class_num';");
	echo json_encode(array("success"=>$success));

});

$app->post('/leaveOrganization', function() use ($database) {
	$uid = "";
	if(isset($_SESSION['uid']))
		$uid = $_SESSION['uid'];
	else {
		echo json_encode(array("success"=>false,"errorType"=>"User not logged in."));
		return;
	}
	$orgid = $_POST['orgid'];

	$error = "None";
	$success = true;

	$database->query("UPDATE OrgEnroll SET active = FALSE where uid = '$uid' AND orgid ='$orgid';");
	echo json_encode(array("success"=>$success));
});

$app->post('/leaveStudyGroup', function() use ($database) {
	$uid = "";
	$gid = $_POST['gid'];
	$num_members = 0;
    $error = "None";
    $success = true;

    if(isset($_SESSION['uid']))
    	$uid = $_SESSION['uid'];
	else {
		echo json_encode(array("success"=>false, "errorType"=>"User not logged in."));
		return;
	}
    //assign num members!
    $numMemStart = $database->query("SELECT num_members FROM StudyGroups WHERE gid = 'gid';");
    $numMem = $numMemStart->fetch_assoc();
    $num_members = $numMem['num_members'] - 1;

	//changed this to update. old deleting method below if needed
	$database->query("UPDATE StudyGroups SET num_members = '$num_members' WHERE gid = '$gid';");
	$database->query("UPDATE GroupEnroll SET active = FALSE WHERE gid = '$gid' AND uid = '$uid';");
	//$database->query("DELETE FROM GroupEnroll WHERE gid = '$gid' and uid = '$uid';");
	echo json_encode(array("success"=>true));
});

$app->post('/login', function () use ($database) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    //Remove duplicates
    $runQuery = $database->query("SELECT uid, f_name, l_name FROM Users WHERE email = '$email' AND passwd = '$password' LIMIT 1;");
    $result = $runQuery->fetch_assoc();

    //Frame response
    if($result === NULL)
    	$response = array("success"=>false, "uid"=>-1,"f_name"=>"Not Valid","l_name"=>"Not Valid");
	else {
		$response = array("success"=>true, "uid"=>$result['uid'], "f_name"=>$result['f_name'],"l_name"=>$result['l_name']);
		$_SESSION["uid"] = $response["uid"];
	}
    echo json_encode($response);
});

$app->post('/logout', function () {
	$_SESSION = array(); //Unsets all variables
	$params = session_get_cookie_params(); //Expires/Deletes cookie
    setcookie(session_name(), '', time() - 60,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]);
	session_destroy(); //Ends session server side
	echo json_encode(array("success"=>true));
});

$app->post('/register', function () use ($database) {
	$fName = $_POST['f_name'];
	$lName = $_POST['l_name'];
	$uid = 0; //First user

	//Assign incremented ID
	$uidStart = $database->query("SELECT uid FROM Users ORDER BY uid DESC LIMIT 1;");
	if($uidStart->num_rows > 0) {
		$lastUID = $uidStart->fetch_assoc();
		$uid = $lastUID['uid'] + 1;
	}

	$email = $_POST['email'];
	$password = $_POST['passwd'];
	$error = "None";
	$success = true;

	//Check for duplicates
	$results = $database->query("SELECT * FROM Users WHERE email = '$email';");
	if($results->num_rows > 0) {
		$error = "User already exists";
		$success = false;
	}
	//Add user
	else {
		//added active to this query as well
		$database->query("INSERT INTO Users (uid, f_name, l_name, email, passwd, active) VALUES ('$uid', '$fName', '$lName', '$email', '$password', TRUE);");
		$_SESSION["uid"] = $uid;
	}

	//Respond
	$response = array("success"=>$success, "f_name"=>$fName, "uid"=>$uid, "errorType"=>$error);
	echo json_encode($response);
});

$app->post('/searchByClass', function() use ($database) {
	if(!empty($_POST['dept']) && !empty($_POST['class_num'])) {
		$dept = $_POST['dept'];
  		$class_num = $_POST['class_num'];

    	//$query = $database->query("SELECT gname, time1, loc, gid FROM StudyGroups WHERE dept = '$dept' AND class_num = '$class_num' AND active = TRUE;"); 
    	//now we may be getting a whole list of similar searches!!
    	$query = $database->query("SELECT gname, time1, loc, gid FROM StudyGroups WHERE dept LIKE '$dept[0]%' AND class_num = '$class_num' AND active = TRUE;");
    	
    	$response = array();
    	if ($query->num_rows != 0) {
			while($row = $query->fetch_assoc()) 
				$response[] = array("success"=>true, "gname"=>$row['gname'], "time1"=>$row['time1'], "loc"=>$row['loc'], "gid"=>$row['gid'], "errorType"=>"None");
			echo json_encode($response);
		}
		else
			echo json_encode(array("success"=>false, "errorType"=>"No groups found"));
    }
    else 
    	echo json_encode(array("success"=>false, "errorType"=>"Insufficient data entered"));
});

$app->post('/searchByGroup', function() use ($database) {
	if(!empty($_POST['group'])) {
		$gname = $_POST['group'];

		//should show more results...
		$query = $database->query("SELECT gname, time1, loc, gid FROM StudyGroups WHERE gname LIKE '%$gname[0]%';");

		$response = array();
		if($query->num_rows!= 0) {
			while($row = $query->fetch_assoc())
				$response[] = array("success"=>true, "gname"=>$row['gname'], "time1"=>$row['time1'], "loc"=>$row['loc'], "gid"=>$row['gid'], "errorType"=>"None");
			echo json_encode($response);
		}

		else echo json_encode(array("success"=>false, "errorType"=>"No groups found"));
	}

	else echo json_encode(array("success"=>false, "errorType"=>"No data entered"));

});

$app->post('/searchByOrg', function() use ($database) {		
	if(!empty($_POST['org'])) {
		$org_name = $_POST['org']; 	
  		
  		//this gets UserId. This will return more than 1 result, if needed, so then what do we do?
  		//I think this is the problem. It returns more than one uid sometimes.
		$uidGet = $database->query("SELECT uid from OrgEnroll e, Organizations o WHERE o.org_name LIKE '$org_name[0]%' AND u.orgid = o.orgid;"); 
		$query = $database->query("SELECT s.gname, s.time1, s.loc, s.gid FROM StudyGroups s, GroupEnroll g WHERE g.uid = '$uidGet' AND s.gid = g.gid AND g.active = TRUE;");
    	
    	$response = array();
    	if($query->num_rows != 0) {
			while($row = $query->fetch_assoc()) 
				$response[] = array("success"=>true, "gname"=>$row['gname'], "time1"=>$row['time1'], "loc"=>$row['loc'], "gid"=>$row['gid'], "errorType"=>"None");
			echo json_encode($response);
		}
		else
			echo json_encode(array("success"=>false, "gname"=>"NOT VALID", "time1"=>"NOT VALID", "loc"=>"NOT VALID", "gid"=>"NOT VALID", "errorType"=>"No groups found"));
    }
    else 
    	echo json_encode(array("success"=>false, "gname"=>"NOT VALID", "time1"=>"NOT VALID", "loc"=>"NOT VALID", "gid"=>"NOT VALID", "errorType"=>"Insufficient data entered"));
});


$app->run();
?>