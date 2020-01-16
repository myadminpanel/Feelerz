<?php

class Gigs extends CI_Controller{

  public function __construct() {

    parent::__construct();

    $this->load->helper('currency');

    $this->data['title']          = 'Gigs';

    $this->data['theme']          = 'user';

    $this->data['module']         = 'gigs';

    $this->load->model('user_panel_model');

    $this->load->model('notification_model');

    $this->load->model('gigs_model');
   
    $this->data['time_zone'] = "Asia/Calcutta"; 

    $this->load->helper('favourites');
    $this->data['country_list'] = $this->user_panel_model->country_list();
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

    $this->data['currency_option'] = 'USD';

    /***********************Stripe API Key and Secret Key  ***************************/

    $this->data['secret_key'] = '';

    $this->data['publishable_key'] = '';

    

    $publishable_key =  '';

    $secret_key =  '';

    $live_publishable_key =  '';

    $live_secret_key =  '';

    $stripe_option = '';



   /***********************Stripe API Key and Secret Key  ***************************/



   /***********************Amplifypay API Key and Secret Key  ***************************/



   $this->data['amplify_api_key']     = '';

   $this->data['amplify_secret_key']  = '';

   $this->data['paypal_allow']        = '';

   $this->data['stripe_allow']        = '';



   $demo_amplify_api_key    = '';

   $demo_amplify_secret_key = '';

   $live_amplify_api_key    = '';

   $live_amplify_secret_key = '';

   $amplifypay_option       = '';



   /***********************Amplifypay API Key and Secret Key  ***************************/



   if(!empty($common_settings))

    {

      foreach($common_settings as $datas){
        if($datas['key'] == 'paypal_allow'){

          $this->data['paypal_allow'] = $datas['value'];

        }

        if($datas['key'] == 'stripe_allow'){

          $this->data['stripe_allow'] = $datas['value'];

        }
         if($datas['key'] == 'secret_key'){

          $secret_key = $datas['value'];

        }

        if($datas['key'] == 'publishable_key'){

          $publishable_key = $datas['value'];

        }

        if($datas['key'] == 'live_secret_key'){

          $live_secret_key = $datas['value'];

        }

        if($datas['key'] == 'live_publishable_key'){

          $live_publishable_key = $datas['value'];

        }

        if($datas['key'] == 'stripe_option'){

          $stripe_option = $datas['value'];

        }

        if($datas['key'] == 'amplifypay_option'){

          $amplifypay_option = $datas['value'];

        }if($datas['key'] == 'amplifypay_api_key'){

          $demo_amplify_api_key = $datas['value'];

        }

        if($datas['key'] == 'amplifypay_merchant_id'){

          $demo_amplify_secret_key = $datas['value'];

        }



        if($datas['key'] == 'live_amplifypay_api_key'){

          $live_amplify_api_key = $datas['value'];

        }

        if($datas['key'] == 'live_amplifypay_merchant_id'){

          $live_amplify_secret_key = $datas['value'];

        }
        if($datas['key']=='currency_option'){

         $this->data['currency_option'] =$datas['value'];

        }
      }

      if($stripe_option == 1){

        $this->data['publishable_key'] = $publishable_key;

        $this->data['secret_key']      = $secret_key;

      }

      if($stripe_option == 2){

        $this->data['publishable_key'] = $live_publishable_key;

        $this->data['secret_key']      = $live_secret_key;

      }

      if($amplifypay_option == 1){

       $this->data['amplify_api_key']     = $demo_amplify_api_key;

       $this->data['amplify_secret_key']  = $demo_amplify_secret_key;

      }

      if($amplifypay_option == 2){

        $this->data['amplify_api_key']     = $live_amplify_api_key;

        $this->data['amplify_secret_key']  = $live_amplify_secret_key;

      }

    }


    $this->data['client_list']              = $this->user_panel_model->get_client_list();

    $this->data['categories_subcategories'] = $this->user_panel_model->categories_subcategories();

    $this->data['logo']                     = $this->user_panel_model->get_logo();

    $this->data['slogan']                   = $this->user_panel_model->get_slogan();

    $this->data['footer_main_menu']         = $this->user_panel_model->footer_main_menu();

    $this->data['footer_sub_menu']          = $this->user_panel_model->footer_sub_menu();

    $this->data['system_setting']           = $this->user_panel_model->system_setting();

    $this->data['policy_setting']           = $this->user_panel_model->policy_setting();

    //$this->data['rupee_dollar_rate']        = $this->user_panel_model->get_rupee_dollar_rate();


    $this->data['country_list']       = $this->user_panel_model->country_list();

    //$rupee_dollar_rate            = $this->data['rupee_dollar_rate'];

    $this->data['gig_price']       = $this->gigs_model->gig_price();

    $this->data['extra_gig_price'] = $this->gigs_model->extra_gig_price();

    $this->data['price_option']    = $this->gigs_model->get_setting_price_option();



    $user_id = $this->session->userdata('SESSION_USER_ID');





    if($user_id!=''){

        $settings   = $this->gigs_model->settings();

        if(!empty($settings)){

          foreach ($settings as $key => $value) {

                $this->data[$key] = $value;

          }

        }

      $this->data['one_signal_user_id']   = $user_id;

    }



      $LAST_ACTIVITY              = $this->session->userdata('LAST_ACTIVITY');

    if (isset($LAST_ACTIVITY) && (time() - $LAST_ACTIVITY > 86400 )){

    session_unset();     // unset $_SESSION variable for the run-time

    session_destroy();   // destroy session data in storage

    redirect(base_url());

  }



  if(($this->session->userdata('time_zone'))){     // Getting timezone from session



    $this->data['time_zone']      = $this->session->userdata('time_zone');

    $this->data['dollar_rate']      = $this->session->userdata('dollar_rate');

    $rupee_rate='';

    if($this->data['dollar_rate'] != 0){

      $rupee_rate = ( 1 / $this->data['dollar_rate']);

    }



    $this->data['rupee_rate'] = $rupee_rate;

    $data['user_timezone']        = $this->data['time_zone'] ;

    $user_id =$this->session->userdata('SESSION_USER_ID');

     $this->db->where('USERID',$user_id);

     $this->db->update('members',$data);



  }else{



    if($this->session->userdata('LAST_ACTIVITY')==''){

      $this->session->set_userdata('LAST_ACTIVITY',time());

    }

    if(isset($this->data['dollar_rate'])){

		$this->session->set_userdata('dollar_rate',$this->data['dollar_rate']);

	}

	if(isset($this->data['rupee_rate'])){

		$this->session->set_userdata('rupee_rate',$this->data['rupee_rate']);

	}

  }

  if($this->session->userdata('SESSION_USER_ID')){

    $this->data['user_favorites'] = $this->gigs_model->add_favourites();

  }



  $gig_price = $this->gigs_model->gig_price();

  $this->data['gig_price'] = $gig_price['value'];

  $extra_gig_price = $this->gigs_model->extra_gig_price();

  $this->data['extra_gig_price'] = $extra_gig_price['value'];

}

    function getTimezoneGeo($geoplugin_latitude, $geoplugin_longitude,$t)

