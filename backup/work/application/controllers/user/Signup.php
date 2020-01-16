<?php defined('BASEPATH') OR exit('No direct script access allowed');
class Signup extends CI_Controller
{
  public function __construct() {

        parent::__construct();   

        $this->load->library('encrypt');
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
        //  $geo = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=$user_ip"));              

        // $geoplugin_latitude = $geo["geoplugin_latitude"];   

        // $geoplugin_longitude = $geo["geoplugin_longitude"];

        $geoplugin_latitude = '23.2667';   

        $geoplugin_longitude = '77.4126';

        $t=time();

         $result = $this->getTimezoneGeo($geoplugin_latitude,$geoplugin_longitude,$t);
         $this->data['time_zone'] = $result;   
        $this->data['theme'] = 'user';

        $this->data['module'] = 'dashboard';

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

        $this->data['recent_gigs'] = $this->gigs_model->recent_gigs();

       // $this->data['latest_gigs'] = $this->gigs_model->latest_gigs();

        $this->data['gig_price'] = $this->gigs_model->gig_price();

        $this->data['extra_gig_price'] = $this->gigs_model->gig_price();

		 $this->data['logo'] = $this->user_panel_model->get_logo();  

        $this->data['slogan'] = $this->user_panel_model->get_slogan();
        $this->load->model('user_panel_model');

        $this->data['country_list'] = $this->user_panel_model->country_list();
        $this->data['state_list'] = $this->user_panel_model->state_list();


    }

	public function index(){
// var_dump($this->session->userdata());
if(@$this->session->userdata("SESSION_USER_ID")!="")
{
  redirect(base_url());
}

  if($this->uri->segment("4"))
  {
   
    $this->session->set_flashdata("pass2","Account");
  }


       if($this->input->post())
       {
        
              $username = implode("_",explode(" ",$this->input->post('displayname'))).'_'.strtotime(date('Y-m-d H:i:s')); 
               $result = $this->user_panel_model->check_username($username);     
            if ($result > 0) {

                       $this->session->set_flashdata("fail","Username is already taken"); 
                       // redirect(base_url()."/signup");
                       // $isAvailable = FALSE;

               } else {

                   $email = $this->input->post('email');   

       

                        $result = $this->user_panel_model->check_email($email);       

                        if ($result > 0) {

                                   $this->session->set_flashdata("fail","Email is already taken"); 

                           } else {

                                    
                                    // $phone = $this->input->post('phone');   
                                    //     $result = $this->user_panel_model->check_phone($phone);  
                            $result=0;
                                    if ($result > 0) {
                                              $this->session->set_flashdata("fail","Number is already taken");
                                       } else {
                                               
                         $data['fullname']         = $this->input->post('displayname');

                                             $data['email']           = $this->input->post('email');
                                              // $data['phone']   = $this->input->post('phone');
                                              $data['password']        = md5($this->input->post('rep_password'));

                                               $data['username']        = $username;
                                                $data['types']     = $this->input->post('types');


                                               $data['country']         = 13;

                                               // $data['state']       = $this->input->post('state_id');

                                               $data['user_timezone']   = $this->data['time_zone'];
                                               
                                               date_default_timezone_set($data['user_timezone']);

                                               $data['created_date']    = date('Y-m-d H:i:s') ;
                                               $data['created_date_in_string']    = strtotime(date('d-M-Y')) ;
                                               
                                               // $data['lname']   = ucfirst($this->input->post('lname'));
                                               
                                              
                                               
                                      $username =  $data['username'];       


       $url_encypted = urlencode($this->encryptor('encrypt',$username));

        $data['username_code'] = $url_encypted; 
        
                                               
                                               $data['verified'] = 1;

                                               $data['status'] = 1;

                                    
                                    $res=$this->db->insert('user_login',$data);
                                  
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

        $body = str_replace('{USER_NAME}', $data['fullname'], $body);

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
         
                                         
                                     // redirect(base_url()."signup");


                                                }
                           }

               }

       } 
       $this->data['list'] = $this->user_panel_model->membership();  
       $this->data['page_title'] = "Signup-".$this->site_name;  
       // var_dump($this->data['list']);
		$this->load->model('signup_model');
			$this->load->vars($this->data);    

	$this->load->view($this->data['theme'] . '/signup');
			
		// $this->load->view('user/signup');
	}




  public function user_login(){
// var_dump($this->session->userdata());
if(@$this->session->userdata("SESSION_USER_ID")!="")
{
  redirect(base_url());
}

    $this->load->model('signup_model');
      $this->load->vars($this->data);    
   
$this->data["page_title"]="Login-".$this->site_name;

$this->load->vars($this->data);   
  $this->load->view($this->data['theme'] . '/login');
      
    // $this->load->view('user/signup');
  }



 function getTimezoneGeo($geoplugin_latitude, $geoplugin_longitude,$t) {

    $json = file_get_contents("https://maps.googleapis.com/maps/api/timezone/json?location=$geoplugin_latitude,$geoplugin_longitude&timestamp=$t&key=AIzaSyCrF-ZcLpYjLO7ygnisZJk_eHogmlzawwE ");     

    $data = json_decode($json,true);  

    $tzone=$data['timeZoneId'];      

    return $tzone;

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



}	
?>
