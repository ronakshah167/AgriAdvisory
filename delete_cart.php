<?php
include "db_connect.php";

$id = $_POST['id'];

$sql = "DELETE FROM cart WHERE id=$id";

if($conn->query($sql)){
echo "Deleted";
}else{
echo "Error";
}
?>