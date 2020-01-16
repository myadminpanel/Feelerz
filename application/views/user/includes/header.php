<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0' >
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
<?php 
	
	$base_url = base_url();

   $fav = base_url().'assets/images/favicon.png';
	$query=$this->db->query("select * from system_settings WHERE status = 1");
	$result=$query->result_array();
	 $meta_title = $meta_keywords = $meta_description = '';
	 $website_email ='admin@dreamguys.co.in';
	   $this->site_name='';
	if(!empty($result))
	{
		$sitename=$meta_keywords=$meta_description='';
	foreach($result as $data){
		if($data['key'] == 'meta_title'){
		     $meta_title = $data['value'];
	}
			if($data['key'] == 'meta_keywords'){
			 $meta_keywords = $data['value'];
		
	}
		if($data['key'] == 'site_name' ||  $data['key'] == 'website_name'){
        $this->site_name = $data['value'];
        }
			if($data['key'] == 'meta_description'){
			 $meta_description = $data['value'];
	}
	if($data['key'] == 'favicon'){
			 $favicon = $data['value'];
	}
	if($data['key'] == 'website_email'){
		$website_email = $data['value'];
	}
	}
	}
	if(!empty($favicon))
	{
		$fav = base_url().'uploads/logo/'.$favicon;
	}
	?>
		<title><?php echo  $meta_title; ?></title>
    <meta name="description" content="<?php echo $meta_description;?>">
	<meta name="keywords" content="<?php echo $meta_keywords ;?>">
	<link rel="shortcut icon" href="<?php echo $fav;  ?>">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" media="screen" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/css/owl.carousel.css" rel="stylesheet">
    <link href="<?php echo base_url(); ?>assets/css/owl.theme.default.min.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/css/font-awesome.min.css" media="screen" rel="stylesheet" type="text/css" />	        
	<link href="<?php echo base_url(); ?>assets/css/select2.min.css" media="screen" rel="stylesheet" type="text/css" />	        
	<link href="<?php echo base_url(); ?>assets/css/jquery-ui.css" media="screen" rel="stylesheet" type="text/css" />
	<?php if($module=="profile" ) { ?>
	<link href="<?php echo base_url(); ?>assets/css/cropper.min.css" media="screen" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>assets/css/bootstrap-tokenfield.css" media="screen" rel="stylesheet" type="text/css" />
	<link href="<?php echo base_url(); ?>assets/css/tokenfield-typeahead.css" media="screen" rel="stylesheet" type="text/css" />
	<?php } ?>
	<?php if($module=="sell_service" || $module=="edit_gig" ) { ?>
	<link href="<?php echo base_url(); ?>assets/css/bootstrap-tagsinput.css" media="screen" rel="stylesheet" type="text/css" />
	<?php } ?>
	<link href="<?php echo base_url(); ?>assets/css/app.css" media="screen" rel="stylesheet" type="text/css" />
<!-- <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async='async'>
</script>
<script>
    var OneSignal = window.OneSignal || [];
    OneSignal.push(["init", {
        appId: "be2f5422-99a5-4c91-9ada-cd11efa7a231",
        autoRegister: true,
        httpPermissionRequest: {
            enable: true
        },
        notifyButton: {
            enable: true
        }
    }]);
