<?php
/**
 * User: delmwinbaeka
 * Date: 4/2/19
 * Time: 9:19 PM
 */


class Student
{
    public $apid;
    public $firstname;
    public $lastname;
    public $email;
    public $gender;
    public $dateOfBirth;
    public $password;
    public $phone;
    public $firebaseToken;
    public $socialToken;
    public $socialID;
    public $interests;
    public $skills;
    public $portfolio;
    public $education;
    public $work_experience;
    /**
     * @var $conn PDO
     */
    private $conn;
    private $table_name = "students";
    private $table_user = "appusers";
    private $base_url = "https://myrookery.com";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function createAccount()
    {

        if (!($this->genderValidate($this->gender) && $this->emailValidate($this->email) && !empty($this->password) && $this->phoneValidate($this->phone) && $this->nameValidate($this->firstname, $this->lastname) && $this->dobValidate($this->dateOfBirth)))
            return false;

        $data = [
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'gender' => $this->gender,
            'dateOfBirth' => $this->dateOfBirth,
            'phone' => $this->phone,
            'timenow' => date("Y-m-d H:i:s", time())
        ];

        $query = "INSERT INTO " . $this->table_name . " (fname, lname, gender, dob, phone, date) VALUES(:firstname, :lastname, :gender, :dateOfBirth, :phone, :timenow)";

        $stmt = $this->conn->prepare($query);

        if ($stmt->execute($data)) {
            $userid = $this->conn->lastInsertId();
            $usertype = "s";
            $this->firebaseToken = $this->clean($this->firebaseToken);
            $password_hash = password_hash($this->password, PASSWORD_BCRYPT);

            $data = [
                'userid' => $userid,
                'email' => $this->email,
                'user_type' => $usertype,
                'firebase' => $this->firebaseToken,
                'password' => $password_hash,
            ];

            $query = "INSERT INTO " . $this->table_user . " (userid, email, user_type, firebase, password) VALUES(:userid, :email, :user_type, :firebase, :password)";

            $stmt = $this->conn->prepare($query);

            if ($stmt->execute($data)) {
                $this->apid = $this->conn->lastInsertId();
                $this->sendVerificationCode();
                return true;
            }
            return false;
        }

        return false;
    }

    private function genderValidate($gender)
    {
        $this->gender = $this->clean($gender);
        return !empty($this->gender) && ($this->gender == 'm' || $this->gender == 'f');
    }

    private function clean($string)
    {
        return htmlspecialchars(strip_tags($string));
    }

    private function emailValidate($email)
    {
        $this->email = $this->clean($email);
        $query = "SELECT apid FROM " . $this->table_user . " WHERE email = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $email);
        $stmt->execute();
        $num = $stmt->rowCount();
        return filter_var($this->email, FILTER_VALIDATE_EMAIL) && !empty($this->email) && !($num > 0);
    }

    private function phoneValidate($phone)
    {
        $this->phone = $this->clean($phone);
        if (empty($this->phone))
            return false;
        $code = substr($this->phone, 0, 3);
        $phone = substr($this->phone, 3, 9);
        return !empty($phone) && preg_match("/^[0-9]+$/", $phone) && ($code == '233' || $code == '234');
    }

    private function nameValidate($firstname, $lastname)
    {
        $this->firstname = $this->clean($firstname);
        $this->lastname = $this->clean($lastname);
        return !empty($this->firstname) && !empty($this->lastname);
    }

    private function dobValidate($dob)
    {
        $this->dateOfBirth = $this->clean($dob);
        if (!($this->dateOfBirth = date("Y-m-d", strtotime($this->dateOfBirth))))
            return false;
        return !empty($this->dateOfBirth);
    }

    public function sendVerificationCode()
    {
        $userid = $this->getUserID();
        $userdata = $this->getUserData($this->apid, $userid, "students", 'stid', 'active', 'phone');
        if (!empty($userdata['phone']) && $userdata['active'] == 0) {

            $phone = $userdata['phone'];
            $userid = $userdata['stid'];

            $sqnum = $this->conn->query("SELECT pcid FROM phone_code WHERE uid='$userid'")->rowCount();
            $codex = rand(10000, 99999);
            if ($sqnum == 0) {
                $this->conn->exec("INSERT INTO phone_code(`code`,`uid`) VALUES('$codex','$userid') ");
            } else {
                $this->conn->exec("UPDATE phone_code SET code='$codex' WHERE uid='$userid' ");
            }

            $message = 'Activation Code: ' . $codex . '';
            $sender_id = 'Rook';
            $this->apiSendSMS($sender_id, $message, $phone);
        }
    }

