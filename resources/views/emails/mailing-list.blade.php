<!DOCTYPE html>
<html>
<head>
    <title>Boomtown Mailing List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #000;
            color: #fff;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #1a1a1a;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
        }
        .content {
            text-align: left;
            margin-bottom: 20px;
        }
        .content p {
            font-size: 16px;
            line-height: 1.6;
        }
        .cta {
            display: inline-block;
            background-color: #ff4500;
            color: #fff;
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 5px;
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            font-size: 12px;
            margin-top: 20px;
            color: #bbb;
        }
        .footer a {
            color: #ff4500;
            text-decoration: none;
        }
    </style>
</head>
<body>
<div class="container">
    <!-- Header Section -->
    <div class="header">
        <img src="http://www.boomtownpa.com/images/boomtown_banner_1_transparent.png" alt="Boomtown Band">
    </div>

    <!-- Content Section -->
    <div class="content">
        <p>{{ $messageBody }}</p>
    </div>

    <!-- Call-to-Action Section -->
    <div class="content">
        <p>
            If you no longer wish to receive these emails, you can
            <a href="{{ $unsubscribeUrl }}" class="cta">Unsubscribe</a>.
        </p>
    </div>

    <!-- Footer Section -->
    <div class="footer">
        <p>&copy; 2024 Boomtown Band. All rights reserved.</p>
        <p>
            <a href="https://www.facebook.com/profile.php?id=61558485951813">Follow us on Facebook</a>
        </p>
    </div>
</div>
</body>
</html>
