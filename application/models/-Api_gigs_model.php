<?php
class Api_gigs_model extends CI_Model
{
    public function __construct() {

        parent::__construct();
        $this->load->helper('favourites');
        $common_settings = gigs_settings();
        $this->default_currency = 'USD';
        if(!empty($common_settings)){
          foreach($common_settings as $datas){
            if($datas['key']=='currency_option'){
             $default_currency = $datas['value'];
            }
         }
        }
        $this->load->helper('currency');
        $this->default_currency      = $default_currency;
        $this->default_currency_sign = currency_sign($default_currency);

        $this->load->model('templates_model');
        $this->load->model('user_panel_model');
        $this->load->model('gigs_model');
        $this->load->model('payment_model');
        $this->email_address = 'mail@example.com';
        $this->email_tittle  = 'Gigs';
        $this->logo_front    = base_url().'assets/images/logo.png';
        $this->site_name     = 'Gigs';
        $this->base_domain   = base_url();
    }

     public function current_paypal_id($id){
        $where  = array('user_id' =>$id);
        $data = $this->db->get_where('bank_account',$where)->row();
        return (!empty($data))?$data->paypal_email_id:'';
    }


    public function popular_gigs_image(){

        $this->db->select('SG.id,replace(SG.title,"-", " ") as title , IFNULL(GI.image_path, "") AS image');
        $this->db->from('sell_gigs AS SG');
        $this->db->join('gigs_image AS GI', 'GI.gig_id = SG.id', 'LEFT');
        $this->db->join('members AS M', 'M.USERID = SG.user_id', 'LEFT');
        $this->db->where('SG.status',0);
        $this->db->where('M.status',0);
        $this->db->group_by('SG.id');
        $this->db->order_by('total_views', 'desc');
        $this->db->limit(5);
        return $this->db->get()->result_array();

    }

    public function popular_gigs_list($id = ''){


     $query_string = "SELECT SG.id,SG.user_id,SG.delivering_time as delivering_days,SG.currency_type,CASE SG.currency_type when 'USD'  then '$' when 'EUR'  then '€' when 'GBP'  then '£' END as currency_sign, replace(SG.title,'-', ' ') as title ,SG.gig_price,SG.total_views,M.fullname,IFNULL(C.country, '') AS country,IFNULL(S.state_name, '') AS state_name, IFNULL(GI.gig_image_medium, '') AS image,(SELECT count(id) FROM `feedback` WHERE `gig_id` = SG.id and to_user_id = SG.user_id) AS gig_usercount,

                (SELECT COALESCE(CAST(AVG(rating) AS DECIMAL(10,1)),0) as rating FROM `feedback` WHERE `gig_id` = SG.id and to_user_id = SG.user_id) AS gig_rating ,'0' as favourite  FROM sell_gigs AS SG

        LEFT JOIN gigs_image AS GI  ON GI.gig_id = SG.id

        LEFT JOIN members AS M  ON M.USERID = SG.user_id

        LEFT JOIN country AS C  ON C.id = M.country

        LEFT JOIN states AS S  ON S.state_id = M.state

        WHERE SG.status = 0 AND M.status = 0";



        if(!empty($id) && $id!=0){

           $query_string .= " AND SG.user_id != $id";

        }

        $query_string .= " GROUP BY SG.id ORDER BY total_views DESC LIMIT 0,5";

        $query = $this->db->query($query_string);



        if ($query->num_rows() > 0) {

            return $query->result_array();

        }else{

            return array();

        }



    }

    public function recent_gigs_list($id = ''){



        $query_string = "SELECT SG.id,SG.user_id,SG.delivering_time as delivering_days,SG.currency_type,CASE SG.currency_type when 'USD'  then '$' when 'USR'  then '$' when 'EUR'  then '€' when 'GBP'  then '£' END as currency_sign, replace(SG.title,'-', ' ') as title ,SG.gig_price,SG.total_views,M.fullname,IFNULL(C.country, '') AS country,IFNULL(S.state_name, '') AS state_name, IFNULL(GI.gig_image_medium, '') AS image,(SELECT count(id) FROM `feedback` WHERE `gig_id` = SG.id and to_user_id = SG.user_id) AS gig_usercount,

                (SELECT COALESCE(CAST(AVG(rating) AS DECIMAL(10,1)),0) as rating FROM `feedback` WHERE `gig_id` = SG.id and to_user_id = SG.user_id) AS gig_rating ,'0' as favourite FROM sell_gigs AS SG

        LEFT JOIN gigs_image AS GI  ON GI.gig_id = SG.id

        LEFT JOIN members AS M  ON M.USERID = SG.user_id

        LEFT JOIN country AS C  ON C.id = M.country

        LEFT JOIN states AS S  ON S.state_id = M.state

        WHERE SG.status = 0 AND M.status = 0";



        if(!empty($id) && $id!=0){

            $query_string .= " AND SG.user_id != $id";

        }



        $query_string .= " GROUP BY SG.id ORDER BY SG.id DESC LIMIT 0,5";

        $query = $this->db->query($query_string);



        if ($query->num_rows() > 0) {

            return $query->result_array();

        }else{

            return array();

        }

    }



    public function categories(){



        $this->db->select('C.CATID AS id, C.name AS category,IF(count(SC.CATID)>=1, "1", "0") as subcategory');

        $this->db->from('sell_gigs AS SG');

        $this->db->join('categories AS C', 'C.CATID = SG.category_id', 'LEFT');

        $this->db->join('categories AS SC', 'SC.parent = C.CATID', 'LEFT');

        $this->db->where('C.parent',0);



        $this->db->where('C.status',0);

        $this->db->group_by('category_id');

        $this->db->order_by('total_views', 'desc');

        $this->db->limit(3);



        $category_array = $this->db->get()->result_array();

      //  echo $this->db->last_query();



        $categories = array();

        if(!empty($category_array)){

          foreach ($category_array as $value) {

            $value['sub_category'] = array();

            if($value['subcategory']==1){

              $id = $value['id'];

              $query = $this->db->query("SELECT name FROM categories WHERE parent = $id ORDER BY name ASC LIMIT 0,2");

              if($query->num_rows() > 0){

                  $value['sub_category'] = $query->result_array();

              }



            }

            $categories[] = $value;

          }

        }

        return $categories;

    }



     public function allcategories($type){

            $catgories = array();
            
              $query_string = "SELECT a.CATID as cid,a.name, IF(count(b.CATID)>=1, '1', '0') as subcategory  FROM `categories` as a  LEFT JOIN  categories as b on b.parent = a.CATID and b.parent >0  WHERE a.status = 0  and a.parent = 0 group by a.CATID";
               $query = $this->db->query($query_string);
              if ($query->num_rows() > 0) {
                   $catgories =  $query->result_array();
             }
             $catgories_all = array();
            if(strtolower($type) == 'all'){

                if(!empty($catgories)){
                    foreach ($catgories as $catgorie_all) {
                      $catgories_all[] = $catgorie_all;
                     $this->db->select('CATID as cid,name,"0" as subcategory'); 
                    $this->db->order_by('name', 'asc');
                    $result = $this->db->get_where('categories',array('status'=> 0,'parent' => $catgorie_all['cid']))->result_array();
                    $catgories_all = array_merge($catgories_all,$result);
                    
                    }
                }
               $catgories = array(); 
               $catgories =  $catgories_all;
            }

            

            return  $catgories;





    }





    public function categoriesandgigs($category_id,$sub_categoryid,$user_id,$services,$device_type='',$page=1){

            $services = strtolower($services);

            $records  = array();

            if(!empty($user_id) && $user_id!=0){

              $favourites_gig_ids = $this->gigs->favourites_gig_ids($user_id);

            }





            $query_common_query = "SELECT SG.id,SG.user_id,SG.delivering_time as delivering_days,SG.category_id,SG.currency_type,CASE SG.currency_type when 'USD'  then '$' when 'EUR'  then '€' when 'GBP'  then '£' END as currency_sign, replace(SG.title,'-', ' ') as title ,SG.gig_price,SG.total_views,M.fullname,C.country,IFNULL(S.state_name, '') AS state_name, GI.gig_image_medium AS image,(SELECT count(id) FROM `feedback` WHERE `gig_id` = SG.id and to_user_id = SG.user_id) AS gig_usercount,

                (SELECT COALESCE(CAST(AVG(rating) AS DECIMAL(10,1)),0) as rating FROM `feedback` WHERE `gig_id` = SG.id and to_user_id = SG.user_id) AS gig_rating,'0' as favourite  FROM sell_gigs AS SG

                LEFT JOIN gigs_image AS GI  ON GI.gig_id = SG.id

                LEFT JOIN members AS M  ON M.USERID = SG.user_id

                LEFT JOIN country AS C  ON C.id = M.country

                LEFT JOIN states AS S  ON S.state_id = M.state ";



            // Buyser and Seller Gigs List

            if(empty($category_id) && empty($sub_categoryid) &&  empty($user_id) && ($services=='all')){



                 $query_string =  $query_common_query;

                 $query_string .= " WHERE SG.status = 0 AND M.status = 0 GROUP BY SG.id ORDER BY SG.id ASC";

                 $query = $this->db->query($query_string);

                if ($query->num_rows() > 0) {

                    $records =  $query->result_array();

                    if(!empty($favourites_gig_ids)){

                      if(!empty($records)){

                        $records = favorites_check($records,$favourites_gig_ids);

                      }

                    }

                }

               // Buyser  Gigs List

            }if(empty($category_id) && empty($sub_categoryid) &&  !empty($user_id) && ($services=='all')){



                 $query_string =  $query_common_query;

                 $query_string .= " WHERE SG.status = 0 AND M.status = 0 AND SG.user_id != $user_id GROUP BY SG.id ORDER BY SG.id ASC";

                 $query = $this->db->query($query_string);

                if ($query->num_rows() > 0) {

                    $records =  $query->result_array();

                    if(!empty($favourites_gig_ids)){

                      if(!empty($records)){

                        $records = favorites_check($records,$favourites_gig_ids);

                      }

                    }

                }

             // Category Gigs

            }if(!empty($category_id) && ($services=='all'))

            {



                $query = $this->db->query("SELECT count(CATID) AS subcategory FROM categories WHERE parent = $category_id");

                $count =  $query->row_array();



               if($count['subcategory'] >0)

               {

                    if(empty($sub_categoryid)){

                        $this->db->select('CATID as cid,name');

                        $this->db->from('categories');

                        $this->db->where('parent',$category_id);

                        $this->db->where(array('status'=>0,'delete_sts'=>0));

                        $this->db->order_by('name', 'ASC');

                        $records  =  $this->db->get()->result_array();



                    }elseif(empty($records)){



                        if(!empty($sub_categoryid)){

                            // With sub category, with and with out login

                         $query_string =  $query_common_query;

                         $query_string .= " LEFT JOIN categories AS CA ON CA.CATID = $sub_categoryid ";

                         $query_string .= " WHERE SG.status = 0 AND M.status = 0 AND category_id = $sub_categoryid AND CA.parent = $category_id";



                         if($user_id!=0 && !empty($user_id)){

                            $query_string .= " AND SG.user_id != $user_id";

                          }



                         $query_string .= " GROUP BY SG.id ORDER BY SG.id ASC";

                         $query = $this->db->query($query_string);

                            if ($query->num_rows() > 0) {

                                $records =  $query->result_array();

                                if(!empty($favourites_gig_ids)){

                                  if(!empty($records)){

                                    $records = favorites_check($records,$favourites_gig_ids);

                                  }

                                }

                            }

                        }



                    }

                }

                else

                {

                 // No sub category, with and with out login



                     $query_string =  $query_common_query;

                     $query_string .= " WHERE SG.status = 0 AND M.status = 0 AND category_id = $category_id";



                     if($user_id!=0 && !empty($user_id)){

                        $query_string .= " AND SG.user_id != $user_id";

                      }



                    $query_string .= " GROUP BY SG.id ORDER BY SG.id ASC";

                    $query = $this->db->query($query_string);

                    if ($query->num_rows() > 0) {

                        $records =  $query->result_array();

                        if(!empty($favourites_gig_ids)){

                          if(!empty($records)){

                            $records = favorites_check($records,$favourites_gig_ids);

                          }

                        }

                    }

                }



            }


          if(isset($device_type) && !empty($device_type) && ($device_type == 'ios' || $device_type == 'android'))
          {
            $total_records = count($records);
            if($page == 1) {
               $start = 0;
            }else {
               $start = ($page-1) * 10;
            }
            $records = array_slice( $records, $start, 10 );
            return array('total_pages'=>ceil($total_records/10),'category_details'=>$records);
          }
          else {
            return $records;
          }





     }



     public function gigs_list($userid){



            $giges = array();



          $query_string = "SELECT SG.id,SG.user_id,SG.delivering_time as delivering_days,SG.currency_type,CASE SG.currency_type when 'USD'  then '$' when 'EUR'  then '€' when 'GBP'  then '£' END as currency_sign, replace(SG.title,'-', ' ') as title ,SG.gig_price,SG.total_views,M.fullname,C.country,S.state_name, GI.gig_image_medium AS image,(SELECT count(id) FROM `feedback` WHERE `gig_id` = SG.id and to_user_id = SG.user_id) AS gig_usercount,

                (SELECT COALESCE(CAST(AVG(rating) AS DECIMAL(10,1)),0) as rating FROM `feedback` WHERE `gig_id` = SG.id and to_user_id = SG.user_id) AS gig_rating ,'0' as favourite FROM sell_gigs AS SG

                LEFT JOIN gigs_image AS GI  ON GI.gig_id = SG.id

                LEFT JOIN members AS M  ON M.USERID = SG.user_id

                LEFT JOIN country AS C  ON C.id = M.country

                LEFT JOIN states AS S  ON S.state_id = M.state

                WHERE SG.status = 0 AND M.status = 0";

                if($userid!=0){

                    $query_string .= " AND SG.user_id != $userid";

                }

                  $query_string .= " ORDER BY SG.id ASC";



                $query = $this->db->query($query_string);



            if ($query->num_rows() > 0) {

                   $giges =  $query->result_array();

            }

            return $giges;

     }





     public function my_gigs_list($userid){



            $giges = array();

        if($userid!=0){

          $query_string = "SELECT SG.id,SG.user_id,SG.delivering_time as delivering_days,SG.currency_type,CASE SG.currency_type when 'USD'  then '$' when 'EUR'  then '€' when 'GBP'  then '£' END as currency_sign, replace(SG.title,'-', ' ') as title ,SG.gig_price,SG.total_views,M.fullname,IFNULL(C.country, '') AS country,IFNULL(S.state_name, '') AS state_name, IFNULL(GI.gig_image_medium, '') AS image,(SELECT count(id) FROM `feedback` WHERE `gig_id` = SG.id and to_user_id = SG.user_id) AS gig_usercount,

                (SELECT COALESCE(CAST(AVG(rating) AS DECIMAL(10,1)),0) as rating FROM `feedback` WHERE `gig_id` = SG.id and to_user_id = SG.user_id) AS gig_rating ,'0' as favourite FROM sell_gigs AS SG

                LEFT JOIN gigs_image AS GI  ON GI.gig_id = SG.id

                LEFT JOIN members AS M  ON M.USERID = SG.user_id

                LEFT JOIN country AS C  ON C.id = M.country

                LEFT JOIN states AS S  ON S.state_id = M.state

                WHERE SG.status = 0 AND M.status = 0 AND SG.user_id = $userid GROUP BY SG.id  ORDER BY SG.id ASC";



                $query = $this->db->query($query_string);



            if ($query->num_rows() > 0) {

                   $giges =  $query->result_array();

             }

           }

            return $giges;

     }



