<?php
require('../app/validate.php');
require('../app/task.php');

$val = new Validate();
$tx = new Task();

if(isset($_POST['action']) && $_POST['action']=='login'){
	if(isset($_POST['email'], $_POST['password'], $_POST['firebase']) && $_POST['email'] && $_POST['password'] && $_POST['firebase']){
		$error = 0;

		$email = clean($link, $_POST['email']);
		$password = clean($link, $_POST['password']);
		$firebase = clean($link, $_POST['firebase']);

		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
	    $error++;
	  }

	  if($error == 0){ 
	  	$udata = $val->app_login($email, $password, $firebase);
	    $udatax = explode("|", $udata);
	    if($udatax[0] == true){
	      $apid = $udatax[1];
	      $idata = $val->user_data($apid, 'stid','fname','lname', 'active', 'gender', 'dob', 'phone', 'avatar');
				$stid = $idata['stid'];
				$data = $val->get_statistics($stid);
				$data['fname'] = $idata['fname'];
	      $data['lname'] = $idata['lname'];
	      $data['active'] = $idata['active'];
	      if($idata['active'] == 1){
	      	$mdata = $val->user_data($apid, 'school','program', 'year', 'username');
	      	if(empty($mdata['username']) == true){
	      		$data['active'] = 1;
	      	}
	      	else{
	      		$data['active'] = 2;
	      		$data['school'] = $mdata['school'];
		      	$data['program'] = $mdata['program'];
		      	$data['year'] = $mdata['year'];
		      	$data['username'] = $mdata['username'];
	      	}
	      	
	      }
				$data['gender'] = $idata['gender'];
				if(empty($idata['avatar'])){
					$data['avatar'] = '';
				}else{
					$data['avatar'] = $baseUrl.'/img/avatar/'.$idata['avatar'];
				}
	      
	      $data['dob'] = $idata['dob'];
	      $data['phone'] = $idata['phone'];
	      $data['token'] = $udatax[2];
	      $data['state'] = 200;
	      echo json_encode($data);
				exit();
	    }
	    else{
	      $data['state'] = 400;
				$data['response_msg'] = $udatax[1];
				echo json_encode($data);
				exit();
	    }
	  }
	  else{
	  	$data['state'] = 400;
			$data['response_msg'] = 'invalid parameters';
			echo json_encode($data);
			exit();
	  }

	}
	else{
		$data['state'] = 400;
		$data['response_msg'] = 'invalid parameters';
		echo json_encode($data);
		exit();
	}
}
else if(isset($_POST['action']) && $_POST['action']=='register'){
	if(isset($_POST['email'], $_POST['password'], $_POST['firebase'], $_POST['fname'], $_POST['lname'], $_POST['month'], $_POST['day'], $_POST['year'], $_POST['country'], $_POST['phone'], $_POST['gender']) 
	&& $_POST['email'] && $_POST['password'] && $_POST['firebase'] && $_POST['fname'] && $_POST['lname'] && $_POST['month'] && $_POST['day'] && $_POST['year'] && $_POST['country'] && $_POST['phone'] && $_POST['gender']){
		$error = 0;

		$email = clean($link, $_POST['email']);
		$password = clean($link, $_POST['password']);
		$firebase = clean($link, $_POST['firebase']);
		$fname = clean($link, $_POST['fname']);
		$lname = clean($link, $_POST['lname']);
		$month = clean($link, $_POST['month']);
		$day = clean($link, $_POST['day']);
		$year = clean($link, $_POST['year']);
		$country = clean($link, $_POST['country']);
		$phone = clean($link, $_POST['phone']);
		$gender = clean($link, $_POST['gender']);

		if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
	    $error++;
		}
		
		if(!preg_match("/^[0-9]+$/", $phone)){
			$error++;
		}

	  if($error == 0){ 
			$dob = date("Y-m-d", strtotime($year.'-'.$month.'-'.$day));

	  	$udata = $val->app_signup($firebase ,$fname, $lname, $gender, $email, $password, $dob, $country, $phone);
	    $udatax = explode("|", $udata);
	    if($udatax[0] == true){
				$data['active'] = 0;
				$data['token'] = $udatax[1];
				$data['state'] = 200;
	      echo json_encode($data);
				exit();
	    }
	    else{
	      $data['state'] = 400;
				$data['response_msg'] = $udatax[1];
				echo json_encode($data);
				exit();
	    }
	  }
	  else{
	  	$data['state'] = 400;
			$data['response_msg'] = 'invalid parameters';
			echo json_encode($data);
			exit();
	  }

	}
	else{
		$data['state'] = 400;
		$data['response_msg'] = 'invalid parameters';
		echo json_encode($data);
		exit();
	}
}
else if(isset($_POST['action']) && $_POST['action']=='activate'){
	if(isset($_POST['token'], $_POST['code']) && $_POST['token'] && $_POST['code']){
		$token = clean($link, $_POST['token']);
		$code = clean($link, $_POST['code']);
		$result = $val->code_check($token, $code);
		if($result != 1){
			$data['state'] = 400;
			$data['response_msg'] = $result;
		}
		else{
			$data['state'] = 200;
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
}
else if(isset($_POST['action']) && $_POST['action']=='userinfo'){
	if(isset($_POST['username'], $_POST['school'], $_POST['program'], $_POST['year'], $_POST['token']) && $_POST['username'] && $_POST['school'] && $_POST['program'] && $_POST['year'] && $_POST['token']){
		$username = clean($link, $_POST['username']);
		$school = clean($link, $_POST['school']);
		$program = clean($link, $_POST['program']);
		$year = clean($link, $_POST['year']);
		$token = clean($link, $_POST['token']);

		$userid = $val->get_userid($token);
		if($userid == 0){
			$data['state'] = 400;
			$data['response_msg'] = 'invalid parameters';
			
		}
		else{
			$up = $tx->complete_signup($userid, $username, $school, $program, $year);
			if($up == 1){
				$data['active'] = 2;
				$data['state'] = 200;
			}
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
}
else if(isset($_POST['action']) && $_POST['action']=='resendsms'){
	if(isset($_POST['token']) && $_POST['token']){
		$token = clean($link, $_POST['token']);

		$userid = $val->get_userid($token);
		if($userid == 0){
			$data['state'] = 400;
			$data['response_msg'] = 'invalid parameters';
			
		}else{
			$data = $val->resendsms($userid);
		}

		
		
		echo json_encode($data);
		exit();
	}
	else{
		$data['state'] = 400;
		$data['error'] = 'invalid parameters';
		echo json_encode($data);
		exit();
	}
}
else{
	$data['state'] = 400;
	$data['response_msg'] = 'required parameters missing';
	echo json_encode($data);
	exit();
}


?>