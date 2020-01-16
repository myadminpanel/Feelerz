<?php
ini_set("display_errors", "0");
error_reporting(0);
defined('BASEPATH') OR exit('No direct script access allowed');
class Installer extends CI_Controller
{
	function __construct()
	{	
		parent::__construct();
		if (!$this->check_already_installed())
		{
		}
	}

	public function index()
        {			 
				$this->session->set_userdata(array('step1_completed'=>'true'));		
                $this->load->view('installer');
        }
    public function purcahse_code()
    {
        	if ($_POST['purcahse_code']) {

					$value = $_POST['purcahse_code'];
					$site_name =  $_SERVER['HTTP_REFERER'];
					$site_ip =  $_SERVER['REMOTE_ADDR'];
					$array_inputs = array('purcahse_code' => $value,'site_ip'=>$site_name,'site_ip'=>$site_ip);
			        $ch = curl_init(); 

			        
				$curlConfig = array(
				    CURLOPT_URL            => "http://dreamguys.co.in/envato_code_check/isvalid.php",
				    CURLOPT_POST           => true,
				    CURLOPT_RETURNTRANSFER => true,
				    CURLOPT_POSTFIELDS     => $array_inputs
				);
				
				curl_setopt_array($ch, $curlConfig);
				$result = curl_exec($ch);
				$result = json_decode($result,true);

				if($result['status_code'] == 200){

					
					file_put_contents(FCPATH."assets/temp_files/install.sql", "");
					$myfile = fopen(FCPATH."assets/temp_files/install.sql", "wr") or die("Unable to open file!");
					$txt = $result['data'][0];
					fwrite($myfile, $txt);
					fclose($myfile);
					redirect(base_url() . 'installer/move_next');
				}else{

			    	$this->session->set_userdata(array('error_message' => $result['message']));
			    	redirect(base_url() . 'installer');
				}

				}else{
					$this->session->set_userdata(array('error_message' => 'Please enter your puchase code to verify'));
			    	redirect(base_url() . 'installer');
				}
    }    
    
    public function move_next()
    {	 
		  
		$this->session->set_userdata(array('step2_completed'=>'true'));
		redirect(base_url() . 'installer/?step=2');			 		
    }
        
	public function check_already_installed()
	{
		include APPPATH . 'config/database.php';
		$hostname = $db['default']['hostname'];
		$db_username = $db['default']['username'];
		$db_password = $db['default']['password'];
		$db_name = $db['default']['database'];
		$status = $this->connection_check($hostname, $db_username, $db_password);
		return $status;
	}

	public function connection_check($hostname = '', $db_username = '', $db_password = '')
	{
		if ($hostname=='') {
				$hostname = 'localhost';
			}	
		$connection = mysqli_connect($hostname, $db_username, $db_password);
		if (!$connection)
		{
			return false;
		}
		else
		{
			return true;
		}
	}

	public function db_installation()
	{
		$hostname = $_POST['hostname'];
		$db_username = $_POST['db_username'];
		$db_password = $_POST['db_password'];
		$status = $this->connection_check($hostname, $db_username, $db_password);
		if (!$status)
		{
			$this->session->set_userdata(array(
				'error_message' => "Database Connection could not be established , Please check your inputs ",
				"hostname" => $_POST['hostname'],
				"db_username" => $_POST['db_username'],
				"db_password" => $_POST['db_password'],
				"db_name" => $_POST['db_name']
			));
			redirect(base_url() . 'installer/?step=2', $this->data);
		}
		else
		{
			$this->session->set_userdata(array('step3_completed'=>'true'));
			$this->session->set_userdata(array(
				"hostname" => $_POST['hostname'],
				"db_username" => $_POST['db_username'],
				"db_password" => $_POST['db_password'],
				"db_name" => $_POST['db_name']
			));
			$hostname = $this->session->userdata("hostname");
			$db_username = $this->session->userdata("db_username");
			$db_password = $this->session->userdata("db_password");
			$database_name = $this->session->userdata("db_name");
			$dbdata = file_get_contents('./application/config/database.php');
			$dbdata = str_replace('%DB_DATABASE_NAME%', '', $dbdata);
			$dbdata = str_replace('%DB_USERNAME%', trim($db_username) , $dbdata);
			$dbdata = str_replace('%DB_PASSWORD%', trim($db_password) , $dbdata);
			$dbdata = str_replace('%HOSTNAME%', trim($hostname) , $dbdata);
			if (write_file(FCPATH . '/application/config/database.php', $dbdata))
			{
				$this->load->database();
				$this->load->dbutil();
				usleep(1000000);
				if (!$this->dbutil->database_exists($database_name))
				{ 
					$this->create_dbforge_database($database_name);
				}
				else
				{
					$this->load->dbforge();
					$this->dbforge->drop_database($database_name);
					$this->create_dbforge_database($database_name);
				}				
			}
			else
			{
				             	 $this->session->set_userdata(array(
                                    'error_message' => " Database files is not writable "));		
                                                         redirect(base_url() .'installer/?step=2');
			}
		}
		}

		// return $status;

