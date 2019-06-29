<?php


/**
 * @api {post} /users/update_work_xp UpdateUserWorkExperience
 * @apiVersion 0.0.1
 * @apiName UpdateUserWorkExperience
 * @apiGroup Users
 * @apiPermission none
 *
 * @apiDescription Adds the array of work experience to the specified user. Returns true if at least one new work experience was added.
 * Returns false otherwise.
 *
 * @apiHeader {String} x-ROOK-token User's unique jwt sent from client
 *
 * @apiParam {Object[]} work_experience List of work experience
 * @apiParam {Number} work_experience.workplace_id Workplace ID of workplace in database. The list of workplaces is retrieved from database using lists/workplaces endpoint. Use value of -1 for workplace not found in the list (Requires you use name and location)
 * @apiParam {String} [work_experience.name] Name of workplace if not in the list. Use if workplace_id is -1
 * @apiParam {String} [work_experience.location] Location of added workplace that is not in the list. Use if workplace_id is -1
 * @apiParam {Number} [work_experience.id] id of work experience if the user is updating an old work experience. Omit if the work experience is a new addition
 * @apiParam {String} work_experience.title Title of work experience
 * @apiParam {Bool} work_experience.is_current True if student still works here. False otherwise
 * @apiParam {String} work_experience.start_date Start date of work experience. Format: month year eg. March 2019
 * @apiParam {String} work_experience.end_date End date of work experience. Format: month year eg. March 2019
 * @apiParam {Number} count Number of work experience in list
 *
 * @apiParamExample {json} Request-Example:
 *
 *  {
 * "work_experience": [
 * {
 * "workplace_id": 1,
 * "id": 18,
 * "title": "Electrical Engineer",
 * "start_date": "March 2018",
 * "end_date": "February 2019",
 * "is_current": false
 * },
 * {
 * "workplace_id": -1,
 * "name": "DreamOval Limited",
 * "location": "Accra, Ghana",
 * "title": "Software Engineer Intern",
 * "start_date": null,
 * "end_date": null,
 * "is_current": false
 * }
 * ],
 * "count": 2
 * }
 *
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
if ($jwt) {
    try {
        $decoded = JWT::decode($jwt, base64_decode($jwtkey), array('HS256'));
        $student->apid = $decoded->data->apid;
        $student->email = $decoded->data->email;

        $data = json_decode(file_get_contents("php://input"));
        if (isset($data->work_experience, $data->count)) {
            $student->work_experience = $data->work_experience;
            if ($student->updateWorkExperience($data->count)) {
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
                        "errorMessage" => "Work Experience already exists for user",
                        "errorCode" => "UPDATE_WORK_XP_ERROR",
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
    } catch (\Firebase\JWT\ExpiredException $e) {
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
    } catch (\Firebase\JWT\BeforeValidException | \Firebase\JWT\SignatureInvalidException $e) {
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

