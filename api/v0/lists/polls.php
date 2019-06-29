<?php
/**
 * Created by PhpStorm.
 * User: delmwinbaeka
 * Date: 4/16/19
 * Time: 1:37 AM
 */


/**
 * @api {get} /lists/polls ListAllPolls
 * @apiVersion 0.0.1
 * @apiName ListAllPolls
 * @apiGroup Lists Home
 * @apiPermission none
 *
 * @apiDescription Returns the polls to populate the Home section
 *
 * @apiHeader {String} x-ROOK-token User's unique jwt sent from client
 *
 * @apiSuccess {Boolean} success=true Shows if request was successful or not
 * @apiSuccess {String} errorMessage Contains the error message generated
 * @apiSuccess {String} errorCode Programmable defined error messages
 * @apiSuccess {Object[]} result List of Request Output for User
 * @apiSuccess {Object[]} result.polls List of polls
 * @apiSuccess {String} result.polls.cname Company name
 * @apiSuccess {String} result.polls.id Poll id
 * @apiSuccess {String[]} result.polls.options Array of options that are available as answers
 * @apiSuccess {String} result.polls.timepost Time event was posted
 * @apiSuccess {String} result.polls.logo Company logo url
 * @apiSuccess {String} result.polls.title Event title
 * @apiSuccess {Object[]} result.polls.result List of polls
 * @apiSuccess {String} result.polls.result.option Answer option ID. Where 0 is first option from result.options array.
 * @apiSuccess {String} result.polls.result.count Number of users that chose the option
 * @apiSuccess {Number} result.count Number of polls
 *
 * @apiSuccessExample {json} Success-Response:
 *  HTTP/1.1 200 OK
 * {
 *      "success": true,
 *      "errorMessage": null,
 *      "errorCode": null,
 *      "result": {
 *                  "count": 1,
 *                  "polls": [
 *                             {
 *                                  "id": "1",
 *                                  "options": "[\"Yes\",\"No\",\"None\"]",
 *                                  "title": "Would you buy data for Ghc10000",
 *                                  "timepost": "2019-06-28 12:50:13",
 *                                  "cname": "Atrossy Ltd",
 *                                  "logo": "https://myrookery.com/img/avatar/companye9154c95a2.png",
 *                                  "result": [
 *                                      {
 *                                          "option": "0",
 *                                          "count": "2"
 *                                      },
 *                                      {
 *                                           "option": "1",
 *                                           "count": "1"
 *                                      }
 *                                  ]
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

        $data = $student->getPollsList();

        echo json_encode(
            array(
                "success" => true,
                "errorMessage" => null,
                "errorCode" => null,
                "result" => array(
                    "polls" => $data,
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
