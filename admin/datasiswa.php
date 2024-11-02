<?php
session_start();
include '../all/connection.php';

if (!isset($_SESSION['email'])) {
    header("location: ../login-done/login71.php");
    exit();
}

$email = $_SESSION['email'];

// Fetch user data based on email
$banyak_admin = $conn->query("SELECT * FROM user WHERE email = '$email'");
$admin = [];
if ($row = $banyak_admin->fetch_assoc()) {
    $admin = $row;
}

if (isset($_POST['submit'])) {
    $nis = $_POST['nis'];
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $kelas = $_POST['kelas'];
    
        $sql = "SELECT * FROM user WHERE email='$email'";
        $result = mysqli_query($conn, $sql);
        if (!$result->num_rows > 0) {
            $sql = "INSERT INTO user (nis, nama, kelas, email, password)
                    VALUES ('$nis', '$nama', '$kelas', '$email', '$password')";
            $result = mysqli_query($conn, $sql);
            if ($result) {
                // mengkosongkan value setelah berhasil insert data
                $nis = "";
                $nama = "";
                $kelas= "";
                $email= "";
                $_POST['password'] = "";
                
                echo "<script>
                alert('Selamat, registrasi berhasil!');
                window.location.href = 'datasiswa.php';
              </script>";
    
                exit();
            } else {
                echo "<script>alert('Woops! Terjadi kesalahan.')</script>";
            }
        } else {
            echo "<script>alert('Woops! Email Sudah Terdaftar.')</script>";
        }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Base styling */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            display: flex;
            background-color: #f4f4f9;
            color: #333;
        }

        /* Sidebar styling */
        .sidebar {
            width: 250px;
            background-color: #2C3E50;
            color: #fff;
            padding: 20px;
            height: 100vh;
            position: fixed;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .sidebar img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin-bottom: 20px;
        }

        .sidebar h2 {
            font-size: 20px;
            margin-bottom: 20px;
        }

        .sidebar ul {
            list-style: none;
            width: 100%;
        }

        .sidebar ul li {
            margin: 15px 0;
        }

        .sidebar ul li a {
            text-decoration: none;
            color: #fff;
            font-size: 18px;
            display: flex;
            align-items: center;
        }

        .sidebar ul li a i {
            margin-right: 10px;
        }

        /* Main content styling */
        .main-content {
            margin-left: 250px;
            padding: 20px;
            width: 100%;
        }

        .header {
            background-color: #2980B9;
            color: #fff;
            padding: 30px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 20px;
        }

        .info-boxes {
            display: flex;
            justify-content: space-between;
            gap: 20px;
            margin-top: 20px;
        }

        .info-box {
            background-color: #3498DB;
            color: #fff;
            width: 30%;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
        }

        .info-box h2 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .info-box .icon {
            font-size: 50px;
            margin-bottom: 15px;
        }

        /* Form container styling */
        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 300px;
            position: absolute;
            top: 160px;
            right: 20px;
        }

        .form-container h2 {
            font-size: 24px;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .submit-btn {
            background-color: #2980B9;
            color: #fff;
            padding: 10px;
            width: 100%;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .submit-btn:hover {
            background-color: #3498DB;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <img src="logo.png" alt="Admin">
        <h2>Admin : <?= htmlspecialchars($admin['nama']); ?></h2>
        <ul>
            <li><a href=""><i class="fas fa-home"></i> Home</a></li>
            <li><a href="#"><i class="fas fa-user-check"></i> Data Siswa</a></li>
            <li><a href="#"><i class="fas fa-user-cog"></i> Manajemen Admin</a></li>
            <li><a href="#"><i class="fas fa-history"></i> Riwayat Absen</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header / Welcome Message -->
        <div class="header">
            <h1>Data Siswa SMKN 71 Jakarta</h1>
            <p>Dashboard for managing student attendance and admin settings</p>
        </div>

        <!-- Form Container -->
        <div class="form-container">
            <h2>Tambah Data Siswa</h2>
            <form method="POST" action="">
                <div class="form-group">
                    <label for="nis">NIS</label>
                    <input type="number" name="nis" id="nis" required>
                </div>

                <div class="form-group">
                    <label for="nama">Nama</label>
                    <input type="text" name="nama" id="nama" required>
                </div>

                <div class="form-group">
                    <label for="kelas">Kelas</label>
                    <select name="kelas" id="kelas" required>
                        <option value="X RPL 1">X RPL 1</option>
                        <option value="X RPL 2">X RPL 2</option>
                        <option value="X DKV 1">X DKV 1</option>
                        <option value="X DKV 2">X DKV 2</option>
                        <option value="X ANM 1">X ANM 1</option>
                        <option value="X ANM 2">X ANM 2</option>
                        <option value="XI RPL 1">XI RPL 1</option>
                        <option value="XI RPL 2">XI RPL 2</option>
                        <option value="XI DKV 1">XI DKV 1</option>
                        <option value="XI DKV 2">XI DKV 1</option>
                        <option value="XI ANM 1">XI ANM 2</option>
                        <option value="XI ANM 2">XI ANM 1</option>
                        <option value="XII RPL ">XII RPL </option>
                        <option value="XII DKV ">XII DKV </option>
                        <option value="XII ANM ">XII ANM </option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="email_siswa">Email</label>
                    <input type="email" name="email" id="email" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" required>
                </div>

                <button type="submit" class="submit-btn" name="submit">Submit</button>
            </form>
        </div>
    </div>

</body>
</html>
