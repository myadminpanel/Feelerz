<div class="content-page">
	<div class="content">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<h4 class="page-title m-b-20 m-t-0">Release Payment</h4>
				</div>
			</div>
			<?php if($this->session->userdata('message')) {  ?>
			<?php echo $this->session->userdata('message');?>
			<?php } ?>
			<div class="row">
				<div class="col-lg-12">
					<div class="card-box">                                   
				 
						<div class="table-responsive">
							<table class="table table-striped releasetable m-b-0">
								<thead>
									<tr>                                                    
										<th>Order Id</th><th>Order Date</th>
										<th>Transaction Id</th><th>Seller</th>
										<th>Buyer</th><th> Paypal Id</th> <!-- New  -->
										<th>Amount</th><th>commission Amount</th>
										<th>Amount to Seller</th><th>Order Status</th>
										<th>Seller Status</th>
									</tr>
								</thead>
								<tbody>
									<?php
									
									if(!empty($list)) 
									{
									foreach($list as $item) { 

										



										$default_currency = $item['currency_type'];
										$payment_id = $item['id'];
										$rate_symbol = currency_sign($default_currency);

								 									
									$seller_id 	    = $item['seller_id'];
									$source 	    = $item['source'];
									$item_amount    = $item['item_amount'];
									$item_paymentid = (!empty($item['paypal_uid']))?$item['paypal_uid']:'';
									 

									if($item['seller_status'] !=6 || ($item['pay_status']==1 || $item['pay_status']==0)){
									if($item['cancel_accept'] ==1 || $item['decline_accept']==1 || $item['cancel_accept'] ==0 || $item['decline_accept']==0){

										//if($item['seller_status'] !=6 && $item['pay_status']==''){
										//if($item['cancel_accept'] ==1 || $item['decline_accept']==1){

											//$rate_symbol = "$";	
											$rate        = $item['item_amount'] ;		
											$price       = $rate_symbol.$rate;   
											$paypal_amnt = 0; 
											$d_rate = (int)$this->session->userdata('dollar_rate');
											 
											if($d_rate> 0 ){
												$paypal_amnt        = $item['item_amount'] / $d_rate;
											}else{
												$paypal_amnt        = $item['item_amount'] / 1;
											}
											
											$paypal_amnt        = number_format((float)$paypal_amnt, 2, '.', '');	

											$commision_rate = (($rate*$item['commision'])/100);
											$seller_amount = $rate - $commision_rate ;
											$status = 'Active'; if($item['status']==1){$status = 'Inactive';} 
											$parent_category = 'None' ;
											$status = $item['seller_status']; 
											$cancel_accept = $item['cancel_accept']; 
											if($status ==1 && $cancel_accept ==0) {
												$sts='New';
												$class='label-success';
											}elseif($status ==1 && $cancel_accept ==1) {
												$sts='Cancelled';
												$class='label-danger';
											}elseif($status ==2){
												$sts='Pending';
												$class='label-warning';
												$class='label-primary';
											}elseif($status ==3){
												$sts='Process';
											}elseif($status ==4){
												$sts='Refunded';
												$class='label-danger';
											}elseif($status ==5){

												$sts='Cancelled';
												$class='label-danger';

												if($item['decline_accept'] ==0 && $item['status']==1)
											{
												$sts='Decline Request';
												$process='-';
											}
											else{
												$sts='Declined';
												$process='<button type="submit" class="btn btn-primary btn-sm btn-border">Process 
												Payment</button>';
											}

											}elseif($status ==6){
												$sts='Completed';
												$class='label-success';
											}
											$created_on = '-';
											if (isset($item['created_at'])) {
												if (!empty($item['created_at']) && $item['created_at'] != "0000-00-00 00:00:00") {
													$created_on = '<span>' . date('d M Y', strtotime($item['created_at'])) . '</span>';
												}
											}
											?>
											<tr id="row_id_<?php echo $item['id']; ?>">                                                    
												<td><?php echo $item['id']; ?></td>
												<td><?php echo $created_on; ?></td>
												<td><?php echo $item['paypal_uid']; ?></td>
												<td><?php echo $item['seller_name']; ?></td>   
												<td><?php echo $item['buyer_name']; ?></td>
												<td><?php 
														if($status == 1 || $status == 5)
														{
															echo $item['paypal_email_id'];
														
														}else{
														
														echo $item['buyer_paybalemail'];
														}
												?></td>

												<td><?php echo $price; ?></td>
												<td><?php echo $rate_symbol.$commision_rate; ?></td> 
												<td><?php echo $rate_symbol.$seller_amount; ?></td>

												<!--  Cancelled  -->
												<?php if($item['buyer_status'] ==1  && $item['cancel_accept'] ==1) {
													$process='<button type="submit" class="btn btn-primary btn-sm btn-border">Process payment</button>';
													if($item['pay_status']==''){
														?>
														<td><span class="label label-danger">Cancelled</span></td>
														<?php }else{ echo '<td><span class="label label-danger">Cancelled</span></td>';} }else if($item['buyer_status'] ==1  && $item['cancel_accept'] ==0) {
															$process='-';
															?>
															<td><span class="label label-primary">Waiting for seller approval</span></td>
															<?php  }elseif($item['status']==1){?>
															<td><span class="label <?php echo $class;?>"><?php echo $sts;?></span></td>

															<?php } else  {
																$process='new';
																?>
																<td><span class="label label-success">New</span></td>
																<?php }?>
																<!--  Cancelled  -->

						<td>                  
						<div class="withdraw-btn">
							<?php if($item['payment_status'] ==2){?>
							<div id="change_<?php echo $item['id']; ?>" class="btn btn-success btn-sm btn-border"> Transfer Completed </div>
							<?php }else { 
							$buyer_email = $item['buyer_email'];
							$selleremail = $item['selleremail'];
							?>
						<input type="hidden" name="request_payment_id" id="request_payment_id" value="" />
						<?php if($source=='paypal') { ?>
						<form action="<?php echo base_url().'admin/release_payments/payment';?>" method="post" id="payment_formid" name="payment_submit">
							 <input type="hidden" name="status" id="status" value="<?php  echo $status;?>" />  
							<input type="hidden" name="gigs_rate" id="gigs_rate" value="<?php  echo $paypal_amnt;?>" />
							<input type="hidden" name="buyeremail" id="buyeremail" value="<?php  echo $buyer_email;?>" />
							<input type="hidden" name="title" id="title" value="<?php  echo  $item['title'];?>" />
							<input type="hidden" name="sellername" id="sellername" value="<?php  echo  $item['seller_name'];?>" />
							<input type="hidden" name="buyer_name" id="buyer_name" value="<?php  echo  $item['buyer_name'];?>" />
							<input type="hidden" name="selleremail" id="selleremail" value="<?php  echo $selleremail;?>" />
							<input type="hidden" name="converted_india_gigs_rate" id="converted_india_gigs_rate" value="500" />
							<input type="hidden" name="gigs_actual_rate" id="gigs_actual_rate" value="<?php  echo $seller_amount;?>" />
							<input type="hidden" name="extra_gig_row_id" id="extra_gig_row_id" value="<?php  echo $item['id'];?>" />
							<input type="hidden" name="buyer_paybalemail"  value="<?php  echo $item['buyer_paybalemail'];?>" />
							<input type="hidden" name="buyer_email" id="buyer_email" value="<?php  echo $buyer_email;?>" />
							<input type="hidden" name="paypalseller_email" id="paypalseller_email" value="<?php  echo $item['paypal_email_id'];?>" />
							<input type="hidden" name="currency_type" id="currency_type" value="<?php  echo $case;?>" />
							
							<input type ="hidden" name="hidden_super_fast_delivery" value="" id="hidden_super_fast_delivery"  />
							<input type ="hidden" name="total_delivery_days" value="" id="total_delivery_days"  />
							<input type="hidden" id="hidden_super_fast_delivery_charges" name="hidden_super_fast_delivery_charges" value="" />
							<div>
								<button type="submit" class="btn btn-primary btn-sm btn-border" value="true" name="submit">Process Payment</button>
							</div>
						</form>
						<?php } elseif($source=='stripe') {?>

							<a href="javascript:void(0)" class="btn btn-primary btn-sm btn-border" onclick="refund_striptpaymet(<?php echo $item_amount; ?>,'<?php echo $item_paymentid; ?>','<?php echo $sts; ?>','<?php echo $seller_amount; ?>','<?php echo $seller_id; ?>','<?php echo $payment_id; ?>')">Process Payment</a>
								
								<?php } elseif($source=='amplify') {?>
								<a href="javascript:void(0)" class="btn btn-primary btn-sm btn-border" onclick="refund_amplifypaymet(<?php echo $item_amount; ?>,'<?php echo $item_paymentid; ?>')">Process Payment</a>
								<?php }?>
								<?php }?>
							</div>    
																</td>                                            
															</tr>
															<?php 
											}
														} 
														} 
													} else { ?>
													<tr>
														<td colspan="11"><p class="text-center text-danger m-b-0">No Records Found</p></td>
													</tr>
													<?php } ?>
												</tbody>
											</table>
											 
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

 <div id="stripe_popup" class="modal fade custom-popup" role="dialog" >
                <div class="modal-dialog">
                    <div class="modal-content">
                           <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h3 class="text-primaryt">Stripe</h3>
                                <p>The Gigs amount is <span class="stripe_payment_price_text">0</span> Please pay less than the paid amount</p>
                          </div>
                        <div class="modal-body" style="height: 150px">
                            <form class="form-horizontal"  method="POST" id="payment-form">
                            
                            <div class="form-group">
                                <label class="control-label col-sm-8 col-md-8" for="email">Refund Amount</label>
                                <div class="col-sm-4">    
                                	<input type="hidden" id="return_token" name="return_token" value="">
                                	<input type="hidden" id="stripe_payment_price_max" name="return_token" value="">
                                <input type="number" name="stripe_payment_price" id="stripe_payment_price" min="0" max="" class="form-control" required="required" size="50" placeholder="Refund Amount" />
                                </div>
                                <p class="text-danger col-sm-12 col-md-12 empty_amount"  style="display: none;">Please enter refund amount</p>
                                <p class="text-danger col-sm-12 col-md-12 empty_amount_refund" style="display: none;" >Please enter refund amount less than the paid amount</p>
                            </div>
 
                            <button type="button" onclick="paycancel()" class="pull-right btn btn-danger">Cancel</button> &nbsp;
                            <button type="button" id="stripe_payment" onclick="submit_stripe()" class="pull-right btn btn-success" style="margin-right:5px;">Pay Now</button>
                            
                        </form>
                        </div>
                    </div>
                </div>
            </div>

