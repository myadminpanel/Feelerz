<?php 
class Search extends CI_Controller{
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


     

    	$this->data['title'] = 'Gigs';
		$this->data['theme'] = 'user';
    	$this->data['module'] = 'search';
		$this->load->model('user_panel_model');
		$this->load->model('gigs_model');
		$this->data['categories_subcategories'] = $this->user_panel_model->categories_subcategories();  
		$this->data['footer_main_menu']         = $this->user_panel_model->footer_main_menu();
        $this->data['footer_sub_menu']          = $this->user_panel_model->footer_sub_menu();
        $this->data['system_setting']           = $this->user_panel_model->system_setting();	
		$this->data['user_favorites']           = $this->gigs_model->add_favourites();   
		 $this->data['client_list']              = $this->user_panel_model->get_client_list();

    $this->data['categories_subcategories'] = $this->user_panel_model->categories_subcategories();

    $this->data['logo']                     = $this->user_panel_model->get_logo();

    $this->data['slogan']                   = $this->user_panel_model->get_slogan();

    $this->data['footer_main_menu']         = $this->user_panel_model->footer_main_menu();

    $this->data['footer_sub_menu']          = $this->user_panel_model->footer_sub_menu();

    $this->data['system_setting']           = $this->user_panel_model->system_setting();

    $this->data['policy_setting']           = $this->user_panel_model->policy_setting();

		$this->load->model('search_model');
		$this->data['gigs_price'] 				= $this->gigs_model->gig_price();
        $this->data['extra_gig_price'] 			= $this->gigs_model->extra_gig_price();
		$this->data['country_list']             = $this->user_panel_model->country_list(); 
		$this->data['gigs_country']             =  $this->gigs_model->gigs_country();

		if($this->input->post('change_country')){
			$country_id = $this->input->post('change_country');		
		}else{
			$country_id = ($this->uri->segment(5))?$this->uri->segment(5):0; 
		}
		$this->data['gigs_country_id'] 	 = $country_id;     
		$this->data['gigs_state'] 	     =  $this->gigs_model->gigs_state($country_id);
		$state_id = 0;
		if($this->input->post('state')){
			$state_id = $this->input->post('state');		
		}else{
			$state_id = ($this->uri->segment(6))?$this->uri->segment(6):0; 
		}
		$this->data['gigs_state_id'] 	 = $state_id; 
	 

	}


public function data_set_searck_button()
{
	$data=$this->input->post("quick_search");
	if(!$data)
	{
		$data=$this->input->post("quick_search_1");
	}	
    if(!$data)
	{
		$data=$this->input->post("quick_search_2");
	}	

	if(!$data)
	{
		$data=$this->input->post("quick_search_3");
	}
	if(!$data)
	{
		$data=$this->input->post("quick_search_4");
	}
	$type=$this->input->post("types");
	
 	redirect(base_url()."search/index/0/".$type."/".implode("-", explode(" ", $data))."/all-state/no-zip-code");



}

