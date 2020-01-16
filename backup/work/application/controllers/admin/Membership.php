<?php 
class Membership extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->data['theme'] = 'admin';
        $this->data['module'] = 'manage-membership';
        $this->load->model('admin_panel_model');
    }


public function update_addon()
{
  $data=$this->input->post();
  $this->admin_panel_model->update_addon($data);
  $this->session->set_flashdata('alert','Addon is Updated.');
  redirect(base_url().'admin/manage-membership');    
}

public function get_one_addone()
{
  $id=$this->input->post("id");
  $data=$this->db->query("select * from membership where id='".$id."'")->row_array();
        // $this->data['page'] = 'edit_addon';      
        // $this->data['data'] = $data;      
               
        $this->load->vars($this->data);
        $this->load->view("/admin/modules/manage-membership/edit_addon",array("data"=>$data)); 
}


    
    public function index()
    {    
        $this->data['page'] = 'index';      
        $this->data['list'] = $this->admin_panel_model->membership();        
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');        
    }
 public function user_set_operation()
{
     $ids=$this->input->post("id");
   
     $operation=$this->input->post("operation");
       

       $this->admin_panel_model->set_status_package($ids,$operation);
        // $this->admin_panel_model->delete_users_post_dsp($ids); 
         // redirect(base_url().'admin/manage-dropdown');
}

public function add_addon()
{
  $data=$this->input->post();
  $this->admin_panel_model->insert_addon($data);
  $this->session->set_flashdata('alert','Addon is created.');
  redirect(base_url().'admin/manage-membership');   

}

    public function edit_membership($id)
    {
        
        $this->data['page'] = 'edit-membership';      
        // $this->data['list'] = $this->admin_panel_model->membership();   
        $this->data['list'] = $this->admin_panel_model->edit_membership($id);
        $this->data['service_name'] = $this->admin_panel_model->get_service_name();

        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');  
    }
    public function add_membership()
    {
        // $this->data['insert_category'] = $this->admin_panel_model->insert_membership();       
        if($this->input->post())
        {
            // var_dump($this->input->post());
             $check_name="";
               // $check_name=$this->admin_panel_model->check_membership($this->input->post()); 
              if($check_name)
              {
                $this->session->set_flashdata('alert','Package name already exist.');
                redirect(base_url().'admin/manage-membership');                
              }
              else
              {
                 $this->admin_panel_model->insert_membership($this->input->post());

             redirect(base_url().'admin/manage-membership');
              }
            
        }
        $this->data['service_name'] = $this->admin_panel_model->get_service_name();  
        $this->data['page'] = 'add-membership';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');        

        
    }
    public function get_one_service()
    {
        $id=$this->input->post("id");
        // var_dump($id);
        $this->data['list_data']=$this->admin_panel_model->member_service($id);
         // $this->data['page'] = 'edit'; 
        // var_dump($this->data['data']);
        $this->load->vars($this->data);
        $this->load->view("admin/modules/manage-membership/edit");  
    }
     public function update_membership()
    {
        $data=$this->input->post();
        // var_dump($data);
         // $check_name=$this->admin_panel_model->check_membership_edit($this->input->post()); 
        $check_name="";
         // var_dump($check_name);
              if($check_name)
              {
                $this->session->set_flashdata('alert','Package name already exist.');
                redirect(base_url().'admin/manage-membership');                
              }
              else
              {
            $this->admin_panel_model->update_membership($data);
        $this->session->set_flashdata('message','Your data is Updated.');
        redirect(base_url().'admin/manage-membership');        
              }
        
    }

}
?>