</script> -->

	<?php  /* if($one_signal_user_id!='') { ?>
<!-- One Signal -->
 <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async></script>
        <script>
        	var base_url = "<?php echo $base_url;?>";
        	var user_id = "<?php echo $one_signal_user_id;?>";

            var OneSignal = window.OneSignal || [];
            OneSignal.push(["init", {
                appId: "<?php  echo $one_signal_app_id; ?>",
                subdomainName: "<?php echo $one_signal_subdomain; ?>",
                autoRegister: true,
          		httpPermissionRequest: {
            		enable: true
        		},
        		notifyButton: {
            		enable: true
            	}	
        		// ,
          //       promptOptions: {
          //           actionMessage: "We'd like to show you notifications for the latest news.",
          //           acceptButtonText: "ALLOW",
          //           cancelButtonText: "NO THANKS"
          //       }
            }]);
        </script>
        <script>
            // function subscribe() {
            //     // OneSignal.push(["registerForPushNotifications"]);
            //     OneSignal.push(["registerForPushNotifications"]);
            //     event.preventDefault();
            // }
            // function unsubscribe(){
            //     OneSignal.setSubscription(true);
            // }
            var OneSignal = OneSignal || [];
            var userId = "<?php  echo $one_signal_user_id; ?>";
            OneSignal.push(function() {
                
                // Occurs when the user's subscription changes to a new value.
                OneSignal.on('subscriptionChange', function (isSubscribed) {
                    console.log("The user's subscription state is now:", isSubscribed);
                    OneSignal.sendTag("user_id",userId, function(tagsSent)
                    {
                        // Callback called when tags have finished sending
                        console.log("Tags have finished sending!");
                    });
                });

                 OneSignal.getUserId(function(userId) {
                 	 device_id = userId;
                 	 $.post(base_url+'devicedetails',{device_id:device_id,device:'browser',user_id:user_id}, function(data, status){
       						console.log(data);
       						console.log(status);
    				});
   						 console.log("OneSignal User ID:", userId);
  				});

                var isPushSupported = OneSignal.isPushNotificationsSupported();
                if (isPushSupported)
                {
                    // Push notifications are supported
                    OneSignal.isPushNotificationsEnabled().then(function(isEnabled)
                    {
                        if (isEnabled)
                        {
                            console.log("Push notifications are enabled!");

                        } else {
                            OneSignal.showHttpPrompt();
                            console.log("Push notifications are not enabled yet.");
                        }
                    });

                } else {
                    console.log("Push notifications are not supported.");
                }
            });
        </script>  
        <?php
        
        // One signal end 
          } */ ?>

	<!--[if lt IE 9]>
		<script src="<?php echo base_url(); ?>assets/js/html5shiv.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/respond.min.js"></script>
	<![endif]-->
