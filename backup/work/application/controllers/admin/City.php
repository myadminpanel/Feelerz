<?php 
class City extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->data['theme'] = 'admin';
        $this->data['module'] = 'manage-city';
        $this->load->model('admin_panel_model');
    }
    public function index()
    {    
        $this->data['page'] = 'index';      
        $this->data['list'] = $this->admin_panel_model->Location();        
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');        
    }
    public function get_one_city()
    {
        $id=$this->input->post("id");
        $this->data['data']=$this->admin_panel_model->city_value($id);
         // $this->data['page'] = 'edit'; 
        $this->load->vars($this->data);
        $this->load->view("admin/modules/manage-city/edit");  

    }
      public function update_city()
    {
        $data=$this->input->post();
        $check_data=$this->admin_panel_model->check_state_city($data);
        if($check_data)
        {
              $this->admin_panel_model->update_city_value($data);
        $this->session->set_flashdata('message','Your data is Updated.');
        }
        else
        {
             $this->session->set_flashdata('alert','State and city is already exit.');
        }
      
        redirect(base_url().'admin/manage-city');
    }
    public function city_set_operation()
{
     $ids=$this->input->post("id");
   
     $operation=$this->input->post("operation");
       $this->admin_panel_model->city_status_update($ids,$operation);
        // $this->admin_panel_model->delete_users_post_dsp($ids); 
         // redirect(base_url().'admin/manage-city');
}
}
?>