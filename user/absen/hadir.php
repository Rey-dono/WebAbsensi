<?php
session_start();
include '../../all/connection.php';

if (!isset($_SESSION['email'])) {
    header("location: ../../login-done/login71.php");
}

$email = $_SESSION['email'];

$siswa = $conn->query("SELECT * FROM user WHERE email ='$email'");

if (mysqli_query($conn, "INSERT INTO history (nis, status, waktu, surat, id_user)
SELECT nis, status, waktu, surat, id
FROM user WHERE email = '$email'")) {
    if (mysqli_query($conn, "UPDATE user SET status ='hadir', surat='' WHERE email = '$email'")) {
        header("location: ../selamat/berhasil_absen.php");
    }
    
}