<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Footer_menu extends CI_Controller {

    public $data;

    public function __construct() {
        parent::__construct();
        $this->data['theme'] = 'admin';
        $this->data['module'] = 'footer_menu';
          $this->load->model('admin_panel_model');   
	 
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
        $config['base_url'] = site_url("admin/footer_menu/");
        $config['total_rows'] = $this->db->count_all('page');
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
        $this->data['lists'] = $this->admin_panel_model->get_footer_menu($config['per_page'], $offset);
        $this->data['footercount'] = $this->admin_panel_model->footercount();
        $this->data['links'] = $this->pagination->create_links();
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');  
    }
    
    public function create() {
        
        if ($this->input->post('form_submit')) {	
            
            str_replace("world","Peter","Hello world!");
            
                                $value = $this->input->post('menu_name');
				$table_data['title'] = str_replace(' ','_',$value);
				
				if ($this->db->insert('footer_menu', $table_data)) {
					$message='<div class="alert alert-success text-center fade in" id="flash_succ_message">footer widget added successfully. </div>';
			      $this->session->set_flashdata('message',$message);
                                redirect(base_url('admin/' . $this->data['module']));
                                        	}
			
        }
        $this->data['page'] = 'create';
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'] . '/template');
    }

    public function edit($cls_id) {
      
    $current_date = date('Y-m-d H:i:s');
        if (!empty($cls_id)) {
            if ($this->input->post('form_submit')) {			
					$value = $this->input->post('menu_name');
                                        $table_data['title'] = str_replace(' ','_',$value);                                        
                                        $this->db->update('footer_menu', $table_data, "id = " . $cls_id);
											$message='<div class="alert alert-success text-center fade in" id="flash_succ_message">footer widget edited successfully. </div>';
			         $this->session->set_flashdata('message',$message);
					redirect(base_url('admin/' . $this->data['module']));          
            }            
            $this->data['datalist'] = $this->admin_panel_model->edit_footer_menu($cls_id);	    
            $this->data['page'] = 'edit';
            $this->load->vars($this->data);
            $this->load->view($this->data['theme'] . '/template');
        } else {
            redirect(base_url('admin/' . $this->data['module']));
        }
    }

			public function delete_footer_menu() { 
	
			$id = $_POST['tbl_id'];                      
			if (!empty($id)) 
			{
			$this->db->delete('footer_menu', array('id' => $id));         
			$message='<div class="alert alert-success text-center fade in" id="flash_succ_message">footer widget delete successfully. </div>';

			echo 1;                        
			}     
			$this->session->set_flashdata('message',$message);
			}
    public function notification($pag_id){
        $page_id = $pag_id;
        $this->db->set('notify_status', '1', FALSE);
        $this->db->where('page_id', $pag_id);
        $this->db->update('page');
    redirect(base_url("admin/page/edit/".$page_id));
        }
        
    
     }

/* End of file users.php */
/* Location: ./application/controllers/admin/users.php */