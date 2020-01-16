function max_lenght(e){

    if($(e).val()==""){

        $('#super_fast_delivery_date').val(1);

    }else{

    if( parseInt($(e).val())< 1 || parseInt($(e).val())>=30){

         $('.delivery_days_error').show();

         $('.validdays').attr('disabled','disabled');



         $(e).val('');

        }else{

            $('.delivery_days_error').hide();

            $('.validdays').removeAttr('disabled');

            

       }    

    }

    

}



function gig_title_check(e){

    

    var gig_title = $(e).val();

    var gig_id = $('#gig_id').val();

    $.post(base_url + 'user/dashboard/check_gig_title',{gig_title:gig_title,gig_id:gig_id},function(message){



            var data = JSON.parse(message);

            if(data.valid == false){

                $('.gig_title_valid').val(1); // Invalid 

                $('.gig_title_already_error').show();

            }else{

                $('.gig_title_valid').val(0); // Valid 

                $('.gig_title_already_error').hide();

            }

        }); 

}







function sell_services_update(){



    var error =0;

    var gig_title = $('#gig_title').val().trim();

    

    

    if(gig_title==""){

        $('.gig_title_error').show();

        error =1; 

    }else{

        $('.gig_title_error').hide();

    }



   



      if($('.gig_title_valid').val()==1){

             error = 1;

            $('.gig_title_already_error').show();

        }else{

                $('.gig_title_already_error').hide();

        }

  



    if($('#gig_price').val()==""){

        error = 1;

        $('.gig_price_error').show();

    }else{

        $('.gig_price_error').hide();

    }

    if($('#delivering_time').val()==""){

        error = 1;

        $('.main_delivery_days_error').show();

    }else{

        $('.main_delivery_days_error').hide();

    }

    if($('#delivering_time').val()!=""){

        

        if(parseInt($('#delivering_time').val())>=30){

          error = 1;

         $('.delivery_days_error').show();

        }else{

            $('.delivery_days_error').hide();

       }

    }



    if($('#gig_category_id').val()==""){

        error = 1;

        $('.gig_category_id_error').show();

    }else{

        $('.gig_category_id_error').hide();

    }

    

    var new_s_file = $("#image_array").val();

    var s_file = $("#delete_image_array").val();

    var image_length = s_file.length;
    var new_image_length = new_s_file.length;

    if (image_length == 0 && new_image_length == 0) {

        error = 1;

        $('.image_error_error').show();

    }else{

        $('.image_error_error').hide();

    }

    var ckValue = CKEDITOR.instances['gig_details'].getData();

        if ($.trim(ckValue).length === 0) {

         error = 1;

        $('.gig_details_error').show();

    }else{

        $('.gig_details_error').hide();

    }       

    

      $('.extra_money_price').each(function(){



            var no = $(this).attr('date-no');



            if(no!='#' && typeof no !== "undefined"){

                if($('#label_name_'+no).val() !="" || $('#label_val_'+no).val() !="" )  {

                   if($('#label_name_'+no).val() ==""){$('.extra_gigs_gig_name').show(); error = 1 ;  return false; }else{$('.extra_gigs_gig_name').hide(); } 

                   if($('#label_val_'+no).val() ==""){ $('.extra_gigs_validate').show(); error = 1 ;  return false; }else{ $('.extra_gigs_validate').hide(); } 

                } 

            }

        });

       



      if($('input[name="work_option"]').is(':checked')==false){

        error = 1;

        $('.work_option_error').show();

      }else{

        $('.work_option_error').hide();

      }



      if($('#super_fast_delivery').is(':checked')==true){

            if($('#super_fast_delivery_desc').val()==''){

                error = 1;

                $('.super_fast_error').show();

            }else{

                $('.super_fast_error').hide();

            }



            if($('#super_fast_charges').val()==''){

                error = 1;

                $('.super_fast_priece_error').show();

            }else{

                $('.super_fast_priece_error').hide();

            }



            // if($('#super_fast_delivery_date').val()>$('#main_delivery_days').val()){

            //     error = 1;

            //     $('.less_then_priece_error').show();

            // }else{

            //     $('.less_then_priece_error').hide();

            // }

      }

      

      if($('#terms_conditions').is(':checked')==false){

            error = 1;

            $('.terms_conditions_error').show();

      }else{

             $('.terms_conditions_error').hide();

      }

      

    if (error==0) {



         $('#update_gig').submit();



    } else {

        return false;

    }





}