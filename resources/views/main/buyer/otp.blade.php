<!DOCTYPE html>
<html>

<head>
    <title>Email Verification OTP</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" class="href">
</head>

<body>
    <h1 class="text-center">Welcome, Klasmeyt!</h1>
    <div class="d-flex justify-content-center align-items-center" style="background-color: #0B1E59; height: 200px;">
        <img src="images/logo/logohf1.png" alt="images/logo/logohf1.png" class="img-fluid" style="max-height: 100%; max-width: 100%; object-fit: contain;">
    </div>

    <h2>Hello {{ $user->first_name }},</h2>
    <p>Your One-Time Password (OTP) for verifying your email address is:</p>
    <h1>{{ $otp }}</h1>
    <p>This OTP is valid for 10 minutes.</p>
</body>

</html>