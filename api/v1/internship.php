<?php
require '../app/validate.php';
require '../app/app_internship.php';

$val = new Validate();
$ix = new Internship();

if(isset($_POST['action']) && $_POST['action']=='internship'){
	if(isset($_POST['token'], $_POST['type'], $_POST['index']) && $_POST['token'] && $_POST['type'] && $_POST['index']){
		$error = 0;

		$token = clean($link, $_POST['token']);
		$type = clean($link, $_POST['type']);
		$index = clean($link, $_POST['index']);

	

		$userid = $val->get_userid($token);
		if($userid == 0){
			$error++;	
		}

		if($type != 'n' && $type != 'o'){
			$error++;	
		}

		if($error == 0){
			$data = $ix->get_internships($userid, $type, $index);
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
else if(isset($_POST['action']) && $_POST['action']=='apply'){
	if(isset($_POST['token'], $_POST['internship']) && $_POST['token'] && $_POST['internship']){
		$error = 0;

		$token = clean($link, $_POST['token']);
		$inid = clean($link, $_POST['internship']);

		$userid = $val->get_userid($token);
		if($userid == 0){
			$error++;	
		}

		if($error == 0){
			$data = $ix->apply($userid, $inid);
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


?>