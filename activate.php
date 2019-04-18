<?php

session_start();

if(!isset($_SESSION['apid']) == true || empty($_SESSION['apid']) == true){
  header("Location: home");
  exit();
}

require 'app/user.php';
$ux = new User();
$apid = $_SESSION['apid'];
$uc = $ux->get_user_type($apid);
$usertype = $uc['user_type'];
if($usertype == 'a'){
  header("Location: admin");
  exit();
}
else if($usertype == 'c'){
  header("Location: hub");
  exit();
}
$userid = $uc['userid'];

$msg = '';
if(isset($_POST['addphone'])){
  $uphone = $_POST['phone'];
  $phone = $_POST['phone'];
  $code = $_POST['code'];

  if(empty($code) == true){
    $msg = '<div class="alert alert-danger" role="alert" style="text-align:center;"> <strong>Oh snap!</strong> Field is empty or invalid</div>';
  }
  else if($code != '233' && $code != '234'){
    $msg = '<div class="alert alert-danger" role="alert" style="text-align:center;"> <strong>Oh snap!</strong> Field is empty or invalid</div>';
  }
  else{
    if(empty($phone) == true) {
      $msg = '<div class="alert alert-danger" role="alert" style="text-align:center;"> <strong>Oh snap!</strong> Field is empty or invalid</div>';
    }
    else if(!preg_match("/^[0-9]+$/", $phone)){
      $msg = '<div class="alert alert-danger" role="alert" style="text-align:center;"> <strong>Oh snap!</strong> Phone number is invalid</div>';
    }
    else{
      if(substr($phone,0,1) == '0'){
        $phone = substr($phone,1,15);
      }
      $phonenum = $code.$phone;
      $upadd = $ux->addphone($userid, $phonenum);
      $up = explode('|', $upadd);
      if($up[0] == false){
        $msg = '<div class="alert alert-danger" role="alert" style="text-align:center;"> <strong>Oh snap!</strong> '.$up[1].'</div>';
      }
    }
  }

  
}

if(isset($_POST['resendsms'])){
  $rsnd = $ux->resend_sms($apid);
  $ru = explode('|', $rsnd);
  if($ru[0] == false){
    $msg = '<div class="alert alert-danger" role="alert" style="text-align:center;"> <strong>Oh snap!</strong> '.$ru[1].'</div>';
  }
  else{
    $msg = '<script type="text/javascript">
              swal({
                title: "SMS Sent Successfully!",
                text: "'.$ru[1].'",
                type: "success",
                showCancelButton: false,
                confirmButtonText: "Okay"
              }).then(function () {
                window.location.href = "activate";
              });
            </script>';
  }
}

if(isset($_POST['changenumber'])){
  $chng = $ux->change_number($userid);
  if($chng == false){
    $msg = '<div class="alert alert-danger" role="alert" style="text-align:center;"> <strong>Oh snap!</strong> Error changing your number. Try again</div>';
  }
}


$duser = $ux->user_data($apid, "fname,lname,phone,username,active");

if($duser['active'] == 1){
  if(empty($duser['username']) == true){
    header("Location: info");
    exit();
  }
  header("Location: dashboard");
  exit();
}
else if($duser['active'] == 2){
  header("Location: door");
  exit();
}

$phone = $duser['phone'];
if(empty($phone) == true){
  $get_code = $ux->get_country_code();
  $resultx = '<div class="imghead">
                <img src="img/activate.png">
              </div>
              <p style="text-align: center;">Activate your account</p>
              '.$msg.'
              <form method="POST" action="" data-parsley-validate>
                <div class="form-group">
                  <label class="d-block tx-11 tx-uppercase tx-medium tx-spacing-1 text-center">Enter your phone number</label>
                  <div class="row row-xs">
                    <div class="col-sm-4">
                      <select class="form-control select2" name="code" data-placeholder="Code" required>
                        <option label="Code"></option>
                        '.$get_code.'
                      </select>
                    </div><!-- col-4 -->
                    <div class="col-sm-8 mg-t-20 mg-sm-t-0">
                      <input type="text" class="form-control" data-parsley-length="[9, 15]" data-parsley-type="digits" name="phone" placeholder="Phone Number" required>
                    </div><!-- col-4 -->
                  </div><!-- row -->
                </div
                <div class="form-group" style="text-align: center;">
                  <button type="submit" class="btn btn-success waves-effect waves-light" name="addphone" style="width: 100%;">Submit</button>
                </div>
              </form>';
  
}
else{
  $resultx = '<div class="imghead">
                <img src="img/sms.png">
              </div>
              <p style="text-align: center;">An SMS with activation code has been sent to <span style="color: #FF5722;font-weight: 700;"><br>+'.$phone.'</span></p>
              '.$msg.'
                <div class="form-group">
                  <input type="text" class="form-control" id="code" style="text-align: center;" placeholder="Enter Activation Code"> 
                </div>
                <div class="form-group" style="margin-bottom: 5px;">
                  <button class="btn btn-success waves-effect waves-light" onclick="activate()" style="width: 100%;">Activate</button>
                </div>
              <form method="POST" action="">
                <div class="form-group">
                  <button class="btn btn-primary waves-effect waves-light" name="resendsms" style="width: 46%;font-size: 14px;">Resend SMS</button>
                  <button class="btn btn-warning pull-right waves-effect waves-light" name="changenumber" style="width: 46%;font-size: 14px;">Change Number</button>
                </div>
              </form>';
}

