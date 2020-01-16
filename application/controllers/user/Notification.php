<?php 
class Notification extends CI_Controller{
    public function __construct() {
        parent::__construct();        
        $this->load->model('notification_model');
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
		$this->email_tittle =!empty($data['value']) ? $data['value'] : 'Gigs' ;
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
		$this->load->model('user_panel_model');
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

    }
    
    public function get_notification_count()
    {
        $result = $this->notification_model->new_notification_count();
	 	  //print_r($result);exit;
        $html = '';
		$total_count=0;
    	if(!empty($result))
		{
			$total_count =count($result);
			$image  = base_url().'assets/images/avatar2.jpg';
			$time_zone = $this->session->userdata('time_zone');  
			foreach($result as $notifications)
			{   
			 
				  $date = new DateTime($notifications['created_date']);
					$time = date($notifications['created_date']);
					 date_default_timezone_set($time_zone);
					 $date1= date('Y-m-d H:i:s') ;
					 
						$now = new DateTime($date1);
						$ref = new DateTime($time);
						$diff = $now->diff($ref);
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
				if(!empty($notifications['buyer_img']))
				{
				 $image = base_url().$notifications['buyer_img'];    
				}
				$active_class = '';
				
				 if($notifications['notification_status']==1)
				{
				$active_class = 'active';
				}
				$status = '';
				if($notifications['status']=='completed')
				{   
				   
				$html .= '<li class="media notification-message">
						<a onclick="change_notification_status('.$id.', \''.$status_s.'\',\'purchases\');" href="javascript:;">
								<div class="media-left">
										<img width="32" class="img-circle" src="'.$image.'" alt="'.$username.'">
								</div>
								<div class="media-body">
										<p class="m-0 noti-details"><span class="noti-title">"'.$name.'"</span> completed your order <span class="noti-title">"'.str_replace("-"," ",$title).'"</span></p>
										<p class="m-0"><span class="notification-time">'.$time_taken.'</span></p>
								</div>
						</a>
						</li>';      
				 
				}
				elseif($notifications['status']=='completedrequest'){
					$html .= '<li class="media notification-message">
						<a onclick="change_notification_status('.$id.', \''.$status_s.'\',\'purchases\');" href="javascript:;">
								<div class="media-left">
										<img width="32" class="img-circle" src="'.$image.'" alt="'.$username.'">
								</div>
								<div class="media-body">
										<p class="m-0 noti-details"><span class="noti-title">"'.$name.'"</span>  request a order Complete <span class="noti-title">"'.str_replace("-"," ",$title).' has been completed"</span></p>
										<p class="m-0"><span class="notification-time">'.$time_taken.'</span></p>
								</div>
						</a>
						</li>';      
					
				}
				elseif($notifications['status']=='complete-request-accept'){
					$html .= '<li class="media notification-message">
						<a onclick="change_notification_status('.$id.', \''.$status_s.'\',\'sales\');" href="javascript:;">
								<div class="media-left">
										<img width="32" class="img-circle" src="'.$image.'" alt="'.$username.'">
								</div>
								<div class="media-body">
										<p class="m-0 noti-details"><span class="noti-title">"'.$name.'"</span>  complete request accepted <span class="noti-title">"'.str_replace("-"," ",$title).' has been completed"</span></p>
										<p class="m-0"><span class="notification-time">'.$time_taken.'</span></p>
								</div>
						</a>
						</li>';      
					
				}
				elseif ($notifications['status']=='buyed') 
				{               
					$html .= '<li class="media notification-message">
						<a onclick="change_notification_status('.$id.', \''.$status_s.'\',\'sales\');" href="javascript:;">
								<div class="media-left">
										<img width="32" class="img-circle" src="'.$image.'" alt="'.$username.'">
								</div>
								<div class="media-body">
										<p class="m-0 noti-details"><span class="noti-title">'.$name.'</span> has purchased your gig <span class="noti-title">"'.str_replace("-"," ",$title).'"</span></p>
										<p class="m-0"><span class="notification-time">'.$time_taken.'</span></p>
								</div>
						</a>
						</li>';  
				}
				elseif ($notifications['status']=='payment_release') 
				{               
					$html .= '<li class="media notification-message">
						<a onclick="change_notification_status('.$id.', \''.$status_s.'\',\'payments\');" href="javascript:;">
								<div class="media-left">
										<img width="32" class="img-circle" src="'.$image.'" alt="'.$username.'">
								</div>
								<div class="media-body">
								<p class="m-0 noti-details">Admin released payment for a completed gig <span class="noti-title">"'.str_replace("-"," ",$title).'"</span></p>
										<p class="m-0"><span class="notification-time">'.$time_taken.'</span></p>
								</div>
						</a>
						</li>';  
				}
				  elseif ($notifications['status']=='own_buying') 
				{
					
					$html .= '<li class="media notification-message">
						<a onclick="change_notification_status('.$id.', \''.$status_s.'\',\'purchases\');" href="javascript:;">
								<div class="media-left">
										<img width="32" class="img-circle" src="'.$image.'" alt="'.$username.'">
								</div>
								<div class="media-body">
								<p class="m-0 noti-details">You have made a purchase from <span class="noti-title">'.$name.'</span></p>
								<p class="m-0"><span class="notification-time">'.$time_taken.'</span></p>
								</div>
								</a>
								</li>';
								}
				elseif ($notifications['status']=='buyer_cancel') 
				{
					
					$html .= '<li class="media notification-message">
						<a onclick="change_notification_status('.$id.', \''.$status_s.'\',\'sales\');" href="javascript:;">
								<div class="media-left">
										<img width="32" class="img-circle" src="'.$image.'" alt="'.$username.'">
								</div>
								<div class="media-body">
								<p class="m-0 noti-details"><span class="noti-title">'.$name.'</span> cancel the gigs of <span class="noti-title">"'.str_replace("-"," ",$title).'"</span></p>
								<p class="m-0"><span class="notification-time">'.$time_taken.'</span></p>
								</div>
								</a>
								</li>';
								}
				elseif ($notifications['status']=='seller_cancel') 
				{
					
					$html .= '<li class="media notification-message">
						<a onclick="change_notification_status('.$id.', \''.$status_s.'\',\'purchases\');" href="javascript:;">
								<div class="media-left">
										<img width="32" class="img-circle" src="'.$image.'" alt="'.$username.'">
								</div>
								<div class="media-body">
								<p class="m-0 noti-details"><span class="noti-title">'.$name.'</span> decline the gigs of <span class="noti-title">"'.str_replace("-"," ",$title).'"</span></p>
								<p class="m-0"><span class="notification-time">'.$time_taken.'</span></p>
								</div>
								</a>
								</li>';
								}				
				if(($notifications['status'])=='to_user')
				{
					
					$html .= '<li class="media notification-message">
						<a onclick="change_notification_status('.$id.', \''.$status_s.'\',\'purchases\');" href="javascript:;">
								<div class="media-left">
										<img width="32" class="img-circle" src="'.$image.'" alt="'.$username.'">
								</div>
								<div class="media-body">
										<p class="m-0 noti-details"><span class="noti-title">'.$name.'</span> given reply feedback on  <span class="noti-title">" '.str_replace("-"," ",$title).' "</span></p>
										<p class="m-0"><span class="notification-time">'.$time_taken.'</span></p>
								</div>
						</a>
						</li>';  
				  
				}
				if(($notifications['status'])=='from_user')
				{
				$query = $this->db->query("SELECT sent_recieved FROM `feedback` WHERE `id` = $id " );
        		$notificationsdata = $query->row_array();
				$s1=$notificationsdata['sent_recieved'];
				if($s1==1){
					$rep='reply';
					$link='purchases';
				}else
				{
					$rep='';
					$link='sales';
				}
					$html .= '<li class="media notification-message">
						<a onclick="change_notification_status('.$id.', \''.$status_s.'\',\''.$link.'\');" href="javascript:;">
								<div class="media-left">
										<img width="32" class="img-circle" src="'.$image.'" alt="'.$username.'">
								</div>
								<div class="media-body">
										<p class="m-0 noti-details"><span class="noti-title">'.$name.'</span> given '.$rep.' feedback on <span class="noti-title">" '.str_replace("-"," ",$title).' "</span></p>
										<p class="m-0"><span class="notification-time">'.$time_taken.'</span></p>
								</div>
						</a>
						</li>';  
				  
				}   
				
				
				if(($notifications['status'])=='seller_cancelled')
				{
				  
					$html .= '<li class="media notification-message">
						<a onclick="change_notification_status('.$id.', \''.$status_s.'\',\'purchases\');" href="javascript:;">
								<div class="media-left">
										<img width="32" class="img-circle" src="'.$image.'" alt="'.$username.'">
								</div>
								<div class="media-body">
										<p class="m-0 noti-details"><span class="noti-title">'.$name.'</span> has accepted the cancel request <span class="noti-title">" '.str_replace("-"," ",$title).' "</span></p>
										<p class="m-0"><span class="notification-time">'.$time_taken.'</span></p>
								</div>
						</a>
						</li>';  
				  
				}   
				if(($notifications['status'])=='buyer_cancelled')
				{
				  
					$html .= '<li class="media notification-message">
						<a onclick="change_notification_status('.$id.', \''.$status_s.'\',\'purchases\');" href="javascript:;">
								<div class="media-left">
										<img width="32" class="img-circle" src="'.$image.'" alt="'.$username.'">
								</div>
								<div class="media-body">
										<p class="m-0 noti-details"><span class="noti-title">'.$name.'</span> has accepted the decline request  <span class="noti-title">" '.str_replace("-"," ",$title).' "</span></p>
										<p class="m-0"><span class="notification-time">'.$time_taken.'</span></p>
								</div>
						</a>
						</li>';  
				  
				}  
				if ($notifications['status']=='buyer_cancel_payment') 
				{               
					$html .= '<li class="media notification-message">
						<a onclick="change_notification_status('.$id.', \''.$status_s.'\',\'payments\');" href="javascript:;">
								<div class="media-left">
										<img width="32" class="img-circle" src="'.$image.'" alt="'.$username.'">
								</div>
								<div class="media-body">
								<p class="m-0 noti-details">Admin released cancel payment for a gig <span class="noti-title">"'.str_replace("-"," ",$title).'"</span></p>
										<p class="m-0"><span class="notification-time">'.$time_taken.'</span></p>
								</div>
						</a>
						</li>';  
				}
				elseif ($notifications['status']=='buyer_decline_payment') 
				{               
					$html .= '<li class="media notification-message">
						<a onclick="change_notification_status('.$id.', \''.$status_s.'\',\'payments\');" href="javascript:;">
								<div class="media-left">
										<img width="32" class="img-circle" src="'.$image.'" alt="'.$username.'">
								</div>
								<div class="media-body">
								<p class="m-0 noti-details">Admin released decline payment for a gig <span class="noti-title">"'.str_replace("-"," ",$title).'"</span></p>
										<p class="m-0"><span class="notification-time">'.$time_taken.'</span></p>
								</div>
						</a>
						</li>';  
				}
				if(($notifications['status'])=='seller_declined')
				{
				  
					$html .= '<li class="media notification-message">
						<a onclick="change_notification_status('.$id.', \''.$status_s.'\',\'sales\');" href="javascript:;">
								<div class="media-left">
										<img width="32" class="img-circle" src="'.$image.'" alt="'.$username.'">
								</div>
								<div class="media-body">
										<p class="m-0 noti-details"><span class="noti-title">'.$name.'</span> has declined your Order  <span class="noti-title">" '.str_replace("-"," ",$title).' "</span></p>
										<p class="m-0"><span class="notification-time">'.$time_taken.'</span></p>
								</div>
						</a>
						</li>';  
				  
				}   
				
				if(($notifications['status'])=='buyer_accept_seller_declined')
				{
				  
					$html .= '<li class="media notification-message">
						<a onclick="change_notification_status('.$id.', \''.$status_s.'\',\'sales\');" href="javascript:;">
								<div class="media-left">
										<img width="32" class="img-circle" src="'.$image.'" alt="'.$username.'">
								</div>
								<div class="media-body">
										<p class="m-0 noti-details"><span class="noti-title">'.$name.'</span> has accepted the declined  request  <span class="noti-title">" '.str_replace("-"," ",$title).' "</span></p>
										<p class="m-0"><span class="notification-time">'.$time_taken.'</span></p>
								</div>
						</a>
						</li>';  
				  
				} 

			}
			        
			} 
            else {
                 $html .= '';
        
    		}
    
        //echo $result;
		echo json_encode( array('new_data'=>$html,'new_total'=>$total_count));
    }
    public function get_new_notification()
    {
        $result = $this->notification_model->notification_all_gigs();
        $html = '';
    if(!empty($result))
    {
        $image  = base_url().'assets/images/avatar2.jpg';
        $time_zone = $this->session->userdata('time_zone');  
        foreach($result as $notifications)
        {   
			  $date = new DateTime($notifications['created_date']);
				$date->setTimezone(new DateTimeZone($time_zone));                                                        
				$time = $date->format('Y-m-d H:i:s');                                                        
			 //   echo "posted time :" .$time ;
				
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
            if(!empty($notifications['buyer_img']))
            {
             $image = base_url().$notifications['buyer_img'];    
            }
            $active_class = '';
            
             if($notifications['notification_status']==1)
            {
            $active_class = 'active';
            }
            $status = '';
            if($notifications['status']=='completed')
            {   
               
            $html .= '<li class="media notification-message">
                    <a href="'.base_url().'gig-preview/'.$title.'">
                            <div class="media-left">
                                    <img width="32" class="img-circle" src="'.$image.'" alt="'.$username.'">
                            </div>
                            <div class="media-body">
								<p class="m-0 noti-details"><span class="noti-title">"'.$name.'"</span>completed your order <span class="noti-title">"'.str_replace("-"," ",$title).'"</span></p>
								<p class="m-0"><span class="notification-time">'.$time_taken.'</span></p>
                            </div>
                    </a>
                    </li>';      
             
            }
            elseif ($notifications['status']=='buyed') 
            {               
                $html .= '<li class="media notification-message">
                    <a href="'.base_url().'gig-preview/'.$title.'">
                            <div class="media-left">
                                    <img width="32" class="img-circle" src="'.$image.'" alt="'.$username.'">
                            </div>
                            <div class="media-body">
                                    <p class="m-0 noti-details"><span class="noti-title">'.$name.'</span> has purchased your gig <span class="noti-title">"'.str_replace("-"," ",$title).'"</span></p>
                                    <p class="m-0"><span class="notification-time">'.$time_taken.'</span></p>
                            </div>
                    </a>
                    </li>';  
            }
              elseif ($notifications['status']=='own_buying') 
            {
                
                $html .= '<li class="media notification-message">
                    <a href="'.base_url().'gig-preview/'.$title.'">
                            <div class="media-left">
                                    <img width="32" class="img-circle" src="'.$image.'" alt="'.$username.'">
                            </div>
                            <div class="media-body">
                            <p class="m-0 noti-details">You have made a purchase  from <span class="noti-title">'.$name.'</span></p>
                            <p class="m-0"><span class="notification-time">'.$time_taken.'</span></p>
                            </div>
                            </a>
                            </li>';
                            }
            if(($notifications['status'])=='to_user')
            {
                
                $html .= '<li class="media notification-message">
                    <a href="'.base_url().'gig-preview/'.$title.'">
                            <div class="media-left">
                                    <img width="32" class="img-circle" src="'.$image.'" alt="'.$username.'">
                            </div>
                            <div class="media-body">
                                    <p class="m-0 noti-details"><span class="noti-title">'.$name.'</span> given feedback on  <span class="noti-title">" '.str_replace("-"," ",$title).' "</span></p>
                                    <p class="m-0"><span class="notification-time">'.$time_taken.'</span></p>
                            </div>
                    </a>
                    </li>';  
              
            }
            if(($notifications['status'])=='from_user')
            {
              
                $html .= '<li class="media notification-message">
                    <a href="'.base_url().'gig-preview/'.$title.'">
                            <div class="media-left">
                                    <img width="32" class="img-circle" src="'.$image.'" alt="'.$username.'">
                            </div>
                            <div class="media-body">
                                    <p class="m-0 noti-details"><span class="noti-title">'.$name.'</span> given feedback on  <span class="noti-title">" '.str_replace("-"," ",$title).' "</span></p>
                                    <p class="m-0"><span class="notification-time">'.$time_taken.'</span></p>
                            </div>
                    </a>
                    </li>';  
              
            }   
        }
    echo $html;        
            } 
            else {
                 $html .= '<li class="media notification-message">
                    <a href="javascript:;">                             
                            <div class="media-body">
                                    <p style="text-align:center;" > Sorry ! No Notifications </p>                                    
                            </div>
                    </a>
                    </li>';  
      echo $html;
        
    }
    
    }
    
