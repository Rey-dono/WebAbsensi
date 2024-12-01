<?php
session_start();
include '../all/connection.php';

if (!isset($_SESSION['email'])) {
    header("Location: ../login-done/login71.php");
    exit();
}

$nis = $_GET['nis'] ?? null;

if (!$nis) {
    echo "nis is missing!";
    exit();
}

// Fetch the student data
$siswaQuery = $conn->prepare("SELECT * FROM user WHERE nis = ?");
$siswaQuery->bind_param("s", $nis);
$siswaQuery->execute();
$siswa = $siswaQuery->get_result()->fetch_assoc();

if (!$siswa) {
    echo "Data not found!";
    exit();
}

// Handle the form submission
// Handle the form submission
// Handle the form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];
    $status = $_POST['status'];
    $waktu = $_POST['waktu'];

    // Only upload the file if the status is not 'hadir'
    if ($status !== 'hadir') {
        $surat = upload(); // Call the upload function
        if (!$surat) {
            die;
        }
    } else {
        // If the status is 'hadir', don't upload and use the existing surat
        $surat = $siswa['surat'];
    }

    // Check for duplicate student name
    $duplicateQuery = $conn->prepare("SELECT * FROM user WHERE nama = ? AND nis != ?");
    $duplicateQuery->bind_param("ss", $nama, $nis);
    $duplicateQuery->execute();
    $duplicateResult = $duplicateQuery->get_result();

    if ($duplicateResult->num_rows > 0) {
        echo "<script>alert('Nama sudah digunakan oleh siswa lain!');</script>";
    } else {
        // Update student data
        $updateQuery = $conn->prepare(
            "UPDATE user SET nama = ?, kelas = ?, status = ?, waktu = ?, surat = ? WHERE nis = ?"
        );
        $updateQuery->bind_param("ssssss", $nama, $kelas, $status, $waktu, $surat, $nis);

        if ($updateQuery->execute()) {
            header("Location: riwayat.php");
            exit();
        } else {
            echo "<script>alert('Gagal memperbarui data!');</script>";
        }
    }
}


function upload()
{
    $namaFile = $_FILES['surat_baru']['name'];
    $ukuranFile = $_FILES['surat_baru']['size'];
    $error = $_FILES['surat_baru']['error'];
    $tmpName = $_FILES['surat_baru']['tmp_name'];

    if ($error === 4) {
        echo "<script>
                alert('Pilih gambar terlebih dahulu!');
                window.location.href='izin.php';
              </script>";
        return false;
    }

    if ($ukuranFile > 1000000) {
        echo "<script>
                alert('Ukuran gambar terlalu besar!');
                window.location.href='edit-riwayat.php';
              </script>";
        return false;
    }

    // Generate a unique file name to avoid conflicts
    $fileExt = pathinfo($namaFile, PATHINFO_EXTENSION);
    $newFileName = uniqid() . '.' . $fileExt;

    $uploadDir = realpath(__DIR__ . '/../user/img/surat') . '/';
    $uploadPath = $uploadDir . $newFileName;

    if (move_uploaded_file($tmpName, $uploadPath)) {
        return $newFileName;
    } else {
        echo "<script>
                alert('Gagal mengupload file!');
                window.location.href='riwayat.php';
              </script>";
        return false;
    }
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
<div class="container">
    <div class="left-section">
        <h1>Edit Data Siswa</h1>
        <img src="computer.png" alt="Update Illustration">
    </div>

    <div class="right-section">
        <div class="edit-box">
            <h1>Edit Data Siswa</h1>
            <form method="POST" enctype="multipart/form-data">
                <table class="form-table">
                    <tr>
                        <th>nis:</th>
                        <td><input type="text" name="nis" value="<?= htmlspecialchars($siswa['nis']) ?>" readonly></td>
                    </tr>
                    <tr>
                        <th>Nama:</th>
                        <td><input type="text" name="nama" value="<?= htmlspecialchars($siswa['nama']) ?>" required></td>
                    </tr>
                    <tr>
                        <th>Kelas:</th>
                        <td>
                            <select name="kelas" required>
                                <option value="">Pilih Kelas</option>
                                <?php
                                $classes = [
                                    "X RPL 1", "X RPL 2", "X DKV 1", "X DKV 2", 
                                    "X ANM 1", "X ANM 2", "XI RPL 1", "XI RPL 2",
                                    "XI DKV 1", "XI DKV 2", "XI ANM 1", "XI ANM 2",
                                    "XII RPL", "XII DKV", "XII ANM"
                                ];
                                foreach ($classes as $class) {
                                    $selected = $class === $siswa['kelas'] ? 'selected' : '';
                                    echo "<option value=\"$class\" $selected>$class</option>";
                                }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>Status:</th>
                        <td>
                            <select name="status" required>
                                <option value="hadir" <?= $siswa['status'] === 'hadir' ? 'selected' : '' ?>>Hadir</option>
                                <option value="sakit" <?= $siswa['status'] === 'sakit' ? 'selected' : '' ?>>Sakit</option>
                                <option value="izin" <?= $siswa['status'] === 'izin' ? 'selected' : '' ?>>Izin</option>
                                <option value="alfa" <?= $siswa['status'] === 'alfa' ? 'selected' : '' ?>>Alfa</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>Waktu:</th>
                        <td>
                            <input type="date" name="waktu" value="<?= htmlspecialchars(date('Y-m-d', strtotime($siswa['waktu']))) ?>" required>
                        </td>
                    </tr>
                    <tr>
                        <th>surat:</th>
                        <td>
                            <img src="../user/img/surat/<?= $siswa['surat']?>" width="100px" alt="">
                            <input type="file" name="surat_baru" id="">
                        </td>
                    </tr>
                </table>
                <button type="submit">Simpan</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
