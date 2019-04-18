<?php
session_start();
if(isset($_SESSION['apid']) == true){
  header("Location: dashboard");
  exit();
}

require('app/connect.php');
require('app/admin.php');
$ax = new Admin();

$studentx = $ax->get_total_students();
$students = $studentx['total'];

$companiesx = $ax->get_total_companies();
$companies = $companiesx['active'];

$tasks = $ax->get_total_tasks();
$solutionx = $ax->get_total_task_solutions();

?>

<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width,initial-scale=1.0,maximum-scale=1" />
        <!-- title -->
        <title>Rook+ | Home</title>
        <meta name="description" content="Rook+" />
        <meta name="keywords" content="Rook+" />
        <meta name="author" content="ONE957">
        <!-- favicon -->
        <link rel="shortcut icon" href="assets/images/icon/favicon.png">
        <!-- animation -->
        <link rel="stylesheet" href="assets/css/animate.css" />
        <!-- bootstrap -->
        <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
        <!-- font-awesome icon -->
        <link rel="stylesheet" href="assets/css/font-awesome.min.css" />
        <!-- themify-icons -->
        <link rel="stylesheet" href="assets/css/themify-icons.css" />
        <!-- owl carousel -->
        <link rel="stylesheet" href="assets/css/owl.transitions.css" />
        <link rel="stylesheet" href="assets/css/owl.carousel.css" /> 
        <!-- magnific popup -->
        <link rel="stylesheet" href="assets/css/magnific-popup.css" /> 
        <!-- base -->
        <link rel="stylesheet" href="assets/css/base.css" /> 
        <!-- elements -->
        <link rel="stylesheet" href="assets/css/elements.css" />
        <!-- responsive -->
        <link rel="stylesheet" href="assets/css/responsive.css" />
        <!--[if IE 9]>
        <link rel="stylesheet" type="text/css" href="css/ie.css" />
        <![endif]-->
        <!--[if IE]>
            <script src="js/html5shiv.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <header class="header-style1" id="header-section3">
            <!-- nav -->
            <nav class="navbar bg-white no-margin alt-font tz-header-bg shrink-header header-border-dark light-header">
                <div class="container navigation-menu">
                    <div class="row">
                        <!-- logo -->
                        <div class="col-md-3 col-sm-4 col-xs-9">
                            <a href="home" class="inner-link"><img alt="" src="assets/images/logo.png" data-img-size="(W)163px X (H)39px"></a>
                        </div>
                        <!-- end logo -->
                        <div class="col-md-9 col-sm-8 col-xs-3 position-inherit">
                            <button data-target="#bs-example-navbar-collapse-1" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
                                <span class="sr-only">Toggle navigation</span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                            <div id="bs-example-navbar-collapse-1" class="collapse navbar-collapse pull-right">
                                <ul class="nav navbar-nav font-weight-600">
                                    <li class="propClone"><a class="inner-link" href="#home">HOME</a></li>
                                    <li class="propClone"><a class="inner-link" href="#content-section22">ABOUT US</a></li>
                                    <li class="propClone"><a class="inner-link" href="#features">FEATURES</a></li>
                                    <li class="propClone sm-no-border"><a class="inner-link" href="#contact-section3">CONTACT</a></li>
                                    <li class="propClone"><a class="inner-link" href="blog">BLOG</a></li>
                                    <li class="nav-button propClone sm-no-margin-tb float-left btn-medium sm-no-margin-left"> <a href="login" class="inner-link btn btn-small propClone bg-rook text-white border-radius-0 font-weight-500 sm-padding-nav-btn sm-display-inline-block">LOGIN</a> </li>
                                    <li class="nav-button propClone sm-no-margin-tb float-left btn-medium sm-no-margin-left"> <a href="register" class="inner-link btn btn-small propClone bg-rook text-white border-radius-0 font-weight-500 sm-padding-nav-btn sm-display-inline-block">JOIN US</a> </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </nav> 
            <!-- end nav -->
        </header>
        <!-- slider text -->
				<section id="home" class="no-padding slider-style7 border-none">
					<div class="row item owl-bg-img tz-builder-bg-image cover-background bg-img-one" style="background: url(assets/images/bg-image/wall2.jpg) no-repeat scroll center center;background-size: cover;height: 775px;"></div>
				</section>
       
        <!-- end slider text -->
        <section class="padding-80px-tb xs-padding-60px-tb bg-white builder-bg" id="content-section22">
            <div class="container">
                <div class="row equalize sm-equalize-auto">
                    <!-- section title -->
                    <div class="col-md-5 col-sm-12 col-xs-12 display-table xs-text-center sm-margin-twenty-bottom xs-margin-twenty-nine-bottom" style="">                            
                        <div class="display-table-cell-vertical-middle">
                            <!-- section title -->
                            <h2 class="alt-font title-large sm-title-large xs-title-large text-dark-gray margin-eight-bottom tz-text sm-margin-five-bottom">Welcome to Rook+</h2>
                            <!-- end section title -->
                            <div class="text-medium tz-text width-90 sm-width-100 margin-twelve-bottom sm-margin-five-bottom"><p>Welcome to the Rook+ web platform. Its our hope you use and fully benefit from this great innovation.</p></div>                            
                        </div>
                    </div>
                    <!-- end section title -->
                    <!-- feature box -->
                    <div class="col-md-7 col-sm-12 col-xs-12 display-table" style="">
                        <div class="display-table-cell-vertical-middle ">
					        <a href="register"><button class="btn btn-lg btn-success pull-right">Become a Rookie Now!</button></a>
                        </div>
                    </div>
                    <!-- end feature box -->
                </div>
            </div>
        </section>
        <section class="bg-rook builder-bg border-none" id="tab-section6">
            <div class="container-fluid">
                <div class="row equalize">
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 tz-builder-bg-image sm-height-600-px xs-height-400-px cover-background bg-img-four" data-img-size="(W)1000px X (H)800px" style="background: linear-gradient(rgba(0, 0, 0, 0.01), rgba(0, 0, 0, 0.01)) repeat scroll 0% 0%, transparent url('assets/images/bg-image/wall3.jpg') repeat scroll 0% 0%;"></div>
                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12 display-table" style="">
                        <div class="display-table-cell-vertical-middle padding-twenty-two md-padding-seven xs-padding-nineteen xs-no-padding-lr">
                            <h3 class="title-extra-large border-bottom-light font-weight-100 text-white xs-title-large padding-fifteen-bottom margin-fifteen-bottom tz-text sm-padding-ten-bottom sm-margin-ten-bottom"><span class="font-weight-600">Learn more about Rook+</span></h3>                                
                            <div class="tab-style6">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <!-- tab navigation -->
                                        <ul class="nav nav-tabs nav-tabs-light alt-font text-left margin-ten-bottom">
                                            <li class="active"><a href="#tab_sec1" data-toggle="tab"><span class="tz-text">WHY ROOK+?</span></a></li>
																						<li><a href="#tab_sec2" data-toggle="tab"><span class="tz-text">ABOUT US</span></a></li>
																						<li><a href="#tab_sec3" data-toggle="tab"><span class="tz-text">STUDENTS</span></a></li>
																						<li><a href="#tab_sec4" data-toggle="tab"><span class="tz-text">COMPANIES</span></a></li>
                                        </ul>
                                        <!-- tab end navigation -->
                                    </div>
                                </div>                                    
                                <div class="tab-content">
                                    <!-- tab content -->
                                    <div class="tab-pane med-text fade in active" id="tab_sec1">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="text-white tz-text"><p>Most companies desire graduates who don’t just KNOW the job, but can actually DO the job. Rook+ exploits that desire to provide students with corporate level experience needed for the competitive scene. Companies get the quintessential student, with the requisite work knowledge and job-specific talents to serve their interests through Rook+. We create an environment where students subscribe to companies of their dreams and are given tasks to find solutions to, be rated, and move a step closer to being qualified for their dream job. Essentially, the more ratings you get, the more recognition you get from companies on the platform, which eventually lead to internships and employment.</p></div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end tab content -->
                                    <!-- tab content -->
                                    <div class="tab-pane fade in" id="tab_sec2">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="text-white tz-text"><p>We are your friends, your mates, your neighbours. We are the people making a difference in society, the people making a better place for those around us as well as those yet to come. We realized that the hustle graduates go through whilst looking for jobs after school worsened progressively, no matter the calibre of student. Yes, we live in a world where everything is hard to get, but we are here. We are your heroes! We are connecting you in the university and any other tertiary institution with a company in and out of your country, exposing you to the various vital job markets: what they do, how they do it and how you can do it. We want to share this opportunity to sharpen your problem-solving abilities to match corporate efficiency and demand. Rook+ is redefining education and work by cancelling out inexperience and putting you in line of the scope of companies.</p></div>
                                            </div>
                                        </div>
                                    </div>
																		<!-- end tab content -->
																		<!-- tab content -->
                                    <div class="tab-pane fade in" id="tab_sec3">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="text-white tz-text"><p>•	Virtual work experience<br>•	Work at your own convenience<br>•	Build your CV <br>•	Internships<br>•	Become job ready </p></div>                                      
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end tab content -->
                                    <!-- tab content -->
                                    <div class="tab-pane fade in" id="tab_sec4">
                                        <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="text-white tz-text"><p>•	Cut down costs used for training workforce.<br>•	Reduce the workload of staff to have them focused on more challenging work.<br>•	No more business outsourcing. <br>•	Abundant and diverse business solutions and ideas.<br>•	Get the chance to test your products.</p></div>                                                                                                
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end tab content -->
                                </div>                                    
                            </div>                                
                        </div>
                    </div>
                </div>
            </div>
        <section class="bg-white builder-bg padding-110px-tb xs-padding-60px-tb team-style3 border-none" id="features">
        <div class="container">
                <div class="row equalize sm-equalize-auto">
                    <!-- section title -->
                    <div class="col-md-5 col-sm-12 col-xs-12 display-table xs-text-center sm-margin-twenty-bottom xs-margin-twenty-nine-bottom" style="">                            
                        <div class="display-table-cell-vertical-middle">
                            <!-- section title -->
                            <h2 class="alt-font title-large sm-title-large xs-title-large text-dark-gray margin-eight-bottom tz-text sm-margin-five-bottom">Here are some<br>core features of Rook+!</h2>
                            <!-- end section title -->
                            <div class="text-medium tz-text width-90 sm-width-100 margin-twelve-bottom sm-margin-five-bottom"><p>We create an environment where students subscribe to companies of their dreams and are given tasks to find solutions to, be rated, and move a step closer to being qualified for their dream job</p></div>
                            <!-- <a class="btn btn-medium propClone btn-circle bg-red text-white" href="#content-section32"><span class="tz-text">READ MORE</span><i class="fa fa-angle-right icon-extra-small tz-icon-color"></i></a> -->
                        </div>
                    </div>
                    <!-- end section title -->
                    <!-- feature box -->
                    <div class="col-md-7 col-sm-12 col-xs-12 display-table" style="">
                        <div class="display-table-cell-vertical-middle ">
                            <div class="two-column">
                                <div class="col-md-6 col-sm-6 col-xs-12 margin-five-bottom xs-margin-ten-bottom xs-text-center">
                                    <div class="float-left width-100 margin-four-bottom"> 
                                        <div class="info col-md-2 col-sm-2 col-xs-12 no-padding"><i class="fa ti-check-box icon-medium text-red tz-icon-color"></i> </div>
                                        <h3 class="text-medium font-weight-600 text-dark-gray col-md-10 col-sm-10 col-xs-12 no-padding margin-one-top tz-text">Internship Opportunities</h3> 
                                    </div>
                                    <div class="text-medium sm-text-medium float-left tz-text"><p>Get notification on internship opportunities from your favourite companies and apply with just a click of a button.</p></div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 margin-five-bottom xs-margin-ten-bottom xs-text-center">
                                    <div class="float-left width-100 margin-four-bottom"> 
                                        <div class="info col-md-2 col-sm-2 col-xs-12 no-padding"><i class="fa ti-medall icon-medium text-red tz-icon-color"></i> </div>
                                        <h3 class="text-medium font-weight-600 text-dark-gray col-md-10 col-sm-10 col-xs-12 no-padding margin-two-top tz-text">Experience</h3> 
                                    </div>
                                    <div class="text-medium sm-text-medium float-left tz-text"><p>Acquire experience by solving tasks posted by companies, to get a feel of some of the everyday tasks in the corporate world. </p></div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 xs-margin-ten-bottom xs-text-center">
                                    <div class="float-left width-100 margin-four-bottom"> 
                                        <div class="info col-md-2 col-sm-2 col-xs-12 no-padding"><i class="fa ti-agenda icon-medium text-red tz-icon-color"></i> </div>
                                        <h3 class="text-medium font-weight-600 text-dark-gray col-md-10 col-sm-10 col-xs-12 no-padding margin-two-top tz-text">Smart CV</h3> 
                                    </div>
                                    <div class="text-medium sm-text-medium float-left tz-text"><p class="no-margin-bottom">Rook's smart cv, automatically updates itself base on the task you solve and can be downloaded with a click of a button.</p></div>
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12 xs-text-center">
                                    <div class="float-left width-100 margin-four-bottom"> 
                                        <div class="info col-md-2 col-sm-2 col-xs-12 no-padding"><i class="fa ti-light-bulb icon-medium text-red tz-icon-color"></i> </div>
                                        <h3 class="text-medium font-weight-600 text-dark-gray col-md-10 col-sm-10 col-xs-12 no-padding margin-one-top tz-text">Access to Raw Talents</h3> 
                                    </div>
                                    <div class="text-medium sm-text-medium float-left tz-text"><p class="no-margin-bottom">Companies can follow students, to study their potential and progress for future employment</p></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end feature box -->
                </div>
            </div>
        </section>
        <section class="padding-60px-tb bg-rook builder-bg border-none" id="callto-action9">
            <div class="container">
                <div class="row equalize sm-equalize-auto">
                    <!-- section title -->
                    <div class="col-md-6 col-sm-12 col-xs-12 sm-text-center display-table sm-margin-ten-bottom xs-margin-fifteen-bottom">
                        <div class="offer-box-left display-table-cell-vertical-middle">
                            <div class="display-table-cell-vertical-middle sm-display-inline-block">
                                <span class="title-small xs-title-extra-large text-white display-block tz-text">We are creating a system where companies groom their future employees.</span>
                                <span class="title-extra-large-2 alt-font xs-title-extra-large text-white display-block tz-text">Become job ready </span>
                            </div>
                        </div>
                    </div>
                    <!-- end section title -->
                </div>
            </div>
        </section>
        <section  id="counter-section7" class="padding-110px-tb cover-background tz-builder-bg-image xs-padding-60px-tb border-none bg-img-five" data-img-size="(W)1920px X (H)525px" style="background:linear-gradient(rgb(7, 39, 79), #3F51B5);">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                        <!-- timer -->
                        <div id="counter">
                            <div class="col-md-3 col-sm-3 col-xs-12 first xs-margin-seventeen-bottom">                                    
                                <i class="fa fa-mortar-board icon-large tz-icon-color text-white margin-ten-bottom xs-margin-seven-bottom"></i>
                                <div class="counter-content">                                          
                                    <span class="timer counter-number title-extra-large sm-title-extra-large alt-font text-white display-block tz-text" data-to="<?php echo $students;?>" data-speed="7000"></span>
                                    <span class="text-small2 alt-font text-white sm-text-medium display-block tz-text">STUDENTS</span>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-12 first xs-margin-seventeen-bottom">
                                <i class="fa fa-bank icon-large tz-icon-color text-white margin-ten-bottom xs-margin-seven-bottom"></i>
                                <div class="counter-content">                                        
                                    <span class="timer counter-number title-extra-large sm-title-extra-large alt-font text-white display-block tz-text" data-to="<?php echo $companies;?>" data-speed="7000"></span>
                                    <span class="text-small2 alt-font text-white sm-text-medium display-block tz-text">COMPANIES</span>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-12 first xs-margin-seventeen-bottom">
                                <i class="fa fa-book icon-large tz-icon-color text-white margin-ten-bottom xs-margin-seven-bottom"></i>
                                <div class="counter-content">                                        
                                    <span class="timer counter-number title-extra-large sm-title-extra-large alt-font text-white display-block tz-text" data-to="<?php echo $tasks;?>" data-speed="7000"></span>
                                    <span class="text-small2 alt-font text-white sm-text-medium display-block tz-text">TASKS</span>
                                </div>
                            </div>
                            <div class="col-md-3 col-sm-3 col-xs-12 first">
                                <i class="fa fa-lightbulb-o icon-large tz-icon-color text-white margin-ten-bottom xs-margin-seven-bottom"></i>
                                <div class="counter-content">                                       
                                    <span class="timer counter-number title-extra-large sm-title-extra-large alt-font text-white display-block tz-text" data-to="<?php echo $solutionx;?>" data-speed="7000"></span>
                                    <span class="text-small2 alt-font text-white sm-text-medium display-block tz-text">TASK SOLUTIONS</span>
                                </div>
                            </div>
                        </div>
                        <!-- end timer -->
                    </div>
                </div>
            </div>
        </section>
        <section class="padding-110px-tb bg-light-gray border-none builder-bg xs-padding-60px-tb" id="contact-section3">
            <div class="container">
                <div class="row">
                    <!-- section title -->
                    <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                        <h2 class="section-title-large sm-section-title-medium xs-section-title-large text-dark-gray font-weight-700 alt-font tz-text margin-ten-bottom xs-margin-fifteen-bottom">GET IN TOUCH</h2>
                    </div>
                    <!-- end section title -->
                </div>
                <div class="row">
                    <!-- contact detail -->
                    <div class="col-md-12 col-sm-12 col-xs-12 no-padding text-center center-col clear-both">
                        <div class="col-md-4 col-sm-4 col-xs-12 xs-margin-thirteen-bottom">
                            <div class="col-md-2 vertical-align-middle no-padding display-block md-margin-nine-bottom xs-margin-three-bottom"><i class="fa ti-location-pin icon-extra-large text-red xs-icon-medium-large tz-icon-color"></i></div>
                            <div class="col-md-10 vertical-align-middle text-left no-padding text-dark-gray md-display-block sm-text-center text-medium tz-text">Accra, <br>Greater Accra, Ghana</div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12 xs-margin-thirteen-bottom">
                            <div class="col-md-3 vertical-align-middle no-padding display-block md-margin-nine-bottom xs-margin-three-bottom"><i class="fa ti-email icon-extra-large text-red xs-icon-medium-large tz-icon-color"></i></div>
                            <div class="col-md-9 vertical-align-middle text-left no-padding md-display-block sm-text-center">
                                <div class="text-medium font-weight-600 text-dark-gray display-block tz-text">General Enquiries</div>
                                <a class="tz-text text-dark-gray text-medium" href="mailto:info@myrookery.com">info@myrookery.com</a>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-4 col-xs-12">
                            <div class="col-md-2 vertical-align-middle no-padding display-block md-margin-nine-bottom xs-margin-three-bottom"><i class="fa ti-mobile icon-extra-large text-red xs-icon-medium-large tz-icon-color"></i></div>
                            <div class="col-md-10 vertical-align-middle text-left no-padding md-display-block sm-text-center">
                                <div class="text-medium font-weight-600 text-dark-gray display-block tz-text">Call Us Today!</div>
                                <div class="text-medium text-dark-gray tz-text">+233 (0) 500 291 475</div>
                                <div class="text-medium text-dark-gray tz-text">+233 (0) 248 997 133</div>
                            </div>
                        </div>
                    </div>
                    <!-- end contact detail -->
                    <!-- map -->
                    <!-- <div class="col-md-12 col-sm-12 col-xs-12 map margin-ten-top">
                        <iframe class="width-100" height="313" id="map_canvas1" style="pointer-events: none;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.843821917424!2d144.956054!3d-37.817127!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad65d4c2b349649%3A0xb6899234e561db11!2sEnvato!5e0!3m2!1sen!2sin!4v1427947693651"></iframe>
                    </div> -->
                    <!-- end map -->
                </div>
            </div>
        </section>
        <footer id="footer-section4" class="bg-white builder-bg padding-60px-tb xs-padding-40px-tb footer-style4">
            <div class="container">
                <div class="row equalize sm-equalize-auto">
                    <!-- logo -->
                    <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 sm-text-center sm-margin-five-bottom xs-margin-nine-bottom display-table">
                        <div class="display-table-cell-vertical-middle">
                            <a href="#home" class="inner-link"><img src="assets/images/logo.png" alt="" data-img-size="(W)163px X (H)39px"></a>
                        </div>
                    </div>
                    <!-- end logo -->
                    <div class="col-lg-6 col-md-5 col-sm-12 col-xs-12 sm-margin-three-bottom text-center xs-text-center display-table">
                        <div class="display-table-cell-vertical-middle">
                            <span class="tz-text"><?php echo $footer;?></span>
                        </div>
                    </div>
                    <!-- social elements -->
                    <div class="col-lg-3 col-md-4 col-sm-12 col-xs-12 text-right sm-text-center display-table">
                        <div class="social icon-extra-small display-table-cell-vertical-middle">
                            <a href="https://web.facebook.com/therookery233/" class="margin-sixteen-right">
                                <i class="fa fa-facebook tz-icon-color"></i>
                            </a>
                            <a href="https://twitter.com/therookery233" class="margin-sixteen-right">
                                <i class="fa fa-twitter tz-icon-color"></i>
                            </a>
                            <!-- <a href="#" class="margin-sixteen-right">
                                <i class="fa fa-google-plus tz-icon-color"></i>
                            </a>
                            <a href="#" class="margin-sixteen-right">
                                <i class="fa fa-pinterest tz-icon-color"></i>
                            </a>
                            <a href="#" class="margin-sixteen-right">
                                <i class="fa fa-linkedin tz-icon-color"></i>
                            </a>
                            <a href="#">
                                <i class="fa fa-youtube tz-icon-color"></i>
                            </a> -->
                        </div>
                    </div>                            
                    <!-- end social elements -->
                </div>
            </div>
        </footer>    
        <?php echo $footer;?>  
        <!-- javascript libraries -->
        <script type="text/javascript" src="assets/js/jquery.min.js"></script>
        <script type="text/javascript" src="assets/js/jquery.appear.js"></script>
        <script type="text/javascript" src="assets/js/smooth-scroll.js"></script>
        <script type="text/javascript" src="assets/js/bootstrap.min.js"></script>
        <!-- wow animation -->
        <script type="text/javascript" src="assets/js/wow.min.js"></script>
        <!-- owl carousel -->
        <script type="text/javascript" src="assets/js/owl.carousel.min.js"></script>        
        <!-- images loaded -->
        <script type="text/javascript" src="assets/js/imagesloaded.pkgd.min.js"></script>
        <!-- isotope -->
        <script type="text/javascript" src="assets/js/jquery.isotope.min.js"></script> 
        <!-- magnific popup -->
        <script type="text/javascript" src="assets/js/jquery.magnific-popup.min.js"></script>
        <!-- navigation -->
        <script type="text/javascript" src="assets/js/jquery.nav.js"></script>
        <!-- equalize -->
        <script type="text/javascript" src="assets/js/equalize.min.js"></script>
        <!-- fit videos -->
        <script type="text/javascript" src="assets/js/jquery.fitvids.js"></script>
        <!-- number counter -->
        <script type="text/javascript" src="assets/js/jquery.countTo.js"></script>
        <!-- time counter  -->
        <script type="text/javascript" src="assets/js/counter.js"></script>
        <!-- twitter Fetcher  -->
        <script type="text/javascript" src="assets/js/twitterFetcher_min.js"></script>
        <!-- main -->
        <script type="text/javascript" src="assets/js/main.js"></script>
    </body>
</html>
