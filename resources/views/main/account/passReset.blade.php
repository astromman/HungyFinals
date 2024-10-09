@extends('layouts.account.forgotMaster')

@section('content')
<div class="container">
    <h1>Password reset</h1>
    <p style="font-size: 15px;">We sent a code to your email. {{ $censoredEmail }}</p>
    <form method="POST" action="{{ route('verify.reset.otp') }}">
        @csrf
        <label for="otp">Authentication code</label>
        <input type="text" id="otp" name="otp" class="form-control" placeholder="Enter the code" required>
        @error('otp')
        <span class="invalid-feedback">{{ $message }}</span>
        @enderror
        <button type="submit">Continue</button>
    </form>

    <p style="font-size: 12px; margin-top: 23px;">Didn't receive the email? <a href="#" style="color: #007bff;">Click here</strong></p>

    <div class="back-to-login">
        <a href="{{ route('login.form') }}"> ← Back to login</a>
    </div>
</div>
@endsection