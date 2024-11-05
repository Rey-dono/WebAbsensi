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
        $query = "SELECT nis, nama, kelas, status, waktu 
                  FROM user 
                  WHERE kelas = '$kelas' AND email != '$email' 
                  ORDER BY nis";
    } else {
        // Query for historical data from `history` table joined with `user`
        $query = "SELECT user.nis, user.nama, user.kelas, history.status, history.waktu
                  FROM history
                  JOIN user ON history.nis = user.nis 
                  WHERE user.kelas = '$kelas' AND history.waktu = '$date'
                  ORDER BY history.waktu";
    }

    $result = $conn->query($query);

    // Check for query execution errors
    if (!$result) {
        echo "<tr><td colspan='6'>Query Error: " . $conn->error . "</td></tr>";
    } elseif ($result->num_rows > 0) {
        // Display data if rows are found
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['nis']}</td>
                    <td>{$row['nama']}</td>
                    <td>{$row['kelas']}</td>
                    <td>{$row['status']}</td>
                    <td>{$row['waktu']}</td>
                    <td>
                        <a href='edit-absen.php?nis={$row['nis']}' class='edit-btn'>
                            <i class='fas fa-edit'></i>
                        </a>
                        <a href='delete.php?nis={$row['nis']}' class='delete-btn' onclick='return confirm(\"Are you sure you want to delete this record?\");'>
                            <i class='fas fa-trash-alt'></i>
                        </a>
                    </td>
                  </tr>";
        }
    } else {
        // Display message if no data is found
        echo "<tr><td colspan='6'>No data available for the selected class and date.</td></tr>";
    }
} else {
    // Prompt user to select both class and date if either is missing
    echo "<tr><td colspan='6'>Please select both a class and a date.</td></tr>";
}
?>
