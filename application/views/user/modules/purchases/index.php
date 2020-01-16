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

                        <h3 class="page-title">My Purchases</h3>

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

                                <li class="active">

									<a href="javascript:;">

										<span class="visible-xxs"><i class="fa fa-credit-card" aria-hidden="true"></i> <?php if($purchases_order_count>0){?><span class="badge badge-white position-right"><?php echo $purchases_order_count;?></span><?php }?></span> 

										<span class="hidden-xxs">My Purchases <?php if($purchases_order_count>0){?><span class="badge badge-white position-right"><?php echo $purchases_order_count;?></span><?php }?></span>

									</a>

								</li>

                                <li>

									<a href="<?php echo base_url().'sales';?>">

										<span class="visible-xxs"><i class="fa fa-shopping-cart" aria-hidden="true"></i> <?php if($order_count>0){?><span class="badge badge-white position-right"><?php echo $order_count;?></span><?php }?></span> 

										<span class="hidden-xxs">My Sales <?php if($order_count>0){?><span class="badge badge-white position-right"><?php echo $order_count;?></span><?php }?></span>

									</a>

								</li>

                                <li>

									<a href="<?php echo base_url().'payments';?>">

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

                <div class="row">

                    <div class="col-md-12">

                                <div class="table-responsive order-table">

                                    <table class="table table-actions-bar">

                                        <thead>

                                            <tr>

                                                <th>Order Title </th>

                                                <th>Order ID</th>

                                                <th>Delivery Date</th>

                                                <th>Seller</th>

                                                <th>Feedback</th>

                                                <th>Order Cancel</th>

                                                <th>Amount</th>

												<th>Order Status</th>

                                            </tr>

                                        </thead>



                                        <tbody>

										<?php

										 if(!empty($order_data)) 

										 {

											$country_name = $this->session->userdata('country_name');

											$rupee_rate  = $this->session->userdata('rupee_rate');

											$dollar_rate  = $this->session->userdata('dollar_rate');

										 

											foreach($order_data as $item) { 	

											 $paypal_uid = $item['paypal_uid'];	

											 $source = $item['source'];		

                                             $ref='';

											 $refclass='';

											 $status = $item['seller_status']; 

                                           	if(($item['payment_status']==2 && ($status==5 || ($status==1 && $item['buyer_status']==1)))){

											    $ref='refunded';

												 $refclass='label label-info';

										   }											   

										
										$currency_option = (!empty($item['currency_type']))?$item['currency_type']:'USD';
										$rate_symbol = currency_sign($currency_option);	 
										$rate = $item['item_amount'];
										$f_uid = $item['user_id'];
										$t_uid = $userid;
										$gid   = $item['gigs_id'];
										$status = $item['seller_status']; 
										$order_id =$item['id'];
										if($status ==0) {

												$sts='Failed';

												$class='label-danger';

											}elseif($status ==1) {

												$sts='New';

												$class='label-success';

												if($item['buyer_status'] ==1) { if($item['cancel_accept'] ==1){

													$sts='Cancelled';

													$class='label-danger';

													if($item['pay_status']=='Payment Processed'){

													$class='label-info';

													}

												}

												}

											}elseif($status ==2){

												$sts='Pending';

												$class='label-warning';

												if($item['buyer_status'] ==1) { if($item['cancel_accept'] ==1){

													$sts='Cancelled';

													$class='label-danger';

													if($item['pay_status']=='Payment Processed'){

													$class='label-info';

													}

												}

												}

											}elseif($status ==3){

												$sts='Process';

												$class='label-primary';

												if($item['buyer_status'] ==1) { if($item['cancel_accept'] ==1){

													$sts='Cancelled';

													$class='label-danger';

													if($item['pay_status']=='Payment Processed'){

													$class='label-info';

													}

												}

												}

											}elseif($status ==4){

												$sts='Refunded';

												$class='label-danger';

											}elseif($status ==5){

												$sts='Declined';

												$class='label-danger';

											}elseif($status ==6){

												$sts='Completed';

												$class='label-success';

											}elseif($status ==7){

												$sts='Completed Accept';

												$class='label-success';

											}



											if($paypal_uid == 'issue'){

												$sts='Failed';

												$class='label-danger';

											}

											



											$fead_stautus=0;

											if($status ==6) {

												

												$query = $this->db->query("SELECT id FROM `feedback` WHERE `from_user_id` = $t_uid and `to_user_id` = $f_uid and `gig_id` = $gid and `order_id` = $order_id;");
												$result = array();
												if($query->num_rows() > 0){
													$result = $query->row_array();	
												}

												$fead_stautus=1; 

												if(!empty($result['id'])){

													$b_sts='See Feedback';

												}else

												{

													$b_sts='Leave Feedback';

												}

											}

											else

											{

												$b_sts='Pending';

											}

											 $created_on = '-';

                                            if (isset($item['created_at'])) {

                                                if (!empty($item['created_at']) && $item['created_at'] != "0000-00-00 00:00:00") {

                                                    $created_on = date('j F Y G:i', strtotime($item['created_at']));

                                                }

                                            }

											$delivery_date='-';

											 if (isset($item['delivery_date'])) {

                                                if (!empty($item['delivery_date']) || !empty($item['delivering_time']) && $item['delivery_date'] != "0000-00-00 00:00:00") {

													$date = strtotime("+".$item['delivering_time']." days", strtotime($item['delivery_date']));

													$delivery_date = date("d M Y", $date);

                                                    //$delivery_date = date('d M Y', strtotime($item['delivery_date']));

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

                                                            <a href="javascript:;" onclick="purchase_view(<?php echo $item['id'];?>)"><img src="<?php echo $image_url;?>" alt="" width="50" height="34"></a>

                                                        </div>

                                                        <div class="pull-left">

                                                            <h4 class="product-name2"><a href="javascript:;" onclick="purchase_view(<?php echo $item['id'];?>)"><?php echo ucfirst(str_replace("-"," ",$item['title'])); ?></a></h4> <span class="order_date"><?php echo $created_on;?></span> 

                                                        </div>

                                                    </div>

                                                </td>

                                                <td><a href="javascript:;" onclick="purchase_view(<?php echo $item['id'];?>)" ><?php echo $item['id'];?></a></td>

                                                <td>

                                                    <span class="label label-success"><?Php echo $delivery_date; ?></span>

                                                </td>

                                                <td>

                                                    <a href="<?php echo $user_linkone;?>" class="text-dark"><b><?php echo ucfirst($item['fullname']);?></b></a>

                                                </td>

                                                <td><a href="javascript:;" <?php if($fead_stautus ==1){?> onclick="add_feedback(<?php echo $f_uid;?> ,<?php echo $t_uid;?>, <?php echo $gid;?>, <?php echo $item['id'];?>);" <?php }else { ?> onclick="add_seller_feedbacks()" <?php  } ?>><?php echo $b_sts;?></a></td>

                                                 <td class="text-center">

                                                

												<?php if($item['buyer_status'] ==0 && $status !=6 && $sts!='Completed Accept') { if($status !=0 ){ if($status !=5 ){

													  

													 

													?>

												<a href="javascript:;" onclick="buyer_cancel(<?php echo $item['id'];?>,'<?php echo $source; ?>')" ><span class="label label-danger">Cancel</span></a>

                                                    <?php }else{ echo '<span>-</span>'; } }else{ echo '<span>-</span>'; }  } else if($item['buyer_status'] ==1) { if($item['cancel_accept'] ==1){?>

                                                    	 <span>-</span>

                                                    <?php } else{?>

                                                    	<span class="label label-danger">Request send</span>

													<?php }} else {?>

                                                    	-

                                                    <?php }?>

                                                </td>

                                                <td><?php echo $rate_symbol.$rate ;?></td>

                                               

                                                <td>

                                                <?php if($status ==5){ if($item['decline_accept']==1) {?>

                                                	<span class="label <?php echo $class;?>"><?php echo 'Declined';?></span>

													 <span class="<?php echo $refclass;?>"><?php echo$ref;?></span>

                                                <?php } else{?>

                                                	<a href="javascript:;" onclick="buyer_accept_seller_request(<?php echo $item['id'];?>,'<?php echo $source; ?>')"><span class="label <?php echo $class;?>">Decline Request</span></a>

                                                <?php  }

                                            } else{ ?>


                                            	<?php if($sts=='Completed Accept') {

												 	    $buyer_id = $this->session->userdata('SESSION_USER_ID');
												 		$gig_id  = $item['gigs_id'];
												 		$order_id  =$item['id'];
												 		$seller_id  =$item['seller_id'];

												 	$this->db->where(array('seller_id' => $seller_id,'buyer_id' => $buyer_id,'gig_id' => $gig_id,'order_id' => $order_id,'rejected_request' => 0 ));	
												 	$reject_count = $this->db->count_all_results('buyer_rejected_list');

												 	if($reject_count == 1 || $reject_count > 1){ ?>
												 		<span class="btn btn-warning btn-xs">Reject Request Completed</span>
												 	<?php }else{  ?>
												 		
                                                    	<div class="dropdown">
												<button class="btn btn-xs btn-info dropdown-toggle" type="button" id="menu1" data-toggle="dropdown"><?php echo $sts;?>
												<span class="caret"></span></button>



												<ul class="dropdown-menu pull-right" role="menu" aria-labelledby="menu1">
												<li role="presentation"><a role="menuitem" tabindex="-1" href="" <?php if($sts=='Completed Accept') { ?> onclick="change_product_status_update(6,<?php echo $item['id'];?>);" <?php } ?> >Completed</a></li>
												<li role="presentation"><a role="menuitem" tabindex="-1" href="javascript:void(0);"  onclick="popup_reject(<?php echo $item['gigs_id'];?>,<?php echo $item['id'];?>,<?php echo $item['seller_id']; ?>)">Reject Request</a></li>
												</ul>



												</div>
												<?php } ?>
												<!-- <?php echo $sts;?> --></span>
													 <span class="<?php echo $refclass;?>"><?php echo$ref;?></span>
													 
													 <?php }else{ ?>

                                                    <a href="javascript:;">
                                                    <span class="label <?php echo $class;?>"   >
                                                    	<div class="dropdown">
											
												 
												</div><?php echo $sts;?></span>
													 <span class="<?php echo $refclass;?>"><?php echo$ref;?></span>
												</a>  

												<?php } ?>

												<!-- <a href="javascript:;">

                                                    <span class="label <?php echo $class;?>" <?php if($sts=='Completed Accept') { ?> onclick="change_product_status_update(6,<?php echo $item['id'];?>);" <?php } ?> ><?php echo $sts;?></span>

													 <span class="<?php echo $refclass;?>"><?php echo$ref;?></span>

												</a>	 -->

                                                    <?php }?>

                                                </td>

                                            </tr>

											 <?php  }

                                                } else { ?>

                                                <tr>

                                                    <td colspan="8"><p class="text-center text-danger m-b-0">No Records Found</p></td>

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

                            <div id="_error_" class="error_msg"></div>

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


			<?php 
										$buyer_id = $this->session->userdata('SESSION_USER_ID');
										
									 ?>

			<div id="reject-popup" class="modal fade custom-popup" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<div class="modal-body">
						<div class="msg-user-details" id="msg-user-details"></div>
							<div class="new-message">
                            <div id="_error_" class="error_msg"></div>
							<form id="rejected_orders" method="post" action="<?php echo base_url().'user/buy_service/rejected_orders';?>" >
                            <input type="hidden" name="hidd_gig_id" id="hidd_gig_id" value=""/>
                            <input type="hidden" name="hide_order_id" id="hide_order_id" value=""/>
                            <input type="hidden" name="hide_seller_id" id="hide_seller_id" value=""/>				
                            <input type="hidden" name="buyer_id" id="buyer_id" value="<?php echo $buyer_id; ?>"/>						
								<div class="form-group">
									<label class="form-label">Your Complaint</label>
									<textarea name="reject_message_content" placeholder="Your Queries" required="" id="reject_message_content" class="form-control"></textarea>
								</div>						
							
						<button type="submit" name="submit" value="submit" class="btn btn-primary btn-style">Send</button>
						</form>
						</div>
						</div>
					</div>
				</div>
			</div>

            

            <div id="feedback-popup" class="modal fade custom-popup order-popup" role="dialog">

				<div class="modal-dialog">

					<div class="modal-content">

						<button type="button" class="close" data-dismiss="modal">&times;</button>

						<div class="modal-header text-center">

							<h5>Leave Feedback</h5>

						</div>

						<div class="modal-body">

							<div id="parent_user_details"></div>

							<div class="feedback-area">

									<ul class="feedback-list">

										<li class="media">

                                        	<div id="_error_msg" class="error_msg"></div>



											<a href="javascript:;" class="pull-left" id="reset_user_image"></a>

											<div class="media-body">

                                            <form action="" type="post" id="feedback_rating_form">

                                                <input type="hidden" id="rating_frmuser" value="" name="rating_frmuser" />

                                                <input type="hidden" id="rating_touser" value="" name="rating_touser" />

                                                <input type="hidden" id="rating_gig" value="" name="rating_gig" />

                                                <input type="hidden" id="rating_orderid" value="" name="rating_orderid" />

                                                <div class="row">

                                                    <div class="form-group clearfix">

                                                        <div class="col-md-12">

                                                            <textarea rows="4" class="form-control" name="comment" id="comment" placeholder="Comment"></textarea>

                                                        </div>

                                                    </div>

                                                </div>

                                                <div class="row">

                                                    <div class="col-md-6">

                                                        <span id="stars-existing" class="starrr" data-rating=''></span> 

                                                        <input type="hidden" id="rating_input" value="" name="rating_input" />

                                                    </div>

                                                    <div class="col-md-6 text-right">

                                                        <input type="button" value="Send Feedback" onclick="submit_comment();" class="btn btn-primary btn-border" data-loading-text="Loading...">

                                                    </div>

                                                </div>

                                            </form>

											</div>

										</li>

									</ul>

								</div>

						</div>

					</div>

				</div>

			</div>

            

            <div id="see-feedback" class="modal fade custom-popup order-popup" role="dialog">

				<div class="modal-dialog">

					<div class="modal-content">

						<button type="button" class="close" data-dismiss="modal">&times;</button>

						<div class="modal-header text-center">

							<h5>See your feedback</h5>

						</div>

						<div class="modal-body">

							<div id="parent_user_detailsone"></div>

							<div id="feedback_user_area"></div>

						</div>

					</div>

				</div>

			</div>

     </div>

     

     <div id="status-popup-buyer" class="modal fade custom-popup" role="dialog">

        <div class="modal-dialog">

            <div class="modal-content">

                <button type="button" class="close" data-dismiss="modal">&times;</button>

                <div class="modal-header text-center">

                    <h5>Cancel your Order</h5>

                </div>

                <div class="modal-body">

                <div class="error_msg text-center" id="reason_errormsg"> </div>

                <form id="change_gigs_status" method="post" enctype="multipart/form-data">

                	<input type="hidden" name="sell_gigs_statusid" id="sell_gigs_statusid" value="" />
                	<input type="hidden" name="" id="payment_soruce" value="" />

                        <div class="form-group">

                            <label>Reason</label>

							<span class="status-select">

								<input type="text" name="reason_txt" id="reason_txt" value="" class="form-control no_spl_chars" placeholder="Enter Reason" />

							</span>

                        </div>

                        <div class="form-group" id="cancel_fields">

                            <label>PayPal Email ID</label>

                            <input type="text" class="form-control" value="<?php echo $list['paypal_email_id'];?>" name="paypal_email" id="paypal_email">

                        </div>

                        <div class="form-group stripe_input_content">
						<label >The Account Holders Name</label>
						<input type="text" id="account_holder_name" name="account_holder_name" class="form-control stripe_input">
						</div>

						<div class="form-group stripe_input_content">
						<label >Account Number</label>
						<input type="text" id="account_number" name="account_number" class="form-control stripe_input">
						</div>

								<div class="form-group stripe_input_content">
									<label >IBAN</label>
									<input type="text" id="account_iban" name="account_iban" class="form-control stripe_input">

								</div>

								<div class="form-group stripe_input_content">
									<label >Bank Name</label>
										<input type="text" id="bank_name" name="bank_name" class="form-control stripe_input">
								</div>

								<div class="form-group stripe_input_content">

									<label  >Bank Address</label>
										<input type="text" id="bank_address" name="bank_address" class="form-control stripe_input">
								</div>
								<div class="form-group stripe_input_content">
									<label  >Sort Code(UK)</label>
										<input type="text" id="sort_code" name="sort_code" class="form-control stripe_input" placeholder="UK Bank code (6 digits usually displayed as 3 pairs of numbers)">

								</div>

								<div class="form-group stripe_input_content">

									<label >Routing Number(US)</label>
										<input type="text" id="routing_number" name="routing_number" class="form-control stripe_input" placeholder="The American Bankers Association Number (consists of 9 digits) and is also called a ABA Routing Number">
								</div>

								<div class="form-group stripe_input_content">

									<label >IFSC Code(Indian)</label>
 

										<input type="text" id="account_ifsc" name="account_ifsc" class="form-control stripe_input" placeholder="Financial System Code, which is a unique 11-digit code that identifies the bank branch i.e. ICIC0001245">

									 

								</div>

                        <div class="form-group text-right">

                            <button class="btn btn-primary btn-border" onclick="change_productorder_status();" type="button">Update </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

		</div>

        

        <div id="buyer_accept_model" class="modal fade custom-popup" role="dialog">

        <div class="modal-dialog">

            <div class="modal-content">

                <button type="button" class="close" data-dismiss="modal">&times;</button>

                <div class="modal-header text-center">

                    <h5>Buyer Accept Request</h5>

                </div>

                <div class="modal-body">

				<div class="error_msg text-center" id="reason_errormsgone"> </div>

					<form>

						<input type="hidden" id="buyer_accept_rowid" name="buyer_accept_rowid" value="" />

                        <div class="form-group">

							<h4 id="reason_txt_message">Seller decline this order, please accept this request?</h4>

                        </div>

						<div class="form-group payment_type_block">

                            <label>PayPal Email ID</label>

                            <input type="text" class="form-control" value="<?php echo $list['paypal_email_id'];?>" name="paypal_emailid" id="paypal_emailid">

                        </div>

                        <div class="form-group text-right" id="accept_div_row">

							<button class="btn btn-primary btn-border" onclick="buyer_accept_order_request();" type="button">Save & Accept</button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

	</div>

<div class="modal center-modal custom-popup fade" id="feedbackmodel" role="dialog" >

	<div class="modal-dialog" >

		<div class="modal-content">

			<div class="modal-header text-center">

				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

				<h5 class="modal-title" id="myModalLabel">No Feedback </h5>

			</div>

			<div class="modal-body">

				<div class="alert alert-danger feedback-alert">Feedback can be provided once the order is completed.</div>

			</div>

		</div>

	</div>

</div>