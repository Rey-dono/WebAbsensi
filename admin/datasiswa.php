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
            width: calc(100% - 250px);
            display: flex;
            flex-direction: column; /* Stack the header vertically */
            gap: 20px; /* Add spacing between elements */
        }

        .header {
            background-color: #2980B9;
            color: #fff;
            padding: 30px;
            border-radius: 8px;
            text-align: center;
        }

        /* Flex container for table and form */
        .content-wrapper {
            display: flex;
            gap: 20px; /* Space between table and form */
        }

        /* Table container styling */
        .table-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            flex: 1; /* Allow the table to take available space */
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

        /* Form container styling */
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
        .edit-btn, .delete-btn {
        color: #2980B9;
        margin-right: 10px;
        text-decoration: none;
    }

    .edit-btn:hover {
        color: #3498DB;
    }

    .delete-btn {
        color: #e74c3c;
    }

    .delete-btn:hover {
        color: #c0392b;
    }
    /* Style the select dropdown */
#kelas-select, 
#kelas {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    margin-bottom: 20px;
    background-color: #f9f9f9;
    color: #333;
    font-size: 16px;
    cursor: pointer;
}

/* Add custom dropdown arrow */
#kelas-select::after, 
#kelas::after {
    content: "▼";
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    color: #2980B9;
}

/* Style individual options in select (limited) */
#kelas-select option,
#kelas option {
    background-color: #f4f4f9;
    color: #333;
    padding: 8px;
}
.password-container {
            position: relative;
            width: 100%;
        }

        .password-container input {
            width: 100%;
            padding-right: 40px;
        }

        .password-container .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #555;
        }
        .password-container {
            position: relative;
            width: 100%;
        }

        .password-container input {
            width: 100%;
            padding-right: 40px;
        }

        .password-container .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #555;
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
