<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Code</title>
    <style>
        /* Global styles */
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #4CAF50, #2E8B57);
            color: #333;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        /* OTP Card */
        .otp-container {
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
            max-width: 400px;
            width: 90%;
            animation: fadeIn 0.5s ease-in-out;
        }

        h1 {
            font-size: 24px;
            color: #2E8B57;
            margin-bottom: 10px;
        }

        p {
            font-size: 18px;
            margin-bottom: 15px;
        }

        /* OTP Code Styling */
        .otp-code {
            font-size: 28px;
            font-weight: bold;
            color: #4CAF50;
            background: #f3f3f3;
            padding: 10px 20px;
            border-radius: 5px;
            display: inline-block;
            letter-spacing: 3px;
        }

        /* Fade-in animation */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <div class="otp-container">
        <h1>Your OTP Code</h1>
        <p>Your OTP code is:</p>
        <p class="otp-code">{{ $otp }}</p>
        <p>This code will expire in 1 minute.</p>
    </div>
</body>

</html>
