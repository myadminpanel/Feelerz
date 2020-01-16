<?php 
    $active =$this->uri->segment(2);
    
    $query1 = $this->db->query("select * from setting WHERE id = 1");
	$result1 = $query1->row_array();
	$this->profilepic = '';
	 $fav1=base_url().'uploads';
	if(!empty($result1))
	{

	if($result1['profilepic']){
    	$this->profilepic = $result1['profilepic'];
	}
		if($result1['profilepic']){
			 $favicon1 = $result1['profilepic'];
	
	}
	}
	
	if(!empty($favicon1))
	{
     	$fav1 = base_url().'uploads/'.$favicon1;
	}
 ?>
 
<div class="sidebar">
            <div class="scroll-wrapper">
                <div class="navbar nav-title">
                    <a href="<?php echo base_url().'admin/dashboard'; ?>" class="site-title navbar-brand site-logo">
                        <img src="http://digimonk.net/social_media/assets/feelerz2.png" alt="logo" class="img-responsive">
                    </a>
                </div>
                <div class="nav toggle">
                    <a href="javascript:void(0)" id="sidebar-menu-toggle" class="btn btn-circle ripple">
                       <i class="fa fa-times"></i>
                    </a>
                </div>
                <div class="clearfix"></div>
                <!-- menu profile quick info -->
                <div class="profile clearfix">
                    <div class="profile-pic">
                         
                        <img src="<?php echo $fav1; ?>" alt="Profile picture" class="rounded-circle profile-img">
                    </div>
                   <?php $id=$this->session->userdata('SESSION_USER_ID');
                    // var_dump($id);
                    $data=$this->db->query("SELECT * FROM administrators WHERE ADMINID='".$id."'")->row_array();
                    // var_dump($data);
                    
                    ?>
                    <div class="profile-info">
                        <h2><?php echo $data['name'];?></h2>
                    </div>
                </div>
                <!-- /menu profile quick info -->
        
                <!-- search -->
                <div class="search-wrap d-sm-none clearfix text-center">
                    <form autocomplete="on">
                        <input class="search" name="search" type="text" placeholder="What're we looking for?">
                        <div>
                            <button class="search-submit" value="Rechercher" type="submit"> <i class="fa fa-search" aria-hidden="true"></i></button>
                        </div>
                    </form>
                </div>
                <!-- /search -->
        
                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main-menu-wrapper">
                    <div class="menu-section">
                        <ul class="nav side-menu flex-column">
                            <li class="nav-item">
                                <a href="<?php echo base_url().'admin'; ?>" class="ripple" title="Manage App User">
                                    <i class="fa fa-home" aria-hidden="true"></i>
                                    <span>User Dashboard</span>
                                </a>
                            </li>
							<li class="nav-item">
                                <a href="<?php echo base_url().'admin/user'; ?>" class="ripple" title="Manage App User">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                    <span>Manage App User</span>
                                    <!--<span class="fa fa-chevron-right"></span>-->
                                </a>
                            </li>
                            <li class="nav-item has-child">
                                <a href="<?php echo base_url().'admin/country'; ?>" class="ripple" title="Manage Country">
                                    <i class="fa fa-flag" aria-hidden="true"></i>
                                    <span>Manage Country</span>
                                    <!--<span class="fa fa-chevron-right"></span>-->
                                </a>
                                <!--<ul class="nav child-menu">
                                    <li class="child-menu-title">UI Elements</li>
                                    <li><a href="ui-colors.html">Colors</a></li>
                                    <li><a href="ui-typography.html">Typography</a></li>
                                    <li><a href="ui-buttons.html">Buttons</a></li>
                                    <li><a href="ui-cards.html">Cards</a></li>
                                    <li><a href="ui-tabs-accordions.html">Tabs & Accordions</a></li>
                                    <li><a href="ui-modals.html">Modals</a></li>
                                    <li><a href="ui-progress-bars.html">Progress Bars</a></li>
                                    <li><a href="ui-notifications.html">Notifications</a></li>
                                    <li><a href="ui-images.html">Images</a></li>
                                    <li><a href="ui-carousel.html">Carousel</a></li>
                                    <li><a href="ui-sliders.html">Sliders</a></li>
                                </ul>-->
                            </li>
                            <!--<li class="nav-item has-child">-->
                            <!--    <a href="<?php echo base_url().'admin/emoji/getemodetails'; ?>" class="ripple" title="Manage Emoji">-->
                            <!--        <i class="fa fa-smile-o" aria-hidden="true"></i>-->
                            <!--        <span>Manage Feelings</span>-->
                                    <!--<span class="fa fa-chevron-right" aria-hidden="true"></span>--->
                            <!--    </a>-->
                                <!--<ul class="nav child-menu">
                                 <li class="child-menu-title">Tables</li>-->
                            <!--        <li><a href="basic-tables.html">Basic Tables</a></li>-->
                            <!--        <li><a href="data-tables.html">Data Tables</a></li>-->
                            <!--    </ul>-->
                            <!--</li>-->
                            
                            
                            
                <li class="nav-item has-child">
                    <a href="javascript:void(0);" class="ripple" title="Manage Feelings">
                        <i class="fa fa-file-word-o" aria-hidden="true"></i>
                        <span>Manage Feelings</span>
                        <span class="fa fa-chevron-right" aria-hidden="true"></span>
                    </a>
        <ul class="nav child-menu">
            <!--<li class="child-menu-title">Images</li>-->
            <li><a href="<?php echo base_url().'admin/mainfeeling'; ?>">Main Feelings</a></li>
            <li><a href="<?php echo base_url().'admin/emoji/getemodetails'; ?>">Sub Feelings</a></li>
            <!--<li> <a href="<?php echo base_url().'admin/managevideos'; ?>"> Video</a></li>-->
            <!--<li><a href="form-layouts.html">Form Layouts</a></li>
            <li><a href="form-wizard.html">Form Wizard</a></li>-->
        </ul>
     </li>
                            
                            
                            
                            
                            
                            <!--<li class="nav-item has-child">-->
                            <!--    <a href="manage-trending.html" class="ripple" title="Manage Trending">-->
                            <!--        <i class="fa fa-line-chart" aria-hidden="true"></i>-->
                            <!--        <span>Manage Trending</span>-->
                                    <!--<span class="fa fa-chevron-right" aria-hidden="true"></span>-->
                            <!--    </a>-->
                                <!--<ul class="nav child-menu">
                                  <li class="child-menu-title">Icons</li>-->
                            <!--        <li><a href="icons-material.html">Material Design</a></li>-->
                            <!--        <li><a href="icons-fontawesome.html">Font awesome</a></li>-->
                            <!--    </ul>-->
                            <!--</li>-->
                            <!--<li class="nav-item has-child">-->
                            <!--    <a href="javascript:void(0);" class="ripple" title="Manage Content">-->
                            <!--        <i class="fa fa-file-word-o" aria-hidden="true"></i>-->
                            <!--        <span>Manage Content</span>-->
                            <!--        <span class="fa fa-chevron-right" aria-hidden="true"></span>-->
                            <!--    </a>-->
                                
                                
                 <li class="nav-item has-child">
                   <a href="<?php echo base_url().'admin/post'; ?>" class="ripple" title="Manage Post">
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                        <span>Manage Post</span>
                        <!--<span class="fa fa-chevron-right"></span>-->
                    </a>
                    </li>
                    
                     <li class="nav-item has-child">
                    <a href="<?php echo base_url().'admin/managesupport'; ?>" class="ripple" title="Manage Support">
                        <i class="fa fa-support" aria-hidden="true"></i>
                        <span>Manage Support</span>
                        <!--<span class="fa fa-chevron-right"></span>-->
                    </a>
                    </li>
                                
                <!--    <ul class="nav child-menu">-->
                        <!--<li class="child-menu-title">Images</li>-->
                        <!--<li><a href="<?php echo base_url().'admin/manageimages'; ?>">Images</a></li>-->
                <!--        <li><a href="<?php echo base_url().'admin/post'; ?>">Post</a></li>-->
                        <!--<li> <a href="<?php echo base_url().'admin/managevideos'; ?>"> Video</a></li>-->
                        <!--<li><a href="form-layouts.html">Form Layouts</a></li>
                      <li><a href="form-wizard.html">Form Wizard</a></li>-->
                <!--    </ul>-->
                <!--</li>-->

                            <li class="nav-item has-child">
                                <a href="<?php echo base_url().'admin/managereported'; ?>" class="ripple" title="Manage Reported Post">
                                    <i class="fa fa-file-powerpoint-o" aria-hidden="true"></i>
                                    <span>Manage Reported Post</span>
                                    <!--<span class="fa fa-chevron-right"></span>-->
                                </a>
                                <!--<ul class="nav child-menu">
                                    <li class="child-menu-title">Extras</li>
                                    <li><a href="403-error.html">403 Error</a></li>
                                    <li><a href="404-error.html">404 Error</a></li>
                                    <li><a href="500-error.html">500 Error</a></li>
                                    <li><a href="invoice.html">Invoice</a></li>
                                    <li class="has-child">
                                        <a href="javascript:void(0);" title="Login">
                                            <span>Login</span>
                                            <span class="fa fa-chevron-right"></span>
                                        </a>
                                        <ul class="nav child-menu">
                                            <li><a href="login.html">Login V1</a></li>
                                            <li><a href="loginV2.html">Login V2</a></li>
                                        </ul>
                                    </li>
                                    <li class="has-child">
                                        <a href="javascript:void(0);" title="Register">
                                            <span>Register</span>
                                            <span class="fa fa-chevron-right"></span>
                                        </a>
                                        <ul class="nav child-menu">
                                            <li><a href="register.html">Register V1</a></li>
                                            <li><a href="registerV2.html">Register V2</a></li>
                                        </ul>
                                    </li>
                                    <li><a href="lockscreen.html">Lockscreen</a></li>
                                    <li><a href="recover-password.html">Recover Password</a></li>
                                    <li><a href="user-profile.html">User Profile</a></li>
                                    <li class="has-child">
                                        <a href="javascript:void(0);" title="Email Templates">
                                            <span>Email Templates</span>
                                            <span class="fa fa-chevron-right"></span>
                                        </a>
                                        <ul class="nav child-menu">
                                            <li><a href="email-template-basic.html">Email Template Basic</a></li>
                                            <li><a href="email-template-alert.html">Email Template Alert</a></li>
                                            <li><a href="email-template-billing.html">Email Template Billing</a></li>
                                        </ul>
                                    </li>
                                    <li class="has-child">
                                        <a href="javascript:void(0);" title="Coming Soon">
                                            <span>Coming Soon</span>
                                            <span class="fa fa-chevron-right"></span>
                                        </a>
                                        <ul class="nav child-menu">
                                            <li><a href="coming-soon.html">Coming Soon</a></li>
                                            <li><a href="coming-soonV2.html">Coming Soon V2</a></li>
                                        </ul>
                                    </li>
                                </ul>-->
                            </li>
                            <li class="nav-item has-child">
                                <a href="javascript:void(0);" class="ripple" title="Manage CMS Page">
                                    <i class="fa fa-file" aria-hidden="true"></i>
                                    <span>Manage CMS Page</span>
                                    <span class="fa fa-chevron-right"></span>
                                </a>
                                <ul class="nav child-menu">
                                    <!--<li class="child-menu-title"></li>-->
                                    <li><a href="<?php echo base_url().'admin/privacypolicy'; ?>">Privacy Policy</a></li>
                                    <li><a href="<?php echo base_url().'admin/about'; ?>">About us</a></li>
									<!--<li><a href="<?php echo base_url().'admin/disclaimer'; ?>">Legal Disclaimer</a></li>-->
									<!-- <li><a href="<?php echo base_url().'admin/managesupport'; ?>">Manage Support</a></li> -->
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="<?php echo base_url().'admin/setting'; ?>" title="Setting">
                                    <i class="fa fa fa-cog" aria-hidden="true"></i>
                                    <span>Setting</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- /sidebar menu -->
            </div>
</div>