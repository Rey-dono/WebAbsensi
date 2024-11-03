<?php
include '../all/connection.php';

// Check if form was submitted and necessary data is present
if (isset($_POST['simpan']) && isset($_POST['nis'])) {
    // Retrieve the form data
    $nis = $_POST['nis'];
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];
    $email = $_POST['email'];

    // Prepare an SQL statement to update the data
    $query = "UPDATE user SET nama = ?, kelas = ?, email = ? WHERE nis = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssss", $nama, $kelas, $email, $nis); // Assuming all fields are strings

    // Execute the statement and check for success
    if ($stmt->execute()) {
        echo "Data berhasil diperbarui!";
        // Redirect to another page or display a success message
        header("Location: datasiswa.php");
        exit;
    } else {
        echo "Error updating data: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "Form not submitted or data missing.";
}

$conn->close();
?>
