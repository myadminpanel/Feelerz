<?php 
class Disclaimer extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->data['theme'] = 'admin';
        $this->data['module'] = 'disclaimer';
        $this->load->model('admin_panel_model');
     
    }
    public function index()
    {

        $this->data['page']='legal';
        $this->data['list'] = $this->admin_panel_model->get_disclaimer();
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');


    }
    
    
    
     public function update_disclaimer()
{

    $id = $this->input->post('disclaimerId');
     $countryname = $this->input->post('disclaimerName');
    

    $data=array('disclaimer_content'=>$countryname ); 
    // $status = $this->input->get("status");
    // print_r($update_countrydata);
    // die;
    
    $update=$this->admin_panel_model->updateDisclaimer($data,$id);
    if($update==1){
echo "true";
    }else{
        echo"false";
    }
    redirect("admin/disclaimer");
  


} 
    
    
    
    
    
    
    
    
    
    
    
}
    ?>