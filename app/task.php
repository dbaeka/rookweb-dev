<?php

class Task{
	public function complete_signup($userid, $username, $school, $program, $year){
		global $link;

		$userid = clean($link, $userid);
		$username = clean($link, $username);
		$school = clean($link, $school);
		$program = clean($link, $program);
		$year = clean($link, $year);

		$iq = mysqli_query($link, "UPDATE students SET username='$username', school='$school', program='$program', year='$year' WHERE stid='$userid'");
		if($iq){
			return 1;
		}
		return 'Error updating your information.';
	}

	public function get_new_tasks($stid, $type, $index){
		global $link,$baseUrl;

		$stid = clean($link, $stid);
		$type = clean($link, $type);
		$index = clean($link, $index);

		if($type == 'n'){
			if($index == 'a'){
				$q = mysqli_query($link, "SELECT * FROM task WHERE cid IN (SELECT cid FROM subscribe WHERE stid='$stid') AND tid NOT IN (SELECT tid FROM solution WHERE stid='$stid') AND delete_task='0'  ORDER BY `date` DESC LIMIT 20 ");
			}else{
				$q = mysqli_query($link, "SELECT * FROM task WHERE cid IN (SELECT cid FROM subscribe WHERE stid='$stid') AND tid NOT IN (SELECT tid FROM solution WHERE stid='$stid') AND `tid` > '$index' AND delete_task='0'  ORDER BY `date` DESC LIMIT 20 ");
			}
			
		}
		else{
			$q = mysqli_query($link, "SELECT * FROM task WHERE cid IN (SELECT cid FROM subscribe WHERE stid='$stid') AND tid NOT IN (SELECT tid FROM solution WHERE stid='$stid') AND `tid` < '$index' AND delete_task='0'  ORDER BY `date` DESC LIMIT 20 ");
		}

		$qnum = mysqli_num_rows($q);
		if($qnum == 0){
			$data['state'] = 300;
			$data['response_msg'] = 'No tasks found';
			return $data;
		}

		$taskx = array();
		while ($qr = mysqli_fetch_array($q, MYSQLI_ASSOC)) {
			$cinfo = $this->get_company_info($qr['cid']);

			if(empty($cinfo['logo'])){
				$logo = 'p.png';
			}
			else{
				$logo = $cinfo['logo'];
			}

			$tk['tid'] = $qr['tid'];
			$tk['company'] = $cinfo['cname'];
			$tk['company_location'] = $cinfo['location'];
			$tk['company_logo'] = $baseUrl.'/img/avatar/'.$logo;
			$tk['title'] = $qr['title'];
			$tk['summary'] = $qr['summary'];
			$tk['file'] = $baseUrl.'/docs/'.$qr['file'];
			$tk['date'] = $qr['date'];
			$tk['submitted_solutions'] = $this->total_task_solutions($qr['tid']);

			array_push($taskx, $tk);
		}

		$data['task'] = $taskx;
  	$data['state'] = 200;
  	return $data;

	}


