 <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container">

                        <!-- Page-Title -->
                        <div class="row">
                            <div class="col-sm-12">
                                <h4 class="page-title">Request</h4>
                                <ol class="breadcrumb">
                                    <li><a href="<?php echo base_url().'admin' ?>">Home</a></li>
                                   <li><a href="<?php echo base_url('admin/request');?>">Request</a></li>                                     
                                    <li class="active">Edit </li>
                                </ol>
                            </div>
                        </div>
                        
                        <div class="row">
        <div class="col-lg-12">
                <div class="card-box">
                        <h4 class="m-t-0 header-title"><b>Edit Request </b></h4>
                        <p class="text-muted font-13 m-b-30">
<?php // print_r($child_category) ; ?>
</p>

            <form id="admin_add_cat" action="<?php echo base_url().'admin/request/edit_request/'.$list['id']; ?>" method="post"  enctype="multipart/form-data"  >
                                
                                <div class="form-group">
                                        <label for="req_desc"> Request Description </label>
                                        <textarea name="req_desc" class="form-control" id="category_name" required> <?php if(!empty($list['req_desc'])){echo $list['req_desc']; } ?> </textarea>
                                </div>                        
                
                                <div class="form-group">
                                        <label for="parent_category">Parent Category </label>
                                        <select  class="form-control" name="parent_category">
                                             <option value="0">None</option>
                                            <?php foreach ($parent_category as $parent_cat) { ?>
                                            <option value="<?php echo $parent_cat['CATID'];?>" <?php if($parent_cat['CATID'] == $list['main_cat']){ echo "selected";} ?>><?php  echo $parent_cat['name']; ?></option>    
                                            <?php } ?>
                                        </select>
                                </div>                                
                                <div class="form-group">
                                        <label for="child_category">Child Category </label>
                                        <select  class="form-control" name="child_category">
                                             <option value="0">None</option>
                                            <?php foreach ($child_category as $child_cat) { ?>
                                            <option value="<?php echo $child_cat['CATID'];?>" <?php if($child_cat['CATID'] == $list['sub_cat']){ echo "selected";} ?>><?php  echo $child_cat['name']; ?></option>    
                                            <?php } ?>
                                        </select>
                                </div>    									 
                                <div class="form-group">
                                        <label for="delivery_time"> Delivery Time </label>
                                        <input type="text" name="delivery_time"  placeholder="Enter Delivery Time" value="<?php if(!empty($list['delivery_time'])){echo $list['delivery_time']; } ?>"  class="form-control" id="delivery_time">
                                </div>
                                <div class="form-group">
                                        <label for="amount"> Amount </label>
                                        <input type="text" name="amount"    placeholder="Enter amount " value="<?php if(!empty($list['amount'])){echo $list['amount']; } ?>" class="form-control" id="amount">
                                </div>     
                <?php if(!empty($list['uploaded_file'])){ ?>
                <a href="<?php echo base_url().$list['uploaded_file']; ?>" download>download file </a> <?php } ?>
                                <div class="form-group">                                     
                                        <label for="request_file"> Attachment File </label>
                                        <input type="file" name="request_file"    class="form-control" id="request_file" >
                                </div> 
                                
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label">Status</label>
                                    <div class="col-sm-9">
                                        <div class="radio radio-info radio-inline">
                                            <input type="radio" id="blog_status1" value="0" name="status" <?php
                                            if ($list['status'] == 0) {
                                                echo 'checked=""';
                                            }
                                            ?>>
                                            <label for="blog_status1">Active</label>
                                        </div>
                                        <div class="radio radio-inline">
                                            <input type="radio" id="blog_status2" value="1" name="status" <?php
                                            if ($list['status'] == 1) {
                                                echo 'checked=""';
                                            }
                                            ?>>
                                            <label for="blog_status2">Inactive</label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group text-right m-b-0">
                                    <button class="btn btn-primary waves-effect waves-light" name="form_submit" value="submit" type="submit">
                                                Submit
                                        </button>
                                        <button type="reset" class="btn btn-default waves-effect waves-light m-l-5">
                                                Cancel
                                        </button>
                                </div>
                        </form>
                </div>
        </div>
</div>
                    </div>
                </div>
 </div>