public function add_filter()
{

// get reyale work by _

$verified="all";
 $gender="all";
  $available="all";
  $age="all";
  $rates="all";
  $escort_for="all";
  $hayer="all";
  $bust_size="all";
  $body_type="all";
  $ethnicity="all";
   $orienatation="all";
    $call_type="all";
    $types="all";
 $name="all";
 $location="all";
  
  if(@$this->input->post("loation"))
  {
  	$location=implode("__", explode("/",implode("_", explode(" ", $this->input->post("loation")))));
  }
  
   if(@$this->input->post("name"))
   {
      $name=implode("__", explode("/",implode("_", explode(" ", $this->input->post("name")))));
   }
  
  if($this->input->post("type"))
  {
    $types=implode("__", explode("/",$this->input->post("type")));	
  }
  

  if($this->input->post("call_type"))
  {
    $call_type=implode("__", explode("/",implode("_",$this->input->post("call_type"))));
  }
 
  if($this->input->post("orienatation"))
  {
  	  $orienatation=implode("__", explode("/",implode("_", explode(" ", $this->input->post("orienatation")))));
  }

 if(@$this->input->post("ethnicity"))
 {
 	$ethnicity=implode("__", explode("/",implode("_",explode(" ", implode("-",$this->input->post("ethnicity"))))));
 }

 
 if(@$this->input->post("body_type"))
 {
 	$body_type=implode("__", explode("/",implode("_", explode(" ",implode("-",$this->input->post("body_type"))))));
 }

 if(@$this->input->post("bust_size"))
 {
 	$bust_size=implode("__", explode("/",implode("_", explode(" ",implode("-",$this->input->post("bust_size"))))));
 }
 
  
   if(@$this->input->post("hayer"))
 {
 	$hayer=implode("__", explode("/",implode("_", explode(" ", implode("-",$this->input->post("hayer"))))));
 }
 

 if(@$this->input->post("escort_for"))
 {
 	$escort_for=implode("__", explode("/",implode("_", explode(" ", implode("-",$this->input->post("escort_for"))))));
 }

 
 if(@$this->input->post("rates"))
 {
 	$rates=implode("__", explode("/",implode("_", explode(" ", $this->input->post("rates")))));
 }

 
 if(@$this->input->post("age"))
 {
 	$age=implode("__", explode("/",implode("_", explode(" ", $this->input->post("age")))));
 }

 if(@$this->input->post("verified"))
 {
 	$verified=implode("__", explode("/",$this->input->post("verified")));
 }

if(@$this->input->post("gender"))
 {
 	$gender=implode("__", explode("/",implode("_", explode(" ", $this->input->post("gender")))));
 }

 if(@$this->input->post("available"))
 {
 	$available=$this->input->post("available");
 }



  $url=base_url()."search/index/0/".$location."/".$name."/".$types."/".$call_type."/".$orienatation."/".$ethnicity."/".$body_type."/".$bust_size."/".$hayer."/".$escort_for."/".$rates."/".$age."/".$verified."/".$gender."/".$available;
   redirect($url);

  // var_dump($this->input->post("ethnicity"));
  // var_dump($url);
}





