
<div class="content-page">
    <div class="content">
        <div class="container">            
            <div class="row"> 
                <div class="panel-body">
                    <?php if($this->session->flashdata('message')) { ?>
                    <div class="alert alert-success text-center fade in" id="flash_succ_message">
                    <?php echo $this->session->userdata('message'); ?>
                    <?php } ?>
                    </div>               
                <div class="col-md-8 col-md-offset-2">
                    <h4 class="page-title m-b-20 m-t-0 text-center">Language Management</h4>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="card-box">
                        <form class="form-horizontal" id="" onsubmit="return language_validation();" action="" method="POST">
                            <div class="tab-pane active">
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Language</label>
                                    <div class="col-sm-9">
                                        <input  type="text" id="language" name="language" value="" class="form-control" >
                                        <small class="error_msg help-block language_error" style="display: none;">Please enter a language</small>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-3 control-label">Value</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="value" name="value" value="" class="form-control" >
                                        <small class="error_msg help-block value_error" style="display: none;">Please enter a value</small>
                                    </div>
                                </div>
                            </div>
                            <div class="m-t-30 text-center">
                                <button name="form_submit"  type="submit" class="btn btn-primary center-block" value="true">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <h4 class="page-title m-b-20 m-t-0 text-center">All Languages</h4>
        <div class="panel">

                <div class="panel-body">

                        <div class="table-responsive">

                            <table class="table table-striped table-actions-bar">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Language</th>
                                        <th>Language Value</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody >
                                    <?php 
                                    
                                    if (!empty($list))
                                    {
                                        foreach ($list as $row)
                                        {      
                                        $new = '';      
                                        $status = 'Active';
                                        if($row['status']==2){
                                            $status = 'Inactive';

                                        }else{

                                        }  
                                                ?>
                                                <tr>
                                                    <td> <?php echo $row['id']?></td>
                                                    <td> <?php echo  $row['language'] ?></td>
                                                    <td> <?php echo  $row['language_value'] ?></td>
                                                    <td class="toogle_switch">
                                                        <?php $status = ''; if ($row['status'] == 1) {  $status = 'checked="checked"'; } 

                                                            $new='';                                        

                                                            if($this->session->userdata('id') != 1)

                                                            {

                                                             // $new ='disabled'; // Only enable demo users                

                                                            }?>
                                                        <input type="checkbox" <?php echo  $new; ?> <?php echo $status; ?>  class="alert-status switch" id="<?php echo $row['id']; ?>" data-size="normal" name="my-checkbox" data-on-text="on" data-off-text="off">

                                            </td>
                                                </tr>
                                                <?php
                                            }
                                       
                                            }else {
                                        ?>
                                        <tr>
                                            <td colspan="6"><p class="text-danger text-center m-b-0">No Records Found</p></td>
                                        </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>


<script type="text/javascript">
    
function language_validation(){

    var error =0;
    var language = $('#language').val().trim();
    
    
    if(language==""){
        $('.language_error').show();
        error =1; 
    }else{
        $('.language_error').hide();
      
    }

    var value = $('#value').val().trim();
    
    
    if(value==""){
        $('.value_error').show();
        error =1; 
    }else{
        $('.value_error').hide();
         
    }

if(error==0){
      return true;
}else{
      return false;
}

}

    
    function delete_language(val)
        {
                 bootbox.confirm("Are you sure want to Delete ? ", function(result) {
                //alert(result);
               if(result ==true)                {
                var url        = BASE_URL+'admin/language_management_controller/delete_language';
        var id = val;                               
              $.ajax({
              url:url,
              data:{id:id}, 
              type:"POST",
              success:function(res){ 
                if(res==1)
                        {
                           window.location = BASE_URL+'admin/language_management_controller/language';
                        }
              }
        });  
        }
            }); 
             }     


</script>
