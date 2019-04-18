<?php
/**
 * Created by PhpStorm.
 * User: delmwinbaeka
 * Date: 4/4/19
 * Time: 1:48 AM
 */

error_reporting(E_ALL);


// set your default time-zone
date_default_timezone_set('Africa/Accra');

$sms_key = "36c31907b1138f201022";

// variables used for jwt
$jwtkey = "c3YIbQR5A/qE6B6OrFbTmR/58jgqkuEjZPcz5U6QeMA+ijafomCz4ixsYj2UmaLVT/3dRU2J6/7GAoE0dHiI3Q==";
$iss = "https://rookweb.herokuapp.com";
$aud = "https://rookweb.herokuapp.com/student-users";
$iat = time();
$nbf = $iat + 1;
$exp = $nbf + 600000000000;

if(!function_exists('getallheaders')){
    function getallheaders(){
        $headers = array();
        foreach ($_SERVER as $name => $value) {
            if (substr($name, 0, 5) == 'HTTP_') {
                $headers[str_replace(' ', '-', ucwords(strtolower(str_replace('_', ' ', substr($name, 5)))))] = $value;
            }
        }
        return $headers;
    }
}
?>