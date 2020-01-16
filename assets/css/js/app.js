	var windowHeight = $(window).height();
    var final_gig_amount = $('#gigs_rate').val();
    handleMobileMenu();

    // Mobile Menu Handler
    function handleMobileMenu() {
        var phoneMenuWrapper = $('.mobile-menu-wrapper');
        var phoneSubmenuWrapper = $('.mobile-submenu-wrapper');

        phoneMenuWrapper.css({
            display: 'block'
        });
        phoneSubmenuWrapper.css({
            display: 'none'
        });
        $('.menu-toggle').click(function() {

            $(this).parents('li').children('.mobile-submenu-wrapper').slideToggle(300);
            return false;
        });
    }
	
$('.alphaonly').keypress(function (e) {
        var regex = new RegExp("^[a-zA-Z0-9_ ]|[\b]+$");
        var str = String.fromCharCode(!e.charCode ? e.which : e.charCode);
        if (regex.test(str)) {
            return true;
        }
        else
        {
        e.preventDefault();
        //alert('Please Enter Alphabate');
        return false;
        }
    });

// script js

var owlCarouselSelector = $('.owl-carousel');
'use strict';

var imageCarousel = $('.img-carousel');
var imageCarouselSize = $('.img-carousel > .item').size();
var partnersCarousel = $('#partners');
var latestProduct = $('#latest-products');
var popularProducts = $('#popular-products');
var otherGigsCarousel = $('#othergigs-products-carousel');
var owlCarouselSelector = $('.owl-carousel');
var toTop = $('#to-top');
 

jQuery(document).ready(function () {
    // Scroll totop button
    $(window).scroll(function () {
        if ($(this).scrollTop() > 1) {
            toTop.css({bottom: '15px'});
        } else {
            toTop.css({bottom: '-100px'});
        }
    });
    toTop.click(function () {
        $('html, body').animate({scrollTop: '0px'}, 800);
        return false;
    });
    // Sliders
    if ($().owlCarousel) {
        var owl = $('.owl-carousel');
        owl.on('changed.owl.carousel', function(e) {
            // update prettyPhoto
            if ($().prettyPhoto) {
                $("a[data-gal^='prettyPhoto']").prettyPhoto({
                    theme: 'dark_square'
                });
            }
        });
        // Top products carousel  popular_gigs_count
        if (latestProduct.length) {
			var popular_gigs_count = $('#popular_gigs_count').val();
			var popular_gigs_status = false ; 			 
			if(popular_gigs_count >=4 )			
				{
					popular_gigs_status = true ;
				}
            latestProduct.owlCarousel({
                autoplay: false,
                loop: true,
                margin: 30,
                dots: false,
                nav: popular_gigs_status,
                navText: [
                    "<i class='fa fa-angle-left'></i>",
                    "<i class='fa fa-angle-right'></i>"
                ],
                responsive: {
                    0: {items: 1},
                    479: {items: 2},
                    768: {items: 3},
                    991: {items: 4},
                    1024: {items: 4},
                    1280: {items: 4}
                },
				onInitialize: function (event) {
					if ($('.owl-carousel .item').length <= 1) {
					   this.settings.loop = false;
					}
				}
            });
        }
        // other products carousel
		 
		  if (otherGigsCarousel.length) {
			var otherGigs_count = $('#hidden_other_gigs').val();
			var otherGigs_status = false ; 			 
			if(otherGigs_count >=4 )			
				{
					otherGigs_status = true ;
				}
            otherGigsCarousel.owlCarousel({
                autoplay: false,
                loop: true,
                margin: 30,
                dots: false,
                nav: otherGigs_status,
                navText: [
                    "<i class='fa fa-angle-left'></i>",
                    "<i class='fa fa-angle-right'></i>"
                ],
                responsive: {
                    0: {items: 1},
                    479: {items: 2},
                    768: {items: 3},
                    991: {items: 4},
                    1024: {items: 4},
                    1280: {items: 4}
                },
				onInitialize: function (event) {
					if ($('.owl-carousel .item').length <= 1) {
					   this.settings.loop = false;
					}
				}
            });
        }
      
	    if (popularProducts.length) {
			var latest_gigs_count = $('#latest_gigs_count').val();
			var latest_gigs_status = false ; 
			if(latest_gigs_count >=4 )			
				{
					latest_gigs_status = true ;
				}
            popularProducts.owlCarousel({
                autoplay: false,
                loop: true,
                margin: 30,
                dots: false,
                nav: latest_gigs_status ,
                navText: [
                    "<i class='fa fa-angle-left'></i>",
                    "<i class='fa fa-angle-right'></i>"
                ],
                responsive: {
                    0: {items: 1},
                    479: {items: 2},
                    768: {items: 3},
                    991: {items: 4},
                    1024: {items: 4},
					1280: {items: 4}
                },
				onInitialize: function (event) {
					if ($('.owl-carousel .item').length <= 1) {
					   this.settings.loop = false;
					}
				}
            });
        }
        // Partners carousel
        if (partnersCarousel.length) {
			var client_length = $('#clients_count').val();
			var client_status = false ; 
			if(client_length > 6 )			
				{
					client_status = true ;
				}
            partnersCarousel.owlCarousel({
                autoplay: false,
                loop: true,
                margin: 30,
                dots: false,
                nav: client_status ,
                navText: [
                    "<i class='fa fa-angle-left'></i>",
                    "<i class='fa fa-angle-right'></i>"
                ],
                responsive: {
                    0: {items: 1},
                    479: {items: 2},
                    768: {items: 3},
                    991: {items: 4},
                    1024: {items: 5},
                    1280: {items: 6}
                },
				onInitialize: function (event) {
					if ($('.owl-carousel .item').length <= 1) {
					   this.settings.loop = false;
					}
				}
            });
        }
        // Images carousel
        if (imageCarousel.length) {
            imageCarousel.owlCarousel({
                autoplay: false,
                loop: imageCarouselSize > 1 ? true : false,
                margin: 0,
                dots: true,
                nav: true,
                navText: [
                    "<i class='fa fa-angle-left'></i>",
                    "<i class='fa fa-angle-right'></i>"
                ],
                responsiveRefreshRate: 100,
                responsive: {
                    0: {items: 1},
                    479: {items: 1},
                    768: {items: 1},
                    991: {items: 1},
                    1024: {items: 1}
                },
				onInitialize: function (event) {
					if ($('.owl-carousel .item').length <= 1) {
					   this.settings.loop = false;
					}
				}
            });
        }
    }
});

var modalUniqueClass = ".modal";
$('.modal').on('show.bs.modal', function(e) {
  var $element = $(this);
  var $uniques = $(modalUniqueClass + ':visible').not($(this));
  if ($uniques.length) {
    $uniques.modal('hide');
    $uniques.one('hidden.bs.modal', function(e) {
      $element.modal('show');
    });
    return false;
  }
});

$("#create_gig_btn").click(function() {
    $('html,body').animate({
        scrollTop: $("#post_gig_area").offset().top},
        'slow');
});
	$(document).on('click', '#mobile_btn', function (e) {
		$("#main-wrapper").removeClass('open-search close-menu').toggleClass('slide-nav-toggle');
		$("body").removeClass('').toggleClass('menu-open');
		return false;
	});
	$(document).on('click', '#toggle_mobile_nav', function (e) {
		$("#main-wrapper").removeClass('slide-nav-toggle').toggleClass('open-search');
		return false;
	});
	$(document).on('click', '#close_menu', function() {
		$('#main-wrapper').toggleClass('close-menu').removeClass('slide-nav-toggle');
		$("body").removeClass('menu-open').toggleClass('');
		return false;
	});
	$(document).ready(function() {
		if($('.select').length > 0 ){
		$('.select').select2({
			templateResult: function (data, container) {
    if (data.element) {
      $(container).addClass($(data.element).attr("class"));
    }
    return data.text;
  },
			minimumResultsForSearch: -1,
			width: '100%'
		});
		}
	});
	$(document).ready(function() {
		if($('.custom-select').length > 0 ){
		$('.custom-select').select2({
			minimumResultsForSearch: -1,
			width: '100%'
		});
		}
	});
	$(document).ready(function(){
		if($('.content').length > 0 ){
			var height = $(window).height();	
			var header_height = $("#header").height();
			var footer_height = $("#footer").height();
			var setheight = height - header_height;
			var trueheight = setheight - footer_height;
			$(".content").css("min-height", trueheight);
		}
	});
	$(window).resize(function(){
		if($('.content').length > 0 ){
			var height = $(window).height();	
			var header_height = $("#header").height();
			var footer_height = $("#footer").height();
			var setheight = height - header_height;
			var trueheight = setheight - footer_height;
			$(".content").css("min-height", trueheight);
		}
	});
	$(document).ready(function(){
		if($('.slimscroll').length > 0 ){
			$('.slimscroll').slimScroll({
				height: 'auto',
				width: '100%',
				position: 'right',
				size: "7px",
				color: '#ccc',
				touchScrollStep : 50,
				wheelStep: 5
			});
			
			var h=$(window).height()-60;
			$('.slimscroll').height(h);
			$('.sidebar .slimScrollDiv').height(h);
			
			$(window).resize(function(){
				var h=$(window).height()-60;
				$('.slimscroll').height(h);
				$('.sidebar .slimScrollDiv').height(h);
			});
		}
	});

// main js

jQuery.ajaxSetup({
    'beforeSend': function(xhr) {
        xhr.setRequestHeader("Accept", "text/javascript")
    }
})

