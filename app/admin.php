<?php


class Admin{

  public function get_user_type($apid){
    global $link;
    
    $apid = clean($link, $apid);

    $data = mysqli_fetch_assoc(mysqli_query($link, "SELECT user_type, userid FROM appusers WHERE apid='$apid' "));
    return $data;
  }

	public function get_total_students(){
		global $link;

    $users['active']=$users['total']= 0;
		$q = mysqli_query($link, "SELECT COUNT(stid) as users, active FROM `students` WHERE 1 GROUP BY active ");
		$qnum = mysqli_num_rows($q);
		if($qnum == 0){
			return $users;
		}

		$total = 0;
		while ($qr = mysqli_fetch_array($q, MYSQLI_ASSOC)) {
			if($qr['active'] == 1){
				$users['active'] = $qr['users'];
			}
			$total += $qr['users'];
		}

		$users['total'] = $total;
		return $users;
	}


  public function get_gender_percent(){
    global $link;

    $users['male']=$users['female']= 0;
    $q = mysqli_query($link, "SELECT COUNT(stid) as users, gender FROM `students` WHERE 1 GROUP BY gender ");
    $qnum = mysqli_num_rows($q);
    if($qnum == 0){
      return $users;
    }

    while ($qr = mysqli_fetch_array($q, MYSQLI_ASSOC)) {
      if($qr['gender'] == 'm'){
        $users['male'] = $qr['users'];
      }
      else if($qr['gender'] == 'f'){
        $users['female'] = $qr['users'];
      }
    }
    return $users;
  }


  public function get_task_stats(){
    global $link;

    $task['solution']=$task['total']= 0;
    $q = mysqli_query($link, "SELECT COUNT(sid) as sid, status FROM `solution` WHERE 1 GROUP BY status ");
    $qnum = mysqli_num_rows($q);
    if($qnum == 0){
      return $task;
    }

    $total = 0;
    while ($qr = mysqli_fetch_array($q, MYSQLI_ASSOC)) {
      if($qr['status'] == 1 || $qr['status'] == 2){
        $task['solution'] = $qr['sid'];
      }
      $total += $qr['sid'];
    }

    $task['total'] = $total;
    return $task;
  }


  public function get_total_companies(){
    global $link;

    $comp['active']=$comp['total']= 0;
    $q = mysqli_query($link, "SELECT COUNT(cid) as comp, active FROM `company` WHERE 1 GROUP BY active ");
    $qnum = mysqli_num_rows($q);
    if($qnum == 0){
      return $comp;
    }

    $total = 0;
    while ($qr = mysqli_fetch_array($q, MYSQLI_ASSOC)) {
      if($qr['active'] == 1){
        $comp['active'] = $qr['comp'];
      }
      $total += $qr['comp'];
    }

    $comp['total'] = $total;
    return $comp;
  }


  public function get_total_tasks(){
    global $link;

    $q = mysqli_query($link, "SELECT * FROM `task` WHERE 1 ");
    $qnum = mysqli_num_rows($q);
    return $qnum;
  }


