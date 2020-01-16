<?php 

if(!function_exists('favorites_check')){
  
  function favorites_check($parent_array,$child_array){
    
    $array = array();
    foreach ($parent_array as $value) {
      
      if(in_array($value['id'],$child_array)){
        $value['favourite'] = '1';
      }
      $array[] = $value;
    }
    return  $array;
  }
}

if(!function_exists('send_message')){

 function send_message($data){

      
        $message = $data['message'];
        $user_chat_details = (!empty($data['additional_data']))?$data['additional_data']:'';
        $notifications_title = (!empty($user_chat_details['from_name']))?$user_chat_details['from_name']:'Success notification';

        if(!empty($message)){
          $user_id = $data['user_id'];
        $include_player_ids = $data['include_player_ids'];
        $include_player_id =  array($include_player_ids);
        $heading = array(
           "en" => $notifications_title
        );
        $content = array(
            "en" => "$message"
        );

        $app_id = $data['app_id'];

        $fields = array(
            'app_id' => $app_id,
            'data' => $data['additional_data'],
            //'included_segments' => array('All'),
            //'included_segments' =>  array("Active Users", "Inactive Users"),
           // 'filters' => array(array("field" => "tag", "key" => "user_id", "relation" => "=", "value" => "$user_id")),

            'include_player_ids' => $include_player_id,
            'contents' => $content,
            'headings' => $heading
        );
        if(empty($include_player_ids)){
            unset($fields['include_player_ids']);
        }
 

        $fields = json_encode($fields);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://onesignal.com/api/v1/notifications");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json; charset=utf-8',
            'Authorization: Basic '.$data['reset_key']));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $response = curl_exec($ch);
        curl_close($ch);
    
       return $response;
        }
    }
 }

  if(!function_exists('gigs_settings')){
  
  function gigs_settings(){
      $ci =& get_instance();
      $query = $ci->db->query("select * from system_settings WHERE status = 1");
      return  $query->result_array();
     }
}

if(!function_exists('smtp_mail_config')){

  function smtp_mail_config(){ 
      $config = array(
         'protocol'  => 'send',
           'mailtype'  => 'html',
           'charset'   => 'utf-8'
         );
     $ci =& get_instance();
     $ci->load->database();
     $ci->db->select('key,value,system,groups');
     $ci->db->from('system_settings');
     $query = $ci->db->get();
     $results = $query->result();

      $smtp_host = '';
      $smtp_port = '';
      $smtp_user = '';
      $smtp_pass = '';
     if(!empty($results)){
      foreach ($results as $result) {
        $result = (array)$result;
        if($result['key'] == 'smtp_host'){
          $smtp_host = $result['value'];
        }
        if($result['key'] == 'smtp_port'){
          $smtp_port = $result['value'];
        }
        if($result['key'] == 'smtp_user'){
          $smtp_user = $result['value'];
        }
        if($result['key'] == 'smtp_pass'){
          $smtp_pass = $result['value'];
        }
      }

      if(!empty($smtp_host) && !empty($smtp_port) && !empty($smtp_user) && !empty($smtp_pass)){
         $config = array(
           'protocol'  => 'send',
           'smtp_host' => 'ssl://'.$smtp_host,
           'smtp_port' => $smtp_port,
           'smtp_user' => "$smtp_user",
           'smtp_pass' => "$smtp_pass",
           'mailtype'  => 'html',
           'charset'   => 'utf-8'
         );
      }
      }
      return  $config;    
    }

 }



?>