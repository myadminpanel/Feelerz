<?php 

	$query = $this->db->query("UPDATE `buyer_rejected_list` SET `notification_seen` = '1'");
?>
<div class="content-page">

	<div class="content">

		<div class="container">

			<div class="row">

				<div class="col-sm-12">

					<h4 class="page-title m-b-20 m-t-0">Rejected Orders</h4>

				</div>

			</div>

            <div class="row">

				<div class="col-lg-12">

					<div class="card-box m-b-0">

						<div class="table-responsive">

							<table class="table table-actions-bar datatable m-b-0">

								<thead>

									<tr>                 

										<th>Buyer</th>

										<th>Seller</th>

										<th>Offers</th>

										<th>Order Id</th>

										<th>Message</th>

										<th>Order Status</th>

									</tr>

								</thead>

								<tbody>

									<?php

									 if(!empty($result)) 

									{

									foreach($result as $item) { 

										//print_r($item);exit;
										$id = $item['buyer_id'];
										$rjid = $item['id'];

										$buyer_name = $item['buyername'];

										$seller_name = $item['sellername'];

										$title = $item['gig_name'];

										$status = $item['status'];

										if(($status == 0)){

											$refclass='';
											$class='';

												$change_reject_status =1;
												$refclass='label-info';
												$b_sts='<div class="dropdown">
												<button class="btn btn-xs btn-info dropdown-toggle" type="button" id="menu1" data-toggle="dropdown">Pending
												<span class="caret"></span></button>
												<ul class="dropdown-menu pull-right" role="menu" aria-labelledby="menu1">
												<li role="presentation"><a role="menuitem" tabindex="-1" href="'.base_url().'orders/accept_rejected_orders/'.$change_reject_status.'/'.$rjid.'"> Cancel Completed Request</a></li>					
												</ul>
												</div>';												

											}elseif($status == 1) {

												$sts='Accept';
												$class='label-success';
												$fead_stautus=1;												
												$b_sts ='<button class="btn btn-xs btn-success">Accepted</button>';
												
											}
										 



										

										?>

									<tr>

										<td><?php echo $buyer_name ?></td>    

										<td><?php echo $seller_name; ?></td>

										<td><?php echo $title; ?></td>

										<td><?php echo $item['order_id']; ?></td>

										<td><?php echo $item['message']; ?></td>

										<td><span><?php echo $b_sts;?></span></td>

									</tr>

									<?php } } else { ?>

									<tr>

										<td colspan="8"><p class="text-danger text-center m-b-0">No Records Found</p></td>

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
