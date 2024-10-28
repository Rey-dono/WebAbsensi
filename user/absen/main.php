<?php
session_start();

include '../../all/connection.php';

if (!isset($_SESSION['email'])) {
    header("location: ../../login-done/login71.php");
}

$email = $_SESSION['email'];

$banyak_siswa = $conn->query("SELECT * FROM user WHERE email = '$email'");

while ($row = $banyak_siswa->fetch_row()) {
    $siswa[] = $row;
}

// if(true) {
//     $i = 0;
//     while(true) {
//         echo "$i";
//         $i++;
//     }
// }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presensi Kehadiran</title>
    <style>
        /* Reset dasar */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
            text-decoration: none;
        }

        /* Latar belakang halaman */
        body {
            background-color: #6c6666;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        /* Container utama */
        .container {
            background-color: #f9f9f9;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 1890px;
            height: 925px;
        }

        /* Judul */
        h2 {
            margin-bottom: 20px;
            color: #000;
        }

        /* Kotak status */
        .status-container {
            display: flex;
            justify-content: space-around;
            margin-bottom: 130px;
            margin-top: 150px;
        }

        .status {
            width: 100px;
            height: 100px;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 10px;
            background-color: #e0e0e0;
            font-size: 2rem;
            font-weight: bold;
            color: #fff;
        }

        /* Warna status */
        .hadir {
            background-color: #2ecc71;
            width: 350px;
            height: 350px;
        }

        .izin {
            background-color: #f1c40f;
            /* color: #000; */
            width: 350px;
            height: 350px;
        }

        .sakit {
            background-color: red;
            width: 350px;
            height: 350px;
        }

        /* Bagian jadwal */
        .schedule {
            background-color: #7abaff;
            display: inline-block;
            margin: auto;
            padding: 10px;
            padding-right: 100px;
            padding-left: 100px;
            /* width: 1600px; */
            border-radius: 10px;
            color: #fff;
            font-size: 2rem;
        }
        .schedule table {
            border-collapse: collapse;
            border-color: gray; 
            
        }
        .schedule td{
            padding: 20px;
        }
        .schedule th {
            text-align: center;
            font-weight: bold;
            height: 80px;
            padding: 20px;
        }
        .center {
            text-align: center;
        }
        .left {
            text-align: left;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>PRESENSI KEHADIRAN</h1>

        <div class="status-container">
            <a href="hadir.php">
                <div class="status hadir">Hadir</div>
            </a>
            <a href="">
                <div class="status izin">Izin</div>
            </a>
            <a href="sakit.php">
                <div class="status sakit">Sakit</div>
            </a>
        </div>

        <div class="schedule">
            <p>Welcome..</p>
            <?php foreach ($banyak_siswa as $siswa) : ?>
                <table border="1">
                <tr>
                    <th>NIS</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Status</th>
                </tr>
                <tr>
                    <td class="center"><?= $siswa['nis'] ?></td>
                    <td class="left"><?= $siswa['nama'] ?></td>
                    <td class="center"><?= $siswa['kelas'] ?></td>
                    <td class="center"><?= $siswa['status'] ?></td>
                </tr>
                </table>
            <?php endforeach; ?>
            
        </div>
    </div>
</body>



</html>