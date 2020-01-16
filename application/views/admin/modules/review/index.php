<div class="content-page">
	<div class="content">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<h4 class="page-title m-b-20 m-t-0">Reviews</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="card-box">
						<div class="table-responsive">
							<table class="table table-actions-bar datatable">
								<thead>
									<tr>
										<th>S.No</th>                                                     
										<th>Gigs Title</th>                                                     
										<th>User</th>
										<th>Review</th>
										<th>Status</th>
										<th>Created Date</th> 
									</tr>
								</thead>
								<tbody>
									<?php 
									 if(!empty($list)) 
									{
									$i=1;
									foreach($list as $item) { 
										$status = 'Inactive'; if($item['status']==1){$status = 'Active';}
										?>
									<tr>                                                    
										<td><?php echo $i; ?></td>                                                    
										<td><?php echo ucfirst(str_replace('-',' ',$item['title'])); ?></td>
										<td><?php echo $item['fullname']; ?></td>
										<td><?php echo $item['comment']; ?></td>
										<td><?php echo $status; ?></td>
										<td><?php echo date('d M Y', strtotime(str_replace('-','/', $item['created_date']))); ?></td>
									</tr>
									<?php $i = $i+1; } } else { ?>
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