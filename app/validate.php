<?php
require 'connect.php';

class Validate{

	public function login($email, $password){
		global $link;

		$email = clean($link, $email);
		$password = clean($link, $password);

		$passx = md5($password);

		$q = mysqli_query($link, "SELECT apid,token FROM appusers WHERE email='$email' AND password='$passx' ");
		$qnum = mysqli_num_rows($q);
		if($qnum == 0){
			return false.'|Invalid Email and Password combination';
		}
		else{
			
			$qr = mysqli_fetch_assoc($q);
			$apid = $qr['apid'];
			$token = $qr['token'];

			return true.'|'.$apid.'|'.$token;
		}
	}


	public function app_login($email, $password, $firebase){
		global $link;

		$email = clean($link, $email);
		$password = clean($link, $password);
		$firebase = clean($link, $firebase);

		$passx = md5($password);

		$q = mysqli_query($link, "SELECT apid,token FROM appusers WHERE email='$email' AND password='$passx' AND user_type='s' ");
		$qnum = mysqli_num_rows($q);
		if($qnum == 0){
			return false.'|Invalid Email and Password combination';
		}
		else{
			
			$qr = mysqli_fetch_assoc($q);
			$apid = $qr['apid'];
			$token = $qr['token'];

			$uq = mysqli_query($link, "UPDATE appusers SET firebase='$firebase' WHERE apid='$apid' ");
			if($uq){
				return true.'|'.$apid.'|'.$token;
			}
			return false.'|Error adding firebase token';
		}
	}


	public function get_userid($token){
		global $link;

		$token = clean($link, $token);

		$cq = mysqli_query($link, "SELECT userid FROM appusers WHERE token='$token' AND user_type='s' ");
		$cqnum = mysqli_num_rows($cq);
		if($cqnum == 0){
			return 0;
		}

		$qr = mysqli_fetch_assoc($cq);
		return $qr['userid'];
	}


	public function tokenizer(){
		return md5(time()*rand(1000,99999)*7);
	}


	public function compact($token, $password){
		global $link;

		$token = clean($link, $token);
		$password = md5(clean($link, $password));

		$cq = mysqli_query($link, "SELECT email,cid,cname FROM company WHERE passcode='$token' ");
		$cqnum = mysqli_num_rows($cq);
		if ($cqnum == 0) {
			return 'Invalid information';
		}

		$cqr = mysqli_fetch_assoc($cq);
		$cid = $cqr['cid'];
		$email = $cqr['email'];
		$cname = $cqr['cname'];
		$tk = $this->tokenizer();

		$timenow = date("Y-m-d H:i:s", time());
		$uq = mysqli_query($link, "UPDATE company SET active='1',`date`='$timenow' WHERE cid='$cid' ");
		$inq = mysqli_query($link, "INSERT INTO appusers(userid,email,password,user_type,token) VALUES('$cid','$email','$password','c','$tk')");
		if($inq){

			$message = 'For so long, you have been behind the veil, not knowing what your next employees might be like in attitude and skill. The days of having to spend more money than usual to correct the errors of taking in the wrong kind of employee are over. With Rook+ you get to model your right employee that reflects idea of a "Best Fit" employee. Train and mingle with students who have your company at heart. Rook+ is your gateway to a hassle free recruitment. Don\'t shun from using the platform\'s full potential! Feel bigger with Rook+';
			$this->send_welcome_email($email, $cname, $message);

			return 1;
		}

		return 'Error activating account';

	}


	public function set_new_password($token, $password){
		global $link;

		$token = clean($link, $token);
		$password = md5(clean($link, $password));

		$cq = mysqli_query($link, "SELECT apid FROM password_change_keys WHERE pass='$token' ");
		$cqnum = mysqli_num_rows($cq);
		if ($cqnum == 0) {
			return 'Invalid information';
		}

		$cqr = mysqli_fetch_assoc($cq);
		$apid = $cqr['apid'];
		$tk = $this->tokenizer();

		$uq = mysqli_query($link, "UPDATE appusers SET `password`='$password',token='$tk' WHERE apid='$apid' ");
		if($uq){
			$dq = mysqli_query($link, "DELETE FROM password_change_keys WHERE pass='$token' ");
			return 1;
		}
		return 'Error changing password';

	}


