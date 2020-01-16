<div class="content-page">
	<div class="content">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<h4 class="page-title m-b-20 m-t-0">Edit Client</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="card-box">
						<form id="admin_edit_ads" action="<?php echo base_url().'admin/client/edit/'.$list['id'] ;?>" method="post"  enctype="multipart/form-data"  >
							<div class="form-group">
								<label for="client_name">Client Name</label>
								<input type="text" value="<?php if(!empty($list['client_name'])){ echo $list['client_name']; } ?>" name="client_name" placeholder="Enter Title" value=" " class="form-control" id="client_name">
							</div>
							<div class="form-group">                                     
								<?php if(!empty($list['client_cropped_image'])){ ?>
								<img class="img-thumbnail m-b-0" src="<?php echo base_url().$list['client_cropped_image']; ?>">                                     
								<?php }   ?>     
							</div> 
							<div class="form-group">
								<label for="client_image">Client Image</label>
								<input type="file" name="client_image" class="form-control" id="ads_image" >
							</div> 
							<div class="form-group">
								<label class="control-label">Status</label>
								<div>
									<div class="radio radio-primary radio-inline">
										<input type="radio" id="blog_status1" value="0" name="status" <?php
										if ($list['status'] == 0) {
											echo 'checked=""';
										}
										?>>
										<label for="blog_status1">Active</label>
									</div>
									<div class="radio radio-danger radio-inline">
										<input type="radio" id="blog_status2" value="1" name="status" <?php
										if ($list['status'] == 1) {
											echo 'checked=""';
										}
										?>>
										<label for="blog_status2">Inactive</label>
									</div>
								</div>
							</div>
							<div class="form-group m-b-0 m-t-30">
								<button class="btn btn-primary" name="form_submit" value="submit" type="submit">Submit</button>
								<a href="<?php echo base_url().'admin/client' ?>" class="btn btn-default m-l-5">Cancel</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
 </div>