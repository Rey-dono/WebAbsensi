<?php
session_start();
include '../../all/connection.php';

if (!isset($_SESSION['email'])) {
    header("location: ../../login-done/login71.php");
}

$email = $_SESSION['email'];

$siswa = $conn->query("SELECT * FROM user WHERE email ='$email'");

if (mysqli_query($conn, "INSERT INTO history (id, nis, status, waktu)
SELECT id, nis, status, waktu
FROM user WHERE email = '$email'")) {
    if (mysqli_query($conn, "UPDATE user SET status ='hadir', surat_sakit='', surat_izin='' WHERE email = '$email'")) {
        header("location: ../selamat/berhasil_absen.php");
    }
    
}