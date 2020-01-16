</div>

	<footer id="footer" class="footer">

		<div class="footer-top" >

			<div class="container">

				<div class="row">

					<?php foreach($footer_main_menu as $main_menu){

						?>	

					<div class="footer-widget">

						<h4 class="widget-title"><?php echo str_replace('_',' ', $main_menu['title']); ?></h4>

						<div class="footer-line">

							<span></span>

						</div>		

						<div class="about">

							<div class="contactdet">

								<ul>

									<?php foreach($footer_sub_menu as $sub_menu) { 

										if($main_menu['id']==$sub_menu['footer_menu'])

										{

										?>

											<li><a href="<?php echo base_url().'pages/'.$sub_menu['footer_submenu']; ?>"><?php echo str_replace('_',' ',$sub_menu['footer_submenu']); ?></a></li>

									<?php } }?>	 

								</ul>	

							</div>	

						</div>	

					</div>

					<?php } ?>

					<div class="footer-widget">

						<h4 class="widget-title text-right">FOLLOW US</h4>

						<div class="footer-line">

							<span></span>

						</div>

						<ul class="social-list">

							<?php foreach($system_setting as $settings) { 

								  if($settings['key']=='facebook' && !empty($settings['value']) ) {?>

								  <li><a target="_blank" href="<?php echo $settings['value'];  ?>"><i class="fa fa-facebook"></i></a></li>

							<?php } ?>

							<?php  if($settings['key']=='twitter' && !empty($settings['value']) ) {?>

								   <li><a target="_blank" href="<?php echo $settings['value'];  ?>"><i class="fa fa-twitter"></i></a></li>

							<?php } ?>

							<?php  if($settings['key']=='linkedIn' && !empty($settings['value']) ) {?>

									<li><a target="_blank" href="<?php echo $settings['value'];  ?>"><i class="fa fa-linkedin"></i></a></li>

							<?php } 

							if($settings['key']=='google_plus' && !empty($settings['value']) ) { ?>

									 <li><a target="_blank" href="<?php echo $settings['value'];  ?>"><i class="fa fa-google-plus"></i></a></li>

							<?php } }?>                                                                

						</ul>	

					</div>	

				</div>

			</div>

		</div>

		<div class="footer-bottom">

			<div class="container">

				<div class="row">

					<div class="col-md-12 copyright text-center">

<?php

$query=$this->db->query("select * from system_settings WHERE status = 1");

	$result=$query->result_array();

	 $website_name ='';

	if(!empty($result))

	{

		$sitename=$meta_keywords=$meta_description='';

	foreach($result as $data){

		if($data['key'] == 'website_name'){

		     $website_name = $data['value'];

	}

		if($data['key'] == 'google_analytics_code'){

		$google_analytics_code = $data['value'];

	}

	}

	}

if(!empty($google_analytics_code))

{

 echo $google_analytics_code ; 

}

?>

						<p>&copy; <?php echo date('Y'); ?> <span><a href="<?php echo base_url(); ?>"><?php echo $website_name; ?></a>.</span> All Rights Reserved.</p>

					</div>

				</div>

			</div>

		</div>

	</footer>

	<div class="to-top" id="to-top" style="bottom: 15px;"><i class="fa fa-angle-up"></i></div>

</div>

	<script type="text/javascript"> var base_url = '<?php echo base_url(); ?>';</script>

	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/modernizr.min.js"></script>

	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-2.1.4.min.js"></script>

	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap.min.js"></script> 

	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/owl.carousel.min.js"></script> 

	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrapValidator.min.js"></script>

	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.slimscroll.js"></script>

	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/select2.min.js"></script>

	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/theia-sticky-sidebar.js"></script>

	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-tokenfield.js" charset="UTF-8"></script>

	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery-ui.js"></script>

	<?php if($module=="profile") { ?>

	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/cropper.min.js"></script>

	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/cropper_main.js"></script>

	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/tokens.js"></script>	

	<?php } ?>

	<?php if($this->session->userdata('SESSION_USER_ID')) { ?>



	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/notification.js"></script>

	 <?php if($module=="message") { ?>

	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/message.js"></script>

	 <?php }?> 

	<?php if($module=="purchases" || $module=="payments" || $module=="sales" || $module=="purchase_success") { ?>

	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/purchases.js"></script> 

	<?php }?>     

	<?php }?>

	<?php if($module=="purchases") { ?>

	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/star_rating.js"></script>

	<?php }

	if($module=="gig_preview"||$module=="user_profile"||$module=="profile"||$module=="password"||$module=="payment_settings")

	 {?>

	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/rating.js"></script>  

	<?php }?>

	<?php if($module=="sell_service" || $module=="edit_gig") { ?>

	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootstrap-tagsinput.js"></script>

	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.cropit.js"></script>

	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/cropper_main_gig.js"></script>

	<script>

	$( document ).ready(function() {

	  $("#upload_image_btn").click(function(){ 

			$("#avatar-gig-modal").css('display','block');

			$("#avatar-gig-modal").modal('show');

			

		});	

	});

	</script>

	<?php }?>

	<script>

	function show_usermessage(id,frmuser)

