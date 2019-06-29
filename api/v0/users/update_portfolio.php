<?php
/**
 * Created by PhpStorm.
 * User: delmwinbaeka
 * Date: 4/8/19
 * Time: 11:14 PM
 */


/**
 * @api {post} /users/update_portfolio UpdateUserPortfolio
 * @apiVersion 0.0.1
 * @apiName UpdateUserPortfolio
 * @apiGroup Users
 * @apiPermission none
 *
 * @apiDescription Adds the array of portfolio to the specified user. Returns true if at least one new portfolio was added.
 * Returns false otherwise.
 *
 * @apiHeader {String} x-ROOK-token User's unique jwt sent from client
 *
 * @apiParam {Object[]} portfolio List of portfolio
 * @apiParam {String} portfolio.title Title of portoflio
 * @apiParam {Number} [portfolio.id] id of portoflio if the user is updating an old portfolio. Omit if the portfolio is a new addition
 * @apiParam {String} portfolio.description Description of portoflio
 * @apiParam {String} portfolio.start_date Start date of portoflio. Format: month year eg. March 2019
 * @apiParam {String} portfolio.end_date End date of portoflio. Format: month year eg. March 2019
 * @apiParam {Object[]} [portfolio.items] Items represents images or links added to the portfolio
 * @apiParam {String="link","image"} portfolio.items.type Type of portoflio item
 * @apiParam {String} portfolio.items.url Url of image to add, or link
 * @apiParam {Number} [portfolio.items.item_id] id of portoflio item if the user is updating an old portfolio item. Omit if the portfolio item is a new addition
 * @apiParam {Number} count Number of portfolio in list
 *
 * @apiParamExample {json} Request-Example:
 * {
 *      "portfolio": [
 *          {
 *              "title": "iOS App Project",
 *              "description": "Project about developing iOS apps for everyone",
 *              "start_date": "February 2019",
 *              "end_date": "May 2020"
 *          },
 *          {
 *              "title": "iOS App Project 2",
 *              "id": 12,
 *              "description": "Project about developing iOS apps for everyone",
 *              "start_date": "February 2019",
 *              "end_date": "May 2020",
 *              "items": [
 *                  {
 *                      "type": "image",
 *                      "url": "https://winiw.eqeoqco.qefqfqef"
 *                  },
 *                  {
 *                      "type": "image",
 *                      "url": "https://adadadao.qefqfqef"
 *                  },
 *                  {
 *                      "type": "link",
 *                      "url": "https://sdwrfwr.eqeoqco.qefqfqef"
 *                  }
 *              ]
 *          }
 *      ],
 *      "count": 2
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
 * @apiError {String} UPDATE_PORTFOLIO_ERROR Portfolio could not be added for user
 * @apiError {String} MISSING_PARAMETERS Missing one or two parameters in request
 *
 * @apiErrorExample Error-Response (Example):
 *     HTTP/1.1 401 Not Authenticated
 *     {
 *       "success": false,
 *       "errorMessage": "Portfolio could not be added for user",
 *       "errorCode": "UPDATE_PORTFOLIO_ERROR",
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
        if(isset($data->portfolio, $data->count)){
            $student->portfolio = $data->portfolio;
            if($student->updatePortfolio($data->count)){
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
                        "errorMessage" => "Portfolio could not be added for user",
                        "errorCode" => "UPDATE_PORTFOLIO_ERROR",
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