    public function getUserData($apid, $userid, $table="students")
    {
        $func_num_args = func_num_args();
        $func_get_args = func_get_args();

        $column_id = ($table == "students") ? "stid" : "cid";
        if ($func_num_args > 1) {
            unset($func_get_args[0], $func_get_args[1], $func_get_args[2]);
            $fields = '' . implode(',', $func_get_args) . '';
            $userid = $this->clean($userid);
            $query = "SELECT $fields FROM " . $table . " WHERE " . $column_id . "='$userid' ";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
        return array();
    }

    private function getUserID()
    {
        $this->apid = $this->clean($this->apid);
        $query = "SELECT userid FROM " . $this->table_user . " WHERE apid=". $this->apid;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)["userid"];
    }

    private function apiSendSMS($sender_id, $message, $phone)
    {
        global $sms_key;

        //  $url = "https://apps.mnotify.net/smsapi?key=$sms_key&to=$phone&msg=$message&sender_id=$sender_id";
        //   $result = file_get_contents($url);
        //  return $result
    }

    public function checkUserExists($socialType)
    {
        if ((!$this->emailValidate($this->email) || !$this->socialIDValidate($socialType, $this->socialID)) && !empty($this->socialID) && !empty($socialType))
            return true;
        return false;
    }

    private function socialIDValidate($socialType, $socialID)
    {
        $this->socialID = $this->clean($socialID);
        $query = "SELECT apid FROM " . $socialType . "_account" . " WHERE " . $socialType . "_id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $socialID);
        $stmt->execute();
        $num = $stmt->rowCount();
        return !empty($this->socialID) && !($num > 0);
    }

    public function socialCreate($socialType)
    {
        if (!($this->emailValidate($this->email) && $this->socialIDValidate($socialType, $this->socialID) && !empty($this->socialID) && !empty($socialType)))
            return false;

        $data = [
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'phone' => $this->phone,
            'timenow' => date("Y-m-d H:i:s", time())
        ];
        $query = "INSERT INTO " . $this->table_name . " (fname, lname, phone, date) VALUES(:firstname, :lastname, :phone, :timenow)";
        $stmt = $this->conn->prepare($query);

        if ($stmt->execute($data)) {
            $userid = $this->conn->lastInsertId();
            $usertype = "s";
            $this->firebaseToken = $this->clean($this->firebaseToken);

            $data1 = [
                'userid' => $userid,
                'email' => $this->email,
                'user_type' => $usertype,
                'firebase' => $this->firebaseToken
            ];

            $query1 = "INSERT INTO " . $this->table_user . " (userid, email, user_type, firebase) VALUES(:userid, :email, :user_type, :firebase)";
            $stmt1 = $this->conn->prepare($query1);

            if ($stmt1->execute($data1)) {
                $this->apid = $this->conn->lastInsertId();

                $data2 = [
                    'socialid' => $this->socialID,
                    'apid' => $this->apid,
                    'token' => $this->socialToken,
                    'timenow' => $data['timenow']
                ];

                $query2 = "INSERT INTO " . $socialType . "_account" . " (" . $socialType . "_id, apid, token, createdDate) VALUES(:socialid, :apid, :token, :timenow)";
                $stmt2 = $this->conn->prepare($query2);

                if ($stmt2->execute($data2)) {
                    $this->sendVerificationCode();
                    return true;
                }
            }
            return false;
        }

        return false;
    }

    public function getUserProfile()
    {
        $userid = $this->getUserID();
        $userdata = $this->getUserData($this->apid, $userid,"students", 'fname', 'lname', 'gender', 'dob', 'city', 'nationality', 'employment_status', 'marital_status', 'phone', 'avatar');
        $userdata["email"] = $this->email;
        $userdata["interests"] = $this->getInterests();
        $userdata["education"] = $this->getEducation();
        //TODO: Finish the stats part
        $userdata["stats"] = array(
            "total_tasks" => rand(0,20),
            "completed" => rand(0,6),
            "points" => rand(10,1000),
            "success_rate" => rand(0,100),
            "speed" => rand(0,100),
            "badges" => array(
                array(
                    "name" => "badge1",
                    "image" => "https://badges/1"
                ), array(
                    "name" => "badge2",
                    "image" => "https://badges/2"
                )
            )
        );
        $userdata["experience"] = $this->getWorkExperience();
        $userdata["skills"] = $this->getSkills();
        $userdata["portfolio"] = $this->getPortfolio();
        //TODO: Finish the aptitude section
        $userdata["aptitude"] = array(
            "tests_taken" => rand(5,20),
            "highest_score" => rand(60,100),
            "average_score" => rand(60,100),
            "percentile" => rand(60,100)
        );
        return $userdata;
    }

