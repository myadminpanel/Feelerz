<?php 
class About extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->data['theme'] = 'admin';
        $this->data['module'] = 'abtus';
        $this->load->model('admin_panel_model');
     
    }
    public function index()
    {

        $this->data['page']='index';
        $this->data['list'] = $this->admin_panel_model->get_about();
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');


    }
    
    
    
     public function update_about()
{

    $id = $this->input->post('aboutId');
     $countryname = $this->input->post('aboutName');
    

    $data=array('about_us_content'=>$countryname ); 
    // $status = $this->input->get("status");
    // print_r($update_countrydata);
    // die;
    $update=$this->admin_panel_model->updateAbout($data,$id);
    if($update==1){
echo "true";
    }else{
        echo"false";
    }
    redirect("admin/about");
  


} 
    
    
    
    
    
    
    
    
    
    
    
    
}
    ?>