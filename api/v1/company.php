<?php
require '../app/validate.php';
require '../app/app_company.php';

$val = new Validate();
$cx = new Company();

if(isset($_POST['action']) && $_POST['action']=='company'){
	if(isset($_POST['token']) && $_POST['token']){
		$error = 0;

		$token = clean($link, $_POST['token']);
		if(isset($_POST['search']) && $_POST['search']){
			$search = clean($link, $_POST['search']);
		}
		else{
			$search = null;
		}



		$userid = $val->get_userid($token);
		if($userid == 0){
			$error++;	
		}

		if($error == 0){
			$data = $cx->get_company_list($userid, $search);
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
}else if(isset($_POST['action']) && $_POST['action']=='subscribe'){
	if(isset($_POST['token'], $_POST['company_id']) && $_POST['token'] && $_POST['company_id']){
		$error = 0;

		$token = clean($link, $_POST['token']);
		$cid = clean($link, $_POST['company_id']);

		$userid = $val->get_userid($token);
		if($userid == 0){
			$error++;	
		}

		if($error == 0){
			$data = $cx->subscribe($userid, $cid);
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
}
else{
	$data['state'] = 400;
	$data['response_msg'] = 'required parameters missing';
	echo json_encode($data);
	exit();
}