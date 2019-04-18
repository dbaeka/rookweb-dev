<?php
/**
 * Created by PhpStorm.
 * User: delmwinbaeka
 * Date: 4/6/19
 * Time: 3:33 PM
 */

header("Access-Control-Allow-Origin: http://localhost:8080/api/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once 'config/database.php';
include_once 'objects/student.php';
include_once 'config/core.php';
include_once 'libs/php-jwt/BeforeValidException.php';
include_once 'libs/php-jwt/ExpiredException.php';
include_once 'libs/php-jwt/SignatureInvalidException.php';
include_once 'libs/php-jwt/JWT.php';
use  \Firebase\JWT\JWT;

$database = new Database();
$db = $database->getConnection();

$student = new Student($db);
$data = json_decode(file_get_contents("php://input"));

$jwt = isset($data->jwt) ? $data->jwt : "";

if($jwt){
    try {
        $decoded = JWT::decode($jwt, base64_decode($jwtkey), array('HS256'));

        http_response_code(200);

        echo json_encode(array(
            "message" => "Access granted.",
            "data" => $decoded->data
        ));
    } catch (\Firebase\JWT\ExpiredException $e){
        $token = $student->generateJWT();
        $jwt = JWT::encode($token, base64_decode($jwtkey));
        http_response_code(401);
        echo json_encode(array(
            "message" => "JWT refreshed",
            "error" => $e->getMessage(),
            "jwt" => $jwt
        ));
    } catch (\Firebase\JWT\BeforeValidException | \Firebase\JWT\SignatureInvalidException $e){
        http_response_code(401);
        echo json_encode(array(
            "message" => "Access denied.",
            "error" => $e->getMessage()
        ));
    }
} else {
    http_response_code(401);
    echo json_encode(array("message" => "Access denied."));
}