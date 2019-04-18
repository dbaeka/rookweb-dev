<?php
session_start();

if(!isset($_SESSION['apid']) == true || empty($_SESSION['apid']) == true){
  header("Location: home");
  exit();
}

require 'app/user.php';
require 'app/company.php';
$ux = new User();
$cx = new Company();

$apid = $_SESSION['apid'];
$note = $ux->subscription($apid);
if($note == '0'){
  header("Location: subscription");
  exit();
}


$uc = $ux->get_user_type($apid);
$usertype = $uc['user_type'];
if($usertype == 's'){
  header("Location: dashboard");
  exit();
}
else if($usertype == 'c'){
  $userx = $ux->user_data($apid, "cname,logo,active");
  $userz = $ux->user_email($apid);
  if ($userx['active'] == 2){
    header("Location: door");
    exit();
  }
  
}
else if($usertype == 'a'){
  header("Location: admin");
  exit();
}
else{
  header("Location: home");
  exit();
}

$menu = $ux->menu_switch('c',2);
$pay=$msg= '';
$cn = explode(" ", $userx['cname']);
$cnamesht = $cn[0];
$fullname = $userx['cname'];
$email = $userz['email'];

if(empty($userx['logo'])){
  $logo = 'p.png';
}
else{
  $logo = $userx['logo'];
}

if(isset($_POST['submit'])){
  $error=0;
  $msgerror='';

  $summary = $_POST['summary'];
  $title = $_POST['title'];
  $days = $_POST['days'];
  $file = $_FILES['file']['name'];
  $file_size = $_FILES['file']['size'];
  $file_temp = $_FILES['file']['tmp_name'];

  if(empty($title) == true){
    $msgerror .= '<br>Task title can not be empty';
    $error++;
  }

  if(empty($days) == true){
    $msgerror .= '<br>Days can not be empty';
    $error++;
  }
  else if(!preg_match('/^[0-9]+$/', $days)){
    $msgerror .= '<br>Invalid Days entered';
    $error++;
  }
  else if($days == 0){
    $msgerror .= '<br>Invalid Days entered';
    $error++;
  }

  if(empty($summary) == true){
    $msgerror .= '<br>Task summary can not be empty';
    $error++;
  }
  else if(strlen($summary) > 160){
    $msgerror .= '<br>Task summary can not be more than 160 characters';
    $error++;
  }

  if(empty($file) == false){
    $fileupdt = $cx->checkfile($file,$file_size);
    if($fileupdt == 0){
        $msgerror .= "<br>Invalid file format (Allowed txt,pdf,doc,docx)";
        $error++;
    }
    else if($fileupdt == 2){
        $msgerror .= "<br>Task file size too big (Max file size 2MB)";
        $error++;
    }
  }
  else{
    $msgerror .= '<br>Task Document can not be empty';
    $error++;
  }

  if($error == 0){
    $inad = $cx->create_task($apid, $title, $summary, $days, $file, $file_temp);
    if($inad == 1){
      $msg = '<script type="text/javascript">
              swal("Task Created!", "Task has been created successfully.", "success");
            </script>';
    }
    else{
      $msg = '<script type="text/javascript">
              swal("Error!", "'.$inad.'", "error")
            </script>';
    }
    
  }
  else{
    $msg = '<script type="text/javascript">
              swal("Error!", "'.$msgerror.'", "error")
            </script>';
  }
}

$search = '';

if(isset($_GET['page']) && empty($_GET['page']) == false){
  $pagex = $_GET['page'];
}
else{
  $pagex = 0;
}


if(isset($_GET['t']) && $_GET['t']){
  $tid = $_GET['t'];

  if(isset($_GET['st']) && empty($_GET['st']) == false){
    $search = $_GET['st'];
  }

  $tasks = $cx->get_task_solutions($apid, $tid, $search, $pagex);
  $head = $cx->get_task_info($apid, $tid);
  $head .= '<form method="GET" action="">
              <div class="input-group">
                <input type="text" class="form-control" name="st" value="'.$search.'" placeholder="Search for students by username">
                <input type="hidden" name="t" value="'.$tid.'">
                <span class="input-group-btn">
                  <button class="btn bd bg-primary" type="submit" style="color: #fff;"><i class="icon ion-android-search"></i></button>
                </span>
              </div>
            </form>';
}
else{
  if(isset($_GET['q']) && empty($_GET['q']) == false){
    $search = $_GET['q'];
  }
  $tasks = $cx->get_tasks($apid, $search, $pagex);
  $head = '<h6 class="tx-13 tx-uppercase tx-inverse tx-semibold tx-spacing-1 mg-b-20">My Task</h6>
          <form method="GET" action="">
            <div class="input-group">
              <input type="text" class="form-control" name="q" value="'.$search.'" placeholder="Search for task by title">
              <span class="input-group-btn">
                <button class="btn bd bg-primary" type="submit" style="color: #fff;"><i class="icon ion-android-search"></i></button>
              </span>
            </div>
          </form>';
}


