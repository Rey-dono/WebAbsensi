<?php
session_start();
include '../../all/connection.php';

if (!isset($_SESSION['email'])) {
    header("location: ../../login-done/login71.php");
}

$email = $_SESSION['email'];

// Fetch user data based on email
$banyak_siswa = $conn->query("SELECT * FROM user WHERE email = '$email'");
$siswa = [];
if ($row = $banyak_siswa->fetch_assoc()) {
    $siswa = $row;
}

// Set pagination variables
$records_per_page = 4; // Maximum records per page set to 4
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Current page number
$offset = ($page - 1) * $records_per_page; // Calculate offset

// Fetch history data with pagination and sorting by 'waktu'
$sql = "SELECT user.nis, user.nama, user.kelas, history.status, history.waktu
        FROM history
        JOIN user ON history.nis = user.nis 
        WHERE user.email = '$email'
        ORDER BY history.waktu DESC
        LIMIT $offset, $records_per_page";
$result = $conn->query($sql);

// Store history data in an array
$history_data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $history_data[] = $row;
    }
}

// Get the total number of records for pagination
$total_records_query = "SELECT COUNT(*) AS total FROM history
                        JOIN user ON history.nis = user.nis 
                        WHERE user.email = '$email'";
$total_records_result = $conn->query($total_records_query);
$total_records = $total_records_result->fetch_assoc()['total'];
$total_pages = ceil($total_records / $records_per_page);

$conn->close();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presensi Kehadiran</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
            text-decoration: none;
        }

        /* Latar belakang halaman */
        body {
            background-color: #6c6666;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Container utama */
        .container {
            margin-top: 100px;
            background-color: #f9f9f9;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 80%; /* Adjusted for better responsiveness */
            max-width: 1200px; /* Maximum width */
        }

        /* Judul */
        h1 {
            margin-bottom: 20px;
            color: #000;
        }

        /* Kotak status */
        .status-container {
            display: flex;
            justify-content: space-around;
            margin-bottom: 30px;
            margin-top: 20px;
        }

        .status {
            width: 100px;
            height: 100px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 10px;
            background-color: #e0e0e0;
            font-size: 2rem;
            font-weight: bold;
            color: #fff;
        }

        /* Warna status */
        .hadir {
            background-color: #2ecc71;
            width: 350px;
            height: 350px;
        }

        .izin {
            background-color: #f1c40f;
            width: 350px;
            height: 350px;
        }

        .sakit {
            background-color: red;
            width: 350px;
            height: 350px;
        }

        /* Bagian jadwal */
        .schedule {
            background-color: #7abaff;
            display: inline-block;
            margin: auto;
            padding: 10px;
            border-radius: 10px;
            color: #fff;
            font-size: 2rem;
            width: 100%; /* Make the table responsive */
        }

        .schedule table {
            border-collapse: collapse;
            width: 100%; /* Full width for the table */
        }

        .schedule th, .schedule td {
            border: 1px solid gray; /* Border for the cells */
            padding: 20px;
            text-align: center; /* Center align for better readability */
        }

        /* Styles for the student data table */
        .student-table {
            margin-top: 20px;
            width: 100%; /* Full width for the table */
        }

        .student-table th {
            background-color: darkgreen; /* Light gray background for header */
        }

        /* Pagination container */
.pagination {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

/* Pagination links */
.pagination a {
    color: #2d5d34; /* Dark green text */
    padding: 10px 15px;
    margin: 0 5px;
    text-decoration: none;
    font-weight: bold;
    border: 1px solid #2d5d34; /* Dark green border */
    border-radius: 5px;
    transition: background-color 0.3s, color 0.3s;
}

/* Hover effect for pagination links */
.pagination a:hover {
    background-color: #2d5d34; /* Dark green background on hover */
    color: #fff; /* White text */
    border-color: #2d5d34;
}

/* Active page link */
.pagination a.active {
    background-color: #2d5d34; /* Darker green for active page */
    color: #fff;
    border-color: #2d5d34;
}

/* Disabled pagination link */
.pagination a.disabled {
    pointer-events: none;
    color: #999; /* Lighter color for disabled state */
    border-color: #999; /* Lighter border */
    background-color: #f0f0f0; /* Light background */
}

/* ini kerennnnnn */
    </style>
</head>

<body>
    <div class="container">
        <h1>PRESENSI KEHADIRAN</h1>

        <div class="status-container">
            <a href="hadir.php">
                <div class="status hadir">Hadir</div>
            </a>
            <a href="izin.php">
                <div class="status izin">Izin</div>
            </a>
            <a href="sakit.php">
                <div class="status sakit">Sakit</div>
            </a>
        </div>

        <div class="schedule">
            <p>Welcome, <?= htmlspecialchars($siswa['nama']); ?>..</p>
            <table class="student-table">
                <thead>
                    <tr>
                        <th>NIS</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Status</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($history_data as $data): ?>
                    <tr>
                        <td><?= htmlspecialchars($data['nis']) ?></td>
                        <td><?= htmlspecialchars($data['nama']) ?></td>
                        <td><?= htmlspecialchars($data['kelas']) ?></td>
                        <td><?= htmlspecialchars($data['status']) ?></td>
                        <td><?= htmlspecialchars($data['waktu']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <!-- Pagination links -->
            <!-- Pagination links -->
<div class="pagination">
    <!-- Previous Button -->
    <a href="?page=<?= $page - 1 ?>" class="<?= $page <= 1 ? 'disabled' : '' ?>">Previous</a>

    <!-- Page Number Links -->
    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <a href="?page=<?= $i ?>" <?= $i === $page ? 'class="active"' : '' ?>><?= $i ?></a>
    <?php endfor; ?>

    <!-- Next Button -->
    <a href="?page=<?= $page + 1 ?>" class="<?= $page >= $total_pages ? 'disabled' : '' ?>">Next</a>
</div>

        </div>
    </div>
</body>
</html>
