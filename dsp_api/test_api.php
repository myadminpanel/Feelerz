<?php 

  date_default_timezone_set("Senegal/Dakar");

  $conn = mysqli_connect("localhost","digimonk_carrent","digicar@123","digimonk_cars");
  // date_default_timezone_set("Asia/kolkata");
mysqli_set_charset($conn, "utf8");
// Takes raw data from the request
$json = file_get_contents('php://input');

// Converts it into a PHP object
$data = json_decode($json);

if(@$data->email!="" && @$data->password!="")
{
    
    $data_res=mysqli_query($conn,"select * from registration where email='".@$data->email."' and password='".@$data->password."'");
    $data_res_fetch=mysqli_fetch_array($data_res);
    if(@$data_res_fetch)
    {
        echo json_encode(array("status"=>true,"data"=>$data_res_fetch));
    }
    else
    {
       echo json_encode(array("status"=>false,"message"=>"user id and password is incorrect."));
    }
}
else
{
echo json_encode(array("status"=>false,"message"=>"user email and password is required."));    
}

?>