$('#avatarInput').change(function(){
   var url = $(this).val();    
   var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();    
   if ((ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) 
    {
        $('#img_upload_error').css('display','none');
   }
   else
   {
     $('#img_upload_error').css('display','block');
     $('#avatarInput').val('');
   }
 });
function register_account() {
    $('#login-popup').hide();
    $('#register-popup').modal('show');
}
function forget_click() {
    /*$("#login_form").css('display', 'none');*/
    $("#forget_form").css('display', 'block');
}
function show_clicksignin() {
    /*$("#login_form").css('display', 'block');*/
    $("#forget_form").css('display', 'none');
}
function select_username(username) {
    $('#username').val(username);
    $('#username_suggestion').css('display', 'none');
    $('#submit_button').removeAttr("disabled");
}
function selected_menu(value) {
    $('#selected_menu').val(value);
    $('#login-popup').modal('show');
}
 function usernamevalidate(e)
{
       var keyCode = e.keyCode || e.which;                                  
       if(keyCode!=9 && keyCode!=8 && keyCode!=46 )
       {                     
			  var regex = new RegExp("^[a-zA-Z\-._ ]+$");
               var key = String.fromCharCode(!e.charCode ? e.which : e.charCode);                                        
               if (!regex.test(key))
               {                                        
                       e.preventDefault();
                       return false;
               }
       }
}
 function phonevalidate(e)
{
       var keyCode = e.keyCode || e.which;                                  
       if(keyCode!=9 && keyCode!=8 && keyCode!=46 )
       {        
               var regex = new RegExp("^[0-9 ]+$");
               var key = String.fromCharCode(!e.charCode ? e.which : e.charCode);                                        
               if (!regex.test(key))
               {                                        
                       e.preventDefault();
                       return false;
               }
       }
}
 function addressvalidate(e)
{
       var keyCode = e.keyCode || e.which;                                  
       if(keyCode!=9 && keyCode!=8 && keyCode!=46 )
       {        
               var regex = new RegExp("^[a-zA-Z\-._, 0-9]+$");
               var key = String.fromCharCode(!e.charCode ? e.which : e.charCode);                                        
               if (!regex.test(key))
               {                                        
                       e.preventDefault();
                       return false;
               }
       }
}
$(document).ready(function() {
$('#name,#user_city').bind('keypress', function(event) {
                usernamevalidate(event);
                                       });
	$('#user_contact,#user_zip').bind('keypress', function(event) {
                phonevalidate(event);
                                       });
$('#profile_form').bootstrapValidator({
        // To use feedback icons, ensure that you use Bootstrap v3.1.0 or later
        fields: {
            user_name: {
                validators: {
                        stringLength: {
                        min: 3,
                    },
                        notEmpty: {
                        message: 'Please enter your user name'
                    }
                }
            },
            email: {
                validators: {
                    notEmpty: {
                        message: 'Please enter your email address'
                    },
                    emailAddress: {
                        message: 'Please enter a valid email address'
                    }
                }
            },
            user_contact: {
                validators: {
				
                        stringLength: {
                        min: 10,
                    },
                    notEmpty: {
                        message: 'Please enter your phone number'
                    },
                 
                }
            },
			   user_addr: {
                validators: {
                    notEmpty: {
                        message: 'Please enter your  address'
                    }
                }
            },
            user_city: {
                validators: {
                    
                    notEmpty: {
                        message: 'Please enter your city'
                    }
                }
            },
            user_zip: {
                validators: {
					stringLength: {
                        min: 5,
                    },
                    notEmpty: {
                        message: 'Please enter your zip code'
                    },
                   
                }
            },
		}
        })
        .on('success.form.bv', function(e) {
			   if (event.keyCode == 13) {
            event.preventDefault();
        }
            $('#success_message').slideDown({ opacity: "show" }, "slow") // Do something ...
                $('#contact_form').data('bootstrapValidator').resetForm();

            // Prevent form submission
          //  e.preventDefault();

            // Get the form instance
            var $form = $(e.target);

            // Get the BootstrapValidator instance
            var bv = $form.data('bootstrapValidator');
        });
       $( document ).on('cut copy paste',".username_validation , #password" ,function(e) {
     e.preventDefault();
        }); 
        $( document ).on('keypress',".password_validation",function(event) 
        { 
            var pattern  =  new RegExp(/^(?=.*[a-zA-Z])(?=.*\d)(?=.*[!@#$%^&*()_+])[A-Za-z\d][A-Za-z\d!@#$%^&*()_+]{8,19}$/);
            var password =  $('.password_validation').val();
            var result   =  pattern.test(password); 
            if(result)
            {
                $('.pass_val').html('');
                return true ;
            }
            else
            {
                $('.pass_val').html(' The password Must be 8 to 20 characters with a special character and number');                
            }
        });
       $( document ).on('keypress',".username_validation",function(event) { 
                    var username_length = $.trim($('.username_validation').val());
                    var keyCode = event.keyCode || event.which;                  
                    if(username_length.length<50)  
                    {                                                    
                            if(keyCode!=9)
                            {                   
                                var regex = new RegExp("^[-0-9a-zA-Z_@., \b]+$");
                                var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);                   
                                if (!regex.test(key)) 
                                {                    
                                    event.preventDefault();
                                    return false;
                                }
                            }
                    }  
                    else
                    {
                        if(keyCode!=9)
                            {                   
                                var regex = new RegExp("^[ \b]+$");
                                var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);                   
                                if (!regex.test(key)) 
                                {                    
                                    event.preventDefault();
                                    return false;
                                }
                            }
                    }      
             });

        $( document ).on('keypress',".tag_input_validation",function(event) { 
                    var username_length = $.trim($('.tag_input_validation').val());
                    var keyCode = event.keyCode || event.which;                  
                    if(username_length.length<12)  
                    {                                                    
                            if(keyCode!=9)
                            {                   
                                var regex = new RegExp("^[0-9a-zA-Z, \b]+$");
                                var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);                   
                                if (!regex.test(key)) 
                                {                    
                                    event.preventDefault();
                                    return false;
                                }
                            }
                    }  
                    else
                    {
                        if(keyCode!=9)
                            {                   
                                var regex = new RegExp("^[ \b]+$");
                                var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);                   
                                if (!regex.test(key)) 
                                {                    
                                    event.preventDefault();
                                    return false;
                                }
                            }
                    }      
             });

    $('#common_search').bind('keypress', function(event) {     
        var keyCode = event.keyCode || event.which;                
                    if(keyCode!=9)
                    {                   
                        var regex = new RegExp("^[0-9a-zA-Z \b]+$");
                        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);                   
                        if (!regex.test(key)) 
                        {                    
                            event.preventDefault();
                            return false;
                        }
                    }
        var common_selected_category = $('#selected_category').val();
        var submit_url = base_url + 'gig-preview';
        var url = base_url + 'gigs/common_search/' + common_selected_category;
        $("#common_search").autocomplete({
            source: url,
            select: function(event, ui) {
                var selected_value = String(ui.item.label);
                if (selected_value != "No Results Found") {
                    var $form = $(document.createElement('form')).css({
                        display: 'none'
                    }).attr("method", "POST").attr("action", submit_url);
                    var $input = $(document.createElement('input')).attr('name', 'selected_category').val(selected_value);
                    $form.append($input); 
                    $("body").append($form);
                    $form.submit();
                }
            }
        });
    });
   
    $('.search_form').submit(function(e) {
        var common_search_value = $.trim($('#common_search').val());
        var category_value = $.trim($('.selected_category').val());
        var country = $('.selected_category').val();
        var state = $('.selected_category').val();
        if (common_search_value == '' && category_value == '' && country == '' && state == '') {
            e.preventDefault(e);
        }
    });

    $(".register_success").fadeTo(5000, 500).slideUp(500, function() {
        $(".register_success").slideUp(500);
    });
    $('#password_form').bootstrapValidator({       
        fields: {
            current_password: {
                validators: {
						notEmpty: {
					message: 'Please enter your old password'
				                   },
                    remote: {
                        url: base_url + 'check_password',
                        data: function(validator) {
                            return {
                                current_password: validator.getFieldElements('current_password').val() // input name - return value to php 
                            };
                        },
                        message: 'The Password is not correct',
                        type: 'POST'
                    }
                }
            },
            new_password: {

                validators: {
									regexp:
       {
                         regexp: '^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[$@!%?&]).{8,12}$',
                            message: ''
       },
                    notEmpty: {
                        message: 'Please enter your New password'
                    }
                }
            },
            repeat_password: {
                validators: {
                    notEmpty: {
                        message: 'Please Re-enter your New password'
                    },
                    identical: {
                        field: 'new_password',
                        message: 'The new password and its confirm are not the same'
                    }
                }
            }
        }
    });

  /*  $('#sell_service').bootstrapValidator({       
        fields: {
            gig_title: {
                validators: {
                    remote: {
                        url: base_url + 'user/dashboard/check_gig_title',
                        data: function(validator) {
                            return {
                                gig_title: validator.getFieldElements('gig_title').val() // input name - return value to php 
                            };
                        },
                        message: 'This tilte is already taken',
                        type: 'POST'
                    },
                    notEmpty: {
                        message: 'Please enter a title'
                    }
                }
            },
             addmore: {
           // selector: '.addmore',
            validators: {
                notEmpty: {
                    message: 'required'
                }
            }
            },
            delivering_time: {
                validators: {
                    notEmpty: {
                        message: 'Please enter a estimated delivery days'
                    },
                      between: {
                        min: 1,
                        max: 29,
                        message: 'Please enter a Days 1 to 29.'
                    }
                }
            },
            gig_category_id: {
                validators: {
                    notEmpty: {
                        message: 'Please select a category'
                    }
                }
            },
            gig_image: {
                validators: {
                    notEmpty: {
                        message: 'Please select atleast One Image'
                    }
                }
            },
            requirements: {
                validators: {
                    notEmpty: {
                        message: 'Please provide requirement details about the gig'
                    }
                }
            },
            terms_conditions: {
                validators: {
                    notEmpty: {
                        message: 'Please accept Terms & Conditions'
                    }
                }
            },
            work_option: {
                validators: {
                    notEmpty: {
                        message: 'Please select any option'
                    }
                }
            },
            super_fast_delivery_date: {
                validators: {
                    notEmpty: {
                        message: 'Please select the days'
                    }
                }
            },
            gig_price: {
                validators: {
                    notEmpty: {
                        message: 'Please enter the price for gig'
                    }
                }
            },
            'extra_gigs_amount[]': {
                validators: {
                    notEmpty: {
                        message: 'Please enter the price for extra gig'
                    }
                }
            },
            super_fast_charges: {
                validators: {
                    notEmpty: {
                        message: 'Please enter the price for super fast delivery'
                    }
                }
            }
        }
    });
*/
    /*
$('#update_gig').bootstrapValidator({    
        fields: {
            gig_title: {
                validators: {
                    remote: {
                        url: base_url + 'user/dashboard/check_gig_title',
                        data: function(validator) {
                            return {
                                gig_title: validator.getFieldElements('gig_title').val(), 
                                gig_id: validator.getFieldElements('gig_id').val()
                            };
                        },
                        message: 'This tilte is already taken',
                        type: 'POST'
                    },
                    notEmpty: {
                        message: 'Please enter a title'
                    }
                }
            },
            delivering_time: {
                validators: {
                      between: {
                        min: 0,
                        max: 29,
                        message: 'Please enter a Days 1 to 29.'
                    },
                    notEmpty: {
                        message: 'Please enter a estimated delivery days'
                    }
                }
            },
            gig_category_id: {
                validators: {
                    notEmpty: {
                        message: 'Please select a category'
                    }
                }
            },
            gig_details: {
                validators: {
                    notEmpty: {
                        message: 'Please provide more details about the gig'
                    }
                }
            },
            super_fast_delivery_date: {
                validators: {
                    notEmpty: {
                        message: 'Please select a days'
                    }
                }
            },
            requirements: {
                validators: {
                    notEmpty: {
                        message: 'Please provide requirement details about the gig'
                    }
                }
            },
            terms_conditions: {
                validators: {
                    notEmpty: {
                        message: 'Please accept terms & conditions'
                    }
                }
            },
            work_option: {
                validators: {
                    notEmpty: {
                        message: 'Please select any option'
                    }
                }
            },
            gig_price: {
                validators: {
                    notEmpty: {
                        message: 'Please enter the price for gig'
                    }
                }
            }
        }
    });
    */

    $('.button_close').click(function() {
        $('#register-popup').modal('hide');
        $('#login-popup').modal('hide');
        $('#forget_form').modal('hide');
        $('#users_login input[type="text"],input[type="password"]').val('');
        $('#users_register input[type="text"]').val('');
        $('#users_forget input[type="email"]').val('');
    });
    $('#forget_form').bootstrapValidator({   
        fields: {
            forget_email: {
                validators: {
                    remote: {
                        url: base_url + 'user/dashboard/check_registered_email',
                        data: function(validator) {
                            return {
                                forget_email: validator.getFieldElements('forget_email').val() 
                            };
                        },
                       message: 'Please enter a valid Email address ',
                        type: 'POST'
                    },
                    notEmpty: {
                        message: 'Please enter Email address'
                    }
                }
            }
        }
    }).on('success.form.bv', function(e) {
        $('#success_message').slideDown({
                opacity: "show"
            }, "slow") // Do something ...
        $('#users_login').data('bootstrapValidator').resetForm();
        $('#register_errtext').html('');
        var forget_email = $('#forget_email').val();
        var url = base_url + 'user/dashboard/forgot_password';
        $.ajax({
            type: 'POST',
            url: url,
            data: {
                forget_email: forget_email
            },
            success: function(response) {
                if (response == 1) {
                    $('#forgot_password_msg').html('<div class="account-error success">We have sent you mail with password reset link</div>');
                    window.setTimeout(function() {
                        window.location.href = base_url;
                    }, 5000);
                } else if (response == 2) {
                    $('#register_errtext').html('<div class="account-error">Your Username / Password Does not match</div>');
                }
            }
        });
        e.preventDefault();
    });
    $('#users_register').bootstrapValidator({           
        fields: {
			name:{
				 validators: {
                    notEmpty: {
                        message: 'Please enter your  name'
                    }
				 }
			},
				username:{
				 validators: {
					  remote: {
                        url: base_url + 'user/dashboard/check_username',
                        data: function(validator) {
                            return {
                                username: validator.getFieldElements('username').val() 
                            };
                        },
                        message: 'The username is already exists',
                        type: 'POST'
                    },
                    notEmpty: {
                        message: 'Please enter your  username'
                    }
				 }
			},
            email: {
                validators: {
                    remote: {
                        url: base_url + 'user/dashboard/check_available_email',
                        data: function(validator) {
                            return {
                                forget_email: validator.getFieldElements('email').val() 
                            };
                        },
                        message: 'The Email is already exists',
                        type: 'POST'
                    },
					 notEmpty: {
                        message: 'Please enter your  email'
                    },
					 regexp: {
                            regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
                            message: 'Please enter the valid email address'
                        }
                }
            },
            Password: {
                validators: {
                    notEmpty: {
                        message: 'Please enter your new password'
                    },
					regexp: {
                             regexp: '^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,20}$',
                            message: ''
                        },
					
                    identical: {
                        field: 'Password',
                        message: 'The password and its confirm are not the same'
					} 
                }
            },
            RepeatPassword: {
                validators: {
                    notEmpty: {
                        message: 'Please re-enter your  password'
                    },
                    identical: {
                        field: 'Password',
                        message: 'The password and its confirm are not the same'
                    }
                }
            },
            country_id: {
                validators: {
                    notEmpty: {
                        message: 'Please select a country '
                    }
                }
            },
            state_id: {
                validators: {
                    notEmpty: {
                        message: 'Please select a state '
                    }
                }
            }
        }
    }).on('success.form.bv', function(e) {
        $('#success_message').slideDown({
                opacity: "show"
            }, "slow") // Do something ...
        $('#users_register').data('bootstrapValidator').resetForm();
        $('#register_errtext').html('');
        var username = $('#username').val();
        var password = $('#repeatpassword').val();
        var email = $('#email').val();
        var name = $('#name').val();
        var country_id = $('#country_id').val();
        var state_id = $('#state_id').val();
        $.ajax({
            type: 'POST',
            url: base_url + 'user/dashboard/users_registeration',
            data: {
                username: username,
                password: password,
                email: email,
                name: name,
                country_id: country_id,
                state_id: state_id
            },
            success: function(response) {
                if (response == 1) {                    
                    $('#register_success').html('<div class="account-error success">Thanks ! Activation Mail Has been sent to Registered Mail Id</div>');
                    window.setTimeout(function() {
                        window.location.href = base_url;
                    }, 5000);
                } else if (response == 2) {
                    $('#register_success').html('<div class="account-error">Something Went Wrong</div>');

                }
            }
        });
    });
    $('#users_login').bootstrapValidator({    
        fields: {
            user_name: {
                validators: {
                    notEmpty: {
                        message: 'Please enter username or email'
                    }
                }
            },
            password: {
                validators: {
                    notEmpty: {
                        message: 'Please enter password'
                    }
                }
            },

        }
    }).on('success.form.bv', function(e) {
        $('#success_message').slideDown({
                opacity: "show"
            }, "slow") // Do something ...
        $('#users_login').data('bootstrapValidator').resetForm();
        $('#register_errtext').html('');
        var username = $('#user_name').val();
        var password = $('#password').val();
        var selected_menu = $('#selected_menu').val();
        $.ajax({
            type: 'POST',
            url: base_url + 'user/dashboard/is_valid_login',
            data: {
                username: username,
                password: password
            },
            success: function(response) {
                if (response == 1) {
                    if (selected_menu != '') {
                        window.location.href = base_url + selected_menu;                        
                    } else {
                        location.reload();
                    }
                } else if (response == 0) {
                    $('#register_errtext').html('<div class="account-error">Login failed wrong user credentials</div>');
						$('#users_login').bootstrapValidator('resetForm', true);
                } else if (response == 2) {
                    $('#register_errtext').html('<div class="account-error success m-t-0">Activation Link has been sent to your MailID.</div>');
                }
            }
        });
    });

    if ($('#gig_title').length != 0) {
        updateGigTitleCharsCount();
        $('#gig_title').keyup(function() {
            updateGigTitleCharsCount();
        });
    };
    if ($('#gig_description').length != 0) {
        updateGigDescCharsCount();
        $('#gig_description').keyup(function() {
            updateGigDescCharsCount();
        });
    };
    $('input[maxlength],textarea[maxlength]').keyup(function() {
        var max = parseInt($(this).attr('maxlength'));
        if ($(this).val().length > max) {
            $(this).val($(this).val().substr(0, $(this).attr('maxlength')));
        };
    });

    $("#user_username").keyup(function() {
        checkUsername();
    });

});

