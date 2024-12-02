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
* {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
    font-family: 'Roboto', Arial, sans-serif;
}

html, body {
    width: 100%;
    height: 100%;
    margin: 0;
    padding: 0;
    overflow-x: hidden;
}

/* Softer Background */
body {
    background: linear-gradient(135deg, #a0c4ff, #f6e1a4); /* Soft pastel gradient */
    background-attachment: fixed;
    display: flex;
    color: #333;
    min-height: 100vh;
    line-height: 1.6;
}

/* Sidebar */
.sidebar {
    width: 280px;
    background: #34495e; /* Muted dark gray-blue */
    color: #ecf0f1;
    padding: 40px 20px;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    box-shadow: 4px 0 8px rgba(0, 0, 0, 0.1);
    transition: width 0.3s ease;
    z-index: 100;
    border-radius: 0 10px 10px 0;
}

/* Sidebar Image Hover Effect */
.sidebar img {
    width: 120px;
    height: 120px;
    border-radius: 50%;
    margin-bottom: 30px;
    object-fit: cover;
    border: 4px solid #3498db;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease;
}

.sidebar img:hover {
    transform: scale(1.05); /* Slight zoom on hover */
    box-shadow: 0 0 8px rgba(52, 152, 219, 0.5); /* Softer glow effect */
}

.sidebar h2 {
    font-size: 22px;
    margin-bottom: 20px;
    text-align: center;
    color: #fff;
    font-weight: 700;
}

.sidebar ul {
    list-style: none;
    width: 100%;
    padding: 0;
}

.sidebar ul li {
    width: 100%;
    margin-bottom: 15px;
}

.sidebar ul li a {
    text-decoration: none;
    color: #ecf0f1;
    font-size: 18px;
    display: block;
    padding: 12px 20px;
    border-radius: 8px;
    transition: all 0.3s ease;
    width: 100%;
}

.sidebar ul li a:hover {
    background-color: #3498db;
    transform: scale(1.02); /* Slightly larger effect on hover */
}

/* Main Content */
.main-content {
    margin-left: 280px;
    padding: 40px;
    width: calc(100% - 280px);
    display: flex;
    flex-direction: column;
    gap: 25px;
}

/* Header */
.header {
    background: #3498db;
    color: #fff;
    padding: 25px;
    border-radius: 15px;
    text-align: center;
    margin-bottom: 25px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.05);
}

/* Info Boxes */
.info-boxes {
    display: flex;
    justify-content: space-between;
    gap: 20px;
    flex-wrap: wrap;
}

.info-box {
    background: #ecf0f1;
    color: #333;
    flex: 1 1 calc(33.333% - 20px);
    padding: 25px;
    border-radius: 10px;
    text-align: center;
    box-shadow: 4px 4px 8px rgba(0, 0, 0, 0.1);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    overflow: hidden;
}

.info-box:hover {
    transform: translateY(-6px); /* Smaller hover effect */
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
}

.info-box .icon {
    font-size: 50px;
    margin-bottom: 20px;
    color: #3498db;
}

.info-box h2 {
    font-size: 20px;
    font-weight: 700;
    margin-bottom: 10px;
}

/* Scrollbar Styling */
body::-webkit-scrollbar {
    width: 8px;
}

body::-webkit-scrollbar-thumb {
    background: #3498db;
    border-radius: 10px;
}

body::-webkit-scrollbar-thumb:hover {
    background: #2980b9;
}

/* Responsive Design */
@media screen and (max-width: 1024px) {
    .sidebar {
        width: 250px;
    }

    .main-content {
        margin-left: 250px;
        width: calc(100% - 250px);
    }
}

@media screen and (max-width: 768px) {
    .sidebar {
        width: 80px;
    }

    .main-content {
        margin-left: 80px;
        width: calc(100% - 80px);
    }

    .sidebar h2, .sidebar ul li a span {
        display: none;
    }

    .info-box {
        flex: 1 1 calc(50% - 20px);
    }
}

@media screen and (max-width: 480px) {
    .sidebar {
        width: 60px;
    }

    .main-content {
        margin-left: 60px;
        width: calc(100% - 60px);
        padding: 15px;
    }

    .info-box {
        flex: 1 1 100%;
    }
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
            <!-- <li><a href="#"><i class="fas fa-user-cog"></i> Manajemen Admin</a></li> -->
            <li><a href="riwayat.php"><i class="fas fa-history"></i> Data Absensi</a></li>
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
            if(idleTime>=20000){
                window.location.href='../admin/logout.php';
            }
            
        }, 1000);
    </script>
</body>
</html>
