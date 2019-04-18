<?php
session_start();

if(!isset($_SESSION['apid']) == true || empty($_SESSION['apid']) == true){
  header("Location: home");
  exit();
}

require 'app/user.php';
$ux = new User();

$apid = $_SESSION['apid'];
$note = $ux->subscription($apid);
if($note == '0'){
  header("Location: subscription");
  exit();
}
$msg='';
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

if(isset($_POST['changepassword'])){
  $error = 0;

  $oldpassword = $_POST['oldpassword'];
  $newpassword = $_POST['newpassword'];

  if(empty($oldpassword) == true){
    $error++;
  }
  if(empty($newpassword) == true){
    $error++;
  }

  if($error == 0){
    $password = $ux->update_password($apid, $oldpassword, $newpassword);
    if($password == 1){
      $msg = '<script type="text/javascript">
                swal("Password Updated!","Your password have been updated successfully","success");
              </script>';
    }
    else{
      $msg = '<script type="text/javascript">
                swal("Error","'.$password.'","error");
              </script>';
    }
  }
  else{
    $msg = '<script type="text/javascript">
              swal("Error","Some of the fields were empty or invalid","error");
            </script>';
  }
}


$uc = $ux->get_user_type($apid);
$usertype = $uc['user_type'];
if($usertype == 's'){
  $userx = $ux->user_data($apid, "fname,lname,username,avatar,active");
  $userz = $ux->user_email($apid);
  $notes = $ux->get_notifications($apid);
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
}
else if($usertype == 'a'){
  header("Location: admin");
  exit();
}
else if($usertype == 'c'){
  header("Location: hub");
  exit();
}
else{
  header("Location: home");
  exit();
}

if(empty($userx['avatar'])){
  $avatar = 'p.png';
}
else{
  $avatar = $userx['avatar'];
}
$menu = $ux->menu_switch('s',0);

$fullname = $userx['fname'].' '.$userx['lname'];
$email = $userz['email'];
$points = $ux->get_points($apid);
$studentpts = '<div class="tx-center">
                <span class="profile-earning-label">Points</span>
                <h3 class="profile-earning-amount">'.$points.' <i class="icon ion-ios-arrow-thin-up tx-success"></i></h3>
                <span class="profile-earning-text">Based on task solutions.</span>
              </div>
              <hr>';

