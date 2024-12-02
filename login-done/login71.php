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
   
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <title>Login Page - SMKN 71 Jakarta</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap');
        @import url('https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap');

:root {
    --first-color: #12192c;
    --text-color: #8590ad;

    --body-font: 'Roboto', sans-serif;
    --big-font-size: 2rem;
    --normal-font-size: .938rem;
    --smaller-font-size: .875rem;
}

@media screen and (min-width: 768px) {
    :root {
        --big-font-size: 2.5rem;
        --normal-font-size: 1rem;
    }
}

*,::before,::after { box-sizing: border-box; }

body {
    margin: 0;
    padding: 0;
    font-family: var(--body-font);
    color: var(--first-color);
}

h1 { margin: 0; }
a { text-decoration: none; }
img { max-width: 100%; height: auto; }

.l-form {
    position: relative;
    height: 100vh;
    overflow: hidden;
}

.shape1, .shape2 {
    position: absolute;
    width: 200px;
    height: 200px;
    border-radius: 50%;
}

    .shape1 { 
        top: -7rem;
        left: -3.5rem;
        background: linear-gradient(180deg, var(--first-color) 0%, rgba(196, 196, 196, 0) 100%);
    }

    .shape2 {
        bottom: -6rem;
        right: -5.5rem;
        background: linear-gradient(180deg, var(--first-color) 0%, rgba(196, 196, 196, 0) 100%);
        transform: rotate(180deg);
    }

.form {
    height: 100vh;
    display: grid;
    justify-content: center;
    align-items: center;
    padding: 0 1rem;
}

.form-content { width: 290px; }
.form-img { display: none; }

.form-title {
    font-size: var(--big-font-size);
    font-weight: 500;
    margin-bottom: 2rem;
}

.form-div {
    position: relative;
    display: grid;
    grid-template-columns: 7% 93%;
    margin-bottom: 1rem;
    padding: 0.25rem 0;
    border-bottom: 1px solid var(--text-color);
}

    .form-div.focus { border-bottom: 1px solid var(--first-color); }

.form-div-one { margin-bottom: 3rem; }
.form-icon { 
    font-size: 1.5rem; 
    color: var(--text-color);
    transition: .3s; 
}

    .form-div.focus .form-icon { color: var(--first-color); }

.form-label {
    display: block;
    position: absolute;
    left: 0.75rem;
    top: 0.25rem;
    font-size: var(--normal-font-size);
    color: var(--text-color);
    transition: .3s;
}

    .form-div.focus .form-label {
        top: -1.5rem;
        font-size: .875rem;
        color: var(--first-color);
    }

.form-div-input { position: relative; }

.form-input {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    border: none;
    outline: none;
    background: none;
    padding: 0.5rem .75rem;
    font-size: 1.2rem;
    color: var(--first-color);
    transition: .3s;
}

.form-forgot {
    display: block;
    text-align: right;
    margin-bottom: 2rem;
    font-size: var(--normal-font-size);
    color: var(--text-color);
    font-weight: 500;
    transition: .5s;
}

    .form-forgot:hover { color: var(--first-color); }

.form-button {
    width: 100%;
    padding: 1rem;
    font-size: var(--normal-font-size);
    outline: none;
    border: none;
    margin-bottom: 3rem;
    background-color: var(--first-color);
    color: #fff;
    border-radius: .5rem;
    cursor: pointer;
    transition: .3s;
}

    .form-button:hover { box-shadow: 0px 15px 36px rgba(0, 0, 0, .15); }

.form-social { text-align: center; }

.form-social-text {
    display: block;
    font-size: var(--normal-font-size);
    margin-bottom: 1rem;
}

.form-social-icon {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    width: 30px;
    height: 30px;
    margin-right: 1rem;
    padding: 0.5rem;
    background-color: var(--text-color);
    color: #fff;
    font-size: 1.25rem;
    border-radius: 50%;
    transition: .5s;
}

    .form-social-icon:hover { background-color: var(--first-color); }

@media screen and (min-width: 968px) {
    .shape1 { 
        width: 400px;
        height: 400px;
        top: -11rem;
        left: -6.5rem;
    }

    .shape2 {
        width: 300px;
        height: 300px;
        right: -6.5rem;
    }

    .form {
        grid-template-columns: 1.5fr 1fr;
        padding: 0 2rem;
    }

    .form-content { width: 320px; }
    .form-img { 
        display: block;
        width: 700px;
        justify-self: center; 
    }
}
    
      
            :root {
    --first-color: #12192c;
    --text-color: #8590ad;

    --body-font: 'Roboto', sans-serif;
    --big-font-size: 2rem;
    --normal-font-size: .938rem;
    --smaller-font-size: .875rem;
}

