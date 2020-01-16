<?php 
class Review extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->data['theme'] = 'admin';
        $this->data['module'] = 'review';
        $this->load->model('admin_panel_model');  
    }
    public function index ($offset=0)
    {
        $this->load->library('pagination');
        $config['base_url'] = base_url("admin/review/");
        $config['per_page'] = 15;
                                
        $config['total_rows'] =  $this->db->count_all('feedback');
        
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
        $this->data['list'] = $this->admin_panel_model->get_review($offset,$config['per_page']);
        $this->data['links'] = $this->pagination->create_links();
        $this->data['page'] = 'index';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');
    }    
    public function edit($review_id)
    {
        $this->data['page'] = 'edit_review';
        $this->data['list'] = $this->admin_panel_model->edit_review($review_id);  
		if($this->input->post('form_submit'))
        {  
	     
            $data['status'] = $this->input->post('status');
            $this->db->where('id' ,$review_id);
            if($this->db->update('feedback',$data))
            {
                redirect(base_url().'admin/review');
            }
        }        
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');        
    }
    public function delete()
    {
        $id = $this->input->post('tbl_id');
        $this->db->where('id',$id);
        if($this->db->delete('feedback'))
        {
            echo 1;
        }
        
    }
}
?>