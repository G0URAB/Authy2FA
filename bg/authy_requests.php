<?php
session_start();
require_once "Authy.php";
require_once "connection.php";

$email = isset($_POST['email']) ? $_POST['email']: "";
$phone = isset($_POST['phone']) ? $_POST['phone']: "";
$country_code = isset($_POST['country_code']) ? $_POST['country_code']: "";
$OTP= isset($_POST['otp']) ? $_POST['otp']: "";
$api_key = "Insert your api key"; //API key can be found at Authy Dasboard

$authy = new Authy($api_key,$email,$phone,$country_code);

//extract auth_id
$stmt = $conn->prepare("select 2fa_id from authy_2fa where id= ? LIMIT 1");
$stmt->bind_param('i', $_SESSION['id']);
$stmt->execute();
$result= $stmt->get_result();
$row=$result->fetch_assoc();
$stmt->close();

$msg = [ "status"=>false, "text"=>"Please provide phone number and country code" ];


if(isset($_POST['2fa_activate'])){

  $response = $authy->authyRegisterUser();
  if (json_decode($response)->success ==true) {

    //To check if user has performed 2FA
    $_SESSION['2fa_verified'] = true;
    
    $stmt = $conn->prepare("UPDATE authy_2fa SET  2fa_status ='on', 2fa_id=? where id= ?");
    $stmt->bind_param('si', json_decode($response)->user->id, $_SESSION['id']);
    $stmt->execute();
    $stmt->close();

    $msg['status'] = true;
    $msg['text']= json_decode($response)->message;
    }
}

else if(isset($_POST['2fa_deactivate'])){

  $authyID = isset($row['2fa_id']) ? $row['2fa_id']: "";
  $response= $authy->authyDeregisterUser($authyID);

  if (json_decode($response)->success ==true) {

    //To check if user has performed 2FA
    $_SESSION['2fa_verified'] = false;

    $stmt = $conn->prepare("UPDATE authy_2fa SET  2fa_status ='off', 2fa_id='' where id= ?");
    $stmt->bind_param('i', $_SESSION['id']);
    $stmt->execute();
    $stmt->close();

    $msg['status'] = true;
    }

}

else if (isset($_POST['new_otp'])){
  
  $authyID = isset($row['2fa_id']) ? $row['2fa_id']: "";
  $response = $authy->authySendOTP($authyID);
  $msg['status']=true; 
}

else if (isset($_POST['verify_otp'])){

    $authyID = isset($row['2fa_id']) ? $row['2fa_id']: "";
    $response= $authy->authyVerifyOTP($authyID,$OTP);
    if(json_decode($response)->success ==true){
        //To check if user has performed 2FA
        $_SESSION['2fa_verified'] =true;
        $msg['status'] = true;
    }
    else
     $_SESSION['2fa_verified'] =false;

}

$msg['text']= json_decode($response)->message;

//close connection
$conn->close();

echo json_encode($msg);

?>