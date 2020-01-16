<div class="content-page">
	<div class="content">
		<div class="container">
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<h4 class="page-title m-b-20 m-t-0">Add Profession</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-md-6 col-md-offset-3">
					<div class="card-box">
						<form id="admin_edit_profession" action="<?php echo base_url().'admin/profession/edit/'.$list['id']; ?>" method="post" >
							<div class="form-group">
								<label for="Profession">Profession</label>
								<input type="text" name="profession" placeholder="Profession .... " class="form-control" id="profession" value="<?php if(!empty($list['profession_name'])){ echo $list['profession_name']; } ?>" required>
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
							<div class="text-center m-t-30">
								<button class="btn btn-primary" name="form_submit" value="submit" type="submit">Submit</button>
								<a href="<?php echo base_url().'admin/profession' ?>" class="btn btn-default m-l-5">Cancel</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
 </div>