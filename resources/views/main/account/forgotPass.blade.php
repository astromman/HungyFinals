@extends('layouts.account.forgotMaster')

@section('content')
<div class="container">
    <h1>Forgot password?</h1>
    <p style="font-size: 15px;">No worries, we'll send you reset instructions.</p>
    <form method="POST" action="{{ route('forgot.pass.email') }}">
        @csrf
        <label for="email">Email</label>
        <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" placeholder="Enter your email" required>
        @error('email')
        <span class="invalid-feedback">{{ $message }}</span>
        @enderror
        <button type="submit">Reset password</button>
    </form>
    <div class="back-to-login">
        <a href="{{ route('login.form') }}"> ← Back to login</a>
    </div>
</div>
@endsection