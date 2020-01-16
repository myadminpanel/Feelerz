<div class="content-page">
	<div class="content">
		<div class="container">		
			<div class="row">
				<div class="col-sm-8">
					<h4 class="page-title m-b-20 m-t-0">Client List</h4>
				</div>
				<div class="col-sm-4 text-right m-b-20">
					<a href="<?php echo base_url().'admin/client/create'; ?>" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add Client</a>
				</div>
			</div>
			<?php if($this->session->userdata('message')) {  ?>
			<?php echo $this->session->userdata('message');?>
			<?php } ?>
			<div class="row">
				<div class="col-lg-12">
					<div class="card-box">
						<div class="table-responsive">
							<table class="table table-actions-bar">
								<thead>
									<tr>
										<th>#</th>
										<th>Image</th>
										<th>Client Name</th>                                                     
										<th>Status</th>
										<th>Created Date</th>
										<th class="text-right">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php
									 if(!empty($list)) 
									{
										 $i=1;
									foreach($list as $item) { 
										$status = 'Active'; if($item['status']==1){$status = 'Inactive';}                                                      
										?>
									<tr>                                                    
										<td><?php echo $i; ?></td>
										<td><img class="thumbnail m-b-0" src="<?php echo base_url().$item['client_cropped_image']; ?>" height="32"></td>
										<td><?php echo $item['client_name']; ?></td>                                                   
										<td><?php echo $status; ?></td>
										<td><?php echo date('d M Y', strtotime(str_replace('-','/', $item['created_date']))); ?></td>
										<td class="text-right">
											<a href="<?php echo base_url()."admin/client/edit/".$item['id']; ?>" class="table-action-btn" title="Edit"><i class="mdi mdi-pencil text-success"></i></a>
											<a href="#" onclick="delete_client(<?php echo $item['id'] ?>)" class="table-action-btn" title="Delete"><i class="mdi mdi-window-close text-danger"></i></a>
										</td>
									</tr>
									<?php $i = $i+1; }
									} else { ?>
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