	public function get_company_info($token){
		global $link;

		$token = clean($link, $token);

		$q = mysqli_query($link, "SELECT cname,active FROM company WHERE passcode='$token' ");
		$qnum = mysqli_num_rows($q);
		if ($qnum == 0) {
			return 0;
		}

		$qr = mysqli_fetch_assoc($q);
		if($qr['active'] == 1){
			return 2;
		}
		return $qr['cname'];
	}


	public function reset_password_info($token){
		global $link;

		$token = clean($link, $token);
		
		$cq = mysqli_query($link, "SELECT apid FROM password_change_keys WHERE pass='$token'");
		$cqnum = mysqli_num_rows($cq);
		if($cqnum == 0){
			return 0;
		}

		$qr = mysqli_fetch_assoc($cq);
		$apid = $qr['apid'];

		$ux = $this->get_user_type($apid);
		$usertype = $ux['user_type'];
		if($usertype == 's'){
			$info = $this->user_data($apid, "fname");
			$fname = $info['fname'];
		}else if($usertype == 'c'){
			$info = $this->user_data($apid, "cname");
			$fname = $info['cname'];
		}else if($usertype == 'a'){
			$info = $this->user_data($apid, "fname");
			$fname = $info['fname'];
		}

		return $fname;
	}


	public function code_check($token, $code){
    global $link;

    $token = clean($link, $token);
    $code = clean($link, $code);

   	$q = mysqli_query($link, "SELECT pcid FROM phone_code WHERE uid=(SELECT userid FROM appusers WHERE token='$token' AND user_type='s') AND code='$code' ");
		$qnum = mysqli_num_rows($q);

		if($qnum == 0){
			return 'Invalid activation code';
		}

		$uq = mysqli_query($link, "UPDATE students SET active='1' WHERE stid=(SELECT userid FROM appusers WHERE token='$token' AND user_type='s') ");
		if($uq){
			$qr = mysqli_fetch_assoc($q);
			$pcid = $qr['pcid'];
			$dq = mysqli_query($link, "DELETE FROM phone_code WHERE pcid='$pcid' ");
			return 1;
		}
		return 'Error activating your account';
  }


  public function check_country($country){
    global $link;

    $country = clean($link, $country);

    $q = mysqli_query($link, "SELECT id FROM countries WHERE id='$country' ");
    $qnum = mysqli_num_rows($q);
    return $qnum;
  }


  public function get_countries(){
    global $link;

    $q = mysqli_query($link, "SELECT country_name,id FROM countries WHERE country_code='GH' OR country_code='NG' ORDER BY country_name ASC");

    $country = '';
    while ($qr = mysqli_fetch_array($q, MYSQLI_ASSOC)) {
      $country .= '<option value="'.$qr['id'].'">'.$qr['country_name'].'</option>';
    }

    return $country;
  }


  public function get_country_code(){
    global $link;

    $q = mysqli_query($link, "SELECT phonecode FROM countries WHERE country_code='GH' OR country_code='NG' GROUP BY phonecode ORDER BY phonecode ASC");

    $codes = '';
    while ($qr = mysqli_fetch_array($q, MYSQLI_ASSOC)) {
      $codes .= '<option value="'.$qr['phonecode'].'">+ '.$qr['phonecode'].'</option>';
    }

    return $codes;
  }



	public function signup($fname, $lname, $gender, $email, $password, $dob, $country, $phonenum){
		global $link;

		$fname = clean($link, $fname);
		$lname = clean($link, $lname);
    $gender = clean($link, $gender);
		$email = clean($link, $email);
		$password = clean($link, $password);
    $dob = clean($link, $dob);
    $country = clean($link, $country);
    $phonenum = clean($link, $phonenum);

		$ec = $this->email_validate($email);
		if($ec==1){
			return false.'|Email already exist';
		}

			$timenow = date("Y-m-d H:i:s", time());
			$q = mysqli_query($link, "INSERT INTO students(`fname`,`lname`,`gender`,`country`,`dob`,`phone`,`date`) VALUES('$fname','$lname','$gender','$country','$dob','$phonenum','$timenow')");
			if($q){
				$uid = mysqli_insert_id($link);
				$passx = md5($password);
				$token = $this->tokenizer();
				$qz = mysqli_query($link, "INSERT INTO appusers(`userid`,`email`,`password`,`user_type`,`token`) VALUES('$uid', '$email', '$passx', 's', '$token')");
				if($qz){
					$apid = mysqli_insert_id($link);
					$this->resend_sms($apid);
					return true.'|'.$apid;
				}
				else{
					return false.'|Error signing you up. Try again';
				}
			}
			else{
				return false.'|Error signing you up. Try again';
			}
	}


