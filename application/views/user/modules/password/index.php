  <?php	$this->load->view('user/includes/search_include'); ?>
  		<section class="profile-section">
				<div class="container">
				<?php if($this->session->userdata('message')) {					 ?>
                     <div class="alert alert-success text-center fade in alert-dismissable" id="flash_succ_message"><?php echo $this->session->userdata('message');?></div>
								<?php } ?>
					<div class="row">	
						<div class="col-md-12">
							<ol class="breadcrumb menu-breadcrumb">
								<li><a href="<?php echo base_url(); ?>">Home</a> <i class="fa fa fa-chevron-right"></i></li>
								<li class="active">My Profile</li>        
							</ol>
						</div>
					</div>
					<div class="row">	
						<div class="col-md-12">
							<div class="user-block"  >
								<div class="user-image">
                                      <div id="crop-avatar">
                	<?php $image =  base_url().'assets/images/avatar-lg.jpg' ;
					if(!empty($profile['user_profile_image']))
					{
						$image = base_url().$profile['user_profile_image'];
					}
					 ?>
                    <div id="profile-avatar"> 
                        <div class="avatar-view" id="img_view" title="Click to change picture">
                      <img style="cursor:pointer;" src="<?php  echo $image; ?>" alt="Avatar">
                     </div>        			 
                     <div class="loading" aria-label="Loading" role="img" tabindex="-1"></div>
                </div> 
                <!-- Cropping modal -->
                <div class="modal fade" id="avatar-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" role="dialog" tabindex="-1">
                  <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                      <form class="avatar-form" action="<?php echo base_url().'prf_crop';?>" enctype="multipart/form-data" method="post">
                        <div class="modal-header">
                          <button class="close" data-dismiss="modal" type="button">&times;</button>
                          <h4 class="modal-title" id="avatar-modal-label">Change Avatar</h4>
                        </div>
                        <div class="modal-body">
                          <div class="avatar-body">
                            <div class="avatar-upload">
                              <input class="avatar-src" name="avatar_src" type="hidden">
                              <input class="avatar-data" name="avatar_data" type="hidden"> 
                               <label for="avatarInput">Local upload</label>
                              <input class="avatar-input" id="avatarInput" name="avatar_file" type="file">
                            </div>
                            <div class="row">
                              <div class="col-md-9">
                                <div class="avatar-wrapper"></div>
                              </div>
                              <div class="col-md-3">
                                <div class="avatar-preview preview-lg"></div>
                                <div class="avatar-preview preview-md"></div>
                                <div class="avatar-preview preview-sm"></div>
                              </div>
                            </div>
                             <div class="row avatar-btns"> 
                              <div class="col-md-3 pull-right">
                                <button class="btn btn-primary btn-block avatar-save" type="submit">Done</button>
                              </div>
                            </div>
                          </div>
                        </div> 
                      </form>
                    </div>
                  </div>
                </div>
                <div class="loading" aria-label="Loading" role="img" tabindex="-1"></div> 
		</div>
									
								</div>
								<div class="user-details">
									<div class="user-name-block">
                                                                            <input type="text" name="show_user_name" id="show_user_name" value="<?php echo $profile['fullname'];  ?>" style="display: none" >
                                                                            <input type="button" name="save" id="save" value="save" style="display: none" >  <input type="button" name="cancel" id="cancel" value="cancel" style="display: none">
										<h3 id="uname-edit" class="user-name"><?php echo ucfirst($profile['fullname']);  ?></h3>
                                                                                <input type="hidden" name="hidden_user_name" id="hidden_user_name" value="<?php echo $profile['fullname'];  ?>" > 
									</div>
									<div class="user-contact">
										<ul class="list-inline">
                                        	 <?php 
											$query_feed = $this->db->query("SELECT AVG(rating),count(id) FROM `feedback` WHERE rating !=0 AND `to_user_id` = ".$profile['USERID']."");
											$fe_count = $query_feed->row_array();
											$rat=0;
											$rat_count=0;
											if($fe_count['AVG(rating)']!='')
											{
											$rat=round($fe_count['AVG(rating)']);
											$rat_count=$fe_count['count(id)'];
											}
											?>
											<li class="user-rating feedback-area"> <span id="stars-existing" class="starrr" data-rating="<?php echo $rat;?>"> </span>(<?php echo $rat_count;?>)</li>
			<?php if(!empty($country_name)) { ?>									<li class="user-country2">FROM <?php echo $country_name; ?> <span class="ppcn country <?php echo $country_shortname; ?>"></span></li> <?php } ?> 
										</ul>
									</div>
									<div class="user-description">
									<p class="user-desc"> <?php echo ucfirst($profile['description']); ?> <span class="more-desc"></span></p>
									</div>
                                      <?php if(!empty($profile['lang_speaks'])) { ?>
									<div class="user-language">
										<span><img src="<?php echo base_url(); ?>assets/images/li-world.png"></span>
                                                                                Speaks: <span id="language_list"><?php echo ucfirst($profile['lang_speaks']);  ?></span> 										<input type="hidden" value="" id="lang_speaks">
										</span>
									</div>
                                    <?php } ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
			<div class="tab-section">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="tab-list">
								<ul>
									<li class="active">
										<a href="#">
											<span class="visible-xxs"><i class="fa fa-key" aria-hidden="true"></i></span> 
											<span class="hidden-xxs">Password</span> 
										</a>
									</li>
									<li>
										<a href="<?php echo base_url().'profile'; ?>">
											<span class="visible-xxs"><i class="fa fa-user" aria-hidden="true"></i></span>
											<span class="hidden-xxs">Profile</span>
										</a>
									</li>
									<li>
										<a href="<?php echo base_url().'payment-settings'; ?>">
											<span class="visible-xxs"><i class="fa fa-money" aria-hidden="true"></i></span>
											<span class="hidden-xxs">Payment Settings</span>
										</a>
									</li>
								</ul>    
							</div>		
						</div>
					</div>
				</div>
			</div>
			<div class="tab-content">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<form id="password_form" action="<?php echo base_url().'password'; ?>" method="POST">
								<div class="row">
									<div class="col-md-9 col-sm-12">
										<div class="form-group">
											<div class="row">
												<div class="col-sm-12">
													<label>Email</label>
													<input type="email" class="form-control" disabled="disabled" value="<?php echo $profile['email']; ?>">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<label>Username</label>
													<input type="text" class="form-control" disabled="disabled" value="<?php echo $profile['username']; ?>">
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label>Current password</label>
													<input type="password" name="current_password" id="current_password" class="form-control" value="">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<label>New password</label>
													<input type="password" name="new_password" id="new_password" class="form-control">
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label>Repeat password</label>
													<input type="password" name="repeat_password" id="repeat_password" class="form-control">
												</div>
											</div>
										</div>
										<div class="text-center">
											<button name="form_submit" class="btn btn-primary save-btn" value="true" type="submit">Save</button>
										</div>
									</div>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>