function updateGigTitleCharsCount() {
    var used = $('#gig_title').val().length;
    $('.gigtitleused').html(used);
};

function updateGigDescCharsCount() {
    var used = $('#gig_description').val().length;
    $('.gigdescused').html(used);
};

function unselectCheckboxes() {
    $('.checkbox').each(function() {
        $(this).attr('checked', false);
    });
};

function reset_html(id) {
    $('#' + id).html($('#' + id).html());
}

(function($) {
    var url1 = /(^|&lt;|\s)(www\..+?\..+?)(\s|&gt;|$)/g,
        url2 = /(^|&lt;|\s)(((https?|ftp):\/\/|mailto:).+?)(\s|&gt;|$)/g,
        linkifyThis = function() {
            var childNodes = this.childNodes,
                i = childNodes.length;
            while (i--) {
                var n = childNodes[i];
                if (n.nodeType == 3) {
                    var html = $.trim(n.nodeValue);
                    if (html) {
                        html = html.replace(/&/g, '&amp;')
                            .replace(/</g, '&lt;')
                            .replace(/>/g, '&gt;')
                            .replace(url1, '$1<a href="http://$2" target="_blank">$2</a>$3')
                            .replace(url2, '$1<a href="$2" target="_blank">$2</a>$5');
                        $(n).after(html).remove();
                    }
                } else if (n.nodeType == 1 && !/^(a|button|textarea)$/i.test(n.tagName)) {
                    linkifyThis.call(n);
                }
            }
        };
    $.fn.linkify = function() {
        return this.each(linkifyThis);
    };
})(jQuery);

function getgigs(category) {
    $("#gigsloader").show();
    $.post(base_url+"upload/getgigs.php", {
            c: category
        },
        function(data) {

            $("#gigsloader").hide();
            if (data.result == "success") {
                $("ul#gigsservice li").remove();
                $("#gigsservice").append(data.success);
            } else {
                $("#gigserror").show();               
                return false;
            }
        },
        "json");
}

    function validatetitle(gig_title) {
        if (gig_title.val() == "") {
            gig_title.addClass("error");
            return false;
        } else {
            gig_title.removeClass("error");
            return true;
        }
    }

    function validateprc(gig_prc) {
        if (gig_prc.val() == "") {
            gig_prc.addClass("error");
            return false;
        } else {
            gig_prc.removeClass("error");
            return true;
        }
    }

    function validatedur(gig_duration) {
        if (gig_duration.val() == "") {
            gig_duration.addClass("error");
            return false;
        } else {
            gig_duration.removeClass("error");
            return true;
        }
    }

    function validatecur(gcurrency) {
        if (gcurrency.is(':checked')) {
            $("#curlist").append("");
            return true;
        } else {
            $("#curlist").append("&nbsp;&nbsp;<span style='color:red;'>Currency field is required</span>");
            return false;
        }

    }

    function validatecat(gig_category_id) {
        if (gig_category_id.val() == 0) {
            $("#catlist .select .value").addClass("error");
            return false;
        } else {
            $("#catlist .select .value").removeClass("error");
            return true;
        }
    }

    function validatetag(gig_tag_list) {
        if (gig_tag_list.val() == "") {
            gig_tag_list.addClass("error");
            return false;
        } else {
            gig_tag_list.removeClass("error");
            return true;
        }
    }

    function validatedesc(gig_description) {
        if (gig_description.val() == "") {
            gig_description.addClass("error");
            return false;
        } else {
            gig_description.removeClass("error");
            return true;
        }
    }

    function validatereq(gig_requirement) {
        if (gig_requirement.val() == "") {
            gig_requirement.addClass("error");
            return false;
        } else {
            gig_requirement.removeClass("error");
            return true;
        }
    }
//});

//gig view page scroll
$(document).ready(function() {
    $('.rightsidebar')
        .theiaStickySidebar({
            additionalMarginTop: 0
        });
});

