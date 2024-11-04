<?php
// update_password.php
include 'connection.php'; // Menghubungkan file db.php

$message = ""; // Variabel untuk menyimpan pesan

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $nama = $_POST['nama'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validasi input
    if (empty($email) || empty($nama) || empty($new_password) || empty($confirm_password)) {
        $message = "All fields are required.";
    } elseif ($new_password !== $confirm_password) {
        $message = "Passwords do not match.";
    } else {
        // Mencari pengguna berdasarkan email dan nama
        $stmt = $conn->prepare("SELECT * FROM user WHERE email = ? AND nama = ?");
        $stmt->bind_param("ss", $email, $nama);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            $message = "User not found.";
        } else {
            // Memperbarui password
            $stmt = $conn->prepare("UPDATE user SET password = ? WHERE email = ? AND nama = ?");
            $stmt->bind_param("sss", $new_password, $email, $nama);
            if ($stmt->execute()) {
                
            } else {
                $message = "Error updating password.";
            }
        }
        $stmt->close();
    }
}
$conn->close();
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: #5b5558;
            position: relative;
            padding: 20px;
        }

        .container {
            display: flex;
            width: 100%;
            max-width: 450px;
            height: auto;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            border-radius: 20px;
            padding: 40px;
            overflow: hidden;
        }

        .form-container {
            width: 100%;
        }

        h2 {
            margin-bottom: 20px;
            font-size: 26px;
            text-align: center;
        }

        .input-container {
            position: relative;
            margin-bottom: 20px;
        }

        input[type="email"], input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px 40px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        .input-container i {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #888;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #5b5558;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #4a4547;
        }

        .school-name {
            position: absolute;
            bottom: 530px;
            right: 20px;
            font-size: 18px;
            color: white;
            font-weight: bold;
        }

        .alert {
            margin-bottom: 20px;
            padding: 10px;
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            border-radius: 4px;
        }

        @media (max-width: 480px) {
            .container {
                width: 90%;
            }
            h2 {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2>Forgot Password</h2>
            <?php if (!empty($message)): ?>
                <div class="alert"><?php echo htmlspecialchars($message); ?></div>
            <?php endif; ?>
            <form action="" method="POST">
                <div class="input-container">
                    <i class="fas fa-envelope"></i>
                    <input type="email" placeholder="Enter email" name="email" required>
                </div>
                <div class="input-container">
                    <i class="fas fa-user"></i>
                    <input type="text" placeholder="Enter nama" name="nama" required>
                </div>
                <div class="input-container">
                    <i class="fas fa-lock"></i>
                    <input type="password" placeholder="New Password" name="new_password" required>
                </div>
                <div class="input-container">
                    <i class="fas fa-lock"></i>
                    <input type="password" placeholder="Confirm Password" name="confirm_password" required>
                </div>
                <button type="submit">Continue</button>
            </form>
        </div>
    </div>
    <p class="school-name">SMKN 71 JAKARTA</p>
</body>
</html>

