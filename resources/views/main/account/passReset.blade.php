@extends('layouts.account.forgotMaster')

@section('content')
<div class="container">
    <h1>Password reset</h1>
    <p style="font-size: 15px;">We sent a code to <strong>genejustine@gmail.com</strong></p>
    <form>
        <label for="email" style="font-size: 11px; font-weight: bold;">Authentication code</label>
        <input type="email" id="email" placeholder="Enter the code" required>
        <button type="submit">Continue</button>
    </form>

    <p style="font-size: 12px; margin-top: 23px;">Didn't receive the email? <a href="#" style="color: #007bff;">Click here</strong></p>

    <div class="back-to-login">
        <a href="{{ route('login.form') }}"> ← Back to login</a>
    </div>
</div>
@endsection