{

    window.location = base_url+'message/'+frmuser;

    

}

	$( document ).ready(function() {

		

	  $('#stars').on('starrr:change', function(e, value){

		$('#count').html(value);

	  });

	  

	  $('#stars-existing').on('starrr:change', function(e, value){

		$('#count-existing').html(value);

		$('#rating_input').val(value);

	  });

	});

	</script>

		<script>

	function add_seller_feedbacks()

	{

			$('#feedbackmodel').modal('show');

	}

	</script>

 <!-- REQUIRED FOR FETCHING USER TIME ZONE -->

    <script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jstz-1.0.4.min.js"></script>  
    <script language="JavaScript" src="http://www.geoplugin.net/javascript.gp" type="text/javascript"></script>  

    <script type="text/javascript">

      $(document).ready(function() {

        var tz = jstz.determine();

        var timezone = tz.name();
        var ip_city = '';
    	// var ip_city = geoplugin_city();        

        $.post('<?php echo base_url(); ?>ajax',{timezone:timezone,ip_city:ip_city},function(res){

           // console.log(res);

        })      

    

      });

    </script>

	<script>setTimeout(function(){ $('.alert-dismissable').hide(); }, 2000);</script>

	<script>

	$(document).on("keydown",".numberonly",function (e) {

		// Allow: backspace, delete, tab, escape, enter and . 		 // Allow: Ctrl+A, Command+A                                            // Allow: home, end, left, right, down, up

		if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 || (e.keyCode === 65 && (e.ctrlKey === true || e.metaKey === true)) || 	(e.keyCode >= 35 && e.keyCode <= 40)) {

				 // let it happen, don't do anything

				 return;

		}

		// Ensure that it is a number and stop the keypress

		if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {

			e.preventDefault();

		}

	});

	</script>

	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/app.js"></script>

		

	<?php 

	$uri =  $this->uri->segment(1);	

		if($uri=='sell-service'){ ?>

			<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/sell_services.js"></script>

	<?php }	

		if($uri=='edit-gig'){ ?>

			<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/sell_services_update.js"></script>

	<?php }	



		if($uri=='sales' || $uri=='files'){ ?>

			<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/bootbox.min.js"></script>

			<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/file_upload.js"></script>

	<?php }	 ?>



