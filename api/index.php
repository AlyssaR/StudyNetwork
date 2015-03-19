<?php
require 'vendor/autoload.php';

$app = new \Slim\Slim();
$database = mysql_connect("localhost", "web", "wearegeniuses");
if(!$database) {
    die('Could not connect:'.mysql_error());
}   
mysql_select_db("StudyNetwork",$database);
    

$app->post('/login', function () {
    if(isset($_POST['email'])){
        $email = $_POST['email'];
        $password = $_POST['password'];

        $result = mysql_query("select uid, f_name, l_name from Users where email='" . $email . "' and passwd = '" . $password . "';");
        $row = mysql_fetch_array($result);
        if(!empty($row)) {
            $response = array ('status'=>"Success", "id"=>$row['uid'],"f_name"=>$row['f_name'],"l_name"=>$row['l_name']);
        }
        else {
            $response = array('status'=>"Failure", "id"=>0,"f_name"=>"Not Valid","l_name"=>"Not Valid");
        }
        
        echo json_encode($response);
    }
});

mysql_close($database);
?>