	public function app_signup($firebase, $fname, $lname, $gender, $email, $password, $dob, $country, $phonenum){
		global $link;

		$firebase = clean($link, $firebase);
		$fname = clean($link, $fname);
		$lname = clean($link, $lname);
    $gender = clean($link, $gender);
		$email = clean($link, $email);
		$password = clean($link, $password);
    $dob = clean($link, $dob);
    $country = clean($link, $country);
    $phonenum = clean($link, $phonenum);

		$ec = $this->email_validate($email);
		if($ec==1){
			return false.'|Email already exist';
		}
			$timenow = date("Y-m-d H:i:s", time());
			$q = mysqli_query($link, "INSERT INTO students(`fname`,`lname`,`gender`,`country`,`dob`,`phone`,`date`) VALUES('$fname','$lname','$gender','$country','$dob','$phonenum','$timenow')");
			if($q){
				$uid = mysqli_insert_id($link);
				$passx = md5($password);
				$token = $this->tokenizer();
				$qz = mysqli_query($link, "INSERT INTO appusers(`userid`,`email`,`password`,`user_type`,`token`,`firebase`) VALUES('$uid', '$email', '$passx', 's', '$token', '$firebase')");
				if($qz){
					$apid = mysqli_insert_id($link);
					$this->resend_sms($apid);
					return true.'|'.$token;
				}
				else{
					return false.'|Error signing you up. Try again';
				}
			}
			else{
				return false.'|Error signing you up. Try again';
			}
	}


	public function email_validate($email){
		global $link;

		$email = clean($link, $email);
		$q = mysqli_query($link, "SELECT apid FROM appusers WHERE email='$email' ");

		return  mysqli_num_rows($q);
	}


	public function user_data($apid){
		global $link;

		$data = array();
		$func_num_args = func_num_args();
		$func_get_args = func_get_args();

		$uc = $this->get_user_type($apid);
		$usertype = $uc['user_type'];
		$userid = $uc['userid'];
		
		if($func_num_args > 1){
			unset($func_get_args[0]);
			$fields = ''.implode(',',$func_get_args).'';
			$userid = clean($link, $userid);

			if($usertype == 'a'){
				$data = mysqli_fetch_assoc(mysqli_query($link, "SELECT $fields FROM admins WHERE aid='$userid' "));
				return $data;
			}
			else if($usertype == 'c'){
				$data = mysqli_fetch_assoc(mysqli_query($link, "SELECT $fields FROM company WHERE cid='$userid' "));
				return $data;
			}
			else{
				$data = mysqli_fetch_assoc(mysqli_query($link, "SELECT $fields FROM students WHERE stid='$userid' "));
				return $data;
			}
			
		}

	}


	public function resend_sms($apid){
		global $link;

		$us = $this->user_data($apid,'stid','active','phone');
		if (empty($us['phone']) == false && $us['active'] == 0) {

			$phone = $us['phone'];
			$userid = $us['stid'];

			$sq = mysqli_query($link, "SELECT pcid FROM phone_code WHERE uid='$userid'");
			$sqnum = mysqli_num_rows($sq);

			$codex = rand(10000,99999);
			if($sqnum == 0){
				$inq = mysqli_query($link, "INSERT INTO phone_code(`code`,`uid`) VALUES('$codex','$userid') ");
			}
			else{
				$inq = mysqli_query($link, "UPDATE phone_code SET code='$codex' WHERE uid='$userid' ");
			}

			$message = 'Activation Code: '.$codex.'';
      $sender_id = 'Rook+';
			$this->sendsms($sender_id, $message, $phone);
		}
	}


