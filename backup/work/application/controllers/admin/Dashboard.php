<?php
class Dashboard extends CI_Controller{
    public function __construct(){    
    parent::__construct();
    error_reporting(0);
    $this->data['theme'] = 'admin';
    $this->data['module'] = 'dashboard';
    $this->load->model('admin_login_model');    
    $this->load->model('admin_panel_model');
	$this->data['rupee_dollar_rate']        = 	$this->admin_panel_model->get_rupee_dollar_rate(); 
	$this->data['price_of_gig']        = 	$this->admin_panel_model->gig_price();	
	$rupee_dollar_rate 						= $this->data['rupee_dollar_rate'];
	 $this->load->helper('ckeditor'); 
		$this->data['ckeditor_editor1'] = array
		(
			//id of the textarea being replaced by CKEditor
			'id'   => 'ck_editor_textarea_id',
 			// CKEditor path from the folder on the root folder of CodeIgniter
			'path' => 'assets/js/ckeditor',
			//theme/
 			// optional settings
			'config' => array
			(
				'toolbar' => "Full",
				'filebrowserBrowseUrl'      => base_url().'assets/js/ckfinder/ckfinder.html',
				'filebrowserImageBrowseUrl' => base_url().'assets/js/ckfinder/ckfinder.html?Type=Images',
				'filebrowserFlashBrowseUrl' => base_url().'assets/js/ckfinder/ckfinder.html?Type=Flash',
				'filebrowserUploadUrl'      => base_url().'assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
				'filebrowserImageUploadUrl' => base_url().'assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
				'filebrowserFlashUploadUrl' => base_url().'assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
			)
		);
	if(($this->session->userdata('admin_time_zone')))
     {     

        $this->data['time_zone'] = $this->session->userdata('admin_time_zone');        
        $this->data['full_country_name'] = $this->session->userdata('admin_full_country_name');        
        $this->data['country_name'] = $this->session->userdata('admin_country_name');                 
       $this->data['dollar_rate'] 			=  $rupee_dollar_rate['dollar_rate'] ;  
        $this->data['rupee_rate']  			=  $rupee_dollar_rate['indian_rate']; 
		$this->session->set_userdata('dollar_rate',$this->data['dollar_rate']); 
		$this->session->set_userdata('rupee_rate',$this->data['rupee_rate']);
        }        
        else             
        {
        $user_ip = getenv('REMOTE_ADDR');    
        	//$user_ip = '59.97.116.168';
        @$geo = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=$user_ip"));              
		$geoplugin_latitude = $geo["geoplugin_latitude"];	
        $geoplugin_longitude = $geo["geoplugin_longitude"];
        $t=time();
        $result = $this->getTimezoneGeo($geoplugin_latitude,$geoplugin_longitude,$t);
        $this->data['time_zone'] = $result;        
        $this->data['full_country_name'] = $geo['geoplugin_countryName'];    
        $this->data['country_name'] = $geo['geoplugin_countryCode'];        
        /*$this->data['dollar_rate'] = $geo['geoplugin_currencyConverter'];  
		$this->session->set_userdata('dollar_rate',$this->data['dollar_rate']); 
        $this->data['rupee_rate'] = ( 1 / $this->data['dollar_rate']);  
		$this->session->set_userdata('rupee_rate',$this->data['rupee_rate']);*/
		$this->data['dollar_rate'] 			=  $rupee_dollar_rate['dollar_rate'] ;  
        $this->data['rupee_rate']  			=  $rupee_dollar_rate['indian_rate']; 
		$this->session->set_userdata('dollar_rate',$this->data['dollar_rate']); 
		$this->session->set_userdata('rupee_rate',$this->data['rupee_rate']);
        $newdata = array(
        'admin_country_name'  => $geo['geoplugin_countryCode'],
        'admin_time_zone'     => $result,
        'admin_full_country_name' => $geo['geoplugin_countryName'] 
        );
        $this->session->set_userdata($newdata);                            
  	 }	
	if(!$this->session->userdata('copy_right_year'))
		{
			$result = $this->admin_panel_model->copy_right_year();
			$this->session->set_userdata('copy_right_year',$result['value']);
		}
    }
	function getTimezoneGeo($geoplugin_latitude, $geoplugin_longitude,$t) {
    @$json = file_get_contents("https://maps.googleapis.com/maps/api/timezone/json?location=$geoplugin_latitude,$geoplugin_longitude&timestamp=$t&key=AIzaSyCrF-ZcLpYjLO7ygnisZJk_eHogmlzawwE ");     
    $data = json_decode($json,true);  
    $tzone=$data['timeZoneId'];      
    return $tzone;
    }
	public function delete_seo_setting()
	{
		$seo_id =  $this->input->post('seo_id');    
		$result=$this->admin_panel_model->delete_seo_setting($seo_id);
		if($result >0){
			echo 1;
		}else{
			echo 2;
		}	
	}
		public function terms()
	{	
	    $this->data['module'] = 'terms';
	    $this->load->model('admin_panel_model');	
	     $this->data['lists'] = $this->admin_panel_model->get_terms();
	    $this->data['page'] = 'index';        
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');
	}
			public function termsedit($id)
	       {	
	    $this->data['module'] = 'terms';
		 $this->load->model('admin_panel_model');	
	    $this->data['datalist'] = $this->admin_panel_model->edit_terms($id);
        if($this->input->post('form_submit'))
        {
            $value = $this->input->post('sub_menu');                                         
            $data['footer_submenu'] = str_replace(' ','_',$value);
            $data['page_desc'] = $this->input->post('page_desc');
            $this->db->where('id',$id);
            if($this->db->update('term',$data))
            {
					  $message="<div class='alert alert-success text-center fade in' id='flash_succ_message'>Terms edited successfully.</div>";
			      
            }
			   $this->session->set_flashdata('message',$message);
                redirect(base_url().'admin/dashboard/terms/');
	    
	}
	$this->data['page'] = 'edit';        
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');
		   }
			public function termcreate()
	{	
	    $this->data['module'] = 'terms';
		 if($this->input->post('form_submit'))
        {
            $value = $this->input->post('sub_menu');                                         
            $data['footer_submenu'] = str_replace(' ','_',$value);
            $data['page_desc'] = $this->input->post('page_desc');
            if($this->db->insert('term',$data))
            {
				$message="<div class='alert alert-success text-center fade in' id='flash_succ_message'>Terms created successfully.</div>";
            }
			$this->session->set_flashdata('message',$message);
                redirect(base_url().'admin/dashboard/terms');
        }
	    $this->data['page'] = 'create';        
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');
	}
		public function create()
	{
			if($this->input->post('form_submit'))		
		{
	$data['title']=$this->input->post('TermsTitle');
		    $data['description']=	$this->input->post('page_desc');
			$data['status']=$this->input->post('status');
			$this->db->insert('terms',$data);
		}
	    $this->data['page'] = 'create';        
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');
	}
		public function update_gig_status()
	{
		 $id = $this->input->post('gig_id');
		$status = $this->input->post('update_status');
		$update_data['status'] = $status;
      $data=$this->db->query("select * from crasol where item_id='".$id."'");
      $package=$this->db->query("select * from sell_gigs where id='".$id."'");
      $package1=$package->row_array();
    $data2=$data->row_array();
    if($data2)
    {
    	$this->db->query("UPDATE `crasol` SET `status` = '".$status."' WHERE type='package' and item_id = ".$id." ");
    }
    else
    {
    $this->db->query("INSERT INTO crasol(item_name, type, date, item_id, status) VALUES ('".implode(" ",explode("-", $package1["title"]))."','package','".date("d-m-Y")."','".$id."','".$status."')"); 
    }

		$this->db->query(" UPDATE `sell_gigs` SET `status` = ".$status." WHERE `id` = ".$id." ");
	}
    public function index()
	{      
		$data['user_timezone']   = $this->data['time_zone'] ;
                                               
        date_default_timezone_set($data['user_timezone']);
        $times=strtotime(date('d-M-Y'));
    		$this->data['new_escort']  = $this->admin_panel_model->dashboard_new_escort($times);
		$this->data['popular_orders']  = $this->admin_panel_model->dashboard_popular_gigs();
		$this->data['dashboard_details']  = $this->admin_panel_model->dashboard_details();		
        $this->data['page'] = 'index';        
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');
	}
	public function catagorycheck()
	{
		$category_name =  $this->input->post('category_name');    
		$catagory_id =  $this->input->post('catagory_id');    
		$result = $this->admin_panel_model->catagorycheck($category_name,$catagory_id );
		 if ($result > 0) {
				 $isAvailable = FALSE;
		   } else {               
					 $isAvailable = TRUE;
		   }
		   
		   echo json_encode(
				   array(
						   'valid' => $isAvailable
				   ));
	}
	public function is_valid_login()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');    
		// var_dump($password);
		$result = $this->admin_login_model->is_valid_login($username,$password); 
		// var_dump($this->db);  
		if(!empty($result))
		{        		 
			$this->session->set_userdata('id',$result['ADMINID']);  
			$this->session->set_userdata('SESSION_USER_ID',$result['ADMINID']);  
			$this->session->set_userdata('user_role',$result['user_role']);   
			$site_name = $this->admin_panel_model->site_name();          
			$this->session->set_userdata('sitename',$site_name['value']);
			echo 1;
		}
	 else 
		{ 
			echo 2;
			$this->session->set_flashdata('message','wrong login credential.');
		}

	}
	public function check_existing_ip()
	{
		$ip_addr = $this->input->post('ip_addr');   
		$result = $this->admin_panel_model->check_ip($ip_addr);     
		if ($result > 0) {
				   $isAvailable = FALSE;
		   } else {
				   $isAvailable = TRUE;
		   }
		   
		   echo json_encode(
				   array(
						   'valid' => $isAvailable
				   ));
	}

	public function check_old_password()
	{
		$id = $this->session->userdata['id'];
		$password = $this->input->post('old_password');     
		$result = $this->admin_login_model->is_valid_password($id,$password);
		 if ($result > 0) {
				   $isAvailable = TRUE;
		   } else {
				   $isAvailable = FALSE;
		   }
		   
		   echo json_encode(
				   array(
						   'valid' => $isAvailable
				   ));
	}

	public function check_footer_menu()
	{
		$menu_name =  $this->input->post('menu_name');    
		$result = $this->admin_panel_model->is_valid_menu_name($menu_name);
		 if ($result > 0) {
				 $isAvailable = FALSE;
		   } else {               
					 $isAvailable = TRUE;
		   }
		   
		   echo json_encode(
				   array(
						   'valid' => $isAvailable
				   ));
	}
    
	public function check_footer_submenu()
	{
		$menu_name =  $this->input->post('menu_name');    
		$result = $this->admin_panel_model->is_valid_submenu($menu_name);
		 if ($result > 0) {
				 $isAvailable = FALSE;
		   } else {               
					 $isAvailable = TRUE;
		   }
		   
		   echo json_encode(
				   array(
						   'valid' => $isAvailable
				   ));
	}
 	public function logout() 
	{
        if (!empty($this->session->userdata['id'])) 
            {
	            $this->session->unset_userdata('id');
	            $this->session->unset_userdata('user_role');
	            $this->session->unset_userdata('SESSION_USER_ID');
            }
        redirect(base_url($this->data['theme']));
    }
	public function get_all_notification()
	{
		$updates = $this->admin_panel_model->get_updates();
        $result = $this->admin_panel_model->new_notification();
        $html = '';
				$paymenthtml= $otherhtml = '';
		       $paymentcount= $othercount = 0;
		$total_count=0;
    	if(!empty($result))
		{
			$total_count =count($result);
			$time_zone = $this->session->userdata('time_zone');  
			foreach($result as $notifications)
			{   
				  $date = new DateTime($notifications['created_date']);
					//$date->setTimezone(new DateTimeZone($time_zone));                                                        
					//$time = $date->format('Y-m-d H:i:s');                                                        
				 //   echo "posted time :" .$time ;
					$time = date($notifications['created_date']);
					$time_zone = ($time_zone!="")?$time_zone:'Asia/Kolkata'; 
					 date_default_timezone_set($time_zone);
					 $date1= date('Y-m-d H:i:s') ;
					 
						$now = new DateTime($date1);
						$ref = new DateTime($time);
						$diff = $now->diff($ref);
						//print_r($diff);
						$total_seconds = 0 ;       
						$days = $diff->days;
						$hours = $diff->h;
						$mins = $diff->i;                                                            
						if(!empty($days)&&($days>0)) 
						{
						 $days_to_seconds = $diff->days*24*60*60;
						 $total_seconds = $total_seconds+$days_to_seconds;                                                   
						}
						if(!empty($hours)&&($hours>0)) 
						{
						 $hours_to_seconds = $diff->h*60*60;
						 $total_seconds = $total_seconds+$hours_to_seconds;
						}
						if(!empty($mins)&&($mins>0)) 
						{
						 $min_to_seconds = $mins*60;
						 $total_seconds = $total_seconds+$min_to_seconds;
						}
						$intervals      = array (
							'year' => 31556926, 'month' => 2629744, 'week' => 604800, 'day' => 86400, 'hour' => 3600, 'minute'=> 60
						);
						$time_taken = '';
					   //now we just find the difference
	
					if ($total_seconds < 60 || $total_seconds==0 )
					{
							$time_taken = 'just now';
						//$time_taken = $total_seconds == 1 ? $total_seconds . ' second ago' : $total_seconds . ' seconds ago';
					}       
				
					if ($total_seconds >= 60 && $total_seconds < $intervals['hour'])
					{
						$total_seconds = floor($total_seconds/$intervals['minute']);
						 $time_taken =  $total_seconds == 1 ? $total_seconds . ' minute ago' : $total_seconds . ' minutes ago';
					}       
				
					if ($total_seconds >= $intervals['hour'] && $total_seconds < $intervals['day'])
					{
						$total_seconds = floor($total_seconds/$intervals['hour']);
						 $time_taken =  $total_seconds == 1 ? $total_seconds . ' hour ago' : $total_seconds . ' hours ago';
					}   
				
					if ($total_seconds >= $intervals['day'] && $total_seconds < $intervals['week'])
					{
						$total_seconds = floor($total_seconds/$intervals['day']);
						 $time_taken =  $total_seconds == 1 ? $total_seconds . ' day ago' : $total_seconds . ' days ago';
					}   
				
					if ($total_seconds >= $intervals['week'] && $total_seconds < $intervals['month'])
					{
						$total_seconds = floor($total_seconds/$intervals['week']);
						 $time_taken =  $total_seconds == 1 ? $total_seconds . ' week ago' : $total_seconds . ' weeks ago';
					}   
				
					if ($total_seconds >= $intervals['month'] && $total_seconds < $intervals['year'])
					{
						$total_seconds = floor($total_seconds/$intervals['month']);
						 $time_taken =  $total_seconds == 1 ? $total_seconds . ' month ago' : $total_seconds . ' months ago';
					}   
				
					if ($total_seconds >= $intervals['year'])
					{
						$total_seconds = floor($total_seconds/$intervals['year']);
						 $time_taken =  $total_seconds == 1 ? $total_seconds . ' year ago' : $total_seconds . ' years ago';
					}      
				
				$username = $notifications['buyer_username'];
				$name = $notifications['buyer_name'];
				$title = $notifications['title'];
				$id=   $notifications['id'];
				$status_s= $notifications['status'];
				 $image='';
				if(!empty($notifications['gig_image_thumb']))
				{
				 $image = base_url().$notifications['gig_image_thumb'];    
				}
				
				$status = '';
				if($notifications['status']=='completed')
				{   
				   
					$otherhtml .= '<a onclick="change_notification_alert('.$id.', \''.$status_s.'\', \''.$title.'\');" href="javascript:void(0);" class="list-group-item">
								  <div class="media">
									 <div class="pull-left p-r-10 noti-img">
										<img src="'.$image.'" alt="'.$title.'">
									 </div>
									 <div class="media-body noti-cont">
										<h5 class="media-heading">'.str_replace("-"," ",$title).'</h5>
										<p class="m-0">
											<small>has completed from "'.$name.'"</small>
										</p>
									 </div>
								  </div>
							   </a>';    
                           $othercount++;							   
				 
				}
				elseif ($notifications['status']=='buyed') 
				{               
					$otherhtml .= '<a onclick="change_notification_alert('.$id.', \''.$status_s.'\', \''.$title.'\');" href="javascript:void(0);" class="list-group-item">
								  <div class="media">
									 <div class="pull-left p-r-10 noti-img">
										<img src="'.$image.'" alt="'.$title.'">
									 </div>
									 <div class="media-body noti-cont">
										<h5 class="media-heading">'.str_replace("-"," ",$title).'</h5>
										<p class="m-0">
											<small>has purchased to "'.$name.'"</small>
										</p>
									 </div>
								  </div>
							   </a>';  
							    $othercount++;
				}
				elseif ($notifications['status']=='payment_request') 
				{               
					$paymenthtml .= '<a onclick="change_notification_alert('.$id.', \''.$status_s.'\', \''.$title.'\');" href="javascript:void(0);" class="list-group-item">
								  <div class="media">
									 <div class="pull-left p-r-10 noti-img">
										<img src="'.$image.'" alt="'.$title.'">
									 </div>
									 <div class="media-body noti-cont">
										<h5 class="media-heading">'.str_replace("-"," ",$title).'</h5>
										<p class="m-0">
											<small>payment request for "'.$name.'"</small>
										</p>
									 </div>
								  </div>
							   </a>';  
							   $paymentcount++;	
				}elseif ($notifications['status']=='payment_decline') 
				{               
					$paymenthtml .= '<a onclick="change_notification_alert('.$id.', \''.$status_s.'\', \''.$title.'\');" href="javascript:void(0);" class="list-group-item">
								  <div class="media">
									 <div class="pull-left p-r-10 noti-img">
										<img src="'.$image.'" alt="'.$title.'">
									 </div>
									 <div class="media-body noti-cont">
										<h5 class="media-heading">'.str_replace("-"," ",$title).'</h5>
										<p class="m-0">
											<small>payment request for "'.$name.'"</small>
										</p>
									 </div>
								  </div>
							   </a>';  
							   $paymentcount++;	
				}elseif ($notifications['status']=='payment_cancel') 
				{               
					$paymenthtml .= '<a onclick="change_notification_alert('.$id.', \''.$status_s.'\', \''.$title.'\');" href="javascript:void(0);" class="list-group-item">
								  <div class="media">
									 <div class="pull-left p-r-10 noti-img">
										<img src="'.$image.'" alt="'.$title.'">
									 </div>
									 <div class="media-body noti-cont">
										<h5 class="media-heading">'.str_replace("-"," ",$title).'</h5>
										<p class="m-0">
											<small>payment request for "'.$name.'"</small>
										</p>
									 </div>
								  </div>
							   </a>';  
							   $paymentcount++;	
				}
				elseif ($notifications['status']=='new_gig') 
				{               
					$otherhtml .= '<a onclick="change_notification_alert('.$id.', \''.$status_s.'\', \''.$title.'\');" href="javascript:void(0);" class="list-group-item">
								  <div class="media">
									 <div class="pull-left p-r-10 noti-img">
										<img src="'.$image.'" alt="'.$title.'">
									 </div>
									 <div class="media-body noti-cont">
										<h5 class="media-heading">'.str_replace("-"," ",$title).'</h5>
										<p class="m-0">
											<small>New package added from "'.$name.'"</small>
										</p>
									 </div>
								  </div>
							   </a>';  
							    $othercount++;
				}
			}
			        
			} 
		echo json_encode( array('payment_html'=>$paymenthtml,'payment_total'=>$paymentcount,'other_html'=>$otherhtml,'other_total'=>$othercount));
    
	}
	public function change_notification_alert()
	{
		$sts = $this->input->post('sts');
        //$update_data = array('notification_status'=>2);
        $id = $this->input->post('id');
		$table= ' ';
		if($sts=='completed')
		{
			$table= 'payments';
		}
		elseif($sts=='buyed')
		{
			$table= 'payments';
		}
		elseif($sts=='payment_request')
		{
			$table=  'payments';
		}
		elseif($sts=='new_gig')
		{
			$table= 'sell_gigs';
		}
		if(!empty($table))
		{
			
				if($sts=='new_gig'){
					$query = $this->db->query("UPDATE $table SET  `notification_status` = 0 WHERE `id` = $id ");
				}
				else
				{
					$query = $this->db->query("UPDATE $table SET  `admin_notification_status` = 0 WHERE `id` = $id ");
				}
			
			echo 1;
		}
		else
		{
			echo 2;
		}
	}
}

?>
