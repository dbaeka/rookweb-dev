<?php

session_start();
require 'user.php';
require 'admin.php';
require 'company.php';
require 'transaction.php';

if (isset($_SESSION['apid']) == true) {
  $apid = $_SESSION['apid'];
  $ux = new User();
  $ax = new Admin();
	$cx = new Company();
	$tx = new Transaction();
  
  $uc = $ux->get_user_type($apid);
  $userid = $uc['userid'];
  $usertype = $uc['user_type'];

}
else {
  header('location: home');
  exit();
}


if(isset($_POST['avatarup'])){

	if($usertype != 's'){
		echo "You do not have the privilege to perform this action";
		exit();
	}

	$data = $_POST['avatarup'];
	$ac = $ux->change_avatar($data, $userid);
	echo $ac;
	exit();
}



if(isset($_POST['logoup'])){

	if($usertype != 'c'){
		echo "You do not have the privilege to perform this action";
		exit();
	}

	$data = $_POST['logoup'];
	$ac = $cx->change_logo($data, $userid);
	echo $ac;
	exit();
}



if(isset($_POST['action']) && $_POST['action']=='ratessolution'){
	if($usertype != 'c'){
		echo "You do not have the privilege to perform this action";
		exit();
	}

	$solution = $_POST['solution'];
	$rate = $_POST['rate'];
	if(!preg_match('/^[0-9]+$/', $rate)){
    echo "Invalid rate";
		exit();
  }
  else if($rate == 0 || $rate >= 6){
  	echo "Invalid rate";
		exit();
  }


	$ac = $cx->rate_solution($userid, $solution, $rate);
	echo $ac;
	exit();
}



if(isset($_POST['action']) && $_POST['action']=='checkpayment'){
	if($usertype != 's' && $usertype != 'c'){
		echo "You do not have the privilege to perform this action";
		exit();
	}

	$invoice = $_POST['invoice'];

	if(empty($invoice)){
		echo "Some of the fields were empty or invalid";
		exit();
	}
	
	$ac = $tx->check_invoice($apid, $invoice);
	echo $ac;
	exit();
}


if(isset($_POST['action']) && $_POST['action']=='viewapplicant'){
	if($usertype != 'c'){
		echo "You do not have the privilege to perform this action";
		exit();
	}

	$applicant = $_POST['student'];

	if(empty($applicant)){
		echo "Some of the fields were empty or invalid";
		exit();
	}
	
	$ac = $cx->view_student_cv($apid, $applicant);
	echo $ac;
	exit();
}



if(isset($_POST['action']) && $_POST['action']=='acceptstudent'){
	if($usertype != 'c'){
		echo "You do not have the privilege to perform this action";
		exit();
	}

	$applicant = $_POST['applicant'];

	if(empty($applicant)){
		echo "Some of the fields were empty or invalid";
		exit();
	}
	
	$ac = $cx->accept_applicant($apid, $applicant);
	echo $ac;
	exit();
}


if(isset($_POST['action']) && $_POST['action']=='check_applicant_code'){
	if($usertype != 'c'){
		echo "You do not have the privilege to perform this action";
		exit();
	}

	$code = $_POST['code'];

	if(empty($code)){
		echo "Some of the fields were empty or invalid";
		exit();
	}
	
	$ac = $cx->check_applicant_code($apid, $code);
	echo $ac;
	exit();
}



if(isset($_POST['action']) && $_POST['action']=='delete_company'){
	if($usertype != 'a'){
		echo "You do not have the privilege to perform this action";
		exit();
	}

	$company = $_POST['company'];

	if(empty($company)){
		echo "Some of the fields were empty or invalid";
		exit();
	}
	
	$ac = $ax->delete_company($apid, $company);
	echo $ac;
	exit();
}


if(isset($_POST['action']) && $_POST['action']=='delete_student'){
	if($usertype != 'a'){
		echo "You do not have the privilege to perform this action";
		exit();
	}

	$student = $_POST['student'];

	if(empty($student)){
		echo "Some of the fields were empty or invalid";
		exit();
	}
	
	$ac = $ax->delete_student($apid, $student);
	echo $ac;
	exit();
}



if(isset($_POST['action']) && $_POST['action']=='applytointern'){
	if($usertype != 's'){
		echo "You do not have the privilege to perform this action";
		exit();
	}

	$internship = $_POST['internship'];

	if(empty($internship)){
		echo "Some of the fields were empty or invalid";
		exit();
	}
	
	$ac = $ux->apply_to_intern($apid, $internship);
	echo $ac;
	exit();
}



if(isset($_POST['action']) && $_POST['action']=='payment'){
	if($usertype != 's' && $usertype != 'c'){
		echo "You do not have the privilege to perform this action";
		exit();
	}

	$ptype = $_POST['ptype'];
	$wallet = $_POST['wallet'];

	if(empty($ptype) || empty($wallet)){
		echo "Some of the fields were empty or invalid";
		exit();
	}elseif($ptype != 'm' && $ptype != 't'){
		echo "Some of the fields were empty or invalid";
		exit();
	}
	
	$ac = $tx->pay($apid, $ptype, $wallet);
	echo $ac;
	exit();
}


if(isset($_POST['action']) && $_POST['action']=='activate'){
	if($usertype != 's'){
		echo "You do not have the privilege to perform this action";
		exit();
	}

	$code = $_POST['code'];
	$ac = $ux->activate($userid, $code);
	echo $ac;
	exit();
}



