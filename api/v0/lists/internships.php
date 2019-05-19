<?php


/**
 * @api {get} /lists/internships ListAllInternships
 * @apiVersion 0.0.1
 * @apiName ListAllInternships
 * @apiGroup Lists
 * @apiPermission none
 *
 * @apiDescription Returns the internships on the platform and the short details to populate a list. Also contains if user has applied
 *
 * @apiHeader {String} x-ROOK-token User's unique jwt sent from client
 *
 * @apiSuccess {Boolean} success=true Shows if request was successful or not
 * @apiSuccess {String} errorMessage Contains the error message generated
 * @apiSuccess {String} errorCode Programmable defined error messages
 * @apiSuccess {Object[]} result List of Request Output for User
 * @apiSuccess {Object[]} result.internships List of internships
 * @apiSuccess {String} result.internships.cname Company name
 * @apiSuccess {String="free","paid"} result.internships.type Type of internship
 * @apiSuccess {String} result.internships.location Location of the internship
 * @apiSuccess {String} result.internships.deadline Deadline for internship
 * @apiSuccess {String} result.internships.logo Company logo url
 * @apiSuccess {String} result.internships.id Internship id for getting specific internship from database
 * @apiSuccess {String} result.internships.title Internhsip title
 * @apiSuccess {String} result.internships.category Category of company that posted
 * @apiSuccess {String="1", "0"} result.internships.is_applied True if student has applied for internship. False otherwise
 * @apiSuccess {Number} result.count Number of internships
 *
 * @apiSuccessExample {json} Success-Response:
 *
 * {
 * "success": true,
 * "errorMessage": null,
 * "errorCode": null,
 * "result": {
 * "internships": [
 * {
 * "id": "2",
 * "type": "free",
 * "location": "East Legon",
 * "title": "Graphic Designer",
 * "deadline": "2020-04-23",
 * "cname": "4 Byte Gh",
 * "logo": "https://myrookery.com/img/avatar/rookCompa012dcd9e001b53.jpg",
 * "category": "Design",
 * "is_applied": "0"
 * },
 * {
 * "id": "1",
 * "type": "paid",
 * "location": "Accra, Ghana",
 * "title": "Software Engineer Intern",
 * "deadline": "2020-06-16",
 * "cname": "Rook+",
 * "logo": "https://myrookery.com/img/avatar/companydfebe490a7.png",
 * "category": "Technology",
 * "is_applied": "0"
 * }
 * ],
 * "count": 2
 * }
 * }
 *
 * @apiError {String} JWT_INVALID Invalid jwt provided
 * @apiError {String} JWT_EXPIRED jwt has expired and has been refreshed
 *
 * @apiErrorExample Error-Response (Example):
 *     HTTP/1.1 401 Not Authenticated
 *     {
 *       "success": false,
 *       "errorMessage": "Access Denied",
 *       "errorCode": "JWT_INVALID",
 *       "result": null
 *     }
 */


header("Access-Control-Allow-Origin: http://localhost:8080/api/");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");
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
        http_response_code(200);
        $student->apid = $decoded->data->apid;
        $student->email = $decoded->data->email;

        $data = $student->getInternshipsList();

        echo json_encode(
            array(
                "success" => true,
                "errorMessage" => null,
                "errorCode" => null,
                "result" => array(
                    "internships" => $data,
                    "count" => count($data)
                )
            )
        );
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
    echo json_encode(
        array(
            "success" => false,
            "errorMessage" => "No jwt in header",
            "errorCode" => "JWT_INVALID",
            "result" => null
        )
    );
}
