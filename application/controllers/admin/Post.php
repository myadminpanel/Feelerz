<?php 
class Post extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->data['theme'] = 'admin';
        $this->data['module'] = 'post';
        $this->load->library('pagination');
        $this->load->model('admin_panel_model');
        ob_start();
    }
   public function index()
    {

//set pagination start
$this->load->library('pagination');

if($this->uri->segment(4))
{
    $start=$this->uri->segment(4);
}
else
{
    $start=0;
}


$config['base_url'] = base_url("admin/post/index/");
$config['per_page'] = 10;  
$config['uri_segment'] = 4;
$config['num_links'] = 1;  
$config['full_tag_open'] = '<ul class="pagination">';
$config['full_tag_close'] = '</ul>';


$config['first_link'] = 'First';
$config['first_tag_open'] = '<li>';
$config['first_tag_close'] = '</li>';
// $limit_set=$start;
$data_get=$this->admin_panel_model->get_post($start,$config['per_page']);
$this->data["list"]=$data_get;

$total_psot_data=$this->db->query("SELECT count(id) as total_work FROM post")->row_array();

$total_post=$total_psot_data["total_work"];

$config['prev_link'] = '&laquo;';
$config['prev_tag_open'] = '<li>';
$config['prev_tag_close'] = '</li>';

$config['total_rows'] =$total_post;

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

$this->data['links'] = $this->pagination->create_links();
$this->data['page'] = "index";
//set pagination end

// var_dump($this->data['links']);
// View data according to array.
$this->load->vars($this->data);
$this->load->view($this->data['theme'].'/template');



}


   public function d(){
     $id=$this->uri->segment(4);
    // var_dump($id);
   $query = $this->admin_panel_model->delete_post($id);
   
//   if($query == 1){
//         echo '<script>alert("Deleted successfully.");</script>';
            
//         }else{ 
//             return false;
//         }
    
    
    
     redirect("admin/post");

}



}


?>