	public function get_my_tasks($stid, $type, $index){
		global $link,$baseUrl;

		$stid = clean($link, $stid);
		$type = clean($link, $type);
		$index = clean($link, $index);

		if($type == 'n'){
			if($index == 'a'){
				$q = mysqli_query($link, "SELECT * FROM solution WHERE stid='$stid' AND `status`!='3' ORDER BY `date` DESC LIMIT 20 ");
			}else{
				$q = mysqli_query($link, "SELECT * FROM solution WHERE stid='$stid' AND `status`!='3' AND sid > '$index' ORDER BY `date` DESC LIMIT 20 ");
			}
			
		}
		else{
			$q = mysqli_query($link, "SELECT * FROM solution WHERE stid='$stid' AND `status`!='3' AND sid < '$index' ORDER BY `date` DESC LIMIT 20 ");
		}


		$qnum = mysqli_num_rows($q);
		if($qnum == 0){
			$data['state'] = 300;
			$data['response_msg'] = 'No tasks found';
			return $data;
		}

		$taskx = array();
		while ($qr = mysqli_fetch_array($q, MYSQLI_ASSOC)) {
			$tid = $qr['tid'];
			$tq = mysqli_query($link, "SELECT * FROM task WHERE tid='$tid' ");
			$tqr = mysqli_fetch_assoc($tq);
			$cid = $tqr['cid'];

			$cinfo = $this->get_company_info($cid);

			if(empty($cinfo['logo'])){
				$logo = 'p.png';
			}
			else{
				$logo = $cinfo['logo'];
			}

			if($qr['status'] != 0){
				$tk['solution_summary'] = $qr['summary'];
				$tk['solution_file'] = $baseUrl.'/docs/solutions/'.$qr['file'];
				$tk['solution_date'] = $qr['send_date'];
				$tk['solution_rate'] = $qr['rate'];

			}
			else{
				$tk['solution_summary']=$tk['solution_file']=$tk['solution_date']=$tk['solution_rate']= '';
			}

			$tk['tid'] = $tid;
			$tk['sid'] = $qr['sid'];
			$tk['company'] = $cinfo['cname'];
			$tk['company_location'] = $cinfo['location'];
			$tk['company_logo'] = $baseUrl.'/img/avatar/'.$logo;
			$tk['task_title'] = $tqr['title'];
			$tk['task_summary'] = $tqr['summary'];
			$tk['task_file'] = $baseUrl.'/docs/'.$tqr['file'];
			$tk['task_date'] = $tqr['date'];
			$tk['solution_status'] = $qr['status'];
			$tk['submitted_solutions'] = $this->total_task_solutions($tid);
			array_push($taskx, $tk);
		}

		$data['task'] = $taskx;
  	$data['state'] = 200;
  	return $data;

	}


	public function get_company_info($cid){
		global $link;

		$q = mysqli_query($link, "SELECT * FROM company WHERE cid='$cid' ");
		$qr = mysqli_fetch_assoc($q);
		return $qr;
	}

	public function start_task($userid, $task){
		global $link;

		$userid = clean($link, $userid);
		$task = clean($link, $task);

		$tcq = mysqli_query($link, "SELECT tid FROM task WHERE tid='$task' AND delete_task='0' ");
		$tcqnum = mysqli_num_rows($tcq);
		if($tcqnum == 0){
			$data['state'] = 400;
			$data['response_msg'] = 'Invalid task information';
			return $data;
		}

		$cq = mysqli_query($link, "SELECT sid FROM solution WHERE stid='$userid' AND tid='$task' ");
		$cqnum = mysqli_num_rows($cq);
		if($cqnum == 1){
			$data['state'] = 400;
			$data['response_msg'] = 'You have added this task already';
			return $data;
		}

		$timenow = date("Y-m-d H:i:s", time());
		$iq = mysqli_query($link, "INSERT INTO solution(stid, tid, `date`) VALUES('$userid', '$task', '$timenow') ");
		if($iq){
			$data['state'] = 200;
			return $data;
		}

		$data['state'] = 400;
		$data['response_msg'] = 'Error adding task...try again';
		return $data;
	}


	public function cancel_task($userid, $task){
		global $link;

		$userid = clean($link, $userid);
		$task = clean($link, $task);

		$uq = mysqli_query($link, "UPDATE solution SET `status`='3' WHERE stid='$userid' AND tid='$task' ");
		if($uq){
			$data['state'] = 200;
			return $data;
		}

		$data['state'] = 400;
		$data['response_msg'] = 'Error canceling task...try again';
		return $data;
	}


	public function total_task_solutions($task){
		global $link;

		$task = clean($link, $task);

		$q = mysqli_query($link, "SELECT `sid` FROM solution WHERE tid='$task' AND `status` IN ('1','2') ");
		$qnum = mysqli_num_rows($q);
		return $qnum;
	}


