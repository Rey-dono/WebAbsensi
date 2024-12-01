<?php
session_start();
include '../all/connection.php';



switch(isset($_SESSION['role'])){
    case 'admin':
        header('location: ../user/absen/main.php');
        break;
    case 'user':
        header('location: ../admin/admin.php');
        break;
}

if(isset($_POST['submit'])){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $sql = "SELECT * FROM user WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn,$sql);

    if ($result->num_rows > 0) {
        $row = mysqli_fetch_assoc($result);
        // $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];
        $_SESSION['email'] = $row['email'];

        
        switch($_SESSION['role']){
            case 'admin':
                header('location: ../admin/admin.php');
                break;
            case 'user':
                header('location: ../user/absen/main.php');
                break;
        }
        exit();
    } else {
        echo "<script>alert('Email atau password Anda salah. Silakan coba lagi!')</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">





<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page - SMKN 71 Jakarta</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f7f7f7;
        }

        .container {
            display: flex;
            width: 90%;
            max-width: 1200px;
            height: 80vh;
            background: #fff;
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }

        /* Left Section (Image + Text) */
        .illustration {
            flex: 1.5;
            background: #7b68ee;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            color: white;
            text-align: center;
            padding: 20px;
            position: relative;
        }

        .illustration img {
            max-width: 80%;
            height: auto;
            margin-bottom: 20px;
        }

        .illustration h1 {
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .illustration p {
            font-size: 16px;
            line-height: 1.5;
        }

        /* Right Section (Form) */
        .login-form {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
        }

        .form-container {
            width: 100%;
            max-width: 400px;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .form-container img {
            width: 120px;
            height: auto;
            margin-bottom: 20px;
        }

        .form-container h2 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #333;
        }

        .input-group {
            margin-bottom: 20px;
            position: relative;
        }

        .input-group input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: 25px;
            font-size: 14px;
            background: #f9f9f9;
            transition: all 0.3s;
        }

        .input-group input:focus {
            border-color: #7b68ee;
            background: #fff;
        }

        .options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .options a {
            color: #7b68ee;
            text-decoration: none;
            transition: color 0.3s;
        }

        .options a:hover {
            color: #5e4edc;
        }

        .buttons button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 25px;
            font-size: 16px;
            background: #7b68ee;
            color: white;
            cursor: pointer;
            transition: all 0.3s;
        }

        .buttons button:hover {
            background: #5e4edc;
        }

        .register-link {
            margin-top: 10px;
            font-size: 14px;
        }

        .register-link a {
            color: #7b68ee;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        .register-link a:hover {
            color: #5e4edc;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                height: auto;
            }

            .illustration {
                flex: none;
                width: 100%;
                padding: 20px;
            }

            .login-form {
                flex: none;
                width: 100%;
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Bagian Kiri dengan Ilustrasi dan Tulisan SMKN 71 -->
        <div class="illustration">
            <div class="illustration-text">SMKN 71 JAKARTA</div>
            <img src="login.jpeg" alt="Illustration of person working on computer">
        </div>

        <!-- Bagian Kanan dengan Form Login dan Logo -->
        <div class="login-form">
            <!-- Kotak Putih yang menyatukan logo dan form -->
            <div class="form-container">
                <!-- Logo -->
                <div class="logo-box">
                    <img src="logo.png" alt="SMKN 71 Logo">
                </div>

                <!-- Form Login -->
                <form method="POST" class="action">
                    <div class="input-group">
                        <img src="email.jpeg" alt="Email Icon"> <!-- Gambar ikon email -->
                        <input type="email" name="email" placeholder="Enter Email" required>
                    </div>
                    <div class="input-group">
                        <img src="kunci.jpeg" alt="Lock Icon"> <!-- Gambar ikon gembok -->
                        <input type="password" name="password" placeholder="Enter Password" required>
                    </div>
                    <div class="options">
                        <label for="remember-me">
                            <input type="checkbox" id="remember-me"> Remember me
                        </label>
                        <a href="../forgot-pass-done/forgot.php">Forgot Password?</a>
                    </div>
                    <div class="buttons">
                        <button type="submit" name="submit" class="login-btn">LOGIN</button>                        
                    </div>                    
                </form>
            </div>
        </div>
    </div>
</body>

</html>
