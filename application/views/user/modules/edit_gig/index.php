		<?php 	// Setting Price Option 0 - Fixed, 1 - Dynamic.  

			 //$allow	= ($price_option['value'] == 'dynamic')?1:0; 

			 $allow = $gig_details['cost_type'];
			 /*echo "<pre>";
			 print_r($gig_details);
			 exit;*/

		?>

<section class="post-gig-area">	

	<div class="container">		

		<div class="row">

			<div class="col-md-8">                                                   

				<h3 class="post-gig-title">Post a Gig in few seconds</h3>

				<p class="sub-title">Gig: a packed service you can deliver remotely or  around you for a fixed price in a set time frame.</p>

				<input type="hidden" id="payment_option" value="<?php echo $price_option['value']; ?>">	

				<input type="hidden" class="gig_title_valid" value="0">	



				<form id="update_gig"  action="<?php echo base_url()."edit-gig/".$basic_details['title']; ?>" method="post" class="sell-service-form" enctype= "multipart/form-data" >

                

			<input type="hidden" name="country_name" id="country_name" value="">

			<input type="hidden" name="client_timezone" id="client_timezone" value="">

			<input type="hidden" name="full_country_name" id="full_country_name" value="<?php echo (!empty($gig_details['country_name'])?$gig_details['country_name']:'')?>">

			<input type="hidden" name="gig_id" id="gig_id" value="<?php echo $basic_details['id']; ?>" />	

			<input type="hidden" name="dollar_rate" id="dollar_rate" value="<?php echo $dollar_rate; ?>">

			<input type="hidden" name="rupee_rate" id="rupee_rate" value="<?php echo $rupee_rate; ?>">

			<input type="hidden" name="youtube_url" id="youtube_url" value="<?php echo (!empty($gig_details['youtube_url'])?$gig_details['youtube_url']:'')?>">

			<input type="hidden" name="vimeo_url" id="vimeo_url" value="<?php echo (!empty($gig_details['vimeo_url'])?$gig_details['vimeo_url']:'')?>">

			<input type="hidden" name="vimeo_video_id" id="vimeo_video_id" value="<?php echo (!empty($gig_details['vimeo_video_id'])?$gig_details['vimeo_video_id']:'')?>">

					<div class="form-group clearfix">

						<label class="label-title">Title for your Gig <span class="required">*</span></label>

						<div class="name-block">

							<span class="name-input">

								<input type="text" name="gig_title" id="gig_title" onkeyup="gig_title_check(this)" onchange="gig_title_check(this)"  value="<?php echo str_replace('-',' ', $basic_details['title']); ?>" class="form-control gig-name" maxlength="80" placeholder="I can"  >	

							</span>

							<span class="currency">for <span class="currency-group">
								<?php 


								$currency_option = (!empty($basic_details['currency_type']))?$basic_details['currency_type']:'USD';
                   				$rate_symbol = currency_sign($currency_option); 												 

								//$rate = $gig_price;
								$rate = $gig_details['gig_price'];

								?>

								<?php echo $rate_symbol; ?>	 <input type="text" class="form-control amount numberonly" onfocusout="inputfocusout(this)" name="gig_price" id="edit_gig_price" <?php echo ($allow==1)?'':'readonly'; ?> value="<?php echo $rate; ?>">

								</span>

							</span>

						</div>

						<span class="form-description">eg. I can repair a door in Paris </span>

						<small class="error_msg help-block gig_title_error" style="display: none;">Please enter a title</small>

						<small class="error_msg help-block gig_title_already_error" style="display: none;">This tilte is already taken</small>

						<small class="error_msg help-block gig_price_error" style="display: none;">Please enter the price for gig</small>

					</div>

					<div class="form-group delivery-day clearfix">

						<label class="label-title">When will you deliver the Gig? <span class="required">*</span></label>

						<input type="text" name="delivering_time" id="delivering_time" class="form-control" value="<?php echo $basic_details['delivering_time'] ;?>" maxlength="2" onkeyup="max_lenght(this)" placeholder="Just type number of days (ex : 2 Days)"><span id="main_delivery_days" class="actual_delivery_days"> 

						<?php if($basic_details['delivering_time']==1){ echo " Day ";}else{ echo " Days"; } ?>

						</span>

						<small class="error_msg help-block main_delivery_days_error" style="display: none;">Please enter a estimated delivery days</small>

						<small class="error_msg help-block delivery_days_error" style="display: none;">Please enter a Days 1 to 29.</small>

					</div>

                                                  

								<div class="form-group clearfix">

									<label class="label-title">Pick Category <span class="required">*</span></label>

									<div class="category-select">

				<select class="select gig-category" id="gig_category_id" name="gig_category_id">										
				<option value="">--Select--</option>
				<?php                                                                                     
				foreach($categories_subcategories as $cat)
				{ 
				if($cat['parent']==0)

									{

										$query  = $this->db->query("SELECT `CATID` , `name` FROM `categories` WHERE `parent` = ". $cat['CATID']." ");

										$result = $query->result_array(); 

										$result_count = $query->num_rows();

									?>

									<option class="category_main_menu" value="<?php echo $cat['CATID']; ?>" <?php if($cat['CATID'] == $basic_details['category_id'] ) echo "Selected";  ?> > <?php echo $cat['name']; ?> </option>    

									<?php 

										if($result_count>0)

										{

											foreach($result as $sub_category_list)

											{ ?>

												<option class="sub_category_menu" value="<?php echo $sub_category_list['CATID']; ?>" <?php if($sub_category_list['CATID'] == $basic_details['category_id'] ) echo "Selected";  ?> > <?php echo $sub_category_list['name']; ?> </option>    

									<?php   }

										}

									}

								}

                                                                                    ?>

										</select>										 

									<small class="error_msg help-block gig_category_id_error" style="display: none;">Please select a category</small>

									</div>

								</div>



								<div class="form-group clearfix">

									<label class="label-title">Add tags <span class="small-title">(separated with a comma)</span></label>

									<input type="text" placeholder="Enter your tags" name="gig_tags" id="gig_tags" data-role="tagsinput" value="<?php echo $basic_details['gig_tags'] ;?>" class="form-control">	

								</div>

								<div class="form-group add-image clearfix">

                                <?php   $image_values =  implode(',',$images_value) ; 

								$video_details = '';

								if(!empty($video_detail))

								{

										$video_details =  implode(',',$video_detail) ; 

								}

								

								?>

								<input type="hidden" name="image_array" id="image_array" value="" />

								<input type="hidden" name="delete_image_array" id="delete_image_array" value="<?php echo $image_values ?>" />

								<input type="hidden" name="deleted_image_array" id="deleted_image_array" value=""  />

								<input type="hidden" name="image_div_id" id="image_div_id" value="1" />

								<input type="hidden" name="video_array" id="video_array" value="" />

								<input type="hidden" name="delete_video_array" id="delete_video_array" value="<?php echo $video_details ?>" />

								<input type="hidden" name="deleted_video_array" id="deleted_video_array" value=""  />

								<input type="hidden" name="video_div_id" id="video_div_id" value="1" />

									<label class="label-title">Make it fun: upload photos or videos!</label>

									<div class="upload-block">

										<div class="photos-upload image_upload" id="upload_image_btn">

											<div id="show_loader" style="display:none;">

												<img src="<?php echo base_url().'assets/images/loader.gif'; ?>" >

											</div>

											<h4>Upload</h4>

											<p> photos</p>

										</div>

										<div class="photos-upload">

											<div id="video_show_loader" style="display:none;">

												<img src="<?php echo base_url().'assets/images/loader.gif'; ?>" >

											</div>

											<input class="gig-img-upload" id="video_files" name="gig_video" size="20" type="file">

											<h4>Upload </h4>

											<p> Videos </p>                                                                                            

										</div>  

										<div class="embedded"  id="third_party">

											<h4>Embedded</h4>

											<p>from 3rd party sites</p>

										</div>	

									</div>

									<div class="embedded-url" style="display:none">

										<label class="label-title">Add Url</label>

										<input class="form-control" type="text">

									</div>	

								</div>

                                <div class="form-group clearfix uploaded-section"> 

                                <?php 

								if($gig_image_details)

								{

								$row_id = 1;

								$total_loop_count = 1 ; 

								

								foreach($gig_image_details as $gig_images) 

								{ 								

								?>

                                <div id="remove_image_div_<?php echo $row_id ;?>" class="uploaded-img"> 

                                    <img height="68" width="100" class="imageThumb" src="<?php echo base_url().$gig_images['gig_image_tile'] ; ?> " title= "images" />

                                    <a onclick="update_gig(<?php echo $gig_images['id']; ?>,'<?php echo $gig_images['gig_image_tile']; ?>','<?php echo $row_id; ?>','image')"  href="javascript:;" class="uploaded-remove pull-right">

                                    <i class="fa fa-times"></i>

						            </a>

                                </div> 

                                <?php

								$row_id = $row_id + 1 ;  

								} 

								$total_loop_count = $row_id;

								}

								

								

								

								if($gig_video_details)

								{

								$vedio_row_id = 1;

								// $total_loop_count = 1 ; 

								foreach($gig_video_details as $gig_video) 

								{ 								

								?>

                                <div id="remove_video_div_<?php echo $vedio_row_id ;?>" class="uploaded-img"> 

             				    <video  class="img-responsive"  style="height:100px !important; ">

                                <source  src="<?php echo base_url().$gig_video['video_path']?>"; type="video/mp4" codecs="avc1.4D401E, mp4a.40.2">

                                <source  src="<?php echo base_url().$gig_video['video_path']?>"; type="video/webm" codecs="vp8.0, vorbis">"

                                <source  src="<?php echo base_url().$gig_video['video_path']?>"; type="video/ogg" codecs="theora, vorbis">"

                                <source  src="<?php echo base_url().$gig_video['video_path']?>"; type="video/mp4" codecs=\"avc1.4D401E, mp4a.40.2\"></video>                   

						

                                    <a onclick="update_gig(<?php echo $gig_video['id']; ?>,'<?php echo $gig_video['video_path']; ?>','<?php echo $vedio_row_id; ?>','video')"  href="javascript:;" class="uploaded-remove pull-right">

                                    <i class="fa fa-times"></i>

						            </a>

                                </div> 

                                <?php

								$vedio_row_id = $vedio_row_id + 1 ;  

								}								 

								}

								$link = $vimeo_url = $vimeo_link='';	

								$width = '200px';		$height = '100px';							

								if(!empty($gig_details['youtube_url']))

                                    { 



							           $link = $gig_details['youtube_url'];

               						   $result = preg_match_all('~https?://(?:[0-9A-Z-]+\.)?(?:youtu\.be/|youtube(?:-nocookie)?\.com\S*[^\w\s-])([\w-]{11})(?=[^\w-]|$)(?![?=&+%\w.-]*(?:[\'"][^<>]*>|</a>))[?=&+%\w.-]*~ix', $link, $matchs);               

     								    if($result>0)

										   {              

											   foreach($matchs as $key => $vals)

												{   				    

												   if (filter_var($vals[0], FILTER_VALIDATE_URL) === false) 

												   {

													   $url = $vals[0] ;

													   break;

												   }                      

											    }

										   }

									?>

                                 		<div class="uploaded-img" id="remove_youtube_div">		

                                 		<a onclick="remove_third_party_link('remove_youtube_div')" href="javascript:;" class="uploaded-remove pull-right"><i class="fa fa-times"></i></a>															

<?php	

		

		echo "<iframe src=\"https://www.youtube.com/embed/$url\" width=\"".$width."\" height=\"".$height."\" frameborder=\"0\" allowfullscreen></iframe>";

		 

?>

										 

                                        </div>

                                     <?php } 

									  if(!empty($gig_details['vimeo_video_id']))

                                    { 	

                                    	$vimeo_link = $gig_details['vimeo_url'];

									$vimeo_url = 	$gig_details['vimeo_video_id'];				          

									?>

                                 		<div class="uploaded-img" id="remove_vimeo_div">	

                                 		<a onclick="remove_third_party_link('remove_vimeo_div')" href="javascript:;" class="uploaded-remove pull-right"><i class="fa fa-times"></i></a>									 

																

<?php	

		

		echo 	"<iframe src=\"//player.vimeo.com/video/$vimeo_url?portrait=0&color=333\" width=\"".$width."\" height=\"".$height."\" frameborder=\"0\" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>";

?>	

                                        </div>

                                     <?php } ?>

                                <small id="image_video_error_msg" class="error_msg help-block pull-left" ></small>

                                 <small class="error_msg help-block image_error_error" style="display: none;">Please upload a file</small>

                                </div> 

								<div class="form-group item-description clearfix">

									<label class="label-title">Provide more details about your gig <span class="required">*</span></label>

                                   <textarea rows="5" placeholder="Explain in more detail what exactly you will deliver to the Buyer..." name="gig_details" id="gig_details" class="form-control"> <?php echo $basic_details['gig_details']; ?> </textarea><?php echo display_ckeditor($ckeditor_editor); ?>

                                <span class="error_msg help-block" id="desc_err" ></span>

                                <small class="error_msg help-block gig_details_error" style="display: none;">Please enter about your gig details</small>

								</div>

								<div class="form-group clearfix">

									<label class="label-title">Earn extra money - offer optional add-on services to the Buyer</label>

									<div class="add-more-items clearfix">

									<input type="hidden" name="extra_gig_rate_symbol" id="extra_gig_rate_symbol" value="<?php echo $rate_symbol; ?>">

                                    <input type="hidden" name="extra_gig_rate" id="extra_gig_rate" value="<?php echo $extra_gig_price; ?>">

                        <?php 

						$iteration_value = 1;
						$ex_price = 0 ;
						$table_content_row_id = 0 ;
					 
						 if(!empty($extra_gig_details))

						 { 				

						foreach($extra_gig_details as $extra_gigs) { 

						$table_content_row_id = $table_content_row_id + 1;
							$rate = $extra_gig_price;
							// $rate = number_format((float)$rate, 2, '.', '');
							//$rate = ($allow==1)?'':$extra_gig_price;
							$rate = $extra_gigs['extra_gigs_amount']; // Extra gig rate 

						 ?>

                         

                         

     <div class="clearfix extra-gig-option" id="row_id_<?php echo $iteration_value; ?>">

				 <span class="close-offer"><i class="fa fa-times" onclick="remove_edit_gig_div(<?php echo $iteration_value; ?>);" aria-hidden="true"></i></span>

						 <div class="name-block2">

								 <span class="name-input2">

										 	<input type="text" name="extra_gigs[]" id="label_name_<?php echo $iteration_value; ?>" value="<?php echo $extra_gigs['extra_gigs']; ?>" class="form-control gig-name extra_money_price" placeholder="I can" date-no="<?php echo $iteration_value; ?>">	

					             </span>

												<span class="currency">

													for <span class="currency-group">												 

                                                                                                            

  <?php echo $rate_symbol; ?> <input type="text" class="form-control amount numberonly" name="extra_gigs_amount[]" id="label_val_<?php echo $iteration_value; ?>" <?php echo ($allow==1)?'':'readonly'; ?> onfocusout="inputfocusout(this)" value="<?php echo $ex_price = $rate; ?>">

  </span> in <input type="text" value="<?php echo $extra_gigs['extra_gigs_delivery']; ?>" class="form-control amount2 numberonly" onkeyup="extra_gig_days(this,1)" onmouseup="extra_gig_days(this,1)"  name="extra_gigs_delivery[]">

  

												  <span class="sub_delivery_days">Day</span>

												</span>

							 </div>	

	 </div>                          

                           <?php 

						   $iteration_value = $iteration_value + 1;

						   }

	 					 } else { 
					     					$table_content_row_id = $table_content_row_id + 1;
											$country_name= empty($gig_details['country_name'])?$gig_details['country_name']:'';
  	             							//if( $country_name=="IN" ||  $country_name !="IN" )
										 	//{
										    //$rate_symbol = "$";
											$rate = ($allow==1)?'':$extra_gig_price;
											// $rate = number_format((float)$rate, 2, '.', '');
											//}

						 ?>
                  <div class="clearfix extra-gig-option" id="row_id_1">
				 <span class="close-offer"><i class="fa fa-times" onclick="remove_div(1);" aria-hidden="true"></i></span>
         <div class="name-block2">

		<span class="name-input2"><input type="text" name="extra_gigs[]" value="" id="label_name_1" class="form-control gig-name extra_money_price" placeholder="I can" date-no="1"></span>

		<span class="currency">for <span class="currency-group">

		 <?php echo $rate_symbol; ?><input type="text" class="form-control amount numberonly" id="label_val_1" name="extra_gigs_amount[]"  <?php echo ($allow==1)?'':'readonly'; ?> value="<?php echo $ex_price = $rate; ?>">

  </span> in <input type="text" value="1" class="form-control amount2 numberonly" onkeyup="extra_gig_days(this,1)" onmouseup="extra_gig_days(this,1)" name="extra_gigs_delivery[]">

  

			<span class="sub_delivery_days">Day</span>

			</span>

			</div>

			</div>

                         <?php } ?>     

                                                                            

            <div id="add_extra_gig"><input type="hidden" name="table_content" id="table_content" value="<?php echo $table_content_row_id ; ?>"></div>

			<div class="add-more" <?php if($table_content_row_id>9) { ?>  style="display:none" <?php } ?>>	

                 <a href="javascript:;" class="add-more-btn" onclick="add_edit_gig_extra_service('<?php echo ($allow==1)?'':'readonly'; ?>','<?php echo $ex_price; ?>');">+ Add more items</a> 

			</div> 

					

					</div>

				</div>

				<small class="error_msg help-block extra_gigs_validate" style="display: none;">Please enter the price for extra gig</small>

				<small class="error_msg help-block extra_gigs_gig_name" style="display: none;">Please enter the gig name </small>

					

					<div class="form-group clearfix">

					<label class="label-title m-t-10">Super fast Delivery</label>

					<div class="delivery-block clearfix">                                                                                  

					<div class="checkbox checkbox-primary checkbox-inline pull-left">                                                                                            

					<input type="checkbox" name="super_fast_delivery" class="validdays"   id="super_fast_delivery" value="yes" <?php if(

					$basic_details['super_fast_delivery']=='yes'){ echo "checked";} ?> >

					<label for="super_fast_delivery">&nbsp; </label>

					</div>

					<span class="super-fast">Super Fast</span>

					<div class="name-block2 superfast-block">  
					<span class="name-input2"><input name="super_fast_delivery_desc" id="super_fast_delivery_desc"  class="form-control gig-name" placeholder="I can deliver the gigs in 2 days" type="text" value="<?php echo (!empty($basic_details['super_fast_delivery_desc']))?$basic_details['super_fast_delivery_desc']:''; ?>"></span>

					<span class="currency">

						<?php 

						$country_name=!empty($gig_details['country_name'])?$gig_details['country_name']:''; 

						//if( $country_name=="IN" || $country_name!="IN")

						//{

						//$rate_symbol = "$";

						//$rate = $extra_gig_price;

						$superfast_delivery_rate  = $gig_details['super_fast_charges'];

						

						//}

						?>

						for <?php echo $rate_symbol; ?> <span class="currency-group"><input type="text" class="form-control amount numberonly validdays" name="super_fast_charges" value="<?php echo ($superfast_delivery_rate!=0)?$superfast_delivery_rate:''; ?>"></span> in <input type="text"  onkeyup="extra_gig_days(this,2)" onfocusout="inputfocusout(this)" onmouseup="extra_gig_days(this,2)" class="form-control amount2 numberonly" maxlength="2" name="super_fast_delivery_date" id="super_fast_delivery_date" value="<?php echo $basic_details['super_fast_delivery_date']; ?>" >

						<span class="sub_delivery_days">Day</span>

					</span>                                       

					</div>

											</div>

					<small class="error_msg" id="super_fast_delivery_time_error"> </small> 

					<small class="error_msg help-block super_fast_error" style="display: none;" >Please enter a description</small>

					<small class="error_msg help-block super_fast_priece_error" style="display: none;" >Please enter a super fast price</small>

								</div>

								<div class="form-group select-condition clearfix">

									<label class="label-title">How are you planning to work with the Buyer? <span class="required">*</span></label>

									<div class="buyer-option">

										<div class="radio radio-primary">

											<input type="radio" value="0" id="radio3" name="work_option" <?php if ($basic_details['work_option'] == 0) {

                                                echo 'checked=""';

                                            }

                                            ?> >

											<label for="radio3">

												Remotely

											</label>

										</div>

										<div class="radio radio-primary">

											<input type="radio"  value="1" id="radio4" name="work_option" <?php if ($basic_details['work_option'] == 1) {echo 'checked=""'; } ?> >

											<label for="radio4">

												On-site 

											</label>

										</div>

										<small class="error_msg help-block work_option_error" style="display: none;">Please select any option</small>

									</div>

								</div>

								<div class="form-group item-description clearfix">

									<label class="label-title">What do you need from the Buyer to get started <span class="required">*</span></label>

									<textarea rows="4" placeholder="Explain what you will need from the Buyer to deliver the world..." name="requirements" id="requirements" class="form-control"><?php echo $basic_details['requirements']; ?>

									</textarea> <?php echo display_ckeditor($ckeditor_editor_one); ?>

								</div>

								<div class="form-group agreement clearfix">

									<div class="checkbox checkbox-primary checkbox-inline">

										<input type="checkbox" name="terms_conditions" id="terms_conditions" value="terms_conditions" checked="checked">

										<label for="terms_conditions">&nbsp; </label>

									</div>

									I confirm that I am able to deliver this service to Buyers within the delivery time specified.<br>

									I will update or pause my Gig if I can no longer meet this delivery time.<br>

									I understand that late delivery will adversely affect my rankings on <span class="sitename2

									"><?php echo $site_name; ?></span> and will

									entitle the Buyer to a refund. See <a href="<?php echo base_url().'tandc'?>" target="_blank" class="chk-link">  T&amp;Cs </a>



								<small class="error_msg help-block terms_conditions_error" style="display: none;">Please accept terms & conditions</small>

								</div>

							

							<input type="hidden" name="form_submit" value="update"> 

							<a href="javascript:void(0)" onclick="sell_services_update()" class="btn btn-yellow sell_service_submit"  >Post Your Ad</a> 

							</form>

						</div>

						<div class="col-md-4">

							<div class="left-sidebar">	

								<div class="testimonials">	

									<p>"If people understood the banking system they would revolt."</p>

									<span class="client-name">Henry Ford</span>			

								</div>	

								<div class="daily-figures">	

									<span>.</span><br>

									<span><p class="figure-title">“Latest <br>Daily Figures”</p></span>

									<span>.</span><br>	

									<span><i class="fa fa-chevron-down"></i></span>	

								</div>

							</div>

						</div>

					</div>	

				</div>	

			</section>



