<?php


/**
 * @api {post} /users/update_demographics UpdateUserDemographics
 * @apiVersion 0.0.1
 * @apiName UpdateUserDemographics
 * @apiGroup Users
 * @apiPermission none
 *
 * @apiDescription Update the demographic information of student. Returns true if successful. False otherwise
 *
 * @apiHeader {String} x-ROOK-token User's unique jwt sent from client
 *
 * @apiParam {String} [fname] Student first name
 * @apiParam {String} [lnzme] Student last name
 * @apiParam {String="m","f"} [gender] Student gender
 * @apiParam {String} [dob] Student date of birth. Format: day month year eg. 20 February 1997
 * @apiParam {String} [city] City student is located in
 * @apiParam {String} [nationality] Student nationality. List of available countries is populated from lists/countries endpoint
 * @apiParam {String="employed","student"} [employment_status] Student employment status
 * @apiParam {String="single","married"} [marital_status] Student marital status
 * @apiParam {String} [phone] Student phone number
 * @apiParam {String} [avatar] Student avatar url
 * @apiParam {String} [email] Student email address
 *
 * @apiParamExample {json} Success-Response:
 * {
 * "fname": "Delmwin",
 * "lname": "Baea",
 * "city": "Accra"
 * }
 *
 * @apiSuccess {Boolean} success=true Shows if request was successful or not
 * @apiSuccess {String} errorMessage Contains the error message generated
 * @apiSuccess {String} errorCode Programmable defined error messages
 * @apiSuccess {Object[]} result List of Request Output for User
 *
 * @apiSuccessExample {json} Success-Response:
 *  HTTP/1.1 200 OK
 * {
 *      "success": true,
 *      "errorMessage": null,
 *      "errorCode": null,
 *      "result": null
 *  }
 *
 *
 * @apiError {String} UPDATE_EDUCATION_ERROR Education already exists for user
 * @apiError {String} MISSING_PARAMETERS Missing one or two parameters in request
 *
 * @apiErrorExample Error-Response (Example):
 *     HTTP/1.1 401 Not Authenticated
 *     {
 *       "success": false,
 *       "errorMessage": "Education already exists for user",
 *       "errorCode": "UPDATE_EDUCATION_ERROR",
 *       "result": null
 *     }
 */


header("Access-Control-Allow-Origin: http://localhost:8080/api/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/student.php';
include_once '../config/core.php';
include_once '../libs/php-jwt/BeforeValidException.php';
include_once '../libs/php-jwt/ExpiredException.php';
include_once '../libs/php-jwt/SignatureInvalidException.php';
include_once '../libs/php-jwt/JWT.php';
use  \Firebase\JWT\JWT;

$database = new Database();
$db = $database->getConnection();

$student = new Student($db);
$headers = getallheaders();

$jwt = isset($headers["x-ROOK-token"]) ? $headers["x-ROOK-token"] : "";
if($jwt){
    try {
        $decoded = JWT::decode($jwt, base64_decode($jwtkey), array('HS256'));
        $student->apid = $decoded->data->apid;
        $student->email = $decoded->data->email;

        $data = json_decode(file_get_contents("php://input"));
        if(isset($data)){
            if($student->updateDemographics($data)){
                http_response_code(200);
                echo json_encode(
                    array(
                        "success" => true,
                        "errorMessage" => null,
                        "errorCode" => null,
                        "result" => null
                    )
                );
            } else {
                http_response_code(400);
                echo json_encode(
                    array(
                        "success" => false,
                        "errorMessage" => "Profile could not be updated for user",
                        "errorCode" => "UPDATE_DEMOGRAPHICS_ERROR",
                        "result" => null
                    )
                );
            }
        } else {
            http_response_code(400);
            echo json_encode(
                array(
                    "success" => false,
                    "errorMessage" => "Missing one or two parameters in request",
                    "errorCode" => "MISSING_PARAMETERS",
                    "result" => null
                )
            );
        }
    } catch (\Firebase\JWT\ExpiredException $e){
        $token = $student->generateJWT();
        $jwt = JWT::encode($token, base64_decode($jwtkey));
        http_response_code(401);
        echo json_encode(
            array(
                "success" => false,
                "errorMessage" => $e->getMessage(),
                "errorCode" => "JWT_EXPIRED",
                "result" => array(
                    "jwt" => $jwt
                )
            )
        );
    } catch (\Firebase\JWT\BeforeValidException | \Firebase\JWT\SignatureInvalidException $e){
        http_response_code(401);
        echo json_encode(
            array(
                "success" => false,
                "errorMessage" => $e->getMessage(),
                "errorCode" => "JWT_INVALID",
                "result" => null
            )
        );
    }
} else {
    http_response_code(401);
    echo json_encode(array("message" => "Access denied."));
}
?>
