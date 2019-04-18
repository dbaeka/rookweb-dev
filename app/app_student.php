<?php

class Student{
  public function update_info($token, $stid, $fname, $lname, $username, $school, $program, $year, $phone){
		// public function update_info($token, $stid, $fname, $lname, $gender, $email, $postal, $dob, $country, $phonenum, $city, $state){
		global $link;

		$fname = clean($link, $fname);
		$lname = clean($link, $lname);
		$username = clean($link, $username);
		$school = clean($link, $school);
		$program = clean($link, $program);
		$year = clean($link, $year);
		$phone = clean($link, $phone);
    // $gender = clean($link, $gender);
		// $email = clean($link, $email);
		// $postal = clean($link, $postal);
    // $dob = clean($link, $dob);
    // $country = clean($link, $country);
		// $phonenum = clean($link, $phonenum);
		// $city = clean($link, $city);
		// $state = clean($link, $state);
		
		$stid = clean($link, $stid);
		$token = clean($link, $token);

		// if(empty($postal)){
		// 	$postal = NULL;
		// }

		$ec = mysqli_query($link, "SELECT stid FROM students WHERE username='$username' AND stid != '$stid' ");
		$ecnum = mysqli_num_rows($ec);
		if($ecnum==1){
      $data['state'] = 400;
      $data['response_msg'] = 'Username already exist';
      return $data;
		}

		// $q = mysqli_query($link, "UPDATE students SET `fname`='$fname', `lname`='$lname', `postal`='$postal', `gender`='$gender', `country`='$country', `dob`='$dob', `phone`='$phonenum', `city`='$city', `state`='$state' WHERE stid='$stid'");
		$q = mysqli_query($link, "UPDATE students SET `fname`='$fname', `lname`='$lname', `phone`='$phone', `username`='$username', `school`='$school', `program`='$program', `year`='$year' WHERE stid='$stid'");
		if($q){
			$data['state'] = 200;
      return $data;
		}
		else{
      $data['state'] = 400;
      $data['response_msg'] = 'Error updating Personal Information. Try again';
      return $data;
		}
  }
  

  public function email_update($token, $email){
		global $link;

		$email = clean($link, $email);
		$token = clean($link, $token);
		$q = mysqli_query($link, "SELECT apid FROM appusers WHERE email='$email' AND token !='$token' ");

		return  mysqli_num_rows($q);
  }
  

  public function check_country($country){
    global $link;

    $country = clean($link, $country);

    $q = mysqli_query($link, "SELECT id FROM countries WHERE id='$country' ");
    $qnum = mysqli_num_rows($q);
    return $qnum;
	}
	

	public function upload_avatar($userid, $avatar){
		global $link, $baseUrl;

		$userid = clean($link, $userid);

		$file = base64_decode($avatar);
		$imageName = 'rookie'.substr(md5(time()), 0, 10).'.png';
		$oldavat = mysqli_query($link, "SELECT avatar FROM students WHERE stid='$userid' ");
		$or = mysqli_fetch_assoc($oldavat);
		if(empty($or['avatar']) != true){
			$path = '../img/avatar/'.$or['avatar'];
			if(file_exists($path)){
				unlink($path);
			}
		}

		$upavat = mysqli_query($link, "UPDATE students SET avatar='$imageName' WHERE stid='$userid' ");
		if($upavat){
			if(file_put_contents('../img/avatar/'.$imageName , $file)){
				$data['state'] = 200;
				$data['avatar'] = $baseUrl.'/img/avatar/'.$imageName;
				return $data;
			}
			$data['state'] = 400;
			$data['response_msg'] = 'Error uploading avatar. Try again';
			return $data;
		}
		$data['state'] = 400;
		$data['response_msg'] = 'Error uploading avatar. Try again';
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

      $sdata['attempted_task'] = $taskc['attempted_task'];
      $sdata['watching'] = $this->get_companies_watching($stid);

      $data['statistics'] = $sdata;
      $data['state'] = 200;
			return $data;
	}


	public function get_attempts($stid){
		global $link;

		$stid = clean($link, $stid);

		$q = mysqli_query($link, "SELECT sid FROM solution WHERE stid='$stid' AND status !='3' ");
		$qnum = mysqli_num_rows($q);
		return $qnum;
	}


	public function get_solutions($stid){
		global $link;

		$stid = clean($link, $stid);

		$q = mysqli_query($link, "SELECT sid FROM solution WHERE stid='$stid' AND `status` NOT IN ('0','3') ");
		$qnum = mysqli_num_rows($q);
		return $qnum;
	}
	

	public function get_progress($stid){
		global $link;

		$stid = clean($link, $stid);
		
		$attempts = $this->get_attempts($stid);
		$solutions = $this->get_solutions($stid);
		$comp = 0;
		if ($attempts != 0) {
			if($solutions != 0){
				$comp = number_format(($solutions / $attempts) * 100);
			}
		}

		$dx['precentage_completed'] = $comp;
		$dx['task_attempts'] = $attempts;
		$dx['task_solutions'] = $solutions;

		$data['progress'] = $dx;
		$data['state'] = 200;
		return $data;
	}
	


	public function get_companies_watching($stid){
		global $link;

		$stid = clean($link, $stid);

		$q = mysqli_query($link, "SELECT wid FROM watches WHERE stid='$stid' ");
		$qnum = mysqli_num_rows($q);
		return $qnum;
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
}

?>