	public function create_dbforge_database($database_name)
	{
		$this->load->dbforge();
		if ($this->dbforge->create_database($database_name, TRUE))
		{
			$dbdata = file_get_contents('./application/config/database.php');
			$dbdata = str_replace('"database" =>""', '"database" =>"' . $database_name . '"', $dbdata);
			if (write_file(FCPATH . '/application/config/database.php', $dbdata))
			{
				$this->load->database();
				$this->load->dbutil();
				usleep(1000000);
				if ($this->dbutil->database_exists($database_name))
				{
					if($this->create_tables())
                                        {
                                            $routesData = file_get_contents('./application/config/routes.php');
                                            $routesData = str_replace('installer','gigs',$routesData);
                                            if (write_file(FCPATH . '/application/config/routes.php',$routesData))
                                            {
												$this->session->set_userdata(array('step3_completed'=>'true'));
                                                redirect(base_url() .'installer/?step=3');
                                            }
                                            else 
                                            {
												$this->session->set_userdata(array('step2_completed'=>'true'));
                                                  	 $this->session->set_userdata(array(
                                    'error_message' => " Routes files is not writable "));		
                                                         redirect(base_url() .'installer/?step=3');
                                            }
                                        }
                                        else 
                                        {
                                            redirect(base_url() .'installer/?step=3');
                                        }
				}
				else
				{
					 $this->session->set_userdata(array(
				'error_message' => "Database cannot be Created , Please check your inputs "));
				redirect(base_url() .'installer/?step=3');
				}				 
			}
		}
                else
                {
					$this->load->dbforge();
					$this->dbforge->delete_database($database_name, TRUE);
					if(!$this->dbforge->create_database($database_name, TRUE))
					{
							$this->session->set_userdata(array(
						'error_message' => "Database cannot be Created , Please contact Authour. "));				
						redirect(base_url() .'installer/?step=3');
					}
                }
	}

	public function create_tables()
	{
		$hostname = $this->session->userdata("hostname");
		$db_username = $this->session->userdata("db_username");
		$db_password = $this->session->userdata("db_password");
		$database_name = $this->session->userdata("db_name");
		$mysqli = new mysqli($hostname, $db_username, $db_password, $database_name); 
		if (mysqli_connect_errno())
		{
                        $this->session->set_userdata(array(
				'error_message' => "Error with Databsae Connection"));				
			return false;
		}
                if(is_file(getcwd()."/assets/temp_files/install.sql"))
                {
                    $query = file_get_contents('assets/temp_files/install.sql');
                    $mysqli->multi_query($query);
                    $mysqli->close();
                    return true;
                }
                else 
                {
                    $this->session->set_userdata(array(
				'error_message' => "Installer File Not Found "));				
                    return false;
                }
	}
        
        public function admin_details()
        {
            $status = 2 ;
            $admin['email']     = $this->input->post('admin_email');
            $admin['password']  = md5($this->input->post('admin_password'));
            $admin['username']  = $this->input->post('admin_username');    
            $admin['user_role']  = 1;    

            $hostname = $this->session->userdata("hostname");
			$db_username = $this->session->userdata("db_username");
			$db_password = $this->session->userdata("db_password");
			$database_name = $this->session->userdata("db_name");
			$mysqli = new mysqli($hostname, $db_username, $db_password, $database_name); 
			
				if (mysqli_connect_errno()){
                        $this->session->set_userdata(array('error_message' => "Error with Databsae Connection"));				
                        return false;
				}
            	if(is_file(getcwd()."/assets/temp_files/install_1.sql"))
                {

                    $query = file_get_contents('assets/temp_files/install_1.sql');
                    $mysqli->multi_query($query);
                   
                }
                if(is_file(getcwd()."/assets/temp_files/install_2.sql"))
                {

                    $query = file_get_contents('assets/temp_files/install_2.sql');
                    $mysqli->multi_query($query);
                   
                }
                if(is_file(getcwd()."/assets/temp_files/install_3.sql"))
                {

                    $query = file_get_contents('assets/temp_files/install_3.sql');
                    $mysqli->multi_query($query);
                  
                }
                  $mysqli->close();
                

            if($this->db->insert('administrators',$admin))
            {
                $status = 1 ;
                $system_settings['base_domain']        = $this->input->post('base_url');
                $system_settings['website_name']       = $this->input->post('website_name');
                $system_settings['email_tittle']       = $this->input->post('website_name');
				$system_settings['email_address']      = $this->input->post('admin_email');
				$system_settings['price_option']       = 'dynamic';
			
			
                foreach($system_settings as $key => $value)
                {
                    $settings['key']         = $key;
                    $settings['value']       = $value;
                    $settings['groups']      = "config";
                    $settings['update_date'] = date('Y-m-d');
                    if($this->db->insert('system_settings',$settings))
                    {
                    	$status = 0 ;
                    }
                }
            }
             
            if($status==0)
            {
                redirect(base_url() .'installer/?step=4');
            }
            else
            {
                $this->session->set_userdata(array(
				'error_message' => " Problem While Inserting Data "));	
                redirect(base_url() .'installer/?step=4');
            }
        }

        public function gig_details()
        {        	    
                $system_settings['default_currency']       = $this->input->post('default_currency');
                $system_settings['currency_option']        = $this->input->post('default_currency');
                $system_settings['gig_price']     		   = $this->input->post('gig_price');
                $system_settings['extra_gig_price']        = $this->input->post('extra_gig_price');
                $system_settings['admin_commision']        = $this->input->post('admin_commision');
                foreach($system_settings as $key => $value)
                {
                	$status = 1 ;
                    $settings['key']         = $key;
                    $settings['value']       = $value;
                    $settings['groups']      = "config";
                    $settings['update_date'] = date('Y-m-d');
                    if($this->db->insert('system_settings',$settings))
                    {
                        $status = 0 ;
                    }
                }
            
	            if($status==0)
	            {
	            	$files = glob(FCPATH.'assets/temp_files/*'); // get all file names
					foreach($files as $file){ // iterate files
  						if(is_file($file))
    						unlink($file); // delete file
					}
	                redirect(base_url().'admin');
	            }	
        }
}
