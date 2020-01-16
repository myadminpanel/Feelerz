<div class="content-page">
	<div class="content">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<h4 class="page-title m-b-20 m-t-0">Review</h4>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="card-box">
                        <h4 class="m-t-0 header-title"><b>Edit Review</b></h4>
						<form id="admin_edit_ip" action="<?php echo base_url().'admin/review/edit/'.$list['id']; ?>" method="post" >
							<div class="form-group">
								<label for="gigs_title"> Gigs Title </label>
								<input type="text" name="gigs_title"  class="form-control" id="gigs_title" value="<?php if(!empty($list['title'])){ echo $list['title']; } ?>" readonly>
							</div>     
							<div class="form-group">
								<label for="posted_by"> Posted by </label>
								<input type="text" name="posted_by"  class="form-control" id="posted_by" value="<?php if(!empty($list['fullname'])){ echo $list['fullname']; } ?>" readonly>
							</div>
							<div class="form-group">
								<label for="review"> Gigs Review </label>
								<input type="text" name="review"  class="form-control" id="gigs_title" value="<?php if(!empty($list['comment'])){ echo $list['comment']; } ?>" readonly>
							</div>
							 <div class="form-group">
								<label for="inputEmail3" class="col-sm-3 control-label">Status</label>
								<div class="col-sm-9">
									<div class="radio radio-info radio-inline">
										<input type="radio" id="blog_status1" value="1" name="status" <?php
										if ($list['status'] == 1) {
											echo 'checked=""';
										}
										?>>
										<label for="blog_status1">Active</label>
									</div>
									<div class="radio radio-inline">
										<input type="radio" id="blog_status2" value="0" name="status" <?php
										if ($list['status'] == 0) {
											echo 'checked=""';
										}
										?>>
										<label for="blog_status2">Inactive</label>
									</div>
								</div>
							</div>
							<div class="form-group text-right m-b-0">
								<button class="btn btn-primary" name="form_submit" value="submit" type="submit">Submit</button>
								<button type="reset" class="btn btn-default m-l-5">Cancel</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>