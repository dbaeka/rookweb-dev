<?php
session_start();

if(!isset($_SESSION['apid']) == true || empty($_SESSION['apid']) == true){
  header("Location: home");
  exit();
}

require 'app/user.php';
require 'app/admin.php';
require 'app/company.php';

$ux = new User();
$ax = new Admin();
$cx = new Company();

$apid = $_SESSION['apid'];
$note = $ux->subscription($apid);
if($note == '0'){
  header("Location: subscription");
  exit();
}

$userz = $ux->user_email($apid);

$uc = $ux->get_user_type($apid);
$usertype = $uc['user_type'];


$student = '';
if(isset($_GET['student']) && empty($_GET['student']) == false){
  $student = $_GET['student'];
}

$studentpts=$msg='';

if(isset($_POST['profsubmit'])){
  $prof = $_POST['prof'];

  if(empty($prof)){
    $msg='<script type="text/javascript">
              swal("Error!", "Professional Summary cannot be empty", "error")
            </script>';
  }
  else if(strlen($prof) > 160){
    $msg='<script type="text/javascript">
              swal("Error!", "Professional Summary cannot be more than 160 characters ", "error")
            </script>';
  }
  else{
    $pfadd = $ux->update_professional_summary($apid, $prof);
    if($pfadd == 1){
      $msg='<script type="text/javascript">
              swal("Updated", "Professional Summary updated successfully", "success")
            </script>';
    }else{
      $msg='<script type="text/javascript">
              swal("Error", "'.$pfadd.'", "error")
            </script>';
    }
  }
}


if(isset($_POST['commsubmit'])){
  $comms = $_POST['comms'];

  if(empty($comms)){
    $msg='<script type="text/javascript">
              swal("Error!", "Community Service cannot be empty", "error")
            </script>';
  }
  else if(strlen($comms) > 160){
    $msg='<script type="text/javascript">
              swal("Error!", "Community Service cannot be more than 160 characters ", "error")
            </script>';
  }
  else{
    $cmadd = $ux->update_community_service($apid, $comms);
    if($cmadd == 1){
      $msg='<script type="text/javascript">
              swal("Updated", "Community Service updated successfully", "success")
            </script>';
    }else{
      $msg='<script type="text/javascript">
              swal("Error", "'.$cmadd.'", "error")
            </script>';
    }
  }
}


if(isset($_POST['hobsubmit'])){
  $hobby = $_POST['hobby'];

  if(empty($hobby)){
    $msg='<script type="text/javascript">
              swal("Error!", "Hobbies and Interests cannot be empty", "error")
            </script>';
  }
  else if(strlen($hobby) > 160){
    $msg='<script type="text/javascript">
              swal("Error!", "Hobbies and Interests cannot be more than 160 characters ", "error")
            </script>';
  }
  else{
    $hoadd = $ux->update_hobby($apid, $hobby);
    if($hoadd == 1){
      $msg='<script type="text/javascript">
              swal("Updated", "Hobbies and Interests updated successfully", "success")
            </script>';
    }else{
      $msg='<script type="text/javascript">
              swal("Error", "'.$hoadd.'", "error")
            </script>';
    }
  }
}


if(isset($_POST['skillsubmit'])){
  $error=0;

  $skill = $_POST['skill'];

  if(empty($skill)){
    $error++;
  }

  if($error == 0){
    $sk = $ux->update_skill($apid, $skill);
    if($sk == 1){
      $msg='<script type="text/javascript">
              swal("Updated", "Skill Information updated successfully", "success")
            </script>';
    }
    else{
      $msg='<script type="text/javascript">
            swal("Error", "'.$sk.'", "error")
          </script>';
    }

  }
  else{
    $msg='<script type="text/javascript">
            swal("Error", "Error...some fields are empty or invalid", "error")
          </script>';
  }
}


if(isset($_POST['edusubmit'])){
  $error=0;

  $sname = $_POST['sname'];
  $sloc = $_POST['sloc'];
  $degree = $_POST['degree'];
  $field = $_POST['field'];
  $cyear = $_POST['cyear'];

  if(empty($sname) || empty($sloc) || empty($degree) || empty($field)){
    $error++;
  }


  if(empty($cyear)){
    $error++;
  }else if(!preg_match("/^\d{4}$/", $cyear)){
    $error++;
  }


  if($error == 0){
    $edu = $ux->update_education($apid, $sname, $sloc, $degree, $field, $cyear);
    if($edu == 1){
      $msg='<script type="text/javascript">
              swal("Updated", "Education Information updated successfully", "success")
            </script>';
    }
    else{
      $msg='<script type="text/javascript">
            swal("Error", "'.$edu.'", "error")
          </script>';
    }

  }
  else{
    $msg='<script type="text/javascript">
            swal("Error", "Error...some fields are empty or invalid", "error")
          </script>';
  }
}


