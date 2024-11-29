<?php
session_start();
include '../all/connection.php';

if (!isset($_SESSION['email'])) {
    header("location: ../login-done/login71.php");
    exit();
}

$email = $_SESSION['email'];
$kelas = isset($_POST['kelas']) ? $_POST['kelas'] : "";
$date = isset($_POST['date']) ? $_POST['date'] : "";

if ($kelas && $date) {
    $today = date("Y-m-d");

    if ($date === $today) {
        // Query for today's data from `user` table
        $query = "SELECT nis, nama, kelas, status, waktu, surat 
                  FROM user 
                  WHERE kelas = '$kelas' AND email != '$email' 
                  ORDER BY nis";
    } else {
        // Query for historical data from `history` table joined with `user`
        $query = "SELECT user.nis, user.nama, user.kelas, history.status, history.waktu 
                  FROM user
                  JOIN history ON user.id = history.id_user
                  WHERE user.kelas = '$kelas' AND DATE(history.waktu) = '$date'";
    }

    $result = $conn->query($query);

    if (!$result) {
        echo "<tr><td colspan='7'>Query Error: " . $conn->error . "</td></tr>";
    } elseif ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['nis']}</td>
                    <td>{$row['nama']}</td>
                    <td>{$row['kelas']}</td>
                    <td>{$row['status']}</td>
                    <td>{$row['waktu']}</td>";

            // Handle the 'surat' column dynamically
            if (isset($row['surat'])) {
                echo "<td><img width='200' src='../user/img/surat/{$row['surat']}' /></td>";
            } else {
                echo "<td>-</td>"; // Display a placeholder if 'surat' is not available
            }

            echo "<td>
                    <a href='edit-riwayat.php?nis={$row['nis']}&waktu={$row['waktu']}' class='edit-btn'>
                        <i class='fas fa-edit'></i>
                    </a>
                    <a href='delete.php?nis={$row['nis']}' class='delete-btn' onclick='return confirm(\"Are you sure you want to delete this record?\");'>
                        <i class='fas fa-trash-alt'></i>
                    </a>
                  </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='7'>No data available for the selected class and date.</td></tr>";
    }
} else {
    echo "<tr><td colspan='7'>Please select both a class and a date.</td></tr>";
}
?>
