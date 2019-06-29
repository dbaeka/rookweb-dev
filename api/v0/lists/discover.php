<?php
/**
 * Created by PhpStorm.
 * User: delmwinbaeka
 * Date: 4/16/19
 * Time: 1:37 AM
 */


/**
 * @api {get} /lists/discover ListAllDiscoveries
 * @apiVersion 0.0.1
 * @apiName ListAllDiscoveries
 * @apiGroup Lists Home
 * @apiPermission none
 *
 * @apiDescription Returns the discover items to populate the Discover section
 *
 * @apiHeader {String} x-ROOK-token User's unique jwt sent from client
 *
 * @apiSuccess {Boolean} success=true Shows if request was successful or not
 * @apiSuccess {String} errorMessage Contains the error message generated
 * @apiSuccess {String} errorCode Programmable defined error messages
 * @apiSuccess {Object[]} result List of Request Output for User
 * @apiSuccess {Object[]} result.discoveries List of Discoveries
 * @apiSuccess {String} result.discoveries.id Discovery id
 * @apiSuccess {String} result.discoveries.image_url URL to image
 * @apiSuccess {String="task", "company", "rookie"} result.discoveries.type Type of discovery. If company then clickable to move to the company page using the target_id as CID. If task the target_id is the TID (task ID). If Rookie then no target.
 * @apiSuccess {String} result.discoveries.target_id Target id when tapped. Can be one of CID or TID to navigate to the correct page
 * @apiSuccess {Number} result.count Number of discoveries
 *
 * @apiSuccessExample {json} Success-Response:
 *  HTTP/1.1 200 OK
 * {
 *      "success": true,
 *      "errorMessage": null,
 *      "errorCode": null,
 *      "result": {
 *                  "count": 2,
 *                  "discoveries": [
 *                             {
 *                                  "id": "5",
 *                                   "image_url": "https://myrookery.com/img/discover/dis2.png",
 *                                   "type": "company",
 *                                   "target_id": "9"
 *                             },
 *                             {
 *                                  "id": "4",
 *                                  "image_url": "https://myrookery.com/img/discover/dis3.png",
 *                                  "type": "rookie",
 *                                  "target_id": null
}
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

        $data = $student->getDiscoverList();

        echo json_encode(
            array(
                "success" => true,
                "errorMessage" => null,
                "errorCode" => null,
                "result" => array(
                    "discoveries" => $data,
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
