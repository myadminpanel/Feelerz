<?php 

class Sell_service extends CI_Controller{

    public function __construct() 

    {			

    	parent::__construct(); 
    	
    	$this->load->helper('favourites');
    	$common_settings = gigs_settings();
    	$default_currency = 'USD';
        if(!empty($common_settings)){
          foreach($common_settings as $datas){
            if($datas['key']=='currency_option'){
             $default_currency = $datas['value'];
            }
         }
        }

$this->load->helper('currency');
        $this->default_currency      = $default_currency;
        $this->default_currency_sign = currency_sign($default_currency);
        $this->smtp_config           = smtp_mail_config();
       
        $user_ip = getenv('REMOTE_ADDR'); 
         $geo = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=$user_ip"));              

        $geoplugin_latitude = $geo["geoplugin_latitude"];   

        $geoplugin_longitude = $geo["geoplugin_longitude"];

        $t=time();

         $result = $this->getTimezoneGeo($geoplugin_latitude,$geoplugin_longitude,$t);
         $this->data['time_zone'] = $result;   



$this->load->model('user_login_model');

        $this->load->model('user_panel_model');

  $this->data['client_list'] = $this->user_panel_model->get_client_list();        

        $this->data['categories_subcategories'] = $this->user_panel_model->categories(); 

        $this->data['footer_main_menu'] = $this->user_panel_model->footer_main_menu();

        $this->data['footer_sub_menu'] = $this->user_panel_model->footer_sub_menu();   

        $this->data['system_setting'] = $this->user_panel_model->system_setting();

		$this->data['policy_setting'] = $this->user_panel_model->policy_setting();			

        $this->load->model('gigs_model');

       $query = $this->db->query("select * from system_settings WHERE status = 1");

		$result = $query->result_array();

		$this->email_address='mail@example.com';

		$this->email_tittle='Gigs';

		$this->logo_front=base_url().'assets/images/logo.png';

		$this->site_name ='Escort';

	    $this->base_domain = base_url();

		if(!empty($result))

		{

		foreach($result as $data){

		if($data['key'] == 'email_address'){

		$this->email_address = !empty($data['value']) ?$data['value'] : 'mail@example.com' ;

		}

	   if($data['key'] == 'email_tittle'){

		$this->email_tittle =!empty($data['value']) ? $data['value'] : 'Escort' ;

		}

		   if($data['key'] == 'logo_front'){

		$this->logo_front = base_url().$data['value'];

		}

		if($data['key'] == 'site_name' || $data['key'] == 'website_name'){

		$this->site_name = $data['value'];

		}



    $this->data['currency_option'] = 'USD';

		if($data['key']=='currency_option'){

          $this->data['currency_option'] =$data['value'];

        }



    }

		}

        // $this->load->helper('currency');
        // $this->default_currency      = $default_currency;
        // $this->default_currency_sign = currency_sign($default_currency);
        // $this->smtp_config           = smtp_mail_config();

		if($this->session->userdata('SESSION_USER_ID'))

		{

			$this->load->helper('ckeditor'); 

			$this->data['ckeditor_editor'] = array

			(

			//id of the textarea being replaced by CKEditor

			'id' => 'gig_details',

			// CKEditor path from the folder on the root folder of CodeIgniter

			'path' => 'assets/js/ckeditor',

			// optional settings

			'config' => array

			(

			'toolbar' => "Full"

			)

			);

			$this->data['ckeditor_editor_one'] = array

			(

			//id of the textarea being replaced by CKEditor

			'id' => 'requirements',

			// CKEditor path from the folder on the root folder of CodeIgniter

			'path' => 'assets/js/ckeditor',

			// optional settings

			'config' => array

			(

			'toolbar' => "Full"

			

			)

			);

			

			$LAST_ACTIVITY = $this->session->userdata('LAST_ACTIVITY');

			if (isset($LAST_ACTIVITY) && (time() - $LAST_ACTIVITY > 86400 )) 

			{        

				session_unset();     // unset $_SESSION variable for the run-time

				session_destroy();   // destroy session data in storage

				redirect(base_url());

			 }

			$this->load->model('user_panel_model');

			$this->load->model('gigs_model');

			$this->data['title'] 			= 'Gigs';

			$this->data['theme']			= 'user';

			$this->data['module']			= 'sell_service';       

			$this->data['client_list']		= $this->user_panel_model->get_client_list();        

			$this->data['categories']  		= $this->user_panel_model->categories(); 

			$this->data['footer_main_menu'] = $this->user_panel_model->footer_main_menu();

			$this->data['footer_sub_menu'] 	= $this->user_panel_model->footer_sub_menu();   

			$this->data['system_setting']	= $this->user_panel_model->system_setting();
			 $this->data['logo'] = $this->user_panel_model->get_logo();

           $this->load->model('admin_panel_model');
			$this->data['rupee_dollar_rate']         = $this->admin_panel_model->get_rupee_dollar_rate();

			$rupee_dollar_rate 						 = $this->data['rupee_dollar_rate'];

			$user_ip 						= getenv('REMOTE_ADDR');		 

			if(($this->session->userdata('time_zone'))){

			       

				$this->data['time_zone']		 = $this->session->userdata('time_zone');        

				$this->data['full_country_name'] ='';         

				$this->data['country_name'] 	 = $this->session->userdata('country_name');                

				$this->data['dollar_rate'] 		 = $this->session->userdata('dollar_rate');  

				$this->data['rupee_rate'] 		 = $this->session->userdata('rupee_rate'); 

			}        

			else             

			{

				if($this->session->userdata('LAST_ACTIVITY')=='')

				{

					$this->session->set_userdata('LAST_ACTIVITY',time());	

				}

					$user_ip 	= getenv('REMOTE_ADDR');     					 

					 $this->data['time_zone'] 			= $this->session->userdata('timezone');                       

					$this->data['dollar_rate'] 			=  $rupee_dollar_rate['dollar_rate'] ;  

					$this->data['rupee_rate']  			=  $rupee_dollar_rate['indian_rate']; 

					$this->session->set_userdata('dollar_rate',$this->data['dollar_rate']); 

					$this->session->set_userdata('rupee_rate',$this->data['rupee_rate']);            

					if($this->session->userdata('SESSION_USER_ID'))

					{

						$data['user_timezone'] = $this->data['time_zone'] ;

						$this->db->where('USERID',$this->session->userdata('SESSION_USER_ID'));

						$this->db->update('members',$data);         

					}

      		 }

			if($this->session->userdata('SESSION_USER_ID'))

			{

			$this->data['user_favorites'] = $this->gigs_model->add_favourites();

			}

			

		

		

			$this->data['gig_price'] = $this->gigs_model->gig_price();

			$this->data['extra_gig_price'] = $this->gigs_model->extra_gig_price();

			$this->data['price_option'] = $this->gigs_model->get_setting_price_option();

			$this->data['gigs_country']             =  $this->gigs_model->gigs_country();
			
			$this->data['categories_subcategories'] = $this->user_panel_model->categories_subcategories();


	 }

	 else

	 {

		 redirect(base_url());

	 }

	 $this->data['currency_option'] = 'USD';

	 if(!empty($this->data['system_setting'])){

	 	$system_setting = $this->data['system_setting'];

	 	if(!empty($system_setting)){

	 		foreach ($system_setting as  $settings) {

	 			if($settings['key']=='currency_option'){

	 				$this->data['currency_option'] =$settings['value'];

	 			}

	 		}

	 	}

	 }

 

    }  


