<?php
session_start();

if(!isset($_SESSION['apid']) == true || empty($_SESSION['apid']) == true){
  header("Location: home");
  exit();
}

require 'app/user.php';
require 'app/admin.php';
$ux = new User();
$ax = new Admin();

$apid = $_SESSION['apid'];
$userx = $ux->user_data($apid, "fname,lname,level,active");
$userz = $ux->user_email($apid);

$uc = $ux->get_user_type($apid);
$usertype = $uc['user_type'];
if($usertype == 's'){
  header("Location: dashboard");
  exit();
}
else if($usertype == 'a'){
  if ($userx['active'] == 2){
    header("Location: door");
    exit();
  }
  
}
else if($usertype == 'c'){
  header("Location: hub");
  exit();
}
else{
  header("Location: home");
  exit();
}

$msg=$menu= '';

$menu = $ux->menu_switch('a',6);

$fullname = $userx['fname'].' '.$userx['lname'];
$email = $userz['email'];


$tasks = $ax->get_total_tasks();
$search=$taskinfo=$tform= '';

if(isset($_GET['page']) && empty($_GET['page']) == false){
  $pagex = $_GET['page'];
}
else{
  $pagex = 0;
}

if(isset($_GET['q']) && empty($_GET['q']) == false){
  $search = $_GET['q'];
}

if(isset($_GET['task']) && empty($_GET['task']) == false){
  $task = $_GET['task'];
  $tform = '<input type="hidden" name="task" value="'.$task.'">';
  $list = $ax->get_tasks_submitters($task, $search, $pagex);
  $taskinfo = $ax->task_info($task);
}else{
  $list = $ax->get_tasks($search, $pagex);
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

    <title>Rook+ | Tasks</title>

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
              <!-- <span class="square-8 bg-danger pos-absolute t-15 r-5 rounded-circle"></span> -->
              <!-- end: if statement -->
            </a>
            <div class="dropdown-menu dropdown-menu-header">
              <div class="dropdown-menu-label">
                <label>Notifications</label>
                <!-- <a href="#">Mark All as Read</a> -->
              </div><!-- d-flex -->

              <div class="media-list">
                <!-- loop starts here -->
              
                <div class="dropdown-footer">
                  No Notifications
                </div>
              </div><!-- media-list -->
            </div><!-- dropdown-menu -->
          </div><!-- dropdown -->
          <div class="dropdown">
            <a href="#" class="nav-link nav-link-profile" data-toggle="dropdown">
              <span class="logged-name hidden-md-down"><?php echo $userx['fname']?></span>
              <img src="img/avatar/p.png" class="wd-32 rounded-circle" alt="">
              <span class="square-10 bg-success"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-header wd-250">
              <div class="tx-center">
                <a href="profile"><img src="img/avatar/p.png" class="wd-80 rounded-circle" alt=""></a>
                <a href="profile"><h6 class="logged-fullname"><?php echo $fullname;?></h6></a>
                <p style="margin:0;"><?php echo $email;?></p>
                <p style="font-size: 11px;">Level: <?php echo $userx['level'];?></p>
              </div>
              <hr>
              <ul class="list-unstyled user-profile-nav">
                <li><a href="asettings"><i class="icon ion-ios-gear"></i> Account Settings</a></li>
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
      <div class="br-pagetitle">
        <i class="icon ion-ios-people-outline"></i>
        <div>
          <h4>Tasks</h4>
          <p class="mg-b-0">List of all the tasks on Rook+</p>
        </div>
      </div>

      <div class="br-pagebody">

        <div class="row row-sm mg-t-20">
          <div class="col-lg-8">
            <div class="card bd-0 shadow-base">
              <div class="pd-x-25 pd-t-25">
                <h6 class="tx-13 tx-uppercase tx-inverse tx-semibold tx-spacing-1 mg-b-20">Tasks 
                  
                </h6>
                <?php echo $taskinfo; ?>
                <form method="GET" action="">
                  <div class="input-group">
                    <?php echo $tform;?>
                    <input type="text" class="form-control" name="q" value="<?php echo $search;?>" placeholder="Search for...">
                    <span class="input-group-btn">
                      <button class="btn bd bg-primary" type="submit" style="color: #fff;"><i class="icon ion-android-search"></i></button>
                    </span>
                  </div>
                </form>
                <hr>
                <?php echo $list['tasks'].$list['range'].$list['page'];?>

              </div><!-- pd-x-25 -->
            </div><!-- card -->


          </div><!-- col-8 -->
          <div class="col-lg-4 mg-t-20 mg-lg-t-0">

            <div class="card shadow-base card-body pd-25 bd-0">
              <div class="row">
                <div class="col-sm-12">
                  <h6 class="card-title tx-uppercase tx-12">Total Tasks</h6>
                  <p class="display-4 tx-medium tx-inverse mg-b-5 tx-lato"><?php echo $tasks;?></p>
                  <p class="tx-12">This shows tasks on Rook+</p>
                </div><!-- col-6 -->
              </div><!-- row -->
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
    <div id="overlaytask">
      <form method="POST" action="" data-parsley-validate enctype="multipart/form-data">
        <div class="row" style="margin-top:50px;">
          <div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-10 col-sm-offset-1">
            <div id="closebut" onclick="closetask()"><span class="icon ion-android-close"></span></div>
            <div class="card bd-0 shadow-base">
              <div class="pd-x-25 pd-t-25">
                <h5 class="text-center">Add a New Company</h5>
                <div class="form-group">
                  <label class="d-block tx-11 tx-medium tx-spacing-1 text-left">Company Name</label>
                  <input type="text" class="form-control" name="cname" style="margin-top: 0px; margin-bottom: 0px;" required>
                </div>
                <div class="form-group">
                  <label class="d-block tx-11 tx-medium tx-spacing-1 text-left">Location</label>
                  <input type="text" class="form-control" name="locat" style="margin-top: 0px; margin-bottom: 0px;" required>
                </div>
                <div class="form-group">
                  <label class="d-block tx-11 tx-medium tx-spacing-1 text-left">Address</label>
                  <input type="text" class="form-control" name="address" style="margin-top: 0px; margin-bottom: 0px;" required>
                </div>
                <div class="form-group">
                  <label class="d-block tx-11 tx-medium tx-spacing-1 text-left">Email</label>
                  <input type="text" class="form-control" name="email" style="margin-top: 0px; margin-bottom: 0px;" required>
                </div>
                <div class="form-group">
                  <label class="d-block tx-11 tx-medium tx-spacing-1 text-left">Enter a Bio about the Company</label>
                  <textarea id="textarea" class="form-control" name="bio" maxlength="160" rows="4" placeholder="Company Bio" style="margin-top: 0px; margin-bottom: 0px; height: 123px;" required></textarea>
                </div>
                <div class="form-group text-center">
                  <label class="d-block tx-11 tx-medium tx-spacing-1 text-left">Upload Company logo <i style="color: #F49917;">(allowed files: <b>png, jpg and jpeg</b>)</i></label>
                  <input type="file" class="form-control" name="logo">
                </div>
                <hr>
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