function checkPassword(str)
{
    var re = /^(?=.*\d)(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
    return re.test(str);
}
var password_checker = function(obj){ 
		if($('#password_error').length == 0) $('<div class="pwd-hint" id="pwd-hint"><ul id="password_error"><li class="psw_head">Your password must</li></ul></div> ').insertAfter(obj);		
		var passwdVal = obj.val();
		var passwdFlag = true;
		
		$('#lengthErr').remove();
		$('#lowerErr').remove();
		$('#digitErr').remove();
		$('#upperErr').remove();
		$('#specialErr').remove();					 
	  	if (passwdVal.length < 8){  
			$('#password_error').append('<li id="lengthErr" class="psw_points">Be at least 8 characters</li>');	
			passwdFlag = false;
		}			
		if(!/[a-z]/.test(passwdVal)){ 
			$('#password_error').append('<li id="lowerErr" class="psw_points">Include a lowercase letter</li>');
			passwdFlag = false;
		}
		if(!/\d/.test(passwdVal)) {
			$('#password_error').append('<li id="digitErr" class="psw_points">Include a number</li>');
			passwdFlag = false;
		} 
		if(!/[A-Z]/.test(passwdVal)){
			$('#password_error').append('<li id="upperErr" class="psw_points">Include an uppercase letter</li>');
			passwdFlag = false;
		}
		if(!/[!@#$%^&*]/.test(passwdVal)){
			$('#password_error').append('<li id="specialErr" class="psw_points">Include a special character</li>');
			passwdFlag = false;
		}
		if(passwdFlag == false) { 
		$('#pwd-hint').show();
		$( "#registers" ).addClass( "disabled" );
		}
		if(passwdFlag == true)	{
			$('#pwd-hint').remove(); 
			  $( "#registers" ).removeClass( "disabled" );
			}	
	}
$( document ).ready(function() {	
	
	$("#reg_password,#new_password").keyup(function() { 	 
		password_checker($(this));
	});
	
})

// common js 

$('#gig_title').bind('keypress', function(event) {
    var regex = new RegExp("^[a-zA-Z0-9 \b]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key)) {
        event.preventDefault();
        return false;
    }
});
function parseVideoURL(url) {
    function getParm(url, base) {
        var re = new RegExp("(\\?|&)" + base + "\\=([^&]*)(&|$)");
        var matches = url.match(re);
        if (matches) {
            return (matches[2]);
        } else {
            return ("");
        }
    }
    var retVal = {};
    var matches;
    if (url.indexOf("youtube.com/watch") != -1) {
        retVal.provider = "youtube";
        retVal.id = getParm(url, "v");
    } else if (matches = url.match(/vimeo.com\/(\d+)/)) {
        retVal.provider = "vimeo";
        retVal.id = matches[1];
    }
    return (retVal);
} 
function category_search(search_value) {
    window.location.href = base_url + "search/category?search_value=" + search_value;
}
function tag_search(search_value) {
    window.location.href = base_url + "search/?search_value=" + search_value;
}
function check_extra_gigs() {
	  $("#locloader").css("display", "block");
    var checkedValues = $("li input[type=checkbox]:checked").map(function() {
        return this.id;
    }).get();
    var arr = checkedValues.toString().split(',');
    var temp = new Array();
    temp = arr;
    var extra_gigs_details = [];
    var iteration = 0;
    var gig_id = $('#gigs_id').val();
    var super_fast_desc = '';
    var super_fast_delivery_charges = 0;
    var super_fast_delivery = '';
    var rate_symbol = $('#rate_symbol').val();
    var super_fast_delivery_date = '';
    var total_days = 0;
    for (a in temp) {
        if (temp[a] == 'super_fast_delivery') {
            super_fast_desc = $('#super_fast_delivery_desc').html();
            super_fast_delivery_charges = $('#super_fast_delivery_charges').val();
            super_fast_delivery = 'yes';
            super_fast_delivery_date = $('#super_fast_delivery_date').val();
            total_days = parseInt(super_fast_delivery_date + total_days);
        } else {
            if ($.trim($('#extra_gig_desc_' + temp[a]).val()) != '' && $.trim($('#extra_gig_input_' + temp[a]).val()) != '' && $.trim($('#extra_gigs_amount_' + temp[a]).val()) != '' && $.trim($('#default_extra_gigs_delivery_' + temp[a])) != '') {
                temp[a] = parseInt(temp[a], 10);
                $('#extra_gig_desc_' + temp[a]).val();
                $('#extra_gig_input_' + temp[a]).val();
                $('#extra_gigs_amount_' + temp[a]).val();
                $('#default_extra_gigs_delivery_' + temp[a]).val();
                total_days = parseInt(total_days) + parseInt($('#default_extra_gigs_delivery_' + temp[a]).val());
                extra_gigs_details.push($('#extra_gig_desc_' + temp[a]).val() + '___' + $('#extra_gig_input_' + temp[a]).val() + '___' + $('#extra_gigs_amount_' + temp[a]).val() + '___' + $('#rate_symbol').val() + '___' + $('#default_extra_gigs_delivery_' + temp[a]).val());
            }
        }
    }
    var country_symbol = $('#rate_symbol').val();
    var currency_type = 1;
    if (country_symbol == '$') {
        currency_type = 2;
    }
    var url = base_url + 'user/dashboard/extra_gig_calculations';
    $.ajax({
        type: 'post',
        url: url,
        data: {
            extra_gigs_details: extra_gigs_details,
            gig_id: gig_id,
            currency_type: currency_type,
            super_fast_desc: super_fast_desc,
            super_fast_delivery_charges: super_fast_delivery_charges,
            super_fast_delivery: super_fast_delivery,
            rate_symbol: rate_symbol,
            super_fast_delivery_date: super_fast_delivery_date
        },
        dataType: "json",
        success: function(data) {
			 $("#locloader").css("display", "none");
            $('#extra_gig_calculation').html(data.html);
            $('#extra_gig_row_id').val(data.sub_html);
            $('#currency_type').val(data.rate_symbol);
            $('#hidden_super_fast_delivery').val(data.super_fast_delivery);
            $('#total_delivery_days').val(total_days);
            $('#hidden_super_fast_delivery_charges').val(data.super_fast_delivery_charges);
        }
    })
}
function ReverseDisplay(d) {
    if (document.getElementById(d).style.display == "none") {
        document.getElementById(d).style.display = "inline-block";
        $(".add-html").html('cancel');
    } else {
        document.getElementById(d).style.display = "none";
        $(".add-html").html('change location');
    }
}
$('.search_category').on('change', function() {
    var category_id = $.trim(this.value); // or $(this).val()
    var url = base_url + "category_search/" + category_id;
    if (category_id != '') {
        window.location.href = url;
    }
});
function inputfocusout(e){
	if($(e).val()=="" || $(e).val()=="0"){
		$(e).val('1');
	}
}



function extra_gig_days(e, status) { 
   var value = $(e).val();
	var result = 'Day';
    if(Math.floor(value) == value && $.isNumeric(value)) {
		$(e).val($(e).val());
	}else{
		if($(e).val()!=""){
			//$(e).val('1');	
		}
	}
	value = $(e).val();
	
    if (status == 1) {
        if (value == 1) {
            result = 'Day';
        } else if (value > 1) {
            result = 'Days';
        } else {
            result = '';
        }
		if(value == '')
		{
		 //$(e).val(1);
		}
        if (value > 14) {
            $(e).val(14);
        }
        $(e).parent().find(".sub_delivery_days").html(result);
    } else {
        var main_delivering_time = parseInt($('#delivering_time').val());
        var result = '';
        if (value > main_delivering_time) {
            $("#super_fast_delivery_time_error").html("The days should be less than actual delivery days");
            $(e).val(main_delivering_time);
            $(e).parent().find(".sub_delivery_days").html('Days');
        } else {
            if (value == 1) {
                result = 'Day';
            } else if (value > 1) {
                result = 'Days';
            } else {
                result = '';
            }
            $(e).parent().find(".sub_delivery_days").html(result);
            $("#super_fast_delivery_time_error").html(" ");
        }
    }
}
base_iteration = 0;

function add_extra_service() {

    var extra_gig_rate_symbol = $('#extra_gig_rate_symbol').val();
    var extra_gig_rate = $('#extra_gig_rate').val();
    var full_country_name = $('#full_country_name').val();
    var dollar_rate = $('#dollar_rate').val();
    var rupee_rate = $('#rupee_rate').val();
	var rate_symbol = '';
    var rate = '';
    if (extra_gig_rate_symbol == '$') {
        extra_gig_rate_symbol = "$";
        rate = extra_gig_rate;
    }
    if (base_iteration <= 9) {
        var row_id = $('#table_content').val(); 
		var calculated_rate = Math.round(rate * 100) / 100 ;
            if($('#payment_option').val()=='dynamic'){
                calculated_rate = '';
            }
        var div_content = $('.extra_gig_content').html();
            div_content   = div_content.replace(/#/g,row_id);     
            div_content   = div_content.replace('_0_',calculated_rate);  

        // var div_content = " <div class='clearfix extra-gig-option' id='row_id_" + row_id + "' >" +
        //     "<span class='close-offer'><i class='fa fa-times' aria-hidden='true' onclick='remove_div(" + row_id + ");' ></i></span>" +
        //     "<div class='name-block2'>" +
        //     "<span class='name-input2'>" +
        //     "<input type='text' name='extra_gigs[]' value='' class='form-control gig-name' placeholder='I can'>	" +
        //     "										</span>" +
        //     "										<span class='currency'>" +
        //     "											for <span class='currency-group'>" +
        //     extra_gig_rate_symbol + " <input type='text' class='form-control amount' name='extra_gigs_amount[]' readonly value='"+calculated_rate+"'></span> in <input type='text'   class='form-control amount2 numberonly addmore' value='1' onkeypress='return event.charCode >= 48 && event.charCode <= 57'  onkeyup='extra_gig_days(this,1)'  onfocusout='inputfocusout(this)' onmouseup='extra_gig_days(this,1)'  name='extra_gigs_delivery[]'><span class='sub_delivery_days'>Day</span>" +
        //     "										</span>" +
        //     "									</div>	" +
        //     "								</div>	 ";
        
        $('#add_extra_gig').append(div_content);
        var new_value = parseInt(row_id) + 1;
        $('#table_content').val(new_value);
        base_iteration = base_iteration + 1;
    }
    if (base_iteration === 9) {
        $('.add-more').css('display', 'none');
    }
}
 
function remove_div(id) {
    $("#row_id_" + id).remove();
    base_iteration = base_iteration - 1;
    $('.add-more').css('display', 'block');
}

var edit_gig_base_iteration = $('#table_content').val();
var edit_gig_iteration = edit_gig_base_iteration;

function remove_edit_gig_div(id) {
    $("#row_id_" + id).remove();
    edit_gig_iteration = edit_gig_iteration - 1; 
    $('.add-more').css('display', 'block');
}

function add_edit_gig_extra_service() {
    if (edit_gig_iteration <= 10) {
        edit_gig_iteration = (parseInt(edit_gig_iteration) + 1);

        var extra_gig_rate_symbol = $('#extra_gig_rate_symbol').val();
        var extra_gig_rate = $('#extra_gig_rate').val();
        var full_country_name = $('#full_country_name').val();
        var dollar_rate = $('#dollar_rate').val();
        var rupee_rate = $('#rupee_rate').val(); 

        var rate_symbol = '';
        var rate = '';

        if (extra_gig_rate_symbol == '$') {
            extra_gig_rate_symbol = "$";
            rate = extra_gig_rate;          
        }  

		var math_round_value = Math.round(rate * 100) / 100;
        var readonly = ''; // readonly
        if($('#payment_option').val()=='dynamic'){
                math_round_value = '';
                readonly = '';
            }

        var div_content = " <div class='clearfix extra-gig-option' id='row_id_" + edit_gig_iteration + "' >" +
            "<span class='close-offer'><i class='fa fa-times' aria-hidden='true' onclick='remove_edit_gig_div(" + edit_gig_iteration + ");' ></i></span>" +
            "<div class='name-block2'>" +
            "<span class='name-input2'>" +
            "<input type='text' name='extra_gigs[]' id='label_name_"+ edit_gig_iteration +"' value='' class='form-control gig-name extra_money_price' date-no='" + edit_gig_iteration + "'  placeholder='I can'>	" + "</span>" +
            "<span class='currency'>" + "for <span class='currency-group'>" +
            extra_gig_rate_symbol + " <input type='text' class='form-control amount' id='label_val_"+ edit_gig_iteration +"' name='extra_gigs_amount[]'  onfocusout='inputfocusout(this)' "+readonly+" value='" +math_round_value+ "'></span> in <input type='text'  class='form-control amount2 numberonly' onkeypress='return event.charCode >= 48 && event.charCode <= 57' value='1' onkeyup='extra_gig_days(this,1)'  onmouseup='extra_gig_days(this,1)'  name='extra_gigs_delivery[]'> <span class='sub_delivery_days'>Day</span>" +
            "										</span>" +
            "									</div>	" +
            "								</div>	 ";
        $('#add_extra_gig').append(div_content);
    }
    if (edit_gig_iteration === 10) {
        $('.add-more').css('display', 'none');
    }
}

function remove_files(filename, row_id, file_type) {
    var url = base_url + 'user/sell_service/delete_uploaded_file';
    $.ajax({
        type: 'post',
        url: url,
        dataType: 'json',
        data: {
            filename: filename,
            file_type: file_type
        },
        success: function(data) {
            if (data.html == 1) {
                if (file_type == 'image') {

                    $('#remove_image_div_' + row_id).remove();
                    var total_array = $('#image_array').val();
                    var arr = total_array.split(",");
                    var itemtoRemove = data.sub_html;
                    arr.splice($.inArray(itemtoRemove, arr), 1);
                    $("#image_array").val(arr);

                    var delete_image_total_array = $('#delete_image_array').val();
                    var arr = delete_image_total_array.split(",");
                    var itemtoRemove = data.sub_html;
                    arr.splice($.inArray(itemtoRemove, arr), 1);
                    $("#delete_image_array").val(arr);

                    var deleted_image_total_array = $('#deleted_image_array').val();
                    var arr = deleted_image_total_array.split(",");
                    var itemtoRemove = data.sub_html;
                    arr.splice($.inArray(itemtoRemove, arr), 1);
                    $("#deleted_image_array").val(arr);

                } else if (file_type == 'video') {
                    $('#remove_video_div_' + row_id).remove();
                    var total_array = $('#video_array').val();
                    var arr = total_array.split(",");
                    var itemtoRemove = data.sub_html;
                    arr.splice($.inArray(itemtoRemove, arr), 1);
                    $("#video_array").val(arr);


                    var delete_video_total_array = $('#delete_video_array').val();
                    var arr = delete_video_total_array.split(",");
                    var itemtoRemove = data.sub_html;
                    arr.splice($.inArray(itemtoRemove, arr), 1);
                    $("#delete_video_array").val(arr);

                    var deleted_video_total_array = $('#deleted_video_array').val();
                    var arr = deleted_video_total_array.split(",");
                    var itemtoRemove = data.sub_html;
                    arr.splice($.inArray(itemtoRemove, arr), 1);
                    $("#deleted_video_array").val(arr);
                }
            }
        }
    });
}
$(document).ready(function(e) {
    $('#update_gig').submit(function() {
        var ckValue = CKEDITOR.instances['gig_details'].getData();
        if ($.trim(ckValue).length === 0) {
            $("#desc_err").html('Please enter about your gig details ');
            $('.sell_service_submit').removeAttr('disabled');
            return false;
        }
        if ($('#super_fast_delivery').prop('checked') == true) {
            var super_fast_delivery_desc_length = $.trim($('#super_fast_delivery_desc').val()).length;
            var allow_super_fast = true;
            if (super_fast_delivery_desc_length < 1) {
                $("#super_fast_delivery_time_error").html("Please enter a description  ");
                allow_super_fast = false;
                $('.sell_service_submit').removeAttr('disabled');
            }
        }
        if (($('#delete_image_array').val() == '') && ($('#image_array').val() == '')) {
            $('#image_video_error_msg').html(' Please upload atleast one image ');
            $('.sell_service_submit').removeAttr('disabled');
            return false;

        }
        if ((($('#delete_image_array').val() != '') || ($('#image_array').val() != ''))) {

            if ($('#super_fast_delivery').prop('checked') == true) {
                var super_fast_delivery_desc_length = $.trim($('#super_fast_delivery_desc').val()).length;
                if (super_fast_delivery_desc_length > 0) {
                    return true;
                } else {
                    $('.sell_service_submit').removeAttr('disabled');
                    return false;
                }
            } else {
                return true;
            }
        }
    });
});

function update_gig(id, filename, row_id, file_type) {
    if (file_type == 'image') {
        var actual_array = $('#delete_image_array').val();
        var total_array = $('#delete_image_array').val();
        var arr = total_array.split(",");
        var image_name = filename.split('/', 3);
        var itemtoRemove = image_name[2];
        arr.splice($.inArray(itemtoRemove, arr), 1);
        $("#delete_image_array").val(arr)
        var result = $.trim($("#delete_image_array").val());
        var image_array_result = $.trim($('#image_array').val());

        $('#remove_image_div_' + row_id).remove();
        var v1 = $("#deleted_image_array").val();
        var image_name = filename.split('/', 3);
        if (v1.length > 0) {
            var v2 = [];
            v2.push(v1);
            v2.push(filename);
            $("#deleted_image_array").val(v2);
        } else {
            var array = [];
            array.push(filename);
            $("#deleted_image_array").val(array);
        }

    }
    if (file_type == 'video') {
        var actual_array = $('#delete_video_array').val();
        var total_array = $('#delete_video_array').val();
        var arr = total_array.split(",");
        var video_name = filename.split('/', 3);
        var itemtoRemove = video_name[2];
        arr.splice($.inArray(itemtoRemove, arr), 1);
        $("#delete_video_array").val(arr);
        var result = $.trim($("#delete_video_array").val());
        if (result != '') {
            $('#remove_video_div_' + row_id).remove();
            var v1 = $("#deleted_video_array").val();
            var image_name = filename.split('/', 3);
            if (v1.length > 0) {
                var v2 = [];
                v2.push(v1);
                v2.push(filename);
                $("#deleted_video_array").val(v2);
            } else {
                var array = [];
                array.push(filename);
                $("#deleted_video_array").val(array);
            }
        } else {
            $('#remove_video_div_' + row_id).remove();
            var array = [];
            array.push(filename);
            $("#deleted_video_array").val(array);
        }
    }
}
 
function ytVidId(url) {
    var p = /^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
    return (url.match(p)) ? RegExp.$1 : false;
}

vimeo_Reg = /https?:\/\/(?:www\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|album\/(\d+)\/video\/|)(\d+)(?:$|\/|\?)/;

function vimeo_validator(url) {
    if (url.match(vimeo_Reg)) {
        return true;
    } else {
        return false;
    }
}
function remove_third_party_link(link_type) {
    if (link_type == 'remove_youtube_div') {
        $('#remove_youtube_div').remove();
        $('#youtube_url_link').val('');
        $('#youtube_url').val('');
    }
    if (link_type == 'remove_vimeo_div') {
        $('#remove_vimeo_div').remove();
        $('#vimeo_url_link').val('');
        $('#vimeo_url').val('');
        $('#vimeo_video_id').val('');
    }
}
$(document).ready(function() {
    $('#tokenfield').tokenfield({
  autocomplete: {
    source: ["Dutch", "English", "Papiamento", "Spanish", "Balochi", "Dari", "Pashto", "Turkmenian", "Uzbek", "Ambo", "Chokwe", "Kongo", "Luchazi", "Luimbe-nganguela", "Luvale", "Mbundu", "Nyaneka-nkhumbi", "Ovimbundu", "Albaniana", "Greek", "Macedonian", "Catalan", "French", "Portuguese", "Arabic", "Hindi", "Indian-Languages", "Italian", "Armenian", "Azerbaijani", "Samoan", "Tongan", "Creole-English", "Canton-Chinese", "German", "Serbo-Croatian", "Vietnamese", "Czech", "Hungarian", "Polish", "Romanian", "Slovene", "Turkish", "Lezgian", "Russian", "Kirundi", "Swahili", "Adja", "Aizo", "Bariba", "Fon", "Ful", "Joruba", "Somba", "Busansi", "Dagara", "Dyula", "Gurma", "Mossi", "Bengali", "Chakma", "Garo", "Khasi", "Marma", "Santhali", "Tripuri", "Bulgariana", "Romani", "Creole-French", "Belorussian", "Ukrainian", "Garifuna", "Maya-Languages", "Aimar\u00e1", "Guaran\u00ed", "Ket\u0161ua", "Japanese", "Bajan", "Chinese", "Malay", "Malay-English", "Asami", "Dzongkha", "Nepali", "Khoekhoe", "Ndebele", "San", "Shona", "Tswana", "Banda", "Gbaya", "Mandjia", "Mbum", "Ngbaka", "Sara", "Eskimo-Languages", "Punjabi", "Romansh", "Araucan", "Rapa-nui", "Dong", "Hui", "Mant\u0161u", "Miao", "Mongolian", "Puyi", "Tibetan", "Tujia", "Uighur", "Yi", "Zhuang", "Akan", "Gur", "Kru", "Malinke", "[South]Mande", "Bamileke-bamum", "Duala", "Fang", "Maka", "Mandara", "Masana", "Tikar", "Boa", "Luba", "Mongo", "Ngala-and-Bangi", "Rundi", "Rwanda", "Teke", "Zande", "Mbete", "Mboshi", "Punu", "Sango", "Maori", "Arawakan", "Caribbean", "Chibcha", "Comorian", "Comorian-Arabic", "Comorian-French", "Comorian-madagassi", "Comorian-Swahili", "Crioulo", "Moravian", "Silesiana", "Slovak", "Southern-Slavic-Languages", "Afar", "Somali", "Danish", "Norwegian", "Swedish", "Berberi", "Sinaberberi", "Bilin", "Hadareb", "Saho", "Tigre", "Tigrinja", "Basque", "Galecian", "Estonian", "Finnish", "Amhara", "Gurage", "Oromo", "Sidamo", "Walaita", "Saame", "Fijian", "Faroese", "Kosrean", "Mortlock", "Pohnpei", "Trukese", "Wolea", "Yap", "Mpongwe", "Punu-sira-nzebi", "Gaeli", "Kymri", "Abhyasi", "Georgiana", "Osseetti", "Ewe", "Ga-adangme", "Kissi", "Kpelle", "Loma", "Susu", "Yalunka", "Diola", "Soninke", "Wolof", "Balante", "Mandyako", "Bubi", "Greenlandic", "Cakchiquel", "Kekch\u00ed", "Mam", "Quich\u00e9", "Chamorro", "Korean", "Philippene-Languages", "Chiu-chau", "Fukien", "Hakka", "Miskito", "Haiti-Creole", "Bali", "Banja", "Batakki", "Bugi", "Javanese", "Madura", "Minangkabau", "Sunda", "Gujarati", "Kannada", "Malayalam", "Marathi", "Orija", "Tamil", "Telugu", "Urdu", "Irish", "Bakhtyari", "Gilaki", "Kurdish", "Luri", "Mazandarani", "Persian", "Assyrian", "Icelandic", "Hebrew", "Friuli", "Sardinian", "Circassian", "Ainu", "Kazakh", "Tatar", "Gusii", "Kalenjin", "Kamba", "Kikuyu", "Luhya", "Luo", "Masai", "Meru", "Nyika", "Turkana", "Kirgiz", "Tadzhik", "Khmer", "T\u0161am", "Kiribati", "Tuvalu", "Lao", "Lao-Soung", "Mon-khmer", "Thai", "Bassa", "Gio", "Grebo", "Mano", "Mixed-Languages", "Singali", "Sotho", "Zulu", "Lithuanian", "Luxembourgish", "Latvian", "Mandarin-Chinese", "Monegasque", "Gagauzi", "Malagasy", "Dhivehi", "Mixtec", "N\u00e1huatl", "Otom\u00ed", "Yucatec", "Zapotec", "Marshallese", "Bambara", "Senufo-and-Minianka", "Songhai", "Tamashek", "Maltese", "Burmese", "Chin", "Kachin", "Karen", "Kayah", "Mon", "Rakhine", "Shan", "Bajad", "Buryat", "Dariganga", "Dorbet", "Carolinian", "Chuabo", "Lomwe", "Makua", "Marendje", "Nyanja", "Ronga", "Sena", "Tsonga", "Tswa", "Hassaniya", "Tukulor", "Zenaga", "Bhojpuri", "Chichewa", "Ngoni", "Yao", "Dusun", "Iban", "Mahor\u00e9", "Afrikaans", "Caprivi", "Herero", "Kavango", "Nama", "Ovambo", "Malenasian-Languages", "Polynesian-Languages", "Hausa", "Kanuri", "Songhai-zerma", "Bura", "Edo", "Ibibio", "Ibo", "Ijo", "Tiv", "Sumo", "Niue", "Fries", "Maithili", "Newari", "Tamang", "Tharu", "Nauru", "Brahui", "Hindko", "Saraiki", "Sindhi", "Cuna", "Embera", "Guaym\u00ed", "Pitcairnese", "Bicol", "Cebuano", "Hiligaynon", "Ilocano", "Maguindanao", "Maranao", "Pampango", "Pangasinan", "Pilipino", "Waray-waray", "Palau", "Papuan-Languages", "Tahitian", "Avarian", "Bashkir", "Chechen", "Chuvash", "Mari", "Mordva", "Udmur", "Bari", "Beja", "Chilluk", "Dinka", "Fur", "Lotuko", "Nubian-Languages", "Nuer", "Serer", "Bullom-sherbro", "Kono-vai", "Kuranko", "Limba", "Mende", "Temne", "Nahua", "Sranantonga", "Czech-and-Moravian", "Ukrainian-and-Russian", "Swazi", "Seselwa", "Gorane", "Hadjarai", "Kanem-bornu", "Mayo-kebbi", "Ouaddai", "Tandjile", "Ane", "Kaby\u00e9", "Kotokoli", "Moba", "Naudemba", "Watyi", "Kuy", "Tokelau", "Arabic-French", "Arabic-French-English", "Ami", "Atayal", "Min", "Paiwan", "Chaga-and-Pare", "Gogo", "Ha", "Haya", "Hehet", "Luguru", "Makonde", "Nyakusa", "Nyamwesi", "Shambala", "Acholi", "Ganda", "Gisu", "Kiga", "Lango", "Lugbara", "Nkole", "Soga", "Teso", "Tagalog", "Karakalpak", "Goajiro", "Warrau", "Man", "Muong", "Nung", "Tho", "Bislama", "Futuna", "Wallis", "Samoan-English", "Soqutri", "Northsotho", "Southsotho", "Venda", "Xhosa", "Bemba", "Chewa", "Lozi", "Nsenga"],
    delay: 100
  },
  showAutocompleteOnFocus: true
});
    $('#tokenfield').on('tokenfield:createtoken', function (event) {
    var existingTokens = $(this).tokenfield('getTokens');
    $.each(existingTokens, function(index, token) {
        if (token.value === event.attrs.value)
            event.preventDefault();
    });
});
    $("#youtube_url_link").blur(function() {
        var youtube_link_val = '';
        youtube_link_val = $.trim($('#youtube_url_link').val());
        if (youtube_link_val.length > 0) {
            var result = ytVidId(youtube_link_val);
            if (result == false) {
                $('#error_youtube_link').html('Please Enter a Correct Url');
                $('#youtube_url').val('');
                $('#youtube_url_link').val('');
            } else {
                $('#youtube_url').val(youtube_link_val);
                $('#error_youtube_link').html('');
            }
        }
    });
    $("#vimeo_url_link").blur(function() {
        var vimeo_link_val = '';
        vimeo_link_val = $.trim($('#vimeo_url_link').val());   
        if (vimeo_link_val.length > 0) {
            var result = vimeo_validator(vimeo_link_val);
            if (result == false) {
                $('#error_vimeo_link').html('Please Enter a Correct Url');
                $('#vimeo_url_link').val('');
                $('#vimeo_url').val('');
                $('#vimeo_video_id').val('');
            } else {
                var video = parseVideoURL(vimeo_link_val);
                $('#vimeo_video_id').val(video.id);
                $('#vimeo_url').val(vimeo_link_val);
                $('#error_vimeo_link').html('');
            }
        }
    });
    $('#third_party_videos').click(function() {
        $('#youtube_url').val($('#youtube_url_link').val());
        $('#vimeo_url').val($('#vimeo_url_link').val());
        var youtube_url = $.trim($('#youtube_url').val());
        var vimeo_url = $.trim($('#vimeo_url').val());
		if( (youtube_url.length > 0) || (vimeo_url.length > 0)) { 
		
			if (youtube_url.length > 0) {
				var url = base_url + 'user/sell_service/you_tube_links';
	
				$.ajax({
					type: 'post',
					url: url,
					data: {
						youtube_url: youtube_url
					},
					success: function(data) {
						$('#remove_youtube_div').remove();
						$(".uploaded-section").css("display", "block");
						$(".uploaded-section").append(data);
					}
				});
			}else{
                $('#remove_youtube_div').remove();
            }
			if (vimeo_url.length > 0) {
				var url = base_url + 'user/sell_service/vimeo_links';
				var vimeo_video_id = $('#vimeo_video_id').val();
				$.ajax({
					type: 'post',
					url: url,
					data: {
						vimeo_video_id: vimeo_video_id
					},
					success: function(data) {
						$('#remove_vimeo_div').remove();
						$(".uploaded-section").css("display", "block");
						$(".uploaded-section").append(data);
					}
				});
			}else{
                $('#remove_vimeo_div').remove();
            }
			$("#third-party-gig-modal").css('display', 'none');
        	$("#third-party-gig-modal").modal('hide');
		}
		else{ 
			var q1=$("#error_youtube_link").html(); 
			var q2=$("#error_vimeo_link").html(); 
			if(q1=='' && q2==''){ 
			$("#error_all_link").html('Please Enter any one URL');
			setTimeout(function(){
			  $("#error_all_link").html('');
			}, 5000);
			}
		}
    })
    $("#third_party").click(function() {
        $("#third-party-gig-modal").css('display', 'block');
        $("#third-party-gig-modal").modal('show');
    });
    jQuery('#delivering_time').keyup(function() { 
        var recieved_value = $('#delivering_time').val();        
        var returned_value = this.value.replace(/[^0-9\.]/g, '');
        if ($.isNumeric(recieved_value) == true) {
            recieved_value = $('#delivering_time').val();
            this.value = recieved_value;
        } else {
            this.value = '';
        }
    });
    $('#delivering_time').bind('keyup mouseup', function() {  
        value = this.value;
        if (value == 1) {
            $('#main_delivery_days').html('Day');
        } else if (value > 1) {
            $('#main_delivery_days').html('Days');
        } else {
            $('#main_delivery_days').html('');
        }
		var main_delivering_time = $('#delivering_time').val();
        if (($("#super_fast_delivery").prop("checked") == true) && main_delivering_time > 0) {
            $('#super_fast_delivery_desc').removeAttr("disabled");
            $('#super_fast_delivery_date').removeAttr("disabled");
        } else {
            $('#super_fast_delivery_desc').attr("disabled", "disabled");
            $('#super_fast_delivery_date').attr("disabled", "disabled");
        }
    });
});
 
var _URL = window.URL || window.webkitURL;
var ckeditor_gig_details_value = '';

/*function validate_image() {

    $(document).ready(function() {
        ckeditor_gig_details_value = $("#cke_gig_details iframe").contents().find("body").text();
    });
    $("#desc_err").html(' ');
    $("#image_video_error_msg").html("");
    var ckValue = CKEDITOR.instances['gig_details'].getData();
    var s_file = $("#image_array").val();
    var image_length = s_file.length;

    if ($.trim(ckValue).length === 0) {
        $("#desc_err").html('Please enter about your gig details ');
        $('.sell_service_submit').removeAttr('disabled');
    }
    if (image_length == 0) {
        $("#image_video_error_msg").html("Please upload a file ");
    }
    if ($('#super_fast_delivery').prop('checked') == true) {
        var super_fast_delivery_desc_length = $.trim($('#super_fast_delivery_desc').val()).length;
        var allow_super_fast = true;
        if (super_fast_delivery_desc_length < 1) {
            $("#super_fast_delivery_time_error").html("Please enter a description  ");
            $('#super_fast_delivery_desc').removeAttr("disabled");
            $('#super_fast_delivery_date').removeAttr("disabled");
            $('.sell_service_submit').removeAttr('disabled');
            allow_super_fast = false;
        }
    }

    var error =  0;
        $('.sell_service_submit').removeAttr('disabled');
        $('.extra_money_price').each(function(){

            var no = $(this).attr('date-no');
            if(no!='#' && typeof no !== "undefined"){
                if($('#label_name_'+no).val() !="" || $('#label_val_'+no).val() !="" )  {
                   if($('#label_name_'+no).val() ==""){$('.extra_gigs_gig_name').show(); error = 1 ; return false; }else{$('.extra_gigs_gig_name').hide(); } 
                   if($('#label_val_'+no).val() ==""){ $('.extra_gigs_validate').show(); error = 1 ; return false; }else{ $('.extra_gigs_validate').hide(); } 
                } 
            }
        });
 



    if (($.trim(ckValue).length > 0) && (image_length > 0) && error==0) {
        if ($('#super_fast_delivery').prop('checked') == true) {
            var super_fast_delivery_desc_length = $.trim($('#super_fast_delivery_desc').val()).length;
            if (super_fast_delivery_desc_length > 0) {
                return true;
            } else {
                $("#super_fast_delivery_time_error").html("Please enter a description  ");
                $('#super_fast_delivery_desc').removeAttr("disabled");
                $('#super_fast_delivery_date').removeAttr("disabled");
                $('.sell_service_submit').removeAttr('disabled');
                return false;

            }
        } else {
            return true;
        }
    } else {
        
        if(error==0){
            
            $('.sell_service_submit').removeAttr('disabled');
            return false;    
        }else{

            return false;    
        }
        
    } 
}*/
$(document).ready(function() {
    if (window.File && window.FileList && window.FileReader) {
        $("#image_files").on("change", function(e) {
            var u = URL.createObjectURL(this.files[0]);
            var ext = $('#image_files').val().split('.').pop().toLowerCase();
            if ($.inArray(ext, ['gif', 'png', 'jpg', 'jpeg']) == -1) {
                $('#image_video_error_msg').html('invalid extension!');
                $("#image_files").val('');
            } else {
                var img = new Image;
                img.src = u;
                img.onload = function() {
                    if (img.width >= 680 && img.height >= 460) {
                        $('#show_loader').show();
                        $('#image_video_error_msg').html('');
                        var formData = new FormData();
                        formData.append('gig_files', $('#image_files')[0].files[0]);
                        formData.append('row_id', $('#image_div_id').val());
                        formData.append('file_type', 'image');
                        var url = base_url + 'user/sell_service/file_upload';
                        $.ajax({
                            url: url, 
                            type: "POST",  
                            data: formData, 
                            dataType: 'json',
                            contentType: false,  
                            cache: false, 
                            processData: false, 
                            success: function(data) 
                                {
                                    $('#show_loader').hide();
                                    $('.uploaded-section').css('display', 'block');
                                    $(".uploaded-section").append(data.html);
                                    $('#image_div_id').val(data.row_id);
                                    var v1 = $("#image_array").val();
                                    if (v1.length > 0) {
                                        alert('v1');
                                        var v2 = [];
                                        v2.push(v1);
                                        v2.push(data.sub_html);
                                        $("#image_array").val(v2);
                                    } else {
                                        alert('v1');
                                        var array = [];
                                        array.push(data.sub_html);
                                        $("#image_array").val(array);
                                    }
                                    var v3 = $("#delete_image_array").val();
                                    if (v3.length > 0) {
                                        alert(v3 + data.sub_html);
                                        var v4 = [];
                                        v4.push(v3);
                                        v4.push(data.sub_html);
                                        $("#delete_image_array").val(v4);
                                    } else {
                                        alert(v3 + data.sub_html);
                                        var array1 = [];
                                        array1.push(data.sub_html);
                                        $("#delete_image_array").val(array1);
                                    }
                                    var v5 = $("#deleted_image_array").val();
                                    if (v5.length > 0) {
                                        alert(v5 + data.sub_html);
                                        var v6 = [];
                                        v6.push(v5);
                                        v6.push(data.sub_html);
                                        $("#deleted_image_array").val(v6);
                                    } else {
                                        alert(v5 + data.sub_html);
                                        var array2 = [];
                                        array2.push(data.sub_html);
                                        $("#deleted_image_array").val(array2);
                                    }
                                }
                        });
                    } else {
                        $("#image_video_error_msg").html("Please upload size more than 680*460 ");
                        $('#image_files').val('');

                    }
                }
            }
        });
        $("#video_files").on("change", function(e) {
            var ext = $('#video_files').val().split('.').pop().toLowerCase();
            if ($.inArray(ext, ['mp4', 'webm', 'ogg']) == -1) {
                $('#image_video_error_msg').html('Invalid extension! Supports MP4 , WebM , Ogg files only ');
                $("#video_files").val('');
            } else {
                $('#image_video_error_msg').html('');
                var formData = new FormData();
                formData.append('gig_files', $('#video_files')[0].files[0]);
                formData.append('row_id', $('#video_div_id').val());
                formData.append('file_type', 'video');
                var url = base_url + 'user/sell_service/file_upload';
                $('#video_show_loader').css('display','block');
                $.ajax({
                    url: url,  
                    type: "POST",  
                    data: formData, 
                    dataType: 'json',
                    contentType: false, 
                    cache: false, 
                    processData: false, 
                    success: function(data) 
                        {
                            $('#video_show_loader').css('display','none');
                            $(".uploaded-section").append(data.html);
                            $('#video_div_id').val(data.row_id);
                            var v1 = $("#video_array").val();
                            if (v1.length > 0) {
                                var v2 = [];
                                v2.push(v1);
                                v2.push(data.sub_html);
                                $("#video_array").val(v2);
                            } else {
                                var array = [];
                                array.push(data.sub_html);
                                $("#video_array").val(array);
                            }
                        }
                });
            }
        });

    } else {
        alert("Your browser doesn't support to File API")
    }
});
$(document).on('click', '.loadmore', function() {
    $(this).text('Loading...');
    var ele = $(this).parent('li');
    $.ajax({
        url: 'loadmore.php',
        type: 'POST',
        data: {
            page: $(this).data('page'),
        },
        success: function(response) {
            if (response) {
                ele.hide();
                $(".news_list").append(response);
            }
        }
    });
});
$(function() {
    var url = base_url + 'gigs/get_country_list';
    var submit_url = base_url + 'gigs/search';
    $("#full_country_name").autocomplete({
        source: url,
        select: function(event, ui) {            
            var selected_value = String(ui.item.label);            
            var $form = $(document.createElement('form')).css({
                display: 'none'
            }).attr("method", "POST").attr("action", submit_url);
            var $input = $(document.createElement('input')).attr('name', 'selected_category').val(selected_value);
            var $input2 = $(document.createElement('input')).attr('name', 'search_type').val(1);
            $form.append($input).append($input2);
            $("body").append($form);
            $form.submit();
        }
    });
});
$(function() {
    var url = base_url + 'gigs/all_categories';
    var submit_url = base_url + 'gigs/search';
    $("#search_category_name").autocomplete({
        source: url,
        select: function(event, ui) {           
            var selected_value = String(ui.item.label);
            var $form = $(document.createElement('form')).css({
                display: 'none'
            }).attr("method", "POST").attr("action", submit_url);
            var $input = $(document.createElement('input')).attr('name', 'selected_category').val(selected_value);
            var $input2 = $(document.createElement('input')).attr('name', 'search_type').val(2);
            $form.append($input).append($input2);
            $("body").append($form);
            $form.submit();
        }
    });
});

function country_id_chnage(e) {
    
    var country_id = $(e).find('option:selected').val();
    var url = base_url + 'get_state_list';
      if (country_id != '') {
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    country_id: country_id
                },
                success: function(data) {
                    if (data) {
                        $('#search_state').html(data);
                    }
                }
            });
        } else {
            $('#search_state').html('');
        }
}


