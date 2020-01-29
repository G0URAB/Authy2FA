<?php

class Authy{

    private $api_key;
    private $email;
    private $phone;
    private $country_code;

    function __construct($api_key,$email,$phone,$country_code)
    {
        $this->api_key= $api_key;
        $this->email= $email;
        $this->phone= $phone;
        $this->country_code= $country_code;
    }

    function authyRegisterUser(){
    
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://api.authy.com/protected/json/users/new",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "user%5Bemail%5D={$this->email}&user%5Bcellphone%5D={$this->phone}&user%5Bcountry_code%5D={$this->country_code}",
            CURLOPT_HTTPHEADER => array(
                "X-Authy-API-Key: {$this->api_key}",
                'Content-Type: application/x-www-form-urlencoded'
            ),
        ));
        $response = curl_exec($curl);
        return $response;
    }

    function authyDeregisterUser($user_id){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.authy.com/protected/json/users/{$user_id}/remove");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        $headers = array();
        $headers[] = "X-Authy-Api-Key: {$this->api_key}";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        return $response = curl_exec($ch);
    }

    function authySendOTP($user_id){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.authy.com/protected/json/sms/{$user_id}?force=true");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        $headers = array();
        $headers[] = "X-Authy-Api-Key: {$this->api_key}";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        return curl_exec($ch);
    }

    function authyVerifyOTP($user_id,$OTP){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.authy.com/protected/json/verify/{$OTP}/{$user_id}");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        $headers = array();
        $headers[] = "X-Authy-Api-Key: {$this->api_key}";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        return $response;
    }
}

?>