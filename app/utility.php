<?php
class Utility{
	public function send_firebase_notification($token, $notication, $data){
    global $fb_key;

    $fcmUrl = 'https://fcm.googleapis.com/fcm/send';

    $fcmNotification = [
      // 'registration_ids' => $tokens, //multple token array
        'to'        => $token, //single token
        'notification' => $notication,
        'data' => $data
    ];

    $headers = [
        'Authorization: key='.$fb_key,
        'Content-Type: application/json'
    ];


    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$fcmUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
    $result = curl_exec($ch);
    curl_close($ch);
    
  }

  public function send_mass_firebase_notification($tokens, $notication, $data){
    global $fb_key;

    $fcmUrl = 'https://fcm.googleapis.com/fcm/send';

    $fcmNotification = [
      'registration_ids' => $tokens, //multple token array
        // 'to'        => $token, //single token
        'notification' => $notication,
        'data' => $data
    ];

    $headers = [
        'Authorization: key='.$fb_key,
        'Content-Type: application/json'
    ];


    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$fcmUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fcmNotification));
    $result = curl_exec($ch);
    curl_close($ch);
    
  }
}
?>