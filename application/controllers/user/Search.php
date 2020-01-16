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
		
	public function index($start=0)
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