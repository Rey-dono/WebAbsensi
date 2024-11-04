<?php

include '../all/connection.php';

$nis = $_GET['nis'];  

mysqli_query($conn, "delete from user WHERE nis=$nis");

header("location:../admin/datasiswa.php");    
?>