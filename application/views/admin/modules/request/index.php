<div class="content-page">
    <div class="content">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<h4 class="page-title">Request</h4>
					<ol class="breadcrumb">
							<li><a href="<?php echo base_url().'admin' ?>">Home</a></li>
						<li><a href="<?php echo base_url('admin/request');?>">Payment Request</a></li>                                     
					</ol>
				</div>
			</div>
            <div class="row">
				<div class="col-lg-12">
					<div class="card-box">                                   
						<h4 class="text-dark header-title m-t-0">Recent Orders</h4>
						<div class="table-responsive">
							<table class="table table-actions-bar">
								<thead>
									<tr>                                                    
										<th>Order Id</th>
										<th>Order Date</th>
										<th>Transaction Id</th>
										<th>Seller</th>
										<th>Seller paypal id</th>
										<th>Buyer</th>
										<th>Amount</th>
										<th>Seller Status</th>
										<th>Buyer Status</th>
										<th>Status</th>
									</tr>
								</thead>
								<tbody>
									<?php
									 if(!empty($list)) 
									{
									foreach($list as $item) { 
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
												$created_on = '<span class="label label-default">' . date('d-m-Y', strtotime($item['created_at'])) . '</span>';
											}
										}	
										$payment_status = $item['payment_status']; 
										if($payment_status ==1) {
											$pay_status='Request';
											$class_1='label-primary';
										}elseif($payment_status ==2){
											$pay_status='Transfer Completed';
											$class_1='label-success';
										}
										else
										{
											$pay_status='New';
											$class_1='label-success';
										}
										?>
									<tr>                                                    
										<td><?php echo $item['id']; ?></td>
										<td><?php echo $created_on; ?></td>
										<td><?php echo $item['paypal_uid']; ?></td>
										<td><?php echo $item['seller_name']; ?></td>  
										<td><?php echo $item['paypal_email_id']; ?></td>    
										<td><?php echo $item['buyer_name']; ?></td>
										<td><?php echo $item['item_amount']; ?></td>
										<td><span class="label <?php echo $class;?>"><?php echo $sts;?></span></td>
										<?php if($item['buyer_status'] ==1  && $item['cancel_accept'] ==1) {?>
										<td><span class="label label-primary">Payment requst from buyer</span></td>
										<?php  }else if($item['buyer_status'] ==1  && $item['cancel_accept'] ==0) {?>
										<td><span class="label label-primary">Waiting for seller approval</span></td>
										<?php  }else  {?>
										<td><span class="label label-success">New</span></td>
										<?php }?>
									   <?php if($payment_status ==1) {?>
										<td> <a onclick="change_payments_status(<?php echo $item['id']; ?>, this.id);" id="change_<?php echo $item['id']; ?>"><span class="label <?php echo $class_1;?>"><?php echo $pay_status;?></span></a></td>
										<?php } else {?>
										<td><span class="label <?php echo $class_1;?>"><?php echo $pay_status;?></span></td>
										<?php }?>
										</tr>
										<?php } } else { ?>
										<tr>
											<td colspan="6"><p class="text-danger text-center m-b-0">No Records Found</p></td>
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
 <script>
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
 </script>