$pinfo = $ux->get_student_edit_info($apid);

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

    <title>Rook+ | Settings</title>

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
    <script src="js/jquery.js"></script>
    <link href="css/croppie.css" rel="stylesheet" />
    <script src="js/croppie.js"></script>
    <script src="js/actions.js"></script>
    <link rel="shortcut icon" href="assets/images/icon/favicon.png">

    <link rel="stylesheet" href="css/rook.css">
    <script type="text/javascript">
      $(document).ready(function(){
              $uploadCrop = $('#uploadview').croppie({
                  enableExif: true,
                  viewport: {
                      width: 200,
                      height: 200,
                      type: 'circle'
                  },
                  boundary: {
                      width: 250,
                      height: 250
                  }
              });

              $('#upload').on('change', function () { 
                  $('#displayavat').fadeOut(1);
                  $('#cropavat').fadeIn(20);
                  $('#donebutcnt').fadeIn(200);
                  var reader = new FileReader();
                  reader.onload = function (e) {
                      $uploadCrop.croppie('bind', {
                          url: e.target.result
                      }).then(function(){
                          console.log('jQuery bind complete');
                      });
                      
                  }
                  reader.readAsDataURL(this.files[0]);
              });

              $('#donebut').on('click', function (ev) {
                  loading();
                  $uploadCrop.croppie('result', {
                      type: 'canvas',
                      size: 'viewport'
                  }).then(function (resp) {

                      $.ajax({
                          url: "app/actions.php",
                          type: "POST",
                          data: {"avatarup":resp},
                          success: function (data) {
                              closepop();
                              if(data=="done"){
                                  html = '<img src="' + resp + '" />';
                                  $("#avatarbxz").html(html);
                                  uploadedx();
                                  $('#displayavat').fadeIn(20);
                                  $('#cropavat').fadeOut(1);
                                  $('#donebutcnt').fadeOut(1);
                              }
                              else{
                                  swal("Error!", "Error changing your avatar. Try again", "error");
                                  $('#displayavat').fadeIn(20);
                                  $('#cropavat').fadeOut(1);
                                  $('#donebutcnt').fadeOut(1);
                              }
                          }
                      });
                  });
              });
      });

      function endavatarup(){
          $('#displayavat').fadeIn(20);
          $('#cropavat').fadeOut(1);
          $('#donebutcnt').fadeOut(1);
      }

      function uploadedx(){
        swal({
              title: "Avatar Changed!",
              text: "Your avatar has been changed successfully.",
              type: "success",
              showCancelButton: false,
              confirmButtonText: "Okay"
            }).then(function () {
              window.location.href = "settings";
            });
      }

    </script>
    <style type="text/css">
      #avatarbxz {
          width: 200px;
          height: 200px;
          border-radius: 150px;
          margin: 0 auto;
          background-size: 100%;
          position: relative;
          border: 2px solid #eee;
      }
      #upbut{
          width: 40px;
          margin: 20px auto;
      }
      #donebutcnt{
          display: none;
      }
      #cropavat{
          display: none;
      }
      .fileUpload {
          position: relative;
          overflow: hidden;
      }
      .fileUpload input.upload {
          position: absolute;
          top: 0;
          right: 0;
          margin: 0;
          padding: 0;
          font-size: 20px;
          cursor: pointer;
          opacity: 0;
          filter: alpha(opacity=0);
      }
    </style>
  </head>

  <body>
    <?php echo $msg;?>
    <!-- ########## START: LEFT PANEL ########## -->
    <div class="br-logo"><a href="dashboard" class="inner-link"><img alt="" src="assets/images/logo.png" width="150"></a></div>
    <div class="br-sideleft overflow-y-auto">
      <label class="sidebar-label pd-x-10 mg-t-20 op-3">Navigation</label>
      <?php echo $menu; ?>
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
              <span class="logged-name hidden-md-down"><?php echo $userx['fname']?></span>
              <img src="img/avatar/<?php echo $avatar;?>" class="wd-32 rounded-circle" alt="">
              <span class="square-10 bg-success"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-header wd-250">
              <div class="tx-center">
                <a href="profile"><img src="img/avatar/<?php echo $avatar;?>" class="wd-80 rounded-circle" alt=""></a>
                <a href="profile"><h6 class="logged-fullname"><?php echo $fullname;?></h6></a>
                <p><?php echo $email;?></p>
              </div>
              <hr>
              <?php echo $studentpts;?>
              <ul class="list-unstyled user-profile-nav">
                <li><a href="settings"><i class="icon ion-ios-gear"></i>Account Settings</a></li>
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
        <i class="icon ion-ios-gear"></i>
        <div>
          <h4>Account Settings</h4>
          <p class="mg-b-0">Edit account information</p>
        </div>
      </div>

      <div class="br-pagebody">

        <div class="row row-sm mg-t-20">
          <div class="col-lg-6 mg-t-20">
            <div class="card bd-0 shadow-base">
              <div class="pd-x-25 pd-t-25">
                 <h6 class="tx-13 tx-uppercase tx-inverse tx-semibold tx-spacing-1 mg-b-20">Personal Information</h6>
                <hr>
                <?php echo $pinfo;?>

              </div>
            </div>


          </div>
          <div class="col-lg-6 mg-t-20">

            <div class="card bd-0 shadow-base">
              <div class="pd-x-25 pd-t-25">
                 <h6 class="tx-13 tx-uppercase tx-inverse tx-semibold tx-spacing-1 mg-b-20">Change Password</h6>
                <hr>
                <form method="POST" data-parsley-validate>
                  <div class="form-group">
                    <input type="password" class="form-control" name="oldpassword" placeholder="Enter your old password" data-parsley-minlength="6" required>
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control" name="newpassword" placeholder="Enter your new password" id="password" data-parsley-minlength="6" required>
                  </div>
                  <div class="form-group">
                    <input type="password" class="form-control" placeholder="Re-enter your new password" data-parsley-minlength="6" data-parsley-equalto="#password" required>
                  </div>
                  <div class="form-group text-center">
                    <button type="submit" name="changepassword" class="btn btn-success mg-b-10" style="width: 40%;">Submit</button>
                  </div>
                </form>

              </div>
            </div>           
          </div>
          <div class="col-lg-6 mg-t-20">

            <div class="card bd-0 shadow-base">
              <div class="pd-x-25 pd-t-25">
                 <h6 class="tx-13 tx-uppercase tx-inverse tx-semibold tx-spacing-1 mg-b-20">Change Avatar</h6>
                <hr>
                <div class="mindsetx" style="min-height:20px;">
                    <div class="row" style="padding:20px 0;">
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="displayavat">
                            <div id="avatarbxz">
                                <img src="img/avatar/<?php echo $avatar;?>" style="width:100%;border-radius: 150px;">
                            </div>
                            <div id="upbut" class="fileUpload">
                                <button name="updateacc" class="btn btn-success tx-20" style="border-radius: 46px;width: 40px;padding: 0;height: 40px;"><i class="icon ion-android-camera"></i></button>
                                <input type="file" id="upload" class="upload"/>
                            </div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="cropavat">
                            <div id="uploadview"></div>
                        </div>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="donebutcnt">
                            <p class="tx-center">
                                <button class="btn btn-success" id="donebut">Done <i class="icons ion-checkmark"></i></button>
                                <button class="btn btn-danger" onclick="endavatarup()">Cancel <i class="icons ion-close"></i></button>
                            </p>
                        </div>
                    </div>
                </div>

              </div>
            </div>           
          </div>
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

    <script src="js/popper.js"></script>
    <script src="js/parsley.js"></script>
    <script src="js/bootstrap.js"></script>
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