if(isset($_POST['infosubmit'])){
  $error = 0;

  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $email = $_POST['email'];
  $postal = $_POST['postal'];
  $phone = $_POST['phone'];
  $code = $_POST['code'];
  $gender = $_POST['gender'];
  $country = $_POST['country'];
  $city = $_POST['city'];
  $state = $_POST['state'];

  $month = $_POST['month'];
  $year = $_POST['year'];
  $day = $_POST['day'];

  $dob = date("Y-m-d", strtotime($year.'-'.$month.'-'.$day));


  if(empty($phone) == true) {
    $error++;
  }
  else if(!preg_match("/^[0-9]+$/", $phone)){
    $error++;
  }
  else{
    if(substr($phone,0,1) == '0'){
      $phone = substr($phone,1,15);
    }
  }

  if(empty($email) == true){
    $error++;
  }
  else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
    $error++;
  }

  if(empty($gender) == true){
    $error++;
  }
  else if($gender != 'm' && $gender != 'f'){
    $error++;
  }


  if(empty($country) == true){
    $error++;
  }
  else{
    $cc = $ux->check_country($country);
    if(empty($cc) == true){
      $error++;
    }
  }


  if(empty($dob) == true){
    $error++;
  }

  if(empty($code) == true){
    $error++;
  }
  else if($code != '233' && $code != '234'){
    $error++;
  }

  if(empty($fname) == true){
    $error++;
  }
  if(empty($lname) == true){
    $error++;
  }

  if($error == 0){
    $phonenum = $code.$phone;
    $udata = $ux->update_info($apid, $fname, $lname, $gender, $email, $postal, $dob, $country, $phonenum, $city, $state);
    if($udata == 1){
      $msg='<script type="text/javascript">
              swal("Updated", "Personal Information updated successfully", "success")
            </script>';
    }else{
      $msg='<script type="text/javascript">
            swal("Error", "'.$udata.'", "error")
          </script>';
    }
  }
  else{
    $msg='<script type="text/javascript">
            swal("Error", "Error...some fields are empty or invalid", "error")
          </script>';
  }
}



if(isset($_POST['worksubmit'])){
  $error = 0;

  $jobtitle = $_POST['jobtitle'];
  $employer = $_POST['employer'];
  $duties = $_POST['duties'];
  $smonth = $_POST['smonth'];
  $syear = $_POST['syear'];
  $country = $_POST['country'];

  $emonth=$eyear=$current=NULL;
  if(!isset($_POST['current'])){
    $emonth = $_POST['emonth'];
    $eyear = $_POST['eyear'];
    $edate = date("Y-m-d", strtotime($eyear.'-'.$emonth.'-1'));
  }
  else{
    $current=1;
    $edate = '';
  }

  if(empty($jobtitle) || empty($employer) || empty($country) || empty($smonth)){
    $error++;
  }

  if(empty($duties)){
    $error++;
  }else if(strlen($duties) > 160){
    $error++;
  }

  if(empty($syear)){
    $error++;
  }else if(!preg_match("/^\d{4}$/", $syear)){
    $error++;
  }

  if(empty($current) && (empty($emonth) || empty($eyear))){
    $error++;
  }
  else if(!empty($eyear) && !preg_match("/^\d{4}$/", $eyear)){
    $error++;
  }

  $sdate = date("Y-m-d", strtotime($syear.'-'.$smonth.'-1'));

  if($error == 0){
    $work = $ux->update_work_history($apid, $jobtitle, $employer, $country, $duties, $sdate, $edate, $current);
    if($work == 1){
      $msg='<script type="text/javascript">
              swal("Updated", "Work History updated successfully", "success")
            </script>';
    }
    else{
      $msg='<script type="text/javascript">
            swal("Error", "'.$work.'", "error")
          </script>';
    }

  }
  else{
    $msg='<script type="text/javascript">
            swal("Error", "Error...some fields are empty or invalid", "error")
          </script>';
  }


}


