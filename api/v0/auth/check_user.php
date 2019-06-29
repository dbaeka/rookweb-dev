<?php
/**
 * Created by PhpStorm.
 * User: delmwinbaeka
 * Date: 4/15/19
 * Time: 7:48 PM
 */


/**
 * @api {post} /auth/check_user Check User
 * @apiVersion 0.0.1
 * @apiName CheckUser
 * @apiGroup Auth
 * @apiPermission none
 *
 * @apiDescription Checks if user exists with email or social account ID and then returns true if client can go ahead
 * with registration ie. no user conflict. Returns false otherwise
 *
 * @apiParam (Social) {String} email User's email address
 * @apiParam (Social) {String="facebook", "twitter", "linkedin"} socialType Social media type
 * @apiParam (Social) {String} socialID Unique ID of user with social account
 *
 * @apiParamExample {json} Request-Example (Email):
 *  {
 *      "email": "kofirook@myrookery.com",
 *      "socialType": "facebook",
 *      "socialID": "Social ID"
 *  }
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
 * @apiError {String} USER_EXIST User already exists and cannot create with email or social media account given
 * @apiError {String} MISSING_PARAMETERS Missing one or two parameters in request
 *
 * @apiErrorExample Error-Response (Example):
 *     HTTP/1.1 401 Not Authenticated
 *     {
 *       "success": false,
 *       "errorMessage": "Missing some parameters in request",
 *       "errorCode": "MISSING_PARAMETERS",
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

$database = new Database();
$db = $database->getConnection();

$student = new Student($db);

$data = json_decode(file_get_contents("php://input"));


if(isset($data->socialID, $data->email, $data->socialType)){
    $student->email = $data->email;
    $student->socialID = $data->socialID;

    if(!$student->checkUserExists($data->socialType)){
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
                "errorMessage" => "User already exists",
                "errorCode" => "USER_EXIST",
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

?>