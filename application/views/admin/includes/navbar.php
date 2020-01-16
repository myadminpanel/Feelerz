<?php

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

<div class="content-wrapper">
<header class="header">
                <nav class="header-menu">
                    <div class="nav toggle">
                        <a href="javascript:void(0)" id="menu-toggle" class="ripple">
                            <span class="bars"></span>
                        </a>
                    </div>
                    <ul class="nav navbar-nav navbar-right">
                        
                        <!--<li role="presentation" class="dropdown notifications-list">-->
                        <!--    <a href="javascript:void(0)" class="dropdown-toggle info-number ripple" data-toggle="dropdown" aria-expanded="false">-->
                        <!--        <i class="fa fa-bell-o"></i>-->
                        <!--        <span class="badge">6</span>-->
                        <!--    </a>-->
                        <!--    <ul id="menu" class="dropdown-menu list-unstyled dropdown-menu-lg" role="menu">-->
                        <!--        <li class="notif-title"> Notifications-->
                        <!--            <button type="button" class="float-right close btn btn-circle d-none d-block-xs"><i class="fa fa-close"></i></button>-->
                        <!--        </li>-->
                                <!--<li class="list-group notification-list">-->
                                <!--  <ul class="p-0">-->
                                      <!-- list item-->
                                <!--      <li class="list-group-item">-->
                                <!--          <a href="javascript:void(0);">-->
                                <!--              <div class="m-r-10 notif-img float-left">-->
                                <!--                  <i class="fa fa-exclamation-triangle text-danger" aria-hidden="true"></i>-->
                                <!--              </div>-->
                                <!--              <div class="notif-info d-flex align-items-center justify-content-between"><p class="text-danger notif-text">98% Server Load</p>-->
                                <!--                  <span class="time">12 min ago</span>-->
                                <!--              </div>-->
                                <!--          </a>-->
                                <!--      </li>-->
                                      <!-- list item-->
                                  <!--    <li class="list-group-item">-->
                                  <!--        <a href="javascript:void(0);">-->
                                  <!--            <div class="m-r-10 notif-img float-left">-->
                                  <!--                <i class="fa fa-exclamation-triangle text-warning " aria-hidden="true"></i>-->
                                  <!--            </div>-->
                                  <!--            <div class="notif-info d-flex align-items-center justify-content-between"><p class="text-warning notif-text">Warning Notification</p>-->
                                  <!--                <span class="time">12 min ago</span>-->
                                  <!--            </div>-->
                                  <!--        </a>-->
                                  <!--    </li>-->
                                      <!-- list item-->
                                  <!--    <li class="list-group-item">-->
                                  <!--        <a href="javascript:void(0);">-->
                                  <!--            <div class="m-r-10 notif-img float-left">-->
                                  <!--                <i class="fa fa-check-circle text-success" aria-hidden="true"></i>-->
                                  <!--            </div>-->
                                  <!--            <div class="notif-info d-flex align-items-center justify-content-between"><p class="text-success notif-text">Success Notification</p>-->
                                  <!--              <span class="time">12 min ago</span>-->
                                  <!--            </div>-->
                                  <!--        </a>-->
                                  <!--    </li>-->
            
                                  <!--</ul>-->
                        <!--        </li>-->
                        <!--        <li class="read-all-notif"><a href="javascript:void(0)">Read all notifications<i class="fa fa-angle-right" aria-hidden="true"></i></a></li>-->
                        <!--    </ul>-->
                        <!--</li>-->
                      
                       
                        <li class="profile-dropdown dropdown">
                            <a href="javascript:void(0)" class="user-profile dropdown-toggle ripple" data-toggle="dropdown" aria-expanded="false">
                         <?php $id=$this->session->userdata('SESSION_USER_ID');
                    // var_dump($id);
                    $data=$this->db->query("SELECT * FROM administrators WHERE ADMINID='".$id."'")->row_array();
                    // var_dump($data);
                    
                    ?>
                                <img src="<?php echo $fav1; ?>" alt="Profile picture" class="rounded-circle">
                                <span class="d-none d-sm-block"><?php echo $data ['name']; ?> </span>
                                
                                <span class="fa fa-angle-down"></span>
                            </a>
                            <ul class="dropdown-menu float-right">
                                <li class="d-none d-block-xs p-0">
                                    <button type="button" class="close btn btn-circle"><i class="fa fa-close"></i></button>
                                    <div class="profile clearfix">
                                        <div class="profile-pic">
                                            <img src="<?php echo base_url(); ?>assets/images/avatar.png" alt="Profile picture" class="rounded-circle profile-img">
                                        </div>
                                        <div class="profile-info">
                                            <h2>James Mcavoy</h2>
                                        </div>
                                    </div>
                                </li>
                                <!--<li><a href="user-profile.html"><i class="fa fa-user-o" aria-hidden="true"></i>Profile</a></li>-->
                                <!--<li><a href="javascript:void(0)"><i class="fa fa-cog" aria-hidden="true"></i> Settings</a></li>
                                <li><a href="lockscreen.html"><i class="fa fa-lock" aria-hidden="true"></i> Lock screen</a></li>-->
                                <li class="divider"></li>
                                <li><a href="<?php echo base_url()."admin/dashboard/logout"; ?>"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </nav>
</header>