public function index()
{


$page_no=0;
$location_get_incript="all";
$location_get="all";
$name_get_incript="all";
$name_get="all";
$types_get_incript="all";
$types_get="all";
$call_type_get_incript="all";
$call_type_get="all";
$orienatation_get_incript="all";
$orienatation_get="all";
$ethnicity_get_incript="all";
$ethnicity_get="all";
$body_type_get_incript="all";
$body_type_get="all";
$bust_size_get_incript="all";
$bust_size_get="all";
$hayer_get_incript="all";
$hayer_get="all";
$escort_for_get_incript="all";
$escort_for_get="all";
$rate_get_incript="all";
$rate_get="all";
$age_get_incript="all";
$age_get="all";
$verified_get_incript="all";
$verified_get="all";
$gender_get_incript="all";
$gender_get="all";
$available_get_incript="all";
$available_get="all";



if(@$this->uri->segment(3))
{
 $page_no=$this->uri->segment(3);	
}
if(@$this->uri->segment(4))
{
    
$location_get=implode(" ",explode("-",implode(" ",explode("_",implode("/",explode("__",$this->uri->segment(4)))))));
$location_get_incript=$this->uri->segment(4);
// var_dump($location);
}
if(@$this->uri->segment(5))
{
 $name_get=implode(" ",explode("-",implode(" ",explode("_",implode("/",explode("__",$this->uri->segment(5)))))));
 $name_get_incript=$this->uri->segment(5);
//  var_dump($name);
}
if(@$this->uri->segment(6))
{
$types_get=implode("/",explode("__",$this->uri->segment(6)));	
$types_get_incript=$this->uri->segment(6);	
// var_dump($types);
}
if(@$this->uri->segment(7))
{
$call_type_get=explode("_",implode("/",explode("__",$this->uri->segment(7))));
$call_type_get_incript=$this->uri->segment(7);
// var_dump($call_type);
}
if(@$this->uri->segment(8))
{
$orienatation_get=implode(" ",explode("-",implode(" ",explode("_",implode("/",explode("__",$this->uri->segment(8)))))));
$orienatation_get_incript=$this->uri->segment(8);
// var_dump($orienatation);
}
if(@$this->uri->segment(9))
{
$ethnicity_get=explode("-",implode(" ",explode("_",implode("/",explode("__",$this->uri->segment(9))))));
$ethnicity_get_incript=$this->uri->segment(9);
// var_dump($ethnicity);
}
if(@$this->uri->segment(10))
{
$body_type_get=explode("-",implode(" ",explode("_",implode("/",explode("__",$this->uri->segment(10))))));
$body_type_get_incript=$this->uri->segment(10);
// var_dump($body_type);
}
if(@$this->uri->segment(11))
{
$bust_size_get=explode("-",implode(" ",explode("_",implode("/",explode("__",$this->uri->segment(11))))));
$bust_size_get_incript=$this->uri->segment(11);
// var_dump($bust_size);
}
if(@$this->uri->segment(12))
{
$hayer_get=explode("-",implode(" ",explode("_",implode("/",explode("__",$this->uri->segment(12))))));
$hayer_get_incript=$this->uri->segment(12);
// var_dump($hayer);
}
if(@$this->uri->segment(13))
{
$escort_for_get=explode("-",implode(" ",explode("_",implode("/",explode("__",$this->uri->segment(13))))));	
$escort_for_get_incript=$this->uri->segment(13);	
// var_dump($escort_for);
}
if(@$this->uri->segment(14)!="all")
{
$rate_get=implode(" ",explode("_",implode("/",explode("__",$this->uri->segment(14)))));
$rate_get_incript=$this->uri->segment(14);
// var_dump($rate);
}
if(@$this->uri->segment(15))
{
$age_get=implode(" ",explode("_",implode("/",explode("__",$this->uri->segment(15)))));
$age_get_incript=$this->uri->segment(15);
// var_dump($age);
}
if(@$this->uri->segment(16))
{
$verified_get=implode("/", explode("__",$this->uri->segment(16)));
$verified_get_incript=$this->uri->segment(16);
// var_dump($verified);
}
if(@$this->uri->segment(17))
{
$gender_get=implode(" ",explode("-",implode(" ",explode("_",implode("/",explode("__",$this->uri->segment(17)))))));	
$gender_get_incript=$this->uri->segment(17);	
}
if(@$this->uri->segment(18))
{
$available_get=$this->uri->segment(18);	

}




 $this->load->model("gigs_model");
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
  
$this->data["page_no"]=$page_no;
$this->data["location_get"]=$location_get;
$this->data["name_get"]=$name_get;
$this->data["types_get"]=$types_get;
$this->data["call_type_get"]=$call_type_get;
$this->data["orienatation_get"]=$orienatation_get;
$this->data["ethnicity_get"]=$ethnicity_get;
$this->data["body_type_get"]=$body_type_get;
$this->data["bust_size_get"]=$bust_size_get;
$this->data["hayer_get"]=$hayer_get;
$this->data["escort_for_get"]=$escort_for_get;
$this->data["rate_get"]=$rate_get;
$this->data["age_get"]=$age_get;
$this->data["verified_get"]=$verified_get;
$this->data["gender_get"]=$gender_get;
$this->data["available_get"]=$available_get;
// var_dump($available_get);
//================================================
$this->data["location_get_incript"]=$location_get_incript;
$this->data["name_get_incript"]=$name_get_incript;
$this->data["types_get_incript"]=$types_get_incript;
$this->data["call_type_get_incript"]=$call_type_get_incript;
$this->data["orienatation_get_incript"]=$orienatation_get_incript;
$this->data["ethnicity_get_incript"]=$ethnicity_get_incript;
$this->data["body_type_get_incript"]=$body_type_get_incript;
$this->data["bust_size_get_incript"]=$bust_size_get_incript;
$this->data["hayer_get_incript"]=$hayer_get_incript;
$this->data["escort_for_get_incript"]=$escort_for_get_incript;
$this->data["rate_get_incript"]=$rate_get_incript;
$this->data["age_get_incript"]=$age_get_incript;
$this->data["verified_get_incript"]=$verified_get_incript;
$this->data["gender_get_incript"]=$gender_get_incript;
$this->data["available_get_incript"]=$available_get_incript;

$start=0;
if(@$this->uri->segment(19))
{
	$start=@$this->uri->segment(19);
}

//start pagination
$this->load->library('pagination');
$config['base_url'] = base_url("search/index/0/".$location_get_incript."/".$name_get_incript."/".$types_get_incript."/".$call_type_get_incript."/".$orienatation_get_incript."/".$ethnicity_get_incript."/".$body_type_get_incript."/".$bust_size_get_incript."/".$hayer_get_incript."/".$escort_for_get_incript."/".$rate_get_incript."/".$age_get_incript."/".$verified_get_incript."/".$gender_get_incript."/".$available_get_incript);
$config['per_page'] = 8;  
$config['uri_segment'] = 19;  
$config['full_tag_open'] = '<ul class="pagination">';
$config['full_tag_close'] = '</ul>';

$config['first_link'] = 'First';
$config['first_tag_open'] = '<li>';
$config['first_tag_close'] = '</li>';
 $time_zone_set_dsp='Asia/Calcutta';
date_default_timezone_set($time_zone_set_dsp);
$corrent_date_in_string=strtotime(date('d-M-Y'));
$data_get=$this->search_model->get_all_user_list_with_all_filters_apply($page_no,$location_get,$name_get,$types_get,$call_type_get,$orienatation_get,$ethnicity_get,$body_type_get,$bust_size_get,$hayer_get,$escort_for_get,$rate_get,$age_get,$verified_get,$gender_get,$available_get,$start,$config['per_page'],$corrent_date_in_string);
$this->data["list"]=$data_get["data"];
// var_dump($location_get_incript);
$addon_value_2=$this->db->query("select * from membership where name='Large home page ad banner'")->row_array();


$this->data["escrrt_of_city"]=$this->search_model->get_ecort_by_city($location_get,$corrent_date_in_string,$addon_value_2["values"]);

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
//end pagination




$this->load->model("gigs_model");
 $this->data['get_all_popular_city']  = $this->gigs_model->get_all_popular_city();

 $this->data['escort_avelavel_now']  = $this->db->query("select a.*,b.photo_status from user_login as a,escort_info as b where b.escort_id=a.USERID and  a.verified='0' and a.status='0' and a.end_date_in_string>=".strtotime(date('d-M-Y'))." and a.login_status='Login'")->result_array();
// var_dump($this->db->last_query());
   
   $this->data['active_users']  = $this->gigs_model->get_all_active_users();
 
  $this->data['total_row'] = $data_get["count"]["USERID"]; 
  $this->data['page_title'] = 'Search'; 
  $this->data['module'] 	= 'search';
  $this->data['page'] 	= 'index';
  $this->load->vars($this->data);    
  $this->load->view($this->data['theme'] . '/template'); 
   
}		

	public function index1($start=0)
	{

		

		if($this->input->get('search_value'))
		{
				$search_value =$this->input->get('search_value'); 
				$category_value = 0;		 
				
				$this->load->library('pagination');
				$config['base_url'] = base_url("search/index/$category_value/$search_value");
						 
				$config['per_page'] = 16;  
				$append_sql = '';
				
				if($search_value!=''&&$search_value!= '0')
				{		
				$append_sql .=  " AND S.gig_tags LIKE '%".$search_value."%' ";
				}
				 
				$query = $this->db->query("SELECT * FROM sell_gigs S LEFT JOIN members M ON M.USERID = S.user_id  WHERE S.status = 0  AND M.status = 0 " . $append_sql);
								
				  $rowcount = $query->num_rows();
				 

				$config['total_rows'] =  $rowcount; 
				$config['uri_segment'] = 5;        
				if($this->uri->segment(5)!='')
				{
				$start = $this->uri->segment(5);
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
				
				$this->data['links'] = $this->pagination->create_links();
			   
				$category_response  	=         $this->search_model->tags_search($search_value,$start,$config['per_page']);  
				 
				
				if(!empty($category_value))
				{
				$category_name  		=         $this->search_model->get_category_name($category_value);  
				$this->data['search_value'] = $category_name['name'];  
				}
				else
				{
				$this->data['search_value'] = $search_value;  
				}
				$this->data['list'] 	= $category_response;
				$this->data['page_title'] = 'Search'; 
				$this->data['module'] 	= 'search';
				$this->data['page'] 	= 'index';
				
				$this->data['searched_value'] = $search_value ;
				$this->data['selected_category_value'] = $category_value;
			   
				$this->data['search_type'] = 'Category';
				$this->data['total_results'] = $config['total_rows'];
				$this->load->vars($this->data);    
				$this->load->view($this->data['theme'] . '/template'); 
					
		}else{
				
				$search_value = $this->input->post('common_search');	
				$country_id = $this->input->post('change_country');	
				$state_id = $this->input->post('state');	
				if(empty($country_id))
				{
					$country_id = 0;
				}
				if(empty($state_id))
				{
					$state_id = 0;
				}
				if(empty($search_value))
				{
					$search_value = 0;
				}
				$category_value = $this->input->post('search_category');
				if(empty($category_value))
				{
					$category_value = 0;
				}	
				 	
						if($this->uri->segment(3)!='')
						{
							$category_value = $this->uri->segment(3);
						}
						if($this->uri->segment(4)!='')
						{
							$search_value = $this->uri->segment(4);
						}
						if($this->uri->segment(5)!='')
						{
							$country_id = $this->uri->segment(5); // Country Id 
						}
						if($this->uri->segment(6)!='')
						{
							$state_id = $this->uri->segment(6); // State Id 
						}
				
				$this->load->library('pagination');
				$config['base_url'] = base_url("search/index/$category_value/$search_value/$country_id/$state_id");
				if($this->uri->segment(7)!='')
				{
				$start = $this->uri->segment(7);				
				$config['uri_segment'] = 7;  
				}	 
				$config['per_page'] = 16;  
				$append_sql = '';
				$category_response  	= '';
				if(!empty($category_value) && $category_value!=0)
				{
						$category_type 	 = $this->search_model->get_parent_details($category_value);							 
						if($category_type['parent']==1)
						{
							$append_sql = " AND category_id = ".$category_value ;
							$category_response = $this->search_model->search($search_value,$category_value,$start,$config['per_page'],$country_id,$state_id);  
						}
						else
						{
							$subcategory_list 	 = $this->search_model->get_subcategory_list($category_value);							
							if($subcategory_list['category_id']!='')
							{			 
							$append_sql 		= " AND category_id IN (".$subcategory_list['category_id'].",".$category_value.")" ;		 
							$category_response  =   $this->search_model->search_subcategory_details_list($search_value,$category_value,$start,$config['per_page'],$country_id,$state_id);  
							}
							else
							{
							$append_sql = " AND category_id = ".$category_value ;
							$category_response  	=         $this->search_model->search($search_value,$category_value,$start,$config['per_page'],$country_id,$state_id);  	
							}
						}						
			
				}
				else
				{      
				if($this->uri->segment(7)!='')
				{
				$start = $this->uri->segment(7);
				}	
				$category_response  	=         $this->search_model->search($search_value,$category_value,$start,$config['per_page'],$country_id,$state_id);  				 
				}
				 
				if($search_value!=''&&$search_value!= '0')
				{		
					$append_sql .=  " AND title LIKE '%".str_replace(' ','-',$search_value)."%' ";
				}
				
				$joins_append = '';
				//if((!empty($country_id) && ($country_id!=0)) || (!empty($state_id) && ($state_id!=0))){
					
					$joins_append =" LEFT JOIN  members as M On M.USERID = SE.user_id "; 

					$append_sql .= " AND  M.status = 0";
				//}	
 
				if(!empty($country_id) && ($country_id!=0)){
					$append_sql .= " AND  M.country = $country_id";
				}
				if(!empty($state_id) && ($state_id!=0)){

					$append_sql .= " AND  M.state = $state_id";
				}
				
				
				$query = $this->db->query("SELECT * FROM sell_gigs AS SE ".$joins_append." WHERE SE.status = 0 " . $append_sql);				
				 $rowcount = $query->num_rows();
				 $this->db->last_query();
				 
				$config['total_rows'] =  $rowcount; 				
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
			   
				
				 
				
				if(!empty($category_value))
				{
				$category_name  		=         $this->search_model->get_category_name($category_value);  
				$this->data['search_value'] = $category_name['name'];  
				}
				else
				{
				$this->data['search_value'] = $search_value;  
				}
				$this->data['list'] 	= $category_response;
				$this->data['page_title'] = 'Search'; 
				$this->data['module'] 	= 'search';
				$this->data['page'] 	= 'index';
				
				$this->data['searched_value'] = $search_value ;
				$this->data['selected_category_value'] = $category_value;
			   
				$this->data['search_type'] = 'Category';
				$this->data['total_results'] = $config['total_rows'];
				//echo '<pre>'; print_r($this->data);
				//exit;
				$this->load->vars($this->data);    
				$this->load->view($this->data['theme'] . '/template'); 	
				}
	}	
	
	
	public function location($start=0)
	{
	$this->load->library('pagination');
        $config['base_url'] = base_url("search/location/");				 
        $config['per_page'] = 16;  
		$country = $this->session->userdata('full_country_name');
		$data = array('country_name'=>$country);		
		$this->db->from('sell_gigs');
        $this->db->where($data);
		$query = $this->db->get();
		$rowcount = $query->num_rows();
        $config['total_rows'] =  $rowcount; 
		        
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
		$category_response  	= $this->search_model->location_base_gigs($country,$start,$config['per_page']);  		 
		$this->data['list'] 	= $category_response;
    	$this->data['page_title'] = 'Search'; 
        $this->data['module'] 	= 'search';
        $this->data['page'] 	= 'index';
        $this->data['search_value'] = $country;  
        $this->data['search_type'] = 'Location';
        $this->data['total_results'] = $config['total_rows'];
        $this->load->vars($this->data);    
        $this->load->view($this->data['theme'] . '/template'); 
 
	}
	
	
	public function recent($start=0)
	{
	$this->load->library('pagination');
        $config['base_url'] = base_url("search/location/");				 
        $config['per_page'] = 16;  		 
		$data = array('status'=> 0);		
		$this->db->from('sell_gigs');
        $this->db->where($data);
		$query = $this->db->get();
		$rowcount = $query->num_rows();
        $config['total_rows'] =  $rowcount; 
		        
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
		$category_response  	= $this->search_model->recent_gigs($start,$config['per_page']);  		 
		$this->data['list'] 	= $category_response;
    	$this->data['page_title'] = 'Search'; 
        $this->data['module'] 	= 'search';
        $this->data['page'] 	= 'index';
        $this->data['search_value'] = 'Recent Gigs';  
        $this->data['search_type'] = 'Recent Gigs';  
        $this->data['total_results'] = $config['total_rows'];
        $this->load->vars($this->data);    
        $this->load->view($this->data['theme'] . '/template'); 
 
	}
	
	 public function category($start=0)
        {
        $this->load->library('pagination');
        if($this->input->get('search_value'))
        {
        $search_value 	= str_replace("-",' ',$this->input->get('search_value')); 
		$append_suffix	= "/?search_value=".$search_value;
        }
        $config['base_url'] = base_url("search/category/");				 
        $config['per_page'] = 16;  	 
        $category_id	 = $this->search_model->get_category_id($search_value);		 
		$category_type 	 = $this->search_model->get_parent_details($category_id['CATID']);		 		 
        if($category_type['parent']==1)
		{
        $data = array('status'=> 0 ,'category_id'=>$category_id['CATID']);		
        $this->db->from('sell_gigs');
        $this->db->where($data);
        $query = $this->db->get();
        $rowcount = $query->num_rows();
        $config['total_rows'] 	=  $rowcount; 
		$category_response  	= $this->search_model->category_search($category_id['CATID'],$start,$config['per_page']);  		 
		}
		else
		{
		$category_list = $this->search_model->search_subcategory_total($category_id['CATID']);
		$config['total_rows'] 	=  $category_list ; 		 
		$category_response  	=  $this->search_model->search_subcategory_details($category_id['CATID'],$start,$config['per_page']);  		 
		}
		        
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
		$config['uri_segment'] = 3 ;
		$config['suffix'] = $append_suffix;
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
       
        $this->data['list'] 	= $category_response;
    	$this->data['page_title'] = 'Search'; 
        $this->data['module'] 	= 'search';
        $this->data['page'] 	= 'index';
        $this->data['search_value'] = $search_value ;  
        $this->data['search_type'] = $search_value ;  
		$this->data['selected_category_value'] = $category_id['CATID'];
        $this->data['total_results'] = $config['total_rows'];
        $this->load->vars($this->data);    
        $this->load->view($this->data['theme'] . '/template'); 
            
        }
	
	
	}
?>