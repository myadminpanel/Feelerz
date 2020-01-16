<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

 class Apimodel extends CI_Model {



 ////////////////login with users details//////////////////////////////////////
public function login($userid,$password) {
    $insert = $this->db->query("select a.*,(select country.country_code from country where country.name=a.country) as country_code from users as a where a.email='".$userid."' and a.password='".$password."'");
    $insert=$insert->row_array();
    if($insert)
     {
       return $insert;    
     }else
      {
        return false;
      }
    }

   public function social_login($social_id){
        $this->db->where('social_login_id', $social_id);
        $insert = $this->db->get('users');
        $insert=$insert->row_array();
        if($insert)
        {
          return $insert;    
        }
        else
        {
      $data = array(
        'social_login_id' => $social_id,
        );
            $check = $this->db->insert('users', $data);
            $id=$this->db->insert_id();
            return $id;
        }

}

// check Email and contact

public function checked_num_email($chreck_email,$chreck_mobile)
{
    $check_email=$this->db->query("select * from users where email='".$chreck_email."'")->row_array();
    // var_dump($check_email);
    if(@$check_email)
    {
        $email_status="Email id already exist";
    }
    else
    {
         $email_status=false;
    }

    //  $check_num=$this->db->query("select * from users where contact='".$chreck_mobile."'")->row_array();
    //  // var_dump(@$check_num);
    // if(@$check_num)
    // {
    //      $num_status=false;
    //   //  $num_status="Mobile No. is already exist";
    // }
    // else
    // {
    //      $num_status=false;
    // }
// var_dump($num_status);
    if(@$email_status==false)
    {
        return false;
    }
    else
    {

        return $email_status;
    }

}

public function social_login_dsp($social_id,$devicetoken,$data)
{
    $data_res=$this->db->query("select * from users where social_login_id='".$social_id."'")->row_array();

    if($data_res)
    {
        $this->db->query("UPDATE users set deviceToken='".$devicetoken."' WHERE social_login_id='".$social_id."' ");
        return $data_res;
    }
    else
    {

      $this->db->insert("users",$data);
      $user_id_get=$this->db->insert_id();
      if(@$data["email"])
      {
         $username=explode("@",@$data["email"]);
          $user_name=$username[0];
      }
      else
      {
          $user_name="feelerz";
      }
      
       $this->db->update("users",array("userName"=>@$user_name."".$user_id_get),array("id"=>$user_id_get));
     $data_res2=$this->db->query("select * from users where social_login_id='".$social_id."'")->row_array();
      return $data_res2;
    }
}

 

  }

?>