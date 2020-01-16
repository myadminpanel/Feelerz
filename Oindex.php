<h1>feelerzapp</h1>
<?php
$con = mysqli_connect('localhost','feelerza_admin','admin@123','feelerza_admin');
if($con)
{
    echo 'Success';
}
else
{
    echo 'Failed';
}
?>