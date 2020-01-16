	<div class="">

        <?php $this->load->view('user/includes/search_include'); ?>

        <section class="profile-section">

            <div class="container">

			<?php if($this->session->flashdata('msg_error')){ ?>

			<div class="row">

				<div class="col-md-12">

					<div class="alert alert-danger"><?php echo $this->session->flashdata('msg_error'); ?></div>

				</div>

			</div>

			<?php }  ?>

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

                        <h3 class="page-title">My Sales</h3>

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

                                <li class="active">

									<a href="javascript:;">

										<span class="visible-xxs"><i class="fa fa-shopping-cart" aria-hidden="true"></i> <?php if($sales_order_count>0){?><span class="badge badge-white position-right"><?php echo $sales_order_count;?></span><?php }?></span> 

										<span class="hidden-xxs">My Sales <?php if($sales_order_count>0){?><span class="badge badge-white position-right"><?php echo $sales_order_count;?></span><?php }?></span>

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

                                                <th>Order Title</th>

                                                <th>Order ID</th>

                                                <th>Delivery Date</th>

                                                <th>Buyer</th>

                                                <th>Feedback</th>

                                                <th>Cancel Request</th>

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

										 

											$rate = $item['item_amount'];

										 
$currency_option = (!empty($item['currency_type']))?$item['currency_type']:'USD';
$rate_symbol = currency_sign($currency_option);
 
											 

											$f_uid = $item['user_id'];

											$t_uid = $item['USERID'];

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

														$sts='Refunded';

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

														$sts='Refunded';

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

														$sts='Refunded';

													$class='label-info';

													}

												}

												}

											}elseif($status ==4){

												$sts='Refunded';

												$class='label-danger';

											}elseif($status ==5){

												if($item['decline_accept'] ==0)

												{

													$sts='Decline Request';

												}

												else{

													$sts='Declined';

												}

												$class='label-danger';

											}elseif($status ==6){

												$sts='Completed';

												$class='label-success';

											}elseif($status ==7){

												$sts='Completed Request';

												$class='label-success';

											}

											$fead_stautus=0;

											if($status ==6) {

												

												$query = $this->db->query("SELECT id FROM `feedback` WHERE `from_user_id` = $t_uid and `to_user_id` = $f_uid and `gig_id` = $gid and `order_id` = $order_id;");

        										$result = $query->row_array();

												$fead_stautus=1; 

												if($result['id']!=''){

													$b_sts='See Feedback';

												}else

												{

													$fead_stautus=2; 	

													$b_sts='Pending';

												}

											}

											else

											{

												$fead_stautus=2; 

												$b_sts='Pending';

											}

											 $created_on = '-';

                                            if (isset($item['created_at'])) {

                                                if (!empty($item['created_at']) && $item['created_at'] != "0000-00-00 00:00:00") {

                                                    $created_on = date('j F Y g:i', strtotime($item['created_at']));

                                                }

                                            }

											$delivery_date='-';

											 if (isset($item['delivery_date'])) {								 

                                                if (!empty($item['delivery_date'])  && $item['delivery_date'] != "0000-00-00 00:00:00" || $item['delivering_time']) {



												$date = strtotime("+".$item['delivering_time']." days", strtotime($item['delivery_date']));

												 $delivery_date = date("d M Y", $date);

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

                                                            <a href="javascript:;" onclick="sales_view(<?php echo $item['id'];?>)"><img src="<?php echo $image_url;?>" alt="" width="50" height="34"></a>

                                                        </div>

                                                        <div class="pull-left">

                                                            <h4 class="product-name2"><a href="javascript:;" onclick="sales_view(<?php echo $item['id'];?>)"><?php echo ucfirst(str_replace("-"," ",$item['title']));?></a></h4> <span class="order_date"><?php echo $created_on;?></span> 

                                                        </div>

                                                    </div>

                                                </td>

                                                <td><a href="javascript:;" onclick="sales_view(<?php echo $item['id'];?>)" ><?php echo $item['id'];?></a></td>

                                                <td>

                                                    <span class="label label-success"><?Php echo $delivery_date; ?></span>

                                                </td>

                                                <td>

                                                    <a href="<?php echo $user_linkone;?>" class="text-dark"><b><?php echo ucfirst($item['fullname']);?></b></a>

                                                </td>

                                                <td>

													<a href="javascript:;" <?php if($fead_stautus ==1 ){ ?> onclick="add_seller_feedback(<?php echo $f_uid;?> ,<?php echo $t_uid;?>, <?php echo $gid;?>,<?php echo $item['id'];?>);" <?php } else { ?>  onclick="add_seller_feedbacks();" <?php  }?>><?php echo $b_sts;?></a>

												</td>

                                                <td class="text-center">

													<?php if($item['buyer_status'] ==0 && $status ==6 ) {?>

                                                    	-

                                                    <?php } else if($item['buyer_status'] ==1) {

														if($item['cancel_accept'] ==0){?>

                                                        	<a href="javascript:;" onclick="show_cancelreason('<?php echo $item['cancel_reason'] ?>',<?php echo $item['cancel_accept'] ?>,<?php echo $item['id'];?>);"><span class="label label-danger">Cancel Request</span></a>

                                                        <?php }else{?>

                                                    	 	<a href="javascript:;" onclick="show_cancelreason('<?php echo $item['cancel_reason'] ?>',<?php echo $item['cancel_accept'] ?>,<?php echo $item['id'];?>);"><span class="label label-danger">View Reason</span></a>

                                                    <?php } } else {?>

                                                    	-

                                                    <?php }?>

                                                </td>

                                                <td><?php echo $rate_symbol.$rate ;?></td>

                                                <td>

                                                	<?php if($item['buyer_status'] ==1) {?>

                                                    	<span class="label <?php echo $class;?>"><?php echo $sts;?></span>

                                                	<?php }else if($status ==0) {?>

                                                    	<span class="label <?php echo $class;?>"><?php echo $sts;?></span>

                                                	<?php } else if($status ==6) {?>

                                                     	<span class="label <?php echo $class;?>"><?php echo $sts;?></span>

                                                    <?php }else if($status ==5) {?>

                                                     	<span class="label <?php echo $class;?>"><?php echo $sts;?></span>

                                                    <?php }else{?>

                                                    	<a href="javascript:;" <?php if($status!=7) { ?> onclick="change_gig_status(<?php echo $item['id'];?>, <?php echo $status;?>);" <?php } ?>><span class="label <?php echo $class;?>"><?php echo $sts;?></span></a>

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

											<a href="#" class="pull-left"><img class="img-circle" width="60" height="60" alt="" src="assets/images/user.jpg"></a>

											<div class="media-body">

                                            <form action="" type="post" id="feedback_rating_formqw">

                                                <input type="hidden" id="rating_frmuser" value="" name="rating_frmuser" />

                                                <input type="hidden" id="rating_touser" value="" name="rating_touser" />

                                                <input type="hidden" id="rating_gig" value="" name="rating_gig" />

                                                <input type="hidden" id="rating_orderid" value="" name="rating_orderid" />

                                                <div class="row">

                                                    <div class="form-group clearfix">

                                                        

                                                    </div>

                                                </div>

                                                <div class="row">

                                                    <div class="col-md-6">

                                                        <span id="stars-existing" class="starrr" data-rating='1'></span> 

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

     

     <div id="status-popup" class="modal fade custom-popup" role="dialog">

        <div class="modal-dialog">

            <div class="modal-content">

                <button type="button" class="close" data-dismiss="modal">&times;</button>

                <div class="modal-header text-center">

                    <h5>Change your status</h5>

                </div>

                <div class="modal-body">

                <form class="form-horizontal" id="change_gigs_status" method="post" enctype="multipart/form-data">

                	<input type="hidden" name="sell_gigs_statusid" id="sell_gigs_statusid" value="" />

                        <div class="form-group">

                            <label class="col-lg-4">Order Status</label>

                            <div class="col-lg-8">

                                <span class="status-select">

                                    <select class="custom-select" id="seller_status" name="seller_status">

                                        <option value="2">Pending</option>

                                        <option value="3">Processing</option>

                                        <option value="6">Completed</option>

                                        <option value="5" >Declined </option>

                                    </select>

                                </span>

                            </div>

                        </div>

                        <div class="form-group">

                            <div class="col-lg-12"><button class="btn btn-primary btn-border pull-right" onclick="change_product_status();" type="button">Update Order status</button></div>

                        </div>

                    </form>

                </div>

            </div>

        </div>

		</div>

			<div class="modal fade custom-popup center-modal" id="feedbackmodel" role="dialog" >

				<div class="modal-dialog" >

					<div class="modal-content">

						<div class="modal-header text-center">

							<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

							<h5 class="modal-title" id="myModalLabel">No Feedback </h4>

						</div>

						<div class="modal-body">

							<div class="alert alert-danger alert alert-danger">No Feedback Received</div>

						</div>

					</div>

				</div>

			</div>

        <div id="reason_model" class="modal fade custom-popup" role="dialog">

        <div class="modal-dialog">

            <div class="modal-content">

                <button type="button" class="close" data-dismiss="modal">&times;</button>

                <div class="modal-header text-center">

                    <h5>Buyer Cancel Reason</h5>

                </div>

                <div class="modal-body">

                

                <form class="form-horizontal"  method="" >

                        <div class="form-group">

                            <div class="col-lg-12">

                                <div id="reason_txt_message" class="custom-box"></div>

                            </div>

                        </div>

                        <div class="form-group" id="accept_div_row">

                        </div>

                    </form>

                </div>

            </div>

        </div>

		</div>