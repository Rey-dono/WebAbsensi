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
            background-color: #fff; /* Set background to white */
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
            justify-content: space-between; /* Add spacing between status boxes */
            margin-bottom: 30px;
            margin-top: 20px;
        }

        .status {
            width: 150px; /* Reduced size of the divs */
            height: 150px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 10px;
            font-size: 1.5rem; /* Smaller font size */
            font-weight: bold;
            color: #fff;
            cursor: pointer; /* Make the div clickable */
        }
        .status-container {
    display: flex;
    justify-content: space-around; /* Adjust to space out evenly */
    margin-bottom: 30px;
    margin-top: 20px;
}

.status {
    width: 120px; /* Adjusted size for better spacing */
    height: 120px;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 10px;
    font-size: 1.2rem; /* Adjusted for smaller font size */
    font-weight: bold;
    color: white;
    cursor: pointer;
    background-color: #f0e6d6; /* White-gading background */
}

.status.hadir {
    color: #3498db; /* Blue text color for "Hadir" */
}

.status.izin {
    color: #e74c3c; /* Red text color for "Izin" */
}

.status.sakit {
    color: #f39c12; /* Orange text color for "Sakit" */
}

        /* Warna status */
        .hadir {
            background-color: #2ecc71;
        }

        .izin {
            background-color: #f1c40f;
        }

        .sakit {
            background-color: red;
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
        /* Styling for the student data table */
.student-table {
    margin-top: 20px;
    width: 100%; /* Full width for the table */
    border-collapse: collapse; /* Collapse borders for a cleaner look */
}

.student-table th, .student-table td {
    padding: 15px;
    text-align: center; /* Center align for better readability */
    border: 1px solid #ddd; /* Light gray border for table cells */
}

.student-table th {
    background-color: #2d5d34; /* Dark green background for the header */
    color: white; /* White text for header */
    font-weight: bold; /* Bold text for the header */
}

.student-table tr:nth-child(even) {
    background-color: #f9f9f9; /* Alternating row colors for better readability */
}

.student-table tr:hover {
    background-color: #f1f1f1; /* Highlight row on hover */
}

.student-table td {
    font-size: 1rem; /* Slightly smaller font size for better fit */
    color: #333; /* Darker text color for readability */
}

/* Styling for pagination */
.pagination a {
    color: #2d5d34; /* Dark green text */
    padding: 8px 12px; /* Reduced padding for smaller button size */
    margin: 0 5px;
    text-decoration: none;
    font-weight: bold;
    border: 1px solid #2d5d34; /* Dark green border */
    border-radius: 5px;
    transition: background-color 0.3s, color 0.3s;
}

.pagination a:hover {
    background-color: #2d5d34; /* Dark green background on hover */
    color: #fff; /* White text */
    border-color: #2d5d34;
}

.pagination a.active {
    background-color: #2d5d34; /* Darker green for active page */
    color: #fff;
    border-color: #2d5d34;
}

.pagination a.disabled {
    pointer-events: none;
    color: #999; /* Lighter color for disabled state */
    border-color: #999; /* Lighter border */
    background-color: #f0f0f0; /* Light background */
}

    </style>
</head>

<body>
    <div class="container">
        <h1>PRESENSI KEHADIRAN</h1>

        <div class="status-container">
            <a href="hadir.php">
                <div class="status hadir">
                    <img src="path_to_image/hadir.png" alt="Hadir" style="width: 80px; height: 80px;">
                    Hadir
                </div>
            </a>
            <a href="izin.php">
                <div class="status izin">
                    <img src="path_to_image/izin.png" alt="Izin" style="width: 80px; height: 80px;">
                    Izin
                </div>
            </a>
            <a href="sakit.php">
                <div class="status sakit">
                    <img src="sakit.png" alt="Sakit" style="width: 80px; height: 80px;">
                    Sakit
                </div>
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
