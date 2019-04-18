<?php 
class Company{

  public function get_company_list($stid, $search){
    global $link, $baseUrl;

    $search = clean($link, $search);
    $stid = clean($link, $stid);

    $parameter = '';
    if(empty($search)){
      $parameter = "AND cname LIKE '%$search%'";
    }else{
      $parameter = "AND cid IN (SELECT cid FROM task WHERE 1 ORDER BY RAND() LIMIT 15) ORDER BY RAND()";
    }

    $q = mysqli_query($link, "SELECT * FROM company WHERE cid NOT IN (SELECT cid FROM subscribe WHERE stid='$stid' ) $parameter LIMIT 15");
    $qnum = mysqli_num_rows($q);
    if($qnum == 0){
      $data['state'] = 400;
      $data['response_msg'] = 'no compnay found';
      return $data;
    }

    $list = array();
    while($qr = mysqli_fetch_array($q, MYSQLI_ASSOC)){
      $dt['company_name'] = $qr['cname'];
      $dt['location'] = $qr['location'];
      $dt['address'] = $qr['address'];
      $dt['email'] = $qr['email'];
      $dt['bio'] = $qr['bio'];
      $dt['logo'] = $baseUrl.'img/avatar/'.$qr['logo'];;

      array_push($list, $dt);
    } 

    $data['state'] = 200;
    $data['companies'] = $list;
    return $data;
  }

}

?>