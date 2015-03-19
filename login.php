<html>
<head><title>Say the Magic Word...</title></head>
<body>
    <?php
    
        $con = mysql_connect("localhost", "web", "wearegeniuses");
        if(!$con) {
            die('Could not connect:'.mysql_error());
        }   

        mysql_select_db("StudyNetwork",$con);
        
        if(isset($_POST['email'])){
            $email = $_POST['email'];
            $password = $_POST['password'];

            $result = mysql_query("select uid, f_name, l_name from Users where email='" . $email . "' and passwd = '" . $password . "';");
            $row = mysql_fetch_array($result);
            if(!empty($row)) {
                $response = array ('status'=>"Success", "id"=>$row['uid'],"f_name"=>$row['f_name'],"l_name"=>$row['l_name']);
            }
            else {
                $response = array('status'=>"Failure", "id"=>0,"f_name"=>"N/A","l_name"=>"N/A");
            }
            
            echo json_encode($response);
        }
        mysql_close($con);
    ?>

    <h2>Are you really sure you want in this crazy house?</h2>
    <form method="post" action="login.php">
        Email: <input type="text" name="email" /><br />
        Password <input type="password" name="password" /><br />
        <input type="submit" />
    </form>
</body>
</html>