@media screen and (min-width: 768px) {
    :root {
        --big-font-size: 2.5rem;
        --normal-font-size: 1rem;
    }
}

*,::before,::after { box-sizing: border-box; }

body {
    margin: 0;
    padding: 0;
    font-family: var(--body-font);
    color: var(--first-color);
}

h1 { margin: 0; }
a { text-decoration: none; }
img { max-width: 100%; height: auto; }

.l-form {
    position: relative;
    height: 100vh;
    overflow: hidden;
}

.shape1, .shape2 {
    position: absolute;
    width: 200px;
    height: 200px;
    border-radius: 50%;
}

    .shape1 { 
        top: -7rem;
        left: -3.5rem;
        background: linear-gradient(180deg, var(--first-color) 0%, rgba(196, 196, 196, 0) 100%);
    }

    .shape2 {
        bottom: -6rem;
        right: -5.5rem;
        background: linear-gradient(180deg, var(--first-color) 0%, rgba(196, 196, 196, 0) 100%);
        transform: rotate(180deg);
    }

.form {
    height: 100vh;
    display: grid;
    justify-content: center;
    align-items: center;
    padding: 0 1rem;
}

.form-content { width: 290px; }
.form-img { display: none; }

.form-title {
    font-size: var(--big-font-size);
    font-weight: 500;
    margin-bottom: 2rem;
}

.form-div {
    margin-bottom: 1rem; /* Jarak antar elemen */
}
.form-input {
    width: 100%; /* Lebar penuh */
    padding: 20px; /* Ruang dalam */
    font-size: 14px; /* Ukuran teks */
    border: 20px ; /* Garis luar */
    border-radius: 3px; /* Sedikit sudut melengkung */
    outline: none; /* Hilangkan garis fokus bawaan */
    box-sizing: border-box; /* Padding dihitung dalam ukuran elemen */
}

.form-input:focus {
    border-color: #666; /* Warna garis luar saat fokus */
}
.form-forgot {
    display: block;
    text-align: right;
    margin-bottom: 2rem;
    font-size: var(--normal-font-size);
    color: var(--text-color);
    font-weight: 500;
    transition: .5s;
}

    .form-forgot:hover { color: var(--first-color); }

.submit {
    width: 100%;
    padding: 1rem;
    font-size: var(--normal-font-size);
    outline: none;
    border: none;
    margin-bottom: 3rem;
    background-color: var(--first-color);
    color: #fff;
    border-radius: .5rem;
    cursor: pointer;
    transition: .3s;
}

    .submit:hover { box-shadow: 0px 15px 36px rgba(0, 0, 0, .15); }

.form-social { text-align: center; }

.form-social-text {
    display: block;
    font-size: var(--normal-font-size);
    margin-bottom: 1rem;
}

.form-social-icon {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    width: 30px;
    height: 30px;
    margin-right: 1rem;
    padding: 0.5rem;
    background-color: var(--text-color);
    color: #fff;
    font-size: 1.25rem;
    border-radius: 50%;
    transition: .5s;
}

    .form-social-icon:hover { background-color: var(--first-color); }

@media screen and (min-width: 968px) {
    .shape1 { 
        width: 400px;
        height: 400px;
        top: -11rem;
        left: -6.5rem;
    }

    .shape2 {
        width: 300px;
        height: 300px;
        right: -6.5rem;
    }

    .form {
        grid-template-columns: 1.5fr 1fr;
        padding: 0 2rem;
    }

    .form-content { width: 320px; }
    .form-img { 
        display: block;
        width: 700px;
        justify-self: center; 
    }
}
    </style>
</head>

<body>
    <div class="l-form">
        <div class="shape1"></div>
        <div class="shape2"></div>
        <div class="form">
            <img src="login.png" alt="image" class="form-img">

                <form method="POST" action="#" class="form-content">
                    
           
                <h1 class="form-title">Welcome</h1>
                    <div class="form-div">
                        <input type="email" name="email" placeholder="Enter Email" class="form-input" required>
                    </div>
                    <div class="form-div">
                        <input type="password" name="password" placeholder="Enter Password" class="form-input" required>
                    </div>
                    <input type="submit" name="submit" value="Login" class="form-button">
              
               
            </div>
        </div>
        </form>

<script>
const inputs = document.querySelectorAll(".form-input");

function addfocus() {
    let parent = this.parentNode.parentNode;
    parent.classList.add("focus");
}

function remfocus() {
    let parent = this.parentNode.parentNode;
    if(this.value == ""){
        parent.classList.remove("focus");
    }
}

inputs.forEach(input => {
    input.addEventListener("focus", addfocus);
    input.addEventListener("blur", remfocus)
});
</script>
</body>
</html>