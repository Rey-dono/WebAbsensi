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
        .navbar {
            position: fixed;
            top: 1rem;
            left: 1rem;
            background: #fff;
            border-radius: 10px;
            padding: 1rem 0;
            box-shadow: 0 0 40px rgba(0, 0, 0, 0.03);
            height: calc(100vh - 4rem);
        }

        .navbar__menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .navbar__item {
            position: relative;
        }

        .navbar__item:last-child::before {
            content: '';
            position: absolute;
            opacity: 0;
            z-index: -1;
            top: 0;
            left: 1rem;
            width: 3.5rem;
            height: 3.5rem;
            background: #406ff3;
            border-radius: 17.5px;
            transition: 250ms cubic-bezier(1, 0.2, 0.1, 1.2) all;
        }

        .navbar__link {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 3.5rem;
            width: 5.5rem;
            color: #6a778e;
            transition: 250ms ease all;
        }

        .navbar__link span {
            position: absolute;
            left: 100%;
            transform: translate(-3rem);
            margin-left: 1rem;
            opacity: 0;
            pointer-events: none;
            color: #406ff3;
            background: #fff;
            padding: 0.75rem;
            transition: 250ms ease all;
            border-radius: 17.5px;
        }

        .navbar__link:hover {
            color: #fff;
        }

        .navbar__link:hover span {
            opacity: 1;
            transform: translate(0);
        }

        .navbar__link:focus,
        .navbar__link:hover {
            span {
                opacity: 1;
                transform: translate(0);
            }
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
    <div class="navbar">
        <ul class="navbar__menu">
            <li class="navbar__item">
                <a href="admin.php" class="navbar__link"><i class="fas fa-home"></i><span>Home</span></a>
            </li>
            <li class="navbar__item">
                <a href="datasiswa.php" class="navbar__link"><i class="fas fa-user-check"></i><span>Data Siswa</span></a>
            </li>
            <li class="navbar__item">
                <a href="riwayat.php" class="navbar__link"><i class="fas fa-history"></i><span>Customers</span></a>
            </li>
            <li class="navbar__item">
                <a href="#" class="navbar__link"><i class="fas fa-folder"></i><span>Projects</span></a>
            </li>
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