 public function remove_escort_from_agency()
 {
 	$id=$this->input->post("id");
 	$this->db->where(array("USERID"=>$id));
 	$this->db->delete("user_login");
 	$this->db->where(array("escort_id"=>$id));
 	$this->db->delete("escort_info");
 }     


public function set_order_of_gallery_images()
{
	$user_id=$this->input->post("id");
	$order=$this->input->post("order_ids");
	$data=$this->db->query("select * from gallery_image where user_id='".$user_id."' ORDER BY id DESC")->result_array();
if($data)
{
	$i=0;
foreach ($data as $dat) {
		 $this->db->where(array("id"=>$dat["id"]));
		 $this->db->update("gallery_image",array("priborty"=>$order[$i]));
		 $i=$i+1;
	}
}
	
}

public function get_all_gallery_images()
{
	$id=$this->input->post("id");
	$data=$this->db->query("select * from gallery_image where user_id='".$id."' ORDER BY id DESC")->result_array();
	$this->load->view("user/modules/sell_service/show_image",array("data"=>@$data));
}

public function add_suburbs_set()
{

	
	$user_id=$this->input->post("user_id");
	$suburbs=implode("*#*", $this->input->post("ids"));
	$res=$this->db->query("select * from suburbs where user_id='".$user_id."'")->row_array();
	if($res)
	{
		$this->db->where(array("user_id"=>@$user_id));
		$this->db->update("suburbs",array("suburbs"=>@$suburbs));
	}
	else
	{
		$this->db->insert("suburbs",array("user_id"=>@$user_id,"suburbs"=>@$suburbs));
	}
}

public function remove_image()
{
	$id=$this->input->post("id");
	// var_dump($id);
	$this->db->where(array("id"=>$id));
	$this->db->delete("gallery_image");
	var_dump($this->db->last_query());
}


public function add_image_gallery()
{
	$data = $this->input->POST("blob");
	$user_id=$this->input->POST("id");
	$image_array_1 = explode(";", $data);
	$image_array_2 = explode(",", $image_array_1[1]);
	$data = base64_decode($image_array_2[1]);
	$imageName_only = time() . '.png';
     $data_set["user_id"]=$user_id;
     $data_set["image"]=$imageName_only;
     $data_set["date"]=date("d-M-y");
     $data_set["status"]="1";
    $this->db->insert('gallery_image',$data_set);

	$imageName = "assets/uploads/".$imageName_only;
	file_put_contents($imageName, $data);
 
       $image_id=$this->db->query("select * from gallery_image where user_id='".$user_id."' ORDER BY `gallery_image`.`id` DESC limit 1")->row_array();
       // var_dump($this->db->last_query());
	echo '<dlv class="example-image-link advertiser-gallery-thumb over-img"><img src="'.base_url().'assets/uploads/'.$imageName_only.'" alt="Isabella - Image 1" class="img-responsive img-thumb"><a href="javascript:;" class="remove_gallery_image_dsp_remove" data-id="'.$image_id["id"].'"><i class="fa fa-remove over-img1" style="font-size:16px"></i></a><a href="'.base_url().'assets/uploads/'.$imageName_only.'" data-fancybox="images" ><i class="fa fa-search over-img2" style="font-size:14px"></i></a></dlv>';
}

public function add_image()
{
	$data = $this->input->POST("blob");
	$image_array_1 = explode(";", $data);
	$image_array_2 = explode(",", $image_array_1[1]);
	$data = base64_decode($image_array_2[1]);
	$imageName_only = time() . '.png';
//$id=$_SESSION["user"]["id"];
//mysqli_query($conn,"UPDATE `registration` SET `image`='".$imageName_only."' WHERE id='".$id."'");

	$imageName = "assets/uploads/".$imageName_only;
	file_put_contents($imageName, $data);
	echo '<input type="hidden" name="user_lofin[profile_image]" value="'.$imageName_only.'">';
}

public function add_image_cover()
{
	$data = $this->input->POST("blob");
	$image_array_1 = explode(";", $data);
	$image_array_2 = explode(",", $image_array_1[1]);
	$data = base64_decode($image_array_2[1]);
	$imageName_only = time() . '.png';
//$id=$_SESSION["user"]["id"];
//mysqli_query($conn,"UPDATE `registration` SET `image`='".$imageName_only."' WHERE id='".$id."'");

	$imageName = "assets/uploads/".$imageName_only;
	file_put_contents($imageName, $data);
	echo '<input type="hidden" name="user_lofin[cover_image]" value="'.$imageName_only.'">';
}


    function getTimezoneGeo($geoplugin_latitude, $geoplugin_longitude,$t)

