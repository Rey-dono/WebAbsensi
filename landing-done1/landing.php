<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">


    <style>
        * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body, html {
    height: 100%;
    /* font-family: Arial, sans-serif; Menggunakan font Arial untuk seluruh halaman */
    background-color: #f0f0f0;
    display: flex;
    justify-content: center;
    align-items: center;
    font-family: 'Poppins', sans-serif;
}

.container {
    display: flex;
    width: 100%; /* Membuat container mengisi lebar layar penuh */
    height: 100vh; /* Membuat container mengisi tinggi layar penuh */
    background-color: #fff;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
    /* border-radius: 10px; */
    overflow: hidden;
    
}

/* Left Section */
.left-section {
    position: relative;
    width: 60%;
}

.background-image {
    width: 100%;
    height: 100%;
    object-fit: cover; /* Membuat gambar memenuhi seluruh kotak */
    background: linear-gradient(to bottom, rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0)), 
                url('apa1.png'); /* Tambahkan gradient di atas gambar */
  
}

.contact-us {
    position: absolute;
    bottom: 20px;
    left: 20px;
    color: white;
}

.contact-us {
    font-size: 18px;
    margin: 0;
    background-color: gray;
    opacity: 0.7;
    padding: 5px;
    border-radius: 15px
}

.icons {
    display: flex;
    gap: 10px;
    margin-top: 10px;
}

.icon {
    width: 30px;
    height: 30px;
}

/* Right Section */
.right-section {
    width: 40%;
    background-color:#f0f0f0 ;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 20px; /* Memberi ruang di dalam kotak */
}

.login-box {
    background-color: #fff;
    padding: 30px; /* Memperbesar padding untuk memberi ruang lebih besar */
    border-radius: 10px;
    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
    width: 85%; /* Lebih besar sedikit agar tidak terlalu kecil */
    max-width: 350px; /* Lebar maksimal untuk login-box agar standar */
    position: relative;
}

.inner-box {
    background-color: #020202;
    border-radius: 10px;
    padding: 15px; /* Memberi ruang yang lebih rapi */
    text-align: center;
    margin-bottom: 20px;
}

.logo-container {
    background-color:#cec8ef  ;
    padding: 20px;
    border-radius: 10px;
    margin-bottom: 15px;
    max-width: 300px;
    margin: 0 auto;
    display: flex;
    flex-direction: column; /* Stack elements vertically */
    justify-content: center;
    align-items: center;
    text-align: center; /* Center the text */
}

.logo {
    width: 300px;
    text-align: center;
}

h3 {
    font-size: 20px;
    color: #333;
    margin-top: 10px; /* Adjust the spacing between logo and heading */
    text-align: center;
}

.logo-container p{
    font-size: 25px;
    /* font-weight: bold; */
}

.subtext {
    font-size: 16px;
    color: #333;
    margin-bottom: 20px;
}

.buttons {
    /* display: flex; */
    /* justify-content: space-between; */
    margin-top: 10px; /* Mengurangi jarak agar tombol lebih ke atas */
    width: 600px;
}

.login-btn, .register-btn {
    width: 48%;
    padding: 10px;
    border-radius: 25px;
    border: none;
    font-size: 16px;
    cursor: pointer;
}

.login-btn {
    background-color: #72ADF0;
    color: white;
}

.register-btn {
    background-color: white;
    color: #72ADF0;
    border: 1px solid #ccc;
}

.login-btn:hover, .register-btn:hover {
    opacity: 0.8;
}

.register-btn:hover {
    background-color: #ccc;
}

/* Additional style for 'Absensi Harian Siswa' */
.absensi-title {
    font-size: 20px;
    color: #333;
    margin-top: 20px; /* Memberi jarak antara logo dan judul */
    text-align: center;
    margin-bottom: 30px; /* Memberikan jarak bawah yang lebih besar */
}

    </style>
</head>
<body>

    <div class="container">
        <div class="left-section">
            <img src="apa1.png" alt="School Building" class="background-image">
            <div class="contact-us">
                <p>Contact Us</p>
                <div class="icons">
                    <a href=""><img src="ig.png" alt="Instagram" class="icon"></a>
                    <a href=""><img src="yt.jpg" alt="YouTube" class="icon"></a>
                    <a href=""><img src="wa.jpg" alt="WhatsApp" class="icon"></a>
                </div>
            </div>
        </div>
        <div class="right-section">
            <div class="login-box">
                <div class="logo-container">
                    <img src="logo71.png" alt="Logo SMKN 71" class="logo">
                    <p>ABSENSI HARIAN SISWA</p>
                </div>
                <div class="buttons">
                    <form action="../login-done/login71.php">
                    <button class="login-btn">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>
</html>