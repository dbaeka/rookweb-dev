<?php

class Internship{

  public function get_internships($stid, $type, $index){
    global $link;

    $stid = clean($link, $stid);
		$type = clean($link, $type);
		$index = clean($link, $index);

		$uq = mysqli_query($link, "UPDATE `notification` SET seen='1' WHERE apid IN (SELECT apid FROM appusers WHERE user_type='s' AND userid='$stid') AND ntype='i' ");

    if($type == 'n'){
			if($index == 'a'){
				$q = mysqli_query($link, "SELECT * FROM internship WHERE 1 ORDER BY `created` DESC LIMIT 20 ");
			}else{
				$q = mysqli_query($link, "SELECT * FROM internship WHERE `inid` > '$index'  ORDER BY `created` DESC LIMIT 20 ");
			}
			
		}
		else{
			$q = mysqli_query($link, "SELECT * FROM internship WHERE `inid` > '$index' ORDER BY `created` DESC LIMIT 20 ");
    }
    

    $qnum = mysqli_num_rows($q);
		if($qnum == 0){
			$data['state'] = 300;
			$data['response_msg'] = 'No internship found';
			return $data;
		}

    $intern=array();
    while ($qr = mysqli_fetch_array($q, MYSQLI_ASSOC)) {			
			$cid = $qr['cid'];   
			
			$cmq = mysqli_query($link, "SELECT cname FROM company WHERE cid='$cid' ");
      $cmqr = mysqli_fetch_assoc($cmq); 
      
      $inid = $qr['inid'];

      $aq = mysqli_query($link, "SELECT code,accepted FROM applicants WHERE stid='$stid' AND inid='$inid' ");
      $aqnum = mysqli_num_rows($aq);
      if($aqnum == 0){
        $dx['applied'] = 0;
      }else{
				$dx['applied'] = 1;
        $aqr = mysqli_fetch_assoc($aq);
        $dx['accepted'] = $aqr['accepted'];
        if($aqr['accepted'] == 1){
          $dx['acceptance_code'] = $aqr['code'];
        }
      }

      $dx['inid'] = $qr['inid'];
      $dx['title'] = $qr['title'];
      $dx['description'] = $qr['description'];
      $dx['starts'] = $qr['starts'];
      $dx['ends'] = $qr['ends'];
      $dx['posted'] = $qr['created'];
      $dx['company_name'] = $cmqr['cname'];

      array_push($intern, $dx);
    }

    $data['internship'] = $intern;
  	$data['state'] = 200;
  	return $data;
  }
  

  public function apply($stid, $inid){
    global $link;

    $stid = clean($link, $stid);
    $inid = clean($link, $inid);
    
    $cq = mysqli_query($link, "SELECT inid FROM internship WHERE inid='$inid' OR inid IN (SELECT inid FROM applicants WHERE stid='$stid' AND inid='$inid' ) ");
		$cqnum = mysqli_num_rows($cq);
		if($cqnum == 0){
      $data['state'] = 400;
			$data['response_msg'] = 'Invalid internship information';
			return $data;
		}

		$caq = mysqli_query($link, "SELECT inid FROM applicants WHERE stid='$stid' AND inid='$inid' ");
		$caqnum = mysqli_num_rows($caq);
		if($caqnum > 0){
      $data['state'] = 400;
			$data['response_msg'] = 'You have applied already for this internship';
			return $data;
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
      $data['state'] = 200;
			return $data;
    }
    $data['state'] = 400;
    $data['response_msg'] = 'Error applying for internship...try again';
    return $data;
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