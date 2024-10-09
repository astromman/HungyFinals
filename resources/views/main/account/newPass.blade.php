@extends('layouts.account.forgotMaster')

@section('content')
<div class="container">
    <h1>Set a new password</h1>
    <p style="font-size: 15px;">Must be Atleast 8 characters</strong></p>
    <form method="POST" action="{{ route('reset.password') }}">
        @csrf
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter new password" required>
        <label for="confirm_password">Confirm Password</label>
        <input type="password" id="confirm_password" name="confirm_password" placeholder="Confirm new password" required>
        <button type="submit">Continue</button>
    </form>

    <div class="back-to-login">
        <a href="{{ route('login.form') }}"> ← Back to login</a>
    </div>
</div>
@endsection