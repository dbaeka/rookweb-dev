<?php
/**
 * User: delmwinbaeka
 * Date: 4/2/19
 * Time: 9:09 PM
 */

class Database {

    private $host;
    private $db_name;
    private $username;
    private $password;
    private $environment;

    public $conn;

    public function __construct()
    {
        $this->environment = getenv("RUN_ENVIRONMENT");
        if ($this->environment == "DEVELOPMENT"){
            $this->host = "localhost:3306";
            $this->db_name = "myrooker_develDB";
            $this->username = "myrooker_master";
            $this->password = "rookMasterdb7";
        } else {
            $cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));
            $this->host = $cleardb_url["host"];
            $this->db_name = substr($cleardb_url["path"], 1);
            $this->username = $cleardb_url["user"];
            $this->password = $cleardb_url["pass"];
        }
    }

    public function getConnection(){
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ":3306;dbname=" . $this->db_name, $this->username, $this->password);
        } catch (PDOException $exception){
            error_log($exception->getMessage());
            header('location: 500');
            die("location: 500");
        }

        return $this->conn;
    }
}

?>
