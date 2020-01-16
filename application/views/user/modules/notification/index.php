<div class="notification-section">
			<div class="tab-content">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<ul class="list-group notify-list">
                                                            
								<?php 
                                if(!empty($list)) {
                               // $image  = base_url().'assets/images/avatar2.jpg';
                                $time_zone = $this->session->userdata('time_zone');
								date_default_timezone_set($time_zone);
                                foreach($list as $notifications)
                                {   
                            
								$db_time =  $notifications['created_date'];
										$db_timezone = $notifications['time_zone'];
										/* $time_taken = $this->notification_model->mylastupdate($db_time,$db_timezone,$time_zone); */
									
         
                                                      $date = new DateTime($notifications['created_date']);
                                                       // $date->setTimezone(new DateTimeZone($time_zone));                                                        
                                                        $time = date($notifications['created_date']);                                                        
                                                       //echo "posted time :" .$time ;
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
            $name = ucfirst($notifications['buyer_name']);
            $title = ucfirst($notifications['title']);
            $status = '';
            if(!empty($notifications['buyer_img']))
            {
             $image = $notifications['buyer_img'];    
            }else{
				$image = base_url().'assets/images/avatar2.jpg';
			}
            if($notifications['status']=='completed')
            {      
                 $data = array('notification_status'=>0);
                $this->db->where('id',$notifications['id']);
                $this->db->update('payments',$data);
                
                 $html = '<li id="remove_payments_'.$notifications['id'].'" class="list-group-item">
                    <a href="'.base_url().'purchases" class="notify-content">                            
                    <img width="32" class="img-circle" src="'.$image.'" alt="'.$username.'">
                    <strong>'.ucfirst($username).'</strong> <span class="grey-text">has completed the gig </span> <strong>'.str_replace("-"," ",$title).'</strong>   
                    <span class="time">- '.$time_taken.' </span>
                    </a>
                    <span title="Delete" class="noti-close"><i class="fa fa-times" onclick = "hide_notification(\'payments\','.$notifications['id'].')" ></i></span>
                    </li>';   
                
                 echo $html;
            
            }
			 elseif ($notifications['status']=='completedrequest') 
            {
                $data = array('notification_status'=>0);
                $this->db->where('id',$notifications['id']);
                $this->db->update('payments',$data);
                 
                $html = '<li id="remove_payments_'.$notifications['id'].'" class="list-group-item">
                    <a href="'.base_url().'purchases" class="notify-content">                            
                    <img width="32" class="img-circle" src="'.$image.'" alt="'.$username.'">
                    <strong>'.ucfirst($name).'</strong> <span class="grey-text">  request a order complete </span> <strong>'.ucfirst(str_replace("-"," ",$title)).'</strong>  
                    <span class="time">- '.$time_taken.' </span>
                    </a>
                    <span title="Delete" class="noti-close"><i class="fa fa-times" onclick = "hide_notification(\'payments\','.$notifications['id'].')" ></i></span>
                    </li>';      
                
                echo $html;
                
                 
            }
			elseif ($notifications['status']=='complete-request-accept') 
            {
                $data = array('notification_status'=>0);
                $this->db->where('id',$notifications['id']);
                $this->db->update('payments',$data);
                 
                $html = '<li id="remove_payments_'.$notifications['id'].'" class="list-group-item">
                    <a href="'.base_url().'sales" class="notify-content">                            
                    <img width="32" class="img-circle" src="'.$image.'" alt="'.$username.'">
                    <strong>'.ucfirst($name).'</strong> <span class="grey-text">  complete request accepted </span> <strong>'.ucfirst(str_replace("-"," ",$title)).'</strong>  
                    <span class="time">- '.$time_taken.' </span>
                    </a>
                    <span title="Delete" class="noti-close"><i class="fa fa-times" onclick = "hide_notification(\'payments\','.$notifications['id'].')" ></i></span>
                    </li>';      
                
                echo $html;
                
                 
            }
            elseif ($notifications['status']=='buyed') 
            {
                $data = array('notification_status'=>0);
                $this->db->where('id',$notifications['id']);
                $this->db->update('payments',$data);
                 
                $html = '<li id="remove_payments_'.$notifications['id'].'" class="list-group-item">
                    <a href="'.base_url().'sales" class="notify-content">                            
                    <img width="32" class="img-circle" src="'.$image.'" alt="'.$username.'">
                    <strong>'.ucfirst($name).'</strong> <span class="grey-text"> purchased your gigs </span> <strong>'.ucfirst(str_replace("-"," ",$title)).'</strong>  
                    <span class="time">- '.$time_taken.' </span>
                    </a>
                    <span title="Delete" class="noti-close"><i class="fa fa-times" onclick = "hide_notification(\'payments\','.$notifications['id'].')" ></i></span>
                    </li>';      
                
                echo $html;
                
                 
            }
            elseif ($notifications['status']=='own_buying') 
            {
                 $data = array('notification_status'=>0);
                $this->db->where('id',$notifications['id']);
                $this->db->update('payments',$data);
                 
                $html = '<li id="remove_payments_'.$notifications['id'].'" class="list-group-item">                    
                    <a href="'.base_url().'purchases" class="notify-content">                            
                    <img width="32" class="img-circle" src="'.$image.'" alt="'.$username.'">
                     <span class="grey-text">You have made a purchase on a gig <strong>'.ucfirst(str_replace("-"," ",$title)).'</strong>   from </span> <strong>'.ucfirst($name).'</strong>    
                    <span class="time">- '.$time_taken.' </span>
                    </a>
                    <span title="Delete" class="noti-close"><i class="fa fa-times" onclick = "hide_notification(\'payments\','.$notifications['id'].')"></i></span>
                    </li>';      
                
                echo $html;
                
                 
            }
            elseif ($notifications['status']=='admin_payment') 
            {
                 $html = '<li class="list-group-item">
                    <a href="'.base_url().'payments" class="notify-content">                            
                    <img width="32" class="img-circle" src="'.$image.'" alt="'.$username.'">
                    <strong>'.ucfirst($username).'</strong> <span class="grey-text"> The admin has released payment for gig </span> <strong>'.ucfirst(str_replace("-"," ",$title)).'</strong>   
                    <span class="time">- '.$time_taken.' </span>
                    </a>
                    <span title="Delete" class="noti-close"><i class="fa fa-times" onclick = "hide_notification()" ></i></span>
                    </li>';   
                      echo $html;
            }
            elseif ($notifications['status']=='to_user')   
            {
                $data = array('notification_status'=>0);
                $this->db->where('id',$notifications['id']);
                $this->db->update('feedback',$data);
                $html = '<li id="remove_feedback_'.$notifications['id'].'" class="list-group-item">
                    <a href="'.base_url().'purchases" class="notify-content">                            
                    <img width="32" class="img-circle" src="'.$image.'" alt="'.$username.'">                        
                    <strong>'.ucfirst($name).'</strong> given reply feedback on </span> <strong>'.ucfirst(str_replace("-"," ",$title)).'</strong>   
                    <span class="time">- '.$time_taken.' </span>
                    </a>
                    <span title="Delete" class="noti-close"><i class="fa fa-times" onclick = "hide_notification(\'feedback\','.$notifications['id'].')" ></i></span>
                    </li>';   
                
                 echo $html; 
            }
            elseif ($notifications['status']=='from_user')   
            {
				$id=$notifications['id'];
				$query = $this->db->query("SELECT sent_recieved FROM `feedback` WHERE `id` = $id " );
        		$notificationsdata = $query->row_array();
                 $data = array('notification_status'=>0);
                $this->db->where('id',$notifications['id']);
                $this->db->update('feedback',$data);
                $s1=$notificationsdata['sent_recieved'];
				if($s1==1){
					$rep='reply';
				}else
				{
					$rep='';
				}
                $html = '<li id="remove_feedback_'.$notifications['id'].'" class="list-group-item">
                    <a href="'.base_url().'sales" class="notify-content">                            
                    <img width="32" class="img-circle" src="'.$image.'" alt="'.$username.'">                    
                    <strong>'.ucfirst($name).'</strong> given '.$rep.' feedback on  </span> <strong>'.ucfirst(str_replace("-"," ",$title)).'</strong>   
                    <span class="time">- '.$time_taken.' </span>
                    </a>
                    <span title="Delete" class="noti-close"><i class="fa fa-times" onclick = "hide_notification(\'feedback\','.$notifications['id'].')" ></i></span>
                    </li>';   
                
                 echo $html; 
            }
			elseif ($notifications['status']=='payment_release') 
            {
                 $data = array('notification_paycomplete'=>0);
                $this->db->where('id',$notifications['id']);
                $this->db->update('payments',$data);
                 
                $html = '<li id="remove_payments_'.$notifications['id'].'" class="list-group-item">                    
                    <a href="'.base_url().'gig-preview/'.$title.'" class="notify-content">                            
                    <img width="32" class="img-circle" src="'.$image.'" alt="'.$username.'">
                     <span class="grey-text">Admin released payment for a completed gig <strong>'.ucfirst(str_replace("-"," ",$title)).'</strong>     </span>    
                    <span class="time">- '.$time_taken.' </span>
                    </a>
                    <span title="Delete" class="noti-close"><i class="fa fa-times" onclick = "hide_notification(\'payments\','.$notifications['id'].')"></i></span>
                    </li>';      
                
                echo $html;
                
                 
            }
			 elseif ($notifications['status']=='buyer_cancel') 
            {
                 $data = array('cancel_notification_status'=>0);
                $this->db->where('id',$notifications['id']);
                $this->db->update('payments',$data);
                 
                $html = '<li id="remove_payments_'.$notifications['id'].'" class="list-group-item">                    
                    <a href="'.base_url().'sales" class="notify-content">                            
                    <img width="32" class="img-circle" src="'.$image.'" alt="'.$username.'">
                     <span class="grey-text"> <strong>'.ucfirst($name).'</strong> cancel the gigs of <strong>'.ucfirst(str_replace("-"," ",$title)).'</strong>    </span>    
                    <span class="time">- '.$time_taken.' </span>
                    </a>
                    <span title="Delete" class="noti-close"><i class="fa fa-times" onclick = "hide_notification(\'payments\','.$notifications['id'].')"></i></span>
                    </li>';      
                
                echo $html;
                
                 
            } 
			 elseif ($notifications['status']=='seller_cancelled') 
            {
                 $data = array('cancel_notification_status'=>0);
                $this->db->where('id',$notifications['id']);
                $this->db->update('payments',$data);
                 
                $html = '<li id="remove_payments_'.$notifications['id'].'" class="list-group-item">                    
                    <a href="'.base_url().'purchases" class="notify-content">                            
                    <img width="32" class="img-circle" src="'.$image.'" alt="'.$username.'">
                     <span class="grey-text"> <strong>'.ucfirst($name).'</strong> has accepted the cancel request <strong>'.ucfirst(str_replace("-"," ",$title)).'</strong>    </span>    
                    <span class="time">- '.$time_taken.' </span>
                    </a>
                    <span title="Delete" class="noti-close"><i class="fa fa-times" onclick = "hide_notification(\'payments\','.$notifications['id'].')"></i></span>
                    </li>';      
                
                echo $html;
                
                 
            } 
			 elseif ($notifications['status']=='buyer_accept_seller_declined') 
            {
                 $data = array('cancel_notification_status'=>0);
                $this->db->where('id',$notifications['id']);
                $this->db->update('payments',$data);
                 
                $html = '<li id="remove_payments_'.$notifications['id'].'" class="list-group-item">                    
                    <a href="'.base_url().'sales" class="notify-content">                            
                    <img width="32" class="img-circle" src="'.$image.'" alt="'.$username.'">
                     <span class="grey-text"> <strong>'.ucfirst($name).'</strong> has accepted the declined request <strong>'.ucfirst(str_replace("-"," ",$title)).'</strong>    </span>    
                    <span class="time">- '.$time_taken.' </span>
                    </a>
                    <span title="Delete" class="noti-close"><i class="fa fa-times" onclick = "hide_notification(\'payments\','.$notifications['id'].')"></i></span>
                    </li>';      
                
                echo $html;
                
                 
            }
			elseif ($notifications['status']=='seller_cancel') 
            {
                 $data = array('cancel_notification_status'=>0);
                $this->db->where('id',$notifications['id']);
                $this->db->update('payments',$data);
                 
                $html = '<li id="remove_payments_'.$notifications['id'].'" class="list-group-item">                    
                    <a href="'.base_url().'purchases" class="notify-content">                            
                    <img width="32" class="img-circle" src="'.$image.'" alt="'.$username.'">
                     <span class="grey-text"> <strong>'.ucfirst($name).'</strong> decline the gigs of <strong>'.ucfirst(str_replace("-"," ",$title)).'</strong>    </span>    
                    <span class="time">- '.$time_taken.' </span>
                    </a>
                    <span title="Delete" class="noti-close"><i class="fa fa-times" onclick = "hide_notification(\'payments\','.$notifications['id'].')"></i></span>
                    </li>';      
                
                echo $html;
                
                 
            }
			elseif ($notifications['status']=='cancel_payment_received') 
            {
                 $data = array('notification_paycomplete'=>0);
                $this->db->where('id',$notifications['id']);
                $this->db->update('payments',$data);
                 
                $html = '<li id="remove_payments_'.$notifications['id'].'" class="list-group-item">                    
                    <a href="'.base_url().'gig-preview/'.$title.'" class="notify-content">                            
                    <img width="32" class="img-circle" src="'.$image.'" alt="'.$username.'">
                     <span class="grey-text">Admin released cancel payment for a gig <strong>'.ucfirst(str_replace("-"," ",$title)).'</strong>     </span>    
                    <span class="time">- '.$time_taken.' </span>
                    </a>
                    <span title="Delete" class="noti-close"><i class="fa fa-times" onclick = "hide_notification(\'payments\','.$notifications['id'].')"></i></span>
                    </li>';      
                
                echo $html;
                
                 
            }
			elseif ($notifications['status']=='decline_payment_received') 
            {
                 $data = array('notification_paycomplete'=>0);
                $this->db->where('id',$notifications['id']);
                $this->db->update('payments',$data);
                 
                $html = '<li id="remove_payments_'.$notifications['id'].'" class="list-group-item">                    
                    <a href="'.base_url().'gig-preview/'.$title.'" class="notify-content">                            
                    <img width="32" class="img-circle" src="'.$image.'" alt="'.$username.'">
                     <span class="grey-text">Admin released decline payment for a gig <strong>'.ucfirst(str_replace("-"," ",$title)).'</strong>     </span>    
                    <span class="time">- '.$time_taken.' </span>
                    </a>
                    <span title="Delete" class="noti-close"><i class="fa fa-times" onclick = "hide_notification(\'payments\','.$notifications['id'].')"></i></span>
                    </li>';      
                
                echo $html;
                
                 
            }
			elseif ($notifications['status']=='buyer_cancel_payment') 
            {
                 $data = array('notification_paycomplete'=>0);
                $this->db->where('id',$notifications['id']);
                $this->db->update('payments',$data);
                 
                $html = '<li id="remove_payments_'.$notifications['id'].'" class="list-group-item">                    
                    <a href="'.base_url().'purchases" class="notify-content">                            
                    <img width="32" class="img-circle" src="'.$image.'" alt="'.$username.'">
                     <span class="grey-text">Admin released cancel payment for a gig <strong>'.ucfirst(str_replace("-"," ",$title)).'</strong>     </span>    
                    <span class="time">- '.$time_taken.' </span>
                    </a>
                    <span title="Delete" class="noti-close"><i class="fa fa-times" onclick = "hide_notification(\'payments\','.$notifications['id'].')"></i></span>
                    </li>';      
                
                echo $html;
                
                 
            }
			elseif ($notifications['status']=='buyer_decline_payment') 
            {
                 $data = array('notification_paycomplete'=>0);
                $this->db->where('id',$notifications['id']);
                $this->db->update('payments',$data);
                 
                $html = '<li id="remove_payments_'.$notifications['id'].'" class="list-group-item">                    
                    <a href="'.base_url().'purchases" class="notify-content">                            
                    <img width="32" class="img-circle" src="'.$image.'" alt="'.$username.'">
                     <span class="grey-text">Admin released payment for a gig <strong>'.ucfirst(str_replace("-"," ",$title)).'</strong>     </span>    
                    <span class="time">- '.$time_taken.' </span>
                    </a>
                    <span title="Delete" class="noti-close"><i class="fa fa-times" onclick = "hide_notification(\'payments\','.$notifications['id'].')"></i></span>
                    </li>';      
                
                echo $html;
                
                 
            }
           
        }
    }  else { 
           
                 $html = '<li class="list-group-item">
                    <a href="javascript:;" class="notify-content">                                                                  
                    <p class="text-center m-b-0"> <strong>Sorry !</strong> No Notifications</span></p>
                    </a>                    
                    </li>';   
                
                 echo $html;   
    } ?>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>