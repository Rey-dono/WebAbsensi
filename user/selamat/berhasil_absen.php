<?php
session_start();
include '../../all/connection.php';

if (!isset($_SESSION['email'])) {
    header("location: ../../login-done/login71.php");
}

$email = $_SESSION['email'];

$banyak_siswa = $conn->query("SELECT * FROM user WHERE email = '$email'");

$siswa = $banyak_siswa->fetch_row();
// print_r($siswa);









?>



<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            font-family: "Poppins", sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-color: #666666;
        }

        .card {
            background: #D9D9D9;
            padding: 4rem;
            border-radius: 26px;
            text-align: center;
            max-width: 100%;
            width: 600px;
        }

        img {
            width: 200px;
            height: 200px;
            margin-bottom: 2rem;
        }

        h1 {
            color: #000;
            margin: 0 0 0.5rem 0;
            font-size: 1.75rem;
            font-weight: 600;
        }

        p {
            color: #333;
            margin: 0;
            font-size: 1.25rem;
            line-height: 1.6;
        }
    </style>
</head>

<body>
    <div class="card">
        <img src="absen.png" alt="Success Icon">
        <h1>SELAMAT!</h1>
        <h1>Anda berhasil absen<br>pada <h1>
                <!-- <p><time id="current-time"></time></p> -->
                <p>
                    <?= $siswa[4] ?>
                </p>
               
<script>
        let idleTime = 0;

        function resetIdleTime  (){
            idleTime = 0;
        }
        setInterval(function() {
            idleTime++; 
            if(idleTime>=2){
                window.location.href='../absen/logout.php';
            }
            
        }, 1000);
    </script> 
    </div>
</body>

<!-- <script>
        const now = new Date();
        document.getElementById('current-time').setAttribute('datetime', now.toISOString());
        document.getElementById('current-time').textContent = now.toLocaleString();
</script> -->

</html>