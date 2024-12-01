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
        }

        body {
            background-color: #f7f7f7;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            background-color: #ffffff;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 100%;
            max-width: 1000px;
        }

        h1 {
            margin-bottom: 20px;
            color: #333;
            font-size: 2rem;
        }

        .status-container {
            display: flex;
            justify-content: space-between;
            margin: 30px 0;
        }

        .status {
            flex: 1;
            margin: 0 10px;
            padding: 20px;
            border-radius: 10px;
            color: #fff;
            font-size: 1.5rem;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.3s, background-color 0.3s;
            text-align: center;
        }

        .status:hover {
            transform: scale(1.05);
        }

        .hadir {
            background-color: #2ecc71;
        }

        .izin {
            background-color: #f1c40f;
        }

        .sakit {
            background-color: #e74c3c;
        }

        .schedule {
            margin: 30px 0;
            text-align: left;
            overflow-x: auto;
        }

        .schedule p {
            font-size: 1.2rem;
            margin-bottom: 20px;
            color: #555;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            border: 1px solid #ddd;
        }

        th, td {
            padding: 15px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #007bff;
            color: #fff;
        }

        .pagination {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 10px;
        }

        .pagination a {
            padding: 10px 15px;
            border: 1px solid #007bff;
            border-radius: 5px;
            color: #007bff;
            text-decoration: none;
            transition: all 0.3s;
        }

        .pagination a:hover {
            background-color: #007bff;
            color: #fff;
        }

        .pagination a.disabled {
            pointer-events: none;
            color: #ccc;
            border-color: #ccc;
        }

        .pagination a.active {
            background-color: #007bff;
            color: #fff;
        }


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
