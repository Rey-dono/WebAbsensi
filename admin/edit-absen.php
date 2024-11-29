<?php
include '../all/connection.php'; // Include the database connection

// Initialize variables with default values
$id = $nis = $waktu = $status = '';

// Check if an ID was provided to load data for editing
if (isset[($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch the current record from the `history` table based on the `id`
    $query = "SELECT * FROM history WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the record exists
    if ($result->num_rows > 0) {
        $data = $result->fetch_assoc();
        $nis = $data['nis'];
        $waktu = $data['waktu'];
        $status = $data['status'];
    } else {
        echo "Data not found.";
        exit;
    }
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $conn->real_escape_string($_POST['id']);
    $nis = $conn->real_escape_string($_POST['nis']);
    $waktu = $conn->real_escape_string($_POST['waktu']);
    $status = $conn->real_escape_string($_POST['status']);
    
    // Convert waktu to the correct MySQL timestamp format
    $waktu = date('Y-m-d H:i:s', strtotime($waktu));
    
    // Debugging: Check the prepared statement and values
    echo "ID: $id, NIS: $nis, Waktu: $waktu, Status: $status<br>";

    // Prepare and execute the update query
    $query = "UPDATE history SET waktu = ?, status = ? WHERE nis = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $waktu, $status, $id);

    if ($stmt->execute()) {
        echo "Data siswa berhasil diperbarui.";
        header("Location: riwayat.php");
        exit;
    } else {
        echo "Error updating record: " . $stmt->error; // Output the error message
    }

    $stmt->close();
    $conn->close();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Data Siswa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
       * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body, html {
            height: 100%;
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
        }

        .container {
            display: flex;
            width: 100vw; /* Full viewport width */
            height: 100vh; /* Full viewport height */
            background-color: #fff;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .right-section {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            background-color: #d3d3d3;
            padding: 20px;
        }

        .edit-box {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 640px;
            height: 600px;
        }

        .form-table {
            width: 100%;
        }

        .form-table th, .form-table td {
            padding: 15px 0;
            text-align: left;
        }

        .form-table input, .form-table select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }

        .form-table input[readonly] {
            background-color: #f0f0f0;
            color: #888;
        }

        .form-table button {
            width: 100%;
            padding: 10px;
            border-radius: 25px;
            border: none;
            background-color: #72ADF0;
            color: white;
            font-size: 16px;
            cursor: pointer;
        }

        .form-table button:hover {
            opacity: 0.8;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="right-section">
        <div class="edit-box">
            <h1>Edit Data Siswa</h1>
            <form action="edit-absen.php?id=<?= htmlspecialchars($id); ?>" method="POST"> <!-- Pass ID in action -->
                <table class="form-table">
                    <tr>
                        <th>ID :</th>
                        <td><input type="number" name="id" value="<?= htmlspecialchars($id); ?>" readonly></td>
                    </tr>
                    <tr>
                        <th>NIS :</th>
                        <td><input type="number" name="nis" value="<?= htmlspecialchars($nis); ?>" readonly></td>
                    </tr>
                    <tr>
                        <th>Waktu :</th>
                        <td><input type="datetime-local" name="waktu" value="<?= htmlspecialchars(date('Y-m-d\TH:i', strtotime($waktu))); ?>" required></td>
                    </tr>
                    <tr>
                        <th>Status :</th>
                        <td>
                            <select name="status" required>
                                <option value="">Pilih Status</option>
                                <option value="Hadir" <?= $status == "Hadir" ? 'selected' : ''; ?>>Hadir</option>
                                <option value="Sakit" <?= $status == "Sakit" ? 'selected' : ''; ?>>Sakit</option>
                                <option value="Izin" <?= $status == "Izin" ? 'selected' : ''; ?>>Izin</option>
                                <option value="Alfa" <?= $status == "Alfa" ? 'selected' : ''; ?>>Alfa</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <button type="submit" name="simpan">Update Data</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>

</body>
</html>
