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
    

    $query = "INSERT INTO history (id, nis, status, waktu)
    SELECT id, nis, status, waktu
    FROM user WHERE email = '$email'";

    if (mysqli_query($conn, $query)) {
    if (mysqli_query($conn, "UPDATE user SET status ='sakit', surat_sakit = '$surat',surat_izin='' WHERE email = '$email'")) {
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

    $uploadDir = realpath(__DIR__ . '/../img/surat-sakit') . '/';
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
    <title>Presensi Kehadiran Sakit</title>
    <style>
        /* General styling */
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #5a4f4f;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Container for the form and footer info */
        .container {
            background-color: #f8f4f4;
            width: 1600px;
            height: 800px;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        /* Form styling */
        .form-container {
            margin-top: 20px;
        }

        .input-group {
            display: flex;
            align-items: center;
            background-color: #d3d3d3;
            border-radius: 25px;
            padding: 10px;
            margin-bottom: 10px;
        }

        .input-group .icon {
            margin-right: 10px;
            font-size: 1.2rem;
        }

        .input-group input {
            border: none;
            background: none;
            flex: 1;
            outline: none;
            font-size: 1rem;
        }

        /* Small note under input field */
        .note {
            color: red;
            font-size: 0.8rem;
            margin-bottom: 20px;
        }

        /* Submit button styling */
        .submit-btn {
            background-color: #82aef5;
            color: white;
            border: none;
            border-radius: 25px;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 1rem;
        }

        .submit-btn:hover {
            background-color: #5a8ed1;
        }

        /* Footer info styling */
        .footer-info {
            margin-top: 600px;
            background-color: #72b4fc;
            padding: 15px;
            border-radius: 10px;
            color: white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .footer-info p {
            margin: 5px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>PRESENSI KEHADIRAN SAKIT</h2>
        <form class="form-container" method="POST" enctype="multipart/form-data">
            <div class="input-group">
                <span class="icon">✉️</span>
                <input type="file" placeholder="Enter Reason" name="surat">
            </div>
            <small class="note">*wajib diisi bila sakit</small>
            <button name="submit" type="submit" class="submit-btn">SUBMIT</button>
        </form>
        <div class="footer-info">
            
        </div>
    </div>
</body>
</html>
