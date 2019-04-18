<?php
require('connect.php');
include('qrcode/qrlib.php');
class User{


	public function menu_switch($user, $page){
		if($user == 'a'){
			$p_admin=$p_adcompany=$p_adtranscations=$p_adstudent=$p_administrators=$p_task='';
			switch ($page) {
				case 1:
					$p_admin = 'active';
					break;
				case 2:
					$p_adcompany = 'active';
					break;
				case 3:
					$p_adtranscations = 'active';
					break;
				case 4:
					$p_adstudent = 'active';
					break;
				case 5:
					$p_administrators = 'active';
					break;
				case 6:
					$p_task = 'active';
					break;
				default:
					/**/
					break;
			}

			$menu = '<ul class="br-sideleft-menu">
		            <li class="br-menu-item">
		              <a href="admin" class="br-menu-link '.$p_admin.'">
		                <i class="menu-item-icon icon ion-ios-home-outline tx-24"></i>
		                <span class="menu-item-label">Dashboard</span>
		              </a>
		            </li>
		            <li class="br-menu-item">
		              <a href="students" class="br-menu-link '.$p_adstudent.'">
		                <i class="menu-item-icon icon ion-android-people tx-24"></i>
		                <span class="menu-item-label">Students</span>
		              </a>
		            </li>
		            <li class="br-menu-item">
		              <a href="adcompany" class="br-menu-link '.$p_adcompany.'">
		                <i class="menu-item-icon icon ion-ios-people-outline tx-24"></i>
		                <span class="menu-item-label">Companies</span>
		              </a>
								</li>
								<li class="br-menu-item">
		              <a href="adtasks" class="br-menu-link '.$p_task.'">
										<i class="menu-item-icon icon ion-ios-list-outline tx-24"></i>
		                <span class="menu-item-label">Tasks</span>
		              </a>
		            </li>
		            <li class="br-menu-item">
		              <a href="transactions" class="br-menu-link '.$p_adtranscations.'">
		                <i class="menu-item-icon icon ion-ios-list tx-24"></i>
		                <span class="menu-item-label">Transactions</span>
		              </a><!-- br-menu-link -->
		            </li>
		            <!--<hr style="border-top:1px solid rgba(255, 255, 255, 0.52);">
		            <li class="br-menu-item">
		              <a href="mycv" class="br-menu-link '.$p_administrators.'">
		                <i class="menu-item-icon icon ion-ios-person tx-24"></i>
		                <span class="menu-item-label">Administrators</span>
		              </a>
		            </li>-->
		          </ul>';
		  return $menu;
		}
		else if($user == 'c'){
			$p_hub=$p_ctasks=$p_ctranscations=$p_watchlist=$p_companyprofile=$p_internship='';
			switch ($page) {
				case 1:
					$p_hub = 'active';
					break;
				case 2:
					$p_ctasks = 'active';
					break;
				case 3:
					$p_ctranscations = 'active';
					break;
				case 4:
					$p_watchlist = 'active';
					break;
				case 5:
					$p_companyprofile = 'active';
				break;
				case 6:
					$p_internship = 'active';
				break;
				default:
					/**/
					break;
			}

			$menu = '<ul class="br-sideleft-menu">
		            <li class="br-menu-item">
		              <a href="hub" class="br-menu-link '.$p_hub.'">
		                <i class="menu-item-icon icon ion-ios-home-outline tx-24"></i>
		                <span class="menu-item-label">Dashboard</span>
		              </a>
		            </li>
		            <li class="br-menu-item">
		              <a href="ctask" class="br-menu-link '.$p_ctasks.'">
		                <i class="menu-item-icon icon ion-ios-list-outline tx-24"></i>
		                <span class="menu-item-label">Tasks</span>
		              </a>
		            </li>
		            <li class="br-menu-item">
		              <a href="transactions" class="br-menu-link '.$p_ctranscations.'">
		                <i class="menu-item-icon icon ion-ios-list tx-24"></i>
		                <span class="menu-item-label">Transactions</span>
		              </a>
		            </li>
		            <li class="br-menu-item">
		              <a href="watchlist" class="br-menu-link '.$p_watchlist.'">
		                <i class="menu-item-icon icon ion-ios-eye tx-24"></i>
		                <span class="menu-item-label">Watch List</span>
		              </a>
								</li>
								<li class="br-menu-item">
		              <a href="internship" class="br-menu-link '.$p_internship.'">
		                <i class="menu-item-icon  ion-ios-personadd-outline tx-24"></i>
		                <span class="menu-item-label">Internship</span>
									</a>
								</li>
								<li class="br-menu-item">
		              <a href="company_profile" class="br-menu-link '.$p_companyprofile.'">
		                <i class="menu-item-icon icon ion-ios-people-outline tx-24"></i>
		                <span class="menu-item-label">Company Profile</span>
		              </a>
		            </li>
		          </ul>';
		  return $menu;
		}
		else if($user == 's'){
			$p_dashboard=$p_task=$p_companies=$p_mycv=$p_myprofile=$p_transaction=$p_internship='';
			switch ($page) {
				case 1:
					$p_dashboard = 'active';
					break;
				case 2:
					$p_task = 'active';
					break;
				case 3:
					$p_companies = 'active';
					break;
				case 4:
					$p_mycv = 'active';
					break;
				case 5:
					$p_myprofile = 'active';
					break;
				case 6:
					$p_transaction = 'active';
					break;
				case 7:
					$p_internship = 'active';
				break;
				default:
					/**/
					break;
			}

			$menu = '<ul class="br-sideleft-menu">
		            <li class="br-menu-item">
		              <a href="dashboard" class="br-menu-link '.$p_dashboard.'">
		                <i class="menu-item-icon icon ion-ios-home-outline tx-24"></i>
		                <span class="menu-item-label">Dashboard</span>
		              </a>
		            </li>
		            <li class="br-menu-item">
		              <a href="task" class="br-menu-link '.$p_task.'">
		                <i class="menu-item-icon icon ion-ios-list-outline tx-24"></i>
		                <span class="menu-item-label">Tasks</span>
		              </a>
		            </li>
		            <li class="br-menu-item">
		              <a href="companies" class="br-menu-link '.$p_companies.'">
		                <i class="menu-item-icon icon ion-ios-people-outline tx-24"></i>
		                <span class="menu-item-label">Companies</span>
		              </a>
								</li>
								<li class="br-menu-item">
		              <a href="transactions" class="br-menu-link '.$p_transaction.'">
		                <i class="menu-item-icon icon ion-ios-list tx-24"></i>
		                <span class="menu-item-label">Transactions</span>
		              </a>
		            </li>
		            <li class="br-menu-item">
		              <a href="cv" class="br-menu-link '.$p_mycv.'">
		                <i class="menu-item-icon icon ion-ios-paper tx-24"></i>
		                <span class="menu-item-label">My CV</span>
		              </a>
								</li>
								<li class="br-menu-item">
		              <a href="internship" class="br-menu-link '.$p_internship.'">
		                <i class="menu-item-icon  ion-ios-personadd-outline tx-24"></i>
		                <span class="menu-item-label">Internship</span>
		              </a>
								</li>
		            <li class="br-menu-item">
		              <a href="profile" class="br-menu-link '.$p_myprofile.'">
		                <i class="menu-item-icon icon ion-ios-person tx-24"></i>
		                <span class="menu-item-label">My Profile</span>
		              </a>
		            </li>';
		  return $menu;
		}
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


	public function honey_pot(){
		global $link;
		
		$q = mysqli_query($link, "SELECT * FROM task WHERE 1 ORDER BY RAND() LIMIT 5");
		$qnum = mysqli_num_rows($q);
		if($qnum == 0){
			return '<p class="text-center">No tasks found</p>
							<p class="text-center"><a href="companies"><button class="btn btn-primary mg-b-10">Subscribe to a Company?</button></a></p>';
		}

		$task='';
		while ($qr = mysqli_fetch_array($q, MYSQLI_ASSOC)) {
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

			$task .= '<h6 class="card-title">'.$qr['title'].'</h6>
                <p class="card-subtitle"><a class="stylename" href="company_profile?company='.$cid.'"><b style="font-size: 17px;color: #333;">'.$cqr['cname'].'</b></a> - <i style="color: #237ad4;font-size: 12px;">'.$timepost.'</i></p>
                <p class="card-text">'.$qr['summary'].'</p>
                <hr>';
		}
		return $task;
	}


	public function get_notifications($apid){
		global $link;

		$apid = clean($link, $apid);
		$st = $this->get_user_type($apid);
		if($st['user_type'] != 's'){
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
				$notes .= '<a href="company_profile?'.$qr['note_id'].'" class="media-list-link read">
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


	public function subscription($apid){
		global $link;

		$apid = clean($link, $apid);
		$st = $this->get_user_type($apid);
		if($st['user_type'] == 's'){
			$stid = $st['userid'];

			$q = mysqli_query($link, "SELECT subscription, `date`,fname FROM students WHERE stid='$stid' ");
			$qr = mysqli_fetch_assoc($q);
			if(empty($qr['subscription'])){
				$space = time() - strtotime($qr['date']);
				if($space >= 7776000){
					return 0;
				}else{
					$space = 7776000 - $space;
					if($space <= 2592000){
						$days = floor($space/86400);
						if($days == 1){
							$days = $days.' day';
						}else if($days == 0){
							$days = 'Today';
						}else{
							$days = $days.' days';
						}
						return '<div class="alert alert-danger alert-solid" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">×</span>
										</button>
										<div class="d-flex align-items-center justify-content-start tx-center">
											<i class="icon ion-android-warning alert-icon tx-32"></i>
											<span><b>Hi '.$qr['fname'].'</b>, your subscription ends in <b>'.$days.'</b>. Continue to enjoy this platform by <b>subscribing for a year</b> at <b>GHS 20.00</b> <a href="subscription"><button class="btn btn-danger mg-l-5" style="border-color: #fff;padding:5px 7px;">Subscribe Now</button></a></span>
										</div>
									</div>';
					}
					return '';
				}
			}

			$space = strtotime($qr['subscription']) - time();
			if($space <= 0){
				return 0;
			}else{
				if($space <= 604800){
					$days = floor($space/86400);
					if($days == 1){
						$days = $days.' day';
					}else if($days == 0){
						$days = 'Today';
					}else{
						$days = $days.' days';
					}
					return '<div class="alert alert-danger alert-solid" role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">×</span>
									</button>
									<div class="d-flex align-items-center justify-content-start tx-center">
										<i class="icon ion-android-warning alert-icon tx-32"></i>
										<span><b>Hi '.$qr['fname'].'</b>, your subscription ends in <b>'.$days.'</b>. Continue to enjoy this platform by <b>subscribing for a year</b> at <b>GHS 20.00</b> <a href="subscription"><button class="btn btn-danger mg-l-5" style="border-color: #fff;padding:5px 7px;">Subscribe Now</button></a></span>
									</div>
								</div>';
				}
				return '';
				
			}
		}else if($st['user_type'] == 'c'){
			$cid = $st['userid'];

			$q = mysqli_query($link, "SELECT subscription, `date`,cname FROM company WHERE cid='$cid' ");
			$qr = mysqli_fetch_assoc($q);
			if(empty($qr['subscription'])){
				$space = time() - strtotime($qr['date']);
				if($space >= 7776000){
					return '0';
				}else{
					$space = 7776000 - $space;
					if($space <= 2592000){
						$cn = explode(" ", $qr['cname']);
						$fname = $cn[0];
						$days = floor($space/86400);
						if($days == 1){
							$days = $days.' day';
						}else if($days == 0){
							$days = 'Today';
						}else{
							$days = $days.' days';
						}
						return '<div class="alert alert-danger alert-solid" role="alert">
										<button type="button" class="close" data-dismiss="alert" aria-label="Close">
											<span aria-hidden="true">×</span>
										</button>
										<div class="d-flex align-items-center justify-content-start tx-center">
											<i class="icon ion-android-warning alert-icon tx-32"></i>
											<span><b>Hi '.$fname.'</b>, your subscription ends in <b>'.$days.'</b>. Continue to enjoy this platform by <b>subscribing for a year</b> at <b>GHS 70.00</b> <a href="subscription"><button class="btn btn-danger mg-l-5" style="border-color: #fff;padding:5px 7px;">Subscribe Now</button></a></span>
										</div>
									</div>';
					}
					return '1';
				}
			}

			$space = strtotime($qr['subscription']) - time();
			if($space <= 0){
				return '0';
			}else{
				if($space < 604800){
					$cn = explode(" ", $qr['cname']);
					$fname = $cn[0];
					$days = floor($space/86400);
					if($days == 1){
						$days = $days.' day';
					}else if($days == 0){
						$days = 'Today';
					}else{
						$days = $days.' days';
					}
					return '<div class="alert alert-danger alert-solid" role="alert">
									<button type="button" class="close" data-dismiss="alert" aria-label="Close">
										<span aria-hidden="true">×</span>
									</button>
									<div class="d-flex align-items-center justify-content-start tx-center">
										<i class="icon ion-android-warning alert-icon tx-32"></i>
										<span><b>Hi '.$fname.'</b>, your subscription ends in <b>'.$days.'</b>. Continue to enjoy this platform by <b>subscribing for a year</b> at <b>GHS 70.00</b> <a href="subscription"><button class="btn btn-danger mg-l-5" style="border-color: #fff;padding:5px 7px;">Subscribe Now</button></a></span>
									</div>
								</div>';
				}
				return '1';
			}
		}
		

	}


	public function check_welcome($apid){
		global $link;

		$apid = clean($link, $apid);
		$st = $this->get_user_type($apid);
		if($st['user_type'] != 's'){
			return '<p class="text-center">Sorry, you do not have the privilege to access this information</p>';
		}
		$stid = $st['userid'];

		$q = mysqli_query($link, "SELECT welcome FROM students WHERE stid='$stid' ");
		$qr = mysqli_fetch_assoc($q);
		return $qr['welcome'];
	}


	public function seen_welcome($apid){
		global $link;

		$apid = clean($link, $apid);
		$st = $this->get_user_type($apid);
		if($st['user_type'] != 's'){
			return '<p class="text-center">Sorry, you do not have the privilege to access this information</p>';
		}
		$stid = $st['userid'];

		$q = mysqli_query($link, "UPDATE students SET welcome='1' WHERE stid='$stid' ");

	}


	public function show_statics($apid){
		global $link;

		$apid = clean($link, $apid);
		$st = $this->get_user_type($apid);
		if($st['user_type'] != 's'){
			return '<p class="text-center">Sorry, you do not have the privilege to access this information</p>';
		}
		$stid = $st['userid'];
		$statictics = $this->get_student_statistics($stid);
		
		return '<h6 class="tx-gray-800 tx-uppercase tx-semibold tx-13 mg-b-25" style="color: #fff;">Statistics</h6>
						<p class="mg-b-0 tx-14 tx-white-7">Speed</p>
						<div class="progress mg-b-20">
							<div class="progress-bar bg-warning progress-bar-md wd-'.$statictics['speed'].'p"
							role="progressbar" aria-valuenow="'.$statictics['speed'].'" aria-valuemin="0" aria-valuemax="100">'.$statictics['speedtxt'].'</div>
						</div>
						<p class="mg-b-0 tx-14 tx-white-7">Technicality</p>
						<div class="progress mg-b-20">
							<div class="progress-bar bg-warning progress-bar-md wd-'.$statictics['rate'].'p"
							role="progressbar" aria-valuenow="'.$statictics['rate'].'" aria-valuemin="0" aria-valuemax="100">'.$statictics['ratetxt'].'</div>
						</div>
						<p class="mg-b-0 tx-14 tx-white-7">Initiative</p>
						<div class="progress mg-b-20">
							<div class="progress-bar bg-warning progress-bar-md wd-'.$statictics['initiative'].'p"
							role="progressbar" aria-valuenow="'.$statictics['initiative'].'" aria-valuemin="0" aria-valuemax="100">'.$statictics['initiativetxt'].'</div>
						</div>
						<p class="mg-b-0 tx-14 tx-white-7">Execution</p>
						<div class="progress mg-b-20">
							<div class="progress-bar bg-warning progress-bar-md wd-'.$statictics['execute'].'p"
							role="progressbar" aria-valuenow="'.$statictics['execute'].'" aria-valuemin="0" aria-valuemax="100">'.$statictics['executetxt'].'</div>
						</div>';
	}


	public function get_company_info($apid, $company, $page){
		global $link;

		$apid = clean($link, $apid);
		$st = $this->get_user_type($apid);
		if($st['user_type'] != 's'){
			return '<p class="text-center">Sorry, you do not have the privilege to access this information</p>';
		}
		$stid = $st['userid'];
		$cid = clean($link, $company);
		$page = clean($link, $page);

		$noteid = "company=".$cid;

		$uq = mysqli_query($link, "UPDATE `notification` SET seen='1' WHERE apid='$apid' AND ntype='t' AND note_id='$noteid' ");


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

		$subscribebut = '<button id="subscibe_'.$cid.'" onclick="sub(\''.$cid.'\',\'1\')" class="btn btn-primary btn-sm mg-b-0">Subscribe</button>';
		$suq = mysqli_query($link, "SELECT sbid FROM subscribe WHERE stid='$stid' AND cid='$cid' ");
		$suqnum = mysqli_num_rows($suq);
		if($suqnum != 0){
			$subscribebut = '<button id="subscibe_'.$cid.'" onclick="sub(\''.$cid.'\',\'2\')" class="btn btn-danger btn-sm mg-b-0">Unsubscribe</button>';
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
		                  <h6 class="tx-white tx-center">'.$this->get_total_subscribers($cid).'</h6>
		                </div>
		                <div>
		                  <span class="tx-11">Total Tasks</span>
		                  <h6 class="tx-white tx-center">'.$this->get_total_tasks($cid).'</h6>
		                </div>
		                <div>
		                  <span class="tx-11">Total Solutions</span>
		                  <h6 class="tx-white tx-center">'.$this->get_total_task_solutions($cid).'</h6>
		                </div>
		              </div>
	              </div>
	              <p class="mg-b-0 tx-center">
	              	'.$subscribebut.'
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
    
    $return = $this->get_company_tasks($stid, $cid, $page);
    $data['info'] = $info;
    $data['tasks'] = $return['task'];
    $data['page'] = $return['page'];
    $data['range'] = $return['range'];
    return $data;
	}



	public function get_company_tasks($stid,$cid,$page){
		global $link;

		$cid = clean($link, $cid);
		$stid = clean($link, $stid);
		$page = clean($link, $page);

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
			$data['task'] = '<p class="text-center">No task found</p>';
      $data['page'] = '';
      $data['range'] = '';
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
			$buttonx = '<p class="text-right"><button class="btn btn-primary mg-b-10" onclick="viewtask(\''.$qr['tid'].'\')">View</button></p>';
			$sq = mysqli_query($link, "SELECT sid,status FROM solution WHERE stid='$stid' AND tid='$tid' ");
			$sqnum = mysqli_num_rows($sq);
			if($sqnum != 0){
				$sqr = mysqli_fetch_assoc($sq);
				if($sqr['status'] == 0){
	      	$buttonx = '<p class="text-right"><a href="task?t='.$tid.'"><button class="btn btn-success mg-b-10">Upload Solution</button></a></p>';
	      }
	      else{
	      	$buttonx = '<p class="text-right"><a href="task?t='.$tid.'"><button class="btn btn-light mg-b-10">Solution Submitted</button></a></p>';
	      }
			}

			

			$tasks .= '<h6 class="card-title">'.$qr['title'].'</h6>
								<p class="card-text">'.$qr['summary'].' - <i style="color: #237ad4;font-size: 12px;">'.date("jS M Y, g:i a", strtotime($qr['date'])).'</i></p>
								<p class="card-subtitle"><span class="icon ion-ios-list-outline" style="font-size: 20px;"></span> Submitted Solutions: <b style="color: #333;">'.$this->get_task_solutions($tid).'</b></p>
								<p class="card-subtitle"><span class="icon ion-ios-clock-outline" style="font-size: 20px;"></span> Deadline: <b style="color: #333;">'.$qr['days'].' days</b></p>
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


	public function get_student_info($apid, $page){
    global $link;

    $apid = clean($link, $apid);
    $su = $this->get_user_type($apid);
    if($su['user_type'] != 's'){
      $data['info'] = '<p class="text-center">Sorry, you do not have the privilege to access this information</p>';
      $data['page'] = '';
      $data['range'] = '<p class="text-center mg-b-0">Showing <span>0</span> to <span>0</span> of <span>0</span> Tasks</p>';
      return $data;
    }

    $stid = $su['userid'];

    $q = mysqli_query($link, "SELECT * FROM students WHERE stid='$stid' ");
    $qnum = mysqli_num_rows($q);
    if($qnum == 0){
      $data['info'] = '<p class="text-center">Invalid Info</p>';
			$data['page'] = '';
			$data['tasks'] = '';
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
		
		$eq = mysqli_query($link, "SELECT email FROM appusers WHERE userid='$stid' AND user_type='s' ");
		$eqr = mysqli_fetch_assoc($eq);

		$taskinfo = $this->get_total_student_tasks($stid);

		$statictics = $this->get_student_statistics($stid);

    $info = '<div class="card shadow-base bd-0 overflow-hidden" style="background-color: #07274f;">
							<div class="pd-x-25 pd-t-25">
							<p class="tx-center">
								<img style="border: 3px solid #fff;" src="img/avatar/'.$avatar.'" width="100" class="rounded-circle" alt="">
							</p>
							<h6 class="logged-fullname tx-center" style="color: #fff;">'.$qr['fname'].' '.$qr['lname'].'</h6>
							<p class="tx-center">'.$eqr['email'].'</p>
							<div class="widget-1">
								<div class="card-footer">
									<div>
										<span class="tx-11">Points</span>
										<h6 class="tx-white tx-center">'.$this->get_points($apid).'</h6>
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
							<hr>
							<h6 class="tx-gray-800 tx-uppercase tx-semibold tx-13 mg-b-25" style="color: #fff;">Profile</h6>

							<label class="tx-10 tx-uppercase tx-mont tx-medium tx-spacing-1 mg-b-2">Username</label>
							<p class="tx-info mg-b-25" style="color: #fff;">'.$qr['username'].'</p>

							<hr>
							<h6 class="tx-gray-800 tx-uppercase tx-semibold tx-13 mg-b-25" style="color: #fff;">Other Information</h6>

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

		$info .= '<div class="card card-body bd-0 pd-25 bg-primary mg-t-20">
								<div class="d-xs-flex justify-content-between align-items-center tx-white mg-b-20">
									<h6 class="tx-13 tx-uppercase tx-semibold tx-spacing-1 mg-b-0">Completed Tasks</h6>
								</div>
								<p class="tx-12 tx-white-7">Percentage of tasks completed</p>              
								<div class="progress bg-white-3 mg-b-0">
									<div class="progress-bar bg-success wd-'.$comp.'p"
									role="progressbar" aria-valuenow="'.$comp.'" aria-valuemin="0" aria-valuemax="100">'.$ptext.'</div>
								</div>
								<p class="tx-11 mg-b-0 mg-t-15 tx-white-7">'.$taskinfo['solution'].'/'.$taskinfo['total'].' tasks</p>
							</div>';

    $return = $this->my_tasks($stid, $page);
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
			FROM solution WHERE stid='$stid' AND `status` NOT IN ('0','3')  ");
			
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

		$q = mysqli_query($link, "SELECT `status`, COUNT(sid) as `count` FROM `solution` WHERE stid='$stid' AND `status`!='3' GROUP BY `status` ");
		$data['total']=$data['solution']=0;
    while($qr = mysqli_fetch_array($q, MYSQLI_ASSOC)){
			if($qr['status'] == 1 || $qr['status'] == 2){
				$data['solution'] += $qr['count'];
			}
			$data['total'] += $qr['count'];
		}
		
		return $data;
  }
	


	public function my_tasks($stid, $page){
		global $link;

		$stid = clean($link, $stid);
		$page = clean($link, $page);

    $pagegets = '';

    if(empty($page) == false){
      $checkqx = mysqli_query($link, "SELECT COUNT(*) FROM solution WHERE stid='$stid' AND `status`!='3' "); 
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

		$q = mysqli_query($link, "SELECT * FROM solution WHERE stid='$stid' AND `status`!='3' ORDER BY `date` DESC");
		$qnum = mysqli_num_rows($q);
		if($qnum == 0){
			$data['task'] = '<p class="text-center">No task found</p>';
      $data['page'] = '';
      $data['range'] = '';
      return $data;
		}

		$pagg=$task='';
    $pqx = mysqli_query($link, "SELECT COUNT(*) FROM solution WHERE stid='$stid' AND `status`!='3' ");
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
                  <a style="border:none;" class="page-link" href="profile?page='.($page+1).$pagegets.'" aria-label="Next"><i class="ion ion-arrow-right-a"></i></a>
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
			
			$rate='';
      if($qr['status'] == 0){
      	$buttonx = '<p class="text-right"><a href="task?t='.$tid.'"><button class="btn btn-success mg-b-10">Upload Solution</button></a></p>';
      }
      else{
				if($qr['status'] == '2'){
					$rate = '<span id="sol_'.$qr['sid'].'" style="font-size:14px; margin-right:10px;">Rated: <b style="font-size:20px;">'.$qr['rate'].'<i class="ion ion-android-star" style="color: #FF9800;"></i></b></span>';
				} 
      	$buttonx = '<p class="text-right">'.$rate.'<a href="task?t='.$tid.'"><button class="btn btn-light mg-b-10">Solution Submitted</button></a></p>';
			}
			

      $task .= '<h6 class="card-title">'.$tqr['title'].'</h6>
                <p class="card-subtitle"><a class="stylename" href="company_profile?company='.$cid.'"><b style="color: #333;">'.$cqr['cname'].'</b></a> - <i style="color: #237ad4;font-size: 12px;">'.$timepost.'</i></p>
                <p class="card-text">'.$tqr['summary'].'</p>
		                <p class="card-subtitle"><span class="icon ion-ios-list-outline" style="font-size: 20px;"></span> Submitted Solutions: <b style="color: #333;">'.$this->get_task_solutions($tid).'</b></p>
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



	public function get_total_subscribers($cid){
		global $link;

    $cid = clean($link, $cid);

		$q = mysqli_query($link, "SELECT sbid FROM `subscribe` WHERE cid='$cid' ");
		$qnum = mysqli_num_rows($q);
			return $qnum;
	}



	public function get_total_tasks($cid){
    global $link;

    $cid = clean($link, $cid);

    $q = mysqli_query($link, "SELECT tid FROM `task` WHERE cid='$cid' AND delete_task='0' ");
    $qnum = mysqli_num_rows($q);
    return $qnum;
  }


  public function get_total_task_solutions($cid){
    global $link;

    $cid = clean($link, $cid);

    $q = mysqli_query($link, "SELECT sid FROM `solution` WHERE tid IN (SELECT tid FROM `task` WHERE cid='$cid') AND status NOT IN ('0','3') ");
    $qnum = mysqli_num_rows($q);
    return $qnum;
  }



	public function check_username($username){
		global $link;

		$username = clean($link, $username);
		$q = mysqli_query($link, "SELECT stid FROM students WHERE username='$username' ");
		$qnum = mysqli_num_rows($q);
		if($qnum == 0){
			return 1;
		}
		return 0;
	}


	public function complete_signup($userid, $username, $school, $program, $year){
		global $link;

		$userid = clean($link, $userid);
		$username = clean($link, $username);
		$school = clean($link, $school);
		$program = clean($link, $program);
		$year = clean($link, $year);

		$iq = mysqli_query($link, "UPDATE students SET username='$username', school='$school', program='$program', `year`='$year' WHERE stid='$userid'");
		if($iq){
			$fq = mysqli_query($link, "SELECT fname FROM students WHERE stid='$userid'");
			$qr = mysqli_fetch_assoc($fq);
			$fname = $qr['fname'];

			$eq = mysqli_query($link, "SELECT email FROM appusers WHERE userid='$userid' AND user_type='s' ");
			$sqr = mysqli_fetch_assoc($eq);
			$email = $sqr['email'];

			$message = nl2br('This is not your usual welcome message. It\'s not long to read. We at Rook+ believe in firsthand approach to the way of life - experiencing, learning, and partaking. Are you ready to be a Rookie? Explore the Rook+ features now on your phone or pc!');
			$this->send_welcome_email($email, $fname, $message);
			return 1;
		}
		return 'Error updating your information.';
	}


	public function user_email($apid){
		global $link;

		$data = mysqli_fetch_assoc(mysqli_query($link, "SELECT email FROM appusers WHERE apid='$apid' "));
		return $data;
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


	public function get_email($apid){
		global $link;

		$apid = clean($link, $apid);

		$q = mysqli_query($link, "SELECT email FROM appusers WHERE apid='$apid' ");
		$qr = mysqli_fetch_assoc($q);
		return $qr['email'];
	}


	public function get_user_type($apid){
		global $link;
		
		$apid = clean($link, $apid);

		$data = mysqli_fetch_assoc(mysqli_query($link, "SELECT user_type, userid FROM appusers WHERE apid='$apid' "));
		return $data;
	}


	public function addphone($userid, $phone){
		global $link;

		$phone = clean($link, $phone);
		$userid = clean($link, $userid);

		$q = mysqli_query($link, "UPDATE students SET phone='$phone' WHERE stid='$userid'");
		if($q){

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
			return true.'|sms sent';
			 
		}
		else{
			return false.'|Error adding phone number. Try again';
		}

	}


	public function change_number($userid){
		global $link;

		$userid = clean($link, $userid);
		$q = mysqli_query($link, "UPDATE students SET phone=NULL WHERE stid='$userid' ");
		if($q){
			$dq = mysqli_query($link, "DELETE FROM phone_code WHERE uid='$userid' ");
			return true;
		}
		return false;
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
			return true.'|SMS has been resent successfully';
		}
		return false.'|Error resending sms';
	}


	public function activate($userid, $code){
		global $link;

		$userid = clean($link, $userid);
		$code = clean($link, $code);

		$q = mysqli_query($link, "SELECT pcid FROM phone_code WHERE uid='$userid' AND code='$code' ");
		$qnum = mysqli_num_rows($q);

		if($qnum == 0){
			return 'Invalid activation code';
		}

		$uq = mysqli_query($link, "UPDATE students SET active='1' WHERE stid='$userid'");
		if($uq){
			$qr = mysqli_fetch_assoc($q);
			$pcid = $qr['pcid'];
			$dq = mysqli_query($link, "DELETE FROM phone_code WHERE pcid='$pcid' ");
			return 'done';
		}
		return 'Error activating your account';
	}



	public function sendsms($sender_id, $message, $phone){
    global $key;
    
    $url = "https://apps.mnotify.net/smsapi?key=$key&to=$phone&msg=$message&sender_id=$sender_id";
    $result = file_get_contents($url);
    return $result;
	}
	


	public function cancel_task($userid, $task){
		global $link;

		$userid = clean($link, $userid);
		$task = clean($link, $task);

		$uq = mysqli_query($link, "UPDATE solution SET `status`='3' WHERE stid='$userid' AND tid='$task' ");
		if($uq){
			return 'done';
		}
		return 'Error canceling task...try again';
	}



	public function start_task($userid, $task){
		global $link;

		$userid = clean($link, $userid);
		$task = clean($link, $task);

		$tcq = mysqli_query($link, "SELECT tid FROM task WHERE delete_task='0' AND tid='$task' ");
		$tcqnum = mysqli_num_rows($tcq);
		if($tcqnum == 0){
			return 'Invalid task information';
		}

		$cq = mysqli_query($link, "SELECT sid FROM solution WHERE stid='$userid' AND tid='$task' ");
		$cqnum = mysqli_num_rows($cq);
		if($cqnum == 1){
			return 'You have added this task already';
		}

		$timenow = date("Y-m-d H:i:s", time());
		$iq = mysqli_query($link, "INSERT INTO solution(stid, tid, `date`) VALUES('$userid', '$task', '$timenow') ");
		if($iq){
			return 'done';
		}

		return 'Error adding task...try again';
	}


	public function get_task_info($task){
		global $link;

		$task = clean($link, $task);

		$q = mysqli_query($link, "SELECT * FROM task WHERE tid='$task' ");
		$qnum = mysqli_num_rows($q);
		if($qnum == 0){
			return 'Invalid task information';
		}

		$qr = mysqli_fetch_assoc($q);
		$cid = $qr['cid'];
		$cq = mysqli_query($link, "SELECT cname FROM company WHERE cid='$cid'");
		$cqr = mysqli_fetch_assoc($cq);

		$filedl = '<p class="text-right mg-t-5"><button id="start" class="btn btn-warning mg-b-10" onclick="start_task(\''.$task.'\')">Start Task</button></p>';

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

		$task = '<div class="row" style="margin-top:50px;">
								<div class="col-lg-8 col-lg-offset-2 col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
									<div id="closebut" onclick="closepop()"><span class="icon ion-android-close"></span></div>
									<div class="card bd-0 shadow-base">
             			 <div class="pd-x-25 pd-t-25">
             			 	<h6 class="card-title">'.$qr['title'].'</h6>
		                <p class="card-subtitle"><b style="font-size: 17px;color: #333;"><a class="stylename" href="company_profile?company='.$cid.'">'.$cqr['cname'].'</a></b> - <i>'.$timepost.'</i></p>
		                <p class="card-text">'.$qr['summary'].'</p>		          
		                <p class="card-subtitle"><span class="icon ion-ios-list-outline" style="font-size: 20px;"></span> Submitted Solutions: <b style="color: #333;">'.$this->get_task_solutions($task).'</b></p>
										<p class="card-subtitle"><span class="icon ion-ios-clock-outline" style="font-size: 20px;"></span> Deadline: <b style="color: #333;">'.$qr['days'].' days</b></p>
										'.$filedl.'
		                <hr>
             			 </div>
             			</div>
								</div>
							</div>';
		return 'done|'.$task;
	}


	public function get_task_solutions($task){
		global $link;
		$q = mysqli_query($link, "SELECT sid FROM solution WHERE tid='$task' AND status NOT IN ('0','3') ");
		return mysqli_num_rows($q);
	}


	public function get_companies($apid, $search, $page){
		global $link;

		$apid = clean($link, $apid);
		$st = $this->get_user_type($apid);
		if($st['user_type'] != 's'){
			return '<p class="text-center">Sorry, you do not have the privilege to access this information</p>';
		}
		$stid = $st['userid'];
		$search = clean($link, $search);
    $page = clean($link, $page);

    $parameter = '';
    $pagegets = '';
    if(!empty($search) == true){
      $parameter = "AND cname LIKE '%$search%'";
      $pagegets = '&q='.$search;
    }


    if(empty($page) == false){
      $checkqx = mysqli_query($link, "SELECT COUNT(*) FROM company WHERE active='1' $parameter"); 
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


		$q = mysqli_query($link, "SELECT * FROM company WHERE active='1' $parameter ORDER BY `cname` ASC $qlimit");
		$qnum = mysqli_num_rows($q);
		if($qnum == 0){
			$data['company'] = '<p class="text-center">No company found</p>';
      $data['page'] = '';
      $data['range'] = '';
      return $data;
		}

		$pagg=$comp='';
    $pqx = mysqli_query($link, "SELECT COUNT(*) FROM company WHERE active='1' $parameter ");
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
                  <a class="page-link" href="companies?page='.($page-1).$pagegets.'" aria-label="Previous"><i class="ion ion-arrow-left-a"></i></a>
                </li>';
    }

    for($i=$start;$i<=($start+4);$i++){
        if($i == $page){
            $pagg .= '<li class="page-item active"><a class="page-link" href="companies?page='.$i.$pagegets.'">'.$i.'</a></li>';
        }
        else if($i <= $pqnumx){
            $pagg .= '<li class="page-item"><a class="page-link" href="companies?page='.$i.$pagegets.'">'.$i.'</a></li>';   
        }
    }


    if($pqnumx > 1 && $pqnumx > $page){
      $pagg .= '<li class="pag-prev mg-5">
                  <a style="border:none;" class="page-link" href="companies?page='.($page+1).$pagegets.'" aria-label="Next"><i class="ion ion-arrow-right-a"></i></a>
                </li>';
    }

		while ($qr = mysqli_fetch_array($q, MYSQLI_ASSOC)) {
			$cid = $qr['cid'];
			$cq = mysqli_query($link, "SELECT sbid FROM subscribe WHERE cid='$cid' AND stid='$stid' ");
			$cqnum = mysqli_num_rows($cq);
			if($cqnum == 0){
				$buttonx = '<p class="text-right"><button id="subscibe_'.$cid.'" class="btn btn-primary mg-b-10" onclick="sub(\''.$cid.'\',\'1\')">Subscribe</button></p>';
			}
			else{
				$buttonx = '<p class="text-right"><button id="subscibe_'.$cid.'" class="btn btn-danger mg-b-10" onclick="sub(\''.$cid.'\',\'2\')">Unsubscribe</button></p>';
			}

			if(empty($qr['logo'])){
				$logo = 'p.png';
			}
			else{
				$logo = $qr['logo'];
			}

			$comp .= '<div class="media align-items-center">
                  <img src="img/avatar/'.$logo.'" class="wd-50 rounded-circle d-flex mg-r-10 mg-xs-r-15 align-self-start" alt="">
                  <div class="media-body">
                    <b style="color: #333;"><a class="stylename" href="company_profile?company='.$cid.'"><span class="d-block tx-medium tx-inverse" style="font-weight:600;">'.$qr['cname'].'</span></a></b>
										<span class="tx-12">'.$qr['location'].'</span><br>
										<span class="tx-12"><b>Bio: </b>'.$qr['bio'].'</span>
                  </div><!-- media-body -->
                </div><!-- media -->
                <span class="tx-12">
                  '.$buttonx.'
                </span>
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


	public function subscribe_to_company($userid,$company){
		global $link;

		$userid = clean($link, $userid);
		$company = clean($link, $company);

		$cq = mysqli_query($link, "SELECT cid FROM company WHERE cid='$company' ");
		$cqnum = mysqli_num_rows($cq);
		if($cqnum == 0){
			return 'Invalid company info';
		}

		$q =  mysqli_query($link, "SELECT cid FROM subscribe WHERE stid='$userid' AND cid='$company'");
		$qnum = mysqli_num_rows($q);
		if($qnum == 1){
			$dq = mysqli_query($link, "DELETE FROM subscribe WHERE stid='$userid' AND cid='$company'");
			if($dq){
				return 'subscribe';
			}
			return 'Error unsubscribing...try again';
		}

		$timenow = date("Y-m-d H:i:s", time());
		$iq = mysqli_query($link, "INSERT INTO subscribe(stid,cid,`date`) VALUES('$userid','$company','$timenow')");
		if($iq){
			return 'unsubscribe';
		}
		return 'Error subscribing...try again';
	}


	public function task_detail($apid, $task){
		global $link;

		$task = clean($link, $task);
		$apid = clean($link, $apid);
		$st = $this->get_user_type($apid);
		if($st['user_type'] != 's'){
			return '<p class="text-center">Sorry, you do not have the privilege to access this information</p>';
		}
		$stid = $st['userid'];

		$chq = mysqli_query($link, "SELECT tid FROM task WHERE (delete_task='1' AND tid IN (SELECT tid FROM solution WHERE tid='$task' AND stid='$stid')) OR (delete_task='0' AND tid='$task' AND (tid IN (SELECT tid FROM solution WHERE tid='$task' AND stid='$stid' AND status !='3')))  ");
		$chqnum = mysqli_num_rows($chq);
		if($chqnum == 0){
			return '<p class="text-center">Invalid Task information</p>
							<p class="text-center"><a href="task"><button class="btn btn-primary mg-b-10">Back to Tasks</button></a></p>';
		}

		
		$q = mysqli_query($link, "SELECT * FROM task WHERE tid='$task' ");

		$qr = mysqli_fetch_assoc($q);
		$cid = $qr['cid'];
		$cq = mysqli_query($link, "SELECT cname FROM company WHERE cid='$cid'");
		$cqr = mysqli_fetch_assoc($cq);

		$supbut =$solution= '';
		$sq = mysqli_query($link, "SELECT * FROM solution WHERE tid='$task' AND stid='$stid' ");
		$sqnum = mysqli_num_rows($sq);
		if($sqnum == 0){
			$supbut = '<p class="text-right mg-t-5"><button id="start" class="btn btn-warning mg-b-10" onclick="start_task(\''.$task.'\')">Start Task</button></p>';
		}
		else{
			$sqr = mysqli_fetch_assoc($sq);
			if($sqr['status'] == 0){
				$supbut = '<p class="text-right mg-t-5"><a href="docs/'.$qr['file'].'" download><button id="start" class="btn btn-info mg-b-10">Download Document</button></a><button id="start" class="btn btn-warning mg-b-10 mg-l-5" onclick="uploadtask(\''.$task.'\')">Upload Solution</button><button id="cancel" class="btn btn-danger mg-b-10 mg-l-5" onclick="cancel_task(\''.$task.'\')">Cancel</button></p>';
			}
			else{
				$solution = '<p class="card-text">'.$sqr['summary'].' - <i>'.date("jS M Y, g:i a", strtotime($sqr['send_date'])).'</i></p>
			                <p class="card-subtitle"><a href="docs/'.$sqr['file'].'" download><button class="btn btn-secondary mg-b-10 mg-l-5"><span class="icon ion-ios-cloud-download-outline" style="font-size: 20px;"></span> My Solution</button></a></p>';
				$supbut = '<p class="text-right mg-t-5"><a href="docs/solutions/'.$qr['file'].'" download><button id="start" class="btn btn-info mg-b-10">Download Document</button></a></p>';
			}
			
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

		$task = '<h6 class="card-title">'.$qr['title'].'</h6>
		                <p class="card-subtitle"><a class="stylename" href="company_profile?company='.$cid.'"><b style="font-size: 17px;color: #333;">'.$cqr['cname'].'</b></a> - <i style="color: #237ad4;font-size: 12px;">'.$timepost.'</i></p>
		                <p class="card-text">'.$qr['summary'].'</p>
		                <p class="card-subtitle"><span class="icon ion-ios-list-outline" style="font-size: 20px;"></span> Submitted Solutions: <b style="color: #333;">'.$this->get_task_solutions($task).'</b></p>
										<p class="card-subtitle"><span class="icon ion-ios-clock-outline" style="font-size: 20px;"></span> Deadline: <b style="color: #333;">'.$qr['days'].' days</b></p>
										'.$supbut.'
		                <hr>'.$solution;
		return $task;
	}



	public function new_tasks($apid, $page){
		global $link;

		$apid = clean($link, $apid);
		$st = $this->get_user_type($apid);
		if($st['user_type'] != 's'){
			return '<p class="text-center">Sorry, you do not have the privilege to access this information</p>';
		}
		$stid = $st['userid'];
		$page = clean($link, $page);

		if(empty($page) == false){
      $checkqx = mysqli_query($link, "SELECT COUNT(*) FROM task WHERE delete_task='0' AND cid IN (SELECT cid FROM subscribe WHERE stid='$stid') AND tid NOT IN (SELECT tid FROM solution WHERE stid='$stid')"); 
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

		$q = mysqli_query($link, "SELECT * FROM task WHERE delete_task='0' AND cid IN (SELECT cid FROM subscribe WHERE stid='$stid') AND tid NOT IN (SELECT tid FROM solution WHERE stid='$stid') ORDER BY `date` DESC $qlimit");
		$qnum = mysqli_num_rows($q);
		if($qnum == 0){
			$data['tasks'] = '<p class="text-center">No tasks found</p>
							<p class="text-center"><a href="companies"><button class="btn btn-primary mg-b-10">Subscribe to a Company?</button></a></p>';
      $data['page'] = '';
      $data['range'] = '';
      return $data;
		}

		$pagg=$task='';
    $pqx = mysqli_query($link, "SELECT COUNT(*) FROM task WHERE delete_task='0' AND cid IN (SELECT cid FROM subscribe WHERE stid='$stid') AND tid NOT IN (SELECT tid FROM solution WHERE stid='$stid') ORDER BY `date` DESC ");
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
                  <a class="page-link" href="tasks?page='.($page-1).'" aria-label="Previous"><i class="ion ion-arrow-left-a"></i></a>
                </li>';
    }

    for($i=$start;$i<=($start+4);$i++){
        if($i == $page){
            $pagg .= '<li class="page-item active"><a class="page-link" href="tasks?page='.$i.'">'.$i.'</a></li>';
        }
        else if($i <= $pqnumx){
            $pagg .= '<li class="page-item"><a class="page-link" href="tasks?page='.$i.'">'.$i.'</a></li>';   
        }
    }


    if($pqnumx > 1 && $pqnumx > $page){
      $pagg .= '<li class="pag-prev mg-5">
                  <a style="border:none;" class="page-link" href="tasks?page='.($page+1).'" aria-label="Next"><i class="ion ion-arrow-right-a"></i></a>
                </li>';
    }
		while ($qr = mysqli_fetch_array($q, MYSQLI_ASSOC)) {
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
			

			$task .= '<h6 class="card-title">'.$qr['title'].'</h6>
                <p class="card-subtitle"><a class="stylename" href="company_profile?company='.$cid.'"><b style="font-size: 17px;color: #333;">'.$cqr['cname'].'</b></a> - <i style="color: #237ad4;font-size: 12px;">'.$timepost.'</i></p>								
								<p class="card-text">'.$qr['summary'].'</p>
								<p class="card-subtitle"><span class="icon ion-ios-clock-outline" style="font-size: 20px;"></span> Deadline: <b style="color: #333;">'.$qr['days'].' days</b></p>
                <p class="text-right"><button class="btn btn-primary mg-b-10" onclick="viewtask(\''.$qr['tid'].'\')">View</button></p>
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
	


	public function current_tasks($apid){
		global $link;

		$apid = clean($link, $apid);
		$st = $this->get_user_type($apid);
		if($st['user_type'] != 's'){
			return '<p class="text-center">Sorry, you do not have the privilege to access this information</p>';
		}
		$stid = $st['userid'];

		$q = mysqli_query($link, "SELECT * FROM task WHERE tid IN (SELECT tid FROM solution WHERE stid='$stid' AND status='0') ORDER BY `date` DESC LIMIT 10");
		$qnum = mysqli_num_rows($q);
		if($qnum == 0){
			return '<p class="text-center">No tasks found</p>';
		}

		$task = '';
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
                <p class="card-subtitle"><a class="stylename" href="company_profile?company='.$cid.'"><b style="color: #333;">'.$cqr['cname'].'</b></a> - <i style="color: #237ad4;font-size: 12px;">'.$timepost.'</i></p>
                <p class="card-text">'.$qr['summary'].'</p>
                <a href="task?t='.$tid.'"><button class="btn btn-success mg-b-10">Upload Solution</button></a>
                <hr>';
		}

		return $task;
	}


	public function get_points($apid){
		global $link;

		$apid = clean($link, $apid);
		$st = $this->get_user_type($apid);
		if($st['user_type'] != 's'){
			return '<p class="text-center">Sorry, you do not have the privilege to access this information</p>';
		}
		$stid = $st['userid'];

		$q = mysqli_query($link, "SELECT SUM(rate+submission+attempt+speed) as points FROM solution WHERE stid='$stid' ");

		$qr = mysqli_fetch_assoc($q);
		if($qr['points'] == 0){
			return '0';
		}
		return $qr['points'];
	}


	public function get_attempts($apid){
		global $link;

		$apid = clean($link, $apid);
		$st = $this->get_user_type($apid);
		if($st['user_type'] != 's'){
			return '<p class="text-center">Sorry, you do not have the privilege to access this information</p>';
		}
		$stid = $st['userid'];

		$q = mysqli_query($link, "SELECT sid FROM solution WHERE stid='$stid' AND status !='3' ");
		$qnum = mysqli_num_rows($q);
		return $qnum;
	}


	public function get_solutions($apid){
		global $link;

		$apid = clean($link, $apid);
		$st = $this->get_user_type($apid);
		if($st['user_type'] != 's'){
			return '<p class="text-center">Sorry, you do not have the privilege to access this information</p>';
		}
		$stid = $st['userid'];

		$q = mysqli_query($link, "SELECT sid FROM solution WHERE stid='$stid' AND `status` NOT IN ('0','3') ");
		$qnum = mysqli_num_rows($q);
		return $qnum;
	}


	public function get_companies_watching($apid){
		global $link;

		$apid = clean($link, $apid);
		$st = $this->get_user_type($apid);
		if($st['user_type'] != 's'){
			return '<p class="text-center">Sorry, you do not have the privilege to access this information</p>';
		}
		$stid = $st['userid'];

		$q = mysqli_query($link, "SELECT wid FROM watches WHERE stid='$stid' ");
		$qnum = mysqli_num_rows($q);
		return $qnum;
	}


	public function update_solution($apid, $task, $summary, $solution, $solution_temp){
		global $link;

		$apid = clean($link, $apid);
		$st = $this->get_user_type($apid);
		if($st['user_type'] != 's'){
			return '<p class="text-center">Sorry, you do not have the privilege to access this information</p>';
		}
		$stid = $st['userid'];

		$task = clean($link, $task);
		$summary = clean($link, $summary);

		$tq = mysqli_query($link, "SELECT `task`.`days` as `days`, `solution`.`date` as `begin` FROM `solution`,`task` WHERE `solution`.`tid`='$task' AND `task`.`tid`='$task' AND `solution`.`stid`='$stid' ");
		
		$speed = 0;
		$tqr = mysqli_fetch_assoc($tq);
		$days = $tqr['days']*86400;
		$start = time() - strtotime($tqr['begin']);
		if($days >= $start){
			$speed = 3;
		}

		$timenow = date("Y-m-d H:i:s", time());
		$filename = $this->uploadfile($solution, $solution_temp);
		$q = mysqli_query($link, "UPDATE solution SET summary='$summary', file='$filename',status='1',submission='1',speed='$speed',attempt='1',send_date='$timenow' WHERE tid='$task' AND stid='$stid' ");
		if($q){
			$sq = mysqli_query($link, "SELECT apid,email FROM appusers WHERE userid IN (SELECT cid FROM task WHERE tid='$task') AND user_type='c'");           
			$sqr = mysqli_fetch_assoc($sq);
			$user = $sqr['apid'];
			$userx = $this->user_data($apid, "username");
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
	


	public function uploadfile($filename,$filetmp){

	    $allow = array('doc','docx','pdf');
	    $bits = explode('.',$filename);
	    $file_extn = strtolower(end($bits));
	    $filenamex = 'rookSol'.substr(md5(time().rand(10000,99999)), 0, 15).'.'.$file_extn;
	    $fullpath = 'docs/solutions/'.$filenamex;
	        $move = move_uploaded_file($filetmp ,$fullpath) ;
	        if(!$move){
	            return '0';
	        }
	        return $filenamex;
	}


	public function task_check($apid, $task){
		global $link;

		$task = clean($link, $task);
		$apid = clean($link, $apid);
		$st = $this->get_user_type($apid);
		if($st['user_type'] != 's'){
			return '<p class="text-center">Sorry, you do not have the privilege to access this information</p>';
		}
		$stid = $st['userid'];

		$q = mysqli_query($link, "SELECT sid,status FROM solution WHERE stid='$stid' AND tid='$task' ");
		$qnum = mysqli_num_rows($q);
		if($qnum == 0){
			return 'Your have to added this task to your <b>To Do tasks</b>';
		}

		$qr = mysqli_fetch_assoc($q);
		if($qr['status'] == 0){
			return 1;
		}
		return 'Solution for this task has been submitted already';
		
	}


	public function qrcode_generate($token, $username){
		global $link,$baseUrl;

		$fileName = $username.'.svg';
		$string = $baseUrl.'/rookcv?cv='.$token.'';
		
		$path = 'qrcode/'.$fileName;
		if(file_exists($path)){
			unlink($path);
		}
		QRcode::svg($string, $path); 
	}


	public function get_my_cv($apid){
		global $link, $baseUrl;

		$apid = clean($link, $apid);
		$st = $this->get_user_type($apid);
		if($st['user_type'] != 's'){
			return '<div class="col-lg-12 mg-t-20 mg-lg-t-0">
								<div class="card bd-0 shadow-base">
									<div class="pd-x-25 pd-t-25">
										<p class="text-center">Sorry, you do not have the privilege to access this information</p>
									</div>
								</div>
							</div>';
		}
		$stid = $st['userid'];

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
		
		
		$em = $this->user_email($apid);
		$info = $this->user_data($apid, 'fname,lname,username,dob,gender,phone,country,postal,city,state');
		if($info['gender'] == 'f'){
			$gender = 'Female';
		}else{
			$gender = 'Male';
		}

		$username = $info['username'];

		$tkq = mysqli_query($link, "SELECT token FROM appusers WHERE apid='$apid'");
		$tkqr = mysqli_fetch_assoc($tkq);
		$token = $tkqr['token'];
		
		$this->qrcode_generate($token, $username);

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
					$wh1 .= '<p class="tx-14 mg-b-10" id="job_'.$whqr['cwid'].'">
										<b>'.$whqr['job_title'].'</b> <span onclick="delinfo(\'job\',\''.$whqr['cwid'].'\')" style="cursor:pointer;" class="tx-danger mg-l-5"><i class="ion ion-android-delete"></i>Delete</span><br>
										'.$whqr['duties'].'<br>
										'.$whqr['employer'].' - '.$whqr['country'].'<br>
										'.date("M Y", strtotime($whqr['start'])).' - '.$end.'
									</p>';
				}
				else{
					$wh2 .= '<p class="tx-14 mg-b-10" id="job_'.$whqr['cwid'].'">
										<b>'.$whqr['job_title'].'</b> <span onclick="delinfo(\'job\',\''.$whqr['cwid'].'\')" style="cursor:pointer;" class="tx-danger mg-l-5"><i class="ion ion-android-delete"></i>Delete</span><br>
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
					$ed1 .= '<p class="tx-14 mg-b-10" id="edu_'.$edqr['ceid'].'">
										<b>'.$edqr['school'].'</b> - '.$edqr['location'].' <span onclick="delinfo(\'edu\',\''.$edqr['ceid'].'\')" style="cursor:pointer;" class="tx-danger mg-l-5"><i class="ion ion-android-delete"></i>Delete</span><br>
										'.$edqr['degree'].' - '.$edqr['field'].'<br>
										'.date("Y", strtotime($edqr['finish'])).'
									</p>';
				}
				else{
					$ed2 .= '<p class="tx-14 mg-b-10" id="edu_'.$edqr['ceid'].'">
										<b>'.$edqr['school'].'</b> - '.$edqr['location'].' <span onclick="delinfo(\'edu\',\''.$edqr['ceid'].'\')" style="cursor:pointer;" class="tx-danger mg-l-5"><i class="ion ion-android-delete"></i>Delete</span><br>
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
					
					$sk1 .= '<p class="tx-14 mg-b-10" id="skill_'.$skqr['csid'].'">
										<b>'.$skqr['skill'].'</b> <span onclick="delinfo(\'skill\',\''.$skqr['csid'].'\')" style="cursor:pointer;" class="tx-danger mg-l-5"><i class="ion ion-android-delete"></i>Delete</span>
									</p>';
				}
				else{
					$sk2 .= '<p class="tx-14 mg-b-10" id="skill_'.$skqr['csid'].'">
										<b>'.$skqr['skill'].'</b> <span onclick="delinfo(\'skill\',\''.$skqr['csid'].'\')" style="cursor:pointer;" class="tx-danger mg-l-5"><i class="ion ion-android-delete"></i>Delete</span>
									</p>';
					$c=0;
				}
				$c++;
			}

			$skills = '<div class="col-md-6">'.$sk1.'</div><div class="col-md-6">'.$sk2.'</div>';
		}


		return '<div class="col-lg-12 mg-t-20 mg-lg-t-0">
							<div class="card bd-0 shadow-base">
								<div class="pd-x-25 pd-t-25">
									<p><img alt="" src="assets/images/logo.png" width="150">
										<span class="pull-right"><button data-clipboard-text="'.$baseUrl.'/rookcv?cv='.$token.'" class="btn btn-primary btn-md tx-12 mg-3 copyButton" >Click to copy CV Link</button></span>
									</p>
									<hr>
									<div class="row">
										<div class="col-md-8">
											<p></p>
											<h4 class="tx-inverse tx-semibold tx-spacing-1 mg-b-20">'.$info['fname'].' '.$info['lname'].'<button onclick="edit_info()" class="btn btn-warning btn-sm tx-12 mg-3" style="padding: 1px 5px;"><i class="ion ion-edit"></i> Edit</button></h4>
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
									<h6 class="tx-inverse tx-semibold tx-spacing-1 mg-b-10">Professional Summary 
										<button onclick="edit_prof()" class="btn btn-warning btn-sm tx-12 mg-3" style="padding: 1px 5px;"><i class="ion ion-edit"></i> Edit</button>                  
										<button class="btn btn-primary btn-sm tx-12" style="padding: 1px 5px;" data-container="body" data-toggle="popover" data-popover-color="primary" data-placement="bottom" title="Professional Summary" data-html="true" data-content="<p>Make a great first impression.</p><p>Write a career overview so that hiring managers can immediately see the value that you bring.</p><p>Make your summary sound stronger by writing it in the present tense. Focus on what you can do for a company, rather than what you did in the past.</p>"><i class="ion ion-ios-lightbulb"></i> Tip</button>
									</h6>
									<p class="tx-14 mg-b-5">'.$prof.'</p>
									<hr>
									<h6 class="tx-inverse tx-semibold tx-spacing-1 mg-b-10">Work History
										<button onclick="edit_work()" class="btn btn-success btn-sm tx-12 mg-3" style="padding: 1px 5px;"><i class="ion ion-plus"></i> Add</button>                  
										<button class="btn btn-primary btn-sm tx-12" style="padding: 1px 5px;" data-container="body" data-toggle="popover" data-popover-color="primary" data-placement="bottom" title="Work History" data-html="true" data-content="<p>Let employers see where you’ve worked before</p><p>Hiring managers will scan this information looking for career progression</p><p>Do not abbreviate job titles. Using your full title looks more professional and is easier for managers to understand.</p>"><i class="ion ion-ios-lightbulb"></i> Tip</button>
									</h6>
									<div class="row">
										'.$work.'
									</div>
									<hr>
									<h6 class="tx-inverse tx-semibold tx-spacing-1 mg-b-10">Education
										<button onclick="edit_education()" class="btn btn-success btn-sm tx-12 mg-3" style="padding: 1px 5px;"><i class="ion ion-plus"></i> Add</button>
										<button class="btn btn-primary btn-sm tx-12" style="padding: 1px 5px;" data-container="body" data-toggle="popover" data-popover-color="primary" data-placement="bottom" title="Education" data-html="true" data-content="<p>Help employers better understand your background</p><p>List the schools you’ve attended and any degrees you’ve earned, starting with your most recent.</p><p>List high school only if you did not go to college.</p>"><i class="ion ion-ios-lightbulb"></i> Tip</button>
									</h6>
									<div class="row">
										'.$education.'
									</div>								
									<hr>
									<h6 class="tx-inverse tx-semibold tx-spacing-1 mg-b-10">Skills
										<button onclick="edit_skills()" class="btn btn-success btn-sm tx-12 mg-3" style="padding: 1px 5px;"><i class="ion ion-plus"></i> Add</button>
										<button class="btn btn-primary btn-sm tx-12" style="padding: 1px 5px;" data-container="body" data-toggle="popover" data-popover-color="primary" data-placement="bottom" title="Skills" data-html="true" data-content="<p>Write a career overview so that hiring managers can immediately see the value that you bring.</p>"><i class="ion ion-ios-lightbulb"></i> Tip</button>
									</h6>
									<div class="row">
										'.$skills.'
									</div>
									<hr>									
									<h6 class="tx-inverse tx-semibold tx-spacing-1 mg-b-10">Community Service
										<button onclick="edit_comms()" class="btn btn-warning btn-sm tx-12 mg-3" style="padding: 1px 5px;"><i class="ion ion-edit"></i> Edit</button>                  
										<button class="btn btn-primary btn-sm tx-12" style="padding: 1px 5px;" data-container="body" data-toggle="popover" data-popover-color="primary" data-placement="bottom" title="Professional Summary" data-html="true" data-content="<p>Add any community service you have been involved.</p>"><i class="ion ion-ios-lightbulb"></i> Tip</button>
									</h6>
									<p class="tx-14 mg-b-5">'.$service.'</p>
									<hr>
									<h6 class="tx-inverse tx-semibold tx-spacing-1 mg-b-10">Hobbies and Interests
										<button onclick="edit_hobby()" class="btn btn-warning btn-sm tx-12 mg-3" style="padding: 1px 5px;"><i class="ion ion-edit"></i> Edit</button>                  
										<button class="btn btn-primary btn-sm tx-12" style="padding: 1px 5px;" data-container="body" data-toggle="popover" data-popover-color="primary" data-placement="bottom" title="Professional Summary" data-html="true" data-content="<p>Add your interest and hobbies.</p>"><i class="ion ion-ios-lightbulb"></i> Tip</button>
									</h6>
									<p class="tx-14 mg-b-5">'.$hobbies.'</p>
									<hr>	
									<h6 class="tx-inverse tx-semibold tx-spacing-1 mg-b-10">Rook+ Statistics</h6>
									<h5 class="mg-b-20" style="font-weight:400">Completed Tasks: <b>'.$taskinfo['total'].'</b></h5>
									<h6 class="mg-b-20" style="font-weight:400">Total Points: <b>'.$this->get_points($apid).'</b></h6>
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


	public function download_cv($apid){
		global $link;

		$apid = clean($link, $apid);
		$st = $this->get_user_type($apid);
		if($st['user_type'] != 's'){
			return '<div class="col-lg-12 mg-t-20 mg-lg-t-0">
								<div class="card bd-0 shadow-base">
									<div class="pd-x-25 pd-t-25">
										<p class="text-center">Sorry, you do not have the privilege to access this information</p>
									</div>
								</div>
							</div>';
		}
		$stid = $st['userid'];

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
		
		
		$em = $this->user_email($apid);
		$info = $this->user_data($apid, 'fname,lname,username,dob,gender,phone,country,postal,city,state');
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
									<h6 class="mg-b-20" style="font-weight:400">Total Points: <b>'.$this->get_points($apid).'</b></h6>
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


	public function get_apid($token){
		global $link;

		$token = clean($link, $token);

		$q = mysqli_query($link, "SELECT apid FROM appusers WHERE token='$token'");
		$qnum = mysqli_num_rows($q);
		if($qnum == 0){
			return 0;
		}
		$qr = mysqli_fetch_assoc($q);
		return $qr['apid'];
	}


	public function get_hobby($stid){
		global $link;

		$stid = clean($link, $stid);

		$q = mysqli_query($link, "SELECT `hobbies` FROM cv_hobbies WHERE stid='$stid' ");
		$qnum = mysqli_num_rows($q);
		if($qnum == 0){
			$hobby = 'done|';
			return $hobby;
		}
		$qr = mysqli_fetch_assoc($q);
		$hobby = $qr['hobbies'];
		return 'done|'.$hobby;
	}


	public function get_community_service($stid){
		global $link;

		$stid = clean($link, $stid);

		$q = mysqli_query($link, "SELECT `service` FROM cv_service WHERE stid='$stid' ");
		$qnum = mysqli_num_rows($q);
		if($qnum == 0){
			$comms = 'done|';
			return $comms;
		}
		$qr = mysqli_fetch_assoc($q);
		$comms = $qr['service'];
		return 'done|'.$comms;
	}


	public function get_professional_summary($stid){
		global $link;

		$stid = clean($link, $stid);

		$q = mysqli_query($link, "SELECT `summary` FROM cv_prof WHERE stid='$stid' ");
		$qnum = mysqli_num_rows($q);
		if($qnum == 0){
			$prof = 'done|';
			return $prof;
		}
		$qr = mysqli_fetch_assoc($q);
		$prof = $qr['summary'];
		return 'done|'.$prof;
	}


	public function update_work_history($apid, $jobtitle, $employer, $country, $duties, $sdate, $edate, $current){
		global $link;

		$jobtitle = clean($link, $jobtitle);
		$employer = clean($link, $employer);
		$country = clean($link, $country);
		$duties = clean($link, $duties);
		$start = clean($link, $sdate);
		$end = clean($link, $edate);
		$current = clean($link, $current);

		$apid = clean($link, $apid);
		$st = $this->get_user_type($apid);
		if($st['user_type'] != 's'){
			return 'Sorry, you do not have the privilege to access this information';
		}

		$stid = $st['userid'];
		
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
			return 1;
		}
		return 'Error, updating your work history';
	}



	public function update_hobby($apid, $hobby){
		global $link; 
		
		$hobby = clean($link, $hobby);
		$apid = clean($link, $apid);
		$st = $this->get_user_type($apid);
		if($st['user_type'] != 's'){
			return 'Sorry, you do not have the privilege to access this information';
		}
		$stid = $st['userid'];

		$cq = mysqli_query($link, "SELECT * FROM cv_hobbies WHERE stid='$stid' ");
		$cqnum = mysqli_num_rows($cq);

		$timenow = date("Y-m-d H:i:s", time());
		if($cqnum == 0){
			$iq = mysqli_query($link, "INSERT INTO cv_hobbies(`stid`,`hobbies`,`date`) VALUES('$stid', '$hobby', '$timenow')");
			if($iq){
				return 1;
			}
			return 'Error updating Hobbies and Interests';
		}

		$uq = mysqli_query($link, "UPDATE cv_hobbies SET `hobbies`='$hobby', `date`='$timenow' WHERE stid='$stid' ");
		if($uq){
			return 1;
		}
		return 'Error updating Hobbies and Interests';
	}



	public function update_community_service($apid, $comms){
		global $link; 
		
		$comms = clean($link, $comms);
		$apid = clean($link, $apid);
		$st = $this->get_user_type($apid);
		if($st['user_type'] != 's'){
			return 'Sorry, you do not have the privilege to access this information';
		}
		$stid = $st['userid'];
		
		$cq = mysqli_query($link, "SELECT * FROM cv_service WHERE stid='$stid' ");
		$cqnum = mysqli_num_rows($cq);
		$timenow = date("Y-m-d H:i:s", time());
		if($cqnum == 0){
			$iq = mysqli_query($link, "INSERT INTO cv_service(`stid`,`service`,`date`) VALUES('$stid', '$comms', '$timenow')");
			if($iq){
				return 1;
			}
			return 'Error updating Community Service';
		}

		$uq = mysqli_query($link, "UPDATE cv_service SET `service`='$comms', `date`='$timenow' WHERE stid='$stid' ");
		if($uq){
			return 1;
		}
		return 'Error updating Community Service';
	}



	public function update_professional_summary($apid, $prof){
		global $link; 
		
		$prof = clean($link, $prof);
		$apid = clean($link, $apid);
		$st = $this->get_user_type($apid);
		if($st['user_type'] != 's'){
			return 'Sorry, you do not have the privilege to access this information';
		}
		$stid = $st['userid'];

		$cq = mysqli_query($link, "SELECT * FROM cv_prof WHERE stid='$stid' ");
		$cqnum = mysqli_num_rows($cq);
		$timenow = date("Y-m-d H:i:s", time());

		if($cqnum == 0){
			$iq = mysqli_query($link, "INSERT INTO cv_prof(`stid`,`summary`,`date`) VALUES('$stid', '$prof', '$timenow')");
			if($iq){
				return 1;
			}
			return 'Error updating Professional Summary';
		}

		$uq = mysqli_query($link, "UPDATE cv_prof SET summary='$prof', `date`='$timenow' WHERE stid='$stid' ");
		if($uq){
			return 1;
		}
		return 'Error updating Professional Summary';
	}


	public function update_education($apid, $sname, $sloc, $degree, $field, $cyear){
		global $link;

		$sname = clean($link, $sname);
		$sloc = clean($link, $sloc);
		$degree = clean($link, $degree);
		$field = clean($link, $field);
		$cyear = clean($link, $cyear);

		$apid = clean($link, $apid);
		$st = $this->get_user_type($apid);
		if($st['user_type'] != 's'){
			return 'Sorry, you do not have the privilege to access this information';
		}

		$stid = $st['userid'];
		
		$timenow = date("Y-m-d H:i:s", time());
		$iq = mysqli_query($link, "INSERT INTO cv_education(`stid`,`school`,`location`,`degree`,`field`,`finish`,`date`) 
			VALUES('$stid', '$sname', '$sloc', '$degree', '$field', '$cyear', '$timenow')");
		if($iq){
			return 1;
		}
		
		return 'Error updating Education Infomation';
		
	}


	public function update_skill($apid, $skill){
		global $link;

		$skill = clean($link, $skill);
		$apid = clean($link, $apid);
		$st = $this->get_user_type($apid);
		if($st['user_type'] != 's'){
			return 'Sorry, you do not have the privilege to access this information';
		}

		$stid = $st['userid'];

		$timenow = date("Y-m-d H:i:s", time());
		$iq = mysqli_query($link, "INSERT INTO cv_skills(`stid`,`skill`,`date`) 
			VALUES('$stid', '$skill', '$timenow')");
		if($iq){
			return 1;
		}
		
		return 'Error updating Skill Infomation';

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
			return 'done';
		}

		return 'Error delete CV information...Try again';
	}


	public function get_student_data($apid){
		global $link;

		$apid = clean($link, $apid);
		$em = $this->user_email($apid);
		$info = $this->user_data($apid, 'fname,lname,dob,gender,phone,country,postal,city,state');
		if($info['gender'] == 'm'){
			$gender = '<option value="m">Male</option>';
		}
		else{
			$gender = '<option value="f">Female</option>';
		}

		$code = '<option value="'.substr($info['phone'],0,3).'">+ '.substr($info['phone'],0,3).'</option>';
		$phone = '0'.substr($info['phone'],3,15);
		
		$month = '<option value="'.date("n", strtotime($info['dob'])).'">'.date("F", strtotime($info['dob'])).'</option>';
		$day = '<option value="'.date("j", strtotime($info['dob'])).'">'.date("j", strtotime($info['dob'])).'</option>';
		$year = '<option value="'.date("Y", strtotime($info['dob'])).'">'.date("Y", strtotime($info['dob'])).'</option>';

		$nowx = date("Y", time()) - 45;
		$dyear='';
		for ($i=$nowx; $i <= $nowx+45; $i++) { 
			$dyear .= '<option value="'.$i.'">'.$i.'</option>';
		}

		$countryid = $info['country'];
		$cq = mysqli_query($link, "SELECT `country_name` FROM countries WHERE id='$countryid' ");
		$cqr = mysqli_fetch_assoc($cq);
		$country = '<option value="'.$countryid.'">'.$cqr['country_name'].'</option>';

		$get_code = $this->get_country_code();
		$countries = $this->get_countries();


		return '<form id="form" method="POST" action="" data-parsley-validate enctype="multipart/form-data">
							<div class="row" style="margin-top:50px;">
								<div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-10 col-sm-offset-1">
									<div id="closebut" onclick="closepop()">
										<span class="icon ion-android-close"></span>
									</div>
									<div class="card bd-0 shadow-base">
										<div class="pd-x-25 pd-t-25">
											<h5 class="text-center">Personal Info</h5>
											<div class="form-group">
												<div class="row row-xs">
													<div class="col-sm-6">
														<input type="text" value="'.$info['lname'].'" class="form-control" name="lname" placeholder="Last Name" required>
													</div>
													<div class="col-sm-6 mg-t-20 mg-sm-t-0">
														<input type="text" value="'.$info['fname'].'" class="form-control" name="fname" placeholder="First Name" required>
													</div>
												</div>
											</div>
											<div class="form-group">
												<select class="form-control select2" name="gender" data-placeholder="Gender" required>
													'.$gender.'
													<option label="Gender"></option>
													<option value="f">Female</option>
													<option value="m">Male</option>
												</select>
											</div>
											<div class="form-group">
												<input type="email" value="'.$em['email'].'" class="form-control" name="email" placeholder="Email" required>
											</div>
											<div class="form-group">
												<input type="text" value="'.$info['postal'].'" class="form-control" name="postal" placeholder="Postal Address">
											</div>
											<div class="form-group">
												<label class="d-block tx-11 tx-uppercase tx-medium tx-spacing-1">Birthday</label>
												<div class="row row-xs">
													<div class="col-sm-4">
														<select class="form-control select2" name="month" data-placeholder="Month" required>
															'.$month.'
															<option label="Month"></option>
															<option value="1">January</option>
															<option value="2">February</option>
															<option value="3">March</option>
															<option value="4">April</option>
															<option value="5">May</option>
															<option value="6">June</option>
															<option value="7">July</option>
															<option value="8">August</option>
															<option value="9">September</option>
															<option value="10">October</option>
															<option value="11">November</option>
															<option value="12">December</option>
														</select>
													</div>
													<div class="col-sm-4 mg-t-20 mg-sm-t-0">
														<select class="form-control select2" name="day" data-placeholder="Day" required>
															'.$day.'
															<option label="Day"></option>
															<option value="1">1</option>
															<option value="2">2</option>
															<option value="3">3</option>
															<option value="4">4</option>
															<option value="5">5</option>
															<option value="6">6</option>
															<option value="7">7</option>
															<option value="8">8</option>
															<option value="9">9</option>
															<option value="10">10</option>
															<option value="11">11</option>
															<option value="12">12</option>
															<option value="13">13</option>
															<option value="14">14</option>
															<option value="15">15</option>
															<option value="16">16</option>
															<option value="17">17</option>
															<option value="18">18</option>
															<option value="19">19</option>
															<option value="20">20</option>
															<option value="21">21</option>
															<option value="22">22</option>
															<option value="23">23</option>
															<option value="24">24</option>
															<option value="25">25</option>
															<option value="26">26</option>
															<option value="27">27</option>
															<option value="28">28</option>
															<option value="29">29</option>
															<option value="30">30</option>
															<option value="31">31</option>
														</select>
													</div>
													<div class="col-sm-4 mg-t-20 mg-sm-t-0">
														<select class="form-control select2" name="year" data-placeholder="Year" required>
															'.$year.'
															<option label="Year"></option>
															'.$dyear.'
														</select>
													</div>
												</div>
											</div>
											<div class="form-group">
												<label class="d-block tx-11 tx-uppercase tx-medium tx-spacing-1">Phone Number</label>
												<div class="row row-xs">
													<div class="col-sm-4">
														<select class="form-control select2" name="code" data-placeholder="Code" required>
															'.$code.'
															<option label="Code"></option>
															'.$get_code.'
														</select>
													</div>
													<div class="col-sm-8 mg-t-20 mg-sm-t-0">
														<input type="text" value="'.$phone.'" class="form-control" data-parsley-length="[9, 15]" data-parsley-type="digits" name="phone" placeholder="Phone Number" required>
													</div>
												</div>
											</div>
											<div class="form-group">
												<select class="form-control select2" name="country" data-placeholder="Country" required>
													'.$country.'
													<option label="Country"></option>
													'.$countries.'
												</select>
											</div>
											<div class="form-group">
												<input type="text" value="'.$info['city'].'" class="form-control" name="city" required>
											</div>
											<div class="form-group">
												<input type="text" value="'.$info['state'].'" class="form-control" name="state" placeholder="State" required>
											</div>
											<hr>
											<div class="form-group text-center">
												<button type="submit" name="infosubmit" class="btn btn-success mg-b-10" style="width: 40%;">Submit</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</form>';
	}


	public function get_student_edit_info($apid){
		global $link;

		$apid = clean($link, $apid);
		$em = $this->user_email($apid);
		$info = $this->user_data($apid, 'fname,lname,dob,gender,phone,country,postal,city,state');
		if($info['gender'] == 'm'){
			$gender = '<option value="m">Male</option>';
		}
		else{
			$gender = '<option value="f">Female</option>';
		}

		$code = '<option value="'.substr($info['phone'],0,3).'">+ '.substr($info['phone'],0,3).'</option>';
		$phone = '0'.substr($info['phone'],3,15);
		
		$month = '<option value="'.date("n", strtotime($info['dob'])).'">'.date("F", strtotime($info['dob'])).'</option>';
		$day = '<option value="'.date("j", strtotime($info['dob'])).'">'.date("j", strtotime($info['dob'])).'</option>';
		$year = '<option value="'.date("Y", strtotime($info['dob'])).'">'.date("Y", strtotime($info['dob'])).'</option>';

		$nowx = date("Y", time()) - 45;
		$dyear='';
		for ($i=$nowx; $i <= $nowx+45; $i++) { 
			$dyear .= '<option value="'.$i.'">'.$i.'</option>';
		}

		$countryid = $info['country'];
		$cq = mysqli_query($link, "SELECT `country_name` FROM countries WHERE id='$countryid' ");
		$cqr = mysqli_fetch_assoc($cq);
		$country = '<option value="'.$countryid.'">'.$cqr['country_name'].'</option>';

		$get_code = $this->get_country_code();
		$countries = $this->get_countries();


		return '<form id="form" method="POST" action="" data-parsley-validate enctype="multipart/form-data">						
							<div class="form-group">
								<div class="row row-xs">
									<div class="col-sm-6">
										<input type="text" value="'.$info['lname'].'" class="form-control" name="lname" placeholder="Last Name" required>
									</div>
									<div class="col-sm-6 mg-t-20 mg-sm-t-0">
										<input type="text" value="'.$info['fname'].'" class="form-control" name="fname" placeholder="First Name" required>
									</div>
								</div>
							</div>
							<div class="form-group">
								<select class="form-control select2" name="gender" data-placeholder="Gender" required>
									'.$gender.'
									<option label="Gender"></option>
									<option value="f">Female</option>
									<option value="m">Male</option>
								</select>
							</div>
							<div class="form-group">
								<input type="email" value="'.$em['email'].'" class="form-control" name="email" placeholder="Email" required>
							</div>
							<div class="form-group">
								<input type="text" value="'.$info['postal'].'" class="form-control" name="postal" placeholder="Postal Address">
							</div>
							<div class="form-group">
								<label class="d-block tx-11 tx-uppercase tx-medium tx-spacing-1">Birthday</label>
								<div class="row row-xs">
									<div class="col-sm-4">
										<select class="form-control select2" name="month" data-placeholder="Month" required>
											'.$month.'
											<option label="Month"></option>
											<option value="1">January</option>
											<option value="2">February</option>
											<option value="3">March</option>
											<option value="4">April</option>
											<option value="5">May</option>
											<option value="6">June</option>
											<option value="7">July</option>
											<option value="8">August</option>
											<option value="9">September</option>
											<option value="10">October</option>
											<option value="11">November</option>
											<option value="12">December</option>
										</select>
									</div>
									<div class="col-sm-4 mg-t-20 mg-sm-t-0">
										<select class="form-control select2" name="day" data-placeholder="Day" required>
											'.$day.'
											<option label="Day"></option>
											<option value="1">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
											<option value="6">6</option>
											<option value="7">7</option>
											<option value="8">8</option>
											<option value="9">9</option>
											<option value="10">10</option>
											<option value="11">11</option>
											<option value="12">12</option>
											<option value="13">13</option>
											<option value="14">14</option>
											<option value="15">15</option>
											<option value="16">16</option>
											<option value="17">17</option>
											<option value="18">18</option>
											<option value="19">19</option>
											<option value="20">20</option>
											<option value="21">21</option>
											<option value="22">22</option>
											<option value="23">23</option>
											<option value="24">24</option>
											<option value="25">25</option>
											<option value="26">26</option>
											<option value="27">27</option>
											<option value="28">28</option>
											<option value="29">29</option>
											<option value="30">30</option>
											<option value="31">31</option>
										</select>
									</div>
									<div class="col-sm-4 mg-t-20 mg-sm-t-0">
										<select class="form-control select2" name="year" data-placeholder="Year" required>
											'.$year.'
											<option label="Year"></option>
											'.$dyear.'
										</select>
									</div>
								</div>
							</div>
							<div class="form-group">
								<label class="d-block tx-11 tx-uppercase tx-medium tx-spacing-1">Phone Number</label>
								<div class="row row-xs">
									<div class="col-sm-4">
										<select class="form-control select2" name="code" data-placeholder="Code" required>
											'.$code.'
											<option label="Code"></option>
											'.$get_code.'
										</select>
									</div>
									<div class="col-sm-8 mg-t-20 mg-sm-t-0">
										<input type="text" value="'.$phone.'" class="form-control" data-parsley-length="[9, 15]" data-parsley-type="digits" name="phone" placeholder="Phone Number" required>
									</div>
								</div>
							</div>
							<div class="form-group">
								<select class="form-control select2" name="country" data-placeholder="Country" required>
									'.$country.'
									<option label="Country"></option>
									'.$countries.'
								</select>
							</div>
							<div class="form-group">
								<input type="text" value="'.$info['city'].'" class="form-control" name="city" required>
							</div>
							<div class="form-group">
								<input type="text" value="'.$info['state'].'" class="form-control" name="state" placeholder="State" required>
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


	public function email_update($apid, $email){
		global $link;

		$email = clean($link, $email);
		$apid = clean($link, $apid);
		$q = mysqli_query($link, "SELECT apid FROM appusers WHERE email='$email' AND apid !='$apid' ");

		return  mysqli_num_rows($q);
	}



	public function update_info($apid, $fname, $lname, $gender, $email, $postal, $dob, $country, $phonenum, $city, $state){
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
		
		$apid = clean($link, $apid);
		$st = $this->get_user_type($apid);
		if($st['user_type'] != 's'){
			return 'Sorry, you do not have the privilege to access this information';
		}
		$stid = $st['userid'];

		if(empty($postal)){
			$postal = NULL;
		}

		$ec = $this->email_update($apid, $email);
		if($ec==1){
			return 'Email already exist';
		}

		$q = mysqli_query($link, "UPDATE students SET `fname`='$fname', `lname`='$lname', `postal`='$postal', `gender`='$gender', `country`='$country', `dob`='$dob', `phone`='$phonenum', `city`='$city', `state`='$state' WHERE stid='$stid'");
		if($q){
			$qz = mysqli_query($link, "UPDATE appusers SET `email`='$email' WHERE apid='$apid' ");
			if($qz){
				return 1;
			}
			else{
				return 'Error updating Personal Informationx. Try again';
			}
		}
		else{
			return 'Error updating Personal Information. Try again';
		}
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


	public function get_transactions($apid, $search, $pagex){
		global $link;

		$apid = clean($link, $apid);
		$st = $this->get_user_type($apid);
		if($st['user_type'] != 's'){
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
	

	public function change_avatar($data, $userid){
		global $link;

		list($type, $data) = explode(';', $data);
		list(, $data)      = explode(',', $data);
		$data = base64_decode($data);

		$imageName = 'rookie'.substr(md5(time()), 0, 10).'.png';
		$oldavat = mysqli_query($link, "SELECT avatar FROM students WHERE stid='$userid' ");
		$or = mysqli_fetch_assoc($oldavat);
		if(empty($or['avatar']) != true){
			unlink("../img/avatar/".$or['avatar']);
		}

		$upavat = mysqli_query($link, "UPDATE students SET avatar='$imageName' WHERE stid='$userid' ");

		if(file_put_contents('../img/avatar/'.$imageName , $data)){
			return "done";
		}
		return "error updating avatar";
	}



	public function get_internships($apid, $search, $pagex){
    global $link;

    $apid = clean($link, $apid);
    $st = $this->get_user_type($apid);
    if($st['user_type'] != 's'){
      $data['info'] = '<p class="text-center">Sorry, you do not have the privilege to access this information</p>';
      $data['page'] = '';
      $data['range'] = '';
      return $data;
    }
		$cid = $st['userid'];
		$uq = mysqli_query($link, "UPDATE `notification` SET seen='1' WHERE apid='$apid' AND ntype='i' ");

    $search = clean($link, $search);
    $page = clean($link, $pagex);

    $parameter = '1';
    $pagegets = '';
    if(!empty($search) == true){
      $parameter = "cid IN ( SELECT cid FROM company WHERE cname LIKE '%$search%')";
      $pagegets = '&q='.$search;
    }

    if(empty($page) == false){
      $checkqx = mysqli_query($link, "SELECT COUNT(*) FROM internship WHERE $parameter"); 
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

    $q = mysqli_query($link, "SELECT * FROM internship WHERE $parameter ORDER BY `created` DESC $qlimit");
    $qnum = mysqli_num_rows($q);
    if($qnum == 0){
      $data['info'] = '<p class="text-center">No internship found</p>';
      $data['page'] = '';
      $data['range'] = '';
      return $data;
    }

    $pagg=$intern='';
    $pqx = mysqli_query($link, "SELECT COUNT(*) FROM internship WHERE $parameter ");
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
			$cid = $qr['cid'];
  

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
			
			$cmq = mysqli_query($link, "SELECT cname FROM company WHERE cid='$cid' ");
			$cmqr = mysqli_fetch_assoc($cmq); 

			$intern .= '<h6 class="card-title mg-b-2">'.$qr['title'].'</h6>
									<p class="tx-primary">posted by <b>'.$cmqr['cname'].'</b></p>
									<p class="card-text">'.$qr['description'].' - <i style="color:#2196f3;">'.$timepost.'</i></p>
									<p class="card-text">Starts: <b class="tx-success">'.date("jS M Y", strtotime($qr['starts'])).'</b> - Ends: <b class="tx-danger">'.date("jS M Y", strtotime($qr['ends'])).'</b></b></p>                
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
	


	public function get_internship_info($apid, $intern){
    global $link;

    $intern =  clean($link, $intern);
    $apid =  clean($link, $apid);
    $uc = $this->get_user_type($apid);
    if($uc['user_type'] != 's'){
      return 'You do not have the privilege to perform this action';
    }

    $cq = mysqli_query($link, "SELECT * FROM internship WHERE inid='$intern' ");
    $cqnum = mysqli_num_rows($cq);
    if($cqnum == 0){
      return 'Internship Information';
    }

    $qr = mysqli_fetch_assoc($cq);
    $title = $qr['title'];
    $description = $qr['description'];
		$date = date("jS M Y, h:i a", strtotime(($qr['created'])));
		
		$cmq = mysqli_query($link, "SELECT cname FROM company WHERE cid IN (SELECT cid FROM internship WHERE inid='$intern' )");
		$cmqr = mysqli_fetch_assoc($cmq);

		$head = '<p class="mg-b-0"><b>'.$title.'</b></p>
						<p class="tx-primary">posted by <b>'.$cmqr['cname'].'</b></p>
            <p class="mg-b-0">'.$description.' - <i style="color:#2196f3;">'.$date.'</i></p>
            <p class="card-text">Starts: <b class="tx-success">'.date("jS M Y, h:i a", strtotime($qr['starts'])).'</b> - Ends: <b class="tx-danger">'.date("jS M Y, h:i a", strtotime($qr['ends'])).'</b></b></p>';
    return $head;
	}
	


	public function get_internship_applicants($apid, $intern, $pagex){
    global $link;

    $inid =  clean($link, $intern);
    $apid =  clean($link, $apid);
    $uc = $this->get_user_type($apid);
    if($uc['user_type'] != 's'){
			$data['info'] = '<p>You do not have the privilege to perform this action</p>';
			$data['page'] = '';
			$data['range'] = '';
			return $data;
    }
		$stid = $uc['userid'];
		$uq = mysqli_query($link, "UPDATE `notification` SET seen='1' WHERE apid='$apid' AND ntype='i' ");
		
		$cq = mysqli_query($link, "SELECT * FROM applicants WHERE stid='$stid' AND inid='$inid' ");
		$cqnum = mysqli_num_rows($cq);
		if($cqnum == 0){
			$data['info'] = '<p class="text-center mg-50"><button onclick="applytointern(\''.$inid.'\')" class="btn btn-primary btn-lg">Apply for Internship</button></p>';
			$data['page'] = '';
			$data['range'] = '';
			return $data;
		}
		
		$cqr = mysqli_fetch_assoc($cq);
		if($cqr['accepted'] == '0'){
			$data['info'] = '<p class="text-center mg-50"><button class="btn btn-warning btn-lg">Application Pending</button></p>';
			$data['page'] = '';
			$data['range'] = '';
			return $data;
		}

		$cmq = mysqli_query($link, "SELECT cname FROM company WHERE cid IN (SELECT cid FROM internship WHERE inid='$inid' )");
		$cmqr = mysqli_fetch_assoc($cmq);

		$data['info'] = '<h4 class="tx-center tx-success">Congratulation!</h4>
										<hr>
										<p class="tx-center"><b>'.$cmqr['cname'].'</b> has accepted your internship application. <br>Below is your <b>Internship Acceptance Code</b><br></p>
										<h5 class="tx-center"><span class="tx-15">Code:</span> <b class="tx-warning">'.$cqr['code'].'</b></h5>
										<hr>
										<p class="tx-center">
											<a href="acceptance?i='.$inid.'" target="_blank">
												<button class="btn btn-primary btn-with-icon mg-t-10">
													<div class="ht-40">
														<span class="icon wd-40"><i class="ion-android-print" style="font-size: 25px;color: #fff;"></i></span>
														<span class="pd-x-15">Print</span>
													</div>
												</button>
											</a>
										</p>';
		$data['page'] = '';
		$data['range'] = '';
		return $data;
	}

	
	public function apply_to_intern($apid, $internship){
		global $link;

		$inid =  clean($link, $internship);
    $apid =  clean($link, $apid);
    $uc = $this->get_user_type($apid);
    if($uc['user_type'] != 's'){
			return 'You do not have the privilege to perform this action';
    }
		$stid = $uc['userid'];

		$cq = mysqli_query($link, "SELECT inid FROM internship WHERE inid='$inid' OR inid IN (SELECT inid FROM applicants WHERE stid='$stid' AND inid='$inid' ) ");
		$cqnum = mysqli_num_rows($cq);
		if($cqnum == 0){
			return 'Invalid internship information';
		}

		$caq = mysqli_query($link, "SELECT inid FROM applicants WHERE stid='$stid' AND inid='$inid' ");
		$caqnum = mysqli_num_rows($caq);
		if($caqnum > 0){
			return 'You have applied already for this internship';
		}

		$timenow = date("Y-m-d H:i:s", time());
		$inq = mysqli_query($link, "INSERT INTO applicants(`inid`,`stid`,`date`) VALUES('$inid', '$stid', '$timenow')");
		if($inq){	
      $sq = mysqli_query($link, "SELECT apid,email FROM appusers WHERE userid IN (SELECT cid FROM internship WHERE inid='$inid') AND user_type='c'");
      $sqnum = mysqli_num_rows($sq);
      if($sqnum > 0){      
       	$sqr = mysqli_fetch_assoc($sq);
				$user = $sqr['apid'];
				$cq = mysqli_query($link, "SELECT username FROM students WHERE stid='$stid'");
				$cqr = mysqli_fetch_assoc($cq);
				$note = '<b>'.$cqr['username'].'</b> applied for an internship.';
				$tid = 'i='.$inid.'&st='.$cqr['username'];
				$inq = mysqli_query($link, "INSERT INTO `notification`(`apid`,`ntype`,`note_id`,`note`,`date`) VALUES('$user', 'i', '$tid', '$note', '$timenow') ");  
				
				$email = $sqr['email'];
				$message = nl2br($note);
				$this->send_email($email, "Internship Applicant", $message);
			}
			return 'done';
		}
		return 'Error applying for internship...try again';
	}



	public function download_intern_code($apid, $intern){
		global $link;

		$inid =  clean($link, $intern);
    $apid =  clean($link, $apid);
    $uc = $this->get_user_type($apid);
    if($uc['user_type'] != 's'){
			return '<p>You do not have the privilege to perform this action</p>';
    }
		$stid = $uc['userid'];
		$uq = mysqli_query($link, "UPDATE `notification` SET seen='1' WHERE apid='$apid' AND ntype='i' ");
		
		$cq = mysqli_query($link, "SELECT * FROM applicants WHERE stid='$stid' AND inid='$inid' ");
		$cqnum = mysqli_num_rows($cq);
		if($cqnum == 0){
			return '<p>You do not have the privilege to perform this action</p>';
		}
		
		$cqr = mysqli_fetch_assoc($cq);
		if($cqr['accepted'] == '0'){
			return '<p>You do not have the privilege to perform this action</p>';
		}

		$cmq = mysqli_query($link, "SELECT cname FROM company WHERE cid IN (SELECT cid FROM internship WHERE inid='$inid' )");
		$cmqr = mysqli_fetch_assoc($cmq);

		return '<div class="col-lg-12 mg-t-20 mg-lg-t-0">
							<div class="card bd-0 shadow-base">
								<div class="pd-x-25 pd-t-25">
									<p class="tx-center"><img alt="" src="assets/images/logo.png" width="150"></p>
									<hr>
									<p class="tx-center"><b>'.$cmqr['cname'].'</b> has accepted your internship application. <br>Below is your <b>Internship Acceptance Code</b><br></p>
									<h5 class="tx-center mg-b-50"><span class="tx-15">Code:</span> <b class="tx-warning">'.$cqr['code'].'</b></h5>																		
								</div><!-- pd-x-25 -->
							</div><!-- card -->
						</div>';
	
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