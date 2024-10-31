<?php
session_start();
include '../../all/connection.php';

if (!isset($_SESSION['email'])) {
    header("location: ../../login-done/login71.php");
}

$email = $_SESSION['email'];

// Fetch user data based on email
$banyak_siswa = $conn->query("SELECT * FROM user WHERE email = '$email'");

// Store user data in an array
$siswa = [];
if ($row = $banyak_siswa->fetch_assoc()) {
    $siswa = $row; // Store the first (and expected only) result
}

// Fetch history data with join, sorted by the most recent 'waktu'
$sql = "SELECT user.nis, user.nama, user.kelas, history.status, history.waktu
        FROM history
        JOIN user ON history.nis = user.nis 
        WHERE user.email = '$email'
        ORDER BY history.waktu DESC"; // Order by 'waktu' in descending order

$result = $conn->query($sql);

// Store history data in an array
$history_data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $history_data[] = $row;
    }
} else {
    echo "0 results";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presensi Kehadiran</title>
    <style>
        /* Reset dasar */
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
            <p>Welcome, <?= htmlspecialchars($siswa['nama']); ?>..</p> <!-- Personalized welcome message -->
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
        </div>
    </div>
</body>
</html>
