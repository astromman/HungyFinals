@extends('layouts.account.forgotMaster')

@section('content')
<div class="container">
    <h1>Set a new password</h1>
    <p style="font-size: 15px;">Must be Atleast 8 characters</strong></p>
    <form>
        <label for="email" style="font-size: 11px; font-weight: bold;">Password</label>
        <input type="email" id="email" placeholder="Enter the code" required>
        <label for="email" style="font-size: 11px; font-weight: bold;">Confirm Password</label>
        <input type="email" id="email" placeholder="Enter the code" required>
        <button type="submit">Continue</button>
    </form>

    <div class="back-to-login">
        <a href="{{ route('login.form') }}"> ← Back to login</a>
    </div>
</div>
@endsection