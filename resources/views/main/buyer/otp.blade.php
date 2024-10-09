<!DOCTYPE html>
<html>

<head>
    <title>Email Verification OTP</title>

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
    
    <h2>Welcome, Klasmeyt {{ $user->first_name }}!</h2>
    <p>Thank you for registering.</p>
    <p>Your One-Time Password (OTP) for verifying your email address is:</p>
    <h1>{{ $otp }}</h1>
    <p>This OTP is valid for 5 minutes.</p>
    <p>Best Regards,<br>Hungry Falcons Team</p>
</body>

</html>