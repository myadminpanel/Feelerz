<?php 
class Completed_payments extends CI_Controller {
    public $data;
    public function __construct() {
        parent::__construct();
        $this->data['theme']  = 'admin';
        $this->data['module'] = 'Completed_payments';
        $this->load->model('admin_panel_model');  
		$this->data['admin_commision']       = $this->admin_panel_model->admin_commision();
    }

    public function index($offset = 0) {      
        $this->load->library('pagination');
        $config['base_url'] = base_url("admin/completed_payments/");
        $config['per_page'] = 15;
				 
        $config['total_rows'] = $this->admin_panel_model->Completed_payments(0,$offset,$config['per_page']);	 
		 
		
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
		$offset = (int)$this->uri->segment(3);
        $this->data['list'] = $this->admin_panel_model->Completed_payments(1,$offset,$config['per_page']);
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }	
}
?>