<div class="content-page">
    <div class="content">
        <div class="container">
            <div class="row">
                <h4>Add Other Language Keywords</h4>
                <div class="panel">
                    <div class="panel-body">
                        <div class="table-responsive">
                            <form action="<?php echo base_url().'admin/language_management_controller/update_multi_language/';?>" onsubmit="update_multi_lang();" method="post" id="form_id">
                                
                            
                            <table class="table table-striped table-actions-bar datatable">
                                <thead>
                                    <tr>
                                        <?php
                                        if (!empty($active_language))
                                        {
                                            foreach ($active_language as $row)
                                            {  
                                                ?>
                                                <th><?php echo ucfirst($row['language'])?></th>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody>
                               <?php
                                    foreach ($language_list as $keyword) {
                                        ?>
                                        <tr>
                                            <?php 
                               
                                            if (!empty($active_language))
                                            {
                                                foreach ($active_language as $row)
                                                {     
                                                 $lg_language_name = $keyword['lang_key'];   
                                                 $language_key = $row['language_value']; 



                                                 $key = $keyword['language'] ;
                                                 $value = ($language_key == $key)?$keyword['lang_value']:'';

                                                $key = $keyword['language'] ;
                                                $value = (!empty($currenct_page_key_value[$lg_language_name][$language_key]))?$currenct_page_key_value[$lg_language_name][$language_key]:'';
                                                $readonly = ($language_key=='en')?'readonly':'';

                                                 ?>

                                                    <td>

                         <input type="text" class="form-control" name="<?php echo $lg_language_name; ?>[<?php echo $language_key; ?>]" value="<?php echo  $value;  ?>" <?php echo $readonly; ?> ></td>

                                                    <?php
                                                }

                                }else {
                                    ?>
                                     </tr>
                                    <tr>
                                        <td colspan="10"><p class="text-danger text-center m-b-0">No Records Found</p></td>
                                    </tr>
                                    <?php } ?>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <div class="m-t-30 text-center">
                            <button name="form_submit"  type="submit" class="btn btn-primary center-block" value="true">Save</button>
                        </div>
                        </form>
                        <ul class="pagination pull-right">
                            <?php echo $create_links; ?>
                        </ul>
                        
                    </div>
                </div>
            </div>     
        </div>
    </div>
</div>
</div>


<script type="text/javascript">
    
    function update_multi_lang()
    {
        
        
        $("#form_id").submit();
    }

</script>