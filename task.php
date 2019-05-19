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


$userx = $ux->user_data($apid, "fname,lname,username,avatar,active");
$userz = $ux->user_email($apid);

$uc = $ux->get_user_type($apid);
$usertype = $uc['user_type'];
if($usertype == 's'){
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

$msg='';
$menu = $ux->menu_switch('s',2);


$fullname = $userx['fname'].' '.$userx['lname'];
$email = $userz['email'];

if(isset($_POST['submit'])){
  $error=0;
  $msgerror='';

  $summary = $_POST['summary'];
  $task = $_POST['task'];
  $solution = $_FILES['solution']['name'];
  $solution_size = $_FILES['solution']['size'];
  $solution_temp = $_FILES['solution']['tmp_name'];

  if(empty($task) == true){
    $msgerror .= '<br>Invalid task information';
    $error++;
  }

  if(empty($summary) == true){
    $msgerror .= '<br>Solution summary can not be empty';
    $error++;
  }
  else if(strlen($summary) > 160){
    $msgerror .= '<br>Solution summary can not be more than 160 characters';
    $error++;
  }

  if(empty($solution) == false){
    $fileupdt = $ux->checkfile($solution,$solution_size);
    if($fileupdt == 0){
        $msgerror .= "<br>Invalid file format (Allowed pdf,doc,docx)";
        $error++;
    }
    else if($fileupdt == 2){
        $msgerror .= "<br>Solution file size too big (Max file size 2MB)";
        $error++;
    }
  }
  else{
    $msgerror .= '<br>Solution document can not be empty';
    $error++;
  }

  if($error == 0){
    $check = $ux->task_check($apid, $task);
    if($check == 1){
      $inad = $ux->update_solution($apid, $task, $summary, $solution, $solution_temp);
      if($inad == 1){
        $msg = '<script type="text/javascript">
                swal("Solution Submitted!", "Your solution has been submit successfully.", "success");
              </script>';
      }
      else{
        $msg = '<script type="text/javascript">
                swal("Error!", "Solution could not be submit...try again.", "error")
              </script>';
      }
    }
    else{
      $msg = '<script type="text/javascript">
                swal("Error!", "'.$check.'", "error")
              </script>';
    }
  }
  else{
    $msg = '<script type="text/javascript">
              swal("Error!", "'.$msgerror.'", "error")
            </script>';
  }
}

$task_detail=$tasks['tasks']=$tasks['range']=$tasks['page']='';

if(isset($_GET['t']) && $_GET['t']){
  $task = $_GET['t'];
  $task_detail = $ux->task_detail($apid, $task);
  $heading = 'Task Details';
}
else{
  if(isset($_GET['page']) && empty($_GET['page']) == false){
    $pagex = $_GET['page'];
  }
  else{
    $pagex = 0;
  }
  $tasks = $ux->new_tasks($apid, $pagex);
  $heading = 'New Tasks';
}

$ctasks = $ux->current_tasks($apid);
$points = $ux->get_points($apid);
$attempts = $ux->get_attempts($apid);
$solutions = $ux->get_solutions($apid);

if ($attempts != 0) {
  $comp = number_format(($solutions / $attempts) * 100);
  if($solutions == 0){
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

if(empty($userx['avatar'])){
  $avatar = 'p.png';
}
else{
  $avatar = $userx['avatar'];
}

$notes = $ux->get_notifications($apid);

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

    <title>Rook+ | Task</title>

    <!-- vendor css -->
    <link href="css/font-awesome.css" rel="stylesheet">
    <link href="css/ionicons.css" rel="stylesheet">
    <link href="lib/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <link href="lib/jquery-switchbutton/jquery.switchButton.css" rel="stylesheet">
    <link href="lib/rickshaw/rickshaw.min.css" rel="stylesheet">
    <link href="css/select2.min.css" rel="stylesheet">
    <link rel="shortcut icon" href="assets/images/icon/favicon.png">
    <link href="css/parsley.css" rel="stylesheet">
    <link href="css/sweetalert2.min.css" rel="stylesheet">
    <script src="js/sweetalert2.min.js"></script> 

    <link rel="stylesheet" href="css/rook.css">
  </head>

  <body>
    <?php echo $msg;?>
    <!-- ########## START: LEFT PANEL ########## -->
    <div class="br-logo"><a href="dashboard" class="inner-link"><img alt="" src="assets/images/logo.png" width="150"></a></div>
    <div class="br-sideleft overflow-y-auto">
      <label class="sidebar-label pd-x-10 mg-t-20 op-3">Navigation</label>
      <?php echo $menu;?>
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
              <!-- start: if statement -->
              <?php echo $notes['show']?>
              <!-- end: if statement -->
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
              <div class="tx-center">
                <span class="profile-earning-label">Points</span>
                <h3 class="profile-earning-amount"><?php echo $points;?> <i class="icon ion-ios-arrow-thin-up tx-success"></i></h3>
                <span class="profile-earning-text">Based on task solutions.</span>
              </div>
              <hr>
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
        <i class="icon ion-ios-list-outline"></i>
        <div>
          <h4>Tasks</h4>
          <p class="mg-b-0">Tasks from Companies you have subscribed</p>
        </div>
      </div>

      <div class="br-pagebody">

        <div class="row row-sm mg-t-20">
          <div class="col-lg-8">
            <div class="card bd-0 shadow-base">
              <div class="pd-x-25 pd-t-25">
                 <h6 class="tx-13 tx-uppercase tx-inverse tx-semibold tx-spacing-1 mg-b-20"><?php echo $heading; ?></h6>
                <hr>
                <?php echo $task_detail;?>
                <?php echo $tasks['tasks'].$tasks['range'].$tasks['page'];?>

              </div><!-- pd-x-25 -->
            </div><!-- card -->


          </div><!-- col-8 -->
          <div class="col-lg-4 mg-t-20 mg-lg-t-0">

            <div class="card shadow-base bd-0 overflow-hidden">
              <div class="pd-x-25 pd-t-25">
                <h6 class="tx-13 tx-uppercase tx-inverse tx-semibold tx-spacing-1 mg-b-20">Current task to complete</h6>
                <?php echo $ctasks;?>
              </div><!-- pd-x-25 -->
            </div><!-- card -->

            <div class="card card-body bd-0 pd-25 bg-primary mg-t-20">
              <div class="d-xs-flex justify-content-between align-items-center tx-white mg-b-20">
                <h6 class="tx-13 tx-uppercase tx-semibold tx-spacing-1 mg-b-0">Completed Tasks</h6>
              </div>
              <p class="tx-12 tx-white-7">Percentage of tasks completed</p>
              <!-- <div class="progress bg-white-3 mg-b-0">
                <div class="progress-bar bg-success wd-8p" role="progressbar" aria-valuenow="78" aria-valuemin="0" aria-valuemax="100">78%</div>
              </div> --><!-- progress -->
              <div class="progress bg-white-3 mg-b-0">
                <div class="progress-bar bg-success wd-<?php echo $comp;?>p"
                role="progressbar" aria-valuenow="<?php echo $comp;?>" aria-valuemin="0" aria-valuemax="100"><?php echo $ptext;?></div>
              </div>
              <p class="tx-11 mg-b-0 mg-t-15 tx-white-7"><?php echo $solutions;?>/<?php echo $attempts;?> tasks</p>
            </div><!-- card -->

          </div><!-- col-4 -->
        </div><!-- row -->

      </div><!-- br-pagebody -->
      <footer class="br-footer">
        <div class="footer-left">
          <div class="mg-b-2"><?php echo $footer;?></div>
        </div>
      </footer>
    </div><!-- br-mainpanel -->
    <!-- ########## END: MAIN PANEL ########## -->
    <div id="overlaytask">
      <form method="POST" action="" data-parsley-validate enctype="multipart/form-data">
        <div class="row" style="margin-top:50px;">
          <div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-10 col-sm-offset-1">
            <div id="closebut" onclick="closetask()"><span class="icon ion-android-close"></span></div>
            <div class="card bd-0 shadow-base">
              <div class="pd-x-25 pd-t-25">
                <h5 class="text-center">Upload your Solution</h5>
                <div class="form-group">
                  <label class="d-block tx-11 tx-medium tx-spacing-1 text-left">Enter the summary for your solution here</label>
                  <textarea id="textarea" class="form-control" name="summary" maxlength="160" rows="4" placeholder="your solution summary goes here..." style="margin-top: 0px; margin-bottom: 0px; height: 123px;" required></textarea>
                </div>
                <div class="form-group text-center">
                  <label class="d-block tx-11 tx-medium tx-spacing-1 text-left">Upload your detail solution file <i style="color: #F49917;">(allowed files: <b>pdf, doc and docx</b>)</i></label>
                  <input type="file" class="form-control" name="solution" required>
                </div>
                <hr>
                <div id="taskx"></div>
                <div class="form-group text-center">
                  <button type="submit" name="submit" class="btn btn-success mg-b-10" style="width: 40%;">Submit</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
    <div id="overlayload">
    </div>
    <script src="js/jquery.js"></script>
    <script src="js/actions.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/parsley.js"></script>
    <script src="js/select2.min.js"></script>
    <script src="lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js"></script>
    <script src="lib/moment/moment.js"></script>
    <script src="lib/jquery-ui/jquery-ui.js"></script>
    <script src="lib/jquery-switchbutton/jquery.switchButton.js"></script>
    <script src="lib/peity/jquery.peity.js"></script>
    <script src="lib/d3/d3.js"></script>
    <script src="lib/Flot/jquery.flot.js"></script>
    <script src="lib/Flot/jquery.flot.resize.js"></script>
    <script src="lib/flot-spline/jquery.flot.spline.js"></script>
    <script src="lib/jquery.sparkline.bower/jquery.sparkline.min.js"></script>
    <script src="js/bootstrap-maxlength.min.js"></script>
    <script src="js/rook.js"></script>
    <script src="js/ResizeSensor.js"></script>
    <script>
      $('textarea#textarea').maxlength({
            alwaysShow: true,
            warningClass: "badge badge-info",
            limitReachedClass: "badge badge-warning"
        });
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
