<?php
session_start();

unset($_SESSION['apid']);
session_destroy();
header ('location: home');



	
	
?>