     public function gigs_details($userid,$gigid){



        $array    = array();

        $array['gigs_details'] = array();

       if($userid!=0){

       $this->db->select('id');
       $this->db->from('views');
       $this->db->where('user_id',$userid);
       $this->db->where('gig_id',$gigid);
       $check_views = $this->db->count_all_results();

       $this->db->select('id');
       $this->db->from('sell_gigs');
       $this->db->where('user_id',$userid);
       $this->db->where('id',$gigid);
       $check_self_gig = $this->db->count_all_results();

       if($check_views == 0 && $check_self_gig == 0){
         $this->db->insert('views', array('user_id'=>$userid, 'gig_id'=>$gigid));

         $this->db->set('total_views', 'total_views+1', FALSE);
         $this->db->where('id',$gigid);
         $this->db->update('sell_gigs');
       }

       }


        if(!empty($userid) && $userid!=0){

          $favourites_gig_ids = $this->favourites_gig_ids($userid);

        }
  if($gigid!=0){



          $query_string = "SELECT SG.id,SG.user_id,SG.delivering_time as delivering_days,SG.cost_type,SG.currency_type,CASE SG.currency_type when 'USD'  then '$' when 'EUR'  then '€' when 'GBP'  then '£' END as currency_sign, replace(SG.title,'-', ' ') as title ,SG.gig_price,IF(LOWER(SG.super_fast_delivery) = 'yes',1,0) as is_superfast,SG.category_id,SG.gig_details,SG.requirements,IF(SG.super_fast_charges!=0,SG.super_fast_charges,'') as super_fast_charges,SG.super_fast_delivery_desc,SG.super_fast_delivery_date as super_fast_days ,SG.total_views,IFNULL(C.country, '') AS country,IFNULL(S.state_name, '') AS state_name, IFNULL(GI.gig_image_medium, '') AS image,(SELECT count(id) FROM `feedback` WHERE `gig_id` = SG.id and to_user_id = SG.user_id) AS gig_usercount,

                IFNULL((SELECT COALESCE(CAST(AVG(rating) AS DECIMAL(10,1)),0) as rating FROM `feedback` WHERE to_user_id = SG.user_id group by to_user_id), '0.0') AS gig_rating , M.email,M.username,M.fullname,M.user_timezone,M.verified,M.status,M.city,M.address,M.zipcode,M.lang_speaks,M.unique_code,IFNULL(M.country, '') AS country_id,IFNULL(M.state, '') AS state,IFNULL(M.profession, '') AS profession,IFNULL(P.profession_name, '') AS profession_name,M.contact,M.description,M.user_thumb_image,M.user_profile_image ,'0' as favourite  FROM sell_gigs AS SG  LEFT JOIN gigs_image AS GI  ON GI.gig_id = SG.id";



        $query_string .= " LEFT JOIN members AS M  ON M.USERID = SG.user_id LEFT JOIN members AS M1  ON M1.USERID = SG.user_id

        LEFT JOIN country AS C  ON C.id = M1.country

        LEFT JOIN states AS S  ON S.state_id = M1.state

        LEFT JOIN profession AS P  ON P.id = M1.profession

        WHERE SG.status = 0 AND M.status = 0 AND SG.id = $gigid   ORDER BY SG.id ASC";

        $query = $this->db->query($query_string);



        $similar_gigs    = array();



        if ($query->num_rows() > 0) {



            $gig_details =  $query->row_array();

            $currency_type = $gig_details['currency_type'];
            $currency_sign = $gig_details['currency_sign'];

            $gid = $gig_details['id'];

            if(!empty($favourites_gig_ids)){

              if(in_array($gid, $favourites_gig_ids)){

                $gig_details['favourite'] = 1;

              }

            }



            $gig_details['extra_gigs'] = array();

            $single = "'";
            $query1 = $this->db->query("SELECT  gigs_id,extra_gigs, $single$currency_type$single  as currency_type,$single$currency_sign$single as currency_sign,extra_gigs_amount,extra_gigs_delivery, 0 as is_selected FROM extra_gigs WHERE gigs_id = $gid");

            if ($query1->num_rows() > 0) {

              $gig_details['extra_gigs'] = $query1->result_array();

            }

            $gig_details['gig_details'] = rtrim(strip_tags($gig_details['gig_details']));

            $gig_details['requirements'] = rtrim(strip_tags($gig_details['requirements']));



            $array['gigs_details'] = $gig_details;

            $category_id = $gig_details['category_id'];

            $category_gig_id = $gig_details['id'];



            $similar_query_string = "SELECT SG.id,SG.user_id,SG.delivering_time as delivering_days,SG.cost_type,SG.currency_type,CASE SG.currency_type when 'USD'  then '$' when 'EUR'  then '€' when 'GBP'  then '£' END as currency_sign, replace(SG.title,'-', ' ') as title ,SG.gig_price,SG.category_id,IFNULL(GI.gig_image_medium, '') AS image,(SELECT count(id) FROM `feedback` WHERE `gig_id` = SG.id and to_user_id = SG.user_id) AS gig_usercount, (SELECT COALESCE(CAST(AVG(rating) AS DECIMAL(10,1)),0) as rating FROM `feedback`

            WHERE `gig_id` = SG.id and to_user_id = SG.user_id) AS gig_rating, IFNULL(C.country, '') AS country,IFNULL(S.state_name, '') AS state_name,M.fullname,'0' as favourite FROM sell_gigs AS SG

            LEFT JOIN gigs_image AS GI  ON GI.gig_id = SG.id

            LEFT JOIN members AS M  ON M.USERID = SG.user_id

            LEFT JOIN country AS C  ON C.id = M.country

            LEFT JOIN states AS S  ON S.state_id = M.state



        WHERE SG.status = 0 AND M.status = 0 AND SG.category_id= $category_id AND SG.id != $category_gig_id ";

        if(!empty($userid) && $userid!=0){ $similar_query_string .= " AND SG.user_id != $userid";       }

        $similar_query_string .= " ORDER BY SG.id DESC LIMIT 0,5";

        $query = $this->db->query($similar_query_string);

        $array['similar_gigs'] =array();

        if ($query->num_rows() > 0) {



           $similar_gigs = $query->result_array();



            if(!empty($favourites_gig_ids)){

               if(!empty($similar_gigs)){

                  $similar_gigs = favorites_check($similar_gigs,$favourites_gig_ids);

                }

            }

          $array['similar_gigs'] =  $similar_gigs;

        }



        $array['reviews'] =  $this->seller_buyer_review('',$gid,1);

         }



         }   return $array;

     }



     public function seller_buyer_review($userid,$gid,$limit){



        $this->db->select('gig_id,comment,F.rating,time_zone,F.created_date,to_user_id,from_user_id,M.fullname AS sellername,M1.fullname AS buyername,IFNULL(M1.user_thumb_image, "") AS profile_img');

        $this->db->from('feedback AS F');

        $this->db->where('F.gig_id',$gid);

        $this->db->join('members AS M', 'M.USERID = F.to_user_id', 'LEFT');

        $this->db->join('members AS M1', 'M1.USERID = F.from_user_id', 'left');

        if($limit==1){

          $this->db->limit(3);

        }



        $records = $this->db->get()->result_array();


        return $records;



     }





public function remove_favourites($gig_id,$user_id)

{



  return $this->db->query("DELETE FROM `favourites` WHERE `user_id` = $user_id AND `gig_id` = $gig_id");



}

public function add_favourites($data)

{



  return $this->db->insert('favourites',$data);



}



 public function create_gigs($data){

  $gigs_details = array();
  $gigs_details['title'] = $title = str_replace(' ', '-',strtolower($data['title']));
    $this->db->select('id');

    $this->db->from('sell_gigs');

    $this->db->where('title',$title);

    $records = $this->db->count_all_results();

  if($records==0){



  $gigs_details['user_id'] = $data['user_id'];

  $gigs_details['gig_price'] = $data['gig_price'];

  $gigs_details['cost_type'] = $data['cost_type'];

  $gigs_details['delivering_time'] = $data['delivering_time'];

  $gigs_details['category_id'] = $data['category_id'];

  //$gigs_details['image'] = 'noimage.jpg';

  $gigs_details['gig_tags'] = $data['gig_tags'];

  $gigs_details['gig_details'] = $data['gig_details'];

  $gigs_details['super_fast_delivery'] = $data['super_fast_delivery'];

  $gigs_details['super_fast_delivery_desc'] = $data['super_fast_delivery_desc'];

  $gigs_details['super_fast_delivery_date'] = $data['super_fast_delivery_date'];

  //$gigs_details['super_fast_delivery_date'] = $data['super_fast_delivery_date'];

  $gigs_details['super_fast_charges'] = $data['super_fast_charges'];

  $gigs_details['requirements'] = $data['requirements'];

  $gigs_details['work_option'] = $data['work_option'];



    $time_zone = (empty($data['time_zone'])?'Asia/Kolkata':$data['time_zone']);

    date_default_timezone_set($time_zone);

    $current_time= date('Y-m-d H:i:s');

    $gigs_details['created_date'] = $current_time;



    $gigs_details['status'] = 1; // Waiting state

    $gigs_details['currency_type'] = $this->default_currency; // Currency Time



  // Save Gigs details

  if($this->db->insert('sell_gigs',$gigs_details)){



      $gigs_id = $this->db->insert_id();

      /* No image Start */

       $data_image = array();

       $data_image['gig_id'] = $gigs_id;

       $data_image['image_path'] = $data['image_path'];

       $data_image['gig_image_thumb'] = $data['gig_image_thumb'];

       $data_image['gig_image_tile'] = $data['gig_image_tile'];

       $data_image['gig_image_medium'] = $data['gig_image_medium'];

       $this->db->insert('gigs_image',$data_image);

       /* End */



   // save extra gigs details Start

    $extra_gigs = $data['extra_gigs'];

   if(!empty($extra_gigs)){

      if(!is_array($extra_gigs)){
        $extra_gigs = json_decode($extra_gigs);

        if(!empty($extra_gigs)){
          foreach ($extra_gigs as $value) {
               $value =(array)$value;
               $value['gigs_id'] = $gigs_id;
               $value['currency_sign'] = $this->default_currency_sign;
               $value['currency_type'] = $this->default_currency;
               $this->db->insert('extra_gigs',$value);

          }
        }
      }

   }

    return 1;
  }else{
    return 2;
  }
  // end here
   }else{
      return 3;
    }
   }

 public function update_gigs($data){



  $gig_id = $data['gig_id'];
  $gigs_details = array();
  $gigs_details['title'] = $title = str_replace(' ', '-',strtolower($data['title']));
    $this->db->select('id,title');
    $this->db->from('sell_gigs');
    $this->db->where('id',$gig_id);

    $records = $this->db->get()->row_array();

    $allow = 0 ;

    if($records['title'] == $gigs_details['title']){

      $allow = 1 ;

    }else{



      $this->db->select('id');

      $this->db->from('sell_gigs');

      $this->db->where('title',$title);

      $records = $this->db->count_all_results();

      if($records==0){ // Here check gig title already taken or not

        $allow = 1 ;

      }else{

        $allow = 0 ;

      }

    }



  if($allow == 1){



  $gigs_details['user_id'] = $data['user_id'];

  //$gigs_details['cost_type'] = $data['cost_type'];

  $gigs_details['gig_price'] = $data['gig_price'];

  $gigs_details['delivering_time'] = $data['delivering_time'];

  $gigs_details['category_id'] = $data['category_id'];

  //$gigs_details['image'] = 'noimage.jpg';

  $gigs_details['gig_tags'] = $data['gig_tags'];

  $gigs_details['gig_details'] = $data['gig_details'];

  $gigs_details['super_fast_delivery'] = $data['super_fast_delivery'];

  $gigs_details['super_fast_delivery_desc'] = $data['super_fast_delivery_desc'];

  $gigs_details['super_fast_delivery_date'] = $data['super_fast_delivery_date'];

  $gigs_details['super_fast_delivery_date'] = $data['super_fast_delivery_date'];

  $gigs_details['super_fast_charges'] = $data['super_fast_charges'];

  $gigs_details['requirements'] = $data['requirements'];

  $gigs_details['work_option'] = $data['work_option'];
  $gigs_details['currency_type'] = $this->default_currency;

  // Save Gigs details



     $this->db->where('id', $gig_id);

  if($this->db->update('sell_gigs',$gigs_details)){




       $gigs_id = $gig_id;

      /* No image Start */
      if(isset($data['image_path']) && !empty($data['image_path']))
      {

        $data_image = array();

       $data_image['gig_id'] = $gigs_id;

       $data_image['image_path'] = $data['image_path'];

       $data_image['gig_image_thumb'] = $data['gig_image_thumb'];

       $data_image['gig_image_tile'] = $data['gig_image_tile'];

       $data_image['gig_image_medium'] = $data['gig_image_medium'];

       $this->db->insert('gigs_image',$data_image);
     }
       /* End */



   // save extra gigs details Start

     $extra_gigs = $data['extra_gigs'];

	 /*if(!array_filter($extra_gigs)) echo 12;

echo sizeof($extra_gigs);exit;*/
   if(!empty($extra_gigs) && count($extra_gigs) > 0){

        $extra_gigs = json_decode($extra_gigs);

        if(!empty($extra_gigs)){



           $this->db->where('gigs_id',$gigs_id);

           $this->db->delete('extra_gigs');

          foreach ($extra_gigs as $value) {



               $value =(array)$value;

               $value['gigs_id'] = $gigs_id;
               $value['currency_sign'] = $this->default_currency_sign;
               $value['currency_type'] = $this->default_currency;

               $this->db->insert('extra_gigs',$value);

          }

        }



   }else{
	   $this->db->where('gigs_id',$gigs_id);

       $this->db->delete('extra_gigs');

   }
    return 1;

  }else{

    return 2;

  }

  // end here



   }else{

      return 3;

    }

   }

   public function edit_details($where){



    $gig_id = $where['id'] = $where['gig_id'];

    unset($where['gig_id']);



    $records = array();

    $this->db->select('user_id,replace(title,"-", " ") as title'.",SG.cost_type,SG.currency_type,CASE SG.currency_type when 'USD'  then '$' when 'EUR'  then '€' when 'GBP'  then '£' END as currency_sign,SG.id,gig_price,delivering_time,category_id,C.name as category_name,C.parent as sub_categoryid,gig_tags,gig_details,IFNULL(super_fast_delivery, '') AS super_fast_delivery,IF(LOWER(super_fast_delivery)='yes',1,0) as is_superfast,super_fast_delivery_desc,super_fast_delivery_date,super_fast_charges,requirements,work_option");

    $this->db->from('sell_gigs as SG');

    $this->db->join('categories AS C', 'C.CATID = SG.category_id', 'left');

    $this->db->where($where);

    $gig_record = $this->db->get()->row_array();



    if(!empty($gig_record)){

      $gig_record['super_fast_delivery_date'] = (!empty($gig_record['super_fast_delivery_date']))?$gig_record['super_fast_delivery_date']:0;

      $gig_record['gig_details'] = strip_tags($gig_record['gig_details']);

      $gig_record['requirements'] = strip_tags($gig_record['requirements']);

    }



    if(!empty($gig_record)){

      $records['gig_details'] = array();

      $records['extra_gigs'] = array();

      $records['gig_images'] = array();

      $records['gig_details'] =  $gig_record;

      $gig_images =  $this->db->get_where('gigs_image',array('gig_id'=>$gig_id))->result_array();

      if(!empty($gig_images)){

          $records['gig_images'] = $gig_images;

      }
      $single = "'";
      $sign = $this->default_currency_sign;
      $currency = $this->default_currency;
      $this->db->select("extra_gigs,extra_gigs_amount,$single$currency$single as currency_type,$single$sign$single as currency_sign,extra_gigs_delivery");

      $this->db->from('extra_gigs');

      $this->db->where('gigs_id',$gig_id);

      $extra_gigs = $this->db->get();

      $extra_gigs =$extra_gigs->result_array();

      $extra_gig_array = array();

      if(!empty($extra_gigs)){

           $extra_gig_array = $extra_gigs;

      }

      $records['extra_gigs'] = $extra_gig_array;

    }



    return $records;

   }



   public function favourites_gigs($user_id){



     $query_common_query = "SELECT SG.id,SG.user_id,SG.delivering_time as delivering_days,SG.category_id,SG.currency_type,CASE SG.currency_type when 'USD'  then '$' when 'EUR'  then '€' when 'GBP'  then '£' END as currency_sign, replace(SG.title,'-', ' ') as title ,SG.gig_price,SG.total_views,M.fullname,C.country,IFNULL(S.state_name, '') AS state_name, GI.gig_image_medium AS image,(SELECT count(id) FROM `feedback` WHERE `gig_id` = SG.id and to_user_id = SG.user_id) AS gig_usercount,

                (SELECT COALESCE(CAST(AVG(rating) AS DECIMAL(10,1)),0) as rating FROM `feedback` WHERE `gig_id` = SG.id and to_user_id = SG.user_id) AS gig_rating ,'0' as favourite FROM sell_gigs AS SG

                LEFT JOIN gigs_image AS GI  ON GI.gig_id = SG.id

                LEFT JOIN members AS M  ON M.USERID = SG.user_id

                LEFT JOIN country AS C  ON C.id = M.country

                LEFT JOIN states AS S  ON S.state_id = M.state WHERE SG.status = 0 AND M.status = 0 AND SG.id in (SELECT gig_id FROM favourites WHERE user_id = $user_id )";

        $records = array();

        $query = $this->db->query($query_common_query);

        if ($query->num_rows() > 0) {

           $records =  $query->result_array();

         }

    return  $records;

   }

    public function last_visited_gigs($user_id){



     $query_common_query = "SELECT SG.id,SG.user_id,SG.delivering_time as delivering_days,SG.category_id,SG.currency_type,CASE SG.currency_type when 'USD'  then '$' when 'EUR'  then '€' when 'GBP'  then '£' END as currency_sign, replace(SG.title,'-', ' ') as title ,SG.gig_price,SG.total_views,M.fullname,M.unique_code,IFNULL(C.country, '') AS country,IFNULL(S.state_name, '') AS state_name, IFNULL(IF(GI.gig_image_medium = 'noimage.jpg','',GI.gig_image_medium), '')  AS image,(SELECT count(id) FROM `feedback` WHERE `gig_id` = SG.id and to_user_id = SG.user_id) AS gig_usercount,

                (SELECT COALESCE(CAST(AVG(rating) AS DECIMAL(10,1)),0) as rating FROM `feedback` WHERE `gig_id` = SG.id and to_user_id = SG.user_id) AS gig_rating ,'0' as favourite FROM  last_visited AS LV

                LEFT JOIN sell_gigs AS SG  ON  SG.id = LV.gig_id

                LEFT JOIN gigs_image AS GI  ON GI.gig_id = SG.id

                LEFT JOIN members AS M  ON M.USERID = SG.user_id

                LEFT JOIN country AS C  ON C.id = M.country

                LEFT JOIN states AS S  ON S.state_id = M.state

                WHERE SG.status = 0 AND M.status = 0 AND LV.user_id = $user_id ORDER BY LV.created_date DESC";

        $records = array();

        $query = $this->db->query($query_common_query);

        if ($query->num_rows() > 0) {

           $records =  $query->result_array();

         }

    return  $records;

   }

   public function last_visited_update($uid,$gid){



     $record = $this->db->get_where('last_visited',array('user_id'=>$uid,'gig_id'=>$gid))->row_array();

     $date = date('Y-m-d H:i:s');

     if(empty($record)){

       return  $this->db->insert('last_visited', array('user_id'=>$uid,'gig_id'=>$gid,'created_date'=>$date));

     }else{

      $this->db->where(array('user_id'=>$uid,'gig_id'=>$gid,'created_date'=>$date));

       return $this->db->update('last_visited', array('created_date'=>$date));

     }



   }



   public function favourites_gig_ids($id){



      $this->db->select('gig_id');

      $this->db->from('favourites');

      $this->db->where('user_id', $id);

      $recrods = $this->db->get()->result_array();

      if(!empty($recrods)){

        return $recrods =    array_map('current', $recrods);

      }else{

        return array();

      }



   }