if(isset($_POST['action']) && $_POST['action']=='editinfo'){
	if($usertype != 's'){
		echo "You do not have the privilege to perform this action";
		exit();
	}

	$ac = $ux->get_student_data($apid);
	echo $ac;
	exit();
}



if(isset($_POST['action']) && $_POST['action']=='delcvinfo'){
	if($usertype != 's'){
		echo "You do not have the privilege to perform this action";
		exit();
	}

	$tag = $_POST['tag'];
	$type = $_POST['type'];

	if($type == 'job' || $type == 'edu' || $type == 'skill'){
		$ac = $ux->update_cv($userid,$type,$tag);
		echo $ac;
		exit();
	}

	echo "Invalid CV information";
	exit();

	
}


if(isset($_POST['action']) && $_POST['action']=='editcomms'){
	if($usertype != 's'){
		echo "You do not have the privilege to perform this action";
		exit();
	}

	$ac = $ux->get_community_service($userid);
	echo $ac;
	exit();
}



if(isset($_POST['action']) && $_POST['action']=='edithobby'){
	if($usertype != 's'){
		echo "You do not have the privilege to perform this action";
		exit();
	}

	$ac = $ux->get_hobby($userid);
	echo $ac;
	exit();
}



if(isset($_POST['action']) && $_POST['action']=='editprof'){
	if($usertype != 's'){
		echo "You do not have the privilege to perform this action";
		exit();
	}

	$ac = $ux->get_professional_summary($userid);
	echo $ac;
	exit();
}


if(isset($_POST['action']) && $_POST['action']=='valusername'){
	if($usertype != 's'){
		echo "You do not have the privilege to perform this action";
		exit();
	}

	$username = $_POST['username'];
	if(!preg_match("/^[a-z\d]+$/i", $username)){
		echo 'Username must be Only letters, numbers and \'_\'';
		exit();
  }

	$ac = $ux->check_username($username);
	if($ac == 1){
		$ac = 'done';
	}
	else{
		$ac = 'Username already exists';
	}
	echo $ac;
	exit();
}


if(isset($_POST['action']) && $_POST['action']=='subscribe'){
	if($usertype != 's'){
		echo "You do not have the privilege to perform this action";
		exit();
	}

	$company = $_POST['company'];
	$ac = $ux->subscribe_to_company($userid,$company);
	echo $ac;
	exit();
}


if(isset($_POST['action']) && $_POST['action']=='watchlist'){
	if($usertype != 'c'){
		echo "You do not have the privilege to perform this action";
		exit();
	}

	$student = $_POST['student'];
	$ac = $cx->update_watchlist($userid,$student);
	echo $ac;
	exit();
}


if(isset($_POST['action']) && $_POST['action']=='viewtask'){
	if($usertype != 's'){
		echo "You do not have the privilege to perform this action";
		exit();
	}

	$task = $_POST['task'];
	$ac = $ux->get_task_info($task);
	echo $ac;
	exit();
}


if(isset($_POST['action']) && $_POST['action']=='canceltask'){
	if($usertype != 's'){
		echo "You do not have the privilege to perform this action";
		exit();
	}

	$task = $_POST['task'];
	$ac = $ux->cancel_task($userid, $task);
	echo $ac;
	exit();
}


if(isset($_POST['action']) && $_POST['action']=='deletetask'){
	if($usertype != 'c'){
		echo "You do not have the privilege to perform this action";
		exit();
	}

	$task = $_POST['task'];
	$ac = $cx->delete_task($userid, $task);
	echo $ac;
	exit();
}



if(isset($_POST['action']) && $_POST['action']=='starttask'){
	if($usertype != 's'){
		echo "You do not have the privilege to perform this action";
		exit();
	}

	$task = $_POST['task'];
	$ac = $ux->start_task($userid, $task);
	echo $ac;
	exit();
}


if(isset($_POST['action']) && $_POST['action']=='adactivate'){
	if($usertype != 'a'){
		echo "You do not have the privilege to perform this action";
		exit();
	}

	$account = $_POST['account'];
	if($_POST['type'] == 'business'){
		$type = 'b';
	}
	else if($_POST['type'] == 'demo'){
		$type = 'd';
	}
	else{
		echo "Invalid info...";exit();
	}

	$ac = $ax->activate_account($account, $type, $userid);
	echo $ac;
	exit();
}



if(isset($_POST['action']) && $_POST['action']=='deleteacc'){
	if($usertype != 'a'){
		echo "You do not have the privilege to perform this action";
		exit();
	}

	$account = $_POST['account'];
	if($_POST['type'] == 'business'){
		$type = 'b';
	}
	else if($_POST['type'] == 'demo'){
		$type = 'd';
	}
	else{
		echo "Invalid info...";exit();
	}

	$ac = $ax->delete_account($account, $type, $userid);
	echo $ac;
	exit();
}


if(isset($_POST['action']) && $_POST['action']=='deleteuacc'){
	if($usertype != 'a'){
		echo "You do not have the privilege to perform this action";
		exit();
	}

	$account = $_POST['account'];

	$ac = $ax->delete_users_account($account, $userid);
	echo $ac;
	exit();
}


if(isset($_POST['action']) && $_POST['action']=='activateuacc'){
	if($usertype != 'a'){
		echo "You do not have the privilege to perform this action";
		exit();
	}

	$account = $_POST['account'];

	$ac = $ax->activate_users_account($account, $userid);
	echo $ac;
	exit();
}


?>