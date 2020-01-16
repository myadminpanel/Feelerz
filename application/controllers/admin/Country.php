<?php 
class Country extends CI_Controller{
    public function __construct() {
        parent::__construct();
        $this->data['theme'] = 'admin';
        $this->data['module'] = 'country';
        $this->load->model('admin_panel_model');
     ob_start();
    }
    public function index()
    {

        $this->data['page']='county';
        $this->data['list'] = $this->admin_panel_model->get_country();
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');


    }

// public function add_country()
// // {
// //     $data=array('' =>$this->input->post('afganistan')
// //         '' =>$this->input->post('c'),

// //     );

//  $this->data['list'] = $this->addcountrydata->get_country($data);

// $id = $this->uri->segment(4);
//     $this->admin_panel_model->add_country($id);
    

//         //var_dump($this->db->last_query());   
    
//      redirect("admin/country/county");
//  }



public function deact()
{
    var_dump("hiii");
     $id = $this->uri->segment(4);
    // $status = $this->input->get("status");
    
    $this->admin_panel_model->deact("$id");
   // $this->db_user->activate($user_id);
    // var_dump($id);
    redirect("admin/country");
  
 

}

public function act()
{
     $id = $this->uri->segment(4);
    // $status = $this->input->get("status");
    
    $this->admin_panel_model->act("$id");
   // $this->db_user->activate($user_id);
    // var_dump($id);
    redirect("admin/country");
  
 

}


public function edit_country()
{

    $id = $this->input->post('countryId');
     $countryname = $this->input->post('countryName');
    

    $data=array('name'=>$countryname ); 
    // $status = $this->input->get("status");
    // print_r($update_countrydata);
    // die;
    $update=$this->admin_panel_model->updateCountry($data,$id);
    if($update==1){
echo "true";
    }else{
        echo"false";
    }
    redirect("admin/country");
  


}

public function del($id)
{

    $this->admin_panel_model->delete_country($id);
 
    
     redirect("admin/country");

}




// public function add_country()
// {

// $data = array(
//  'id' => $this->input->post('id'),
// // 'sortname' => $this->input->post('sortname'),
// 'name' => $this->input->post('country'),
//  'status' => $this->input->post('country_status')
// );

//   $this->admin_panel_model->country_insert($data);
// $data['message'] = 'country Inserted Successfully';
// //Loading View
// // $this->data['page']='county';
// // $this->load->view($this->data['theme'].'/template');
// // redirect("admin/country");

//  var_dump($data);






// }
// working add country is below //
// public function add_country()
// {
    
// $data = array(
// // 'id' => $this->input->post('id'),
// 'name' => $this->input->post('country'),
// // 'Status' => $this->input->post('status'),
// // 'Student_Address' => $this->input->post('daddress')
// );
// // var_dump($data);
// //Transfering data to Model
// $this->admin_panel_model->country_insert($data);
// $data['message'] = 'Data Inserted Successfully';
// //Loading View
// // $this->load->view('county', $data);
// redirect("admin/country");
// }





public function updatecountrystatus()
{
    
 
     echo $status=$this->input->post("cstatus");
     
     if($status==0){
        $statusn=1; 
     }else{
         $statusn=0;  
     }
      $idArr=$this->input->post("same1");
      

 for($i=0;$i<count($idArr); $i++)
     {
       $countryid=$idArr[$i];
   
 
       $update=$this->db->query(" UPDATE country SET status ='$statusn' WHERE id ='$countryid' ");
 
    }
       redirect("admin/country");
    
}























}
?>