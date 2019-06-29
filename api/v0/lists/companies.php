<?php
/**
 * Created by PhpStorm.
 * User: delmwinbaeka
 * Date: 4/16/19
 * Time: 1:37 AM
 */


/**
 * @api {get} /lists/companies ListAllCompanies
 * @apiVersion 0.0.1
 * @apiName ListAllCompanies
 * @apiGroup Lists
 * @apiPermission none
 *
 * @apiDescription Returns the companies on the platform and the short details to populate a list. Also contains if user
 * is subscribed to the company
 *
 * @apiHeader {String} x-ROOK-token User's unique jwt sent from client
 *
 * @apiSuccess {Boolean} success=true Shows if request was successful or not
 * @apiSuccess {String} errorMessage Contains the error message generated
 * @apiSuccess {String} errorCode Programmable defined error messages
 * @apiSuccess {Object[]} result List of Request Output for User
 * @apiSuccess {Object[]} result.companies List of companies
 * @apiSuccess {String} result.companies.cname Company name
 * @apiSuccess {String} result.companies.type Company name
 * @apiSuccess {String} result.companies.location Company location address
 * @apiSuccess {String} result.companies.cid Company id
 * @apiSuccess {String} result.companies.bio Company short bio
 * @apiSuccess {String} result.companies.logo Company logo url
 * @apiSuccess {String="1", "0"} result.companies.subscribed Company name
 * @apiSuccess {Number} result.count Number of companies
 *
 * @apiSuccessExample {json} Success-Response:
 *  HTTP/1.1 200 OK
 * {
 *      "success": true,
 *      "errorMessage": null,
 *      "errorCode": null,
 *      "result": {
 *                  "count": 1,
 *                  "companies": [
 *                             {
 *                                  "cname": "Rook+",
 *                                  "cid": "1",
 *                                  "type": "Tech",
 *                                  "location": "East Legon, Accra Ghana",
 *                                  "bio": "Company is a tech company specialized in recruitment",
 *                                  "logo": "image URL",
 *                                  "subscribed": "1",
 *                             }
 *                          ]
 *                 }
 *  }
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

        $data = $student->getCompaniesList();

        echo json_encode(
            array(
                "success" => true,
                "errorMessage" => null,
                "errorCode" => null,
                "result" => array(
                    "companies" => $data,
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
