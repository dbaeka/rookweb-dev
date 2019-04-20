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
    /**
     * @var $conn PDO
     */
    private $conn;
    private $table_name = "students";
    private $table_user = "appusers";
    private $base_url = "https://rookweb.herokuapp.com";

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
        $userdata = $this->getUserData($this->apid, 'stid', 'active', 'phone');
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

    public function getUserData($apid)
    {
        $func_num_args = func_num_args();
        $func_get_args = func_get_args();

        $userid = $this->getUserID();
        if ($func_num_args > 1) {
            unset($func_get_args[0]);
            $fields = '' . implode(',', $func_get_args) . '';
            $userid = $this->clean($userid);
            $query = "SELECT $fields FROM students WHERE stid='$userid' ";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }

    private function getUserID()
    {
        $this->apid = $this->clean($this->apid);
        $query = "SELECT userid FROM " . $this->table_user . " WHERE apid=782"; //. $this->apid;
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
        $userdata = $this->getUserData($this->apid, 'fname', 'lname', 'gender', 'dob', 'school', 'program', 'year', 'city', 'state', 'postal', 'country', 'phone', 'avatar');
        $userdata["email"] = $this->email;
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
        echo $userid;
        $userid = $this->clean($userid);
        $query = "SELECT DISTINCT company.cname, company.type, company.location, company.bio, concat('" . $this->base_url .
            "','/img/avatar/',company.logo) as logo, (1-ISNULL(subscribe.sbid)) as subscribed FROM company LEFT JOIN subscribe 
            ON company.cid=subscribe.cid AND subscribe.stid=" . $userid . " WHERE company.active='1' ORDER BY company.cname ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}


?>