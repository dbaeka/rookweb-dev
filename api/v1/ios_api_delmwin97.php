<?php
/**
 * Created by PhpStorm.
 * User: dbaek
 * Date: 3/13/2018
 * Time: 2:27 PM
 */


require '../app/user_iOS.php';
//require '../app/validate_iOS.php';

$ux = new User();
$val = new Validate();

if (isset($_POST['apid'])) {
    $apid = $_POST['apid'];
    $uc = $ux->get_user_type($apid);
    $usertype = $uc['user_type'];
    $userx = $ux->user_data($apid, "fname,lname,username,gender,dob,school,avatar,program,active,postal,city,country,phone,state,year");
    $userz = $ux->user_email($apid);
    $userid = $uc['userid'];


    $code = substr($userx['phone'], 0, 3);
    $phone = substr($userx['phone'], 3, 15);

    $gender = $userx['gender'];
    $school = $userx['school'];
    $program = $userx['program'];

    $dob = $userx['dob'];
    $username = $userx['username'];
    $email = $userz['email'];

    if (empty($userx['avatar'])) {
        $avatar = 'p.png';
    } else {
        $avatar = $userx['avatar'];
    }


    $points = $ux->get_points($apid);
    $attempts = $ux->get_attempts($apid);
    $solutions = $ux->get_solutions($apid);
    $watching = $ux->get_companies_watching($apid);
    $statistics = $ux->show_statics($apid);


    if ($attempts != 0) {
        $comp = number_format(($solutions / $attempts) * 100);
        if ($solutions == 0) {
            $ptext = '';
        } else {
            $ptext = $comp . '%';
        }
    } else {
        $comp = 0;
        $ptext = '';
    }


    if (isset($_POST['action']) && $_POST['action'] == "profile") {
        $data['state'] = 200;
        $data['points'] = $points;
        $data['attempts'] = $attempts;
        $data['solutions'] = $solutions;
        $data['watching'] = $watching;
        $data['email'] = $email;
        $data['school'] = $school;
        $data['dob'] = $dob;
        $data['avatar'] = $avatar;
        $data['year'] = $userx['year'];
        $data['active'] = $userx['active'];
        if ($data['active']==1){
            if (empty($userx['username'])){
                $data['active'] = 1;
            } else {
                $data['active'] = 2;
                    }
                }

        if ($userx['country'] == "81") {
            $data['country'] = "Ghana";
        } else {
            $data['country'] = "Nigeria";
        }

        if (empty($userx['postal'])) {
            $data['postal'] = "N/A";
        } else {
            $data['postal'] = $userx['postal'];
        }

        if (empty($userx['city'])) {
            $data['city'] = "N/A";
        } else {
            $data['city'] = $userx['city'];
        }


        if (empty($userx['state'])) {
            $data['states'] = "N/A";
        } else {
            $data['states'] = $userx['state'];
        }

        $data['fname'] = $userx['fname'];
        $data['lname'] = $userx['lname'];
        $data['code'] = $code;
        $data['phone'] = $phone;
        $data['username'] = $username;
        $data['program'] = $program;
        $data['gender'] = $gender;
        $data['comp'] = $comp;
        $data['speed'] = $statistics['speed'];
        $data['rate'] = $statistics['rate'];
        $data['initiative'] = $statistics['initiative'];
        $data['execute'] = $statistics['execute'];

        echo json_encode($data);
    } else if (isset($_POST['action']) && $_POST['action'] == "tasks") {
        $data['state'] = 200;
        $tasks = $ux->new_tasks($apid);
    } else if (isset($_POST['action']) && $_POST['action'] == "mytasks") {
        $ctasks = $ux->my_tasks($apid);
    } else if (isset($_POST['action']) && $_POST['action'] == "internship") {
        $ctasks = $ux->get_internships($apid);
    } else if (isset($_POST['action']) && $_POST['action'] == "taskdetail") {
        $task = $_POST['t'];
        $tasks = $ux->task_detail($apid, $task);
    } else if (isset($_POST['action']) && $_POST['action'] == "companies") {
        $ctasks = $ux->get_companies($apid);
    } else if (isset($_POST['action']) && $_POST['action'] == "cvstate") {
        $ux->get_cv_state($apid);
    } else if (isset($_POST['action']) && $_POST['action'] == "previewcv") {
        $cv = $ux->download_cv($apid);
        echo $cv;
    } else if (isset($_POST['action']) && $_POST['action'] == "getcv") {
        $ux->get_my_cv($apid);
    } else if (isset($_POST['action']) && $_POST['action'] == 'subscribe') {
        $company = $_POST['company'];
        $ac = $ux->subscribe_to_company($userid, $company);
    } else if (isset($_POST['action']) && $_POST['action'] == 'starttask') {

        $task = $_POST['task'];
        $ac = $ux->start_task($userid, $task);

    } else if (isset($_POST['action']) && $_POST['action'] == 'apply') {

        $internship = $_POST['iid'];

        if (!(empty($internship))) {


            $ac = $ux->apply_to_intern($apid, $internship);
        }
    } else if (isset($_POST['action']) && $_POST['action'] == 'delcvinfo') {

        $tag = $_POST['id'];
        $type = $_POST['type'];

        if ($type == 'job' || $type == 'edu' || $type == 'skill') {
            $ac = $ux->update_cv($userid, $type, $tag);

        }


    } else if (isset($_POST['action']) && $_POST['action'] == "profsum") {
        $prof = $_POST['prof'];

        if (empty($prof)) {
            $msg = '<script type="text/javascript">
              swal("Error!", "Professional Summary cannot be empty", "error")
            </script>';
        } else if (strlen($prof) > 160) {
            $msg = '<script type="text/javascript">
              swal("Error!", "Professional Summary cannot be more than 160 characters ", "error")
            </script>';
        } else {
            $pfadd = $ux->update_professional_summary($apid, $prof);
            if ($pfadd == 1) {
                $data['state'] = 200;
                echo json_encode($data);
            } else {
                $data['state'] = 400;
                echo json_encode($data);
            }
        }
    } else if (isset($_POST['action']) && $_POST['action'] == "commserv") {
        $comms = $_POST['comms'];

        if (empty($comms)) {
            $msg = '<script type="text/javascript">
              swal("Error!", "Community Service cannot be empty", "error")
            </script>';
        } else if (strlen($comms) > 160) {
            $msg = '<script type="text/javascript">
              swal("Error!", "Community Service cannot be more than 160 characters ", "error")
            </script>';
        } else {
            $cmadd = $ux->update_community_service($apid, $comms);
            if ($cmadd == 1) {
                $data['state'] = 200;
                echo json_encode($data);
            } else {
                $data['state'] = 400;
                echo json_encode($data);;
            }
        }
    } else if (isset($_POST['action']) && $_POST['action'] == "hobbyup") {
        $error = 0;
        $hobby = $_POST['hobby'];

        if (empty($hobby)) {
            $msg = '<script type="text/javascript">
              swal("Error!", "Hobbies and Interests cannot be empty", "error")
            </script>';
        } else if (strlen($hobby) > 160) {
            $msg = '<script type="text/javascript">
              swal("Error!", "Hobbies and Interests cannot be more than 160 characters ", "error")
            </script>';
        } else {
            $hoadd = $ux->update_hobby($apid, $hobby);
            if ($hoadd == 1) {
                $data['state'] = 200;
                echo json_encode($data);
            } else {
                $data['state'] = 400;
                echo json_encode($data);
            }
        }
    } else if (isset($_POST['action']) && $_POST['action'] == "skillup") {
        $error = 0;

        $skill = $_POST['skill'];

        if (empty($skill)) {
            $error++;
        }

        if ($error == 0) {
            $sk = $ux->update_skill($apid, $skill);
            if ($sk == 1) {
                $data['state'] = 200;
                echo json_encode($data);
            } else {
                $data['state'] = 400;
                echo json_encode($data);
            }

        } else {
            $data['state'] = 400;
            echo json_encode($data);
        }

    } else if (isset($_POST['action']) && $_POST['action'] == "education") {
        $error = 0;

        $sname = $_POST['sname'];
        $sloc = $_POST['sloc'];
        $degree = $_POST['degree'];
        $field = $_POST['field'];
        $cyear = $_POST['cyear'];

        if (empty($sname) || empty($sloc) || empty($degree) || empty($field)) {
            $error++;
        }


        if (empty($cyear)) {
            $error++;
        } else if (!preg_match("/^\d{4}$/", $cyear)) {
            $error++;
        }


        if ($error == 0) {
            $edu = $ux->update_education($apid, $sname, $sloc, $degree, $field, $cyear);
            if ($edu == 1) {
                $data['state'] = 200;
                echo json_encode($data);
            } else {
                $data['state'] = 400;
                echo json_encode($data);
            }

        } else {
            $data['state'] = 400;
            echo json_encode($data);
        }
    } else if (isset($_POST['action']) && $_POST['action'] == "pinfo") {

        $error = 0;


        $postal = $_POST['postal'];
        $country = $_POST['country'];
        $city = $_POST['city'];
        $state = $_POST['state'];


        if (empty($country) == true) {
            $error++;
        } else {
            $cc = $ux->check_country($country);
            if (empty($cc) == true) {
                $error++;
            }
        }

        if ($error == 0) {
            $udata = $ux->update_info($apid, $postal, $country, $city, $state);
            if ($udata == 1) {
                $data['state'] = 200;
                echo json_encode($data);
            } else {
                $data['state'] = 400;
                echo json_encode($data);
            }
        } else {
            $data['state'] = 400;
            echo json_encode($data);
        }
    } else if (isset($_POST['action']) && $_POST['action'] == "workup") {
        $error = 0;

        $jobtitle = $_POST['jobtitle'];
        $employer = $_POST['employer'];
        $duties = $_POST['duties'];
        $startdate = $_POST['sdate'];
        $enddate = $_POST['edate'];
        $country = "Ghana";   //$_POST['country'];
        $newdate = explode("-", $startdate);
        $smonth = $newdate[0];
        $syear = $newdate[1];

        $emonth = $eyear = $current = NULL;


        if (!isset($_POST['current'])) {
            $newdate = explode("-", $enddate);
            $emonth = $newdate[0];
            $eyear = $newdate[1];
            $edate = date("Y-m-d", strtotime($eyear . '-' . $emonth . '-1'));
        } else {
            $current = 1;
            $edate = '';
        }

        if (empty($jobtitle) || empty($employer) || empty($country) || empty($smonth)) {
            $error++;
        }

        if (empty($duties)) {
            $error++;
        } else if (strlen($duties) > 160) {
            $error++;
        }

        $newedate = explode("-", $enddate);
        $emonth = $newedate[0];
        $eyear = $newedate[1];
        $edate = date("Y-m-d", strtotime($eyear . '-' . $emonth . '-1'));


        $sdate = date("Y-m-d", strtotime($syear . '-' . $smonth . '-1'));

        if ($error == 0) {
            $work = $ux->update_work_history($apid, $jobtitle, $employer, $country, $duties, $sdate, $edate, $current);
            if ($work == 1) {
                $data['state'] = 200;
                echo json_encode($data);
            } else {
                $data['state'] = 400;
                echo json_encode($data);
            }

        } else {
            $data['state'] = 400;
            echo json_encode($data);
        }
    } else if (isset($_POST['action']) && $_POST['action'] == 'activate') {
        $code = $_POST['code'];
        $ac = $ux->activate($userid, $code);
        if ($ac) {
            $data['state'] = 200;
        } else {
            $data['state'] = 400;
        }
        echo json_encode($data);
    } 
   else if (isset($_POST['action']) && $_POST['action'] == 'uploadavatar') {
        $data = $_POST['avatarup'];
        $ac = $ux->change_avatar($data, $apid);
        if ($ac == 1) {
            $result['status'] = 200;
             $result['apid'] = $apid;
              $idata = $val->user_data($apid, 'fname', 'lname', 'active', 'gender', 'dob', 'phone', 'avatar');
                $result['fname'] = $idata['fname'];
                $result['lname'] = $idata['lname'];
                $result['active'] = $idata['active'];
                 if (empty($idata['avatar'])) {
                    $result['avatar'] = 'p.png';
                } else {
                    $result['avatar'] = $idata['avatar'];
                }

                if ($idata['active'] == 1) {
                    $mdata = $val->user_data($apid, 'school', 'program', 'year', 'username');
                    $result['school'] = $mdata['school'];
                    $result['program'] = $mdata['program'];
                    $result['year'] = $mdata['year'];
                    $result['username'] = $mdata['username'];
                }
                $result['gender'] = $idata['gender'];
                $result['dob'] = $idata['dob'];
                $result['phone'] = $idata['phone'];
        } else {
            $result['status'] = 400;
        }
        echo json_encode($result);
    } else if (isset($_POST['action']) && $_POST['action'] == 'resendsms') {
        $rsnd = $ux->resend_sms($apid);
        $ru = explode('|', $rsnd);
        if ($ru[0] == false) {
            $data['state'] = 400;
            $data['response'] = 'Oh Snap';
            echo json_encode($data);
        } else {
            $data['state'] = 200;
            $data['response'] = 'SMS Resent Successfully';
            echo json_encode($data);
        }
    } else if (isset($_POST['action']) && $_POST['action'] == 'changenumber') {
        $phone = $_POST['phone'];
        $code = $_POST['areaCode'];
        if (empty($code) == true) {
            $data['state'] = 400;
            $data['response_msg'] = 'Field is empty or invalid';
            echo json_encode($data);
        } else if ($code != '233' && $code != '234') {
            $data['state'] = 400;
            $data['response_msg'] = 'Field is empty or invalid';
            echo json_encode($data);
        } else {
            if (empty($phone) == true) {
                $data['state'] = 400;
                $data['response_msg'] = 'Field is empty or invalid';
                echo json_encode($data);
            } else if (!preg_match("/^[0-9]+$/", $phone)) {
                $data['state'] = 400;
                $data['response_msg'] = 'Phone is invalid';
                echo json_encode($data);
            } else {
                if (substr($phone, 0, 1) == '0') {
                    $phone = substr($phone, 1, 15);
                }
                $phonenum = $code . $phone;
                $upadd = $ux->addphone($userid, $phonenum);
                $up = explode('|', $upadd);
                if ($up[0] == false) {
                    $data['state'] = 400;
                    $data['response_msg'] = 'Oh Snap';
                    echo json_encode($data);
                } else {
                    $data['state'] = 200;
                    $data['phone'] = $phonenum;
                    echo json_encode($data);
                }
            }
        }
    } else if (isset($_POST['action']) && $_POST['action'] == 'subinfo') {
        $error = 0;
        $emsg = '';
        $username = $_POST['username'];
        $school = $_POST['school'];
        $program = $_POST['program'];
        $year = $_POST['year'];

        if (empty($username) == true) {
            $error++;
        } else if (!preg_match("/^[a-z\d]+$/i", $username)) {
            $error++;
        } else {
            $uch = $ux->check_username($username);
            if (empty($uch)) {
                $error++;
                $data['response_msg'] = "Username already exits";
                echo json_encode($data);
                exit();
            }
        }

        if (empty($school) == true) {
            $error++;
        }
        if (empty($program) == true) {
            $error++;
        }
        if (empty($year) == true) {
            $error++;
        } else if (!preg_match("/^\d{4}$/", $year)) {
            $error++;
        }


        if ($error == 0) {
            $com = $ux->complete_signup($userid, $username, $school, $program, $year);
            if ($com != '1') {
                $data['state'] = 400;
                $data['response_msg'] = "Oh Snap";
                echo json_encode($data);
            } else {
                $data['state'] = 200;
                $data['response_msg'] = "Successfully updated user info";
                $idata = $val->user_data($apid, 'fname', 'lname', 'active', 'gender', 'dob', 'phone');
                $data['fname'] = $idata['fname'];
                $data['lname'] = $idata['lname'];
                $data['active'] = $idata['active'];
                if ($idata['active'] == 1) {
                    $mdata = $val->user_data($apid, 'school', 'program', 'year', 'username');
                    $data['school'] = $mdata['school'];
                    $data['program'] = $mdata['program'];
                    $data['year'] = $mdata['year'];
                    $data['username'] = $mdata['username'];
                     if (empty($mdata['username'])){
                     $data['active'] = 1;
                    } else {
                        $data['active'] = 2;
                    }
                }
                   
                $data['gender'] = $idata['gender'];
                $data['dob'] = $idata['dob'];
                $data['phone'] = $idata['phone'];
                echo json_encode($data);
            }
        } else {
            if (empty($emsg)) {
                $data['state'] = 400;
                $data['response_msg'] = "Oh Snap";
                echo json_encode($data);
            } else {
                $data['state'] = 400;
                $data['response_msg'] = $emsg;
                echo json_encode($data);
            }
        }
    } else if (isset($_POST['action']) && $_POST['action'] == 'submit') {
        $error = 0;
        $summary = $_POST['summary'];
        $task = $_POST['task'];
        $solution = $_FILES['solution']['name'];
        $solution_size = $_FILES['solution']['size'];
        $solution_temp = $_FILES['solution']['tmp_name'];

        if (empty($task) == true) {
            $data["msg"] = "Invalid task information";
            $error++;
        }

        if (empty($summary) == true) {
            $data["msg"] = "Solution summary can not be empty";
            $error++;
        } else if (strlen($summary) > 160) {
            $data["msg"] = "Solution summary can not be more than 160 characters";
            $error++;
        }

        if (empty($solution) == false) {
            $fileupdt = $ux->checkfile($solution, $solution_size);
            if ($fileupdt == 0) {
                $data["msg"] = "Invalid file format (Allowed pdf,doc,docx)";
                $error++;
            } else if ($fileupdt == 2) {
                $data["msg"] = "Solution file size too big (Max image size 2MB)";
                $error++;
            }
        } else {
            $data["msg"] = "Solution document can not be empty";
            $error++;
        }

        if ($error == 0) {
            $check = $ux->task_check($apid, $task);
            if ($check == 1) {
                $inad = $ux->update_solution($apid, $task, $summary, $solution, $solution_temp);
                if ($inad == 1) {
                    $data["msg"] = "Your solution has been submit successfully.";
                    $data["state"] = 200;
                    echo json_encode($data);
                    exit();
                } else {
                    $data["msg"] = "Solution could not be submit...try again.";
                    $data["state"] = 400;
                    echo json_encode($data);
                    exit();
                }
            } else {
                echo json_encode($check);
                exit();
            }
        } else {
            echo json_encode($data);
            exit();
        }
    } else if (isset($_POST['action']) && $_POST['action'] == 'upaccount') {
        $error = 0;


        $email = $_POST['email'];
        $postal = $_POST['postal'];
        $phone = $_POST['phone'];
        $code = $_POST['code'];
        $country = $_POST['country'];
        $city = $_POST['city'];
        $state = $_POST['state'];


        if (empty($phone) == true) {
            $error++;

        } else if (!preg_match("/^[0-9]+$/", $phone)) {
            $error++;

        } else {
            if (substr($phone, 0, 1) == '0') {
                $phone = substr($phone, 1, 15);
            }
        }

        if (empty($email) == true) {
            $error++;

        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error++;

        }


        if (empty($country) == true) {
            $error++;

        } else {
            $cc = $ux->check_country($country);
            if (empty($cc) == true) {
                $error++;

            }
        }


        if (empty($code) == true) {
            $error++;

        } else if ($code != '233' && $code != '234') {
            $error++;

        }


        if ($error == 0) {
            $phonenum = $code . $phone;
            $udata = $ux->update_info($apid, $email, $phonenum, $postal, $country, $city, $state);
            if ($udata == 1) {
                $data['status'] = 200;
            } else {
                $data['status'] = 400;
            }
        } else {
            $data['status'] = 400;
        }


        if (isset($_POST['changepassword']) && $_POST['changepassword'] == "change") {
            $error = 0;

            $oldpassword = $_POST['oldpassword'];
            $newpassword = $_POST['newpassword'];

            if (empty($oldpassword) == true) {
                $error++;
            }
            if (empty($newpassword) == true) {
                $error++;
            }

            if ($error == 0) {
                $password = $ux->update_password($apid, $oldpassword, $newpassword);
                if ($password == 1) {
                    $data['status'] = 200;
                } else {
                    $data['status'] = 500;
                    $data["response"] = "Old Password Incorrect!";
                }
            } else {
                $data['status'] = 400;
            }
        }

        if (isset($_POST['changeavatar']) && $_POST['changeavatar'] == "change") {
            $error = 0;

            $pic = $_POST['avatarup'];
            if (empty($pic) == true) {
                $error++;
            }

            if ($error == 0) {
                $ac = $ux->change_avatar($pic, $apid);
                if ($ac == 1) {
                    $data['status'] = 200;
                } else {
                    $data['status'] = 400;

                }
            } else {
                $data['status'] = 400;

            }
        }
        echo json_encode($data);
    } else {
        $data['state'] = 400;
        $data['response_msg'] = "Unable to establish connection1";
        echo json_encode($data);
    }

} else if (isset($_POST['action']) && $_POST['action'] == 'login') {
    if (isset($_POST['email'], $_POST['password']) && $_POST['email'] && $_POST['password']) {
        $error = 0;
        $email = clean($link, $_POST['email']);
        $password = clean($link, $_POST['password']);
        $firebase = clean($link, $_POST['firebase']);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error++;
        }

        if ($error == 0) {
            $udata = $val->app_login($email, $password, $firebase);
            $udatax = explode("|", $udata);
            if ($udatax[0] == true) {
                $apid = $udatax[1];
                $idata = $val->user_data($apid, 'fname', 'lname', 'active', 'gender', 'dob', 'phone', 'avatar', 'username');
                $data['fname'] = $idata['fname'];
                $data['lname'] = $idata['lname'];
                $data['active'] = $idata['active'];
                if ($data['active']==1){
                    if (empty($idata['username'])){
                     $data['active'] = 1;
                    } else {
                        $data['active'] = 2;
                    }
                }
                $data['apid'] = $apid;
                if (empty($idata['avatar'])) {
                    $data['avatar'] = 'p.png';
                } else {
                    $data['avatar'] = $idata['avatar'];
                }

                if ($idata['active'] == 1) {
                    $mdata = $val->user_data($apid, 'school', 'program', 'year', 'username');
                    $data['school'] = $mdata['school'];
                    $data['program'] = $mdata['program'];
                    $data['year'] = $mdata['year'];
                    $data['username'] = $mdata['username'];
                }
                $data['gender'] = $idata['gender'];
                $data['dob'] = $idata['dob'];
                $data['phone'] = $idata['phone'];
                $data['token'] = $udatax[2];
                $data['state'] = 200;
                echo json_encode($data);
            } else {
                $data['state'] = 400;
                $data['response_msg'] = $udatax[1];
                echo json_encode($data);
            }
        } else {
            $data['state'] = 400;
            $data['response_msg'] = 'invalid parameters';
            echo json_encode($data);
        }

    } else {
        $data['state'] = 400;
        $data['response_msg'] = 'invalid parameters';
        echo json_encode($data);
    }
}  else if (isset($_POST['action']) && $_POST['action'] == 'reset') {
         $error = 0;
         $email = $_POST['email'];
         if(empty($email) == true){
             $error++;
         }
         if($error == 0){
             $udata = $val->forgot_password($email);
             if($udata == 1){
                 $data['state'] = 200;
                 $data['msg'] = "Success";
                 echo json_encode($data);
             }else{
                 $data['state'] = 400;
                 $data['msg'] = "Failed to reset";
                 echo json_encode($data);
             }
         }
         else{
            $data['state'] = 400;
            $data['msg'] = "Failed to reset";
            echo json_encode($data);
         }
    } else if (isset($_POST['action']) && $_POST['action'] == 'logEmail') {
    if (isset($_POST['email'])) {
        $error = 0;
        $email = clean($link, $_POST['email']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error++;
        }
        if ($error == 0) {
            $udata = $val->check_user($email);
            $udatax = explode("|", $udata);
            if ($udatax[0] == true) {
                $apid = $udatax[1];
                $idata = $val->user_data($apid, 'fname');
                $data['fname'] = $idata['fname'];
                $data['state'] = 200;
                echo json_encode($data);
            }
            else {
                $data['result'] = $udata;
                $data['state'] = 400;
                $data['response'] = "User doesn't exist!";
                echo json_encode($data);
            }
        } else {
            $data['state'] = 400;
            $data['response'] = 'invalid parameters';
            echo json_encode($data);
        }
    } else {
        $data['state'] = 400;
        $data['response'] = 'invalid parameters';
        echo json_encode($data);
    }

} 
else if (isset($_POST['action']) && $_POST['action'] == 'invite') {
    if (isset($_POST['email'])){
        $error = 0;
        $email = $_POST['email'];
         if (empty($email) == true) {
            $error++;
        }
           if ($error == 0) {
               $send = $val->invite($email);
               if ($send == 1) {
                   $data['state'] = 200;
                   $data['msg'] = "Successfully sent invite!";
                   echo json_encode($data);
               } else if ($send == 2){
                    $data['state'] = 400;
                    $data['msg'] = "Email is already on Rook+ platform!";
                    echo json_encode($data);
               }
               else {
                   $data['state'] = 400;
                   $data['msg'] = "Failed to send invite!";
                   echo json_encode($data);
               }
        } else {
            $data['state'] = 400;
            $data['msg'] = 'invalid parameters';
            echo json_encode($data);
        }
    } else {
        $data['state'] = 400;
        $data['msg'] = 'invalid parameters';
        echo json_encode($data);
    }
}
else if (isset($_POST['action']) && $_POST['action'] == 'valusername') {
        $username = $_POST['username'];
        $ac = $ux->check_username($username);
        if ($ac) {
            $data['state'] = 200;
        } else {
            $data['state'] = 400;
        }
        echo json_encode($data);
    } 
