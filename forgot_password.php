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

$msg='';

if(isset($_POST['send'])){
  $error = 0;

  $email = $_POST['email'];

  if(empty($email) == true){
    $error++;
  }

  if($error == 0){
    $udata = $val->forgot_password($email);
    if($udata == 1){
      $msg = '<script type="text/javascript">
                  swal({
                    title: "Request Sent",
                    text: "An email has been sent to: '.$email.'. (NB: Check spam/junk if not found in mail)",
                    type: "success",
                    showCancelButton: false,
                    confirmButtonText: "Okay"
                  }).then(function () {
                    window.location.href = "home";
                  });
                </script>';
    }else{
      $msg = '<div class="alert alert-danger" role="alert" style="text-align:center;"> '.$udata.'</div>';
    }
  }
  else{
    $msg = '<div class="alert alert-danger" role="alert" style="text-align:center;"> <strong>Oh snap!</strong> Email field is empty or invalid</div>';
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

    <title>Rook+ | Forgot Password</title>

    <!-- vendor css -->
    <link href="css/font-awesome.css" rel="stylesheet">
    <link href="css/ionicons.css" rel="stylesheet">
    <link rel="shortcut icon" href="assets/images/icon/favicon.png">
    <link href="css/parsley.css" rel="stylesheet">
    <link href="css/sweetalert2.min.css" rel="stylesheet">
    <script src="js/sweetalert2.min.js"></script> 
    <!-- Bracket CSS -->
    <link rel="stylesheet" href="css/rook.css">
  </head>

  <body>

    <div class="row no-gutters flex-row-reverse ht-100v">
      <div class="col-md-6 bg-gray-200 d-flex align-items-center justify-content-center">
        <div class="login-wrapper wd-250 wd-xl-350 mg-y-30">
          <h4 class="tx-inverse tx-center">Forgot Password</h4>
          <p class="tx-center mg-b-60">Can't remember your password? we got you.</p>
          <?php echo $msg;?>
          <form method="POST" action="">
            <div class="form-group">
              <input type="text" class="form-control" name="email" placeholder="Enter your email">
            </div><!-- form-group -->
            <button type="submit" name="send" class="btn btn-info btn-block">Submit</button>
          </form>
          <div class="mg-t-60 tx-center">Remember your password? <a href="login" class="tx-info">Login</a></div>
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
    <script src="js/parsley.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>

  </body>
</html>
