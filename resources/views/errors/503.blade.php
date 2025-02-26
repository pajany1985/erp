<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Maintenance Mode</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
            text-align: center;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .maintenance-container {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 30px;
            text-align: center;
            width: 100%;
            max-width: 600px;
        }

        .maintenance-container img {
            width: 200px; /* Adjust the logo size */
            margin-bottom: 20px;
        }

        .maintenance-container h1 {
            color: #e74c3c;
            font-size: 36px;
            margin-bottom: 20px;
        }

        .maintenance-container p {
            font-size: 18px;
            margin-bottom: 20px;
        }

        .maintenance-container .timestamp {
            font-style: italic;
            color: #777;
        }

        .maintenance-container .contact {
            font-size: 16px;
            color: #555;
        }

        .maintenance-container .contact a {
            color: #3498db;
            text-decoration: none;
        }

        .maintenance-container .contact a:hover {
            text-decoration: underline;
        }

        /* Animation for the loading spinner */
        .spinner {
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            animation: spin 2s linear infinite;
            margin: 20px auto;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
</head>
<body>
    <div class="maintenance-container">
        <!-- Company Logo -->
        <img src="/logo/logo_ideal.png" alt="Maintenance Logo" style="width: 300px;">
        
        <h1>We'll be back soon!</h1>
        <p>Our website is currently undergoing scheduled maintenance. We're working hard to make things better. Thank you for your patience!</p>
        <div class="spinner"></div>
        <p class="timestamp">Last update: <strong>November 30, 2024</strong></p>
        <p class="contact">If you need immediate assistance, please contact us at <a href="mailto:support@idealtraits.com">support@idealtraits.com</a>.</p>
    </div>
</body>
</html>