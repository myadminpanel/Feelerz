<?php 
class Policy_settings extends CI_Controller
{
    public function __construct() {
        parent::__construct();
        $this->data['theme'] = 'admin';
        $this->data['module'] = 'policy_settings';        
        $this->load->model('admin_panel_model');
    }
     public function index($offset = 0) {      
        $this->load->library('pagination');
        $config['base_url'] = site_url("admin/policy_settings/");
        $config['total_rows'] = $this->db->count_all('policy_settings');
        $config['per_page'] = 15;

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
        $this->data['list'] = $this->admin_panel_model->get_policy_settings($offset,$config['per_page']);                
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');
    }
    public function create()
			{
					if($this->input->post('form_submit'))
			{

			$count=$this->db->query('SELECT id FROM policy_settings where status=0');
			if ( $count->num_rows() <= 3)
			{
			$data['policy_name'] = $this->input->post('policy_name');
			$data['policy_terms'] = $this->input->post('policy_description');
			$data['status'] = 0;
			$this->db->insert('policy_settings',$data);
			$message='<div class="alert alert-success text-center fade in" id="flash_succ_message">Policy Created</div>';
			
			}else{
				$message='<div class="alert alert-danger text-center fade in" id="flash_succ_message">You have already created four policy settings.if you want to create more setting please inactive any one existing policy.</div>';
			}
			$this->session->set_flashdata('message',$message);
			redirect(base_url('admin/policy_settings'));
			
			$this->session->set_flashdata('message',$message);
			redirect(base_url('admin/policy_settings'));	
			}
			$this->data['page'] = 'add_policy';
			$this->load->vars($this->data);
			$this->load->view($this->data['theme'].'/template');
			}
    public function edit($id)
    {
		  if($this->input->post('form_submit'))
        {
            $data['policy_name'] = $this->input->post('policy_name');
            $data['policy_terms'] = $this->input->post('policy_description');
            $data['status'] = $this->input->post('status');
            $this->db->where('id',$id);
            $this->db->update('policy_settings',$data);
			$message='<div class="alert alert-success text-center fade in" id="flash_succ_message">Policy updated</div>';               
		$this->session->set_flashdata('message',$message);
		redirect(base_url('admin/policy_settings'));
		}
        $this->data['list'] = $this->admin_panel_model->edit_policy_settings($id);             
        $this->data['page'] = 'edit_policy';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');
	   }
      public function delete() {   
        $ads_id = $this->input->post('tbl_id');
        $this->db->where('id',$ads_id);
        if($this->db->delete('policy_settings'))
        {
				$message='<div class="alert alert-success text-center fade in" id="flash_succ_message">Policy deleted. </div>';
			
            echo 1;
        }
	   $this->session->set_flashdata('message',$message);
        
    }
}
?>