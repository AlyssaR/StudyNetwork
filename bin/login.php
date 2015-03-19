<html>
<head><title>Nothing works</title></head>
<body>
<?php
	echo "Something worked!"
	$con = mysql_connect("localhost", "web", "wearegeniuses");
	echo "Something worked!"
	if(!$con) {
		die('Could not connect:'.mysql_error());
	}	
	echo "Something worked!"

	mysql_select_db("StudyNetwork",$con);
	
	echo "Something worked!"

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
    	echo $response['status'];
    	#echo json_encode($response);
	}
	echo "Maybe?"
	mysql_close($con);
?>
</body>
</html>