	public function resendsms($userid){
		global $link;

		$cq = mysqli_query($link, "SELECT stid,phone,active FROM students WHERE stid='$userid'");
		$us = mysqli_fetch_assoc($cq);
		if (empty($us['phone']) == false && $us['active'] == 0) {

			$phone = $us['phone'];
			$userid = $us['stid'];

			$sq = mysqli_query($link, "SELECT pcid FROM phone_code WHERE uid='$userid'");
			$sqnum = mysqli_num_rows($sq);

			$codex = rand(10000,99999);
			if($sqnum == 0){
				$inq = mysqli_query($link, "INSERT INTO phone_code(`code`,`uid`) VALUES('$codex','$userid') ");
			}
			else{
				$inq = mysqli_query($link, "UPDATE phone_code SET code='$codex' WHERE uid='$userid' ");
			}

			$message = 'Activation Code: '.$codex.'';
      $sender_id = 'Rook+';
			$this->sendsms($sender_id, $message, $phone);
			$data['status'] = 200;
			return $data;
		}

		$data['response_msg'] = "Invalid phone number or account activated already";
		$data['status'] = 400;
			return $data;
	}


	public function sendsms($sender_id, $message, $phone){
    global $key;
    
    $url = "https://apps.mnotify.net/smsapi?key=$key&to=$phone&msg=$message&sender_id=$sender_id";
    $result = file_get_contents($url);
    return $result;
  }


	public function get_user_type($apid){
		global $link;
		
		$apid = clean($link, $apid);

		$data = mysqli_fetch_assoc(mysqli_query($link, "SELECT user_type, userid FROM appusers WHERE apid='$apid' "));
		return $data;
	}


