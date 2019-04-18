<?php

class CV{

  public function update_work_history($stid, $jobtitle, $employer, $country, $duties, $sdate, $edate, $current){
		global $link;

		$jobtitle = clean($link, $jobtitle);
		$employer = clean($link, $employer);
		$country = clean($link, $country);
		$duties = clean($link, $duties);
		$start = clean($link, $sdate);
		$end = clean($link, $edate);
		$current = clean($link, $current);

		$stid = clean($link, $stid);
		$timenow = date("Y-m-d H:i:s", time());
		if(empty($current)){
			$iq = mysqli_query($link, "INSERT INTO cv_work(`stid`,`job_title`,`employer`,`duties`,`country`,`start`,`end`,`current`,`date`) 
					VALUES('$stid', '$jobtitle', '$employer', '$duties', '$country', '$start', '$end', '0', '$timenow')");
		}
		else{
			$iq = mysqli_query($link, "INSERT INTO cv_work(`stid`,`job_title`,`employer`,`duties`,`country`,`start`,`current`,`date`) 
			VALUES('$stid', '$jobtitle', '$employer', '$duties', '$country', '$start', '$current', '$timenow')");
		}

		if($iq){
			$data['state'] = 200;
      return $data;
    }
    $data['state'] = 400;
    $data['response_msg'] = 'Error updating your work history';
    return $data;
	}



	public function update_hobby($stid, $hobby){
		global $link; 
		
		$hobby = clean($link, $hobby);
		$stid = clean($link, $stid);;
		$timenow = date("Y-m-d H:i:s", time());
		$cq = mysqli_query($link, "SELECT * FROM cv_hobbies WHERE stid='$stid' ");
		$cqnum = mysqli_num_rows($cq);
		if($cqnum == 0){
			$iq = mysqli_query($link, "INSERT INTO cv_hobbies(`stid`,`hobbies`,`date`) VALUES('$stid', '$hobby', '$timenow')");
			if($iq){
				$data['state'] = 200;
        return $data;
			}
			$data['state'] = 400;
      $data['response_msg'] = 'Error updating Hobbies and Interests';
      return $data;
		}

		$uq = mysqli_query($link, "UPDATE cv_hobbies SET `hobbies`='$hobby', `date`='$timenow' WHERE stid='$stid' ");
		if($uq){
			$data['state'] = 200;
      return $data;
    }
    $data['state'] = 400;
    $data['response_msg'] = 'Error updating Hobbies and Interests';
    return $data;
	}



	public function update_community_service($stid, $comms){
		global $link; 
		
		$comms = clean($link, $comms);
		$stid = clean($link, $stid);
		$timenow = date("Y-m-d H:i:s", time());

		$cq = mysqli_query($link, "SELECT * FROM cv_service WHERE stid='$stid' ");
		$cqnum = mysqli_num_rows($cq);
		if($cqnum == 0){
			$iq = mysqli_query($link, "INSERT INTO cv_service(`stid`,`service`,`date`) VALUES('$stid', '$comms', '$timenow')");
			if($iq){
				$data['state'] = 200;
        return $data;
			}
			$data['state'] = 400;
      $data['response_msg'] = 'Error updating Community Service';
      return $data;
		}

		$uq = mysqli_query($link, "UPDATE cv_service SET `service`='$comms', `date`='$timenow' WHERE stid='$stid' ");
		if($uq){
			$data['state'] = 200;
      return $data;
		}
    $data['state'] = 400;
    $data['response_msg'] = 'Error updating Community Service';
    return $data;
	}



	public function update_professional_summary($stid, $prof){
		global $link; 
		
		$prof = clean($link, $prof);
		$stid = clean($link, $stid);
		$timenow = date("Y-m-d H:i:s", time());

		$cq = mysqli_query($link, "SELECT * FROM cv_prof WHERE stid='$stid' ");
		$cqnum = mysqli_num_rows($cq);
		if($cqnum == 0){
			$iq = mysqli_query($link, "INSERT INTO cv_prof(`stid`,`summary`,`date`) VALUES('$stid', '$prof', '$timenow')");
			if($iq){
				$data['state'] = 200;
        return $data;
			}
			$data['state'] = 400;
      $data['response_msg'] = 'Error updating Professional Summary';
      return $data;
		}

		$uq = mysqli_query($link, "UPDATE cv_prof SET summary='$prof', `date`='$timenow' WHERE stid='$stid' ");
		if($uq){
			$data['state'] = 200;
      return $data;
    }
    $data['state'] = 400;
    $data['response_msg'] = 'Error updating Professional Summary';
    return $data;
	}


	public function update_education($stid, $sname, $sloc, $degree, $field, $cyear){
		global $link;

		$sname = clean($link, $sname);
		$sloc = clean($link, $sloc);
		$degree = clean($link, $degree);
		$field = clean($link, $field);
		$cyear = clean($link, $cyear);

		$stid = clean($link, $stid);
		$timenow = date("Y-m-d H:i:s", time());

		$iq = mysqli_query($link, "INSERT INTO cv_education(`stid`,`school`,`location`,`degree`,`field`,`finish`,`date`) 
			VALUES('$stid', '$sname', '$sloc', '$degree', '$field', '$cyear', '$timenow')");
    if($iq){
      $data['state'] = 200;
      return $data;
		}
    
    $data['state'] = 400;
    $data['response_msg'] = 'Error updating Education Infomation';
    return $data;
		
	}


	public function update_skill($stid, $skill){
		global $link;

		$skill = clean($link, $skill);
		$stid = clean($link, $stid);
		$timenow = date("Y-m-d H:i:s", time());

		$iq = mysqli_query($link, "INSERT INTO cv_skills(`stid`,`skill`,`date`) 
			VALUES('$stid', '$skill', '$timenow')");
		if($iq){
      $data['state'] = 200;
      return $data;
		}
    
    $data['state'] = 400;
    $data['response_msg'] = 'Error updating Skill Infomation';
    return $data;

	}


	public function update_info($stid, $fname, $lname, $gender, $email, $postal, $dob, $country, $phonenum, $city, $state){
		global $link;

		$fname = clean($link, $fname);
		$lname = clean($link, $lname);
    $gender = clean($link, $gender);
		$email = clean($link, $email);
		$postal = clean($link, $postal);
    $dob = clean($link, $dob);
    $country = clean($link, $country);
		$phonenum = clean($link, $phonenum);
		$city = clean($link, $city);
		$state = clean($link, $state);
		
		$stid = clean($link, $stid);

		if(empty($postal)){
			$postal = NULL;
		}

		$ec = $this->email_update($stid, $email);
		if($ec==1){
			$data['state'] = 400;
			$data['response_msg'] = 'Email already exist';
			return $data;
		}

		$q = mysqli_query($link, "UPDATE students SET `fname`='$fname', `lname`='$lname', `postal`='$postal', `gender`='$gender', `country`='$country', `dob`='$dob', `phone`='$phonenum', `city`='$city', `state`='$state' WHERE stid='$stid'");
		if($q){
			$qz = mysqli_query($link, "UPDATE appusers SET `email`='$email' WHERE stid ='$stid' AND user_type='s' ");
			if($qz){
				$data['state'] = 200;
      	return $data;
			}
			else{
				$data['state'] = 400;
				$data['response_msg'] = 'Error updating Personal Informationx. Try again';
				return $data;
			}
		}
		else{
			$data['state'] = 400;
			$data['response_msg'] = 'Error updating Personal Information. Try again';
			return $data;
		}
	}


	public function email_update($stid, $email){
		global $link;

		$email = clean($link, $email);
		$stid = clean($link, $stid);
		$q = mysqli_query($link, "SELECT apid FROM appusers WHERE email='$email' AND stid !='$stid' AND user_type='s' ");

		return  mysqli_num_rows($q);
	}


	public function get_skills($stid){
		global $link;

		$stid = clean($link, $stid);
		$skq = mysqli_query($link, "SELECT * FROM cv_skills WHERE stid='$stid' ");
		$sknum = mysqli_num_rows($skq);
		if($sknum == 0){
			$data['state'] = 300;
      return $data;
		}
		$skills=array();
		while($skqr = mysqli_fetch_array($skq, MYSQLI_ASSOC)){			
			$dx['skill_id'] = $skqr['csid'];
			$dx['skill'] = $skqr['skill'];
			
			array_push($skills, $dx);
		}

		$data['skills'] = $skills;
  	$data['state'] = 200;
  	return $data;

	}


	public function get_education($stid){
		global $link;

		$stid = clean($link, $stid);
		$edq = mysqli_query($link, "SELECT * FROM cv_education WHERE stid='$stid' ");
		$ednum = mysqli_num_rows($edq);
		if($ednum == 0){
			$data['state'] = 300;
      return $data;
		}
		$education=array();
		while($edqr = mysqli_fetch_array($edq, MYSQLI_ASSOC)){			
			$dx['edu_id'] = $edqr['ceid'];
			$dx['school'] = $edqr['school'];
			$dx['degree'] = $edqr['degree'];
			$dx['location'] = $edqr['location'];
			$dx['field'] = $edqr['field'];
			$dx['finish'] = date("Y", strtotime($edqr['finish']));
			
			array_push($education, $dx);
		}

		$data['education'] = $education;
  	$data['state'] = 200;
  	return $data;

	}


	public function get_professional_summary($stid){
		global $link;

		$stid = clean($link, $stid);
		$psq = mysqli_query($link, "SELECT `summary` FROM cv_prof WHERE stid='$stid' ");
		$psnum = mysqli_num_rows($psq);
		if($psnum == 0){
			$data['state'] = 300;
      return $data;
		}

		$psqr = mysqli_fetch_assoc($psq);
		$data['summary'] = clean($link, $psqr['summary']);
  	$data['state'] = 200;
  	return $data;

	}

	public function get_community_service($stid){
		global $link;

		$stid = clean($link, $stid);
		$svq = mysqli_query($link, "SELECT `service` FROM cv_service WHERE stid='$stid' ");
		$svnum = mysqli_num_rows($svq);
		if($svnum == 0){
			$data['state'] = 300;
      return $data;
		}
		$svqr = mysqli_fetch_assoc($svq);
		$data['service'] = clean($link, $svqr['service']);
  	$data['state'] = 200;
  	return $data;

	}


	public function get_hobbies($stid){
		global $link;

		$stid = clean($link, $stid);
		$hbq = mysqli_query($link, "SELECT `hobbies` FROM cv_hobbies WHERE stid='$stid' ");
		$hbnum = mysqli_num_rows($hbq);
		if($hbnum == 0){
			$data['state'] = 300;
      return $data;
		}
		$hbqr = mysqli_fetch_assoc($hbq);
		$data['hobbies'] = clean($link, $hbqr['hobbies']);
  	$data['state'] = 200;
  	return $data;
	}


	public function get_work_history($stid){
		global $link;

		$stid = clean($link, $stid);
		$whq = mysqli_query($link, "SELECT * FROM cv_work WHERE stid='$stid' ");
		$whnum = mysqli_num_rows($whq);
		if($whnum == 0){
			$data['state'] = 300;
      return $data;
		}

		$work=array();
		while($whqr = mysqli_fetch_array($whq, MYSQLI_ASSOC)){						
			$dx['work_id'] = $whqr['cwid'];
			$dx['job_title'] = $whqr['job_title'];
			$dx['duties'] = clean($link, $whqr['duties']);
			$dx['employer'] = clean($link, $whqr['employer']);
			$dx['country'] = $whqr['country'];
			$dx['start'] = date("M Y", strtotime($whqr['start']));
			if($whqr['current'] == 0){
				$dx['end'] = date("M Y", strtotime($whqr['end']));
			}else{
				$dx['end'] = 'Current';
			}
			
			array_push($work, $dx);
		}

		$data['work'] = $work;
  	$data['state'] = 200;
  	return $data;
	}


	public function get_companies_worked_with($stid){
		global $link;

		$stid = clean($link, $stid);

		$cmq = mysqli_query($link, "SELECT `cname`, `location` FROM company WHERE cid IN (SELECT cid FROM task WHERE tid IN (SELECT tid FROM solution WHERE stid='$stid' AND `status` NOT IN ('0','3') ) ) ORDER BY `cname` ASC ");
		$cmnum = mysqli_num_rows($cmq);
		if($cmnum == 0){
			$data['state'] = 300;
      return $data;
		}

		
		$company=array();
		while($cmqr = mysqli_fetch_array($cmq, MYSQLI_ASSOC)){		
			$dx['company_name'] = $cmqr['cname'];
			$dx['company_location'] = $cmqr['location'];
			array_push($company, $dx);
		}

		$data['companies'] = $company;
  	$data['state'] = 200;
  	return $data;
	}
	


	public function get_info($stid){
		global $link;

		$stid = clean($link, $stid);
		$q = $tkq = mysqli_query($link, "SELECT * FROM students WHERE stid='$stid'");
		$info = mysqli_fetch_assoc($q);

		$dx['first_name'] = $info['fname'];
		$dx['last_name'] = $info['lname'];
		$dx['date_of_birth'] = date("jS M, Y",strtotime($info['dob']));

		if($info['gender'] == 'f'){
			$dx['gender'] = 'Female';
		}else{
			$dx['gender'] = 'Male';
		}

		$dx['phone'] = $info['phone'];
		$dx['username'] = $info['username'];

		$eq = mysqli_query($link, "SELECT email FROM appusers WHERE userid='$stid' AND user_type='s'");
		$eqr = mysqli_fetch_assoc($eq);
		$dx['email'] = $eqr['email'];

		$dx['city']=$dx['postal']=$dx['state']= 'N/A';
		if(!empty($info['city'])){
			$dx['city'] = $info['city'];
		}

		if(!empty($info['postal'])){
			$dx['postal'] = $info['postal'];
		}

		if(!empty($info['state'])){
			$dx['state'] = $info['state'];
		}
		
		$countryid = $info['country'];
		$dx['country_id'] = $info['country'];
		$cq = mysqli_query($link, "SELECT `country_name` FROM countries WHERE id='$countryid' ");
		$cqr = mysqli_fetch_assoc($cq);
		$dx['country'] = $cqr['country_name'];


		$data['info'] = $dx;
  	$data['state'] = 200;
  	return $data;
	}


	public function update_cv($userid,$type,$tag){
		global $link;

		$userid = clean($link, $userid);
		$type = clean($link, $type);
		$tag = clean($link, $tag);

		if($type == 'job'){
			$dq = mysqli_query($link, "DELETE FROM cv_work WHERE cwid='$tag' ");
		}elseif($type == 'edu'){
			$dq = mysqli_query($link, "DELETE FROM cv_education WHERE ceid='$tag' ");
		}else{
			$dq = mysqli_query($link, "DELETE FROM cv_skills WHERE csid='$tag' ");
		}

		if($dq){
			$data['state'] = 200;
  		return $data;
		}

		$data['state'] = 400;
		$data['response_msg'] = 'Error delete CV information...Try again';
		return $data;
	}


}

?>