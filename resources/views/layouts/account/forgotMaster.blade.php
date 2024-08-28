<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: white;
        }
        .container {
            text-align: center;
            background-color: #fff;
            padding: 20px 40px;
            border-radius: 10px;
            /* box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); */
        }
        h1 {
            font-size: 24px;
            margin-bottom: 10px; /* Reduced margin here */
        }
        p {
            font-size: 15px;
            color: #666;
            margin-top: 5px; /* Reduced margin here */
            margin-bottom: 26px; /* Adjusted margin for more spacing */
        }
        label {
            display: block;
            font-size: 14px;
            text-align: left;
            margin-bottom: 5px;
        }
        input[type="email"] {
            width: 93%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        button:hover {
            background-color: #0056b3;
        }
        .back-to-login {
            margin-top: 20px;
            font-size: 12px;
        }
        .back-to-login a {
            color: #007bff;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            padding-top: 10px; /* Added padding here to increase gap */
        }
        .back-to-login a:hover {
            text-decoration: underline;
        }
        .back-to-login a::before {
            margin-right: 8px;
        }
    </style>
</head>
<body>
    @yield('content')
</body>
</html>