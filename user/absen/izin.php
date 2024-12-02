<?php
session_start();
include '../../all/connection.php';

if (!isset($_SESSION['email'])) {
    header("location: ../../login-done/login71.php");
    exit;
}

$email = $_SESSION['email'];

if (isset($_POST["submit"])) {
    $surat = upload();

    if (!$surat) {
        return false;
    }
// Set the new status to "izin", clear surat_sakit, and store the new surat_izin
$query = "INSERT INTO history (nis, status, waktu, id_user, surat)
SELECT nis, status, waktu, id, surat
FROM user WHERE email = '$email'";

    if (mysqli_query($conn, $query)) {
    if (mysqli_query($conn, "UPDATE user SET status ='izin', surat='$surat' WHERE email = '$email'")) {
        header("location: ../selamat/berhasil_absen.php");
    }
    

    } else {
        echo "<script>
                alert('Silakan coba lagi!');
                window.location.href='izin.php';
              </script>";
    }
}

function upload()
{
    $namaFile = $_FILES['surat']['name'];
    $ukuranFile = $_FILES['surat']['size'];
    $error = $_FILES['surat']['error'];
    $tmpName = $_FILES['surat']['tmp_name'];

    if ($error === 4) {
        echo "<script>
                alert('Pilih gambar terlebih dahulu!');
                window.location.href='izin.php';
              </script>";
        return false;
    }

    if ($ukuranFile > 1000000) {
        echo "<script>
                alert('Ukuran gambar terlalu besar!');
                window.location.href='izin.php';
              </script>";
        return false;
    }

    // Generate a unique file name to avoid conflicts
    $fileExt = pathinfo($namaFile, PATHINFO_EXTENSION);
    $newFileName = uniqid() . '.' . $fileExt;

    $uploadDir = realpath(__DIR__ . '/../img/surat') . '/';
    $uploadPath = $uploadDir . $newFileName;

    if (move_uploaded_file($tmpName, $uploadPath)) {
        return $newFileName;
    } else {
        echo "<script>
                alert('Gagal mengupload file!');
                window.location.href='izin.php';
              </script>";
        return false;
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presensi Kehadiran Izin</title>
    <style>
    /* General Reset */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif; /* Modern font */
        text-decoration: none;
    }

    /* Background and body styling */
    body {
        background: linear-gradient(135deg, #1e3c72, #2a5298); /* Gradient background */
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        color: #fff;
        font-size: 1rem;
    }

    /* Main container with blur effect */
    .container {
        background: rgba(255, 255, 255, 0.1); /* Transparent background */
        border-radius: 20px;
        padding: 40px;
        box-shadow: 0 10px 50px rgba(0, 0, 0, 0.2);
        text-align: center;
        width: 90%;
        max-width: 800px;
        backdrop-filter: blur(10px); /* Cool blur effect */
        border: 1px solid rgba(255, 255, 255, 0.3); /* Subtle border */
    }

    /* Title with glowing effect */
    h2 {
        color: #f39c12;
        text-transform: uppercase;
        letter-spacing: 4px;
        font-size: 2.5rem;
        text-shadow: 0 0 15px rgba(255, 255, 255, 0.8);
        margin-bottom: 30px;
    }

    /* Form styling */
    .form-container {
        margin-top: 20px;
    }

    .input-group {
        display: flex;
        align-items: center;
        background: rgba(255, 255, 255, 0.2); /* Semi-transparent input background */
        border-radius: 25px;
        padding: 15px;
        margin-bottom: 20px;
        border: 1px solid rgba(255, 255, 255, 0.3); /* Subtle border */
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2); /* Input box shadow */
    }

    .input-group .icon {
        margin-right: 15px;
        font-size: 1.5rem;
        color: #f39c12; /* Icon color */
    }

    .input-group input {
        border: none;
        background: none;
        flex: 1;
        outline: none;
        font-size: 1.1rem;
        color: #fff; /* White input text */
    }

    /* Small note for mandatory input */
    .note {
        color: #f39c12;
        font-size: 0.9rem;
        margin-bottom: 20px;
        font-weight: bold;
    }

    /* Submit button styling */
    .submit-btn {
        background: linear-gradient(45deg, #f39c12, #e67e22); /* Gradient button */
        color: white;
        border: none;
        border-radius: 25px;
        padding: 15px 30px;
        cursor: pointer;
        font-size: 1.1rem;
        font-weight: bold;
        text-transform: uppercase;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .submit-btn:hover {
        transform: scale(1.1); /* Slight scaling on hover */
        background: linear-gradient(45deg, #e67e22, #d35400); /* Darker gradient on hover */
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.4);
    }

    /* Footer info styling */
    .footer-info {
        margin-top: 30px;
        background: rgba(255, 255, 255, 0.1);
        padding: 15px;
        border-radius: 10px;
        color: #fff;
        font-size: 1rem;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .footer-info p {
        margin: 5px 0;
    }
</style>

</head>

<body>
    <div class="container">
        <h2>PRESENSI KEHADIRAN IZIN</h2>
        <form class="form-container" method="POST" enctype="multipart/form-data">
            <div class="input-group">
                <span class="icon">✉️</span>
                <input type="file" placeholder="Enter Reason" name="surat">
            </div>
            <small class="note">*wajib diisi bila izin</small>
            <button name="submit" type="submit" class="submit-btn">SUBMIT</button>
        </form>
        <div class="footer-info">

        </div>
    </div>
</body>

</html>