<?php if($module=="gig_preview"){ ?>



	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/css/sweetalert2.css">

	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/sweetalert2.js"></script>

	<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

	

 <!-- Stripe Payment Start  -->



 <script type="text/javascript">

	$('#payment_formid').submit(function(){



		var option = $('input[name=group2]:checked').val(); 

		var gigs_rate = $('#gigs_rate').val();

		var converted_india_gigs_rate = $('#converted_india_gigs_rate').val();

		var gigs_actual_rate = $('#gigs_actual_rate').val();

		var gigs_id = $('#gigs_id').val();

		var gig_user_id = $('#gig_user_id').val();

		var extra_gig_row_id = $('#extra_gig_row_id').val();

		var currency_type = $('#currency_type').val();

		var hidden_super_fast_delivery = $('#hidden_super_fast_delivery').val();

		var total_delivery_days = $('#total_delivery_days').val();

		var hidden_super_fast_delivery_charges = $('#hidden_super_fast_delivery_charges').val();

		 

		if(option == 'stripe'){



			$('#gigs_rates').val(gigs_rate);

			$('#converted_india_gigs_rates').val(converted_india_gigs_rate);

			$('#gigs_actual_rates').val(gigs_actual_rate);

			$('#gigs_ids').val(gigs_id);

			$('#gig_user_ids').val(gig_user_id);

			$('#extra_gig_row_ids').val(extra_gig_row_id);

			$('#currency_types').val(currency_type);

			$('#hidden_super_fast_deliverys').val(hidden_super_fast_delivery);

			$('#total_delivery_dayss').val(total_delivery_days);

			$('#hidden_super_fast_delivery_chargess').val(hidden_super_fast_delivery_charges);

			$('#stripe_amount').val(gigs_rate);

			//$("#stripe_popup").modal('show'); // Stripe Payment Gateway					

			$("#checkout-popup").modal('hide');

			$("#my_stripe_payyment").click();	

			return false;

		}

		 

	});

	</script>



	<script type="text/javascript">

		

		$(document).on('click','#cancelInlineBtn',function(){

			$("#checkout-popup").modal('show');

		});



		$(document).on('click','#stripe_payment',function(){

			$('#locloader').show();

			setTimeout(function(){

				$('#locloader').hide();

			},1000);

		});







		Stripe.setPublishableKey(publishable_key);

		$(function() {		

			var $form = $('#payment-form');

			$form.submit(function(event) {

		// Disable the submit button to prevent repeated clicks:

		$form.find('.submit').prop('disabled', true);

		$form.find('.submit').val('Please wait...');



		// Request a token from Stripe:

		Stripe.card.createToken($form, stripeResponseHandler);

		// Prevent the form from being submitted:



		return false;

	});



		});



		function stripeResponseHandler(status, response) {

			if (response.error) {			

				swal("Warning!", response.error.message, "error");

				$('.submit').prop('disabled', false);			

			} else {					

				$('#access_token').val(response.id);



				$.ajax({

					url: '<?php echo base_url('user/buy_service/stripe_payment');?>',

					data: $('#payment-form').serialize(),			

					type: 'POST',

					dataType: 'JSON',

					success: function(response){									



						if(response.status == 200){

							swal({ 



								title: "Success!",      

								type: "success" ,

								icon: 'success',							

								text:'Please wait a moment this page will redirect you  !',							

							});

							setTimeout(function() {

								window.location.href = '<?php echo base_url();?>user/stripe_payment/send_stripe_mail/'+response.id;

							}, 1000);



							$('.submit').prop('disabled', false);

							$('.submit').val('Pay');



						}else{

							swal("Warning!", response.error, "error");

							$('.submit').prop('disabled', false);

							$('.submit').val('Pay');

						}



					},

					error: function(error){

						swal("Warning!", error, "error");

						$('.submit').prop('disabled', false);

						$('.submit').val('Pay');

					}

				});



			}

		}



		function paycancel(){

			$("#checkout-popup").modal('show');

		}



/* Stripe Payment End   */

// Returns a random integer between min and max



function getRandomInt(min, max) {

	return Math.floor(Math.random() * (max - min + 1)) + min;

}



</script>



<!-- Stripe Payment Gateway Start  -->



<script src="https://checkout.stripe.com/checkout.js"></script>

<button id="my_stripe_payyment" style="display: none;">Purchase</button>

<script>

var handler = StripeCheckout.configure({

  key: '<?php echo $publishable_key;?>',

  image: '<?php	if(!empty($logo['value'])) { echo base_url().$logo['value']; }else { echo base_url()."assets/images/logo.png";   }?>',

  locale: 'auto',

  token: function(token,args) {

    // You can access the token ID with `token.id`.

    $('#access_token').val(token.id);

    $.ajax({

		

			url: base_url+'user/stripe_payment/',

			data: $('#payment-form').serialize(),			

			type: 'POST',

			dataType: 'JSON',

			success: function(response){

				window.location.href = base_url+'user/buy_service/send_stripe_mail/'+response.payment_id;

			},

			error: function(error){

				console.log(error);

			}

		});

  }

});

$('#my_stripe_payyment').click(function(e) {

	final_gig_amount = (final_gig_amount * 100); //  dollar to cent 

	var cur = $('#currency_type').val();

	striep_currency = 'USD';

	if(cur =='$'){ striep_currency ='USD';}

	if(cur =='€'){ striep_currency ='EUR';}

	if(cur =='£'){ striep_currency ='GBP';}

  // Open Checkout with further options:

  handler.open({

    name: base_url,

    description: 'My Gigs Purchase',

    amount: final_gig_amount,

    currency:striep_currency

  });

  final_gig_amount = (final_gig_amount / 100); // cent to dollar 

  e.preventDefault();

});



// Close Checkout on page navigation:

window.addEventListener('popstate', function() {

  handler.close();

});

</script>

<!-- Stripe Payment Gateway End   -->



<?php }	 ?>

</body>

</html>