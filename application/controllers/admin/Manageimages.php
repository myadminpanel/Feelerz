<?php 
class Manageimages extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->data['theme'] = 'admin';
        $this->data['module'] = 'images';
        $this->load->model('admin_panel_model');
    }
   public function index()
    {
        $this->data['page']='image';
        $this->data['list'] = $this->admin_panel_model->get_images();
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');
    }




public function delet()
{
    $id=$this->uri->segment(4);
    // var_dump($id);
    $this->admin_panel_model->delete_image($id);
     redirect("admin/manageimages");

} 

}


?>