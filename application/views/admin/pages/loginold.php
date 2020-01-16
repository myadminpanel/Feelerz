<?php
	$query = $this->db->query("select * from system_settings WHERE status = 1");
	$result = $query->result_array();
	$this->website_name = '';
	 $fav=base_url().'assets/images/favicon.png';
	if(!empty($result))
	{
	foreach($result as $data){
	if($data['key'] == 'website_name'){
	$this->website_name = $data['value'];
	}
		if($data['key'] == 'favicon'){
			 $favicon = $data['value'];
	}
	}
	}
	if(!empty($favicon))
	{
	$fav = base_url().'uploads/logo/'.$favicon;
	}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">        
		<link rel="shortcut icon" href="<?php echo $fav ;?>">
		<title><?php echo $this->website_name.' Admin Panel'; ?></title>
        <link href="<?php echo base_url(); ?>assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/admin.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/color-settings.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/login-register.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/main.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url(); ?>assets/css/vendor.min.css" rel="stylesheet" type="text/css" />
        <!--[if lt IE 9]>
			<script src="<?php echo base_url(); ?>assets/js/html5shiv.js"></script>
			<script src="<?php echo base_url(); ?>assets/js/respond.min.js"></script>
        <![endif]-->
        <script src="<?php echo base_url(); ?>assets/js/modernizr.min.js"></script>
    </head>
    <body>
        <div class="account-pages"></div>
        <div class="clearfix"></div>

        <div class="main-container login-register  style="background:url(<?php echo base_url(); ?>/assets/images/bg.png);">
            <?php if($this->session->userdata('message')) {  ?>
                <div class="alert alert-danger text-center fade in" id="flash_succ_message"><?php echo $this->session->userdata('message');?></div>
                <?php   $this->session->unset_userdata('message'); } ?>
    <div class="d-flex justify-content-center h-100vh w-100 align-items-center">
        <div class="login-container">
            <div class="form-container">
                <div class="text-center logo-container sp-logo-class">
                    <a href="index.html">
                        <img src="<?php echo base_url(); ?>assets/images/logo.png" alt="logo" class="img-responsive">
                    </a>
                </div>
                <h4 class="text-center">Log in to your account</h4>
                <form action="" id="admin_login" class="m-t-20 material-form" method="post">
                    <div class="form-group floating-label">
                        <input type="text" class="form-control" name="username" id="username">
                        <label for="username">Username</label>
                    </div>
                    <div class="form-group floating-label">
                        <input type="password" class="form-control" name="password" id="password">
                        <label for="password">Password</label>
                        <small class="help-block"><a href="recover-password.html">Forgotten?</a></small>
                    </div>
                    <div class="form-check">
                        <div class="custom-control custom-checkbox material-checkbox">
                            <input type="checkbox" class="custom-control-input" id="rememberMe">
                            <label class="custom-control-label" for="rememberMe">Remember me</label>
                        </div>
                         <!--<p>Don't have an account? <a href="register.html" class="text-theme m-l-5">Sign Up</a></p>-->
                    </div>
                    <div class="form-group">
                        <button name="submit" type="submit" value="true" id="fap_login" class="btn btn-theme ripple btn-raised btn-block btn-submit">
                            <span>Log in</span>
                        </button>
                    </div>
                    <!--<div class="form-group mb-0">
                        <div class="text-center form-bottom">
                            <p>Don't have an account? <a href="register.html" class="text-theme m-l-5"><b>Sign Up</b></a></p>
                            <p class="text-center text-uppercase bold">or</p>
                            <div>
                                <p class="mr-2 d-inline-block">Sign in with</p>
                                <button type="button" class="btn btn-facebook btn-circle bg-transparent" title="Facebook"> <i class="fa fa-facebook" aria-hidden="true"></i></button>
                                <button type="button" class="btn btn-twitter btn-circle bg-transparent" title="Twitter"> <i class="fa fa-twitter" aria-hidden="true"></i> </button>
                                <button type="button" class="btn btn-googleplus btn-circle bg-transparent" title="Google Plus"> <i class="fa fa-google-plus" aria-hidden="true"></i> </button>
                            </div>
                        </div>
                    </div>-->
                </form>
            </div>
        </div>
    </div>
</div>
       <!--  <div class="wrapper-page">
        	<div class=" card-box">
            <div class="panel-heading"> 
                <h3 class="text-center"><strong class="text-custom">LOGIN</strong></h3>
            </div> 
            <div class="panel-body">
				<?php if($this->session->userdata('message')) {  ?>
				<div class="alert alert-danger text-center fade in" id="flash_succ_message"><?php echo $this->session->userdata('message');?></div>
				<?php   $this->session->unset_userdata('message'); } ?>
            <div id="fap_info"></div>
            <form action="" id="admin_login" class="m-t-20" method="post" >
                <div class="form-group">
				    <label>Username</label>
                        <input type="text" class="form-control" name="username" id="username">
                </div>
                <div class="form-group">
				    <label>Password</label>
                        <input type="password" class="form-control" name="password" id="password">
                </div>
                <span id="login_error_msg" class="error_msg"></span>
                <div class="form-group text-center m-t-40">
					<button class="btn btn-primary btn-block text-uppercase" name="submit" type="submit" value="true" id="fap_login">Log In</button>
                </div>
            </form>
            </div>   
            </div>
        </div> -->
        <script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script>
		<script src="<?php echo base_url(); ?>assets/js/bootstrapValidator.min.js"></script>
        <script src="js/vendor.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/main.js"></script>
<script src="<?php echo base_url(); ?>assets/js/settings.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/charts.js"></script>
        <script>
            var BASE_URL = "<?php echo base_url(); ?>";
            var login_error = "<?php echo $this->session->flashdata('login_error'); ?>";
			     $('#admin_login').bootstrapValidator({  
        fields: {        
        	username:   {
                validators:          {
                notEmpty:              {
                        message: 'Please enter your Username'
                                       }
                                     }
                                    },
                password:           {
                validators:           {
                notEmpty:               {
                        message: 'Please enter your Password'
                                        }
                                      }
                                    }           
		}
        }).on('success.form.bv', function(e) {
          
        var username = $('#username').val();
           var password = $('#password').val();
    $.ajax({
           type:'POST',
           url: BASE_URL+'admin/dashboard/is_valid_login',
           data : {username:username,password:password},
           success:function(response)
           {     
         if(response==1)
         {
             window.location = BASE_URL+'admin';
         }
         else if (response==2)
         {
				location.reload();
         }
           }                
            });
        });  // admin login success function completes here  
        </script>
	</body>
</html>