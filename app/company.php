<?php
require('utility.php');

class Company{

  public function get_user_type($apid){
    global $link;
    
    $apid = clean($link, $apid);

    $data = mysqli_fetch_assoc(mysqli_query($link, "SELECT user_type, userid FROM appusers WHERE apid='$apid' "));
    return $data;
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


	public function get_total_students($apid){
		global $link;

    $apid =  clean($link, $apid);
    $uc = $this->get_user_type($apid);
    if($uc['user_type'] != 'c'){
      return 'You do not have the privilege to perform this action';
    }

    $cid = $uc['userid'];

		$q = mysqli_query($link, "SELECT sbid FROM `subscribe` WHERE cid='$cid' ");
		$qnum = mysqli_num_rows($q);
			return $qnum;
	}


  public function honey_pot($apid){
		global $link;
		
		$apid =  clean($link, $apid);
    $uc = $this->get_user_type($apid);
    if($uc['user_type'] != 'c'){
      return 'You do not have the privilege to perform this action';
    }

    $cid = $uc['userid'];

    $q = mysqli_query($link, "SELECT * FROM `solution` WHERE tid IN (SELECT tid FROM `task` WHERE cid='$cid') AND status='1' ORDER BY RAND() LIMIT 5 ");
    $qnum = mysqli_num_rows($q);
    if($qnum == 0){
      return '<p class="text-center">No Task Solution found</p>';
    }

    $sol = '';
    while ($qr = mysqli_fetch_array($q, MYSQLI_ASSOC)) {
      $tid = $qr['tid'];
      $tq = mysqli_query($link, "SELECT title FROM task WHERE tid='$tid' ");
      $tqr = mysqli_fetch_assoc($tq);

      $stid = $qr['stid'];
      $stq = mysqli_query($link, "SELECT username FROM students WHERE stid='$stid'");
      $stqr = mysqli_fetch_assoc($stq);

      $datepost = strtotime(date("Y-m-d", strtotime($qr['send_date'])));
      $tdate = strtotime(date("Y-m-d", time()));
      $datedif = $tdate - $datepost;
      if($datedif < 86400){
          $timepost = 'Today '.date("g:i A",strtotime($qr['send_date']));
      }
      else if($datedif >= 86400 && $datedif < 172800){
          $timepost = 'Yesterday '.date("g:i A",strtotime($qr['send_date']));
      }
      else if($datedif >= 31104000){
          $timepost = date("jS M, Y",strtotime($qr['send_date']));
      }
      else{
          $timepost = date("jS M",strtotime($qr['send_date']));
      }

      $sol .= '<h6 class="card-title">'.$tqr['title'].'</h6>
                <p class="card-text mg-b-5" style="color:#212529;cursor:pointer;">'.$qr['summary'].'</p>
                <p class="card-subtitle mg-b-0" style="font-size:13px;"><b>'.$stqr['username'].'</b> - '.$timepost.'</p>                
                <hr>';
    }
    return $sol;
  }
  

  public function get_notifications($apid){
		global $link;

		$apid = clean($link, $apid);
		$st = $this->get_user_type($apid);
		if($st['user_type'] != 'c'){
			$data['show'] = '';
			$data['notes'] = '<p class="text-center">Sorry, you do not have the privilege to access this information</p>';
			return $data;
		}

		$q = mysqli_query($link, "SELECT * FROM `notification` WHERE apid='$apid' AND seen='0' ORDER BY `date` DESC LIMIT 10 ");
		$qnum = mysqli_num_rows($q);
		if($qnum == 0){
			$data['show'] = '';
			$data['notes'] = '<div class="dropdown-footer">
													No Notifications
												</div>';
			return $data;
		}

		$notes = '';
		while($qr = mysqli_fetch_array($q, MYSQLI_ASSOC)){
			if($qr['ntype'] == 't'){
				$notes .= '<a href="ctask?'.$qr['note_id'].'" class="media-list-link read">
										<div class="media" style="padding: 10px;">
											<div class="bg-success" style="width: 10px;height:10px;text-align: center;border-radius: 10px;color: #fff;"></div>
											<div class="media-body">
												<p class="noti-text">'.$qr['note'].'</p>
												<span>'.date("jS M, Y h:i a",strtotime($qr['date'])).'</span>
											</div>
										</div>
									</a>';
			}else if($qr['ntype'] == 'a'){
				$notes .= '<a href="#" class="media-list-link read">
										<div class="media" style="padding: 10px;">
											<div class="bg-danger" style="width: 10px;height:10px;text-align: center;border-radius: 10px;color: #fff;"></div>
											<div class="media-body">
												<p class="noti-text"><strong>Suzzeth Bungaos</strong> tagged you and 18 others in a post.</p>
												<span>October 03, 2017 8:45am</span>
											</div>
										</div>
									</a>';
			}else if($qr['ntype'] == 'i'){
				$notes .= '<a href="internship?'.$qr['note_id'].'" class="media-list-link read">
										<div class="media" style="padding: 10px;">
											<div class="bg-warning" style="width: 10px;height:10px;text-align: center;border-radius: 10px;color: #fff;"></div>
											<div class="media-body">
												<p class="noti-text">'.$qr['note'].'</p>
												<span>'.date("jS M, Y h:i a",strtotime($qr['date'])).'</span>
											</div>
										</div>
									</a>';
			}
			
		}
		$data['show'] = '<span class="square-8 bg-danger pos-absolute t-15 r-5 rounded-circle"></span>';
		$data['notes'] = $notes;
		return $data;
	}


  public function get_total_tasks($apid){
    global $link;

    $apid =  clean($link, $apid);
    $uc = $this->get_user_type($apid);
    if($uc['user_type'] != 'c'){
      return 'You do not have the privilege to perform this action';
    }

    $cid = $uc['userid'];

    $q = mysqli_query($link, "SELECT tid FROM `task` WHERE cid='$cid' ");
    $qnum = mysqli_num_rows($q);
    return $qnum;
  }


  public function get_total_task_solutions($apid){
    global $link;

    $apid =  clean($link, $apid);
    $uc = $this->get_user_type($apid);
    if($uc['user_type'] != 'c'){
      return 'You do not have the privilege to perform this action';
    }

    $cid = $uc['userid'];

    $q = mysqli_query($link, "SELECT sid FROM `solution` WHERE tid IN (SELECT tid FROM `task` WHERE cid='$cid') AND `status` NOT IN ('0','3') ");
    $qnum = mysqli_num_rows($q);
    return $qnum;
  }


  public function get_watch_list($apid, $search, $pagex){
    global $link;
    
    $apid =  clean($link, $apid);
    $cu = $this->get_user_type($apid);
    if($cu['user_type'] != 'c'){
      $data['list'] = '<p class="text-center">Sorry, you do not have the privilege to access this information</p>';
      $data['page'] = '';
      $data['range'] = '';
      return $data;
    }
    $cid = $cu['userid'];

    $search = clean($link, $search);
    $page = clean($link, $pagex);

    $parameter = '';
    $pagegets = '';
    if(!empty($search) == true){
      $parameter = "AND stid IN (SELECT stid FROM students WHERE username LIKE '%$search%')";
      $pagegets = '&st='.$search;
    }

    if(empty($page) == false){
      $checkqx = mysqli_query($link, "SELECT COUNT(*) FROM students WHERE stid IN (SELECT stid FROM watches WHERE cid='$cid') $parameter"); 
      $pqcount = mysqli_fetch_assoc($checkqx);
      $cknum = $pqcount['COUNT(*)'];
      $pagemax = ceil($cknum/12);
      if($pagemax < $page){
        $page = $pagemax;
      }

      if($page > 1){
        $pagex = (12*$page) - 12;
      }
      else{
        $pagex = 0;
      }
      $qlimit = "LIMIT $pagex,12";
    }
    else{
      $qlimit = "LIMIT 12";
    }

    $q = mysqli_query($link, "SELECT stid,username FROM students WHERE stid IN (SELECT stid FROM watches WHERE cid='$cid' ) $parameter ORDER BY username ASC $qlimit");
    $qnum = mysqli_num_rows($q);
    if($qnum == 0){
      $data['list'] = '<p class="text-center">No Student found</p>';
      $data['page'] = '';
      $data['range'] = '';
      return $data;
    }

    $pagg=$wt='';
    $pqx = mysqli_query($link, "SELECT COUNT(*) FROM students WHERE stid IN (SELECT stid FROM watches WHERE cid='$cid' ) $parameter ");
    $pqcount = mysqli_fetch_assoc($pqx);
    $pqnum = $pqcount['COUNT(*)'];
    $pqnumx = ceil($pqnum/12);
    $start = 1;
    if($page == 1 || empty($page) == true){
      $page = 1;
    }
    else if($page > 2){
      $start = $page - 2;
      $pagg .= '<li class="page-item">
                  <a class="page-link" href="watchlist?page='.($page-1).$pagegets.'" aria-label="Previous"><i class="ion ion-arrow-left-a"></i></a>
                </li>';
    }

    for($i=$start;$i<=($start+4);$i++){
        if($i == $page){
            $pagg .= '<li class="page-item active"><a class="page-link" href="watchlist?page='.$i.$pagegets.'">'.$i.'</a></li>';
        }
        else if($i <= $pqnumx){
            $pagg .= '<li class="page-item"><a class="page-link" href="watchlist?page='.$i.$pagegets.'">'.$i.'</a></li>';   
        }
    }


    if($pqnumx > 1 && $pqnumx > $page){
      $pagg .= '<li class="pag-prev mg-5">
                  <a style="border:none;" class="page-link" href="watchlist?page='.($page+1).$pagegets.'" aria-label="Next"><i class="ion ion-arrow-right-a"></i></a>
                </li>';
    }
    while ($qr = mysqli_fetch_array($q, MYSQLI_ASSOC)) {
      $stid = $qr['stid'];

      $wt .= '<p class="tx-sm tx-inverse mg-b-0 tx-15"><a href="profile?student='.$stid.'"><b>'.$qr['username'].'</b></a></p>
              <p class="tx-12 mg-b-0 mg-t-0">Points: <b>'.$this->get_student_points($stid).'</b></p>
              <hr>';
    }
    
    $fromnum = 1;
    $tonum = ($page * 12);
    if($tonum > $pqnum){
      $tonum = $pqnum;
    }
    if($page > 1){
      $fromnum = ($page * 12)-11;
      if($tonum > $pqnum){
        $tonum = $pqnum;
      }
    }

		$data['list'] = $wt;
    $data['page'] = '<div class="ht-80 d-flex align-items-center justify-content-center">
                      <nav aria-label="Page navigation">
                        <ul class="pagination pagination-basic pagination-circle mg-b-0">
                          '.$pagg.'
                        </ul>
                      </nav>
                    </div>';
    $data['range'] = '<p class="text-center mg-b-0">Showing <span>'.$fromnum.'</span> to <span>'.$tonum.'</span> of <span>'.$pqnum.'</span> Students</p>';

    return $data;
  }


  public function get_watch_count($apid){
    global $link;

    $apid =  clean($link, $apid);
    $uc = $this->get_user_type($apid);
    if($uc['user_type'] != 'c'){
      return 'You do not have the privilege to perform this action';
    }

    $cid = $uc['userid'];

    $q = mysqli_query($link, "SELECT stid,username FROM students WHERE stid IN (SELECT stid FROM watches WHERE cid='$cid' ORDER BY RAND()) LIMIT 5");
    return mysqli_num_rows($q);
  
  }
  


  public function get_watching_list($apid){
    global $link;

    $apid =  clean($link, $apid);
    $uc = $this->get_user_type($apid);
    if($uc['user_type'] != 'c'){
      return 'You do not have the privilege to perform this action';
    }

    $cid = $uc['userid'];

    $q = mysqli_query($link, "SELECT stid,username FROM students WHERE stid IN (SELECT stid FROM watches WHERE cid='$cid' ORDER BY RAND()) LIMIT 5");
    $qnum = mysqli_num_rows($q);
    if($qnum == 0){
      return '<p class="text-center">You are not watching any student...</p>';
    }

    $wt = '';
    while ($qr = mysqli_fetch_array($q, MYSQLI_ASSOC)) {
      $stid = $qr['stid'];

      $wt .= '<p class="tx-sm tx-inverse mg-b-0 tx-15"><a href="profile?student='.$stid.'"><b>'.$qr['username'].'</b></a></p>
              <p class="tx-12 mg-b-0 mg-t-0">Points: <b>'.$this->get_student_points($stid).'</b></p>
              <hr>';
    }
    return $wt;
  }


  public function get_student_info($apid, $student, $page){
    global $link;

    $apid = clean($link, $apid);
    $cu = $this->get_user_type($apid);
    if($cu['user_type'] != 'c'){
      $data['info'] = '';
      $data['page'] = '';
      $data['tasks'] = '<p class="text-center">Invalid Info</p>';
      $data['range'] = '';
      return $data;
    }

    if(empty($student)){
      $data['info'] = '';
      $data['tasks'] = '<p class="text-center">Invalid Info</p>';
      $data['page'] = '';
      $data['range'] = '';
      return $data;
    }

    $cid = $cu['userid'];
    $stid = clean($link, $student);

    $q = mysqli_query($link, "SELECT * FROM students WHERE stid='$stid' ");
    $qnum = mysqli_num_rows($q);
    if($qnum == 0){
      $data['info'] = '';
      $data['tasks'] = '<p class="text-center">Invalid Info</p>';
      $data['page'] = '';
      $data['range'] = '';
      return $data;
    }

    $qr = mysqli_fetch_assoc($q);
    if(empty($qr['avatar'])){
      $avatar = 'p.png';
    }
    else{
      $avatar = $qr['avatar'];
    }

    $wq = mysqli_query($link, "SELECT stid FROM watches WHERE stid='$stid' AND cid='$cid' ");
    $wnum = mysqli_num_rows($wq);
    if($wnum == 0){
      $watch = '<button onclick="watchlist(\''.$stid.'\',\'1\')" class="btn btn-warning btn-sm btn-with-icon mg-t-10">
                  <div class="ht-30">
                    <span class="icon wd-30"><i class="ion-android-add" style="font-size: 20px;color: #fff;"></i></span>
                    <span class="pd-x-15">Add to Watch List</span>
                  </div>
                </button>';
    }else{
      $watch = '<button onclick="watchlist(\''.$stid.'\',\'2\')" class="btn btn-danger btn-sm btn-with-icon mg-t-10">
                  <div class="ht-30">
                    <span class="icon wd-30"><i class="ion-android-close" style="font-size: 20px;color: #fff;"></i></span>
                    <span class="pd-x-15">Remove from Watch List</span>
                  </div>
                </button>';
    }

    $taskinfo = $this->get_total_student_tasks($stid);
    $statictics = $this->get_student_statistics($stid);

    $info = '<div class="card shadow-base bd-0 overflow-hidden" style="background-color: #07274f;">
              <div class="pd-x-25 pd-t-25">
                <p class="tx-center">
                  <img src="img/avatar/'.$avatar.'" width="100" class="rounded-circle" alt="">
                </p>
                <h6 class="logged-fullname tx-center" style="color: #fff;">'.$qr['username'].'</h6>
                <div class="widget-1">
                  <div class="card-footer">
                    <div>
                      <span class="tx-11">Points</span>
                      <h6 class="tx-white tx-center">'.$this->get_student_points($stid).'</h6>
                    </div>                    
                    <div>
                      <span class="tx-11">Total Solutions</span>
                      <h6 class="tx-white tx-center">'.$taskinfo['solution'].'</h6>
                    </div>
                    <div>
                      <span class="tx-11">Total Tasks</span>
                      <h6 class="tx-white tx-center">'.$taskinfo['total'].'</h6>
                    </div>
                  </div>
                </div>
                <p class="mg-b-0 tx-center" id="watchbut">
                  '.$watch.'
                </p>
                <hr>
                <label class="tx-10 tx-uppercase tx-mont tx-medium tx-spacing-1 mg-b-2">School</label>
                <p class="tx-inverse mg-b-25" style="color: #fff;">'.$qr['school'].'</p>

                <label class="tx-10 tx-uppercase tx-mont tx-medium tx-spacing-1 mg-b-2">Program</label>
                <p class="tx-inverse mg-b-25" style="color: #fff;">'.$qr['program'].'</p>
                <hr>
                <h6 class="tx-gray-800 tx-uppercase tx-semibold tx-13 mg-b-25" style="color: #fff;">Statistics</h6>
                <p class="mg-b-0 tx-14">Speed</p>
                <div class="progress mg-b-20">
                  <div class="progress-bar progress-bar-md wd-'.$statictics['speed'].'p"
                  role="progressbar" aria-valuenow="'.$statictics['speed'].'" aria-valuemin="0" aria-valuemax="100">'.$statictics['speedtxt'].'</div>
                </div>
                <p class="mg-b-0 tx-14">Technicality</p>
                <div class="progress mg-b-20">
                  <div class="progress-bar progress-bar-md wd-'.$statictics['rate'].'p"
                  role="progressbar" aria-valuenow="'.$statictics['rate'].'" aria-valuemin="0" aria-valuemax="100">'.$statictics['ratetxt'].'</div>
                </div>
                <p class="mg-b-0 tx-14">Initiative</p>
                <div class="progress mg-b-20">
                  <div class="progress-bar progress-bar-md wd-'.$statictics['initiative'].'p"
                  role="progressbar" aria-valuenow="'.$statictics['initiative'].'" aria-valuemin="0" aria-valuemax="100">'.$statictics['initiativetxt'].'</div>
                </div>
                <p class="mg-b-0 tx-14">Execution</p>
                <div class="progress mg-b-20">
                  <div class="progress-bar progress-bar-md wd-'.$statictics['execute'].'p"
                  role="progressbar" aria-valuenow="'.$statictics['execute'].'" aria-valuemin="0" aria-valuemax="100">'.$statictics['executetxt'].'</div>
                </div>
              </div>
            </div>';
    
    if ($taskinfo['total'] != 0) {
      $comp = number_format(($taskinfo['solution'] / $taskinfo['total']) * 100);
      if($taskinfo['solution'] == 0){
        $ptext = '';
      }
      else{
        $ptext = $comp.'%';
      }
    }
    else{
      $comp = 0;
      $ptext = '';
    }


    $return = $this->get_student_tasks($stid, $page);
    $data['info'] = $info;
    $data['tasks'] = $return['task'];
    $data['page'] = $return['page'];
    $data['range'] = $return['range'];
    return $data;


  }


  public function get_student_statistics($stid){
		global $link;

		$stid = clean($link, $stid);

			$q = mysqli_query($link, "SELECT COUNT(`sid`) as `solutions`, SUM(`rate`) as `rate`, SUM(`submission`) as `execute`, SUM(`attempt`) as `initiative`, SUM(`speed`) as `speed`
			FROM solution WHERE stid='$stid' AND `status` NOT IN ('0','3') ");
			
			$qr = mysqli_fetch_assoc($q);

			$data['rate']=$data['execute']=$data['initiative']=$data['speed']=0;
			$data['ratetxt']=$data['executetxt']=$data['initiativetxt']=$data['speedtxt']='';
			if($qr['solutions'] == 0){
				return $data;
			}

			$solutions = $qr['solutions'];
			$rateTotal = 5 * $solutions;
			$executeTotal = 1 * $solutions;
			$speedTotal = 3 * $solutions;
			$initiativeTotal = 1 * $solutions;

			$data['rate'] = number_format(($qr['rate'] / $rateTotal) * 100);
			if($data['rate'] != 0){
				$data['ratetxt'] = $data['rate'].'%';
			}

			$data['execute'] = number_format(($qr['execute'] / $executeTotal) * 100);
			if($data['execute'] != 0){
				$data['executetxt'] = $data['execute'].'%';
			}

			$data['initiative'] = number_format(($qr['initiative'] / $initiativeTotal) * 100);
			if($data['initiative'] != 0){
				$data['initiativetxt'] = $data['initiative'].'%';
			}

			$data['speed'] = number_format(($qr['speed'] / $speedTotal) * 100);
			if($data['speed'] != 0){
				$data['speedtxt'] = $data['speed'].'%';
			}

			return $data;
	}


  public function get_total_student_tasks($stid){
    global $link;

    $stid = clean($link, $stid);

		$q = mysqli_query($link, "SELECT `status`, COUNT(sid) as `count` FROM `solution` WHERE stid='$stid' AND `status` != '3' GROUP BY `status` ");
		$data['total']=$data['solution']=0;
    while($qr = mysqli_fetch_array($q, MYSQLI_ASSOC)){
			if($qr['status'] == 1 || $qr['status'] == 2){
				$data['solution'] += $qr['count'];
			}
			$data['total'] += $qr['count'];
		}
		
		return $data;
  }


  public function get_student_points($stid){
		global $link;

		$stid = clean($link, $stid);

		$q = mysqli_query($link, "SELECT SUM(rate+submission+attempt+speed) as points FROM solution WHERE stid='$stid' ");

		$qr = mysqli_fetch_assoc($q);
		if($qr['points'] == 0){
			return '0';
		}
		return $qr['points'];
	}

  
  public function get_student_tasks($stid, $page){
    global $link;

    $stid = clean($link, $stid);
    $page = clean($link, $page);

    $pagegets = '&student='.$stid;

    if(empty($page) == false){
      $checkqx = mysqli_query($link, "SELECT COUNT(*) FROM solution WHERE stid='$stid' AND `status` != '3' "); 
      $pqcount = mysqli_fetch_assoc($checkqx);
      $cknum = $pqcount['COUNT(*)'];
      $pagemax = ceil($cknum/12);
      if($pagemax < $page){
        $page = $pagemax;
      }

      if($page > 1){
        $pagex = (12*$page) - 12;
      }
      else{
        $pagex = 0;
      }
      $qlimit = "LIMIT $pagex,12";
    }
    else{
      $qlimit = "LIMIT 12";
    }

		$q = mysqli_query($link, "SELECT * FROM solution WHERE stid='$stid' AND `status` != '3' ORDER BY `date` DESC $qlimit");
		$qnum = mysqli_num_rows($q);
		if($qnum == 0){
      $data['task'] = '<p class="text-center">No task found</p>';
      $data['page'] = '';
      $data['range'] = '';
      return $data;
		}

		$pagg=$task='';
    $pqx = mysqli_query($link, "SELECT COUNT(*) FROM solution WHERE stid='$stid' AND `status` != '3' ");
    $pqcount = mysqli_fetch_assoc($pqx);
    $pqnum = $pqcount['COUNT(*)'];
    $pqnumx = ceil($pqnum/12);
    $start = 1;
    if($page == 1 || empty($page) == true){
      $page = 1;
    }
    else if($page > 2){
      $start = $page - 2;
      $pagg .= '<li class="page-item">
                  <a class="page-link" href="profile?page='.($page-1).$pagegets.'" aria-label="Previous"><i class="ion ion-arrow-left-a"></i></a>
                </li>';
    }

    for($i=$start;$i<=($start+4);$i++){
        if($i == $page){
            $pagg .= '<li class="page-item active"><a class="page-link" href="profile?page='.$i.$pagegets.'">'.$i.'</a></li>';
        }
        else if($i <= $pqnumx){
            $pagg .= '<li class="page-item"><a class="page-link" href="profile?page='.$i.$pagegets.'">'.$i.'</a></li>';   
        }
    }


    if($pqnumx > 1 && $pqnumx > $page){
      $pagg .= '<li class="pag-prev mg-5">
                  <a style="border: none;" class="page-link" href="profile?page='.($page+1).$pagegets.'" aria-label="Next"><i class="ion ion-arrow-right-a"></i></a>
                </li>';
    }

		while ($qr = mysqli_fetch_array($q, MYSQLI_ASSOC)) {
			$tid = $qr['tid'];
			$tq = mysqli_query($link, "SELECT * FROM task WHERE tid='$tid' ");
			$tqr = mysqli_fetch_assoc($tq);
			$cid = $tqr['cid'];
			$cq = mysqli_query($link, "SELECT cname FROM company WHERE cid='$cid'");
			$cqr = mysqli_fetch_assoc($cq);

			$datepost = strtotime(date("Y-m-d", strtotime($tqr['date'])));
      $tdate = strtotime(date("Y-m-d", time()));
      $datedif = $tdate - $datepost;
      if($datedif < 86400){
          $timepost = 'Today '.date("g:i A",strtotime($tqr['date']));
      }
      else if($datedif >= 86400 && $datedif < 172800){
          $timepost = 'Yesterday '.date("g:i A",strtotime($tqr['date']));
      }
      else if($datedif >= 31104000){
          $timepost = date("jS M, Y",strtotime($tqr['date']));
      }
      else{
          $timepost = date("jS M",strtotime($tqr['date']));
      }

      $rate=$buttonx='';
      if($qr['status'] == '1'){
        $buttonx = '<p class="text-right">'.$rate.'<button class="btn btn-default btn-sm mg-b-10">Solution Submitted</button></p>';
      }else if($qr['status'] == '2'){
        $rate = '<span id="sol_'.$qr['sid'].'" style="font-size:14px; margin-right:10px;">Rated: <b style="font-size:20px;">'.$qr['rate'].'<i class="ion ion-android-star" style="color: #FF9800;"></i></b></span>';
        $buttonx = '<p class="text-right">'.$rate.'<button class="btn btn-default btn-sm mg-b-10">Solution Submitted</button></p>';
      }     

      


      $task .= '<h6 class="card-title">'.$tqr['title'].'</h6>
                  <p class="card-subtitle"><a href="#"><b style="color: #333;">'.$cqr['cname'].'</b></a> - <i style="color: #237ad4;font-size: 12px;">'.$timepost.'</i></p>
                  <p class="card-text">'.$tqr['summary'].'</p>
                  <p class="card-subtitle"><span class="icon ion-ios-list-outline" style="font-size: 20px;"></span> Submitted Solutions: <b style="color: #333;">'.$this->get_task_solutions_total($tid).'</b></p>
                  '.$buttonx.'
                <hr>';

    }
    
    $fromnum = 1;
    $tonum = ($page * 12);
    if($tonum > $pqnum){
      $tonum = $pqnum;
    }
    if($page > 1){
      $fromnum = ($page * 12)-11;
      if($tonum > $pqnum){
        $tonum = $pqnum;
      }
    }

		$data['task'] = $task;
    $data['page'] = '<div class="ht-80 d-flex align-items-center justify-content-center">
                      <nav aria-label="Page navigation">
                        <ul class="pagination pagination-basic pagination-circle mg-b-0">
                          '.$pagg.'
                        </ul>
                      </nav>
                    </div>';
    $data['range'] = '<p class="text-center mg-b-0">Showing <span>'.$fromnum.'</span> to <span>'.$tonum.'</span> of <span>'.$pqnum.'</span> Tasks</p>';

    return $data;
  }


  public function get_task_solutions_total($task){
		global $link;
		$q = mysqli_query($link, "SELECT `sid` FROM solution WHERE tid='$task' AND `status` NOT IN ('0','3') ");
		return mysqli_num_rows($q);
	}


  public function get_tasks($apid, $search, $pagex){
    global $link;

    $apid = clean($link, $apid);
    $st = $this->get_user_type($apid);
    if($st['user_type'] != 'c'){
      $data['info'] = '<p class="text-center">Sorry, you do not have the privilege to access this information</p>';
      $data['page'] = '';
      $data['range'] = '<p class="text-center mg-b-0">Showing <span>0</span> to <span>0</span> of <span>0</span> Tasks</p>';
      return $data;
    }
    $cid = $st['userid'];

    $search = clean($link, $search);
    $page = clean($link, $pagex);

    $parameter = '';
    $pagegets = '';
    if(!empty($search) == true){
      $parameter = "AND title LIKE '%$search%'";
      $pagegets = '&q='.$search;
    }

    if(empty($page) == false){
      $checkqx = mysqli_query($link, "SELECT COUNT(*) FROM task WHERE cid='$cid' AND delete_task='0' $parameter"); 
      $pqcount = mysqli_fetch_assoc($checkqx);
      $cknum = $pqcount['COUNT(*)'];
      $pagemax = ceil($cknum/12);
      if($pagemax < $page){
        $page = $pagemax;
      }

      if($page > 1){
        $pagex = (12*$page) - 12;
      }
      else{
        $pagex = 0;
      }
      $qlimit = "LIMIT $pagex,12";
    }
    else{
      $qlimit = "LIMIT 12";
    }

    $q = mysqli_query($link, "SELECT * FROM task WHERE cid='$cid' AND delete_task='0' $parameter ORDER BY `date` DESC $qlimit");
    $qnum = mysqli_num_rows($q);
    if($qnum == 0){
      $data['info'] = '<p class="text-center">No tasks found</p>';
      $data['page'] = '';
      $data['range'] = '<p class="text-center mg-b-0">Showing <span>0</span> to <span>0</span> of <span>0</span> Tasks</p>';
      return $data;
    }

    $pagg=$task='';
    $pqx = mysqli_query($link, "SELECT COUNT(*) FROM task WHERE cid='$cid' AND delete_task='0' $parameter ");
    $pqcount = mysqli_fetch_assoc($pqx);
    $pqnum = $pqcount['COUNT(*)'];
    $pqnumx = ceil($pqnum/12);
    $start = 1;
    if($page == 1 || empty($page) == true){
      $page = 1;
    }
    else if($page > 2){
      $start = $page - 2;
      $pagg .= '<li class="page-item">
                  <a class="page-link" href="ctask?page='.($page-1).$pagegets.'" aria-label="Previous"><i class="ion ion-arrow-left-a"></i></a>
                </li>';
    }

    for($i=$start;$i<=($start+4);$i++){
        if($i == $page){
            $pagg .= '<li class="page-item active"><a class="page-link" href="ctask?page='.$i.$pagegets.'">'.$i.'</a></li>';
        }
        else if($i <= $pqnumx){
            $pagg .= '<li class="page-item"><a class="page-link" href="ctask?page='.$i.$pagegets.'">'.$i.'</a></li>';   
        }
    }


    if($pqnumx > 1 && $pqnumx > $page){
      $pagg .= '<li class="pag-prev mg-5">
                  <a style="border:none;" class="page-link" href="ctask?page='.($page+1).$pagegets.'" aria-label="Next"><i class="ion ion-arrow-right-a"></i></a>
                </li>';
    }
    while ($qr = mysqli_fetch_array($q, MYSQLI_ASSOC)) {
      $tid = $qr['tid'];
      $tq = mysqli_query($link, "SELECT COUNT(sid) as sid,status FROM  solution WHERE tid='$tid' GROUP BY status ");
      $newtask=$viewedtask=0;
      while ($tqr = mysqli_fetch_array($tq, MYSQLI_ASSOC)) {
        if($tqr['status'] == 1){
          $newtask = $tqr['sid'];
        }
        
        if($tqr['status'] == 2){
          $viewedtask = $tqr['sid'];
        }
      }
      $tx = $newtask+$viewedtask;
      $total = '';
      if($tx > 0){
        $total = '<p class="card-text" style="color: #ff9800;">'.$newtask.'/'.$tx.' solutions</p>';
      }
      

      $datepost = strtotime(date("Y-m-d", strtotime($qr['date'])));
      $tdate = strtotime(date("Y-m-d", time()));
      $datedif = $tdate - $datepost;
      if($datedif < 86400){
          $timepost = 'Today '.date("g:i A",strtotime($qr['date']));
      }
      else if($datedif >= 86400 && $datedif < 172800){
          $timepost = 'Yesterday '.date("g:i A",strtotime($qr['date']));
      }
      else if($datedif >= 31104000){
          $timepost = date("jS M, Y",strtotime($qr['date']));
      }
      else{
          $timepost = date("jS M",strtotime($qr['date']));
      }

      $task .= '<h6 class="card-title">'.$qr['title'].'</h6>
                <p class="card-text">'.$qr['summary'].' - <i style="color:#2196f3;">'.$timepost.'</i></p>
                '.$total.'
                <p class="text-right"><a href="ctask?t='.$tid.'"><button class="btn btn-primary mg-b-10">View</button></a></p>
                <hr>';
    }

    $fromnum = 1;
    $tonum = ($page * 12);
    if($tonum > $pqnum){
      $tonum = $pqnum;
    }
    if($page > 1){
      $fromnum = ($page * 12)-11;
      if($tonum > $pqnum){
        $tonum = $pqnum;
      }
    }

    $data['info'] = $task;
    $data['page'] = '<div class="ht-80 d-flex align-items-center justify-content-center">
                      <nav aria-label="Page navigation">
                        <ul class="pagination pagination-basic pagination-circle mg-b-0">
                          '.$pagg.'
                        </ul>
                      </nav>
                    </div>';
    $data['range'] = '<p class="text-center mg-b-0">Showing <span>'.$fromnum.'</span> to <span>'.$tonum.'</span> of <span>'.$pqnum.'</span> Tasks</p>';

    return $data;
  }


  public function get_internships($apid, $search, $pagex){
    global $link;

    $apid = clean($link, $apid);
    $st = $this->get_user_type($apid);
    if($st['user_type'] != 'c'){
      $data['info'] = '<p class="text-center">Sorry, you do not have the privilege to access this information</p>';
      $data['page'] = '';
      $data['range'] = '';
      return $data;
    }
    $cid = $st['userid'];
    $uq = mysqli_query($link, "UPDATE `notification` SET seen='1' WHERE apid='$apid' AND ntype='i' ");

    $search = clean($link, $search);
    $page = clean($link, $pagex);

    $parameter = '';
    $pagegets = '';
    if(!empty($search) == true){
      $parameter = "AND title LIKE '%$search%'";
      $pagegets = '&q='.$search;
    }

    if(empty($page) == false){
      $checkqx = mysqli_query($link, "SELECT COUNT(*) FROM internship WHERE cid='$cid' $parameter"); 
      $pqcount = mysqli_fetch_assoc($checkqx);
      $cknum = $pqcount['COUNT(*)'];
      $pagemax = ceil($cknum/12);
      if($pagemax < $page){
        $page = $pagemax;
      }

      if($page > 1){
        $pagex = (12*$page) - 12;
      }
      else{
        $pagex = 0;
      }
      $qlimit = "LIMIT $pagex,12";
    }
    else{
      $qlimit = "LIMIT 12";
    }

    $q = mysqli_query($link, "SELECT * FROM internship WHERE cid='$cid' $parameter ORDER BY `created` DESC $qlimit");
    $qnum = mysqli_num_rows($q);
    if($qnum == 0){
      $data['info'] = '<p class="text-center">No internship found</p>';
      $data['page'] = '';
      $data['range'] = '';
      return $data;
    }

    $pagg=$intern='';
    $pqx = mysqli_query($link, "SELECT COUNT(*) FROM internship WHERE cid='$cid' $parameter ");
    $pqcount = mysqli_fetch_assoc($pqx);
    $pqnum = $pqcount['COUNT(*)'];
    $pqnumx = ceil($pqnum/12);
    $start = 1;
    if($page == 1 || empty($page) == true){
      $page = 1;
    }
    else if($page > 2){
      $start = $page - 2;
      $pagg .= '<li class="page-item">
                  <a class="page-link" href="internship?page='.($page-1).$pagegets.'" aria-label="Previous"><i class="ion ion-arrow-left-a"></i></a>
                </li>';
    }

    for($i=$start;$i<=($start+4);$i++){
        if($i == $page){
            $pagg .= '<li class="page-item active"><a class="page-link" href="internship?page='.$i.$pagegets.'">'.$i.'</a></li>';
        }
        else if($i <= $pqnumx){
            $pagg .= '<li class="page-item"><a class="page-link" href="internship?page='.$i.$pagegets.'">'.$i.'</a></li>';   
        }
    }


    if($pqnumx > 1 && $pqnumx > $page){
      $pagg .= '<li class="pag-prev mg-5">
                  <a style="border:none;" class="page-link" href="internship?page='.($page+1).$pagegets.'" aria-label="Next"><i class="ion ion-arrow-right-a"></i></a>
                </li>';
    }
    while ($qr = mysqli_fetch_array($q, MYSQLI_ASSOC)) {
      $inid = $qr['inid'];
      $tq = mysqli_query($link, "SELECT COUNT(aplid) as aplid,accepted FROM applicants WHERE inid='$inid' GROUP BY accepted ");
      $accepted=$other=0;
      while ($tqr = mysqli_fetch_array($tq, MYSQLI_ASSOC)) {
        if($tqr['accepted'] == 1){
          $accepted = $tqr['aplid'];
        }
        
        if($tqr['accepted'] == 0){
          $other = $tqr['aplid'];
        }
      }
      $tx = $accepted+$other;
      $total = '';
      if($tx > 0){
        $total = '<p class="card-text" style="color: #ff9800;"><b>'.$accepted.'</b>/'.$tx.' applicants</p>';
      }
      

      $datepost = strtotime(date("Y-m-d", strtotime($qr['created'])));
      $tdate = strtotime(date("Y-m-d", time()));
      $datedif = $tdate - $datepost;
      if($datedif < 86400){
          $timepost = 'Today '.date("g:i A",strtotime($qr['created']));
      }
      else if($datedif >= 86400 && $datedif < 172800){
          $timepost = 'Yesterday '.date("g:i A",strtotime($qr['created']));
      }
      else if($datedif >= 31104000){
          $timepost = date("jS M, Y",strtotime($qr['created']));
      }
      else{
          $timepost = date("jS M",strtotime($qr['created']));
      }

      $intern .= '<h6 class="card-title">'.$qr['title'].'</h6>
                <p class="card-text">'.$qr['description'].' - <i style="color:#2196f3;">'.$timepost.'</i></p>
                <p class="card-text">Starts: <b class="tx-success">'.date("jS M Y", strtotime($qr['starts'])).'</b> - Ends: <b class="tx-danger">'.date("jS M Y", strtotime($qr['ends'])).'</b></b></p>
                '.$total.'
                <p class="text-right"><a href="internship?i='.$inid.'"><button class="btn btn-primary mg-b-10">View</button></a></p>
                <hr>';
    }

    $fromnum = 1;
    $tonum = ($page * 12);
    if($tonum > $pqnum){
      $tonum = $pqnum;
    }
    if($page > 1){
      $fromnum = ($page * 12)-11;
      if($tonum > $pqnum){
        $tonum = $pqnum;
      }
    }

    $data['info'] = $intern;
    $data['page'] = '<div class="ht-80 d-flex align-items-center justify-content-center">
                      <nav aria-label="Page navigation">
                        <ul class="pagination pagination-basic pagination-circle mg-b-0">
                          '.$pagg.'
                        </ul>
                      </nav>
                    </div>';
    $data['range'] = '<p class="text-center mg-b-0">Showing <span>'.$fromnum.'</span> to <span>'.$tonum.'</span> of <span>'.$pqnum.'</span> Internships</p>';

    return $data;
  }


  public function get_task_info($apid, $task){
    global $link;

    $tid =  clean($link, $task);
    $apid =  clean($link, $apid);
    $uc = $this->get_user_type($apid);
    if($uc['user_type'] != 'c'){
      return 'You do not have the privilege to perform this action';
    }
    $cid = $uc['userid'];

    $cq = mysqli_query($link, "SELECT * FROM task WHERE cid='$cid' AND tid='$tid' ");
    $cqnum = mysqli_num_rows($cq);
    if($cqnum == 0){
      return 'Task Solutions';
    }

    $qr = mysqli_fetch_assoc($cq);
    $title = $qr['title'];
    $summary = $qr['summary'];
    $days = $qr['days'];
    $date = date("jS M Y, h:i a", strtotime(($qr['date'])));

    $head = '<p class="mg-b-0"><b>'.$title.'</b></p>
            <p class="mg-b-0">'.$summary.' - <i style="color:#2196f3;">'.$date.'</i></p>
            <p class="card-subtitle"><span class="icon ion-ios-list-outline" style="font-size: 20px;"></span> Submitted Solutions: <b style="color: #333;">'.$this->get_task_solutions_count($task).'</b></p>
            <p class="mg-b-0 text-right"><a href="docs/'.$qr['file'].'" download><button class="btn btn-info btn-sm mg-b-10">Download Document</button></a></p>';
    return $head;
  }


  public function get_internship_info($apid, $intern){
    global $link;

    $intern =  clean($link, $intern);
    $apid =  clean($link, $apid);
    $uc = $this->get_user_type($apid);
    if($uc['user_type'] != 'c'){
      return 'You do not have the privilege to perform this action';
    }
    $cid = $uc['userid'];

    $cq = mysqli_query($link, "SELECT * FROM internship WHERE cid='$cid' AND inid='$intern' ");
    $cqnum = mysqli_num_rows($cq);
    if($cqnum == 0){
      return 'Internship Information';
    }

    $qr = mysqli_fetch_assoc($cq);
    $title = $qr['title'];
    $description = $qr['description'];
    $date = date("jS M Y, h:i a", strtotime(($qr['created'])));

    $head = '<p class="mg-b-0"><b>'.$title.'</b></p>
            <p class="mg-b-0">'.$description.' - <i style="color:#2196f3;">'.$date.'</i></p>
            <p class="card-text">Starts: <b class="tx-success">'.date("jS M Y, h:i a", strtotime($qr['starts'])).'</b> - Ends: <b class="tx-danger">'.date("jS M Y, h:i a", strtotime($qr['ends'])).'</b></b></p>';
    return $head;
  }


  public function get_task_solutions_count($task){
    global $link;
    $q = mysqli_query($link, "SELECT sid FROM solution WHERE tid='$task' AND `status` NOT IN ('0','3') ");
    return mysqli_num_rows($q);
  }



  public function rate_solution($userid, $solution, $rate){
    global $link;

    $sid =  clean($link, $solution);
    $rate =  clean($link, $rate);
    $userid =  clean($link, $userid);

    $cq = mysqli_query($link, "SELECT `sid`,`stid` FROM solution WHERE sid='$sid' AND tid IN (SELECT tid FROM company WHERE cid='$userid') ");
    $cqnum = mysqli_num_rows($cq);
    if($cqnum == 0){
      return 'Invalid solution information';
    }
    $cqr = mysqli_fetch_assoc($cq);
    $stid = $cqr['stid'];
    $q = mysqli_query($link, "UPDATE solution SET rate='$rate', status='2' WHERE sid='$sid' ");
    if($q){
      $sq = mysqli_query($link, "SELECT apid,email,firebase FROM appusers WHERE userid='$stid' AND user_type='s'");
      $sqnum = mysqli_num_rows($sq);
      $ut = new Utility();
      if($sqnum > 0){   
        $timenow = date("Y-m-d H:i:s", time());   
        $sqr = mysqli_fetch_assoc($sq);
        $user = $sqr['apid'];
        $cq = mysqli_query($link, "SELECT cname FROM company WHERE cid='$userid'");
        $cqr = mysqli_fetch_assoc($cq);
        $note = '<b>'.$cqr['cname'].'</b> have rated your solution.';
        $inq = mysqli_query($link, "INSERT INTO `notification`(`apid`,`ntype`,`note_id`,`note`,`date`) VALUES('$user', 'i', '$tid', '$note', '$timenow') ");      
      
        $email = $sqr['email'];
        $message = nl2br($note);
        $this->send_email($email, "Solution Rated!", $message);

        if(!empty($sqr['firebase'])){
          $token = $sqr['firebase'];
          $note['title'] = 'Solution Rated!';    
          $note['body'] = $cqr['cname'].' have rated your solution.';
          $note['click_action'] = 'MAIN_ACTIVITY';
          $note['android_channel_id'] = 'rook_task';
          $data['type'] = "task";
          $ut->send_firebase_notification($token, $note, $data);
        }
      }
      return 'done';
    }

    return 'Error rating solution';
  }


  public function get_task_solutions($apid, $task, $search, $pagex){
    global $link;

    $tid =  clean($link, $task);
    $apid =  clean($link, $apid);
    $uc = $this->get_user_type($apid);
    if($uc['user_type'] != 'c'){
      $data['info'] = 'You do not have the privilege to perform this action';
      $data['page'] = '';
      $data['range'] = '';
      return $data;
    }
    $cid = $uc['userid'];

    $noteid = 'st='.$search.'&t='.$tid;

		$uq = mysqli_query($link, "UPDATE `notification` SET seen='1' WHERE apid='$apid' AND ntype='t' AND note_id='$noteid' ");


    $cq = mysqli_query($link, "SELECT tid FROM task WHERE cid='$cid' AND tid='$tid' ");
    $cqnum = mysqli_num_rows($cq);
    if($cqnum == 0){
      $data['info'] = '<p class="text-center">Invalid task information</p>
                        <p class="text-center"><a href="ctask"><button class="btn btn-primary mg-b-10">Go Back</button></a></p>';
      $data['page'] = '';
      $data['range'] = '';
      return $data;
    }

    $search = clean($link, $search);
    $page = clean($link, $pagex);

    $parameter = '';
    $pagegets = '';
    if(!empty($search) == true){
      $parameter = "AND stid IN (SELECT stid FROM students WHERE username LIKE '%$search%')";
      $pagegets = '&t='.$tid.'&st='.$search;
    }
    else{
      $pagegets = '&t='.$tid;
    }

    if(empty($page) == false){
      $checkqx = mysqli_query($link, "SELECT COUNT(*) FROM solution WHERE tid='$tid' AND `status` NOT IN ('0','3') $parameter"); 
      $pqcount = mysqli_fetch_assoc($checkqx);
      $cknum = $pqcount['COUNT(*)'];
      $pagemax = ceil($cknum/12);
      if($pagemax < $page){
        $page = $pagemax;
      }

      if($page > 1){
        $pagex = (12*$page) - 12;
      }
      else{
        $pagex = 0;
      }
      $qlimit = "LIMIT $pagex,12";
    }
    else{
      $qlimit = "LIMIT 12";
    }



    $q = mysqli_query($link, "SELECT * FROM `solution` WHERE tid='$tid' AND `status` NOT IN ('0','3') $parameter ORDER BY `date` DESC $qlimit");
    $qnum = mysqli_num_rows($q);
    if($qnum == 0){
      $data['info'] = '<p class="text-center">No Task Solution found</p>
              <p class="text-center"><a href="ctask"><button class="btn btn-primary mg-b-10">Go Back</button></a></p>';
      $data['page'] = '';
      $data['range'] = '<p class="text-center mg-b-0">Showing <span>0</span> to <span>0</span> of <span>0</span> Companies</p>';
      return $data;
    }

    $pagg=$sol='';
    $pqx = mysqli_query($link, "SELECT COUNT(*) FROM solution WHERE tid='$tid' AND `status` NOT IN ('0','3') $parameter ");
    $pqcount = mysqli_fetch_assoc($pqx);
    $pqnum = $pqcount['COUNT(*)'];
    $pqnumx = ceil($pqnum/12);
    $start = 1;
    if($page == 1 || empty($page) == true){
      $page = 1;
    }
    else if($page > 2){
      $start = $page - 2;
      $pagg .= '<li class="page-item">
                  <a class="page-link" href="ctask?page='.($page-1).$pagegets.'" aria-label="Previous"><i class="ion ion-arrow-left-a"></i></a>
                </li>';
    }

    for($i=$start;$i<=($start+4);$i++){
        if($i == $page){
            $pagg .= '<li class="page-item active"><a class="page-link" href="ctask?page='.$i.$pagegets.'">'.$i.'</a></li>';
        }
        else if($i <= $pqnumx){
            $pagg .= '<li class="page-item"><a class="page-link" href="ctask?page='.$i.$pagegets.'">'.$i.'</a></li>';   
        }
    }


    if($pqnumx > 1 && $pqnumx > $page){
      $pagg .= '<li class=" mg-5">
                  <a style="border:none;" class="page-link" href="ctask?page='.($page+1).$pagegets.'" aria-label="Next"><i class="ion ion-arrow-right-a"></i></a>
                </li>';
    }
    while ($qr = mysqli_fetch_array($q, MYSQLI_ASSOC)) {
      $tid = $qr['tid'];
      $tq = mysqli_query($link, "SELECT title FROM task WHERE tid='$tid' ");
      $tqr = mysqli_fetch_assoc($tq);

      $stid = $qr['stid'];
      $stq = mysqli_query($link, "SELECT username FROM students WHERE stid='$stid'");
      $stqr = mysqli_fetch_assoc($stq);

      $datepost = strtotime(date("Y-m-d", strtotime($qr['send_date'])));
      $tdate = strtotime(date("Y-m-d", time()));
      $datedif = $tdate - $datepost;
      if($datedif < 86400){
          $timepost = 'Today '.date("g:i A",strtotime($qr['send_date']));
      }
      else if($datedif >= 86400 && $datedif < 172800){
          $timepost = 'Yesterday '.date("g:i A",strtotime($qr['send_date']));
      }
      else if($datedif >= 31104000){
          $timepost = date("jS M, Y",strtotime($qr['send_date']));
      }
      else{
          $timepost = date("jS M",strtotime($qr['send_date']));
      }


      
      $rete='';
      if($qr['status'] == '1'){
        $rate = '<span id="sol_'.$qr['sid'].'" style="font-size:14px; margin-right:10px;"><button onclick="ratessolution(\''.$qr['sid'].'\')" class="btn btn-warning btn-sm mg-b-10"><span class="ion ion-android-star-outline" style="color: #fff;"></span> Rate Solution</button></span>';
      }else if($qr['status'] == '2'){
        $rate = '<span id="sol_'.$qr['sid'].'" style="font-size:14px; margin-right:10px;">Rated: <b style="font-size:20px;">'.$qr['rate'].'<i class="ion ion-android-star" style="color: #FF9800;"></i></b></span>';
      }     

      $buttonx = '<p class="text-right">'.$rate.'<a href="docs/solutions/'.$qr['file'].'" download><button class="btn btn-default btn-sm mg-b-10">Download Solution</button></a></p>';

      $sol .= '<h6 class="card-title">'.$tqr['title'].'</h6>
                <p class="card-text mg-b-5" style="color:#212529;cursor:pointer;">'.$qr['summary'].'</p>
                <p class="card-subtitle" style="font-size:13px;"><a href="profile?student='.$stid.'"><b>'.$stqr['username'].'</b></a> - '.$timepost.'</p>
                '.$buttonx.'
                <hr>';
    }
    $fromnum = 1;
    $tonum = ($page * 12);
    if($tonum > $pqnum){
      $tonum = $pqnum;
    }
    if($page > 1){
      $fromnum = ($page * 12)-11;
      if($tonum > $pqnum){
        $tonum = $pqnum;
      }
    }

    $data['info'] = $sol;
    $data['page'] = '<div class="ht-80 d-flex align-items-center justify-content-center">
                      <nav aria-label="Page navigation">
                        <ul class="pagination pagination-basic pagination-circle mg-b-0">
                          '.$pagg.'
                        </ul>
                      </nav>
                    </div>';
    $data['range'] = '<p class="text-center mg-b-0">Showing <span>'.$fromnum.'</span> to <span>'.$tonum.'</span> of <span>'.$pqnum.'</span> Solutions</p>';

    return $data;

  }



  public function get_internship_applicants($apid, $intern, $search, $pagex){
    global $link;

    $inid =  clean($link, $intern);
    $apid =  clean($link, $apid);
    $uc = $this->get_user_type($apid);
    if($uc['user_type'] != 'c'){
      $data['info'] = 'You do not have the privilege to perform this action';
      $data['page'] = '';
      $data['range'] = '';
      return $data;
    }
    $cid = $uc['userid'];
    $uq = mysqli_query($link, "UPDATE `notification` SET seen='1' WHERE apid='$apid' AND ntype='i' ");

    $cq = mysqli_query($link, "SELECT inid FROM internship WHERE cid='$cid' AND inid='$inid' ");
    $cqnum = mysqli_num_rows($cq);
    if($cqnum == 0){
      $data['info'] = '<p class="text-center">Invalid internship information</p>
                        <p class="text-center"><a href="internship"><button class="btn btn-primary mg-b-10">Go Back</button></a></p>';
      $data['page'] = '';
      $data['range'] = '';
      return $data;
    }

    $search = clean($link, $search);
    $page = clean($link, $pagex);

    $parameter = '';
    $pagegets = '';
    if(!empty($search) == true){
      $parameter = "AND stid IN (SELECT stid FROM students WHERE username LIKE '%$search%')";
      $pagegets = '&i='.$inid.'&st='.$search;
    }
    else{
      $pagegets = '&i='.$inid;
    }

    if(empty($page) == false){
      $checkqx = mysqli_query($link, "SELECT COUNT(*) FROM applicants WHERE inid='$inid' $parameter"); 
      $pqcount = mysqli_fetch_assoc($checkqx);
      $cknum = $pqcount['COUNT(*)'];
      $pagemax = ceil($cknum/12);
      if($pagemax < $page){
        $page = $pagemax;
      }

      if($page > 1){
        $pagex = (12*$page) - 12;
      }
      else{
        $pagex = 0;
      }
      $qlimit = "LIMIT $pagex,12";
    }
    else{
      $qlimit = "LIMIT 12";
    }



    $q = mysqli_query($link, "SELECT * FROM `applicants` WHERE inid='$inid' $parameter ORDER BY `date` DESC $qlimit");
    $qnum = mysqli_num_rows($q);
    if($qnum == 0){
      $data['info'] = '<p class="text-center">No Applicants found</p>
              <p class="text-center"><a href="internship"><button class="btn btn-primary mg-b-10">Go Back</button></a></p>';
      $data['page'] = '';
      $data['range'] = '';
      return $data;
    }

    $pagg=$sol='';
    $pqx = mysqli_query($link, "SELECT COUNT(*) FROM applicants WHERE inid='$inid' $parameter ");
    $pqcount = mysqli_fetch_assoc($pqx);
    $pqnum = $pqcount['COUNT(*)'];
    $pqnumx = ceil($pqnum/12);
    $start = 1;
    if($page == 1 || empty($page) == true){
      $page = 1;
    }
    else if($page > 2){
      $start = $page - 2;
      $pagg .= '<li class="page-item">
                  <a class="page-link" href="internship?page='.($page-1).$pagegets.'" aria-label="Previous"><i class="ion ion-arrow-left-a"></i></a>
                </li>';
    }

    for($i=$start;$i<=($start+4);$i++){
        if($i == $page){
            $pagg .= '<li class="page-item active"><a class="page-link" href="internship?page='.$i.$pagegets.'">'.$i.'</a></li>';
        }
        else if($i <= $pqnumx){
            $pagg .= '<li class="page-item"><a class="page-link" href="internship?page='.$i.$pagegets.'">'.$i.'</a></li>';   
        }
    }


    if($pqnumx > 1 && $pqnumx > $page){
      $pagg .= '<li class=" mg-5">
                  <a style="border:none;" class="page-link" href="internship?page='.($page+1).$pagegets.'" aria-label="Next"><i class="ion ion-arrow-right-a"></i></a>
                </li>';
    }
    while ($qr = mysqli_fetch_array($q, MYSQLI_ASSOC)) {

      $stid = $qr['stid'];
      $stq = mysqli_query($link, "SELECT username FROM students WHERE stid='$stid'");
      $stqr = mysqli_fetch_assoc($stq);

      $datepost = strtotime(date("Y-m-d", strtotime($qr['date'])));
      $tdate = strtotime(date("Y-m-d", time()));
      $datedif = $tdate - $datepost;
      if($datedif < 86400){
          $timepost = 'Today '.date("g:i A",strtotime($qr['date']));
      }
      else if($datedif >= 86400 && $datedif < 172800){
          $timepost = 'Yesterday '.date("g:i A",strtotime($qr['date']));
      }
      else if($datedif >= 31104000){
          $timepost = date("jS M, Y",strtotime($qr['date']));
      }
      else{
          $timepost = date("jS M",strtotime($qr['date']));
      }


      
      if($qr['accepted'] == '1'){
        $rate = '<span id="sol_'.$qr['aplid'].'" style="font-size:14px; margin-right:10px;"><span class="btn btn-warning btn-sm mg-b-10">Accepted</span></span>';
      }else if($qr['accepted'] == '0'){
        $rate = '<span id="sol_'.$qr['aplid'].'" style="font-size:14px; margin-right:10px;"><button onclick="viewapplicant(\''.$qr['aplid'].'\')" class="btn btn-primary btn-sm mg-b-10">View</button></span>';
      }     

      $buttonx = '<p class="text-right">'.$rate.'</p>';

      $sol .= '<h6 class="card-title mg-b-0">'.$stqr['username'].'</h6>
                <p class="tx-13 mg-b-5">Points: '.$this->get_student_points($stid).'</p>                
                '.$buttonx.'
                <hr>';
    }
    $fromnum = 1;
    $tonum = ($page * 12);
    if($tonum > $pqnum){
      $tonum = $pqnum;
    }
    if($page > 1){
      $fromnum = ($page * 12)-11;
      if($tonum > $pqnum){
        $tonum = $pqnum;
      }
    }

    $data['info'] = $sol;
    $data['page'] = '<div class="ht-80 d-flex align-items-center justify-content-center">
                      <nav aria-label="Page navigation">
                        <ul class="pagination pagination-basic pagination-circle mg-b-0">
                          '.$pagg.'
                        </ul>
                      </nav>
                    </div>';
    $data['range'] = '<p class="text-center mg-b-0">Showing <span>'.$fromnum.'</span> to <span>'.$tonum.'</span> of <span>'.$pqnum.'</span> Applicants</p>';

    return $data;

  }



  public function get_solution($apid){
    global $link;

    $apid =  clean($link, $apid);
    $uc = $this->get_user_type($apid);
    if($uc['user_type'] != 'c'){
      return 'You do not have the privilege to perform this action';
    }

    $cid = $uc['userid'];

    $q = mysqli_query($link, "SELECT * FROM `solution` WHERE tid IN (SELECT tid FROM `task` WHERE cid='$cid') AND status='1' ");
    $qnum = mysqli_num_rows($q);
    if($qnum == 0){
      return '<p class="text-center">No Task Solution found</p>
              <p class="text-center"><button onclick="add()" class="btn btn-primary mg-b-10">Create a Tasks</button></p>';
    }

    $sol = '';
    while ($qr = mysqli_fetch_array($q, MYSQLI_ASSOC)) {
      $tid = $qr['tid'];
      $tq = mysqli_query($link, "SELECT title FROM task WHERE tid='$tid' ");
      $tqr = mysqli_fetch_assoc($tq);

      $stid = $qr['stid'];
      $stq = mysqli_query($link, "SELECT username FROM students WHERE stid='$stid'");
      $stqr = mysqli_fetch_assoc($stq);

      $datepost = strtotime(date("Y-m-d", strtotime($qr['send_date'])));
      $tdate = strtotime(date("Y-m-d", time()));
      $datedif = $tdate - $datepost;
      if($datedif < 86400){
          $timepost = 'Today '.date("g:i A",strtotime($qr['send_date']));
      }
      else if($datedif >= 86400 && $datedif < 172800){
          $timepost = 'Yesterday '.date("g:i A",strtotime($qr['send_date']));
      }
      else if($datedif >= 31104000){
          $timepost = date("jS M, Y",strtotime($qr['send_date']));
      }
      else{
          $timepost = date("jS M",strtotime($qr['send_date']));
      }

      if($qr['status'] == '1'){
        $rate = '<span id="sol_'.$qr['sid'].'" style="font-size:14px; margin-right:10px;"><button onclick="ratessolution(\''.$qr['sid'].'\')" class="btn btn-warning btn-sm mg-b-10"><span class="ion ion-android-star-outline" style="color: #fff;"></span> Rate Solution</button></span>';
      }else if($qr['status'] == '2'){
        $rate = '<span id="sol_'.$qr['sid'].'" style="font-size:14px; margin-right:10px;">Rated: <b style="font-size:20px;">'.$qr['rate'].'<i class="ion ion-android-star" style="color: #FF9800;"></i></b></span>';
      }   

      $buttonx = '<p class="text-right">'.$rate.'<a href="docs/solutions/'.$qr['file'].'" download><button class="btn btn-default btn-sm mg-b-10">Download Solution</button></a></p>';

      $sol .= '<h6 class="card-title">'.$tqr['title'].'</h6>
                <p class="card-text mg-b-5" style="color:#212529;cursor:pointer;">'.$qr['summary'].'</p>
                <p class="card-subtitle mg-b-0" style="font-size:13px;"><b>'.$stqr['username'].'</b> - '.$timepost.'</p>
                '.$buttonx.'
                <hr>';
    }
    return $sol;

  }


  public function create_task($apid, $title, $summary, $days, $file, $file_temp){
    global $link;

    $apid = clean($link, $apid);
    $st = $this->get_user_type($apid);
    if($st['user_type'] != 'c'){
      return 'Sorry, you do not have the privilege to perform this action';
    }
    $cid = $st['userid'];
    $title = clean($link, $title);
    $summary = clean($link, $summary);
    $days = clean($link, $days);


    $cq = mysqli_query($link, "SELECT tid FROM task WHERE title='$title' AND summary='$summary' AND days='$days' AND cid='$cid' ");
    $cqnum = mysqli_num_rows($cq);
    if($cqnum > 0){
      return 'Task already exists';
    }

    $timenow = date("Y-m-d H:i:s", time());
    $file = $this->uploadfile($file,$file_temp);
    if($file != '0'){
      $inq = mysqli_query($link, "INSERT INTO task(`cid`,`title`,`summary`,`file`,`days`,`date`) VALUES('$cid', '$title', '$summary', '$file', '$days', '$timenow')");
      if($inq){
        $tid = 'company='.$cid;
        $sq = mysqli_query($link, "SELECT apid,email,firebase FROM appusers WHERE userid IN (SELECT stid FROM subscribe WHERE cid='$cid') AND user_type='s'");
        $sqnum = mysqli_num_rows($sq);
        if($sqnum > 0){      
          $ut = new Utility();
          $tokens = array();
          while($sqr = mysqli_fetch_array($sq, MYSQLI_ASSOC)){
            $user = $sqr['apid'];
            $cq = mysqli_query($link, "SELECT cname FROM company WHERE cid='$cid'");
            $cqr = mysqli_fetch_assoc($cq);
            $note = '<b>'.$cqr['cname'].'</b> uploaded a new task.';
            $inq = mysqli_query($link, "INSERT INTO `notification`(`apid`,`ntype`,`note_id`,`note`,`date`) VALUES('$user', 't', '$tid', '$note', '$timenow') ");
            
            if(!empty($sqr['firebase'])){
              array_push($tokens, $sqr['firebase']);
              $title = $cqr['cname'].' uploaded a new task';    
              $body = nl2br($summary);          
            }
            

            $email = $sqr['email'];
            $message = $note.'<br><p><b>'.$title.'</b></p><br><p>'.nl2br($summary).'</p>';
            $this->send_email($email, "New Task", $message);
          }

          if(!empty($tokens)){
            $note['title'] = $title;    
            $note['body'] = $body;
            $note['click_action'] = 'MAIN_ACTIVITY';
            $note['android_channel_id'] = 'rook_task';
            $data['type'] = "task";
            $ut->send_mass_firebase_notification($tokens, $note, $data);
          }
         
        }
        
        return 1;
      }
      return 'Error creating Task...try again';
    }
    return 'Error uploading Task Document';
  }


  public function email_validate($email){
    global $link;

    $email = clean($link, $email);
    $q = mysqli_query($link, "SELECT apid FROM appusers WHERE email='$email' ");

    return  mysqli_num_rows($q);
  }


  public function uploadfile($filename,$filetmp){

      $allow = array('txt','doc','docx','pdf');
      $bits = explode('.',$filename);
      $file_extn = strtolower(end($bits));
      $filenamex = 'rookTask'.substr(md5(time().rand(10000,99999)), 0, 15).'.'.$file_extn;
      $fullpath = 'docs/'.$filenamex;
          $move = move_uploaded_file($filetmp ,$fullpath) ;
          if(!$move){
              return '0';
          }
          return $filenamex;
  }


  public function sendsms($sender_id, $message, $phone){
    global $key;
    
    $url = "https://apps.mnotify.net/smsapi?key=$key&to=$phone&msg=$message&sender_id=$sender_id";
    $result = file_get_contents($url);
    return $result;
  }


  public function tokenizer(){
    return md5(time()*rand(1000,99999)*7);
  }


  public function checkfile($filename,$filesize){

    $allow = array('txt','pdf','doc','docx');
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


  public function get_company_info($apid, $page){
    global $link;

    $page = clean($link, $page);
    $apid = clean($link, $apid);
    $cu = $this->get_user_type($apid);
    if($cu['user_type'] != 'c'){
      return '<p class="text-center">Sorry, you do not have the privilege to access this information</p>';
    }

    $cid = $cu['userid'];

    $q = mysqli_query($link, "SELECT * FROM company WHERE cid='$cid' ");
    $qnum = mysqli_num_rows($q);
    if($qnum == 0){
      $data['info'] = '';
      $data['tasks'] = '<p class="text-center">Company not found</p>';
      $data['range'] = '';
      $data['page'] = '';
      return $data;
    }

    $qr = mysqli_fetch_assoc($q);
    if(empty($qr['logo'])){
      $logo = 'p.png';
    }
    else{
      $logo = $qr['logo'];
    }


    $info = '<div class="card shadow-base bd-0 overflow-hidden" style="background-color: #07274f;">
              <div class="pd-x-25 pd-t-25">
                <p class="tx-center">
                  <img style="border: 3px solid #fff;background-color:#fff;" src="img/avatar/'.$logo.'" width="100" class="rounded-circle" alt="">
                </p>
                <h6 class="logged-fullname tx-center" style="color: #fff;">'.$qr['cname'].'</h6>
                <p class="tx-center">'.$qr['email'].'</p>               
                <div class="widget-1">
                  <div class="card-footer">
                    <div>
                      <span class="tx-11">Subscribers</span>
                      <h6 class="tx-white tx-center">'.$this->get_total_company_subscribers($cid).'</h6>
                    </div>
                    <div>
                      <span class="tx-11">Total Tasks</span>
                      <h6 class="tx-white tx-center">'.$this->get_total_company_tasks($cid).'</h6>
                    </div>
                    <div>
                      <span class="tx-11">Total Solutions</span>
                      <h6 class="tx-white tx-center">'.$this->get_total_company_task_solutions($cid).'</h6>
                    </div>
                  </div>
                </div>
                <hr>
                <h6 class="tx-gray-800 tx-uppercase tx-semibold tx-13 mg-b-25" style="color: #fff;">Profile</h6>

                <label class="tx-10 tx-uppercase tx-mont tx-medium tx-spacing-1 mg-b-2">Location</label>
                <p class="tx-info mg-b-25" style="color: #fff;">'.$qr['location'].'</p>

                <label class="tx-10 tx-uppercase tx-mont tx-medium tx-spacing-1 mg-b-2">Address</label>
                <p class="tx-inverse mg-b-25" style="color: #fff;">'.$qr['address'].'</p>
                <hr>
                <h6 class="tx-gray-800 tx-uppercase tx-semibold tx-13 mg-b-25" style="color: #fff;">Other Information</h6>

                <label class="tx-10 tx-uppercase tx-mont tx-medium tx-spacing-1 mg-b-2">Bio</label>
                <p class="tx-inverse mg-b-25" style="color: #fff;">'.$qr['bio'].'</p>
              </div>
            </div>';

    $return = $this->get_company_tasks($cid, $page);
    $data['info'] = $info;
    $data['tasks'] = $return['task'];
    $data['page'] = $return['page'];
    $data['range'] = $return['range'];
    return $data;
  }


  public function get_company_tasks($cid, $page){
    global $link;

    $cid = clean($link, $cid);
    $page = clean($link, $page);

    $pagegets = '&company='.$cid;

    if(empty($page) == false){
      $checkqx = mysqli_query($link, "SELECT COUNT(*) FROM task WHERE cid='$cid' AND delete_task='0' "); 
      $pqcount = mysqli_fetch_assoc($checkqx);
      $cknum = $pqcount['COUNT(*)'];
      $pagemax = ceil($cknum/12);
      if($pagemax < $page){
        $page = $pagemax;
      }

      if($page > 1){
        $pagex = (12*$page) - 12;
      }
      else{
        $pagex = 0;
      }
      $qlimit = "LIMIT $pagex,12";
    }
    else{
      $qlimit = "LIMIT 12";
    }

    $q = mysqli_query($link, "SELECT * FROM task WHERE cid='$cid' AND delete_task='0' ORDER BY `date` DESC $qlimit");
    $qnum = mysqli_num_rows($q);
    if($qnum == 0){
      $data['task']='No task found';
      $data['page']=$data['range']='';
      return $data;
    }

    $pagg=$tasks='';
    $pqx = mysqli_query($link, "SELECT COUNT(*) FROM task WHERE cid='$cid' AND delete_task='0' ");
    $pqcount = mysqli_fetch_assoc($pqx);
    $pqnum = $pqcount['COUNT(*)'];
    $pqnumx = ceil($pqnum/12);
    $start = 1;
    if($page == 1 || empty($page) == true){
      $page = 1;
    }
    else if($page > 2){
      $start = $page - 2;
      $pagg .= '<li class="page-item">
                  <a class="page-link" href="company_profile?page='.($page-1).$pagegets.'" aria-label="Previous"><i class="ion ion-arrow-left-a"></i></a>
                </li>';
    }

    for($i=$start;$i<=($start+4);$i++){
        if($i == $page){
            $pagg .= '<li class="page-item active"><a class="page-link" href="company_profile?page='.$i.$pagegets.'">'.$i.'</a></li>';
        }
        else if($i <= $pqnumx){
            $pagg .= '<li class="page-item"><a class="page-link" href="company_profile?page='.$i.$pagegets.'">'.$i.'</a></li>';   
        }
    }


    if($pqnumx > 1 && $pqnumx > $page){
      $pagg .= '<li class="pag-prev mg-5">
                  <a style="border:none;" class="page-link" href="company_profile?page='.($page+1).$pagegets.'" aria-label="Next"><i class="ion ion-arrow-right-a"></i></a>
                </li>';
    }


    while($qr = mysqli_fetch_array($q, MYSQLI_ASSOC)) {
      $tid = $qr['tid'];
      $tasks .= '<h6 class="card-title">'.$qr['title'].'</h6>
                <p class="card-text">'.$qr['summary'].' - <i style="color: #237ad4;font-size: 12px;">'.date("jS M Y, g:i a", strtotime($qr['date'])).'</i></p>
                <p class="card-subtitle"><span class="icon ion-ios-list-outline" style="font-size: 20px;"></span> Submitted Solutions: <b style="color: #333;">'.$this->get_task_solutions_count($tid).'</b><button id="delete" onclick="delete_task(\''.$tid.'\')" class="btn btn-sm btn-danger pull-right">Delete</button></p>

                <hr>';
    }
    
    $fromnum = 1;
    $tonum = ($page * 12);
    if($tonum > $pqnum){
      $tonum = $pqnum;
    }
    if($page > 1){
      $fromnum = ($page * 12)-11;
      if($tonum > $pqnum){
        $tonum = $pqnum;
      }
    }

    $data['task'] = $tasks;
    $data['page'] = '<div class="ht-80 d-flex align-items-center justify-content-center">
                      <nav aria-label="Page navigation">
                        <ul class="pagination pagination-basic pagination-circle mg-b-0">
                          '.$pagg.'
                        </ul>
                      </nav>
                    </div>';
    $data['range'] = '<p class="text-center mg-b-0">Showing <span>'.$fromnum.'</span> to <span>'.$tonum.'</span> of <span>'.$pqnum.'</span> Tasks</p>';

    return $data;
  }


  public function get_total_company_subscribers($cid){
    global $link;

    $cid = clean($link, $cid);

    $q = mysqli_query($link, "SELECT sbid FROM `subscribe` WHERE cid='$cid' ");
    $qnum = mysqli_num_rows($q);
      return $qnum;
  }


  public function get_total_company_tasks($cid){
    global $link;

    $cid = clean($link, $cid);

    $q = mysqli_query($link, "SELECT tid FROM `task` WHERE cid='$cid' AND delete_task='0' ");
    $qnum = mysqli_num_rows($q);
    return $qnum;
  }


  public function get_total_company_task_solutions($cid){
    global $link;

    $cid = clean($link, $cid);

    $q = mysqli_query($link, "SELECT sid FROM `solution` WHERE tid IN (SELECT tid FROM `task` WHERE cid='$cid') AND `status` NOT IN ('0','3') ");
    $qnum = mysqli_num_rows($q);
    return $qnum;
  }


  public function update_watchlist($userid,$student){
    global $link;

		$cid = clean($link, $userid);
		$stid = clean($link, $student);

		$cq = mysqli_query($link, "SELECT stid FROM students WHERE stid='$stid' ");
		$cqnum = mysqli_num_rows($cq);
		if($cqnum == 0){
			return 'Invalid student info';
		}

		$q =  mysqli_query($link, "SELECT stid FROM watches WHERE stid='$stid' AND cid='$cid'");
		$qnum = mysqli_num_rows($q);
		if($qnum == 1){
			$dq = mysqli_query($link, "DELETE FROM watches WHERE stid='$stid' AND cid='$cid'");
			if($dq){
				return 'watch';
			}
			return 'Error removing student from watch list...try again';
		}
    
    $timenow = date("Y-m-d H:i:s", time());
		$iq = mysqli_query($link, "INSERT INTO watches(stid,cid,`date`) VALUES('$stid','$cid','$timenow')");
		if($iq){
			return 'unwatch';
		}
		return 'Error adding student to watch list...try again';
  }



  public function user_email($apid){
		global $link;

		$data = mysqli_fetch_assoc(mysqli_query($link, "SELECT email FROM appusers WHERE apid='$apid' "));
		return $data;
	}



  public function get_company_edit_info($apid){
		global $link;

		$apid = clean($link, $apid);
		$em = $this->user_email($apid);
		$info = $this->user_data($apid, 'cname,location,address,email,bio');


		return '<form id="form" method="POST" action="" data-parsley-validate enctype="multipart/form-data">						
              <div class="form-group">
                <label class="d-block tx-11 tx-medium tx-spacing-1 text-left">Company Name</label>
                <input type="text" class="form-control" value="'.$info['cname'].'" name="cname" style="margin-top: 0px; margin-bottom: 0px;" required>
              </div>
              <div class="form-group">
                <label class="d-block tx-11 tx-medium tx-spacing-1 text-left">Location</label>
                <input type="text" class="form-control" value="'.$info['location'].'" name="locat" style="margin-top: 0px; margin-bottom: 0px;" required>
              </div>
              <div class="form-group">
                <label class="d-block tx-11 tx-medium tx-spacing-1 text-left">Address</label>
                <input type="text" class="form-control" value="'.$info['address'].'" name="address" style="margin-top: 0px; margin-bottom: 0px;" required>
              </div>
              <div class="form-group">
                <label class="d-block tx-11 tx-medium tx-spacing-1 text-left">Enter a Bio about the Company</label>
                <textarea id="textarea" class="form-control" name="bio" maxlength="160" rows="4" placeholder="Company Bio" style="margin-top: 0px; margin-bottom: 0px; height: 123px;" required>'.$info['bio'].'</textarea>
              </div>
              <hr>
              <div class="form-group text-center">
                <button type="submit" name="infosubmit" class="btn btn-success mg-b-10" style="width: 40%;">Submit</button>
              </div>
						</form>';
  }
  

  public function update_password($apid, $oldpassword, $newpassword){
		global $link;

		$apid = clean($link, $apid);
		$oldpassword = md5(clean($link, $oldpassword));
		$newpassword = md5(clean($link, $newpassword));

		if($oldpassword == $newpassword){
			return 'Change password...New password should not be the same as the old password';
		}

		$qp = mysqli_query($link, "SELECT apid FROM appusers WHERE apid='$apid' AND password='$oldpassword' ");
		$qpnum = mysqli_num_rows($qp);
		if($qpnum == 0){
			return 'Current password is invalid';
		} 

		$q = mysqli_query($link, "UPDATE appusers SET password='$newpassword' WHERE apid='$apid' ");
		if($q){
			return 1;
		}
		return 'Error updating password...Try again';
  }
  

  public function change_logo($data, $userid){
		global $link;

		list($type, $data) = explode(';', $data);
		list(, $data)      = explode(',', $data);
		$data = base64_decode($data);

		$imageName = 'company'.substr(md5(time()), 0, 10).'.png';
		$oldavat = mysqli_query($link, "SELECT logo FROM company WHERE cid='$userid' ");
		$or = mysqli_fetch_assoc($oldavat);
		if(empty($or['logo']) != true){
			unlink("../img/avatar/".$or['logo']);
		}

		$upavat = mysqli_query($link, "UPDATE company SET logo='$imageName' WHERE cid='$userid' ");

		if(file_put_contents('../img/avatar/'.$imageName , $data)){
			return "done";
		}
		return "error updating logo";
  }
  

  public function update_company($apid, $bio, $cname, $locat, $address){
    global $link;

    $cname = clean($link, $cname);
		$bio = clean($link, $bio);
    $locat = clean($link, $locat);
		$address = clean($link, $address);
		
		$apid = clean($link, $apid);
		$st = $this->get_user_type($apid);
		if($st['user_type'] != 'c'){
			return 'Sorry, you do not have the privilege to access this information';
		}
		$cid = $st['userid'];

		if(empty($postal)){
			$postal = NULL;
		}


		$q = mysqli_query($link, "UPDATE company SET `cname`='$cname', `location`='$locat', `address`='$address', `bio`='$bio' WHERE cid='$cid'");
		if($q){
			return 1;
		}
		else{
			return 'Error updating Company Information. Try again';
		}
  }


  public function get_transactions($apid, $search, $pagex){
		global $link;

		$apid = clean($link, $apid);
		$st = $this->get_user_type($apid);
		if($st['user_type'] != 'c'){
			$data['list'] = '<p class="text-center">Sorry, you do not have the privilege to access this information</p>';
      $data['page'] = '';
      $data['range'] = '';
      return $data;
		}

    $search = clean($link, $search);
    $page = clean($link, $pagex);

    $parameter = '';
    $pagegets = '';
    if(!empty($search) == true){
      $parameter = "AND (wallet LIKE '%$search%' OR invoice_num LIKE '%$search%' OR transaction_num LIKE '%$search%') ";
      $pagegets = '&q='.$search;
    }

    if(empty($page) == false){
      $checkqx = mysqli_query($link, "SELECT COUNT(*) FROM `transaction` WHERE apid='$apid' $parameter"); 
      $pqcount = mysqli_fetch_assoc($checkqx);
      $cknum = $pqcount['COUNT(*)'];
      $pagemax = ceil($cknum/12);
      if($pagemax < $page){
        $page = $pagemax;
      }

      if($page > 1){
        $pagex = (12*$page) - 12;
      }
      else{
        $pagex = 0;
      }
      $qlimit = "LIMIT $pagex,12";
    }
    else{
      $qlimit = "LIMIT 12";
    }

		$q = mysqli_query($link, "SELECT * FROM `transaction` WHERE apid='$apid' $parameter ORDER BY `date` DESC $qlimit ");
		$qnum = mysqli_num_rows($q);
		if($qnum == 0){
			$data['list'] = '<p class="text-center">No transactions found</p>';
      $data['page'] = '';
      $data['range'] = '';
      return $data;
		}

		$pagg=$trans='';
    $pqx = mysqli_query($link, "SELECT COUNT(*) FROM `transaction` WHERE apid='$apid' $parameter ");
    $pqcount = mysqli_fetch_assoc($pqx);
    $pqnum = $pqcount['COUNT(*)'];
    $pqnumx = ceil($pqnum/12);
    $start = 1;
    if($page == 1 || empty($page) == true){
      $page = 1;
    }
    else if($page > 2){
      $start = $page - 2;
      $pagg .= '<li class="page-item">
                  <a class="page-link" href="transactions?page='.($page-1).$pagegets.'" aria-label="Previous"><i class="ion ion-arrow-left-a"></i></a>
                </li>';
    }

    for($i=$start;$i<=($start+4);$i++){
        if($i == $page){
            $pagg .= '<li class="page-item active"><a class="page-link" href="transactions?page='.$i.$pagegets.'">'.$i.'</a></li>';
        }
        else if($i <= $pqnumx){
            $pagg .= '<li class="page-item"><a class="page-link" href="transactions?page='.$i.$pagegets.'">'.$i.'</a></li>';   
        }
    }


    if($pqnumx > 1 && $pqnumx > $page){
      $pagg .= '<li class="pag-prev mg-5">
                  <a style="border:none;" class="page-link" href="transactions?page='.($page+1).$pagegets.'" aria-label="Next"><i class="ion ion-arrow-right-a"></i></a>
                </li>';
		}
		
		$c=1;
    while ($qr = mysqli_fetch_array($q, MYSQLI_ASSOC)) {
      // $stid = $qr['apid'];
			if($qr['wallet_type'] == 't'){
				$net = '<span class="badge-pill bg-primary tx-white tx-12" style="padding: 2px 12px;border-radius: 2px;">TiGO</span>';
			}
			else{
				$net = '<span class="badge-pill bg-warning tx-white tx-12" style="padding: 2px 12px;border-radius: 2px;">MTN</span>';
			}

			if($qr['status'] == 'p'){
				$state = '<span class="badge-pill bg-light tx-10" style="padding: 2px 10px;">pending</span>';
			}else if($qr['status'] == 's'){
				$state = '<span class="badge-pill bg-success tx-10 tx-white" style="padding: 2px 10px;">success</span>';
			}else{
				$state = '<span class="badge-pill bg-danger tx-10 tx-white" style="padding: 2px 10px;">failed</span>';
			}

      $trans .= '<tr>
									<td>'.$qr['wallet'].'</td>
									<td>'.$net.'</td>
									<td>GHC '.$qr['amount'].'</td>
									<td>'.$qr['invoice_num'].'</td>
									<td>'.$qr['transaction_num'].'</td>
									<td>'.$state.'</td>
									<td>'.date("jS M Y, h:i a", strtotime($qr['date'])).'</td>
								</tr>';
			$c++;
		}
		
		$trans = '<div class="bd bd-gray-300 rounded table-responsive">
									<table class="table table-striped mg-b-0">
										<thead>
											<tr>
												<th>Wallet Number</th>
												<th>Type</th>
												<th>Amount</th>
												<th>Invoice Number</th>
												<th>Transaction Number</th>
												<th>Status</th>
												<th>Date</th>
											</tr>
										</thead>
										<tbody>
											'.$trans.'
										</tbody>
									</table>
								</div>';
    
    $fromnum = 1;
    $tonum = ($page * 12);
    if($tonum > $pqnum){
      $tonum = $pqnum;
    }
    if($page > 1){
      $fromnum = ($page * 12)-11;
      if($tonum > $pqnum){
        $tonum = $pqnum;
      }
    }

		$data['list'] = $trans;
    $data['page'] = '<div class="ht-80 d-flex align-items-center justify-content-center">
                      <nav aria-label="Page navigation">
                        <ul class="pagination pagination-basic pagination-circle mg-b-0">
                          '.$pagg.'
                        </ul>
                      </nav>
                    </div>';
    $data['range'] = '<p class="text-center mg-b-20">Showing <span>'.$fromnum.'</span> to <span>'.$tonum.'</span> of <span>'.$pqnum.'</span> Transactions</p>';

    return $data;

  }
  

  public function delete_task($userid, $task){
    global $link;
    
    $userid = clean($link, $userid);
    $task = clean($link, $task);

    $uq = mysqli_query($link, "UPDATE task SET `delete_task`='1' WHERE cid='$userid' AND tid='$task' ");
		if($uq){
      $tid = 't='+$task;
      $dq = mysqli_query($link, "DELETE FROM `notification` WHERE note_id='$tid' AND ntype='t' AND seen='0' ");
			return 'done';
		}
		return 'Error deleting task...try again';
  }



  public function create_internship($apid, $title, $summary, $starts, $ends){
    global $link;

    $apid = clean($link, $apid);
    $st = $this->get_user_type($apid);
		if($st['user_type'] != 'c'){
      return 'Sorry, you do not have the privilege to access this information';
    }
    $cid = $st['userid'];
    $title = clean($link, $title);
    $summary = clean($link, $summary);
    $starts = date("Y-m-d", strtotime(clean($link, $starts)));
    $ends = date("Y-m-d", strtotime(clean($link, $ends)));
   
    $cq = mysqli_query($link, "SELECT inid FROM internship WHERE cid='$cid' AND title='$title' AND `description`='$summary' AND `starts`='$starts' AND `ends`='$ends' ");
    $cqnum = mysqli_num_rows($cq);
    if($cqnum > 0){
      return 'Internship already exist';
    }
    $created = date("Y-m-d H:i:s", time());
    $q = mysqli_query($link, "INSERT INTO `internship`(`cid`,`title`,`description`,`starts`,`ends`,`created`) VALUES('$cid', '$title', '$summary', '$starts', '$ends', '$created')");
    if($q){
      $tid = 'i='.mysqli_insert_id($link);
      $sq = mysqli_query($link, "SELECT apid,email,firebase FROM appusers WHERE userid IN (SELECT stid FROM subscribe WHERE cid='$cid') AND user_type='s'");
      $sqnum = mysqli_num_rows($sq);
      if($sqnum > 0){   
        $ut = new Utility();   
        $tokens = array();
        while($sqr = mysqli_fetch_array($sq, MYSQLI_ASSOC)){
          $timenow = date("Y-m-d H:i:s", time());
          $user = $sqr['apid'];
          $cq = mysqli_query($link, "SELECT cname FROM company WHERE cid='$cid'");
          $cqr = mysqli_fetch_assoc($cq);
          $note = '<b>'.$cqr['cname'].'</b> uploaded a new internship.';
          $inq = mysqli_query($link, "INSERT INTO `notification`(`apid`,`ntype`,`note_id`,`note`,`date`) VALUES('$user', 'i', '$tid', '$note', '$timenow') ");
          
          $email = $sqr['email'];
          $message = $note.'<br><p><b>'.$title.'</b></p><br><p>'.nl2br($summary).'</p>';
          $this->send_email($email, "Internship Opportunity", $message);

          if(!empty($sqr['firebase'])){
            array_push($tokens, $sqr['firebase']);
            $title = $cqr['cname'].'</b> uploaded a new internship.';   
            $body = $title.', '.nl2br($summary); 
          }
          
        }

        if(!empty($tokens)){
          $note['title'] = $title;    
          $note['body'] = $body;
          $note['click_action'] = 'INTERNSHIP_ACTIVITY';
          $note['android_channel_id'] = 'rook_internship';
          
          $ut->send_mass_firebase_notification($tokens, $note, $data);
        }
      }
      return 1;
    }
    return 'Error creating internship';
  }


  public function view_student_cv($apid, $applicant){
    global $link;

    $apid = clean($link, $apid);
    $st = $this->get_user_type($apid);
		if($st['user_type'] != 'c'){
      return 'Sorry, you do not have the privilege to access this information';
    }
    $cid = $st['userid'];
    $aplid = clean($link, $applicant);

    $cq = mysqli_query($link, "SELECT aplid, stid FROM applicants WHERE aplid='$aplid' AND inid IN (SELECT inid FROM internship WHERE cid='$cid') ");
    $cqnum = mysqli_num_rows($cq);
    if($cqnum == 0){
      return "Invalid applicant information";
    }

    $cqr = mysqli_fetch_assoc($cq);
    $stid = $cqr['stid'];

    $statictics = $this->get_student_statistics($stid);
		$taskinfo = $this->get_total_student_tasks($stid);

		$cmq = mysqli_query($link, "SELECT `cname`, `location` FROM company WHERE cid IN (SELECT cid FROM task WHERE tid IN (SELECT tid FROM solution WHERE stid='$stid' AND `status` NOT IN ('0','3') ) ) ORDER BY `cname` ASC ");
		$cmnum = mysqli_num_rows($cmq);
		$companies = 'Yet to be added';
		if($cmnum != 0){
			$c=1;
			$cm1=$cm2='';
			while($cmqr = mysqli_fetch_array($cmq, MYSQLI_ASSOC)){			
				if($c==1){					
					$cm1 .= '<p class="tx-14 mg-b-10">
										<b>'.$cmqr['cname'].'</b> - '.$cmqr['location'].'
									</p>';
				}
				else{
					$cm2 .= '<p class="tx-14 mg-b-10">
										<b>'.$cmqr['cname'].'</b> - '.$cmqr['location'].'
									</p>';
					$c=0;
				}
				$c++;
			}

			$companies = '<div class="col-md-6">'.$cm1.'</div><div class="col-md-6">'.$cm2.'</div>';
		}
		
		
    $stq = mysqli_query($link, "SELECT username, dob,gender,country,city,`state` FROM students WHERE stid='$stid' ");
    
    $info = mysqli_fetch_assoc($stq);
		if($info['gender'] == 'f'){
			$gender = 'Female';
		}else{
			$gender = 'Male';
		}

		if(empty($info['city'])){
			$info['city'] = 'City';
		}

		if(empty($info['state'])){
			$info['state'] = 'State';
		}
		
		$countryid = $info['country'];
		$cq = mysqli_query($link, "SELECT `country_name` FROM countries WHERE id='$countryid' ");
		$cqr = mysqli_fetch_assoc($cq);

		$psq = mysqli_query($link, "SELECT `summary` FROM cv_prof WHERE stid='$stid' ");
		$psnum = mysqli_num_rows($psq);
		$prof = 'Yet to be added';
		if($psnum != 0){
			$psqr = mysqli_fetch_assoc($psq);
			$prof = $psqr['summary'];
		}

		$svq = mysqli_query($link, "SELECT `service` FROM cv_service WHERE stid='$stid' ");
		$svnum = mysqli_num_rows($svq);
		$service = 'Yet to be added';
		if($svnum != 0){
			$svqr = mysqli_fetch_assoc($svq);
			$service = $svqr['service'];
		}

		$hbq = mysqli_query($link, "SELECT `hobbies` FROM cv_hobbies WHERE stid='$stid' ");
		$hbnum = mysqli_num_rows($hbq);
		$hobbies = 'Yet to be added';
		if($hbnum != 0){
			$hbqr = mysqli_fetch_assoc($hbq);
			$hobbies = $hbqr['hobbies'];
		}

		$whq = mysqli_query($link, "SELECT * FROM cv_work WHERE stid='$stid' ");
		$whnum = mysqli_num_rows($whq);
		$work = '<div class="col-md-6"><p class="tx-14 mg-b-10">Yet to be added</p></div>';
		if($whnum != 0){
			$c=1;
			$wh1=$wh2='';
			while($whqr = mysqli_fetch_array($whq, MYSQLI_ASSOC)){
				if($whqr['current'] == 0){
					$end = date("M Y", strtotime($whqr['end']));
				}else{
					$end = 'Current';
				}

				if($c==1){
					
					$wh1 .= '<p class="tx-14 mg-b-10">
										<b>'.$whqr['job_title'].'</b><br>
										'.$whqr['duties'].'<br>
										'.$whqr['employer'].' - '.$whqr['country'].'<br>
										'.date("M Y", strtotime($whqr['start'])).' - '.$end.'
									</p>';
				}
				else{
					$wh2 .= '<p class="tx-14 mg-b-10">
										<b>'.$whqr['job_title'].'</b><br>
										'.$whqr['duties'].'<br>
										'.$whqr['employer'].' - '.$whqr['country'].'<br>
										'.date("M Y", strtotime($whqr['start'])).' - '.$end.'
									</p>';
					$c=0;
				}
				$c++;
			}

			$work = '<div class="col-md-6">'.$wh1.'</div><div class="col-md-6">'.$wh2.'</div>';
		}

		$edq = mysqli_query($link, "SELECT * FROM cv_education WHERE stid='$stid' ");
		$ednum = mysqli_num_rows($edq);
		$education = '<div class="col-md-6"><p class="tx-14 mg-b-10">Yet to be added</p></div>';
		if($ednum != 0){
			$c=1;
			$ed1=$ed2='';
			while($edqr = mysqli_fetch_array($edq, MYSQLI_ASSOC)){			
				if($c==1){
					
					$ed1 .= '<p class="tx-14 mg-b-10">
										<b>'.$edqr['school'].'</b> - '.$edqr['location'].'<br>
										'.$edqr['degree'].' - '.$edqr['field'].'<br>
										'.date("Y", strtotime($edqr['finish'])).'
									</p>';
				}
				else{
					$ed2 .= '<p class="tx-14 mg-b-10">
										<b>'.$edqr['school'].'</b> - '.$edqr['location'].'<br>
										'.$edqr['degree'].' - '.$edqr['field'].'<br>
										'.date("Y", strtotime($edqr['finish'])).'
									</p>';
					$c=0;
				}
				$c++;
			}

			$education = '<div class="col-md-6">'.$ed1.'</div><div class="col-md-6">'.$ed2.'</div>';
		}


		$skq = mysqli_query($link, "SELECT * FROM cv_skills WHERE stid='$stid' ");
		$sknum = mysqli_num_rows($skq);
		$skills = '<div class="col-md-6"><p class="tx-14 mg-b-10">Yet to be added</p></div>';
		if($sknum != 0){
			$c=1;
			$sk1=$sk2='';
			while($skqr = mysqli_fetch_array($skq, MYSQLI_ASSOC)){			
				if($c==1){
					
					$sk1 .= '<p class="tx-14 mg-b-10">
										<b>'.$skqr['skill'].'</b>
									</p>';
				}
				else{
					$sk2 .= '<p class="tx-14 mg-b-10">
										<b>'.$skqr['skill'].'</b>
									</p>';
					$c=0;
				}
				$c++;
			}

			$skills = '<div class="col-md-6">'.$sk1.'</div><div class="col-md-6">'.$sk2.'</div>';
		}


		return 'done|<div class="col-lg-8 col-lg-offset-2 mg-t-100 mg-b-100">
							<div class="card bd-0 shadow-base">
								<div class="pd-x-25 pd-t-25">
                  <p><img alt="" src="assets/images/logo.png" width="150">                    
                    <button class="btn btn-danger pull-right" onclick="closepop()"><i class="ion-close"></i> Close</button>
                    <button class="btn btn-success pull-right mg-r-5" onclick="acceptapplicant(\''.$aplid.'\')"><i class="ion-checkmark"></i> Accept</button>
                  </p>
									<hr>
									<div class="row">
										<div class="col-md-8">
											<h4 class="tx-inverse tx-semibold tx-spacing-1 mg-b-20">'.$info['username'].'</h4>
											<p class="tx-14 mg-b-0">Date of Birth: <b>'.date("jS M, Y",strtotime($info['dob'])).'</b></p>
											<p class="tx-14 mg-b-0">Gender: <b>'.$gender.'</b></p>
											<p class="tx-14 mg-b-0">Location: <b>'.$info['city'].'/'.$info['state'].'/'.$cqr['country_name'].'</b></p>
										</div>
									</div>
									
									<hr>
									<h6 class="tx-inverse tx-semibold tx-spacing-1 mg-b-10">Professional Summary</h6>
									<p class="tx-14 mg-b-5">'.$prof.'</p>
									<hr>
									<h6 class="tx-inverse tx-semibold tx-spacing-1 mg-b-10">Work History</h6>
									<div class="row">
										'.$work.'
									</div>
									<hr>
									<h6 class="tx-inverse tx-semibold tx-spacing-1 mg-b-10">Education</h6>
									<div class="row">
										'.$education.'
									</div>								
									<hr>
									<h6 class="tx-inverse tx-semibold tx-spacing-1 mg-b-10">Skills</h6>
									<div class="row">
										'.$skills.'
									</div>
									<hr>									
									<h6 class="tx-inverse tx-semibold tx-spacing-1 mg-b-10">Community Service</h6>
									<p class="tx-14 mg-b-5">'.$service.'</p>
									<hr>
									<h6 class="tx-inverse tx-semibold tx-spacing-1 mg-b-10">Hobbies and Interests</h6>
									<p class="tx-14 mg-b-5">'.$hobbies.'</p>
									<hr>	
									<h6 class="tx-inverse tx-semibold tx-spacing-1 mg-b-10">Rook+ Statistics</h6>
									<h5 class="mg-b-20" style="font-weight:400">Completed Tasks: <b>'.$taskinfo['total'].'</b></h5>
									<h6 class="mg-b-20" style="font-weight:400">Total Points: <b>'.$this->get_student_points($stid).'</b></h6>
									<div class="row">
										<div class="col-md-6">                  
											<p class="mg-b-0 tx-14">Speed: '.$statictics['speedtxt'].'</p>
											<div class="progress mg-b-20">
												<div class="progress-bar progress-bar-md wd-'.$statictics['speed'].'p"
												role="progressbar" aria-valuenow="'.$statictics['speed'].'" aria-valuemin="0" aria-valuemax="100"></div>
											</div>											
											<p class="mg-b-0 tx-14">Technicality: '.$statictics['ratetxt'].'</p>
											<div class="progress mg-b-20">
												<div class="progress-bar progress-bar-md wd-'.$statictics['rate'].'p"
												role="progressbar" aria-valuenow="'.$statictics['rate'].'" aria-valuemin="0" aria-valuemax="100"></div>
											</div>							
										</div>
										<div class="col-md-6">
											<p class="mg-b-0 tx-14">Initiative: '.$statictics['initiativetxt'].'</p>
											<div class="progress mg-b-20">
												<div class="progress-bar progress-bar-md wd-'.$statictics['initiative'].'p"
												role="progressbar" aria-valuenow="'.$statictics['initiative'].'" aria-valuemin="0" aria-valuemax="100"></div>
											</div>
											<p class="mg-b-0 tx-14">Execution: '.$statictics['executetxt'].'</p>
											<div class="progress mg-b-20">
												<div class="progress-bar progress-bar-md wd-'.$statictics['execute'].'p"
												role="progressbar" aria-valuenow="'.$statictics['execute'].'" aria-valuemin="0" aria-valuemax="100"></div>
											</div>							
										</div>
									</div>
									<hr>
									<h6 class="tx-inverse tx-semibold tx-spacing-1 mg-b-10">Company Task Completed</h6>
									<div class="row mg-b-20">
										'.$companies.'
									</div>											
								</div><!-- pd-x-25 -->
							</div><!-- card -->
						</div>';
  }



  public function accept_applicant($apid, $applicant){
    global $link;

    $apid = clean($link, $apid);
    $st = $this->get_user_type($apid);
		if($st['user_type'] != 'c'){
      return 'Sorry, you do not have the privilege to access this information';
    }
    $cid = $st['userid'];
    $aplid = clean($link, $applicant);

    $cq = mysqli_query($link, "SELECT aplid, inid, stid FROM applicants WHERE aplid='$aplid' AND inid IN (SELECT inid FROM internship WHERE cid='$cid') ");
    $cqnum = mysqli_num_rows($cq);
    if($cqnum == 0){
      return "Invalid applicant information";
    }

    $cqr = mysqli_fetch_assoc($cq);
    $stid = $cqr['stid'];
    $inid = $cqr['inid'];

    $userx = $this->user_data($apid, "cname");
    $cn = explode(" ", $userx['cname']);
    $fname = $cn[0];
    $code = $fname.'-'.date("Ymd",time()).'-'.rand(10000,99999)*7;
    $uq = mysqli_query($link, "UPDATE applicants SET accepted='1',code='$code' WHERE aplid='$aplid' ");
    if($uq){
      $tid = 'i='.$inid;
      $sq = mysqli_query($link, "SELECT apid,email,firebase FROM appusers WHERE userid='$stid' AND user_type='s'");
      $sqnum = mysqli_num_rows($sq);
      $ut = new Utility();
      if($sqnum > 0){   
        $timenow = date("Y-m-d H:i:s", time());   
        $sqr = mysqli_fetch_assoc($sq);
        $user = $sqr['apid'];
        $cq = mysqli_query($link, "SELECT cname FROM company WHERE cid='$cid'");
        $cqr = mysqli_fetch_assoc($cq);
        $note = '<b>'.$cqr['cname'].'</b> accepted you for an internship.';
        $inq = mysqli_query($link, "INSERT INTO `notification`(`apid`,`ntype`,`note_id`,`note`,`date`) VALUES('$user', 'i', '$tid', '$note', '$timenow') ");      
      
        $email = $sqr['email'];
        $message = nl2br($note);
        $this->send_email($email, "Congratulation!", $message);

        if(!empty($sqr['firebase'])){
          $token = $sqr['firebase'];
          $note['title'] = 'Congratulation!';    
          $note['body'] = $cqr['cname'].' accepted you for an internship.';
          $note['click_action'] = 'INTERNSHIP_ACTIVITY';
          $note['android_channel_id'] = 'rook_internship';
          $data['type'] = "internship";
          $ut->send_firebase_notification($token, $note, $data);
        }
      }
      return 'done';
    }
    return 'Error accepting applicant...try again';
  
  }



  public function check_applicant_code($apid, $code){
    global $link;

    $apid = clean($link, $apid);
    $st = $this->get_user_type($apid);
		if($st['user_type'] != 'c'){
      return 'Sorry, you do not have the privilege to access this information';
    }
    $cid = $st['userid'];
    $code = clean($link, $code);

    $cq = mysqli_query($link, "SELECT aplid, stid, inid FROM applicants WHERE code='$code' AND inid IN (SELECT inid FROM internship WHERE cid='$cid') ");
    $cqnum = mysqli_num_rows($cq);
    if($cqnum == 0){
      return "Invalid code";
    }

    $cqr = mysqli_fetch_assoc($cq);
    $stid = $cqr['stid'];
    $inid = $cqr['inid'];

    $stq = mysqli_query($link, "SELECT username FROM students WHERE stid='$stid' ");
    $stqr = mysqli_fetch_assoc($stq);

    $q = mysqli_query($link, "SELECT * FROM internship WHERE inid='$inid' ");
    $qr = mysqli_fetch_assoc($q);

    $datepost = strtotime(date("Y-m-d", strtotime($qr['created'])));
    $tdate = strtotime(date("Y-m-d", time()));
    $datedif = $tdate - $datepost;
    if($datedif < 86400){
        $timepost = 'Today '.date("g:i A",strtotime($qr['created']));
    }
    else if($datedif >= 86400 && $datedif < 172800){
        $timepost = 'Yesterday '.date("g:i A",strtotime($qr['created']));
    }
    else if($datedif >= 31104000){
        $timepost = date("jS M, Y",strtotime($qr['created']));
    }
    else{
        $timepost = date("jS M",strtotime($qr['created']));
    }

    return 'done|<h6 class="card-title">'.$qr['title'].'</h6>
    <p class="card-text">'.$qr['description'].' - <i style="color:#2196f3;">'.$timepost.'</i></p>
    <p class="card-text">Starts: <b class="tx-success">'.date("jS M Y", strtotime($qr['starts'])).'</b> - Ends: <b class="tx-danger">'.date("jS M Y", strtotime($qr['ends'])).'</b></b></p>    
    <hr>
    <h5 class="mg-b-20 tx-18">Applicant: <b class="tx-20">'.$stqr['username'].'</b></h5>';

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