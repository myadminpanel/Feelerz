<div class="content-page">
	<div class="content">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<h4 class="page-title m-b-20 m-t-0">Edit Category</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="card-box">
						<form id="admin_add_cat" action="<?php echo base_url().'admin/category/edit_category/'.$list['CATID']; ?>" method="post"  enctype="multipart/form-data"  >
							<div class="form-group">
								<label for="parent_category">Parent Category</label>
								<select class="form-control" name="parent_category">
									 <option value="0">None</option>
									<?php foreach ($parent_category as $parent_cat) { ?>
									<option value="<?php echo $parent_cat['CATID'];?>" <?php if($parent_cat['CATID'] == $list['parent']){ echo "selected";} ?>><?php  echo $parent_cat['name']; ?></option>    
									<?php } ?>
								</select>
							</div>
							<div class="form-group">
								<label for="category_name">Category Name</label>
								<input type="text" name="category_name"  placeholder="Enter Category Name " value="<?php if(!empty($list['name'])){echo $list['name']; } ?>" class="form-control" id="category_name" required>
							</div>                                
							<input type ="hidden" name="catagory_id" value="<?php if(!empty($list['CATID'])){echo $list['CATID']; } ?>" id="catagory_id">
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
								<a href="<?php echo base_url().'admin/category'?>" class="btn btn-default m-l-5">Cancel</a>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>