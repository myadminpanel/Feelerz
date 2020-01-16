<?php
class Message_model extends CI_Model{
     public function students_friends_with_details($id) { 
	 	
		
		$querychat   = $this->db->query("SELECT id,chat_from,chat_to FROM chats 
						WHERE status = 0 AND (chat_to = '".$this->session->userdata('SESSION_USER_ID')."' and to_delete_sts=0) 
						OR (chat_from = '".$this->session->userdata('SESSION_USER_ID')."' and from_delete_sts=0) order by id desc ");
		$chat_counta = $querychat->result_array();
		$to_user = array();
		$cht_rw_id=0;
		$data =array();
		 if (!empty($chat_counta)) {
			 $data['details']=array();
			 foreach ($chat_counta as $key => $usr_lst) { 
			 	 $flw_id = $flw_name = $flw_image = $chat_id=  '';
				 $totres=0;
				 $push=array();
				  if($usr_lst['chat_from']==$this->session->userdata('SESSION_USER_ID')){
					  if(!in_array($usr_lst['chat_to'],$to_user)){
						  $to_user[]=$usr_lst['chat_to'];
						  $queryuser   = $this->db->query("SELECT USERID,fullname,user_thumb_image,user_timezone FROM members WHERE USERID=".$usr_lst['chat_to']."");
						  $chat_data = $queryuser->row_array();
						  $flw_id        = $chat_data['USERID'];
						  $flw_name      = $chat_data['fullname'];
						  $flw_image     = $chat_data['user_thumb_image'];
						  $chat_zone     = $chat_data['user_timezone'];
						  $chat_id       = $usr_lst['id'];
						  
						  $totres=1;
						  $push['user_id']          =  $flw_id;
								$push['firstname']        =  $flw_name;
								$push['profile_image']    =  $flw_image; 
								$push['chat_id']          =  $chat_id;
								$push['timezone']          =  $chat_zone;
					  }
				  }
				  elseif($usr_lst['chat_to']==$this->session->userdata('SESSION_USER_ID')){
					   if(!in_array($usr_lst['chat_from'],$to_user)){
						  $to_user[]=$usr_lst['chat_from'];
						  $queryuser   = $this->db->query("SELECT USERID,fullname,user_thumb_image,user_timezone FROM members WHERE USERID=".$usr_lst['chat_from']."");
						  $chat_data = $queryuser->row_array();
						  $flw_id        = $chat_data['USERID'];
						  $flw_name      = $chat_data['fullname'];
						  $flw_image     = $chat_data['user_thumb_image'];
						  $chat_zone     = $chat_data['user_timezone'];
						  $chat_id       = $usr_lst['id'];
						  $totres=1;
						  $push['user_id']          =  $flw_id;
								$push['firstname']        =  $flw_name;
								$push['profile_image']    =  $flw_image; 
								$push['chat_id']          =  $chat_id;
								$push['timezone']          =  $chat_zone;
					  }
				  }
				  
					if(!empty($push)) { 
								//$chk = $data['details'];
								$data['details'][] = $push;
								
									  
							} 
			 }
		 }
 		  //if(!empty($chat_counta)) $data['table_ids'] = $friends_ids;
 		  return $data;
    }
}

?>