$watch = $cx->get_watching_list($apid);
$notes = $cx->get_notifications($apid);
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
                <?php echo $notes['notes']?>
              </div><!-- media-list -->
            </div><!-- dropdown-menu -->
          </div><!-- dropdown -->
          <div class="dropdown">
            <a href="#" class="nav-link nav-link-profile" data-toggle="dropdown">
              <span class="logged-name hidden-md-down"><?php echo $cnamesht?></span>
              <img src="img/avatar/<?php echo $logo;?>" class="wd-32 rounded-circle" alt="">
              <span class="square-10 bg-success"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-header wd-250">
              <div class="tx-center">
                <a href="profile"><img src="img/avatar/<?php echo $logo;?>" class="wd-80 rounded-circle" alt=""></a>
                <a href="profile"><h6 class="logged-fullname"><?php echo $fullname;?></h6></a>
                <p style="margin:0;"><?php echo $email;?></p>
              </div>
              <hr>
              <ul class="list-unstyled user-profile-nav">
                <li><a href="csettings"><i class="icon ion-ios-gear"></i>Account Settings</a></li>
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
          <p class="mg-b-0">Tasks and their Solutions</p>
          <button onclick="add()" class="btn btn-primary btn-with-icon mg-t-10">
            <div class="ht-40">
              <span class="icon wd-40"><i class="ion-android-add" style="font-size: 25px;color: #fff;"></i></span>
              <span class="pd-x-15">Create a Task</span>
            </div>
          </button>
        </div>
      </div>

      <div class="br-pagebody">

        <div class="row row-sm mg-t-20">
          <div class="col-lg-8">
            <div class="card bd-0 shadow-base">
              <div class="pd-x-25 pd-t-25">
                 <?php echo $head;?>
                <hr>
                <?php echo $tasks['info'].$tasks['range'].$tasks['page'];?>

              </div><!-- pd-x-25 -->
            </div><!-- card -->


          </div><!-- col-8 -->
          <div class="col-lg-4 mg-t-20 mg-lg-t-0">

            <div class="card shadow-base bd-0">
              <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                <h6 class="card-title tx-uppercase tx-12 mg-b-0">Watch List</h6>
                <span class="tx-12 tx-uppercase"><a href="watchlist">VIEW ALL</a></span>
              </div><!-- card-header -->
              <div class="card-body">
                <?php echo $watch;?>
              </div><!-- card-body -->
            </div>

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

    <div id="overlayrate"></div>
    <div id="overlayload"></div>
    <div id="overlaytask">
      <form method="POST" action="" data-parsley-validate enctype="multipart/form-data">
        <div class="row" style="margin-top:50px;">
          <div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-10 col-sm-offset-1">
            <div id="closebut" onclick="closetask()"><span class="icon ion-android-close"></span></div>
            <div class="card bd-0 shadow-base">
              <div class="pd-x-25 pd-t-25">
                <h5 class="text-center">Create a New Task</h5>
                <div class="form-group">
                  <label class="d-block tx-11 tx-medium tx-spacing-1 text-left">Title</label>
                  <input type="text" class="form-control" name="title" style="margin-top: 0px; margin-bottom: 0px;" required>
                </div>
                <div class="form-group">
                  <label class="d-block tx-11 tx-medium tx-spacing-1 text-left">Duration in days</label>
                  <input type="number" class="form-control" data-parsley-min="1" step="1" name="days" style="margin-top: 0px; margin-bottom: 0px;" required>
                </div>
                <div class="form-group">
                  <label class="d-block tx-11 tx-medium tx-spacing-1 text-left">Task Summary</label>
                  <textarea id="textarea" class="form-control" name="summary" maxlength="160" rows="4" placeholder="Summary" style="margin-top: 0px; margin-bottom: 0px; height: 123px;" required></textarea>
                </div>
                <div class="form-group text-center">
                  <label class="d-block tx-11 tx-medium tx-spacing-1 text-left">Upload Task Document <i style="color: #F49917;">(allowed files: <b>.txt, .pdf, .doc and .docx</b>)</i></label>
                  <input type="file" class="form-control" name="file" required>
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

    <script src="js/jquery.js"></script>
    <script src="js/rater.js"></script> 
    <script src="js/actions.js"></script>
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
    <script src="js/bootstrap-maxlength.min.js"></script>
    <script src="js/rook.js"></script>
    <script src="js/map.shiftworker.js"></script>
    <script src="js/ResizeSensor.js"></script>
    <script src="js/dashboard.js"></script>
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
