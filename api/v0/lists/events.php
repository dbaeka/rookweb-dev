<?php
/**
 * Created by PhpStorm.
 * User: delmwinbaeka
 * Date: 4/16/19
 * Time: 1:37 AM
 */


/**
 * @api {get} /lists/events ListAllEvents
 * @apiVersion 0.0.1
 * @apiName ListAllEvents
 * @apiGroup Lists Home
 * @apiPermission none
 *
 * @apiDescription Returns the events to populate the Home section
 *
 * @apiHeader {String} x-ROOK-token User's unique jwt sent from client
 *
 * @apiSuccess {Boolean} success=true Shows if request was successful or not
 * @apiSuccess {String} errorMessage Contains the error message generated
 * @apiSuccess {String} errorCode Programmable defined error messages
 * @apiSuccess {Object[]} result List of Request Output for User
 * @apiSuccess {Object[]} result.events List of events
 * @apiSuccess {String} result.events.cname Company name
 * @apiSuccess {String} result.events.id Event id
 * @apiSuccess {String} result.events.image URL to image thumbnail
 * @apiSuccess {String} result.events.price Price of the event in GHc. 0 means free
 * @apiSuccess {String} result.events.timepost Time event was posted
 * @apiSuccess {String} result.events.logo Company logo url
 * @apiSuccess {String} result.events.title Event title
 * @apiSuccess {String} result.events.category Category of event
 * @apiSuccess {String} result.events.location Location of event
 * @apiSuccess {String} result.events.event_date Date event is happening
 * @apiSuccess {String} result.events.details Details about the event
 * @apiSuccess {Number} result.count Number of events
 *
 * @apiSuccessExample {json} Success-Response:
 *  HTTP/1.1 200 OK
 * {
 *      "success": true,
 *      "errorMessage": null,
 *      "errorCode": null,
 *      "result": {
 *                  "count": 1,
 *                  "events": [
 *                             {
 *                                  "id": "1",
*                                   "image": "https://myrookery.com/img/sat.png",
*                                   "price": "20",
*                                   "title": "SAT Trial Exams",
*                                   "timepost": "2018-06-28 12:27:19",
*                                   "location": "Aikins Educational Consult",
*                                   "event_date": "2019-06-28 12:27:39",
*                                   "details": "Take the SAT diagnostic test to find your score",
*                                   "cname": "Rook+ Artificial Intelligence",
*                                   "logo": "https://myrookery.com/img/avatar/companyf9bd769ce9.png",
*                                   "category": "Technology"
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

        $data = $student->getEventsList();

        echo json_encode(
            array(
                "success" => true,
                "errorMessage" => null,
                "errorCode" => null,
                "result" => array(
                    "events" => $data,
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
