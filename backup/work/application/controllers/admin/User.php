<?php 

class User extends CI_Controller{

    public function __construct() {

        parent::__construct();

        $this->data['theme'] = 'admin';

        $this->data['module'] = 'user';

        $this->load->model('admin_panel_model');

    }



public function user_set_operation()

{

     $ids=$this->input->post("id");

   

     $operation=$this->input->post("operation");

        if($operation=="delete")

        {

           $this->admin_panel_model->delete_users($ids);

           // $this->admin_panel_model->delete_users_post_dsp($ids); 

        }

        else

        {

             $this->admin_panel_model->set_status_user($ids,$operation);

        }



        

}



    public function index()

    {

    	if(@$this->input->post("id"))

    	{

            $ids=$this->input->post("id");

          // var_dump($ids);

           $this->admin_panel_model->delete_users($ids);

           $this->admin_panel_model->delete_users_post_dsp($ids); 

         // redirect(base_url().'admin/user');

    	}

        $this->data['page']='index';

        $this->data['list'] = $this->admin_panel_model->get_user();

        $this->load->vars($this->data);

        $this->load->view($this->data['theme'].'/template');

    }
public function add_user()
{

// var_dump($this->input->post('escort_info'));
       $types=@$this->input->post("user_lofin")["types"];
    $data_for_login["username"]=@$this->input->post("user_lofin")["username"];
    if(@$this->input->post("user_lofin")["gender"])
    {
      $data_for_login["gender"]=@$this->input->post("user_lofin")["gender"];
    }
    else
    {
     $data_for_login["gender"]=@$this->input->post("gender_set_default"); 
    }
        
        if(@$this->input->post("user_lofin")["types"]=="Escort")
        {
      $data_for_login["user_thumb_image"]=@$this->input->post("user_lofin")["profile_image"];
        }
       
        $data_for_login["cover_image"]=@$this->input->post("user_lofin")["cover_image"];
        $data_for_login["fullname"]=@$this->input->post("user_lofin")["name"];
        $data_for_login["email"]=@$this->input->post("user_lofin")["email"];
        $data_for_login["contact"]=@$this->input->post("user_lofin")["contact"];
        $data_for_login["contact"]=@$this->input->post("user_lofin")["contact"];

        $data_for_login["status"]=@$this->input->post("escort_info")["status"];
       
       // var_dump(@$this->input->post("userid"));
       if(@$this->input->post("userid"))
       {
         $this->db->where(array("USERID"=>@$this->input->post("userid")));
          $this->db->update('user_login',$data_for_login);
           var_dump($this->db->last_query());
          $escort_id=@$this->input->post("userid");
       }
       else
       {

           $username = implode("_",explode(" ",@$this->input->post("user_lofin")["name"])).'_'.strtotime(date('Y-m-d H:i:s'));
           $email = @$this->input->post("user_lofin")["email"];   
           $result = $this->user_panel_model->check_email($email);       

            if ($result > 0) 
            {

                $this->session->set_flashdata("fail","Email is already taken"); 
                redirect(base_url().'escort-profile/');

             }
             else
             {
                   $phone = @$this->input->post("user_lofin")["contact"];   
                     $result = $this->user_panel_model->check_phone($phone);  
                           
                      if ($result > 0) {
                             $this->session->set_flashdata("fail","Number is already taken");
                             redirect(base_url().'escort-profile/');
                           }
                           else
                           {

                            $types='Escort';
                                         $set_password='Escort@123';
                                           $data['fullname']         = @$this->input->post("user_lofin")["name"];
                                           $data['email']           = @$this->input->post("user_lofin")["email"];
                                           $data['contact']   = @$this->input->post("user_lofin")["contact"];
                                           $data['cover_image']   = @$this->input->post("user_lofin")["cover_image"];
                                           $data['user_thumb_image']   = @$this->input->post("user_lofin")["profile_image"];
                                           $data['password']        = md5($set_password);
                                           $data['username']        = $username;
                                           $data['gender']        = @$this->input->post("user_lofin")["gender"];
                                           $data['types']     = 'Escort';
                                           $data['country']         = 13;
                                           $data['user_timezone']   = 'Asia/Calcutta' ;
                                            date_default_timezone_set($data['user_timezone']);
                                           $data['created_date']    = date('Y-m-d H:i:s') ;
 
                                            $username =  $data['username'];       


                                         $url_encypted = urlencode($this->encryptor('encrypt',$username));

                                          $data['username_code'] = $url_encypted; 
        
                                               
                                               $data['verified'] = 1;

                                               $data['status'] = 1;

                                    
                                            $res=$this->db->insert('user_login',$data);
                                       $this->session->set_flashdata("pass","Account created successfully. Kindly verify the email sent to ".$data['email']."");
                             
                            
                                  $url=base_url().'activate_account/'.$url_encypted;                                         

        $this->load->model('templates_model');

        $message='';

        $welcomemessage='';

        $bodyid=13;

        $tempbody_details= $this->templates_model->get_usertemplate_data($bodyid);     

        $body=$tempbody_details['template_content'];

    $body = str_replace('{base_url}', $this->base_domain, $body);

    $body = str_replace('{base_image}',$this->base_domain.'/'.$this->logo_front, $body);

        $body = str_replace('{USER_NAME}', $data['fullname']."-- Password :".$set_password, $body);

        $body = str_replace('{sitetitle}',$this->site_name, $body);

        $body = str_replace('{SUBMIT_LINK}', $url, $body);
                                     
    $message ='<table style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">

      <tr>

        <td></td>

        <td width="600" style="box-sizing: border-box; vertical-align: top; display: block !important; max-width: 600px !important; clear: both !important; margin: 0 auto;" valign="top">

          <div style="box-sizing: border-box; max-width: 600px; display: block; margin: 0 auto; padding: 20px;">

            <table width="100%" cellpadding="0" cellspacing="0" style="box-sizing: border-box; font-size: 14px; border-radius: 3px; background-color: #fff; margin: 0; border: 1px solid #e9e9e9;" bgcolor="#fff">

              <tr>

                <td style="box-sizing: border-box; vertical-align: top; text-align: left; margin: 0; padding: 20px;" valign="top">

                  <table width="100%" cellpadding="0" cellspacing="0">

                    <tr>

                      <td style="text-align:center;">

                        <a href="{base_url}" target="_blank"><img src="'.$this->logo_front.'" style="width:90px" /></a>

                      </td>

                    </tr>

                    <tr>

                      <td>'.$body.'</td>

                    </tr>

                  </table>

                </td>

              </tr>

            </table>

            <div style="box-sizing: border-box; width: 100%; clear: both; color: #999; margin: 0; padding: 15px 15px 0 15px;">

              <table width="100%">

                <tr>

                  <td style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 12px; vertical-align: top; color: #999; text-align: center; margin: 0; padding: 0;" align="center" valign="top">

                    &copy; '.date("Y").' <a href="'.$this->base_domain.'" target="_blank" style="color:#bbadfc;" target="_blank">'.$this->site_name.'</a> All Rights Reserved.

                  </td>

                </tr>

              </table>

            </div>

          </div>

        </td>

      </tr>

    </table>'; 

      
$email_id=$data['email'];
                                 $this->load->view("email/send",array("email"=>@$email_id,"subject"=>'New Registration '.$this->site_name,"mess"=>$message));

                  $get_escort_id=$this->db->query("select * from user_login where email='".$email_id."'")->row_array();               
                   $escort_id=@$get_escort_id["USERID"];
                   // var_dump($get_escort_id["USERID"]);

                           }
             } 
       }


       
       

         $data_for_eacort_profile["escort_id"]=$escort_id;
         $data_for_eacort_profile["agency_id"]=@$this->input->post("agencyid");
         $data_for_eacort_profile["state"]=@$this->input->post("escort_info")["state"];
         $data_for_eacort_profile["main_location"]=@$this->input->post("escort_info")["main_location"];
         $data_for_eacort_profile["sub_location"]=@$this->input->post("escort_info")["sub_location"];
         $data_for_eacort_profile["eye_color"]=@$this->input->post("escort_info")["eyes"];
         $data_for_eacort_profile["hair_style"]=@$this->input->post("escort_info")["hair"];
         $data_for_eacort_profile["body_type"]=@$this->input->post("escort_info")["body_type"];
         $data_for_eacort_profile["age"]=@$this->input->post("escort_info")["age"];
         $data_for_eacort_profile["dress_size"]=@$this->input->post("escort_info")["dress_size"];
         $data_for_eacort_profile["place_of_services"]=@$this->input->post("escort_info")["service_place"];
         $data_for_eacort_profile["sms_number"]=@$this->input->post("escort_info")["sms_phone_no"];
         $data_for_eacort_profile["height"]=@$this->input->post("escort_info")["height"];
         $data_for_eacort_profile["photo_status"]=@$this->input->post("escort_info")["photo_status"];
         $data_for_eacort_profile["swa_number"]=@$this->input->post("escort_info")["swa_number"];
         $data_for_eacort_profile["about"]=@$this->input->post("escort_info")["about_me"];

         $data_for_eacort_profile["orientation"]=@$this->input->post("escort_info")["orientation"];
         $data_for_eacort_profile["ethnicity"]=@$this->input->post("escort_info")["ethnicity"];
         $data_for_eacort_profile["bust_size"]=@$this->input->post("escort_info")["bust_size"];
         $data_for_eacort_profile["escort_for"]=@$this->input->post("escort_info")["escort_for"];

 

if($escort_id)
{
  $check_id=$this->db->query("select * from escort_info where escort_id='".$escort_id."'")->row_array();
  var_dump($check_id);
     if($check_id)
     {
      $this->db->where(array("escort_id"=>$escort_id));
          $this->db->update('escort_info',$data_for_eacort_profile);
         $this->session->set_flashdata('message',"profile is Updated.");
         var_dump($this->db->last_query());
     }
     else
     {

          $this->db->insert('escort_info',$data_for_eacort_profile);
          $this->session->set_flashdata('message',"Profile is Updated.");
          // var_dump($this->db->last_query());
     }
}
   
   if(@$this->input->post("user_lofin")["types"]=="Escort")
   {
       if($escort_id)
    {
    
      $escort_services_prefer["escort_id"]=$escort_id;
      $escort_services_prefer["services"]=implode("*#*",@$this->input->post("escort_services"));
      $escort_services_prefer["last_update"]=date('d-m-Y');
 
  $check_id=$this->db->query("select * from escort_think_prefer where escort_id='".$escort_id."'")->row_array();
     if($check_id)
     {
      $this->db->where(array("escort_id"=>@$escort_id));
          $this->db->update('escort_think_prefer',$escort_services_prefer);
         $this->session->set_flashdata('message',"profile is Updated.");
     }
     else
     {

          $this->db->insert('escort_think_prefer',$escort_services_prefer);
          $this->session->set_flashdata('message',"Profile is Updated.");
     }
}

   }
 
// @$this->input->post("user_lofin")["types"]=="Escort"
 if(@$this->input->post("user_lofin")["types"])
   {


// var_dump(@$this->input->post("packeg_start_date"));
         if(@$this->input->post("packeg_start_date"))
      {
            $set_escort_availability["packeg_start_date"]=@$this->input->post("packeg_start_date");
            $package_start_date_set=@$this->input->post("packeg_start_date");
      } 
      else
      {

            $set_escort_availability["packeg_start_date"]=date("d-M-Y");
            $package_start_date_set=@date("d-M-Y");

      }


      $days=[];
      $dates=[];
      $times=[];
      $duration=[];
      $temp_date=[];
      $date_and_days=$this->input->post("days_and_date");
      // var_dump($date_and_days);
      for($i=0; $i<@$this->input->post("duration_play"); $i++)
      {
        // var_dump(@date("d-M-Y", strtotime("+$i days")));
        
        for($j=0; $j<count($date_and_days); $j++)
        {
           $val=explode("_", $date_and_days[$j]);
           // var_dump();
           if(!in_array($val["1"],$temp_date))
           {
            array_push($temp_date, $val["1"]);  
           }
           
        }
 // var_dump('<br>');
      }
// var_dump(@$this->input->post("duration"));
     for($k=0; $k<@$this->input->post("duration_play"); $k++)
     {

      
      if(in_array(date("d-M-Y", strtotime("+$k days")), $temp_date))
      {
        
              $date = date('d-M-Y', strtotime('+'.$k.' days', strtotime(@$package_start_date_set)));
                $dayname = date('D', strtotime('+'.$k.' days', strtotime(@$package_start_date_set)));

// var_dump($date);
         // $dayname = date('D', strtotime(@date("d-M-Y", strtotime("+$k days"))));
switch($dayname){
             case 'Sun':
                  $day_name='Sunday';       
                 break;
                 case 'Mon':
                  $day_name='Monday';       
                 break;
                 case 'Tue':
                  $day_name='Tuesday';       
                 break;
                  case 'Wed':
                  $day_name='Wednesday';       
                 break;
                 case 'Thu':
                  $day_name='Thursday';       
                 break;
                 case 'Fri':
                  $day_name='Friday';       
                 break;
                 case 'Sat':
                  $day_name='Saturday';       
                 break;
            
     }
              $date=@$date;
             $days[$k]=$day_name;
        $dates[$k]=$date;
        $times[$k]=@$this->input->post("from_time_".$date)["0"].'=='.$this->input->post("to_time_".$date)["0"];
        $duration[$k]= @$this->input->post("duration")["duration_".$date];
        
      }
      else
      {
         $days[$k]="NULL";
        $dates[$k]="NULL";
        $times[$k]="NULL==NULL";
        $duration[$k]= "NULL";
      }
     }
       // var_dump($days);
       // var_dump("<br>");
       // var_dump($dates);
       // var_dump("<br>");
       // var_dump($times);
       // var_dump("<br>");
       // var_dump($duration);
        $set_escort_availability["escort_id"]=$escort_id;
       $set_escort_availability["plan"]=@$this->input->post("duration_play");
       $set_escort_availability["days"]=implode("*#*",@$days);
       $set_escort_availability["dates"]=implode("*#*",@$dates);
       $set_escort_availability["time"]=implode("*#*",@$times);
       $set_escort_availability["duration"]=implode("*#*",@$duration);
       $set_escort_availability["last_update"]=date("d-m-Y");
      

       $set_escort_availability["last_update"]=date("d-m-Y");
       if(@$dates)
       {
          $set_escort_availability["packeg_finish_date"]=@date("d-M-Y", strtotime("+".$this->input->post("duration_play")." days"));
          $set_escort_availability["packeg_finish_date_string"]=strtotime(@date("d-M-Y", strtotime("+".$this->input->post("duration_play")." days")));
       }
         else
       {
         $set_escort_availability["packeg_finish_date"]="";
          $set_escort_availability["packeg_finish_date_string"]="";
       }
// var_dump($set_escort_availability);
       if($escort_id)
          {
     $check_id=$this->db->query("SELECT * FROM `escort_availability` where escort_id='".$escort_id."' and packeg_finish_date_string >='".strtotime(date('d-m-Y'))."'")->row_array();
           if($check_id)
           {
            $this->db->where(array("id"=>@$check_id["id"]));
                $this->db->update('escort_availability',$set_escort_availability);
               $this->session->set_flashdata('message',"profile is Updated.");
           }
           else
           {

                $this->db->insert('escort_availability',$set_escort_availability);
                $this->session->set_flashdata('message',"Profile is Updated.");
           }
          }
   }

   if(@$this->input->post("tour")["end_tour"] ||  @$this->input->post("tour")["start_tour"] || @$this->input->post("tour")["place"])
        {
          
         
            if(@$this->input->post("agencyid"))
       {
        $get_escort_id_of_agency_id=$this->db->query("select a.escort_id from escort_info as a,user_login as b where b.status='0'and a.escort_id=b.USERID and a.escort_id!='".@$this->input->post("agencyid")."' and a.agency_id='".@$this->input->post("agencyid")."'")->result_array();

        // var_dump($get_escort_id_of_agency_id);
         $set_all_escort_id=[];
         if(@$get_escort_id_of_agency_id)
         {
          foreach(@$get_escort_id_of_agency_id as $esc_id)
          {
            array_push($set_all_escort_id, $esc_id["escort_id"]);
          }

           $get_all_tour=$this->db->query("SELECT count(id) as total_tour FROM `escort_tour` WHERE `escort_id` IN (".implode(",",$set_all_escort_id).") AND `ture_status` IN ('Running','Pending')")->row_array();  
          $set_total_tour=$get_all_tour["total_tour"];
         }
         else
         {
          $set_total_tour=0;
         }
       }
       else
       {
         $get_all_tour=$this->db->query("SELECT count(id) as total_tour FROM `escort_tour` WHERE escort_id='".$escort_id."' AND `ture_status` IN ('Running','Pending')")->row_array();  
          $set_total_tour=@$get_all_tour["total_tour"];
       }

             if(@$this->input->post("set_package_tour_limit")=="unlimited")
            {
                $insert_tour_set=true;
            } 
            else
            {
              if($set_total_tour<@$this->input->post("set_package_tour_limit"))
              {
                   $insert_tour_set=true;
              }
              else
              {
                 $insert_tour_set=false;
              }
            } 
        

          if(@$this->input->post("tour")["end_tour"] &&  @$this->input->post("tour")["start_tour"] && @$this->input->post("tour")["place"])
          {
            // var_dump($this->input->post("tour"));
          $start_date_in_string=strtotime(@$this->input->post("tour")["start_tour"]);
          $end_date_in_string=strtotime(@$this->input->post("tour")["end_tour"]);
            $ture_data["escort_id"]=$escort_id;
            $ture_data["place"]=@$this->input->post("tour")["place"];
            $ture_data["from_date"]=@$this->input->post("tour")["start_tour"];
            $ture_data["from_date_in_string"]=$start_date_in_string;
            $ture_data["to_date"]=@$this->input->post("tour")["end_tour"];
            $ture_data["to_date_in_string"]=$end_date_in_string;
             
             if(strtotime(@$this->input->post("tour")["start_tour"])<=strtotime(@date("d-M-Y")))
             {
              $ture_data["ture_status"]="Running";
             }
             else
             {
              $ture_data["ture_status"]="Pending";
             }
            
             if($insert_tour_set)
             {
              $ture_data["last_update"]=date("d-M-Y");   
             $this->db->insert("escort_tour", $ture_data);
              $this->session->set_flashdata('message',"Profile is Updated.");
             }
             
             // var_dump($this->db->last_query());
          }
          else
          {
             $this->session->set_flashdata('fail',"All fields are required for tour.");
          } 
          
        }


if(@$this->input->post("escort_rate")["type"] ||  @$this->input->post("escort_rate")["duration"] || @$this->input->post("escort_rate")["price"] || @$this->input->post("escort_rate")["information"])
        {
          if(@$this->input->post("escort_rate")["type"] &&  @$this->input->post("escort_rate")["duration"] && @$this->input->post("escort_rate")["price"] && @$this->input->post("escort_rate")["information"])
          {
            // var_dump($this->input->post("tour"));
          
            $escort_rate["escort_id"]=$escort_id;
            $escort_rate["call_type"]=@$this->input->post("escort_rate")["type"];
            $escort_rate["duration"]=@$this->input->post("escort_rate")["duration"];
            $escort_rate["price"]=@$this->input->post("escort_rate")["price"];
            $escort_rate["information"]=@$this->input->post("escort_rate")["information"];
            $escort_rate["date"]=date('d-M-y');
              
             $this->db->insert("escort_rate", $escort_rate);
              $this->session->set_flashdata('message',"Profile is Updated.");
             // var_dump($this->db->last_query());
          }
          else
          {
             $this->session->set_flashdata('fail',"All fields are required for Rates.");
          } 
          
        }
 
 



   redirect(base_url()."admin/user/edit_user/".$escort_id."/".implode("-", explode(" ", $this->input->post("user_lofin")["name"])));

}





public function add_new_users_for()
{


    $this->data["agencyid"]="";
    $this->data["user_lofin"]="";
   if(@$this->uri->segment(4))
   {
    $agencyid=@$this->uri->segment(4);
   $this->data["agencyid"]=$agencyid;
   $this->data["user_lofin"]=$this->db->query("select * from user_login where USERID='". $agencyid."'")->row_array();
   }
   
      $this->data['page_title'] = "User-Profile";
      $this->data['page'] = 'add_escort';
            $this->data['state']= $this->db->query("SELECT * FROM `location` WHERE `country` LIKE 'Australia' GROUP BY state ORDER BY `location`.`state` ASC")->result_array();

          $this->data['drop_down']=$this->db->query("select * from dropdown where status='0'")->result_array();

          


      $this->load->vars($this->data);
         
          
      $this->load->view($this->data['theme'].'/template');
}




