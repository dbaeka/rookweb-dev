<?php
session_start();
require 'app/validate.php';

if(isset($_SESSION['apid']) == true){
  header("Location: dashboard");
  exit();
}
else{
  $val = new Validate();
}

$msg=$cname='';

if(isset($_GET['t']) && $_GET['t']){
  $token = $_GET['t'];
  $cname = $val->get_company_info($token);
  if($cname == '0'){
    $msg = '<script type="text/javascript">
              swal("Error", "Invalid activation link", "error");
            </script>';
    $cname = '';
  }
  else if($cname == '2'){
    $msg = '<script type="text/javascript">
                  swal({
                    title: "Account Activated!",
                    text: "Your have been activated already",
                    type: "success",
                    showCancelButton: false,
                    confirmButtonText: "Okay"
                  }).then(function () {
                    window.location.href = "login";
                  });
                </script>';
    $cname = '';
  }
}
else{
  $msg='';
}

if(isset($_POST['activate'])){
  $error = 0;
  $password = $_POST['password'];
  $token = $_GET['t'];

  if(empty($token) == true){
    $error++;
  }
  
  if(empty($password) == true){
    $error++;
  }

  if($error == 0){
    $udata = $val->compact($token, $password);
    if($udata == 1){
      $msg = '<script type="text/javascript">
                  swal({
                    title: "Account Activated!",
                    text: "You have activated your account successfully",
                    type: "success",
                    showCancelButton: false,
                    confirmButtonText: "Okay"
                  }).then(function () {
                    window.location.href = "login";
                  });
                </script>';
    }
    else{
      $msg = '<div class="alert alert-danger" role="alert" style="text-align:center;"> <strong>Oh snap!</strong> '.$udata.'</div>';
    }
  }
  else{
    $msg = '<div class="alert alert-danger" role="alert" style="text-align:center;"> <strong>Oh snap!</strong> Some of the fields were empty or invalid</div>';
  }
}




?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Meta -->
    <meta name="description" content="Rook+" />
    <meta name="keywords" content="Rook+" />
    <meta name="author" content="ONE957">

    <title>Rook+ | Activate Account</title>

    <!-- vendor css -->
    <link href="css/font-awesome.css" rel="stylesheet">
    <link href="css/ionicons.css" rel="stylesheet">
    <link href="css/parsley.css" rel="stylesheet">
    <link rel="shortcut icon" href="assets/images/icon/favicon.png">
    <link href="css/sweetalert2.min.css" rel="stylesheet">
    <script src="js/sweetalert2.min.js"></script> 

    <!-- Bracket CSS -->
    <link rel="stylesheet" href="css/rook.css">
  </head>

  <body>

    <div class="row no-gutters flex-row-reverse ht-100v">
      <div class="col-md-6 bg-gray-200 d-flex align-items-center justify-content-center">
        <div class="login-wrapper wd-250 wd-xl-350 mg-y-30">
          <h4 class="tx-inverse tx-center">Set Password</h4>
          <p class="tx-center mg-b-60">Hi <b><?php echo $cname;?></b>, Set a password for your account here.</p>
          <?php echo $msg;?>
          <form method="POST" action="" data-parsley-validate>
            <div class="form-group">
              <input type="password" class="form-control" name="password" placeholder="Enter your password" id="password" data-parsley-minlength="6" required>
            </div><!-- form-group -->
            <div class="form-group">
              <input type="password" class="form-control" placeholder="Re-enter your password" data-parsley-minlength="6" data-parsley-equalto="#password" required>
            </div>
            <button type="submit" name="activate" class="btn btn-primary btn-block">Submit</button>
          </form>
        </div><!-- login-wrapper -->
      </div><!-- col -->
      <div class="col-md-6 bg-rook d-flex align-items-center justify-content-center">
        <div class="wd-250 wd-xl-450 mg-y-30">
          <div class="signin-logo tx-28 tx-bold tx-white"><a href="home" class="inner-link"><img alt="" src="img/wlogo.png" data-img-size="(W)163px X (H)39px"></a><!-- <span class="tx-normal">[</span> bracket <span class="tx-info">plus</span> <span class="tx-normal">]</span> --></div>
          <div class="tx-white mg-b-60">Feel Bigger!</div>

          <h5 class="tx-white">Why Rook+ ?</h5>
          <p class="tx-white-6">Rook+  is an application service that seeks to link every human resource officer and office to every major tertiary institution on the platform and thus make it easier for these offices to pursue their human resource agendas.</p>
          <p class="tx-white-6 mg-b-60">Rook+ provides a relevant platform of communication between undergraduates and companies to communicate services and new corporate strategies and discoveries that may be relevant to the pursuit of a career in the field of study of undergraduates</p>
          <a href="register" class="btn btn-outline-light bd bd-white bd-2 tx-white pd-x-25 tx-uppercase tx-12 tx-spacing-2 tx-medium">Join Now</a>
          <p class="tx-white-6 mg-t-10"><?php echo $footer;?></p>
        </div><!-- wd-500 -->
      </div>
    </div><!-- row -->

    <script src="js/jquery.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/parsley.js"></script>
    <script src="js/bootstrap.js"></script>

  </body>
</html>
