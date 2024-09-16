<!DOCTYPE html>
<html lang="en">
<head>
    <title>Xero Authorization</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7f6;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .auth-container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .auth-container h1 {
            color: #0082fc; /* Xero's color scheme */
            margin-bottom: 20px;
            font-weight: bold;
        }

        .auth-btn {
            background-color: #0082fc; /* Xero's color */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            text-transform: uppercase;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .auth-btn:hover {
            background-color: #006bb3; /* Darker shade of Xero color */
            box-shadow: 0 6px 12px rgba(0, 130, 252, 0.3);
        }
    </style>
</head>
<body>
    <div class="auth-container">
        <h1>Access Xero</h1>
        <a class="auth-btn" href="https://login.xero.com/identity/connect/authorize?response_type=code&client_id=BCD8984403E84080997975DB333B42E6&redirect_uri=http://localhost/Learing_Project/xerointegration/callback.php&scope=payroll.employees&state=YOUR_STATE">
            Click to Get Access
        </a>
    
    </div>
</body>
</html>
