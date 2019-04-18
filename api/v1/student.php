<?php

require '../app/validate.php';
require '../app/app_student.php';

$val = new Validate();
$sx = new Student();

if(isset($_POST['action']) && $_POST['action']=='update_personal_info'){
	if(isset($_POST['token'], $_POST['username'], $_POST['fname'], $_POST['lname'], $_POST['school'], $_POST['program'], $_POST['year'], $_POST['phone']) 
	&& $_POST['token'] && $_POST['username'] && $_POST['fname'] && $_POST['lname'] && $_POST['school'] && $_POST['program'] && $_POST['year'] && $_POST['phone']){
	// if(isset($_POST['token'], $_POST['email'], $_POST['fname'], $_POST['lname'], $_POST['month'], $_POST['day'], $_POST['year'], $_POST['country'], $_POST['phone'], $_POST['gender']) 
	// && $_POST['token'] && $_POST['email'] && $_POST['fname'] && $_POST['lname'] && $_POST['month'] && $_POST['day'] && $_POST['year'] && $_POST['country'] && $_POST['phone'] && $_POST['gender']){
		$error = 0;

    $token = clean($link, $_POST['token']);
		// $email = clean($link, $_POST['email']);
		$username = clean($link, $_POST['username']);
		$fname = clean($link, $_POST['fname']);
		$lname = clean($link, $_POST['lname']);
		// $month = clean($link, $_POST['month']);
		// $day = clean($link, $_POST['day']);
		$year = clean($link, $_POST['year']);
		// $country = clean($link, $_POST['country']);
		$phone = clean($link, $_POST['phone']);
		$school = clean($link, $_POST['school']);
		$program = clean($link, $_POST['program']);
    // $gender = clean($link, $_POST['gender']);

    // $city = clean($link, $_POST['city']);
    // $state = clean($link, $_POST['state']);
    // $postal = clean($link, $_POST['postal']);
    
    $userid = $val->get_userid($token);
		if($userid == 0){
			$error++;	
		}

		// if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
	  //   $error++;
		// }
		
		if(!preg_match("/^[0-9]+$/", $phone)){
			$error++;
    }
    
    // if($gender != 'm' && $gender != 'f'){
    //   $error++;
    // }

    // $cc = $sx->check_country($country);
    // if(empty($cc) == true){
    //   $error++;
    // }

	  if($error == 0){ 
			// $dob = date("Y-m-d", strtotime($year.'-'.$month.'-'.$day));
	  	// $data = $sx->update_info($token, $userid, $fname, $lname, $gender, $email, $postal, $dob, $country, $phone, $city, $state);	  
	  	$data = $sx->update_info($token, $userid, $fname, $lname, $username, $school, $program, $year, $phone);	  
	  }
	  else{
	  	$data['state'] = 400;
			$data['response_msg'] = 'invalid parameters';
    }
    echo json_encode($data);
		exit();

	}
	else{
		$data['state'] = 400;
		$data['response_msg'] = 'invalid parameters';
		echo json_encode($data);
		exit();
	}
}else if(isset($_POST['action']) && $_POST['action']=='get_statistics'){
	if(isset($_POST['token']) && $_POST['token']){
		$error = 0;

		$token = clean($link, $_POST['token']);

		$userid = $val->get_userid($token);
		if($userid == 0){
			$error++;	
		}

		if($error == 0){
			$data = $sx->get_statistics($userid);
		}
		else{
			$data['state'] = 400;
			$data['response_msg'] = 'invalid parameters';
		}
		echo json_encode($data);
		exit();
	}
	else{
		$data['state'] = 400;
		$data['response_msg'] = 'invalid parameters';
		echo json_encode($data);
		exit();
	}
}else if(isset($_POST['action']) && $_POST['action']=='get_progress'){
	if(isset($_POST['token']) && $_POST['token']){
		$error = 0;

		$token = clean($link, $_POST['token']);

		$userid = $val->get_userid($token);
		if($userid == 0){
			$error++;	
		}

		if($error == 0){
			$data = $sx->get_progress($userid);
		}
		else{
			$data['state'] = 400;
			$data['response_msg'] = 'invalid parameters';
		}
		echo json_encode($data);
		exit();
	}
	else{
		$data['state'] = 400;
		$data['response_msg'] = 'invalid parameters';
		echo json_encode($data);
		exit();
	}
}else if(isset($_POST['action']) && $_POST['action']=='personal_info'){
	if(isset($_POST['token']) && $_POST['token']){
		$error = 0;

		$token = clean($link, $_POST['token']);

		$userid = $val->get_userid($token);
		if($userid == 0){
			$error++;	
		}

		if($error == 0){
			$data = $sx->get_statistics($userid);
			$data['personal'] = $sx->user_data($userid,"fname,lname,gender,dob,school,program,username,city,state,postal,country,phone,avatar");
			
		}
		else{
			$data['state'] = 400;
			$data['response_msg'] = 'invalid parameters';
		}
		echo json_encode($data);
		exit();
	}
	else{
		$data['state'] = 400;
		$data['response_msg'] = 'invalid parameters';
		echo json_encode($data);
		exit();
	}
}else if(isset($_POST['action']) && $_POST['action']=='upload_avatar'){
	if(isset($_POST['token'], $_POST['avatar']) && $_POST['token'] && $_POST['avatar']){
		$error = 0;

		$token = clean($link, $_POST['token']);
		$avatar = $_POST['avatar'];

		$userid = $val->get_userid($token);
		if($userid == 0){
			$error++;	
		}

		if($error == 0){
			$data = $sx->upload_avatar($userid, $avatar);	
			
		}
		else{
			$data['state'] = 400;
			$data['response_msg'] = 'invalid parameters';
		}
		echo json_encode($data);
		exit();
	}
	else{
		$data['state'] = 400;
		$data['response_msg'] = 'invalid parameters';
		echo json_encode($data);
		exit();
	}
}else{
	$data['state'] = 400;
	$data['response_msg'] = 'required parameters missing';
	echo json_encode($data);
	exit();
}


?>