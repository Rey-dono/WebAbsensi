<?php
// Koneksi ke database
$conn = new mysqli('127.0.0.1', 'root', '', 'absen');

if ($conn->connect_errno) {
    echo "Error: " . $conn->connect_error;
    exit();
}

// Mulai transaksi
$conn->begin_transaction();

try {
    // Query untuk insert ke history, pastikan menggunakan VALUES dengan data yang valid

    // Query untuk update di user
    // $sql = "UPDATE user SET waktu='', status='alfa', surat_sakit='', surat_izin=''";
    // if (!$conn->query($sql)) {
    //     throw new Exception("Error resetting field: " . $conn->error);
    // } else {
    //     echo "Field reset successfully.";
    // }

    if (mysqli_query($conn, "INSERT INTO history (id, nis, status, waktu)
SELECT id, nis, status, waktu
FROM user")) {
    if (mysqli_query($conn, "UPDATE user SET waktu='', status='alfa', surat_sakit='', surat_izin=''")) {
        echo "Field reset successfully.";
    } else {
        throw new Exception("Error resetting field: " . $conn->error);
    }
    
}

    // Commit transaksi jika kedua query berhasil
    $conn->commit();

} catch (Exception $e) {
    // Rollback transaksi jika ada query yang gagal
    $conn->rollback();
    echo $e->getMessage();
}

// Tutup koneksi
$conn->close();

// Log waktu script dijalankan
file_put_contents('C:\xampp\htdocs\WebAbsensi\admin\log.txt', "Script dijalankan pada: " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);
?>
