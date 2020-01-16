<div class="content-page">
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
					<h4 class="page-title m-b-20 m-t-0">Edit Terms</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="card-box">                        
                        <?php 
                        foreach($datalist as $value)
                        {
                        ?>
                        <form class="form-horizontal" action="<?php echo base_url('admin/dashboard/termsedit/'.$value['id']); ?>" method="POST" enctype="multipart/form-data" >
							
							<div class="form-group">
								<label class="col-sm-3 control-label">Terms Title</label>
								<div class="col-sm-9">
									<input type="text" class="form-control" name="sub_menu" id="sub_menu" value="<?php if($value['footer_submenu'])echo $value['footer_submenu'] ?>">                             
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-3 control-label">Terms Content</label>
								<div class="col-sm-9">
									<?php
									if (!empty($value['page_desc'])) {
										echo  "<textarea class='form-control' id='ck_editor_textarea_id' rows='6' name='page_desc'>" . $value['page_desc'] ."</textarea>";
										echo display_ckeditor($ckeditor_editor1);
									}
									else {
										echo "<textarea class='form-control' id='ck_editor_textarea_id' rows='6' name='page_desc'> </textarea>";
										echo display_ckeditor($ckeditor_editor1);
									}
									?>
								</div>
							</div>
							<div class="m-t-30 text-center">
								<button name="form_submit" type="submit" class="btn btn-primary center-block" value="true">Save Changes</button>
							</div>
						</form>     
                        <?php } ?>  
                    </div>
                </div>
			</div>
        </div>
    </div>
</div>