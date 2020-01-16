<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Ajax extends CI_Controller {



	public function __construct()

	{

		parent::__construct();



	}



	public function index()

	{

		 $version = 0;



		 $query = $this->db->select('version')->order_by('version_id','desc')->get('version_updates');

		 

		 if($query->num_rows()>0){

				

				$version = $query->row()->version;

		} 

		if(isset($_REQUEST['timezone'])){

			$array = array(
				'time_zone' => $_REQUEST['timezone'],
				'ip_city' => $_REQUEST['ip_city'],
				'version' => $version,
				);

				$this->check_updates();

			$this->session->set_userdata( $array );

			echo json_encode($array);

		}

	}

Public function check_updates()

	{

		$this->load->model('New_update_model','updates');

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

			$this->session->set_userdata(array('updates'=>1));		

		}

	}

}



/* End of file  */

/* Location: ./application/controllers/ */