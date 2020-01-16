<?php
class Language_management_controller extends CI_Controller
{
	public function __construct()
	{    
    parent::__construct();
    error_reporting(0);
	$this->load->library('form_validation');
    $this->data['module'] = 'language'; 
    $this->data['theme'] = 'admin';
    $this->load->library("pagination");
    $this->load->model('language_management_model','language');
}

	public function language()
	{	

		if($this->input->post()){
			$result = $this->language->language_model();
			if($result==true){
				$this->session->set_flashdata('message','The Language has been added successfully...');
			}else{
				$this->session->set_flashdata('message','Already exists');
			} 
				redirect( base_url('admin/language_management_controller/language'));
		}       
		$this->data['list'] = $this->language->lang_data();
	    $this->data['page'] = 'index';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');
		
	}

	public function add_keyword()
	{

		if($this->input->post()){
			$result = $this->language->keyword_model();
			if($result == true){
				$this->session->set_flashdata('message','The Keyword has been added successfully...');
			}elseif(is_array($result) && count($result)==0){
				$this->session->set_flashdata('message','The Keyword has been added successfully...');
			}elseif(is_array($result) && count($result)> 0){
				$this->session->set_flashdata('message','Already exists'.implode(',',$result));
			} else{
				$this->session->set_flashdata('message','Already exists');
			}
			
				redirect('admin/language_management_controller/add_keyword');
		}       

 		$data = array();
        $conditions['returnType'] = 'count';
        $totalRec = $this->language->getRows($conditions);

        $config['base_url'] = base_url() . 'admin/language_management_controller/add_keyword/'; 

        $config['total_rows']  = $totalRec;

        $config['per_page']    = 10;
        
        $config["uri_segment"] = 4;
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="javascript:void(0);">';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Prev';
        $config['next_tag_open'] = '<li class="pg-next">';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="pg-prev">';
        $config['prev_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $this->pagination->initialize($config);

        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $offset = !$page?0:$page;
        $conditions['returnType'] = '';
        $conditions['start'] = $offset;
        $conditions['limit'] = $config['per_page'];
        $this->data['language_list'] = $this->language->getRows($conditions);

        $this->data['links'] = $this->pagination->create_links();

		$this->data['list'] = $this->language->lang_keyword();
		$this->data['page'] = 'add_keyword';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');
	
	}


	


    
    public function delete_keyword()
		{
		$id = $this->input->post('id');
		$this->db->where('sno',$id);
		 	 
		if($this->db->delete('language_management'))
		{
			
/*			$message="<div class='alert alert-danger text-center fade in' id='flash_succ_message'>Keyword Successfully Deleted.</div>";*/
			$this->session->set_flashdata('message', 'Keyword Successfully Deleted');
			echo 1;
		}
		
		}

		public function update_language_status()
	{
		 $id = $this->input->post('id');
		$status = $this->input->post('update_language');
		$update_data['status'] = $status;
		$this->db->query(" UPDATE `language` SET `status` = ".$status." WHERE `id` = ".$id." ");
	}
		

		public function edit_add_keyword()
		{
			  if($this->input->post('edit_id')){
			  	$data = $this->input->post();
			  	unset($data['form_submit']);
			  	$result =  $this->language->update_keyword_model($data);
			  	if($result){
			  		$this->session->set_flashdata('message', 'update successfully');
			  		redirect(base_url('admin/language_management_controller/add_keyword'));
			  	}
			  } 
			 
			$id = $this->uri->segment(4);
			$this->data['page'] = 'edit_add_keyword';
			$edit_data = '';
			if(!empty($id)){
				$edit_data = $this->language->edit_keyword_model($id);

			}
			$this->data['edit_lang_details'] = $edit_data; 
			

        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');
		}

		public function other_language_keys()
		{
			$data = array();
        $conditions['returnType'] = 'count';
        $totalRec = $this->language->get_keywords($conditions); 

        $config['base_url'] = base_url() . 'admin/language_management_controller/other_language_keys/'; 

        $config['total_rows']  = $totalRec;

        $config['per_page']    = 10;
        
        $config["uri_segment"] = 4; 
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a href="javascript:void(0);">';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_link'] = 'Next';
        $config['prev_link'] = 'Prev';
        $config['next_tag_open'] = '<li class="pg-next">';
        $config['next_tag_close'] = '</li>';
        $config['prev_tag_open'] = '<li class="pg-prev">';
        $config['prev_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li>';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li>';
        $config['last_tag_close'] = '</li>';
        $this->pagination->initialize($config);

        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0; 
        $offset = !$page?0:$page;
        $conditions['returnType'] = '';
        $conditions['start'] = $offset;
        $conditions['limit'] = $config['per_page'];
       
        $this->data['language_list'] = $this->language->get_keywords($conditions);
        $language_list = $this->data['language_list'];
        $this->data['currenct_page_key_value'] = '';
        if(!empty($language_list)){
        $this->data['currenct_page_key_value'] = $this->language->currenct_page_key_value($language_list);
        	
        }

        	$this->data['create_links'] = $this->pagination->create_links(); 
			$result = $this->language->active_language();
			$this->data['page'] = 'other_language_keys';
			$this->data['active_language'] = $result;
			$record = $this->language->active_keyword();
			$this->data['active_keyword'] = $record;
	        $this->load->vars($this->data);
	        $this->load->view($this->data['theme'].'/template');
		}

		public function update_multi_language()
		{
			if ($this->input->post()) {

				$data = $this->input->post(); 
				foreach($data as $row => $object)
				{
					
				 
					if (!empty($object)) {

						foreach ($object as $key => $value) {
							$this->db->where('language', $key);
							$this->db->where('lang_key', $row);
							//$this->db->where('lang_value', $value);
							 
							$record = $this->db->count_all_results('language_management');
							//,'lang_value' =>$value
							if ($record==0) {
								$array = array(
									'language' =>$key,
									'lang_key' =>$row
								);

								$this->db->insert('language_management', $array);
							}else{
								$this->db->where('language', $key);
							    $this->db->where('lang_key', $row);
						     	$this->db->update('language_management', array('lang_value'=> $value));
							}
						}

					}
				}
			}			
			redirect(base_url('admin/language_management_controller/other_language_keys'));
		}
		
}

?>