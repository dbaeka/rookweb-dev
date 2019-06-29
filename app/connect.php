<?php

require 'clean.php';
date_default_timezone_set("Africa/Accra");

$key = '36c31907b1138f201022';
$baseUrl = 'https://rookweb.herokuapp.com';
$cp_key = 'E8C48D4BBAC8FDC0484E58E579EB74C3';
$fb_key = 'AAAArQP7pdg:APA91bERJRgVaS0ELjLuOx5Gt4p94Ky9Pikw5UcigRe0I-IXQvUiExX7C8zuMcW0z0BRg2Ic_7-NjiBZ_wxc-fnkKfErgThM7oSZEJIbmNVTsX6cobQHSDkVaPVaVHgqzeSQFgDaubhc';

$database = array();
$environment = getenv("RUN_ENVIRONMENT");

if ($environment == "DEVELOPMENT"){
    $database["host"] = "localhost:3306";
    $database["username"] = "myrooker_master";
    $database["password"] = "rookMasterdb7";
    $database["db_name"] =  "myrooker_develDB";
} else {
//Get Heroku ClearDB connection information
   // $cleardb_url = parse_url(getenv("CLEARDB_DATABASE_URL"));
    $database["host"] = "localhost:3306";//$cleardb_url["host"];
    $database["username"] = "rook_dev";//$cleardb_url["user"];
    $database["password"] = "rookDevel@123";//$cleardb_url["pass"];
    $database["db_name"] =  "devel_db";//substr($cleardb_url["path"], 1);
}

$help = '<script type="text/javascript">
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src=\'https://embed.tawk.to/5b11210710b99c7b36d489d7/default\';
        s1.charset=\'UTF-8\';
        s1.setAttribute(\'crossorigin\',\'*\');
        s0.parentNode.insertBefore(s1,s0);
        })();
        </script>';

$link = mysqli_connect($database["host"], $database["username"], $database["password"], $database["db_name"]);
if (!$link) {
	die(header('location: 500'));
    // die('Could not connect: '.mysql_error());
}

$footer = 'Copyright &copy; <script>document.write(new Date().getFullYear());</script>. Rook+. All Rights Reserved. <b><a href="terms">Terms and Conditions</a></b>'.$help;

?>
