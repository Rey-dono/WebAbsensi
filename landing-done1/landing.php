<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap" rel="stylesheet">


    <style>
        /* Reset */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

body, html {
    height: 100%;
    background-color: #edf6f9;
    display: flex;
    justify-content: center;
    align-items: center;
}

/* Container */
.container {
    display: flex;
    width: 90%; 
    max-width: 1200px; 
    height: 80vh;
    background: linear-gradient(135deg, #7b68ee, #89cff0);
    border-radius: 20px;
    box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.1);
    overflow: hidden;
}

/* Left Section */
.left-section {
    width: 50%;
    background-color: #f9f9f9;
    position: relative;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    padding: 20px;
    text-align: center;
}

.left-section img {
    width: 80%;
    max-width: 400px;
    border-radius: 20px;
    margin-bottom: 20px;
    box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
}

.left-section p {
    font-size: 18px;
    color: #555;
}

.icons {
    display: flex;
    gap: 15px;
    margin-top: 20px;
}

.icon {
    width: 40px;
    height: 40px;
    transition: transform 0.2s ease-in-out;
}

.icon:hover {
    transform: scale(1.2);
}

/* Right Section */
.right-section {
    width: 50%;
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    background-color: #ffffff;
    padding: 40px;
}

.logo-container {
    text-align: center;
    margin-bottom: 30px;
}

.logo-container img {
    width: 100px;
    margin-bottom: 10px;
}

.logo-container p {
    font-size: 22px;
    color: #7b68ee;
    font-weight: bold;
    letter-spacing: 1px;
}

.absensi-title {
    font-size: 16px;
    color: #555;
    margin-bottom: 30px;
}

.buttons {
    display: flex;
    flex-direction: column;
    gap: 15px;
    width: 100%;
    max-width: 300px;
}

button {
    width: 100%;
    padding: 15px;
    border-radius: 30px;
    border: none;
    font-size: 18px;
    font-weight: bold;
    cursor: pointer;
    transition: all 0.3s ease-in-out;
}

button.login-btn {
    background-color: #7b68ee;
    color: #fff;
}

button.login-btn:hover {
    background-color: #5a4abe;
}

button.register-btn {
    background-color: #edf6f9;
    color: #7b68ee;
    border: 2px solid #7b68ee;
}

button.register-btn:hover {
    background-color: #7b68ee;
    color: #fff;
}


    </style>
</head>
<body>

    <div class="container">
        <div class="left-section">
            <img src="apa.jpg" alt="School Building" class="background-image">
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