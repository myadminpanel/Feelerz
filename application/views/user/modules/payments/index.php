<?php 

	$payment_stripe = 0;

	$payment_paypal = 0;



	if(!empty($system_setting)){

		foreach ($system_setting as $system) {

			if($system['key'] == 'stripe_allow'){

				$payment_stripe = $system['value'];

			}

			if($system['key'] == 'paypal_allow'){

				$payment_paypal = $system['value'];

			}

		}

	}	



    	

    	

 ?>

	<div class="">

        <?php $this->load->view('user/includes/search_include'); ?>

        <section class="profile-section">

            <div class="container">

                <div class="row">	

                    <div class="col-md-12">

                        <ol class="breadcrumb menu-breadcrumb">

                            <li><a href="#">Home</a> <i class="fa fa fa-chevron-right"></i></li>

                            <li class="active">My Profile</li>        

                        </ol>

                    </div>

                </div>

                <div class="row">	

                    <div class="col-md-12">

                        <h3 class="page-title">My Payments</h3>

                    </div>

                </div>

            </div>

        </section>

        <div class="tab-section grey-bg">

            <div class="container">

                <div class="row">

                    <div class="col-md-12">

                    	<div class="tab-list payments-tabs">

                            <ul>

                                <li>

									<a href="<?php echo base_url().'purchases';?>">

										<span class="visible-xxs"><i class="fa fa-credit-card" aria-hidden="true"></i> <?php if($order_count>0){?><span class="badge badge-white position-right"><?php echo $order_count ;?></span><?php }?></span> 

										<span class="hidden-xxs">My Purchases <?php if($order_count>0){?><span class="badge badge-white position-right"><?php echo $order_count ;?></span><?php }?></span>

									</a>

								</li>

                                <li>

									<a href="<?php echo base_url().'sales';?>">

										<span class="visible-xxs"><i class="fa fa-shopping-cart" aria-hidden="true"></i> <?php if($sell_order_count>0){?><span class="badge badge-white position-right"><?php echo $sell_order_count;?></span><?php }?></span> 

										<span class="hidden-xxs">My Sales <?php if($sell_order_count>0){?><span class="badge badge-white position-right"><?php echo $sell_order_count;?></span><?php }?></span>

									</a>

								</li>

                                <li class="active">

									<a href="javascript:;">

										<span class="visible-xxs"><i class="fa fa-money" aria-hidden="true"></i> <?php if($wallet_order_count>0){?><span class="badge badge-white position-right"><?php echo $wallet_order_count;?></span><?php }?></span> 

										<span class="hidden-xxs">My Payments <?php if($wallet_order_count>0){?><span class="badge badge-white position-right"><?php echo $wallet_order_count;?></span><?php }?></span>

									</a>

								</li>



								<li>

									<a href="<?php echo base_url().'files';?>">

										<span class="visible-xxs"><i class="fa fa-money" aria-hidden="true"></i></span> 

										<span class="hidden-xxs">My Files</span>

									</a>

								</li>



                            </ul>

                        </div>		

                    </div>

                </div>

            </div>

        </div>

        <div class="tab-content grey-bg">

            <div class="container">

                <div class="row wallet-balance m-b-20">

                    <div class="col-md-6">

                        <div class="withdraw-amount">

                         <?php

						 $country_name = $this->session->userdata('country_name');

						 $rupee_rate  = $this->session->userdata('rupee_rate');

			  			$dollar_rate = $this->session->userdata('dollar_rate');

						 $t_amount=0;

						 $tl_amount=0;

						 $total_amount = 0;

						 $total_amount1 = 0;

						 $rate_symbol = '';
						 $all_sources = array();
						 if(!empty($order_details)) 

						 {

							foreach($order_details as $item_am) {
								
								$all_sources[] = $item_am['source'];

								if($item_am['payment_status']!=2)

								{

									$c_amounts =$item_am['item_amount'];		

									

									$commision_rate = (($c_amounts*$item_am['commision'])/100);

										$c_amount = $c_amounts - $commision_rate ;							

									$t_amount = $c_amount;

									$dollar_amount= $item_am['dollar_amount'];

									$t_amount = $c_amount;
 									$currency_option = (!empty($item_am['currency_type']))?$item_am['currency_type']:'USD';
									$rate_symbol = currency_sign($currency_option);	

									$total_amount += $t_amount;

								}

										

								if($item_am['payment_status']==0){

									$cls_amount =$item_am['item_amount'];

									$commision_rates = (($cls_amount*$item_am['commision'])/100);

										$cl_amount = $c_amounts - $commision_rates ;	

									$dl_amount =$item_am['dollar_amount'];

									$tl_amount = $cl_amount;

									$currency_option = (!empty($item_am['currency_type']))?$item_am['currency_type']:'USD';
									$rate_symbol = currency_sign($currency_option);	
 

												$tl_amount = $tl_amount;

											 

											

											$total_amount1 += $tl_amount;

								}

							}

						 }?>

                            <span class="unit-price">Current Balance:</span> <span class="price-tag"><?php echo $rate_symbol ;?><?php echo $total_amount;?></span>

                        </div>

                    </div>

                    <?php if($total_amount1>0){

                    	$all_sources = array_unique($all_sources);
						$asc = count($all_sources);
                    ?>

					<div class="col-md-6 text-right">

						<a href="javascript:;" data-sources="<?php echo implode('-', $all_sources); ?>" onclick="withdraw_all(this,'<?php echo $asc; ?>');" class="withdraw_all_sources btn btn-primary btn-border text-uppercase bold">Request entire amount</a>

                    </div>

                    <?php }?>

                </div>

                <div class="row">

                    <div class="col-md-12">

                        <div class="table-responsive order-table">

                            <table class="table table-actions-bar">

                                <thead>

                                    <tr>

                                        <th>Order Date</th>

                                        <th>Order ID</th>

                                        <th>Buyer</th>

                                        <th>Payment</th>

                                        <th>Amount</th>

                                    </tr>

                                </thead>



                                <tbody>

                                <?php

								 if(!empty($order_details)) 

								 {								

									 		$country_name = $this->session->userdata('country_name');

											$rupee_rate  = $this->session->userdata('rupee_rate');

											$dollar_rate  = $this->session->userdata('dollar_rate');

								 	

									foreach($order_details as $item) { 	

										 $source = $item['source']; 

                                         $seller_id = $item['seller_id']; 


$currency_option = (!empty($item['currency_type']))?$item['currency_type']:'USD';
$rate_symbol = currency_sign($currency_option);

								  			

									$rates = $item['item_amount'];

									$commision_rate = (($rates*$item['commision'])/100);

										$rate = $rates - $commision_rate ;

									//$rate = number_format((float)$rate, 2, '.', '');

											 

											

									$f_uid = $item['user_id'];

									$t_uid = $item['USERID'];

									$gid   = $item['gigs_id'];

									$id    = $item['id'];

									$status = $item['payment_status']; 

									if($status ==1) {

										$sts='<b class="text-danger">Request Sent</b>';

									}elseif($status ==2){

										$sts='<b class="text-success">Payment Received</b>';

									}else{

										$single ="'";

										$sts='<a href="javascript:;" onclick="withdram_model('.$id.','.$single.$source.$single.','.$seller_id.')" class="btn btn-primary btn-border btn-sm">Withdraw Amount</a>';

									}

									

									$created_on = '-';

									if (isset($item['created_at'])) {

										if (!empty($item['created_at']) && $item['created_at'] != "0000-00-00 00:00:00") {

											$created_on = date('j F Y g:i', strtotime($item['created_at']));

										}

									}

									if($item['gig_image_thumb']!='')

											{

												$image_url=base_url().$item['gig_image_thumb'];

											}

											else

											{

												$image_url='assets/images/gig-small.jpg';

											}

											$user_linkone=base_url().'user-profile/'.$item['username'];

								?>

                                    <tr>

                                        <td>

                                            <div class="product-group">

                                                <div class="pro_img">

                                                    <a href="javascript:;" onclick="wallets_view(<?php echo $item['id'];?>)"><img src="<?php echo $image_url;?>" alt="" width="50" height="34"></a>

                                                </div>

                                                <div class="pull-left">

                                                    <h4 class="product-name2" ><a href="javascript:;" onclick="wallets_view(<?php echo $item['id'];?>)"><?php echo ucfirst(str_replace("-"," ",$item['title'])); ?></a></h4> <span class="order_date"><?php echo $created_on;?></span> 

                                                </div>

                                            </div>

                                        </td>

                                        <td><a href="javascript:;" onclick="wallets_view(<?php echo $item['id'];?>)"><?php echo $item['id'];?></a></td>

                                        <td>

                                            <a href="<?php echo $user_linkone;?>" class="text-dark"><b><?php echo ucfirst($item['fullname']);?></b></a>

                                        </td>

                                        <td><?php echo $sts;?></td>

                                        <td><b><?php echo $rate_symbol.$rate;?></b></td>

                                    </tr>

                                    <?php

									}

								 

									 }

									 

									 else { ?>

                                    <tr>

                                        <td colspan="5"><p class="text-center text-danger m-b-0">No Records Found</p></td>

                                    </tr>

                                    <?php } ?>

                                </tbody>

                            </table>

                        </div>

                    </div>

                </div>

                <div class="row">

                    <div class="col-md-12">

                        <div class="bottom-pagination">

                            <ul class="pagination pagination-sm">

                                <li><?php echo $links; ?></li>  

                            </ul>

                        </div>	

                    </div>	

				</div>

            </div>

		</div>

			<div id="purchase-popup" class="modal fade custom-popup order-popup" role="dialog">

				<div class="modal-dialog">

					<div class="modal-content" id="purchases_model_deatils"></div>

				</div>

			</div>

            <div id="message-popup" class="modal fade custom-popup" role="dialog">

				<div class="modal-dialog">

					<div class="modal-content">

						<button type="button" class="close" data-dismiss="modal">&times;</button>

						<div class="modal-body">

						<div class="msg-user-details" id="msg-user-details"></div>

							<div class="new-message">

                            <div id="_error_"></div>

							<form id="form_messagecontent_id" method="post" enctype="multipart/form-data" >

                            <input type="hidden" name="sell_gigs_userid" id="sell_gigs_userid" value=""/>						

								<div class="form-group">

									<label class="form-label">Your Message</label>

									<textarea name="chat_message_content" placeholder="Message" required="" id="messageone" class="form-control"></textarea>

								</div>						

							</form>

						</div>

						<button type="submit" name="submit" class="btn btn-primary btn-style" onclick="save_newchat();">Send</button>

						</div>

					</div>

				</div>

			</div>

     </div>

     <div id="withdraw-popup" class="modal fade custom-popup grey-popup" role="dialog">

				<div class="modal-dialog">

					<div class="modal-content">

						<button type="button" class="close" data-dismiss="modal">&times;</button>

						<div class="modal-header text-center">

							<h5>Withdraw Amount</h5>

						</div>

						<div class="modal-body">

							<div class="table-responsive" id="wallets_gigs_details"></div>

							 <div id="payment-method">

								<h4 class="clearfix">Select your payment method</h4>

									<div class="payment-method">

										<p>

										

									<?php  if($payment_paypal == 1){ ?>

									<span class="remove_paypal">

									<input class="le-radio" type="radio" name="group2" value="Direct" id="request_payment_method"> <img src="assets/images/paypal-icon.png" alt="Paypal">

									<label class="radio-label bold ">Paypal</label>

									</span>

									<?php } ?>



									<?php  if($payment_stripe == 1){ ?>

									<span class="remove_stripe">

									<input class="le-radio" type="radio" name="group2" value="stripe" id="request_payment_method">

									<label class="radio-label bold ">Stripe</label>

									</span>

									<?php } ?>

									</p>



									</div>

							</div> 

							<div class="row">

								<div class="col-md-12">

									<div class="withdraw-amount">

										<span class="unit-price">Requested Amount :</span><span class="price-tag"><?php echo $rate_symbol ?></span><span class="price-tag" id="wallets_request_amount"></span>

									</div>

								</div>

							</div>

							<div class="withdraw-btn">

                            	<input type="hidden" name="request_payment_id" id="request_payment_id" value="" />

                            	<button type="button" onclick="payment_request();" class="btn btn-primary btn-border">Request Withdraw</button>

							</div>

						</div>

						<div class="modal-footer text-left">

							<div class="media secure-money">

								<div class="media-left">

									<img width="46" height="40" src="assets/images/secure-money.png" alt="">

								</div>

								<div class="media-body">

									<span>Your deposit will be securely held in Escrow until you are happy to release it to the Seller upon Hourlie completion.</span>

								</div>

							</div>

						</div>

					</div>

				</div>

			</div>

            <div id="withdraw-redirect-popup" class="modal fade custom-popup grey-popup" role="dialog">

				<div class="modal-dialog">

					<div class="modal-content">

						<button type="button" class="close" data-dismiss="modal">&times;</button>

						<div class="modal-header text-center">

							<h5>Withdraw Amount</h5>

						</div>

						<div class="modal-body">

							<div class="table-responsive" id="wallets_gigs_details"></div>

							 <div id="payment-method">

								<div class="alert alert-danger text-center">

									<strong>You have not entered your bank account details.<br/>Please click the button below to add your account payment details. </strong>

								</div>

								<div class="text-center"><a href="javascript:void(0)" data-toggle="modal" data-target="#paypal-popup" class="btn btn-primary"onclick="checkandfillaccount()" >Add account details</a></div>

							</div> 							 

						</div>

						<div class="modal-footer text-left">

							<div class="media secure-money">

								<div class="media-left">

									<img width="46" height="40" src="assets/images/secure-money.png" alt="">

								</div>

								<div class="media-body">

									<span>Your deposit will be securely held in Escrow until you are happy to release it to the Seller upon Hourlie completion.</span>

								</div>

							</div>

						</div>

					</div>

				</div>

			</div>

			<div id="paypal-popup" class="modal fade custom-popup" role="dialog">

				<div class="modal-dialog">

					<div class="modal-content">

						<button type="button" class="close" data-dismiss="modal">&times;</button>

						<div class="modal-header text-center">

							<h4 class="sign-title">Add account detail</h4>

						</div>

						<div class="modal-body">

							<form class="form-horizontal" id="bank_details_form">

                            	<div class="error_msg text-center" id="paypal_errormsg"></div>

							

								<div class="form-group paypal_input_content">

									<label class="col-lg-4">Paypal Email Id</label>

									<div class="col-lg-8">

										<input type="text" id="user_paypal_id" name="user_paypal_id" class="form-control paypal_input">

									</div>

								</div>



								<div class="form-group stripe_input_content">

									<label class="col-lg-4">The Account Holders Name</label>

									<div class="col-lg-8">

									<input type="text" id="account_holder_name" name="account_holder_name" class="form-control stripe_input">

									</div>

								</div>

								<div class="form-group stripe_input_content">

									<label class="col-lg-4">Account Number</label>

									<div class="col-lg-8">

										<input type="text" id="account_number" name="account_number" class="form-control stripe_input">

									</div>

								</div>

								<div class="form-group stripe_input_content">

									<label class="col-lg-4">IBAN</label>

									<div class="col-lg-8">

										<input type="text" id="account_iban" name="account_iban" class="form-control stripe_input">

									</div>

								</div>

								<div class="form-group stripe_input_content">

									<label class="col-lg-4">Bank Name</label>

									<div class="col-lg-8">

										<input type="text" id="bank_name" name="bank_name" class="form-control stripe_input">

									</div>

								</div>

								<div class="form-group stripe_input_content">

									<label class="col-lg-4">Bank Address</label>

									<div class="col-lg-8">

										<input type="text" id="bank_address" name="bank_address" class="form-control stripe_input">

									</div>

								</div>

								<div class="form-group stripe_input_content">

									<label class="col-lg-4">Sort Code(UK)</label>

									<div class="col-lg-8">

										<input type="text" id="sort_code" name="sort_code" class="form-control stripe_input" placeholder="UK Bank code (6 digits usually displayed as 3 pairs of numbers)">

									</div>

								</div>

								<div class="form-group stripe_input_content">

									<label class="col-lg-4">Routing Number(US)</label>

									<div class="col-lg-8">

										<input type="text" id="routing_number" name="routing_number" class="form-control stripe_input" placeholder="The American Bankers Association Number (consists of 9 digits) and is also called a ABA Routing Number">

									</div>

								</div>

								<div class="form-group stripe_input_content">

									<label class="col-lg-4">IFSC Code(Indian)</label>

									<div class="col-lg-8">

										<input type="text" id="account_ifsc" name="account_ifsc" class="form-control stripe_input" placeholder="Financial System Code, which is a unique 11-digit code that identifies the bank branch i.e. ICIC0001245">

									</div>

								</div>







								<div class="form-group">

									<div class="col-lg-6"><p class="text-danger error_note" ></p></div>

									<div class="col-lg-6"><button type="button" onclick="user_paypal_submit()" id="payment_btn" class="btn btn-primary logon-btn pull-right">Save</button></div>

								</div>

							</form>

						</div>

					</div>

				</div>

			</div>

            <div id="withdraw-all" class="modal fade custom-popup grey-popup" role="dialog">

				<div class="modal-dialog">

					<div class="modal-content">

						<button type="button" class="close" data-dismiss="modal">&times;</button>

						<div class="modal-header text-center">

							<h5>Withdraw Amount</h5>

						</div>

						<div class="modal-body">

							<div class="row">

								<div class="col-md-12">

									<div class="withdraw-amount">

                                    <?php

                                     $tot_amount=0;

                                     $pay_throught = '';

									 if(!empty($order_details)) 

									 {

										foreach($order_details as $item_am) {

											if($item_am['payment_status']==0){

												$c_amount = $item_am['item_amount'];

												$pay_throught = strtolower($item_am['source']);

												$tot_amount =$tot_amount+$c_amount;

											}

											

										}

									 }?>

										<span class="unit-price">Available Balance :</span> <span class="price-tag"><?php echo $rate_symbol.$total_amount1;?></span>

									</div>

								</div>

							</div>

							<form>

							 <div id="payment-method">

								<h4 class="clearfix">Select your payment method</h4>

									<div class="payment-method">

										

										<?php  if($payment_paypal == 1){ ?>

											<input class="le-radio" type="radio" name="group2" value="Direct" checked="checked"> <img src="assets/images/paypal-icon.png" alt="Paypal">

											<label class="radio-label bold ">Paypal</label>

										<?php } ?>



										<?php  if($payment_stripe == 1){ ?>

											<input class="le-radio" type="radio" name="group2" value="stripe">

											 <strong class="text-primary">Stripe</strong>

										<?php } ?>

										

										



									</div>

							</div> 

									<div>

										<button type="button" onclick="overall_payment_request()" class="btn btn-primary btn-border">Request Withdraw</button>

									</div>

								</form>

						</div>

						<div class="modal-footer text-left">

							<div class="media secure-money">

								<div class="media-left">

									<img width="46" height="40" src="assets/images/secure-money.png" alt="">

								</div>

								<div class="media-body">

									<span>Your deposit will be securely held in Escrow until you are happy to release it to the Seller upon Hourlie completion.</span>

								</div>

							</div>

						</div>

					</div>

				</div>

			</div>

     

     

			

			

			

			

            

            

		