	 {

		$json = file_get_contents("https://maps.googleapis.com/maps/api/timezone/json?location=$geoplugin_latitude,$geoplugin_longitude&timestamp=$t&key=AIzaSyCrF-ZcLpYjLO7ygnisZJk_eHogmlzawwE ");     

		$data = json_decode($json,true);  

		$tzone=$data['timeZoneId'];      

		return $tzone;

	}


public function get_citys()
{
	$stat=$this->input->post("state");
	$citys=$this->db->query("SELECT * FROM `location` WHERE `state` LIKE '".$stat."' ORDER BY `state` ASC")->result_array();
	if($citys)
	{
		$citys_set ='<option value="">Select City</option>';
          foreach ($citys as $cit) {
          	 $citys_set .='<option value="'.$cit['city'].'">'.$cit['city'].'</option>';

          }
          echo $citys_set;
	}
	else
	{
		echo '<option value="">No City</option>';
	}
}

public function add_escort()
{
	// var_dump($this->input->post('escort_info'));
        $types=@$this->input->post("user_lofin")["types"];
		$data_for_login["username"]=@$this->input->post("user_lofin")["username"];
		if(@$this->input->post("user_lofin")["gender"])
		{
			$data_for_login["gender"]=@$this->input->post("user_lofin")["gender"];
		}
		else
		{
		 $data_for_login["gender"]=@$this->input->post("gender_set_default");	
		}
       	
       	if(@$this->input->post("user_lofin")["types"]=="Escort")
       	{
	    $data_for_login["user_thumb_image"]=@$this->input->post("user_lofin")["profile_image"];
       	}
       
       	$data_for_login["cover_image"]=@$this->input->post("user_lofin")["cover_image"];
       	$data_for_login["fullname"]=@$this->input->post("user_lofin")["name"];
       	$data_for_login["email"]=@$this->input->post("user_lofin")["email"];
       	$data_for_login["contact"]=@$this->input->post("user_lofin")["contact"];
       // var_dump(@$this->input->post("userid"));
       if(@$this->input->post("userid"))
       {
         $this->db->where(array("USERID"=>@$this->input->post("userid")));
          $this->db->update('user_login',$data_for_login);
           // var_dump($this->db->last_query());
          $escort_id=@$this->input->post("userid");
       }
       else
       {

       	   $username = implode("_",explode(" ",@$this->input->post("user_lofin")["name"])).'_'.strtotime(date('Y-m-d H:i:s'));
       	   $email = @$this->input->post("user_lofin")["email"];   
       	   $result = $this->user_panel_model->check_email($email);       

            if ($result > 0) 
            {

                $this->session->set_flashdata("fail","Email is already taken"); 
                redirect(base_url().'escort-profile/');

             }
             else
             {
             	     $phone = @$this->input->post("user_lofin")["contact"];   
                     $result = $this->user_panel_model->check_phone($phone);  
                           
                      if ($result > 0) {
                             $this->session->set_flashdata("fail","Number is already taken");
                             redirect(base_url().'escort-profile/');
                           }
                           else
                           {

                           	$types='Escort';
                           	             $set_password='Escort@123';
                           	               $data['fullname']         = @$this->input->post("user_lofin")["name"];
                                           $data['email']           = @$this->input->post("user_lofin")["email"];
                                           $data['contact']   = @$this->input->post("user_lofin")["contact"];
                                           $data['cover_image']   = @$this->input->post("user_lofin")["cover_image"];
                                           $data['user_thumb_image']   = @$this->input->post("user_lofin")["profile_image"];
                                           $data['password']        = md5($set_password);
                                           $data['username']        = $username;
                                           $data['gender']        = @$this->input->post("user_lofin")["gender"];
                                           $data['types']     = @$this->input->post("user_lofin")["types"];
                                           $data['country']         = 13;
                                           $data['user_timezone']   = 'Asia/Calcutta' ;
                                            date_default_timezone_set($data['user_timezone']);
                                           $data['created_date']    = date('Y-m-d H:i:s') ;
 
                                            $username =  $data['username'];       


                                         $url_encypted = urlencode($this->encryptor('encrypt',$username));

                                          $data['username_code'] = $url_encypted; 
        
                                               
                                               $data['verified'] = 1;

                                               $data['status'] = 1;

                                    
                                            $res=$this->db->insert('user_login',$data);
                                            var_dump($this->db->last_query());
                                       $this->session->set_flashdata("pass","Account created successfully. Kindly verify the email sent to ".$data['email']."");
                             
                            
                                  $url=base_url().'activate_account/'.$url_encypted;                                         

        $this->load->model('templates_model');

        $message='';

        $welcomemessage='';

        $bodyid=13;

        $tempbody_details= $this->templates_model->get_usertemplate_data($bodyid);     

        $body=$tempbody_details['template_content'];

    $body = str_replace('{base_url}', $this->base_domain, $body);

    $body = str_replace('{base_image}',$this->base_domain.'/'.$this->logo_front, $body);

        $body = str_replace('{USER_NAME}', $data['fullname']."-- Password :".$set_password, $body);

        $body = str_replace('{sitetitle}',$this->site_name, $body);

        $body = str_replace('{SUBMIT_LINK}', $url, $body);
                                     
    $message ='<table style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">

      <tr>

        <td></td>

        <td width="600" style="box-sizing: border-box; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">

          <div style="box-sizing: border-box; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">

            <table width="100%" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;" bgcolor="#fff">

              <tr>

                <td style="box-sizing: border-box; vertical-align: top; text-align: left; margin: 0; padding: 20px;" valign="top">

                  <table width="100%" cellpadding="0" cellspacing="0">

                    <tr>

                      <td style="text-align:center;">

                        <a href="{base_url}" target="_blank"><img src="'.$this->logo_front.'" style="width:90px" /></a>

                      </td>

                    </tr>

                    <tr>

                      <td>'.$body.'</td>

                    </tr>

                  </table>

                </td>

              </tr>

            </table>

            <div style="box-sizing: border-box; width: 100%; clear: both; color: #999; margin: 0; padding: 15px 15px 0 15px;">

              <table width="100%">

                <tr>

                  <td style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0;" align="center" valign="top">

                    &copy; '.date("Y").' <a href="'.$this->base_domain.'" target="_blank" style="color:#bbadfc;" target="_blank">'.$this->site_name.'</a> All Rights Reserved.

                  </td>

                </tr>

              </table>

            </div>

          </div>

        </td>

      </tr>

    </table>'; 

      
$email_id=$data['email'];
                                 $this->load->view("email/send",array("email"=>@$email_id,"subject"=>'New Registration '.$this->site_name,"mess"=>$message));
var_dump($this->db->last_query());
                  $get_escort_id=$this->db->query("select * from user_login where email='".$email_id."'")->row_array();               
                   $escort_id=@$get_escort_id["USERID"];
                   // var_dump($get_escort_id["USERID"]);

                           }
             } 
       }


       
       

         $data_for_eacort_profile["escort_id"]=$escort_id;
         $data_for_eacort_profile["agency_id"]=@$this->input->post("agencyid");
       	 $data_for_eacort_profile["state"]=@$this->input->post("escort_info")["state"];
       	 $data_for_eacort_profile["main_location"]=@$this->input->post("escort_info")["main_location"];
       	 $data_for_eacort_profile["sub_location"]=@$this->input->post("escort_info")["sub_location"];
       	 $data_for_eacort_profile["eye_color"]=@$this->input->post("escort_info")["eyes"];
       	 $data_for_eacort_profile["hair_style"]=@$this->input->post("escort_info")["hair"];
       	 $data_for_eacort_profile["body_type"]=@$this->input->post("escort_info")["body_type"];
       	 $data_for_eacort_profile["age"]=@$this->input->post("escort_info")["age"];
       	 $data_for_eacort_profile["dress_size"]=@$this->input->post("escort_info")["dress_size"];
       	 $data_for_eacort_profile["place_of_services"]=@$this->input->post("escort_info")["service_place"];
       	 $data_for_eacort_profile["sms_number"]=@$this->input->post("escort_info")["sms_phone_no"];
       	 $data_for_eacort_profile["height"]=@$this->input->post("escort_info")["height"];
       	 $data_for_eacort_profile["photo_status"]=@$this->input->post("escort_info")["photo_status"];
       	 $data_for_eacort_profile["swa_number"]=@$this->input->post("escort_info")["swa_number"];
       	 $data_for_eacort_profile["about"]=@$this->input->post("escort_info")["about_me"];


       	 $data_for_eacort_profile["orientation"]=@$this->input->post("escort_info")["orientation"];
       	 $data_for_eacort_profile["ethnicity"]=@$this->input->post("escort_info")["ethnicity"];
       	 $data_for_eacort_profile["bust_size"]=@$this->input->post("escort_info")["bust_size"];
       	 $data_for_eacort_profile["escort_for"]=@$this->input->post("escort_info")["escort_for"];

 

if($escort_id)
{
	$check_id=$this->db->query("select * from escort_info where escort_id='".$escort_id."'")->row_array();
	var_dump($check_id);
     if($check_id)
     {
     	$this->db->where(array("escort_id"=>$escort_id));
          $this->db->update('escort_info',$data_for_eacort_profile);
         $this->session->set_flashdata('message',"profile is Updated.");
         var_dump($this->db->last_query());
     }
     else
     {

          $this->db->insert('escort_info',$data_for_eacort_profile);
          $this->session->set_flashdata('message',"Profile is Updated.");
          // var_dump($this->db->last_query());
     }
}
   
   if(@$this->input->post("user_lofin")["types"]=="Escort")
   {
   	   if($escort_id)
    {
    
      $escort_services_prefer["escort_id"]=$escort_id;
      if(@$this->input->post("escort_services"))
      {
      	$escort_services_prefer["services"]=implode("*#*",@$this->input->post("escort_services"));
      }
      else
      {
      	$escort_services_prefer["services"]="";
      }
      $escort_services_prefer["last_update"]=date('d-m-Y');
 
	$check_id=$this->db->query("select * from escort_think_prefer where escort_id='".$escort_id."'")->row_array();
     if($check_id)
     {
     	$this->db->where(array("escort_id"=>@$escort_id));
          $this->db->update('escort_think_prefer',$escort_services_prefer);
         $this->session->set_flashdata('message',"profile is Updated.");
     }
     else
     {

          $this->db->insert('escort_think_prefer',$escort_services_prefer);
          $this->session->set_flashdata('message',"Profile is Updated.");
     }
}

   }
 
// @$this->input->post("user_lofin")["types"]=="Escort"
 if(@$this->input->post("user_lofin")["types"])
   {


// var_dump(@$this->input->post("packeg_start_date"));
         if(@$this->input->post("packeg_start_date"))
      {
            $set_escort_availability["packeg_start_date"]=@$this->input->post("packeg_start_date");
            $package_start_date_set=@$this->input->post("packeg_start_date");
      } 
      else
      {

      	    $set_escort_availability["packeg_start_date"]=date("d-M-Y");
            $package_start_date_set=@date("d-M-Y");

      }


      $days=[];
      $dates=[];
      $times=[];
      $duration=[];
      $temp_date=[];
      $date_and_days=$this->input->post("days_and_date");
      // var_dump($date_and_days);
      for($i=0; $i<@$this->input->post("duration_play"); $i++)
      {
      	// var_dump(@date("d-M-Y", strtotime("+$i days")));
      	
        for($j=0; $j<count($date_and_days); $j++)
        {
        	 $val=explode("_", $date_and_days[$j]);
        	 // var_dump();
        	 if(!in_array($val["1"],$temp_date))
        	 {
        	  array_push($temp_date, $val["1"]);	
        	 }
        	 
        }
 // var_dump('<br>');
      }
// var_dump(@$this->input->post("duration"));
     for($k=0; $k<@$this->input->post("duration_play"); $k++)
     {

     	
     	if(in_array(date("d-M-Y", strtotime("+$k days")), $temp_date))
     	{
     		
              $date = date('d-M-Y', strtotime('+'.$k.' days', strtotime(@$package_start_date_set)));
                $dayname = date('D', strtotime('+'.$k.' days', strtotime(@$package_start_date_set)));

// var_dump($date);
     		 // $dayname = date('D', strtotime(@date("d-M-Y", strtotime("+$k days"))));
switch($dayname){
             case 'Sun':
                  $day_name='Sunday';       
                 break;
                 case 'Mon':
                  $day_name='Monday';       
                 break;
                 case 'Tue':
                  $day_name='Tuesday';       
                 break;
                  case 'Wed':
                  $day_name='Wednesday';       
                 break;
                 case 'Thu':
                  $day_name='Thursday';       
                 break;
                 case 'Fri':
                  $day_name='Friday';       
                 break;
                 case 'Sat':
                  $day_name='Saturday';       
                 break;
            
     }
              $date=@$date;
             $days[$k]=$day_name;
     		$dates[$k]=$date;
     		$times[$k]=@$this->input->post("from_time_".$date)["0"].'=='.$this->input->post("to_time_".$date)["0"];
     		$duration[$k]= @$this->input->post("duration")["duration_".$date];
     		
     	}
     	else
     	{
     		 $days[$k]="NULL";
     		$dates[$k]="NULL";
     		$times[$k]="NULL==NULL";
     		$duration[$k]= "NULL";
     	}
     }
       // var_dump($days);
       // var_dump("<br>");
       // var_dump($dates);
       // var_dump("<br>");
       // var_dump($times);
       // var_dump("<br>");
       // var_dump($duration);
        $set_escort_availability["escort_id"]=$escort_id;
       $set_escort_availability["plan"]=@$this->input->post("duration_play");
       $set_escort_availability["days"]=implode("*#*",@$days);
       $set_escort_availability["dates"]=implode("*#*",@$dates);
       $set_escort_availability["time"]=implode("*#*",@$times);
       $set_escort_availability["duration"]=implode("*#*",@$duration);
       $set_escort_availability["last_update"]=date("d-m-Y");
      

       $set_escort_availability["last_update"]=date("d-m-Y");
       if(@$dates)
       {
       	$dates_set_data=$this->input->post("duration_play")-1;
       	  $set_escort_availability["packeg_finish_date"]=@date("d-M-Y", strtotime("+".$dates_set_data." days"));
       	  $set_escort_availability["packeg_finish_date_string"]=strtotime(@date("d-M-Y", strtotime("+".$dates_set_data." days")));
       }
         else
       {
       	 $set_escort_availability["packeg_finish_date"]="";
       	  $set_escort_availability["packeg_finish_date_string"]="";
       }
// var_dump($set_escort_availability);
       if($escort_id)
          {
     $check_id=$this->db->query("SELECT * FROM `escort_availability` where escort_id='".$escort_id."' and packeg_finish_date_string >='".strtotime(date('d-m-Y'))."'")->row_array();
			     if($check_id)
			     {
			     	$this->db->where(array("id"=>@$check_id["id"]));
			          $this->db->update('escort_availability',$set_escort_availability);
			         $this->session->set_flashdata('message',"profile is Updated.");
			     }
			     else
			     {

			          $this->db->insert('escort_availability',$set_escort_availability);
			          $this->session->set_flashdata('message',"Profile is Updated.");
			     }
          }
   }

   if(@$this->input->post("tour")["end_tour"] ||  @$this->input->post("tour")["start_tour"] || @$this->input->post("tour")["place"])
        {
        	
         
			      if(@$this->input->post("agencyid"))
			 {
			 	$get_escort_id_of_agency_id=$this->db->query("select a.escort_id from escort_info as a,user_login as b where b.status='0'and a.escort_id=b.USERID and a.escort_id!='".@$this->input->post("agencyid")."' and a.agency_id='".@$this->input->post("agencyid")."'")->result_array();

			 	// var_dump($get_escort_id_of_agency_id);
			 	 $set_all_escort_id=[];
			 	 if(@$get_escort_id_of_agency_id)
			 	 {
			 	 	foreach(@$get_escort_id_of_agency_id as $esc_id)
			 	 	{
			 	 		array_push($set_all_escort_id, $esc_id["escort_id"]);
			 	 	}

			 	   $get_all_tour=$this->db->query("SELECT count(id) as total_tour FROM `escort_tour` WHERE `escort_id` IN (".implode(",",$set_all_escort_id).") AND `ture_status` IN ('Running','Pending')")->row_array();	
			 	 	$set_total_tour=$get_all_tour["total_tour"];
			 	 }
			 	 else
			 	 {
			 	 	$set_total_tour=0;
			 	 }
			 }
			 else
			 {
			 	 $get_all_tour=$this->db->query("SELECT count(id) as total_tour FROM `escort_tour` WHERE escort_id='".$escort_id."' AND `ture_status` IN ('Running','Pending')")->row_array();	
			 	 	$set_total_tour=@$get_all_tour["total_tour"];
			 }

             if(@$this->input->post("set_package_tour_limit")=="unlimited")
            {
                $insert_tour_set=true;
            } 
            else
            {
            	if($set_total_tour<@$this->input->post("set_package_tour_limit"))
            	{
                   $insert_tour_set=true;
            	}
            	else
            	{
            		 $insert_tour_set=false;
            	}
            }	
        

        	if(@$this->input->post("tour")["end_tour"] &&  @$this->input->post("tour")["start_tour"] && @$this->input->post("tour")["place"])
        	{
        		// var_dump($this->input->post("tour"));
        	$start_date_in_string=strtotime(@$this->input->post("tour")["start_tour"]);
        	$end_date_in_string=strtotime(@$this->input->post("tour")["end_tour"]);
            $ture_data["escort_id"]=$escort_id;
            $ture_data["place"]=@$this->input->post("tour")["place"];
            $ture_data["from_date"]=@$this->input->post("tour")["start_tour"];
            $ture_data["from_date_in_string"]=$start_date_in_string;
            $ture_data["to_date"]=@$this->input->post("tour")["end_tour"];
            $ture_data["to_date_in_string"]=$end_date_in_string;
             
             if(strtotime(@$this->input->post("tour")["start_tour"])<=strtotime(@date("d-M-Y")))
             {
             	$ture_data["ture_status"]="Running";
             }
             else
             {
             	$ture_data["ture_status"]="Pending";
             }
            
             if($insert_tour_set)
             {
             	$ture_data["last_update"]=date("d-M-Y");  
            $check_data_res_tour=$this->db->query("select * from escort_tour where escort_id='".$escort_id."' and (ture_status='Running' or ture_status='Pending') and to_date_in_string>=".$start_date_in_string." and from_date_in_string<=".$end_date_in_string)->result_array();

              if($check_data_res_tour)
              {
              
              $this->session->set_flashdata('fail',"Your Tour is already exist for given time period. ");
              }
              else
              {
              	 $this->db->insert("escort_tour", $ture_data);
              $this->session->set_flashdata('message',"Profile is Updated.");
              } 
             }
             
             // var_dump($this->db->last_query());
        	}
        	else
        	{
        		 $this->session->set_flashdata('fail',"All fields are required for tour.");
        	}	
        	
        }


if(@$this->input->post("escort_rate")["type"] ||  @$this->input->post("escort_rate")["duration"] || @$this->input->post("escort_rate")["price"] || @$this->input->post("escort_rate")["information"])
        {
        	if(@$this->input->post("escort_rate")["type"] &&  @$this->input->post("escort_rate")["duration"] && @$this->input->post("escort_rate")["price"] && @$this->input->post("escort_rate")["information"])
        	{
        		// var_dump($this->input->post("tour"));
        	
            $escort_rate["escort_id"]=$escort_id;
            $escort_rate["call_type"]=@$this->input->post("escort_rate")["type"];
            $escort_rate["duration"]=@$this->input->post("escort_rate")["duration"];
            $escort_rate["price"]=@$this->input->post("escort_rate")["price"];
            $escort_rate["information"]=@$this->input->post("escort_rate")["information"];
            $escort_rate["date"]=date('d-M-y');
              
             $this->db->insert("escort_rate", $escort_rate);
              $this->session->set_flashdata('message',"Profile is Updated.");
             // var_dump($this->db->last_query());
        	}
        	else
        	{
        		 $this->session->set_flashdata('fail',"All fields are required for Rates.");
        	}	
        	
        }
 
 

      var_dump($escort_id);
 if(@$this->input->post("redirect_url"))
 {
 	redirect(base_url()."".@$this->input->post("redirect_url")."/".@$escort_id."/".implode("-", explode(" ", $this->input->post("user_lofin")["name"])));
 }
 else
 {

 	redirect(base_url().strtolower($types)."-profile/".$escort_id."/".implode("-", explode(" ", $this->input->post("user_lofin")["name"])));
 }

   

}



