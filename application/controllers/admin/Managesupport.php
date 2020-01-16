<?php 
class Managesupport extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->data['theme'] = 'admin';
        $this->data['module'] = 'support';
        $this->load->model('admin_panel_model');
         $this->load->library(array('table','form_validation'));
        $this->load->helper('url');
    }
   public function index()
    {
        $this->data['page']='support';
        $this->data['list'] = $this->admin_panel_model->get_support();
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');
         $this->load->database();
        // $this->load->model('cbc','',TRUE);

        
    }
    
public function resolve(){
    $id=$this->uri->segment(4);
    $this->admin_panel_model->insert_into($id);
    
     
     redirect("admin/managesupport");
    
    
   
    
}






}


?>