$fullname = $duser['fname'].' '.$duser['lname'];
$userz = $ux->user_email($apid);
$email = $userz['email'];

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

    <title>Rook+ | Activate</title>

    <!-- vendor css -->
    <link href="css/font-awesome.css" rel="stylesheet">
    <link href="css/ionicons.css" rel="stylesheet">
    <link href="lib/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <link href="lib/jquery-switchbutton/jquery.switchButton.css" rel="stylesheet">
    <link href="lib/rickshaw/rickshaw.min.css" rel="stylesheet">
    <link href="css/select2.min.css" rel="stylesheet">
    <link href="css/parsley.css" rel="stylesheet">
    <link href="css/spinkit.css" rel="stylesheet">
    <link href="css/sweetalert2.min.css" rel="stylesheet">
    <script src="js/sweetalert2.min.js"></script> 
    <link rel="shortcut icon" href="assets/images/icon/favicon.png">


    <link rel="stylesheet" href="css/rook.css">
    <style type="text/css">
      .imghead{
          margin: 10px auto;
          width: 60px;
      }
      .imghead img{
          width: 100%;
      }
      #overlayload{
        top: 0;
        display: none;
        background-color: #e9ecefeb;
        position: fixed;
        width: 100%;
        height: 100%;
        z-index: 1000;
      }
    </style>
  </head>

  <body>

    <!-- ########## START: LEFT PANEL ########## -->
    <div class="br-logo"><a href="dashboard" class="inner-link"><img alt="" src="assets/images/logo.png" width="150"></a></div>
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
            <a href="#" class="nav-link nav-link-profile" data-toggle="dropdown">
              <span class="logged-name hidden-md-down"><?php echo $duser['fname']?></span>
              <img src="img/avatar/p.png" class="wd-32 rounded-circle" alt="">
              <span class="square-10 bg-success"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-header wd-250">
              <div class="tx-center">
                <a href="#"><img src="img/avatar/p.png" class="wd-80 rounded-circle" alt=""></a>
                <h6 class="logged-fullname"><?php echo $fullname;?></h6>
                <p><?php echo $email;?></p>
              </div>
              <hr>
              <ul class="list-unstyled user-profile-nav">
                <li><a href="#"><i class="icon ion-ios-gear"></i> Settings</a></li>
                <li><a href="logout"><i class="icon ion-power"></i> Sign Out</a></li>
              </ul>
            </div><!-- dropdown-menu -->
          </div><!-- dropdown -->
        </nav>
      </div><!-- br-header-right -->
    </div><!-- br-header -->
    <!-- ########## END: HEAD PANEL ########## -->

    <!-- ########## START: MAIN PANEL ########## -->
    <div class="br-mainpanel" style="margin-left: 0;">

      <div class="br-pagebody mg-t-150">

        <div class="row row-sm mg-t-20">
          <div class="col-lg-4 col-lg-offset-4 col-md-4 col-md-offset-4">
            <div class="card bd-0 shadow-base">
              <div class="pd-x-25 pd-t-25 pd-b-25">
                 <!-- <h6 class="tx-13 tx-uppercase tx-inverse tx-semibold tx-spacing-1 mg-b-20">New Tasks</h6>
                <hr> -->
                <?php echo $resultx;?>
              </div><!-- pd-x-25 -->
            </div><!-- card -->


          </div><!-- col-8 -->
        </div><!-- row -->

      </div><!-- br-pagebody -->
      <footer class="br-footer">
      <p style="width: 100%;" class="text-center mg-b-2"><?php echo $footer;?></p>
      </footer>
    </div><!-- br-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->
    <div id="overlayload">
    </div>
    <script src="js/jquery.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/actions.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/parsley.js"></script>
    <script src="js/select2.min.js"></script>
    <script src="lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js"></script>
    <script src="lib/moment/moment.js"></script>
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
    <script>
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
