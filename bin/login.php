<?php
	$con = mysql_connect("localhost", "web", "wearegeniuses");
	if(!$con) {
		die('Could not connect:'.mysql_error());
	}	

	mysql_select_db("StudyNetwork",$con);
	
	if(isset($_POST['email'])){
		$email = $_POST['email'];
		$password = $_POST['password'];

		$result = mysql_query("select id, f_name, l_name from Users where email = '" . email . "' and passwd = '" . password . "';");
		$row = mysql_fetch_array($result);
    	if($row) {
	    	$response = array ('status'=>"Success", "id"=>$row['id'],"f_name"=>$row['f_name'],"l_name"=>$row['l_name']);
		}
		else {
			$response = array('status'=>"Failure", "id"=>0,"f_name"=>"N/A","l_name"=>"N/A");
		}
    	
    	echo json_encode($response);
	}

	mysql_close($con);
?>