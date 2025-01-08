<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your OTP Code - Ecolodges</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .email-container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
        }
        .header img {
            max-width: 200px;
        }
        .content {
            font-size: 16px;
            line-height: 1.5;
        }
        .otp-code {
            font-size: 24px;
            font-weight: bold;
            color: #2d6a4f;
            padding: 10px;
            border: 2px solid #2d6a4f;
            border-radius: 5px;
            display: inline-block;
        }
        .footer {
            margin-top: 30px;
            font-size: 14px;
            text-align: center;
            color: #888;
        }
        .footer a {
            color: #2d6a4f;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="header">
            <img src="https://vnfoxcdnoahqenfjssdv.supabase.co/storage/v1/object/public/ecolodgesmr/images/logo1.jpg" alt="Ecolodges Logo">
        </div>
        <div class="content">
            <p>Dear Valued Guest,</p>
            <p>Thank you for choosing Ecolodges for your upcoming stay. Your one-time password (OTP) is:</p>
            <p class="otp-code">{{ $otp }}</p>
            <p>This OTP is valid for 10 minutes only. Please use it to complete your request.</p>
            <p>If you did not request this, kindly disregard this message.</p>
        </div>
        <div class="footer">
            <p>Warm regards,</p>
            <p><strong>Ecolodges Resort & Hotel Management</strong></p>
            <p><a href="mailto:support@ecolodges.com">support@ecolodges.com</a></p>
        </div>
    </div>
</body>
</html>
