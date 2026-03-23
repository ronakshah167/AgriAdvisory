<?php
include "db_connect.php";

$fullname = $_POST['fullname'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$password = $_POST['password'];
$address = $_POST['address'];
$land = $_POST['land'];
$service = $_POST['service'];

$sql = "INSERT INTO farmers(fullname,email,phone,password,address,land_area,service)
VALUES('$fullname','$email','$phone','$password','$address','$land','$service')";

if($conn->query($sql)){
echo "Success";
}else{
echo "Error";
}
?>