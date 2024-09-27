<div class="container">
    @if (session('success'))
    <div class="alert alert-info" role="alert">
        <strong>{{ session('success') }}</strong>
    </div>
    @endif
    <h1>Enter OTP:</h1>
    <p style="font-size: 15px;">We sent a code to your email. {{ $censoredEmail }}</p>
    <form action="{{ route('verify.otp.post') }}" method="POST">
        @csrf
        <label for="otp" style="font-size: 11px; font-weight: bold;">Authentication code</label>
        <input type="text" name="otp" placeholder="Enter the code" required>
        <button type="submit">Verify</button>
    </form>

    <p style="font-size: 12px; margin-top: 23px;">Didn't receive the email?
        <a href="{{ route('resend.otp') }}" style="color: #007bff;">Click here</a>
    </p>
</div>

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
        /* box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); */
    }

    h1 {
        font-size: 24px;
        margin-bottom: 10px;
        /* Reduced margin here */
    }

    p {
        font-size: 15px;
        color: #666;
        margin-top: 5px;
        /* Reduced margin here */
        margin-bottom: 26px;
        /* Adjusted margin for more spacing */
    }

    label {
        display: block;
        font-size: 14px;
        text-align: left;
        margin-bottom: 5px;
    }

    input[type="text"] {
        width: 100%;
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
        padding-top: -1px;
        /* Added padding here to increase gap */
    }

    .back-to-login a:hover {
        text-decoration: underline;
    }

    .back-to-login a::before {
        margin-right: 8px;
    }
</style>