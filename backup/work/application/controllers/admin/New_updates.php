<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class New_updates extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->data['theme'] = 'admin';
		$this->data['module'] = 'new_updates';
		$this->load->model('New_update_model','updates');
		error_reporting(0);
		if($this->session->userdata('id')==2){ 
			redirect(base_url('admin'));
		}
	}

	public function import_sql()
	{

		$this->backup_db_automatic();

// Temporary variable, used to store current query
		$templine = '';
// Read in entire file
		$lines = file(base_url().'/uploads/db.sql');
// Loop through each line
		foreach ($lines as $line)
		{
// Skip it if it's a comment
			if (substr($line, 0, 2) == '--' || $line == '')
				continue;

// Add this line to the current segment
			$templine .= $line;
// If it has a semicolon at the end, it's the end of the query
			if (substr(trim($line), -1, 1) == ';')
			{
    // Perform the query
				$this->db->query($templine);
    // Reset temp variable to empty
				$templine = '';
			}
		}

		
	}

	public function index()
	{	
		$datas['backups'] = $this->updates->get_all_backups();
		$datas['updates'] = $this->updates->get_all_updates();
		$this->data['page'] = 'index';	
		$this->load->vars($this->data);
		$this->load->view($this->data['theme'] . '/template',$datas);  
	}


	Public function get_updates()
	{

		$ch = curl_init();
		$options = array(
			CURLOPT_URL => 'https://www.dreamguys.co.in/gigs_updates/',
			CURLOPT_RETURNTRANSFER => true
			);

		if (!ini_get('safe_mode') && !ini_get('open_basedir')) {
			$options[CURLOPT_FOLLOWLOCATION] = true;
		}
		curl_setopt_array($ch, $options);            
		$output = curl_exec($ch);
		curl_close($ch);

		$updates = json_decode($output, TRUE);           
		$check_updates = $this->updates->check_updates($updates['build']);
		if($check_updates==0){
			echo $output;
		}else{
			echo json_encode(array('error'=>'No Updates'));
		}


	}

	Public function upload_updates()
	{
		$config['upload_path']          = 'application/';
		$config['allowed_types']        = 'zip';	

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload('upload_file')){			
			$status['error'] = $this->upload->display_errors();
		}else{
			$data = array('upload_data' => $this->upload->data());
			$zip = new ZipArchive;
			$file = $data['upload_data']['full_path'];
			chmod($file,0777);
			if ($zip->open($file) === TRUE) {
				$zip->extractTo('./');
				$zip->close();
				$status['success'] = true;
				$datas = $this->get_update_datas();
				$this->updates->updated_file($datas);
				unlink($file);
				rename(FCPATH.'/application/db.sql','./uploads/db.sql');
				$this->import_sql();

			} else {
				$status['error'] = 'File cannot updated ! try again later ';
			}
		}
		echo json_encode($status);
	}


	Public function backup_db() {
        
        $this->mysql_backup();
        if (!is_dir('./backup/')) {           
             $this->session->set_flashdata('message', 'Create a folder named backup in resource folder !'); 
            redirect(base_url().'admin/new_updates');
        }
        if (!is_writeable("./backup/")) {
           $this->session->set_flashdata('message', 'Files backup failed cannot write to backup folder !'); 
            redirect(base_url().'admin/new_updates');
        }

        ini_set('memory_limit', '-1');

        $ignore = array("./backup");

        $this->load->library('zip');
        $path = './';
        $filename = 'full_backup_'.rand().'_'.date('Y-m-d') . '.zip';
        $this->zip->read_dir($path,TRUE, NULL, $ignore);
        $this->zip->archive('./backup/'.$filename);
        $this->updates->update_backup($filename);
    	redirect(base_url().'admin/new_updates');
    }



	Public function mysql_backup()
	{

		$this->load->dbutil();
		$prefs = array('format' => 'zip', 'filename' => 'full_backup_'.rand().'_'.date('Y-m-d'));

		$backup = &$this->dbutil->backup($prefs);
		$filename = 'database-full-backup_'.rand().'_'.date('Y-m-d') . '.zip';
		if (!write_file('./backup/'.$filename, $backup)) {
			$this->session->set_flashdata('message', 'Database backup failed cannot write to backup folder !');            
		}else{			
			$this->session->set_flashdata('success', 'Backuped successfully !');  
		}
		//redirect(base_url().'admin/new_updates');
	}


	Public function backup_db_automatic()
	{
		$this->load->dbutil();
		$prefs = array('format' => 'zip', 'filename' => 'database-full-backup_'.rand().'_'.date('Y-m-d'));

		$backup = &$this->dbutil->backup($prefs);
		$filename = 'database-full-backup_'.rand().'_'.date('Y-m-d') . '.zip';
		if(!write_file('./backup/'.$filename, $backup)){

		}
	}




	Public function get_update_datas()
	{
		$ch = curl_init();
		$options = array(
			CURLOPT_URL => 'https://www.dreamguys.co.in/gigs_updates/',
			CURLOPT_RETURNTRANSFER => true
			);

		if (!ini_get('safe_mode') && !ini_get('open_basedir')) {
			$options[CURLOPT_FOLLOWLOCATION] = true;
		}
		curl_setopt_array($ch, $options);            
		$output = curl_exec($ch);
		curl_close($ch);

		return $datas = json_decode($output);
	}


}

/* End of file  */
/* Location: ./application/controllers/ */