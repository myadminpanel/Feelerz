<?php 
class Profession extends CI_Controller {
    public $data;
    public function __construct() {
        parent::__construct();
        $this->data['theme'] = 'admin';
        $this->data['module'] = 'profession';
        $this->load->model('admin_panel_model');         
    }

    public function index($offset = 0) {      
        $this->load->library('pagination');
        $config['base_url'] = site_url("admin/profession/");
        $config['per_page'] = 15;
				 
        $config['total_rows'] = $this->db->count_all_results('profession');
		
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
        $this->data['list'] = $this->admin_panel_model->all_profession($offset,$config['per_page']);
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }	
	
	public function create()
	{
		if($this->input->post('form_submit'))	
		{
			$data['profession_name'] = $this->input->post('profession');
			if($this->db->insert('profession',$data))
			{
			$message='<div class="alert alert-success text-center fade in" id="flash_succ_message">Profession create successfully.</div>';
			}
			$this->session->set_flashdata('message',$message);
			redirect(base_url().'admin/profession');			
		}
		   $this->data['page'] = 'create';
		   $this->load->vars($this->data);
	       $this->load->view($this->data['theme'] . '/template');
	}
	public function check_profession()
	{
		$Profession =  $this->input->post('profession');    
		$result = $this->admin_panel_model->check_profession($Profession);
		 if ($result > 0) {
				 $isAvailable = FALSE;
		   } else {               
					 $isAvailable = TRUE;
		   }
		   
		   echo json_encode(
				   array(
						   'valid' => $isAvailable
				   ));
	}
	public function edit($id)
	{
		if($this->input->post('form_submit'))	
		{
			$data['profession_name'] = $this->input->post('profession');
			$data['status'] = $this->input->post('status');
			$this->db->where('id',$id);
			if($this->db->update('profession',$data))
			{
			$message='<div class="alert alert-success text-center fade in" id="flash_succ_message">Profession edit successfully.</div>';
			}
			$this->session->set_flashdata('message',$message);
			redirect(base_url().'admin/profession');	
		}
		   $this->data['list'] =	$this->admin_panel_model->edit_profession($id);
		   $this->data['page'] =    'edit';
		   $this->load->vars($this->data);
	       $this->load->view($this->data['theme'] . '/template');
		
	}
	
	public function delete()
	{
		$id = $this->input->post('tbl_id'); 
		$this->db->where('id',$id);
		if($this->db->delete('profession'))
		{
		 $message='<div class="alert alert-success text-center fade in" id="flash_succ_message">Profession deleted successfully.</div>';
			
			echo 1;
		}
		   $this->session->set_flashdata('message',$message);
	}
	
	public function process_payment()
	{
	$payment_id = $this->input->post('payment_id');	
	if(!empty($payment_id))
	{
		echo 1;
	}
	}
}

?>