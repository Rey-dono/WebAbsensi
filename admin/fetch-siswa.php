<?php
include '../all/connection.php';

if (isset($_POST['kelas'])) {
    $kelas = $_POST['kelas'];
    
    // Fetch students for the selected class excluding those with the role 'admin' and order by NIS in ascending order
    $query = "SELECT nis, nama, kelas, email, password FROM user WHERE kelas = '$kelas' AND role != 'admin' ORDER BY nis ASC";
    $result = $conn->query($query);
    
    // Generate HTML table rows with icons for edit and delete
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['nis']}</td>
                    <td>{$row['nama']}</td>
                    <td>{$row['kelas']}</td>
                    <td>{$row['email']}</td>
                    <td>{$row['password']}</td>
                    <td>
                        <a href='edit.php?nis={$row['nis']}' class='edit-btn'>
                            <i class='fas fa-edit'></i>
                        </a>
                        <a href='delete.php?nis={$row['nis']}' class='delete-btn' onclick='return confirm(\"Are you sure you want to delete this record?\");'>
                            <i class='fas fa-trash-alt'></i>
                        </a>
                    </td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='6'>No data available</td></tr>";
    }
}
?>
