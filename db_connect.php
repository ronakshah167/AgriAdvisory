<?php
$conn = new mysqli("localhost","root","","agriadvisory");

if($conn->connect_error){
die("Connection Failed: ".$conn->connect_error);
}
?>