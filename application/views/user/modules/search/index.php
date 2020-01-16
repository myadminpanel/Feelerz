			<?php  $this->load->view('user/includes/search_include'); ?>

			<section class="profile-section">

				<div class="container">

					<div class="row">	

						<div class="col-md-12">

							<ol class="breadcrumb menu-breadcrumb">

								<li><a href="<?php echo base_url(); ?>">Home</a> <i class="fa fa fa-chevron-right"></i></li>

								 <li class="active"><?php echo $country_name =  @$this->db->get_where('country',array('id'=>$_POST['change_country']))->row()->country; ?></li>        
<!-- 								<li class="active"><?php echo ucfirst($search_value); ?></li>         -->

							</ol>

						</div>

					</div>

					<div class="row">	

						<div class="col-md-12">

                        <?php 


// echo '<pre>'; print_r($search_value); 
						$display_result = "Sorry! No Gigs Found ";
												

						if($total_results!=0 && $total_results>1 ) { 
							$display_result = $total_results . " Gigs found "; 
						} 

						else if($total_results!=0 && $total_results==1) { 
							$display_result = $total_results . " Gig found "; 
						}  ?>

                            <h3 class="header-title"> <?php 
                            echo $display_result;
                            //echo ucfirst($search_value);
                             ?> <span>  <?php //echo $display_result; ?> </span>

                            </h3>

						</div>

					</div>

				</div>

			</section>

			<?php 

            if(($this->session->userdata('SESSION_USER_ID')))

            {

                $user_id = $this->session->userdata('SESSION_USER_ID'); 

                $favorites_list=array();

                foreach ($user_favorites as $value){

                    $favorites_list[]=$value['gig_id'];

                }

            }?>

			<div class="tab-content buy-section">

				<div class="container">

					<div class="row">

                                             <input type="text" name="country_name" id="full_country_name" style="display: none" >

						<div class="col-md-12">                                                    

							<div class="top-pagination">						 

                                <?php echo $links; ?>

							</div>	

						</div>	

					</div>

                                

				<div class="row">

                                    <?php 

                                    if(!empty($list)) {

										$country_name = $this->session->userdata('country_name');										 

										$rupee_rate   = $this->session->userdata('rupee_rate');

 										$dollar_rate   = $this->session->userdata('dollar_rate');								  

										 

                                    foreach($list as $gigs ) 

                                    {

										 $rate  =  $gig_price = $gigs['gig_price']; // Dynamic Price 

                                        

										 $currency = (!empty($gigs['currency_type']))?$gigs['currency_type']:'USD';
										 $rate_symbol = currency_sign($currency);
										 // $rate = $gigs_price['value']; // Fixed Price 
											$username = $gigs['username'];
											$name = '';
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

											if(!empty($gigs['gig_rating']))

											{

											$gig_rating1 = round($gigs['gig_rating']);  

											$gig_rating  = $gig_rating1 *2;  

											} 

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

														<a href="<?php echo base_url().'user-profile/'.$username; ?>"><img src="<?php echo $user_img;?>" title="<?php echo $gigs['fullname']; ?>" alt="" width="50" height="50"></a>

														<a class="author-name" href="<?php echo base_url().'user-profile/'.$username; ?>"><?php echo ucfirst($name); ?></a>

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

													<div class="user-country text-ellipsis"><?php echo ucfirst($gigs['state_name']);?> <?php if($gigs['state_name']!=''){ echo ', ';}?><?php echo ucfirst($gigs['country']); ?></div>	

													<div class="product-currency"></div>	

												</div>

											</div>

										</div>	

                                    </div>

                                    <?php } } else { ?>      

                                    <div class="col-md-12"><p> Sorry ! No Gigs Found  </p></div>

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

			</div>