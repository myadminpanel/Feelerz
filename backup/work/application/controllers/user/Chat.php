<?php

if (!defined('BASEPATH'))

    exit('No direct script access allowed');



class Chat extends CI_Controller {



    public $data;

   public $website_email;

    public function __construct() {

        parent::__construct();
        $this->load->helper('favourites');
    	$common_settings = gigs_settings();
    	$default_currency = 'USD';
        if(!empty($common_settings)){
          foreach($common_settings as $datas){
            if($datas['key']=='currency_option'){
             $default_currency = $datas['value'];
            }
         }
        }

        $this->load->helper('currency');
        $this->default_currency      = $default_currency;
        $this->default_currency_sign = currency_sign($default_currency);
        $this->smtp_config           = smtp_mail_config();


    	$query = $this->db->query("select * from system_settings WHERE status = 1");

		$result = $query->result_array();

		$this->email_address='mail@example.com';

		$this->email_tittle='Gigs';

		$this->logo_front=base_url().'assets/images/logo.png';

		if(!empty($result))

		{

		foreach($result as $data){

		if($data['key'] == 'email_address'){

		$this->email_address = !empty($data['value']) ?$data['value'] : 'mail@example.com' ;

		}

	   if($data['key'] == 'email_tittle'){

		$this->email_tittle = !empty($data['value']) ? $data['value'] : 'Gigs' ;

		}

		   if($data['key'] == 'base_domain'){

		$this->base_domain = $data['value'];

		}

		   if($data['key'] == 'logo_front'){

		$this->logo_front = base_url().$data['value'];

		}

		if($data['key'] == 'site_name' ||  $data['key'] == 'website_name'){

		$this->site_name = $data['value'];

		}

		}

		}

        $this->data['module'] = 'user';

		$this->load->model('user_panel_model');

		$this->load->model('templates_model');
		if(empty($this->session->userdata('timezone'))){
			$this->session->set_userdata('timezone','Asia/Kolkata');
		}
    }

    public function index() {  }

 	