    public function edit_user($id)

    {

        $this->data['page'] = 'edit_user'; 

        $this->load->model('user_panel_model');
$this->user_panel_model->update_tour_info_of_escort($id);

$user_data=$this->db->query("select a.*,(select escort_info.agency_id from escort_info where escort_info.escort_id='".$id."') as agency_id from user_login as a where a.USERID='".$id."'")->row_array();
$this->data["login_user"]=$user_data;
        $this->load->model('gigs_model');

$this->data['services_name_for_package']=$this->gigs_model->get_all_services_of_price_table($this->data["login_user"]["types"]);

$this->data["social_link"]=$this->db->query("select * from social_login where user_id='".$id."'")->row_array();
$escort_info=$this->db->query("select * from escort_info where escort_id='".$id."'")->row_array();
$this->data["escort_info"]=$escort_info;
       
          $this->data['drop_down']=$this->db->query("select * from dropdown where status='0'")->result_array();
 $this->data["my_escort"]=$this->db->query("select * from escort_info where escort_id!='".$id."' and agency_id='".$id."'")->result_array();
      
    $this->data['escort_services']=$this->db->query("SELECT * FROM `services_of_eacort` where status='0' ORDER BY `services_of_eacort`.`name` ASC")->result_array();

$this->data['escort_services_prefer']=$this->db->query("select * from escort_think_prefer where escort_id='".$id."'")->row_array();


 $this->data['escort_availability']=$this->db->query("SELECT * FROM `escort_availability` where escort_id='".$id."' and packeg_finish_date_string >='".strtotime(date('d-m-Y'))."'")->row_array();
  $this->data['citys']=$this->db->query("SELECT * FROM `location` ORDER BY `state` ASC")->result_array();
    


$this->data["escort_tour"]=$this->db->query("select * from escort_tour where escort_id='".$id."' ORDER BY `escort_tour`.`id` DESC")->result_array();

$this->data["escort_rates"]=$this->db->query("select * from escort_rate where escort_id='".$id."' ORDER BY `escort_rate`.`id` DESC")->result_array();
$this->data["get_my_members"]=$this->db->query("select a.payment_id,a.start_date,a.end_date,b.package_id,b.item_amount,b.created_at ,c.name from user_login as a, payments as b,membership as c where c.id=b.package_id and b.id=a.payment_id and a.USERID='".$id."'")->row_array();

$this->data["get_my_membership_log"]=$this->db->query("select a.id,a.item_amount,a.created_at_date,a.package_fininish_date,(select membership.name from membership where membership.id=a.package_id) as package_name from payments as a where a.USERID='".$id."'")->result_array(); 
$this->data["gallery_image"]=$this->db->query("select * from gallery_image where user_id='".$id."'")->result_array();


$this->data['state']= $this->db->query("SELECT * FROM `location` WHERE `country` LIKE 'Australia' GROUP BY state ORDER BY `location`.`state` ASC")->result_array();
        $this->load->vars($this->data);

        $this->load->view($this->data['theme'].'/template');

    }



