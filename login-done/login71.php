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
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            overflow: hidden; /* Supaya halaman tidak scrollable jika tidak perlu */
            margin: 0;
        }

        .container {
            display: flex;
            width: 100%;
            height: 100vh;
            background-color: #D9D9D9;
            border-radius: 0; /* Menghapus border-radius untuk tampilan penuh */
            box-shadow: none; /* Menghapus box-shadow untuk tampilan penuh */
            overflow: hidden;
        }

        .illustration {
            flex: 1;
            background-color: #666064;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            padding: 40px;
        }

        .illustration img {
            width: 100%;
            height: auto;
            max-width: 600px; /* Menambah lebar maksimal ilustrasi */
        }

        .illustration-text {
            position: absolute;
            top: 40px;
            left: 40px;
            font-size: 24px;
            font-weight: 600;
            color: white;
        }

        .login-form {
            flex: 1;
            padding: 60px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .form-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .logo-box {
            margin-bottom: 30px;
        }

        .logo-box img {
            width: 180px;
            height: auto;
        }

        .input-group {
            position: relative;
            margin-bottom: 25px;
            width: 100%;
        }

        .input-group img {
            position: absolute;
            top: 50%;
            left: 20px;
            width: 24px;
            height: auto;
            transform: translateY(-50%);
        }

        .input-group input {
            width: 100%;
            padding: 15px 20px 15px 60px; /* Tambahkan padding untuk ikon */
            font-size: 16px;
            border: 1px solid #ddd;
            border-radius: 30px;
            outline: none;
            background-color: #f9f9f9;
            transition: border-color 0.3s;
        }

        .input-group input:focus {
            border-color: #007bff;
            background-color: #fff;
        }

        .options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            width: 100%;
        }

        .options label {
            font-size: 14px;
            color: #333;
            display: flex;
            align-items: center;
        }

        .options label input {
            margin-right: 8px;
        }

        .options a {
            font-size: 14px;
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s;
        }

        .options a:hover {
            color: #0056b3;
        }

        .buttons {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
            margin-bottom: 20px;
        }

        .login-btn {
            width: 48%;
            padding: 12px;
            border: none;
            background-color: #72ADF0;
            color: white;
            font-size: 16px;
            border-radius: 30px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .login-btn:hover {
            background-color: #5e9dd9;
        }

        .signup-btn {
            width: 48%;
            padding: 12px;
            background-color: #D9D9D9;
            color: #007bff;
            border: 1px solid #ddd;
            text-align: center;
            font-size: 16px;
            border-radius: 30px;
            text-decoration: none;
            display: inline-block;
            transition: background-color 0.3s, color 0.3s;
        }

        .signup-btn:hover {
            background-color: #c3c3c3;
            color: #6c9edc;
        }

        .register-link {
            font-size: 14px;
            text-align: center;
            width: 100%;
        }

        .register-link a {
            color: #007bff;
            text-decoration: none;
            transition: color 0.3s;
        }

        .register-link a:hover {
            color: #0056b3;
        }

        /* Responsif untuk layar lebih kecil */
        @media (max-width: 1024px) {
            .container {
                flex-direction: column;
                height: auto;
            }

            .illustration, .login-form {
                flex: none;
                width: 100%;
                padding: 20px;
            }

            .illustration img {
                max-width: 400px;
            }

            .illustration-text {
                font-size: 20px;
                top: 20px;
                left: 20px;
            }

            .form-container {
                max-width: 400px;
                padding: 30px;
            }

            .logo-box img {
                width: 150px;
            }

            .input-group img {
                left: 15px;
                width: 20px;
            }

            .input-group input {
                padding: 12px 15px 12px 50px;
                font-size: 14px;
            }

            .options {
                flex-direction: column;
                align-items: flex-start;
            }

            .options a {
                margin-left: 0;
                margin-top: 10px;
            }

            .buttons {
                flex-direction: column;
            }

            .login-btn, .signup-btn {
                width: 100%;
                margin: 5px 0;
            }

            .register-link {
                font-size: 13px;
            }
        }

        @media (max-width: 768px) {
            .illustration img {
                max-width: 300px;
            }

            .illustration-text {
                font-size: 18px;
            }

            .form-container {
                padding: 20px;
            }

            .logo-box img {
                width: 130px;
            }

            .input-group img {
                left: 10px;
                width: 18px;
            }

            .input-group input {
                padding: 10px 10px 10px 40px;
                font-size: 13px;
            }

            .options label {
                font-size: 12px;
            }

            .options a {
                font-size: 12px;
            }

            .buttons {
                flex-direction: column;
            }

            .login-btn, .signup-btn {
                width: 100%;
                margin: 5px 0;
                font-size: 14px;
            }

            .register-link {
                font-size: 12px;
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
