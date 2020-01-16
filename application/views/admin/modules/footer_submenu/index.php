<div class="content-page">
    <div class="content">
        <div class="container">
            <div class="row">
                <div class="col-sm-8">
                    <h4 class="page-title m-b-20 m-t-0">Footer Menu</h4>
                </div>
				<div class="col-sm-4 text-right m-b-20">
					<a href="<?php echo base_url($theme . '/' . $module . '/create'); ?>" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i> Add Menu</a>
				</div>
            </div>
			<?php if($this->session->userdata('message')) {  ?>
			<?php echo $this->session->userdata('message');?>
			<?php } ?> 
            <div class="panel">
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-actions-bar datatable">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Widget</th>
                                    <th>Menu Title</th>
                                    <th>Page Description</th>
                                    <th>Create Date</th>                                    
                                    <th>Status</th>
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
                                            $main_menu = $row['title'] ;
                                            $sub_menu = $row['footer_submenu'] ;                              
                                            $seo_title = $row['seo_title'];
                                            $seo_desc = $row['seo_desc'];
                                            $seo_keyword = $row['seo_keyword'];
                                            $page_title = isset($row['page_title']) ? $row['page_title'] : '';
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
                                        
                                            if(isset($row['page_desc']))
                                            {
                                               $page_content = $row['page_desc'] ;
                                            }                                                
                                            ?>
                                            <tr>
                                                <td> <?php echo $sno?></td>
                                                <td> <?php echo str_replace('_',' ',$main_menu);?></td>
                                                <td> <?php echo $sub_menu?></td>
                                                <td> <?php echo substr(strip_tags($page_content), 0,20);?><?php if(strlen($page_content)>20){?> ...<?php } ?> </td>
                                                <td> <?php echo $created_on?></td>                                                
                                                <td> <?php echo $user_status; ?></td>
                                                <td class="text-right">
                                                    <a href="<?php echo base_url('admin/footer_submenu/edit/' . $_id); ?>" class="on-default view-row table-action-btn" title="Edit"><i class="mdi mdi-pencil text-success"></i></a>&nbsp;
                                                    <a href="javascript:void(0)" class="on-default remove-row table-action-btn" title="Delete" id="Onremove_<?php echo $_id; ?>" onclick="delete_footer_submenu(<?php echo $_id; ?>);"><i class="mdi mdi-window-close text-danger"></i></a>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                   $sno = $sno +1;
                                        }
                                } else {
                                    ?>
                                    <tr>
                                        <td colspan="11"><p class="text-danger text-center m-b-0">No Records Found</p></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> 
    </div>