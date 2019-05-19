<?php
/**
 * Created by PhpStorm.
 * User: delmwinbaeka
 * Date: 4/8/19
 * Time: 11:14 PM
 */

/**
 * @api {get} /company/profile GetCompanyProfile
 * @apiVersion 0.0.1
 * @apiName GetCompanyProfile
 * @apiGroup Company
 * @apiPermission none
 *
 * @apiDescription Returns the student's complete profile
 *
 * @apiHeader {String} x-ROOK-token User's unique jwt sent from client
 *
 * @apiSuccess {Boolean} success=true Shows if request was successful or not
 * @apiSuccess {String} errorMessage Contains the error message generated
 * @apiSuccess {String} errorCode Programmable defined error messages
 * @apiSuccess {Object} result List of Request Output for User
 * @apiSuccess {Object} result.user User info for student
 * @apiSUccess {String} result.user.fname Student first name
 * @apiSUccess {String} result.user.lnzme Student last name
 * @apiSUccess {String="m","f"} result.user.gender Student gender
 * @apiSUccess {String} result.user.dob Student date of birth. Format: year-month-day eg. 1997-02-20
 * @apiSUccess {String} result.user.city City student is located in
 * @apiSUccess {String} result.user.nationality Student nationality
 * @apiSUccess {String="employed","student"} result.user.employment_status Student employment status
 * @apiSUccess {String="single","married"} result.user.marital_status Student marital status
 * @apiSUccess {String} result.user.phone Student phone number
 * @apiSUccess {String} result.user.avatar Student avatar url
 * @apiSUccess {String} result.user.email Student email address
 * @apiSUccess {Object[]} result.user.interests List of student's interests
 * @apiSUccess {String} result.user.interests.title Title of student's interest
 * @apiSUccess {String} result.user.interests.id id of student's interest as saved in database
 * @apiSUccess {Object[]} result.user.education List of student's education
 * @apiSUccess {String} result.user.education.name Name of student's school
 * @apiSUccess {String} result.user.education.id id of student's education as in database
 * @apiSUccess {String} result.user.education.completion Year of completion from school
 * @apiSUccess {String} result.user.education.course Course taken in school
 * @apiSUccess {String} result.user.education.level Level of student in the school
 * @apiSUccess {Object} result.user.stats Student's statistics information
 * @apiSUccess {Number} result.user.stats.total_tasks Total tasks started by student
 * @apiSUccess {Number} result.user.stats.completed Number of completed tasks
 * @apiSUccess {Number} result.user.stats.points Points accrued by student
 * @apiSUccess {Number} result.user.stats.success_rate Success rate of student
 * @apiSUccess {Number} result.user.stats.speed Speed score of student
 * @apiSUccess {Object[]} result.user.stats.badges List of student's badge achievements
 * @apiSUccess {String} result.user.stats.badges.name Name of student's badge
 * @apiSUccess {String} result.user.stats.badges.image Image url for badge achieved
 * @apiSUccess {Object[]} result.user.experience List of student's work experience
 * @apiSUccess {String} result.user.experience.name Name of student's workplace
 * @apiSUccess {String} result.user.experience.id id of student's work experience as in database
 * @apiSUccess {String} result.user.experience.location Location of workplace
 * @apiSUccess {String} result.user.experience.title Title of experience or position
 * @apiSUccess {String="1", "0"} result.user.experience.is_current If student is cuurently at the workplace
 * @apiSUccess {String} result.user.experience.start_date Start date of experience. Format: year-month eg. 2012-01
 * @apiSUccess {String} result.user.experience.end_date End date of experience. Format: year-month eg. 2012-01
 * @apiSUccess {Object[]} result.user.skills List of student's skills
 * @apiSUccess {String} result.user.skills.title Title of student's skills
 * @apiSUccess {String} result.user.skills.id id of student's skill as saved in database
 * @apiSUccess {Object[]} result.user.portfolio List of student's portfolio
 * @apiSUccess {String} result.user.portfolio.name Name of student's portfolio
 * @apiSUccess {String} result.user.portfolio.id id of student's portfolio as in database
 * @apiSUccess {String} result.user.portfolio.description Portfolio description
 * @apiSUccess {String} result.user.portfolio.start_date Start date of experience. Format: year-month eg. 2012-01
 * @apiSUccess {String} result.user.portfolio.end_date End date of experience. Format: year-month eg. 2012-01
 * @apiSUccess {Object[]} result.user.portfolio.items List of links or images added to portfolio
 * @apiSUccess {String} result.user.portfolio.items.item_id id of item in database
 * @apiSUccess {String="link", "image"} result.user.portfolio.items.type Type of portfolio item
 * @apiSUccess {String} result.user.portfolio.items.url Url of portfolio item
 * @apiSUccess {Object} result.user.aptitude Student aptitude tests information
 * @apiSUccess {Number} result.user.aptitude.tests_taken Number of tests taken
 * @apiSUccess {Number} result.user.aptitude.highest_score Highest score on all tests taken
 * @apiSUccess {Number} result.user.aptitude.average_score Average score on all tests taken
 * @apiSUccess {Number} result.user.aptitude.percentile Percentile of compared to other test takers
 *
 *
 * @apiSuccessExample {json} Success-Response:
 * {
 * "success": true,
 * "errorMessage": null,
 * "errorCode": null,
 * "result": {
 * "user": {
 * "fname": "Delmwin",
 * "lname": "Baea",
 * "gender": "m",
 * "dob": "1997-02-13",
 * "city": "Accra",
 * "nationality": "Ghana",
 * "employment_status": "student",
 * "marital_status": "single",
 * "phone": "233503878809",
 * "avatar": "https://myrookery.com/img/avatar/rookUser465.png",
 * "email": "delmwinbaeka@myrookery.com",
 * "interests": [
 * {
 * "title": "dancing",
 * "id": "3"
 * },
 * {
 * "title": "surfing",
 * "id": "4"
 * }
 * ],
 * "education": [
 * {
 * "name": "University of Ghana",
 * "id": "18",
 * "completion": "2025",
 * "course": "Electrical Engineering",
 * "level": "Sophomore"
 * },
 * {
 * "name": "University of Michigan",
 * "id": "19",
 * "completion": "2020",
 * "course": "Electrical Engineering",
 * "level": "Sophomore"
 * }
 * ],
 * "stats": {
 * "total_tasks": 20,
 * "completed": 4,
 * "points": 689,
 * "success_rate": 20,
 * "speed": 60,
 * "badges": [
 * {
 * "name": "badge1",
 * "image": "https://badges/1"
 * },
 * {
 * "name": "badge2",
 * "image": "https://badges/2"
 * }
 * ]
 * },
 * "experience": [
 * {
 * "name": "Rook+",
 * "id": "25",
 * "location": "Tema, Ghana",
 * "title": "Electrical Engineer",
 * "is_current": "0",
 * "start_date": "2018-03",
 * "end_date": "2019-02"
 * },
 * {
 * "name": "DreamOval Limited",
 * "id": "26",
 * "location": "Accra, Ghana",
 * "title": "Software Engineer Intern",
 * "is_current": "0",
 * "start_date": "0",
 * "end_date": "0"
 * }
 * ],
 * "skills": [
 * {
 * "title": "c++",
 * "id": "1"
 * },
 * {
 * "title": "python",
 * "id": "2"
 * }
 * ],
 * "portfolio": [
 * {
 * "title": "iOS App Project",
 * "id": "1",
 * "description": "Project about developing iOS apps for everyone",
 * "start_date": "2019-02",
 * "end_date": "2020-05",
 * "items": null
 * },
 * {
 * "title": "iOS App Project 2",
 * "id": "2",
 * "description": "Project about developing iOS apps for everyone",
 * "start_date": "2019-02",
 * "end_date": "2020-05",
 * "items": null
 * },
 * {
 * "title": "iOS App Project",
 * "id": "19",
 * "description": "Project about developing iOS apps for everyone",
 * "start_date": "2019-02",
 * "end_date": "2020-05",
 * "items": null
 * },
 * {
 * "title": "iOS App Project 2",
 * "id": "20",
 * "description": "Project about developing iOS apps for everyone",
 * "start_date": "2019-02",
 * "end_date": "2020-05",
 * "items": [
 * {
 * "item_id": "22",
 * "type": "image",
 * "url": "https://winiw.eqeoqco.qefqfqef"
 * },
 * {
 * "item_id": "24",
 * "type": "link",
 * "url": "https://sdwrfwr.eqeoqco.qefqfqef"
 * },
 * {
 * "item_id": "23",
 * "type": "image",
 * "url": "https://adadadao.qefqfqef"
 * }
 * ]
 * }
 * ],
 * "aptitude": {
 * "tests_taken": 20,
 * "highest_score": 69,
 * "average_score": 99,
 * "percentile": 64
 * }
 * }
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

        echo json_encode(
            array(
                "success" => true,
                "errorMessage" => null,
                "errorCode" => null,
                "result" => array(
                    "company" => $student->getCompanyProfile()
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
    echo json_encode(array("message" => "Access denied."));
}
?>