	public function get_all_new_chats() { 

	  $new_chats = array(); 

	  if($this->session->userdata('SESSION_USER_ID'))

	  {					   

	   $chat_qry  = $this->db->query("SELECT id,chat_from,GROUP_CONCAT(content SEPARATOR '^') as contents,

									  GROUP_CONCAT(date_time SEPARATOR '^') as times,

									  CASE

											WHEN chat_type = 1 THEN (SELECT concat(u.USERID,'[^]',u.fullname,'[^]',u.user_thumb_image,'[^]',u.username,'[^]',u.user_timezone) FROM members u WHERE u.USERID = chat_from)

											ELSE ''

											END AS from_detail 

									  FROM chats WHERE  status = 0 and  chat_to = ".$this->session->userdata('SESSION_USER_ID')." AND to_delete_sts =0 group by chat_from order by id DESC");							   

   	   $chat_det  = $chat_qry->result_array(); 

	   $last_userid=0;

 	   $html_one ='';

	   $total=0;

	   

	   if(!empty($chat_det)){

	        foreach($chat_det as $key => $val){

 				$msg     = $tme = '';

 				$content = explode('^',$val['contents']);

				$times   = explode('^',$val['times']);

 				if(!empty($content)){ 

 					$msg = substr($content[count($content)-1], 0, 30);  

 				}

				else

				{

					$msg ='Receive an attachment';

				}

				$dets = explode('[^]',$val['from_detail']);
				$fromzone = end($dets);
				if(!empty($times)){ 
					$to_timezone =  $this->session->userdata('timezone');
					$UTC = new DateTimeZone($fromzone);
					$newTZ = new DateTimeZone($to_timezone);
					$match_date = new DateTime( $times[count($times)-1], $UTC );
					$match_date->setTimezone( $newTZ );
					$newtime = $match_date->format('h:i A');
					/*$date       = new DateTime();
					$match_date = new DateTime($times[count($times)-1]);*/

					$interval   = $match_date->diff($match_date);
					date_default_timezone_set($to_timezone); 

 					if($interval->days == 0) $tme = $newtime; // date(' h:i A',strtotime($val['times']));
 					else  $tme = $interval->days.' Days ago ';

 				} 

				$dets = explode('[^]',$val['from_detail']);

				if(!empty($dets)){ 

 					$html ='<span class="time-text pull-right"> '.$tme.'</span><span class="clear text-ellipsis text-xs">'.$msg.'</span>';	

								

 					$new_chats[$val['chat_from']] = $html;  

				}

 			}

 	   }

	   if(!empty($chat_det)){

	        foreach($chat_det as $key => $val){

 				$msg     = $tme = '';

 				$content = explode('^',$val['contents']);

				$times   = explode('^',$val['times']);

				$id      = $val['id'];

				$frm_user= $val['chat_from'];

 				if(!empty($content)){ 

 					$msg_one = substr($content[0], 0, 30);  

 				}

				else

				{

					$msg_one ='Receive an attachment';

				}

				if(!empty($times)){ 

 					/*$from_timezone =  $this->session->userdata('timezone');
                    
                    $newTZ = new DateTimeZone($from_timezone);
					
					$date->setTimezone( $newTZ );

 					$date       = new DateTime();

					$match_date = new DateTime($times[count($times)-1]);

					$interval   = $date->diff($match_date);

 					if($interval->days == 0) $tme = date(' h:i A',strtotime($val['times']));

 					else  $tme = $interval->days.' Days ago ';*/

 					$to_timezone =  $this->session->userdata('timezone');
					$UTC = new DateTimeZone($fromzone);
					$newTZ = new DateTimeZone($to_timezone);
					$match_date = new DateTime( $times[count($times)-1], $UTC );
					$match_date->setTimezone( $newTZ );
					$newtime = $match_date->format('h:i A');
					/*$date       = new DateTime();
					$match_date = new DateTime($times[count($times)-1]);*/

					$interval   = $match_date->diff($match_date);
					date_default_timezone_set($to_timezone); 

 					if($interval->days == 0) $tme = $newtime; //  date(' h:i A',strtotime($val['times']));
 					else  $tme = $interval->days.' Days ago ';

 				} 

				$dets = explode('[^]',$val['from_detail']);

				$link=base_url().'message';

				$prf_img1  = base_url().'assets/images/avatar2.jpg'; 

				$fullname = 'User';

			    if(!empty($dets[2])) $prf_img1 =  base_url().$dets[2];

				if(!empty($dets[1])) $fullname = $dets[1];

				if(!empty($dets)){ 

 					$html_one .='<li class="media notification-message">

								<a href="javascript:;" onclick="show_usermessage('.$id.', '.$frm_user.');">

									<div class="media-left">

										<img width="32" class="img-circle" src="'.$prf_img1.'" alt="'.$fullname.'">

									</div>

									<div class="media-body">

										<h4 class="notification-heading text-ellipsis"><strong>'.$fullname.'</strong> - <span class="text-gray">'.$msg_one.' </span></h4>

										<span class="notification-time">'.$tme.'</span>

									</div>

								</a>

							</li>';	

				}

				$total =$total +1;

 			}

 	   }

	  }

	   echo json_encode( array('new_chats'=>$new_chats,'new_chats_content'=>$html_one,'new_total'=>$total));

	   

 	}

	public function get_last_chat_user(){



		 $qry = $this->db->query("SELECT id,chat_from,chat_to FROM `chats` WHERE (chat_from= ".$this->session->userdata('SESSION_USER_ID')." and from_delete_sts=0) OR (chat_to= ".$this->session->userdata('SESSION_USER_ID')." and to_delete_sts =0) ORDER BY id DESC limit 1 ");

		 

		  $last_user  = $qry->row_array(); 

		  $last_userid=0;

		  if(count($last_user)>0)

		  {

			  if($last_user['chat_from']==$this->session->userdata('SESSION_USER_ID'))

			  {

			  $last_userid =$last_user['chat_to'];

			  }

			  if($last_user['chat_to']==$this->session->userdata('SESSION_USER_ID'))

			  {

			  $last_userid =$last_user['chat_from'];

			  }

		  }

		  echo json_encode( array('chat_id'=>$last_userid)); 

	}

	

	public function oposit_new_chat() { 

	 $html2='';

	   // echo 'this is new chat content';

	   $chat_id      = $this->input->post('chat_id');

	   $last_chat    = $this->input->post('last_chat'); 

 	   $chat_qry  = $this->db->query("SELECT  *,

									   CASE

											WHEN chat_type = 1 THEN (SELECT concat(u.USERID,'[^]',u.fullname,'[^]',u.user_thumb_image,'[^]',u.username) FROM members u WHERE u.USERID = chat_from)

											ELSE ''

											END AS from_detail 

									   FROM chats WHERE  chat_from   = ".$chat_id." and  chat_to = ".$this->session->userdata('SESSION_USER_ID')." and status=0  and to_delete_sts=0 and  id > ".$last_chat." 

									  order by  id desc");							  

 	   $chat_det  = $chat_qry->result_array(); 

	   $new_chats = array();

 	   if(!empty($chat_det)){

 		   foreach($chat_det as $key => $val){

			  $chat_user_prfs = 'assets/images/avatar2.jpg';

 			  $dets = explode('[^]',$val['from_detail']);

			  if(!empty($dets)){

				  if(!empty($dets[2])) $chat_user_prfs = $dets[2]; 

				  

							 $html = '<div class="chat chat-left last_chat_'.$val['id'].'" last_chat="'.$val['id'].'">

								   <div class="chat-avatar">

										<a class="avatar" href="'.base_url().'user-profile/'.$dets[3].'">

										  <img width="30" class="img-responsive img-circle" alt="Image" src="'.base_url().$chat_user_prfs.'">

										</a>

										</div>

										<div class="chat-body">

                  							<div class="chat-content">	';

										if($val['file_path']){

											$path=$val['file_path'];

											$str=explode(".",$val['file_path']);

											$strone=strtolower(end($str));

											$allowed =  array('gif','png' ,'jpg','jpeg');

											if(in_array($strone,$allowed) ) {

												$msg ='You received an attachment';

												$html .= '<span><a href="'.base_url().$path.'" target="_blank"><img height="100" width="110" src="'.base_url().$path.'"></a></span>';

											}

											else

											{

												$msg ='You received an attachment';

												$strpath=explode("/",$val['file_path']);

												$strpathone=strtolower(end($strpath));

												$html .= '<span><a href="'.base_url().$path.'" target="_blank">'.$strpathone.'</a></span>';

											}

										}	

										else{

										$msg =$val['content'];	

										$html .='<p>'.$val['content'].'</p>';

										}

										$html .='<span class="chat-time">'.date(' h:i A',strtotime($val['chat_to_time'])).'</span>

										</div>

									</div>

							 </div>';

				  $html2 ='<span class="time-text pull-right"> '.date(' h:i A',strtotime($val['chat_to_time'])).'</span><span class="clear text-ellipsis text-xs"> '.$msg.'</span>';

 				   $new_chats[$val['id']] = $html;

			  }

 		   }

 	   } 

			 

	  

 	   echo json_encode( array('new_chat'=>$new_chats,'left_content'=>$html2 ));

 	}

	



 	public function settings(){

 	    $this->db->select('key, value');

        $this->db->from('system_settings');

        $records = $this->db->get()->result_array();

        $array = array();

         foreach ($records as $value) {

            if($value['key']=='one_signal_subdomain'){

                $array['one_signal_subdomain'] = $value['value'];

            }

            if($value['key']=='one_signal_app_id'){

                $array['one_signal_app_id']  = $value['value'];

            }

            if($value['key']=='one_signal_reset_key'){

              $array['one_signal_reset_key'] = $value['value'];

            }

          }

        return $array;  

    }

    public function player_ids($userid){

    	 if(!empty($userid)){

        $query = $this->db->query("SELECT device_id,device FROM one_signal_device_ids WHERE user_id = $userid") ;

        if($query->num_rows() >0){

          $records = $query->row_array();

          return $records;

        }else{

          return '';

        }

      }

    }



	public function save_chat() { 

		

	  $html=''; 

  	  $chat_id      = $this->input->post('active_chat_id');
	  $content      = $this->input->post('chat_message_content');
	  $from_c_uid = $this->session->userdata('SESSION_USER_ID');
      $chat_type    = 1;
	  $chat_image    = $this->input->post('user_message_imgpath');
	 // $to_timezone    = $this->input->post('temp_chat_tz');
	  $qrystr         = $this->db->query("SELECT user_timezone FROM `members` WHERE USERID = ".$chat_id);
	  $chat_user_tz     = $qrystr->row();
	  $to_timezone    = $chat_user_tz->user_timezone;
	  date_default_timezone_set("UTC");
      $utc_time  = date('Y-m-d H:i:s');
 	  $from_timezone = $this->session->userdata('time_zone');
	  date_default_timezone_set($to_timezone); 
      $to_tz= date('Y-m-d H:i:s'); //Returns IST
	  date_default_timezone_set($from_timezone); 
      $from_tz= date('Y-m-d H:i:s'); //Returns IST
	  $current_time= date('Y-m-d H:i:s A');
	  $left_con='';
 	  if(count($chat_image)>0)

	  {
	  
		  $left_con='You sent an attachment.';

		 if(!empty($content)) {

		  $left_con='You sent a message with an attachment';	 

		  $data['chat_from']    = $this->session->userdata('SESSION_USER_ID');

		  $data['timezone'] = $this->session->userdata('time_zone');

		  $data['chat_utc_time']     = $utc_time;

		  $data['chat_to']      = $chat_id;

		  $data['content']      = $content; 

		  $data['file_path']    = ''; 

		  $data['chat_type']    = $chat_type; 

		  $data['date_time']    = $current_time; 

		  $data['chat_from_time']    = $from_tz; 

		  $data['chat_to_time']    = $to_tz; 



		  $this->db->insert('chats',$data);

		  $chat_tbl_id = $this->db->insert_id();

		  $qry         = $this->db->query("SELECT u.USERID,u.fullname,u.user_thumb_image,u.username 

										   FROM `members` u 

										   WHERE u.USERID = ".$this->session->userdata('SESSION_USER_ID')." ");

		  $login_user  = $qry->result_array();  

		  $prof_img    = 'assets/images/avatar2.jpg';

		  if($login_user[0]['user_thumb_image'] != '') $prof_img = $login_user[0]['user_thumb_image']; 

		  

				$html .= '<div class="chat last_chat_'.$chat_tbl_id.'" last_chat="'.$chat_tbl_id.'">

											<div class="chat-body">

											<div class="chat-content">

											

											<p>'.$content.'</p>';

											$html .= '<span class="chat-time"> '.date(' h:i A',strtotime($from_tz)).'</span>

											</div>

										</div>

								 </div>';

	  

		 }

	  foreach($chat_image as $path){

	  $data['chat_from']    = $this->session->userdata('SESSION_USER_ID');

	  $data['timezone'] = $this->session->userdata('time_zone');

	  $data['chat_to']      = $chat_id;

	  $data['content']      = ''; 

	  $data['file_path']    = $path; 

	  $data['chat_type']    = $chat_type; 

	  $data['chat_utc_time']     = $utc_time;

	  $data['date_time']    = $current_time; 

	  $data['chat_from_time']    = $from_tz; 

	  $data['chat_to_time']    = $to_tz; 

 	  $this->db->insert('chats',$data);

 	  $chat_tbl_id = $this->db->insert_id();

  	  $qry         = $this->db->query("SELECT u.USERID,u.fullname,u.user_thumb_image,u.username

	  								   FROM `members` u 

									   WHERE u.USERID = ".$this->session->userdata('SESSION_USER_ID')." ");

	  $login_user  = $qry->result_array();  

	  $prof_img    = 'assets/images/avatar2.jpg';

	  

	  if($login_user[0]['user_thumb_image'] != '') $prof_img = $login_user[0]['user_thumb_image']; 

	  

	  		$html .= '<div class="chat last_chat_'.$chat_tbl_id.'" last_chat="'.$chat_tbl_id.'">

										<div class="chat-body">

										<div class="chat-content">';

										if($chat_image){

										$str=explode(".",$path);

										$strone=strtolower(end($str));

										$allowed =  array('gif','png' ,'jpg','jpeg');

										if(in_array($strone,$allowed) ) {

										$html .= '<span><a href="'.base_url().$path.'" target="_blank"><img height="100" width="110" src="'.base_url().$path.'"></a></span>';

										}

										else

										{

											$strpath=explode("/",$path);

											$strpathone=strtolower(end($strpath));

											$html .= '<span><a href="'.base_url().$path.'" target="_blank">'.$strpathone.'</a></span>';

										}

										}

										$html .= '<span class="chat-time">'.date(' h:i A',strtotime($from_tz)).'</span>

										</div>

									</div>

							 </div>';

	  

	  }

	  }else{

	  $left_con=substr($content, 0, 30);	  
	  $data['chat_from']    = $this->session->userdata('SESSION_USER_ID');
	  $data['chat_to']      = $chat_id;
	  $data['content']      = $content; 
	  $data['timezone']     = $this->session->userdata('time_zone');
	  $data['file_path']    = ''; 
	  $data['chat_utc_time']     = $utc_time;
	  $data['chat_type']    = $chat_type; 
	  $data['date_time']    = $current_time; 
	  $data['chat_from_time']    = $from_tz; 
	  $data['chat_to_time']    = $to_tz; 
 	  $this->db->insert('chats',$data);
 	  $chat_tbl_id = $this->db->insert_id();
  	  $qry         = $this->db->query("SELECT u.USERID,u.fullname,u.user_thumb_image ,u.username FROM `members` u WHERE u.USERID = ".$this->session->userdata('SESSION_USER_ID')." ");

	  $login_user  = $qry->result_array();  
	  $prof_img    = 'assets/images/avatar2.jpg';
	  if($login_user[0]['user_thumb_image'] != '') $prof_img = $login_user[0]['user_thumb_image']; 
	  		$html .= '<div class="chat last_chat_'.$chat_tbl_id.'" last_chat="'.$chat_tbl_id.'">
										<div class="chat-body">
										<div class="chat-content">
										<p>'.$content.'</p>';
										$html .= '<span class="chat-time">'.date(' h:i A',strtotime($from_tz)).'</span>
										</div>
									</div>
							 </div>';
	  }

	 $html2 ='<span class="time-text pull-right"> '.date(' h:i A',strtotime($from_tz)).'</span><span class="clear text-ellipsis text-xs">You: '.$left_con.'</span>';

	 
	 $API_details  = $this->settings();
	 $include_player = $this->player_ids($chat_id);
 
	 $include_player_ids = (!empty($include_player['device_id']))?$include_player['device_id']:'';


	 if(!empty($include_player_ids)){
	 if($include_player['device']!='browser'){



	 	$query = $this->db->query("select IF(chat_utc_time!='0000-00-00 00:00:00',chat_utc_time,'' ) as chat_utc_time,M.fullname as from_name,M.user_thumb_image as from_user_image,M1.fullname as to_name,M1.user_thumb_image as to_user_image from chats AS C LEFT JOIN members AS M ON M.USERID = C.chat_from LEFT JOIN members AS M1 ON M1.USERID = C.chat_to where  chat_from = $from_c_uid and chat_to = $chat_id and id = $chat_tbl_id");

    

     $last_record = array();

    if($query->num_rows() > 0){

      $last_record = $query->row_array(); 

      $last_record['from_user_id'] = $from_c_uid;

      $last_record['to_user_id'] =$chat_id;

    }



	 if(!empty($API_details['one_signal_app_id']) && !empty($API_details['one_signal_reset_key'])){

	      $data = array();   

	      $data['user_id'] = $chat_id;

	      $data['message'] = $content;

	      $data['app_id'] = $API_details['one_signal_app_id'];

	      $data['reset_key'] = $API_details['one_signal_reset_key'];

	      $data['include_player_ids'] = $include_player_ids;

	      $data['additional_data'] = $last_record;

		  $result = send_message($data);

	    }
		 }
	 } 

	 // Stop Browser Notifications 
	 echo json_encode( array('right_content'=>$html,'left_content'=>$html2));

 	}

	public function chat_details_selctuser(){

		  

 	     $user_id = $this->input->post('user_id');

		 

 		 $chat_qry  = $this->db->query("SELECT *,

										CASE

											WHEN chat_type = 1 THEN (SELECT concat(u.USERID,'[^]',u.fullname,'[^]',u.user_thumb_image,'[^]',u.username) FROM members u WHERE u.USERID = chat_from)

											ELSE ''

											END AS from_detail,

										CASE

											WHEN chat_type = 1 THEN (SELECT concat(u.USERID,'[^]',u.fullname,'[^]',u.user_thumb_image,'[^]',u.username) FROM members u WHERE u.USERID = chat_to)

											ELSE ''

											END AS to_details

										FROM chats WHERE status=0 AND

									    (chat_from = ".$user_id." and chat_to = ".$this->session->userdata('SESSION_USER_ID')." and to_delete_sts=0 ) order by id ASC ");

	     $chat_det1  = $chat_qry->result_array(); 

		  //echo $this->db->last_query();exit;

  		 $html 	  = '';

		 if(!empty($chat_det1)){ 

			 

 			 foreach($chat_det1 as $key => $val){

				

				 if($val['chat_from'] != $this->session->userdata('SESSION_USER_ID')){

					$dets = explode('[^]',$val['from_detail']);

					if(!empty($dets)){

					$prf_img = 'assets/images/avatar2.jpg'; 

			        if(!empty($dets[2])) $prf_img = $dets[2];

					$html .= '<div class="chat chat-left last_chat_'.$val['id'].'" last_chat="'.$val['id'].'">

								   <div class="chat-avatar">

										<a class="avatar" href="'.base_url().'user-profile/'.$dets[3].'">

										  <img width="30" class="img-responsive img-circle" alt="Image" src="'.base_url().$prf_img.'">

										</a>

										</div>

										<div class="chat-body">

                  							<div class="chat-content">';	

											if($val['file_path']){

												$path=$val['file_path'];

												$str=explode(".",$path);

												$strone=strtolower(end($str));

												$allowed =  array('gif','png' ,'jpg','jpeg');

												if(in_array($strone,$allowed) ) {

												$html .= '<span><a href="'.base_url().$path.'" target="_blank"><img height="100" width="110" src="'.base_url().$path.'"></a></span>';

												}

												else

												{

												$strpath=explode("/",$path);

												$strpathone=strtolower(end($strpath));

												$html .= '<span><a href="'.base_url().$path.'" target="_blank">'.$strpathone.'</a></span>';

												}

											}

											else{

												$html .='<p>'.$val['content'].'</p>';

											}

											$html .='<span class="chat-time">'.date(' h:i A',strtotime($val['chat_to_time'])).'</span>

										</div>

									</div>

								

							 </div>';

							 

							  

					}

				 }     

				 if($val['chat_to'] == $this->session->userdata('SESSION_USER_ID') && $val['status'] == 0){

					 $data_up['status'] = 1;

					 $this->db->update('chats',$data_up,array('id'=>$val['id']));

				 } 

		 }

		 }

		 

	   echo json_encode( array('content'=>$html)); 

 	

	}

     public function chat_details() {  

	 

	    $new_zone= $this->session->userdata('time_zone');

		$old_zone= $this->session->userdata('old_timezone');

	     if( $new_zone != $old_zone)		 

		 {

			  $czq=$this->db->query("SELECT id,chat_from, chat_to,chat_from_time,chat_to_time FROM chats WHERE (chat_from = ".$this->session->userdata('SESSION_USER_ID')." and from_delete_sts=0) OR 

									    (chat_to = ".$this->session->userdata('SESSION_USER_ID')." and to_delete_sts=0 )");

		  $chat_zone  = $czq->result_array();

		   if($chat_zone)

		   {

			   foreach($chat_zone as $tval)

			   {

				   if($tval['chat_from'] == $this->session->userdata('SESSION_USER_ID'))

				   {

					    $date = new DateTime($tval['chat_from_time'], new DateTimeZone($old_zone));

			 			$date->setTimezone(new DateTimeZone($new_zone));

						$tz_fr['chat_from_time']    = $date->format('Y-m-d H:i:s');

						$this->db->update('chats',$tz_fr,array('id'=> $tval['id']));

				   }else if($tval['chat_to'] == $this->session->userdata('SESSION_USER_ID'))

				   {

					   	$date = new DateTime($tval['chat_to_time'], new DateTimeZone($old_zone));

			 			$date->setTimezone(new DateTimeZone($new_zone));

					   	$tz_to['chat_to_time']    =$date->format('Y-m-d H:i:s');

					    $this->db->update('chats',$tz_to,array('id'=> $tval['id']));

				   }

			   }

		   }

			 $this->session->set_userdata('old_timezone', $new_zone);

		 }

 	     $user_id = $this->input->post('user_id');

		 $list_number = $this->input->post('group_no');

		 $limit = 20;

		 $offset = 0;

		 $stq=$this->db->query("SELECT id FROM chats WHERE (chat_from = ".$this->session->userdata('SESSION_USER_ID')." and chat_to = ".$user_id." and from_delete_sts=0) OR 

									    (chat_from = ".$user_id." and chat_to = ".$this->session->userdata('SESSION_USER_ID')." and to_delete_sts=0 )");

		  $chat_count  = $stq->num_rows();

		  $chat_count = ceil($chat_count / $limit); 

 		 $chat_qry  = $this->db->query("SELECT *,

										CASE

											WHEN chat_type = 1 THEN (SELECT concat(u.USERID,'[^]',u.fullname,'[^]',u.user_thumb_image,'[^]',u.username) FROM members u WHERE u.USERID = chat_from)

											ELSE ''

											END AS from_detail,

										CASE

											WHEN chat_type = 1 THEN (SELECT concat(u.USERID,'[^]',u.fullname,'[^]',u.user_thumb_image,'[^]',u.username) FROM members u WHERE u.USERID = chat_to)

											ELSE ''

											END AS to_details

										FROM chats WHERE (chat_from = ".$this->session->userdata('SESSION_USER_ID')." and chat_to = ".$user_id." and from_delete_sts=0) OR 

									    (chat_from = ".$user_id." and chat_to = ".$this->session->userdata('SESSION_USER_ID')." and to_delete_sts=0 ) order by id DESC limit " .$offset.",".$limit);

	     $chat_det_one  = $chat_qry->result_array(); 

		 $chat_det = $this->array_orderby($chat_det_one, 'id', SORT_ASC);

		  //echo $this->db->last_query();exit;

  		 $html 	  = '';

		 $user_content='';

		 $c_datecheck=array(); 

		 if(!empty($chat_det)){ 

			 

 			 foreach($chat_det as $key => $val){

				 if(!in_array(date("Y-m-d", strtotime($val['date_time'])),$c_datecheck)){

					 $ldate =date('Y-m-d',strtotime($val['date_time'])); 

			 		$html .= '<div class="text-center chat-date setchat-date_'.$ldate.'" last-date="'.$ldate.'"><span>'.date('j F Y',strtotime($val['date_time'])).'</span></div>';

			  		$c_datecheck[]= date("Y-m-d", strtotime($val['date_time']));

				 }

				 if($val['chat_from'] == $this->session->userdata('SESSION_USER_ID')){

					$dets = explode('[^]',$val['from_detail']);                                         

					if(!empty($dets)){

					$prf_img = 'assets/images/avatar2.jpg'; 

			        if(!empty($dets[2])) $prf_img = $dets[2]; 

					

					$html .= '<div class="chat last_chat_'.$val['id'].'" last_chat="'.$val['id'].'">

										<div class="chat-body">

										<div class="chat-content">';

										if($val['file_path']){

											$path=$val['file_path'];

										$str=explode(".",$val['file_path']);

										$strone=strtolower(end($str));

										$allowed =  array('gif','png' ,'jpg','jpeg');

										if(in_array($strone,$allowed) ) {

										$html .= '<span><a href="'.base_url().$path.'" target="_blank"><img height="100" width="110" src="'.base_url().$path.'"></a></span>';

										}

										else

										{

											$strpath=explode("/",$val['file_path']);

											$strpathone=strtolower(end($strpath));

											$html .= '<span><a href="'.base_url().$path.'" target="_blank">'.$strpathone.'</a></span>';

										}

										}	

										else{

										$html .='<p>'.$val['content'].'</p>';

										}

										

										$html .='<span class="chat-time">'.date('h:i A',strtotime($val['chat_from_time'])).'</span>

										</div>

									</div>

							 </div>';

					

					}

				 }

				

				 if($val['chat_from'] != $this->session->userdata('SESSION_USER_ID')){

					$dets = explode('[^]',$val['from_detail']);

					if(!empty($dets)){

					$prf_img = 'assets/images/avatar2.jpg'; 

			        if(!empty($dets[2])) $prf_img = $dets[2];

					$html .= '<div class="chat chat-left last_chat_'.$val['id'].'" last_chat="'.$val['id'].'">

								   <div class="chat-avatar">

										<a class="avatar" href="'.base_url().'user-profile/'.$dets[3].'">

										  <img width="30" class="img-responsive img-circle" alt="Image" src="'.base_url().$prf_img.'">

										</a>

										</div>

										<div class="chat-body">

                  							<div class="chat-content">';	

											if($val['file_path']){

												$path=$val['file_path'];

												$str=explode(".",$path);

												$strone=strtolower(end($str));

												$allowed =  array('gif','png' ,'jpg','jpeg');

												if(in_array($strone,$allowed) ) {

												$html .= '<span><a href="'.base_url().$path.'" target="_blank"><img height="100" width="110" src="'.base_url().$path.'"></a></span>';

												}

												else

												{

												$strpath=explode("/",$path);

												$strpathone=strtolower(end($strpath));

												$html .= '<span><a href="'.base_url().$path.'" target="_blank">'.$strpathone.'</a></span>';

												}

											}

											else{

												$html .='<p>'.$val['content'].'</p>';

											}

											$html .='<span class="chat-time">'.date(' h:i A',strtotime($val['chat_to_time'])).'</span>

										</div>

									</div>

								

							 </div>';

					}

				 }     

				 if($val['chat_to'] == $this->session->userdata('SESSION_USER_ID') && $val['status'] == 0){

					 $data_up['status'] = 1;

					 $this->db->update('chats',$data_up,array('id'=>$val['id']));

				 } 

		 }

			 $html_sts = 0;

		 }else {

			$html_sts = 1;

		     $html = '<p style="color: red"> &nbsp; &nbsp; No Chats Availabe </p>';	 

 		 }

		 

            $user_details = $this->user_panel_model->get_user_data($user_id);

			if($user_details['user_thumb_image']){

				$set_img=base_url().$user_details['user_thumb_image'];

			}

			else

			{

				$set_img=base_url().'assets/images/avatar2.jpg';

			}

			$user_linkone=base_url().'user-profile/'.$user_details['username'];

			

			

			

			

		 $user_content='<div class="msg-user-details">

            

            <div class="pull-left user-img" style="margin-right: 10px;">

                <a href="'.$user_linkone.'"><img src="'.$set_img.'" alt="" class="w-40 img-circle"></a>

            </div>

            <div class="user-info pull-left">

                <div class="dropdown">                               

                <a href="'.$user_linkone.'"><span >'.ucfirst($user_details['fullname']).'</span></a>

                </div>

                <p class="text-muted m-0">'.$user_details['country'].'</p>

            </div>

            </div>

            <ul class="user-menu nav navbar-nav navbar-right pull-right">

                        <li class="dropdown">

                         <!-- <a href="" class="dropdown-toggle profile" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-ellipsis-v"></i></a>-->

                            <ul class="dropdown-menu" >

                            <li><a href="javascript:void(0)" onclick="delete_conversation('.$user_id.')" id="delete_conversations_id">Delete Conversations</a></li>

                            </ul>

                        </li>

                    </ul></div>';

 	  //echo $html;
             $this->db->select('status');       
             $this->db->where('USERID', $user_id);
             $user_status = $this->db->get('members')->row();
             $user_status = $user_status->status;

	   echo json_encode( array('top_content'=>$user_content,'bottom_content'=>$html,'chat_count'=>$chat_count,'flag'=>$html_sts,'user_status'=>$user_status)); 

 	}

	public function load_morechats()

	{

 	     $user_id = $this->input->post('user_id');

		 $list_number = $this->input->post('group_no');

		 $get_id = $this->input->post('last_id');

		 $limit = 20;

		 $offset = 0;

		 $stq=$this->db->query("SELECT id FROM chats WHERE (chat_from = ".$this->session->userdata('SESSION_USER_ID')." and chat_to = ".$user_id." and from_delete_sts=0) OR 

									    (chat_from = ".$user_id." and chat_to = ".$this->session->userdata('SESSION_USER_ID')." and to_delete_sts=0 )");

		  $chat_count  = $stq->num_rows();

		  $chat_count = ceil($chat_count / $limit); 

		  $wheregetid=''; 

		  if($get_id)

		  {

			  $wheregetid=' and id<'.$get_id;

			  

		  }

 		 $chat_qry  = $this->db->query("SELECT *,

										CASE

											WHEN chat_type = 1 THEN (SELECT concat(u.USERID,'[^]',u.fullname,'[^]',u.user_thumb_image,'[^]',u.username) FROM members u WHERE u.USERID = chat_from)

											ELSE ''

											END AS from_detail,

										CASE

											WHEN chat_type = 1 THEN (SELECT concat(u.USERID,'[^]',u.fullname,'[^]',u.user_thumb_image,'[^]',u.username) FROM members u WHERE u.USERID = chat_to)

											ELSE ''

											END AS to_details

										FROM chats WHERE (chat_from = ".$this->session->userdata('SESSION_USER_ID')." and chat_to = ".$user_id." and from_delete_sts=0".$wheregetid.") OR 

									    (chat_from = ".$user_id." and chat_to = ".$this->session->userdata('SESSION_USER_ID')." and to_delete_sts=0".$wheregetid." ) order by id DESC limit " .$offset.",".$limit);

	     $chat_det_one  = $chat_qry->result_array(); 

		 $chat_det = $this->array_orderby($chat_det_one, 'id', SORT_DESC);

		  //echo $this->db->last_query();exit;

  		 $html 	  = '';

		 $main_array =array();

		 if(!empty($chat_det)){ 

			 

 			 foreach($chat_det as $key => $val){

				 $html ='';

				

				 if($val['chat_from'] == $this->session->userdata('SESSION_USER_ID')){

					$dets = explode('[^]',$val['from_detail']);

					if(!empty($dets)){

					$prf_img = 'assets/images/avatar2.jpg'; 

			        if(!empty($dets[2])) $prf_img = $dets[2]; 

					

					$html = '<div class="chat last_chat_'.$val['id'].'" last_chat="'.$val['id'].'">

										<div class="chat-body">

										<div class="chat-content">';

										if($val['file_path']){

											$path=$val['file_path'];

										$str=explode(".",$val['file_path']);

										$strone=strtolower(end($str));

										$allowed =  array('gif','png' ,'jpg','jpeg');

										if(in_array($strone,$allowed) ) {

										$html .= '<span><a href="'.base_url().$path.'" target="_blank"><img height="100" width="110" src="'.base_url().$path.'"></a></span>';

										}

										else

										{

											$strpath=explode("/",$val['file_path']);

											$strpathone=strtolower(end($strpath));

											$html .= '<span><a href="'.base_url().$path.'" target="_blank">'.$strpathone.'</a></span>';

										}

										}	

										else{

										$html .='<p>'.$val['content'].'</p>';

										}

										$html .='<span class="chat-time">'.date('h:i A',strtotime($val['chat_from_time'])).'</span>

										</div>

									</div>

							 </div>';

					}

				 }

				

				 if($val['chat_from'] != $this->session->userdata('SESSION_USER_ID')){

					$dets = explode('[^]',$val['from_detail']);

					if(!empty($dets)){

					$prf_img = 'assets/images/avatar2.jpg'; 

			        if(!empty($dets[2])) $prf_img = $dets[2];

					$html = '<div class="chat chat-left last_chat_'.$val['id'].'" last_chat="'.$val['id'].'">

								   <div class="chat-avatar">

										<a class="avatar" href="'.base_url().'user-profile/'.$dets[3].'">

										  <img width="30" class="img-responsive img-circle" alt="Image" src="'.base_url().$prf_img.'">

										</a>

										</div>

										<div class="chat-body">

                  							<div class="chat-content">';	

											if($val['file_path']){

												$path=$val['file_path'];

												$str=explode(".",$path);

												$strone=strtolower(end($str));

												$allowed =  array('gif','png' ,'jpg','jpeg');

												if(in_array($strone,$allowed) ) {

												$html .= '<span><a href="'.base_url().$path.'" target="_blank"><img height="100" width="110" src="'.base_url().$path.'"></a></span>';

												}

												else

												{

												$strpath=explode("/",$path);

												$strpathone=strtolower(end($strpath));

												$html .= '<span><a href="'.base_url().$path.'" target="_blank">'.$strpathone.'</a></span>';

												}

											}

											else{

												$html .='<p>'.$val['content'].'</p>';

											}

											$html .='<span class="chat-time">'.date(' h:i A',strtotime($val['chat_to_time'])).'</span>

										</div>

									</div>

								

							 </div>';

							 

							  

					}

				 }     

				 if($val['chat_to'] == $this->session->userdata('SESSION_USER_ID') && $val['status'] == 0){

					 $data_up['status'] = 1;

					 $this->db->update('chats',$data_up,array('id'=>$val['id']));

				 } 

				 $main_array[] = array(

								   "content"=>$html,

								   "user_date"=> date("Y-m-d", strtotime($val['date_time'])),

								   "date_str"=>date('j F Y',strtotime($val['date_time']))

								);

		 }

			 $html_sts = 0;

		 }else {

			$html_sts = 1;

		     $html = '<p style="color: red"> &nbsp; &nbsp; No Chats Availabe </p>';	 

 		 }

		 

           

		

 	  //echo $html;

	   echo json_encode( array('bottom_content'=>$main_array,'chat_count'=>$chat_count,'flag'=>$html_sts)); 

 	

	}

	public function delete_conversation() { 

  	  $chat_id      = $this->input->post('user_id');

	  if($chat_id ){

		  $data_p['from_delete_sts']=1;

		  $data_q['to_delete_sts'] =1;

		  $this->db->update('chats',$data_q, array('chat_from' => $chat_id ,'chat_to' => $this->session->userdata('SESSION_USER_ID')));

		  $this->db->update('chats', $data_p, array('chat_to' => $chat_id ,'chat_from' => $this->session->userdata('SESSION_USER_ID'))); 

		  echo 1;

	  }

	  else

	  {

		  echo 2;

	  }

	}

	function array_orderby()

    { 

	   $args = func_get_args();

	   $data = array_shift($args);

	   foreach ($args as $n => $field) {

		   if (is_string($field)) {

			   $tmp = array();

			   foreach ($data as $key => $row)

				   $tmp[$key] = $row[$field];

			   $args[$n] = $tmp;

			   }

	   }

	   $args[] = &$data;

	   call_user_func_array('array_multisort', $args);

	   return array_pop($args);

    }

	function save_buyerchat()

	{

	  $chat_id      = $this->input->post('sell_gigs_userid');

	  $content      = $this->input->post('chat_message_content');           

	  $chat_type    = 1;

	 // $to_timezone    = $this->input->post('temp_chat_tz');

	  $qrystr         = $this->db->query("SELECT user_timezone FROM `members` WHERE USERID = ".$chat_id);

	  $chat_user_tz     = $qrystr->row();

	  $to_timezone    = $chat_user_tz->user_timezone;   

	  $from_timezone = $this->session->userdata('time_zone');
	  
	  date_default_timezone_set("UTC");
      $utc_time  = date('Y-m-d H:i:s');

	  date_default_timezone_set($to_timezone); 

      $to_tz= date('Y-m-d H:i:s'); //Returns IST

	   date_default_timezone_set($from_timezone); 

       $from_tz= date('Y-m-d H:i:s'); //Returns IST

	   $current_time= date('Y-m-d H:i:s');

	     

	  	  $data['chat_from']    = $this->session->userdata('SESSION_USER_ID');

		  $data['chat_to']      = $chat_id;

		  $data['content']      = $content; 

		  $data['chat_utc_time']     = $utc_time;

		  $data['timezone'] = $this->session->userdata('time_zone');
		  
		  $data['file_path']    = ''; 

		  $data['chat_type']    = $chat_type; 

		  $data['date_time']    = $current_time; 

		  $data['chat_from_time']    = $from_tz; 

		  $data['chat_to_time']    = $to_tz; 

		  if($this->db->insert('chats',$data)){

			  $users_tbl_id  = 	$this->db->insert_id();

			  $query = $this->db->query("SELECT m.fullname as buyername,m.username as buyerusername, sm.fullname as sellername,sm.username as sellerusername,  sm.email as selleremail

			  		FROM `chats` as py

					LEFT JOIN members as m ON m.USERID = py.chat_from

					LEFT JOIN members as sm ON sm.USERID = py.chat_to

					WHERE py.`id` = $users_tbl_id");

				$data_one = $query->row_array();

				$to_email= $data_one['selleremail'];

				$bodyid = 23;

				$tempbody_details= $this->templates_model->get_usertemplate_data($bodyid);

				$body=$tempbody_details['template_content'];

				$message='';

				$user_profile_link  = base_url().'user-profile/'.$data_one['buyerusername'];

				$message_link = base_url().'message';

				//$body = str_replace('{PAYPAL_ID}', $order_id, $body);

				$body = str_replace('{base_url}', $this->base_domain, $body);

				$body = str_replace('{user_profile_link}', $user_profile_link, $body);		 

				$body = str_replace('{from_username}', $data_one['buyername'], $body);

				$body = str_replace('{to_username}', $data_one['sellername'], $body);

				$body = str_replace('{message_link}', $message_link, $body);

				$body = str_replace('{site_name}',$this->site_name, $body);

				                    $message ='<table style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">

								<tr>

									<td></td>

									<td width="600" style="box-sizing: border-box; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">

										<div style="box-sizing: border-box; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">

											<table width="100%" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;" bgcolor="#fff">

												<tr>

													<td style="box-sizing: border-box; vertical-align: top; text-align: left; margin: 0; padding: 20px;" valign="top">

														<table width="100%" cellpadding="0" cellspacing="0">

															<tr>

																<td style="text-align:center;">

																	<a href="{base_url}" target="_blank"><img src="'.$this->logo_front.'" style="width:90px" /></a>

																</td>

															</tr>

															<tr>

																<td>'.$body.'</td>

															</tr>

														</table>

													</td>

												</tr>

											</table>

											<div style="box-sizing: border-box; width: 100%; clear: both; color: #999; margin: 0; padding: 15px 15px 0 15px;">

												<table width="100%">

													<tr>

														<td style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0;" align="center" valign="top">

															&copy; '.date("Y").' <a href="'.$this->base_domain.'" target="_blank" style="color:#bbadfc;" target="_blank">'.$this->site_name.'</a> All Rights Reserved.

														</td>

													</tr>

												</table>

											</div>

										</div>

									</td>

								</tr>

							</table>';  

				// $this->load->helper('file');  

				// $this->load->library('email');
				// $this->email->initialize($this->smtp_config);
				// $this->email->set_newline("\r\n");

				// $this->email->from($this->email_address,$this->email_tittle); 

				// $this->email->to($to_email); 

				// $this->email->subject('Received message from '.$data_one['buyername']);

				// $this->email->message($message);



				$email_id=$to_email;
                                 $this->load->view("email/send",array("email"=>@$email_id,"subject"=>'Received message from '.$data_one['buyername'],"mess"=>$message));

echo 1;
				// if($this->email->send()){

			 //  		echo 1;

				// }else{

				// 	echo 1;

				// }

		  }

		  else

		  {

			  echo 2;

		  }

	}

	 

}

 

