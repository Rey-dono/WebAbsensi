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
            background-color: #f9fafb; /* Soft light gray */
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            display: flex;
            width: 100%;
            height: 100vh;
            background-color: #ffffff; /* White background for the container */
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            overflow: hidden;
        }

        /* Left Section */
        .left-section {
            position: relative;
            width: 60%;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
        }

        .background-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.6s ease-in-out;
        }

        .contact-us {
            position: absolute;
            bottom: 20px;
            left: 20px;
            color: white;
            font-size: 18px;
            background-color: rgba(0, 0, 0, 0.6);
            padding: 8px 15px;
            border-radius: 20px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.3);
        }

        .contact-us p {
            margin: 0;
            font-weight: bold;
        }

        .icons {
            display: flex;
            gap: 10px;
            margin-top: 5px;
        }

        .icon {
            width: 30px;
            height: 30px;
            transition: transform 0.3s ease;
        }

        .icon:hover {
            transform: scale(1.1);
        }

        /* Right Section */
        .right-section {
            width: 40%;
            background-color: #4f83cc; /* Soft Blue */
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
            transition: all 0.3s ease;
        }

        .login-box {
            background-color: #ffffff; /* White background for login box */
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 0 30px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            position: relative;
            text-align: center;
        }

        .logo-container {
            background-color: #d6e6f1; /* Light blue background for logo container */
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 15px;
            max-width: 300px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .logo {
            width: 180px;
            margin-bottom: 10px;
        }

        h3 {
            font-size: 22px;
            color: #333;
            margin-top: 10px;
        }

        .logo-container p {
            font-size: 24px;
            font-weight: 600;
            color: #4f83cc; /* Blue color for heading */
        }

        .subtext {
            font-size: 16px;
            color: #333;
            margin-bottom: 20px;
        }

        .buttons {
            width: 100%;
        }

        .login-btn, .register-btn {
            width: 100%;
            padding: 14px;
            border-radius: 30px;
            border: none;
            font-size: 18px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
            margin-bottom: 15px;
        }

        .login-btn {
            background-color: #6b9fff; /* Soft Blue */
            color: white;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .register-btn {
            background-color: white;
            color: #4f83cc; /* Blue */
            border: 1px solid #4f83cc;
        }

        .login-btn:hover, .register-btn:hover {
            transform: translateY(-2px);
            opacity: 0.9;
        }

        .register-btn:hover {
            background-color: #f0f7ff; /* Light Blue */
        }

        /* Additional style for 'Absensi Harian Siswa' */
        .absensi-title {
            font-size: 20px;
            color: #333;
            margin-top: 20px;
            text-align: center;
            margin-bottom: 30px;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }

            .left-section, .right-section {
                width: 100%;
            }

            .login-box {
                padding: 20px;
                max-width: 100%;
            }

            .logo-container {
                max-width: 250px;
            }

            .login-btn, .register-btn {
                font-size: 16px;
            }
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
                        <button type="submit" class="login-btn">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>