else if (isset($_POST['action']) && $_POST['action'] == 'signup') {
    if (isset($_POST['fname'], $_POST['lname'], $_POST['email'], $_POST['password'], $_POST['phone'], $_POST['code'], $_POST['gender'], $_POST['country'], $_POST['month'], $_POST['year'], $_POST['day'])
        && $_POST['fname'] && $_POST['lname'] && $_POST['email'] && $_POST['password'] && $_POST['phone'] && $_POST['code'] && $_POST['gender'] && $_POST['country'] && $_POST['month'] && $_POST['year'] && $_POST['day']&& $_POST['firebase']) {
        $error = 0;
        $firebase = $_POST['firebase'];
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

        $dob = date("Y-m-d", strtotime($year . '-' . $month . '-' . $day));


        if (empty($phone) == true) {
            $error++;
        } else if (!preg_match("/^[0-9]+$/", $phone)) {
            $error++;
        } else {
            if (substr($phone, 0, 1) == '0') {
                $phone = substr($phone, 1, 15);
            }
        }

        if (empty($email) == true) {
            $error++;
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error++;
        }

        if (empty($password) == true) {
            $error++;
        }

        if (empty($gender) == true) {
            $error++;
        } else if ($gender != 'm' && $gender != 'f') {
            $error++;
        }


        if (empty($country) == true) {
            $error++;
        } else {
            $cc = $val->check_country($country);
            if (empty($cc) == true) {
                $error++;
            }
        }


        if (empty($dob) == true) {
            $error++;
        }

        if (empty($code) == true) {
            $error++;
        } else if ($code != '233' && $code != '234') {
            $error++;
        }

        if (empty($fname) == true) {
            $error++;
        }
        if (empty($lname) == true) {
            $error++;
        }

        if ($error == 0) {
            $phonenum = $code . $phone;
            $udata = $val->app_signup($firebase, $fname, $lname, $gender, $email, $password, $dob, $country, $phonenum);
            $udatax = explode("|", $udata);
            if ($udatax[0] == true) {
                $apid = $udatax[1];
                $data['phone'] = $phone;
                $data['code'] = $code;
                $data['phonenum'] = $phonenum;
                $data['state'] = 200;
                $data['apid'] = $apid;
                echo json_encode($data);
            } else {
                $data['state'] = 400;
                $data['response_msg'] = "Unable to signup!";
                echo json_encode($data);
            }
        } else {
            $data['state'] = 400;
            $data['response_msg'] = 'inva parameters';
            echo json_encode($data);
        }
    } else {
        $data['state'] = 400;
        $data['response_msg'] = 'inv parameters';
        echo json_encode($data);
    }
} else {
    $data['state'] = 400;
    $data['response_msg'] = "Unable to establish connection2";
    echo json_encode($data);
}

?>