 function encryptor($action, $string) {

    $output = false;



    $encrypt_method = "AES-256-CBC";

    //pls set your unique hashing key

    $secret_key = 'muni';

    $secret_iv = 'muni123';



    // hash

    $key = hash('sha256', $secret_key);

    

    // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning

    $iv = substr(hash('sha256', $secret_iv), 0, 16);



    //do the encyption given text/string/number

    if( $action == 'encrypt' ) {

        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);

        $output = base64_encode($output);

    }

    else if( $action == 'decrypt' ){

      //decrypt the given text/string/number

        $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);

    }



    return $output;

}     


public function add_social_link()
{
	// var_dump($this->input->post());
	$page_name=$this->input->post("page_name");
	$user_id=$this->input->post("user_id");
	$user_name=$this->input->post("user_name");
	$set_data["user_id"]=@$user_id;
	$set_data["facebook"]=@$this->input->post("facebook");
	$set_data["instagram"]=@$this->input->post("instagram");
	$set_data["twitter"]=@$this->input->post("twitter");
	$set_data["skype"]=@$this->input->post("skype");
	$set_data["direct_link"]=@$this->input->post("direct_link");
	$this->user_panel_model->set_social_link($set_data);
	$this->session->set_flashdata("message","Social link is updated.");

	redirect(base_url()."".$page_name."/".$user_id."/".$user_name);
} 