    public function getCompanyProfile($company_id)
    {
        $userdata = $this->getUserData($this->apid, $company_id, "company", 'stid', 'active', 'phone');
        $userdata["email"] = $this->email;
        $userdata["interests"] = $this->getInterests();
        $userdata["education"] = $this->getEducation();
        //TODO: Finish the stats part
        $userdata["stats"] = array(
            "total_tasks" => rand(0,20),
            "completed" => rand(0,6),
            "points" => rand(10,1000),
            "success_rate" => rand(0,100),
            "speed" => rand(0,100),
            "badges" => array(
                array(
                    "name" => "badge1",
                    "image" => "https://badges/1"
                ), array(
                    "name" => "badge2",
                    "image" => "https://badges/2"
                )
            )
        );
        $userdata["experience"] = $this->getWorkExperience();
        $userdata["skills"] = $this->getSkills();
        $userdata["portfolio"] = $this->getPortfolio();
        //TODO: Finish the aptitude section
        $userdata["aptitude"] = array(
            "tests_taken" => rand(5,20),
            "highest_score" => rand(60,100),
            "average_score" => rand(60,100),
            "percentile" => rand(60,100)
        );
        return $userdata;
    }

    public function emailExists()
    {
        $query = "SELECT apid, password FROM " . $this->table_user . " WHERE email = ? LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $this->email = $this->clean($this->email);

        $stmt->bindParam(1, $this->email);
        $stmt->execute();

        $num = $stmt->rowCount();

        if ($num > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->apid = $row["apid"];
            $this->password = $row["password"];

            return true;
        }
        return false;
    }

    public function socialExists($socialType)
    {
        $socialType = $this->clean($socialType);
        $query = "SELECT apid, email FROM " . $this->table_user . " WHERE apid=(SELECT apid FROM " . $socialType . "_account" . " WHERE " . $socialType . "_id = ? LIMIT 0,1)";

        $stmt = $this->conn->prepare($query);
        $this->socialID = $this->clean($this->socialID);

        $stmt->bindParam(1, $this->socialID);
        $stmt->execute();

        $num = $stmt->rowCount();

        if ($num > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->apid = $row["apid"];
            $this->email = $row["email"];
            return true;
        }
        return false;
    }

    public function generateJWT()
    {
        global $iss, $aud, $iat, $nbf, $exp;
        $token = array(
            "iss" => $iss,
            "aud" => $aud,
            "iat" => $iat,
            "nbf" => $nbf,
            "exp" => $exp,
            "data" => array(
                "apid" => $this->apid,
                "email" => $this->email
            )
        );
        return $token;
    }

