<?php
/**
 * Created by PhpStorm.
 * User: delmwinbaeka
 * Date: 4/16/19
 * Time: 1:37 AM
 */


/**
 * @api {get} /lists/videos ListAllVideos
 * @apiVersion 0.0.1
 * @apiName ListAllVideos
 * @apiGroup Lists Home
 * @apiPermission none
 *
 * @apiDescription Returns the Videos to populate the Home section
 *
 * @apiHeader {String} x-ROOK-token User's unique jwt sent from client
 *
 * @apiSuccess {Boolean} success=true Shows if request was successful or not
 * @apiSuccess {String} errorMessage Contains the error message generated
 * @apiSuccess {String} errorCode Programmable defined error messages
 * @apiSuccess {Object[]} result List of Request Output for User
 * @apiSuccess {Object[]} result.videos List of videos
 * @apiSuccess {String} result.videos.cname Company name
 * @apiSuccess {String} result.videos.id Video id
 * @apiSuccess {String} result.videos.link URL to video
 * @apiSuccess {String} result.videos.views Number of video views
 * @apiSuccess {String} result.videos.timepost Time video was posted
 * @apiSuccess {String} result.videos.logo Company logo url
 * @apiSuccess {String} result.videos.category Category of video
 * @apiSuccess {String} result.videos.title Video title
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
 *                  "videos": [
 *                             {
 *                                  "id": "1",
 *                                  "views": "2",
 *                                  "link": "https://www.youtube.com/watch?v=zfLcdBuB7NY&list=PLqtuzCJ-NAlb0mFcL9YfFlc3XHivFPzl8&index=15",
 *                                  "title": "Career talk about the positions available at the company",
 *                                  "timepost": "2019-06-29 06:36:32",
 *                                  "cname": "Rook+ Medical Centre",
 *                                  "logo": "https://myrookery.com/img/avatar/companybf208186f1.png",
 *                                  "category": "Technology"
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

        $data = $student->getVideosList();

        echo json_encode(
            array(
                "success" => true,
                "errorMessage" => null,
                "errorCode" => null,
                "result" => array(
                    "videos" => $data,
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
