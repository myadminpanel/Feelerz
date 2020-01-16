<div class="content-page">
	<div class="content">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<h4 class="page-title">Dashboard</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-3 col-sm-6">
					<div class="widget-panel widget-style-2 bg-white">
						<i class="md md-attach-money text-primary"></i>
						<h2 class="m-0 text-dark counter font-600"><?php echo $dashboard_details['total_gigs']; ?></h2>
						<div class="text-muted m-t-5">Total Gigs</div>
					</div>
				</div>
				<div class="col-lg-3 col-sm-6">
					<div class="widget-panel widget-style-2 bg-white">
					  <i class="md md-account-child text-custom"></i>
						<h2 class="m-0 text-dark counter font-600"><?php echo $dashboard_details['total_user']; ?></h2>
						<div class="text-muted m-t-5">Total Users</div>
					</div>
				</div>
				<div class="col-lg-3 col-sm-6">
					<div class="widget-panel widget-style-2 bg-white">
						<i class="md md-store-mall-directory text-info"></i>
						<h2 class="m-0 text-dark counter font-600"><?php echo $dashboard_details['total_orders']; ?></h2>
						<div class="text-muted m-t-5">Total Orders</div>
					</div>
				</div>
				<div class="col-lg-3 col-sm-6">
					<div class="widget-panel widget-style-2 bg-white">
														<i class="md md-add-shopping-cart text-pink"></i>  
						<h2 class="m-0 text-dark counter font-600"><?php echo $dashboard_details['completed_orders']; ?></h2>
						<div class="text-muted m-t-5">Completed Orders</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-6">
					<div class="card-box">
						<a href="#" class="pull-right btn btn-default btn-sm waves-effect waves-light">View All</a>
						<h4 class="text-dark header-title m-t-0">Recent Orders</h4>
						<div class="table-responsive">
							<table class="table table-actions-bar">
								<thead>
									<tr>
										<th>Product</th>
										<th>Order Date</th>
										<th>Order Number</th>
										<th>Amount</th>                                                   
									</tr>
								</thead>
								<tbody>
									<?php 
									$rate = "$";
									foreach($recent_orders as $recent) { 
									 $image = base_url().'assets/images/gig-small.jpg';
									 if(!empty($recent['gig_image_thumb']))
									 {
									 $image = base_url().$recent['gig_image_thumb'];
									 }
									 ?>                                        
									<tr>
										<td><img src="<?php echo $image; ?>" class="thumb-sm" alt=""> </td>
										<td><?php echo    date('Y-m-d', strtotime(str_replace('-','/', $recent['created_at'])));  ?></td>
										<td><a href="javascript:;"><?php echo $recent['paypal_uid']; ?></a></td>
										<td><?php echo  $rate.$recent['item_amount']; ?></td>
									</tr>
									<?php } ?>
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<div class="card-box">
						<a href="#" class="pull-right btn btn-default btn-sm waves-effect waves-light">View All</a>
						<h4 class="text-dark header-title m-t-0">Popular Products</h4>
						<div class="table-responsive">
							<table class="table table-actions-bar">
								<thead>
									<tr>
										<th>Product</th>
										<th>Addded Date</th>
										<th>Orders</th>
										<th>Amount</th>                                                    
									</tr>
								</thead>
								<tbody>
								<?php foreach($popular_orders as $popular_order) { 
									$image = base_url().'assets/images/gig-small.jpg';
									if(!empty($recent['gig_image_thumb']))
									{
									$image = base_url().$recent['gig_image_thumb'];
									}
								?>         
									<tr>
										<td><img src="<?php echo $image ; ?>" class="thumb-sm" alt=""> </td>
										<td><?php echo date('Y-m-d', strtotime(str_replace('-','/', $popular_order['created_at'])));  ?></td>
										<td><b><?php echo $popular_order['total_views']; ?></b></td>
										<td><?php echo $rate.$popular_order['item_amount']; ?></td>
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
	<footer class="footer text-right">
	  <?php echo $this->session->userdata('copy_right_year') ; ?>
	</footer>
</div>