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
    <style>* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif; /* Modern font */
    text-decoration: none;
}

/* Background for the entire page */
body {
    background: linear-gradient(135deg, #1e3c72, #2a5298); /* Gradient background */
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    color: #fff;
    font-size: 1rem;
}

/* Main container with a cool shadow effect */
.container {
    background: rgba(255, 255, 255, 0.1); /* Transparent background */
    border-radius: 20px;
    padding: 30px;
    box-shadow: 0 10px 50px rgba(0, 0, 0, 0.2);
    text-align: center;
    width: 80%;
    max-width: 1200px;
    backdrop-filter: blur(10px); /* Cool blur effect */
    border: 1px solid rgba(255, 255, 255, 0.3); /* Subtle border */
}

/* Title with a glowing effect */
h1 {
    margin-bottom: 20px;
    color: #f39c12;
    text-transform: uppercase;
    letter-spacing: 5px;
    font-size: 3rem;
    text-shadow: 0 0 15px rgba(255, 255, 255, 0.8);
}

/* Status container with a hover scale effect */
.status-container {
    display: flex;
    justify-content: space-around;
    margin-bottom: 30px;
    margin-top: 20px;
}

.status {
    width: 150px;
    height: 150px;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 50%;
    font-size: 2rem;
    font-weight: bold;
    color: #fff;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.3);
    cursor: pointer;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

/* Hover effect for status buttons */
.status:hover {
    transform: scale(1.1);
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.5);
}

/* Unique colors for each status */
.hadir {
    background: linear-gradient(45deg, #2ecc71, #27ae60);
}

.izin {
    background: linear-gradient(45deg, #f1c40f, #f39c12);
}

.sakit {
    background: linear-gradient(45deg, #e74c3c, #c0392b);
}

/* Table styling */
.schedule {
    background-color: #3498db;
    display: inline-block;
    padding: 20px;
    border-radius: 10px;
    color: #fff;
    font-size: 1.5rem;
    width: 100%;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.4);
}

.schedule table {
    border-collapse: collapse;
    width: 100%;
}

.schedule th, .schedule td {
    border: 1px solid #fff;
    padding: 15px;
    text-align: center;
    font-size: 1rem;
    transition: background-color 0.3s;
}

/* Hover effect for table rows */
.schedule tr:hover {
    background-color: rgba(255, 255, 255, 0.1);
}

/* Pagination container */
.pagination {
    display: flex;
    justify-content: center;
    margin-top: 20px;
}

.pagination a {
    color: #fff;
    padding: 12px 20px;
    margin: 0 5px;
    text-decoration: none;
    font-weight: bold;
    border: 2px solid #fff;
    border-radius: 10px;
    transition: background-color 0.3s, color 0.3s;
}

/* Pagination link hover and active states */
.pagination a:hover {
    background-color: #f39c12;
    color: #fff;
    border-color: #f39c12;
}

.pagination a.active {
    background-color: #27ae60;
    color: #fff;
    border-color: #27ae60;
}

/* Disabled pagination link */
.pagination a.disabled {
    pointer-events: none;
    color: #7f8c8d;
    background-color: #95a5a6;
    border-color: #95a5a6;
}
+

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
