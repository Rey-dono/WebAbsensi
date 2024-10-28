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
            margin-top: 60px;
            height: 80vh;
            background: linear-gradient(to right, #D9D9D9 50%, #5b5558 50%);
        }

        .container {
            display: flex;
            width: 40%;
            height: 70%;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            border-radius: 20px;
            margin-left: 100px; /* Geser ke kanan */
        }

        .left-section {
            width: 100%;
            padding: 40px;
        }

        .form-container {
            max-width: 400px;
            margin: 0 auto;
        }

        h2 {
            margin-bottom: 15px;
            font-size: 25px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .input-container {
            position: relative; /* Menjaga posisi relatif untuk ikon */
            margin-bottom: 20px;
        }

        input[type="email"], input[type="text"] {
            width: 100%;
            padding: 10px 40px 10px 40px; /* Tambahkan padding untuk ruang ikon */
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .input-container i {
            position: absolute;
            left: 10px; /* Jarak dari kiri */
            top: 50%;
            transform: translateY(-50%); /* Memposisikan ikon di tengah vertikal */
            color: black; /* Warna ikon */
        }

        .form-container p {
            font-size: 14px;
            color: #666;
            padding-bottom: 12px;
        }

        .form-container p a {
            color: #0066cc;
            text-decoration: none;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color: #5b5558;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            margin-top: 10px;
        }

        button:hover {
            background-color: #4a4547;
        }

        .image-section {
            width: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative; /* Tambahkan posisi relatif untuk anak */
        }

        .image-section img {
            width: 350px;
            height: auto;
            margin-left: 350px;
        }

        .school-name {
            position: absolute; /* Mengatur posisi absolut untuk teks */
            bottom: 400px; /* Jarak dari atas */
            right: -300px; /* Jarak dari kanan */
            color: white; /* Warna teks putih */
            font-size: 20px; /* Ukuran font */
            font-weight: bold; /* Tebal */
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5); /* Bayangan teks untuk efek */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="left-section">
            <div class="form-container">
                <h2>Forgot Password</h2>
                <form action="#" method="POST">
                    <div class="input-container">
                        <i class="fas fa-envelope"></i>
                        <input type="email" placeholder="Enter email" name="email" required>
                    </div>
                    <div class="input-container">
                        <i class="fas fa-user"></i>
                        <input type="text" placeholder="Enter username" name="username" required>
                    </div>
                    <p>Already Have an Account? <a href="#">Login</a></p>
                    <button type="submit">Continue</button>
                </form>
            </div>
        </div>
    </div>
    <div class="right-section">
        <div class="image-section">
            <img src="frame 1.png" alt="Illustration">
            <p class="school-name">SMKN 71 JAKARTA</p> <!-- Tambahkan kelas untuk teks -->
        </div>
    </div>
</body>
</html>
