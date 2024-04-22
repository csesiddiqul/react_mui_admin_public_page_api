<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OTP Verification Email</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f2f2f2;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 50px auto;
            background-color: #f9f9f9;
            border-radius: 10px;
            padding: 40px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .otp-container {
            background-color: #42AD50;
            border-radius: 10px;
            padding: 10px;
            text-align: center;
            margin-bottom: 30px;
            color: #ffffff;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        .otp-code {
            font-size: 30px;
            font-weight: bold;
            letter-spacing: 5px;
        }
        .note {
            text-align: center;
            font-style: italic;
            color: #666;
            margin-top: 20px;
        }
        .note p {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h2 class="mb-4">OTP Verification</h2>
        <p class="mb-3"> Thank you for choosing Us</p>
        <p class="mb-3">Your OTP Verification Code is:</p>
    </div>
    <div class="otp-container">
        <span class="otp-code">{{ $otp }}</span>
    </div>
    <div class="note">
        <p>Please use the above OTP to verify your account.</p>
        <p>This OTP is valid for a limited time.</p>
    </div>
</div>

<!-- Bootstrap JS and jQuery (optional) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
