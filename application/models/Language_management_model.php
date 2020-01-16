<?php 
class Language_management_model extends CI_Model
{

	public function language_model()
    { 

    	$where = array();
    	$where['language'] = $this->input->post('language');
        $where['language_value'] = $this->input->post('value');
    	
    	$this->db->where($where);
    	$record = $this->db->count_all_results('language');
    	
    	if($record == 1)
    	{
    		return false;
    	}else{	

    	$data = array(
		'language_value' => trim($this->input->post('value')),
		'language' => trim($this->input->post('language')),
		'status' => 1
		);

       $result = $this->db->insert('language',$data);
        return $result;
    	}
    }
    public function lang_data()
	{
		$query = $this->db->query(" SELECT * FROM language");
		return $query->result_array();
	}


	public function keyword_model()
    { 
    	if (!empty($_POST['keyword'])) {
    		
    	$data = array();
    	$lang =trim($_POST['keyword']);
		$language = 'lg_'.str_replace(array(' ','!','&'),'_',strtolower($lang));
    	$data['lang_key'] = $language;
		$data['lang_value'] = $lang;
		$data['language'] = 'en';
		$this->db->where($data);
    	$record = $this->db->count_all_results('language_management');
    	if($record == 1)
    	{
    		return false;
    	}else{
			$result = $this->db->insert('language_management', $data);
			return $result;
	   }
	}
	
	$already_exits = array();
		if (!empty($_POST['multiple'])) {
	    		
	    	$data = array();
	    	
	    	$multiple = $_POST['multiple'];
	    	
	    	$multiple_keyword = explode(',',$_POST['multiple']);
	    	
	    	$multiple_keyword = array_filter($multiple_keyword);

	    	if (!empty($multiple_keyword)) {
	    		foreach ($multiple_keyword as $lang) {
	    			$lang = trim($lang);
	    			$language = 'lg_'.str_replace(array(' ','!','&'),'_',strtolower($lang));
	    			$data['lang_key'] = $language;
					$data['lang_value'] = $lang;
					$data['language'] = 'en';
					$this->db->where($data);
	    			$record = $this->db->count_all_results('language_management');
	    			if($record == 1)
				    	{
				    		$already_exits[] = $lang;
				    	}else{
						
							$result = $this->db->insert('language_management', $data);	
					   }

	    			}
	    	}

			return $already_exits;
		}
}
    	


    public function lang_keyword()
    {
    	$query = $this->db->query(" SELECT * FROM language_management");
		return $query->result_array();
    }

    function getRows($params = array()){
        $this->db->select('*');
        $this->db->from('language_management');
        if(array_key_exists("sno",$params)){
            $this->db->where('sno',$params['id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            //set start and limit
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        // print_r($result);exit;
        //return fetched data
        return $result;
    }

      public function currenct_page_key_value($inputs){ 
    	 
    	$my_keys = array();
    	if(!empty($inputs)){
    		foreach ($inputs as $input) {
    			$my_keys[] = $input['lang_key'];
    		}
    	}
     

    	$my_final_values = array();
    	if(!empty($my_keys)){
    		
    		$this->db->select('lang_key,lang_value,language');
       		$this->db->from('language_management');
          	$this->db->where_in('lang_key',$my_keys);
          	$this->db->order_by('lang_key');
          	$my_final = $this->db->get()->result_array();
    		 if(!empty($my_final)){
    		 	foreach ($my_final as $keyvalue) {
    		 		$my_final_values[$keyvalue['lang_key']][$keyvalue['language']] = $keyvalue['lang_value'];
    		 	}
    		 }

    	}
     return $my_final_values;  
    } 

    function get_keywords($params = array()){
 

        $this->db->select('*');
        $this->db->from('language_management');
          $this->db->where('language','en');
        if(array_key_exists("sno",$params)){
            $this->db->where('sno',$params['id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            //set start and limit
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        
         
        //return fetched data
        return $result;
    }

  public function edit_keyword_model($id)
    {
        $query = $this->db->query("SELECT * FROM `language_management` where sno = '".$id."'");
        $result = $query->row_array();
        return $result;
    }

    public function update_keyword_model($record){
    	$sno = $record['edit_id'];
    	unset($record['edit_id']);
    	$this->db->where('sno', $sno);
      return $this->db->update('language_management', $record);
     }
     public function active_language()
    {
    	$query = $this->db->query("SELECT language, language_value FROM `language` WHERE status = 1");
    	$result = $query->result_array();
        return $result;
    }

    public function active_keyword()
    {
    	$query = $this->db->query("SELECT lang_value FROM `language_management` WHERE language = 'english'");
    	$result = $query->result_array();
        return $result;
    }

  }
?>