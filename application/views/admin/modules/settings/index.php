<div class="content-page">

    <div class="content">

        <div class="container">

            <div class="row">

                <div class="col-sm-12">

                    <h4 class="page-title m-b-20 m-t-0">Settings </h4>

                </div>

            </div>

			<?php if($this->session->flashdata('message')) { ?>

			<?php echo $this->session->userdata('message'); ?>

			<?php } ?>

            <div class="row">

                <div class="col-lg-12">

                    <div class="card-box">

						<form class="form-horizontal" action="" method="POST" enctype="multipart/form-data">

							<div>

								<ul class="nav nav-tabs navtab-bg nav-justified">

									<li class="active tab"><a href="#general" data-toggle="tab">General</a></li>

									<li class="tab"><a href="#seo" data-toggle="tab">SEO</a></li>

									<li class="tab"><a href="#social_links" data-toggle="tab">Social Links</a></li>

									<li class="tab"><a href="#push_notification" data-toggle="tab">Push Notification</a></li>

									<li class="tab"><a href="#payment_setting" data-toggle="tab">Payments</a></li>

								</ul>

								<div class="tab-content">

									<div id="general" class="tab-pane active">

										<div class="form-group">

											<label class="col-sm-3 control-label">Website Name</label>

											<div class="col-sm-9">

												<input type="text" class="form-control" id="website_name" name="website_name" placeholder="Dreamguy's Technologies" value="<?php if (isset($website_name)) echo $website_name;?>">

											</div>

										</div>

										<div class="form-group">

											<label class="col-sm-3 control-label">Base domain</label>

											<div class="col-sm-9">

												<input type="text" class="form-control" id="base_domain" readonly="" name="base_domain" placeholder="https://www.dreamguys.co.in/" value="<?php if (isset($base_domain)) echo $base_domain;?>">

											</div>

										</div>

										<div class="form-group">

											<label class="col-sm-3 control-label">Website Slogan</label>

											<div class="col-sm-9">

												<input type="text" class="form-control" id="website_slogan" name="website_slogan" placeholder="Service Marketplace" value="<?php if (isset($website_slogan)) echo $website_slogan;?>">

											</div>

									</div>





									<div class="form-group">

											<label class="col-sm-3 control-label">Currency</label>

											<div class="col-sm-9">

												<div class="input-group">

								<?php 
									$sell_gigs_total = $this->db->count_all_results('sell_gigs');
									$payments_total  = $this->db->count_all_results('payments');
									$currency_option = (!empty($currency_option))?$currency_option:'USD';
									if($sell_gigs_total == 0 && $payments_total == 0 ){		
							 ?>

									      <select class="form-control" name="currency_option" id="currency_option" required>

                                            <option value="USD" <?php echo ($currency_option=='USD')?'selected':''; ?>>USD</option>

                                            <option value="EUR" <?php echo ($currency_option=='EUR')?'selected':''; ?>>EUR</option>

                                            <option value="GBP" <?php echo ($currency_option=='GBP')?'selected':''; ?>>GBP</option>

                                          </select>
                                           <?php }else{ ?>
                                          	<p><strong><?php echo $currency_option; ?></strong></p>
                                          <?php }  ?>

											</div>

											</div>

									</div>

									<?php 

										$currency_sign = '$';

										if(!empty($currency_option)=='USD'){

											$currency_sign = '$';

										}

										if(!empty($currency_option)=='EUR'){

											$currency_sign = '€';

										}

										if(!empty($currency_option)=='GBP'){

											$currency_sign = '£';

										}





									if(!isset($price_option)){

										$price_option = 'fixed';

									} ?>	



									<div class="form-group">

											<label class="col-sm-3 control-label">Price Option</label>

											<div class="col-sm-9">

												<div class="input-group">

													<select class="form-control" name="price_option" onchange="priceoption(this)">

														<option value="fixed" <?php echo ($price_option=='fixed')?'selected':''; ?>>Fixed</option>

														<option value="dynamic" <?php echo ($price_option=='dynamic')?'selected':''; ?> >Dynamic</option>

													</select>

												</div>

												<span class="help-block small">Seller can add dynamic price, choose dynamic price option</span>

											</div>

										</div>



										<div class="form-group fixed_price" <?php echo ($price_option=='dynamic')?'style="display:none"':''; ?> >

											<label class="col-sm-3 control-label">Base Gig Price</label>

											<div class="col-sm-9">

												<div class="input-group">

													<span class="input-group-addon"><?php echo $currency_sign; ?></span>

													<input type="text" class="form-control numberonly" id="base_gig_price" maxlength="5" <?php echo ($price_option=='fixed')?'required':''; ?> name="gig_price" value="<?php if (isset($gig_price)) echo $gig_price;?>">

												</div>

											</div>

										</div>

										<div class="form-group fixed_price" <?php echo ($price_option=='dynamic')?'style="display:none"':''; ?> >

											<label class="col-sm-3 control-label">Base Extra Gig Price</label>

											<div class="col-sm-9">

												<div class="input-group">

													<span class="input-group-addon"><?php echo $currency_sign; ?></span>

													<input type="text" class="form-control numberonly" id="base_extra_gig_price" maxlength="5" <?php echo ($price_option=='fixed')?'required':''; ?>  name="extra_gig_price"  value="<?php if (isset($extra_gig_price)) echo $extra_gig_price;?>">

												</div>

											</div>

										</div>

										<div class="form-group">

											<label class="col-sm-3 control-label">Admin's Commision %</label>

											<div class="col-sm-9">

												<div class="input-group">

													<span class="input-group-addon">%</span>

													<input type="text" class="form-control numberonly" onkeyup="this.value = fnc(this.value, 0, 50)" required id="admin_commision" name="admin_commision" value="<?php if (isset($admin_commision)) echo $admin_commision;?>">

												</div>

											</div>

										</div>

										<div class="form-group">

											<label class="col-sm-3 control-label">Website Logo</label>

											<div class="col-sm-9">

												<div class="media">

													<div class="media-left">

														<?php if (!empty($logo_front)){ ?><img src="<?php echo base_url().$logo_front?>" class="site-logo" /><?php } ?>

													</div>

													<div class="media-body">

														<div class="uploader"><input type="file" id="site_logo" multiple="true"  class="form-control" name="site_logo" placeholder="Select file"></div>

														<span class="help-block small">Recommended image size is <b>150px x 150px</b></span>

													</div>

												</div>

												<div id="img_upload_error" class="text-danger"  style="display:none">Please upload valid image file.</b></div>

											</div>

										</div>

										<div class="form-group">

											<label class="col-sm-3 control-label">Favicon</label>

											<div class="col-sm-9">

												<div class="media">

													<div class="media-left">

														<?php if (!empty($favicon)){ ?><img src="<?php echo base_url().'uploads/logo/'.$favicon?>" class="fav-icon" /><?php } ?>

													</div>

													<div class="media-body">

														<div class="uploader"><input type="file"  multiple="true"  class="form-control" id="favicon" name="favicon" placeholder="Select file"></div>

														<span class="help-block small">Recommended image size is <b>16px x 16px</b> or <b>32px x 32px</b></span>

														<span class="help-block small">Accepted formats: only png and ico</span>

													</div>

												</div>

												<div id="img_upload_errors" class="text-danger" style="display:none">Please upload valid image file.</div>

											</div>

										</div>

										<div class="form-group">

											<label class="col-sm-3 control-label">Google analytics code</label>

											<div class="col-sm-9">

												<input type="text" class="form-control" id="google_analytics_code" name="google_analytics_code" value="<?php if (isset($google_analytics_code)) echo $google_analytics_code;?>">

											</div>

										</div>

									</div>

									<div id="seo" class="tab-pane">

										<div class="form-group">

											<label class="col-sm-3 control-label">Meta title</label>

											<div class="col-sm-9">

												<input type="text" class="form-control" id="mete_title" name="meta_title" value="<?php if (isset($meta_title)) echo $meta_title;?>">

											</div>

										</div>

										<div class="form-group">

											<label class="col-sm-3 control-label">Meta keywords</label>

											<div class="col-sm-9">

												<input type="text" class="form-control" id="meta_keywords" name="meta_keywords" value="<?php if (isset($meta_keywords)) echo $meta_keywords;?>">

											</div>

										</div>

										<div class="form-group">

											<label class="col-sm-3 control-label">Meta description</label>

											<div class="col-sm-9">

												<textarea class="form-control" rows="6" id="meta_description" name="meta_description"><?php if (isset($meta_description)) echo $meta_description;?></textarea>

											</div>

										</div>

									</div>

									<div id="social_links" class="tab-pane">

										<div class="form-group">

											<label class="col-sm-3 control-label">FaceBook</label>

											<div class="col-sm-9">

												<input type="text" class="form-control" id="facebook" name="facebook" placeholder="https://www.facebook.com" value="<?php if (isset($facebook)) echo $facebook;?>">

											</div>

										</div>

										<div class="form-group">

											<label class="col-sm-3 control-label">Twitter</label>

											<div class="col-sm-9">

												<input type="text" class="form-control" id="Twitter" name="twitter" placeholder="https://www.twitter.com" value="<?php if (isset($twitter)) echo $twitter;?>">

											</div>

										</div>

										<div class="form-group">

											<label class="col-sm-3 control-label">Google+</label>

											<div class="col-sm-9">

												<input type="text" class="form-control" id="googleplus" name="google_plus" placeholder="https://plus.google.com" value="<?php if (isset($google_plus)) echo $google_plus;?>">

											</div>

										</div>

										<div class="form-group">

											<label 

											class="col-sm-3 control-label">LinkedIn</label>

											<div class="col-sm-9">

												<input type="text" class="form-control" id="LinkedIn" name="linkedIn" placeholder="https://www.linkedin.com" value="<?php if (isset($linkedIn)) echo $linkedIn;?>">

											</div>

										</div>

										<div class="hrs_detail_addmore"></div>

									</div>

									

									<div id="push_notification" class="tab-pane">

										<div class="form-group">

											<label class="col-sm-3 control-label">One Signal Subdomain</label>

											<div class="col-sm-9">

												<input type="text" class="form-control" id="one_signal_subdomain" name="one_signal_subdomain"   value="<?php if (isset($one_signal_subdomain)) echo $one_signal_subdomain;?>">

											</div>

										</div>

										<div class="form-group">

											<label class="col-sm-3 control-label">One Signal AppId</label>

											<div class="col-sm-9">

												<input type="text" class="form-control" id="one_signal_app_id" name="one_signal_app_id"  value="<?php if (isset($one_signal_app_id)) echo $one_signal_app_id;?>">

											</div>

										</div>

										<div class="form-group">

											<label class="col-sm-3 control-label">One Signal Reset Key</label>

											<div class="col-sm-9">

												<input type="text" class="form-control" id="one_signal_reset_key" name="one_signal_reset_key" value="<?php if (isset($one_signal_reset_key)) echo $one_signal_reset_key;?>">

											</div>

										</div>	

									</div>

									<div id="payment_setting" class="tab-pane">



										<h3 class="text-primary">PayPal</h3>

										<div class="form-group">

											<label class="col-sm-3 control-label">PayPal</label>

											<div class="col-sm-9">

												<?php 

												 $ckd1 = 'checked="checked"';

												 $ckd2 = '';

												if (isset($paypal_option)){

													if($paypal_option==1){

														$ckd1 = 'checked="checked"';

												 		$ckd2 = '';

													}

													if($paypal_option==2){

														$ckd1 = '';

												 		$ckd2 = 'checked="checked"';

													}

												} ?>

												<label class="radio-inline">

														<input type="radio" <?php echo $ckd1; ?> name="paypal_option" value="1"> SandBox

												</label>

												<label class="radio-inline">

														<input type="radio" <?php echo $ckd2; ?> name="paypal_option" value="2"> Live

												</label>



											</div>

											<label class="col-sm-3 control-label">PayPal Payment</label>

											<div class="col-sm-9">

												<?php 

												 $ckd1 = 'checked="checked"';

												 $ckd2 = '';

												if (isset($paypal_allow)){

													if($paypal_allow==1){

														$ckd1 = 'checked="checked"';

												 		$ckd2 = '';

													}

													if($paypal_allow==2){

														$ckd1 = '';

												 		$ckd2 = 'checked="checked"';

													}

												} ?>

												<label class="radio-inline">

														<input type="radio" <?php echo $ckd1; ?> name="paypal_allow" value="1"> Active

												</label>

												<label class="radio-inline">

														<input type="radio" <?php echo $ckd2; ?> name="paypal_allow" value="2"> Inactive

												</label>



											</div>



										</div>



											<h3 class="text-primary">Stripe</h3>

										<div class="form-group">

											<label class="col-sm-3 control-label">Stripe Option</label>

											<div class="col-sm-9">

												<?php 

												 $ckd1 = 'checked="checked"';

												 $ckd2 = '';

												if (isset($stripe_option)){

													if($stripe_option==1){

														$ckd1 = 'checked="checked"';

												 		$ckd2 = '';

													}

													if($stripe_option==2){

														$ckd1 = '';

												 		$ckd2 = 'checked="checked"';

													}

												} ?>

												<label class="radio-inline">

														<input type="radio" <?php echo $ckd1; ?> name="stripe_option" value="1"> SandBox

												</label>

												<label class="radio-inline">

														<input type="radio" <?php echo $ckd2; ?> name="stripe_option" value="2"> Live

												</label>



											</div>

											<label class="col-sm-3 control-label">Stripe Payment</label>

											<div class="col-sm-9">

												<?php 

												 $ckd1 = 'checked="checked"';

												 $ckd2 = '';

												if (isset($stripe_allow)){

													if($stripe_allow==1){

														$ckd1 = 'checked="checked"';

												 		$ckd2 = '';

													}

													if($stripe_allow==2){

														$ckd1 = '';

												 		$ckd2 = 'checked="checked"';

													}

												} ?>

												<label class="radio-inline">

														<input type="radio" <?php echo $ckd1; ?> name="stripe_allow" value="1"> Active

												</label>

												<label class="radio-inline">

														<input type="radio" <?php echo $ckd2; ?> name="stripe_allow" value="2"> Inactive

												</label>



											</div>

										</div>

										

										<!-- <div class="form-group">

											<label class="col-sm-12 control-label">SandBox</label>

										</div>	

										<div class="form-group">

											<label class="col-sm-3 control-label">Publishable key</label>

											<div class="col-sm-9">

												<input type="text" class="form-control" id="publishable_key " name="publishable_key"   value="<?php if (isset($publishable_key)) echo $publishable_key;?>">

											</div>

										</div>



										<div class="form-group">

											<label class="col-sm-3 control-label">Secret key</label>

											<div class="col-sm-9">

												<input type="text" class="form-control" id="secret_key" name="secret_key"   value="<?php if (isset($secret_key)) echo $secret_key;?>">

											</div>

										</div>



										<div class="form-group">

											<label class="col-sm-12 control-label">Live</label>

										</div>	

										<div class="form-group">

											<label class="col-sm-3 control-label">Publishable key</label>

											<div class="col-sm-9">

												<input type="text" class="form-control" id="live_publishable_key" name="live_publishable_key"   value="<?php if (isset($live_publishable_key)) echo $live_publishable_key;?>">

											</div>

										</div>



										<div class="form-group">

											<label class="col-sm-3 control-label">Secret key</label>

											<div class="col-sm-9">

												<input type="text" class="form-control" id="live_secret_key" name="live_secret_key"   value="<?php if (isset($live_secret_key)) echo $live_secret_key;?>">

											</div>

										</div>

										<hr /> -->



										<!-- <h3 class="text-primary">Amplifypay</h3>

										<div class="form-group">

											<label class="col-sm-3 control-label">Amplifypay Option</label>

											<div class="col-sm-9">

												<?php 

												 $ckd1 = 'checked="checked"';

												 $ckd2 = '';

												if (isset($amplifypay_option)){

													if($amplifypay_option==1){

														$ckd1 = 'checked="checked"';

												 		$ckd2 = '';

													}

													if($amplifypay_option==2){

														$ckd1 = '';

												 		$ckd2 = 'checked="checked"';

													}

												} ?>

												<label class="radio-inline">

														<input type="radio" <?php echo $ckd1; ?> name="amplifypay_option" value="1"> SandBox

												</label>

												<label class="radio-inline">

														<input type="radio" <?php echo $ckd2; ?> name="amplifypay_option" value="2"> Live

												</label>



											</div>

										</div>

										<div class="form-group">

											<label class="col-sm-12 control-label">SandBox</label>

										</div>	

										<div class="form-group">

											<label class="col-sm-3 control-label">Merchant ID</label>

											<div class="col-sm-9">

												<input type="text" class="form-control" id="amplifypay_merchant_id" name="amplifypay_merchant_id"   value="<?php if (isset($amplifypay_merchant_id)) echo $amplifypay_merchant_id;?>">

											</div>

										</div>



										<div class="form-group">

											<label class="col-sm-3 control-label">API Key</label>

											<div class="col-sm-9">

												<input type="text" class="form-control" id="amplifypay_api_key" name="amplifypay_api_key"   value="<?php if (isset($amplifypay_api_key)) echo $amplifypay_api_key;?>">

											</div>

										</div>



										<div class="form-group">

											<label class="col-sm-12 control-label">Live</label>

										</div>	

										<div class="form-group">

											<label class="col-sm-3 control-label">Merchant ID</label>

											<div class="col-sm-9">

												<input type="text" class="form-control" id="live_amplifypay_merchant_id" name="live_amplifypay_merchant_id"   value="<?php if (isset($live_amplifypay_merchant_id)) echo $live_amplifypay_merchant_id;?>">

											</div>

										</div>



										<div class="form-group">

											<label class="col-sm-3 control-label">API Key</label>

											<div class="col-sm-9">

												<input type="text" class="form-control" id="live_amplifypay_api_key" name="live_amplifypay_api_key"   value="<?php if (isset($live_amplifypay_api_key)) echo $live_amplifypay_api_key;?>">

											</div>

										</div>

 -->



									</div>







								</div>

							</div>

                           <button name="form_submit" type="submit" class="btn btn-primary center-block" value="true">Save Changes</button>

						</form>

					</div>

                </div>

			</div>

		</div>



		<div id="con-close-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">

			<div class="modal-dialog"> 

				<div class="modal-content"> 

					<div class="modal-header"> 

						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button> 

						<h4 class="modal-title">Add More Social Media Link</h4> 

					</div> 

					<div class="modal-body"> 

						<div class="row"> 

							<div class="col-md-6"> 

								<div class="form-group"> 

									<label for="field-1" class="control-label">Label Name</label> 

									<input type="text" class="form-control" id="field-1" placeholder="Type here"> 

								</div> 

							</div> 

						 </div> 

						 <div class="row"> 

							<div class="col-md-6"> 

								<div class="form-group"> 

									<label for="field-2" class="control-label">Field Name</label> 

									<input type="text" class="form-control" id="field-2" placeholder="Type here"> 

								</div> 

							</div> 

						</div> 

					</div> 

					<div class="modal-footer"> 

						<button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 

						<button type="button"  onclick="subitmorefield()" class="btn btn-info">Save</button> 

					</div> 

				</div> 

			</div>

		</div>

 