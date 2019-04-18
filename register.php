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

$nowx = date("Y", time()) - 45;
$dyear='';

for ($i=$nowx; $i <= $nowx+45; $i++) { 
  $dyear .= '<option value="'.$i.'">'.$i.'</option>';
}

$get_code = $val->get_country_code();
$countries = $val->get_countries();

$msg='';

if(isset($_POST['signup'])){
  $error = 0;

  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $phone = $_POST['phone'];
  $code = $_POST['code'];
  $gender = $_POST['gender'];
  $country = $_POST['country'];

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

  if(empty($password) == true){
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
    $cc = $val->check_country($country);
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
    $udata = $val->signup($fname, $lname, $gender, $email, $password, $dob, $country, $phonenum);
    $udatax = explode("|", $udata);
    if($udatax[0] == true){
      $_SESSION['apid'] = $udatax[1];
      $msg = '<script type="text/javascript">
                  swal({
                    title: "Registration Successful!",
                    text: "You have signed up successfully",
                    type: "success",
                    showCancelButton: false,
                    confirmButtonText: "Okay"
                  }).then(function () {
                    window.location.href = "dashboard";
                  });
                </script>';
    }
    else{
      $msg = '<div class="alert alert-danger" role="alert" style="text-align:center;"> <strong>Oh snap!</strong> '.$udatax[1].'</div>';
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

    <meta name="description" content="Rook+" />
    <meta name="keywords" content="Rook+" />
    <meta name="author" content="ONE957">

    <title>Rook+ | Register</title>

    <link href="css/font-awesome.css" rel="stylesheet">
    <link href="css/ionicons.css" rel="stylesheet">
    <link href="css/select2.min.css" rel="stylesheet">
    <link href="css/parsley.css" rel="stylesheet">
    <link rel="shortcut icon" href="assets/images/icon/favicon.png">
    <link href="css/sweetalert2.min.css" rel="stylesheet">
    <script src="js/sweetalert2.min.js"></script> 

    <link rel="stylesheet" href="css/rook.css">
  </head>

  <body>

    <div class="row no-gutters flex-row-reverse">
      <div class="col-md-6 bg-gray-200 d-flex align-items-center justify-content-center">
        <div class="login-wrapper wd-250 wd-xl-350 mg-y-30">
          <h4 class="tx-inverse tx-center">Register</h4>
          <p class="tx-center mg-b-60">Create your own account.</p>
          <?php echo $msg;?>
          <form method="POST" action="" data-parsley-validate>
            <div class="form-group">
              <div class="row row-xs">
                <div class="col-sm-6">
                  <input type="text" class="form-control" name="lname" placeholder="Last Name" required>
                </div><!-- col-4 -->
                <div class="col-sm-6 mg-t-20 mg-sm-t-0">
                  <input type="text" class="form-control" name="fname" placeholder="First Name" required>
                </div>
              </div><!-- row -->
            </div>
            <div class="form-group">
              <select class="form-control select2" name="gender" data-placeholder="Gender" required>
                <option label="Gender"></option>
                <option value="f">Female</option>
                <option value="m">Male</option>
              </select>
            </div>
            <div class="form-group">
              <input type="email" class="form-control" name="email" placeholder="Enter your email" required>
            </div><!-- form-group -->
            <div class="form-group">
              <input type="password" class="form-control" name="password" placeholder="Enter your password" id="password" data-parsley-minlength="6" required>
            </div><!-- form-group -->
            <div class="form-group">
              <input type="password" class="form-control" placeholder="Re-enter your password" data-parsley-minlength="6" data-parsley-equalto="#password" required>
            </div><!-- form-group -->
            <div class="form-group">
              <label class="d-block tx-11 tx-uppercase tx-medium tx-spacing-1">Birthday</label>
              <div class="row row-xs">
                <div class="col-sm-4">
                  <select class="form-control select2" name="month" data-placeholder="Month" required>
                    <option label="Month"></option>
                    <option value="1">January</option>
                    <option value="2">February</option>
                    <option value="3">March</option>
                    <option value="4">April</option>
                    <option value="5">May</option>
                    <option value="6">June</option>
                    <option value="7">July</option>
                    <option value="8">August</option>
                    <option value="9">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                  </select>
                </div><!-- col-4 -->
                <div class="col-sm-4 mg-t-20 mg-sm-t-0">
                  <select class="form-control select2" name="day" data-placeholder="Day" required>
                    <option label="Day"></option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                    <option value="14">14</option>
                    <option value="15">15</option>
                    <option value="16">16</option>
                    <option value="17">17</option>
                    <option value="18">18</option>
                    <option value="19">19</option>
                    <option value="20">20</option>
                    <option value="21">21</option>
                    <option value="22">22</option>
                    <option value="23">23</option>
                    <option value="24">24</option>
                    <option value="25">25</option>
                    <option value="26">26</option>
                    <option value="27">27</option>
                    <option value="28">28</option>
                    <option value="29">29</option>
                    <option value="30">30</option>
                    <option value="31">31</option>
                  </select>
                </div><!-- col-4 -->
                <div class="col-sm-4 mg-t-20 mg-sm-t-0">
                  <select class="form-control select2" name="year" data-placeholder="Year" required>
                    <option label="Year"></option>
                    <?php echo $dyear;?>
                  </select>
                </div><!-- col-4 -->
              </div><!-- row -->
            </div><!-- form-group -->
            <div class="form-group">
              <select class="form-control select2" name="country" data-placeholder="Country" required>
                <option label="Country"></option>
                <?php echo $countries;?>
              </select>
            </div>
            <div class="form-group">
              <label class="d-block tx-11 tx-uppercase tx-medium tx-spacing-1">Phone Number</label>
              <div class="row row-xs">
                <div class="col-sm-4">
                  <select class="form-control select2" name="code" data-placeholder="Code" required>
                    <option label="Code"></option>
                    <?php echo $get_code;?>
                  </select>
                </div><!-- col-4 -->
                <div class="col-sm-8 mg-t-20 mg-sm-t-0">
                  <input type="text" class="form-control" data-parsley-length="[9, 15]" data-parsley-type="digits" name="phone" placeholder="Phone Number" required>
                </div><!-- col-4 -->
              </div><!-- row -->
            </div><!-- form-group -->
            <div class="form-group tx-12">By clicking the Sign Up button below you agreed to our privacy policy and terms of use of our website.</div>
            <button type="submit" name="signup" class="btn btn-info btn-block">Sign Up</button>
          </form>

          <div class="mg-t-60 tx-center">Already a member? <a href="login" class="tx-info">Login</a></div>
        </div><!-- login-wrapper -->
      </div><!-- col -->
      <div class="col-md-6 bg-rook d-flex align-items-center justify-content-center">
        <div class="wd-250 wd-xl-450 mg-y-30">
          <div class="signin-logo tx-28 tx-bold tx-white"><a href="home" class="inner-link"><img alt="" src="img/wlogo.png" data-img-size="(W)163px X (H)39px"></a><!-- <span class="tx-normal">[</span> bracket <span class="tx-info">plus</span> <span class="tx-normal">]</span> --></div>
          <div class="tx-white mg-b-60">Feel Bigger!</div>

          <h5 class="tx-white">Why Rook+ ?</h5>
          <p class="tx-white-6">Rook+ is an application service that seeks to link every human resource officer and office to every major tertiary institution on the platform and thus make it easier for these offices to pursue their human resource agendas.</p>
          <p class="tx-white-6 mg-b-60">Rook+ provides a relevant platform of communication between undergraduates and companies to communicate services and new corporate strategies and discoveries that may be relevant to the pursuit of a career in the field of study of undergraduates</p>
          <a href="login" class="btn btn-outline-light bd bd-white bd-2 tx-white pd-x-25 tx-uppercase tx-12 tx-spacing-2 tx-medium">Login Here</a>
          <p class="tx-white-6 mg-t-10"><?php echo $footer;?></p>
        </div><!-- wd-500 -->
      </div>
    </div><!-- row -->

    <script src="js/jquery.js"></script>
    <script src="js/popper.js"></script>
    <script src="js/bootstrap.js"></script>
    <script src="js/parsley.js"></script>
    <script src="js/select2.min.js"></script>
    <script>
      $(function(){
        'use strict';

        $('.select2').select2({
          minimumResultsForSearch: Infinity
        });
      });
    </script>

  </body>
</html>