   {

    $json = file_get_contents("https://maps.googleapis.com/maps/api/timezone/json?location=$geoplugin_latitude,$geoplugin_longitude&timestamp=$t&key=AIzaSyCrF-ZcLpYjLO7ygnisZJk_eHogmlzawwE ");     

    $data = json_decode($json,true);  

    $tzone=$data['timeZoneId'];      

    return $tzone;

  }

public function check_likes_for_escort_for_current_user()
{
  $user_id=$this->input->post("user_id");
    $cooki_id=$this->input->post("cook_id");
     $data=$this->db->query("select * from escort_likes where escort_id='".$user_id."' and cooki_id='".$cooki_id."'")->result_array();
      if($data)
    {
      echo '1';
    }
    else
    {
      echo "0";
    }
}

public function get_review_message()
{
  $id=$this->input->post("id");
  $data=$this->db->query("select * from feedback where id='".$id."'")->row_array();
// var_dump($data);
  echo @$data["comment"];
}

public function add_like_for_escort_dsp()
{
    $user_id=$this->input->post("user_id");
    $cooki_id=$this->input->post("cook_id");
    $data=$this->db->query("select * from escort_likes where escort_id='".$user_id."' and cooki_id='".$cooki_id."'")->result_array();
    if($data)
    {
      echo '1';
    }
    else
    {
        $from_timezone = "Asia/Calcutta";
          $current_time= date('Y-m-d H:i:s');
     
      $data_set_insert["escort_id"]=$user_id;
      $data_set_insert["cooki_id"]=$cooki_id;
      $data_set_insert["created_date"]=$current_time;
      $data_set_insert['time_zone'] =$from_timezone;
     $this->db->insert('escort_likes',$data_set_insert);
     echo '0';
    }
    // var_dump($this->db->last_query());

}

public function save_comment_for_blog()
{
  // var_dump($this->input->post());

  $user_id=$this->input->post("rating_touser");
  $cooki_id=$this->input->post("rating_frmuser");
  $rating_input=$this->input->post("rating_input");
  $mess=$this->input->post("chat_message_content");
  if($rating_input =='' || $rating_input==0)

    {

      $rating_input=1;

    }
    $from_timezone = "Asia/Calcutta";
   
    date_default_timezone_set($from_timezone); 

        $current_time= date('Y-m-d H:i:s');
      $data['from_user'] =$this->input->post("user_name");
      $data['from_cooki_id'] =$cooki_id;
      $data['rating'] =$rating_input;
      $data['to_user_id'] = $user_id;
      $data['comment'] =$mess;
      $data['time_zone'] =$from_timezone;
      // $data['country_name'] =$rating_input;
      $data['created_date'] =$current_time;
      $data['notification_status'] =1;
      $data['status'] =0;
   
   $check_comment=$this->db->query("select * from feedback where to_user_id='".@$user_id."' and from_cooki_id='".@$cooki_id."'")->row_array();
  if($check_comment)
  {
    $this->db->where(array("id"=>$check_comment["id"]));
      $ids=$this->db->update("feedback",$data);
  }
  else
  {
      $ids=$this->db->insert("feedback",$data);
  }
      

   

      // var_dump($this->db->last_query());
     
}

public function get_user_comment_for_escort()
{
  // var_dump($this->input->post());
  $user_id=$this->input->post("user_id");
  $cook_id=$this->input->post("cook_id");
  $data_comment=$this->db->query("select * from feedback where to_user_id='".@$user_id."' and from_cooki_id='".$cook_id."'")->row_array();
  if($data_comment['from_user'])
  {
  $blog["from_user"]=$data_comment['from_user'];
  }
  else
  {
    $blog["from_user"]=0;
  }
   if($data_comment['comment'])
  {
  $blog["comment"]=$data_comment['comment'];
  }
  else
  {
    $blog["comment"]=0;
  }
  
   if($data_comment['rating'])
  {
  $blog["rating"]=$data_comment['rating'];
  }
  else
  {
    $blog["rating"]=0;
  }
  // $data=$this->db->query("select * from feedback where ")->row_array();
// var_dump($data_comment);
$html ='';
$user_info=$this->db->query("select * from user_login where USERID='".@$user_id."'")->row_array();
 
$prof_img="assets/uploads/".$user_info["user_thumb_image"];
$name=$user_info["fullname"];
$rat=0;
$country=$user_info['country']; 

$sortname ='IN';

    if(@$user_info['sortname']!='')

    {

      $sortname=@$user_info['sortname']; 

    }

$html .='<div class="media">

          <div class="media-left">

            <img src="'.$prof_img.'" alt="'.$name.'" class="img-circle" width="50" height="50">

          </div>

          <div class="media-body">

            <div class="user-details">

            <div class="user-name-block">

              <a href="'.base_url().'user-profile/'.$user_info["username"].'" class="user-name">'.$name.'</a>

            </div>

            <div class="user-contact">

              <ul class="list-inline">

                <li class="user-rating"><span id="stars-existing" class="starrr" data-rating="'.$rat.'"></span></li>

                

              </ul>

            </div>

          </div>

          </div>

          <script type="text/javascript" src="'.base_url().'assets/js/rating.js"></script>

        </div>';


$data="";
  echo json_encode(array("data"=>@$data,"blog"=>@$blog,"html_set"=>$html));
}


public function search_influencer_from_search_influecner()
{
  var_dump($this->input->post());
  $type=$this->input->post("types");
  $name=$this->input->post("influencer");
  if($name)
  {
    $name=implode("-",explode(" ", $name));
  }
  else
  {
    $name='all-influencer';
  }
  $state=$this->input->post("state_id_dsp_get_state");
  if($state)
  {
    $state=implode("-",explode(" ", $state));
  }
  else
  {
    $state='all-state';
  }

  $zipcode=$this->input->post("zipcode");
  if($zipcode)
  {
    $$zipcode=$zipcode;
  }
  else
  {
    $zipcode='no-zip-code';
  }

  redirect(base_url()."search/index/0/".$type."/".$name."/".$state."/".$zipcode);
}

public function add_enquery()
{
  // var_dump($this->input->post());
  $data["name"]=$this->input->post("name");
  $data["email"]=$this->input->post("email");
  $data["contact"]=$this->input->post("number");
  $data["message"]=$this->input->post("message");
  $this->db->insert("enquerys",$data);
  $this->session->set_flashdata("notic","Enquery send to admin.");
  redirect(base_url()."".$this->input->post("url"));
}

public function delete_gigs_dsp()
{
  $id=$this->input->post("id");
  $this->load->model('admin_panel_model');
  $data = $this->admin_panel_model->delete_gigs_by_id($id);
  echo $data;
}

public function terms()

{

  $this->load->model('admin_panel_model');

  $this->data['lists'] = $this->admin_panel_model->get_terms();

  $this->data['page_title'] = 'Terms of condition';

  $this->data['module']  = 'terms';

  $this->data['page'] = 'index';

  $this->load->vars($this->data);

  $this->load->view($this->data['theme'].'/template');



}

public function tandc()

{

  $this->load->model('admin_panel_model');

  $this->data['lists'] = $this->admin_panel_model->get_terms();

  $this->data['page_title'] = 'Terms of condition';

  $this->data['module']  = 'tandc';

  $this->data['page'] = 'index';

  $this->load->vars($this->data);

  $this->load->view($this->data['theme'].'/template');



}

public function set_search_data()
{
  $id=$this->uri->segment(3);
  $search_data=$this->gigs_model->get_data_search_dsp($id);
  // var_dump($search_data["type"]);

  redirect(base_url()."search/index/0/".$search_data["type"]."/".implode('-',explode(' ',$search_data["item_name"]))."/all-state/no-zip-code");
}

public function item_search()
{
  $data=$this->input->get("q");
  // var_dump($data);
  $this->load->model("gigs_model");
  $search_data=$this->gigs_model->find_data_item_by_keywords($data);
  echo json_encode($search_data);
}


public function item_search_3()
{
  $data=$this->input->get("q");
  // var_dump($data);
  $this->load->model("gigs_model");
  $search_data=$this->gigs_model->find_data_item_by_keywords_influencer($data);
  echo json_encode($search_data);
}



public function item_search_4()
{
  $data=$this->input->get("q");
  // var_dump($data);
  $this->load->model("gigs_model");
  $search_data=$this->gigs_model->find_data_item_by_keywords_category_only($data);
  echo json_encode($search_data);
}

public function index()
{


$addon_value=$this->db->query("select * from membership where name='Home page adveristing'")->row_array();
$addon_value_2=$this->db->query("select * from membership where name='Large home page ad banner'")->row_array();
// var_dump(date("d-M-Y"));
$time_to_string2=strtotime(date("d-M-Y"));
// var_dump($time_to_string2);
    $time_zone_set_dsp='Asia/Calcutta';
date_default_timezone_set($time_zone_set_dsp);
$time_to_string=strtotime(date("d-M-Y"));

// var_dump($time_to_string);
$this->db->query("UPDATE user_addon SET status='Running' where start_date_in_string<=".@$time_to_string2."");


$this->db->query("UPDATE user_addon SET status='Done' where end_date_in_string<".@$time_to_string2."");

$this->data["danners"]=$this->gigs_model->get_banner_image($time_to_string2,$addon_value_2["values"]);



$data_get_for_update=$this->db->query("select USERID,types from user_login where end_date_in_string!='' and end_date_in_string<'".$time_to_string."'")->result_array();
foreach($data_get_for_update as $date_esc)
{
   if($date_esc['types']=='Escort')
   {
     $this->db->where(array("USERID"=>$date_esc["USERID"]));
     $this->db->update("user_login",array("package_status"=>'0'));
   } 
   else
   {
       $escort_info=$this->db->query("select escort_id from escort_info where agency_id='".$date_esc["USERID"]."' and escort_id !='".$date_esc["USERID"]."'")->result_array();
       foreach($escort_info as $esc)
       {
         $this->db->where(array("USERID"=>$date_esc["USERID"]));
     $this->db->update("user_login",array("package_status"=>'0'));
       }

   }
}

  $this->data['page_title'] = 'Home Page';

 
  // $this->data['get_all_user']  = $this->gigs_model->get_all_users();
  $this->data['get_all_popular_city']  = $this->gigs_model->get_all_popular_city();
  $this->data['active_users']  = $this->gigs_model->get_all_active_users();
  $get_all_dropdown  = $this->gigs_model->get_all_dropdown();
   
   $body_type=[];
   $hayer=[];
   $eyes=[];
   $orienatation=[];
   $ethnicity=[];
   $bust_size=[];
   $escort_for=[];

   foreach($get_all_dropdown as $drop)
   {


       if($drop["name"]=="dorpdown2")
       {
        
        $body_type['title']=$drop["title"];
        $body_type['value']=$drop["value"];
       }
       if($drop["name"]=="dropdown3")
       {
        $hayer['title']=$drop["title"];
        $hayer['value']=$drop["value"];
       }

        if($drop["name"]=="dropdown1")
       {
        $eyes['title']=$drop["title"];
        $eyes['value']=$drop["value"];
       }
        if($drop["name"]=="dropdown4")
       {
        // var_dump($drop["name"]);
        $orienatation['title']=$drop["title"];
        $orienatation['value']=$drop["value"];
       }

        if($drop["name"]=="dropdown5")
       {
        $ethnicity['title']=$drop["title"];
        $ethnicity['value']=$drop["value"];
       }
       if($drop["name"]=="dropdown6")
       {
        $bust_size['title']=$drop["title"];
        $bust_size['value']=$drop["value"];
       }
        if($drop["name"]=="dropdown7")
       {
        $escort_for['title']=$drop["title"];
        $escort_for['value']=$drop["value"];
       }

   }
   $this->data['body_type'] = $body_type;
   $this->data['user_favorites'] = $escort_for;
   $this->data['hayer'] = $hayer;
   $this->data['eyes'] = $eyes;
   $this->data['orienatation'] = $orienatation;
   $this->data['ethnicity'] = $ethnicity;
   $this->data['bust_size'] = $bust_size;
   $this->data['escort_for'] = $escort_for;

 //  $this->data['user_favorites'] = $this->gigs_model->add_favourites();

 //  $this->data['recent_gigs']  =  $this->gigs_model->recent_gigs(1);

 //  $this->data['gigs_country'] =  $this->gigs_model->gigs_country();

 //  $this->data['gigs_state_id'] = 0 ;

 //  $this->data['gigs_country_id'] = 0 ;

 // $this->data['list'] =  $this->gigs_model->get_feature_influencer();
 // $this->data['review'] =  $this->gigs_model->get_reviews();
 // // var_dump($this->data['review']);
 // $this->data['catergory'] =  $this->gigs_model->get_category();


$start=0;
if(@$this->uri->segment(3))
{
  $start=@$this->uri->segment(3);
}
$this->load->library('pagination');
$config['base_url'] = base_url("/index/0");
$config['per_page'] = 8;  
$config['uri_segment'] = 3;  
$config['full_tag_open'] = '<ul class="pagination">';
$config['full_tag_close'] = '</ul>';

$config['first_link'] = 'First';
$config['first_tag_open'] = '<li>';
$config['first_tag_close'] = '</li>';

$addon_value=$this->db->query("select * from membership where name='Home page adveristing'")->row_array();



$data_get=$this->gigs_model->get_all_users($start,$config['per_page'],$addon_value["values"],$time_to_string2);
$this->data["get_all_user"]=$data_get["data"];
$this->data["addon_value"]=$addon_value["values"];
// var_dump($data_get);
// $this->data["escrrt_of_city"]=$this->search_model->get_ecort_by_city($location_get);

$config['prev_link'] = '&laquo;';
$config['prev_tag_open'] = '<li>';
$config['prev_tag_close'] = '</li>';

$config['total_rows'] =$data_get["count"]["USERID"];


$config['cur_tag_open'] = '<li class="active"><a href="javascript:;">';
$config['cur_tag_close'] = '</a></li>';
$config['num_tag_open'] = '<li>';
$config['num_tag_close'] = '</li>';
    
$config['next_link'] = '&raquo;';
$config['next_tag_open'] = '<li>';
$config['next_tag_close'] = '</li>';
    
$config['last_link'] = 'Last';
$config['last_tag_open'] = '<li>';
$config['last_tag_close'] = '</li>';
$this->pagination->initialize($config);


$this->data['links'] = $this->pagination->create_links();




$this->data['corrent_date_in_string'] = strtotime(date('d-M-Y'));
  $this->data['page'] = 'index';

  $this->load->vars($this->data);

  $this->load->view($this->data['theme'].'/template');





}



public function addon_data()
{
  
  $type=$this->uri->segment(2);
  // var_dump($this->db);
  if($this->session->userdata('SESSION_USER_ID'))
  {
      $user_type_get=$this->gigs_model->get_user_info($this->session->userdata('SESSION_USER_ID'));
      if($user_type_get["types"]=="Escort")
      {
        $get_agency_id=$this->gigs_model->get_agency_id($this->session->userdata('SESSION_USER_ID'));
        if(@$get_agency_id["agency_id"])
        {
          $this->session->set_flashdata("message","Package is Buy from your ".$type.".");
          redirect(base_url()."user-profile/".$user_type_get["username"]);
        }
      }
  }

  

 $this->data['page_title'] = 'Addon -EscortOz';
  // $this->data['services_name']=$this->gigs_model->get_all_services_of_price_table($type);
 $this->data['mambership']=$this->gigs_model->get_all_addon();
  
  $this->data['page'] = 'addon';
  $this->data['type'] = $type;
  
  $this->load->vars($this->data);

  $this->load->view($this->data['theme'].'/template');
}



public function price_table_for()
{
  
  $type=$this->uri->segment(2);
  // var_dump($this->db);
  if($this->session->userdata('SESSION_USER_ID'))
  {
      $user_type_get=$this->gigs_model->get_user_info($this->session->userdata('SESSION_USER_ID'));
      if($user_type_get["types"]=="Escort")
      {
        $get_agency_id=$this->gigs_model->get_agency_id($this->session->userdata('SESSION_USER_ID'));
        if(@$get_agency_id["agency_id"])
        {
          $this->session->set_flashdata("message","Package is Buy from your ".$type.".");
          redirect(base_url()."user-profile/".$user_type_get["username"]);
        }
      }
  }

  

 $this->data['page_title'] = 'Price Table of '. $type;
 $this->data['services_name']=$this->gigs_model->get_all_services_of_price_table($type);
 $this->data['mambership']=$this->gigs_model->get_all_mambership($type);
  
  $this->data['page'] = 'price_table';
  $this->data['type'] = $type;
  
  $this->load->vars($this->data);

  $this->load->view($this->data['theme'].'/template');
}


public function index2($peramiter)
{


  $this->data['page_title'] = 'Home Page';

  $this->data['popular_gigs']  = $this->gigs_model->popular_gigs(1);

  $this->data['user_favorites'] = $this->gigs_model->add_favourites();

  $this->data['recent_gigs']  =  $this->gigs_model->recent_gigs(1);

  $this->data['gigs_country'] =  $this->gigs_model->gigs_country();

  $this->data['gigs_state_id'] = 0 ;

  $this->data['gigs_country_id'] = 0 ;

  $this->data['page'] = 'index';

  $this->load->vars($this->data);

  $this->load->view($this->data['theme'].'/template');





}



public function prf_crops() {

    //echo $_SERVER['DOCUMENT_ROOT']; exit;

  // $error_msg       = '';

  // $av_src          = $this->input->post('avatar_src');

  // $av_data         = json_decode($this->input->post('avatar_data'),true);

  // $av_file         = $_FILES['avatar_file'];

  // $src             = 'uploads/profile_images/'.$av_file['name'];

  // $imageFileType   = pathinfo($src,PATHINFO_EXTENSION);

  // $src2            = 'uploads/profile_images/user_'.$this->session->userdata('SESSION_USER_ID').'_original.'.$imageFileType;

  // move_uploaded_file($av_file['tmp_name'], $src2);

  // $image_name      = 'user_'.$this->session->userdata('SESSION_USER_ID').'_original.'.$imageFileType;

  // $new_name1       = "profile_image_".$this->session->userdata('SESSION_USER_ID')."_200x200.".$imageFileType;

  // $data['user_profile_image'] = 'uploads/profile_images/'.$new_name1;

  // $image1          = $this->prf_crop_call($image_name,$av_data,$new_name1,200,200);

  // $new_name2       = "profile_image_".$this->session->userdata('SESSION_USER_ID')."_150x150.".$imageFileType;

  // $image2          = $this->prf_crop_call($image_name,$av_data,$new_name2,150,150);

  // $new_name3       = "profile_image_".$this->session->userdata('SESSION_USER_ID')."_50x50.".$imageFileType;

  // $data['user_thumb_image'] = 'uploads/profile_images/'.$new_name3;

  // $image3          = $this->prf_crop_call($image_name,$av_data,$new_name3,50,50);

  // $rand = rand(100,999);

  // $user_id = $this->session->userdata('SESSION_USER_ID');

  // $this->db->where('USERID',$user_id);

  // $this->db->update('members',$data);

  // $response = array(

  //   'state'  => 200,

  //   'message' => $error_msg,

  //   'result' => 'uploads/profile_images/'.$new_name1.'?dummy='.$rand,

  //   'img_name1' => $new_name1

  //   );

  //         // if (file_exists($src2)) { unlink($src2);  }

  // echo json_encode($response);

}

public function notification()

{

  if(($this->session->userdata('SESSION_USER_ID')))

  {

   // $this->data['seo_module_name']      = $this->user_panel_model->seo_details('notification');

    $this->data['module'] = 'notification';

    $this->data['page'] = 'index';

    $this->data['page_title'] = 'Notification';

    $this->data['list'] = $this->notification_model->all_gigs();

    $this->load->vars($this->data);

    $this->load->view($this->data['theme'].'/template');

  }

  else

  {

    redirect(base_url());

  }

}






public function user_review($username,$start = 0){



  //$this->data['seo_module_name']      = $this->user_panel_model->seo_details('user_profile');
  $this->data['gigs_country']             =  $this->gigs_model->gigs_country();
  $this->load->library('pagination');
  $username = urldecode($username);
  $config['base_url'] = base_url("user-profile/".$username);

  $config['per_page'] = 8;

  $config['total_rows'] =  $this->gigs_model->username_base_gigs($username,0,0,0);



  $config['full_tag_open'] = '<ul class="pagination">';

  $config['full_tag_close'] = '</ul>';

  $config['first_link'] = 'First';

  $config['first_tag_open'] = '<li>';

  $config['first_tag_close'] = '</li>';



  $config['prev_link'] = '&laquo;';

  $config['prev_tag_open'] = '<li>';

  $config['prev_tag_close'] = '</li>';



  $config['cur_tag_open'] = '<li class="active"><a href="javascript:;">';

  $config['cur_tag_close'] = '</a></li>';

  $config['num_tag_open'] = '<li>';

  $config['num_tag_close'] = '</li>';



  $config['next_link'] = '&raquo;';

  $config['next_tag_open'] = '<li>';

  $config['next_tag_close'] = '</li>';



  $config['last_link'] = 'Last';

  $config['last_tag_open'] = '<li>';

  $config['last_tag_close'] = '</li>';



  $this->pagination->initialize($config);



  $this->data['links'] = $this->pagination->create_links();

  $this->data['list'] =   $this->gigs_model->username_base_gigs($username,1,$start,$config['per_page']);

  $this->data['social_link'] =   $this->gigs_model->get_social_link($username);



  $this->data['user_favorites']           = $this->gigs_model->add_favourites();

  $profile = $this->gigs_model->profile($username);

  $result = array();
  if(empty($profile)){
      redirect(base_url());
    }

    $query = $this->db->query("SELECT `sortname`,country FROM `country` WHERE `id` =". $profile['country']."");
    $result = $query->row_array();
  $this->data['user_created']      =   date('Y-m-d H:i:s', strtotime($profile['created_date']));

  $this->data['time_zone']      = $profile['user_timezone'];

  $this->data['completed_gigs']    = 0;

  $query1 = $this->db->query("SELECT * FROM `payments` WHERE `seller_id` = ".$profile['USERID']." AND `seller_status` = 6 ");

  $result1 = $query1->num_rows();

  if(!empty($result1))

  {

    $this->data['completed_gigs'] = $result1;

  }

  $suser_id = $profile['USERID'];

  $query_feed = $this->db->query("SELECT feedback.*,sell_gigs.title,members.fullname,members.username,members.USERID,`members`.`user_thumb_image`,`members`.`user_profile_image`  FROM `feedback`

   left join members on members.USERID = feedback.`from_user_id`

   left join sell_gigs on sell_gigs.id = feedback.`gig_id`

   WHERE  sell_gigs.user_id = $suser_id AND feedback.to_user_id = $suser_id AND feedback.`status` = 1 ");

  $result_feed =  $query_feed->result_array();

  $this->data['feedbacks'] = $result_feed;

  $query_feed = $this->db->query("SELECT AVG(feedback.rating),count(feedback.id) FROM `feedback`

    left join sell_gigs on sell_gigs.id = feedback.`gig_id`

    WHERE sell_gigs.user_id = $suser_id AND feedback.`to_user_id` = $suser_id;");

  $fe_count = $query_feed->row_array();

  $rat=0;

  $rat_count =0;

  if($fe_count['AVG(feedback.rating)']!='')

  {

   $rat=round($fe_count['AVG(feedback.rating)']);

   $rat_count=round($fe_count['count(feedback.id)']);

 }
 $this->data['user_feedback'] = $rat;

 $this->data['user_feedbackcount'] = $rat_count;

 $this->data['country_shortname'] = $result['sortname'];

 $this->data['country_name']      = $result['country'];

 $this->data['user_id']           = $profile['USERID'];

 $this->data['profile']           = $profile ;

 $this->data['user_gigs']         = $this->gigs_model->username_base_gigs($username,1,0,0);

 $this->data['module']            = 'user_profile';

 $this->data['page']              = 'review';

 $this->data['page_title'] = 'User Review';

$this->data['user_name_set'] = $username;
 
 $this->data['list'] =  $this->gigs_model->my_gigs(1,$profile['USERID'],0,3);
// var_dump($profile['USERID']);
 $this->data['feedbacks'] =  $this->gigs_model->my_revidws($profile['USERID']);
 // var_dump($this->data['feedbacks']);
 $this->load->vars($this->data);

 $this->load->view($this->data['theme'].'/template');

}



public function user_about($username,$start = 0){



  //$this->data['seo_module_name']      = $this->user_panel_model->seo_details('user_profile');
  $this->data['gigs_country']             =  $this->gigs_model->gigs_country();
  $this->load->library('pagination');
  $username = urldecode($username);
  $config['base_url'] = base_url("user-profile/".$username);

  $config['per_page'] = 8;

  $config['total_rows'] =  $this->gigs_model->username_base_gigs($username,0,0,0);



  $config['full_tag_open'] = '<ul class="pagination">';

  $config['full_tag_close'] = '</ul>';

  $config['first_link'] = 'First';

  $config['first_tag_open'] = '<li>';

  $config['first_tag_close'] = '</li>';



  $config['prev_link'] = '&laquo;';

  $config['prev_tag_open'] = '<li>';

  $config['prev_tag_close'] = '</li>';



  $config['cur_tag_open'] = '<li class="active"><a href="javascript:;">';

  $config['cur_tag_close'] = '</a></li>';

  $config['num_tag_open'] = '<li>';

  $config['num_tag_close'] = '</li>';



  $config['next_link'] = '&raquo;';

  $config['next_tag_open'] = '<li>';

  $config['next_tag_close'] = '</li>';



  $config['last_link'] = 'Last';

  $config['last_tag_open'] = '<li>';

  $config['last_tag_close'] = '</li>';



  $this->pagination->initialize($config);



  $this->data['links'] = $this->pagination->create_links();

  $this->data['list'] =   $this->gigs_model->username_base_gigs($username,1,$start,$config['per_page']);

  $this->data['social_link'] =   $this->gigs_model->get_social_link($username);



  $this->data['user_favorites']           = $this->gigs_model->add_favourites();

  $profile = $this->gigs_model->profile($username);

  $result = array();
  if(empty($profile)){
      redirect(base_url());
    }

    $query = $this->db->query("SELECT `sortname`,country FROM `country` WHERE `id` =". $profile['country']."");
    $result = $query->row_array();
  $this->data['user_created']      =   date('Y-m-d H:i:s', strtotime($profile['created_date']));

  $this->data['time_zone']      = $profile['user_timezone'];

  $this->data['completed_gigs']    = 0;

  $query1 = $this->db->query("SELECT * FROM `payments` WHERE `seller_id` = ".$profile['USERID']." AND `seller_status` = 6 ");

  $result1 = $query1->num_rows();

  if(!empty($result1))

  {

    $this->data['completed_gigs'] = $result1;

  }

  $suser_id = $profile['USERID'];

  $query_feed = $this->db->query("SELECT feedback.*,sell_gigs.title,members.fullname,members.username,members.USERID,`members`.`user_thumb_image`,`members`.`user_profile_image`  FROM `feedback`

   left join members on members.USERID = feedback.`from_user_id`

   left join sell_gigs on sell_gigs.id = feedback.`gig_id`

   WHERE  sell_gigs.user_id = $suser_id AND feedback.to_user_id = $suser_id AND feedback.`status` = 1 ");

  $result_feed =  $query_feed->result_array();

  $this->data['feedbacks'] = $result_feed;

  $query_feed = $this->db->query("SELECT AVG(feedback.rating),count(feedback.id) FROM `feedback`

    left join sell_gigs on sell_gigs.id = feedback.`gig_id`

    WHERE sell_gigs.user_id = $suser_id AND feedback.`to_user_id` = $suser_id;");

  $fe_count = $query_feed->row_array();

  $rat=0;

  $rat_count =0;

  if($fe_count['AVG(feedback.rating)']!='')

  {

   $rat=round($fe_count['AVG(feedback.rating)']);

   $rat_count=round($fe_count['count(feedback.id)']);

 }

 $this->data['user_feedback'] = $rat;

 $this->data['user_feedbackcount'] = $rat_count;

 $this->data['country_shortname'] = $result['sortname'];

 $this->data['country_name']      = $result['country'];

 $this->data['user_id']           = $profile['USERID'];

 $this->data['profile']           = $profile ;

 $this->data['user_gigs']         = $this->gigs_model->username_base_gigs($username,1,0,0);

 $this->data['module']            = 'user_profile';

 $this->data['page']              = 'about';

 $this->data['page_title'] = 'User About';

$this->data['user_name_set'] = $username;
 
 $this->data['list'] =  $this->gigs_model->my_gigs(1,$profile['USERID'],0,3);
 $this->load->vars($this->data);
  // var_dump($this->data['list']);
 $this->load->view($this->data['theme'].'/template');

}

public function user_profile($username){

 // $this->load->vars($this->data);
 $this->data['gigs_country']             =  $this->gigs_model->gigs_country();
  $username = urldecode($username);
  
  $profile = $this->gigs_model->profile($username);
  // var_dump($profile);
   $result = array();
  if(empty($profile)){
      redirect(base_url());
    }

     $this->data['user_created']      =   date('Y-m-d H:i:s', strtotime($profile['created_date']));
     $this->data['time_zone']      = $profile['user_timezone'];
      $suser_id = $profile['USERID'];
       $this->data['profile']           = $profile;
       
        $this->data['module']            = 'user_profile';
       $this->data['page']              = 'index';
       $this->data['page_title'] = 'User Profile';
       $this->data['user_name_set'] = $username;
       $this->data['list'] =null;
     // var_dump($this->session->userdata('SESSION_USER_ID'));

   $this->load->vars($this->data);

 $this->load->view($this->data['theme'].'/template');

}





public function edit_gig($title,$id)

{



  $title =  urldecode($title);
  $id =  urldecode($id);



  $query = $this->db->query("select * from system_settings WHERE status = 1");

		$result = $query->result_array();

		$this->email_tittle='Gigs';

		if(!empty($result))

		{

			foreach($result as $datas){

				if($datas['key'] == 'site_name' ||  $datas['key'] == 'website_name'){

					$this->site_name = $datas['value'];

					$this->data['site_name'] =$this->site_name;

				}

			}

		}

  if($this->session->userdata('SESSION_USER_ID'))

  {

   // $this->data['seo_module_name']      = $this->user_panel_model->seo_details('edit_gig');

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



    if($this->input->post('form_submit'))

    {

      $gigs_id = $this->input->post('gig_id');

      $gig_tags = ucfirst($this->input->post('gig_tags'));

      if(!empty($gig_tags))

      {

       $data['gig_tags'] = $gig_tags;

      }

     $data['user_id'] = $this->session->userdata('SESSION_USER_ID');

     $title = strtolower($this->input->post('gig_title'));

     $data['title'] = url_title($title,'-');

     $data['gig_price'] = $this->input->post('gig_price');

     $data['time_zone'] = $this->session->userdata('time_zone');

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

     else

     {

      $data['super_fast_charges'] = 0;

      $data['super_fast_delivery'] = '' ;

      $data['super_fast_delivery_desc'] = '';

      $data['super_fast_delivery_date'] = '';

    }

    $youtube_url            = $this->input->post('youtube_url');



    $data['youtube_url']      = $youtube_url;



    $vimeo_url            = $this->input->post('vimeo_url');



    $data['vimeo_url']      = $vimeo_url;



    $vimeo_video_id       = $this->input->post('vimeo_video_id');



    $data['vimeo_video_id']    =  $vimeo_video_id;



    $data['work_option'] = $this->input->post('work_option');

    $data['requirements'] = ucfirst($this->input->post('requirements'));

    $data['country_name'] = $this->input->post('full_country_name');

    $country_name = $this->session->userdata('country_name');

    $data['currency_type'] = $this->data['currency_option'];

    $from_timezone = $this->session->userdata('time_zone');
    date_default_timezone_set($from_timezone);
    $current_time= date('Y-m-d H:i:s');
    $data['created_date']      = $current_time;

    $this->db->where('id',$gigs_id);
    $this->db->update('sell_gigs',$data);

   $this->db->query("UPDATE crasol SET item_name='".$title."' WHERE type='package' and item_id='".$gigs_id."'");

    $to_delete_images = $this->input->post('deleted_image_array');

 if(!empty($to_delete_images))

 {



   $to_delete_images = explode(",",$this->input->post('deleted_image_array'));



   $delete_data = array();

   foreach($to_delete_images as $delete_images)

   {

     $file_path =  FCPATH.$delete_images;

     unlink ($file_path);

     $delete_data['gig_id'] = $gigs_id;

     $delete_data['gig_image_tile'] = $delete_images;

     $this->db->where($delete_data);

     $this->db->delete('gigs_image');

   }



 }



 $to_delete_video = $this->input->post('deleted_video_array');

 if(!empty($to_delete_video))

 {

   $to_delete_video = explode(",",$this->input->post('deleted_video_array'));



   $delete_data = array();

   foreach($to_delete_video as $delete_videos)

   {

    $file_path =  FCPATH.$delete_videos;

    unlink ($file_path);

    $delete_data['gig_id'] = $gigs_id;

    $delete_data['video_path'] = $delete_videos;

    $this->db->where($delete_data);

    $this->db->delete('gigs_video');

  }

}



$images = $this->input->post('image_array');

$videos = $this->input->post('video_array');



$images =  explode(',',$images);

$videos =  explode(',',$videos);

$images   = array_filter($images);

if(!empty($images))

{

  for($i=0;$i<sizeof($images);$i++)

  {

    $data1['gig_id'] = $gigs_id;

    $data1['image_path'] = 'uploads/gig_images/680_460_'.$images[$i];

    $data1['gig_image_thumb'] = 'uploads/gig_images/50_34_'.$images[$i];

    $data1['gig_image_tile'] = 'uploads/gig_images/100_68_'.$images[$i];

    $data1['gig_image_medium'] = 'uploads/gig_images/240_162_'.$images[$i];

    $this->db->insert('gigs_image',$data1);

  }

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


if(!empty($this->input->post('extra_gigs'))){
  $extra_gigs =array_filter($this->input->post('extra_gigs'));  
}else{
  $extra_gigs = array();
}


if(!empty($extra_gigs)&&is_array($extra_gigs))

{

  $extra_gigs = array_filter($extra_gigs);

  $this->db->where('gigs_id',$gigs_id);

  $this->db->delete('extra_gigs');

  if(!empty($extra_gigs)  && is_array($extra_gigs))

  {

    $data3['extra_gigs'] = $this->input->post('extra_gigs');

    $data3['extra_gigs_delivery'] = $this->input->post('extra_gigs_delivery');

    $data3['extra_gigs_amount'] = $this->input->post('extra_gigs_amount');

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



      }

    }

  }

}

$this->session->set_flashdata('msg','Gig Update');

redirect(base_url().'package-preview/'.$data['title']."/".$gigs_id);

}

$this->data['page_title']     = 'Edit Gig';

$this->data['module']       = 'edit_gig';

//$basic_details          = $this->gigs_model->gig_basic_details($title);

$basic_details          = $this->gigs_model->gig_basic_details_id($id);

$this->data['basic_details']  = $basic_details;

$this->data['extra_gig_details']= $this->gigs_model->extra_gig_details($basic_details['id']);

$gig_image_details        = $this->gigs_model->gig_image_details($basic_details['id']);

$gig_video_details        = $this->gigs_model->gig_video_details($basic_details['id']);

$this->data['gig_image_details']= $gig_image_details;

$image_details = array();

foreach($gig_image_details as $img_details)

{

  $file_name    =  explode('/',$img_details['gig_image_tile']);

  $image_details[] = $file_name[2];

}

$this->data['images_value']   = $image_details;



$this->data['gig_video_details']= $gig_video_details;

$image_details = array();

$this->data['video_detail']   = '';

if(!empty($gig_video_details))

{

  foreach($gig_video_details as $video_details)

  {

   $file_name    =  explode('/',$video_details['video_path']);

   $video_detail[] = $file_name[2];

 }

 $this->data['video_detail']    = $video_detail;

}



$this->data['gig_details'] = $this->gigs_model->get_gig_details($title);

$this->data['page']       = 'index';

$this->load->vars($this->data);

$this->load->view($this->data['theme'].'/template');

}

else

{

  redirect(base_url());

}



}


public function user_gigs_get_dsp($username,$start = 0)
{


   // var_dump($username);
   $this->gigs_model->username_base_gigs($username,0,0,0);
    $data=$this->gigs_model->get_user_id($username);
   $user_id =$data["USERID"] ;
     
    

    $this->load->library('pagination');

    $config['base_url'] = base_url("my-gigs/");

    $config['per_page'] = 16;

    $config['uri_segment'] = 2;

    $config['total_rows'] =  $this->gigs_model->my_gigs(0,$user_id,0,0);



    $config['full_tag_open'] = '<ul class="pagination">';

    $config['full_tag_close'] = '</ul>';

    $config['first_link'] = 'First';

    $config['first_tag_open'] = '<li>';

    $config['first_tag_close'] = '</li>';

    $config['prev_link'] = '&laquo;';

    $config['prev_tag_open'] = '<li>';

    $config['prev_tag_close'] = '</li>';



    $config['cur_tag_open'] = '<li class="active"><a href="javascript:;">';

    $config['cur_tag_close'] = '</a></li>';

    $config['num_tag_open'] = '<li>';

    $config['num_tag_close'] = '</li>';



    $config['next_link'] = '&raquo;';

    $config['next_tag_open'] = '<li>';

    $config['next_tag_close'] = '</li>';



    $config['last_link'] = 'Last';

    $config['last_tag_open'] = '<li>';

    $config['last_tag_close'] = '</li>';



    $this->pagination->initialize($config);

    $this->data['page'] = 'index';

    $this->data['links'] = $this->pagination->create_links();



    $this->data['list'] =  $this->gigs_model->my_gigs(1,$user_id,$start,$config['per_page']);
    
    $this->data['page_title'] = 'My Gigs';

    $this->data['module'] = 'my_gigs';

    $this->data['search_value'] = "My Gigs";

    $this->data['total_results'] = $config['total_rows'];

    $this->data['search_type'] = 'Location';

    $this->data['searched_value'] = " " ;

    $this->data['selected_category_value'] = '';
    $username=$this->gigs_model->get_user_name($user_id);
    $this->data['social_link'] =   $this->gigs_model->get_social_link($username);
    $profile = $this->gigs_model->profile($username);
    $this->data['profile']           = $profile ;


     $suser_id = $user_id;

  $query_feed = $this->db->query("SELECT feedback.*,sell_gigs.title,members.fullname,members.username,members.USERID,`members`.`user_thumb_image`,`members`.`user_profile_image`  FROM `feedback`

   left join members on members.USERID = feedback.`from_user_id`

   left join sell_gigs on sell_gigs.id = feedback.`gig_id`

   WHERE  sell_gigs.user_id = $suser_id AND feedback.to_user_id = $suser_id AND feedback.`status` = 1 ");

  $result_feed =  $query_feed->result_array();

  $this->data['feedbacks'] = $result_feed;

  $query_feed = $this->db->query("SELECT AVG(feedback.rating),count(feedback.id) FROM `feedback`

    left join sell_gigs on sell_gigs.id = feedback.`gig_id`

    WHERE sell_gigs.user_id = $suser_id AND feedback.`to_user_id` = $suser_id;");

  $fe_count = $query_feed->row_array();

  $rat=0;

  $rat_count =0;

  if($fe_count['AVG(feedback.rating)']!='')

  {

   $rat=round($fe_count['AVG(feedback.rating)']);

   $rat_count=round($fe_count['count(feedback.id)']);

 }

 $this->data['user_feedback'] = $rat;

  $this->data['user_feedbackcount'] = $rat_count;
  $query = $this->db->query("SELECT `sortname`,country FROM `country` WHERE `id` =". $profile['country']."");
    $result = $query->row_array();
   $this->data['country_shortname'] = $result['sortname'];
$this->data['user_name_set'] = $profile['username'];
$this->data['user_id'] = $profile['USERID'];
 $this->data['country_name']      = $result['country'];
    $this->load->vars($this->data);

    $this->load->view($this->data['theme'] . '/template');

}

public function user_gigs($username,$offset=0)

{

  //$this->data['seo_module_name']      = $this->user_panel_model->seo_details('user_gigs');

  $this->load->library('pagination');

  $config['base_url'] = base_url("gigs/user_gigs/");

  $config['per_page'] = 15;



  $config['total_rows'] =  $this->gigs_model->username_base_gigs($username,0,0,0);



  $config['full_tag_open'] = '<ul class="pagination">';

  $config['full_tag_close'] = '</ul>';

  $config['first_link'] = 'First';

  $config['first_tag_open'] = '<li>';

  $config['first_tag_close'] = '</li>';



  $config['prev_link'] = '&laquo;';

  $config['prev_tag_open'] = '<li>';

  $config['prev_tag_close'] = '</li>';



  $config['cur_tag_open'] = '<li class="active"><a href="javascript:;">';

  $config['cur_tag_close'] = '</a></li>';

  $config['num_tag_open'] = '<li>';

  $config['num_tag_close'] = '</li>';



  $config['next_link'] = '&raquo;';

  $config['next_tag_open'] = '<li>';

  $config['next_tag_close'] = '</li>';



  $config['last_link'] = 'Last';

  $config['last_tag_open'] = '<li>';

  $config['last_tag_close'] = '</li>';



  $this->pagination->initialize($config);



  $this->data['links'] = $this->pagination->create_links();



  $this->data['list'] =   $this->gigs_model->username_base_gigs($username,1,$offset,$config['per_page']);





  $profile = $this->gigs_model->profile($username);

  $query = $this->db->query("SELECT `sortname`,country FROM `country` WHERE `id` =". $profile['country']."");

  $result = $query->row_array();

  $this->data['user_id']           = $profile['USERID'];

  $this->data['country_shortname'] = $result['sortname'];

  $this->data['country_name']      = $result['country'];

  $this->data['profile']           = $profile ;

  $this->data['user_gigs']         = $this->gigs_model->username_base_gigs($username,1,0,0);

  $this->data['module']            = 'user_gigs';

  $this->data['page']              = 'index';

  $this->data['page_title'] = 'User Gigs';

  $this->load->vars($this->data);

  $this->load->view($this->data['theme'].'/template');



}



public function pages($param)

{

  //$this->data['seo_module_name']      = $this->user_panel_model->seo_details('default');

  $query = $this->db->query("SELECT * FROM `footer_submenu` WHERE `footer_submenu` = '$param'; ");

  $this->data['list'] = $query->row_array();

  $this->data['module'] = 'pages';

  $this->data['page'] = 'page';

  $this->data['page_title'] = $param;

  $this->load->vars($this->data);

  $this->load->view($this->data['theme'].'/template');

}

public function search_influencer()
{
  $this->data['module'] = 'pages';

  $this->data['page'] = 'search-influencer';

  $this->data['page_title'] = "Search Influencer";
  $this->data['user_list']=$this->db->query("SELECT fullname FROM members WHERE are_you='Short' and status='0' ORDER BY `members`.`fullname` ASC")->result_array();
  $this->data['states'] =$this->db->query("SELECT * FROM `states` WHERE `country_id` = 231 and state_status='1' ORDER BY `states`.`state_name` ASC")->result_array();
  $this->load->vars($this->data);

  $this->load->view($this->data['theme'].'/template');
}

public function view_all_category()
{

   $this->data['module'] = 'pages';

  $this->data['page'] = 'all-category';

  $this->data['page_title'] = "All Categoryes";

  $this->data['categorys'] =$this->db->query("SELECT * FROM categories where status='0' ORDER BY categories.name ASC")->result_array();


  $this->load->vars($this->data);

  $this->load->view($this->data['theme'].'/template');
}

public function aboutus()
{
    $this->data['module'] = 'pages';

  $this->data['page'] = 'aboutus';

  $this->data['page_title'] = "About Us";

  $this->load->vars($this->data);

  $this->load->view($this->data['theme'].'/template');
}

public function blog(){


    $this->data['module'] = 'pages';

  $this->data['page'] = 'blog';

  $this->data['page_title'] = "Over Blog";
   

 
 // var_dump($count_ids);

//set pagination start
$this->load->library('pagination');


if($this->uri->segment(4))
{
  $start=$this->uri->segment(4);
}
else
{
  $start=0;
}

$cate=$this->uri->segment(2);
$blog_name=$this->uri->segment(3);

$config['base_url'] = base_url("our-blog/".$cate."/".$blog_name);
$config['per_page'] = 6;  
$config['uri_segment'] = 4;  
$config['full_tag_open'] = '<ul class="pagination">';
$config['full_tag_close'] = '</ul>';


if($blog_name!='all')
{
  $set_blog_name="and title LIKE '%".implode(" ",explode("-", $blog_name))."%'";
}
else
{
  $set_blog_name=''; 
}

  
  if($cate!='all')
  {
    $cat=implode(" ",explode("-",$cate));
    $cat_id=$this->db->query("SELECT id FROM `blog_categories` where status='0' and name='".$cat."'")->row_array();
    // var_dump($this->db->last_query());
    
    // $count_ids=$this->db->query("SELECT count(id) FROM `our_blog` where status='0' ORDER BY `our_blog`.`id` DESC")->row_array(); 
     $data_get=$this->db->query("SELECT * FROM `our_blog` where status='0' ".$set_blog_name." ORDER BY `our_blog`.`id` DESC LIMIT ".$start." , ".$config['per_page'] )->result_array();
     // var_dump($this->db->last_query()); 
     $count_set=0;
    $this->data['list']=[];

    foreach ($data_get as $data) {
        // var_dump($data["categorys"]);
      $blog_ids=explode("*#*", $data["categorys"]);
      // var_dump($blog_ids);
      if(in_array($cat_id["id"], $blog_ids))
      { 
        
         $count_set=$count_set+1;
         array_push($this->data['list'], $data);
      }
    }
    // var_dump($this->data['list']);
  }
  else
  {

    $count_ids=$this->db->query("SELECT count(id) FROM `our_blog` where status='0' ".$set_blog_name." ORDER BY `our_blog`.`id` DESC")->row_array(); 
     $this->data['list']=$this->db->query("SELECT * FROM `our_blog` where status='0' ".$set_blog_name." ORDER BY `our_blog`.`id` DESC LIMIT ".$start." , ".$config['per_page'] )->result_array(); 
     $count_set=$count_ids["count(id)"];
  }


$config['first_link'] = 'First';
$config['first_tag_open'] = '<li>';
$config['first_tag_close'] = '</li>';




$config['prev_link'] = '&laquo;';
$config['prev_tag_open'] = '<li>';
$config['prev_tag_close'] = '</li>';

$config['total_rows'] =$count_set;

$config['cur_tag_open'] = '<li class="active"><a href="javascript:;">';
$config['cur_tag_close'] = '</a></li>';
$config['num_tag_open'] = '<li>';
$config['num_tag_close'] = '</li>';
    
$config['next_link'] = '&raquo;';
$config['next_tag_open'] = '<li>';
$config['next_tag_close'] = '</li>';
    
$config['last_link'] = 'Last';
$config['last_tag_open'] = '<li>';
$config['last_tag_close'] = '</li>';
$this->pagination->initialize($config);

$this->data['links'] = $this->pagination->create_links();
//set pagination end





$this->data["cate_name"]=$cate;
$this->data["blog_name"]=$blog_name;
$this->data["result"]=$count_set;


  $this->data['today']=$this->db->query("SELECT * FROM `our_blog` where status='0' and date='".date("d-m-Y")."' ORDER BY `our_blog`.`id` DESC limit 2")->result_array();
   
  $this->data['categorys']=$this->db->query("SELECT * FROM `blog_categories` where status='0' ORDER BY `blog_categories`.`name` ASC")->result_array();

$this->data["select_all_blog"]=$this->db->query("select * from our_blog where status='0' ORDER BY `our_blog`.`title` ASC")->result_array();

  $this->load->vars($this->data);

  $this->load->view($this->data['theme'].'/template');
}



public function read_blog($id,$name)
{


  $this->data["blog"]=$this->db->query("select * from our_blog where id='".$id."'")->row_array();
  
   $this->data['list']=$this->db->query("SELECT * FROM `our_blog` where status='0' ORDER BY `our_blog`.`id` DESC")->result_array();
  $this->data['today']=$this->db->query("SELECT * FROM `our_blog` where status='0' and date='".date("d-m-Y")."' ORDER BY `our_blog`.`id` DESC")->result_array();
   
  $this->data['categorys']=$this->db->query("SELECT * FROM `blog_categories` where status='0' ORDER BY `blog_categories`.`name` ASC")->result_array();
   $this->data['module'] = 'pages';
  
  $this->data['page'] = 'read-blog';

   $this->data["comment"]=$this->db->query("SELECT a.*,b.* FROM blog_comment as a,members as b WHERE b.USERID=a.user_id and a.blog_id='".$id."'")->result_array();

  $this->data['page_title'] = "Contact Us";

  $this->load->vars($this->data);

  $this->load->view($this->data['theme'].'/template');
}





public function contact_us(){


    $this->data['module'] = 'pages';

  $this->data['page'] = 'contact-us';

  $this->data['page_title'] = "Contact Us";

  $this->load->vars($this->data);

  $this->load->view($this->data['theme'].'/template');
}

public function item_search_2()
{
  $data=$this->input->get("q");
  // var_dump($data);
  $this->load->model("gigs_model");
  $search_data=$this->gigs_model->find_data_item_by_help($data);
  echo json_encode($search_data);
}


public function form_submit()
{
  $name=$this->input->post("quick_search_2");
  redirect(base_url()."help-center/search-for/".implode("-",explode(" ", $name)));
}

public function help_center_pages_search_result($name)
{
   $data=$this->db->query("SELECT * FROM `help_center_content` WHERE `name` LIKE '%".implode(" ",explode("-", $name))."%'");
  
   $data2=$data->result_array();
    $this->data['module'] = 'pages';

  $this->data['page'] = 'help-center-content-search';

 
  // var_dump($content);
$this->data['contect']=$data2;
  $this->data['page_title'] = $name;

  $this->load->vars($this->data);

  $this->load->view($this->data['theme'].'/template');
}

public function help_center_pages($id,$name)
{

    $this->data['module'] = 'pages';

  $this->data['page'] = 'help-center-content';

  $data=$this->db->query("select * from help_center_content where status='0'");
  $data2=$data->result_array();
    $content=[];
  if(@$data2)
  {
    foreach($data2 as $dat)
    {
       $cat=explode("*#*",$dat["categorys"]);
       if(in_array($id, $cat))
       {
        array_push($content, $dat);
       }
    }
  }
  // var_dump($content);
$this->data['contect']=$content;
  $this->data['page_title'] = $name;

  $this->load->vars($this->data);

  $this->load->view($this->data['theme'].'/template');
}

public function help_center(){


    $this->data['module'] = 'pages';

  $this->data['page'] = 'help-center';

  $data=$this->db->query("select * from faqs_categories where status='0' ORDER BY `faqs_categories`.`name` ASC");
$this->data['category']=$data->result_array();
  $this->data['page_title'] = "Help Center";

  $this->load->vars($this->data);

  $this->load->view($this->data['theme'].'/template');
}

public function update_location()

{

  $country_name = $this->input->post('country_name');

}



public function public_profile($id,$title='')

{

   $usr_info=$this->user_panel_model->get_one_user($id);
    $this->data["user_login"]=$usr_info;
    $this->data["escort_info"]=$this->user_panel_model->get_one_escort_info($id);
    $this->data["escort_availability"]=$this->user_panel_model->get_one_escort_availability($id);
     
     if(@$usr_info["types"]=="Escort")
   {
    $this->data["escort_rate"]=$this->user_panel_model->get_one_escort_rate($id);
    $this->data["escort_think_prefer"]=$this->user_panel_model->get_one_escort_think_prefer($id);
    $this->data["escort_tour"]=$this->user_panel_model->get_one_escort_tour($id);
  }
  else
  {
     $escort_ids=$this->user_panel_model->get_all_escort_id_of_agecy($id);


      $this->data["escort_rate"]=$this->user_panel_model->get_all_escort_rate_of_one_agency( $escort_ids);
     

      $this->data["my_escort"]=$this->user_panel_model->get_all_my_escort($escort_ids);
  }
    $this->data["social_link"]=$this->user_panel_model->get_one_escort_social_link($id);
    $this->data["get_gallery_image"]=$this->user_panel_model->get_one_escort_gallsery_image($id);

    $this->data['module']  = 'user_priview';
    $this->data['page_title'] = implode(" ", explode("-",$title));
   if(@$usr_info["types"]=="Escort")
   {

      $this->data['page'] = 'index';
   }
   else
   {
      $this->data['page'] = 'agency_page';
   }

$this->data["get_feedback"]=$this->user_panel_model->escort_feedback_data_dsp($id);
$this->load->vars($this->data);

$this->load->view($this->data['theme'].'/template');

}

public function load_more_feedbacks()

{

 // $this->data['seo_module_name']      = $this->user_panel_model->seo_details('feedback');

  if(($this->session->userdata('time_zone')))

  {

   $time_zone = $this->session->userdata('time_zone');



 }

 else

 {

   $user_ip = getenv('REMOTE_ADDR');

   $geo = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=$user_ip"));

   $geoplugin_latitude = $geo["geoplugin_latitude"];

   $geoplugin_longitude = $geo["geoplugin_longitude"];

   $t=time();

   $result = $this->getTimezoneGeo($geoplugin_latitude,$geoplugin_longitude,$t);

   $time_zone = $result;

 }

 $start = $this->input->post('start');

 $userid = $this->input->post('userid');

 $g_id = $this->input->post('g_id');

 $limit=2;

 $html='';

 $status =0;

 $html_count = intval($start) + intval($limit);

 $result_set = $this->gigs_model->more_gigs_feedbacks($g_id,$userid,$start,$limit);

 if(count($result_set)>0)

 {

  $status =1;

}

foreach($result_set as $key=>$feedback) {

  if($time_zone!=$feedback['time_zone'])

  {

   $date = new DateTime($feedback['created_date'], new DateTimeZone($feedback['time_zone']));

   $date->setTimezone(new DateTimeZone($time_zone));

   $time = $date->format('Y-m-d H:i:s');

   date_default_timezone_set($time_zone);

   $date1= date('Y-m-d H:i:s') ;

   $now = new DateTime($date1);

   $ref = new DateTime($time);

   $diff = $now->diff($ref);

 }

 else

 {

  date_default_timezone_set($time_zone);

  $now = new DateTime(date('Y-m-d H:i:s'));

  $ref = new DateTime($feedback['created_date']);

  $diff = $now->diff($ref);

}

$total_seconds = 0 ;

$days = $diff->days;

$hours = $diff->h;

$mins = $diff->i;

if(!empty($days)&&($days>0))

{

  $days_to_seconds = $diff->days*24*60*60;

  $total_seconds = $total_seconds+$days_to_seconds;

}

if(!empty($hours)&&($hours>0))

{

  $hours_to_seconds = $diff->h*60*60;

  $total_seconds = $total_seconds+$hours_to_seconds;

}

if(!empty($mins)&&($mins>0))

{

  $min_to_seconds = $mins*60;

  $total_seconds = $total_seconds+$min_to_seconds;

}

$intervals      = array (

  'year' => 31556926, 'month' => 2629744, 'week' => 604800, 'day' => 86400, 'hour' => 3600, 'minute'=> 60

  );

$time_difference = '';

if ($total_seconds == 0)

{

  $time_difference = 'just now';

}



if ($total_seconds < 60)

{

  $time_difference = $total_seconds == 1 ? $total_seconds . ' second ago' : $total_seconds . ' seconds ago';

}



if ($total_seconds >= 60 && $total_seconds < $intervals['hour'])

{

  $total_seconds = floor($total_seconds/$intervals['minute']);

  $time_difference =  $total_seconds == 1 ? $total_seconds . ' minute ago' : $total_seconds . ' minutes ago';

}



if ($total_seconds >= $intervals['hour'] && $total_seconds < $intervals['day'])

{

  $total_seconds = floor($total_seconds/$intervals['hour']);

  $time_difference =  $total_seconds == 1 ? $total_seconds . ' hour ago' : $total_seconds . ' hours ago';

}



if ($total_seconds >= $intervals['day'] && $total_seconds < $intervals['week'])

{

  $total_seconds = floor($total_seconds/$intervals['day']);

  $time_difference =  $total_seconds == 1 ? $total_seconds . ' day ago' : $total_seconds . ' days ago';

}



if ($total_seconds >= $intervals['week'] && $total_seconds < $intervals['month'])

{

  $total_seconds = floor($total_seconds/$intervals['week']);

  $time_difference =  $total_seconds == 1 ? $total_seconds . ' week ago' : $total_seconds . ' weeks ago';

}



if ($total_seconds >= $intervals['month'] && $total_seconds < $intervals['year'])

{

  $total_seconds = floor($total_seconds/$intervals['month']);

  $time_difference =  $total_seconds == 1 ? $total_seconds . ' month ago' : $total_seconds . ' months ago';

}



if ($total_seconds >= $intervals['year'])

{

  $total_seconds = floor($total_seconds/$intervals['year']);

  $time_difference =  $total_seconds == 1 ? $total_seconds . ' year ago' : $total_seconds . ' years ago';

}



$rat_ing = $feedback['rating'];

$u_images=base_url().'assets/images/avatar2.jpg';

if($feedback['user_thumb_image']!='')

{

  $u_images=base_url().$feedback['user_thumb_image'];

}



$html.='<li class="media">

<a href="'.base_url().'user-profile/'.$feedback['username'].'" class="pull-left"><img width="26" height="26" alt="'.$feedback['fullname'].'" src="'.$u_images.'"></a>

<div class="media-body">

  <div class="feedback-info">

   <div class="feedback-author">

     <a href="'.base_url().'user-profile/'.$feedback['username'].'">'.$feedback['fullname'].'</a>

   </div>

   <span class="feedback-time">'.$time_difference.'</span>



 </div>

 <script type="text/javascript" src="'.base_url().'assets/js/rating.js"></script>

 <div class="feedback-area" ><p>'.$feedback['comment'].'  <span  class="starrr" data-rating="'.$rat_ing.'"></span></p></div>';



 $query = $this->db->query("SELECT feedback.*,members.* FROM `feedback`

  LEFT JOIN members ON members.USERID = feedback.`from_user_id`

  WHERE feedback.`from_user_id` = $userid AND feedback.`to_user_id` = ". $feedback['from_user_id'] ." AND feedback.`order_id` = ". $feedback['order_id'] ." AND feedback.`status` = 1" );

 $result = $query->row_array();

 if(!empty($result)) {

  $u_imagesone=base_url().'assets/images/avatar2.jpg';

  if($result['user_thumb_image']!='')

  {

    $u_imagesone=base_url().$result['user_thumb_image'];

  }

  if($time_zone!=$feedback['time_zone'])

  {

    $date = new DateTime($feedback['created_date'], new DateTimeZone($feedback['time_zone']));

    $date->setTimezone(new DateTimeZone($time_zone));

    $time = $date->format('Y-m-d H:i:s');



    date_default_timezone_set($time_zone);

    $date1= date('Y-m-d H:i:s') ;

    $now = new DateTime($date1);

    $ref = new DateTime($time);

    $diff = $now->diff($ref);

  }

  else

  {

   date_default_timezone_set($time_zone);

   $now = new DateTime(date('Y-m-d H:i:s'));

   $ref = new DateTime($feedback['created_date']);

   $diff = $now->diff($ref);

 }

 $total_seconds = 0 ;

 $days = $diff->days;

 $hours = $diff->h;

 $mins = $diff->i;

 if(!empty($days)&&($days>0))

 {

  $days_to_seconds = $diff->days*24*60*60;

  $total_seconds = $total_seconds+$days_to_seconds;

}

if(!empty($hours)&&($hours>0))

{

  $hours_to_seconds = $diff->h*60*60;

  $total_seconds = $total_seconds+$hours_to_seconds;

}

if(!empty($mins)&&($mins>0))

{

  $min_to_seconds = $mins*60;

  $total_seconds = $total_seconds+$min_to_seconds;

}

$intervals      = array (

  'year' => 31556926, 'month' => 2629744, 'week' => 604800, 'day' => 86400, 'hour' => 3600, 'minute'=> 60

  );

$time_difference = '';

if ($total_seconds == 0)

{

  $time_difference = 'just now';

}



if ($total_seconds < 60)

{

  $time_difference = $total_seconds == 1 ? $total_seconds . ' second ago' : $total_seconds . ' seconds ago';

}



if ($total_seconds >= 60 && $total_seconds < $intervals['hour'])

{

  $total_seconds = floor($total_seconds/$intervals['minute']);

  $time_difference =  $total_seconds == 1 ? $total_seconds . ' minute ago' : $total_seconds . ' minutes ago';

}



if ($total_seconds >= $intervals['hour'] && $total_seconds < $intervals['day'])

{

  $total_seconds = floor($total_seconds/$intervals['hour']);

  $time_difference =  $total_seconds == 1 ? $total_seconds . ' hour ago' : $total_seconds . ' hours ago';

}



if ($total_seconds >= $intervals['day'] && $total_seconds < $intervals['week'])

{

  $total_seconds = floor($total_seconds/$intervals['day']);

  $time_difference =  $total_seconds == 1 ? $total_seconds . ' day ago' : $total_seconds . ' days ago';

}



if ($total_seconds >= $intervals['week'] && $total_seconds < $intervals['month'])

{

  $total_seconds = floor($total_seconds/$intervals['week']);

  $time_difference =  $total_seconds == 1 ? $total_seconds . ' week ago' : $total_seconds . ' weeks ago';

}



if ($total_seconds >= $intervals['month'] && $total_seconds < $intervals['year'])

{



  $total_seconds = floor($total_seconds/$intervals['month']);

  $time_difference =  $total_seconds == 1 ? $total_seconds . ' month ago' : $total_seconds . ' months ago';

}



if ($total_seconds >= $intervals['year'])

{

  $total_seconds = floor($total_seconds/$intervals['year']);

  $time_difference =  $total_seconds == 1 ? $total_seconds . ' year ago' : $total_seconds . ' years ago';

}







$html.='<div class="media">

<a href="'.base_url().'user-profile/'.$result['username'].'" class="pull-left"><img width="26" height="26" alt="'.$result['fullname'].'" src="'.$u_imagesone.'"></a>

<div class="media-body">

  <div class="feedback-info">

    <div class="feedback-author">

     <a href="'.base_url().'user-profile/'.$result['username'].'">'.$result['fullname'].'</a>

   </div>

   <span class="feedback-time">'.$time_difference.'</span>



 </div>

 <p>'.$result['comment'].'</p>

</div>

</div>';



}

$html.=' </div>

</li>';

}

echo json_encode( array('more_data'=>$html,'start_count'=>$html_count,'status'=>$status));

}



public function add_report()
{
  $data=$this->input->post();
  $data_insert["escort_id"]=$data["escort_id"];
  $data_insert["user_name"]=$data["user_name"];
  $data_insert["email"]=$data["email"];
  $data_insert["message"]=$data["message"];
  $data_insert["date_set"]=date("d-M-Y H:m:sa");
  $this->db->insert("admin_report",$data_insert);
  $this->session->set_flashdata("alert","Messade send successfully.");
  redirect(base_url()."".strtolower($data["types"])."/".$data["escort_id"]."/".implode("-",explode(" ", $data["fullname"])));
}
public function load_more_userfeedbacks()

{

  if(($this->session->userdata('time_zone')))

  {

   $time_zone = $this->session->userdata('time_zone');



 }

 else

 {

   $user_ip = getenv('REMOTE_ADDR');

    // $user_ip = '59.97.116.168';

   $geo = unserialize(file_get_contents("http://www.geoplugin.net/php.gp?ip=$user_ip"));

   $geoplugin_latitude = $geo["geoplugin_latitude"];

   $geoplugin_longitude = $geo["geoplugin_longitude"];

   $t=time();

   $result = $this->getTimezoneGeo($geoplugin_latitude,$geoplugin_longitude,$t);

   $time_zone = $result;

 }

 $start = $this->input->post('start');

 $userid = $this->input->post('userid');

 $limit=2;

 $html='';

 $status =0;

 $html_count = intval($start) + intval($limit);

 $limit_cond = " LIMIT " . (int) $start . ", " . (int) $limit;

 $query_feed = $this->db->query("SELECT feedback.*,sell_gigs.title,members.fullname,members.username,members.USERID,`members`.`user_thumb_image`,`members`.`user_profile_image`  FROM `feedback`

   left join members on members.USERID = feedback.`from_user_id`

   left join sell_gigs on sell_gigs.id = feedback.`gig_id`

   WHERE sell_gigs.user_id = $userid AND feedback.to_user_id = $userid AND feedback.`status` = 1 ".$limit_cond);



 $result_set =  $query_feed->result_array();

 if(count($result_set)>0)

 {

  $status =1;

}

foreach($result_set as $key=>$feedback) {

  if($time_zone!=$feedback['time_zone'])

  {

   $date = new DateTime($feedback['created_date'], new DateTimeZone($feedback['time_zone']));

   $date->setTimezone(new DateTimeZone($time_zone));

   $time = $date->format('Y-m-d H:i:s');

   date_default_timezone_set($time_zone);

   $date1= date('Y-m-d H:i:s') ;

   $now = new DateTime($date1);

   $ref = new DateTime($time);

   $diff = $now->diff($ref);

 }

 else

 {

  date_default_timezone_set($time_zone);

  $now = new DateTime(date('Y-m-d H:i:s'));

  $ref = new DateTime($feedback['created_date']);

  $diff = $now->diff($ref);

}

$total_seconds = 0 ;

$days = $diff->days;

$hours = $diff->h;

$mins = $diff->i;

if(!empty($days)&&($days>0))

{

  $days_to_seconds = $diff->days*24*60*60;

  $total_seconds = $total_seconds+$days_to_seconds;

}

if(!empty($hours)&&($hours>0))

{

  $hours_to_seconds = $diff->h*60*60;

  $total_seconds = $total_seconds+$hours_to_seconds;

}

if(!empty($mins)&&($mins>0))

{

  $min_to_seconds = $mins*60;

  $total_seconds = $total_seconds+$min_to_seconds;

}

$intervals      = array (

  'year' => 31556926, 'month' => 2629744, 'week' => 604800, 'day' => 86400, 'hour' => 3600, 'minute'=> 60

  );

$time_difference = '';

        //now we just find the difference

if ($total_seconds == 0)

{

  $time_difference = 'just now';

}



if ($total_seconds < 60)

{

  $time_difference = $total_seconds == 1 ? $total_seconds . ' second ago' : $total_seconds . ' seconds ago';

}



if ($total_seconds >= 60 && $total_seconds < $intervals['hour'])

{

  $total_seconds = floor($total_seconds/$intervals['minute']);

  $time_difference =  $total_seconds == 1 ? $total_seconds . ' minute ago' : $total_seconds . ' minutes ago';

}



if ($total_seconds >= $intervals['hour'] && $total_seconds < $intervals['day'])

{

  $total_seconds = floor($total_seconds/$intervals['hour']);

  $time_difference =  $total_seconds == 1 ? $total_seconds . ' hour ago' : $total_seconds . ' hours ago';

}



if ($total_seconds >= $intervals['day'] && $total_seconds < $intervals['week'])

{

  $total_seconds = floor($total_seconds/$intervals['day']);

  $time_difference =  $total_seconds == 1 ? $total_seconds . ' day ago' : $total_seconds . ' days ago';

}



if ($total_seconds >= $intervals['week'] && $total_seconds < $intervals['month'])

{

  $total_seconds = floor($total_seconds/$intervals['week']);

  $time_difference =  $total_seconds == 1 ? $total_seconds . ' week ago' : $total_seconds . ' weeks ago';

}



if ($total_seconds >= $intervals['month'] && $total_seconds < $intervals['year'])

{

  $total_seconds = floor($total_seconds/$intervals['month']);

  $time_difference =  $total_seconds == 1 ? $total_seconds . ' month ago' : $total_seconds . ' months ago';

}



if ($total_seconds >= $intervals['year'])

{

  $total_seconds = floor($total_seconds/$intervals['year']);

  $time_difference =  $total_seconds == 1 ? $total_seconds . ' year ago' : $total_seconds . ' years ago';

}



$rat_ing = $feedback['rating'];

$u_images=base_url().'assets/images/avatar2.jpg';

if($feedback['user_thumb_image']!='')

{

  $u_images=base_url().$feedback['user_thumb_image'];

}



$html.='<li class="media">

<a href="'.base_url().'user-profile/'.$feedback['username'].'" class="pull-left"><img width="26" height="26" alt="'.$feedback['fullname'].'" src="'.$u_images.'"></a>

<div class="media-body">

  <div class="feedback-info">

   <div class="feedback-author">

     <a href="'.base_url().'user-profile/'.$feedback['username'].'">'.$feedback['fullname'].'</a>

     <span> - </span>

     <a href="'.base_url().'gig_preview/'.$feedback['title'].'">'. str_replace("-"," ",$feedback['title']).'</a>

   </div>

   <span class="feedback-time">'.$time_difference.'</span>



 </div>

 <script type="text/javascript" src="'.base_url().'assets/js/rating.js"></script>

 <div class="feedback-area" ><p>'.$feedback['comment'].'  <span  class="starrr" data-rating="'.$rat_ing.'"></span></p></div>';



 $query = $this->db->query("SELECT feedback.*,members.* FROM `feedback`

  LEFT JOIN members ON members.USERID = feedback.`from_user_id`

  WHERE feedback.`gig_id` = ". $feedback['gig_id'] ." AND feedback.`from_user_id` = ". $feedback['to_user_id'] ." AND feedback.`to_user_id` = ". $feedback['from_user_id'] ." AND feedback.`order_id` = ". $feedback['order_id'] ." AND feedback.`status` = 1" );

 $result = $query->row_array();

 if(!empty($result)) {

  $u_imagesone=base_url().'assets/images/avatar2.jpg';

  if($result['user_thumb_image']!='')

  {

    $u_imagesone=base_url().$result['user_thumb_image'];

  }

  if($time_zone!=$feedback['time_zone'])

  {

    $date = new DateTime($feedback['created_date'], new DateTimeZone($feedback['time_zone']));

    $date->setTimezone(new DateTimeZone($time_zone));

    $time = $date->format('Y-m-d H:i:s');

    date_default_timezone_set($time_zone);

    $date1= date('Y-m-d H:i:s') ;

    $now = new DateTime($date1);

    $ref = new DateTime($time);

    $diff = $now->diff($ref);

  }

  else

  {

   date_default_timezone_set($time_zone);

   $now = new DateTime(date('Y-m-d H:i:s'));

   $ref = new DateTime($feedback['created_date']);

   $diff = $now->diff($ref);

 }

 $total_seconds = 0 ;

 $days = $diff->days;

 $hours = $diff->h;

 $mins = $diff->i;

 if(!empty($days)&&($days>0))

 {

  $days_to_seconds = $diff->days*24*60*60;

  $total_seconds = $total_seconds+$days_to_seconds;

}

if(!empty($hours)&&($hours>0))

{

  $hours_to_seconds = $diff->h*60*60;

  $total_seconds = $total_seconds+$hours_to_seconds;

}

if(!empty($mins)&&($mins>0))

{

  $min_to_seconds = $mins*60;

  $total_seconds = $total_seconds+$min_to_seconds;

}

$intervals      = array (

  'year' => 31556926, 'month' => 2629744, 'week' => 604800, 'day' => 86400, 'hour' => 3600, 'minute'=> 60

  );

$time_difference = '';

                //now we just find the difference

if ($total_seconds == 0)

{

  $time_difference = 'just now';

}



if ($total_seconds < 60)

{

  $time_difference = $total_seconds == 1 ? $total_seconds . ' second ago' : $total_seconds . ' seconds ago';

}



if ($total_seconds >= 60 && $total_seconds < $intervals['hour'])

{

  $total_seconds = floor($total_seconds/$intervals['minute']);

  $time_difference =  $total_seconds == 1 ? $total_seconds . ' minute ago' : $total_seconds . ' minutes ago';

}



if ($total_seconds >= $intervals['hour'] && $total_seconds < $intervals['day'])

{

  $total_seconds = floor($total_seconds/$intervals['hour']);

  $time_difference =  $total_seconds == 1 ? $total_seconds . ' hour ago' : $total_seconds . ' hours ago';

}



if ($total_seconds >= $intervals['day'] && $total_seconds < $intervals['week'])

{

  $total_seconds = floor($total_seconds/$intervals['day']);

  $time_difference =  $total_seconds == 1 ? $total_seconds . ' day ago' : $total_seconds . ' days ago';

}



if ($total_seconds >= $intervals['week'] && $total_seconds < $intervals['month'])

{

  $total_seconds = floor($total_seconds/$intervals['week']);

  $time_difference =  $total_seconds == 1 ? $total_seconds . ' week ago' : $total_seconds . ' weeks ago';

}



if ($total_seconds >= $intervals['month'] && $total_seconds < $intervals['year'])

{



  $total_seconds = floor($total_seconds/$intervals['month']);

  $time_difference =  $total_seconds == 1 ? $total_seconds . ' month ago' : $total_seconds . ' months ago';

}



if ($total_seconds >= $intervals['year'])

{

  $total_seconds = floor($total_seconds/$intervals['year']);

  $time_difference =  $total_seconds == 1 ? $total_seconds . ' year ago' : $total_seconds . ' years ago';

}

$html.='<div class="media">

<a href="'.base_url().'user-profile/'.$result['username'].'" class="pull-left"><img width="26" height="26" alt="'.$result['fullname'].'" src="'.$u_imagesone.'"></a>

<div class="media-body">

  <div class="feedback-info">

    <div class="feedback-author">

     <a href="'.base_url().'user-profile/'.$result['username'].'">'.$result['fullname'].'</a>

   </div>

   <span class="feedback-time">'.$time_difference.'</span>



 </div>

 <p>'.$result['comment'].'</p>

</div>

</div>';

}

$html.=' </div>

</li>';

}

echo json_encode( array('more_data'=>$html,'start_count'=>$html_count,'status'=>$status));

}

public function remove_favourites()

{

  $gig_id = $this->input->post('gig_id');

  $user_id = $this->input->post('user_id');

  $data = array('user_id'=>$gig_id,'gig_id'=>$user_id);

  if($this->db->query("DELETE FROM `favourites` WHERE `user_id` = $user_id AND `gig_id` = $gig_id"))

  {

    echo 1;

  }

}

public function add_favourites()

{

  $data['gig_id'] = $this->input->post('gig_id');

  $data['user_id'] = $this->input->post('user_id');

  if($this->db->insert('favourites',$data))

  {

    echo 1;

  }

}







public function get_country_list()

{

  $country_name = $this->input->get('term');



  $query = $this->db->query("SELECT id,country FROM `country` WHERE `country` LIKE '%$country_name%';");

  $result = $query->result_array();

  $final_array = array();

  foreach ($result as $row) {

  $final_array[] = $row['country'];

}

echo json_encode($final_array);

}



public function update_name()

{

  $data['fullname'] = $this->input->post('updated_name');

  if(($this->session->userdata('SESSION_USER_ID')))

  {

    $user_id = $this->session->userdata('SESSION_USER_ID');

  }

  $this->db->where('USERID',$user_id);

  if($this->db->update('members',$data))

  {

    echo 1;

  }

}

public function update_language()

{

  $data['lang_speaks'] = $this->input->post('updated_name');

  if(($this->session->userdata('SESSION_USER_ID')))

  {

    $user_id = $this->session->userdata('SESSION_USER_ID');

  }

  $this->db->where('USERID',$user_id);

  if($this->db->update('members',$data))

  {

    echo 1;

  }

}

public function language_list()

{

  $lang_name = $this->input->get('term');

  $query = $this->db->query("SELECT DISTINCT(`Language`) FROM `language` WHERE `Language` LIKE'%$lang_name%'; ");

  $result = $query->result_array();

  $final_array = array();

  foreach ($result as $row) {

  $final_array[] = str_replace(" ","-", $row['Language']);//build an array

}

echo json_encode($final_array);

}



public function all_categories()

{



  $caegory_name = $this->input->get('term');



  $query = $this->db->query("SELECT name FROM `categories` WHERE `name` LIKE '%$caegory_name%' AND `status` = 0 ;");

  $result = $query->result_array();

  $final_array = array();

  foreach ($result as $row) {

  $final_array[] = $row['name'];//build an array

}

echo json_encode($final_array);

}



public function common_search($selected_category_id='')

{

  //$this->data['seo_module_name']      = $this->user_panel_model->seo_details('search');

  $common_search = str_replace(" ","-",$this->input->get('term'));

  $query_append = '';

  if(!empty($selected_category_id))

  {

    $query_append = ' AND `category_id` = '. $selected_category_id;

  }

  $query = $this->db->query("SELECT * FROM  `sell_gigs` WHERE  `title` LIKE  '%$common_search%' AND `status` = 0 ".$query_append.";");

  $result = $query->result_array();

  if(!empty($result))

  {

    $final_array = array();

    foreach ($result as $row) {

  $final_array[] = str_replace("-"," ",$row['title']);//build an array

}

}

else

{

  $final_array = array();

  $final_array[] = "No Results Found";

}

echo json_encode($final_array);

}

public function search($start=0)

{

  //$this->data['seo_module_name']      = $this->user_panel_model->seo_details('search');

  $search_value = $this->input->post('common_search');

  $category_id =  $this->input->post('changecatetext');



  $this->data['page_title'] = 'Search';

  if(empty($search_value)&&!empty($category_id))

  {

    $this->load->library('pagination');

    $config['base_url'] = base_url("gigs/search/");

    $config['per_page'] = 15;

    $config['total_rows'] =  $this->gigs_model->common_search_category($category_id,0,0,0);

    $config['full_tag_open'] = '<ul class="pagination">';

    $config['full_tag_close'] = '</ul>';

    $config['first_link'] = 'First';

    $config['first_tag_open'] = '<li>';

    $config['first_tag_close'] = '</li>';



    $config['prev_link'] = '&laquo;';

    $config['prev_tag_open'] = '<li>';

    $config['prev_tag_close'] = '</li>';



    $config['cur_tag_open'] = '<li class="active"><a href="javascript:;">';

    $config['cur_tag_close'] = '</a></li>';

    $config['num_tag_open'] = '<li>';

    $config['num_tag_close'] = '</li>';



    $config['next_link'] = '&raquo;';

    $config['next_tag_open'] = '<li>';

    $config['next_tag_close'] = '</li>';



    $config['last_link'] = 'Last';

    $config['last_tag_open'] = '<li>';

    $config['last_tag_close'] = '</li>';



    $this->pagination->initialize($config);

    $this->data['page'] = 'index';

    $this->data['links'] = $this->pagination->create_links();



    $this->data['list'] =   $this->gigs_model->common_search_category($category_id,$start,$config['per_page'],1);



    $name = '';



    foreach ($this->data['categories_subcategories'] as $value)

    {

      if($value['CATID']==$category_id)

      {

        $name = $value['name'];

        break;

      }

    }

    $this->data['title'] = 'Gigs';

    $this->data['module'] = 'search';

    $this->data['page'] = 'index';

    $this->data['search_value'] = $name;

    $this->data['search_type'] = 'Location';

    $this->data['total_results'] = $config['total_rows'];

    $this->load->vars($this->data);

    $this->load->view($this->data['theme'] . '/template');



  }





  if(!empty($search_value)&&!empty($category_id))

  {

    $this->load->library('pagination');

    $config['base_url'] = base_url("gigs/search/");

    $config['per_page'] = 15;

    if(($this->session->userdata('SESSION_USER_ID')))

    {

      $user_id = $this->session->userdata('SESSION_USER_ID');

    }

    $config['total_rows'] =  $this->gigs_model->common_search($category_id,$search_value,0,0,0);

    $config['full_tag_open'] = '<ul class="pagination">';

    $config['full_tag_close'] = '</ul>';

      //$config['reuse_query_string'] = TRUE;

    $config['first_link'] = 'First';

    $config['first_tag_open'] = '<li>';

    $config['first_tag_close'] = '</li>';



    $config['prev_link'] = '&laquo;';

    $config['prev_tag_open'] = '<li>';

    $config['prev_tag_close'] = '</li>';



    $config['cur_tag_open'] = '<li class="active"><a href="javascript:;">';

    $config['cur_tag_close'] = '</a></li>';

    $config['num_tag_open'] = '<li>';

    $config['num_tag_close'] = '</li>';



    $config['next_link'] = '&raquo;';

    $config['next_tag_open'] = '<li>';

    $config['next_tag_close'] = '</li>';



    $config['last_link'] = 'Last';

    $config['last_tag_open'] = '<li>';

    $config['last_tag_close'] = '</li>';



    $this->pagination->initialize($config);

    $this->data['page'] = 'index';

    $this->data['links'] = $this->pagination->create_links();



    $this->data['list'] =   $this->gigs_model->common_search($category_id,$search_value,$start,$config['per_page'],1);

    $this->data['title'] = 'Gigs';

    $this->data['module'] = 'search';

    $this->data['page'] = 'index';

    $this->data['search_value'] = $search_value;

    $this->data['search_type'] = 'Location';

    $this->data['total_results'] = $config['total_rows'];

    $this->load->vars($this->data);

    $this->load->view($this->data['theme'] . '/template');

  } else {



    if($this->uri->segment(4)==''&&$this->uri->segment(5)=='')

    {

      $search_type    = $this->input->post('search_type');

      $selected_value = $this->input->post('selected_category');

      $selected_value = str_replace(" ","_",$selected_value);

    }

    else

    {

     $search_type    =      $this->uri->segment(5);

     $selected_value =     $this->uri->segment(4);

     $selected_value = str_replace(" ","_",$selected_value);

   }

       // search type country

   if((!empty($search_type))&&( !empty($selected_value ))){

    $this->load->library('pagination');

    $config['base_url'] = base_url("dashboard/search/");

    $config['per_page'] = 15;

    if($search_type==1)

    {

      $config['total_rows'] =  $this->gigs_model->location_base_gigs($selected_value,2,0,0);

      $config['suffix'] = "/".$selected_value."/".$search_type;

    }

    else if ($search_type==2)

    {

      $config['total_rows'] =  $this->gigs_model->category_base_gigs($selected_value,2,0,0);

      $config['suffix'] = "/".$selected_value."/".$search_type;

    }

    $config['full_tag_open'] = '<ul class="pagination">';

    $config['full_tag_close'] = '</ul>';

    $config['first_link'] = 'First';

    $config['first_tag_open'] = '<li>';

    $config['first_tag_close'] = '</li>';



    $config['first_url'] = $config['base_url'] ."/0/".$config['suffix'];



    $config['prev_link'] = '&laquo;';

    $config['prev_tag_open'] = '<li>';

    $config['prev_tag_close'] = '</li>';



    $config['cur_tag_open'] = '<li class="active"><a href="javascript:;">';

    $config['cur_tag_close'] = '</a></li>';

    $config['num_tag_open'] = '<li>';

    $config['num_tag_close'] = '</li>';



    $config['next_link'] = '&raquo;';

    $config['next_tag_open'] = '<li>';

    $config['next_tag_close'] = '</li>';



    $config['last_link'] = 'Last';

    $config['last_tag_open'] = '<li>';

    $config['last_tag_close'] = '</li>';



    $this->pagination->initialize($config);

    $this->data['page'] = 'index';

    $this->data['links'] = $this->pagination->create_links();

    if($search_type==1)

    {

      $this->data['list'] =  $this->gigs_model->location_base_gigs($selected_value,1,$start,$config['per_page']);

      $this->data['search_type'] = 'Location';

    }

    else if($search_type==2)

    {

      $this->data['list'] =  $this->gigs_model->category_base_gigs($selected_value,1,$start,$config['per_page']);

      $this->data['search_type'] = 'Category';

    }

    $this->data['title'] = 'Gigs';

    $this->data['module'] = 'search';

    $this->data['search_value'] = str_replace("_"," ",$selected_value);

    $this->data['total_results'] = $config['total_rows'];

    $this->load->vars($this->data);

    $this->load->view($this->data['theme'] . '/template');

  }

  else

  {

   redirect(base_url());

 }

}



}



public function reminder($offset = 0)

{

  //$this->data['seo_module_name']      = $this->user_panel_model->seo_details('reminder');

  $this->data['gigs_country']             =  $this->gigs_model->gigs_country();
  if(($this->session->userdata('SESSION_USER_ID')))

  {

    $this->load->library('pagination');

    $config['base_url'] = base_url("dashboard/reminder/");

    $config['per_page'] = 16;



    if(($this->session->userdata('SESSION_USER_ID')))

    {

      $user_id = $this->session->userdata('SESSION_USER_ID');

    }



    $config['total_rows'] =  $this->gigs_model->reminder($user_id,0,0,0);



    $config['full_tag_open'] = '<ul class="pagination">';

    $config['full_tag_close'] = '</ul>';

      //$config['reuse_query_string'] = TRUE;

    $config['first_link'] = 'First';

    $config['first_tag_open'] = '<li>';

    $config['first_tag_close'] = '</li>';



    $config['prev_link'] = '&laquo;';

    $config['prev_tag_open'] = '<li>';

    $config['prev_tag_close'] = '</li>';



    $config['cur_tag_open'] = '<li class="active"><a href="javascript:;">';

    $config['cur_tag_close'] = '</a></li>';

    $config['num_tag_open'] = '<li>';

    $config['num_tag_close'] = '</li>';



    $config['next_link'] = '&raquo;';

    $config['next_tag_open'] = '<li>';

    $config['next_tag_close'] = '</li>';



    $config['last_link'] = 'Last';

    $config['last_tag_open'] = '<li>';

    $config['last_tag_close'] = '</li>';



    $this->pagination->initialize($config);

    $this->data['page'] = 'index';

    $this->data['links'] = $this->pagination->create_links();



    $this->data['list'] =   $this->gigs_model->reminder($user_id,1,$offset,$config['per_page']);

    $this->data['page_title'] = 'Favorites';

    $this->data['module'] = 'reminder';

    $this->data['page'] = 'index';

    $this->load->vars($this->data);

    $this->load->view($this->data['theme'] . '/template');

  }

  else

  {

    redirect(base_url());

  }

}



public function last_visited($offset = 0)

{

  //$this->data['seo_module_name']      = $this->user_panel_model->seo_details('last_visited');
  $this->data['gigs_country']             =  $this->gigs_model->gigs_country();
  if(($this->session->userdata('SESSION_USER_ID')))

  {

    $this->load->library('pagination');

    $config['base_url'] = base_url("gigs/last_visited/");

    $config['per_page'] = 16;



    if(($this->session->userdata('SESSION_USER_ID')))

    {

      $user_id = $this->session->userdata('SESSION_USER_ID');

    }



    $config['total_rows'] =  $this->gigs_model->last_visited($user_id,0,0,0);



    $config['full_tag_open'] = '<ul class="pagination">';

    $config['full_tag_close'] = '</ul>';

      //$config['reuse_query_string'] = TRUE;

    $config['first_link'] = 'First';

    $config['first_tag_open'] = '<li>';

    $config['first_tag_close'] = '</li>';



    $config['prev_link'] = '&laquo;';

    $config['prev_tag_open'] = '<li>';

    $config['prev_tag_close'] = '</li>';



    $config['cur_tag_open'] = '<li class="active"><a href="javascript:;">';

    $config['cur_tag_close'] = '</a></li>';

    $config['num_tag_open'] = '<li>';

    $config['num_tag_close'] = '</li>';



    $config['next_link'] = '&raquo;';

    $config['next_tag_open'] = '<li>';

    $config['next_tag_close'] = '</li>';



    $config['last_link'] = 'Last';

    $config['last_tag_open'] = '<li>';

    $config['last_tag_close'] = '</li>';



    $this->pagination->initialize($config);

    $this->data['page'] = 'index';

    $this->data['links'] = $this->pagination->create_links();

    $this->data['page_title'] = 'Last visited gigs';

    $this->data['list'] =   $this->gigs_model->last_visited($user_id,1,$offset,$config['per_page']);

    $this->data['user_favorites']           = $this->gigs_model->add_favourites();

    $this->data['module'] = 'last_visited';

    $this->data['page'] = 'index';

    $this->load->vars($this->data);

    $this->load->view($this->data['theme'] . '/template');



  }

  else

  {

    redirect(base_url());

  }



}



public function profile()

{

 // $this->data['seo_module_name']      = $this->user_panel_model->seo_details('profile');
  $this->data['gigs_country']             =  $this->gigs_model->gigs_country();
  if(($this->session->userdata('SESSION_USER_ID')))

  {

    $user_id = $this->session->userdata('SESSION_USER_ID');

    if($this->input->post('form_submit'))

    {


      $config['upload_path']   = FCPATH.'assets/uploads/'; 
      $config['allowed_types'] = '*';   
         $this->load->library('upload', $config);
         // $cour["file"]=$this->input->post("old_blog_image");
         $new_name = time().$_FILES["videos_name"]['name'];
         $get_file_name=explode(".", $new_name);
         $file_1=$get_file_name["0"].".mp4";
         $file_2=$get_file_name["0"].".ogg";
      
         $config['file_name'] = $file_2;
         $this->load->library('upload', $config);
         $this->upload->initialize($config);
         // $video_name[]="";
        if($this->upload->do_upload('videos_name'))
         {
             $video_name=$this->upload->data("file_name");
            // $video_name["0"]=$name;
        }
        else
        {
          $video_name=$this->input->post('old_videos');
          
        }
      //    $config['upload_path']   = FCPATH.'assets/uploads/'; 
      // $config['allowed_types'] = '*';   
      //    // 
      //    // $cour["file"]=$this->input->post("old_blog_image");
      //    $new_name = time().$_FILES["videos_name"]['name'];
      //    $get_file_name=explode(".", $new_name);
      //    $file_1=$get_file_name["0"].".mp4";
      //        $config['file_name'] = $file_1;
      //    $this->load->library('upload', $config);
      //    // $this->upload->initialize($config);
      //    if($this->upload->do_upload('videos_name'))
      //    {
      //        $name=$this->upload->data("file_name");
      //       $video_name["1"]=$name;
      //   }
      //   else
      //   {
      //     $video_name["1"]="";
          
      //   }  
      $data['phone'] = $this->input->post('user_contact');

      $data['zipcode'] = $this->input->post('user_zip');

      $data['city'] = $this->input->post('user_city');

      $data['address'] = $this->input->post('user_addr');

      $data['description'] = $this->input->post('user_desc');

      $data['country'] = $this->input->post('country_id');

      $data['state'] = $this->input->post('state_id');

      $data['profession'] = $this->input->post('profession');
      
      $data['fullname'] = $this->input->post('user_name');
      
      $data['lname'] = $this->input->post('last_name');
      
      $data['are_you'] = $this->input->post('are_you');

      $data['videos'] = @$video_name;
      // $data['videos'] = implode("*#*", @$video_name);

      $data['lang_speaks'] = $this->input->post('language_tags');



      $this->db->where('USERID',$user_id);

      if($this->db->update('members',$data))

      {

        $message='Profile updated successfully';

        $this->session->set_flashdata('message',$message);

        redirect(base_url().'profile','refresh');



      }

    }

    $this->data['page_title'] = 'Profile Page';

    $this->data['country_list'] = $this->user_panel_model->country_list();

    $this->data['module'] = 'profile';

    $this->data['page'] = 'index';

    $this->data['profession'] =   $this->gigs_model->all_profession();



    $profile = $this->user_panel_model->profile($user_id);

    $query = $this->db->query("SELECT `sortname`,country FROM `country` WHERE `id` =". $profile['country']."");

    $result = $query->row_array();

    $this->data['country_shortname'] = $result['sortname'];

    $this->data['country_name'] = $result['country'];

    $this->data['profile'] = $profile ;

    $this->load->vars($this->data);
    
    $this->load->view($this->data['theme'] . '/template');

  }

  else {

    redirect(base_url());

  }



}





public function password()

{

  $this->data['gigs_country']             =  $this->gigs_model->gigs_country();
  //$this->data['seo_module_name']      = $this->user_panel_model->seo_details('password');

  if(($this->session->userdata('SESSION_USER_ID')))

  {

    $user_id = $this->session->userdata('SESSION_USER_ID');

    if($this->input->post('form_submit'))

    {

      $old_password     = $this->input->post('current_password');

         // if(!empty($old_password))

          //{

      $data['password']     = md5($this->input->post('repeat_password'));

      $this->db->where('USERID',$user_id);

      if($this->db->update('members',$data))

      {

       $message='Password updated successfully';

       $this->session->set_flashdata('message',$message);

       redirect(base_url().'password');

     }

        //  }

   }

   $user_id = $this->session->userdata('SESSION_USER_ID');

   $this->data['module'] = 'password';

   $this->data['page'] = 'index';

   $profile = $this->user_panel_model->profile($user_id);

   $query = $this->db->query("SELECT `sortname`,country FROM `country` WHERE `id` =". $profile['country']."");

   $result = $query->row_array();

   $this->data['country_shortname'] = $result['sortname'];

   $this->data['country_name'] = $result['country'];

   $this->data['profile'] = $profile ;

   $this->data['page_title'] = 'Password';

   $this->load->vars($this->data);

   $this->load->view($this->data['theme'] . '/template');

 }



 else

 {

  redirect(base_url());

}

}





public function payment_settings()
{

  //$this->data['seo_module_name']      = $this->user_panel_model->seo_details('payment_settings');
  $this->data['gigs_country']             =  $this->gigs_model->gigs_country();
  if(($this->session->userdata('SESSION_USER_ID')))

  {
  

    $user_id = $this->session->userdata('SESSION_USER_ID');

    $bank_query = $this->db->query("SELECT * FROM `bank_account` WHERE `user_id` = $user_id ");

    $rows = $bank_query->num_rows();

    if($this->input->post('form_submit'))

    {

     if($rows>0)

     {

      $data['user_name']     = $this->input->post('applicant_name');

      $data['acc_no']     = $this->input->post('account_number');

      $data['bank_name']     = $this->input->post('bank_name');

      $data['bank_addr']     = $this->input->post('bank_addr');

      $data['ifsc_code']     = $this->input->post('ifsc_code');

      $data['pancard_no']     = $this->input->post('pan_no');

      $data['paypal_account']     = $this->input->post('paypal_id');

      $data['user_id']     = $user_id ;

      $data['paypal_email_id']     = $this->input->post('paypal_email_id');



      $this->db->where('user_id',$user_id);

      if($this->db->update('bank_account',$data))

      {

        $message='Your paypal id successfully updated.';

        $this->session->set_flashdata('message',$message);

        redirect(base_url().'payment-settings');

      }

    }

    else

    {

      $data['user_name']     = $this->input->post('applicant_name');

      $data['acc_no']     = $this->input->post('account_number');

      $data['bank_name']     = $this->input->post('bank_name');

      $data['bank_addr']     = $this->input->post('bank_addr');

      $data['ifsc_code']     = $this->input->post('ifsc_code');

      $data['pancard_no']     = $this->input->post('pan_no');

      $data['paypal_account']     = $this->input->post('paypal_id');

      $data['paypal_email_id']     = $this->input->post('paypal_email_id');

      $data['user_id']     = $user_id ;

      if($this->db->insert('bank_account',$data))

      {

        $message='Your paypal id has been successfully updated.';

        $this->session->set_flashdata('message',$message);

        redirect(base_url().'payment-settings');

      }



    }

  }

  $user_id = $this->session->userdata('SESSION_USER_ID');
  $this->data['module'] = 'payment_settings';
  $this->data['page'] = 'index';
  $profile = $this->user_panel_model->profile($user_id);
  $query = $this->db->query("SELECT `sortname`,country FROM `country` WHERE `id` =". $profile['country']."");
  $result = $query->row_array();
  $this->db->where('user_id',$user_id);
  $stripe = $this->db->count_all_results('stripe_bank_details');
  $stripe_details = array(); 
   if($stripe ==1){
    $this->db->where('user_id',$user_id);
    $stripe_details = $this->db->get('stripe_bank_details')->row_array();
   }
  $this->data['list'] = $bank_query->row_array();
  $this->data['country_shortname'] = $result['sortname'];
  $this->data['country_name'] = $result['country'];
  $this->data['profile'] = $profile ;
  $this->data['stripe_details'] = $stripe_details ;
  $this->data['page_title'] = 'Payment Settings';
  $this->load->vars($this->data);

  $this->load->view($this->data['theme'] . '/template');

  }else{
    redirect(base_url());
  }

}

// start of vendor  social profile
public function social_profile()

{

  //$this->data['seo_module_name']      = $this->user_panel_model->seo_details('payment_settings');
  $this->data['gigs_country']             =  $this->gigs_model->gigs_country();
  if(($this->session->userdata('SESSION_USER_ID')))

  {


    $user_id = $this->session->userdata('SESSION_USER_ID');

    $social_query = $this->db->query("SELECT * FROM `social_profile` WHERE `user_id` = $user_id ");

    $rows = $social_query->num_rows();

    if($this->input->post('form_submit'))

    {


     if($rows>0)

     { 
      $data['facebook']     = $this->input->post('facebook');

      $data['instagram']     = $this->input->post('instagram');

      $data['twitter']     = $this->input->post('twitter');

      $data['pinterest']     = $this->input->post('pinterest');

      $data['youtube']     = $this->input->post('youtube');

      $data['linkedin']     = $this->input->post('linkedin');

      $data['snapchat']     = $this->input->post('snapchat');

      $data['blog']     = $this->input->post('blog');

       $data['podcast']     = $this->input->post('podcast');

      $data['user_id']     = $user_id ;

      // $data['paypal_email_id']     = $this->input->post('paypal_email_id');



      $this->db->where('user_id',$user_id);

      if($this->db->update('social_profile',$data))

      {

        $message='Your social profile successfully updated.';

        $this->session->set_flashdata('message',$message);

        redirect(base_url().'social-profile');

      }

    }

    else

    {

      $data['facebook']     = $this->input->post('facebook');

      $data['instagram']     = $this->input->post('instagram');

      $data['twitter']     = $this->input->post('twitter');

      $data['pinterest']     = $this->input->post('pinterest');

      $data['youtube']     = $this->input->post('youtube');

      $data['linkedin']     = $this->input->post('linkedin');

      $data['snapchat']     = $this->input->post('snapchat');

      $data['blog']     = $this->input->post('blog');

      $data['podcast']     = $this->input->post('podcast');

      $data['user_id']     = $user_id ;

      if($this->db->insert('social_profile',$data))

      {

        $message='Your social profile has been successfully updated.';

        $this->session->set_flashdata('message',$message);

        redirect(base_url().'social-profile');

      }



    }

  }

  $user_id = $this->session->userdata('SESSION_USER_ID');
  $this->data['module'] = 'social_profile';
  $this->data['page'] = 'index';
  $profile = $this->user_panel_model->profile($user_id);
  $query = $this->db->query("SELECT `sortname`,country FROM `country` WHERE `id` =". $profile['country']."");
  $result = $query->row_array();
  $this->db->where('user_id',$user_id);
  $stripe = $this->db->count_all_results('stripe_bank_details');
  $stripe_details = array(); 
   if($stripe ==1){
    $this->db->where('user_id',$user_id);
    $stripe_details = $this->db->get('stripe_bank_details')->row_array();
   }
  $this->data['list'] = $social_query->row_array();
  $this->data['country_shortname'] = $result['sortname'];
  $this->data['country_name'] = $result['country'];
  $this->data['profile'] = $profile ;
  $this->data['stripe_details'] = $stripe_details ;
  $this->data['page_title'] = 'Social Profile';
  $this->load->vars($this->data);
  $this->load->view($this->data['theme'] . '/template');

  }else{
    // redirect(base_url());
  }

}

// end of vendor  social profile


public function check_password(){

  $current_password = $this->input->post('current_password');

  if(($this->session->userdata('SESSION_USER_ID')))

  {

    $user_id = $this->session->userdata('SESSION_USER_ID');

    $query = $this->db->query("SELECT `password` FROM `members` WHERE `USERID` = $user_id ;");

    $result = $query->row_array();

    if(!empty($result)){

      if($result['password']==md5($current_password))

      {

        $isAvailable = TRUE;

      }

      else

      {

       $isAvailable = FALSE;

     }

   }

   else{

     $isAvailable = TRUE;

   }

   echo json_encode( array('valid' => $isAvailable ));

 }

 else

 {

   redirect(base_url());

 }

}



public function get_state_list()

{

  $country_id = $this->input->post('country_id');

  $query = $this->db->query("SELECT * FROM `states` WHERE `country_id` = $country_id AND `state_status` = 1");

  $result = $query->result_array();

  $html = '<option value ="">--Select State--</option>';

  foreach($result as $state_list)

  {

    $html .= "<option value = '".$state_list['state_id']."'>".$state_list['state_name']."</option>";

  }

  echo $html;

}





public function prf_crop() {



    //echo $_SERVER['DOCUMENT_ROOT']; exit;

  $error_msg       = '';

  $av_src          = $this->input->post('avatar_src');

  $av_data         = json_decode($this->input->post('avatar_data'),true);

  $av_file         = $_FILES['avatar_file'];

  $src             = 'uploads/profile_images/'.$av_file['name'];

  $imageFileType   = pathinfo($src,PATHINFO_EXTENSION);

  $src2            = 'uploads/profile_images/user_'.$this->session->userdata('SESSION_USER_ID').'_original.'.$imageFileType;

  move_uploaded_file($av_file['tmp_name'], $src2);

  $image_name      = 'user_'.$this->session->userdata('SESSION_USER_ID').'_original.'.$imageFileType;

  $new_name1       = "profile_image_".$this->session->userdata('SESSION_USER_ID')."_200x200.".$imageFileType;

  $data['user_profile_image'] = 'uploads/profile_images/'.$new_name1;

  $image1          = $this->prf_crop_call($image_name,$av_data,$new_name1,200,200);

  $new_name2       = "profile_image_".$this->session->userdata('SESSION_USER_ID')."_150x150.".$imageFileType;

  $image2          = $this->prf_crop_call($image_name,$av_data,$new_name2,150,150);

  $new_name3       = "profile_image_".$this->session->userdata('SESSION_USER_ID')."_50x50.".$imageFileType;

  $data['user_thumb_image'] = 'uploads/profile_images/'.$new_name3;

  $image3          = $this->prf_crop_call($image_name,$av_data,$new_name3,50,50);

  $rand = rand(100,999);

  $user_id = $this->session->userdata('SESSION_USER_ID');

  $this->db->where('USERID',$user_id);

  $this->db->update('members',$data);

  $response = array(

    'state'  => 200,

    'message' => $error_msg,

    'result' => 'uploads/profile_images/'.$new_name1.'?dummy='.$rand,

    'img_name1' => $new_name1

    );

          // if (file_exists($src2)) { unlink($src2);  }

  echo json_encode($response);

}







public function prf_crop_call($image_name,$av_data,$new_name,$t_width,$t_height) {

  $path              = 'uploads/profile_images/';

  $w                 = $av_data['width'];

  $h                 = $av_data['height'];

  $x1                = $av_data['x'];

  $y1                = $av_data['y'];

  list($imagewidth, $imageheight, $imageType) = getimagesize('uploads/profile_images/'.$image_name);

  $imageType                                  = image_type_to_mime_type($imageType);

  $ratio             = ($t_width/$w);

  $nw                = ceil($w * $ratio);

  $nh                = ceil($h * $ratio);

  $newImage          = imagecreatetruecolor($nw,$nh);

  switch($imageType) {

    case "image/gif"  : $source = imagecreatefromgif('uploads/profile_images/'.$image_name);

    break;

    case "image/pjpeg":

    case "image/jpeg" :

    case "image/jpg"  : $source = imagecreatefromjpeg('uploads/profile_images/'.$image_name);

    break;

    case "image/png"  :

    case "image/x-png": $source = imagecreatefrompng('uploads/profile_images/'.$image_name);

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







public function all_gigs($search_type,$start=0)

{

  //$this->data['seo_module_name']      = $this->user_panel_model->seo_details('all_gigs');

  $this->load->library('pagination');

  $config['base_url'] = base_url("gigs/all_gigs/");

  $config['per_page'] = 16;

  $config['total_rows'] =  $this->gigs_model->recent_gigs(2);

  $this->data['list'] =  $this->gigs_model->recent_gigs(1);

  $this->data['page_title'] = 'ALL Gigs';

  if($search_type=='location')

  {

    $config['total_rows'] =  $this->gigs_model->location_base_gigs($this->data['full_country_name'],0,0,0);

    $this->data['list'] =  $this->gigs_model->location_base_gigs($this->data['full_country_name'],1,$start,$config['per_page']);

    $this->data['page_title'] = 'Location Gigs';

  }

  $config['full_tag_open'] = '<ul class="pagination">';

  $config['full_tag_close'] = '</ul>';

  $config['first_link'] = 'First';

  $config['first_tag_open'] = '<li>';

  $config['first_tag_close'] = '</li>';

  $config['prev_link'] = '&laquo;';

  $config['prev_tag_open'] = '<li>';

  $config['prev_tag_close'] = '</li>';

  $config['cur_tag_open'] = '<li class="active"><a href="javascript:;">';

  $config['cur_tag_close'] = '</a></li>';

  $config['num_tag_open'] = '<li>';

  $config['num_tag_close'] = '</li>';

  $config['next_link'] = '&raquo;';

  $config['next_tag_open'] = '<li>';

  $config['next_tag_close'] = '</li>';

  $config['last_link'] = 'Last';

  $config['last_tag_open'] = '<li>';

  $config['last_tag_close'] = '</li>';



  $this->pagination->initialize($config);

  $this->data['page'] = 'index';

  $this->data['links'] = $this->pagination->create_links();

  $this->data['module'] = 'search';

  $this->data['search_value'] = "All Gigs";

  $this->data['total_results'] = $config['total_rows'];

  $this->data['search_type'] = $search_type;

  $this->load->vars($this->data);

  $this->load->view($this->data['theme'] . '/template');



}


// public function user_gigs($user_id)
// {
//   var_dump($user_id);
// }



public function my_gigs($start = 0)

{
  
  $this->data['gigs_country']             =  $this->gigs_model->gigs_country();
  $this->data['gigs_price']         = $this->gigs_model->gig_price();
  if($this->session->userdata('SESSION_USER_ID'))

  {

   // $this->data['seo_module_name']      = $this->user_panel_model->seo_details('my_gigs');

    $user_id = $this->session->userdata('SESSION_USER_ID');
     
    

    $this->load->library('pagination');

    $config['base_url'] = base_url("my-gigs/");

    $config['per_page'] = 16;

    $config['uri_segment'] = 2;

    $config['total_rows'] =  $this->gigs_model->my_gigs(0,$user_id,0,0);



    $config['full_tag_open'] = '<ul class="pagination">';

    $config['full_tag_close'] = '</ul>';

    $config['first_link'] = 'First';

    $config['first_tag_open'] = '<li>';

    $config['first_tag_close'] = '</li>';

    $config['prev_link'] = '&laquo;';

    $config['prev_tag_open'] = '<li>';

    $config['prev_tag_close'] = '</li>';



    $config['cur_tag_open'] = '<li class="active"><a href="javascript:;">';

    $config['cur_tag_close'] = '</a></li>';

    $config['num_tag_open'] = '<li>';

    $config['num_tag_close'] = '</li>';



    $config['next_link'] = '&raquo;';

    $config['next_tag_open'] = '<li>';

    $config['next_tag_close'] = '</li>';



    $config['last_link'] = 'Last';

    $config['last_tag_open'] = '<li>';

    $config['last_tag_close'] = '</li>';



    $this->pagination->initialize($config);

    $this->data['page'] = 'index';

    $this->data['links'] = $this->pagination->create_links();



    $this->data['list'] =  $this->gigs_model->my_gigs(1,$user_id,$start,$config['per_page']);

   $this->data['list_data'] =  $this->gigs_model->my_gigs_all($user_id);    
    // var_dump($this->data['list_data']);
    $this->data['page_title'] = 'My Gigs';

    $this->data['module'] = 'my_gigs';

    $this->data['search_value'] = "My Gigs";

    $this->data['total_results'] = $config['total_rows'];

    $this->data['search_type'] = 'Location';

    $this->data['searched_value'] = " " ;

    $this->data['selected_category_value'] = '';
    $username=$this->gigs_model->get_user_name($user_id);
    $this->data['social_link'] =   $this->gigs_model->get_social_link($username);
    $profile = $this->gigs_model->profile($username);
    $this->data['profile']           = $profile ;


     $suser_id = $user_id;

  $query_feed = $this->db->query("SELECT feedback.*,sell_gigs.title,members.fullname,members.username,members.USERID,`members`.`user_thumb_image`,`members`.`user_profile_image`  FROM `feedback`

   left join members on members.USERID = feedback.`from_user_id`

   left join sell_gigs on sell_gigs.id = feedback.`gig_id`

   WHERE  sell_gigs.user_id = $suser_id AND feedback.to_user_id = $suser_id AND feedback.`status` = 1 ");

  $result_feed =  $query_feed->result_array();

  $this->data['feedbacks'] = $result_feed;

  $query_feed = $this->db->query("SELECT AVG(feedback.rating),count(feedback.id) FROM `feedback`

    left join sell_gigs on sell_gigs.id = feedback.`gig_id`

    WHERE sell_gigs.user_id = $suser_id AND feedback.`to_user_id` = $suser_id;");

  $fe_count = $query_feed->row_array();

  $rat=0;

  $rat_count =0;

  if($fe_count['AVG(feedback.rating)']!='')

  {

   $rat=round($fe_count['AVG(feedback.rating)']);

   $rat_count=round($fe_count['count(feedback.id)']);

 }

 $this->data['user_feedback'] = $rat;

  $this->data['user_feedbackcount'] = $rat_count;
  $query = $this->db->query("SELECT `sortname`,country FROM `country` WHERE `id` =". $profile['country']."");
    $result = $query->row_array();
   $this->data['country_shortname'] = $result['sortname'];
$this->data['user_name_set'] = $profile['username'];
$this->data['user_id'] = $profile['USERID'];
 $this->data['country_name']      = $result['country'];
    $this->load->vars($this->data);

    $this->load->view($this->data['theme'] . '/template');

  }

  else

  {

    redirect(base_url());

  }



}

 public function devicedetails(){



    if($this->input->post()){



      $data = $this->input->post();



      $this->gigs_model->save_device_id($data);

      return 1;

    }



 }





public function logout()

{



  $data = array('LAST_ACTIVITY','dollar_rate','rupee_rate','country_name','time_zone','full_country_name','SESSION_USER_ID','old_timezone','user_role');
 $this->db->query("UPDATE user_login SET login_status='Logout' where USERID='".@$this->session->userdata("SESSION_USER_ID")."'");
  $this->session->unset_userdata($data);

  $this->session->sess_destroy();

  redirect(base_url());

}





}

?>