public function edit_user($id,$title='')
{

$this->user_panel_model->update_tour_info_of_escort($id);

$user_data=$this->db->query("select a.*,(select escort_info.agency_id from escort_info where escort_info.escort_id='".$id."') as agency_id from user_login as a where a.USERID='".$id."'")->row_array();
$this->data["login_user"]=$user_data;
$this->data["social_link"]=$this->db->query("select * from social_login where user_id='".$id."'")->row_array();
$escort_info=$this->db->query("select * from escort_info where escort_id='".$id."'")->row_array();
$this->data["escort_info"]=$escort_info;


$this->data["gallery_image"]=$this->db->query("select * from gallery_image where user_id='".$id."' ORDER BY id DESC")->result_array();



	$query = $this->db->query("select * from system_settings WHERE status = 1");

		$result = $query->result_array();

		$this->email_tittle='Gigs';

		if(!empty($result))

		{

		foreach($result as $data){



		if($data['key'] == 'site_name' ||  $data['key'] == 'website_name'){

		$this->site_name = $data['value'];

		$this->data['site_name'] =$this->site_name;

		}

		}

		}

		if($this->session->userdata('SESSION_USER_ID'))

		{

			$this->data['page_title'] = $user_data["types"]."-".$this->site_name;

			$this->data['page'] = 'index';
            $this->data['state']= $this->db->query("SELECT * FROM `location` WHERE `country` LIKE 'Australia' GROUP BY state ORDER BY `location`.`state` ASC")->result_array();

          $this->data['drop_down']=$this->db->query("select * from dropdown where status='0'")->result_array();
 $this->data["my_escort"]=$this->db->query("select * from escort_info where escort_id!='".$this->session->userdata('SESSION_USER_ID')."' and agency_id='".$this->session->userdata('SESSION_USER_ID')."'")->result_array();
			
    $this->data['escort_services']=$this->db->query("SELECT * FROM `services_of_eacort` where status='0' ORDER BY `services_of_eacort`.`name` ASC")->result_array();

$this->data['escort_services_prefer']=$this->db->query("select * from escort_think_prefer where escort_id='".$id."'")->row_array();

;
 $this->data['escort_availability']=$this->db->query("SELECT * FROM `escort_availability` where escort_id='".$id."' and packeg_finish_date_string >='".strtotime(date('d-m-Y'))."'")->row_array();

	$this->data['citys']=$this->db->query("SELECT * FROM `location` ORDER BY `state` ASC")->result_array();
		


$this->data["escort_tour"]=$this->db->query("select * from escort_tour where escort_id='".$id."' ORDER BY `escort_tour`.`id` DESC")->result_array();

$this->data["escort_rates"]=$this->db->query("select * from escort_rate where escort_id='".$id."' ORDER BY `escort_rate`.`id` DESC")->result_array();
$this->data["get_my_members"]=$this->db->query("select a.payment_id,a.start_date,a.end_date,b.package_id,b.item_amount,b.created_at ,c.name from user_login as a, payments as b,membership as c where c.id=b.package_id and b.id=a.payment_id and a.USERID='".$id."'")->row_array();

$this->data["get_my_membership_log"]=$this->db->query("select a.id,a.item_amount,a.created_at_date,a.package_fininish_date,(select membership.name from membership where membership.id=a.package_id) as package_name from payments as a where a.USERID='".$id."'")->result_array();
$this->load->model('gigs_model');

$this->data['services_name_for_package']=$this->gigs_model->get_all_services_of_price_table($this->data["login_user"]["types"]);
			

 if($escort_info["agency_id"])
 {
 	$get_escort_id_of_agency_id=$this->db->query("select a.escort_id from escort_info as a,user_login as b where b.status='0'and a.escort_id=b.USERID and a.escort_id!='".$escort_info["agency_id"]."' and a.agency_id='".$escort_info["agency_id"]."'")->result_array();

 	// var_dump($get_escort_id_of_agency_id);
 	 $set_all_escort_id=[];
 	 if(@$get_escort_id_of_agency_id)
 	 {
 	 	foreach(@$get_escort_id_of_agency_id as $esc_id)
 	 	{
 	 		array_push($set_all_escort_id, $esc_id["escort_id"]);
 	 	}

 	   $get_all_tour=$this->db->query("SELECT count(id) as total_tour FROM `escort_tour` WHERE `escort_id` IN (".implode(",",$set_all_escort_id).") AND `ture_status` IN ('Running','Pending')")->row_array();	
 	 	$set_total_tour=$get_all_tour["total_tour"];
 	 }
 	 else
 	 {
 	 	$set_total_tour=0;
 	 }
 }
 else
 {
 	 $get_all_tour=$this->db->query("SELECT count(id) as total_tour FROM `escort_tour` WHERE escort_id='".$id."' AND `ture_status` IN ('Running','Pending')")->row_array();	
 	 	$set_total_tour=@$get_all_tour["total_tour"];
 }

 $this->data['total_toure_of_this_user']=@$set_total_tour;


			$this->load->vars($this->data); 
			$this->load->view($this->data['theme'].'/template');

		}

		else

		{

			redirect(base_url());

		}
}


