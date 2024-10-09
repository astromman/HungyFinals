<!DOCTYPE html>
<html>

<head>
    <title>Welcome to Hungry Falcons</title>

    <style>
        .title {
            background-color: #0B1E59;
            font-family: Poppins, sans-serif;
            color: white;
            padding: 1rem;
        }

        .title h1 {
            margin-bottom: 0;
        }

        .subtitle {
            margin-top: 0;
            font-size: 13px;
        }
    </style>

</head>

<body>
    <div class="title">
        <h1>Hungry Falcons</h1>
        <p class="subtitle">Online Ordering Platform</p>
    </div>
    <h2>Hello, Concessionaire</h2>
    <p>Your account for <b>{{ $canteen }}</b> has been created. Below are your credentials:</p>
    <ul>
        <li><strong>Username: </strong>{{ $concessionaire->username }}</li>
        <li><strong>Password: </strong>{{ $password }}</li>
    </ul>
    <p>You can now login to the system using these credentials.</p>
    <p>Please change your password as soon as you login.</p>
    <p>Best Regards,<br>Hungry Falcons Team</p>
</body>

</html>