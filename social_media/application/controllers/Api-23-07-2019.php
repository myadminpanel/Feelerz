<?php  ob_start();
defined('BASEPATH') OR exit('No direct script access allowed');

  class Api extends CI_Controller 
   { 
     public function __construct()
     {
         parent::__construct();
         $this->load->model('apimodel');
         date_default_timezone_set('UTC');
     }


 public function json_function()
 {
 	$json =JSON_UNESCAPED_UNICODE;
 } 

public function get_one_post_by_id()
{

   $json = file_get_contents('php://input');
    // Converts it into a PHP object
   $data = json_decode($json);
   $post_id=@$data->post_id;
   $get_post=$this->db->query("SELECT *,(select users.name from users where users.id=post.user_id) as name,(select users.profileimage from users where users.id=post.user_id) as profileimage,(SELECT count(get_comment.id) from get_comment where get_comment.post_id=post.id) as comments_count FROM post WHERE id='".$post_id."'")->row_array();
         echo json_encode(array("status"=>"1","data"=>$get_post));
}


 public function unblock_user()
 {
      $json = file_get_contents('php://input');
       // Converts it into a PHP object
      $data = json_decode($json);
      $current_user_id=@$data->user_id;        // sender user id 9
      $block_user_id=@$data->block_id;   // reciever user idm 11

      $blocked_user_by_me = $this->db->query("SELECT following,name,block_by_me FROM users WHERE id='".$current_user_id."'")->row_array();

      $blocked_user_by_other = $this->db->query("SELECT block_by_other FROM users WHERE id='".$block_user_id."'")->row_array();

    // print_r($blocked_user_by_other);
    // die();

      $block_user11 = explode(",", $blocked_user_by_me['block_by_me']);
      $keys=(String)array_search($block_user_id, $block_user11);
 
      if(@$keys!="")
         {
        
            unset($block_user11[$keys]);
         }   
            
       $block_user_request = implode(",", $block_user11);

       // blocked by other

      $block_user12 = explode(",", $blocked_user_by_other['block_by_other']);
      $keys=(String)array_search($current_user_id, $block_user12);
 
      if(@$keys!="")
         {
        
            unset($block_user12[$keys]);
         }   
            
       $block_user_request1 = implode(",", $block_user12);


       $result_update = $this->db->query("UPDATE users SET block_by_me='".$block_user_request."' WHERE id='".$current_user_id."'");

       $update_blocked_by_other = $this->db->query("UPDATE users SET block_by_other='".$block_user_request1."' WHERE id='".$block_user_id."'"); 


            echo json_encode(array("status"=>"1","message"=>"User Unblocked"));

      }


  public function block_user_list()
  {
      $json = file_get_contents('php://input');
       // Converts it into a PHP object
      $data = json_decode($json);
      $current_user_id=@$data->user_id;        // sender user id 9
      $send_result = $this->db->query("SELECT block_by_me FROM users WHERE id='".$current_user_id."'")->row_array();  

    if(@$send_result["block_by_me"])
    {

      $block_user_list=implode("','",explode(",",$send_result["block_by_me"]));
    }
    else 
    {
       $block_user_list=""; 
    }

    // if(@$send_result["my_block_user"])
    // {

    //   $my_block_user_list=implode("','",explode(",",$send_result["my_block_user"]));
    // }
    // else 
    // {
    //    $my_block_user_list=""; 
    // }

      $user_info=$this->db->query("SELECT * FROM users WHERE id IN ('".@$block_user_list."')")->result_array();

      echo json_encode(array("status"=>"1","data"=>$user_info));
  }

 
 public function block_users()
 {

     $json = file_get_contents('php://input');
      // Converts it into a PHP object
     $data = json_decode($json);
     $current_user_id=@$data->user_id;        // sender user id 9
     $block_user_id=@$data->block_id;   // reciever user idm 11


     $current_user = $this->db->query("SELECT following,follower,block_by_me FROM users WHERE id='".$current_user_id."'")->row_array();

     $block_user_total=$this->db->query("SELECT following,follower,block_by_other  FROM users WHERE id='".$block_user_id."'")->row_array();    

     //print_r($block_user);
   //  die();
       if($current_user['following'])
         {

            $user_following = explode(",", $current_user['following']);
            $keys1=(String)array_search($block_user_id, $user_following);
             
             if(@$keys1!="")
             {
         
               unset($user_following[$keys1]);
             }   

              $following_friend = implode(",", $user_following);
          }
          else
           {
              $following_friend="";
           }


       if($current_user['follower'])
         {

            $user_follower = explode(",", $current_user['follower']);
            $keys2=(String)array_search($block_user_id, $user_follower);
             
             if(@$keys2!="")
             {
         
               unset($user_follower[$keys2]);
             }   

              $follower_friend = implode(",", $user_follower);
          }
          else
           {
              $follower_friend="";
           }



        if($current_user['block_by_me'])
        {
          $block_user=explode(",", @$current_user['block_by_me']);
          array_push($block_user, $block_user_id);
          $block_user_in_string=implode(",", $block_user);
        }
        else
        {
          $block_user_in_string=$block_user_id;
        }


        

       if($block_user_total['following'])
         {

            $block_following = explode(",", $block_user_total['following']);
            $keys3=(String)array_search($current_user_id, $block_following);
             
             if(@$keys3!="")
             {
         
               unset($block_following[$keys3]);
             }   

              $following_block = implode(",", $block_following);
          }
          else
           {
              $following_block="";
           }


       if($block_user_total['follower'])
         {

            $block_follower = explode(",", $block_user_total['follower']);
            $keys4=(String)array_search($current_user_id, $block_follower);
             
             if(@$keys4!="")
             {
         
               unset($block_follower[$keys4]);
             }   

              $follower_block = implode(",", $block_follower);
          }
          else
           {
              $follower_block="";
           }



        if($block_user_total['block_by_other'])
        {
          $block_user1=explode(",", @$block_user_total['block_by_other']);
          array_push($block_user1, $current_user_id);
          $block_user_in_string1=implode(",", $block_user1);
        }
        else
        {
          $block_user_in_string1=$current_user_id;
        }


      $result_current = $this->db->query("UPDATE users SET following='".$following_friend."',follower='".$follower_friend."' ,block_by_me='".$block_user_in_string."' WHERE id='".$current_user_id."'");
     
      $result_current1 = $this->db->query("UPDATE users SET following='".$following_block."',follower='".$follower_block."' ,block_by_other='".$block_user_in_string1."' WHERE id='".$block_user_id."'");




//      print_r($current_user);
//      die();

//      if(@$current_user['my_block_user'])
//          { 
        
//                $current_block_user=explode(",", @$current_user['my_block_user']);
//                array_push($current_block_user, $follower_user_id);
//                $current_block_user_in_string=implode(",", $current_block_user);
//          }
//          else
//          {
//              $current_block_user_in_string=@$follower_user_id;
//          } 


//    if($send_result_follower['following'])
//      {

//         $sent_friend_follower = explode(",", $send_result_follower['following']);

//         $keys1=(String)array_search($current_user_id,  $sent_friend_follower);
//         if(@$keys1!="")
//         {
//             unset($sent_friend_follower[$keys1]);
//         }   

//           $send_friend_request_follow = implode(",",  $sent_friend_follower);
//       }
//           else
//           {
//             $send_friend_request_follow="";

//           }
 

//        if($send_result_follower['follower'])
//          {

//             $sent_friend_follower1 = explode(",", $send_result_follower['follower']);
//             $keys1=(String)array_search($current_user_id, $sent_friend_follower1);
             
//              if(@$keys1!="")
//              {
         
//                unset($sent_friend_follower1[$keys1]);
//              }   

//               $send_friend_follower1 = implode(",", $sent_friend_follower1);
//           }
//           else
//            {
//               $send_friend_follower1="";
//            }

     
//         if(@$send_result_follower['block_user'])
//          { 
        
//                $block_user=explode(",", @$send_result_follower['block_user']);
//                array_push($block_user, $current_user_id);
              
//                $block_user_in_string=implode(",", $block_user);
//          }
//          else
//          {
//              $block_user_in_string=@$current_user_id;
//          } 

      
//       $result_update = $this->db->query("UPDATE users SET following='".$send_friend_request_follow."',follower='".$send_friend_follower1."' ,block_user='".$block_user_in_string."' WHERE id='".$follower_user_id."'");

// $this->db->update("users",array("my_block_user"=>@$current_block_user_in_string),array("id"=>$current_user_id));
      
//           $message=$current_user["name"]." is now block you!";
//           // $this->db->insert('sent_notification',$insert_notifiction);
//           $deviceToken_get=$this->db->query("SELECT deviceToken from users where id='".$follower_user_id."'")->row_array();

//           $deviceToken=$deviceToken_get["deviceToken"];
//           $this->notifitation_ios($deviceToken,$message);

          echo json_encode(array("status"=>"1","message"=>"User blocked"));

  

  }



public function add_feelings()
{
   $json = file_get_contents('php://input');
   $data = json_decode($json);
   $name=@$data->name;
   $nameO=json_decode('"'.$name.'"');;
   $user_id=@$data->user_id;
   $color_code=@$data->color_code;
   $emojie=@$data->emojie;
   $size="3";
   $parrent=@$data->parrent_cat_name;
   $reating="0";
   $status="0";

   if(!@$name || !@$emojie || !@$color_code || !@$parrent)
   {
      echo json_encode(array("status"=>"0","message"=>"All fields are required !"));
   }
    else
    {

      $get_data=$this->db->query("SELECT * FROM feeling WHERE (name='".$name."' or nameO = '".$nameO."') and parrent='".@$parrent."'")->row_array();


      if(@$get_data)
        {

            $this->db->query("UPDATE feeling SET reating = reating + 1 WHERE (name='".$name."' or nameO = '".$nameO."')");
            echo json_encode(array("status"=>"1","data"=>@$get_data,"message"=>"Feeling insert successfully. dsp 1"));
        }
    else
     {
        $insert_data=array(
               
               "name"=>@$name,
               "nameO"=>@$nameO,
               "color_code"=>@$color_code,
               "emojie"=>@$emojie,
               "size"=>@$size,
               "parrent"=>@$parrent,
               "reating"=>@$reating,
               "user_id"=>@$user_id,
               "status"=>@$status

         );

// $this->db->query("INSERT INTO `feeling`(`name`, `color_code`, `emojie`, `size`, `parrent`, `reating`, `status`, `user_id`) VALUES ('".@$name."','".@$color_code."','".@$emojie."','".@$size."','".@$parrent."','".@$reating."','".@$status."','".@$user_id."')");
      $this->db->insert("feeling",$insert_data);
       $last_data=$this->db->query("SELECT * FROM feeling WHERE user_id='".@$user_id."' ORDER BY id DESC LIMIT 1")->row_array();
       
          echo json_encode(array("status"=>"1","data"=>@$last_data,"message"=>"Feeling insert successfully. dsp 2"));

       }

    }

}



 public function version_control()
  {
      $json = file_get_contents('php://input');
      $data = json_decode($json);
      $version=@$data->version;

      $data=$this->db->query("SELECT * FROM version_control")->row_array();


      if(@$data)
       {

          echo json_encode(array("status"=>"1","message"=>"version is running","data"=>$data));
       }
        else
        {

           echo json_encode(array("status"=>"0","message"=>"version is closed."));
        } 
  }



public function resent_image()

{

  $json = file_get_contents('php://input');

   $data = json_decode($json);



    $user_id=@$data->user_id;



 try {

     $get_image=$this->db->query("SELECT image FROM post WHERE user_id='".$user_id."' and image !='' ORDER BY id DESC")->result_array();

     echo json_encode(array("status"=>"1","data"=>@$get_image));

 } catch (Exception $e) {

    

    echo json_encode(array("status"=>"0","message"=>"Something was wrong."));

 }



    

}







public function change_login_status()

 {



   $json = file_get_contents('php://input');

   $data = json_decode($json);

   $user_id=@$data->user_id;

   try {



        $this->db->update("users",array("login_status"=>date('Y/m/d H:i:s')),array("id"=>$user_id));

        echo json_encode(array("status"=>"1","message"=>"Login status change"));



    } catch (Exception $e) {



       echo json_encode(array("status"=>"0","message"=>"Something was wrong pleace try agian."));



    }



}







 public function resent_tag()

 {

    $json = file_get_contents('php://input');



    $data = json_decode($json);



    $user_id=@$data->user_id;



   



   try {



      $post_data=$this->db->query("select resent_tags from users where id='".$user_id."'")->row_array();



   if(@$post_data["resent_tags"])



   {



     $tag_frieds_in_array=explode(",", $post_data["resent_tags"]);





   $new_resent_ids_array=[];



  



   $last=count($tag_frieds_in_array)-50;  



   if($last<0)



   {



    $last=0;



   }



   for($i=count($tag_frieds_in_array)-1; $i>=$last; $i--)
   {

       array_push($new_resent_ids_array, $tag_frieds_in_array[$i]);
    }







   $last_tag_id_in_string=implode("','",$new_resent_ids_array);
   
   
   $user_data=$this->db->query("select id,name,profileimage from users where id IN ('".$last_tag_id_in_string."')")->result_array();

    echo json_encode(array("status"=>"1","data"=>@$user_data));

  }



   else



   {



     echo json_encode(array("status"=>"1","data"=>@$post_data["tag_friend"]));



   }



    } catch (Exception $e) {



      echo json_encode(array("status"=>"0","message"=>"Something was wrong. pleace try again."));



    } 

 
}







// public function post_tag_friend()



// {



//   $json = file_get_contents('php://input');



//    $data = json_decode($json);



//     $post_id=@$data->post_id;



//     $tag_friendes_id=@$data->tag_friendes_id_in_string;



// try {



//  $post_data=$this->db->query("select tag_friend from post where id='".$post_id."'")->row_array();



//     if(@$post_data["tag_friend"])



//     {



//      $tag_friends=@$post_data["tag_friend"].",".$tag_friendes_id;



//     }



//    else



//    {



//      $tag_friends=$tag_friendes_id;



//    }



//    $this->db->update("post",array("tag_friend"=>@$tag_friends),array("id"=>$post_id));



//    // var_dump($this->db->last_query());



//     echo json_encode(array("status"=>"1","message"=>"Done"));



// } catch (Exception $e) {



//  echo json_encode(array("status"=>"0","message"=>"Something was wrong. pleace try again."));



// }



    



// }



public function user_manage_report()
 {
   $json = file_get_contents('php://input');
   $data = json_decode($json);
   $user_id=@$data->user_id;
   $post_id=@$data->post_id;
   $message=@$data->message;

     $insert_data=array(
        "user_id"=>$user_id,
        "post_id"=>$post_id,
        "reason"=>$message,
        "status"=>"Pending",
        "date"=>date('Y/m/d H:i:s')

     );


     $result=$this->db->insert("user_manage_report",$insert_data);

    if(@$result)
     {

       echo json_encode(array("status"=>"1","message"=>"Post has been reported successfully."));
    } else
     {

       echo json_encode(array("status"=>"0","message"=>"Something was wrong. pleace try again."));
     }
  }

  public function check_otp()
  {
    $json = file_get_contents('php://input');
    $data = json_decode($json);
    $email=@$data->email;
    $otp=@$data->otp;
    $data_get=$this->db->query("SELECT a.*,(select country.country_code from country where country.name=a.country) as country_code from users as a where a.email='".$email."' and a.otp='".$otp."'")->row_array();

   // var_dump($data_get);

   if($data_get)
    {
      $this->db->update("users",array("status"=>"1","otp"=>"DONE"),array("id"=>$data_get["id"]));

      echo json_encode(array("status"=>"1","message"=>"OTP varification is done","data"=>@$data_get));
   } else
    {

       echo json_encode(array("status"=>"0","message"=>"OTP is not correct."));
    }
 }







  public function send_otp($json="")



  {



    $json = file_get_contents('php://input');



     $data = json_decode($json);







      $email=@$data->email;







      $data=$this->db->query("select * from users where email='".$email."'")->row_array();



      if($data)



      {



         



       $otp_code=rand(100000,999999);



      $this->db->update("users",array("otp"=>$otp_code),array("email"=>$email));



        $message="<b>Your OTP IS '".$otp_code."'</b>";



         $res=$this->load->view("email/send",array("email"=>@$email,"subject"=>'OTP FROM APP',"mess"=>$message));



         // var_dump($res);



        echo json_encode(array("status"=>"1","message"=>"We have sent an OTP to your email id '".@$email."'"));  



      }



      else



      {



        echo json_encode(array("status"=>"0","message"=>"Account not found for this email"));



      }



  }











   public function user_login()



    {



       $json = file_get_contents('php://input');



       // Converts it into a PHP object







         $data = json_decode($json);







         $userid=@$data->email;







         $password=md5(@$data->password);







         $social_id=@$data->social_id;



         $deviceToken=@$data->deviceToken;



     











         if($social_id!="")







          {















            $check_user=$this->apimodel->social_login($social_id);















             // var_dump($check_user);







             if($check_user)







              {







              if(@$check_user["status"]=="1")



              {



                $this->db->where("id",$check_user["id"]);







                $this->db->update("users",array("last_login"=>date('Y/m/d H:i:s'),"deviceToken"=>$deviceToken));











                



                echo json_encode(array("status"=>"1","data"=>$check_user));



                 



                // echo json_encode(array("status"=>true,"data"=>$check_user,"your_request_data"=>$this->input->post()));



              }



             else



             {



                echo json_encode(array("status"=>"0","message"=>"Account not varified."));



             }



                







               }







               exit;







         







          }















        // $password=md5($password);















       if($userid!="" && $password!="")







        {















           $this->load->model('apimodel');







           $check_user=$this->apimodel->login($userid,$password);







            if($check_user)







             {











            if(@$check_user["status"]=="1")



           {



              $this->db->where("id",$check_user["id"]);







               $this->db->update("users",array("last_login"=>date('Y/m/d H:i:s'),"deviceToken"=>$deviceToken));







                // header('Content-Type: application/json');







                echo json_encode(array("status"=>"1","data"=>$check_user,"user_image_dir_url"=>base_url()."/assets/images/users/"));







           }



           else



           {



                   echo json_encode(array("status"=>"1","data"=>$check_user,"message"=>"Account is not activated."));



           }







               











                 //  echo json_encode();







                 //  $token=$this->apimodel->set_new_token($userid);







                 //  if(!$token)







                 //  {







                 //   echo json_encode(array("status"=>false,"message"=>"token is not created plc try agen"));







                 //    // token is not create 







                 // }







                 // else







                 // {







                 //   echo json_encode(array("status"=>true,"token"=>$token));







                 // }















             }







             else







             {















             echo json_encode(array("status"=>"0","message"=>"User id and password is incorrect."));







              // echo json_encode(array("status"=>false,"message"=>"user id and password is incorrect.","your_request_data"=>$this->input->post()));







             } 







          







       }







        else







         {







          echo json_encode(array("status"=>"0","message"=>"User id and password is required."));







           // echo json_encode(array("status"=>false,"message"=>"user id and password is required.","your_request_data"=>$this->input->post()));







       







        }







 







  }











// public function text_data_dsp()
// {
//   var_dump("deepak");
//   $message='\\u0627\\u0633\\u062a\\u0633\\u0627_babah';
// echo json_decode('"'.$message.'"');
// }



      public function self_register()
       {







          $json = file_get_contents('php://input');

          // Converts it into a PHP object

          $data = json_decode($json);

          $chreck_email=$data->email;

          $chreck_mobile=$data->mobile;

          $deviceToken=$data->deviceToken;

          // $otp_code=rand(100000,999999);

          $get_result=$this->apimodel->checked_num_email($chreck_email,$chreck_mobile);

          if($get_result)
           {

             echo json_encode(array("status"=>"0","message"=>$get_result));
           }
            else
            {
            

            $nameO=json_decode('"'.@$data->name.'"');
                $insert_data=array(
                     "name"=>@$data->name,
                     "nameO"=>@$nameO,
                     "email"=>@$data->email,
                     "password"=>md5(@$data->password),
                     "contact"=>@$data->mobile, 
                     "profileimage"=>'',                  
                     "country"=>@$data->country,
                     "stype_of_login"=>"Self",
                     "created_date"=>date("Y/m/d H:i:s"),
                     "join_date"=>date("Y/m/d H:i:s"),
                     "deviceToken"=>$deviceToken
              );


              $result=$this->db->insert("users",$insert_data);
             $user_id=$this->db->insert_id();
              $name_two=json_decode('"'.$data->name.'"');
              // $this->db->query("UPDATE users SET userName='".implode("_",explode(" ",json_decode('"'.$data->name.'"')))."@".$user_id."' , userNameO='".implode("_",explode(" ",@$data->name))."@".$user_id."' WHERE id='".$user_id."'");


$username=explode("@",@$data->email);
           $this->db->update("users",array("userName"=>@$username[0]."".$user_id),array("id"=>$user_id));
           // var_dump($this->db->last_query());
              if(@$result)

               {







                 $get_user_id=$this->db->query("select id from users where email='".@$data->email."'")->row_array();















                    echo json_encode(array("status"=>"1","userid"=>$get_user_id["id"],"message"=>"We have sent an OTP to your email id ".@$data->email.", Please enter the OTP back to complete your registration"));







                 }







              else







               {







                 echo json_encode(array("status"=>"0","message"=>"Registration fail"));







               }







             }







       }







 







    public function social_login()

      {







        $json = file_get_contents('php://input');







        $data = json_decode($json);







        $social_id=@$data->social_id;
        $devicetoken=@$data->deviceToken;







        $insert_data=array(

            "name"=>@$data->fname." ".@$data->lname,
            "email"=>@$data->email,
            "password"=>md5(@$data->password),
            "contact"=>@$data->mobile,
            "profileimage"=>'',
            "country"=>@$data->country,
            "stype_of_login"=>@$data->types,
            "social_login_id"=>$social_id,
            "deviceToken"=>$data->deviceToken,
            "status"=>'1',
            "otp"=>'DONE',
            "created_date"=>date("Y/m/d H:i:s")
        );















        if(@$social_id)







          {







            $get_result=$this->apimodel->social_login_dsp($social_id,$devicetoken,$insert_data);







            echo json_encode(array("status"=>"1","data"=>$get_result));







         }else







          {







             echo json_encode(array("status"=>"0","message"=>"Social id is required."));







          }















     }















    public function all_cuntry()

    {



         $get_cuntry=$this->db->query("SELECT * FROM country where status='1' ORDER BY name ASC")->result_array();

         echo json_encode(array("status"=>"1","data"=>$get_cuntry));



    }















    







    public function change_password()







    {







       $json = file_get_contents('php://input');







       $data = json_decode($json);







       $user_id=@$data->user_id;







       $old_password=@$data->old_password;







       $new_password=@$data->new_password;















       if(@$user_id!="" && @$old_password!="" && @$new_password!="")







        {







          $get_data=$this->db->query("select * from users where id='".@$user_id."'")->row_array();







          if($get_data["password"]==md5($old_password))







           {







             //change password







             $this->db->where("id",@$user_id);







             $this->db->update("users",array("password"=>md5($new_password)));







              echo json_encode(array("status"=>"1","message"=>"Password Updated successfully."));







           }







           else







           {







               echo json_encode(array("status"=>"0","message"=>"Old password is not match."));







            }







         }







       else 







       {







            echo json_encode(array("status"=>"0","message"=>"user_id,old_password,new_password is required.")); 







       }















    }















    public function forgate()







     {







        $json = file_get_contents('php://input'); // Converts it into a PHP object







        $data = json_decode($json);







        $email=@$data->email;







        







        if(@$email!="")







        {







           $get_data=$this->db->query("select * from users where email='".@$email."'")->row_array();







           if(@$get_data)







            {







                //check types







               if(@$get_data["stype_of_login"]=="Self")







                {



         











                   $otp_code=rand(100000,999999);







                   // send OTP start







                   // send OTP end







                   $this->db->where("id",@$get_data["id"]);







                  // $this->db->update("users",array("password"=>md5($otp_code)));







                   $this->db->where("user_id",@$get_data["id"]);







                   $this->db->update("set_otp",array("status"=>'1'));







                







                  $insert_otp_data=array(















                         "user_id"=>@$get_data["id"],







                         "code"=>$otp_code,







                         "date"=>date("Y/m/d H:i:s")







                   );















       $this->db->insert("set_otp",$insert_otp_data);



        @$email=$get_data["email"];



        $message="<b>YOUR OTP IS '".$otp_code."'</b>";



        $res=$this->load->view("email/send",array("email"=>@$email,"subject"=>'OTP FOR CHANGE PASSWORD FROM APP',"mess"=>$message));

       echo json_encode(array("status"=>"1","data"=>@$get_data,"message"=>"OTP has been sent."));







        }







        else







         {















            echo json_encode(array("status"=>"0","message"=>"Your can not change the password of this account because account is created from ".@$get_data["stype_of_login"]));







                 }







            }







           else







            {







               echo json_encode(array("status"=>"0","message"=>"Email id does not exist."));















             }















       } 







       else







        {







          echo json_encode(array("status"=>"0","message"=>"'email' is required."));







        }















    }







 























       







     public function check_otp_for_password()







      {







         $json = file_get_contents('php://input');







         // Converts it into a PHP object







         $data = json_decode($json);







         $userid=@$data->user_id; 







         $otp=@$data->otp;















          if(@$userid!="" && @$otp!="")  







           {















            $get_otp=$this->db->query("select * from set_otp where code='".$otp."' and user_id='".$userid."'")->row_array();















            if(@$get_otp)







             {







                if(@$get_otp["status"]=="0")







                 {







                    $this->db->where("id",$get_otp["id"]);







                    $this->db->update("set_otp",array("status"=>"1"));

              echo json_encode(array("status"=>"1","message"=>"OTP has been verified Please set a new password"));







                 }







                 else







                   {















                      echo json_encode(array("status"=>"0","message"=>"Your OTP is rejected."));







                   }







              }







              else







                {







                  echo json_encode(array("status"=>"0","message"=>"OTP is invalid"));







                }







           }















           else







            {















              echo json_encode(array("status"=>"0","message"=>"'user_id' and 'otp' is required."));















             }















         }























     public function set_new_password()







      {







          $json = file_get_contents('php://input');







           // Converts it into a PHP object







          $data = json_decode($json);







          $userid=@$data->user_id; 







          $new_password=@$data->new_password;







          







          if(@$userid!="" && @$new_password!="")







           {







            $check_opt_status=$this->db->query("select * from set_otp where user_id='".$userid."' and status='0'")->result_array();



 



         if(@$check_opt_status)



         {



           echo json_encode(array("status"=>"0","message"=>"Your change password otp is not varified."));



         }



         else



         {



             



             $get_data=$this->db->query("select * from users where id='".$userid."'")->row_array();







           







              if(@$get_data)







              {







                 $this->db->where("id",$userid);







                 $this->db->update("users",array("password"=>md5($new_password)));







                  echo json_encode(array("status"=>"1","message"=>"Password updated successfully."));







               }







                 else







                  {







                      echo json_encode(array("status"=>"0","message"=>"data not found for ".$userid." id."));







                  }



         }



             







            }







             else







              {







                echo json_encode(array("status"=>"0","message"=>"'user_id','new_password' is required."));







               }    







       }















 //============ Api 02-04-2019 Start By Gopal =============//















   public function post_comment()

   {

       $json = file_get_contents('php://input');

        // Converts it into a PHP object

       $data = json_decode($json);

       $user_id=@$data->user_id;


       $feeling=@$data->feeling;



       $feeling_id=@$data->feeling_id;

       $feeling_color=@$data->feeling_color;

       $post_text=@$data->post_text;
       
       $privacy=@$data->privacy;

       $image=@$data->image;

       $image_type=@$data->image_type;
       $post_textO =  @$data->post_textO;

    //   $post_textO=json_decode('"'.$post_text.'"');
       //var_dump($message);

       $tag_friend="";

        try {


           if($image_type=="1")


        {

           $full_img_name_post = "";

        }

        else

        {



               if($image_type=="2")



        { 

            $data_post=base64_decode($image);







            $image_post = time() . '.png';







            $full_img_name_post = $user_id."_".$image_post;


            $imagename_post = "assets/post/".$full_img_name_post;


            file_put_contents($imagename_post, $data_post);               

            }

            else

            {

                $full_img_name_post=$image;

            }



        }

       if(@$feeling!="" && @$privacy!="")
       {


          if(@$post_text!="" || @$full_img_name_post!="")
          {



                   $insert_data_post_comment=array(
                 "user_id"=>$user_id,
                 "feeling"=>$feeling,
                 "feeling_id"=>$feeling_id,
                 "feeling_color"=>$feeling_color,
                 "post_text"=>$post_text,
                 "post_textO"=>$post_textO,
                 "privacy"=>$privacy,
                 "image"=>$full_img_name_post,
                 "image_type"=>$image_type,
                 "tag_friend"=>$tag_friend,
                 "date_time"=>date("Y/m/d H:i:s"),
                 "date_set_by_system"=>date("Y/m/d H:i:s")
             );



        $result=$this->db->insert("post",$insert_data_post_comment);




// var_dump($this->db->last_query());
// $result=true;


         if($result)

         {

          $friend_ids=$this->db->query("SELECT name,following FROM users WHERE id='".$user_id."'")->row_array();

          if(@$friend_ids["following"])
          {



            $following=explode(",", $friend_ids["following"]);



             $message=$friend_ids["name"]." added new post";



             // var_dump($message);



              $deviceToken_get=$this->db->query("SELECT deviceToken From users WHERE id IN ('".implode("','",$following)."')")->result_array();



              // var_dump($deviceToken_get);



              foreach ( $deviceToken_get as $dat) {



                   



                   $this->notifitation_ios($dat["deviceToken"],$message);



              }







          }



       



           // ====== set feeling reating start =====



          $this->db->query("UPDATE feeling SET reating = reating + 1 WHERE id='".$feeling_id."'");



           $get_parent_filling=$this->db->query("SELECT parrent from feeling where id='".$feeling_id."'")->row_array();



           $parrent_feeling=$get_parent_filling["parrent"];



           // var_dump($parrent_feeling);



           $get_sum_of_all_sub_feelings=$this->db->query("SELECT SUM(reating) as total_reating from  feeling  WHERE parrent='".$parrent_feeling."'")->row_array();



         $all_sub_feeling_total_reating=$get_sum_of_all_sub_feelings["total_reating"];



         // var_dump($all_sub_feeling_total_reating);







         $get_all_sub_feelings=$this->db->query("SELECT id,name,size,reating FROM feeling WHERE parrent='".$parrent_feeling."'")->result_array();



        



          if(@$get_all_sub_feelings)



          {



             foreach ($get_all_sub_feelings as $dat) {





$reating=(int)$dat["reating"];

$all_sub_feeling_total_reating=(int)$all_sub_feeling_total_reating;

               $get_percenteg=($reating*100)/$all_sub_feeling_total_reating;



               $get_percenteg=number_format((int)@$get_percenteg, 2, '.', '');

                 $get_percenteg=(int)$get_percenteg;

                 // var_dump($get_percenteg);

                if($get_percenteg<=17)



                {



                  $size='3';



                }



                elseif ($get_percenteg<=34) {



                  $size='4';



                }



                elseif ($get_percenteg<=51) {



                  $size='5';



                }



                elseif ($get_percenteg<=68) {



                 $size='6';



                }



                elseif ($get_percenteg<=85) {



                  $size='7';



                }



                else



                {



                  $size='8';



                }

 // $size='5';

              



                $this->db->query("UPDATE feeling SET size='".$size."' WHERE id='".$dat["id"]."'");



                // var_dump($this->db->last_query());







             }



          }



            // ====== set feeling reating end =====



             $user_data=$this->db->query("select resent_tags from users where id='".$user_id."'")->row_array();



             if(@$user_data["resent_tags"])



    {



     $tag_friends=@$post_data["resent_tags"].",".$tag_friend;



    }



   else



   {



    $tag_friends=$tag_friend;



   }



   $this->db->update("users",array("resent_tags"=>@$tag_friends),array("id"=>$user_id));







            echo json_encode(array("status"=>"1","message"=>"Data Insert Successfully"));







         }







         else







         {







            echo json_encode(array("status"=>"1","message"=>"Data Not Insert"));







         }







          } 



          else



          {



             echo json_encode(array("status"=>"0","message"=>"add some content for post."));



          }



       }



       else



       {



        echo json_encode(array("status"=>"0","message"=>"feeling , privacy and post content is required."));



       }







      



          



        } catch (Exception $e) {



            echo json_encode(array("status"=>"0","message"=>$e));



        }







       







 







     }























public function my_post()

{

   $json = file_get_contents('php://input');

         $data = json_decode($json);

         $user_id=@$data->user_id;
         $friend_id=@$data->friend_id;
         $page_no=@$data->page_no;
        if(!$page_no)
        {
          $page_no=0;
        }
        $limit=$page_no*50;

       // $user_info_data=$this->db->query("SELECT block_user FROM users WHERE id='".$user_id."'")->row_array();

          $friends=$this->db->query("select following, block_by_me, block_by_other from users where id ='".$friend_id."'")->row_array();
          
          $current=$this->db->query("select following, block_by_me, block_by_other from users where id ='".$user_id."'")->row_array();

          $block_user11 = explode(",", $current['block_by_me']);
           $keys=(String)array_search($friend_id, $block_user11);
 
        if(@$keys!="")
         {
            $get_result_post=[];

               echo json_encode(array("status"=>"1","data"=>$get_result_post));
               die();
           
         }


         $block_user13 = explode(",", $current['block_by_other']);
         $keys23=(String)array_search($friend_id, $block_user13);
 
        if(@$keys23!="")
         {
            $get_result_post2=[];
              
               echo json_encode(array("status"=>"1","data"=>$get_result_post2));
               die();
           
         }

          if(in_array($user_id, explode(",", $friends["following"])))

          {

         
            // $get_result_post = $this->db->query("SELECT *,(select users.name from users where users.id=post.user_id) as name,(select users.profileimage from users where users.id=post.user_id) as profileimage,(SELECT count(get_comment.id) from get_comment where get_comment.post_id=post.id) as comments_count from post where privacy IN ('Friend','Public') and user_id='".@$friend_id."' or ( (hug ='".$friend_id."' or (hug LIKE '%".$friend_id.",%' and hug LIKE '%,".$friend_id."%')) or ( repost_user ='".$friend_id."' or (repost_user LIKE '%".$friend_id.",%' and repost_user LIKE '%,".$friend_id."%') ) )   ORDER BY post.date_set_by_system DESC LIMIT ".$limit.",50")->result_array();

        $get_result_post = $this->db->query("SELECT *,(select users.name from users where users.id=post.user_id) as name,(select users.profileimage from users where users.id=post.user_id) as profileimage,(SELECT count(get_comment.id) from get_comment where get_comment.post_id=post.id) as comments_count from post where privacy IN ('Friend','Public') and user_id='".@$friend_id."' or ( repost_user ='".$friend_id."' or (repost_user LIKE '%".$friend_id.",%' and repost_user LIKE '%,".$friend_id."%') or repost_user LIKE '%,".@$friend_id."%' )   ORDER BY post.date_set_by_system DESC LIMIT ".$limit.",50")->result_array();

          }

          else

          {


               $set_privacy="Friend','Public";

                if($user_id==$friend_id)

                {

                   $set_privacy="Friend','Public','Only Me','Anonymous";

                }


  // $get_result_post = $this->db->query("SELECT *,(select users.name from users where users.id=post.user_id) as name,(select users.profileimage from users where users.id=post.user_id) as profileimage,(SELECT count(get_comment.id) from get_comment where get_comment.post_id=post.id) as comments_count from post where privacy IN ('".$set_privacy."') and  user_id='".@$friend_id."' or ( (hug ='".$friend_id."' or (hug LIKE '%".$friend_id.",%' and hug LIKE '%,".$friend_id."%')) or ( repost_user ='".$friend_id."' or (repost_user LIKE '%".$friend_id.",%' and repost_user LIKE '%,".$friend_id."%') ) ) ORDER BY post.date_set_by_system DESC LIMIT ".$limit.",50")->result_array();
          
            $get_result_post = $this->db->query("SELECT *,(select users.name from users where users.id=post.user_id) as name,(select users.profileimage from users where users.id=post.user_id) as profileimage,(SELECT count(get_comment.id) from get_comment where get_comment.post_id=post.id) as comments_count from post where privacy IN ('".$set_privacy."') and  user_id='".@$friend_id."' or ( repost_user ='".$friend_id."' or (repost_user LIKE '%".$friend_id.",%' and repost_user LIKE '%,".$friend_id."%') or repost_user LIKE '%,".@$friend_id."%' ) ORDER BY post.date_set_by_system DESC LIMIT ".$limit.",50")->result_array();



          }

      
// var_dump($this->db->last_query());



// $block_user_in_array=explode(",",$user_info_data["block_user"]);

// if(in_array($friend_id, $block_user_in_array))
// {
//    $get_result_post=[];  
// }

          echo json_encode(array("status"=>"1","data"=>$get_result_post));







}







    public function hugs()
      {

         $json = file_get_contents('php://input');

         $data = json_decode($json);

         $id=@$data->post_id;

         $user_id=@$data->user_id;

         $user_name=$this->db->query("SELECT name FROM users WHERE id='".$user_id."'")->row_array();

         $get_data=$this->db->query("select post_text,hug,total_hug,user_id from post where id='".@$id."'")->row_array();
$get_data_for_notification=$get_data;


        if($get_data['hug'])

         {

             $set_friend = explode(",", $get_data['hug']);

             if(in_array($user_id, $set_friend))

             {
 
              $key=array_search($user_id,$set_friend);

                unset($set_friend[$key]);

                $get_data=$get_data["total_hug"]-1;

                $message=$user_name["name"]." unlike on your '".@$get_data["post_text"]."'";



                $message_2="unlike on your '".@$get_data["post_text"]."'";
                   
                   

             }

             else

             {
              array_push($set_friend,$user_id);

              $get_data=$get_data["total_hug"]+1;

              $message=$user_name["name"]." hugged on your '".@$get_data_for_notification["post_text"]."'";

              $message_2="hugged on your '".@$get_data_for_notification["post_text"]."'";
           
                  $deviceToken_get=$this->db->query("SELECT deviceToken FROM users WHERE id='".$get_data_for_notification["user_id"]."'")->row_array();

            $deviceToken=$deviceToken_get["deviceToken"];

             $this->notifitation_ios($deviceToken,$message);



                $insert_notifiction=array(
                 "from_id"=>$user_id,
                 "to_id"=>$get_data_for_notification["user_id"],
                 "post_id"=>$id,
                 "message"=>$message_2,
                 "date_time"=>date("Y/m/d H:i:s"),
                 "type"=>"2",
                );
                $this->db->insert('sent_notification',$insert_notifiction);

             }

             $set_accept_friend = implode(",", $set_friend);

          }

          else
            {


              $set_accept_friend=$user_id;
              $get_data=1;
              $message=$user_name["name"]." give hug on your '".@$get_data_for_notification["post_text"]."' post.";

              $message_2="hug on your '".@$get_data_for_notification["post_text"]."' post.";

                     $deviceToken_get=$this->db->query("SELECT deviceToken,id FROM users WHERE id='".$get_data_for_notification["user_id"]."'")->row_array();

            $deviceToken=$deviceToken_get["deviceToken"];

             $this->notifitation_ios($deviceToken,$message);

                $insert_notifiction=array(
                 "from_id"=>$user_id,
                 "to_id"=>$deviceToken_get["id"],
                 "post_id"=>$id,
                 "message"=>$message_2,
                 "date_time"=>date("Y/m/d H:i:s"),
                 "type"=>"2",
                );
                $this->db->insert('sent_notification',$insert_notifiction);

            }

          $result=$this->db->query("update post set hug='".$set_accept_friend."' ,total_hug='".$get_data."' where id='".$id."'");

        if($result)
           {

            
              echo json_encode(array("status"=>"1","message"=>"Updated Successfully.","total_hug"=>(string)@$get_data,"hug"=>(string)$set_accept_friend));




            }







            else







             {







               echo json_encode(array("status"=>"0","message"=>"data not update "));







              }







        }























      // public function get_post()







      //  {







      //     $json = file_get_contents('php://input');







      //       // Converts it into a PHP object







      //     $data = json_decode($json);







      //     $id=@$data->user_id;







      //     $get_post_query=$this->db->query("select * from post where id='".@$id."'")->row_array();















      //     if($get_post_query)







      //      {







      //       echo json_encode(array("status"=>"1","message"=>"","data"=>@$get_post_query));







      //      }







      //      else







      //      {







      //         echo json_encode(array("status"=>"0","message"=>"Data not found"));







      //      }







      //   }































   // public function unselect_hug()







   //  {







   //       $json = file_get_contents('php://input');







   //       $data = json_decode($json);







   //       $id=@$data->post_id;







   //       $user_id=@$data->user_id;







   //       $get_data=$this->db->query("select hug from post where id='".@$id."'")->row_array();







   //       $unselect_hug = explode(",", $get_data['hug']);        







         







   //        if(($key = array_search($user_id, $unselect_hug)) !== false)







   //         {







   //            unset($unselect_hug[$key]);







   //          }







   //           $unselected_hug_string = implode(",",$unselect_hug);







   //           $result=$this->db->query("update post set hug='".$unselected_hug_string."' where id='".$id."'");







   //       if($result)







   //        {







   //          echo json_encode(array("status"=>"1","message"=>"Updated Successfully."));







   //        } 







   //        else







   //         {







   //           echo json_encode(array("status"=>"0","message"=>"data not update "));







   //        }







   //    }

public function repost_comment(){
     $json = file_get_contents('php://input');
$data = json_decode($json);
       $user_id=@$data->user_id;
       $post_id=@$data->post_id;
       $your_comment=@$data->your_comment;


  $post_data=$this->db->query("SELECT * FROM post WHERE id='".$post_id."'")->row_array();

  

$repost_user_in_array=explode(",",@$post_data["repost_user"]);

if(in_array($user_id, $repost_user_in_array))
{
 
            $keys=array_search($user_id, $repost_user_in_array);
            unset($repost_user_in_array[$keys]);
            $repost_user_in_string = implode(",", $repost_user_in_array);
            $total_repost=$post_data["total_repost"]-1;
 
          $get_child_id=$this->db->query("SELECT * FROM repost_child_parent WHERE user_id='".@$user_id."' and post_id='".@$post_id."'")->row_array();
          // $this->db->query("DELETE FROM post WHERE id='".$get_child_id["child_post_id"]."'");
$message="Remove Re-post successfully";
}
else
{
  $insert_data_post_comment=array(
                 "user_id"=>@$user_id,
                 "feeling"=>@$post_data["feeling"],
                 "feeling_id"=>@$post_data["feeling_id"],
                 "feeling_color"=>@$post_data["feeling_color"],
                 "post_text"=>@$post_data["post_text"],
                 "privacy"=>@$post_data["privacy"],
                 "image"=>@$post_data["image"],
                 "image_type"=>@$post_data["image_type"],
                 "tag_friend"=>@$post_data["tag_friend"],
                 "date_time"=>date("Y/m/d H:i:s"),
                 "parrent_post"=>@$post_data["id"],
                 "post_comment"=>@$your_comment
               );
  if(@$repost_user_in_array["0"])
  {
    array_push($repost_user_in_array, @$user_id);
  $repost_user_in_string=implode(",",$repost_user_in_array);  
  }
  else
  {
    $repost_user_in_string=@$user_id;
  }
  
  $total_repost=(int)$post_data["total_repost"]+1;

  // $this->db->insert("post",$insert_data_post_comment);
  // $get_current_post_id=$this->db->insert_id();

$insert_post_data=array(
  "user_id"=>@$user_id,
  "post_id"=>@$post_id,
  "comment"=>$your_comment
);

$get_child_id=$this->db->query("SELECT * FROM repost_child_parent WHERE user_id='".@$user_id."' and post_id='".@$post_id."'")->row_array();
$this->db->insert("repost_child_parent",$insert_post_data);
 $message="Re-post successfully";
}

   $this->db->update("post",array("repost_user"=>@$repost_user_in_string,"total_repost"=>$total_repost,"date_set_by_system"=>date("Y/m/d H:i:s")),array("id"=>$post_id));

$total_repost = (String)@$total_repost;
$get_opst_data=$this->db->query("SELECT * FROM post WHERE id='".$post_id."'")->row_array();
  echo json_encode(array("status"=>"1","repost_user"=>@$get_opst_data["repost_user"],"total_repost"=>@$total_repost,"message"=>$message));
}

public function delete_comment()
{
   $json = file_get_contents('php://input');


        // Converts it into a PHP object


        $data = json_decode($json);
       $comment_id=@$data->id;

       $this->db->query("DELETE FROM get_comment WHERE id='".$comment_id."'");
   echo json_encode(array("status"=>"1","message"=>"Comment delete successfully"));

}


   //============ Api 03-04-2019 Start By Gopal =============//




   public function add_comment()

    {


        $json = file_get_contents('php://input');


        // Converts it into a PHP object


        $data = json_decode($json);



        $user_id=@$data->user_id;


        $comment=@$data->comment;


        $post_id=@$data->post_id;

         if(@$comment)

         {


             $post_comment=array(
              "user_id"=>$user_id,
              "post_id"=>$post_id,
              "comment"=>$comment,
              "date_time"=>date("Y/m/d H:i:s")
         );


         $result_comment = $this->db->insert("get_comment",$post_comment);
          $commeent_id=$this->db->insert_id();

   // $result_comment=true;
          if($result_comment)
           {
             $user_data=$this->db->query("SELECT user_id,post_text FROM post WHERE id='".$post_id."'")->row_array();



// var_dump($user_data);
$user_id_to_sent_data=$user_data["user_id"];



// var_dump($user_id_to_sent_data);
$user_info_for_reciver=$this->db->query("SELECT deviceToken FROM users WHERE id='".$user_id_to_sent_data."'")->row_array();
$commented_by=$this->db->query("SELECT name FROM users WHERE id='".$user_id."'")->row_array();



// var_dump($user_info_for_reciver);
$deviceToken=$user_info_for_reciver["deviceToken"];
$message=@$commented_by["name"]." user is added a comment on  '".$user_data["post_text"]."' POST";
$message_2="user is added a comment on '".$user_data["post_text"]."' POST";

// var_dump($message);

               $this->notifitation_ios($deviceToken,$message);

 $insert_notifiction=array(
                 "from_id"=>$user_id,
                 "to_id"=>$user_id_to_sent_data,
                 "post_id"=>$post_id,
                 "message"=>$message_2,
                 "date_time"=>date("Y/m/d H:i:s"),
                 "type"=>"2",
                );
                $this->db->insert('sent_notification',$insert_notifiction);
                $commeny_dat=$this->db->query("SELECT * FROM get_comment  WHERE id='".$commeent_id."'")->row_array();
             echo json_encode(array("status"=>"1","message"=>"Comment Upload successfully","data"=>@$commeny_dat));
            }
            else
             {
               echo json_encode(array("status"=>"0","message"=>"Comment Upload successfully"));
             }



         }
         else
         {

  echo json_encode(array("status"=>"0","message"=>"Pleace add Comment"));



         }
       }
  ///================///

public function share_count()
     {







         $json = file_get_contents('php://input');







         // Converts it into a PHP object







         $data = json_decode($json);







         $user_id=@$data->user_id;







         $id=@$data->post_id;







         // $id=7;







         $share_count=array(







                 







                 "user_id"=>$user_id,







                 "post_id"=>$id,







                 "date_time"=>date("Y/m/d H:i:s")







          );















        $result_count = $this->db->query("SELECT share,total_share FROM post WHERE id='".$id."'")->row_array();















         if(@$result_count['share'])







          {







             $set_share = explode(",", $result_count['share']);







             array_push($set_share,"$user_id");







             $set_share_count = implode(",", $set_share);







             $total_share=$result_count["total_share"]+1;







          }







          else







            {







              $set_share_count=$user_id;







              $total_share=1;







            }















        // $final_result=$this->db->query("UPDATE post SET share='".$set_share_count."' ,total_share='".$total_share."' WHERE id='".$id."'");







$final_result=true;







          if($final_result)







            {







  $user_data=$this->db->query("SELECT user_id,post_text FROM post WHERE id='".$id."'")->row_array();



// var_dump($user_data);



$user_id_to_sent_data=$user_data["user_id"];



// var_dump($user_id_to_sent_data);



$user_info_for_reciver=$this->db->query("SELECT deviceToken FROM users WHERE id='".$user_id_to_sent_data."'")->row_array();



$commented_by=$this->db->query("SELECT name FROM users WHERE id='".$user_id."'")->row_array();



// var_dump($user_info_for_reciver);



$deviceToken=$user_info_for_reciver["deviceToken"];







$message=@$commented_by["name"]." user is share your '".$user_data["post_text"]."' POST";



// var_dump($message);



               $this->notifitation_ios($deviceToken,$message);







              echo json_encode(array("status"=>"1","message"=>"Share Successfully"));







            }







            else







             {







               echo json_encode(array("status"=>"0","message"=>"data not Share "));







             }







  







         // if($result_count['share'])







         // {







         //    $array = array($user_id);







         //    $total_array_count = array_count_values($array);







            







         //    // $total_share=array('1','2','3');







         //    // array_push($total_share,"$user_id");







         // }else







         // {







         //   $set_count = $user_id;







         // }







          







         //   $result_count_update = $this->db->query("UPDATE post SET share='".."'");















         // echo json_encode(array("status"=>"1","data"=>$total_array_count,"message"=>"Share Successfully"));































      }















    ////=================////















  public function get_comment()







   {







       $json = file_get_contents('php://input');







       // Converts it into a PHP object







       $data = json_decode($json);







       $user_id=@$data->user_id;







       $post_id=@$data->post_id;







       $email=@$data->email;







       $name=@$data->name;







       $get_comment=$this->db->query(" SELECT g.*,u.name ,u.profileimage FROM get_comment as g INNER JOIN users as u ON g.user_id = u.id WHERE g.post_id = '".$post_id."' ORDER BY g.id ASC")->result_array();  
       //var_dump($get_comment);















       echo json_encode(array("status"=>"1","data"=>$get_comment));







    }















        















   ////====================////















   public function support()







    {







       $json = file_get_contents('php://input');







       // Converts it into a PHP object







       $data = json_decode($json);







       $id=@$data->id;







       $user_id=@$data->user_id;







       $support_msg=@$data->support_msg;







       $description=@$data->description;







       







       $insert_data_support=array(















                 "user_id"=>$user_id,







                 "support_msg"=>$support_msg,







                 "description"=>$description,







                 "date_time"=>date("Y/m/d H:i:s")







          );















        $result_support = $this->db->insert("support",$insert_data_support);







       







        if($result_support)







         {







           echo json_encode(array("status"=>"1","message"=>"Support Message Sent Successfully"));







         }







         else







          {







            echo json_encode(array("status"=>"1","message"=>"Support Message not sent"));







           }







     }















    //===============//















    // public function get_post()







    //  {







       //   $json = file_get_contents('php://input');







       //   // Converts it into a PHP object







       //   $data = json_decode($json);







      //    $user_id=@$data->user_id;







       //   $post_id=@$data->postid;







       //   $name=@$data->name;







      //    $profile_img=@$data->profileimage;







     //     $get_post=$this->db->query("select a.*,b.name,b.profileimage from post as a, users as b where b.id=a.user_id")->result_array();















      // echo json_encode(array("status"=>"1","data"=>$get_post));















  //  }























    public function get_post()

     {


        $json = file_get_contents('php://input');


        // Converts it into a PHP object

        $data = json_decode($json);


        $user_id=@$data->user_id;

        $feeling_name=@$data->feeling_name;


        $page_no=@$data->page_no;



        if(!$page_no)

        {



          $page_no=0;


        }


        $limit=$page_no*50;


        // $post_id=@$data->postid;


        $page_number=@$data->page_number;


        // var_dump($user_id);

        $friends=$this->db->query("select following from users where id='".$user_id."' ")->row_array();


        $friend_in_array=explode(",", @$friends["following"]);



$send_follow_in_array=implode("','",explode(",",$friends["following"])) ;



    if(@$friends["following"]=="")

    {

      $friend_in_array=array(); 

    }



          array_push($friend_in_array, $user_id);


// array_push($friend_in_array, explode(",", @$friends["send_follow"]);



        $friends_in_string=implode("','",$friend_in_array);



// var_dump(count($friend_in_array));



        $friends_in_string=$friends_in_string;

// var_dump($friends_in_string);

         // $friend=explode(",", $get_friend_data["following"]);

        $set_feeling_filter="";

if(@$feeling_name)

{

  $set_feeling_filter=" and feeling LIKE '%".@$feeling_name."%'";

}



            $filter=array();
       
for($i=0; $i<count($friend_in_array); $i++)

{

  // var_dump($i);

   // $filter .="(hug ='".$friend_in_array[$i]."' and (hug LIKE '%".$friend_in_array[$i].",%' and hug LIKE '%,".$friend_in_array[$i]."%'))";

// array_push($filter, " hug ='".$friend_in_array[$i]."' or (hug LIKE '%".$friend_in_array[$i].",%' and hug LIKE '%,".$friend_in_array[$i]."%')");
   array_push($filter, " repost_user ='".$friend_in_array[$i]."' or (repost_user LIKE '%".$friend_in_array[$i].",%' and repost_user LIKE '%,".$friend_in_array[$i]."%')");
 
}

$set_filters = "or ( (".implode(" or ",$filter).")  and privacy IN ('Friend','Anonymous') ".$set_feeling_filter.")";





// var_dump($set_filters);

        $get_result_post = $this->db->query("SELECT *,(select users.name from users where users.id=post.user_id) as name,(select users.profileimage from users where users.id=post.user_id) as profileimage,(SELECT count(get_comment.id) from get_comment where get_comment.post_id=post.id) as comments_count from post where privacy='Public' ".$set_feeling_filter." or ( user_id IN ('".$send_follow_in_array."') and privacy IN ('Public') ".$set_feeling_filter.") ".$set_filters." or (user_id='".@$user_id."' and privacy IN ('Friend','Anonymous') ".$set_feeling_filter.") or ( user_id IN ('".$friends_in_string."') and privacy IN ('Friend','Anonymous') ".$set_feeling_filter.") ORDER BY post.date_set_by_system DESC LIMIT ".$limit.",50 ")->result_array();



// 



        // var_dump(count($get_result_post));



        //var_dump($this->db->last_query());



        // var_dump(count($get_result_post));







           echo json_encode(array("status"=>"1","data"=>$get_result_post));







    }





  public function get_friend_posts()
   {
       $json = file_get_contents('php://input');
       // Converts it into a PHP object
       $data = json_decode($json);
       $user_id=@$data->user_id;
       $page_no=@$data->page_no;



        if(!$page_no)

        {



          $page_no=0;


        }


        $limit=$page_no*5;

       $friend_list = $this->db->query("SELECT following FROM users WHERE id='".$user_id."'")->row_array();


       

       //var_dump($friend_list['following']);
       $friends_string = $friend_list['following'];


       
      if(@$friend_list['following'])

    {

          
      $all_post_list= $this->db->query("SELECT *,(select users.name from users where users.id=post.user_id) as name,(select users.profileimage from users where users.id=post.user_id) as profileimage,(SELECT count(get_comment.id) from get_comment where get_comment.post_id=post.id) as comments_count FROM post WHERE user_id IN (".$friend_list['following'].") AND privacy IN ('Friend','Public') OR (user_id='".$user_id."' AND privacy IN ('Friend','Public','Anonymous')) ORDER BY post.date_set_by_system DESC LIMIT ".$limit.",50 ")->result_array();
     // var_dump($this->db->last_query());
             echo json_encode(array("status" => "1","data"=>$all_post_list));
         
    }  
           else
           {
           	$all_post_list=[];
            echo json_encode(array("status" => "1","message" => "You are not following anyone.","data"=>$all_post_list));
           }
      
}





public function get_public_posts()
   {
       $json = file_get_contents('php://input');
       // Converts it into a PHP object
       $data = json_decode($json);
     //  $user_id=@$data->user_id;
       $page_no=@$data->page_no;

        if(!$page_no)
        {
          $page_no=0;
        }
        $limit=$page_no*5;
      // $friend_list = $this->db->query("SELECT following FROM users WHERE id='".$user_id."'")->row_array();
       //var_dump($friend_list['following']);
       //$friends_string = $friend_list['following'];
    
      $all_post_list= $this->db->query("SELECT *,(select users.name from users where users.id=post.user_id) as name,(select users.profileimage from users where users.id=post.user_id) as profileimage,(SELECT count(get_comment.id) from get_comment where get_comment.post_id=post.id) as comments_count FROM post WHERE  privacy IN ('Public') ORDER BY post.date_set_by_system DESC LIMIT ".$limit.",50 ")->result_array();
     // var_dump($this->db->last_query());
      if(@$all_post_list)
    {
             echo json_encode(array("status" => "1","data"=>$all_post_list));
   
    }  
           else
           {
           	$all_post_list=[];
            echo json_encode(array("status" => "1","message" => "There is no Public Post.","data"=>$all_post_list));
           }
      
}





public function get_feeling_posts()
   {
       $json = file_get_contents('php://input');
       // Converts it into a PHP object
       $data = json_decode($json);
       $user_id=@$data->user_id;
       $feeling_name=@$data->feeling_name;
       
       // $post_textO=json_decode('"'.$feeling_name.'"');


       $page_no=@$data->page_no;

        if(!$page_no)
        {
          $page_no=0;
        }
        $limit=$page_no*5;

        $set_feeling_filter="";


 $friend_list = $this->db->query("SELECT following FROM users WHERE id='".$user_id."'")->row_array();

//var_dump($friend_list['following']);
 $friends_string = $friend_list['following'];




if(@$feeling_name)

{
	$feeling = $this->db->query("SELECT id FROM feeling WHERE (name='".$feeling_name."' or nameO='".$feeling_name."')")->row_array();


	$set_feeling_filter=" AND feeling_id='".@$feeling['id']."'";
}

      // $friend_list = $this->db->query("SELECT following FROM users WHERE id='".$user_id."'")->row_array();
       //var_dump($friend_list['following']);
       //$friends_string = $friend_list['following'];
    
      $all_post_list= $this->db->query("SELECT *,(select users.name from users where users.id=post.user_id) as name,(select users.profileimage from users where users.id=post.user_id) as profileimage,(SELECT count(get_comment.id) from get_comment where get_comment.post_id=post.id) as comments_count FROM post WHERE  privacy IN ('Public') ".$set_feeling_filter." or(user_id IN (".$user_id.",".$friend_list['following'].") ".$set_feeling_filter.")  ORDER BY post.date_set_by_system DESC LIMIT ".$limit.",50 ")->result_array();
    
      if(@$all_post_list)
    {
             echo json_encode(array("status" => "1","data"=>$all_post_list));
   
    }  
        
           else
           {
           	$all_post_list=[];
            echo json_encode(array("status" => "1","message" => "There is no Public Post.","data"=>$all_post_list));
           }
           
      
}









  public function get_friend_list()







   {







       $json = file_get_contents('php://input');







       // Converts it into a PHP object







       $data = json_decode($json);







       $user_id=@$data->user_id;







       $result_friend_list = $this->db->query("SELECT following FROM users WHERE id='".$user_id."'")->row_array();















      if($result_friend_list['following'])







         {







          







          $list= $this->db->query("SELECT * FROM users WHERE id in (".$result_friend_list['following'].")")->result_array();















             echo json_encode(array("status" => "1","data"=>$list));







           }







           else







           {







            echo json_encode(array("status" => "0","message" => "not following found"));







           }







      }















    







  //================  04-04-2019 gopal  =====================//



     public function following(){



        $json = file_get_contents('php://input');

         // Converts it into a PHP object

        $data = json_decode($json);

        $current_user_id=@$data->user_id;        // sender user id 9

        $follower_user_id=@$data->friend_id;   // reciever user idm 11


        if($follower_user_id != $current_user_id)
        {

          $send_result = $this->db->query("SELECT following,name FROM users WHERE id='".$current_user_id."'")->row_array();



       

        



        if($send_result['following'])

         {





            $sent_friend = explode(",", $send_result['following']);

            array_push($sent_friend,$follower_user_id);

            $send_friend_request = implode(",", $sent_friend);



        }

          else

         {

            $send_friend_request=$follower_user_id;

         }



          $result_update = $this->db->query("UPDATE users SET following='".$send_friend_request."' WHERE id='".$current_user_id."'"); 





          $get_result = $this->db->query("SELECT follower FROM users WHERE id='".$follower_user_id."'")->row_array();



           // var_dump($get_result['follower']);



        if($get_result['follower'])

           {

               $get_friend_array = explode(",", $get_result['follower']);

               array_push($get_friend_array,$current_user_id);

               $get_friends_string = implode(",", $get_friend_array);



               // var_dump($get_friends_string);

           }

           else

            {

                $get_friends_string=$current_user_id;

            }



             

           $get_friend_Result=$this->db->query("UPDATE users SET follower='".$get_friends_string."' WHERE id='".$follower_user_id."'"); 



            // var_dump($get_friend_Result);





            

            if($result_update)

             {



              //   $insert_notifiction=array(

              //    "from_id"=>$current_user_id,

              //    "to_id"=>$send_friend_request,

              //    "message"=>"sent you a follow request",

              //    "date_time"=>date("Y/m/d H:i:s"),

              //    "type"=>"1",

              // );



               $message=$send_result["name"]." is now following you!";

              // $this->db->insert('sent_notification',$insert_notifiction);



               $deviceToken_get=$this->db->query("SELECT deviceToken from users where id='".$send_friend_request."'")->row_array();



                $deviceToken=$deviceToken_get["deviceToken"];

                $this->notifitation_ios($deviceToken,$message);

                echo json_encode(array("status"=>"1","message"=>"Started following"));

            }

            else

             {

                echo json_encode(array("status"=>"0","message"=>"following not started"));



             }


        }
        else
        {

          echo json_encode(array("status"=>"1","message"=>"Something went wrong!"));
        }




       
       }




///==================
       public function unfollowing(){



        $json = file_get_contents('php://input');

         // Converts it into a PHP object

        $data = json_decode($json);

        $current_user_id=@$data->user_id;        // sender user id 9

        $follower_user_id=@$data->friend_id;   // reciever user idm 11



       $send_result = $this->db->query("SELECT following,name FROM users WHERE id='".$current_user_id."'")->row_array();



       

        



        if($send_result['following'])

         {





            $sent_friend = explode(",", $send_result['following']);

            

            $keys=array_search($follower_user_id, $sent_friend);



           unset($sent_friend[$keys]);



            $send_friend_request = implode(",", $sent_friend);



        }

          else

         {

            $send_friend_request="";

         }



          $result_update = $this->db->query("UPDATE users SET following='".$send_friend_request."' WHERE id='".$current_user_id."'"); 





          $get_result = $this->db->query("SELECT follower FROM users WHERE id='".$follower_user_id."'")->row_array();



           // var_dump($get_result['follower']);



        if($get_result['follower'])

           {

               $get_friend_array = explode(",", $get_result['follower']);

                $keys=array_search($follower_user_id, $get_friend_array);



                unset($get_friend_array[$keys]);




               $get_friends_string = implode(",", $get_friend_array);



               // var_dump($get_friends_string);

           }

           else

            {

                $get_friends_string=$current_user_id;

            }



             

           $get_friend_Result=$this->db->query("UPDATE users SET follower='".$get_friends_string."' WHERE id='".$follower_user_id."'"); 



            // var_dump($get_friend_Result);





            

            if($result_update)

             {



              //   $insert_notifiction=array(

              //    "from_id"=>$current_user_id,

              //    "to_id"=>$send_friend_request,

              //    "message"=>"sent you a follow request",

              //    "date_time"=>date("Y/m/d H:i:s"),

              //    "type"=>"1",

              // );



               $message=$send_result["name"]." is now following you!";

              // $this->db->insert('sent_notification',$insert_notifiction);



               $deviceToken_get=$this->db->query("SELECT deviceToken from users where id='".$send_friend_request."'")->row_array();



                $deviceToken=$deviceToken_get["deviceToken"];

                $this->notifitation_ios($deviceToken,$message);

                echo json_encode(array("status"=>"1","message"=>"Started unfollowing"));

            }

            else

             {

                echo json_encode(array("status"=>"0","message"=>"unfollowing not started"));



             }

       }
///==================       
         



      public function following_list(){



        $json = file_get_contents('php://input');

         // Converts it into a PHP object

        $data = json_decode($json);

        $current_user_id=@$data->user_id;        // sender user id

        $friend_user_id=@$data->friend_id;   // reciever user id



      $send_result_current = $this->db->query("SELECT following,follower,name FROM users WHERE id='".$current_user_id."'")->row_array();

      

         

         $set_following_current = $send_result_current['following'];

         $set_follower_current = $send_result_current['follower'];



          



      $send_result_friend = $this->db->query("SELECT following,name FROM users WHERE id='".$friend_user_id."'")->row_array();

      

         

         $set_following_friend = explode(",", $send_result_friend['following']);





         $get_follwing_result = $this->db->query("SELECT *,CASE WHEN id='".$friend_user_id."' THEN '0' WHEN id IN ('".implode("','", explode(",",$set_following_current))."') THEN '1' WHEN id IN ('".implode("','", explode(",",$set_follower_current))."') THEN '2' ELSE '3' END as type FROM users WHERE id IN ('".implode("','",$set_following_friend)."') and id !='".$current_user_id."'")->result_array();



           // $deviceToken_get=$this->db->query("SELECT deviceToken From users WHERE id IN ('".implode("','",$following)."')")->result_array();




echo json_encode(array("status"=>"1","data"=>$get_follwing_result));
      // var_dump($get_follwing_result);

      // if($get_follwing_result)

      // {

      //   echo json_encode(array("status"=>"1","data"=>$get_follwing_result));

      // }else

      // {

      //   echo json_encode(array("status"=>"0","message"=>'Data not found!'));

      // }



       



     }





      public function follower_list(){



      $json = file_get_contents('php://input');

         // Converts it into a PHP object

        $data = json_decode($json);

        $current_user_id=@$data->user_id;        // sender user id

        $friend_user_id=@$data->friend_id;   // reciever user id



      $send_result_current = $this->db->query("SELECT following,follower,name FROM users WHERE id='".$current_user_id."'")->row_array();

      

         

         $set_following_current = $send_result_current['following'];

         $set_follower_current = $send_result_current['follower'];



          



      $send_result_friend = $this->db->query("SELECT follower,name FROM users WHERE id='".$friend_user_id."'")->row_array();

      

         

         $set_following_friend = explode(",", $send_result_friend['follower']);





         $get_follwing_result = $this->db->query("SELECT *,CASE WHEN id='".$friend_user_id."' THEN '0' WHEN id IN ('".implode("','", explode(",",$set_following_current))."') THEN '1' WHEN id IN ('".implode("','", explode(",",$set_follower_current))."') THEN '2' ELSE '3' END as type FROM users WHERE id IN ('".implode("','",$set_following_friend)."') and id !='".$current_user_id."'")->result_array();



           // $deviceToken_get=$this->db->query("SELECT deviceToken From users WHERE id IN ('".implode("','",$following)."')")->result_array();



    echo json_encode(array("status"=>"1","data"=>$get_follwing_result));
      // var_dump($get_follwing_result);

      // if($get_follwing_result)

      // {

      //   echo json_encode(array("status"=>"1","data"=>$get_follwing_result));

      // }else

      // {

      //   echo json_encode(array("status"=>"0","message"=>'Data not found!'));

      // }



       



     }









    public function send_follow()

     {

        $json = file_get_contents('php://input');

         // Converts it into a PHP object

        // $data = json_decode($json);

        // $current_user_id=@$data->user_id;        // sender user id

        // $reciever_user_id=@$data->friend_id;   // reciever user id


        // $json = file_get_contents('php://input');

         // Converts it into a PHP object

        $data = json_decode($json);

        $current_user_id=@$data->user_id;        // sender user id 9

        $follower_user_id=@$data->friend_id; 

       $send_result = $this->db->query("SELECT following,name FROM users WHERE id='".$current_user_id."'")->row_array();



       

        



        if($send_result['following'])

         {





            $sent_friend = explode(",", $send_result['following']);

            array_push($sent_friend,$follower_user_id);

            $send_friend_request = implode(",", $sent_friend);



        }

          else

         {

            $send_friend_request=$follower_user_id;

         }



          $result_update = $this->db->query("UPDATE users SET following='".$send_friend_request."' WHERE id='".$current_user_id."'"); 





          $get_result = $this->db->query("SELECT follower FROM users WHERE id='".$follower_user_id."'")->row_array();



           // var_dump($get_result['follower']);



        if($get_result['follower'])

           {

               $get_friend_array = explode(",", $get_result['follower']);

               array_push($get_friend_array,$current_user_id);

               $get_friends_string = implode(",", $get_friend_array);



               // var_dump($get_friends_string);

           }

           else

            {

                $get_friends_string=$current_user_id;

            }



             

           $get_friend_Result=$this->db->query("UPDATE users SET follower='".$get_friends_string."' WHERE id='".$follower_user_id."'"); 



            // var_dump($get_friend_Result);





            

            if($result_update)

             {



              //   $insert_notifiction=array(

              //    "from_id"=>$current_user_id,

              //    "to_id"=>$send_friend_request,

              //    "message"=>"sent you a follow request",

              //    "date_time"=>date("Y/m/d H:i:s"),

              //    "type"=>"1",

              // );



               $message=$send_result["name"]." is now following you!";

              // $this->db->insert('sent_notification',$insert_notifiction);



               $deviceToken_get=$this->db->query("SELECT deviceToken from users where id='".$send_friend_request."'")->row_array();



                $deviceToken=$deviceToken_get["deviceToken"];

                $this->notifitation_ios($deviceToken,$message);

                echo json_encode(array("status"=>"1","message"=>"Started following"));

            }

            else

             {

                echo json_encode(array("status"=>"0","message"=>"following not started"));



             }

       }



   public function accept_follow()







    {















         $json = file_get_contents('php://input');







          // Converts it into a PHP object







         $data = json_decode($json);







         $user_id=@$data->user_id;        // sender user id







         $friend_id=@$data->friend_id;        // reciever user id







         $user_data=$this->db->query("select name,following,get_follow from users where id='".$user_id."'")->row_array(); 



         // like user_id=12







         $friend_data=$this->db->query("select name,following,send_follow from users where id='".$friend_id."'")->row_array(); 



         // like friend_id=9



try {



  



  // work for user like id = 9 start



          if(@$friend_data["following"])



         {



          $friend_data_friend=explode(",",$friend_data["following"]);



          array_push($friend_data_friend, $user_id);



          $friend_data_friend=implode(",",$friend_data_friend);



         }



         else



         {



          $friend_data_friend=$user_id;



         } 



        



        $friend_data_gsend_friend_request=explode(",",$friend_data["send_follow"]);



         $keys=array_search($user_id, $friend_data_gsend_friend_request);



         unset($friend_data_gsend_friend_request[$keys]);



         $friend_data_gsend_friend_request=implode(",",$friend_data_gsend_friend_request);



         $res_1=$this->db->query("UPDATE users SET following='".$friend_data_friend."',send_follow='".$friend_data_gsend_friend_request."' where id='".$friend_id."'");



         // work for user like id = 9 end



         // work for user like id = 12 start







         if(@$user_data["following"])



         {



          $user_data_friend=explode(",",$user_data["following"]);



          array_push($user_data_friend, $friend_id);



          $user_data_friend=implode(",",$user_data_friend);



         }



         else



         {



          $user_data_friend=$friend_id;



         }



         



         $user_data_get_friend_request=explode(",",$user_data["get_follow"]);



         $keys=array_search($friend_id, $user_data_get_friend_request);



         unset($user_data_get_friend_request[$keys]);



         $user_data_get_friend_request=implode(",",$user_data_get_friend_request);



         $res_1=$this->db->query("UPDATE users SET following='".$user_data_friend."',get_follow='".$user_data_get_friend_request."' where id='".$user_id."'");



     



        $this->db->delete("sent_notification",array("to_id"=>$user_id,"from_id"=>$friend_id));



         // work for user like id = 12 end



        $insert_notifiction=array(







                 "from_id"=>$user_id,







                 "to_id"=>$friend_id,







                 "message"=>"accepted your follow request",







                 "date_time"=>date("Y/m/d H:i:s"),







                 "type"=>"2",







                );







                $this->db->insert('sent_notification',$insert_notifiction);



             



             $message=$user_data["name"]." accepted your follow request"; // message for sent on mobile notification



              



                



                $deviceToken_get=$this->db->query("SELECT deviceToken from users where id='".$friend_id."'")->row_array();



             $deviceToken=$deviceToken_get["deviceToken"];



                $this->notifitation_ios($deviceToken,$message);







         echo json_encode(array("status"=>"1","message"=>"follow accepted."));



} catch ( Exception $e) {



    echo json_encode(array("status"=>"0","message"=>"something was worng."));



}



    }







   public function reject_follow()







    {







       $json = file_get_contents('php://input');







       // Converts it into a PHP object







       $data = json_decode($json);







       $user_id=@$data->user_id;        // sender user id







       $friend_id=@$data->friend_id;        // reciever user id  







try {



  



   $user_data = $this->db->query("SELECT name,get_follow FROM users WHERE id='".$user_id."'")->row_array();







       $friend_data = $this->db->query("SELECT name,send_follow FROM users WHERE id='".$friend_id."'")->row_array(); 







      if($user_data['get_follow'])



        {







          $user_data_in_array=explode(",",$user_data["get_follow"]);



           $keys=array_search($friend_id, $user_data_in_array);



           unset($user_data_in_array[$keys]);



           $user_data_in_array=implode(",",$user_data_in_array);



           



           $this->db->update('users',array("get_follow"=>$user_data_in_array),array("id"=>$user_id));















           $friend_data_in_array=explode(",",$friend_data["send_follow"]);



           $keys=array_search($user_id, $friend_data_in_array);



           unset($friend_data_in_array[$keys]);



           $friend_data_in_array=implode(",",$friend_data_in_array);



           



           $this->db->update('users',array("send_follow"=>$friend_data_in_array),array("id"=>$friend_id));



            



         $this->db->delete("sent_notification",array("to_id"=>$user_id,"from_id"=>$friend_id));



         // work for user like id = 12 end



        $insert_notifiction=array(







                 "from_id"=>$user_id,







                 "to_id"=>$friend_id,







                 "message"=>"rejected your follow request",







                 "date_time"=>date("Y/m/d H:i:s"),







                 "type"=>"2",







                );



$this->db->insert('sent_notification',$insert_notifiction);



   







                  $message=$user_data["name"]." rejected your follow request";



                



                



                $deviceToken_get=$this->db->query("SELECT deviceToken from users where id='".$friend_id."'")->row_array();



             $deviceToken=$deviceToken_get["deviceToken"];



                $this->notifitation_ios($deviceToken,$message);







           echo json_encode(array("status"=>"1","message"=>"Follow is rejacted.!"));



        }







        else







        {







                echo json_encode(array("status"=>"0","message"=>"No Record Found!"));



          }







} catch (Exception $e) {



     



      echo json_encode(array("status"=>"0","message"=>"Something was wrong!"));



}







      







   







         }























    public function get_notification()

     {



        $json = file_get_contents('php://input');



        $data = json_decode($json);







        $user_id=@$data->user_id;



    
     $get_result_notification = $this->db->query("SELECT *,(select users.name from users where users.id=sent_notification.from_id) as name,(select users.profileimage from users where users.id=sent_notification.from_id) as profileimage,concat('"."  "." ',message) as message  from sent_notification where to_id='".$user_id."' ORDER BY id DESC")->result_array();





        echo json_encode(array("status"=>"1","data"=>$get_result_notification));



  }















  public function total_hug_user_list()
   {

      $json = file_get_contents('php://input');
      $data = json_decode($json);
      $user_id=@$data->user_id;
      $post_id=@$data->post_id;
      $page_no=@$data->page_no;


    if(!$page_no)
      {
        $page_no=0;
      }
        $limit=$page_no*100;
        $hug_id_List = $this->db->query("SELECT hug FROM post WHERE id = '".$post_id."' ")->row_array();

        $set_hug="0";

      if($hug_id_List['hug'])
         {
           $set_hug=$hug_id_List['hug'];
           $currentUser = $this->db->query("SELECT following,follower,block_by_me,block_by_other FROM users WHERE id = '".$user_id."'")->row_array();

            $friends = "0"; // my friends

         if($currentUser['following'])
           {
              $friends = $currentUser['following'];
            }

              $send_request = "0"; // send request friends
           
           if($currentUser['follower']) 
             {
                $send_request = $currentUser['follower'];
             }

             $block_By_me = "0";               
          if($currentUser['block_by_me']) 
           {

             $block_By_me = $currentUser['block_by_me'];
           }

            $block_By_other = "0"; // send request to user
          
          if($currentUser['block_by_other']) 
           {

             $block_By_other = $currentUser['block_by_other'];
           }



            $queryString = "select *,users.id as user_id,CASE WHEN id = '".$user_id."' THEN '0' WHEN id IN (".$friends.") THEN '1' WHEN id IN (".$send_request.") THEN '2'  WHEN id IN (".$block_By_me.") THEN '4'  WHEN id IN (".$block_By_other.") THEN '5' ELSE '3' END as type from users where id IN (".$set_hug.") LIMIT ".$limit.",100";

            //var_dump($queryString);

            // $queryString = "SELECT UserTable.*, (CASE WHEN (SELECT id FROM users WHERE id in($set_friend) && id in(UserTable.id))= UserTable.id THEN '1' WHEN (SELECT id FROM users WHERE id in($set_send) && id in(UserTable.id))= UserTable.id THEN '2' WHEN (SELECT id FROM users WHERE id in($get_friend) && id in(UserTable.id))= UserTable.id THEN '3' ELSE '4' END) as is_friend FROM users as UserTable WHERE UserTable.id IN(".$set_hug.") LIMIT 0,25";
          
            $friendList = $this->db->query($queryString)->result_array();

            // var_dump($this->db->last_query());

             echo json_encode(array("status"=>"1","data"=>$friendList));
        
         }else{
              
              $friendList=[];

              echo json_encode(array("status"=>"1","data"=>$friendList));

              // echo json_encode(array("status"=>"0","data"=>"no record found"));    
       }
 
  }


  
    public function sent_notification()
     {
        $json = file_get_contents('php://input');
         // Converts it into a PHP object
        $data = json_decode($json);
        $user_id=@$data->user_id;
        $message=@$data->message;
        $sent_notification=array(

                  "user_id"=>$user_id,
                  "message"=>$message,
                  "date_time"=>date("Y/m/d H:i:s"),
                  "type"=>"2"
               );

        $sent_result=$this->db->insert("sent_notification",$sent_notification);

      if($sent_result)
      {

         echo json_encode(array("status"=>"1","message"=>"Sent Notification Successfully"));
      }else
        {
          echo json_encode(array("status"=>"0","message"=>"Notification Not Sent"));
        }
       

      }


    public function cancel_follow()
     {

       $json = file_get_contents('php://input');
       // Converts it into a PHP object
       $data = json_decode($json);
       $user_id=@$data->user_id;        // sender user id
       $friend_id=@$data->friend_id;        // reciever user id

       $user_data = $this->db->query("SELECT name,send_follow FROM users WHERE id='".$user_id."'")->row_array();

       $friend_data = $this->db->query("SELECT name,get_follow FROM users WHERE id='".$friend_id."'")->row_array();

      try{

           if($user_data['send_follow'])
           {
              $user_data_in_array=explode(",",$user_data["send_follow"]);
              $keys=array_search($friend_id, $user_data_in_array);
              unset($user_data_in_array[$keys]);
              $user_data_in_array=implode(",",$user_data_in_array);

              $this->db->update('users',array("send_follow"=>$user_data_in_array),array("id"=>$user_id));

              $friend_data_in_array=explode(",",$friend_data["get_follow"]);
              $keys=array_search($user_id, $friend_data_in_array);
              unset($friend_data_in_array[$keys]);
              $friend_data_in_array=implode(",",$friend_data_in_array);
             
              $result_update=$this->db->update('users',array("get_follow"=>$friend_data_in_array),array("id"=>$friend_id));
              $this->db->delete("sent_notification",array("to_id"=>$friend_id,"from_id"=>$user_id));

             if($result_update)
              {
                $insert_notifiction=array(

                         "from_id"=>$user_id,
                         "to_id"=>$friend_id,
                         "message"=>"follow request cancel",
                         "date_time"=>date("Y/m/d H:i:s"),
                         "type"=>"2",
                   );

                $this->db->insert('sent_notification',$insert_notifiction);

                $message=$user_data["name"]." is follow request cancel";
                $deviceToken_get=$this->db->query("SELECT deviceToken from users where id='".$friend_id."'")->row_array();
                $deviceToken=$deviceToken_get["deviceToken"];
                $this->notifitation_ios($deviceToken,$message);

              }


            // var_dump("DELETE FROM sent_notification where from_id='".$user_id."' and to_id='".$friend_id."'");
             echo json_encode(array("status"=>"1","message"=>"Follow cancel!"));
         } else
            {

                echo json_encode(array("status"=>"0","message"=>"No Record Found!"));
              }

        } catch (Exception $e) {



          echo json_encode(array("status"=>"0","message"=>"Something was wrong!"));

        }


      }



public function check_username()
{
   $json = file_get_contents('php://input');

          $data = json_decode($json);
           $user_id=@$data->user_id;
           $username=@$data->username;

           $check_data=$this->db->query("SELECT * FROM users WHERE userName='".$username."' and id !='".$user_id."'")->row_array();

           if(@$check_data)
           {
              echo json_encode(array("status"=>"1","is"=>"0","message"=>"Username is already exixt."));
           }
           else
           {
              echo json_encode(array("status"=>"1","is"=>"1","message"=>"Username is avelavel."));
           } 

}

    public function update_profile()

     {

          $json = file_get_contents('php://input');

          $data = json_decode($json);
           $user_id=@$data->user_id;
           $name=@$data->name;
           $nameO=@$data->nameO;

           $contact=@$data->contact;
           $profileimage=@$data->profileimage;
           $gender=@$data->gender;
           $dob=@$data->dob;

           $country=@$data->country;
           $bio=@$data->bio;
           $username=@$data->username;


           if(@$username)
           {
            $userName=implode("",explode(" ",@$username));
            $update_user_name="1";
            
           }
           else
           {
            $userName=implode("",explode(" ",@$username));
            $update_user_name="0";
              
           }
           // $nameO=json_decode('"'.$name.'"');
            
          // var_dump($nameO);
           $old_img_update = $this->db->query("SELECT profileimage FROM users WHERE id='".$user_id."'")->row_array();

           if($profileimage=="")
            {
              $full_img_name = $old_img_update['profileimage'];
            }

            else

            {


                $data=base64_decode($profileimage);


                $imageName_only = time() . '.png';

                $full_img_name = $user_id."_".$imageName_only;

                $imageName = "assets/profile_img/".$full_img_name;

                file_put_contents($imageName, $data);


               $result_update_profile_img = $this->db->query("SELECT profileimage FROM users WHERE id='".$user_id."'")->row_array();

                 unlink('assets/profile_img/'.$result_update_profile_img['profileimage']);

            }


             // $result_update_profile = $this->db->query("SELECT * FROM users WHERE id='".$user_id."'")->result_array();
            $update_data=array(
              "name"=>$name,
              "country"=>@$country,
              "contact"=>@$contact,
              "profileimage"=>@$full_img_name,
              "gender"=>@$gender,
              "dob"=>@$dob,
              "bio"=>@$bio,
              "userName"=>@$userName,
              "update_user_name"=>@$update_user_name,
              "nameO"=>@$nameO
            );


           $update_profile = $this->db->update("users",$update_data,array("id"=>$user_id));





          if($update_profile)



           {

       $user_data_updated=$this->db->query("SELECT * FROM  users WHERE id='".$user_id."'")->row_array();

            echo json_encode(array("status"=>"1","data"=>$full_img_name,"user_profile"=>@$user_data_updated,"message"=>"Profile has been updated successfully"));



           }


           else


           {



            echo json_encode(array("status"=>"1","message"=>"Profile Not Update"));


           }



     }




   public function get_privacy_policy()
    {

        $json = file_get_contents('php://input');


         // Converts it into a PHP object

        $data = json_decode($json);

        $user_id=@$data->user_id;

        $privacy_policy_content=@$data->privacy_policy_content;

        $get_privacy_policy = $this->db->query("SELECT * FROM privacy_policy")->result_array();


      echo json_encode(array("status"=>"1","data"=>$get_privacy_policy,"message"=>"privacy_policy")); 
        //change password
        // $this->db->where("id",@$user_id);

        // $result_privacy = $this->db->update("privacy_policy",array("privacy_policy_content"=>$privacy_policy_content));

        // if($result_privacy)

        //   {

        //    echo json_encode(array("status"=>"1","data"=>$result_privacy,"message"=>" Updated Successfully.")); 

        //    }else{

        //     echo json_encode(array("status"=>"0","message"=>"Not Updated"));

        //   }

      }

    public function get_about_us()







    {







       $json = file_get_contents('php://input');







        // Converts it into a PHP object







        $data = json_decode($json);







        $user_id=@$data->user_id;







        $about_us_content=@$data->about_us_content;







        $get_about_us = $this->db->query("SELECT * FROM about_us")->row_array();







         //change password







        $this->db->where("id",@$user_id);







        $result_about_us = $this->db->update("about_us" , array("about_us_content"=>$about_us_content));







       







       if($get_about_us)







          {







            echo json_encode(array("status"=>"1","data"=>$get_about_us,"message"=>" Updated Successfully."));  















           }else{















             echo json_encode(array("status"=>"0","message"=>"Not Updated"));







           }







 







      }















  public function logout()







   {







       $json = file_get_contents('php://input');







         // Converts it into a PHP object







       $data = json_decode($json);







       $user_id = @$data->user_id;







       $result_logout=$this->db->query("update users set last_logout='".date('Y/m/d H:i:s')."' where id='".$user_id."'");















        echo json_encode(array("status"=>"1","message"=>"logout Successfully"));







   







    } 















  







   // public function chat()







   //  {







   //     $json = file_get_contents('php://input');







   //      // Converts it into a php object







   //     $data = json_decode($json);







   //     $user_id=@$data->user_id;







   //     $sent_chat = array([


 


   //           "id"=>"1",







   //           "chat"=>"Hiii"


 

   //      ]);


 

   //       echo json_encode(array("status"=>"1","data"=>$sent_chat,"message"=>"message sent successfully"));


 
   //   }






 //================= 05-04-2019 Gopal ===============//

 

  public function get_friend_profile()
  {
     $json = file_get_contents('php://input');
     $data = json_decode($json);
     $user_id=@$data->user_id;
     $friend_id=@$data->friend_id;
    
    try {

        $currentUser = $this->db->query("SELECT following,follower,block_by_me,block_by_other FROM users WHERE id = '".$user_id."'")->row_array();

        // $friend_user = $this->db->query("SELECT block_user FROM users WHERE id = '". $friend_id."'")->row_array();

    

    if($currentUser)
      {
         $friends = "0"; // my friends

          if($currentUser['following']) 
           {

             $friends = $currentUser['following'];
           }

          $send_request_friend = "0"; // send request to user
          
          if($currentUser['follower']) 
           {

             $send_request_friend = $currentUser['follower'];
           }

           $block_By_me = "0"; // send request to user
          
          if($currentUser['block_by_me']) 
           {

             $block_By_me = $currentUser['block_by_me'];
           }

            $block_By_other = "0"; // send request to user
          
          if($currentUser['block_by_other']) 
           {

             $block_By_other = $currentUser['block_by_other'];
           }


          //   $block_user = "0"; // send request to user
          
          // if($currentUser['block_user']) 
          //  {

          //     $block_user = $currentUser['block_user'];
          //  }

          //   $friend_block_user = "0"; // send request to user
          
          // if($friend_user['block_user']) 
          //  {

          //     $friend_block_user = $friend_user['block_user'];
          //  }

          //     $set_block_user = explode(",", $friend_user['block_user']);

          //     $keys=(String)array_search($user_id, $set_block_user);
              

            //  if(@$keys!="")
              // {
                  //   $queryString = "select *,(SELECT COUNT(post.id) FROM post WHERE post.user_id='".$friend_id."') as total_post, 5 as type from users where id='".$friend_id."'";
               //}else
              //  {
                   // $queryString = "select *,(SELECT COUNT(post.id) FROM post WHERE post.user_id='".$friend_id."') as total_post,CASE WHEN id='".$user_id."' THEN '0' WHEN id IN (".$friends.") THEN '1' WHEN id IN (".$send_request_friend.") THEN '2' WHEN id IN (".$block_user.") THEN '4'  ELSE '3' END as type from users where id='".$friend_id."'";
               // }

               

           $queryString = "select *,(SELECT COUNT(post.id) FROM post WHERE post.user_id='".$friend_id."') as total_post,CASE WHEN id='".$user_id."' THEN '0' WHEN id IN (".$friends.") THEN '1' WHEN id IN (".$send_request_friend.") THEN '2' WHEN id IN (".$block_By_me.") THEN '4' WHEN id IN (".$block_By_other.") THEN '5' ELSE '3' END as type from users where id='".$friend_id."'";

            

            $friendList = $this->db->query($queryString)->row_array();

            $follow_count="0";

          if(@$friendList["following"])
            {
                $follow_count=(string)@count(explode(",",@$friendList["following"]));
             }

              $follower_count="0";

             if(@$friendList["follower"])
               {

                  $follower_count=(string)@count(explode(",",@$friendList["follower"]));
               }  

              echo json_encode(array("status"=>"1","data"=>$friendList,"following_count"=>@$follow_count,"follower_count"=>@$follower_count));
     
         }

          else{
                $friendList=[];
                $follow_count="0";
                $follower_count="0";

               echo json_encode(array("status"=>"1","data"=>$friendList,"following_count"=>@$follow_count,"follower_count"=>@$follower_count));
                // echo json_encode(array("status"=>"0","data"=>"no record found"));    
              }  

         } catch (Exception $e) {

            echo json_encode(array("status"=>"0","data"=>"Something was wrong."));
      }  
  
  }




   public function search_friend()

    {


       $json = file_get_contents('php://input');

       $data = json_decode($json);


       $user_id=@$data->user_id;

       $search_text=@$data->search_text;
   
       $page_no=@$data->page_no;

       $more=@$data->more;   // u=user , p=post ''=both
       
      // var_dump($search_text);

        if(!$page_no)

        {


          $page_no=0;

        }


        



       // $get_cuntry=$this->db->query("SELECT a.id as user_id,a.name,a.profileimage,b.post_text,b.feeling FROM users as a ,post as b WHERE a.status='1' and a.otp='DONE' and ( (a.name LIKE '%".$search_text."%' or b.post_text LIKE '%".$search_text."%') and b.user_id=a.id )")->result_array();
       // var_dump($this->db->last_query());
        if($more=="u")
        {

            
          $limit=$page_no*50;
          $user_data=$this->db->query("SELECT  a.id as user_id,a.name,a.profileimage FROM users as a WHERE a.status='1' and a.otp='DONE' and a.name LIKE '%".$search_text."%' LIMIT ".$limit.",50")->result_array();
          if(!@$user_data)
          {
             $user_data=[]; 
          }       
          echo json_encode(array("status"=>"1","users"=>@$user_data));
        }
        elseif ($more=="p") {


          $limit=$page_no*50;
           $post_data=$this->db->query("SELECT a.id as user_id,a.name,a.profileimage,b.post_text,b.feeling FROM users as a ,post as b WHERE a.status='1' and a.otp='DONE' and b.post_text LIKE '%".$search_text."%' and b.user_id=a.id LIMIT ".$limit.",50")->result_array();
          
          if(!@$post_data)
          {
             $post_data=[]; 
          }       
          echo json_encode(array("status"=>"1","post"=>@$post_data));
        }
        else
        {
         // var_dump("SELECT  a.id as user_id,a.name,a.profileimage FROM users as a WHERE a.status='1' and a.otp='DONE' and a.name LIKE '%".$search_text."%' LIMIT ".$limit.",4");

          $limit=$page_no*4;
          $user_data=$this->db->query("SELECT  a.id as user_id,a.name,a.profileimage FROM users as a WHERE a.status='1' and a.otp='DONE' and a.name LIKE '%".$search_text."%' LIMIT ".$limit.",4")->result_array(); 

         $post_data=$this->db->query("SELECT a.id as user_id,a.name,a.profileimage,b.post_text,b.feeling FROM users as a ,post as b WHERE a.status='1' and a.otp='DONE' and b.post_text LIKE '%".$search_text."%' and b.user_id=a.id LIMIT ".$limit.",4")->result_array();         
        if(!@$user_data)
          {
             $user_data=[]; 
          }   

           if(!@$post_data)
           {
              $post_data=[]; 
           }   
         //  $post_data=[];
      echo json_encode(array("status"=>"1","users"=>@$user_data,"post"=>@$post_data));

        }


   

// var_dump($this->db->last_query());

    // $search_data=array(
    //  "users"=>@$user_data,
    //  "post"=>@$post_data
    // );

      



    }

   public function use_same_app()

   {



      $json = file_get_contents('php://input');

      // Converts it into a PHP object

      $data = json_decode($json);

      // $user_id=$data->user_id;



      $check_contact = $data->contact; 

      $user_id = $data->user_id; 

         $page_no=@$data->page_no;


        if(!$page_no)

        {


          $page_no=0;

        }


        $limit=$page_no*100;

        



      $all_contact_result = $this->db->query("SELECT id,name,contact,profileimage FROM `users` WHERE following !='".$user_id."' and (following not LIKE '%".$user_id.",%' and following not LIKE '%,".$user_id."%') and send_follow !='".$user_id."' and (send_follow not LIKE '%".$user_id.",%' and send_follow not LIKE '%,".$user_id."%') and get_follow !='".$user_id."' and (get_follow not LIKE '%".$user_id.",%' and get_follow not LIKE '%,".$user_id."%') and contact IN (".$check_contact.") LIMIT ".$limit.",100")->result_array();





// $get_user_data=$this->db->query("SELECT following,send_follow,get_follow FROM users WHERE id='".$user_id."'")->row_array();

      if($all_contact_result)

        {

         echo json_encode(array("status"=>"1","data"=>$all_contact_result,"message"=>"Contact Number Already Exits!"));

        }

       else



        {

         echo json_encode(array("status"=>"1","data"=>$all_contact_result,"message"=>"No Data Found."));

        }















    }























   public function tranding()







    {







      $json = file_get_contents('php://input');







      // Converts it into a php object







      $data = json_decode($json);







      $user_id=@$data->user_id;







      







      $data_tranding = array(







         [







               "id"=>"1",







               "name"=>"Deepak",







               "color_code"=>"#000080"















          ],







          [







               "id"=>"2", 







               "name"=>"gopal",







               "color_code"=>"#7B68EE"







          ],







          [







                "id"=>"5", 







                "name"=>"Pawan",







                "color_code"=>"#191970"







  







           ]







        );







         







          echo json_encode(array("status"=>"1","data"=>$data_tranding,"message"=>"tranding successfully"));







 







      }























public function friend_list()

{



       $json = file_get_contents('php://input');







       // Converts it into a PHP object







       $data = json_decode($json);







       $user_id=@$data->user_id;







      $page_no=@$data->page_no;







        if(!$page_no)







        {







          $page_no=0;







        }

  $limit=$page_no*100;



    $chat_result = $this->db->query("SELECT following FROM users WHERE id='".$user_id."'")->row_array();



try {



$data=$this->db->query("SELECT * FROM users WHERE id IN('".implode("','",explode(",",@$chat_result["following"]))."' ) ORDER BY `name` ASC LIMIT ".$limit.",100")->result_array();



if(@$data)

{



 echo json_encode(array("status"=>"1","data"=>@$data,"message"=>"Data found"));

}

 else

 {

   echo json_encode(array("status"=>"1","data"=>@$data,"message"=>"Data not found"));

 }

  

} catch (Exception  $e) {

  echo json_encode(array("status"=>"0","message"=>"Something was wrong."));

}











}







 







  public function get_chat_friend_list()

   {



       $json = file_get_contents('php://input');



       $data = json_decode($json);


       $user_id=@$data->user_id;







      $page_no=@$data->page_no;







        if(!$page_no)







        {







          $page_no=0;







        }







        $limit=$page_no*200;



if($user_id)



{



   $chat_result = $this->db->query("SELECT following FROM users WHERE id='".$user_id."'")->row_array();











      if($chat_result['following'])







       {







          $all_chat = $chat_result['following'];







          $chat_users = $this->db->query("select users.id as user_id,users.name,users.profileimage,users.last_login,users.login_status,(select count(chat_message.id) from chat_message where chat_message.send_by=users.id and chat_message.status!='3') as message_count,(select chat_message.message from chat_message where (send_by='".$user_id."' and send_to=users.id) or (send_by=users.id and send_to='".$user_id."') ORDER BY id DESC LIMIT 1) as last_message,(select chat_message.date_time from chat_message where (send_by='".$user_id."' and send_to=users.id) or (send_by=users.id and send_to='".$user_id."') ORDER BY id DESC LIMIT 1) as date_time,(select chat_message.date_time from chat_message where chat_message.send_by=users.id or chat_message.send_to=users.id ORDER BY id DESC LIMIT 1) as date_time from users where id IN('".implode("','",explode(",", $all_chat))."') ORDER BY `date_time` DESC LIMIT ".$limit.",200")->result_array();







// var_dump($this->db->last_query());







echo json_encode(array("status"=>"1","data"=>@$chat_users,"message"=>"Data found"));




        }else{

$chat_users=[];
echo json_encode(array("status"=>"1","data"=>@$chat_users,"message"=>"Data found"));
           // echo json_encode(array("status"=>"0","message"=>"No following found"));

       }



}



else



{



     echo json_encode(array("status"=>"0","message"=>"user_id is required."));



}















      







     







     







     }







      






















public function test_api_feeling_data()
{
  $data='\u0649\u0648';
  $message = json_decode('"'.$data.'"');
  echo @$message;
}








      public function main_five_feeling()

      {

         $json = file_get_contents('php://input');



 $data = json_decode($json);


           $user_id=@$data->user_id;
   


         // Converts it into a PH
 try {


  $insert_feeling=$this->db->query("select name from feeling where parrent='' ORDER BY name ASC")->result_array();


           $set_array=[];



          foreach($insert_feeling as $feeling_get)



          {



            $get_sub=$this->db->query("SELECT * FROM feeling WHERE parrent='".$feeling_get["name"]."' and status='1' ORDER BY reating DESC LIMIT 15")->result_array();
            $set_array[$feeling_get["name"]]=$get_sub;
              
             
  
          }

$get_user_filling=$this->db->query("SELECT * FROM feeling  WHERE status='0' ORDER BY reating DESC LIMIT 15")->result_array();
  
            $set_array["Other"]=$get_user_filling;
         

   



       echo json_encode(array("status"=>"1","data"=>$set_array));



 } catch (Exception $e) {



  echo json_encode(array("status"=>"0","message"=>"something was wrong."));



 }







         















      }







    















      public function chat_message()







      {







//1=send



//2=diliverd



//3= read        



          $json = file_get_contents('php://input');







            // Converts it into a PHP object



      



           $data = json_decode($json);



           $user_id =@$data->send_by;

           $send_by=@$data->send_by;



           $send_to=@$data->send_to;



           $chat_message=@$data->message;



           $status="1";



           


           $chat_message_insert = array(















                      "send_by"=>$send_by,







                      "send_to"=>$send_to,







                      "message"=>$chat_message,







                      "status"=>$status,







                      "date_time"=>date("Y/m/d H:i:s")







            );







          try {



             



                         $chat_insert_result = $this->db->insert("chat_message",$chat_message_insert);















            if($chat_insert_result)







            {

              //var_dump($chat_message_insert);
              //var_dump($user_id);
              //var_dump($chat_message);


  $chat_data=$this->db->query("SELECT id FROM chat_message  WHERE send_by='".$send_by."' AND send_to='".$send_to."' ORDER BY id DESC")->row_array();
  //var_dump($chat_data);
  //var_dump($this->db->last_query());



              echo json_encode(array("status"=>"1","data"=>@$chat_data,"message"=>"Message Sent Successfully"));


               $set_message=$chat_message;



              $message=json_decode('"'.$set_message.'"');



             



                



                $deviceToken_get=$this->db->query("SELECT deviceToken from users where id='".$send_to."'")->row_array();



             $deviceToken=$deviceToken_get["deviceToken"];



                $this->notifitation_ios($deviceToken,$message);







            }else{







              echo json_encode(array("status"=>"0","message"=>"Message Not Sent!"));







            }



          } catch (Exception $e) {



            



            echo json_encode(array("status"=>"0","message"=>"something is wrong pleace try agian!"));



          }



           









 


      }







public function set_test_data()



{

    $json = file_get_contents('php://input');



            // Converts it into a PHP object



           $data = json_decode($json);



           $user_id=@$data->user_id;



           $get_friend_data=$this->db->query("SELECT following FROM users WHERE id='".$user_id."'")->row_array();

           $friend=explode(",", $get_friend_data["following"]);

            $filter="";

for($i=0; $i<count($friend); $i++)

{

  // var_dump($i);

   $filter .=" or (hug ='".$friend[$i]."' and (hug LIKE '%".$friend[$i].",%' and hug LIKE '%,".$friend[$i]."%'))";

}

$set_filters = $filter;

// $set_filters = "";

  $post_id=$this->db->query("SELECT id,user_id FROM post WHERE user_id IN ('".implode("','",explode(",",$get_friend_data["following"]))."') ".$set_filters)->result_array();

// var_dump($post_id);

}



















      public function get_chat_message()







      {







          $json = file_get_contents('php://input');







            // Converts it into a PHP object







           $data = json_decode($json);







           $user_id=@$data->user_id;



           $friend_id=@$data->friend_id;



          $page_no=@$data->page_no;







        if(!$page_no)







        {







          $page_no=0;







        }







        $limit=$page_no*2000;

//if($user_id != $friend_id)
//{

try {



  $ids=$user_id."','".$friend_id;



         $get_result = $this->db->query("SELECT * FROM chat_message WHERE send_by IN('".$ids."') and send_to IN('".$ids."') ORDER BY `id` ASC LIMIT ".$limit.",2000")->result_array();







          



$this->db->query("UPDATE chat_message SET status='3' WHERE send_by ='".$friend_id."' and send_to ='".$user_id."'");











$get_last_filling_of_friend=$this->db->query("SELECT feeling,feeling_color FROM post WHERE user_id='".$friend_id."' ORDER BY id DESC")->row_array();







            echo json_encode(array("status"=>"1","data"=>$get_result,"message"=>"Message found","friend_last_feeling"=>@$get_last_filling_of_friend["feeling"],"feeling_color"=>@$get_last_filling_of_friend["feeling_color"]));



          // if($get_result)







          // {







          //   $this->db->query("UPDATE chat_message SET status='3' WHERE send_by IN('".$ids."') and send_to IN('".$ids."')");







          //   echo json_encode(array("status"=>"1","data"=>$get_result,"message"=>"Message found"));







          // }else{















          //   echo json_encode(array("status"=>"1","message"=>"No Message found"));







          // }



} catch (Exception $e) {



    echo json_encode(array("status"=>"0","message"=>"something is wrong pleace try agian."));  



}



       

//}





















      }























      public function message_status_change()







      {







           $json = file_get_contents('php://input');







            // Converts it into a PHP object







           $data = json_decode($json);







           $user_id=@$data->user_id;



           $friend_id=@$data->friend_id;







           $status=@$data->status;















           $update_status = $this->db->query("UPDATE chat_message SET status='".$status."' WHERE id='".$user_id."'");























           if($update_status)







           {







              echo json_encode(array("status"=>"1","data"=>$update_status,"message"=>"Status Updated Successfully"));















           }else{















              echo json_encode(array("status"=>"0","message"=>"Status Not Update"));







           }







     







      }

   
     public function message_status_delivred()
     {

        $json = file_get_contents('php://input');
         // Converts it into a PHP object
         $data = json_decode($json);







           $user_id=@$data->user_id;







           $status=@$data->status;


         $update_delivred = $this->db->query("UPDATE chat_message SET status='2' WHERE send_to='".$user_id."'");

         if($update_delivred)

          {

            echo json_encode(array("status"=>"1","data"=>$update_delivred,"message"=>"Status Updated Successfully"));

 
           }else{

 
              echo json_encode(array("status"=>"0","message"=>"Status Not Update"));







           }

 

      }



public function text_notic()
{

  //var_dump("dvfdv");
  //var_dump("\ud83d\ude42");
//   $json = file_get_contents('php://input');
//     $data = json_decode($json);
//     $user_id=@$data->user_id;
//    $deviceToken_get=$this->db->query("SELECT deviceToken from users where id='".$user_id."'")->row_array();

// $message="This is test message \ud83d\ude42";
// var_dump($deviceToken_get["deviceToken"]);
//                 $deviceToken=$deviceToken_get["deviceToken"];

//                 $this->notifitation_ios($deviceToken,$message);
}


// public function text_notification()
// {
    
   

//   $message="\u2639\ufe0f";

//   $deviceToken="CFF78BD110F31EC02AAFEA3494D4A8B4AF2FAEAF59FD807DC874D9BF37D7DABF";

//   $this->notifitation_ios($deviceToken,$message); 
// }

 public function notifitation_ios($deviceToken,$message)

 {

$message=json_decode('"'.$message.'"');

  $this->load->view("ios_notification/index",array("deviceToken_set"=>@$deviceToken,"message_set"=>@$message));



 }

 public function post_delete()
 {
    $json = file_get_contents('php://input');
    $data = json_decode($json);
    $user_id=@$data->user_id;
    $post_id=@$data->post_id;
 
    $delete_query = $this->db->query("DELETE FROM post WHERE id='".$post_id."' AND user_id='".$user_id."'");
   
   if($delete_query){
    

       echo json_encode(array("status"=>"1","message"=>"Deleted Successfully."));
    }else
    {
       echo json_encode(array("status"=>"0","message"=>"Delete failed"));
    }
  

  }


   public function arvind(){
       $json = file_get_contents('php://input');
        $data = json_decode($json);
        $searchs = @$data->name;
        //echo $searchs;
        
       // $query = $this->db->get('users');
       
       
       
        $query = $this->db->select('*')->from('test')->like('name',$searchs)->get()->result_array();;
            echo json_encode(array("status"=>"1","users"=>@$query));

           //var_dump($query);
            // foreach ($query->result() as $row)
            // {
            //         echo $row->name;
            // }
             
        
        
   }

  public function ctest()
      {
        $json = file_get_contents('php://input');
        $data = json_decode($json);
        $k = @$data->name;
        //$kk = str_replace(" ", "%", $k);
        // var_dump($k);
        //var_dump($kk);
    
    
    
        $result = $this->db->select('*')->from('users')->like('nameO',$k)->get();
        //var_dump($this->db->last_query());
        if(@$result)
        {
          echo json_encode(array("status"=>"1","data"=>$result,"message"=>"Search data"));
        }
        else
        {
          echo json_encode(array("status"=>"0","message"=>"No Result"));
        }
        
        //var_dump($result);
      }








      public function test()
       {

          $json = file_get_contents('php://input');
          $data = json_decode($json);
          $name=$data->name;
          $key = $data->key;

         

                $insert_d=array(
                     "name"=>@$data->name,
                     "key"=>@$data->key,
                
              );
              
              

           //   $result=$this->db->insert("test",$insert_d);
           $result = $this->db->query("INSERT INTO `test`( `name`, `key`) VALUES ('$name','$key')");
           
              if(@$result)
               {
                   echo json_encode(array("status"=>"1","data"=>$result,"message"=>"data"));
                }
        }




   public function tests()
       {

          $json = file_get_contents('php://input');
          $data = json_decode($json);
          $searchs=$data->name;
          // var_dump($searchs);
          
          $QQQQ = "SELECT name FROM test WHERE name LIKE '%".$searchs."%' ";
          
         // var_dump($QQQQ);
         
         $get_post=$this->db->query("SELECT name FROM test WHERE name LIKE '%".$searchs."%' ")->result_array();
         
//var_dump($this->db->last_query());
      //$get_post1= $get_post->result();
    /*  echo"<pre>";
      print_r($get_post1);
      echo"</pre>";*/

//$ar=array("name"=>'ارفيند');
//echo $var=json_encode($ar,JSON_UNESCAPED_UNICODE);

//echo json_encode($get_post1, JSON_UNESCAPED_UNICODE);
//echo json_encode(array("status"=>"1","data"=>$get_post1,"message"=>"search Data"), JSON_UNESCAPED_UNICODE);

   echo json_encode(array("status"=>"1","data"=>$get_post,"message"=>"Search data in json encode"),JSON_UNESCAPED_UNICODE);



//= $this->db->select('*')->from('test')->like('name',$searchs)->get();

              //$result=$this->db->insert("test",$insert_d);
         //var_dump($searchs);     
        /*$get_post=$this->db->query("SELECT * FROM test WHERE name LIKE '%".@$searchs."%' ")->row_array();
      $get_post1= $result->result($get_post)*/
       
              //var_dump($query);
            //   foreach ($result->result() as $row)
            // {
            //         //echo $row->name;
            //         //echo $row->key;
                    
            // }
            //   if(@$result)
            //   {
            //       //echo json_encode(array("status"=>"1","data"=>$result,"message"=>"data"));
            //     }
        }

public function delete_chat()
{
	$json = file_get_contents('php://input');
    $data = json_decode($json);
    $chat_id=@$data->id;
    $send_by =@$data->send_by;
    //var_dump($chat_id);
    //var_dump($send_by);

    $delete_query = $this->db->query("DELETE FROM chat_message WHERE id='".$chat_id."' AND send_by='".$send_by."'");
   
   if($delete_query){
    

       echo json_encode(array("status"=>"1","message"=>"Deleted Successfully."));
    }else
    {
       echo json_encode(array("status"=>"0","message"=>"Something went wrong !"));
    }
  
}

public function create_user()
{
  $json = file_get_contents('php://input');
  $data = json_decode($json);
  $name=@$data->name;
  $email =@$data->email;
  //$add=rand(1,1000);
  //$user_name = $name."".$add;



    $user_name = str_replace(" ", "_",$name);    
    $addString = str_replace("_","",$user_name); 
    $len = strlen($addString); 
    $n = rand(2,5); 
    //var_dump($n."n");
    //var_dump(strlen($user_name));
    //var_dump(strlen($addString));
    for ($i = 0; $i < $n; $i++) 
    { 
        $index = rand(0, $len - 1);
        //var_dump($index."index");   
        $user = $user_name . $addString[$index]; 
        //var_dump(strlen($user_name));
        //var_dump(strlen($name));

    } 
    //var_dump($index);
  echo json_encode(array("status" =>"1","data"=>$user_name,"message"=>"Generated User"),JSON_UNESCAPED_UNICODE);


}

     // Arvind
    
   public function get_TagList() 
    {

        $json = file_get_contents('php://input');

        $data = json_decode($json);

        $user_id=@$data->user_id;        // sender user id 9
        $send_result = $this->db->query("SELECT following FROM users WHERE id='".$user_id."'")->row_array();
         // var_dump($send_result);
        if($send_result['following'])
         {
          $followingList =  $send_result['following'];
           //var_dump($followingList);
         }

        else
         {
            $followingList="0";
         }
         
         
         $list_result = $this->db->query("SELECT name,profileimage,userName FROM users WHERE id in(".$followingList.")")->result_array();
         
         echo json_encode(array("status"=>"1","data"=>$list_result));

        // var_dump($list_result);

         
         
         
    }

   public function total_refeel_user_list()
    {

    $json = file_get_contents('php://input');
    $data = json_decode($json);
    $user_id=@$data->user_id;
    $post_id=@$data->post_id;
    $page_no=@$data->page_no;


    if(!$page_no)
      {
        $page_no=0;
      }
    $limit=$page_no*100;
    $hug_id_List = $this->db->query("SELECT repost_user FROM post WHERE id = '".$post_id."' ")->row_array();
    $set_hug="0";

    if($hug_id_List['repost_user'])
      {
        $set_hug=$hug_id_List['repost_user'];
        $currentUser = $this->db->query("SELECT following,follower,block_by_me,block_by_other FROM users WHERE id = '".$user_id."'")->row_array();
        $friends = "0"; // my friends

        if($currentUser['following'])
          {
            $friends = $currentUser['following'];
          }
          $send_request = "0"; // send request friends
           
        if($currentUser['follower']) 
          {
           $send_request = $currentUser['follower'];
          }

        $block_By_me = "0";               
        if($currentUser['block_by_me']) 
          {
           $block_By_me = $currentUser['block_by_me'];
          }

        $block_By_other = "0"; // send request to user
        if($currentUser['block_by_other']) 
          {
           $block_By_other = $currentUser['block_by_other'];
          }
        $queryString = "select *,users.id as user_id,CASE WHEN id = '".$user_id."' THEN '0' WHEN id IN (".$friends.") THEN '1' WHEN id IN (".$send_request.") THEN '2'  WHEN id IN (".$block_By_me.") THEN '4'  WHEN id IN (".$block_By_other.") THEN '5' ELSE '3' END as type from users where id IN (".$set_hug.") LIMIT ".$limit.",100";
       // var_dump($queryString);
        
        $friendList = $this->db->query($queryString)->result_array();
        echo json_encode(array("status"=>"1","data"=>$friendList));
        
      }
      else
      {
         $friendList=[];
         echo json_encode(array("status"=>"1","data"=>$friendList));
      }
 
  }
  
  
   public function search_friendA()
    {


       $json = file_get_contents('php://input');

       $data = json_decode($json);


       $user_id=@$data->user_id;

       $search_text=@$data->search_text;
   
       $page_no=@$data->page_no;

       $more=@$data->more;   // u=user , p=post ''=both
       
       // var_dump($search_text);

        if(!$page_no)

        {


          $page_no=0;

        }

        if($more=="u")
        {

            
          $limit=$page_no*50;
          $user_data=$this->db->query("SELECT  a.id as user_id,a.name,a.profileimage FROM users as a WHERE a.status='1' and a.otp='DONE' and (a.nameO LIKE '%".$search_text."%' or a.name LIKE '%".$search_text."%') LIMIT ".$limit.",50")->result_array();
          if(!@$user_data)
          {
             $user_data=[]; 
          }       
          echo json_encode(array("status"=>"1","users"=>@$user_data));
        }
        elseif ($more=="p") {


          $limit=$page_no*50;
           $post_data=$this->db->query("SELECT a.id as user_id,a.name,a.profileimage,b.post_text,b.feeling FROM users as a ,post as b WHERE a.status='1' and a.otp='DONE' and b.post_textO LIKE '%".$search_text."%' and b.user_id=a.id LIMIT ".$limit.",50")->result_array();
          
          if(!@$post_data)
          {
             $post_data=[]; 
          }       
          echo json_encode(array("status"=>"1","post"=>@$post_data));
        }
        else
        {
     
         // var_dump("SELECT  a.id as user_id,a.name,a.profileimage FROM users as a WHERE a.status='1' and a.otp='DONE' and a.name LIKE '%".$search_text."%' LIMIT ".$limit.",4");

          $limit=$page_no*4;
          $user_data=$this->db->query("SELECT  a.id as user_id,a.name,a.profileimage FROM users as a WHERE a.status='1' and a.otp='DONE' and (a.nameO LIKE '%".$search_text."%' or a.name LIKE '%".$search_text."%') LIMIT ".$limit.",4")->result_array();
          
             //var_dump("SELECT  a.id as user_id,a.name,a.profileimage FROM users as a WHERE a.status='1' and a.otp='DONE' and a.name LIKE '%".$search_text."%' LIMIT ".$limit.",4");


         $post_data=$this->db->query("SELECT a.id as user_id,a.name,a.profileimage,b.post_text,b.feeling FROM users as a ,post as b WHERE a.status='1' and a.otp='DONE' and (b.post_textO LIKE '%".$search_text."%' or b.post_text LIKE '%".$search_text."%') and b.user_id=a.id LIMIT ".$limit.",4")->result_array();         
        if(!@$user_data)
          {
             $user_data=[]; 
          }   

           if(!@$post_data)
           {
              $post_data=[]; 
          }   
           //$post_data=[];
       echo json_encode(array("status"=>"1","users"=>@$user_data,"post"=>@$post_data));

        }

    }

   
  
   public function search_hashTag()
    {

       $json = file_get_contents('php://input');

       $data = json_decode($json);

       $user_id=@$data->user_id;

       $search_text=@$data->feeling_name;
   
       $page_no=@$data->page_no;

      
       
       // var_dump($search_text);

        if(!$page_no)
        {
          $page_no=0;
        }
        $limit=$page_no*50;

       //  var_dump("SELECT a.id as user_id,a.name,a.profileimage,b.post_text,b.feeling FROM users as a ,post as b WHERE b.post_text LIKE '%".$search_text."%' and b.user_id=a.id LIMIT ".$limit.",20");
         
       $post_data=$this->db->query("SELECT *,(select users.name from users where users.id=post.user_id) as name,(select users.profileimage from users where users.id=post.user_id) as profileimage,(SELECT count(get_comment.id) from get_comment where get_comment.post_id=post.id) as comments_count from post where post.post_textO LIKE '%".$search_text."%' ORDER BY post.date_set_by_system DESC LIMIT ".$limit.",50 ")->result_array();   
       

          if(!@$post_data)
          {
             $post_data=[]; 
          }   
          
         echo json_encode(array("status"=>"1","data"=>@$post_data));

  }
  
  
   public function search_Mention()
    {

       $json = file_get_contents('php://input');

       $data = json_decode($json);

       $user_id=@$data->user_id;

       $search_text=@$data->search_text;
       $post_data=$this->db->query("SELECT id as user_id FROM users WHERE userName ='".$search_text."'")->row_array();   
       
       if (@$post_data["user_id"]){
          echo json_encode(array("status"=>"1","user_id"=>@$post_data["user_id"]));
       }else{
          echo json_encode(array("status"=>"1","user_id"=>"0")); 
       }
       

    }
 
 
}
 ?>