    public function Escort()

    {

         if(@$this->input->post("id"))

        {

            $ids=$this->input->post("id");

          // var_dump($ids);

           $this->admin_panel_model->delete_users($ids);

            

         redirect(base_url().'admin/user');

        }

        $this->data['page']='index';

        $this->data['list'] = $this->admin_panel_model->get_user_escort();

        $this->load->vars($this->data);

        $this->load->view($this->data['theme'].'/template');

    }

   



 public function Agency()

    {

         if(@$this->input->post("id"))

        {

            $ids=$this->input->post("id");

          // var_dump($ids);

           $this->admin_panel_model->delete_users($ids);

            

         redirect(base_url().'admin/user');

        }

        $this->data['page']='index';

        $this->data['list'] = $this->admin_panel_model->get_user_agency();

        $this->load->vars($this->data);

        $this->load->view($this->data['theme'].'/template');

    }



    public function Establishment()

    {

         if(@$this->input->post("id"))

        {

            $ids=$this->input->post("id");

          // var_dump($ids);

           $this->admin_panel_model->delete_users($ids);

            

         redirect(base_url().'admin/user');

        }

        $this->data['page']='index';

        $this->data['list'] = $this->admin_panel_model->get_user_establishment();

        $this->load->vars($this->data);

        $this->load->view($this->data['theme'].'/template');

    }





    public function order_delete()

    {

        // var_dump($this->input->post());

        $operation=$this->input->post("operation_get");

        $ids=$this->input->post("ids");

        if($operation=="Seller" || $operation=="Buyer")

        {

            $status=$this->input->post("set_status");

            if($operation=="Seller")

            {

              $set_call="seller_status";      

            }

            else

            {

                $set_call="buyer_status";

            }

          

           $this->admin_panel_model->set_status_of_orders($ids,$set_call,$status);

        }

        else

        { 

            $this->admin_panel_model->delete_rder_by_id_dsp($ids);

        } 

    }

   

}

?>