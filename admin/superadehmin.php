<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <!-- Tambahkan Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
         @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            background-color: #4D4D56;
        }
        .sidebar {
            width: 250px;
            background-color: #D3D3D3;
            height: 100vh;
            position: fixed;
            padding: 20px;
        }
        .sidebar img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            margin-bottom: 20px;
        }
        .sidebar ul {
            list-style-type: none;
            padding: 0;
        }
        .sidebar ul li {
            margin: 20px 0;
        }
        .sidebar ul li a {
            text-decoration: none;
            color: black;
            font-size: 18px;
            font-weight: bold;
        }
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }
        .header {
            background-color: #6B6566;
            padding: 20px;
            color: white;
            border-radius: 15px;
            text-align: center;
        }
        .info-boxes {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .info-box {
            background-color: #8D8A8B;
            width: 20%;
            padding: 10px;
            border-radius: 15px;
            text-align: center;
            color: white;
            position: relative;
        }
        .info-box h2 {
            font-size: 18px;
        }
        .info-box p {
            font-size: 40px;
            margin: 0;
        }
        .info-box .icon {
            position: absolute;
            top: -20px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #84C2FF;
            padding: 20px;
            border-radius: 50%;
            font-size: 24px;
            color: white;
        }
        .content-boxes {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .content-box {
            background-color: #F0F0F0;
            width: 35%;
            padding: 50px;
            border-radius: 15px;
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <img src="https://via.placeholder.com/50" alt="Admin">
        <ul>
            <li><a href="#">HOME</a></li>
            <li><a href="#">ABSENSI SISWA</a></li>
            <li><a href="#">MANAJEMEN ADMIN</a></li>
            <li><a href="#">RIWAYAT ABSEN</a></li>
            <li><a href="#">LOGOUT</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>Welcome SuperAdmin!</h1>
            <p>To our presence website</p>
        </div>

        <div class="info-boxes">
            <div class="info-box">
                <div class="icon"><i class="fas fa-users"></i></div>
                <h2>JUMLAH PESERTA DIDIK</h2>
                <p>
                    <?php 
                    // Dummy data untuk peserta didik
                    echo 526; 
                    ?>
                </p>
            </div>
            <div class="info-box">
                <div class="icon"><i class="fas fa-user-tie"></i></div>
                <h2>JUMLAH GURU</h2>
                <p>
                    <?php 
                    // Dummy data untuk guru
                    echo 28; 
                    ?>
                </p>
            </div>
            <div class="info-box">
                <div class="icon"><i class="fas fa-chalkboard-teacher"></i></div>
                <h2>JUMLAH KELAS</h2>
                <p>
                    <?php 
                    // Dummy data untuk kelas
                    echo 18; 
                    ?>
                </p>
            </div>
        </div>

        <div class="content-boxes">
            <div class="content-box"></div>
            <div class="content-box"></div>
        </div>
    </div>

</body>
</html>