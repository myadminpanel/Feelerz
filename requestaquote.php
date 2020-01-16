<?php session_start();

    include('admin_digi/connection.php');
?>


<!DOCTYPE html>

<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
     
   <meta name=viewport content="width=device-width, initial-scale=1, user-scalable=no">
    <?php 

              $meta_tag="SELECT * FROM `meta_keywords` WHERE page_name='Requestaquote'";
              $meta=mysqli_query($conn,$meta_tag);
               $meta_des=mysqli_fetch_array($meta)
          
             ?>
      <meta name="description" content="<?php echo $meta_des['meta_description'];?>">
      <meta name="keyword" content="<?php echo $meta_des['meta_keywords'];?>">

       <title><?php echo $meta_des['title'];?></title>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>
<script src='https://www.google.com/recaptcha/api.js'></script>
<link rel="stylesheet" type="text/css" href="cssc5fd.css?f=css/reset.css,css/header.css,css/footer.css,css/common.css,css/jquery.datetimepicker.css,css/responsive/r-common.css&amp;sid=0" />
  
        <link href="css/bootstrap.css" rel="stylesheet">
         <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- Loading Template CSS -->
        <link href="css/style.css" rel="stylesheet">
        <link href="css/rfq.css" rel="stylesheet" type="text/css"/>
        <link rel="canonical" href="requestaquote.html" />
        <link href="img1/favicon.png" rel="shortcut icon">
          <?php 

                $google_ana="SELECT * FROM google_analytics_code WHERE gogl_page_name='Requestaquote'";
                $goo=mysqli_query($conn,$google_ana);
                $google=mysqli_fetch_array($goo);

                echo $google["g_code"];
              ?>
    </head>

    <body>
      
            <!-- Start Header -->
      <?php include('include/header.php');?>
        
       <!--  End Header -->

            <div class="banner">
                    <div class="banner-txt">
                        <h2>Let's Build Something Great Together</h2>
                        <p>Send us your query and you will hear from one of experts soon </p>
                    </div>
			</div>
            <div class="content-rfq">

                <div class="main-content">
                   
                    <div class="main-conatiner"> 
                        <div class="grid">
						<div class="white-wrap">
                          <div class="form-wrapper">
                            <div class="clearfix"><span class="mendtry">*Required</span></div>     
                             <?php if(@$_GET["save"]) { ?>
                               <div class="row">
                               <div class="col-md-12">
                               <div class="alert alert-success alert-dismissible">
                                <a href="requestaquote.php" class="close" style="right:0;">&times;</a>
                                <strong> Save Successfully! </strong>
                                    </div>
                               </div>
                               </div>

                                  <?php
                                }
                         ?> 

                                <?php if(@$_GET["data-not-submitted"]) { ?>
                               <div class="row">
                               <div class="col-md-12">
                               <div class="alert alert-danger alert-dismissible">
                                <a href="requestaquote.php" class="close">&times;</a>
                                <strong> Data Not Submit Please Fill his form Again! </strong>
                                    </div>
                               </div>
                               </div>

                                  <?php
                                }
                         ?>

                                <?php if(@$_GET["empty_captcha"]) { ?>
                               <div class="row">
                               <div class="col-md-12">
                               <div class="alert alert-danger alert-dismissible">
                                <a href="requestaquote.php" class="close">&times;</a>
                                <strong> Please click on the reCAPTCHA box. </strong>
                                    </div>
                               </div>
                               </div>

                                  <?php
                                }
                         ?>                           
            <form class="form"  action="save-register.php" method="POST" enctype="multipart/form-data"> 
                                    
           <div class="form-group">                     
                <input placeholder="Your Name*" type="text" name="name" id="name"  size="25" title="Please enter your name"  value="" class="fieldset">
                </fieldset>
                <fieldset id="emailSet"> 
                    <input  placeholder="Your Email*" type="text" name="your_email" id="your_email" size="25"  class="fieldset" value="" required="">
                </fieldset>
              <fieldset id="messageSet" class="has-value" style="  padding: 0px; height: 165px; ">                      
                    <textarea placeholder="Explain Your Project in a Few Sentences*" name="explain_project" id="message" title="Please enter your message" class="fieldset" required=""></textarea>
                </fieldset>                         
                

                <!--<div class="recommended">
                    <div class="triger ">Optional, But Recommended <span class="expend">(Click to expand)</span> </div>
                </div>-->
                <div class="recommended-data ">
                    <ul class="double-cell">
                        <li>
                   <fieldset class="" style="padding: 0px;height: 62px; ">
                        <input placeholder="Phone Number" type="number" name="phone_no" id="phone" size="25" class="fieldset" value="" style="height: 60px;">
                </fieldset>
                        </li>
                        <li>
                            <fieldset>
                                <input placeholder="Skype ID" type="text" name="skype_id" id="Skype_ID" size="25" class="fieldset" value="">
                            </fieldset>
                        </li>
                        <li>
                            <fieldset>
                                <input placeholder="Website (if Any)" name="website_if_any" type="text" class="fieldset"  value="" />
                            </fieldset>
                        </li>
                        <li>
                            <fieldset class="">
                                <select class="fieldset" name="request_quote_as"> 
                                    <option value="">Requesting Quote as</option>                                               
                                    <option value="Company Representative"  >Company Representative</option>
                                    <option value="Individual"  >Individual</option>
                                </select>
                            </fieldset>
                        </li>
                        <li class="full-width">
                            <fieldset>
                                <input placeholder="What are your deadlines?" type="text" class="fieldset" name="deadline" id="deadline"  size="25" title="What are your deadlines?" value="" >
                            </fieldset>
                        </li>
                        <li class="full-width">
                            <fieldset>
                                <input placeholder="Who is your target audience?" type="text" class="fieldset" name="target_audience" id="target_audience"  size="25" title="Who is your target audience?"  value="" >
                            </fieldset>
                        </li>
                    </ul>
                    <div class="clear"></div>
                    <h3>Service(s) you are interested in:</h3>
                    <div class="interested-listing">
                        <ul class="service-list">
                            <li><label class="checkbox-lbl">
                                <input type="checkbox" name="interested_in[]" value="Website/UI Design & Redesign"  />
                                Website/UI Design & Redesign </label></li>
                            <li><label class="checkbox-lbl">
                                <input type="checkbox" name="interested_in[]" value="Custom Web/CMS Development"   />
                                Custom Web/CMS Development</label></li>
                            <li><label class="checkbox-lbl">
                                <input type="checkbox" name="interested_in[]" value="Mobile Applications"  />
                                Mobile Applications </label></li>
                            <li><label class="checkbox-lbl">
                                <input type="checkbox" name="interested_in[]" value="eCommerce Solutions"  />
                                eCommerce Solutions</label></li> 
                            <li><label class="checkbox-lbl">
                                <input type="checkbox" name="interested_in[]" value="Internet Marketing"   />
                                Internet Marketing </label></li>                                      
                            <li><label class="checkbox-lbl">
                                <input type="checkbox" name="interested_in[]" value="Hiring Dedicated Resource/Team"   />
                                Hiring Dedicated Resource/Team </label></li>  
                            <li><label class="checkbox-lbl">
                                <input type="checkbox" name="interested_in[]" value="Online Reputation Management"  />
                                Online Reputation Management </label></li> 
                            <li><label class="checkbox-lbl">
                                <input type="checkbox" name="interested_in[]" value="Content Writing"   />
                                Content Writing </label></li>
                            <li><label class="checkbox-lbl">
                                <input type="checkbox" name="interested_in[]" value="Search Engine Optimization"  />
                                Search Engine Optimization </label></li>
                            <li><label class="checkbox-lbl">
                                <input type="checkbox" name="interested_in[]" value="Partnership/Collaboration"  />
                                Partnership/Collaboration</label></li>
                            <li><label class="checkbox-lbl">
                                <input type="checkbox" name="interested_in[]" value="Online Marketplace Development"  />
                                Online Marketplace Development</label></li>
                            <li><label class="checkbox-lbl">
                                <input type="checkbox" name="interested_in[]" value="Consultancy"   />
                                Consultancy
                            </label></li>
                            <li><label class="checkbox-lbl">
                                <input type="checkbox" name="interested_in[]" value=""  />
                                Digimonk Products - Custom Requirements
                            </label></li>

                            <li><label class="checkbox-lbl">
                                <input type="checkbox" name="interested_in[]" value="Other Discussion"   />
                                Other Discussion 
                            </label></li>
                        </ul>                                    
                     </div>

                    <fieldset class="noneBorder" >
                        <h3>Add Files</h3>
                        <div class="files-wrapper">
                            <div class="morefiles">
                                <input class="browsefile" data-icon="false" type="file" name="attachment" id="attachment" />
                            </div>
                            <!--<div id="moreUploads" class="morefiles"></div>-->
                            <!--<div id="moreUploadsLink" style="display:none;"><a class="add-more" href="javascript:addFileInput('moreUploads');">Attach another File</a></div>-->
                        </div>
                    </fieldset>

                </div>
                <div class="clear"></div>                            
         
                <div class="clear"></div> 
                <div class="row">
            <center><div class="g-recaptcha" data-sitekey="6LeQKm0UAAAAAFVONASj6RBvrE4zBp1jqApuchq3"></div></center>
        </div><br> 
            <div class="button-wrap"> 
            <input type="submit" value="Submit" id="requestFormBtn" name="submit">
            <p class="note-p">Our expert will get back to you soon</p>
           </div>

               
            </form>
        </div>
	</div>

							
			
        </div><!--grid-->
        
        <div class="grid">
            <div class="about-profile">
                <h2>Why choose Digimonk?</h2>
                <ul>
                    <li><img src="img2.com/retina/industry-experience.svg" alt=""/>
                       <div class="hover-img"><img src="img2.com/retina/industry-experience-2.svg" alt=""/></div>
                    </li>
                    <li><img src="img2.com/retina/team-size.svg" alt=""/>
                        <div class="hover-img"><img src="img2.com/retina/team-size-2.svg" alt=""/></div>
                    </li>                                    
					 <li><img src="img2.com/retina/free-support.svg" alt=""/>
                        <div class="hover-img"><img src="img2.com/retina/free-support-2.svg" alt=""/></div>
                    </li>
                    <li>
					  <div class="testimonial-box">
						<div class="avtar--img"><img src="img2." class="lazy" alt="" style="display: block;"></div>
					     <p>"The team at Digimonk ensures that our website is always running at peak performance.                                 Their attention to detail and timely handing of our website issues is the reason we keep coming back to them for all of our website support needs."</p>
						 <h4>Stephen Key, InventRight</h4>
					  </div>
                    </li>
                </ul>
					  <div class="bottom-page">
					  <?php 
                            $query="SELECT * FROM manage_contact";
                            $sql=mysqli_query($conn,$query);
                            $row=mysqli_fetch_array($sql);
                        ?>									  
									<p class="contact-call">Call us at<br> 
						<span><?php echo $row['talk_to_anexpert'];?></span> 
						<span><?php echo $row['alternate_no'];?></span> 
									
					<p class="contact-call">or mail us at <a href="<?php echo $row['email_id'];?>" style="color:#1a4a72;"><?php echo $row['email_id'];?></a></p>							
									
								</div>
                            </div> 
                        </div>
                        
                    </div>
                </div>

               </div>
        
         <?php include('include/footer.php');?>
        <script src="js/ga-min.js" type="text/javascript"></script>
<script type="text/javascript" language="javascript" src="jsc277.php?f=js/jquery.min.js,js/modernizr-2.7.1-min.js,js/shortcut-min.js,js/common-inner-min-new.js&amp;sid=0"></script>

<script type="text/javascript">
var webroot='index.html';
</script>  

        <script src="js/rfq-function.js"></script>
        
        
        <script>
            $('.nav-togal').click(function () {
            	$(this).toggleClass("is-active");
            	var el = $("html");
            	if (el.hasClass('toggled-left')) el.removeClass("toggled-left");
            	else el.addClass('toggled-left');
            	return false;
            });
            $('html,.mobile--overlay,.closebtn').click(function () {
            	if ($('html').hasClass('toggled-left')) {
            		$('.nav-togal').removeClass("is-active");
            		$('html').removeClass('toggled-left');
            	}
            });
            $('.secondary-nav').click(function (e) {
            	e.stopPropagation();
            });

        </script>
        <script defer src="js/bootstrap.min.js"></script>
    </body>
</html>
