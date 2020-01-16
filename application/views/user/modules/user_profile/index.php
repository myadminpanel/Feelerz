<?php $this->load->view('user/includes/search_include'); ?>

<section class="profile-section user-profile">

	<div class="container">

		<div class="row">	

			<div class="col-md-10">

				<ol class="breadcrumb menu-breadcrumb">

					<li><a href="<?php echo base_url(); ?>">Home</a>  <i class="fa fa fa-chevron-right"></i> </li>

					<?php 

						

						$login_user_id = $this->session->userdata('SESSION_USER_ID');

						 if($profile['USERID'] == $login_user_id){ ?>

							<li class="active">My Profile</li>        

						<?php }else{ ?>

							<li class="active"> Profile</li>        

						<?php } ?>      

				</ol>

			</div>

		</div>

		<?php if($this->session->userdata('message')) {  ?>

               <div class="alert alert-success text-center fade in" id="flash_succ_message"><?php echo $this->session->userdata('message');?></div>

    <?php   $this->session->unset_userdata('message'); } ?>

		<div class="row">	

			<div class="col-md-12">

				<div class="user-block">

					<?php $image = base_url()."assets/images/avatar-lg.jpg"; if(!empty($profile['user_profile_image'])){ $image = base_url().$profile['user_profile_image'];} 

					  $name = $profile['username'];

							$username = $profile['username'];

							if(!empty($profile['fullname']))

							{

								$name = $profile['fullname'];

							}

					

					?>

					<div class="user-image">

						<img class="img-responsive" height="200" width="200" src="<?php echo $image; ?>" alt="<?php echo $name; ?>" title="<?php echo ucfirst($name); ?>" />

						<?php 

						$login_user_id = $this->session->userdata('SESSION_USER_ID');

						if($profile['USERID'] == $login_user_id){ ?>

						<div class="edit-profile">

							<a href="<?php echo base_url().'profile' ?>" title="Edit Profile" class="btn btn-primary btn-block"><i class="fa fa-pencil"></i> Edit Profile</a> 

						</div>

						<?php } ?>

					</div>

					<div class="user-details">

						<div class="user-name-block">

							<h3 id="uname-edit" class="user-name"><?php echo $name; ?></h3> <span class="user-category">

							</span>

						</div>

						<div class="user-contact">

							<ul class="list-inline">

								<li class="user-rating feedback-area"> <span id="stars-existing" class="starrr" data-rating="<?php echo $user_feedback;?>"></span> <span class="rating-count">(<?php echo $user_feedbackcount;?>)</span></li>

					<?php if(!empty($country_name)) { ?>		
						<li class="user-country2">FROM <?php echo $country_name; ?> <span class="ppcn country <?php echo $country_shortname; ?>"></span></li> <?php } ?>

													<?php 

				  if($this->session->userdata('SESSION_USER_ID')) { if($user_id != $this->session->userdata('SESSION_USER_ID')) { ?>			<li class="contact-list"><a  href="javascript:;" data-toggle="modal" data-target="#message-popup">Contact</a></li>    <?php }  }?>

							</ul>

						</div>

						<div class="user-description">

							<p class="user-desc"><?php echo ucfirst($profile['description']); ?><span class="more-desc"></span></p>

						</div>

						<?php if(!empty($profile['lang_speaks'])) { ?>

						<div class="user-language">

							<span><img src="<?php echo base_url(); ?>assets/images/li-world.png" alt="" width="20" height="20"></span>

							Speaks: <span><?php echo ucfirst($profile['lang_speaks']); ?></span><span>

							<input type="hidden" value="" id="lang_speaks"> 

							</span>

						</div>

						<?php } ?>

					</div>

				</div>

			</div>

		</div>

	</div>

</section>