public function delete_escort_info()
{
	$id=$this->input->post("id");
	$table_name=$this->input->post("table_name");

	$this->db->where(array("id"=>@$id));
    $this->db->delete($table_name);
	


}


    public function index()

    {   
    	$this->data["login_user"]=$this->db->query("select * from user_login where USERID='".$this->session->userdata('SESSION_USER_ID')."'")->row_array();

	 	$query = $this->db->query("select * from system_settings WHERE status = 1");

		$result = $query->result_array();

		$this->email_tittle='Gigs';

		if(!empty($result))

		{

		foreach($result as $data){



		if($data['key'] == 'site_name' ||  $data['key'] == 'website_name'){

		$this->site_name = $data['value'];

		$this->data['site_name'] =$this->site_name;

		}

		}

		}

		if($this->session->userdata('SESSION_USER_ID'))

		{

			$this->data['page_title'] = "User-Profile"."-".$this->site_name;

			$this->data['page'] = 'add_escort';
            $this->data['state']= $this->db->query("SELECT * FROM `location` WHERE `country` LIKE 'Australia' GROUP BY state ORDER BY `location`.`state` ASC")->result_array();

          $this->data['drop_down']=$this->db->query("select * from dropdown where status='0'")->result_array();

          


			$this->load->vars($this->data);
         
          
			$this->load->view($this->data['theme'].'/template');

		}

		else

		{

			redirect(base_url());

		}

    }

    

    public function add_gigs()

    {     

    	

       if($this->input->post('form_submit'))

       {		

		$gig_tags = ucfirst($this->input->post('gig_tags'));	   

		if(!empty($gig_tags))

		{

			$data['gig_tags'] = $gig_tags;

		}				   

       $data['user_id'] = $this->session->userdata('SESSION_USER_ID');

       $title =  strtolower($this->input->post('gig_title'));

       $data['title'] = url_title($title,'-');

       $data['gig_price'] = $this->input->post('gig_price');   

       $data['time_zone'] = $time_zone = $this->session->userdata('time_zone');

       $data['delivering_time'] = $this->input->post('delivering_time');

       $data['category_id'] = $this->input->post('gig_category_id');

      

       $data['gig_details'] = ucfirst($this->input->post('gig_details'));  

        

       $super_fast_charges = $this->input->post('super_fast_charges');

       $super_fast_delivery = $this->input->post('super_fast_delivery'); 

       $super_fast_delivery_date = $this->input->post('super_fast_delivery_date');

       if(!empty($super_fast_delivery))

       {

       $data['super_fast_charges'] = $this->input->post('super_fast_charges');

       $data['super_fast_delivery'] = $this->input->post('super_fast_delivery'); 

	   $data['super_fast_delivery_desc'] = ucfirst($this->input->post('super_fast_delivery_desc')); 

       $data['super_fast_delivery_date'] = $this->input->post('super_fast_delivery_date');

       }    

       

       $data['work_option'] = $this->input->post('work_option');

       $data['requirements'] = ucfirst($this->input->post('requirements'));    

       $data['country_name'] = $this->input->post('full_country_name');    

       $country_name = $this->session->userdata('country_name');      	                             

       if($country_name=='IN')

       {

       $data['currency_type'] = 1;    

       }

       else 

       {

       $data['currency_type'] = 2;    

       } 

	   date_default_timezone_set($time_zone);

	   $current_time= date('Y-m-d H:i:s');

	   

	   $data['created_date']      = $current_time;   

	   $data['youtube_url']  	  = $this->input->post('youtube_url');

	   $data['vimeo_url']   	  = $this->input->post('vimeo_url');

   	   $data['vimeo_video_id']    = $this->input->post('vimeo_video_id');

   	   $data['status']   = 1; // 0 - Active , 1 - Inactive 

   	   $data['currency_type'] = $this->data['currency_option'];

   	   $this->db->select('value');
   	   $this->db->where('key', 'price_option');
   	   $price_by = $this->db->get('system_settings')->row_array();
   	   $cost_type = ($price_by['value'] == 'dynamic')?1:0;	
   	   $data['cost_type'] = $cost_type;

       if($this->db->insert('sell_gigs',$data))

       { 

       

	   

	   $gigs_id = $this->db->insert_id();  

	   $this->session->set_flashdata('message',"Package added successfully.package will be shown in your account after 'admin approval.");
       /*$this->session->set_userdata('message','Gig added successfully, once get admin approval gigs will be shown in buy service page.');*/
 

              

       $images = $this->input->post('image_array');    

       $videos = $this->input->post('video_array'); 

	                    

       $images =  explode(',',$images);                                       

       $videos =  explode(',',$videos);                                       

       for($i=0;$i<sizeof($images);$i++)

       {

       $data1['gig_id'] = $gigs_id;

       $data1['image_path'] = 'uploads/gig_images/680_460_'.$images[$i];

	   $data1['gig_image_thumb'] = 'uploads/gig_images/50_34_'.$images[$i];

	   $data1['gig_image_tile'] = 'uploads/gig_images/100_68_'.$images[$i];

	   $data1['gig_image_medium'] = 'uploads/gig_images/240_162_'.$images[$i];

       $this->db->insert('gigs_image',$data1);

	    

       }

	   $videos   = array_filter($videos);

	   if(!empty($videos)){

       for($i=0;$i<sizeof($videos);$i++)

       {

       $data2['gig_id'] = $gigs_id;

       $data2['video_path'] = 'uploads/gigs_videos/'.$videos[$i];

       $this->db->insert('gigs_video',$data2);

	    

       }                                

	   }

       $extra_gigs = $this->input->post('extra_gigs');

       if(!empty($extra_gigs)){

       $extra_gigs = array_filter($extra_gigs);

	   }

    

       if(!empty($extra_gigs))

       {

       $data3['extra_gigs'] 		 = $this->input->post('extra_gigs');

       $data3['extra_gigs_delivery'] = $this->input->post('extra_gigs_delivery');  

       $data3['extra_gigs_amount']   = $this->input->post('extra_gigs_amount');  

    

       for($i=0;$i<sizeof($data3['extra_gigs']);$i++)

       {

		   if($data3['extra_gigs'][$i]!='')

		   {

       $data4['gigs_id'] = $gigs_id;

       $data4['extra_gigs'] = $data3['extra_gigs'][$i];

	   $data4['currency_type'] = $data['currency_type'];

       $data4['extra_gigs_amount'] = $data3['extra_gigs_amount'][$i];

       $data4['extra_gigs_delivery'] = $data3['extra_gigs_delivery'][$i];               

       $this->db->insert('extra_gigs',$data4);  

  		$this->session->set_flashdata('message','The packages have been added to getting the admin approval. After admin approval, the packages have been listed.');

		   }

       }

       }

		redirect(base_url()."sell-service"); 


	   

       // redirect(base_url().'gig-preview/'.$data['title']);

       }

       }

	}

   	public function image_resize($width=0,$height=0,$image_url,$filename)

	{          

		$source_path = $image_url;

		list($source_width, $source_height, $source_type) = getimagesize($source_path);

		switch ($source_type) {

			case IMAGETYPE_GIF:

				$source_gdim = imagecreatefromgif($source_path);

				break;

			case IMAGETYPE_JPEG:

				$source_gdim = imagecreatefromjpeg($source_path);

				break;

			case IMAGETYPE_PNG:

				$source_gdim = imagecreatefrompng($source_path);

				break;

		}

		$source_aspect_ratio = $source_width / $source_height;

		 

		 $desired_aspect_ratio = $width / $height; 

		

		if ($source_aspect_ratio > $desired_aspect_ratio) {

			/*

			 * Triggered when source image is wider

			 */

			 

			$temp_height = $height;

			$temp_width = ( int ) ($height * $source_aspect_ratio);

		} else {

			/*

			 * Triggered otherwise (i.e. source image is similar or taller)

			 */

			$temp_width = $width;

			$temp_height = ( int ) ($width / $source_aspect_ratio);

		}

		

		/*

		 * Resize the image into a temporary GD image

		 */

		$temp_gdim = imagecreatetruecolor($temp_width, $temp_height);

		imagecopyresampled(

			$temp_gdim,

			$source_gdim,

			0, 0,

			0, 0,

			$temp_width, $temp_height,

			$source_width, $source_height

		);

		

		/*

		 * Copy cropped region from temporary image into the desired GD image

		 */

		

		$x0 = ($temp_width - $width) / 2;

		$y0 = ($temp_height - $height) / 2;

		$desired_gdim = imagecreatetruecolor($width, $height);

		imagecopy(

			$desired_gdim,

			$temp_gdim,

			0, 0,

			$x0, $y0,

			$width, $height

		);

		

		/*

		 * Render the image

		 * Alternatively, you can save the image in file-system or database

		 */

		//$filename_without_extension =  preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);

		 

		   $image_url =  "uploads/gig_images/".$width."_".$height."_".$filename."";    

		imagepng($desired_gdim,$image_url);

		

		return $image_url;

		

		/*

		 * Add clean-up code here

		 */

	}

	public function file_upload()

	{

		$file_type = $this->input->post('file_type');                                

		$form_data = $_FILES['gig_files']['name'];

		$row_id = $this->input->post('row_id');                                

		if (isset($_FILES['gig_files']['name']) && !empty($_FILES['gig_files']['name'])) {              

				$html ='';

				$uploaded_file_name = $_FILES['gig_files']['name'];               

				$uploaded_file_name_arr = explode('.', $uploaded_file_name);

				$filename = isset($uploaded_file_name_arr[0]) ? $uploaded_file_name_arr[0] : '';

				$filename = time().$filename;

				$this->load->library('common');

				if($file_type=='image')

				{

				$upload_sts = $this->common->global_file_upload('uploads/gig_images/', 'gig_files', $filename);              

				}

				else if($file_type=='video')

				{

				 $upload_sts = $this->common->global_file_upload('uploads/gigs_videos/', 'gig_files', $filename);                  

				}

				$uploaded_files = array();

				if (isset($upload_sts['success']) && $upload_sts['success'] == 'y') {                

				//	print_r($upload_sts);

				$uploaded_file_name = $upload_sts['data']['file_name'];                                    

				if(isset($upload_sts['data']['file_ext'])&&trim($upload_sts['data']['file_ext'])==".mp4")

				{

					// print_r($upload_sts);

					// $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

					//print_r($_SERVER);

					$file = FCPATH.'uploads/gigs_videos/'.$upload_sts['data']['file_name'];

					$newfile = FCPATH.'uploads/gigs_videos/'.$upload_sts['data']['raw_name'].".ogg";

					copy($file, $newfile);



				}

				$file_name = $uploaded_file_name;              

				$uploaded_files[] = $file_name;

				if($file_type=='image')

				{

				//$file_path =   base_url().'uploads/gig_images/'.$file_name;

				//$this->image_resize(50,34,$file_path,$file_name);

				//$this->image_resize(100,68,$file_path,$file_name);

				//$this->image_resize(680,460,$file_path,$file_name);

				}

				else if($file_type=='video')

				{

				$file_path =   base_url().'uploads/gigs_videos/'.$file_name;

				}

				

				$row_id = $row_id+1; 

				

				if($file_type=='image')

				{   

				$html = "<div id=\"remove_image_div_$row_id\" class=\"uploaded-img\"> "

				. "<img  height='100px' width='100px' class=\"imageThumb\" src=\"" .$file_path. "\" title=\"".$file_name. "\"/>" .

				"<a onclick=\"remove_files('$file_name','$row_id','image')\"  href=\"javascript:;\" class=\"uploaded-remove pull-right\">

				<i class=\"fa fa-times\"></i>

				</a></div>";           

				}

				else if($file_type=='video')

				{

				$html = " <div id=\"remove_video_div_$row_id\" class=\"uploaded-img\"> "

						. "<video  class=\"img-responsive\"  style=\"height:100px !important; \">"

						. "<source  src=\"" .$file_path. "\"; type=\"video/mp4\" codecs=\"avc1.4D401E, mp4a.40.2\">"

						. "<source  src=\"" .$file_path. "\"; type=\'video/webm; codecs=\"vp8.0, vorbis\"'>"

						. "<source  src=\"" .$file_path. "\";type='video/ogg; codecs=\"theora, vorbis\"'>"

						. "<source  src=\"" .$file_path. "\";type='video/mp4; codecs=\"avc1.4D401E, mp4a.40.2\"'>    </video>  "                   

						."<a href=\"javascript:;\"  onclick=\"remove_files('$file_name','$row_id','video')\"  class=\"uploaded-remove pull-right\"><i class=\"fa fa-times\"></i></a></div>";           

				}           

				}            

				echo json_encode(array('html'=>$html,'sub_html'=>$uploaded_files,'row_id'=>$row_id));           

				}                     

	} 



	public function delete_uploaded_file()

	{

		$file_name = $this->input->post('filename');

		$file_type = $this->input->post('file_type');

		

		 if($file_type=='image')

				{

				$file_path =  FCPATH.'uploads/gig_images/'.$file_name;

				}

				else if($file_type=='video')

				{

				 $file_path = FCPATH.'uploads/gigs_videos/'.$file_name;

				}            

				$html = '';

		if(unlink ($file_path))

		{

		$html = 1;

		}

		echo json_encode(array('html'=>$html,'sub_html'=>$file_name));

	}

	public function update_gig_detail()

	{

			$id = $this->input->post('id');

			$file_name = $this->input->post('filename');

			$file_type = $this->input->post('file_type');

			$new_file_name = explode("/",$file_name);	

			 if($file_type=='image')

					{

					$file_path =  FCPATH.'uploads/gig_images/'.$new_file_name[2];

					$this->db->where('id',$id);

					$this->db->delete('gigs_image');

					$html = 1;

					}

					else if($file_type=='video')

					{

					$file_path = FCPATH.'uploads/gigs_videos/'.$new_file_name[2];

					$this->db->where('id',$id);

					$this->db->delete('gigs_video');

					$html = 1;

					}            

					$html = '';

			if(unlink ($file_path))

			{

			$html = 1;			

			}

			echo json_encode(array('html'=>$html,'sub_html'=>$new_file_name[2]));

    }



	public function prf_crop() 

	{ 

 			ini_set('max_execution_time', 3000); 

  			ini_set('memory_limit', '-1');

			$html=$error_msg= $shop_ad_id='';

			$error_sts=0;

			$row_id = $this->input->post('select_row_id');					

			$image_data = $this->input->post('img_data');

 

				$base64string = str_replace('data:image/png;base64,', '', $image_data);

				$base64string = str_replace(' ', '+', $base64string);

				$data = base64_decode($base64string);

				$img_name = time();

				$file_name_final='gig_'.$img_name.".png";

				$img_name2 = "680_460_".$file_name_final; 

				file_put_contents('uploads/gig_images/'.$img_name2, $data); 

				

				//$imageFileType= 'png';

				//$rawname='gig_'.$img_name;

				$source_image= 'uploads/gig_images/'.$img_name2; 

				$blog_themb = $this->image_resize(100,68,$source_image,$file_name_final);

				$blog_themb_one = $this->image_resize(50,34,$source_image,$file_name_final);

				$gigs_medium = $this->image_resize(240,162,$source_image,$file_name_final);

			 

			  $html = "<div id=\"remove_image_div_$row_id\" class=\"uploaded-img\"> "

					. "<img  height='68' width='100' class=\"imageThumb\" src=\"" .base_url().$blog_themb . "\" title=\"".$blog_themb. "\"/>" .

					"<a onclick=\"remove_files('$img_name2','$row_id','image')\"  href=\"javascript:;\" class=\"uploaded-remove pull-right\">

					<i class=\"fa fa-times\"></i>

					</a></div>"; 

					

		    $row_id = $row_id+1;

		    $response = array(

								'state'  => 200,

								'message' => $error_msg,

								'result' => $html,

								'row_id' => $row_id,

								'sub_html' => $file_name_final,

								'sts' => $error_sts

		    );

  		    echo json_encode($response); 

	}

	public function prf_crop_call($image_name,$av_data,$new_name,$t_width,$t_height) { 

  			$path              = 'uploads/gig_images/'; 

   			$w                 = $av_data['width'];

			$h                 = $av_data['height'];

			$x1                = $av_data['x'];

			$y1                = $av_data['y'];

 			list($imagewidth, $imageheight, $imageType) = getimagesize('uploads/gig_images/'.$image_name);

			$imageType                                  = image_type_to_mime_type($imageType);

 			$ratio             = ($t_width/$w); 

			$ratio_one         = ($t_height/$h);

			$nw                = ceil($w * $ratio);

			$nh                = ceil($h * $ratio_one);  

			$newImage          = imagecreatetruecolor($nw,$nh);

			switch($imageType) {

				case "image/gif"  : $source = imagecreatefromgif('uploads/gig_images/'.$image_name); 

									break;

				case "image/pjpeg":

				case "image/jpeg" :

				case "image/jpg"  : $source = imagecreatefromjpeg('uploads/gig_images/'.$image_name); 

									break;

				case "image/png"  :

				case "image/x-png": $source = imagecreatefrompng('uploads/gig_images/'.$image_name); 

									break;

			} 

			imagecopyresampled($newImage,$source,0,0,$x1,$y1,$nw,$nh,$w,$h);

			switch($imageType) {

				case "image/gif"  : imagegif($newImage,$path.$new_name); 

									break;

				case "image/pjpeg":

				case "image/jpeg" :

				case "image/jpg"  : imagejpeg($newImage,$path.$new_name,100); 

									break;

				case "image/png"  :

				case "image/x-png": imagepng($newImage,$path.$new_name);  

									break;

			} 

 	} 

	

	public function you_tube_links()

	{

			$youtube_url = $this->input->post('youtube_url');

		    $result 	 = preg_match_all('~https?://(?:[0-9A-Z-]+\.)?(?:youtu\.be/|youtube(?:-nocookie)?\.com\S*[^\w\s-])([\w-]{11})(?=[^\w-]|$)(?![?=&+%\w.-]*(?:[\'"][^<>]*>|</a>))[?=&+%\w.-]*~ix', $youtube_url, $matchs);

               

             if($result>0)

               {              

               foreach($matchs as $key => $vals)

                        {                                   

                   if (filter_var($vals[0], FILTER_VALIDATE_URL) === false) {

                       $url = $vals[0] ;

                       break;

                   }                      

                        } 

$width = '200px';

$height = '100px';

 $html = " <div id=\"remove_youtube_div\" class=\"uploaded-img\"> "

		.'<iframe width="'.$width.'" height="'.$height.'" src="https://www.youtube.com/embed/'.$url.'" frameborder="0" allowfullscreen></iframe>'		                   

						."<a  onclick=\"remove_third_party_link('remove_youtube_div')\" href=\"javascript:;\"  class=\"uploaded-remove pull-right\"><i class=\"fa fa-times\"></i></a></div>";   

  						

						

 echo $html;

			   }

	}

	

		public function vimeo_links()

	{

			$vimeo_url = $this->input->post('vimeo_video_id');		    

			$width	   = '200px';

			$height    = '100px';



	$html = " <div id=\"remove_vimeo_div\" class=\"uploaded-img\"> "

. "<iframe src=\"//player.vimeo.com/video/$vimeo_url?portrait=0&color=333\" width=\"$width\" height=\"$height\" frameborder=\"0\" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>"

						."<a  onclick=\"remove_third_party_link('remove_vimeo_div')\" href=\"javascript:;\"  class=\"uploaded-remove pull-right\"><i class=\"fa fa-times\"></i></a></div>";  						

						

 echo $html;

			  

	}



}

?>