<div id="stripe_money_transfer" class="modal fade custom-popup" role="dialog" >
                <div class="modal-dialog">
                    <div class="modal-content">
                           <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h3 class="text-primaryt">Please transfer the seller amount to following account details</h3>
                        <p>The Gigs seller amount is <span class="stripe_payment_seller_amt">0</span> Please pay the amount</p>
                          </div>
                        <div class="modal-body" style="height: 350px">
                             <p><strong>Account holder name</strong> : <span class="acc_name"></span></p>
                             <p><strong>Account number</strong> : <span class="acc_no"></span></p>
                             <p><strong>Account iban</strong> : <span class="acc_iban"></span></p>
                             <p><strong>Bank name</strong> : <span class="acc_ban_name"></span></p>
                             <p><strong>Bank address</strong> : <span class="acc_ban_addr"></span></p>
                             <p><strong>Sort code</strong> : <span class="acc_sor_cod"></span></p>
                             <p><strong>Routing number</strong> : <span class="acc_rout"></span></p>
                             <p><strong>Account IFSC</strong> : <span class="acc_ifsc"></span></p>
                             <input type="hidden" id="current_page" value="<?php echo base_url(); ?>admin/release_payments/compete_payment">
                             <a id="update_url" href="javascript:void(0)" class="btn btn-success">After Bank transaction</a>
                        </div>

                    </div>
                </div>
            </div>


