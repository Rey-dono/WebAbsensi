<?php
// Include your database connection file
include '../all/connection.php';

// Check if the NIS is set and valid
if (isset($_GET['nis'])) {
    $nis = $_GET['nis'];
    
    // Fetch student data from the database
    $query = "SELECT * FROM user WHERE nis = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $nis); // assuming NIS is a string
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a student was found
    if ($result->num_rows > 0) {
        $student = $result->fetch_assoc();
        $nama = $student['nama'];
        $kelas = $student['kelas'];
        $email = $student['email'];
        $password = $student['password'];
    } else {
        // Handle the case where no student is found
        echo "Student not found.";
        exit;
    }

    $stmt->close();
} else {
    echo "NIS not provided.";
    exit;
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
            border-radius: 10px;
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
            <img src="image-12.png" alt="Update Illustration">
        </div>

        <div class="right-section">
            <div class="edit-box">
                <h1>Edit Data Siswa</h1>
                <form action="proses_edit.php" method="POST">
                    <table class="form-table">
                        <tr>
                            <th>NIS :</th>
                            <td><input type="text" name="nis" value="<?= htmlspecialchars($nis); ?>" readonly></td>
                        </tr>
                        <tr>
                            <th>Nama :</th>
                            <td><input type="text" name="nama" placeholder="Masukkan Nama" value="<?= htmlspecialchars($nama); ?>" required></td>
                        </tr>
                        <tr>
                            <th>Kelas :</th>
                            <td>
                                <select name="kelas" required>
                                    <option value="">Pilih Kelas</option>
                                    <option value="X RPL 1" <?= $kelas == 'X RPL 1' ? 'selected' : ''; ?>>X RPL 1</option>
                                    <option value="X RPL 2" <?= $kelas == 'X RPL 2' ? 'selected' : ''; ?>>X RPL 2</option>
                                    <option value="X DKV 1" <?= $kelas == 'X DKV 1' ? 'selected' : ''; ?>>X DKV 1</option>
                                    <option value="X DKV 2" <?= $kelas == 'X DKV 2' ? 'selected' : ''; ?>>X DKV 2</option>
                                    <option value="X ANM 1" <?= $kelas == 'X ANM 1' ? 'selected' : ''; ?>>X ANM 1</option>
                                    <option value="X ANM 2" <?= $kelas == 'X ANM 2' ? 'selected' : ''; ?>>X ANM 2</option>
                                    <option value="XI RPL 1" <?= $kelas == 'XI RPL 1' ? 'selected' : ''; ?>>XI RPL 1</option>
                                    <option value="XI RPL 2" <?= $kelas == 'XI RPL 2' ? 'selected' : ''; ?>>XI RPL 2</option>
                                    <option value="XI DKV 1" <?= $kelas == 'XI DKV 1' ? 'selected' : ''; ?>>XI DKV 1</option>
                                    <option value="XI DKV 2" <?= $kelas == 'XI DKV 2' ? 'selected' : ''; ?>>XI DKV 2</option>
                                    <option value="XI ANM 1" <?= $kelas == 'XI ANM 1' ? 'selected' : ''; ?>>XI ANM 1</option>
                                    <option value="XI ANM 2" <?= $kelas == 'XI ANM 2' ? 'selected' : ''; ?>>XI ANM 2</option>
                                    <option value="XII RPL " <?= $kelas == 'XII RPL ' ? 'selected' : ''; ?>>XII RPL </option>
                                    <option value="XII RPL " <?= $kelas == 'XII DKV ' ? 'selected' : ''; ?>>XII DKV </option>
                                    <option value="XII RPL " <?= $kelas == 'XII ANM ' ? 'selected' : ''; ?>>XII ANM </option>
                                   
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <th>Email :</th>
                            <td><input type="email" name="email" placeholder="Masukkan Email" value="<?= htmlspecialchars($email); ?>" required></td>
                        </tr>
                        <tr>
                            <th>Password :</th>
                            <td>
                                <div class="password-container">
                                    <input type="password" id="password" name="password" placeholder="Masukkan Password" value="<?= htmlspecialchars($password); ?>" required>
                                    <i class="fas fa-eye toggle-password" onclick="togglePasswordVisibility()"></i>
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
    <script>
        function togglePasswordVisibility() {
            var passwordField = document.getElementById("password");
            var toggleIcon = document.querySelector(".toggle-password");

            if (passwordField.type === "password") {
                passwordField.type = "text";
                toggleIcon.classList.remove("fa-eye");
                toggleIcon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                toggleIcon.classList.remove("fa-eye-slash");
                toggleIcon.classList.add("fa-eye");
            }
        }
    </script>
    

</body>
</html>
