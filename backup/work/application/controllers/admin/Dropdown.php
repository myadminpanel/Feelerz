<?php 
class Dropdown extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->data['theme'] = 'admin';
        $this->data['module'] = 'manage-dropdown';
        $this->load->model('admin_panel_model');
    }
    public function index()
    {    
        $this->data['page'] = 'index';      
        $this->data['list'] = $this->admin_panel_model->dropdown();        
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');        
    }

    public function get_one_drop()
    {
        $id=$this->input->post("id");
        $this->data['data']=$this->admin_panel_model->dropdown_value($id);
         // $this->data['page'] = 'edit'; 
        $this->load->vars($this->data);
        $this->load->view("admin/modules/manage-dropdown/edit");  

    }

    public function update_drop_down()
    {
        $data=$this->input->post();
        $this->admin_panel_model->update_drop_value($data);
        $this->session->set_flashdata('message','Your data is Updated.');
        redirect(base_url().'admin/manage-dropdown');
    }

      public function user_set_operation()
{
     $ids=$this->input->post("id");
   
     $operation=$this->input->post("operation");
       

       $this->admin_panel_model->set_status_dropdown($ids,$operation);
        // $this->admin_panel_model->delete_users_post_dsp($ids); 
         // redirect(base_url().'admin/manage-dropdown');
}
}
?>