<section class="location-gigs profile-gigs">

	<div class="container">

		<div class="row">

			<div class="col-md-8" >

			<?php 

			$image = base_url()."assets/images/avatar2.jpg";

			if(!empty($profile['user_thumb_image']))

			{

			$image = base_url().$profile['user_thumb_image'];		

			}

			 ?>

				<h3 class="latest-title"><span><?php echo ucfirst($name); ?>'s gigs&nbsp;&nbsp;</span></h3>

				<span class="loca-dd">

				</span>

			</div>

			<div class="col-md-4">                                                    

				<div class="top-pagination">						 

					<?php echo $links; ?>   

				</div>	

			</div>	

		</div>

		<div class="row">

        	<?php 

				if(($this->session->userdata('SESSION_USER_ID')))

				{

					$user_id = $this->session->userdata('SESSION_USER_ID'); 

					$favorites_list=array();

					foreach ($user_favorites as $value){

						$favorites_list[]=$value['gig_id'];

					}

				}?>

			<?php 

			//$country_name = $this->session->userdata('country_name');

			if(!empty($list))

			{ 
			foreach($list as $gigs ) 
			{

					$currency_option = (!empty($gigs['currency_type']))?$gigs['currency_type']:'USD';
					$rate_symbol = currency_sign($currency_option);
					$rate = $gigs['gig_price'];
					// Setting Gigs Price 
					//$rate = $gig_price;
 				    $username = $gigs['username'];
					$name = $gigs['username'];
					if(!empty($gigs['fullname']))
					{
						$name = $gigs['fullname'];
					}
					$image = "assets/images/2.jpg";
					if(!empty($gigs['gig_image'])) {
					$image = base_url().$gigs['gig_image']; }  
					$user_img = base_url()."assets/images/avatar2.jpg";
					if(!empty($gigs['user_thumb_image']))
					{
					$user_img = base_url().$gigs['user_thumb_image'];    
					}
					$gig_rating=0;
					$gig_rating1=0;
					/* if(!empty($gigs['gig_rating']))
					{
					$gig_rating1 = round($gigs['gig_rating']);  
					$gig_rating  = $gig_rating1 *2;  
					} */
					// Setting Gigs Price 
					$gig_rating = $gig_price;
					$gig_usercount=0;
					if(!empty($gigs['gig_usercount']))

					{

						$gig_usercount  = $gigs['gig_usercount'];  

					}                             

				

				

				?>

			<div class="col-md-3 col-sm-6 product-cols">                                        

				<div class="product">  

					<div class="product-img">

						<a href="<?php echo base_url().'gig-preview/'.$gigs['title']; ?>"><img width="240" height="250" alt="<?php echo $gigs['title']; ?>" src="<?php echo $image; ?>"></a>

						<?php if(($this->session->userdata('SESSION_USER_ID'))) {

								$user_id = $this->session->userdata('SESSION_USER_ID'); 

								if($gigs['user_id'] != $user_id) 

								{  

									if (in_array($gigs['id'], $favorites_list)) {?>

										<div id="favourite_area_list"><a href="javascript:;" class="favourite favourited" title="Remove Favourite" onclick="remove_favourites_list('<?php echo $gigs['id']; ?>','<?php echo $user_id; ?>', this)"><i class="fa fa-heart"></i></a></div>

								<?php } else {?>

										<div id="favourite_area_list"><a href="javascript:;" class="favourite" title="Add Favourite" onclick="add_favourites_list('<?php echo $gigs['id']; ?>','<?php echo $user_id; ?>', this)"><i class="fa fa-heart"></i></a></div>

							<?php }  } }?>

                    </div>

					<div class="product-detail">

						<div class="product-name"><a href="<?php echo base_url().'gig-preview/'.$gigs['title']; ?>"><?php echo ucfirst(str_replace("-"," ",$gigs['title'])); ?></a></div>

						<div class="author">

							<span class="author-img">

								<a href="<?php echo base_url()."user-profile/".$username; ?>"><img src="<?php echo $user_img;?>" title="<?php echo $gigs['fullname']; ?>" alt="" width="50" height="50"></a>

								<a class="author-name" href="<?php echo base_url()."user-profile/".$username; ?>"><?php echo ucfirst($name); ?></a>

							</span>

							<div class="ratings">

								<span class="stars-block star-<?php echo $gig_rating;?>"></span><span class="ratings-count">(<?php echo $gig_usercount;?>)</span>

							</div>

						</div>

						<div class="price-box2">

							<div class="price-inner">

								<div class="rectangle">

									<h2><?php echo $rate_symbol.$rate; ?></h2>

								</div>

								<div class="triangle"></div>

							</div>

						</div>

						<div class="product-det">

							<div class="user-country text-ellipsis"><?php echo ucfirst($gigs['state_name']);?><?php if($gigs['state_name']!=''){ echo ', ';}?><?php echo ucfirst($gigs['country']); ?></div>		

						</div>

					</div>

				</div>	

			</div>

			<?php } } else { ?>      

				<div class="col-sm-12"><p> Sorry! No gigs </p></div>

			<?php } ?>

		</div>

		<div class="row">                                            

			<div class="col-md-12">

				<div class="bottom-pagination">

					<?php echo $links; ?>

				</div>	

			</div>	

		</div>

	</div>

</section>

