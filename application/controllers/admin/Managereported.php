<?php 
class Managereported extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->data['theme'] = 'admin';
        $this->data['module'] = 'reported';
        $this->load->model('admin_panel_model');
        //  ob_start();
    }
   public function index()
    {
        $this->data['page']='report';
        $this->data['list'] = $this->admin_panel_model->get_reported();
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');
    }




public function de()
{
    
    $id=$this->uri->segment(4);
    $post_id=$this->uri->segment(5);
    
    
    $query = $this->admin_panel_model->delete_report($id,$post_id);
    
   
//   if($query == 1){
//         echo '<script>alert("Deleted successfully.");</script>';
            
//         }else{ 
//             return false;
//         }
    
    
    
      redirect("admin/managereported");

} 

}


?>