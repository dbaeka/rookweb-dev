<?php

/**
 * Created by PhpStorm.
 * User: delmwinbaeka
 * Date: 4/8/19
 * Time: 11:14 PM
 */


/**
 * @api {post} /users/update_education UpdateUserEducation
 * @apiVersion 0.0.1
 * @apiName UpdateUserEducation
 * @apiGroup Users
 * @apiPermission none
 *
 * @apiDescription Adds the array of education to the specified user. Returns true if at least one new education was added.
 * Returns false otherwise.
 *
 * @apiHeader {String} x-ROOK-token User's unique jwt sent from client
 *
 * @apiParam {Object[]} education List of education
 * @apiParam {Number} education.school_id School ID of schools in database. The list of schools is retrieved from database using lists/schools endpoint. Use value of -1 for schools not found in the list (Requires you use name and location)
 * @apiParam {String} [education.name] Name of school if not in the list. Use if school_id is -1
 * @apiParam {String} [education.location] Location of added school that is not in the list. Use if school_id is -1
 * @apiParam {Number} [education.id] id of education if the user is updating an old education. Omit if the education is a new addition
 * @apiParam {String} education.course Course student is offering
 * @apiParam {Number} education.completion Completion year of education. Format: year eg. 2019
 * @apiParam {String} education.level Level of student. Eg. Sophomore, SHS3 etc
 * @apiParam {Number} count Number of education in list
 *
 * @apiParamExample {json} Request-Example:
 *
 *  {
 * "education": [
 * {
 * "school_id": 1,
 * "id": 18,
 * "course": "Electrical Engineering",
 * "completion": 2025,
 * "level": "Sophomore"
 * },
 * {
 * "school_id": -1,
 * "name": "University of Michigan",
 * "location": "Michigan, Detroit",
 * "course": "Electrical Engineering",
 * "completion": 2020,
 * "level": "Sophomore"
 * }
 * ],
 * "count": 2
 * }
 *
 *
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
        if(isset($data->education, $data->count)){
            $student->education = $data->education;
            if($student->updateEducation($data->count)){
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
                        "errorMessage" => "Education already exists for user",
                        "errorCode" => "UPDATE_EDUCATION_ERROR",
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
