<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body, html {
            height: 100%;
            width: 100%;
            font-family: 'Poppins', sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            display: flex;
            width: 90%;
            max-width: 1200px;
            height: 80vh;
            background-color: #fff;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            overflow: hidden;
        }

        /* Left Section (Form) */
        .left-section {
            width: 40%;
            background-color: #f5f5f5;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px;
        }

        .login-box {
            width: 100%;
            max-width: 400px;
            background-color: #fff;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
        }

        h3 {
            font-size: 24px;
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            color: #555;
        }

        .form-group input {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 14px;
            transition: all 0.3s ease;
        }

        .form-group input:focus {
            border-color: #72ADF0;
            box-shadow: 0 0 5px rgba(114, 173, 240, 0.5);
            outline: none;
        }

        .form-group button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 8px;
            background-color: #72ADF0;
            color: white;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .form-group button:hover {
            background-color: #559ad9;
        }

        .form-footer {
            text-align: center;
            margin-top: 10px;
            font-size: 14px;
        }

        .form-footer a {
            color: #72ADF0;
            text-decoration: none;
        }

        .form-footer a:hover {
            text-decoration: underline;
        }

        /* Right Section (Image) */
        .right-section {
            width: 60%;
            background-color: #665F63;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .right-section img {
            max-width: 80%;
            height: auto;
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                height: auto;
            }

            .left-section, .right-section {
                width: 100%;
                height: auto;
                padding: 30px;
            }

            .right-section img {
                max-width: 100%;
            }
        }

        @media (max-width: 480px) {
            h3 {
                font-size: 20px;
            }

            .form-group input, .form-group button {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Left Section (Form) -->
        <div class="left-section">
            <div class="login-box">
                <h3>Forgot Password</h3>
                <form action="#" method="POST">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Enter your email" required>
                    </div>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" placeholder="Enter your username" required>
                    </div>
                    <div class="form-group">
                        <button type="submit">Continue</button>
                    </div>
                    <div class="form-footer">
                        <p>Already have an account? <a href="#">Login</a></p>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right Section (Image) -->
        <div class="right-section">
            <img src="deactivated.png" alt="Illustration">
        </div>
    </div>
</body>
</html>
