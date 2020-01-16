<div class="content-page">
<?php 
    
    if($details['status'] == 1){
        $checkced2 = 'checked="checked"';
        $checkced1 = '';
    }else{
        $checkced1 = 'checked="checked"';
        $checkced2 = '';
    }

    $gig_id = (!empty($details['id']))?$details['id']:'0';

    $currency = (!empty($details['currency_type']))?$details['currency_type']:'USD';
    $currency_sign = currency_sign($currency);
 ?>
    <div class="content">

        <div class="container">

            <div class="row">

                <section class="product-header">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-8"><h2 class="text-left"><?php echo (!empty($details['title']))?ucfirst(str_replace('-', ' ', $details['title'])):'';?></h2></div>
                            <div class="col-md-4">
                            <h4 class="btn btn-success" ><?php echo (!empty($details['gig_price']))?'Price '.$currency_sign.' '.$details['gig_price']:'';?></h4>
                            </div>
                        </div>
                        
                        
                       

                    </div>
                </section>

                <div class="gig-info">

                    <div class="info-top">

                        <div class="container"> 

                            <div class="row">

                                <div class="col-md-12">

                                    <div class="gig-info-list">
                                        <span class="gig-deliver">Will deliver in <?php if($details['delivering_time'] > 1){echo $details['delivering_time'].' Days';}else{echo $details['delivering_time'].' Day';} ?><span class="gig-count">  </span></span>
                                    </div>      

                                </div>

                            </div>  

                        </div>

                    </div>



                </div>

                <section class="view-gig-area" style="transform: none;">    
                    <div class="container" style="transform: none;">        

                        <div class="row" style="transform: none;">

                            <div class="col-sm-8">

                                <div class="view-left">

                                    <div class="owl-carousel img-carousel owl-theme owl-loaded">
                                     <div class="owl-stage-outer">
                                        <div class="owl-stage" style="transform: translate3d(0px, 0px, 0px); transition: 0s; width: 640px;"><div class="owl-item active" style="width: 640px; margin-right: 0px;"><div class="item">

                                            <?php if(!empty($details['gig_images'][0]['image_path'])){ ?>
                                            <img class="img-responsive" src="<?php echo base_url(); ?><?php echo $details['gig_images'][0]['image_path']; ?>" alt="" width="680" height="460">
                                            <?php } ?>
                                            


                                        </div></div></div></div>
                                    </div>

                                        <div class="gig-information">
                                            <?php if(!empty($details['gig_details'])){ ?>
                                            <h3 class="gig-desc-title">Description</h3>    

                                            <p> <?php 
                                                echo $details['gig_details'];    
                                             ?> </p>
                                             <?php }  ?>

                                             <?php if(!empty($details['requirements'])){ ?>
                                             <h3 class="gig-desc-title">Requirements from user</h3>  

                                            <p> <?php 
                                                echo $details['requirements'];    
                                             ?> </p>
                                             <?php }  ?>

                                          



                                        </div>

                                        <?php 
                                           if(!empty($details['extra_gigs'])){  

                                         ?>


                                        <div class="extras-section">

                                            <div class="view-header clearfix">

                                                <h3 class="gig-view-title">Some Extras</h3>                  

                                            </div>

                                            <ul class="extras-list extra_gig_list">
                                                <?php 

                                                    $extra_gigs = $details['extra_gigs'];
                                                    foreach ($extra_gigs as $extragigs) { ?>
                                                <li>
                                            <div class="delivery-block clearfix">
                                            <p>
                                            <span class="extras-cont"><?php echo (!empty($extragigs['extra_gigs']))?$extragigs['extra_gigs']:''; ?></span>
                                            <span class="extra-input pull-right">  for  <span class="currency_symbol"><?php echo $currency_sign; ?>  <?php echo (!empty($extragigs['extra_gigs_amount']))?$extragigs['extra_gigs_amount']:''; ?></span> in <span class="delivery_days"> <?php echo (!empty($extragigs['extra_gigs_delivery']))?$extragigs['extra_gigs_delivery']:''; ?> day </span></span>         
                                            </div>
                                            </li> 
                                            <?php  } ?>                                      

                                    </ul>

                                </div>  
                                <?php }  ?>
                            </div>
                            

                        </div>
                           <div class="col-md-4">
                        <div class="row">
                                <div class="col-md-12">
                                    <form action="<?php echo base_url(); ?>admin/gig_activate" method="POST" >
                                    <label class="radio-inline">
                                        <input type="hidden" name="gig_id" value="<?php echo $gig_id; ?>">
                                      <input type="radio" name="gig_active" value="0" <?php echo $checkced1; ?>>Active
                                    </label>
                                    <label class="radio-inline">
                                      <input type="radio" name="gig_active" value="1" <?php echo $checkced2; ?>>Inactive
                                    </label>
                                    <input type="submit" name="save" value="Save" class="btn btn-success">
                                  </form>                                    
                                </div>
                            </div>
                        </div>

                    </div>  

                </div>  

            </section>
        </div>

    </div>

</div>
</div>
</div>
</div>
</div>