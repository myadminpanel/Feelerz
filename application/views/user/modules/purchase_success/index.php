<div class="content page-content">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 ">
                <div class="text-center">
                    <h1>Thank you for Purchasing</h1>
                    <h4>we'll let you know when your items are complete</h4>
                </div>
                <?php 
				
				$country_name = $this->session->userdata('country_name');
				$rate = $purchase_details['item_amount'];
				$currency_option = $purchase_details['currency_type'];
				$rate_symbol = '$';
				
					if(!empty($currency_option)=='USD'){ $rate_symbol = '$'; }
					if(!empty($currency_option)=='EUR'){ $rate_symbol = '€'; }
					if(!empty($currency_option)=='GBP'){ $rate_symbol = '£'; }

				 $created_on = date('j F Y g:i A', strtotime($purchase_details['created_at']));
				?>
				<div class="table-responsive m-t-50">
					<table class="table">
						<thead>
							<tr>
								<th>Order Details</th>
								<th>Transaction Id</th>
								<th>Seller</th>
								<th>Amount</th>

							</tr>
						</thead>
						<tbody>
							<tr>
								<td>
									<div class="product-group">
										<div class="pro_img">
											<a href="javascript:;"  onclick="purchase_view(<?php echo $purchase_details['id'];?>)" ><img src="<?php echo base_url().$purchase_details['gig_image'] ?>" class="thumb-sm" alt="<?php echo $purchase_details['title'] ; ?>"></a>
										</div>
										<div class="pull-left">
											<h4 class="product-name2"><a href="javascript:;"  onclick="purchase_view(<?php echo $purchase_details['id'];?>)" ><?php echo ucfirst(str_replace("-"," ",$purchase_details['title'])); ?></a></h4> <span class="order_date"><?php echo  $created_on; ?></span> 
										</div>
									</div>
								</td>
								<td>
								<?php 

									if($purchase_details['paypal_uid'] =='issue'){ ?>
								    	<a href="javascript:void(0);" class="btn btn-xs btn-danger">Failed</a>
									<?php }else{ ?>
								<a href="javascript:;" onclick="purchase_view(<?php echo $purchase_details['id'];?>)" ><?php echo $purchase_details['paypal_uid'] ; ?></a>
								<?php } ?>
							</td>
								<td>
									<a href="<?php echo base_url().'user-profile/'.$purchase_details['username']; ?>" class="text-dark"><b><?php echo $purchase_details['fullname'] ; ?></b></a>
								</td>
								<td><b><?php echo $rate_symbol.$rate; ?></b></td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="text-center thanks-cont">
                    <h3>If you want check your all purchases, click on below link</h3>
                    <a href="<?php echo base_url()."purchases"; ?>" class="btn btn-primary btn-border">View my orders</a> <span class="or-space">or</span> <a href="<?php echo base_url()."buy-service"; ?>" class="underline-link"> Continue shopping</a>
                </div>
			</div>
		</div>
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
<div id="purchase-popup" class="modal fade custom-popup order-popup" role="dialog">
	<div class="modal-dialog">
		<div class="modal-content" id="purchases_model_deatils"></div>
	</div>
</div>