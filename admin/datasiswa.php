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

// Handle form submission
if (isset($_POST['submit'])) {
    $nis = $_POST['nis'];
    $nama = $_POST['nama'];
    $email_siswa = $_POST['email'];
    $password = $_POST['password'];
    $kelas = $_POST['kelas'];

    // Check if email already exists
    $sql = "SELECT * FROM user WHERE email='$email_siswa'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows === 0) {
        // Insert new student data
        $sql = "INSERT INTO user (nis, nama, kelas, email, password) VALUES ('$nis', '$nama', '$kelas', '$email_siswa', '$password')";
        if ($conn->query($sql)) {
            echo "<script>alert('Selamat, registrasi berhasil!');</script>";
        } else {
            echo "<script>alert('Woops! Terjadi kesalahan.');</script>";
        }
    } else {
        echo "<script>alert('Woops! Email sudah terdaftar.');</script>";
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
        /* Reset dan styling dasar */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #a0c4ff, #f6e1a4);
            background-attachment: fixed;
            display: flex;
            color: #333;
            min-height: 100vh;
            line-height: 1.6;
        }

        /* Sidebar */
        .sidebar {
            width: 280px;
            background: #34495e;
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
            z-index: 100;
            border-radius: 0 10px 10px 0;
        }

        .sidebar img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            margin-bottom: 30px;
            object-fit: cover;
            border: 4px solid #3498db;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
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

        /* Konten utama */
        .main-content {
            margin-left: 280px;
            padding: 20px;
            width: calc(100% - 280px);
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .header {
            background-color: #2980B9;
            color: #fff;
            padding: 30px;
            border-radius: 8px;
            text-align: center;
        }

        /* Wrapper konten tabel dan form */
        .content-wrapper {
            display: flex;
            gap: 20px;
        }

        /* Tabel */
        .table-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            flex: 1;
        }

        .table-container h2 {
            font-size: 24px;
            color: #333;
            margin-bottom: 15px;
            text-align: center;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table th, .data-table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .data-table th {
            background-color: #3498DB;
            color: #fff;
        }

        /* Form */
        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 300px;
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
        #kelas-select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    background-color: #fff;
    font-size: 16px;
    color: #333;
    margin-bottom: 20px;
    cursor: pointer;
}

#kelas-select option {
    padding: 10px;
    font-size: 16px;
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#kelas-select').change(function() {
                var selectedKelas = $(this).val();
                $.ajax({
                    url: 'fetch-siswa.php', // URL to the PHP file that fetches students
                    type: 'POST',
                    data: {kelas: selectedKelas},
                    success: function(data) {
                        $('#student-table-body').html(data);
                    }
                });
            });
        });
    </script>
</head>
<body>

    <div class="sidebar">
        <img src="logo.png" alt="Admin">
        <h2>Admin : <?= htmlspecialchars($admin['nama']); ?></h2>
        <ul>
            <li><a href="admin.php"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="#"><i class="fas fa-user-check"></i> Data Siswa</a></li>
            <!-- <li><a href="#"><i class="fas fa-user-cog"></i> Manajemen Admin</a></li> -->
            <li><a href="riwayat.php"><i class="fas fa-history"></i> Data Absensi</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>Data Siswa SMKN 71 Jakarta</h1>
            <p>Dashboard for managing student attendance and admin settings</p>
        </div>

        <div class="content-wrapper">
            <div class="table-container">
                <h2>Data Siswa</h2>
                <select id="kelas-select">
                    <option value="">Select Kelas</option>
                    <option value="X RPL 1">X RPL 1</option>
                    <option value="X RPL 2">X RPL 2</option>
                    <option value="X DKV 1">X DKV 1</option>
                    <option value="X DKV 2">X DKV 2</option>
                    <option value="X ANM 1">X ANM 1</option>
                    <option value="X ANM 2">X ANM 2</option>
                    <option value="XI RPL 1">XI RPL 1</option>
                    <option value="XI RPL 2">XI RPL 2</option>
                    <option value="XI DKV 1">XI DKV 1</option>
                    <option value="XI DKV 2">XI DKV 2</option>
                    <option value="XI ANM 1">XI ANM 1</option>
                    <option value="XI ANM 2">XI ANM 2</option>
                    <option value="XII RPL">XII RPL</option>
                    <option value="XII DKV">XII DKV</option>
                    <option value="XII ANM">XII ANM</option>
                </select>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="student-table-body">
                        <!-- Student data will be injected here via AJAX -->
                    </tbody>
                </table>
            </div>

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
                            <option value="XI DKV 2">XI DKV 2</option>
                            <option value="XI ANM 1">XI ANM 1</option>
                            <option value="XI ANM 2">XI ANM 2</option>
                            <option value="XII RPL">XII RPL</option>
                            <option value="XII DKV">XII DKV</option>
                            <option value="XII ANM">XII ANM</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" required>
                    </div>

                    <button type="submit" class="submit-btn" name="submit">Submit</button>
                    <!-- Edit Student Modal -->


                </form>
            </div>
        </div>
    </div>

</body>
</html>
