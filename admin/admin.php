<?php
session_start();
include '../all/connection.php';

if (!isset($_SESSION['email'])) {
    header("location: ../login-done/login71.php");
}

$email = $_SESSION['email'];

// Fetch user data based on email
$banyak_admin = $conn->query("SELECT * FROM user WHERE email = '$email'");
$admin = [];
if ($row = $banyak_admin->fetch_assoc()) {
    $admin = $row;
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
    </style>
</head>
<body>

    <!-- Sidebar -->
    <div class="sidebar">
        <img src="logo.png" alt="Admin">
        <h2>Admin : <?= htmlspecialchars($admin['nama']); ?></h2>
        <ul>
            <li><a href="#"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="datasiswa.php"><i class="fas fa-user-check"></i> Data Siswa</a></li>
            <li><a href="#"><i class="fas fa-user-cog"></i> Manajemen Admin</a></li>
            <li><a href="#"><i class="fas fa-history"></i> Riwayat Absen</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header / Welcome Message -->
        <div class="header">
            <h1>Welcome, Admin!</h1>
            <p>Dashboard for managing student attendance and admin settings</p>
        </div>

        <!-- Info Boxes -->
        <div class="info-boxes">
            <div class="info-box">
                <div class="icon"><i class="fas fa-users"></i></div>
                <h2>Jumlah Peserta Didik</h2>
                <p>526</p>
            </div>
            <div class="info-box">
                <div class="icon"><i class="fas fa-chalkboard-teacher"></i></div>
                <h2>Jumlah Guru</h2>
                <p>28</p>
            </div>
            <div class="info-box">
                <div class="icon"><i class="fas fa-door-open"></i></div>
                <h2>Jumlah Kelas</h2>
                <p>18</p>
            </div>
        </div>
    </div>
    <script>
        let idleTime = 0;

        function resetIdleTime  (){
            idleTime = 0;
        }
        setInterval(function() {
            idleTime++; 
            if(idleTime>=20){
                window.location.href='../admin/logout.php';
            }
            
        }, 1000);
    </script>
</body>
</html>