if($usertype == 's'){
  $userx = $ux->user_data($apid, "fname,lname,active,avatar,username");
  if($userx['active'] == 0){
    header("Location: activate");
    exit();
  }
  else if(empty($userx['username']) == true){
    header("Location: info");
    exit();
  }
  elseif ($userx['active'] == 2){
    header("Location: door");
    exit();
  }
  
  $notes = $ux->get_notifications($apid);
  $points = $ux->get_points($apid);
  $studentpts = '<div class="tx-center">
                  <span class="profile-earning-label">Points</span>
                  <h3 class="profile-earning-amount">'.$points.' <i class="icon ion-ios-arrow-thin-up tx-success"></i></h3>
                  <span class="profile-earning-text">Based on task solutions.</span>
                </div>
                <hr>';

  $cv = $ux->get_my_cv($apid);
  $menu = $ux->menu_switch('s',4);
  $fullname = $userx['fname'].' '.$userx['lname'];
  $fname = $userx['fname'];
  $email = $userz['email'];
  if(empty($userx['avatar'])){
    $logo = 'p.png';
  }
  else{
    $logo = $userx['avatar'];
  }
  $settings = '<li><a href="settings"><i class="icon ion-ios-gear"></i>Account Settings</a></li>';
}
else if($usertype == 'a'){
  $userx = $ux->user_data($apid, "active");
  if ($userx['active'] == 2){
    header("Location: door");
    exit();
  }
  
  header("Location: admin");
  exit();

}
else if($usertype == 'c'){
  $userx = $ux->user_data($apid, "active");
  if ($userx['active'] == 2){
    header("Location: door");
    exit();
  }

  header("Location: hub");
  exit();
}
else{
  header("Location: home");
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="description" content="Rook+" />
    <meta name="keywords" content="Rook+" />
    <meta name="author" content="ONE957">

    <title>Rook+ | CV</title>

    <!-- vendor css -->
    <link href="css/font-awesome.css" rel="stylesheet">
    <link href="css/ionicons.css" rel="stylesheet">
    <link href="lib/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <link href="lib/jquery-switchbutton/jquery.switchButton.css" rel="stylesheet">
    <link href="lib/rickshaw/rickshaw.min.css" rel="stylesheet">
    <link href="css/select2.min.css" rel="stylesheet">
    <link href="css/spinkit.css" rel="stylesheet">
    <link href="css/parsley.css" rel="stylesheet">
    <link href="css/sweetalert2.min.css" rel="stylesheet">
    <script src="js/sweetalert2.min.js"></script> 
    <link rel="shortcut icon" href="assets/images/icon/favicon.png">

    <link rel="stylesheet" href="css/rook.css">
  </head>

  <body>
    <?php echo $msg;?>
    <!-- ########## START: LEFT PANEL ########## -->
    <div class="br-logo"><a href="dashboard" class="inner-link"><img alt="" src="assets/images/logo.png" width="150"></a></div>
    <div class="br-sideleft overflow-y-auto">
      <label class="sidebar-label pd-x-10 mg-t-20 op-3">Navigation</label>
      <?php echo $menu;?>

      <br>
    </div><!-- br-sideleft -->
    <!-- ########## END: LEFT PANEL ########## -->

    <!-- ########## START: HEAD PANEL ########## -->
    <div class="br-header">
      <div class="br-header-left">
        <div class="navicon-left hidden-md-down"><a id="btnLeftMenu" href="#"><i class="icon ion-navicon-round"></i></a></div>
        <div class="navicon-left hidden-lg-up"><a id="btnLeftMenuMobile" href="#"><i class="icon ion-navicon-round"></i></a></div>
      </div><!-- br-header-left -->
      <div class="br-header-right">
        <nav class="nav">
          <div class="dropdown">
            <a href="#" class="nav-link pd-x-7 pos-relative" data-toggle="dropdown">
              <i class="icon ion-ios-bell-outline tx-24"></i>
              <?php echo $notes['show']?>
            </a>
            <div class="dropdown-menu dropdown-menu-header">
              <div class="dropdown-menu-label">
                <label>Notifications</label>
                <!-- <a href="#">Mark All as Read</a> -->
              </div><!-- d-flex -->

              <div class="media-list">
                <?php echo $notes['notes'];?>
              </div><!-- media-list -->
            </div><!-- dropdown-menu -->
          </div><!-- dropdown -->
          <div class="dropdown">
            <a href="#" class="nav-link nav-link-profile" data-toggle="dropdown">
              <span class="logged-name hidden-md-down"><?php echo $fname;?></span>
              <img src="img/avatar/<?php echo $logo; ?>" class="wd-32 rounded-circle" alt="">
              <span class="square-10 bg-success"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-header wd-250">
              <div class="tx-center">
                <a href="#"><img src="img/avatar/<?php echo $logo; ?>" class="wd-80 rounded-circle" alt=""></a>
                <a href="#"><h6 class="logged-fullname"><?php echo $fullname;?></h6></a>
                <p><?php echo $email;?></p>
              </div>
              <hr>
              <?php echo $studentpts;?>
              <ul class="list-unstyled user-profile-nav">
                <?php echo $settings;?>
                <li><a href="logout"><i class="icon ion-power"></i> Sign Out</a></li>
              </ul>
            </div><!-- dropdown-menu -->
          </div><!-- dropdown -->
        </nav>
      </div><!-- br-header-right -->
    </div><!-- br-header -->
    <!-- ########## END: HEAD PANEL ########## -->

    <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel">
      <?php echo $note;?>
      <div class="br-pagetitle">
        <i class="icon ion-ios-paper"></i>
        <div>
          <h4>CV</h4>
          <p class="mg-b-0">Curriculum Vitae</p>
					<a href="pdfcv" target="_blank"><button class="btn btn-primary btn-with-icon mg-t-10">
            <div class="ht-40">
              <span class="icon wd-40"><i class="ion-android-print" style="font-size: 25px;color: #fff;"></i></span>
              <span class="pd-x-15">Print CV</span>
            </div>
          </button></a>
        </div>
      </div>
      <div class="br-pagebody">

        <div class="row row-sm mg-t-20">
          
          <?php echo $cv; ?>
        </div><!-- row -->

      </div><!-- br-pagebody -->
      <footer class="br-footer">
        <div class="footer-left">
          <div class="mg-b-2"><?php echo $footer;?></div>
        </div>
      </footer>
    </div><!-- br-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->

    <div id="overlayload">
      
    </div>

    <script src="js/jquery.js"></script>
    <script src="js/actions.js?rook=<?php echo rand(100,999);?>"></script>
    <script src="js/parsley.js"></script>
    <script src="js/popover-colored.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/select2.min.js"></script>
    <script src="lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js"></script>
    <script src="lib/moment/moment.js"></script>
    <script src="js/bootstrap-maxlength.min.js"></script>
    <script src="lib/jquery-ui/jquery-ui.js"></script>
    <script src="lib/jquery-switchbutton/jquery.switchButton.js"></script>
    <script src="lib/peity/jquery.peity.js"></script>
    <script src="lib/d3/d3.js"></script>
    <script src="lib/rickshaw/rickshaw.min.js"></script>
    <script src="lib/Flot/jquery.flot.js"></script>
    <script src="lib/Flot/jquery.flot.resize.js"></script>
    <script src="lib/flot-spline/jquery.flot.spline.js"></script>
    <script src="lib/jquery.sparkline.bower/jquery.sparkline.min.js"></script>
    <script src="lib/echarts/echarts.min.js"></script>
    <script src="http://maps.google.com/maps/api/js?key=AIzaSyCuWEQWfVkWfcUoSIZeGw5JioT9LVCwYkE"></script>
    <script src="lib/gmaps/gmaps.js"></script>

    <script src="js/rook.js"></script>
    <script src="js/map.shiftworker.js"></script>
    <script src="js/ResizeSensor.js"></script>    
    <script src="js/dashboard.js"></script>
    <script src="js/clipboard.min.js"></script>
		<script>
			var clipboard = new Clipboard('.copyButton');
			clipboard.on('success', function(e) {
				$('.copyButton').tooltip({ trigger: 'click' });
					// console.log(e);
			});
			clipboard.on('error', function(e) {
					// console.log(e);
			});

		</script>
    <script>
      function currentcheck(){        
        if ($('#currentw').is(":checked")){
          $('.endedx').prop('disabled', true);
        }
        else{         
          $('.endedx').prop('disabled',false);
        }
      }
      

      $(function(){
        'use strict'

        // FOR DEMO ONLY
        // menu collapsed by default during first page load or refresh with screen
        // having a size between 992px and 1299px. This is intended on this page only
        // for better viewing of widgets demo.
        $(window).resize(function(){
          minimizeMenu();
        });

        minimizeMenu();

        function minimizeMenu() {
          if(window.matchMedia('(min-width: 992px)').matches && window.matchMedia('(max-width: 1299px)').matches) {
            // show only the icons and hide left menu label by default
            $('.menu-item-label,.menu-item-arrow').addClass('op-lg-0-force d-lg-none');
            $('body').addClass('collapsed-menu');
            $('.show-sub + .br-menu-sub').slideUp();
          } else if(window.matchMedia('(min-width: 1300px)').matches && !$('body').hasClass('collapsed-menu')) {
            $('.menu-item-label,.menu-item-arrow').removeClass('op-lg-0-force d-lg-none');
            $('body').removeClass('collapsed-menu');
            $('.show-sub + .br-menu-sub').slideDown();
          }
        }
      });
    </script>
  </body>
</html>