	public function checkfile($filename,$filesize){

    $allow = array('doc','docx','pdf');
    $bits = explode('.',$filename);
    $file_extn = strtolower(end($bits));
    if(in_array($file_extn, $allow) == false){
        return '0';
    }
    else if($filesize > 2500000){
        return '2';
    }
    else{
        return '1';
    }
	}


	public function update_solution($userid, $task, $summary, $solution, $solution_temp){
		global $link;

		$stid = $userid;
		$task = clean($link, $task);
		$summary = clean($link, $summary);

		$tq = mysqli_query($link, "SELECT `task`.`days` as `days`, `solution`.`date` as `begin` FROM `solution`,`task` WHERE `solution`.`tid`='$task' AND `task`.`tid`='$task' AND `solution`.`stid`='$stid' ");
		$tqnum = mysqli_num_rows($tq);
		if($tqnum == 0){
			return 0;
		}
		$speed = 0;
		$tqr = mysqli_fetch_assoc($tq);
		$days = $tqr['days']*86400;
		$start = time() - strtotime($tqr['begin']);
		if($days >= $start){
			$speed = 3;
		}

		$timenow = date("Y-m-d H:i:s", time());
		$filename = $this->uploadfile($solution, $solution_temp);
		if($filename == '0'){
			return 0;
		}
		$q = mysqli_query($link, "UPDATE solution SET summary='$summary', file='$filename',status='1',submission='1',speed='$speed',attempt='1',send_date='$timenow' WHERE tid='$task' AND stid='$stid' ");
		if($q){
			$sq = mysqli_query($link, "SELECT email,apid FROM appusers WHERE userid IN (SELECT cid FROM task WHERE tid='$task') AND user_type='c'");           
			$sqr = mysqli_fetch_assoc($sq);
			$user = $sqr['apid'];
			$userx = $this->user_data($stid, "username");
			$tid = 'st='.$userx['username'].'&t='.$task;
			$note = '<b>'.$userx['username'].'</b> submitted a solution for your task.';
			$inq = mysqli_query($link, "INSERT INTO `notification`(`apid`,`ntype`,`note_id`,`note`,`date`) VALUES('$user', 't', '$tid', '$note', '$timenow') ");
			
			$email = $sqr['email'];
			$message = $note.'<br><p>'.nl2br($summary).'</p>';
			$this->send_email($email, "New Solution", $message);
			return 1;
		}
		return 0;
	}


	public function uploadfile($filename,$filetmp){

		$allow = array('doc','docx','pdf');
		$bits = explode('.',$filename);
		$file_extn = strtolower(end($bits));
		$filenamex = 'rookSol'.substr(md5(time().rand(10000,99999)), 0, 15).'.'.$file_extn;
		$fullpath = '../docs/solutions/'.$filenamex;
				$move = move_uploaded_file($filetmp ,$fullpath) ;
				if(!$move){
						return '0';
				}
				return $filenamex;
	}


	public function user_data($stid){
		global $link;

		$data = array();
		$func_num_args = func_num_args();
		$func_get_args = func_get_args();
		
		if($func_num_args > 1){
			unset($func_get_args[0]);
			$fields = ''.implode(',',$func_get_args).'';
			$userid = clean($link, $stid);

			$data = mysqli_fetch_assoc(mysqli_query($link, "SELECT $fields FROM students WHERE stid='$userid' "));
			return $data;
			
		}

	}


	public function send_email($email, $title, $message){
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
                  <table width="100%" cellpadding="0" cellspacing="0" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">
                    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
												<p>'.$message.'</p>
												<hr>
											</td>
                    </tr>
                    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;text-align: center;" valign="top">
												<a href="'.$baseUrl.'/login" class="btn-primary" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #5fbeaa; margin: 0; border-color: #5fbeaa; border-style: solid; border-width: 10px 20px;">View</a>
											</td>
										</tr>
                    <tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;text-align: center;" valign="top">
										<p><b>Rook+,</b> feel bigger.</p>.
											</td>
										</tr></table></td>
							</tr></table></div>
				</td>
				<td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
			</tr></table></body>
		</html>'; 
		$subject = 'Rook+ | '.$title;
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