	public function mail_notification()
	{
		$query = $this->db->query("SELECT * FROM (SELECT payments.id, `members`.`fullname` AS buyer_name,  `members`.`user_thumb_image` AS buyer_img , `members`.email as buyer_email , payments.created_at AS created_date ,  `members`.`username` AS buyer_username, sell_gigs.title , 'buyed' as status
, payments.notification_status
FROM  `payments` 
INNER JOIN members ON payments.`USERID` =  `members`.`USERID` 
INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
WHERE payments.seller_status = 1
AND payments.mail_sent = 1 
AND payments.notification_status = 1
UNION
SELECT payments.id, `members`.`fullname` AS buyer_name,  `members`.`user_thumb_image` AS buyer_img , `members`.email as buyer_email , payments.created_at AS created_date , `members`.`username` AS buyer_username, sell_gigs.title , 'completed' as status
, payments.notification_status
FROM  `payments` 
INNER JOIN members ON payments.`USERID` =  `members`.`USERID` 
INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
WHERE payments.seller_status = 6
AND payments.mail_sent = 1 
AND payments.notification_status = 1
UNION
SELECT payments.id, `members`.`fullname` AS buyer_name,  `members`.`user_thumb_image` AS buyer_img, `members`.email as buyer_email , payments.created_at AS created_date,  `members`.`username` AS buyer_username, sell_gigs.title,  'own_buying' AS 
STATUS , payments.notification_status
FROM  `payments` 
INNER JOIN members ON payments.`seller_id` =  `members`.`USERID` 
INNER JOIN sell_gigs ON payments.`gigs_id` = sell_gigs.id
WHERE payments.seller_status =1
AND payments.mail_sent = 1 
AND payments.notification_status = 1
UNION
SELECT feedback.id, `members`.`fullname` AS buyer_name,  `members`.`user_thumb_image` AS buyer_img, `members`.email as buyer_email , feedback.created_date AS created_date,  `members`.`username` AS buyer_username, sell_gigs.title,  'to_user' AS 
STATUS , feedback.notification_status
FROM  `feedback` 
INNER JOIN members ON members.`USERID` =  `feedback`.`from_user_id` 
INNER JOIN sell_gigs ON feedback.`gig_id` = sell_gigs.id
WHERE feedback.notification_status = 1
AND feedback.mail_sent = 1 
UNION 
SELECT feedback.id, `members`.`fullname` AS buyer_name,  `members`.`user_thumb_image` AS buyer_img, `members`.email as buyer_email , feedback.created_date AS created_date,  `members`.`username` AS buyer_username, sell_gigs.title,  'from_user' AS 
STATUS , feedback.notification_status
FROM  `feedback` 
INNER JOIN members ON members.`USERID` =  `feedback`.`from_user_id` 
INNER JOIN sell_gigs ON feedback.`gig_id` = sell_gigs.id
WHERE feedback.notification_status = 1
AND feedback.mail_sent = 1 
) a ORDER BY a.created_date DESC ");
$result = $query->result_array();
  foreach($result as $notifications)
        {
			$id = $notifications['id'];
        	 $username = $notifications['buyer_username'];
            $name = $notifications['buyer_name'];
            $title = $notifications['title'];
			$buyer_email =  $notifications['buyer_email'];
            if(!empty($notifications['buyer_img']))
            {
             $image = base_url().$notifications['buyer_img'];    
            }
			
			$owner_gig_query = $this->db->query("SELECT members.fullname, members.username,members.email  FROM  `sell_gigs`  
												INNER JOIN members ON members.USERID = sell_gigs.`user_id` 
												WHERE  `title` =  '".$title."'");
			$owner_of_gig	= $owner_gig_query->row_array();								
			
   echo "username ".$username." name "	.$name ." title " . $title . " Owner of gig ".$owner_of_gig['fullname'] ." Owner of gig username " .$owner_of_gig['username'] ." Owner email " .$owner_of_gig['email'] . " buyer email " .$buyer_email;
			
			  if($notifications['status']=='completed')
            {                                    
        
			 
        $url=base_url().'user_profile/'.$username;                                         
        $this->load->model('templates_model');
        $message='';
        $welcomemessage='';
        $template_title=1;
        $tempheader_details= $this->templates_model->get_usertemplate_data($template_title);
        $template=2;
        $tempfooter_details= $this->templates_model->get_usertemplate_data($template);
        $bodyid = 8;
        $tempbody_details= $this->templates_model->get_usertemplate_data($bodyid);
        $body=$tempbody_details['template_content'];
		 
		$gig_preview_link  = base_url().'gig-preview/'.$title ;
		$user_profile_link = base_url().'user-profile/'.$username;		 
		$body = str_replace('{base_url}', $this->base_domain, $body);
        $body = str_replace('{gig_owner}', $owner_of_gig['fullname'], $body);
        $body = str_replace('{sell_name}', $name, $body);
        $body = str_replace('{title}',str_replace("-"," ",$title), $body);				
        $body = str_replace('{gig_preview_link}', $gig_preview_link, $body);
        $body = str_replace('{user_profile_link}', $user_profile_link, $body);
		$body = str_replace('{site_name}',$this->site_name, $body);
        $message .=                    $message ='<table style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">
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
	 
		 				 
        $this->load->helper('file');  
        $this->load->library('email');
        $this->email->initialize($this->smtp_config);
        $this->email->set_newline("\r\n");
        $this->email->from($this->email_address,$this->email_tittle); 
        $this->email->to($buyer_email); 
        $this->email->subject('Update from '.$this->site_name);
        $this->email->message($message);	 
        if($this->email->send())
        { 
		  
			$update_data['mail_sent'] = 0;
			$this->db->where('id',$id);
			$this->db->update('payments',$update_data);
        }	 
        }
        elseif ($notifications['status']=='buyed') 
        { 
        $url=base_url().'user-profile/'.$username;                                         
        $this->load->model('templates_model');
        $message='';
        $welcomemessage='';
        $template_title=1;
        $tempheader_details= $this->templates_model->get_usertemplate_data($template_title);
        $template=2;
        $tempfooter_details= $this->templates_model->get_usertemplate_data($template);
        $bodyid=9;
        $tempbody_details= $this->templates_model->get_usertemplate_data($bodyid);
        $body=$tempbody_details['template_content'];	 
				
		$gig_preview_link  = base_url().'gig-preview/'.$title ;
		$user_profile_link = base_url().'user-profile/'.$username;	 
		$body = str_replace('{base_url}', $this->base_domain, $body);
        $body = str_replace('{buyer_name}', $name , $body);
        $body = str_replace('{sell_name}', $owner_of_gig['fullname'], $body);
        $body = str_replace('{title}',str_replace("-"," ",$title), $body);				
        $body = str_replace('{gig_preview_link}', $gig_preview_link , $body);
        $body = str_replace('{user_profile_link}', $user_profile_link, $body);
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
        $this->load->helper('file');  
        $this->load->library('email');
        $this->email->initialize($this->smtp_config);
        $this->email->set_newline("\r\n");
        $this->email->from($this->email_address,$this->email_tittle); 
        $this->email->to($owner_of_gig['email']); 
        $this->email->subject('Update from '.$this->site_name);
        $this->email->message($message);
		 
        if($this->email->send())
        {            
			$update_data['mail_sent'] = 0;
			$this->db->where('id',$id);
			$this->db->update('payments',$update_data);
        }	
        }
        elseif ($notifications['status']=='own_buying') 
        { 
        $url=base_url().'user-profile/'.$username;                                         
        $this->load->model('templates_model');
        $message='';
        $welcomemessage='';
        $template_title=1;
        $tempheader_details= $this->templates_model->get_usertemplate_data($template_title);
        $template=2;
        $tempfooter_details= $this->templates_model->get_usertemplate_data($template);
        $bodyid=10;
        $tempbody_details= $this->templates_model->get_usertemplate_data($bodyid);
        $body=$tempbody_details['template_content'];
		$body = str_replace('{base_url}', $this->base_domain, $body);
		$body = str_replace('{base_image}',$this->base_domain.'/'.$this->logo_front, $body);
        $body = str_replace('{buyer_name}', $name , $body);
        $body = str_replace('{seller_name}', $owner_of_gig['fullname'], $body);
        $body = str_replace('{title}', str_replace("-"," ",$title), $body);				
        $body = str_replace('{gig_preview_link}', $username, $body);
        $body = str_replace('{user_profile_link}', $url, $body);
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
        $this->load->helper('file');  
        $this->load->library('email');
        $this->email->initialize($this->smtp_config);
        $this->email->set_newline("\r\n");
        $this->email->from($this->email_address,$this->email_tittle); 
        $this->email->to($buyer_email); 
        $this->email->subject('Update from '.$this->site_name);
        $this->email->message($message);
		 
        if($this->email->send())
        {            
			$update_data['mail_sent'] = 0;
			$this->db->where('id',$id);
			$this->db->update('payments',$update_data);
        }	   
              
        }
            if(($notifications['status'])=='to_user')
            {
				

        $url=base_url().'user_profile/'.$username;                                         
        $this->load->model('templates_model');
        $message='';
        $welcomemessage='';
        $template_title=1;
        $tempheader_details= $this->templates_model->get_usertemplate_data($template_title);
        $template=2;
        $tempfooter_details= $this->templates_model->get_usertemplate_data($template);
        $bodyid=7;
        $tempbody_details= $this->templates_model->get_usertemplate_data($bodyid);
        $body=$tempbody_details['template_content'];
		 
		$gig_preview_link  = base_url().'gig-preview/'.$title ;
		$user_profile_link = base_url().'user-profile/'.$username;		 
		$body = str_replace('{base_url}', $this->base_domain, $body);
		$body = str_replace('{base_image}',$this->base_domain.'/'.$this->logo_front, $body);
        $body = str_replace('{own_name}', $owner_of_gig['fullname'], $body);
        $body = str_replace('{seller_name}', $name, $body);
        $body = str_replace('{title}', str_replace("-"," ",$title), $body);				
        $body = str_replace('{gig_preview_link}', $gig_preview_link, $body);
        $body = str_replace('{user_profile_link}', $user_profile_link, $body);
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
        $this->load->helper('file');  
        $this->load->library('email');
        $this->email->initialize($this->smtp_config);
        $this->email->set_newline("\r\n");
        $this->email->from($this->email_address,$this->email_tittle); 
        $this->email->to($owner_of_gig['email']); 
        $this->email->subject('Update from '.$this->site_name);
        $this->email->message($message);
		 
        if($this->email->send())
        {            
			$update_data['mail_sent'] = 0;
			$this->db->where('id',$id);
			$this->db->update('feedback',$update_data);
        }	   
     
     	}
            if(($notifications['status'])=='from_user')
            {
				
				                                    
        
        $url=base_url().'user_profile/'.$username;                                         
        $this->load->model('templates_model');
        $message='';
        $welcomemessage='';
        $template_title=1;
        $tempheader_details= $this->templates_model->get_usertemplate_data($template_title);
        $template=2;
        $tempfooter_details= $this->templates_model->get_usertemplate_data($template);
        $bodyid=7;
        $tempbody_details= $this->templates_model->get_usertemplate_data($bodyid);
        $body=$tempbody_details['template_content'];
		$body = str_replace('{base_url}', $this->base_domain, $body);
		$body = str_replace('{base_image}',$this->base_domain.'/'.$this->logo_front, $body); 
        $body = str_replace('{gig_owner}', $owner_of_gig['fullname'], $body);
        $body = str_replace('{sell_name}', $name, $body);
        $body = str_replace('{title}', $title, $body);				
        $body = str_replace('{gig_preview_link}', $username, $body);
        $body = str_replace('{user_profile_link}', $url, $body);
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
        $this->load->helper('file');  
        $this->load->library('email');
        $this->email->initialize($this->smtp_config);
        $this->email->set_newline("\r\n");
        $this->email->from($this->email_address,$this->email_tittle); 
        $this->email->to($owner_of_gig['email']); 
        $this->email->subject('Update from '.$this->site_name);
        $this->email->message($message);
		 
        if($this->email->send())
        {            
			$update_data['mail_sent'] = 0;
			$this->db->where('id',$id);
			$this->db->update('feedback',$update_data);
        }	          
              
            } 
		
		}
	}
	
    public function update_notification()
    {        
        $table_name = $this->input->post('table_name');
        //$update_data = array('notification_status'=>2);
        $id = $this->input->post('id');
        /*$this->db->where('id',$id);
        if($this->db->update($table_name,$update_data))
        {
        echo 1;     
        } */
        $query = $this->db->query("UPDATE $table_name SET  `notification_status` = 2 WHERE `id` = $id ");           
        if($query)
        {
            echo 1;
        }
    }
	public function change_notification_status()
	{
		$sts = $this->input->post('sts');
        //$update_data = array('notification_status'=>2);
        $id = $this->input->post('id');
		$table= ' ';
		if($sts=='completed')
		{
			$table= 'payments';
		}
		elseif($sts=='completedrequest')
		{
			$table= 'payments';
		}
		elseif($sts=='buyed')
		{
			$table= 'payments';
		}
		elseif($sts=='own_buying')
		{
			$table= 'payments';
		}
		elseif($sts=='to_user')
		{
			$table= 'feedback';
		}
		elseif($sts=='from_user')
		{
			$table= 'feedback';
		}
		elseif($sts=='payment_release')
		{
			$table=  'payments';
		}
		elseif($sts=='buyer_cancel')
		{
			$table= 'payments';
		}
		elseif($sts=='seller_cancel')
		{
			$table= 'payments';
		}
		elseif($sts=='buyer_decline_payment')
		{
			$table= 'payments';
		}
		elseif($sts=='complete-request-accept')
		{
			$table= 'payments';
		}
		elseif($sts=='buyer_cancel_payment')
		{
			$table= 'payments';
		}
		elseif($sts=='buyer_cancel')
		{
			$table= 'payments';
		}
		elseif($sts=='seller_cancel')
		{
			$table= 'payments';
		}
		elseif($sts=='buyer_accept_seller_declined')
		{
			$table= 'payments';
		}
		elseif($sts=='buyer_cancelled')
		{
			$table= 'payments';
		}
		elseif($sts=='seller_declined')
		{
			$table= 'payments';
		}
		if(!empty($table))
		{
			
				if($sts=='buyer_cancel'){
					$query = $this->db->query("UPDATE $table SET  `cancel_notification_status` = 0 WHERE `id` = $id ");
				}
				else if($sts =='seller_cancel')
				{
					$query = $this->db->query("UPDATE $table SET  `cancel_notification_status` = 0 WHERE `id` = $id ");
				}
				else if($sts =='buyer_decline_payment')
				{
					$query = $this->db->query("UPDATE $table SET  `notification_status` = 0 WHERE `id` = $id ");
				}
				else if($sts =='complete-request-accept')
				{
					$query = $this->db->query("UPDATE $table SET  `notification_status` = 0 WHERE `id` = $id ");
				}else if($sts =='buyer_cancelled')
				{
					$query = $this->db->query("UPDATE $table SET  `cancel_notification_status` = 0 WHERE `id` = $id ");
				}
				else
				{
					$query = $this->db->query("UPDATE $table SET  `notification_status` = 0 WHERE `id` = $id ");
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