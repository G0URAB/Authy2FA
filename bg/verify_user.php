<?php

session_start();
require_once "connection.php";

//Switch off php error reporting
error_reporting(0);

$msg = [ "status" => false, "text" => "No username and password given" ];

if(isset($_POST))
{

    if($conn)
    {
        //auth_2fa is the test table containing test data
        $stmt = $conn->prepare("SELECT * from authy_2fa where email=? LIMIT 1");
        $stmt->bind_param('s', $_POST['username']);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        
        if($result->num_rows===0)
        {
            $msg['status']=false;
            $msg['text']="Username and password do not match";
        }
        
        else if($row['password']!=$_POST['password'])
        {
            $msg['status']=false;
            $msg['text']="Username and password do not match";
        }
        else
        {
            $_SESSION['id']=$row['id'];

            if($row['2fa_status']=='on'){
                $msg['status']="2fa";
                $msg['text'] = "2FA is on, OTP must be verified";
            }
            else{
                //For verification
                $msg['status']=true;
                $msg['text']="Welcome ".$row['first_name'];
            }

        }
        $stmt->close();
    }
    else
    {
        $msg['status']=false;
        $msg['text']="Database connection failed";
    }

}

echo json_encode($msg);

//close connection
$conn->close();
?>