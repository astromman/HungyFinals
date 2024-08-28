@extends('layouts.account.forgotMaster')

@section('content')
<div class="container">
    <h1>Forgot password?</h1>
    <p style="font-size: 15px;">No worries, we'll send you reset instructions.</p>
    <form>
        @csrf
        <label for="email" style="font-size: 11px; font-weight: bold;">Email</label>
        <input type="email" id="email" placeholder="Enter your email" required>
        <button type="submit">Reset password</button>
    </form>
    <div class="back-to-login">
        <a href="{{ route('login.form') }}"> ← Back to login</a>
    </div>
</div>
@endsection