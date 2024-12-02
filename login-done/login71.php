<?php
session_start();
include '../all/connection.php';

switch(isset($_SESSION['role'])){
    case 'admin':
        header('location: ../admin/admin.php');
        break;
    case 'user':
        header('location: ../user/absen/main.php');
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
    animation: fadeIn 1s ease-out;
}

.container {
    display: flex;
    width: 100%;
    height: 100vh;
    background-color: #D9D9D9;
    border-radius: 0; /* Menghapus border-radius untuk tampilan penuh */
    box-shadow: none; /* Menghapus box-shadow untuk tampilan penuh */
    overflow: hidden;
    animation: slideIn 0.7s ease-out;
}

.illustration {
    flex: 1;
    background-color: #666064;
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
    padding: 40px;
    animation: fadeInRight 1s ease-out;
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
    animation: fadeInText 1s ease-out;
}

.login-form {
    flex: 1;
    padding: 60px;
    display: flex;
    justify-content: center;
    align-items: center;
    animation: fadeInLeft 1s ease-out;
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
    opacity: 0;
    animation: fadeIn 1.5s ease-out forwards;
}

.logo-box {
    margin-bottom: 30px;
    transition: transform 0.5s ease-in-out; /* Smooth transition */
}

/* Spin animation for logo */
@keyframes spinLogo {
    0% {
        transform: rotate(0deg);
    }
    100% {
        transform: rotate(360deg);
    }
}

/* Logo image */
.logo-box img {
    width: 180px;
    height: auto;
}

/* Trigger spin animation on hover */
.logo-box:hover img {
    animation: spinLogo 1s infinite linear;
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
    transition: border-color 0.3s, background-color 0.3s;
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
    transition: background-color 0.3s, transform 0.2s ease-in-out;
}

.login-btn:hover {
    background-color: #5e9dd9;
    transform: translateY(-5px);
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
    transition: background-color 0.3s, color 0.3s, transform 0.2s ease-in-out;
}

.signup-btn:hover {
    background-color: #c3c3c3;
    color: #6c9edc;
    transform: translateY(-5px);
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

/* Animations */
@keyframes fadeIn {
    0% {
        opacity: 0;
    }
    100% {
        opacity: 1;
    }
}

@keyframes fadeInLeft {
    0% {
        opacity: 0;
        transform: translateX(-30px);
    }
    100% {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes fadeInRight {
    0% {
        opacity: 0;
        transform: translateX(30px);
    }
    100% {
        opacity: 1;
        transform: translateX(0);
    }
}

@keyframes fadeInText {
    0% {
        opacity: 0;
        transform: translateY(-20px);
    }
    100% {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes scaleUp {
    0% {
        transform: scale(0.8);
        opacity: 0;
    }
    100% {
        transform: scale(1);
        opacity: 1;
    }
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
        padding-left: 50px;
    }
}
    </style>
</head>

<body>
    <div class="container">
        <div class="illustration">
            <img src="../login-done/login.jpeg" alt="Illustration">
            <div class="illustration-text">
                <h2>Selamat datang!</h2>
                <p>Login ke sistem absensi untuk memulai.</p>
            </div>
        </div>

        <div class="login-form">
            <div class="form-container">
                <div class="logo-box">
                    <img src="../login-done/logo.png" alt="Logo">
                </div>
                <form action="" method="POST">
                    <div class="input-group">
                        <img src="../login-done/email.jpeg" alt="Email Icon">
                        <input type="email" name="email" placeholder="Email" required>
                    </div>
                    <div class="input-group">
                        <img src="../login-done/kunci.jpeg" alt="Password Icon">
                        <input type="password" name="password" placeholder="Password" required>
                    </div>

                    <div class="options">
                        <label><input type="checkbox" name="remember"> Remember me</label>
                        <a href="../forgot-pass-done/forgot.php">Forgot password?</a>
                    </div>

                    <div class="buttons">
                        <button type="submit" name="submit" class="login-btn">Login</button>
                    </div>
                  
                </form>
            </div>
        </div>
    </div>
</body>

</html>