$('#country_id').change(function() {
			var country_id = $(this).find('option:selected').val();
        var url = base_url + 'get_state_list';
        if (country_id != '') {
            $.ajax({
                type: 'POST',
                url: url,
                data: {
                    country_id: country_id
                },
                success: function(data) {
                    if (data) {
                        $('#state_id').html(data);
                    }
                }
            });
        } else {
            $('#state_id').html('');
        }
	});
$(document).ready(function() {
    $('#save').click(function() {
        var updated_name = $("#show_user_name").val();
        var ajax_update = '';
        var url = base_url + 'gigs/update_name';
        $.ajax({
            type: 'POST',
            url: url,
            data: {
                updated_name: updated_name
            },
            success: function(data) {
                if (data == 1) {
                    $("#show_user_name").css("display", "none");
                    $("#save").css("display", "none");
                    $("#cancel").css("display", "none");
                    $("#uname-edit").html(updated_name);
                    $("#uname-edit").css("display", "block");
                }
            }
        })
    });
    $('#save_language').click(function() {
        var updated_name = $("#language_tags").val();
        var url = base_url + 'gigs/update_language';
        $.ajax({
            type: 'POST',
            url: url,
            data: {
                updated_name: updated_name
            },
            success: function(data) {
                if (data == 1) {
                    $("#language_tags").css("display", "none");
                    $("#save_language").css("display", "none");
                    $("#cancel_language").css("display", "none");
                    $("#language_list").html(updated_name);
                    $('.tokens-token-list').hide();
                }
            }
        })

    });
    $('#changecatetext').change(function() {
        var option = $(this).find('option:selected').val();
        $('#selected_category').val(option);
    });
    $('.changelocation').click(function() {
        $('#full_country_name').css('display', 'block');
    });
    $('.changecategory').click(function() {
        $('#search_category_name').css('display', 'block');
    });
    function total_check_boxes() {
        var sum = 0;
        $("li input[type=checkbox]:checked").map(function() {
            var id = $(this).attr('id');
            var extra_gig_input = $('#extra_gig_input_' + id).val();
            var loop_count = $('#loop_count').val();
            if (id === 'super_fast_delivery') {
                sum = parseFloat(sum) + parseFloat($('#super_fast_delivery_charges').val());
            }
            if (extra_gig_input > 0) {
                sum = parseFloat(sum) + parseFloat($('#extra_gigs_amount_' + id).val());
            }           		  
        });
        $('#total').val(parseFloat(sum));
        var country = $('#rate_symbol').val();
        var rate = 0;
        if (rate == 0) {
            rate = parseFloat($('#gigs_actual_rate').val()).toFixed(2);
        }
        if (country == '$') {
            
            var amount = (parseFloat(sum) + parseFloat(rate));
            final_gig_amount = amount;
            $('#over_all_total').html(amount);
            $('#change_ratecount').html(amount);
            $('#last_modifiy_inputid').val(amount);
            $('#gigs_rate').val(amount);

        } else {
            $('#over_all_total').html(sum + 500);
            $('#change_ratecount').html(sum + 500);
            $('#last_modifiy_inputid').val(sum + 500);
            $('#gigs_rate').val(sum + 500);
        }
    }
    $('#super_fast_delivery').click(function() {
        var main_delivering_time = $('#delivering_time').val();
        if (($(this).prop("checked") == true) && main_delivering_time > 0) {
            $('#super_fast_delivery_desc').removeAttr("disabled");
            $('#super_fast_delivery_date').removeAttr("disabled");
        } else {
            $('#super_fast_delivery_desc').attr("disabled", "disabled");
            $('#super_fast_delivery_date').attr("disabled", "disabled");
        }

    })
    var indian_rupees = 0;
    $('.check_box').click(function() {
        var id = $(this).attr('id');
        if (id == "super_fast_delivery") {
        }
        if ($(this).prop("checked") == true) {
            indian_rupees = (parseInt(indian_rupees) + 500);
            var extra_gig_charges = $('#default_value_' + id).val();
            var num_extra_gigs = $('#extra_gig_input_' + id).val(1);
            var extra_gigs_delivery_days = $('#extra_gigs_delivery_days_' + id).val();
            if (num_extra_gigs === '' || num_extra_gigs === 0) {
                var total = extra_gig_charges;
                $('#extra_gigs_amount_' + id).val($('#default_value_' + id).val());
            } else {
                var total = num_extra_gigs * extra_gig_charges;
            }
            var sum = 0;
            sum = total_check_boxes();
        } else if ($(this).prop("checked") == false) {
            indian_rupees = (parseInt(indian_rupees) - 500);
            $('#extra_gig_input_' + id).val('');
            var extra_gig_charges = $('#default_value_' + id).val();
            var num_extra_gigs = $('#extra_gig_input_' + id).val();
            $('#extra_gigs_delivery_days_' + id).val($('#default_extra_gigs_delivery_' + id).val());
            $('#extra_gig_input_' + id).attr("disabled", "disabled");
            if (num_extra_gigs === '' || num_extra_gigs === 0) {
                var total = extra_gig_charges;
            } else {
                var total = num_extra_gigs * extra_gig_charges;
            }
            total_check_boxes();
        }
        var total_value = (indian_rupees + 500);
        $('#converted_india_gigs_rate').val(total_value);
    });
});
function total_check_boxes() {
    var sum = 0;
    $("li input[type=checkbox]:checked").map(function() {
        var id = $(this).attr('id');
        var extra_gig_input = $('#extra_gig_input_' + id).val();
        if (id === 'super_fast_delivery') {
            sum = parseFloat(sum) + parseFloat($('#super_fast_delivery_charges').val());

        }
        if (extra_gig_input > 0) {
            sum = parseFloat(sum) + parseFloat($('#extra_gigs_amount_' + id).val());

        } 
    });
    var country = $('#rate_symbol').val();
    var rate = 0;
    if (rate == 0) {
        rate = parseFloat($('#gigs_actual_rate').val()).toFixed(2);
    }
    if (country == '$') {		 
        $('#total').val(parseFloat(sum).toFixed(2));
        $('#over_all_total').html((parseFloat(sum) + parseFloat(rate)).toFixed(2));
        $('#change_ratecount').html((parseFloat(sum) + parseFloat(rate)).toFixed(2));
        $('#last_modifiy_inputid').val((parseFloat(sum) + parseFloat(rate)).toFixed(2));
        $('#gigs_rate').val(parseFloat(sum) + parseFloat(rate));
    } else {
        $('#total').val(sum);
        $('#over_all_total').html(sum + 500);
        $('#change_ratecount').html(sum + 500);
        $('#last_modifiy_inputid').val(sum + 500);
        $('#gigs_rate').val(sum + 500);
    }
}
function extra_gig_input(id) {
    var extra_gig_charges = $('#default_value_' + id).val();
    var num_extra_gigs = $('#extra_gig_input_' + id).val();
    var extra_gigs_delivery_days = $('#extra_gigs_delivery_days_' + id).val();
    if (num_extra_gigs == '' || num_extra_gigs == 0) {
        $('#extra_gigs_amount_' + id).val($('#default_value_' + id).val());
        $('#extra_gigs_delivery_days_' + id).val($('#default_extra_gigs_delivery_' + id).val());
        var sum = 0;
        sum = total_check_boxes();
    } else {
        var total = num_extra_gigs * extra_gig_charges;
        var result = total;
        var default_extra_gigs_delivery = $('#default_extra_gigs_delivery_' + id).val();
        var new_extra_gig_days = num_extra_gigs * default_extra_gigs_delivery;
        $('#extra_gigs_delivery_days_' + id).val(new_extra_gig_days);
        if (new_extra_gig_days < 2) {
            $('#extra_gigs_delivery_' + id).html('Day');
        } else {
            $('#extra_gigs_delivery_' + id).html('Days');
        }
        $('#extra_gigs_amount_' + id).val(result);
        var sum = 0;
        sum = total_check_boxes();
    }
    if (num_extra_gigs === '' || num_extra_gigs === '0') {
        $('#extra_gigs_amount_' + id).val($('#default_value_' + id).val());
        var sum = 0;
        sum = total_check_boxes();
    } else {
        var total = num_extra_gigs * extra_gig_charges;
        var result = total;
        $('#extra_gigs_amount_' + id).val(result);
        var sum = 0;
        sum = total_check_boxes();
    }
}
function show_username() {
    $('#uname-edit').html('');
    $("#show_user_name").css("display", "block");
    $("#save").css("display", "block");
    $("#cancel").css("display", "block");
}
function remove_favourites(gig_id, user_id) {
    var url = base_url + 'remove_favourites';
    $.ajax({
        type: 'POST',
        url: url,
        data: {
            gig_id: gig_id,
            user_id: user_id
        },
        success: function(data) {
            if (data == 1) {
                $('.gig-save-btn').html('');
                $('.gig-save-btn').html('<a href="javascript:;" onclick="add_favourites(' + gig_id + ',' + user_id + ')" >Save</a>');
            }
        }
    });

}
function add_favourites(gig_id, user_id) {
    var url = base_url + 'add_favourites';
    $.ajax({
        type: 'POST',
        url: url,
        data: {
            gig_id: gig_id,
            user_id: user_id
        },
        success: function(data) {
            if (data == 1) {
                $('.gig-save-btn').html('');
                $('.gig-save-btn').html('<a href="javascript:;" onclick="remove_favourites(' + gig_id + ',' + user_id + ')" >Saved</a>');
            }
        }
    });
}
function load_more_feedbacks() {
    var start = $("#load_more_feedid").val();
    var gigid = $("#load_more_gigid").val();
    var userid = $("#load_more_gig_userid").val();
    var url = base_url + 'load_more_feedbacks';
    var dataString = "start=" + start + "&userid=" + userid + "&g_id=" + gigid;
    $.ajax({
        url: url,
        data: dataString,
        type: "POST",
        dataType: 'json',
        success: function(res) {
            if (res.status == 1) {
                $(".feedback-list").append(res.more_data);
                $('#load_more_feedid').val(res.start_count);
            } else {
                $(".more-feedback").hide();
            }
        }
    });
}
function load_more_userfeedbacks() {
    var start = $("#load_more_feedid").val();
    var userid = $("#load_more_gig_userid").val();
    var lit = $("#load_more_feedlimit").val();
    var url = base_url + 'load_more_userfeedbacks';
    var dataString = "start=" + start + "&userid=" + userid;
    $.ajax({
        url: url,
        data: dataString,
        type: "POST",
        dataType: 'json',
        success: function(res) {
            if (res.status == 1) {
                if (lit > res.start_count) {
                    $('#load_more_feedid').val(res.start_count);
                } else {
                    $('#load_more_feedid').val(res.start_count);
                    $(".more_user_feedback").hide();
                }
                $("#load_more_feeddatashow").append(res.more_data);
            } else {
                $(".more_user_feedback").hide();
            }
        }
    });
}
function remove_favourites_list(gig_id, user_id, ele) {
    var url = base_url + 'remove_favourites';
    $.ajax({
        type: 'POST',
        url: url,
        data: {
            gig_id: gig_id,
            user_id: user_id
        },
        success: function(data) {
            if (data == 1) {
                $(ele).parent().append('<a href="javascript:;" class="favourite" title="Add Favourite" onclick="add_favourites_list(' + gig_id + ',' + user_id + ', this)" ><i class="fa fa-heart"></i></a>');
                ele.remove();
            }
        }
    });
}
function add_favourites_list(gig_id, user_id, ele) {
    var url = base_url + 'add_favourites';
    $.ajax({
        type: 'POST',
        url: url,
        data: {
            gig_id: gig_id,
            user_id: user_id
        },
        success: function(data) {
            if (data == 1) {
                $(ele).parent().append('<a href="javascript:;" class="favourite favourited" title="Remove Favourite" onclick="remove_favourites_list(' + gig_id + ',' + user_id + ', this)"><i class="fa fa-heart"></i></a>');
                ele.remove();
            }
        }
    });
}
function remove_favourites_me(gig_id, user_id, ele) {
    var url = base_url + 'gigs/remove_favourites';
    $.ajax({
        type: 'POST',
        url: url,
        data: {
            gig_id: gig_id,
            user_id: user_id
        },
        success: function(data) {
            if (data == 1) {
                $(ele).parent().parent().parent().remove();
            }
        }
    });
}
$( document ).ready(function() {
	$('#tokenfield-tokenfield').bind('keypress', function(event) { 
		firstnamevalidate(event);
	});
});
function firstnamevalidate(e)
{
	var keyCode = e.keyCode || e.which; 				 
	if(keyCode!=9 && keyCode!=8 && keyCode!=46 )
	{ 	
		var regex = new RegExp("^[a-zA-Z\-,._ ]+$");
		var key = String.fromCharCode(!e.charCode ? e.which : e.charCode);					 
		if (!regex.test(key)) 
		{					 
			e.preventDefault();
			return false;
		}
	}
}