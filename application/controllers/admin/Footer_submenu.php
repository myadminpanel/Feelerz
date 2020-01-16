<?php 
class Footer_submenu extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->data['theme'] = 'admin';
        $this->data['module'] = 'footer_submenu';
        $this->load->model('admin_panel_model');
        $this->data['main_menu'] = $this->admin_panel_model->get_all_footer_menu();
         $this->load->helper('ckeditor'); 
 		// Array with the settings for this instance of CKEditor (you can have more than one)
		$this->data['ckeditor_editor1'] = array
		(
			//id of the textarea being replaced by CKEditor
			'id'   => 'ck_editor_textarea_id',
 			// CKEditor path from the folder on the root folder of CodeIgniter
			'path' => 'assets/js/ckeditor',
 			// optional settings
			'config' => array
			(
				'toolbar' => "Full",
				'filebrowserBrowseUrl'      => base_url().'assets/js/ckfinder/ckfinder.html',
				'filebrowserImageBrowseUrl' => base_url().'assets/js/ckfinder/ckfinder.html?Type=Images',
				'filebrowserFlashBrowseUrl' => base_url().'assets/js/ckfinder/ckfinder.html?Type=Flash',
				'filebrowserUploadUrl'      => base_url().'assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
				'filebrowserImageUploadUrl' => base_url().'assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
				'filebrowserFlashUploadUrl' => base_url().'assets/js/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
			)
		);  
    }
    
    
    public function index($offset = 0) {

        $this->load->library('pagination');
        $config['base_url'] = site_url("admin/footer_submenu/");
        $config['total_rows'] = $this->admin_panel_model->get_all_footer_submenu(1);
        $config['per_page'] = 20;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';

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
        $this->data['page'] = 'index';
        $this->data['lists'] = $this->admin_panel_model->get_footer_submenu($config['per_page'], $offset);
        $this->data['links'] = $this->pagination->create_links();
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');  
    }
    
    public function create()
    {
        $this->data['page'] = 'create';                
        if($this->input->post('form_submit'))
        {
            $data['footer_menu'] = $this->input->post('main_menu');
            $value = $this->input->post('sub_menu');                                         
            $data['footer_submenu'] = str_replace(' ','_',$value);
            $data['page_desc'] = $this->input->post('page_desc');
            $data['status'] = $this->input->post('status');
            if($this->db->insert('footer_submenu',$data))
            {
				$message="<div class='alert alert-success text-center fade in' id='flash_succ_message'>footer menu created successfully.</div>";
			     
            }
               $this->session->set_flashdata('message',$message);
                redirect(base_url().'admin/footer_submenu');
        }
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');
    }
    public function edit($id)
    {
        $this->data['page'] = 'edit';        
        $this->data['datalist'] = $this->admin_panel_model->edit_submenu($id);
        if($this->input->post('form_submit'))
        {
            $data['footer_menu'] = $this->input->post('main_menu');
            $value = $this->input->post('sub_menu');                                         
            $data['footer_submenu'] = str_replace(' ','_',$value);
            $data['page_desc'] = $this->input->post('page_desc');
            $data['status'] = $this->input->post('status');
            $this->db->where('id',$id);
            if($this->db->update('footer_submenu',$data))
            {
					  $message="<div class='alert alert-success text-center fade in' id='flash_succ_message'>footer menu edited successfully.</div>";
			      
            }
			   $this->session->set_flashdata('message',$message);
                redirect(base_url().'admin/footer_submenu');
        }
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');        
    }
    public function delete_footer_submenu() { 
		
			$id = $_POST['tbl_id'];                      
			if (!empty($id)) 
                        {
                   $this->db->delete('footer_submenu', array('id' => $id));   
                   $message="<div class='alert alert-success text-center fade in' id='flash_succ_message'>footer menu deleted successfully.</div>";
			     			
			echo 1;                        
                        }     
			  $this->session->set_flashdata('message',$message);			
    }
    
}
?>