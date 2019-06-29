<?php 
class Company{

  public function get_company_list($stid, $search){
    global $link, $baseUrl;

    $search = clean($link, $search);
    $stid = clean($link, $stid);

    if(!empty($search)){
      $parameter = "AND cname LIKE '%$search%' ORDER BY cname ASC";
    }else{
      $parameter = "AND cid IN (SELECT cid FROM task WHERE 1 ORDER BY RAND()) ORDER BY RAND()";
    }

    $q = mysqli_query($link, "SELECT * FROM company WHERE `active`='1' $parameter LIMIT 15");
    $qnum = mysqli_num_rows($q);
    if($qnum == 0){
      $data['state'] = 300;
      $data['response_msg'] = 'no compnay found';
      return $data;
    }



    $list = array();
    while($qr = mysqli_fetch_array($q, MYSQLI_ASSOC)){
      $dt['cid'] = $qr['cid'];
      $cid = $qr['cid'];
      
      $sq = mysqli_query($link, "SELECT cid FROM subscribe WHERE stid='$stid' AND cid='$cid'");
      $sqnum = mysqli_num_rows($sq);
      if($sqnum == 0){
        $dt['subscribed'] = '0';
      }else{
        $dt['subscribed'] = '1';
      }
      
      $dt['company_name'] = $qr['cname'];
      $dt['location'] = $qr['location'];
      $dt['address'] = $qr['address'];
      $dt['email'] = $qr['email'];
      $dt['bio'] = $qr['bio'];
      $dt['subscribers'] = $this->get_total_subscribers($qr['cid']);
      $dt['total_tasks'] = $this->get_total_tasks($qr['cid']);
      $dt['total_solutions'] = $this->get_total_task_solutions($qr['cid']);
      $dt['logo'] = $baseUrl.'/img/avatar/'.$qr['logo'];

      array_push($list, $dt);
    }

    $data['state'] = 200;
    $data['companies'] = $list;
    return $data;
  }


  public function get_subscribe_list($stid){
    global $link, $baseUrl;

    $stid = clean($link, $stid);
    
    $q = mysqli_query($link, "SELECT * FROM company WHERE cid IN (SELECT cid FROM subscribe WHERE stid='$stid' ) ORDER BY cname ASC");
    $qnum = mysqli_num_rows($q);
    if($qnum == 0){
      $data['state'] = 400;
      $data['response_msg'] = 'no compnay found';
      return $data;
    }

    $list = array();
    while($qr = mysqli_fetch_array($q, MYSQLI_ASSOC)){
      $dt['cid'] = $qr['cid'];
      $dt['company_name'] = $qr['cname'];
      $dt['location'] = $qr['location'];
      $dt['address'] = $qr['address'];
      $dt['email'] = $qr['email'];
      $dt['bio'] = $qr['bio'];
      $dt['logo'] = $baseUrl.'/img/avatar/'.$qr['logo'];;

      array_push($list, $dt);
    } 

    $data['state'] = 200;
    $data['companies'] = $list;
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

    $q = mysqli_query($link, "SELECT tid FROM `task` WHERE cid='$cid' ");
    $qnum = mysqli_num_rows($q);
    return $qnum;
  }


  public function get_total_task_solutions($cid){
    global $link;

    $cid = clean($link, $cid);

    $q = mysqli_query($link, "SELECT sid FROM `solution` WHERE tid IN (SELECT tid FROM `task` WHERE cid='$cid') AND `status` NOT IN ('0','3') ");
    $qnum = mysqli_num_rows($q);
    return $qnum;
  }


  public function subscribe($userid,$company){
		global $link;

		$userid = clean($link, $userid);
		$company = clean($link, $company);

		$cq = mysqli_query($link, "SELECT cid FROM company WHERE cid='$company' ");
		$cqnum = mysqli_num_rows($cq);
		if($cqnum == 0){
      $data['state'] = 400;
      $data['response_msg'] = 'Invalid company info';
      return $data;
		}

		$q =  mysqli_query($link, "SELECT cid FROM subscribe WHERE stid='$userid' AND cid='$company'");
		$qnum = mysqli_num_rows($q);
		if($qnum == 1){
			$dq = mysqli_query($link, "DELETE FROM subscribe WHERE stid='$userid' AND cid='$company'");
			if($dq){
        $data['state'] = 200;
        $data['subscribe'] = 0;
        return $data;
      }
      $data['state'] = 400;
      $data['response_msg'] = 'Error unsubscribing...try again';
      return $data;
		}
    $timenow = date("Y-m-d H:i:s", time());
		$iq = mysqli_query($link, "INSERT INTO subscribe(stid,cid,`date`) VALUES('$userid','$company','$timenow')");
		if($iq){
      $data['state'] = 200;
      $data['subscribe'] = 1;
      return $data;
    }
    $data['state'] = 400;
    $data['response_msg'] = 'Error subscribing...try again';
    return $data;
	}

}

?>