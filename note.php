<?php
require('app/connect.php');
require('app/utility.php');

$ut = new Utility();

$q = mysqli_query($link, "SELECT firebase FROM appusers WHERE user_type='s' ");
$qnum = mysqli_num_rows($q);
if($qnum == 0){
  echo 'no users found';
  exit();
}
while($qr = mysqli_fetch_array($q, MYSQLI_ASSOC)){
  $alltokens[] = $qr['firebase'];
}
$tokens = $alltokens;
$note['title'] = 'From Server';    
$note['body'] = 'Testing notification feature';
$note['click_action'] = 'MAINACTIVITY';

$data['type'] = "task";
$ut->send_mass_firebase_notification($tokens, $note, $data);

?>