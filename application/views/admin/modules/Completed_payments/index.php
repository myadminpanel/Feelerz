<div class="content-page">
	<div class="content">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<h4 class="page-title m-b-20 m-t-0">Paid Withdrawal</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="card-box">                                   
						<div class="table-responsive">
							<table class="table table-striped table-actions-bar m-b-0 datatable">
								<thead>
									<tr>                                                    
										<th>Order Id</th>
										<th>Order Date</th>
										<th>Transaction Id</th>
										<th>Seller</th>
										<th>Buyer</th>
										<th>Amount</th>
										<th>commission Amount</th>
										<th>Amount to Seller</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>
									<?php
									 if(!empty($list)) 
									{
									foreach($list as $item) { 
										 
										$case = $item['currency_type'];
										 switch ($case) {
								 			case 'USD':
								 			$rate_symbol = "$";	
								 			break;
								 		case 'EUR':
								 			$rate_symbol = "€";	
								 			break;
								 		case 'GBP':
								 			$rate_symbol = "£";	
								 			break;
								 		
								 		default:
								 			$rate_symbol = "$";	
								 			break;
								 	}
										$rate = $item['item_amount'] ;		
										$price = $rate_symbol.$rate;
										$commision_rate = (($rate*$item['commision'])/100);
										$seller_amount = $rate - $commision_rate ;
										$status = 'Active'; if($item['status']==1){$status = 'Inactive';} 
										$parent_category = 'None' ;
										$status = $item['seller_status']; 
										if($status ==1) {
											$sts='New';
											$class='label-success';
										}elseif($status ==2){
											$sts='Pending';
											$class='label-warning';
										}elseif($status ==3){
											$sts='Process';
											$class='label-primary';
										}elseif($status ==4){
											$sts='Refunded';
											$class='label-danger';
										}elseif($status ==5){
											$sts='Cancelled';
											$class='label-danger';
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
										<td><?php echo $price; ?></td>
										<td><?php echo $rate_symbol.$commision_rate; ?></td> 
										<td><?php echo $rate_symbol.$seller_amount; ?></td>
										<td>                  
											<div class="withdraw-btn">
											<?php if($item['payment_status'] ==2){?>
												<span class="label label-success">Paid</span>
											<?php }?>
											</div>    
										</td>                                            
									</tr>
									<?php } } else { ?>
									<tr>
										<td colspan="9"><p class="text-center text-danger m-b-0">No Records Found</p></td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
							<?php echo $links; ?>
						</div>
					</div>
				</div>
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
</script>