  public function get_total_task_solutions(){
    global $link;

    $q = mysqli_query($link, "SELECT * FROM `solution` WHERE `status` NOT IN ('0','3') ");
    $qnum = mysqli_num_rows($q);
    return $qnum;
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

    $q = mysqli_query($link, "SELECT tid FROM `task` WHERE cid='$cid' ");
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


  public function get_company_info($apid, $company,$page){
    global $link;

    $apid = clean($link, $apid);
    $st = $this->get_user_type($apid);
    if($st['user_type'] != 'a'){
      return '<p class="text-center">Sorry, you do not have the privilege to access this information</p>';
    }

    $cid = clean($link, $company);
    $page = clean($link, $page);

    $q = mysqli_query($link, "SELECT * FROM company WHERE cid='$cid' ");
    $qnum = mysqli_num_rows($q);
    if($qnum == 0){
      $data['info'] = '';
      $data['tasks'] = '<p class="text-center">Company not found</p>';
      $data['range'] = '';
      return $data;
    }

    $qr = mysqli_fetch_assoc($q);
    if(empty($qr['logo'])){
      $logo = 'p.png';
    }
    else{
      $logo = $qr['logo'];
    }

    $compdel = '<button onclick="delcomp(\''.$cid.'\')" class="btn btn-warning btn-sm mg-b-0">Deactivate Account</button>';
    if($qr['active'] == 2){
      $compdel = '<button class="btn btn-danger btn-sm mg-b-0">Deactivated</button>';
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
                <p class="mg-b-0 tx-center">
                  '.$compdel.'
                </p>
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
      $checkqx = mysqli_query($link, "SELECT COUNT(*) FROM task WHERE cid='$cid' "); 
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

    $q = mysqli_query($link, "SELECT * FROM task WHERE cid='$cid' ORDER BY `date` DESC ");
    $qnum = mysqli_num_rows($q);
    if($qnum == 0){
      $data['task'] = '<p class="text-center">No task found</p>';
      $data['page'] = '';
      $data['range'] = '';
      return $data;
    }

    $pagg=$tasks='';
    $pqx = mysqli_query($link, "SELECT COUNT(*) FROM task WHERE cid='$cid' ");
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
      $delx = '';
      if($qr['delete_task'] == 1){
        $delx = '<span class="badge-pill badge-danger" style="padding: 2px 8px; font-size:10px;">Deleted</span>';
      }
      $tasks .= '<h6 class="card-title">'.$qr['title'].'</h6>
                <p class="card-text">'.$qr['summary'].' - <i style="color: #237ad4;font-size: 12px;">'.date("jS M Y, g:i a", strtotime($qr['date'])).'</i></p>
                <p class="card-subtitle"><span class="icon ion-ios-list-outline" style="font-size: 20px;"></span> Submitted Solutions: <b style="color: #333;">'.$this->get_task_solutions($tid).'</b> '.$delx.'</p>
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


  public function get_task_solutions($task){
    global $link;
    $q = mysqli_query($link, "SELECT sid FROM solution WHERE tid='$task' AND `status` NOT IN ('0','3') ");
    return mysqli_num_rows($q);
  }


  public function get_companies($search, $pagex){
    global $link;

    $search = clean($link, $search);
    $page = clean($link, $pagex);

    $parameter = '1';
    $pagegets = '';
    if(!empty($search) == true){
      $parameter = "cname LIKE '%$search%'";
      $pagegets = '&q='.$search;
    }

    if(empty($page) == false){
      $checkqx = mysqli_query($link, "SELECT COUNT(*) FROM company WHERE $parameter"); 
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

    $q = mysqli_query($link, "SELECT * FROM company WHERE $parameter ORDER BY `cname` ASC $qlimit");
    $qnum = mysqli_num_rows($q);
    if($qnum == 0){
      $data['company'] = '<p class="text-center">No company found</p>';
      $data['page'] = '';
      $data['range'] = '<p class="text-center mg-b-0">Showing <span>0</span> to <span>0</span> of <span>0</span> Companies</p>';
      return $data;
    }

    $pagg=$comp='';
    $pqx = mysqli_query($link, "SELECT COUNT(*) FROM company WHERE $parameter ");
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
                  <a class="page-link" href="adcompany?page='.($page-1).$pagegets.'" aria-label="Previous"><i class="ion ion-arrow-left-a"></i></a>
                </li>';
    }

    for($i=$start;$i<=($start+4);$i++){
        if($i == $page){
            $pagg .= '<li class="page-item active"><a class="page-link" href="adcompany?page='.$i.$pagegets.'">'.$i.'</a></li>';
        }
        else if($i <= $pqnumx){
            $pagg .= '<li class="page-item"><a class="page-link" href="adcompany?page='.$i.$pagegets.'">'.$i.'</a></li>';   
        }
    }


    if($pqnumx > 1 && $pqnumx > $page){
      $pagg .= '<li class="pag-prev mg-5">
                  <a style="border:none;" class="page-link" href="adcompany?page='.($page+1).$pagegets.'" aria-label="Next"><i class="ion ion-arrow-right-a"></i></a>
                </li>';
    }

    while ($qr = mysqli_fetch_array($q, MYSQLI_ASSOC)) {
      $cid = $qr['cid'];

      if(empty($qr['logo'])){
        $logo = 'p.png';
      }
      else{
        $logo = $qr['logo'];
      }

      if($qr['active'] == 1){
        $state = '<span class="badge-pill badge-success" style="padding:2px 10px; font-size:10px;">Active</span>';
      }
      else if($qr['active'] == 0){
        $state = '<span class="badge-pill badge-light" style="padding:2px 10px; font-size:10px;">Pending</span>';
      }
      else{
        $state = '<span class="badge-pill badge-danger" style="padding:2px 10px; font-size:10px;">Deleted</span>';
      }

      $comp .= '<div class="media align-items-center">
                  <img src="img/avatar/'.$logo.'" class="wd-50 rounded-circle d-flex mg-r-10 mg-xs-r-15 align-self-start" alt="">
                  <div class="media-body">
                    <a href="company_profile?company='.$cid.'"><span class="d-block tx-medium tx-inverse">'.$qr['cname'].'</span></a>
                    <span class="tx-12">'.$qr['location'].' - '.$state.'</span>
                  </div>
                </div>
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

    $data['company'] = $comp;
    $data['page'] = '<div class="ht-80 d-flex align-items-center justify-content-center">
                      <nav aria-label="Page navigation">
                        <ul class="pagination pagination-basic pagination-circle mg-b-0">
                          '.$pagg.'
                        </ul>
                      </nav>
                    </div>';
    $data['range'] = '<p class="text-center mg-b-0">Showing <span>'.$fromnum.'</span> to <span>'.$tonum.'</span> of <span>'.$pqnum.'</span> Companies</p>';

    return $data;
  }


  public function get_students($search, $pagex){
    global $link;

    $search = clean($link, $search);
    $page = clean($link, $pagex);

    $parameter = '1';
    $pagegets = '';
    if(!empty($search) == true){
      $parameter = "username LIKE '%$search%' OR stid IN (SELECT userid FROM appusers WHERE email LIKE '%$search%' AND user_type='s')";
      $pagegets = '&q='.$search;
    }

    if(empty($page) == false){
      $checkqx = mysqli_query($link, "SELECT COUNT(*) FROM students WHERE $parameter"); 
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

    $q = mysqli_query($link, "SELECT * FROM students WHERE $parameter ORDER BY `lname` ASC, `fname` ASC $qlimit");
    $qnum = mysqli_num_rows($q);
    if($qnum == 0){
      $data['company'] = '<p class="text-center">No student found</p>';
      $data['page'] = '';
      $data['range'] = '';
      return $data;
    }

    $pagg=$comp='';
    $pqx = mysqli_query($link, "SELECT COUNT(*) FROM students WHERE $parameter ");
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
                  <a class="page-link" href="students?page='.($page-1).$pagegets.'" aria-label="Previous"><i class="ion ion-arrow-left-a"></i></a>
                </li>';
    }

    for($i=$start;$i<=($start+4);$i++){
        if($i == $page){
            $pagg .= '<li class="page-item active"><a class="page-link" href="students?page='.$i.$pagegets.'">'.$i.'</a></li>';
        }
        else if($i <= $pqnumx){
            $pagg .= '<li class="page-item"><a class="page-link" href="students?page='.$i.$pagegets.'">'.$i.'</a></li>';   
        }
    }


    if($pqnumx > 1 && $pqnumx > $page){
      $pagg .= '<li class="pag-prev mg-5">
                  <a style="border:none;" class="page-link" href="students?page='.($page+1).$pagegets.'" aria-label="Next"><i class="ion ion-arrow-right-a"></i></a>
                </li>';
    }

    while ($qr = mysqli_fetch_array($q, MYSQLI_ASSOC)) {
      $stid = $qr['stid'];

      if(empty($qr['avatar'])){
        $logo = 'p.png';
      }
      else{
        $logo = $qr['avatar'];
      }

      if($qr['active'] == 1){
        $state = '<span class="badge-pill badge-success" style="padding:2px 10px; font-size:10px;">Active</span>';
      }
      else if($qr['active'] == 0){
        $state = '<span class="badge-pill badge-light" style="padding:2px 10px; font-size:10px;">Pending</span>';
      }
      else{
        $state = '<span class="badge-pill badge-danger" style="padding:2px 10px; font-size:10px;">Deleted</span>';
      }

      $comp .= '<div class="media align-items-center">
                  <img src="img/avatar/'.$logo.'" class="wd-50 rounded-circle d-flex mg-r-10 mg-xs-r-15 align-self-start" alt="">
                  <div class="media-body">
                    <a href="profile?student='.$stid.'"><span class="d-block tx-medium tx-inverse">'.$qr['lname'].' '.$qr['fname'].'</span></a>
                    <span class="tx-15">Phone number: <b>'.$qr['phone'].'</b></span>
                    <p><span class="tx-12">'.$qr['school'].' - '.$state.'</span></p>
                  </div>
                </div>
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

    $data['company'] = $comp;
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


  public function get_student_info($apid, $student, $page){
    global $link;

    $apid = clean($link, $apid);
    $cu = $this->get_user_type($apid);
    if($cu['user_type'] != 'a'){
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

    $wq = mysqli_query($link, "SELECT stid FROM students WHERE stid='$stid' AND active='2' ");
    $wnum = mysqli_num_rows($wq);
    if($wnum == 0){
      $activex = '<button onclick="delstudent(\''.$stid.'\')" class="btn btn-warning btn-sm">
                  Deactivate Account
                </button>';
    }else{
      $activex = '<button class="btn btn-danger btn-sm">
                    Deactivated
                </button>';
    }

    $eq = mysqli_query($link, "SELECT email FROM appusers WHERE userid='$stid' AND user_type='s' ");
		$eqr = mysqli_fetch_assoc($eq);

    $taskinfo = $this->get_total_student_tasks($stid);
    $statictics = $this->get_student_statistics($stid);

    $info = '<div class="card shadow-base bd-0 overflow-hidden" style="background-color: #07274f;">
              <div class="pd-x-25 pd-t-25">
                <p class="tx-center">
                  <img src="img/avatar/'.$avatar.'" width="100" class="rounded-circle" alt="">
                </p>
                <h6 class="logged-fullname tx-center" style="color: #fff;">'.$qr['fname'].' '.$qr['lname'].'</h6>
                <p class="tx-center">'.$eqr['email'].'</p>                
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
                  '.$activex.'
                  <a href="pdfcv?student='.$stid.'" target="_blank"><button class="btn btn-primary btn-sm">
                    View CV
                  </button></a>
                </p>
                <hr>
                <label class="tx-10 tx-uppercase tx-mont tx-medium tx-spacing-1 mg-b-2">Username</label>
                <p class="tx-info mg-b-25" style="color: #fff;">'.$qr['username'].'</p>               
                <label class="tx-10 tx-uppercase tx-mont tx-medium tx-spacing-1 mg-b-2">School</label>
                <p class="tx-inverse mg-b-25" style="color: #fff;">'.$qr['school'].'</p>

                <label class="tx-10 tx-uppercase tx-mont tx-medium tx-spacing-1 mg-b-2">Program</label>
                <p class="tx-inverse mg-b-25" style="color: #fff;">'.$qr['program'].'</p>
                <label class="tx-10 tx-uppercase tx-mont tx-medium tx-spacing-1 mg-b-2">Phone Number</label>
                <p class="tx-inverse mg-b-25" style="color: #fff;">'.$qr['phone'].'</p>
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
        $rate = '<span id="sol_'.$qr['sid'].'" style="font-size:14px; margin-right:10px;"><button onclick="ratessolution(\''.$qr['sid'].'\')" class="btn btn-warning btn-sm mg-b-10"><span class="ion ion-android-star-outline" style="color: #fff;"></span> Rate Solution</button></span>';
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


  public function get_tasks($search, $page){
    global $link;

    $search = clean($link, $search);
    $page = clean($link, $page);

    $parameter = '1';
    $pagegets = '';
    if(!empty($search) == true){
      $parameter = "title LIKE '%$search%'";
      $pagegets = '&q='.$search;
    }

    if(empty($page) == false){
      $checkqx = mysqli_query($link, "SELECT COUNT(*) FROM task WHERE $parameter"); 
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

    $q = mysqli_query($link, "SELECT * FROM task WHERE $parameter ORDER BY `title` ASC $qlimit");
    $qnum = mysqli_num_rows($q);
    if($qnum == 0){
      $data['tasks'] = '<p class="text-center">No task found</p>';
      $data['page'] = '';
      $data['range'] = '<p class="text-center mg-b-0">Showing <span>0</span> to <span>0</span> of <span>0</span> Tasks</p>';
      return $data;
    }

    $pagg=$task='';
    $pqx = mysqli_query($link, "SELECT COUNT(*) FROM task WHERE $parameter ");
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
                  <a class="page-link" href="adtasks?page='.($page-1).$pagegets.'" aria-label="Previous"><i class="ion ion-arrow-left-a"></i></a>
                </li>';
    }

    for($i=$start;$i<=($start+4);$i++){
        if($i == $page){
            $pagg .= '<li class="page-item active"><a class="page-link" href="adtasks?page='.$i.$pagegets.'">'.$i.'</a></li>';
        }
        else if($i <= $pqnumx){
            $pagg .= '<li class="page-item"><a class="page-link" href="adtasks?page='.$i.$pagegets.'">'.$i.'</a></li>';   
        }
    }


    if($pqnumx > 1 && $pqnumx > $page){
      $pagg .= '<li class="pag-prev mg-5">
                  <a style="border:none;" class="page-link" href="adtasks?page='.($page+1).$pagegets.'" aria-label="Next"><i class="ion ion-arrow-right-a"></i></a>
                </li>';
    }

    while ($qr = mysqli_fetch_array($q, MYSQLI_ASSOC)) {
      $cid = $qr['cid'];
      $tid = $qr['tid'];
			$cq = mysqli_query($link, "SELECT cname FROM company WHERE cid='$cid'");
			$cqr = mysqli_fetch_assoc($cq);

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
                <p class="card-subtitle"><a class="stylename" href="company_profile?company='.$cid.'"><b style="font-size: 17px;color: #333;">'.$cqr['cname'].'</b></a> - <i style="color: #237ad4;font-size: 12px;">'.$timepost.'</i></p>								
								<p class="card-text">'.$qr['summary'].'</p>
								<p class="card-subtitle"><span class="icon ion-ios-clock-outline" style="font-size: 20px;"></span> Deadline: <b style="color: #333;">'.$qr['days'].' days</b></p>
                <p class="card-subtitle"><span class="icon ion-ios-list-outline" style="font-size: 20px;"></span> Submitted Solutions: <b style="color: #333;">'.$this->get_task_solutions($tid).'</b></p>
                <p class="text-right"><a href="adtasks?task='.$tid.'" class="btn btn-primary mg-b-10">View</a></p>
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

    $data['tasks'] = $task;
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


  public function task_info($task){
    global $link;

    $tid = clean($link, $task);

    $q = mysqli_query($link, "SELECT * FROM task WHERE tid='$tid' ");
    $qnum = mysqli_num_rows($q);
    if($qnum == 0){
      return '<p class="text-center">Invalid task information</p>';
    }

    $qr = mysqli_fetch_assoc($q);
    $cid = $qr['cid'];
    $cq = mysqli_query($link, "SELECT cname FROM company WHERE cid='$cid'");
    $cqr = mysqli_fetch_assoc($cq);

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
    
    return '<h6 class="card-title">'.$qr['title'].'</h6>
                <p class="card-subtitle"><a class="stylename" href="company_profile?company='.$cid.'"><b style="font-size: 17px;color: #333;">'.$cqr['cname'].'</b></a> - <i style="color: #237ad4;font-size: 12px;">'.$timepost.'</i></p>								
								<p class="card-text">'.$qr['summary'].'</p>
								<p class="card-subtitle"><span class="icon ion-ios-clock-outline" style="font-size: 20px;"></span> Deadline: <b style="color: #333;">'.$qr['days'].' days</b></p>
                <p class="card-subtitle"><span class="icon ion-ios-list-outline" style="font-size: 20px;"></span> Submitted Solutions: <b style="color: #333;">'.$this->get_task_solutions($tid).'</b></p>
                <hr>';

  }


  public function get_tasks_submitters($task, $search, $page){
    global $link;

    $search = clean($link, $search);
    $page = clean($link, $page);
    $tid = clean($link, $task);

    $parameter = '';
    $pagegets = '';
    if(!empty($search) == true){
      $parameter = "AND username LIKE '%$search%'";
      $pagegets = '&q='.$search;
    }

    if(empty($page) == false){
      $checkqx = mysqli_query($link, "SELECT COUNT(*) FROM students WHERE stid IN (SELECT stid FROM solution WHERE tid='$tid' AND `status` NOT IN ('0','3')) $parameter"); 
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

    $q = mysqli_query($link, "SELECT * FROM students WHERE stid IN (SELECT stid FROM solution WHERE tid='$tid' AND `status` NOT IN ('0','3')) $parameter ORDER BY `username` ASC $qlimit");
    $qnum = mysqli_num_rows($q);
    if($qnum == 0){
      $data['tasks'] = '<p class="text-center">No students found</p>';
      $data['page'] = '';
      $data['range'] = '<p class="text-center mg-b-0">Showing <span>0</span> to <span>0</span> of <span>0</span> Tasks</p>';
      return $data;
    }

    $pagg=$list='';
    $pqx = mysqli_query($link, "SELECT COUNT(*) FROM students WHERE stid IN (SELECT stid FROM solution WHERE tid='$tid' AND `status` NOT IN ('0','3') ORDER BY send_date) $parameter ");
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
                  <a class="page-link" href="adtasks?task='.$tid.'&page='.($page-1).$pagegets.'" aria-label="Previous"><i class="ion ion-arrow-left-a"></i></a>
                </li>';
    }

    for($i=$start;$i<=($start+4);$i++){
        if($i == $page){
            $pagg .= '<li class="page-item active"><a class="page-link" href="adtasks?task='.$tid.'&page='.$i.$pagegets.'">'.$i.'</a></li>';
        }
        else if($i <= $pqnumx){
            $pagg .= '<li class="page-item"><a class="page-link" href="adtasks?task='.$tid.'&page='.$i.$pagegets.'">'.$i.'</a></li>';   
        }
    }


    if($pqnumx > 1 && $pqnumx > $page){
      $pagg .= '<li class="pag-prev mg-5">
                  <a style="border:none;" class="page-link" href="adtasks?task='.$tid.'&page='.($page+1).$pagegets.'" aria-label="Next"><i class="ion ion-arrow-right-a"></i></a>
                </li>';
    }

    while ($qr = mysqli_fetch_array($q, MYSQLI_ASSOC)) {
      $stid = $qr['stid'];

      $sq = mysqli_query($link, "SELECT send_date FROM solution WHERE tid='$tid' AND stid='$stid' ");
      $sqr = mysqli_fetch_assoc($sq);

			$datepost = strtotime(date("Y-m-d", strtotime($sqr['send_date'])));
      $tdate = strtotime(date("Y-m-d", time()));
      $datedif = $tdate - $datepost;
      if($datedif < 86400){
          $timepost = 'Today '.date("g:i A",strtotime($sqr['send_date']));
      }
      else if($datedif >= 86400 && $datedif < 172800){
          $timepost = 'Yesterday '.date("g:i A",strtotime($sqr['send_date']));
      }
      else if($datedif >= 31104000){
          $timepost = date("jS M, Y",strtotime($sqr['send_date']));
      }
      else{
          $timepost = date("jS M",strtotime($sqr['send_date']));
			}
			

			$list .= '<h6 class="card-title"><a href="profile?student='.$qr['stid'].'">'.$qr['fname'].' '.$qr['lname'].'</a></h6>
                <p class="card-subtitle">'.$qr['username'].'</p>
                <p class="card-subtitle"><span class="icon ion-ios-clock-outline" style="font-size: 20px;"></span> Submitted: <b style="color: #333;">'.$timepost.'</b></p>								
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

    $data['tasks'] = $list;
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


  public function get_task_solutions_total($task){
		global $link;
		$q = mysqli_query($link, "SELECT `sid` FROM solution WHERE tid='$task' AND `status` NOT IN ('0','3') ");
		return mysqli_num_rows($q);
	}


  public function admins(){
    global $link;

    $admins['active']=$admins['total']= 0;
    $q = mysqli_query($link, "SELECT COUNT(aid) as admins, active FROM `admin` WHERE 1 GROUP BY active ");
    $qnum = mysqli_num_rows($q);
    if($qnum == 0){
      return $admins;
    }

    $total = 0;
    while ($qr = mysqli_fetch_array($q, MYSQLI_ASSOC)) {
      if($qr['active'] == 1){
        $admins['active'] = $qr['admins'];
      }
      $total += $qr['admins'];
    }

    $admins['total'] = $total;
    return $admins;
  }



  public function add_admin($fname, $lname, $mname, $email, $level, $admin){
    global $link;

    $fname = clean($link, $fname);
    $mname = clean($link, $mname);
    $lname = clean($link, $lname);
    $email = clean($link, $email);
    $level = clean($link, $level);
    $admin = clean($link, $admin);

    $ec = $this->email_validate($email);
    if($ec==1){
      return false.'|Email already exist';
    }

    $adminlevel = $this->admin_level($admin);
    if($adminlevel != 1){
      return false.'|You do not have the privilege to perform this action';
    }

    if($level == 1){
      $uq = mysqli_query($link, "UPDATE admin SET level='2' WHERE level='1' ");
    }
      $timenow = date("Y-m-d H:i:s", time());
      $q = mysqli_query($link, "INSERT INTO admin(`fname`,`mname`,`lname`,`level`,`date`) VALUES('$fname','$mname','$lname','$level','$timenow')");
      if($q){
        $uid = mysqli_insert_id($link);

        $pword = 'cediplus'.time();
        $encrypt = md5($pword);
        $mpword = 'cediplus'.substr($encrypt,0,5);
        $password = md5($mpword);

        $qz = mysqli_query($link, "INSERT INTO appusers(`userid`,`email`,`password`,`user_type`) VALUES('$uid', '$email', '$password', 'a')");
        if($qz){
          $fullname = $lname.' '.$fname;

          $action = 'added';
          $description = 'added an admin with aid: '.$uid.' and full name: '.$fullname;
          $this->action_log($admin,$action,$description);
 
          $this->send_email($email, $mpword, $fullname);
          return true;
        }
        else{
          return false.'|Error adding admin. Try again';
        }
      }
      else{
        return false.'|Error adding admin. Try again';
      }
  }



  public function get_transactions($apid, $search, $pagex){
		global $link;

		$apid = clean($link, $apid);
		$st = $this->get_user_type($apid);
		if($st['user_type'] != 'a'){
			$data['list'] = '<p class="text-center">Sorry, you do not have the privilege to access this information</p>';
      $data['page'] = '';
      $data['range'] = '';
      return $data;
		}

    $search = clean($link, $search);
    $page = clean($link, $pagex);

    $parameter = '1';
    $pagegets = '';
    if(!empty($search) == true){
      $parameter = "(wallet LIKE '%$search%' OR invoice_num LIKE '%$search%' OR transaction_num LIKE '%$search%') ";
      $pagegets = '&q='.$search;
    }

    if(empty($page) == false){
      $checkqx = mysqli_query($link, "SELECT COUNT(*) FROM `transaction` WHERE $parameter"); 
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

		$q = mysqli_query($link, "SELECT * FROM `transaction` WHERE $parameter ORDER BY `date` DESC $qlimit ");
		$qnum = mysqli_num_rows($q);
		if($qnum == 0){
			$data['list'] = '<p class="text-center">No transactions found</p>';
      $data['page'] = '';
      $data['range'] = '';
      return $data;
		}

		$pagg=$trans='';
    $pqx = mysqli_query($link, "SELECT COUNT(*) FROM `transaction` WHERE $parameter ");
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
      
      $uapid = $qr['apid'];
      $ut = $this->get_user_type($uapid);
		  if($ut['user_type'] == 's'){
        $usx = $this->user_data($uapid, "fname,lname");
        $fname = $usx['fname'].' '.$usx['lname'];
        $utype = '<span class="badge-pill bg-primary tx-white tx-12" style="padding: 2px 5px;border-radius: 2px;">S</span>';
      }else{
        $usx = $this->user_data($uapid, "cname");
        $fname = $usx['cname'];
        $utype = '<span class="badge-pill bg-info tx-white tx-12" style="padding: 2px 5px;border-radius: 2px;">C</span>';
      }

      $trans .= '<tr>
                  <td>'.$utype.' '.$fname.'</td>
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
												<th>User Info.</th>
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



  public function update_admin($fname, $lname, $mname, $email, $level, $upadmin, $admin){
    global $link;

    $fname = clean($link, $fname);
    $mname = clean($link, $mname);
    $lname = clean($link, $lname);
    $email = clean($link, $email);
    $level = clean($link, $level);
    $admin = clean($link, $admin);
    $upadmin = clean($link, $upadmin);

    $eq = mysqli_query($link, "SELECT apid FROM appusers WHERE email='$email' AND (userid !='$upadmin' AND user_type='a') ");
    $eqnum = mysqli_num_rows($eq);
    if($eqnum == 1){
      return false.'|Email already exist';
    }

    $adminlevel = $this->admin_level($admin);
    if($adminlevel != 1){
      return false.'|You do not have the privilege to perform this action';
    }

    if($level == 1){
      $uq = mysqli_query($link, "UPDATE admin SET level='2' WHERE level='1' ");
    }

      $q = mysqli_query($link, "UPDATE admin SET level='$level',fname='$fname',mname='$mname',lname='$lname' WHERE aid='$upadmin' ");
      if($q){
        
        $qz = mysqli_query($link, "UPDATE appusers SET email='$email' WHERE userid='$upadmin' AND user_type='a' ");
        if($qz){
          $fullname = $lname.' '.$fname;
          $action = 'updated';
          $description = 'updated the info of an admin with aid: '.$upadmin.' and full name: '.$fullname;
          $this->action_log($admin,$action,$description);

          return true;
        }
        else{
          return false.'|Error updating admin. Try again';
        }
      }
      else{
        return false.'|Error updating admin. Try again';
      }
  }


  public function email_validate($email){
    global $link;

    $email = clean($link, $email);
    $q = mysqli_query($link, "SELECT apid FROM appusers WHERE email='$email' ");

    return  mysqli_num_rows($q);
  }



  public function send_email($email, $company, $token){
    global $baseUrl;
    $to = $email;
    $from = 'info@myrookery.com';
    $subject = 'Rook+ | Account Activation';

    $message = '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
                                    Hi <strong style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">'.$company.'</strong>,
                                  </td>
                                </tr><tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;" valign="top">
                                    <p>Welcome to Rook+, this is an application service that seeks to link every human resource officer and office to every major tertiary institution on the platform and thus make it easier for these offices to pursue their human resource agendas.</p>
                                    <p>An account has been created for you, click the button below to set your <strong style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;">password and activate</strong> your account.</p> 
                                    <hr>
                                  </td>
                                </tr><tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;text-align: center;" valign="top">
                                    <a href="'.$baseUrl.'/compact?t='.$token.'" class="btn-primary" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; color: #FFF; text-decoration: none; line-height: 2em; font-weight: bold; text-align: center; cursor: pointer; display: inline-block; border-radius: 5px; text-transform: capitalize; background-color: #5fbeaa; margin: 0; border-color: #5fbeaa; border-style: solid; border-width: 10px 20px;">Activiate Account</a>
                                  </td>
                                </tr><tr style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; margin: 0;"><td class="content-block" style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0; padding: 0 0 20px;text-align: center;" valign="top">
                                    Thanks for choosing Rook+.
                                  </td>
                                </tr></table></td>
                          </tr></table></div>
                    </td>
                    <td style="font-family: \'Helvetica Neue\',Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; margin: 0;" valign="top"></td>
                  </tr></table></body>
                </html>';

    $to = $email; 
		$xheaders = "From: Rook+  <$from>\n"; 
		$xheaders .= "X-Sender: <$from>\n"; 
		$xheaders .= 'X-Mailer: PHP/' . phpversion();
		$xheaders .='Reply-To: '. $to . "\n" ;
		$xheaders .= "X-Priority: 1\n";
		$xheaders .= "Content-Type:text/html; charset=iso-8859-1\n";

    if(mail($to, $subject, $message, $xheaders)){
      return 1;
    }
    return 0;
  }


  public function admin_level($admin){
    global $link;

    $admin = clean($link, $admin);

    $q = mysqli_query($link, "SELECT level FROM admin WHERE aid='$admin' ");
    $qr = mysqli_fetch_assoc($q);
    return $qr['level'];
  }



  public function admin_info($admin){
    global $link;

    $admin = clean($link, $admin);

    $q = mysqli_query($link, "SELECT * FROM admin WHERE aid='$admin' ");
    $qnum = mysqli_num_rows($q);
    if($qnum == 0){
      return 'Invalid info';
    }
    $eq = mysqli_query($link, "SELECT email FROM appusers WHERE userid='$admin' AND user_type='a' ");
    $eqr = mysqli_fetch_assoc($eq);

    $qr = mysqli_fetch_assoc($q);

    return 'done|<div class="row">
              <div class="col-lg-4 offset-lg-4 col-md-4 offset-md-4 col-sm-6 offset-sm-3">
                <div id="closebut" onclick="closepop()">
                  <span class="mdi mdi-close"></span>
                </div>
                <div class="midbxcnt">
                  <div class="midbx">
                    <p style="text-align: center;font-size: 35px;margin-bottom: 0;">
                      <i class="ti-id-badge"></i>
                    </p>
                    <p style="text-align: center;">Edit Administrator Info</p>
                    <hr>
                    <form class="form-horizontal m-t-20" method="POST" action="" data-parsley-validate>
                      <div class="form-group row">
                        <div class="col-12">
                          <input class="form-control" name="fname" type="text" value="'.$qr['fname'].'" required="" placeholder="First Name">
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="col-12">
                          <input class="form-control" name="mname" type="text" value="'.$qr['mname'].'" placeholder="Middle Name">
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="col-12">
                          <input class="form-control" name="lname" type="text" value="'.$qr['lname'].'" required="" placeholder="Last Name">
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="col-12">
                          <input class="form-control" name="email" type="email" value="'.$eqr['email'].'" required="" placeholder="Email">
                        </div>
                      </div>
                      <div class="form-group row">
                        <div class="col-12">
                          <input type="number" class="form-control"  placeholder="Level" value="'.$qr['level'].'" name="level" required> 
                        </div>
                      </div>
                      <input type="hidden" value="'.$admin.'" name="upadmin">
                      <div class="form-group text-center row m-t-20">
                        <div class="col-12">
                          <button class="btn btn-primary btn-block waves-effect waves-light" name="editadmin" type="submit">Submit</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>';
  }



  public function admin_status($aid,$type,$admin){
    global $link;

    $aid = clean($link, $aid);
    $type = clean($link, $type);
    $admin = clean($link, $admin);

    $adminlevel = $this->admin_level($admin);
    if($adminlevel != 1){
      return 'You do not have the privilege to perform this action';
    }

    if($type == 'delete'){
      $x = 2;
    }
    else if($type == 'activate'){
      $x = 1;
    }
    else{
      return 'Invalid Info';
    }

    $q = mysqli_query($link, "UPDATE admin SET active='$x' WHERE aid='$aid' AND level != '1' ");
    if($q){
      return 'done';
    }
    return 'Error updating status';
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


  public function add_company($apid, $bio, $cname, $locat, $email, $address, $logo, $logo_temp){
    global $link;

    $apid = clean($link, $apid);
    $st = $this->get_user_type($apid);
    if($st['user_type'] != 'a'){
      return 'Sorry, you do not have the privilege to perform this action';
    }
    $cname = clean($link, $cname);
    $location = clean($link, $locat);
    $email = clean($link, $email);
    $address = clean($link, $address);
    $bio = clean($link, $bio);


    $cq = mysqli_query($link, "SELECT cid FROM company WHERE email='$email' ");
    $cqnum = mysqli_num_rows($cq);
    if($cqnum > 0){
      return 'Company already exists';
    }

    $file = $this->uploadfile($logo,$logo_temp);
    if($file != '0'){
      $token = $this->tokenizer();
      $timenow = date("Y-m-d H:i:s", time());
      $inq = mysqli_query($link, "INSERT INTO company(cname,location,email,address,bio,logo,`date`,passcode) VALUES('$cname', '$location', '$email', '$address', '$bio', '$file', '$timenow','$token')");
      if($inq){
        $cid = mysqli_insert_id($link);
        $sendmail = $this->send_email($email, $cname, $token);
        if($sendmail){
          $tid = 'company='.$cid;
          $sq = mysqli_query($link, "SELECT apid,email,firebase FROM appusers WHERE userid IN (SELECT stid FROM students WHERE activte='1') AND user_type='s'");
          $sqnum = mysqli_num_rows($sq);
          if($sqnum > 0){      
            $ut = new Utility();
            $tokens = array();
            while($sqr = mysqli_fetch_array($sq, MYSQLI_ASSOC)){
              $user = $sqr['apid'];
              $note = '<b>'.$cname.'</b> just joined Rook+.';
              $inq = mysqli_query($link, "INSERT INTO `notification`(`apid`,`ntype`,`note_id`,`note`,`date`) VALUES('$user', 't', '$tid', '$note', '$timenow') ");
              
              if(!empty($sqr['firebase'])){
                array_push($tokens, $sqr['firebase']);
                $title = $cname.' just joined Rook+';    
                $body = nl2br($summary);          
              }
              

              $email = $sqr['email'];
              $message = $note.'<br><p><b>'.$title.'</b></p><br><p>'.nl2br($summary).'</p>';
              $this->send_email($email, "New Company", $message);
            }

            if(!empty($tokens)){
              $note['title'] = $title;    
              $note['body'] = $body;
              $note['click_action'] = 'MAIN_ACTIVITY';
              $note['android_channel_id'] = 'company';
              $data['type'] = "rook_company";
              $ut->send_mass_firebase_notification($tokens, $note, $data);
            }
          }
          return 1;
        }
        return 'Error sending mail';
      }
      return 'Error add Company...try again';
    }
    return 'Error uploading Company logo';
  }


  public function checkfile($filename,$filesize){

    $allow = array('png','jpeg','jpg');
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
  


  public function uploadfile($filename,$filetmp){

      $allow = array('png','jpeg','jpg');
      $bits = explode('.',$filename);
      $file_extn = strtolower(end($bits));
      $move = $this->save_crop($filetmp,$file_extn);
      if(!$move){
          return '0';
      }
      return $move;
  }


  public function save_crop($filename,$type){
    $data = getimagesize($filename);


    $width = $data[0];
    $height = $data[1];

    if($width > $height){
      $lenght = $data[1] - ($data[1] * 0.20);
    }

    else if($width < $height){
      $lenght = $data[0] - ($data[0] * 0.20);
    }

    else{
      $lenght = $data[0];
    }

     $filenamex = 'rookComp'.substr(md5(time().rand(10000,99999)), 0, 15).'.'.$type;
    $cropped = 'img/avatar/'.$filenamex;

    if($this->crop_center($filename, $cropped, $lenght, $lenght, $type)){
      return $filenamex;
    }
    return false;
    
  }


  public function crop_center($file, $cropped, $crop_width, $crop_height, $type) {
    if(copy($file, $cropped)) {
      // READ WIDTH & HEIGHT OF ORIGINAL IMAGE
      list($current_width, $current_height) = getimagesize($file);
      
      // CENTER OF GIVEN IMAGE, WHERE WE WILL START THE CROPPING
      $left = ($current_width / 2) - ($crop_width / 2);
      $top  = ($current_height / 2) - ($crop_height / 2);

      if($type == 'jpg' || $type == 'jpeg'){
        // BUILD AN IMAGE WITH CROPPED PART
        $new_canvas = imagecreatetruecolor($crop_width, $crop_height);
        $new_image = imagecreatefromjpeg($cropped);

        imagecopy($new_canvas, $new_image, 0, 0, $left, $top, $current_width, $current_height);
        imagejpeg($new_canvas, $cropped, 100);
      }
      else if($type == 'png'){
        // BUILD AN IMAGE WITH CROPPED PART
        $new_canvas = imagecreatetruecolor($crop_width, $crop_height);
        $new_image = imagecreatefrompng($cropped);

        imagecopy($new_canvas, $new_image, 0, 0, $left, $top, $current_width, $current_height);
        imagepng($new_canvas, $cropped, 9);
      }
    }
    return true;
  }


  public function delete_company($apid, $company){
    global $link;

    $apid = clean($link, $apid);
    $st = $this->get_user_type($apid);
    if($st['user_type'] != 'a'){
      return 'Sorry, you do not have the privilege to perform this action';
    }
    $cid = clean($link, $company);

    $cq = mysqli_query($link, "SELECT cid FROM company WHERE cid='$cid' ");
    $cqnum = mysqli_num_rows($cq);
    if($cqnum == 0){
      return 'Invalid company information';
    }

    $dtq = mysqli_query($link, "UPDATE task SET delete_task='1' WHERE cid='$cid' ");
    if($dtq){
      $dcq = mysqli_query($link, "UPDATE company SET active='2' WHERE cid='$cid' ");
      if($dcq){
        return 'done';
      }
      return 'Error deleting company...try again';
    }
    return 'Error deleting company...try again';
  }


  public function delete_student($apid, $student){
    global $link;

    $apid = clean($link, $apid);
    $st = $this->get_user_type($apid);
    if($st['user_type'] != 'a'){
      return 'Sorry, you do not have the privilege to perform this action';
    }
    $stid = clean($link, $student);

    $cq = mysqli_query($link, "SELECT stid FROM students WHERE stid='$stid' ");
    $cqnum = mysqli_num_rows($cq);
    if($cqnum == 0){
      return 'Invalid company information';
    }

    $dq = mysqli_query($link, "UPDATE students SET active='2' WHERE stid='$stid' ");
    if($dq){
        return 'done';
    }
    return 'Error deleting student...try again';
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
  

  public function download_cv($apid, $student){
		global $link;

		$apid = clean($link, $apid);
		$stid = clean($link, $student);
		$st = $this->get_user_type($apid);
		if($st['user_type'] != 'a'){
			return '<div class="col-lg-12 mg-t-20 mg-lg-t-0">
								<div class="card bd-0 shadow-base">
									<div class="pd-x-25 pd-t-25">
										<p class="text-center">Sorry, you do not have the privilege to access this information</p>
									</div>
								</div>
							</div>';
    }
    
    $q = mysqli_query($link, "SELECT * FROM students WHERE stid='$stid' ");
    $qnum = mysqli_num_rows($q);
    if($qnum == 0){
      return '<div class="col-lg-12 mg-t-20 mg-lg-t-0">
								<div class="card bd-0 shadow-base">
									<div class="pd-x-25 pd-t-25">
										<p class="text-center">Invalid info</p>
									</div>
								</div>
							</div>';
    }

    $info = mysqli_fetch_assoc($q);
    if(empty($info['username'])){
      return '<div class="col-lg-12 mg-t-20 mg-lg-t-0">
								<div class="card bd-0 shadow-base">
									<div class="pd-x-25 pd-t-25">
										<p class="text-center">Student\'s account is not active </p>
									</div>
								</div>
							</div>';
    }

		$statictics = $this->get_student_statistics($stid);
		$taskinfo = $this->get_total_student_tasks($stid);

		$cmq = mysqli_query($link, "SELECT `cname`, `location` FROM company WHERE cid IN (SELECT cid FROM subscribe WHERE stid='$stid' ) ORDER BY `cname` ASC ");
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
		
		
		
    $eq = mysqli_query($link, "SELECT email FROM appusers WHERE userid='$stid' AND user_type='s' ");
		$em = mysqli_fetch_assoc($eq);

    
    $this->qrcode_generate($info['username']);
    if($info['gender'] == 'f'){
			$gender = 'Female';
		}else{
			$gender = 'Male';
		}

		if(empty($info['city'])){
			$info['city'] = 'City';
		}

		if(empty($info['postal'])){
			$info['postal'] = 'N/A';
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


		return '<div class="col-lg-8 col-lg-offset-2 mg-t-20 mg-lg-t-0">
							<div class="card bd-0 shadow-base">
								<div class="pd-x-25 pd-t-25">
									<p><img alt="" src="assets/images/logo.png" width="150"></p>
									<hr>
									<div class="row">
										<div class="col-md-8">
											<h4 class="tx-inverse tx-semibold tx-spacing-1 mg-b-20">'.$info['fname'].' '.$info['lname'].'</h4>
											<p class="tx-14 mg-b-0">Date of Birth: <b>'.date("jS M, Y",strtotime($info['dob'])).'</b></p>
											<p class="tx-14 mg-b-0">Gender: <b>'.$gender.'</b></p>
											<p class="tx-14 mg-b-0">Email: <b>'.$em['email'].'</b></p>
											<p class="tx-14 mg-b-0">Phone: <b>+'.$info['phone'].'</b></p>
											<p class="tx-14 mg-b-0">Postal Address: <b>'.$info['postal'].'</b></p>
											<p class="tx-14 mg-b-0">Location: <b>'.$info['city'].'/'.$info['state'].'/'.$cqr['country_name'].'</b></p>
										</div>
										<div class="col-md-4">
											<p class="text-right mg-b-0"><img alt="" src="qrcode/'.$info['username'].'.svg" width="100"></p>
											<p class="text-right tx-primary">Scan to view online version</p>
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
									<h6 class="mg-b-20" style="font-weight:400">Total Points: <b>'.$this->get_student_points($apid).'</b></h6>
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
  

  public function qrcode_generate($username){
		global $link,$baseUrl;

		$fileName = $username.'.svg';
		$string = $baseUrl.'/cv?cv='.$username.'';
		
		$path = 'qrcode/'.$fileName;
		if(file_exists($path)){
			unlink($path);
		}
		QRcode::svg($string, $path); 
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

}


?>