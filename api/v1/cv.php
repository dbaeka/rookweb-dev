<?php
require '../app/validate.php';
require '../app/app_cv.php';

$val = new Validate();
$cx = new CV();

if(isset($_POST['action']) && $_POST['action']=='add_skill'){
	if(isset($_POST['token'], $_POST['skill']) && $_POST['token'] && $_POST['skill']){
		$error = 0;

		$token = clean($link, $_POST['token']);
    $skill = clean($link, $_POST['skill']);
    
    $userid = $val->get_userid($token);
		if($userid == 0){
			$error++;	
		}

		if($error == 0){
			$data = $cx->update_skill($userid, $skill);
		}
		else{
			$data['state'] = 400;
			$data['response_msg'] = 'invalid parameters';
		}
		echo json_encode($data);
		exit();

  }else{
		$data['state'] = 400;
		$data['response_msg'] = 'invalid parameters';
		echo json_encode($data);
		exit();
	}

}else if(isset($_POST['action']) && $_POST['action']=='add_education'){
  if(isset($_POST['token'], $_POST['school_name'], $_POST['school_location'], $_POST['degree'], $_POST['field'], $_POST['completion_year']) 
  && $_POST['token'] && $_POST['school_name'] && $_POST['school_location'] && $_POST['degree'] && $_POST['field'] && $_POST['completion_year']){
		$error = 0;

		$token = clean($link, $_POST['token']);
    $sname = clean($link, $_POST['school_name']);
    $sloc = clean($link, $_POST['school_location']);
    $degree = clean($link, $_POST['degree']);
    $field = clean($link, $_POST['field']);
    $cyear = clean($link, $_POST['completion_year']);
    
    $userid = $val->get_userid($token);
		if($userid == 0){
			$error++;	
		}

		if($error == 0){
			$data = $cx->update_education($userid, $sname, $sloc, $degree, $field, $cyear);
		}
		else{
			$data['state'] = 400;
			$data['response_msg'] = 'invalid parameters';
		}
		echo json_encode($data);
		exit();

  }else{
		$data['state'] = 400;
		$data['response_msg'] = 'invalid parameters';
		echo json_encode($data);
		exit();
	}

}else if(isset($_POST['action']) && $_POST['action']=='update_professional_summary'){
	if(isset($_POST['token'], $_POST['summary']) && $_POST['token'] && $_POST['summary']){
		$error = 0;

		$token = clean($link, $_POST['token']);
    $summary = clean($link, $_POST['summary']);
    
    $userid = $val->get_userid($token);
		if($userid == 0){
			$error++;	
		}

		if($error == 0){
			$data = $cx->update_professional_summary($userid, $summary);
		}
		else{
			$data['state'] = 400;
			$data['response_msg'] = 'invalid parameters';
		}
		echo json_encode($data);
		exit();

  }else{
		$data['state'] = 400;
		$data['response_msg'] = 'invalid parameters';
		echo json_encode($data);
		exit();
	}

}else if(isset($_POST['action']) && $_POST['action']=='add_work_history'){
  if(isset($_POST['token'], $_POST['jobtitle'], $_POST['employer'], $_POST['country'], $_POST['duties'], $_POST['start_date'], $_POST['current']) 
  && $_POST['token'] && $_POST['jobtitle'] && $_POST['employer'] && $_POST['country'] && $_POST['duties'] && $_POST['start_date'] && $_POST['current']){
		$error = 0;

		$token = clean($link, $_POST['token']);
    $jobtitle = clean($link, $_POST['jobtitle']);
    $employer = clean($link, $_POST['employer']);
    $country = clean($link, $_POST['country']);
    $duties = clean($link, $_POST['duties']);
    $sdate = clean($link, $_POST['start_date']);
    
    $current = clean($link, $_POST['current']);
    
    
    $userid = $val->get_userid($token);
		if($userid == 0){
			$error++;	
    }
    
    if($current == '1'){
      $edate = '';
    }else{
      if(isset($_POST['end_date']) &&  $_POST['end_date']){
        $edate = clean($link, $_POST['end_date']);
        $current = '0';
      }else{
        $error++;
      }

    }

		if($error == 0){
			$data = $cx->update_work_history($userid, $jobtitle, $employer, $country, $duties, $sdate, $edate, $current);
		}
		else{
			$data['state'] = 400;
			$data['response_msg'] = 'invalid parameters';
		}
		echo json_encode($data);
		exit();

  }else{
		$data['state'] = 400;
		$data['response_msg'] = 'invalid parameters';
		echo json_encode($data);
		exit();
	}

}else if(isset($_POST['action']) && $_POST['action']=='update_community_service'){
	if(isset($_POST['token'], $_POST['service']) && $_POST['token'] && $_POST['service']){
		$error = 0;

		$token = clean($link, $_POST['token']);
    $service = clean($link, $_POST['service']);
    
    $userid = $val->get_userid($token);
		if($userid == 0){
			$error++;	
		}

		if($error == 0){
			$data = $cx->update_community_service($userid, $service);
		}
		else{
			$data['state'] = 400;
			$data['response_msg'] = 'invalid parameters';
		}
		echo json_encode($data);
		exit();

  }else{
		$data['state'] = 400;
		$data['response_msg'] = 'invalid parameters';
		echo json_encode($data);
		exit();
	}

}else if(isset($_POST['action']) && $_POST['action']=='update_hobby'){
	if(isset($_POST['token'], $_POST['hobbies']) && $_POST['token'] && $_POST['hobbies']){
		$error = 0;

		$token = clean($link, $_POST['token']);
    $hobbies = clean($link, $_POST['hobbies']);
    
    $userid = $val->get_userid($token);
		if($userid == 0){
			$error++;	
		}

		if($error == 0){
			$data = $cx->update_hobby($userid, $hobbies);
		}
		else{
			$data['state'] = 400;
			$data['response_msg'] = 'invalid parameters';
		}
		echo json_encode($data);
		exit();

  }else{
		$data['state'] = 400;
		$data['response_msg'] = 'invalid parameters';
		echo json_encode($data);
		exit();
	}

}else if(isset($_POST['action']) && $_POST['action']=='update_profile'){
	if(isset($_POST['token'], $_POST['fname'], $_POST['lname'], $_POST['email'], $_POST['postal'], $_POST['phone'], $_POST['gender'], $_POST['country'], $_POST['city'], $_POST['state'], $_POST['month'], $_POST['day'], $_POST['year']) 
	&& $_POST['token'] && $_POST['fname'] && $_POST['lname'] && $_POST['email'] && $_POST['postal'] && $_POST['phone'] && $_POST['gender'] && $_POST['country'] && $_POST['city'] && $_POST['state'] && $_POST['month'] && $_POST['day'] && $_POST['year']){
		$error = 0;

		$token = clean($link, $_POST['token']);
		$fname = clean($link, $_POST['fname']);
		$lname = clean($link, $_POST['lname']);
		$email = clean($link, $_POST['email']);
		$postal = clean($link, $_POST['postal']);
		$phone = clean($link, $_POST['phone']);
		$gender = clean($link, $_POST['gender']);
		$country = clean($link, $_POST['country']);
		$city = clean($link, $_POST['city']);
		$state = clean($link, $_POST['state']);
		$month = clean($link, $_POST['month']);
		$day = clean($link, $_POST['day']);
		$year = clean($link, $_POST['year']);

		$dob = date("Y-m-d", strtotime($year.'-'.$month.'-'.$day));
    
    $userid = $val->get_userid($token);
		if($userid == 0){
			$error++;	
		}

		if($error == 0){
			$data = $cx->update_info($userid, $fname, $lname, $gender, $email, $postal, $dob, $country, $phone, $city, $state);
		}
		else{
			$data['state'] = 400;
			$data['response_msg'] = 'invalid parameters';
		}
		echo json_encode($data);
		exit();

  }else{
		$data['state'] = 400;
		$data['response_msg'] = 'invalid parameters';
		echo json_encode($data);
		exit();
	}

}else if(isset($_POST['action']) && $_POST['action']=='get_skill'){
	if(isset($_POST['token']) && $_POST['token']){
		$error = 0;
		$token = clean($link, $_POST['token']);

    $userid = $val->get_userid($token);
		if($userid == 0){
			$error++;	
		}

		if($error == 0){
			$data = $cx->get_skills($userid);
		}
		else{
			$data['state'] = 400;
			$data['response_msg'] = 'invalid parameters';
		}
		echo json_encode($data);
		exit();

  }else{
		$data['state'] = 400;
		$data['response_msg'] = 'invalid parameters';
		echo json_encode($data);
		exit();
	}

}else if(isset($_POST['action']) && $_POST['action']=='get_education'){
	if(isset($_POST['token']) && $_POST['token']){
		$error = 0;
		$token = clean($link, $_POST['token']);
		
    $userid = $val->get_userid($token);
		if($userid == 0){
			$error++;	
		}

		if($error == 0){
			$data = $cx->get_education($userid);
		}
		else{
			$data['state'] = 400;
			$data['response_msg'] = 'invalid parameters';
		}
		echo json_encode($data);
		exit();

  }else{
		$data['state'] = 400;
		$data['response_msg'] = 'invalid parameters';
		echo json_encode($data);
		exit();
	}

}else if(isset($_POST['action']) && $_POST['action']=='get_professional_summary'){
	if(isset($_POST['token']) && $_POST['token']){
		$error = 0;
		$token = clean($link, $_POST['token']);

    $userid = $val->get_userid($token);
		if($userid == 0){
			$error++;	
		}

		if($error == 0){
			$data = $cx->get_professional_summary($userid);
		}
		else{
			$data['state'] = 400;
			$data['response_msg'] = 'invalid parameters';
		}
		echo json_encode($data);
		exit();

  }else{
		$data['state'] = 400;
		$data['response_msg'] = 'invalid parameters';
		echo json_encode($data);
		exit();
	}

}else if(isset($_POST['action']) && $_POST['action']=='get_community_service'){
	if(isset($_POST['token']) && $_POST['token']){
		$error = 0;
		$token = clean($link, $_POST['token']);

    $userid = $val->get_userid($token);
		if($userid == 0){
			$error++;	
		}

		if($error == 0){
			$data = $cx->get_community_service($userid);
		}
		else{
			$data['state'] = 400;
			$data['response_msg'] = 'invalid parameters';
		}
		echo json_encode($data);
		exit();

  }else{
		$data['state'] = 400;
		$data['response_msg'] = 'invalid parameters';
		echo json_encode($data);
		exit();
	}

}else if(isset($_POST['action']) && $_POST['action']=='get_hobby'){
	if(isset($_POST['token']) && $_POST['token']){
		$error = 0;
		$token = clean($link, $_POST['token']);

    $userid = $val->get_userid($token);
		if($userid == 0){
			$error++;	
		}

		if($error == 0){
			$data = $cx->get_hobbies($userid);
		}
		else{
			$data['state'] = 400;
			$data['response_msg'] = 'invalid parameters';
		}
		echo json_encode($data);
		exit();

  }else{
		$data['state'] = 400;
		$data['response_msg'] = 'invalid parameters';
		echo json_encode($data);
		exit();
	}

}else if(isset($_POST['action']) && $_POST['action']=='get_work_history'){
	if(isset($_POST['token']) && $_POST['token']){
		$error = 0;
		$token = clean($link, $_POST['token']);

    $userid = $val->get_userid($token);
		if($userid == 0){
			$error++;	
		}

		if($error == 0){
			$data = $cx->get_work_history($userid);
		}
		else{
			$data['state'] = 400;
			$data['response_msg'] = 'invalid parameters';
		}
		echo json_encode($data);
		exit();

  }else{
		$data['state'] = 400;
		$data['response_msg'] = 'invalid parameters';
		echo json_encode($data);
		exit();
	}

}else if(isset($_POST['action']) && $_POST['action']=='get_profile'){
	if(isset($_POST['token']) && $_POST['token']){
		$error = 0;
		$token = clean($link, $_POST['token']);
		
    $userid = $val->get_userid($token);
		if($userid == 0){
			$error++;	
		}

		if($error == 0){
			$data = $cx->get_info($userid);
		}
		else{
			$data['state'] = 400;
			$data['response_msg'] = 'invalid parameters';
		}
		echo json_encode($data);
		exit();

  }else{
		$data['state'] = 400;
		$data['response_msg'] = 'invalid parameters';
		echo json_encode($data);
		exit();
	}

}else if(isset($_POST['action']) && $_POST['action']=='get_companies_worked_with'){
	if(isset($_POST['token']) && $_POST['token']){
		$error = 0;
		$token = clean($link, $_POST['token']);
		
    $userid = $val->get_userid($token);
		if($userid == 0){
			$error++;	
		}

		if($error == 0){
			$data = $cx->get_companies_worked_with($userid);
		}
		else{
			$data['state'] = 400;
			$data['response_msg'] = 'invalid parameters';
		}
		echo json_encode($data);
		exit();

  }else{
		$data['state'] = 400;
		$data['response_msg'] = 'invalid parameters';
		echo json_encode($data);
		exit();
	}

}else if(isset($_POST['action']) && $_POST['action']=='delete_cv_info'){
	if(isset($_POST['token'], $_POST['tag'], $_POST['type']) && $_POST['token'] && $_POST['tag'] && $_POST['type']){
		$error = 0;

		$token = clean($link, $_POST['token']);
    $tag = clean($link, $_POST['tag']);
    $type = clean($link, $_POST['type']);
    
    $userid = $val->get_userid($token);
		if($userid == 0){
			$error++;	
		}

		if(($type == 'job' || $type == 'edu' || $type == 'skill') && $error == 0) {
			$data = $cx->update_cv($userid,$type,$tag);
		}
		else{
			$data['state'] = 400;
			$data['response_msg'] = 'invalid parameters';
		}
		echo json_encode($data);
		exit();

  }else{
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