    public function getCompaniesList()
    {
        $userid = $this->getUserID();
        $userid = $this->clean($userid);
        $query = "SELECT DISTINCT company.cname, company.cid, company.type, company.location, company.bio, concat('" . $this->base_url .
            "','/img/avatar/',company.logo) as logo, (1-ISNULL(subscribe.sbid)) as subscribed FROM company LEFT JOIN subscribe 
            ON company.cid=subscribe.cid AND subscribe.stid=" . $userid . " WHERE company.active='1' ORDER BY company.cname ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getInternshipsList()
    {
        $userid = $this->getUserID();
        $userid = $this->clean($userid);
        $query = "SELECT internships.id, internships.type, internships.location, internships.title, internships.deadline, company.cname, concat('" . $this->base_url .
            "','/img/avatar/',company.logo) as logo, categories.title as category, IFNULL(student_internships.is_applied, false) as is_applied FROM internships INNER JOIN company
                   ON company.cid = internships.comapny_id INNER JOIN categories ON categories.id = internships.category_id LEFT JOIN student_internships ON internships.id = student_internships.internship_id AND user_id=" . $userid . " 
                   WHERE company.active = '1' ORDER BY internships.deadline ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getArticlesList()
    {
        $query = "SELECT articles.id, articles.views, articles.link, articles.title, articles.timepost, company.cname, concat('" . $this->base_url .
            "','/img/avatar/',company.logo) as logo, categories.title as category FROM articles INNER JOIN company
                ON company.cid = articles.company_id INNER JOIN categories ON categories.id = articles.category_id
WHERE company.active = '1' ORDER BY articles.timepost DESC ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDiscoverList()
    {
        $query = "SELECT discover.id, concat('" . $this->base_url .
            "','/img/discover/',discover.image_url) as image_url, discover.type, discover.target_id FROM discover
ORDER BY discover.timepost DESC ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getEventsList()
    {
        $query = "SELECT events.id, events.image, events.price, events.title, events.timepost, events.location, events.event_date, events.details, company.cname, concat('" . $this->base_url .
            "','/img/avatar/',company.logo) as logo, categories.title as category FROM events INNER JOIN company
                ON company.cid = events.company_id INNER JOIN categories ON categories.id = events.category_id
WHERE company.active = '1' ORDER BY events.timepost DESC ";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPollsList()
    {
        $query = "SELECT polls.id, json_unquote(polls.options) as options, polls.title, polls.timepost, company.cname, concat('" . $this->base_url .
            "','/img/avatar/',company.logo) as logo FROM polls INNER JOIN company
   ON company.cid = polls.company_id WHERE company.active = '1' AND polls.status = '1' ORDER BY polls.timepost DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($data as &$item){
            $query = "SELECT result as 'option', count(*) as count FROM poll_results WHERE poll_id = " . $item["id"] . " GROUP BY result";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            $item["result"] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return $data;
    }

    public function getVideosList()
    {
        $query = "SELECT videos.id, videos.views, videos.link, videos.title, videos.timepost, company.cname, concat('" . $this->base_url .
            "','/img/avatar/',company.logo) as logo, categories.title as category FROM videos INNER JOIN company
         ON company.cid = videos.company_id INNER JOIN categories ON categories.id = videos.category_id
WHERE company.active = '1' ORDER BY videos.timepost DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function getRecommendedInternships()
    {
        $userid = $this->getUserID();
        $userid = $this->clean($userid);
        $query = "SELECT internships.id, internships.type, internships.location, internships.title, internships.deadline, company.cname, concat('" . $this->base_url .
            "','/img/avatar/',company.logo) as logo, categories.title as category, IFNULL(student_internships.is_applied, false) as is_applied, CAST(RAND() * 3 + 1 AS INT) as priority FROM internships INNER JOIN company
                   ON company.cid = internships.comapny_id INNER JOIN categories ON categories.id = internships.category_id LEFT JOIN student_internships ON internships.id = student_internships.internship_id AND user_id=" . $userid . " 
                   WHERE company.active = '1' ORDER BY internships.deadline ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateInterests($count)
    {
        $stmt = $this->conn;
        $success = false;
        foreach ($this->interests as $row) {
            $title = strtolower($row->title);
            $query = "INSERT INTO interests (title) VALUES ('" . $title . "')";
            if ($stmt->exec($query) > 0) {
                $interest_id = $stmt->lastInsertId();
                $query = "INSERT INTO student_interests (user_id, interest_id) VALUES ('" . $this->apid . "','" . $interest_id . "')";
                $success = $success || $stmt->exec($query) > 0;
            } else {
                $query = "SELECT id FROM interests WHERE title='" . $title . "'";
                $stmt2 = $this->conn->prepare($query);
                $stmt2->execute();
                $data = $stmt2->fetch(PDO::FETCH_ASSOC);
                $interest_id = $data["id"];
                $query = "INSERT INTO student_interests (user_id, interest_id) VALUES ('" . $this->apid . "','" . $interest_id . "')";
                $success = $success || $stmt->exec($query) > 0;
            }
        }
        return $success;
    }

    public function getInterests()
    {
        $query = "SELECT interests.title, student_interests.id FROM interests INNER JOIN student_interests ON interests.id=student_interests.interest_id 
                    WHERE user_id=" . $this->apid . " ORDER BY title ASC;";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    public function updateSkills($count)
    {
        $stmt = $this->conn;
        $success = false;
        foreach ($this->skills as $row) {
            $title = strtolower($row->title);
            $query = "INSERT INTO skills (title) VALUES ('" . $title . "')";
            if ($stmt->exec($query) > 0) {
                $skill_id = $stmt->lastInsertId();
                $query = "INSERT INTO student_skills (user_id, skill_id) VALUES ('" . $this->apid . "','" . $skill_id . "')";
                $success = $success || $stmt->exec($query) > 0;
            } else {
                $query = "SELECT id FROM skills WHERE title='" . $title . "'";
                $stmt2 = $this->conn->prepare($query);
                $stmt2->execute();
                $data = $stmt2->fetch(PDO::FETCH_ASSOC);
                $skill_id = $data["id"];
                $query = "INSERT INTO student_skills (user_id, skill_id) VALUES ('" . $this->apid . "','" . $skill_id . "')";
                $success = $success || $stmt->exec($query) > 0;
            }
        }
        return $success;
    }



    public function getSkills()
    {
        $query = "SELECT skills.title, student_skills.id FROM skills INNER JOIN student_skills ON skills.id=student_skills.skill_id 
                    WHERE user_id=" . $this->apid . " ORDER BY title ASC;";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateSchool(&$row)
    {
        $stmt = $this->conn;
        $success = false;
        $query = "INSERT INTO schools (name, location) VALUES ('" . $row->name . "','" . $row->location . "')";
        if ($stmt->exec($query) > 0) {
            $row->school_id = $stmt->lastInsertId();
            $success = $success || $stmt->exec($query) > 0;
        }
        return $success;
    }

    public function updateEducation($count)
    {
        $success = false;
        foreach ($this->education as $row) {
            $school_id = $row->school_id;
            if ($school_id < 0){
                $this->updateSchool($row);
            }
            if (isset($row->id)){
                $query = "UPDATE student_schools SET user_id=:apid, school_id=:school_id, course=:course, completion=:completion, level=:level WHERE id=". $row->id;
                $data = [
                    "apid" => $this->apid,
                    "school_id" => $row->school_id,
                    "course" => $row->course,
                    "completion" => $row->completion,
                    "level" => $row->level
                ];
                $stmt = $this->conn->prepare($query);
                $result = $stmt->execute($data);
                $success = $success || $result ;
            } else {
                $query = "INSERT INTO student_schools (user_id, school_id, course, completion, level) VALUES (:apid, :school_id, :course, :completion, :level)";
                $data = [
                    "apid" => $this->apid,
                    "school_id" => $row->school_id,
                    "course" => $row->course,
                    "completion" => $row->completion,
                    "level" => $row->level
                ];
                $stmt = $this->conn->prepare($query);
                $result = $stmt->execute($data);
                $success = $success || $result ;
            }
        }
        return $success;
    }

    public function getEducation()
    {
        $query = "SELECT schools.name, student_schools.id, student_schools.completion, student_schools.course, student_schools.level FROM schools 
        INNER JOIN student_schools ON schools.id=student_schools.school_id WHERE user_id=" . $this->apid . " ORDER BY completion DESC;";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateWorkplace(&$row)
    {
        $stmt = $this->conn;
        $success = false;
        $query = "INSERT INTO workplaces (name, location) VALUES ('" . $row->name . "','" . $row->location . "')";
        if ($stmt->exec($query) > 0) {
            $row->workplace_id = $stmt->lastInsertId();
            $success = $success || $stmt->exec($query) > 0;
        }
        return $success;
    }

    public function updateWorkExperience($count)
    {
        $success = false;
        foreach ($this->work_experience as $row) {
            $workplace_id = $row->workplace_id;
            if ($workplace_id < 0){
                $this->updateWorkplace($row);
            }
            if (isset($row->id)) {
                $query = "UPDATE student_workplaces SET user_id=:apid, workplace_id=:workplace_id, title=:title, is_current=:is_current, start_date=:start_date, end_date=:end_date WHERE id=". $row->id;
                $data = [
                    "apid" => $this->apid,
                    "workplace_id" => $row->workplace_id,
                    "title" => $row->title,
                    "is_current" => $row->is_current,
                    "start_date" => isset($row->start_date) ? $this->str2date($row->start_date) : "0",
                    "end_date" => isset($row->end_date) ? $this->str2date($row->end_date) : "0"
                ];
                $stmt = $this->conn->prepare($query);
                $result = $stmt->execute($data);
                $success = $success || $result ;
            } else {
                $query = "INSERT INTO student_workplaces (user_id, workplace_id, title, is_current, start_date, end_date) VALUES (:apid, :workplace_id, :title, :is_current, :start_date, :end_date)";
                $data = [
                    "apid" => $this->apid,
                    "workplace_id" => $row->workplace_id,
                    "title" => $row->title,
                    "is_current" => $row->is_current,
                    "start_date" => isset($row->start_date) ? $this->str2date($row->start_date) : "0",
                    "end_date" => isset($row->end_date) ? $this->str2date($row->end_date) : "0"
                ];
                $stmt = $this->conn->prepare($query);
                $result = $stmt->execute($data);
                $success = $success || $result ;
            }

        }
        return $success;
    }

    private function str2date($date){
        return date("Y-m", strtotime($date));
    }

    public function getWorkExperience()
    {
        $query = "SELECT workplaces.name, student_workplaces.id, workplaces.location, student_workplaces.title ,student_workplaces.is_current, student_workplaces.start_date, student_workplaces.end_date FROM workplaces 
        INNER JOIN student_workplaces ON workplaces.id=student_workplaces.workplace_id WHERE user_id=" . $this->apid . " ORDER BY end_date DESC;";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updatePortfolioItem(&$row)
    {
        $stmt = $this->conn;
        $success = false;
        foreach ($row->items as $item){
            if(isset($item->item_id)){
                $query = "UPDATE portfolio_items SET portfolio_id='$row->portfolio_id', type='$item->type', url='$item->type' WHERE id=" . $item->item_id;
                $result = $stmt->exec($query) > 0;
                $success = $success || $result;
            } else {
                $query = "INSERT INTO portfolio_items (portfolio_id, type, url) VALUES ('" . $row->portfolio_id . "','" . $item->type . "','" . $item->url . "')";
                $result = $stmt->exec($query) > 0;
                $success = $success || $result;
            }
        }
        return $success;
    }

    public function updatePortfolio($count)
    {
        $success = false;
        foreach ($this->portfolio as $row) {
            if (isset($row->id)){
                $query = "UPDATE student_portfolios SET user_id=:apid, title=:title, description=:description, start_date=:start_date, end_date=:end_date WHERE id=" . $row->id;
                $data = [
                    "apid" => $this->apid,
                    "title" => $row->title,
                    "description" => isset($row->description) ? $row->description : "",
                    "start_date" => isset($row->start_date) ? $this->str2date($row->start_date) : "0",
                    "end_date" => isset($row->end_date) ? $this->str2date($row->end_date) : "0"
                ];
                $stmt = $this->conn->prepare($query);
                $result = $stmt->execute($data);
                if ($result && isset($row->items) ) {
                    $row->portfolio_id = $row->id;
                    $this->updatePortfolioItem($row);
                }
                $success = $success || $result ;
            } else {
                $query = "INSERT INTO student_portfolios (user_id, title, description, start_date, end_date) VALUES (:apid, :title, :description, :start_date, :end_date)";
                $data = [
                    "apid" => $this->apid,
                    "title" => $row->title,
                    "description" => isset($row->description) ? $row->description : "",
                    "start_date" => isset($row->start_date) ? $this->str2date($row->start_date) : "0",
                    "end_date" => isset($row->end_date) ? $this->str2date($row->end_date) : "0"
                ];
                $stmt = $this->conn->prepare($query);
                $result = $stmt->execute($data);
                if ($result && isset($row->items) ) {
                    $row->portfolio_id = $this->conn->lastInsertId();
                    $this->updatePortfolioItem($row);
                }
                $success = $success || $result ;
            }
        }
        return $success;
    }

    public function getPortfolio()
    {
        $query = 'SELECT student_portfolios.title, student_portfolios.id, student_portfolios.description, student_portfolios.id, student_portfolios.start_date,
       student_portfolios.end_date, CONCAT(\'[\', GROUP_CONCAT(CONCAT(\'{"item_id":"\', portfolio_items.id, \'",\', \'"type":"\',type,\'", \',\'"url":"\',url,\'"}\')) , \']\') AS items
FROM student_portfolios LEFT OUTER JOIN portfolio_items ON student_portfolios.id=portfolio_items.portfolio_id WHERE user_id=' . $this->apid . ' 
GROUP BY student_portfolios.id ORDER BY end_date DESC;';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($data as $key => $value){
            $data[$key]["items"] = json_decode($data[$key]["items"], true);
        }
        return $data;
    }

    public function updateDemographics($data){
        $fields = array();
        foreach ($data as $key => $value){
            $string = $key . "='" . $value . "'";
            array_push($fields, $string);
        }
        $fields = '' . implode(',', $fields) . '';
        $userid = $this->getUserID();
        $query = "UPDATE " . $this->table_name . " SET $fields WHERE stid='$userid' ";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute();
    }
}


?>