public function get_user_orders_total($user_id){



      $query = $this->db->query("SELECT py.USERID as user_id,$user_id as to_user_id,py.id as order_id, DATE_FORMAT(py.created_at,'%d %M %Y %H:%i') as created_date,py.currency_type,CASE py.currency_type when 'USD'  then '$' when 'EUR'  then '€' when 'GBP'  then '£' END as currency_sign,replace(sg.title,'-', ' ') as title, DATE_FORMAT(DATE_ADD(py.delivery_date, INTERVAL sg.delivering_time DAY) ,'%d %b %Y') as delivery,m.fullname as seller_name ,py.item_amount as amount,py.pay_status ,py.delivery_date, py.gigs_id, py.extra_gig_ref, py.time_zone, py.seller_id,  py.payment_status, py.decline_accept, py.seller_status, py.cancel_accept, py.buyer_status, py.status,py.created_at,sg.user_id,m.username,

      (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  py.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb

       FROM `payments` as py

          LEFT JOIN sell_gigs as sg ON sg.id = py.gigs_id

          LEFT JOIN members as m ON m.USERID = sg.user_id

      WHERE py.`USERID` = $user_id ORDER BY py.`created_at` DESC  ");

       return $query->num_rows();

    }

    public function get_user_orders($user_id){ 

      $query = $this->db->query("SELECT  py.id as orderid,IFNULL(py.USERID, '') as user_id,IFNULL($user_id, '') as to_user_id,py.id as order_id, DATE_FORMAT(py.created_at,'%d %M %Y %H:%i') as created_date,py.currency_type,CASE py.currency_type when 'USD'  then '$' when 'EUR'  then '€' when 'GBP'  then '£' END as currency_sign,IFNULL(replace(sg.title,'-', ' '), '') as title, IFNULL(DATE_FORMAT(DATE_ADD(py.delivery_date, INTERVAL sg.delivering_time DAY) ,'%d %b %Y'), '') as delivery,py.source,IFNULL(m.fullname, '') as seller_name ,py.item_amount as amount,py.pay_status ,py.delivery_date, py.gigs_id, py.extra_gig_ref, py.time_zone, py.seller_id,  py.payment_status, py.decline_accept, IF(py.seller_status = 7,(SELECT IF(count(rejected_request) = 0,7,IF(rejected_request>=1,7,9)) FROM `buyer_rejected_list` where rejected_request = 0 and order_id = orderid order by rejected_request  ASC limit 0,1),py.seller_status) as seller_status, py.cancel_accept, py.buyer_status, py.status,py.created_at,sg.user_id,IFNULL(m.username, '') as username,IF(m.user_thumb_image='','',m.user_thumb_image) as seller_thumb_image,

      IFNULL((SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  py.gigs_id LIMIT 0 , 1 ), '') AS gig_image_thumb
      FROM `payments` as py
      LEFT JOIN sell_gigs as sg ON sg.id = py.gigs_id
      LEFT JOIN members as m ON m.USERID = sg.user_id
      WHERE py.`USERID` = $user_id AND LOWER(py.source) = 'stripe' ORDER BY py.`created_at` DESC");
      
        $records = array();

       if($query->num_rows() > 0){

         $records  = $query->result_array();

       }

       if(!empty($records)){

          $records_new = array();

          foreach ($records as $key => $value) {



            $status         = $value['seller_status'];

            $payment_status = $value['payment_status'];

            $buyer_status   = $value['buyer_status'];

            $cancel_accept  = $value['cancel_accept'];

            $decline_accept  = $value['decline_accept'];

            $pay_status     = $value['pay_status'];

            $f_uid          = $value['user_id'];

            $order_id       = $value['order_id'];

            $t_uid          = $user_id;

            $gid            = $value['gigs_id'];



            $status_msg     = '';

            $status_msg_val = '';

            if(($payment_status==2 && ($status==5 || ($status==1 && $buyer_status==1))))

              {

                  $status_msg ='Refunded';

                  $status_msg_val = 5;

              }

               if($status ==0) {



                  $status_msg='Failed';

                  $status_msg_val = 0;



                }elseif($status ==1) {



                  $status_msg='New';

                  $status_msg_val = 1;



                  if($buyer_status ==1)

                    {

                     if($cancel_accept ==1)

                      {

                          $status_msg='Cancelled';

                          $status_msg_val = 2;

                      }

                     }

                }elseif($status ==2){



                  $status_msg = 'Pending';

                  $status_msg_val = 3;



                  if($buyer_status ==1)

                    {

                       if($cancel_accept ==1)

                       {

                          $status_msg = 'Cancelled';

                          $status_msg_val = 2;

                        }

                     }

                  }elseif($status ==3)

                  {

                        $status_msg='Process';

                        $status_msg_val = 4;



                    if($buyer_status ==1)

                    {

                     if($cancel_accept ==1)

                      {

                          $status_msg = 'Cancelled';

                           $status_msg_val = 2;

                       }

                    }

                 }elseif($status ==4){

                        $status_msg ='Refunded';

                         $status_msg_val = 5;



                 }elseif($status ==5){
                        if($decline_accept ==0)

                        {

                          $status_msg = 'Decline Request';

                          $status_msg_val = 9;

                        }

                        else{

                          $status_msg ='Declined';

                          $status_msg_val = 6;

                        }



                 }elseif($status ==6){

                        $status_msg = 'Completed';

                        $status_msg_val = 7;



                 }elseif($status ==7){

                        $status_msg = 'Completed Accept';

                        $status_msg_val = 8;

                 }elseif($status ==9){

                        $status_msg = 'Reject request send';

                        $status_msg_val = 9;

                 }
                 $status_msg_val = (string) $status_msg_val;

                 $value['order_status'] = $status_msg;

                 $value['status_msg_val'] = $status_msg_val;



                 $feedback = '';

                 $feedback_msg = '';

                 if($status ==6) {



                        $this->db->select('id');

                        $this->db->from('feedback');

                        $this->db->where(array('from_user_id'=>$t_uid,'to_user_id'=>$f_uid,'gig_id'=>$gid,'order_id'=>$order_id));

                        $feedback_records = $this->db->count_all_results();

                        $fead_stautus=1;

                        if($feedback_records >0){

                          $feedback = 'See Feedback';

                          $feedback_val = 2;

                        }else{

                          $feedback = 'Leave Feedback';

                          $feedback_val = 1;

                        }

                 }else{

                   $feedback = 'Pending';

                    $feedback_val = 0;

                 }



           $value['feedback'] = $feedback;

           $value['feedback_val'] = $feedback_val;



           $order_cancel = '';

           $order_cancel_val = '';



           if($buyer_status ==0 && $status !=6 && $status !=9 && $status_msg != 'Completed Accept'){

             if($status !=0 ){

                if($status !=5 ){

                      $order_cancel = 'Cancel';

                      $order_cancel_val = 1;



                  }else{

                    $order_cancel = '-';

                    $order_cancel_val = 0;

                  }}else{

                    $order_cancel = '-';

                    $order_cancel_val = 0;

                }

              } else if($buyer_status ==1) {

                   if($cancel_accept ==1){

                     $order_cancel = '-';

                     $order_cancel_val = 0;

                   } else{

                    $order_cancel = 'Request send';

                    $order_cancel_val = 2;

                  }

                 } else {

                  $order_cancel = '-';

                  $order_cancel_val = 0;

                  }

             $value['order_cancel'] =$order_cancel;

             $value['order_cancel_val'] =$order_cancel_val;

           $records_new[] = $value;

          }

         $records = $records_new;

       }

      return   $records;

  }



  public function get_selluser_details_total($user_id){
 


    $query = $this->db->query("SELECT py.USERID as user_id,sg.user_id as from_user_id,py.id as order_id, DATE_FORMAT(py.created_at,'%d %M %Y %H:%i') as created_date,py.currency_type,CASE py.currency_type when 'USD'  then '$' when 'EUR'  then '€' when 'GBP'  then '£' END as currency_sign,replace(sg.title,'-', ' ') as title, DATE_FORMAT(DATE_ADD(py.delivery_date, INTERVAL sg.delivering_time DAY) ,'%d %b %Y') as delivery,m.fullname as buyer_name ,py.item_amount as amount,py.pay_status ,py.delivery_date, py.gigs_id, py.extra_gig_ref, py.time_zone, py.seller_id,  py.payment_status, py.decline_accept, py.seller_status, py.cancel_accept, py.buyer_status, py.status,py.created_at,m.username,(SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  py.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb  FROM `payments` as py

          LEFT JOIN sell_gigs as sg ON sg.id = py.gigs_id

            LEFT JOIN members as m ON m.USERID = py.USERID

      WHERE py.`seller_id` = $user_id ORDER BY py.`created_at` DESC ");

    return $query->num_rows();

   }



  public function get_selluser_details($user_id){



    $query = $this->db->query("SELECT py.USERID as user_id,sg.user_id as from_user_id,py.id as order_id, DATE_FORMAT(py.created_at,'%d %M %Y %H:%i') as created_date,py.currency_type,CASE py.currency_type when 'USD'  then '$' when 'EUR'  then '€' when 'GBP'  then '£' END as currency_sign,replace(sg.title,'-', ' ') as title, DATE_FORMAT(DATE_ADD(py.delivery_date, INTERVAL sg.delivering_time DAY) ,'%d %b %Y') as delivery,py.source,m.fullname as buyer_name ,py.item_amount as amount,py.pay_status ,py.delivery_date, py.gigs_id, py.extra_gig_ref, py.time_zone, py.seller_id,  py.payment_status, py.decline_accept, py.seller_status, py.cancel_accept, py.cancel_reason, py.buyer_status, py.status,py.created_at,m.username,IFNULL((SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  py.gigs_id LIMIT 0 , 1 ), '') AS gig_image_thumb,IF(m.user_thumb_image='','',m.user_thumb_image) as buyer_thumb_image  FROM `payments` as py

          LEFT JOIN sell_gigs as sg ON sg.id = py.gigs_id

            LEFT JOIN members as m ON m.USERID = py.USERID

      WHERE py.`seller_id` = $user_id AND LOWER(py.source) = 'stripe' ORDER BY py.`created_at` DESC ");



      $records = array();

       if($query->num_rows() > 0){

         $records  = $query->result_array();

          if(!empty($records)){

          $records_new = array();

          foreach ($records as $key => $value) {



            $status         = $value['seller_status'];

            $payment_status = $value['payment_status'];

            $buyer_status   = $value['buyer_status'];

            $cancel_accept  = $value['cancel_accept'];

            $pay_status     = $value['pay_status'];

            $f_uid          = $value['user_id'];

            $order_id       = $value['order_id'];

            $t_uid          = $user_id;

            $gid            = $value['gigs_id'];

           $decline_accept = $value['decline_accept'];

            $status_msg     = '';

            $status_msg_val = '';



              if($status ==0) {

                        $status_msg = 'Failed';

                        $status_msg_val = 0;

                      }elseif($status ==1) {

                        $status_msg = 'New';

                        $status_msg_val = 1;

                        if($buyer_status ==1) {

                         if($cancel_accept ==1){

                          $status_msg='Cancelled';

                          $status_msg_val = 2;

                          if($pay_status =='Payment Processed'){

                            $status_msg='Refunded';

                            $status_msg_val = 5;

                          }

                         }

                        }

                      }elseif($status ==2){

                        $status_msg='Pending';

                        $status_msg_val = 3;

                        if($buyer_status ==1) {

                          if($itemcancel_accept ==1){

                            $status_msg='Cancelled';

                            $status_msg_val = 2;

                          if($pay_status == 'Payment Processed'){

                            $status_msg = 'Refunded';

                            $status_msg_val = 5;

                          }

                        }

                        }

                      }elseif($status ==3){

                        $status_msg = 'Process';

                        $status_msg_val = 4;

                        if($buyer_status ==1) {

                         if($cancel_accept ==1){

                          $status_msg = 'Cancelled';

                          $status_msg_val = 2;

                          if($pay_status == 'Payment Processed'){

                            $status_msg = 'Refunded';

                            $status_msg_val = 5;

                          }

                         }

                        }

                      }elseif($status ==4){

                        $status_msg = 'Refunded';

                        $status_msg_val = 5;

                      }elseif($status ==5){

                        if($decline_accept ==0)

                        {

                          $status_msg = 'Decline Request';

                          $status_msg_val = 9;

                        }

                        else{

                          $status_msg ='Declined';

                          $status_msg_val = 6;

                        }



                      }elseif($status ==6){

                        $status_msg = 'Completed';

                        $status_msg_val = 7;

                      }elseif($status ==7){

                        $status_msg = 'Completed Request';

                        $status_msg_val = 8;

                      }
                      $status_msg_val = (string) $status_msg_val;

                       $value['order_status'] = $status_msg;

                       $value['status_msg_val'] = $status_msg_val;



                 $feedback = '';

                 $feedback_msg = '';

                 if($status ==6) {



                        $this->db->select('id');

                        $this->db->from('feedback');

                        $this->db->where(array('from_user_id'=>$f_uid,'to_user_id'=>$t_uid,'gig_id'=>$gid,'order_id'=>$order_id));

                        $feedback_records = $this->db->count_all_results();

                        $fead_stautus=1;

                        if($feedback_records >0){

                          $feedback = 'See Feedback';

                          $feedback_val = 2;

                        }else{

                          $feedback = 'Pending';

                          $fead_stautus= 2;

                           $feedback_val = 0;

                        }

                 }else{

                   $fead_stautus=2;

                   $feedback = 'Pending';

                    $feedback_val = 0;

                 }



           $value['feedback'] = $feedback;

           $value['feedback_val'] = $feedback_val;

           $order_cancel = '';

           $order_cancel_val = '';

            if($buyer_status ==0 && $status ==6 ) {

                $order_cancel = '-';

            } else if($buyer_status ==1) {



                if($cancel_accept ==0){

                      $order_cancel = 'Cancel Request';

                      $order_cancel_val = 1;

                   }else{

                    $order_cancel = 'View Reason';

                    $order_cancel_val = 2;

                     }

                } else {

                        $order_cancel = '-';

                        $order_cancel_val = 0 ;

                }

             $value['order_cancel'] =$order_cancel;

             $value['order_cancel_val'] =$order_cancel_val;

             $records_new[] = $value;

          }

            $records = $records_new;

        }





       }

      return $records;



  }



  public function getuser_wallets_details_total($user_id)

  {

    $query = $this->db->query("SELECT py.USERID as user_id,py.id as order_id, DATE_FORMAT(py.created_at,'%d %M %Y %H:%i') as created_date,py.currency_type,CASE py.currency_type when 'USD'  then '$' when 'EUR'  then '€' when 'GBP'  then '£' END as currency_sign,replace(sg.title,'-', ' ') as title,py.gigs_id, py.extra_gig_ref, py.time_zone, py.seller_id, py.delivery_date, py.payment_status, py.decline_accept, py.seller_status,py.item_amount as amount, py.cancel_accept,py.created_at, py.buyer_status, py.status,sg.user_id,m.fullname as buyer_name,m.username,(SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  py.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb FROM `payments` as py LEFT JOIN sell_gigs as sg ON sg.id = py.gigs_id

            LEFT JOIN members as m ON m.USERID = py.USERID WHERE py.seller_id = $user_id AND seller_status = 6 ORDER BY py.`created_at` DESC ");

      return  $query->num_rows();

  }



  public function getuser_wallets_details($user_id)

  {

    $query = $this->db->query("SELECT py.USERID as user_id,py.id as order_id, DATE_FORMAT(py.created_at,'%d %M %Y %H:%i') as created_date,py.currency_type,CASE py.currency_type when 'USD'  then '$' when 'EUR'  then '€' when 'GBP'  then '£' END as currency_sign,replace(sg.title,'-', ' ') as title,py.gigs_id, py.extra_gig_ref, py.time_zone, py.seller_id, py.delivery_date, py.payment_status, py.decline_accept,py.source, py.seller_status,py.item_amount as amount, py.cancel_accept,py.created_at, py.buyer_status, py.status,sg.user_id,m.fullname as buyer_name,m.username,IFNULL((SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  py.gigs_id LIMIT 0 , 1 ), '') AS gig_image_thumb FROM `payments` as py LEFT JOIN sell_gigs as sg ON sg.id = py.gigs_id

            LEFT JOIN members as m ON m.USERID = py.USERID WHERE py.seller_id = $user_id AND seller_status = 6 AND LOWER(py.source) = 'stripe' ORDER BY py.`created_at` DESC ");

       $records = array();

       if($query->num_rows() > 0){

         $records  = $query->result_array();

         if(!empty($records)){

          $records_new = array();

            foreach ($records as  $value) {

              $status = $value['payment_status'];

              if($status ==1) {

                $value['withdraw_message'] = 'Request Sent';

                $value['withdraw_val'] = 1;

              }elseif($status ==2){

                $value['withdraw_message'] = 'Payment Received';

                $value['withdraw_val'] = 2;

              }else{

                $value['withdraw_message'] = 'Withdraw Amount';

                $value['withdraw_val'] = 0;

              }

                $records_new[] = $value;

            }

            $records = $records_new;

         }

       }

      return $records;

  }



    public function wallet_balance($user_id)

  {



    /*$query = $this->db->query("SELECT sum(py.item_amount) as amount FROM payments as py

                               LEFT JOIN sell_gigs as sg ON sg.id = py.gigs_id

                               LEFT JOIN members as m ON m.USERID = py.USERID

                               WHERE py.seller_id = $user_id AND seller_status = 6 AND py.payment_status =0"); //  AND py.payment_status =1 */

    $query = $this->db->query("SELECT sum(py.item_amount) as amount  FROM `payments` as py  WHERE py.seller_id = $user_id  AND seller_status=6  AND py.payment_status != 2 ");

        $records = 0;

       if($query->num_rows() > 0){

         $records  = $query->row_array();

         $records = (int)$records['amount'];



       }

      return $records;

  }



  public function seller_reviews($user_id, $device_type='', $page=1){

    $records = array();
    $query_string = "SELECT from_user_id,to_user_id,gig_id,comment,F.rating,F.time_zone,F.created_date,currency_type,CASE currency_type when 'USD'  then '$' when 'EUR'  then '€' when 'GBP'  then '£' END as currency_sign,replace(SG.title,'-',' ') as title, IF(M.fullname IS NOT NULL,M.fullname,'') as buyer_name, IFNULL(M.user_thumb_image, '') AS profile_img  FROM  feedback F LEFT JOIN sell_gigs As SG  ON SG.id = F.gig_id  LEFT JOIN members M ON M.USERID = F.from_user_id where to_user_id = $user_id";

    $query = $this->db->query($query_string);
      if($query->num_rows() > 0){
          $records  = $query->result_array();
       }
    if(isset($device_type) && !empty($device_type) && ($device_type == 'ios' || $device_type == 'android'))
    {
      if($page == 1){
        $query_string .= " LIMIT 0 ,10";
      }else{
        $start = ($page-1) * 10;
        $query_string .= " LIMIT $start,10";
      }
         $total_records = count($records);
         $records = array();
         $query = $this->db->query($query_string);
           if($query->num_rows() > 0){
               $records  = $query->result_array();
            }
         return array('total_pages'=>ceil($total_records/10),'review_details'=>$records);
    }
    else
    {
       return $records;
      }

  }



  public function change_gigs_status($datas) {



    $p_id    = $datas['order_id'];

    $reason  = $datas['cancel_reason'];

    $pemail  = $datas['paypal_email'];

    $user_id = $datas['user_id'];

    $from_timezone = $datas['time_zone'];



    $bank_query = $this->db->query("SELECT * FROM `bank_account` WHERE `user_id` = $user_id ");

    $rows = $bank_query->num_rows();

    if($rows>0){

      $data['paypal_email_id']     = $pemail;

            $this->db->where('user_id',$user_id);

            $this->db->update('bank_account',$data);

    }else{

      $data['paypal_email_id']     = $pemail;

      $data['user_id']     = $user_id ;

            $this->db->insert('bank_account',$data);

    }



    $data_up['buyer_status'] = 1;

    $data_up['cancel_reason'] = $reason;

    $data_up['cancel_notification_status'] =1;

    date_default_timezone_set($from_timezone);

    $current_time= date('Y-m-d H:i:s');

    $data_up['canceled_at'] =$current_time;

    if($this->db->update('payments',$data_up,array('id'=>$p_id)))

    {



      //seller mail function

      $query = $this->db->query("SELECT paypal_uid,item_amount,( SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id = payments.gigs_id LIMIT 0 , 1  ) as gig_image,payments.extra_gig_ref,payments.extra_gig_dollar,sg.gig_price  FROM `payments`    LEFT JOIN sell_gigs as sg ON sg.id = payments.gigs_id  WHERE payments.id = $p_id");

      $data_one = $query->row_array();

      $email_details  = $this->gigs_model->gig_purchase_requirements($p_id);

      $seller_message = '';

      $welcomemessage = '';

      $toemail= $email_details['email'];

      $gig_price = $this->gigs_model->gig_price();

      //$gig_price = '$'.$gig_price['value'];

      $gig_price = $this->default_currency_sign.' '.$data_one['gig_price'];



      $extra_gig_price = $this->gigs_model->extra_gig_price();

          $extra_gig_price = $extra_gig_price['value'];

      $extra_gig_ref = json_decode($email_details['extra_gig_ref']);

      $user_profile_link =  base_url().'user-profile/'.$email_details['buyer_username'];

      $order_id=$data_one['paypal_uid'];

      $title =$email_details['title'];

      $gig_preview_link  = base_url().'gig-preview/'.$title ;

      $img_path =base_url().$data_one['gig_image'];

      $gig_preview_link  = base_url().'gig-preview/'.$title ;

      $h_all='';

      if(!empty($extra_gig_ref))

      {

        $query_extra = $this->db->query("SELECT * FROM `user_required_extra_gigs` WHERE id IN ($extra_gig_ref)");

        $result_extra = $query_extra->result_array();



        foreach ($result_extra as $data_extra)

        {

          $dataoptions = json_decode($data_extra['options']);

          $gig_values = explode('___',$data_extra['options']);

          if($gig_values[1]!=0 || $gig_values[1]!= "undefined" )

          {

            $h_all.='<tr><td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">&nbsp;</td>

              <td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">

                '.str_replace('"','',$gig_values[0]).'

              </td>

              <td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">'.$gig_values[1].'</td>

              <td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">$'.$extra_gig_price.'</td>

              </tr>';

          }

        }

      }

      if($email_details['payment_super_fast_delivery']==0)

      {

        $sup_dec='Super fast delivery';

        if(!empty($email_details['super_fast_delivery_desc']))

        {

          $sup_dec=$email_details['super_fast_delivery_desc'];

        }

        $h_all.='<tr><td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">&nbsp;</td>

              <td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">

                '.$sup_dec.'

              </td>

              <td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">1</td>

              <td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">$'.$extra_gig_price.'</td>

              </tr>';

      }

      $h_all.='<tr>

            <td colspan="3" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">Total</td>

            <td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">$'.$data_one['item_amount'].'</td>

          </tr>';

      $request_link =base_url().'sales';

      $bodyid = 24;

      $tempbody_details= $this->templates_model->get_usertemplate_data($bodyid);

      $body = $tempbody_details['template_content'];

      $body = str_replace('{base_url}', $this->base_domain, $body);

      $body = str_replace('{base_image}',$this->base_domain.'/'.$this->logo_front, $body);

      $body = str_replace('{gig_owner}', $email_details['seller_name'], $body);

      $body = str_replace('{buyer_name}',$email_details['buyer_name'], $body);

      $body = str_replace('{title}',str_replace("-"," ",$title), $body);

      $body = str_replace('{gig_link}',$gig_preview_link, $body);

      $body = str_replace('{PAYPAL_ID}',$order_id, $body);

      $body = str_replace('{ITEM_NAME}',str_replace("-"," ",$title), $body);

      $body = str_replace('{PRICE}',$gig_price , $body);

      $body = str_replace('{site_name}',$this->site_name, $body);

      $body = str_replace('{BUYER_LINK}', $user_profile_link, $body);

      $body = str_replace('{TEABLE_ROW}', $h_all, $body);

      $body = str_replace('{IMG_SRC}',$img_path , $body);

      $body = str_replace('{accept_link}',$request_link, $body);



      $seller_message ='<table style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">

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

      $this->load->helper('file');

      $this->load->library('email');

      $this->email->set_newline("\r\n");

      $this->email->from($this->email_address,$this->email_tittle);

      $this->email->to($toemail);

      $this->email->subject('Order Cancelled From '.$email_details['buyer_name']);

      $this->email->message($seller_message);

      $this->email->send();

      return 1;

    }else{

      return 2;

    }

  }




  public function seefeedback($data){



    $f_id     = $data['from_user_id'];

    $t_id     = $data['to_user_id'];

    $g_id     = $data['gig_id'];

    $order_id = $data['order_id'];

    $s_id     = $data['user_id'];

    $temp = 0;


    $user_data = $this->user_panel_model->get_user_data($f_id);



    $s_query = $this->db->query("SELECT user_thumb_image FROM members WHERE USERID = $s_id;");

    $s_result = $s_query->row_array();



    $s1_prof_img    = base_url().'assets/images/avatar2.jpg';

    if($s_result['user_thumb_image'] != '') $s1_prof_img = base_url().$s_result['user_thumb_image'];

    $s_prof_img =$s1_prof_img;

    $query_res = $this->db->query("SELECT AVG(feedback.rating) AS rating FROM `feedback` left join sell_gigs on sell_gigs.id = feedback.gig_id WHERE sell_gigs.user_id = $f_id AND feedback.`to_user_id` = $f_id;");

        $result_count = $query_res->row_array();

    $rat=0;

    if($result_count['rating']!='')

    {

      $rat = round($result_count['rating']);

    }



    $prof_img    = base_url().'assets/images/avatar2.jpg';

    if($user_data['user_thumb_image'] != '') $prof_img = base_url().$user_data['user_thumb_image'];

    $name=$user_data['fullname'];

    $country=$user_data['country'];

    $sortname ='IN';

    if($user_data['sortname']!='')

    {

      $sortname=$user_data['sortname'];

    }



    $gig_user_info = array();

    $gig_user_info['profile_name'] = $name;

    $gig_user_info['profile_image'] = $prof_img;

    $gig_user_info['profile_url'] = base_url().'user-profile/'.$user_data["username"];

    $gig_user_info['rating'] = $rat;

    $gig_user_info['country'] = $country;



    $feedback_array = array();



    if($f_id)

    {

      $query = $this->db->query("SELECT a.*,cu.fullname,cu.user_thumb_image,cu.username FROM `feedback` as a

      left join members cu on cu.USERID = a.from_user_id

      WHERE a.`from_user_id` = $t_id and a.`to_user_id` = $f_id and a.`gig_id` = $g_id and a.`order_id` = $order_id;");

          $result = $query->row_array();



      $query_two = $this->db->query("SELECT a.*,cu.fullname,cu.user_thumb_image,cu.username FROM `feedback` as a

      left join members cu on cu.USERID = a.from_user_id

      WHERE a.`from_user_id` = $f_id and a.`to_user_id` = $t_id and a.`gig_id` = $g_id and a.`order_id` = $order_id;");

          $result_array = $query_two->row_array();
      // echo $this->db->last_query();exit;
      if(!empty($result) || !empty($result_array))

      {
        $kk =0;
         if($result){

        $date       = new DateTime();

        $match_date = new DateTime($result['created_date']);

        $interval   = $date->diff($match_date);

        if($interval->days == 0) $tme = date('d M Y h:i A',strtotime($result['created_date']));

        else  $tme = $interval->days.' Days ago ';

        $temp =1;

        $user_img='assets/images/avatar2.jpg';

        if($result['user_thumb_image']!=''){ $user_img =base_url().$result['user_thumb_image'];}

        $name= $result['fullname'];

        $comment= $result['comment'];

        $rating= $result['rating'];





        $feedback_array[$kk]['fb_user_name'] = $result["username"];

        $feedback_array[$kk]['fb_user_url'] = base_url().'user-profile/'.$result["username"];

        $feedback_array[$kk]['fb_user_img'] = $user_img;

        $feedback_array[$kk]['fb_user_time'] = $tme;

        $feedback_array[$kk]['fb_user_comment'] = $comment;

        $feedback_array[$kk]['fb_user_rating'] = $rating;
        $feedback_array[$kk]['fb_from_role'] = 'Seller';
        ++$kk;
      }

        if($result_array){

            $date       = new DateTime();

          $match_date1 = new DateTime($result_array['created_date']);

          $interval1   = $date->diff($match_date1);

          if($interval1->days == 0) $tme1 = date('d M Y h:i A',strtotime($result_array['created_date']));

          else  $tme1 = $interval1->days.' Days ago ';

          $user_img1='assets/images/avatar2.jpg';

          if($result_array['user_thumb_image']!=''){ $user_img1 =base_url().$result_array['user_thumb_image'];}

          $name1= $result_array['fullname'];

          $comment1= $result_array['comment'];

          $rating1= $result_array['rating'];





          $feedback_array[$kk]['fb_user_name'] = $result_array["username"];

          $feedback_array[$kk]['fb_user_url'] = base_url().'user-profile/'.$result_array["username"];

          $feedback_array[$kk]['fb_user_img'] = $user_img1;

          $feedback_array[$kk]['fb_user_time'] = $tme1;

          $feedback_array[$kk]['fb_user_comment'] = $comment1;

          $feedback_array[$kk]['fb_user_rating'] = $rating1;
          $feedback_array[$kk]['fb_from_role'] = 'Buyer';



      }else{

        $temp =2;

      }

      }

      
    return array('user_content'=>$gig_user_info,'status'=>$temp,'user_feed'=>$feedback_array,'f_id'=>$f_id,'t_id'=>$t_id,'g_id'=>$g_id,'order_id'=>$order_id,'s_image'=>$s_prof_img);

  }

  }



  public function save_purchase_feedback($data)

  {

    $f_id=$data['from_user_id'];

    $t_id = $data['to_user_id'];

    $t_id  = $this->get_user_id_using_token($t_id);

    $g_id=$data['gig_id'];

    $orderid=$data['order_id'];

    $comment=$data['comment'];

    $rating_input=$data['rating'];

    $from_timezone=$data['time_zone'];



    if($rating_input =='' || $rating_input==0)

    {

      $rating_input=1;

    }

      $data = array();



      $data['from_user_id'] = $t_id;

      $data['to_user_id'] = $f_id ;

      $data['gig_id'] = $g_id;

      $data['order_id'] = $orderid;

      $data['rating']= $rating_input;

      $data['comment'] =$comment;

      $data['time_zone'] =$from_timezone;



        date_default_timezone_set($from_timezone);

        $current_time= date('Y-m-d H:i:s');

      $data['created_date'] =$current_time;

      $data[' status'] =1;

      if($this->db->insert('feedback',$data))

      {

        $query = $this->db->query("SELECT sg.title,py.currency_type,CASE py.currency_type when 'USD'  then '$' when 'EUR'  then '€' when 'GBP'  then '£' END as currency_sign,m.fullname as buyername,m.username as buyerusername,py.USERID as gbid,py.seller_id as gsid, sm.fullname as sellername,sm.username as sellerusername,  sm.email as selleremail FROM `payments` as py

          LEFT JOIN sell_gigs as sg ON sg.id = py.gigs_id

          LEFT JOIN members as m ON m.USERID = py.USERID

          LEFT JOIN members as sm ON sm.USERID = py.seller_id

          WHERE py.`id` = $orderid");

        $data_one = $query->row_array();

        $title = $data_one['title'];

        $gsid= $data_one['gsid'];

        $gbid= $data_one['gbid'];

        $to_email= $data_one['selleremail'];

        $bodyid = 16;

        $tempbody_details= $this->templates_model->get_usertemplate_data($bodyid);

        $body=$tempbody_details['template_content'];

        $message='';

        $gig_preview_link  = base_url().'sales/';

        $user_profile_link  = base_url().'user-profile/'.$data_one['buyerusername'];



        $body = str_replace('{base_url}', $this->base_domain, $body);

        $body = str_replace('{base_image}',$this->base_domain.'/'.$this->logo_front, $body);

        $body = str_replace('{user_link}', $user_profile_link, $body);

        $body = str_replace('{gig_preview_link}', $gig_preview_link, $body);

        $body = str_replace('{buyer_name}', $data_one['buyername'], $body);

        $body = str_replace('{seller_name}', $data_one['sellername'], $body);

        $body = str_replace('{site_name}',$this->site_name, $body);

        $body = str_replace('{title}',str_replace("-"," ",$title), $body);

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

        $this->load->helper('file');

        $this->load->library('email');

        $this->email->set_newline("\r\n");

        $this->email->from($this->email_address,$this->email_tittle);

        $this->email->to($to_email);
        $feedback = 'Feedback from '.$data_one['buyername'];
        $this->email->subject($feedback);

        $this->email->message($message);

        $this->email->send();
        
        $feedback_title = ucfirst($data_one['buyername']);
        
        $feedback_title .= ' - '. ucfirst(str_replace("-"," ",$title));

        

        $this->order_status_notification($f_id,$feedback_title,$comment);

        return 1;



      }else{



        return 2;

      }

  }



  public function sale_change_gigs_status($data)

  {



    $p_id = $data['order_id'];

    $sts  = $data['order_status'];

    $val  = $data['val'];

    $from_timezone = $data['time_zone'];



    $data['time_zone'] =$from_timezone;

    date_default_timezone_set($from_timezone);

    $current_time= date('Y-m-d H:i:s');

    if($sts == 6 && $val==1){



      $sts = 7; // Completed Request

    }

    $data_up['seller_status'] = $sts;

    $data_up['notification_status'] = 1;

    $data_up['update_date'] = $current_time;

    if($sts==5){

    $data_up['update_date'] = $current_time;

    $data_up['notification_status'] = 1;

    $data_up['cancel_notification_status'] = 1;

    }

    if($this->db->update('payments',$data_up,array('id'=>$p_id)))

    {

      $query = $this->db->query("SELECT sg.title,py.currency_type,CASE py.currency_type when 'USD'  then '$' when 'EUR'  then '€' when 'GBP'  then '£' END as currency_sign,m.fullname as buyername,m.username as buyerusername, m.email as buyeremail,sm.email as selleremail, sm.fullname as sellername,sm.username as sellerusername,py.seller_id as gsid,py.USERID as gbid FROM `payments` as py

          LEFT JOIN sell_gigs as sg ON sg.id = py.gigs_id

          LEFT JOIN members as m ON m.USERID = py.USERID

          LEFT JOIN members as sm ON sm.USERID = py.seller_id

          WHERE py.`id` = $p_id");

      $data_one = $query->row_array();

      $title= ucfirst($data_one['title']);
      $gbid  = $data_one['gbid'];         
      $gsid  = $data_one['gsid'];         
      if($sts ==6)

      {
         
        $to_email= $data_one['buyeremail'];

        $bodyid = 18;

        $tempbody_details= $this->templates_model->get_usertemplate_data($bodyid);

        $body=$tempbody_details['template_content'];

        $message='';

        $gig_preview_link  = base_url().'gig-preview/'.$title ;

        $gig_purchase  = base_url().'purchases/';

        $body = str_replace('{base_url}', $this->base_domain, $body);

        $body = str_replace('{base_image}',$this->base_domain.'/'.$this->logo_front, $body);

        $body = str_replace('{gig_purchase}', $gig_purchase, $body);

        $body = str_replace('{gig_preview_link}', $gig_preview_link, $body);

                $body = str_replace('{site_name}',$this->site_name, $body);

        $body = str_replace('{buyer_name}', $data_one['buyername'], $body);

        $body = str_replace('{gig_owner}', $data_one['sellername'], $body);

        $body = str_replace('{title}',str_replace("-"," ",$title), $body);



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

        $this->load->helper('file');

        $this->load->library('email');

        $this->email->set_newline("\r\n");

        $this->email->from($this->email_address,$this->email_tittle);

        $this->email->to($to_email);

        $this->email->subject('Your Order Completed');

        $this->email->message($message);

        $this->email->send();

        $this->order_status_notification($gbid,$title,'Your Order Completed');

        //order complete request accept_buyer_request

        $title= ucfirst($data_one['title']);

        $to_email= $data_one['selleremail'];

        $bodyid = 30;

        $tempbody_details= $this->templates_model->get_usertemplate_data($bodyid);

        $body=$tempbody_details['template_content'];

        $message='';

        $gig_preview_link  = base_url().'sales';

        $body = str_replace('{base_url}', $this->base_domain, $body);

        $body = str_replace('{base_image}',$this->base_domain.'/'.$this->logo_front, $body);

        $body = str_replace('{gig_preview_link}', $gig_preview_link, $body);

                $body = str_replace('{site_name}',$this->site_name, $body);

        $body = str_replace('{buyer_name}', $data_one['buyername'], $body);

        $body = str_replace('{gig_owner}', $data_one['sellername'], $body);

        $body = str_replace('{title}',str_replace("-"," ",$title), $body);



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

        $this->load->helper('file');

        $this->load->library('email');

        $this->email->set_newline("\r\n");

        $this->email->from($this->email_address,$this->email_tittle);

        $this->email->to($to_email);

        $this->email->subject('Order Complete Request');

        $this->email->message($message);

        $this->email->send();

        $this->order_status_notification($gbid,$title,'Order Complete Request');


      }

      elseif($sts ==8)

      {

        $query = $this->db->query("SELECT sg.title,py.currency_type,CASE py.currency_type when 'USD'  then '$' when 'EUR'  then '€' when 'GBP'  then '£' END as currency_sign,m.fullname as buyername,m.username as buyerusername, m.email as buyeremail,sm.email as selleremail,sm.fullname as sellername,sm.username as sellerusername ,py.USERID ,py.seller_id as gsid as gbid FROM `payments` as py

            LEFT JOIN sell_gigs as sg ON sg.id = py.gigs_id

            LEFT JOIN members as m ON m.USERID = py.USERID

            LEFT JOIN members as sm ON sm.USERID = py.seller_id

            WHERE py.`id` = $p_id");



        $data_one = $query->row_array();

        $title= ucfirst($data_one['title']);

        $gbid  = $data_one['gbid'];         
        $gsid  = $data_one['gsid'];         
      

        $to_email= $data_one['selleremail'];

        $bodyid = 30;

        $tempbody_details= $this->templates_model->get_usertemplate_data($bodyid);

        $body=$tempbody_details['template_content'];

        $message='';

        $gig_preview_link  = base_url().'purchases';

        $body = str_replace('{base_url}', $this->base_domain, $body);

        $body = str_replace('{base_image}',$this->base_domain.'/'.$this->logo_front, $body);

        $body = str_replace('{gig_preview_link}', $gig_preview_link, $body);

                $body = str_replace('{site_name}',$this->site_name, $body);

        $body = str_replace('{buyer_name}', $data_one['buyername'], $body);

        $body = str_replace('{gig_owner}', $data_one['sellername'], $body);

        $body = str_replace('{title}',str_replace("-"," ",$title), $body);



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

        $this->load->helper('file');

        $this->load->library('email');

        $this->email->set_newline("\r\n");

        $this->email->from($this->email_address,$this->email_tittle);

        $this->email->to($to_email);

        $this->email->subject('Order Complete Request');

        $this->email->message($message);

        $this->email->send();
        $this->order_status_notification($gbid,$title,'Order Complete Request');


      }

      elseif($sts ==7)

      {

        $query = $this->db->query("SELECT sg.title,py.currency_type,CASE py.currency_type when 'USD'  then '$' when 'EUR'  then '€' when 'GBP'  then '£' END as currency_sign,m.fullname as buyername,m.username as buyerusername, m.email as buyeremail, sm.fullname as sellername,sm.username as sellerusername,py.seller_id as gsid,py.USERID as gbid FROM `payments` as py

            LEFT JOIN sell_gigs as sg ON sg.id = py.gigs_id

            LEFT JOIN members as m ON m.USERID = py.USERID

            LEFT JOIN members as sm ON sm.USERID = py.seller_id

            WHERE py.`id` = $p_id");

        $data_one = $query->row_array();

        $title= ucfirst($data_one['title']);
        $gbid= $data_one['gbid'];
        $gsid= $data_one['gsid'];

        $to_email= $data_one['buyeremail'];

        $bodyid = 29;

        $tempbody_details= $this->templates_model->get_usertemplate_data($bodyid);

        $body=$tempbody_details['template_content'];

        $message='';

        $gig_preview_link  = base_url().'purchases';

        $body = str_replace('{base_url}', $this->base_domain, $body);

        $body = str_replace('{base_image}',$this->base_domain.'/'.$this->logo_front, $body);

        $body = str_replace('{gig_preview_link}', $gig_preview_link, $body);

                $body = str_replace('{site_name}',$this->site_name, $body);

        $body = str_replace('{buyer_name}', $data_one['buyername'], $body);

        $body = str_replace('{gig_owner}', $data_one['sellername'], $body);

        $body = str_replace('{title}',str_replace("-"," ",$title), $body);



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

        $this->load->helper('file');

        $this->load->library('email');

        $this->email->set_newline("\r\n");

        $this->email->from($this->email_address,$this->email_tittle);

        $this->email->to($to_email);

        $this->email->subject('Order Complete Request');

        $this->email->message($message);

        $this->email->send();

        $this->order_status_notification($gbid,$title,'Order Complete Request');

      }

      else if($sts ==5)

      {

        $to_email= $data_one['buyeremail'];

        $bodyid = 25;

        $tempbody_details= $this->templates_model->get_usertemplate_data($bodyid);

        $body=$tempbody_details['template_content'];

        $message='';

        $gig_preview_link  = base_url().'gig-preview/'.$title ;

        $purchase_link  = base_url().'purchases/' ;

        $body = str_replace('{base_url}', $this->base_domain, $body);

        $body = str_replace('{base_image}',$this->base_domain.'/'.$this->logo_front, $body);

          $body = str_replace('{site_name}',$this->site_name, $body);

        $body = str_replace('{gig_preview_link}', $gig_preview_link, $body);

        $body = str_replace('{purchase_link}', $purchase_link, $body);

        $body = str_replace('{buyer_name}', $data_one['buyername'], $body);

        $body = str_replace('{gig_owner}', $data_one['sellername'], $body);

        $body = str_replace('{title}',str_replace("-"," ",$title), $body);

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

        $this->load->helper('file');

        $this->load->library('email');

        $this->email->set_newline("\r\n");

        $this->email->from($this->email_address,$this->email_tittle);

        $this->email->to($to_email);

        $this->email->subject('Your Order Declined from '.$data_one['sellername']);

        $this->email->message($message);

        $this->email->send();

      $this->order_status_notification($gbid,$title,'Your Order Declined from '.$data_one['sellername']);

      }



      return 1;

    }

    else

    {

      return  2;

    }

  }



  public function withdram_details($id)

  {



    $pay_data = $this->payment_model->get_salespayment_details($id);

     $created_on = '-';

    if (isset($pay_data['created_at'])) {

      if (!empty($pay_data['created_at']) && $pay_data['created_at'] != "0000-00-00 00:00:00") {

        $created_on = date('M j, Y g:i A', strtotime($pay_data['created_at']));

      }

    }

      $image_url='assets/images/gig-small.jpg';

      if($pay_data['image_path']!='')

      {

        $image_url=base_url().$pay_data['image_path'];

      }

      $title=$pay_data['title'];

      //$amt=$pay_data['item_amount'];

      $country_name = $this->session->userdata('country_name');


      $amt = $pay_data['item_amount'];


      $rate_symbol = $this->default_currency_sign;

      $gig_link= base_url().'gig-preview/'.$pay_data['title'];



      $array = array();

      $array['image_url'] = $image_url;

      $array['gig_title'] = $pay_data['title'];

      $array['gig_link'] = $gig_link;

      $array['rate_symbol'] = $rate_symbol;

      $array['amount'] = $amt;

      return  array('giginfo'=>$array,'status'=>1,'amount'=>$amt,'id'=>$id);

  }

  public function account_checking($user_id){



     $bank_query = $this->db->query("SELECT * FROM `bank_account` WHERE `user_id` = $user_id ");

     $records = $bank_query->num_rows();

     return $records;

  }



  public function payment_request($p_id){



    $data_up['payment_status'] = 1;

    if($this->db->update('payments',$data_up,array('id'=>$p_id)))

    {

      $message ='';

      $query = $this->db->query("SELECT py.item_amount,py.paypal_uid,py.currency_type,CASE py.currency_type when 'USD'  then '$' when 'EUR'  then '€' when 'GBP'  then '£' END as currency_sign,sg.title,sg.currency_type,sg.user_id,gi.gig_image_thumb,m.fullname as buyername,m.username as buyerusername, sm.fullname as sellername,sm.username as sellerusername,sg.gig_price,py.extra_gig_ref,py.extra_gig_dollar,py.payment_super_fast_delivery,sg.super_fast_delivery_desc FROM `payments` as py

        LEFT JOIN sell_gigs as sg ON sg.id = py.gigs_id

        LEFT JOIN gigs_image as gi ON gi.gig_id = py.gigs_id

        LEFT JOIN members as m ON m.USERID = py.USERID

        LEFT JOIN members as sm ON sm.USERID = py.seller_id

        WHERE py.`id` = $p_id");



        $data_one = $query->row_array();



        $gig_price = $this->default_currency_sign.' '.$data_one['gig_price']; // Dynamic price

        $extra_gig_price = $data_one['extra_gig_dollar'];



        $extra_gig_ref = json_decode($data_one['extra_gig_ref']);

        $h_all='';

      if(!empty($extra_gig_ref))

      {

        $query_extra = $this->db->query("SELECT * FROM `user_required_extra_gigs` WHERE id IN ($extra_gig_ref)");

        $result_extra = $query_extra->result_array();

        foreach ($result_extra as $data_extra)

        {

          $dataoptions = json_decode($data_extra['options']);

          $gig_values = explode('___',$data_extra['options']);

          if($gig_values[1]!=0 || $gig_values[1]!= "undefined" )

          {

            $h_all.='<tr><td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">&nbsp;</td>

              <td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">

                '.str_replace('"','',$gig_values[0]).'

              </td>

              <td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">'.$gig_values[1].'</td>

              <td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">$'.$gig_values[2].'</td>

              </tr>';

          }

        }

      }



      if($data_one['payment_super_fast_delivery']==0)

      {

        $sup_dec='Super fast delivery';

        if(!empty($data_one['super_fast_delivery_desc']))

        {

          $sup_dec=$data_one['super_fast_delivery_desc'];

        }

        $h_all.='<tr><td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">&nbsp;</td>

        <td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">

          '.$sup_dec.'

        </td>

        <td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">1</td>

        <td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">$'.$extra_gig_price.'</td>

        </tr>';

      }



       $h_all.='<tr>

            <td colspan="3" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">Total</td>

            <td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">$'.$data_one['item_amount'].'</td>

          </tr>';







        $bodyid = 20;

        $tempbody_details= $this->templates_model->get_usertemplate_data($bodyid);

        $body=$tempbody_details['template_content'];

        $title = $data_one['title'];

        $img_path =base_url().$data_one['gig_image_thumb'];

        $gig_preview_link  = base_url().'gig-preview/'.$title ;

        //$user_profile_link = base_url().'user_profile/'.$username;

        $body = str_replace('{PAYPAL_ID}', $data_one['paypal_uid'], $body);

        $body = str_replace('{buyer_name}', $data_one['buyername'], $body);

        $body = str_replace('{seller_name}', $data_one['sellername'], $body);

        $body = str_replace('{ITEM_NAME}',str_replace("-"," ",$title), $body);

          $body = str_replace('{site_name}',$this->site_name, $body);

        //$body = str_replace('{PRICE}', $data_one['item_amount'], $body);

         $body = str_replace('{PRICE}', $gig_price, $body);



        $body = str_replace('{TEABLE_ROW}', $h_all, $body);

        $body = str_replace('{IMG_SRC}',$img_path , $body);

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

        $this->load->helper('file');

        $this->load->library('email');

        $this->email->set_newline("\r\n");

        $this->email->from($this->email_address,$this->email_tittle);

        $this->email->to($this->email_address);

        $this->email->subject('Payment Request from '.$data_one['sellername']);

        $this->email->message($message);

        $url_parts = parse_url(current_url());



       if($url_parts['host'] !='localhost'){

          $this->email->send();

       }

     return 1;



    }else{

      return 2;

    }

  }



public function save_feedback($where_data)

  {

    $f_id=$where_data['from_user_id'];

    $t_id =$where_data['to_user_id'];

    $t_id  = $this->get_user_id_using_token($t_id);

    $g_id=$where_data['gig_id'];

    $orderid=$where_data['order_id'];

    $comment=$where_data['comment'];

    $rating_input=$where_data['rating'];

    $from_timezone = $where_data['time_zone'];



    if($rating_input =='' || $rating_input==0)

    {

      $rating_input=1;

    }



      $data['from_user_id'] = $t_id;

      $data['to_user_id'] = $f_id ;

      $data['gig_id'] = $g_id;

      $data['order_id'] = $orderid;

      $data['rating']= $rating_input;

      $data['comment'] =$comment;

      $data['time_zone'] =$from_timezone;

      date_default_timezone_set($from_timezone);

        $current_time= date('Y-m-d H:i:s');

      $data['created_date'] =$current_time;

      $data[' status'] =1;

      if($this->db->insert('feedback',$data))

      {

        $query = $this->db->query("SELECT sg.title,py.currency_type,CASE py.currency_type when 'USD'  then '$' when 'EUR'  then '€' when 'GBP'  then '£' END as currency_sign,m.fullname as buyername,m.username as buyerusername, sm.fullname as sellername,sm.username as sellerusername,  sm.email as selleremail FROM `payments` as py

          LEFT JOIN sell_gigs as sg ON sg.id = py.gigs_id

          LEFT JOIN members as m ON m.USERID = py.USERID

          LEFT JOIN members as sm ON sm.USERID = py.seller_id

          WHERE py.`id` = $orderid");

        $data_one = $query->row_array();

        $title= $data_one['title'];

        $to_email= $data_one['selleremail'];

        $bodyid = 16;

        $tempbody_details= $this->templates_model->get_usertemplate_data($bodyid);

        $body=$tempbody_details['template_content'];

        $message='';

        //$gig_preview_link  = base_url().'gig-preview/'.$title ;

        $gig_preview_link  = base_url().'sales/';

        $user_profile_link  = base_url().'user-profile/'.$data_one['buyerusername'];



        $body = str_replace('{base_url}', $this->base_domain, $body);

        $body = str_replace('{base_image}',$this->base_domain.'/'.$this->logo_front, $body);

        $body = str_replace('{user_link}', $user_profile_link, $body);

        $body = str_replace('{gig_preview_link}', $gig_preview_link, $body);

        $body = str_replace('{buyer_name}', $data_one['buyername'], $body);

        $body = str_replace('{seller_name}', $data_one['sellername'], $body);

          $body = str_replace('{site_name}',$this->site_name, $body);

        $body = str_replace('{title}',str_replace("-"," ",$title), $body);

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

        $this->load->helper('file');

        $this->load->library('email');

        $this->email->set_newline("\r\n");

        $this->email->from($this->email_address,$this->email_tittle);

        $this->email->to($to_email);

        $this->email->subject('Feedback from '.$data_one['buyername']);

        $this->email->message($message);

        $this->email->send();
      
        $feedback_title = ucfirst($data_one['buyername']);
        
        $feedback_title .= ' - '. ucfirst(str_replace("-"," ",$title));

        $this->order_status_notification($t_id,$feedback_title,$comment);
        return 1;

      }

      else

      {

        return 2;

      }

  }



  public function multiple_withdraw($data){



    return 2;

  }



  public function accept_buyer_request($wheredata) {



    $p_id          = $wheredata['order_id'];

    $from_timezone = $wheredata['time_zone'];



    $data_up['cancel_accept'] = 1;

    $data_up['notification_status'] = 1;

    date_default_timezone_set($from_timezone);

    $current_time= date('Y-m-d H:i:s');

    $data_up['update_date'] = $current_time;



    if($this->db->update('payments',$data_up,array('id'=>$p_id)))

    {

      $query = $this->db->query("SELECT sg.title,py.currency_type,CASE py.currency_type when 'USD'  then '$' when 'EUR'  then '€' when 'GBP'  then '£' END as currency_sign,m.fullname as buyername,m.username as buyerusername, m.email as buyeremail, sm.fullname as sellername,sm.username as sellerusername FROM `payments` as py

          LEFT JOIN sell_gigs as sg ON sg.id = py.gigs_id

          LEFT JOIN members as m ON m.USERID = py.USERID

          LEFT JOIN members as sm ON sm.USERID = py.seller_id

          WHERE py.`id` = $p_id");

      $data_one = $query->row_array();

      $title= $data_one['title'];

      $to_email= $data_one['buyeremail'];

        $bodyid = 27;

        $tempbody_details= $this->templates_model->get_usertemplate_data($bodyid);

        $body=$tempbody_details['template_content'];

        $message='';

        $gig_preview_link  = base_url().'gig-preview/'.$title ;

        $purchase_link  = base_url().'purchases/' ;

        $body = str_replace('{base_url}', $this->base_domain, $body);

        $body = str_replace('{base_image}',$this->base_domain.'/'.$this->logo_front, $body);

        $body = str_replace('{gig_preview_link}', $gig_preview_link, $body);

        $body = str_replace('{purchase_link}', $purchase_link, $body);

                $body = str_replace('{site_name}',$this->site_name, $body);

        $body = str_replace('{buyer_name}', $data_one['buyername'], $body);

        $body = str_replace('{gig_owner}', $data_one['sellername'], $body);

        $body = str_replace('{title}',str_replace("-"," ",$title), $body);

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

        $this->load->helper('file');

        $this->load->library('email');

        $this->email->set_newline("\r\n");

        $this->email->from($this->email_address,$this->email_tittle);

        $this->email->to($to_email);

        $this->email->subject('Your Cancel Request Accepted from '.$data_one['sellername']);

        $this->email->message($message);

        $this->email->send();



      return 1;

    }else{



     return 2;

    }

  }

  public function overall_payment_request($user_id)

  {

    $p_id= $user_id;

    $data_up['payment_status'] = 1;

    $s_sts=6;



      $query = $this->db->query("SELECT py.item_amount,py.paypal_uid,py.currency_type,CASE py.currency_type when 'USD'  then '$' when 'EUR'  then '€' when 'GBP'  then '£' END as currency_sign,sg.title,sg.currency_type,sg.user_id,m.fullname as buyername,m.username as buyerusername, sm.fullname as sellername,sm.username as sellerusername,

      (SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id =  py.gigs_id LIMIT 0 , 1 ) AS gig_image_thumb

       FROM `payments` as py

        LEFT JOIN sell_gigs as sg ON sg.id = py.gigs_id

        LEFT JOIN members as m ON m.USERID = py.USERID

        LEFT JOIN members as sm ON sm.USERID = py.seller_id

        WHERE py.`seller_id` = $p_id AND py.`seller_status` =6 AND py.`payment_status` =0" );

    $data_one = $query->result_array();

    if($this->db->update('payments',$data_up,array('seller_id'=>$user_id,'seller_status'=>$s_sts,'payment_status'=>0)))

    {

      $message ='';



      $h_all='';

      foreach ($data_one as $data_res)

      {

        $h_all.='<tr><td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">'.$data_res['paypal_uid'].'</td>

                                  <td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">

                                    <a style="color:#bbadfc;" href="javascript:;" >'.str_replace("-"," ",$data_res['title']).'</a>

                                  </td>

                                  <td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">'.$data_res['buyername'].'</td>

                                                                    <td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">$'.$data_res['item_amount'].'</td></tr>';

      }





        $bodyid = 21;

        $tempbody_details= $this->templates_model->get_usertemplate_data($bodyid);

        $body=$tempbody_details['template_content'];
        $img_path = '';
        if(!empty($data_one[0])){

          $img_path =base_url().$data_one[0]['gig_image_thumb'];
          $body = str_replace('{seller_name}', $data_one[0]['sellername'], $body);
        }else{
          $body = str_replace('{seller_name}', 'Seller', $body);
        }


        $body = str_replace('{site_name}',$this->site_name, $body);

        $body = str_replace('{TEABLE_ROW}', $h_all, $body);

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

        $this->load->helper('file');

        $this->load->library('email');

        $this->email->set_newline("\r\n");

        $this->email->from($this->email_address,$this->email_tittle);

        $this->email->to($this->email_address);
        if(!empty($data_one[0])){
          $this->email->subject('Payment Request from '.$data_one[0]['sellername']);
        }else{
          $this->email->subject('Payment Request from Seller');
        }


        $this->email->message($message);

        $this->email->send();

     return 1;

    }else{

      return 2;

    }

  }



  public function chart_user_details($id, $page) {



    $querychat   = $this->db->query("SELECT id,chat_from,chat_to,content,chat_from_time,IF(chat_utc_time!='0000-00-00 00:00:00', chat_utc_time,'') as chat_utc_time,timezone FROM chats WHERE (chat_to = '".$id."' and to_delete_sts=0) OR (chat_from = '".$id."' and from_delete_sts=0) order by id desc ");

    $chat_counta = $querychat->result_array();
    $to_user = array();
    $data =array();
    if (!empty($chat_counta)) {
       $data=array();
       foreach ($chat_counta as $key => $usr_lst) {
           $push=array();
            if($usr_lst['chat_from']==$id){
               if(!in_array($usr_lst['chat_to'],$to_user)){
                  $to_user[] = $usr_lst['chat_to'];
                  $queryuser = $this->db->query("SELECT USERID,fullname,user_thumb_image,user_timezone,status FROM members WHERE USERID=".$usr_lst['chat_to']."");
                  $chat_data = $queryuser->row_array();
                  if(!empty($chat_data)){
                      $thambimg = (trim($chat_data['user_thumb_image'])!='')?$chat_data['user_thumb_image']:'uploads/profile_images/noimage_t.jpg';



                    $push['user_id']       =  $chat_data['USERID'];

                    $push['firstname']     =  $chat_data['fullname'];

                    $push['profile_image'] =   $thambimg;

                    $push['user_status']     =  $chat_data['status'];

                    $push['chat_id']       =  $usr_lst['id'];

                    $push['timezone']      =  $chat_data['user_timezone'];

                    $push['last_message']  =  $usr_lst['content'];

                    // $push['chat_time']     =  $usr_lst['chat_from_time'];

                    // $push['chat_timezone'] =  $usr_lst['timezone'];

                    $push['utc_time']      =  $usr_lst['chat_utc_time'];



                  }

            }

          }elseif($usr_lst['chat_to']==$id){



             if(!in_array($usr_lst['chat_from'],$to_user)){



                  $to_user[]=$usr_lst['chat_from'];

                  $queryuser   = $this->db->query("SELECT USERID,fullname,user_thumb_image,user_timezone,status FROM members WHERE USERID=".$usr_lst['chat_from']."");

                  $chat_data = $queryuser->row_array();

                   if(!empty($chat_data)){

                      $thambimg = (trim($chat_data['user_thumb_image'])!='')?$chat_data['user_thumb_image']:'uploads/profile_images/noimage_t.jpg';



                    $push['user_id']       =  $chat_data['USERID'];

                    $push['firstname']     =  $chat_data['fullname'];

                    $push['profile_image'] =   $thambimg;

                    $push['user_status']     =  $chat_data['status'];

                    $push['chat_id']       =  $usr_lst['id'];

                    $push['timezone']      =  $chat_data['user_timezone'];

                    $push['last_message']  =  $usr_lst['content'];

                    // $push['chat_time']     =  $usr_lst['chat_from_time'];

                    // $push['chat_timezone'] =  $usr_lst['timezone'];

                    $push['utc_time']      =  $usr_lst['chat_utc_time'];



                }

            }

          }

          if(!empty($push)) {

                $data[] = $push;

           }

       }

     }

     $total_records = count($data);
     if($page == 1) {
         $start = 0;
     }else {
         $start = ($page-1) * 10;
     }

     $data = array_slice( $data, $start, 10 );

       return array('total_pages'=>ceil($total_records/10),'chat_details'=>$data);



    }



    public function get_chat_details($f_user,$t_user,$page){




      $query_string = "SELECT content,chat_from,M.unique_code,chat_to,if(chat_utc_time!='0000-00-00 00:00:00', chat_utc_time,'') as chat_time,M.fullname as from_user_name,M1.fullname as to_user_name, IF (chat_from = '".$f_user."', M.user_thumb_image,M.user_thumb_image) AS profile_image  from chats LEFT JOIN members AS M ON M.USERID = chat_from LEFT JOIN members AS M1 ON M1.USERID = chat_to where (( chat_from =  ".$f_user." and chat_to = ".$t_user.") OR  (chat_from =  ".$t_user." and chat_to = ".$f_user.")) order by id DESC ";



      $query = $this->db->query($query_string);

      $total_records =  $query->num_rows();

      $page = ($page!=0)?$page:1;

      if($page == 1){

        $query_string .= "LIMIT 0 ,10";

      }else{

        $start = ($page-1) * 10;

        $query_string .= "LIMIT  $start,10";

      }
     
      $data = array( );

      if($total_records>0){

           $query1 = $this->db->query($query_string);

           $data = $query1->result_array();

      }

      $data  = array_reverse($data);

      return array('total_pages'=>ceil($total_records/10),'chat_details'=>$data);



    }





    public function save_buyerchat($where){

        $chat_id      = $where['sell_gigs_userid'];
        $content      = $where['chat_message_content'];
        $chat_type    = 1;
        $qrystr         = $this->db->query("SELECT user_timezone FROM `members` WHERE USERID = ".$chat_id);
        $chat_user_tz     = $qrystr->row();
        $to_timezone    = $chat_user_tz->user_timezone;
        $from_timezone = $this->session->userdata('time_zone');

        date_default_timezone_set("UTC");
        $utc_time  = date('Y-m-d H:i:s');
        date_default_timezone_set($to_timezone);
        $to_tz= date('Y-m-d H:i:s'); //Returns IST
        $from_timezone = (!empty($from_timezone))?$from_timezone:'asia/Kolkata';
        date_default_timezone_set($from_timezone);


       $from_tz= date('Y-m-d H:i:s'); //Returns IST
       $current_time= date('Y-m-d H:i:s');
       $data['chat_utc_time']     = $utc_time;

      $data['chat_from']    = $where['user_id'];

      $data['chat_to']      = $chat_id;

      $data['content']      = $content;

      $data['file_path']    = '';

      $data['chat_type']    = $chat_type;

      $data['date_time']    = $current_time;

      $data['chat_from_time']    = $from_tz;

      $data['chat_to_time']    = $to_tz;



      if($this->db->insert('chats',$data)){

       $insert_id =  $users_tbl_id  =  $this->db->insert_id();

        $query = $this->db->query("SELECT m.fullname as buyername,m.username as buyerusername, sm.fullname as sellername,sm.username as sellerusername,  sm.email as selleremail

            FROM `chats` as py

          LEFT JOIN members as m ON m.USERID = py.chat_from

          LEFT JOIN members as sm ON sm.USERID = py.chat_to

          WHERE py.`id` = $users_tbl_id");

        $data_one = $query->row_array();

        $to_email= $data_one['selleremail'];

        $bodyid = 23;

        $tempbody_details= $this->templates_model->get_usertemplate_data($bodyid);

        $body=$tempbody_details['template_content'];

        $message='';

        $user_profile_link  = base_url().'user-profile/'.$data_one['buyerusername'];

        $message_link = base_url().'message';

        //$body = str_replace('{PAYPAL_ID}', $order_id, $body);

        $body = str_replace('{base_url}', $this->base_domain, $body);

        $body = str_replace('{user_profile_link}', $user_profile_link, $body);

        $body = str_replace('{from_username}', $data_one['buyername'], $body);

        $body = str_replace('{to_username}', $data_one['sellername'], $body);

        $body = str_replace('{message_link}', $message_link, $body);

        $body = str_replace('{site_name}',$this->site_name, $body);

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

        $this->load->helper('file');

        $this->load->library('email');

        $this->email->set_newline("\r\n");

        $this->email->from($this->email_address,$this->email_tittle);

        $this->email->to($to_email);

        $this->email->subject('Received message from '.$data_one['buyername']);

        $this->email->message($message);

        $this->email->send();

      $f_user = $data['chat_from'];
      $t_user = $data['chat_to']; 

    $query = $this->db->query("select IF(chat_utc_time!='0000-00-00 00:00:00',chat_utc_time,'' ) as chat_utc_time,M.fullname as from_name,M.user_thumb_image as from_user_image,M1.fullname as to_name,M1.user_thumb_image as to_user_image from chats AS C LEFT JOIN members AS M ON M.USERID = C.chat_from LEFT JOIN members AS M1 ON M1.USERID = C.chat_to where  chat_from = $f_user and chat_to = $t_user and id = $insert_id");

    $last_record = array();

    if($query->num_rows() > 0){
      $last_record = $query->row_array();
      $last_record['from_user_id'] = $f_user;
      $last_record['to_user_id'] =$t_user;
    }
  

    $API_details  = $this->gigs->settings();

    $include_player = $this->player_ids($t_user);


    $include_player_ids = '';
    if(!empty($include_player)){

      $include_player_ids = $include_player['device_id'];


    if($include_player['device']!='browser'){

    if(!empty($API_details['one_signal_app_id']) && !empty($API_details['one_signal_reset_key'])){

      $data = array();

      $data['user_id'] = $t_user;

      $data['message'] = $content;

      $data['app_id'] = $API_details['one_signal_app_id'];

      $data['reset_key'] = $API_details['one_signal_reset_key'];

      $data['include_player_ids'] = $include_player_ids;

      $data['additional_data'] = $last_record;

      $result = send_message($data);
     
     
      $result = (array)json_decode($result);



     }

    }
    }



        return 1;

      }else{

       return 2;

      }

  }





  public function last_chater($id){


    $qry = $this->db->query("SELECT id,chat_from,chat_to FROM `chats` WHERE (chat_from= ".$id." and from_delete_sts=0) OR (chat_to= ".$id." and to_delete_sts =0) ORDER BY id DESC limit 1 ");
      $last_user  = $qry->row_array();
      $last_userid=0;
      if(count($last_user)>0)
      {
        if($last_user['chat_from']==$id){
          $last_userid =$last_user['chat_to'];
        }
        if($last_user['chat_to']==$id){
          $last_userid =$last_user['chat_from'];
        }
      }
      return $last_userid;
  }

  public function settings(){



        $this->db->select('key, value');

        $this->db->from('system_settings');

        $records = $this->db->get()->result_array();

        $array = array();

         foreach ($records as $value) {

            if($value['key']=='one_signal_subdomain'){

                $array['one_signal_subdomain'] = $value['value'];

            }

            if($value['key']=='one_signal_app_id'){

                $array['one_signal_app_id']  = $value['value'];

            }

            if($value['key']=='one_signal_reset_key'){

              $array['one_signal_reset_key'] = $value['value'];

            }

          }

        return $array;

    }

   public function chat_update($datas){



        $f_user = $datas['from_user_id'];

        $t_user = $datas['to_user_id'];



        date_default_timezone_set("UTC");

        $utc_time  = date('Y-m-d H:i:s');



       $query_string = "SELECT USERID as userid, user_timezone FROM members WHERE  USERID IN (".$f_user.",".$t_user.")";

       $query = $this->db->query($query_string);

       $user_details = $query->result_array();



        $from_tz = '';

        $current_time = '';

        $to_tz = '';

        foreach ($user_details as $value) {



          $user_timezone = $value['user_timezone'];

          if($value['userid'] = $t_user){

            date_default_timezone_set($user_timezone);

            $to_tz  = date('Y-m-d H:i:s');

          }



          if($value['userid'] = $f_user){

            date_default_timezone_set($user_timezone);

            $from_tz  = date('Y-m-d H:i:s');

          }



        }

    $current_time  = date('Y-m-d H:i:s');

    $data['chat_from']    = $f_user;

    $data['chat_to']      = $t_user;

    $data['content']      = $datas['message'];

    $data['timezone']     = $user_timezone;

    $data['file_path']     = '';

    $data['chat_utc_time'] = $utc_time;

    $data['chat_type']     = 1;

    $data['date_time']     = $current_time;

    $data['chat_from_time']= $from_tz;

    $data['chat_to_time']  = $to_tz;



    $this->db->insert('chats',$data);

    $insert_id = $this->db->insert_id();



    $query = $this->db->query("select IF(chat_utc_time!='0000-00-00 00:00:00',chat_utc_time,'' ) as chat_utc_time,M.fullname as from_name,M.user_thumb_image as from_user_image,M1.fullname as to_name,M1.user_thumb_image as to_user_image from chats AS C LEFT JOIN members AS M ON M.USERID = C.chat_from LEFT JOIN members AS M1 ON M1.USERID = C.chat_to where  chat_from = $f_user and chat_to = $t_user and id = $insert_id");



    $last_record = array();

    if($query->num_rows() > 0){

      $last_record = $query->row_array();

      $last_record['from_user_id'] = $f_user;

      $last_record['to_user_id'] =$t_user;



    }



    $API_details  = $this->gigs->settings();

    $include_player = $this->player_ids($t_user);


    $include_player_ids = '';
    if(!empty($include_player)){

      $include_player_ids = $include_player['device_id'];


    if($include_player['device']!='browser'){

    if(!empty($API_details['one_signal_app_id']) && !empty($API_details['one_signal_reset_key'])){

      $data = array();

      $data['user_id'] = $t_user;

      $data['message'] = $datas['message'];

      $data['app_id'] = $API_details['one_signal_app_id'];

      $data['reset_key'] = $API_details['one_signal_reset_key'];

      $data['include_player_ids'] = $include_player_ids;

      $data['additional_data'] = $last_record;

      $result = send_message($data);
     
     
      $result = (array)json_decode($result);



     }

    }
    }




    $query_string = "SELECT content,if(chat_utc_time!='0000-00-00 00:00:00', chat_utc_time,'') as chat_time,M.fullname as from_user_name,M.unique_code as chat_from,M1.unique_code as chat_to,M1.fullname as to_user_name, IF (chat_from = '".$f_user."', M.user_thumb_image,M.user_thumb_image) AS profile_image  from chats LEFT JOIN members AS M ON M.USERID = chat_from LEFT JOIN members AS M1 ON M1.USERID = chat_to where (( chat_from =  ".$f_user." and chat_to = ".$t_user.") OR  (chat_from =  ".$t_user." and chat_to = ".$f_user.")) and id >= $insert_id order by id DESC ";

    $query = $this->db->query($query_string);

     return   $query->result_array();



   }

   public function player_ids($userid){

      if(!empty($userid)){

        $query = $this->db->query("SELECT device_id,device FROM one_signal_device_ids WHERE user_id = $userid") ;

        if($query->num_rows() >0){

          $records = $query->row_array();

          return $records;

        }else{

          return '';

        }

      }







   }

   public function save_device_id($data){



    $user_id   = $data['user_id'];
    $device_id = $data['device_id'];

    $this->db->select('id');
    $this->db->from('one_signal_device_ids');
    $this->db->where('user_id',$user_id);
    $this->db->or_where('device_id',$device_id);
    $records = $this->db->count_all_results();

    if($records == 0){
      $result = $this->db->insert('one_signal_device_ids', $data);
      if($result){
        return 1;
      }

    }else{

      $this->db->where('user_id',$user_id);
      $this->db->or_where('device_id',$device_id);
      $this->db->delete('one_signal_device_ids');

      $result = $this->db->insert('one_signal_device_ids', $data);
       

      if($result){

        return 1;

      }

    }

    return 0;

   }



   public function get_user_time_zone($id){

    $record = $this->db->query("SELECT user_timezone FROM members WHERE USERID=$id")->row_array();

    return $record['user_timezone'];

   }



   public function get_gig_details($id){

    return $this->db->query("SELECT * FROM sell_gigs WHERE id = $id")->row_array();

   }



   public function buy_now_gig($input,$extra_amt){



      $from_timezone = $this->get_user_time_zone($input['buyer_id']);

      date_default_timezone_set($from_timezone);

      $current_time= date('Y-m-d H:i:s');
      $gig_id               = $input['gig_id'];
      $data['source']      = $input['source']; //  paypal, stripe and amplify
      $gig_details          = $this->get_gig_details($gig_id);
      $data['gigs_id']      = $gig_id;
      $data['seller_id']    = $input['seller_id'];

      $data['USERID']       = $input['buyer_id'];



      $data['time_zone']    = $from_timezone;

      $item_amount          = $gig_details['gig_price'];
      $item_amount          += $extra_amt;

      $extra_gig_required_days =  $input['total_delivery_days'];

      $extra_gig_ref           = json_encode($input['extra_gig_row_id']);

      $currency_type           = $this->default_currency;

      $currency_symbol         = $this->default_currency_sign;





      $data['extra_gig_ref']   = '';

      $data['currency_type']   =  $currency_type;



       if(!empty($extra_gig_ref))

       {

         $data['extra_gig_ref'] = $extra_gig_ref;

       }

       $super_fast_delivery = $input['super_fast_delivery'];

       $data['payment_super_fast_delivery'] = 1 ;

       $data['delivery_date']          =  Date('Y-m-d H:i:s', strtotime("+".$extra_gig_required_days." days"));
       $super_fast_charges = 0 ;
       if(!empty($super_fast_delivery))

          {

            $data['payment_super_fast_delivery'] = 0 ;

            $query = $this->db->query("SELECT super_fast_delivery_date,super_fast_charges FROM `sell_gigs` WHERE `id` = ".$data['gigs_id']." ");

            $days  = $query->row_array();
            $super_fast_charges = $days['super_fast_charges'];

            $total_days = $extra_gig_required_days + $days['super_fast_delivery_date'];

            $data['delivery_date']         =  Date('Y-m-d H:i:s', strtotime("+".$total_days." days"));

          }

       $item_amount   += $super_fast_charges;

       $data['item_amount']     =  $item_amount;
       $data['dollar_amount']   = $item_amount ;
       $amount                  =   $data['dollar_amount'];
       $data['created_at']      = $current_time;
       $data['status']          = 1;



        $this->db->select('key, value');

        $this->db->from('system_settings');

        $this->db->where('key', 'admin_commision');

        $settings = $this->db->get()->row_array();

        $data['commision']    =  $settings['value'];



        $data['pay_status'] = '0';

        $data['extra_gig_dollar'] = '0';

        $data['extra_gig_indian_rupee'] = '0';

        $data['gig_price_dollar_rate'] = $item_amount;

        $data['paypal_uid'] = '0';

        $data['paypal_status'] = '0';

        $data['cancel_reason'] = '';

        $data['canceled_at'] = '0000-00-00 00:00:00';

        $data['update_date'] = '0000-00-00';

        $data['payment_returnmethod'] = '0';

        $data['dispatch_date'] = '0000-00-00';

       if($this->db->insert('payments',$data)){



            $users_tbl_id  =  $this->db->insert_id();

            $type =1;

            $amount_1  =intval(($amount*100))/100;

            $g_name= str_replace("-"," ",$gig_details['title']);



        return array('gig_order_id'=>$users_tbl_id,'gig_amount'=>$amount_1,'type'=>$type,'gig_name'=>$g_name);

        }else{

          return array();

        }





   }



   public function paypal_success($input){



      $message='';

      $table_data['paypal_uid']    = $input['paypal_uid'];

      $table_data['seller_status'] = 1;

    //  $table_data['stripe_refund'] = $input['stripe_response'];

      $uid  = $input['item_number'];



    $this->db->where('id',$uid);

    $this->db->update('payments', $table_data);



    $query = $this->db->query("SELECT py.item_amount,py.currency_type,py.paypal_uid,CASE py.currency_type when 'USD'  then '$' when 'EUR'  then '€' when 'GBP'  then '£' END as currency_sign,sg.title,py.USERID as buyer_id,sg.currency_type,sg.user_id,gi.gig_image_thumb,m.fullname as buyername,m.username as buyerusername, sm.fullname as sellername,sm.username as sellerusername,sg.gig_price,py.extra_gig_ref,py.extra_gig_dollar FROM `payments` as py

          LEFT JOIN sell_gigs as sg ON sg.id = py.gigs_id

      LEFT JOIN gigs_image as gi ON gi.gig_id = py.gigs_id

            LEFT JOIN members as m ON m.USERID = py.USERID

      LEFT JOIN members as sm ON sm.USERID = py.seller_id

      WHERE py.`id` = $uid");



    $data_one = $query->row_array();



    $title = $data_one['title'];

    $gig_preview_link  = base_url().'gig-preview/'.$title ;

    $img_path =base_url().$data_one['gig_image_thumb'];



    //seller mail function

      $email_details  = $this->gigs_model->gig_purchase_requirements($uid);

      $seller_message = '';

      $welcomemessage = '';

      $toemail= $email_details['email'];

      $gig_price = $this->default_currency_sign.' '.$data_one['gig_price']; // Dynamic price

      $extra_gig_price = $data_one['extra_gig_dollar'];



      $extra_gig_ref = json_decode($email_details['extra_gig_ref']);

      $user_profile_link =  base_url().'user-profile/'.$email_details['buyer_username'];



      $h_all='';

      if(!empty($extra_gig_ref))

      {

        $query_extra = $this->db->query("SELECT * FROM `user_required_extra_gigs` WHERE id IN ($extra_gig_ref)");

        $result_extra = $query_extra->result_array();

        foreach ($result_extra as $data_extra)

        {

          $dataoptions = json_decode($data_extra['options']);

          $gig_values = explode('___',$data_extra['options']);

          if($gig_values[1]!=0 || $gig_values[1]!= "undefined" )

          {

            $h_all.='<tr><td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">&nbsp;</td>

              <td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">

                '.str_replace('"','',$gig_values[0]).'

              </td>

              <td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">'.$gig_values[1].'</td>

              <td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">'.$this->default_currency_sign.' '.$gig_values[2].'</td>

              </tr>';

          }

        }

      }

      if($email_details['payment_super_fast_delivery']==0)

      {

        $sup_dec='Super fast delivery';

        if(!empty($email_details['super_fast_delivery_desc']))

        {

          $sup_dec=$email_details['super_fast_delivery_desc'];

        }

        $h_all.='<tr><td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">&nbsp;</td>

        <td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">

          '.$sup_dec.'

        </td>

        <td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">1</td>

        <td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">'.$this->default_currency_sign.''.$extra_gig_price.'</td>

        </tr>';

      }

       $h_all.='<tr>

            <td colspan="3" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">Total</td>

            <td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">'.$this->default_currency_sign.''.$data_one['item_amount'].'</td>

          </tr>';

       $order_id = (!empty($data_one['paypal_uid']))?$data_one['paypal_uid']:'';

      $request_link =base_url().'sales';

      $bodyid = 22;

      $tempbody_details= $this->templates_model->get_usertemplate_data($bodyid);

      $body = $tempbody_details['template_content'];

      $body = str_replace('{base_url}', $this->base_domain, $body);

      $body = str_replace('{gig_owner}', $email_details['seller_name'], $body);

      $body = str_replace('{buyer_name}',$email_details['buyer_name'], $body);

      $body = str_replace('{title}',str_replace("-"," ",$title), $body);

      $body = str_replace('{title_url}',$title, $body);

      $body = str_replace('{PAYPAL_ID}',$order_id, $body);

      $body = str_replace('{ITEM_NAME}',str_replace("-"," ",$title), $body);

      $body = str_replace('{PRICE}',$gig_price , $body);

      $body = str_replace('{BUYER_LINK}', $user_profile_link, $body);



       $body = str_replace('{TEABLE_ROW}', $h_all, $body);



      $body = str_replace('{IMG_SRC}',$img_path , $body);

      $body = str_replace('{gig_preview_link}',$gig_preview_link, $body);

      $body = str_replace('{request_link}',$request_link, $body);

      $body = str_replace('{site_name}',$this->site_name, $body);



$seller_message =                    $message ='<table style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">

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

      $this->load->helper('file');

      $this->load->library('email');

      $this->email->set_newline("\r\n");

      $this->email->from($this->email_address,$this->email_tittle);

      $this->email->to($toemail);

      $this->email->subject('New order from '.$email_details['buyer_name']);

      $this->email->message($seller_message);

      $this->email->send();

    //admin mail function

     $from_timezone = $this->get_user_time_zone($data_one['buyer_id']);

     $order_id = (!empty($data_one['paypal_uid']))?$data_one['paypal_uid']:'';


    date_default_timezone_set($from_timezone);

    $current_time= date('Y-m-d H:i:s');

        $bodyid = 19;

        $tempbody_details= $this->templates_model->get_usertemplate_data($bodyid);

        $body=$tempbody_details['template_content'];

    $body = str_replace('{base_url}', $this->base_domain, $body);

    $body = str_replace('{PAYPAL_ID}', $order_id, $body);

    $body = str_replace('{CREATED_ON}', $current_time, $body);

        $body = str_replace('{buyer_name}', $data_one['buyername'], $body);

        $body = str_replace('{seller_name}', $data_one['sellername'], $body);

        $body = str_replace('{ITEM_NAME}',str_replace("-"," ",$title), $body);

        $body = str_replace('{PRICE}',''.$gig_price, $body);

        $body = str_replace('{IMG_SRC}',$img_path , $body);

    $body = str_replace('{site_name}',$this->site_name, $body);

    $body = str_replace('{TEABLE_ROW}', $h_all, $body);

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

      $this->load->helper('file');

      $this->load->library('email');

      $this->email->set_newline("\r\n");

      $this->email->from($this->email_address,$this->email_tittle);

      $this->email->to($this->email_address);

      $this->email->subject('Create New Order');

      $this->email->message($message);

      $this->email->send();

      return $data_one;



   }



  public function user_request_gigs($inputs){

      $inser_ids  = array();

      if(!empty($inputs)){

        foreach ($inputs as  $value) {

        $this->db->insert('user_required_extra_gigs', $value);

        $inser_ids[] =  $this->db->insert_id();

        }

      }

      return $inser_ids;

  }



 public function search_data($input){



    $input = array_filter($input);

    $title          = (!empty($input['title'])) ? str_replace(' ', '_',$input['title']):'';

    $category_id    = (!empty($input['category_id']))?$input['category_id']:'';

    $state          = (!empty($input['state']))?$input['state']:'';

    $country        = (!empty($input['country']))?$input['country']:'';

    $device_type    = (!empty($input['device_type']))?strtolower($input['device_type']):'';

    $page           = (!empty($input['page']))?$input['page']:'';

    if(!empty($title) || !empty($category_id) || !empty($state) || !empty($country)){



      $query_string = "SELECT SG.id,SG.user_id,SG.delivering_time as delivering_days,SG.currency_type,CASE SG.currency_type when 'USD'  then '$' when 'EUR'  then '€' when 'GBP'  then '£' END as currency_sign, replace(SG.title,'-', ' ') as title ,SG.gig_price,SG.total_views,M.fullname,C.country,S.state_name, GI.gig_image_medium AS image,(SELECT count(id) FROM `feedback` WHERE `gig_id` = SG.id and to_user_id = SG.user_id) AS gig_usercount,

                (SELECT COALESCE(CAST(AVG(rating) AS DECIMAL(10,1)),0) as rating FROM `feedback` WHERE `gig_id` = SG.id and to_user_id = SG.user_id) AS gig_rating ,'0' as favourite FROM sell_gigs AS SG

                LEFT JOIN gigs_image AS GI  ON GI.gig_id = SG.id

                LEFT JOIN members AS M ON M.USERID=SG.user_id

                LEFT JOIN country AS C  ON C.id = M.country

                LEFT JOIN states AS S  ON S.state_id = M.state";


      if(!empty($title) && !empty($category_id) && !empty($state) && !empty($country)){

        $query_string .= " WHERE title like '%".$title."%' AND SG.category_id = $category_id AND M.state = $state AND M.country = $country";

      }

      if(empty($title) && !empty($category_id) && !empty($state) && !empty($country)){

        $query_string .= " WHERE SG.category_id = $category_id AND M.state = $state AND M.country = $country";

      }

      if(!empty($title) && empty($category_id) && !empty($state) && !empty($country)){

        $query_string .= " WHERE title like '%".$title."%'  AND M.state = $state AND M.country = $country";

      }

      if(!empty($title) && !empty($category_id) && !empty($state) && empty($country)){

        $query_string .= " WHERE title like '%".$title."%' AND SG.category_id = $category_id AND M.state = $state ";

      }

      if(!empty($title) && !empty($category_id) && !empty($country) && empty($state)){

        $query_string .= " WHERE title like '%".$title."%' AND SG.category_id = $category_id AND M.country = $country";

      }





      if(empty($title) && !empty($category_id) && !empty($state) && empty($country)){

        $query_string .= " WHERE SG.category_id = $category_id AND M.state = $state ";

      }

      if(empty($title) && !empty($category_id) && empty($state) && !empty($country)){

        $query_string .= " WHERE SG.category_id = $category_id  AND M.country = $country";

      }

      if(!empty($title) && !empty($category_id) && empty($country) && empty($state)){

        $query_string .= " WHERE title like '%".$title."%' AND SG.category_id = $category_id";

      }

      if(empty($title) && empty($category_id) && !empty($state) && !empty($country)){

        $query_string .= " WHERE  M.state = $state AND M.country = $country";

      }

      if(!empty($title) && empty($category_id) && !empty($state) && empty($country)){

         $query_string .= " WHERE title like '%".$title."%' AND M.state = $state";

      }

      if(!empty($title) && empty($category_id) && empty($state) && !empty($country)){

        $query_string .= " WHERE title like '%".$title."%'  AND M.country = $country";

      }





      if(!empty($title) && empty($category_id) && empty($country) && empty($state)){

        $query_string .= " WHERE title like '%".$title."%' ";

      }

      if(empty($title) && !empty($category_id) && empty($state) && empty($country)){

        $query_string .= " WHERE SG.category_id = $category_id ";

      }

      if(empty($title) && empty($category_id) && !empty($state) && empty($country)){

        $query_string .= " WHERE M.state = $state ";

      }

      if(empty($title) && empty($category_id) && empty($state) && !empty($country)){

        $query_string .= " WHERE M.country = $country";

      }


       $query_string .= " AND SG.status = 0 AND  M.status = 0  GROUP BY SG.id ORDER BY title ASC";


      $query = $this->db->query($query_string);

      if($query->num_rows() > 0 ){

        $records = $query->result_array();

      }else{

        $records = array();

      }


    if(isset($device_type) && !empty($device_type) && ($device_type == 'ios' || $device_type == 'android'))
    {
      if($page == 1){
        $query_string .= " LIMIT 0 ,10";
      }else{
        $start = ($page-1) * 10;
        $query_string .= " LIMIT $start,10";
      }
      $total_records = count($records);
         $records = array();
         $query = $this->db->query($query_string);
           if($query->num_rows() > 0){
               $records  = $query->result_array();
            }
         return array('total_pages'=>ceil($total_records/10),'result_details'=>$records);
    }
    else
    {
       return $query->result_array();
      }



      //echo $query_string;exit;



    }else{

      return array();

    }





}



  //Get footer details with sub_footer menu

  public function GetAllFooter(){


    $this->db->select('footer_menu.title,footer_submenu.footer_submenu,footer_submenu.page_desc');
    $this->db->from('footer_menu');
    $this->db->join('footer_submenu','footer_submenu.footer_menu=footer_menu.id');
    $this->db->where('footer_menu.status',1);
    $this->db->where('footer_submenu.status',1);
    $query=$this->db->get();

    $recrods=$query->result_array();

      if(!empty($recrods)){

        return $recrods ;

      }else{

        return array();

     }



   }



   public function GetAllPaymentGateway()

  {

    $this->db->select('*');
    $this->db->from('payment_gateways');
    $this->db->where('status',1);
    $query = $this->db->get();
    $recrods = $query->result_array();

    $this->db->select('key, value');
    $this->db->from('system_settings');
    $record = $this->db->get()->result_array();
    if(!empty($record)){
      foreach ($record as $value) {
         if($value['key']=='paypal_option'){
                $paypal_option = $value['value']; // 1 -sandbox, 2 -live
          }
          if($value['key']=='paypal_allow'){
                $paypal_allow = $value['value']; // 1 -Active, 2 -Inactive
          }
          if($value['key']=='stripe_option'){
                $stripe_option = $value['value']; // 1 -sandbox, 2 -live
          }
          if($value['key']=='stripe_allow'){
                $stripe_allow = $value['value']; // 1 -Active, 2 -Inactive
          }
      }
    }
    $payments_array = array();
    $j = 0;
    $query = $this->db->query("SELECT * FROM `paypal_details` WHERE id = 1");
    $result = $query->row_array();
    $l_paypal_u = '';
    $l_paypal_p = '';
    $s_paypal_u = '';
    $s_paypal_p = '';
    if(!empty($result)){
     $l_paypal_u = $result['email'];
     $l_paypal_p = $result['password'];
     $s_paypal_u = $result['sandbox_email'];
     $s_paypal_p = $result['sandbox_password'];
    }
    if($paypal_allow == 1){
      if($paypal_option==1){ // sandbox
         $payments_array[$j]['gateway_name'] = 'PayPal';;
         $payments_array[$j]['gateway_type'] =  'sandbox';
         $payments_array[$j]['api_key'] =  $s_paypal_u;
         $payments_array[$j]['value'] =  $s_paypal_p;
         $payments_array[$j]['status'] =  1;
      ++$j;
      }
      if($paypal_option==2){ // live
          $payments_array[$j]['gateway_name'] =  'PayPal';
          $payments_array[$j]['gateway_type'] =  'live';
         $payments_array[$j]['api_key'] =  $l_paypal_u;
         $payments_array[$j]['value'] =  $s_paypal_p;
         $payments_array[$j]['status'] =  1;
      ++$j;
      }
    }

    if($stripe_allow == 1){
      if($stripe_option==1){ // sandbox
          if(!empty($recrods)){
            foreach ($recrods as $data) {
              if(strtolower($data['gateway_type']) == 'sandbox'){
                 $payments_array[$j]['gateway_name'] =  $data['gateway_name'];
                 $payments_array[$j]['gateway_type'] =  $data['gateway_type'];
                 $payments_array[$j]['api_key'] =  $data['api_key'];
                 $payments_array[$j]['value'] =  $data['value'];
                 $payments_array[$j]['status'] =  $data['status'];
                 ++$j;
              }
            }
          }
      }
      if($stripe_option==2){ // live
          if(!empty($recrods)){
            foreach ($recrods as $data) {
              if(strtolower($data['gateway_type']) == 'live'){
                 $payments_array[$j]['gateway_name'] =  $data['gateway_name'];
                 $payments_array[$j]['gateway_type'] =  $data['gateway_type'];
                 $payments_array[$j]['api_key'] =  $data['api_key'];
                 $payments_array[$j]['value'] =  $data['value'];
                 $payments_array[$j]['status'] =  $data['status'];
                 ++$j;
              }
            }
          }
      }
    }
    return $payments_array;

   }

   public function get_currencies(){
    $this->db->select('currency,currency_sign');
    $this->db->where('status',1);
    return $this->db->get('currencies')->result_array();
   }
   public function get_all_footer_menu(){

      $this->db->select('FM.id,FM.title');
      $this->db->from('footer_menu FM');
      $this->db->where('FM.status',1);
      $this->db->order_by('title', 'asc');
      $records = $this->db->get()->result_array();
      $records_new = array();

      if(!empty($records)){
        $i = 0;
        foreach ($records as $rec) {
          $record = array();
          $this->db->select('REPLACE(FSM.footer_submenu,"_"," ") as title,page_desc');
          $this->db->from('footer_submenu FSM');
          $this->db->where('FSM.status',1);
          $this->db->where('FSM.footer_menu ',$rec['id']);
          $this->db->order_by('footer_submenu', 'asc');
          $record = $this->db->get()->result_array();
          if(sizeof($record)>0){
            $records_new[$i]['main_menu'] = ucfirst(str_replace('_', ' ', $rec['title']));
            $records_new[$i]['is_expand'] = "0";
            $records_new[$i]['sub_menu'] = $record;
            $i++;
          }

        }

      }


      if(!empty($records_new)){

        return $records_new ;

      }else{

        return array();

     }

   }

   public function get_terms(){

            $terms = array();
            $user  = "";
            $gigs  = "";

            $query_string = "SELECT page_desc as description  FROM `term`";
            $query = $this->db->query($query_string);
             if ($query->num_rows() > 0) {
                   $terms =  $query->result_array();
            }

            if(count($terms) > 0){
            for($i=0; $i<=count($terms); $i++)
            {
              if($i == 0){
                $user = (!empty($terms[$i]['description']))?$terms[$i]['description']:'';
              }
              else if($i == 1){
                $gigs = (!empty($terms[$i]['description']))?$terms[$i]['description']:'';
              }
            }
            }
            return $data = array('user_terms_and_conditions' => $user, 'gigs_terms_and_conditions' => $gigs);
    }


  public function change_stripe_status($datas) {

    $p_id          = $datas['order_id'];
    $reason        = $datas['cancel_reason'];
    $user_id       = $datas['user_id'];
    $from_timezone = $datas['time_zone'];

    $data_up['buyer_status'] = 1;
    $data_up['cancel_reason'] = $reason;
    $data_up['cancel_notification_status'] =1;

    date_default_timezone_set($from_timezone);
    $current_time= date('Y-m-d H:i:s');
    $data_up['canceled_at'] =$current_time;

    if($this->db->update('payments',$data_up,array('id'=>$p_id))){

      //seller mail function

      $query = $this->db->query("SELECT paypal_uid,item_amount,( SELECT gigs_image.`gig_image_thumb` FROM `gigs_image` WHERE gigs_image.gig_id = payments.gigs_id LIMIT 0 , 1  ) as gig_image,payments.extra_gig_ref,payments.extra_gig_dollar,sg.gig_price  FROM `payments`    LEFT JOIN sell_gigs as sg ON sg.id = payments.gigs_id  WHERE payments.id = $p_id");

      $data_one = $query->row_array();

      $email_details  = $this->gigs_model->gig_purchase_requirements($p_id);

      $seller_message = '';

      $welcomemessage = '';

      $toemail= $email_details['email'];

      $gig_price = $this->gigs_model->gig_price();

      //$gig_price = '$'.$gig_price['value'];

      $gig_price = $this->default_currency_sign.' '.$data_one['gig_price'];



      $extra_gig_price = $this->gigs_model->extra_gig_price();

          $extra_gig_price = $extra_gig_price['value'];

      $extra_gig_ref = json_decode($email_details['extra_gig_ref']);

      $user_profile_link =  base_url().'user-profile/'.$email_details['buyer_username'];

      $order_id=$data_one['paypal_uid'];

      $title =$email_details['title'];

      $gig_preview_link  = base_url().'gig-preview/'.$title ;

      $img_path =base_url().$data_one['gig_image'];

      $gig_preview_link  = base_url().'gig-preview/'.$title ;

      $h_all='';

      if(!empty($extra_gig_ref))

      {

        $query_extra = $this->db->query("SELECT * FROM `user_required_extra_gigs` WHERE id IN ($extra_gig_ref)");

        $result_extra = $query_extra->result_array();



        foreach ($result_extra as $data_extra)

        {

          $dataoptions = json_decode($data_extra['options']);

          $gig_values = explode('___',$data_extra['options']);

          if($gig_values[1]!=0 || $gig_values[1]!= "undefined" )

          {

            $h_all.='<tr><td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">&nbsp;</td>

              <td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">

                '.str_replace('"','',$gig_values[0]).'

              </td>

              <td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">'.$gig_values[1].'</td>

              <td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">$'.$extra_gig_price.'</td>

              </tr>';

          }

        }

      }

      if($email_details['payment_super_fast_delivery']==0)

      {

        $sup_dec='Super fast delivery';

        if(!empty($email_details['super_fast_delivery_desc']))

        {

          $sup_dec=$email_details['super_fast_delivery_desc'];

        }

        $h_all.='<tr><td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">&nbsp;</td>

              <td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">

                '.$sup_dec.'

              </td>

              <td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">1</td>

              <td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">$'.$extra_gig_price.'</td>

              </tr>';

      }

      $h_all.='<tr>

            <td colspan="3" style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">Total</td>

            <td style="font-family: Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; vertical-align: top; border:1px solid #e7e7e7; margin: 0; padding: 8px;" valign="top">$'.$data_one['item_amount'].'</td>

          </tr>';

      $request_link =base_url().'sales';

      $bodyid = 24;

      $tempbody_details= $this->templates_model->get_usertemplate_data($bodyid);

      $body = $tempbody_details['template_content'];

      $body = str_replace('{base_url}', $this->base_domain, $body);

      $body = str_replace('{base_image}',$this->base_domain.'/'.$this->logo_front, $body);

      $body = str_replace('{gig_owner}', $email_details['seller_name'], $body);

      $body = str_replace('{buyer_name}',$email_details['buyer_name'], $body);

      $body = str_replace('{title}',str_replace("-"," ",$title), $body);

      $body = str_replace('{gig_link}',$gig_preview_link, $body);

      $body = str_replace('{PAYPAL_ID}',$order_id, $body);

      $body = str_replace('{ITEM_NAME}',str_replace("-"," ",$title), $body);

      $body = str_replace('{PRICE}',$gig_price , $body);

      $body = str_replace('{site_name}',$this->site_name, $body);

      $body = str_replace('{BUYER_LINK}', $user_profile_link, $body);

      $body = str_replace('{TEABLE_ROW}', $h_all, $body);

      $body = str_replace('{IMG_SRC}',$img_path , $body);

      $body = str_replace('{accept_link}',$request_link, $body);



      $seller_message ='<table style="font-family: Helvetica Neue,Helvetica,Arial,sans-serif; box-sizing: border-box; font-size: 14px; width: 100%; background-color: #f6f6f6; margin: 0;" bgcolor="#f6f6f6">

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

      $this->load->helper('file');

      $this->load->library('email');

      $this->email->set_newline("\r\n");

      $this->email->from($this->email_address,$this->email_tittle);

      $this->email->to($toemail);

      $this->email->subject('Order Cancelled From '.$email_details['buyer_name']);

      $this->email->message($seller_message);

      $this->email->send();

      return 1;

    }else{

      return 2;

    }

  }

   public function stripe_account_details($input)
  {
    
      $user_id = $input['user_id'];

    // $this->change_stripe_status($input);

    $this->db->where('user_id',$user_id);
    $count = $this->db->count_all_results('stripe_bank_details');

    	unset($input['time_zone'],$input['order_id'],$input['cancel_reason']);

    	if(!empty($input['device_type'])){unset($input['device_type']);}
      
      
    if($count==0){
      $this->db->insert('stripe_bank_details',$input);

    }else{
      $this->db->where('user_id',$user_id);
      $this->db->update('stripe_bank_details', $input);
    }
    $this->db->where('user_id',$user_id);
    return $this->db->get('stripe_bank_details')->row_array();

  }

  public function get_payment_details($id){
      $where  = array('id' =>$id);
      $result = $this->db->get_where('payments',$where)->row();
      return $result;
  }
  public function get_user_id_using_token($token)
  {
    if($token!=''){
      $this->db->select('USERID as user_id');
      $records = $this->db->get_where('members', array('unique_code' => $token))->row_array();
      if(!empty($records)){
        return $records['user_id'];
      }
    }
    return 0;
  }

  public function order_status_notification($t_user,$title,$message)
  {
    
    $API_details    = $this->gigs->settings();
    $include_player = $this->player_ids($t_user);


    $include_player_ids = '';
    if(!empty($include_player)){

      $include_player_ids = $include_player['device_id'];


    if($include_player['device']!='browser'){

    if(!empty($API_details['one_signal_app_id']) && !empty($API_details['one_signal_reset_key'])){

      $data = array();

      $data['user_id'] = $t_user;

      $data['message'] = $message;

      $data['app_id'] = $API_details['one_signal_app_id'];

      $data['reset_key'] = $API_details['one_signal_reset_key'];

      $data['include_player_ids'] = $include_player_ids;

      $data['additional_data'] = array('from_name'=>$title);

      $result = send_message($data);
     
      return $result = (array)json_decode($result);



     }

    }
    }
  }

  public function complete_accept_reject($params)
  {
    
    if($params){ 
      
      $id = $params['buyer_id'];
      
      $input = array();
     
      $current_time = date('Y-m-d H:i:s');
     
      $gig_id = $input['gig_id'] = $params['gig_id'];
     
      $gig_request_details = $this->gigs_model->gig_rejected($gig_id);
     
      $order_id = $input['order_id'] = $params['order_id'];
     
      $input['seller_id'] = $seller_id =  $params['seller_id'];

      $input['buyer_id']  = $id;
      
      $input['message']   = $reject_reason = $params['reject_reason'];
      
      $input['created_time'] = $current_time;
      
      $title = $gig_request_details['title'];
      
      $result = $this->gigs_model->rejected_request($input);
      
      $insert_id = $this->db->insert_id();
      
      $admin_cancel = $this->gigs_model->request_rejected($insert_id,$gig_id);

       $bodyid = 32;
   

        $admin_name = $admin_cancel['admin_name']; 

        $buyer_email = $admin_cancel['buyer_email']; 

        $admin_email = $admin_cancel['admin_email']; 

        $seller_name = $admin_cancel['seller_name']; 

        $buyer_name = $admin_cancel['buyer_name'];

        $this->email_address = $buyer_email;

        $this->admin_email_address = $admin_email; 

        $tempbody_details= $this->templates_model->get_usertemplate_data($bodyid);
         
        $body=$tempbody_details['template_content'];

        $body = str_replace('{admin_name}',$admin_name, $body);

        $body = str_replace('{seller_name}',$seller_name, $body);

        $body = str_replace('{buyer_name}',$buyer_name, $body);

        $body = str_replace('{title}',$title, $body);

        $body = str_replace('{site_name}',$this->site_name, $body);     

        $body = str_replace('{TITLE}', str_replace('-',' ',$title), $body);

        $link=base_url().'admin/rejected_orders';

        $body = str_replace('{gig_link}', $link, $body);

        
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

        $this->load->helper('file');  

        $this->load->library('email');
         $this->email->initialize($this->smtp_config);
        $this->email->set_newline("\r\n");

        $this->email->subject('New Rejected order');

        $this->email->message($message);

        $this->email->from($buyer_email,$this->email_tittle);

        $this->email->to($admin_email);

        $url_parts = parse_url(current_url());
        
        $result = $this->email->send();
        
        $feedback_title = $buyer_name;
        
        $feedback_title .= ' - '.$title;

        $this->order_status_notification($seller_id,$feedback_title,$reject_reason);
        return true;
    }
  }

}
?>
