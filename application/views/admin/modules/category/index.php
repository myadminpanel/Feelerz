<div class="content-page">
	<div class="content">
		<div class="container">
			<div class="row">
				<div class="col-sm-8">
					<h4 class="page-title m-b-20 m-t-0">Gigs Category</h4>
				</div>
				<div class="col-sm-4 text-right m-b-20">
					<a href="<?php echo base_url().'admin/category/add_category'; ?>" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add Category</a>
				</div>
			</div>
			<?php if($this->session->flashdata('message')) { ?>
				<?php echo $this->session->userdata('message');?>
			<?php }
			?>    
			<div class="row">
				<div class="col-lg-12">
					<div class="card-box m-b-0">
						<div class="table-responsive">
							<table class="table table-actions-bar datatable">
								<thead>
									<tr>
										<th>Category Name</th>
										<th>Parent Category</th>
										<th>Status</th>
										<th class="text-right">Action</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									 if(!empty($list)) 
									{
									foreach($list as $item) { 
										$status = 'Active'; if($item['status']==1){$status = 'Inactive';} 
										$parent_category = 'None' ;
										if(!empty($item['parent_name'])){ $parent_category = $item['parent_name'];}
										?>
									<tr>
										<td><?php echo $item['name']; ?></td>
										<td><?php echo $parent_category; ?></td>
										<td><?php echo $status; ?></td>
										<td class="text-right">
											<a href="<?php echo base_url()."admin/category/edit_category/".$item['CATID']; ?>" class="table-action-btn" title="Edit"><i class="mdi mdi-pencil text-success"></i></a>
											<a href="#" onclick="delete_category(<?php echo $item['CATID'] ?>)" class="table-action-btn" title="Delete"><i class="mdi mdi-window-close text-danger"></i></a>
										</td>
									</tr>
									<?php } } else { ?>
									<tr>
										<td colspan="4"><p class="text-danger text-center m-b-0">No Records Found</p></td>
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