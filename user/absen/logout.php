<?php
session_start();
session_unset();
session_destroy();//menghancurkan variabel
 
header("Location: ../../login-done/login71.php"); //mengarahkan program ke halaman login setelah logout
exit();