<div class="modal fade" id="avatar-gig-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" data-backdrop="static" data-keyboard="false" role="dialog">

	<div class="modal-dialog">

		<div class="modal-content">   

			<div class="modal-header">

				<button type="button" class="close" data-dismiss="modal">&times;</button>

				<h4 class="modal-title">Upload Image</h4>

			</div>

			<div class="modal-body">

				<div class="image-editor">

					<input type="hidden" name="select_row_id" id="select_row_id" value="<?php echo $total_loop_count ; ?>" />

					<input type="file" id="fileopen"  name="file" class="cropit-image-input">

					<span class="error_msg help-block" id="error_msg_model" ></span> 

					<div class="cropit-preview"></div>

					<div class="row resize-bottom">

						<div class="col-md-4">

							<div class="image-size-label">Resize image</div>

						</div>

						<div class="col-md-4"><input type="range" class="custom cropit-image-zoom-input"></div>

						<div class="col-md-4 text-right"><button class="btn btn-primary export">Done</button></div>

					</div>

				</div>

			</div>

		</div>

	</div>

</div>

<div class="modal custom-popup fade" id="third-party-gig-modal" aria-hidden="true" aria-labelledby="avatar-modal-label" data-backdrop="static" data-keyboard="false" role="dialog">

	<div class="modal-dialog">

		<div class="modal-content">   

			<div class="modal-header text-center">

				<button type="button" class="close" data-dismiss="modal">&times;</button>

				<h5 class="modal-title"> Edit Video Link </h5>

			</div>

			<div class="modal-body">

				<div class="form-group">

					<label> Youtube Link : </label>	 <input class="form-control" type="url" name="" id="youtube_url_link" value="<?php echo $link; ?>"  />

					<span id ="error_youtube_link" class="error_msg" >  </span>

				</div>

				<div class="form-group">

					<label> Vimeo Link : </label>	 <input class="form-control" type="url" name="" id="vimeo_url_link"  value="<?php echo $vimeo_link; ?>"  />

					<span id ="error_vimeo_link" class="error_msg" >  </span>

				</div>

				<button type="button" class="btn btn-primary logon-btn" id="third_party_videos" value="submit" >Submit</button>

			</div>

		</div>

	</div>

</div>