<section class="user-statistics">

	<div class="container">

		<div class="row">

			<div class="col-md-3 col-xs-6">

				<div class="widget-box clearfix">

					<div class="text-center">

						<h4>New Feedbacks</h4>

						<h2><?php echo $user_feedback;?>/5</h2>

					</div>

				</div>

			</div>

			<div class="col-md-3 col-xs-6">

				<div class="widget-box clearfix">

					<div class="text-center">

						<h4>Since joining</h4>

						

							<?php  

							           

							//$date = new DateTime($user_created, new DateTimeZone($time_zone));

							         // $db_time =  $notifications['created_date'];

										//$db_timezone = $notifications['time_zone'];

										 $time_zones = $this->session->userdata('time_zone');

										$time_taken = $this->notification_model->mylastupdate($user_created,$time_zone,$time_zones);

								/* $date->setTimezone(new DateTimeZone($time_zone));                                                        

								$time = $date->format('Y-m-d H:i:s');                                                        

							 //   echo "posted time :" .$time ;

								

								 date_default_timezone_set($time_zone);

								 $date1= date('Y-m-d H:i:s') ;

							//     echo " Current_time ".$date1;

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

							}            ?> */

					?>	<h2><span><?php echo $time_taken ; ?></span></h2>

					</div>

				</div>

			</div>

			<div class="col-md-3 col-xs-6">

				<div class="widget-box clearfix">

					<div class="text-center">

						<h4>Completed</h4>

						<h2><?php echo $completed_gigs; ?> <span>Gigs</span></h2>

					</div>

				</div>

			</div>

			<div class="col-md-3 col-xs-6">

				<div class="widget-box clearfix">

					<div class="text-center">                                                                           

						<h4>Recent Deliveries</h4>

						<h2><?php echo $completed_gigs; ?> <span>Gigs</span></h2>

					</div>

				</div>

			</div>

		</div>

	</div>

</section>

