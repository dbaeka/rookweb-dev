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
$userz = $ux->user_email($apid);

$uc = $ux->get_user_type($apid);
$usertype = $uc['user_type'];

if(isset($_POST['pay'])){
  $ptype = $_POST['ptype'];
  
  if(empty($ptype)){
    $msg = '';
  }else{
    if($ptype='m' || $ptype='t'){
      $wallet = $_POST['phone'];

      if(empty($wallet)){
        $msg = '';
      }
      else{
        // $pay = $ux->
      }
    }
  }
}

$studentpts = '';

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
  
  $points = $ux->get_points($apid);
  $studentpts = '<div class="tx-center">
                  <span class="profile-earning-label">Points</span>
                  <h3 class="profile-earning-amount">'.$points.' <i class="icon ion-ios-arrow-thin-up tx-success"></i></h3>
                  <span class="profile-earning-text">Based on task solutions.</span>
                </div>
                <hr>';

  $fullname = $userx['fname'].' '.$userx['lname'];
  $fname = $userx['fname'];
  $email = $userz['email'];
  if(empty($userx['avatar'])){
    $logo = 'p.png';
  }
  else{
    $logo = $userx['avatar'];
  }
  $amount = 20;
  $sublengt = 'Anual Subscription';
  $vest = $ux->honey_pot();
}
else if($usertype == 'a'){
  header("Location: admin");
  exit();
}
else if($usertype == 'c'){
  $userx = $ux->user_data($apid, "cname,logo,email,active");
  if ($userx['active'] == 2){
    header("Location: door");
    exit();
  }

  if(empty($userx['logo'])){
    $logo = 'p.png';
  }
  else{
    $logo = $userx['logo'];
  }

  $cn = explode(" ", $userx['cname']);
  $fname = $cn[0];
  $fullname = $userx['cname'];
  $email = $userx['email'];
  $amount = 70;
  $sublengt = 'Monthly Subscription';
  $vest = $cx->honey_pot($apid);
}
else{
  header("Location: home");
  exit();
}

$resultx = '';
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

    <title>Rook+ | Subscription</title>

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
      #emg{
        font-size: 12px;
        padding: 0 5px;
        border-radius: 5px;
        display: none;
        margin-bottom: 0;
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
          <div class="col-md-6 col-md-offset-1">
            <div class="card bd-0 shadow-base">
              <div class="pd-x-25 pd-t-25 pd-b-25">
                <h6 class="tx-13 tx-uppercase tx-inverse tx-semibold tx-spacing-1 mg-b-20">Payment for Subscription</h6>
                <hr>
                <div class="tx-center">
                <div class="row ht-100p">
                  <div class="col-md-5">
                    <img src="img/pay.jpg" class="wd-100p ht-100p object-fit-cover rounded" alt="Image">
                  </div><!-- col-5 -->
                  <div class="col-md-7 pd-y-0 pd-r-10 d-flex align-items-start flex-column">
                    <p class="mg-b-0 tx-center tx-success" style="width:100%;">GHC</p>
                    <h4 class="tx-normal tx-inverse tx-roboto tx-50 mg-b-2" style="width:100%;"><?php echo $amount;?></h4>
                    <p class="mg-b-20" style="width:100%;"><?php echo $sublengt;?></p>
                    <form id="form" data-parsley-validate style="width:100%;">
                      <div class="form-group">
                      <select class="form-control" name="ptype" id="ptype" required>
                        <option value="">*-Select a Payment Option-*</option>
                        <option value="m">MTN Mobile Money</option>
                        <option value="t">TiGO Cash</option>
                      </select>
                      </div>                    
                      <div class="form-group">
                        <input type="text" class="form-control" data-parsley-length="[10, 10]" data-parsley-type="digits" name="phone" id="wallet" placeholder="Enter Mobile Wallet Number" required>
                      </div>
                      <p class="mg-b-20">
                        <button id="pay" type="submit" name="pay" class="btn btn-success pd-x-50">Pay</button>
                      </p>
                    </form>
                  </div><!-- col-6 -->
                </div>
                </div>
              </div><!-- pd-x-25 -->
            </div><!-- card -->
          </div><!-- col-8 -->
          <div class="col-md-4">
            <div class="card bd-0 shadow-base">
              <div class="pd-x-25 pd-t-25 pd-b-25">
                <h6 class="tx-13 tx-uppercase tx-inverse tx-semibold tx-spacing-1 mg-b-20">New Tasks</h6>
                <hr>
                <?php echo $vest;?>
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
      <div class="d-flex ht-300 pos-relative align-items-center mg-t-100">
        <div class="sk-chasing-dots">
          <div class="sk-child sk-dot1 bg-gray-800"></div>
          <div class="sk-child sk-dot2 bg-gray-800"></div>
        </div>        
      </div>
      <p class="tx-center tx-20">Processing Payment...</p>
    </div>
    <script src="js/jquery.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/actions.js"></script>
    <script>
      $(document).ready(function() {
          $("#form").on('submit', function(e){
              e.preventDefault();
              var form = $(this);

              form.parsley().validate();

              if (form.parsley().isValid()){
                  process_transaction();
              }
          });
      });
    </script>


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
