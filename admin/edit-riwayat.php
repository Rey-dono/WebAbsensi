<?php
session_start();
include '../all/connection.php';

if (!isset($_SESSION['email'])) {
    header("location: ../login-done/login71.php");
    exit();
}

$nis = isset($_GET['nis']) ? $_GET['nis'] : "";

if ($nis) {
    // Check if this record is from today or a past date
    $today = date("Y-m-d");

    // Retrieve the record data from either the `user` or `history` table
    $queryToday = "SELECT nis, nama, kelas, status, waktu 
                   FROM user 
                   WHERE nis = '$nis' AND DATE(waktu) = '$today'";

    $resultToday = $conn->query($queryToday);
    $isToday = ($resultToday && $resultToday->num_rows > 0);

    if ($isToday) {
        $record = $resultToday->fetch_assoc();
    } else {
        // If it's a past record, retrieve data from the `history` table
        $queryHistory = "SELECT user.nis, user.nama, user.kelas, history.status, history.waktu
                         FROM user
                         JOIN history ON user.id = history.id_user
                         WHERE user.nis = '$nis'";
                         
        $resultHistory = $conn->query($queryHistory);
        if ($resultHistory && $resultHistory->num_rows > 0) {
            $record = $resultHistory->fetch_assoc();
        }
    }

    if (isset($_POST['simpan'])) {
        $nama = $_POST['nama'];
        $kelas = $_POST['kelas'];
        $status = $_POST['status'];
        $waktu = $_POST['waktu'];

        if ($isToday) {
            // Update today's record in the `user` table
            $updateQuery = "UPDATE user 
                            SET nama = '$nama', kelas = '$kelas', status = '$status', waktu = '$waktu' 
                            WHERE nis = '$nis'";
        } else {
            // Update historical record in the `history` table
            $updateQuery = "UPDATE history 
                            JOIN user ON user.id = history.id_user
                            SET user.nama = '$nama', user.kelas = '$kelas', history.status = '$status', history.waktu = '$waktu'
                            WHERE user.nis = '$nis'";
        }

        if ($conn->query($updateQuery)) {
            // Redirect to avoid resubmission on refresh
            header("location: riwayat.php");
            exit();
        } else {
            echo "Error updating record: " . $conn->error;
        }
    }
} else {
    echo "No record specified.";
    exit();
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
            width: 100%;
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            display: flex;
            width: 100%;
            height: 100vh;
            background-color: #fff;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            /* border-radius: 10px; */
            overflow: hidden;
        }

        .left-section {
            width: 60%;
            background-color: #665F63;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
            position: relative;
        }

        .left-section h1 {
            position: absolute;
            top: 20px;
            left: 20px;
            color: white;
            font-size: 28px;
        }

        .left-section img {
            max-width: 80%;
            height: auto;
        }

        .right-section {
            width: 40%;
            background-color: #d3d3d3;
            display: flex;
            justify-content: center;
            align-items: center;
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

        h1 {
            font-size: 24px;
            color: #333;
            text-align: center;
            margin-bottom: 30px;
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
        .password-container {
            position: relative;
            width: 100%;
        }

        .password-container input {
            width: 100%;
            padding-right: 40px;
        }

        .password-container .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #555;
        }
    </style>
</head>
<body>
<?php if ($record): ?>
    <div class="container">
        <div class="left-section">
            <h1>Edit Data Siswa</h1>
            <img src="computer.png" alt="Update Illustration">
        </div>

        <div class="right-section">
            <div class="edit-box">
                <h1>Edit Data Siswa</h1>
                <form method="POST">
                    <table class="form-table">
                        <tr>
                            <th>NIS :</th>
                            <td><input type="text" name="nis" value="<?= htmlspecialchars($record['nis']); ?>" readonly></td>
                        </tr>
                        <tr>
                            <th>Nama :</th>
                            <td><input type="text" name="nama" placeholder="Masukkan Nama" value="<?= htmlspecialchars($record['nama']); ?>" required></td>
                        </tr>
                        <tr>
                            <th>Kelas :</th>
                            <td>
                                <select name="kelas" required>
                                    <option value="">Pilih Kelas</option>
                                    <option value="X RPL 1" <?php echo ($record['kelas'] === 'X RPL 1') ? 'selected' : ''; ?>>X RPL 1</option>
                                    <option value="X RPL 2" <?php echo ($record['kelas'] === 'X RPL 2') ?'selected' : ''; ?>>X RPL 2</option>
                                    <option value="X DKV 1" <?php echo ($record['kelas'] === 'X DKV 1') ? 'selected' : ''; ?>>X DKV 1</option>
                                    <option value="X DKV 2" <?php echo ($record['kelas'] === 'X DKV 2') ? 'selected' : ''; ?>>X DKV 2I</option>
                                    <option value="X ANM 1" <?php echo ($record['kelas'] === 'X ANM 1') ? 'selected' : ''; ?>>X ANM 1</option>
                                    <option value="X ANM 2" <?php echo ($record['kelas'] === 'X ANM 2') ? 'selected' : ''; ?>>X ANM 2</option>
                                    <option value="XI RPL 1" <?php echo ($record['kelas'] === 'XI RPL 1') ? 'selected' : ''; ?>>XI RPL 1</option>
                                    <option value="XI RPL 2" <?php echo ($record['kelas'] === 'XI RPL 2') ? 'selected' : ''; ?>>XI RPL 2</option>
                                    <option value="XI DKV 1" <?php echo ($record['kelas'] === 'XI DKV 1') ? 'selected' : ''; ?>>XI DKV 1</option>
                                    <option value="XI DKV 2" <?php echo ($record['kelas'] === 'XI DKV 2') ?'selected' : ''; ?>>XI DKV 2</option>
                                    <option value="XI ANM 1" <?php echo ($record['kelas'] === 'XI ANM 1') ? 'selected' : ''; ?>>XI ANM 1</option>
                                    <option value="XI ANM 2" <?php echo ($record['kelas'] === 'XI ANM 2') ? 'selected' : ''; ?>>XI ANM 2</option>
                                    <option value="XII RPL" <?php echo ($record['kelas'] === 'XII RPL') ? 'selected' : ''; ?>>XII RPL</option>
                                    <option value="XII DKV" <?php echo ($record['kelas'] === 'XII DKV') ? 'selected' : ''; ?>>XII DKV</option>
                                    <option value="XII ANM" <?php echo ($record['kelas'] === 'XII ANM') ? 'selected' : ''; ?>>XII ANM</option>
                                    
                                   
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Status :</th>
                            <td><select id="status" name="status">
                <option value="hadir" <?php echo ($record['status'] === 'hadir') ? 'selected' : ''; ?>>Hadir</option>
                <option value="sakit" <?php echo ($record['status'] === 'sakit') ? 'selected' : ''; ?>>Sakit</option>
                <option value="izin" <?php echo ($record['status'] === 'izin') ? 'selected' : ''; ?>>Izin</option>
                <option value="alfa" <?php echo ($record['status'] === 'alfa') ? 'selected' : ''; ?>>Alfa</option>
            </select></td>
                        </tr>
                        <tr>
                            <th>Waktu :</th>
                            <td>
                                <div class="password-container">
                                <input type="date" id="waktu" name="waktu" value="<?php echo htmlspecialchars(date('Y-m-d', strtotime($record['waktu']))); ?>">
                                </div>
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
    <?php else: ?>
        <p>Record not found.</p>
    <?php endif; ?>
    

</body>
</html>
