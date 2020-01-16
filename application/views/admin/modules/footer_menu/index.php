<div class="content-page">
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-sm-8">
                    <h4 class="page-title m-t-0">Footer Widget</h4>
					<p class="m-t-5">Maximum 4 footer widget only!</p>
                </div>
				<?php if($footercount<=3)
				{ ?>
				<div class="col-sm-4 text-right m-b-20">
					<a href="<?php echo base_url($theme . '/' . $module . '/create'); ?>" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add Menu</a>
				</div>
				<?php }
				?>
            </div>
			<?php if($this->session->userdata('message')) {  ?>
			<?php echo $this->session->userdata('message');?>
			<?php } ?> 
            <div class="panel">
                <div class="panel-body">
					<div class="table-responsive">
						<table class="table table-striped table-actions-bar m-b-0">
							<thead>
								<tr>
									<th>#</th>
									<th>Widget Name</th>                                    
									<th>Create Date</th>                                    
									<th class="text-right">Action</th>
								</tr>
							</thead>
							<tbody >
							<?php 
							if (!empty($lists)) {
								$sno = 1;
								foreach ($lists as $row) {
							$_id = isset($row['id']) ? $row['id'] : '';
							 if (!empty($_id)) {
								$page_name = isset($row['title']) ? $row['title'] : '';
								$user_status = 'Inactive';
								if (isset($row['status']) && $row['status'] == 1) {
									$user_status = 'Active';
								}
								 $created_on = '-';
								if (isset($row['created_date'])) {
									if (!empty($row['created_date']) && $row['created_date'] != "0000-00-00 00:00:00") {
										$created_on = '<span >' . date('d M Y', strtotime($row['created_date'])) . '</span>';
									}
								}                                               
								?>
								<tr>
									<td> <?php echo $sno?></td>
										<td> <?php echo str_replace('_',' ',$page_name); ?></td>                                                  
									<td> <?php echo $created_on?></td>                                                
									<td class="text-right">
										<a href="<?php echo base_url('admin/footer_menu/edit/' . $_id); ?>" class="on-default view-row table-action-btn" data-toggle="tooltip" data-placement="top" title="Edit"><i class="mdi mdi-pencil text-success"></i></a>&nbsp;
										<a href="javascript:;" class="on-default remove-row table-action-btn" data-toggle="tooltip" data-placement="top" title="Delete" id="Onremove_<?php echo $_id; ?>" onclick="delete_footer_menu(<?php echo $_id; ?>);"><i class="mdi mdi-window-close text-danger"></i></a>
									</td>
								</tr>
								<?php
									}
							   $sno = $sno +1;
									}
							} else {
								?>
								<tr>
									<td colspan="5"><p class="text-danger text-center m-b-0">No Records Found</p></td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>