	public function get_statistics($stid){
		global $link;

		$stid = clean($link, $stid);

			$q = mysqli_query($link, "SELECT COUNT(`sid`) as `solutions`, SUM(`rate`) as `rate`, SUM(`submission`) as `execute`, SUM(`attempt`) as `initiative`, SUM(`speed`) as `speed`
			FROM solution WHERE stid='$stid' AND `status` NOT IN ('0','3')  ");
			
			$qr = mysqli_fetch_assoc($q);

			$sdata['rate']=$sdata['execute']=$sdata['initiative']=$sdata['speed']=$sdata['points']=$sdata['solutions']=$sdata['tasks']=0;
			if($qr['solutions'] == 0){
        $data['state'] = 200;
        $data['statistics'] = $sdata;
				return $data;
			}

			$solutions = $qr['solutions'];
			$rateTotal = 5 * $solutions;
			$executeTotal = 1 * $solutions;
			$speedTotal = 3 * $solutions;
			$initiativeTotal = 1 * $solutions;

			$sdata['rate'] = number_format(($qr['rate'] / $rateTotal) * 100);

			$sdata['execute'] = number_format(($qr['execute'] / $executeTotal) * 100);

			$sdata['initiative'] = number_format(($qr['initiative'] / $initiativeTotal) * 100);

      $sdata['speed'] = number_format(($qr['speed'] / $speedTotal) * 100);	
      
      $sdata['points'] = $this->get_points($stid);

      $taskc = $this->get_total_tasks($stid);
      $sdata['solutions'] = $taskc['solution'];

      $sdata['tasks'] = $taskc['total'];

      $data['statistics'] = $sdata;
			return $data;
	}
	

	public function get_points($stid){
		global $link;

		$stid = clean($link, $stid);

		$q = mysqli_query($link, "SELECT SUM(rate+submission+attempt+speed) as points FROM solution WHERE stid='$stid' ");

		$qr = mysqli_fetch_assoc($q);
		if($qr['points'] == 0){
			return '0';
		}
		return $qr['points'];
	}


	public function get_total_tasks($stid){
    global $link;

    $stid = clean($link, $stid);

		$q = mysqli_query($link, "SELECT `status`, COUNT(sid) as `count` FROM `solution` WHERE stid='$stid' AND `status`!='3' GROUP BY `status` ");
		$data['total']=$data['attempted_task']=$data['solution']=0;
    while($qr = mysqli_fetch_array($q, MYSQLI_ASSOC)){
			if($qr['status'] == 1 || $qr['status'] == 2){
				$data['solution'] += $qr['count'];
			}else if($qr['status'] == 0){
				$data['attempted_task'] += $qr['count'];
			}
			$data['total'] += $qr['count'];
		}
		
		return $data;
	}


	public function forgot_password($email){
		global $link;

		$email = clean($link, $email);
		$ck = $this->email_validate($email);
		if($ck == 0){
			return 'The email you entered does not match any account';
		}
		$token = $this->tokenizer();
		$q = mysqli_query($link, "SELECT apid,userid,user_type FROM appusers WHERE email='$email' ");
		$qr = mysqli_fetch_assoc($q);

		$apid = $qr['apid'];
		$userid = $qr['userid'];
		$usertype = $qr['user_type'];

		$icq = mysqli_query($link, "SELECT apid FROM password_change_keys WHERE apid='$apid' ");
		$inum = mysqli_num_rows($icq);
		if($inum > 0){
			$dq = mysqli_query($link, "DELETE FROM password_change_keys WHERE apid='$apid' ");
		}

		$iq = mysqli_query($link, "INSERT INTO password_change_keys(`apid`,`pass`) VALUES('$apid','$token')");
		if($iq){
			if($usertype == 's'){
				$cq = mysqli_query($link, "SELECT fname,lname FROM students WHERE stid='$userid' ");
				$cqr = mysqli_fetch_assoc($cq);
				$fname = $cqr['fname'].' '.$cqr['lname'];
			}else if($usertype == 'c'){
				$cq = mysqli_query($link, "SELECT cname FROM company WHERE cid='$userid' ");
				$cqr = mysqli_fetch_assoc($cq);
				$fname = $cqr['cname'];
			}else{
				$cq = mysqli_query($link, "SELECT fname,lname FROM `admins` WHERE aid='$userid' ");
				$cqr = mysqli_fetch_assoc($cq);
				$fname = $cqr['fname'].' '.$cqr['lname'];
			}

			if($this->send_email($email, $fname, $token)){
				return 1;
			}
		}
		return 'Error requesting password change';
	
	}


	public function send_email($email, $fname, $token){
  	global $baseUrl;

		$from = 'info@myrookery.com';

		$msg ='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml" style="font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
		<head>
		<meta name="viewport" content="width=device-width" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Welcome</title>


		<style type="text/css">
		img {
		max-width: 100%;
		}
		body {
		-webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em;
		}
		body {
		background-color: #f6f6f6;
		}
		@media only screen and (max-width: 640px) {
			body {
				padding: 0 !important;
			}
			h1 {
				font-weight: 800 !important; margin: 20px 0 5px !important;
			}
			h2 {
				font-weight: 800 !important; margin: 20px 0 5px !important;
			}
			h3 {
				font-weight: 800 !important; margin: 20px 0 5px !important;
			}
			h4 {
				font-weight: 800 !important; margin: 20px 0 5px !important;
			}
			h1 {
				font-size: 22px !important;
			}
			h2 {
				font-size: 18px !important;
			}
			h3 {
				font-size: 16px !important;
			}
			.container {
				padding: 0 !important; width: 100% !important;
			}
			.content {
				padding: 0 !important;
			}
			.content-wrap {
				padding: 10px !important;
			}
			.invoice {
				width: 100% !important;
			}
		}
		</style>
		</head>

		<body itemscope style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">

		<table class="body-wrap" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6"><tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
				<td class="container" width="600" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">
					<div class="content" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
						<table class="main" width="100%" cellpadding="0" cellspacing="0" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;" bgcolor="#fff"><tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="alert alert-warning" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #fff; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #1D2939; margin: 0; padding: 20px;" align="center" bgcolor="#2f353f" valign="top">
									<img alt="" src="'.$baseUrl.'/img/wlogo.png" width="100">
								</td>
							</tr><tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-wrap" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 20px;" valign="top">
									<table width="100%" cellpadding="0" cellspacing="0" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
												Hi <strong style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">'.$fname.'</strong>,
											</td>
										</tr><tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
												<p>We heard that you lost your Rook+ password. Sorry about that.</p>
												<p>Click on the <strong>Change Password</strong> button to set a new password</p> 
												<hr>
											</td>
										</tr><tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;text-align: center;" valign="top">
												<a href="'.$baseUrl.'/resetpassword?pass='.$token.'" class="btn-primary" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #5fbeaa; margin: 0; border-color: #5fbeaa; border-style: solid; border-width: 10px 20px;">Change Password</a>
											</td>
										</tr><tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;text-align: center;" valign="top">
										<p>If you did not request to reset your password, just ignore this mail.<br>Thanks,<br>Your friends at Rook+</p>.
											</td>
										</tr></table></td>
							</tr></table></div>
				</td>
				<td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
			</tr></table></body>
		</html>'; 
		$subject = 'Rook+ | Password Change';
		$to = $email; 
		$xheaders = "From: Rook+  <$from>\n"; 
		$xheaders .= "X-Sender: <$from>\n"; 
		$xheaders .= 'X-Mailer: PHP/' . phpversion();
		$xheaders .='Reply-To: '. $to . "\n" ;
		$xheaders .= "X-Priority: 1\n";
		$xheaders .= "Content-Type:text/html; charset=iso-8859-1\n";

    if(mail($to, $subject, $msg, $xheaders)){
      return 1;
    }
    return 0;
	}
	

	public function send_welcome_email($email, $fname, $message){
  	global $baseUrl;

		$from = 'info@myrookery.com';

		$msg ='<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
		<html xmlns="http://www.w3.org/1999/xhtml" style="font-family: \'Helvetica Neue\', Helvetica, Arial, sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
		<head>
		<meta name="viewport" content="width=device-width" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Welcome</title>


		<style type="text/css">
		img {
		max-width: 100%;
		}
		body {
		-webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em;
		}
		body {
		background-color: #f6f6f6;
		}
		@media only screen and (max-width: 640px) {
			body {
				padding: 0 !important;
			}
			h1 {
				font-weight: 800 !important; margin: 20px 0 5px !important;
			}
			h2 {
				font-weight: 800 !important; margin: 20px 0 5px !important;
			}
			h3 {
				font-weight: 800 !important; margin: 20px 0 5px !important;
			}
			h4 {
				font-weight: 800 !important; margin: 20px 0 5px !important;
			}
			h1 {
				font-size: 22px !important;
			}
			h2 {
				font-size: 18px !important;
			}
			h3 {
				font-size: 16px !important;
			}
			.container {
				padding: 0 !important; width: 100% !important;
			}
			.content {
				padding: 0 !important;
			}
			.content-wrap {
				padding: 10px !important;
			}
			.invoice {
				width: 100% !important;
			}
		}
		</style>
		</head>

		<body itemscope style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; -webkit-font-smoothing: antialiased; -webkit-text-size-adjust: none; width: 100% !important; height: 100%; line-height: 1.6em; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">

		<table class="body-wrap" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6"><tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
				<td class="container" width="600" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">
					<div class="content" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">
						<table class="main" width="100%" cellpadding="0" cellspacing="0" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;" bgcolor="#fff"><tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="alert alert-warning" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 16px; vertical-align: top; color: #fff; font-weight: 500; text-align: center; border-radius: 3px 3px 0 0; background-color: #1D2939; margin: 0; padding: 20px;" align="center" bgcolor="#2f353f" valign="top">
									<img alt="" src="'.$baseUrl.'/img/wlogo.png" width="100">
								</td>
							</tr><tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-wrap" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 20px;" valign="top">
									<table width="100%" cellpadding="0" cellspacing="0" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
												Hello <strong style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">'.$fname.'</strong>,
											</td>
										</tr><tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
												<p>'.$message.'</p>
												<hr>
											</td>
										</tr><tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;text-align: center;" valign="top">
										<p>Rook+ Team</p>.
											</td>
										</tr></table></td>
							</tr></table></div>
				</td>
				<td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
			</tr></table></body>
		</html>'; 
		$subject = 'Rook+ | Welcome';
		$to = $email; 
		$xheaders = "From: Rook+  <$from>\n"; 
		$xheaders .= "X-Sender: <$from>\n"; 
		$xheaders .= 'X-Mailer: PHP/' . phpversion();
		$xheaders .='Reply-To: '. $to . "\n" ;
		$xheaders .= "X-Priority: 1\n";
		$xheaders .= "Content-Type:text/html; charset=iso-8859-1\n";

    if(mail($to, $subject, $msg, $xheaders)){
      return 1;
    }
    return 0;
  }

}

?>