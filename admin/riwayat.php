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
            background: linear-gradient(135deg, #a0c4ff, #f6e1a4);
            background-attachment: fixed;
            display: flex;
            color: #333;
            min-height: 100vh;
            line-height: 1.6;
        }

/* Sidebar styling */
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

/* Main content styling */
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

/* Flex container for table and form */

.content-wrapper {
            display: flex;
            gap: 20px;
        }

/* Table container styling */
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
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    background-color: #f9f9f9;
    color: #333;
    font-size: 16px;
    margin-bottom: 20px;
    cursor: pointer;
}
/* Style untuk tombol Generate PDF */
.generate-pdf-btn {
    background-color: #28a745; /* Warna hijau untuk tombol */
    color: #fff;
    padding: 10px 20px;
    width: auto;
    border: none;
    border-radius: 4px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    text-align: center;
    display: inline-block;
}

/* Hover effect untuk tombol Generate PDF */
.generate-pdf-btn:hover {
    background-color: #218838; /* Warna hijau yang lebih gelap saat hover */
}

/* Tombol saat dalam keadaan disabled (misalnya, jika data belum dipilih) */
.generate-pdf-btn:disabled {
    background-color: #6c757d;
    cursor: not-allowed;
}

/* Tombol saat fokus */
.generate-pdf-btn:focus {
    outline: none;
    box-shadow: 0 0 5px rgba(40, 167, 69, 0.5); /* Warna hijau terang saat fokus */
}


/* Submit button */
.submit-btn {
    background-color: #2980B9;
    color: #fff;
    padding: 10px;
    width: 100%;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease;
}

.submit-btn:hover {
    background-color: #3498DB;
}

/* Edit and delete button styling */
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
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    margin-bottom: 20px;
    background-color: #f9f9f9;
    color: #333;
    font-size: 16px;
    cursor: pointer;
    transition: border-color 0.3s ease;
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

/* Style individual options in select */
#kelas-select option,
#kelas option {
    background-color: #f4f4f9;
    color: #333;
    padding: 8px;
}

/* Style submit select button */
#submit-select, 
#submit {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    background-color: #2980B9;
    color: #fff;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

/* Hover effect for the submit button */
#submit-select:hover, 
#submit:hover {
    background-color: #3498DB;
}

/* Password container styling */
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

/* Date input styling */
#date-input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    background-color: #f9f9f9;
    color: #333;
    font-size: 16px;
    margin-bottom: 20px;
    cursor: pointer;
}

#date-input::-webkit-calendar-picker-indicator {
    color: #2980B9;
    opacity: 0.6;
    cursor: pointer;
}

#date-input:focus {
    outline: none;
    border-color: #2980B9;
}


    </style>
</head>
<body>

    <div class="sidebar">
        <img src="logo.png" alt="Admin">
        <h2>Admin : <?= htmlspecialchars($admin['nama']); ?></h2>
        <ul>
            <li><a href="admin.php"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="datasiswa.php"><i class="fas fa-user-check"></i> Data Siswa</a></li>
            <li><a href="riwayat.php"><i class="fas fa-history"></i> Data Absensi</a></li>
            <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>Data Absensi SMKN 71 Jakarta</h1>
            <p>Dashboard for managing student attendance and admin settings</p>
        </div>

        <div class="content-wrapper">
            <div class="table-container">
                <h2>Data Absensi</h2>

                <form method="POST" id="attendance-form">
                <select id="kelas-select" name="kelas">
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
                <input id="date-input" name="date" type="date">
                <!-- <input type="submit" name="submit" id="submit"> -->
                <button type="submit" name="submit" id="submit">Submit</button>

                

                
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>NIS</th>
                            <th>Nama</th>
                            <th>Kelas</th>
                            <th>Status</th>
                            <th>Waktu</th>
                            <th>Surat</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody id="student-table-body">
                        <!-- Student data will be injected here via AJAX -->

                    </tbody>
                </table>
                </form>
                <form id="generate-pdf-form" action="pdf.php" method="post" target="_blank">
    <input type="hidden" name="kelas" id="hidden-kelas">
    <input type="hidden" name="date" id="hidden-date">
    <button id="generate-pdf-btn"  class="generate-pdf-btn">Generate PDF</button>

</form>


            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
 
    $(document).ready(function() {
        $('#attendance-form').on('submit', function(event) {
            event.preventDefault(); // Prevent the form from submitting the traditional way

            // Use AJAX to submit form data
            $.ajax({
                url: 'fetch-riwayat.php',
                type: 'POST',
                data: $(this).serialize(), // Send form data
                success: function(response) {
                    $('#student-table-body').html(response); // Insert response data into table body
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        });
    });
    $(document).ready(function() {
    // Handle tombol Submit (untuk memuat data ke tabel via AJAX)
    $('#attendance-form').on('submit', function(event) {
        event.preventDefault(); // Cegah submit form tradisional

        $.ajax({
            url: 'fetch-riwayat.php',
            type: 'POST',
            data: $(this).serialize(), // Kirim data form
            success: function(response) {
                $('#student-table-body').html(response); // Isi tabel dengan data dari server
            },
            error: function(xhr, status, error) {
                console.error('AJAX Error:', error);
            }
        });
    });

    // Handle tombol Generate PDF
    $('#generate-pdf-btn').on('click', function(event) {
        event.preventDefault(); // Cegah submit form tradisional

        // Ambil nilai dari dropdown dan input tanggal
        const kelas = $('#kelas-select').val();
        const date = $('#date-input').val();

        if (!kelas || !date) {
            alert('Pilih kelas dan tanggal terlebih dahulu.');
            return;
        }

        // Masukkan nilai ke hidden input di form PDF
        $('#hidden-kelas').val(kelas);
        $('#hidden-date').val(date);

        // Submit form PDF
        $('#generate-pdf-form').submit();
    });
});



</script>

</body>
</html>