<script>
	function release_payment_admin(id,ele)
	{
		bootbox.confirm("Are you sure want to UPDATE ? ", function(result) {
//alert(result)
 if(result ==true)                {
 	var url        = BASE_URL+'admin/request/update_payment_status';
 	$.ajax({
 		url:url,
 		data:{id:id}, 
 		type:"POST",
 		success:function(res){ 
 			if(res==1)
 			{
 				$("#"+ele).removeAttr("onclick");
 				$("#"+ele).html('Transfer Completed');
 			}
 		}
 	});  
 }
});
					}
					function change_payments_status(id,ele)
					{
						bootbox.confirm("Are you sure want to UPDATE ? ", function(result) {
							if(result ==true)                {
								var url        = BASE_URL+'admin/request/update_payment_status';
								$.ajax({
									url:url,
									data:{id:id}, 
									type:"POST",
									success:function(res){ 
										if(res==1)
										{
											$("#"+ele).html('<span class="label label-success">Transfer Completed</span>');
										}
									}
								});  
							}
						});
					}
	function paycancel(){
		$('#stripe_popup').modal('hide');
		$('.stripe_payment_price_text').text(0);
		$('#stripe_payment_price_max').val(0);
		$('#stripe_payment_price').attr('max',100);
		$('#return_token').val('');
	}

	function refund_striptpaymet(amount,pid,status,seller_amt,seller_id,payment_id){

		if(status == 'Declined' || status == 'Cancelled'){
			$('#stripe_popup').modal('show');
			$('.stripe_payment_price_text').text(amount);
			$('#stripe_payment_price_max').val(amount);
			$('#stripe_payment_price').attr('max',amount);
			$('#return_token').val(pid);
    	}else if(status == 'Completed'){

    		 $('.acc_name').text('loading...');
				 $('.acc_no').text('loading...');
				 $('.acc_iban').text('loading...');
				 $('.acc_ban_name').text('loading...');
				 $('.acc_ban_addr').text('loading...');
				 $('.acc_sor_cod').text('loading...');
				 $('.acc_rout').text('loading...');
				 $('.acc_ifsc').text('loading...');

    		$.post(BASE_URL+'user/stripe_payment/details',{id:seller_id},function(data){
    			 var details = JSON.parse(data);
    			 details
				 $('.acc_name').text(details.account_holder_name);
				 $('.acc_no').text(details.account_number);
				 $('.acc_iban').text(details.account_iban);
				 $('.acc_ban_name').text(details.bank_name);
				 $('.acc_ban_addr').text(details.bank_address);
				 $('.acc_sor_cod').text(details.sort_code);
				 $('.acc_rout').text(details.routing_number);
				 $('.acc_ifsc').text(details.account_ifsc);
				 var curl = $('#current_page').val();
				 curl = curl+'/'+payment_id;
				 $('#update_url').attr('href',curl);

    		});
    		$('#stripe_money_transfer').modal('show');
    		$('.stripe_payment_seller_amt').text(seller_amt);
    	}
 	}

	function submit_stripe(){
		var max_price = parseFloat($('#stripe_payment_price_max').val());
		var stripe_payment_price = parseFloat(($('#stripe_payment_price').val()!="")?$('#stripe_payment_price').val():0);
		var error = 0 ;
		if(stripe_payment_price == ""){
			$('.empty_amount').show();	
			error = 1 ;
		}else{
			$('.empty_amount').hide();	
		}		
		
		if( stripe_payment_price > 0 && stripe_payment_price >= max_price){		
			$('.empty_amount_refund').show();
			error = 1 ;
		}else{
			$('.empty_amount_refund').hide();
		}
		if(error == 0 ){
			var amount = $('#stripe_payment_price').val();
			var pid = $('#return_token').val();
			stripe_ajax_call(pid,amount);
			return false;	
		}else{
			return false;	
		}

		
			
				
	}

	function stripe_ajax_call(pid,amount){
		
		var url = BASE_URL+'user/stripe_payment/stripe_refund';
		$.ajax({
			url:url,
			data:{pid:pid,amount:amount}, 
			type:"POST",
			success:function(res){ 
				if(res==1)
				{
					bootbox.alert("Your customer sees the refund as a credit approximately 5-10 business days later, depending upon the bank");
				}else{
					bootbox.alert("Something is wrong, Please try later.");
				}
				location.reload();
			}
		});
 	}

	function refund_amplifypaymet(amount,pid){
		bootbox.prompt({
	    	title: '<h3 class="text-primary">Refund Amplify Paymet</h3><p>The Gigs amount is '+amount+'. Please pay less than the paid amount</p>',
	    	inputType: 'number',
	    	callback: function (result) {

	        	if(result != '' && result > 0 && result < amount){
	        	
	        		var url = BASE_URL+'user/buy_service/amplify_refund';
	        		$.ajax({
						url:url,
						data:{pid:pid,amount:result}, 
						type:"POST",
						success:function(res){ 
							if(res==1)
							{
								bootbox.alert("Amount has been refunded as soon as possible.");
							}else{
								bootbox.alert("Something is wrong, Please try later.");

							}
							 location.reload();
						}
					});

	        	}else if(result < 0){	

	        		refund_striptpaymet(amount);	
      			
      			}
	    	}
		});	
	}

				</script>