</head>
<body> 
	<div id="main-wrapper">
		<?php
		if($this->session->userdata('SESSION_USER_ID'))
		{ $user_id = $this->session->userdata('SESSION_USER_ID');              
		$query = $this->db->query("SELECT `username` , user_thumb_image , fullname FROM `members` WHERE `USERID` = $user_id ");
		$result = $query->row_array();
		$header_username = $result['username'];                        
		$header_user_image = base_url()."assets/images/avatar2.jpg";   
		if($result['user_thumb_image']!='')
		{
			$header_user_image = base_url().$result['user_thumb_image'];   
		}
		$header_user_fullname = $result['fullname'];                        
		?>
		<input type="hidden" name="session_user_id" id="session_user_id" value="<?php echo $user_id; ?>" >
		<?php }
		?>
	    <header class="header" id="header">
            <div class="menu-bar">
                <div class="container">
                    <nav id="menu-navigation" class="main-menu">
						<input type="hidden" id="selected_menu" name="selected_menu" value="">
                        <ul class="nav navbar navbar-static-top">
                            <?php if(($this->session->userdata('SESSION_USER_ID')))
                            {  ?>
							<li id="menu-1" class="menu-1 <?php if($module == 'gigs') echo 'active'; ?>"><a href="<?php echo base_url(); ?>">Welcome</a></li>
							<li id="menu-2" class="menu-2 <?php if($module == 'sell_service') echo 'active'; ?>"><a href="<?php echo base_url().'sell-service'; ?>">Sell Service</a></li>            
							<li id="menu-3" class="menu-3 <?php if($module == 'buy_service') echo 'active'; ?>"><a href="<?php echo base_url().'buy-service'; ?>">Buy Service</a></li>
							<li id="menu-4" class="dropdown menu-4 <?php if($module == 'reminder' || $module == 'last_visited') echo 'active'; ?>">
								<a href="<?php echo base_url().'reminder'; ?>">Reminder</a>
								<ul class="dropdown-menu">
									<li><a href="<?php echo base_url().'reminder'; ?>">Favorites Gigs</a></li>
									<li><a href="<?php echo base_url().'last-visited'; ?>">Last Visited Gigs</a></li>
								</ul>
							</li>
							<li id="menu-5" class="dropdown menu-5 <?php if($module == 'message') echo 'active'; ?>">
								<a href="<?php echo base_url().'message'; ?>">Messages
									<span class="badge badge-success pull-right" id="new_message_count" style="display: none;"></span>   
								</a>
								<div id="message_notification"></div>
							</li>
							<li id="menu-6"  class="dropdown menu-6 <?php if($module == 'notification') echo 'active'; ?>">
								<a href="<?php echo base_url().'notification'; ?>">Alerts 
									<span id="notification_count" class="badge badge-success pull-right" style="display: none"> </span>
								</a>
								<div class="dropdown-menu notifications arrow" id="notification_notification"></div>
							</li>    
							<li id="menu-7" class="dropdown menu-7 <?php if($module == 'password' || $module == 'profile' || $module == 'payment_settings' ) echo 'active'; ?> ">
								<a href="<?php echo base_url().'password'; ?>">Settings</a>
								<ul class="dropdown-menu">
									<li><a href="<?php echo base_url().'password'; ?>">Account Settings</a></li>
									<li><a href="<?php echo base_url().'profile'; ?>">Profile Settings</a></li>
									<li><a href="<?php echo base_url().'payment-settings'; ?>">Payment Settings</a></li>
								</ul>
							</li>                             
							<li id="menu-8" class="dropdown menu-8 <?php if($module == 'purchases' || $module == 'my_gigs' || $module == 'sales' || $module == 'payments' || $module == 'user_profile' ) echo 'active'; ?> ">
								<img class="menu-pro-img" src="<?php echo $header_user_image ; ?>" alt="<?php echo $header_user_fullname ; ?>" 
								title="<?php echo $header_user_fullname ; ?>" width="50" height="50">
								<a href="<?php echo base_url().'user-profile/'.$header_username; ?>">
									Profile
								</a>
								<ul class="dropdown-menu">
									<li><a href="<?php echo base_url().'purchases'; ?>">My Purchases</a></li>
									<li><a href="<?php echo base_url().'my-gigs'; ?>">My Gigs</a></li>
									<li><a href="<?php echo base_url().'sales'; ?>">My Sales</a></li>
									<li><a href="<?php echo base_url().'payments'; ?>">My Payments</a></li>
									<li><a href="<?php echo base_url().'user-profile/'.$header_username; ?>">My Profile</a></li>
									<li><a href="<?php echo base_url().'logout'; ?>">Log Out</a></li>
								</ul>
							</li>    
							<?php } else {  ?>
							<li id="menu-1" class="menu-1 <?php if($module == 'gigs') echo 'active'; ?> ">
								<a href="<?php echo base_url(); ?>">
									Welcome
								</a>
							</li>
                            <li id="menu-2" class="menu-2">
                                <a href="javascript:;" onclick="selected_menu('sell-service')" >
                                    Sell Service
                                </a>
                            </li>
                            <li id="menu-3" class="menu-3 <?php if($module == 'buy_service') echo 'active'; ?>">
                                <a href="<?php echo base_url().'buy-service'; ?>" >
                                    Buy Service
                                </a>
                            </li>
                            <li id="menu-4" class="menu-4">
                                <a href="javascript:;" onclick="selected_menu('reminder')">
                                    Reminder
                                </a>
                            </li>
                            <li id="menu-5" class="menu-5">
                                <a href="javascript:;" onclick="selected_menu('message')">
                                    Messages
                                </a>
                            </li>
							<li id="menu-6" class="dropdown menu-6">
                                <a href="javascript:;" onclick="selected_menu('notification')">
                                    Alerts
                                </a>                                 
                            </li>
							<li id="menu-7" class="menu-7">
                                <a href="javascript:;" onclick="selected_menu('password')">
                                    Settings
                                </a>
                            </li>
							<li id="menu-8" class="dropdown menu-8 login-img" >
                                <a href="javascript:;"  data-toggle="modal" data-target="#login-popup">
                                    Log In
                                </a>                                 
                            </li>
                          <?php } ?> 
                        </ul>
                    </nav>
                </div>
				<div class="sidebar">
					 <?php if(($this->session->userdata('SESSION_USER_ID')))
						{   ?>
					<div class="sidebar-inner slimscroll">
					<a href="#" id="close_menu"><i class="fa fa-close"></i></a>
					<ul class="mobile-menu-wrapper">
						<li class="<?php if($module == 'gigs') echo 'active'; ?>">
							<div class="mobile-menu-item clearfix">
								<a href="<?php echo base_url(); ?>">
									Welcome
								</a>
							</div>
						</li>
						<li class="<?php if($module == 'sell_service') echo 'active'; ?> " >
							<div class="mobile-menu-item clearfix">
								<a href="<?php echo base_url().'sell-service'; ?>">
									Sell Service
								</a>
							</div>
						</li>
						<li class="<?php if($module == 'buy_service') echo 'active'; ?> ">
							<div class="mobile-menu-item clearfix">
								<a href="<?php echo base_url().'buy-service'; ?>">
									Buy Service
								</a>
							</div>
						</li>
						<li class="<?php if($module == 'reminder' || $module == 'last_visited') echo 'active'; ?>">
							<div class="mobile-menu-item clearfix">
								<a href="<?php echo base_url().'reminder'; ?>">
									Reminder
									<i class="fa fa-chevron-down menu-toggle"></i>
								</a>
							</div>
							 <ul class="mobile-submenu-wrapper">
								<li class="nav-row"><a href="<?php echo base_url().'reminder'; ?>">Favorites Gigs</a></li>
								<li class="nav-row"><a href="<?php echo base_url().'last-visited'; ?>">Last Visited Gigs</a></li>
							</ul>
						</li>
						<li class="<?php if($module == 'message') echo 'active'; ?>">
							<div class="mobile-menu-item clearfix">
								<a href="<?php echo base_url().'message'; ?>">
									Messages
								</a>
							</div>
						</li>
						<li class="<?php if($module == 'notification') echo 'active'; ?>">
							<div class="mobile-menu-item clearfix">
								<a href="<?php echo base_url().'notification'; ?>">
									Alerts
								</a>
							</div>                                
						</li>
						<li class="<?php if($module == 'password' || $module == 'profile' ) echo 'active'; ?>" >
							<div class="mobile-menu-item clearfix">
								<a href="<?php echo base_url().'password'; ?>">
									Settings
									<i class="fa fa-chevron-down menu-toggle"></i>
								</a>
							</div>
							 <ul class="mobile-submenu-wrapper">
								<li class="nav-row"><a href="<?php echo base_url().'password'; ?>">Account Settings</a></li>
								<li class="nav-row"><a href="<?php echo base_url().'profile'; ?>">Profile Settings</a></li>
								<li class="nav-row"><a href="<?php echo base_url().'payment-settings'; ?>">Payment Settings</a></li>
							</ul>
						</li>
						<li class="<?php if($module == 'purchases' || $module == 'my_gigs' || $module == 'sales' || $module == 'wallets' || $module == 'user_profile' ) echo 'active'; ?>" >
							<div class="mobile-menu-item clearfix">
								<a href="<?php echo base_url().'user-profile/'.$header_username; ?>">
									<img class="mobile-user-img" src="<?php echo $header_user_image ; ?>" alt="<?php echo $header_user_fullname ; ?>" title="<?php echo $header_user_fullname ; ?>" width="50" height="50"> Profile
									<i class="fa fa-chevron-down menu-toggle"></i>
								</a>
							</div>
						<?php if($this->session->userdata('SESSION_USER_ID')) { ?>                                
							   <ul class="mobile-submenu-wrapper">
								<li class="nav-row"><a href="<?php echo base_url().'purchases'; ?>">My Purchases</a></li>
								<li class="nav-row"><a href="<?php echo base_url().'my-gigs'; ?>">My Gigs</a></li>
								<li class="nav-row"><a href="<?php echo base_url().'sales'; ?>">My Sales</a></li>
								<li class="nav-row"><a href="<?php echo base_url().'user-profile/'.$header_username; ?>">My Profile</a></li>
								<li class="nav-row"><a href="<?php echo base_url().'logout'; ?>">Log Out</a></li>
							  </ul>
						<?php } ?>
						</li>
					</ul>
					</div>
					<?php } else {   ?>
					<div class="sidebar-inner slimscroll">
					<a href="#" id="close_menu"><i class="fa fa-close"></i></a>
					<ul class="mobile-menu-wrapper">
						<li class="<?php if($module == 'gigs') echo 'active'; ?>">
							<div class="mobile-menu-item clearfix">
								<a href="<?php echo base_url(); ?>">
									Welcome
								</a>
							</div>
						</li>
						<li>
							<div class="mobile-menu-item clearfix">
								 <a href="javascript:;" onclick="selected_menu('sell-service')">
									Sell Service
								</a>
							</div>
						</li>
						<li class="<?php if($module == 'buy_service') echo 'active'; ?>">
							<div class="mobile-menu-item clearfix">
								 <a href="<?php echo base_url().'buy-service'; ?>">
									Buy Service
								</a>
							</div>
						</li>
						<li>
							<div class="mobile-menu-item clearfix">
						 <a href="javascript:;" onclick="selected_menu('reminder')" >
									Reminder
								</a>
							</div>
						</li>
						<li>
							<div class="mobile-menu-item clearfix">
						 <a href="javascript:;" onclick="selected_menu('message')" >
									Messages
								</a>
							</div>
						</li>
						<li>
							<div class="mobile-menu-item clearfix">
						   <a href="javascript:;" onclick="selected_menu('notification')" >
									Alerts                                         
								</a>
							</div>                                
						</li>
						<li>
							<div class="mobile-menu-item clearfix">
							  <a href="javascript:;" onclick="selected_menu('password')" >
									Settings
									</a>
							</div>
						</li>
						<li>
							<div class="mobile-menu-item clearfix">
								<a href="#" data-toggle="modal" data-target="#login-popup">
									Log In
								</a>
							</div>
					   
						</li>
					</ul>
					</div>
					<?php } ?>
				</div>
				<nav id="mobile-navigation">
					<div class="mobile-menu-toggle clearfix">
						<div class="mobile-menu-left-side">
							<a id="mobile_btn" class="mobile_btn pull-left" href="javascript:void(0);"><i class="fa fa-bars" aria-hidden="true"></i></a>
						</div>
						<div class="mobile-menu-right-side">
							<a id="toggle_mobile_nav" class="mobile-only-view" href="javascript:void(0);"><i class="fa fa-search"></i></a>
						</div>
					</div>
				</nav>
            </div>
        </header>
		<div id="login-popup" class="modal fade custom-popup" role="dialog" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog">
				<div class="modal-content">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<div class="modal-header text-center">
						<h4 class="sign-title">Login</h4>
					</div>
					<div class="modal-body">
						<div id="register_errtext"></div>
						<form id="users_login" class="form-horizontal">
							<div class="form-group">
								<label class="col-lg-4">Email / Username:</label>
								<div class="col-lg-8">
									<input type="text" class="form-control" name="user_name" id="user_name" placeholder="Username or Email" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-4">Password    :</label>
								<div class="col-lg-8">
									<input type="password" class="form-control" placeholder="Password" name="password" id="password" required>
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-6"><a href="#" class="pull-left forgot" data-toggle="modal" data-target="#forgot-popup">Forgot password?</a></div>
								<div class="col-lg-6"><button type="submit" class="btn btn-primary logon-btn pull-right">Login</button></div>
							</div>
						</form>
					</div>
					<div class="modal-footer text-center">
						<div class="modal-footer-text">Not a member yet? <a href="" data-toggle="modal" data-target="#register-popup">Register now</a> - it’s fun and easy!</div>
					</div>
				</div>
			</div>
		</div>
        <?php if($this->session->userdata('SESSION_USER_ID')) {} else { ?>
		<div id="register-popup" class="modal fade custom-popup" role="dialog" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog">
				<div class="modal-content">
					<button type="button" id="remove_popuptop" class="close" data-dismiss="modal">&times;</button>
					<div class="modal-header text-center">
					</div>
					<div class="modal-body">
						<form id="users_register" class="form-horizontal">
							<p class="member-text">Already a member? <a href="" data-toggle="modal" data-target="#login-popup">Login</a></p>
							<span id="register_success"> </span>
							<div class="login-or">
								<hr class="hr-or">
								<span class="span-or">or</span>
							</div>
							<div class="form-group">
								<label class="col-lg-4">First Name</label>
								<div class="col-lg-8">
									<input type="text" value=""   placeholder="First Name" id="name" name='name' class="form-control alphaonly" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-4">Last Name</label>
								<div class="col-lg-8">
									<input type="text" value=""   placeholder="Last Name" id="lname" name='lname' class="form-control alphaonly" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-4">Email</label>
								<div class="col-lg-8">
									<input type="email" value=""  placeholder="Email" id="email" name='email' class="form-control" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-4">Phone</label>
								<div class="col-lg-8">
									<input type="number" value=""  placeholder="Phone" id="phone" name='phone' maxlength="12" class="form-control" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-4">Username</label>
								<div class="col-lg-8">
									 <input type="text" name="username"  minlength=5  id="username" class="form-control alphaonly" placeholder="Username" autocomplete="off" required>                                                                              
								</div>
								<div id="username_suggestion"  style="display: none;">
									<input type="hidden" name="hidden_field" >                                                                                           
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-4">Password</label>
								<div class="col-lg-8">
									<input type="password" placeholder="Password" class="form-control" id="reg_password" name="Password" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-4">Repeat Password</label>
								<div class="col-lg-8">
									<input type="password" placeholder="Repeat Password" class="form-control" id="repeatpassword" name="RepeatPassword" required>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-4">Are You</label>
								<div class="col-lg-8">
									<select name="are_you" id="are_you" class="form-control" required>
										<option value="">Select One</option> 
										<option value="Business ">Business </option> 
										<option value="Influnecer">Influnecer </option> 
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-4">Country</label>
								<div class="col-lg-8">
									<select name="country_id" id="country_id" class="form-control" required > 
										<option value="">Select Country</option>
										<?php if(!empty($country_list)) { ?>
										<?php foreach($country_list as $countries) { ?>
										<option value="<?php echo $countries['id']; ?>" ><?php echo $countries['country']; ?></option>
										<?php } ?>
										<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-4">State</label>
								<div class="col-lg-8">
									<select name="state_id" id="state_id" class="form-control" required>
										<option value="">Select State</option> 
									</select>
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-12">
									<div class="terms-text text-center">
										By signing up, I agree to <?php echo  $this->site_name; ?>  <a href="<?php echo base_url().'terms';?>" target="_blank"> Terms of conditions</a>.               
									</div>		
								</div>										
							</div>
							<div class="form-group">								
								<div class="col-lg-12 text-center"><button type="submit" class="btn btn-primary logon-btn" id="registers">Register</button></div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
           <?php } ?>
		<div id="forgot-popup" class="modal fade custom-popup" role="dialog" data-backdrop="static" data-keyboard="false">
			<div class="modal-dialog">
				<div class="modal-content">
					<button type="button" class="close" data-dismiss="modal">&times;</button>
					<div class="modal-header text-center">
						<h4 class="sign-title">Forgot password</h4>
						<span id ="forgot_password_msg"></span>
					</div>
					<div class="modal-body">
						<form id="forget_form" method="post" class="form-horizontal">
							<div class="form-group">
								<label class="col-lg-4">Email</label>
								<div class="col-lg-8">
								<input type="email" placeholder="Email" id="forget_email" name="forget_email" class="form-control">
								</div>
							</div>
							<div class="form-group">
								<div class="col-lg-6"></div>
								<div class="col-lg-6"><button type="submit" class="btn btn-primary logon-btn pull-right">Submit</button></div>
							</div>
						</form>
					</div>
					<div class="modal-footer text-center">
						<div class="modal-footer-text">Do you know your password? <a href="" data-toggle="modal" data-target="#login-popup">Login now</a> - it’s fun and easy!</div>
					</div>
				</div>
			</div>
		</div>
		<div class="content">