<?php if(!empty($feedbacks)) { ?> 

<section class="user-feedback">

	<div class="container">

		<div class="feedback-section">

			<div class="view-header clearfix">

				<h3 class="gig-view-title feedback-area">Latest feedbacks  <span id="stars-existing" class="starrr" data-rating="<?php echo $user_feedback;?>"> </span> (<?php echo count($feedbacks);?>)</h3>

			</div>

			<ul class="feedback-list" id="load_more_feeddatashow">

				<?php foreach($feedbacks as $key=>$feedback) { 

				 $query12 = $this->db->query("SELECT time_zone FROM `sell_gigs` WHERE `id` =". $feedback['gig_id']."");

				 $result12 = $query12->row_array();

				 $gig_time_zone = $result12['time_zone'];
				 $gig_time_zone = (!empty($gig_time_zone))?$gig_time_zone:'Asia/Kolkata';
					if($time_zone!=$feedback['time_zone'])

					{ 

						//                echo "Not same";

					$date = new DateTime($feedback['created_date'], new DateTimeZone($feedback['time_zone']));

					$date->setTimezone(new DateTimeZone($time_zone));                                                        

					$time = $date->format('Y-m-d H:i:s');                                                        

				 //   echo "posted time :" .$time ;

					

					 date_default_timezone_set($time_zone);

					 $date1= date('Y-m-d H:i:s') ;

				//     echo " Current_time ".$date1;

						$now = new DateTime($date1);

					//    print_r($now);

						$ref = new DateTime($time);

					//    print_r($ref);

						$diff = $now->diff($ref);

						}

						else 

						{                                                            
						

						date_default_timezone_set($gig_time_zone);

						$now = new DateTime(date('Y-m-d H:i:s'));                                                

						//$now = new DateTime($feedback['created_date']);

						$ref = new DateTime($feedback['created_date']);                                                              

						$diff = $now->diff($ref);                                                                

						}

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

					$time_difference = '';

					//now we just find the difference

					if ($total_seconds == 0)

					{

						$time_difference = 'just now';

					}   

					if ($total_seconds < 60)

					{

						$time_difference = $total_seconds == 1 ? $total_seconds . ' second ago' : $total_seconds . ' seconds ago';

					}       

					if ($total_seconds >= 60 && $total_seconds < $intervals['hour'])

					{

						$total_seconds = floor($total_seconds/$intervals['minute']);

						 $time_difference =  $total_seconds == 1 ? $total_seconds . ' minute ago' : $total_seconds . ' minutes ago';

					}       

					if ($total_seconds >= $intervals['hour'] && $total_seconds < $intervals['day'])

					{

						$total_seconds = floor($total_seconds/$intervals['hour']);

						 $time_difference =  $total_seconds == 1 ? $total_seconds . ' hour ago' : $total_seconds . ' hours ago';

					}   

					if ($total_seconds >= $intervals['day'] && $total_seconds < $intervals['week'])

					{

						$total_seconds = floor($total_seconds/$intervals['day']);

						 $time_difference =  $total_seconds == 1 ? $total_seconds . ' day ago' : $total_seconds . ' days ago';

					}   

					if ($total_seconds >= $intervals['week'] && $total_seconds < $intervals['month'])

					{

						$total_seconds = floor($total_seconds/$intervals['week']);

						 $time_difference =  $total_seconds == 1 ? $total_seconds . ' week ago' : $total_seconds . ' weeks ago';

					}   

					if ($total_seconds >= $intervals['month'] && $total_seconds < $intervals['year'])

					{

						$total_seconds = floor($total_seconds/$intervals['month']);

						 $time_difference =  $total_seconds == 1 ? $total_seconds . ' month ago' : $total_seconds . ' months ago';

					}   

					if ($total_seconds >= $intervals['year'])

					{

						$total_seconds = floor($total_seconds/$intervals['year']);

						 $time_difference =  $total_seconds == 1 ? $total_seconds . ' year ago' : $total_seconds . ' years ago';

					}                                                                     

					$rat_ing = $feedback['rating']; 

					$u_images=base_url().'assets/images/avatar2.jpg';

					if($feedback['user_thumb_image']!='')

					{

						$u_images=base_url().$feedback['user_thumb_image'];

					}

				?>    

				<li class="media">

					<?php // if($gig_user_id!=$feedback['from_user_id']) { ?>

					<a href="<?php echo base_url().'user-profile/'.$feedback['username'];?>" class="pull-left"><img width="26" height="26" alt="" src="<?php echo $u_images;?>"></a>

					<div class="media-body">

						<div class="feedback-info">

							<div class="feedback-author">

								<a href="<?php echo base_url().'user-profile/'.$feedback['username'];?>"><?php echo $feedback['fullname']; ?></a>

								<span> - </span>

								<a href="<?php echo base_url().'gig-preview/'.$feedback['title'];?>"><?php echo str_replace("-"," ",$feedback['title']); ?></a>

							</div>

							<span class="feedback-time"><?php echo $time_difference; ?></span>

						</div>

						<div class="feedback-area" ><p><?php echo $feedback['comment']; ?>  <span id="stars-existing" class="starrr" data-rating="<?php echo $rat_ing;?>"></span></p></div>

						<?php

							$query = $this->db->query("SELECT feedback.*,members.* FROM `feedback` 

														LEFT JOIN members ON members.USERID = feedback.`from_user_id`

														WHERE feedback.`gig_id` = ". $feedback['gig_id'] ." AND feedback.`from_user_id` = ". $feedback['to_user_id'] ." AND feedback.`to_user_id` = ". $feedback['from_user_id'] ." AND feedback.`order_id` = ". $feedback['order_id'] ." AND feedback.`status` = 1" );

							$result = $query->row_array();

						// } else if($gig_user_id==$feedback['from_user_id']) {   

							if(!empty($result)) { 

							$u_imagesone=base_url().'assets/images/avatar2.jpg';

							if($result['user_thumb_image']!='')

							{

								$u_imagesone=base_url().$result['user_thumb_image'];

							}                                  

							if($time_zone!=$feedback['time_zone'])

											{                                                                     

										$date = new DateTime($feedback['created_date'], new DateTimeZone($feedback['time_zone']));

										$date->setTimezone(new DateTimeZone($time_zone));                                                        

										$time = $date->format('Y-m-d H:i:s');   

										

										 date_default_timezone_set($time_zone);

										 $date1= date('Y-m-d H:i:s') ;                                                      

										 

											$now = new DateTime($date1);

											$ref = new DateTime($time);

											$diff = $now->diff($ref);

											}

											else 

											{                                                            

											date_default_timezone_set($gig_time_zone);

											$now = new DateTime(date('Y-m-d H:i:s'));                                                

											//$now = new DateTime($feedback['created_date']);

											$ref = new DateTime($feedback['created_date']);                                                              

											$diff = $now->diff($ref);                                                                

											}

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

											$time_difference = '';

											//now we just find the difference

											if ($total_seconds == 0)

											{

												$time_difference = 'just now';

											}   

											if ($total_seconds < 60)

											{

												$time_difference = $total_seconds == 1 ? $total_seconds . ' second ago' : $total_seconds . ' seconds ago';

											}       

											if ($total_seconds >= 60 && $total_seconds < $intervals['hour'])

											{

												$total_seconds = floor($total_seconds/$intervals['minute']);

												 $time_difference =  $total_seconds == 1 ? $total_seconds . ' minute ago' : $total_seconds . ' minutes ago';

											}       

											if ($total_seconds >= $intervals['hour'] && $total_seconds < $intervals['day'])

											{

												$total_seconds = floor($total_seconds/$intervals['hour']);

												 $time_difference =  $total_seconds == 1 ? $total_seconds . ' hour ago' : $total_seconds . ' hours ago';

											}   

											if ($total_seconds >= $intervals['day'] && $total_seconds < $intervals['week'])

											{

												$total_seconds = floor($total_seconds/$intervals['day']);

												 $time_difference =  $total_seconds == 1 ? $total_seconds . ' day ago' : $total_seconds . ' days ago';

											}   

											if ($total_seconds >= $intervals['week'] && $total_seconds < $intervals['month'])

											{

												$total_seconds = floor($total_seconds/$intervals['week']);

												 $time_difference =  $total_seconds == 1 ? $total_seconds . ' week ago' : $total_seconds . ' weeks ago';

											}   

											if ($total_seconds >= $intervals['month'] && $total_seconds < $intervals['year'])

											{

												$total_seconds = floor($total_seconds/$intervals['month']);

												 $time_difference =  $total_seconds == 1 ? $total_seconds . ' month ago' : $total_seconds . ' months ago';

											}   

											if ($total_seconds >= $intervals['year'])

											{

												$total_seconds = floor($total_seconds/$intervals['year']);

												 $time_difference =  $total_seconds == 1 ? $total_seconds . ' year ago' : $total_seconds . ' years ago';

											}						

										   ?>            

						<div class="media">

							<a href="<?php echo base_url().'user-profile/'.$result['username'];?>" class="pull-left"><img width="26" height="26" alt="" src="<?php echo $u_imagesone;?>"></a>

								<div class="media-body">

									<div class="feedback-info">

										<div class="feedback-author">

											<a href="<?php echo base_url().'user-profile/'.$result['username'];?>"><?php echo $result['fullname']; ?></a>

										</div>

										<span class="feedback-time"><?php echo $time_difference; ?></span>

									</div>

									<p><?php echo $result['comment']; ?></p>

								</div>

						</div>

					<?php  }?>

					</div>

				</li>

				<?php if($key ==1){

					 break;

				}

				} ?>

			</ul>

			<?php if(count($feedbacks)>2){?>

			<div class="more-feedback more_user_feedback">

				<input type="hidden" id="load_more_feedlimit" name="load_more_feedlimit" value="<?php echo count($feedbacks);?>" />

				<input type="hidden" id="load_more_feedid" name="load_more_feedid" value="2" />

				<input type="hidden" id="load_more_gig_userid" name="load_more_gig_userid" value="<?php echo $user_id;?>" />

				<a href="javascript:;" onclick="load_more_userfeedbacks();">More feedbacks</a>

			</div>

			<?php }?>

		</div>                           

	</div>

</section>

	<?php }?> 

<div id="message-popup" class="modal fade custom-popup" role="dialog">

	<div class="modal-dialog">

		<div class="modal-content">

			<button type="button" class="close" data-dismiss="modal">&times;</button>

			<div class="modal-body">

				<div class="msg-user-details">

					<?php  if(!empty($profile['user_thumb_image'])) {

								$user_image = base_url().$profile['user_thumb_image'];

							 }else{

								 $user_image = base_url().'assets/images/avatar2.jpg';

							 }

						  if(!empty($profile['fullname'])) { $name = $profile['fullname'];}

					?>

					<div class="pull-left user-img m-r-10">

						<img src="<?php echo $user_image;?>" alt="" class="w-40 img-circle"><span class="online"></span>

					</div>

					<div class="user-info pull-left">

						<div class="dropdown">

							<a href="javascript:;"><?php echo $name;?></a>

						</div>

						<p class="text-muted m-0"><?php echo $country_name; ?></p>

					</div>

				</div>

				<div class="new-message">

					<div id="_error_" class="text-danger"></div>

					<form id="form_messagecontent_id" method="post" enctype="multipart/form-data" >

						<input type="hidden" name="sell_gigs_userid" id="sell_gigs_userid" value="<?php echo $profile['USERID'];?>"/>						

						<div class="form-group">

							<label class="form-label">Your Message</label>

							<textarea name="chat_message_content" placeholder="Message to <?php echo $name; ?>" required="" id="messageone" class="form-control"></textarea>

						</div>						

					</form>

				</div>

				<button type="submit" name="submit" class="btn btn-primary btn-style" onclick="save_newchat();">Send</button>

			</div>

		</div>

	</div>

</div>