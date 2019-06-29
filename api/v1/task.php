<?php
require '../app/validate.php';
require '../app/task.php';

$val = new Validate();
$tx = new Task();

if(isset($_POST['action']) && $_POST['action']=='newtask'){
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
			$data = $tx->get_new_tasks($userid, $type, $index);
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
else if(isset($_POST['action']) && $_POST['action']=='mytask'){
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
			$data = $tx->get_my_tasks($userid, $type, $index);
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
else if(isset($_POST['action']) && $_POST['action']=='starttask'){
	if(isset($_POST['token'], $_POST['task']) && $_POST['token'] && $_POST['task']){
		$error = 0;

		$token = clean($link, $_POST['token']);
		$tid = clean($link, $_POST['task']);

		$userid = $val->get_userid($token);
		if($userid == 0){
			$error++;	
		}

		if($error == 0){
			$data = $tx->start_task($userid, $tid);
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
else if(isset($_POST['action']) && $_POST['action']=='canceltask'){
	if(isset($_POST['token'], $_POST['task']) && $_POST['token'] && $_POST['task']){
		$error = 0;

		$token = clean($link, $_POST['token']);
		$tid = clean($link, $_POST['task']);

		$userid = $val->get_userid($token);
		if($userid == 0){
			$error++;	
		}

		if($error == 0){
			$data = $tx->cancel_task($userid, $tid);
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
else if(isset($_POST['action']) && $_POST['action']=='submitsolution'){
	if(isset($_POST['token'], $_POST['summary'], $_POST['task_id'], $_FILES['pdf']['name']) && $_POST['token'] && $_POST['summary'] && $_POST['task_id'] && $_FILES['pdf']['name']){
		$error = 0;


		$token = clean($link, $_POST['token']);
		$summary = clean($link, $_POST['summary']);
		$task = clean($link, $_POST['task_id']);


		$solution = $_FILES['pdf']['name'];
		$solution_size = $_FILES['pdf']['size'];
		$solution_temp = $_FILES['pdf']['tmp_name'];

		$fileupdt = $tx->checkfile($solution,$solution_size);
    if($fileupdt == 0){
			$data['state'] = 400;
			$data['response_msg'] = 'Invalid file format (Allowed pdf,doc,docx)';
			echo json_encode($data);
			exit();
    }
    else if($fileupdt == 2){
			$data['state'] = 400;
			$data['response_msg'] = 'Solution file size too big (Max file size 2MB)';
			echo json_encode($data);
			exit();
    }

		$userid = $val->get_userid($token);
		if($userid == 0){
			$error++;
		}

		if($error == 0){	
			$inad = $tx->update_solution($userid, $task, $summary, $solution, $solution_temp);
      if($inad == 1){
				$data['state'] = 200;
				echo json_encode($data);
				exit();
      }
      else{
				$data['state'] = 400;
				$data['response_msg'] = 'Solution could not be submit...try again.';
				echo json_encode($data);
				exit();
      }
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