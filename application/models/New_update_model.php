<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class New_update_model extends CI_Model {	

	public function __construct()
	{
		parent::__construct();
		
	}

	Public function get_all_updates()
	{
		$where = array('status' => 1 );
		return $this->db->order_by('version_id','desc')->get_where('version_updates',$where)->result();
	}Public function get_all_backups()
	{
		$where = array('status' => 1 );
		return $this->db->order_by('backup_id','desc')->get_where('db_backup_details',$where)->result();
	}
	Public function check_updates($build)
	{
		$where = array('build' => $build );
		return $this->db->get_where('version_updates',$where)->num_rows();
	}
	Public function update_backup($filename)
	{
		$data = array('backup_file_name' => $filename );
		$this->db->insert('db_backup_details',$data);
	}
	Public function updated_file($datas)
	{
		$data = array(
			'build' => $datas->build,
			'version' => $datas->version,
			'title' => $datas->title,
			'filename' => $datas->filename
			);
		$check = $this->db->get_where('version_updates',$data)->row();
		if($check!=''){
			$this->db->update('version_updates',$data,array('version_id'=>$check->version_id));
		}else{
			$this->db->insert('version_updates',$data);				
		}
		
	}

}

/* End of file  */
/* Location: ./application/models/ */