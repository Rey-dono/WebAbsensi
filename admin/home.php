<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presence Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
         @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap');
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Poppins', sans-serif;
            display: flex;
            min-height: 100vh;
            background-color: #3c3a42;
        }
        .sidebar {
            width: 200px;
            background-color: #cfcfcf;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: all 0.3s ease;
        }
        .sidebar .profile-icon img {
            border-radius: 50%;
        }
        .sidebar ul {
            list-style: none;
            margin-top: 20px;
        }
        .sidebar li {
            margin: 15px 0;
            color: #333;
            font-weight: bold;
            cursor: pointer;
            transition: color 0.3s;
        }
        .sidebar li:hover {
            color: #555;
        }
        .main-content {
            flex: 1;
            padding: 20px;
            color: #fff;
            display: flex;
            flex-direction: column;
        }
        .welcome-card {
            background-color: #5a565d;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 20px;
            animation: fadeIn 1s ease;
        }
        .stats {
            display: flex;
            gap: 15px;
            margin-bottom: 20px;
        }
        .stat-card {
            background-color: #a3a1a5;
            padding: 15px;
            border-radius: 10px;
            flex: 1;
            text-align: center;
            color: #333;
            font-weight: bold;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            transition: transform 0.3s, background-color 0.3s;
        }
        .stat-card:hover {
            transform: scale(1.05);
            background-color: #888;
        }
        .stat-icon {
            background-color: #69a7f5;
            color: #fff;
            padding: 10px;
            border-radius: 50%;
            font-size: 24px;
        }
        .content-boxes {
            display: flex;
            gap: 20px;
        }
        .content-box {
            flex: 1;
            background-color: #e5e5e5;
            padding: 20px;
            border-radius: 10px;
            height: 150px;
            transition: background-color 0.3s, transform 0.3s;
        }
        .content-box:hover {
            background-color: #d1d1d1;
            transform: scale(1.02);
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="profile-icon">
            <img src="https://via.placeholder.com/60" alt="User Icon">
        </div>
        <ul>
            <li>HOME</li>
            <li>ABSENSI SISWA</li>
            <li>RIWAYAT ABSEN</li>
            <li>LOGOUT</li>
        </ul>
    </div>
    <div class="main-content">
        <div class="welcome-card">
            <h1>Welcome Admin!</h1>
            <p>To our presence website</p>
        </div>
        <div class="stats">
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-user-graduate"></i></div>
                <p>JUMLAH PESERTA DIDIK</p>
                <h2>526</h2>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                <p>JUMLAH GURU</p>
                <h2>28</h2>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-school"></i></div>
                <p>JUMLAH KELAS</p>
                <h2>18</h2>
            </div>
        </div>
        <div class="content-boxes">
            <div class="content-box"></div>
            <div class="content-box"></div>
        </div>
    </div>
</body>
</html>
