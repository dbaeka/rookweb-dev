<?php

class Transaction{

  public function get_user_type($apid){
		global $link;
		
		$apid = clean($link, $apid);

		$data = mysqli_fetch_assoc(mysqli_query($link, "SELECT user_type, userid FROM appusers WHERE apid='$apid' "));
		return $data;
	}


  public function pay($apid, $ptype, $wallet){
		global $link,$cp_key;

		$apid = clean($link, $apid);
		$ptype = clean($link, $ptype);
		$wallet = clean($link, $wallet);

		$api_key = $cp_key;
    $st = $this->get_user_type($apid);
    if($st['user_type'] == 's'){
      $amount = 20;
    }else{
      $amount = 70;
    }
		$description = 'Payment for student subscription package on Rook+';


    $sURL = "https://www.cediplus.com/apiplus/plus_v1";
    $sPD = 'wallet_type='.$ptype.'&wallet='.$wallet.'&amount='.$amount.'&description='.$description.'&api_key='.$api_key.'&action=sendbill'; 
    $aHTTP = array(
      'http' => array(
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded',
        'content' => $sPD
      )
    );
    $context = stream_context_create($aHTTP);
    $resultx = file_get_contents($sURL, false, $context);
		$result = json_decode($resultx, TRUE);
		
		if($result['state'] == 200){
			$invoice = $result['invoice_number'];

      $timenow = date("Y-m-d H:i:s", time());
			$q = mysqli_query($link, "INSERT INTO `transaction`(`wallet`, `wallet_type`, `apid`, `amount`, `invoice_num`, `status`, `date`) 
					VALUES('$wallet', '$ptype', '$apid', '$amount', '$invoice', 'p', '$timenow')");
			if($q){
				return 'done|'.$invoice;
			}
			return 'Error processing transaction';
		}

		return $result['response_msg'];
  }



  public function check_invoice($apid, $invoice){
    global $link,$cp_key;

    $apid = clean($link, $apid);
    $invoice = clean($link, $invoice);
    
    $cq = mysqli_query($link, "SELECT tid FROM `transaction` WHERE apid='$apid' AND invoice_num='$invoice' ");
    $cqnum = mysqli_num_rows($cq);
    if($cqnum == 0){
      return 'Invalid information';
    }

    $sURL = "https://www.cediplus.com/apiplus/plus_v1";
    $sPD = 'invoice='.$invoice.'&api_key='.$cp_key.'&action=checkbill';
    $aHTTP = array(
      'http' => array(
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded',
        'content' => $sPD
      )
    );
    $context = stream_context_create($aHTTP);
    $resultx = file_get_contents($sURL, false, $context);
    $result = json_decode($resultx, TRUE);
    
    if($result['state'] == 200){
      $code = $result['status_code'];
      if($code == 5000 || $code == 4000){
        $state = 'f';
        $q = mysqli_query($link, "UPDATE `transaction` SET `status`='$state' WHERE apid='$apid' AND invoice_num='$invoice' ");
      }else if($code == 2000){
        $state = 'p';
        $q = mysqli_query($link, "UPDATE `transaction` SET `status`='$state' WHERE apid='$apid' AND invoice_num='$invoice' ");
      }
      else if($code == 1000){
        $state = 's';
        $st = $this->get_user_type($apid);
        if($st['user_type'] == 's'){
          $stid = $st['userid'];
          $oldtime = $this->time_left($apid);
          $new = time() + 31536000 + $oldtime;
          $newtime = date("Y-m-d", $new);
          $sq = mysqli_query($link, "UPDATE students SET subscription='$newtime' WHERE stid='$stid' ");
        }else{
          $cid = $st['userid'];
          $oldtime = $this->time_left($apid);
          $new = time() + 2592000 + $oldtime;
          $newtime = date("Y-m-d", $new);
          $cq = mysqli_query($link, "UPDATE company SET subscription='$newtime' WHERE cid='$cid' ");
        }
      
        $trans = $result['transaction_number'];
        $q = mysqli_query($link, "UPDATE `transaction` SET `status`='$state', transaction_num='$trans' WHERE apid='$apid' AND invoice_num='$invoice' ");
      }
      else{
        $state = 'f';
        $q = mysqli_query($link, "UPDATE `transaction` SET `status`='$state' WHERE apid='$apid' AND invoice_num='$invoice' ");
      }

			
			if($q){
				return $state;
			}
			return 'Error processing transaction';
		}

		return $result['response_msg'];
  }


  public function time_left($apid){
    global $link;

    $apid = clean($link, $apid);
    $st = $this->get_user_type($apid);
    if($st['user_type'] == 's'){
      $stid = $st['userid'];

      $q = mysqli_query($link, "SELECT subscription, `date` FROM students WHERE stid='$stid' ");
      $qr = mysqli_fetch_assoc($q);
      if(empty($qr['subscription'])){
        $space = time() - strtotime($qr['date']);
        if($space >= 15552000){
          return 0;
        }
        else{
          return $space;
        }
      }else{
        $space = strtotime($qr['subscription']) - time();
        if($space <= 0){
          return 0;
        }else{
          return $space;
        }
      }
    }
    else{
      $cid = $st['userid'];
      $q = mysqli_query($link, "SELECT subscription, `date` FROM company WHERE cid='$cid' ");
      $qr = mysqli_fetch_assoc($q);
      if(empty($qr['subscription'])){
        $space = time() - strtotime($qr['date']);
        if($space >= 2592000){
          return 0;
        }
        else{
          return $space;
        }
      }else{
        $space = strtotime($qr['subscription']) - time();
        if($space <= 0){
          return 0;
        }else{
          return $space;
        }
      }
    }

    
  }
}


?>