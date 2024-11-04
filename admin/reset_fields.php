<?php
// Koneksi ke database

$conn = new mysqli('127.0.0.1', 'root', '', 'absen');

if ($conn->connect_errno) {
    echo "Error:" . $conn->connect_error;
}

// Query untuk mereset field
$sql = "UPDATE user SET waktu='', status='alfa', surat_sakit='', surat_izin=''";
if ($conn->query($sql) === TRUE) {
    echo "Field reset successfully.";
} else {
    echo "Error resetting field: " . $conn->error;
}

// Tutup koneksi
$conn->close();

file_put_contents('C:\xampp\htdocs\WebAbsensi\admin\log.txt', "Skrip dijalankan pada: " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
?>
