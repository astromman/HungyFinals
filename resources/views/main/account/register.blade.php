@extends('layouts.account.registerMaster')

@section('content')
<div class="row px-3">
    <div class="col-lg-5 pb-5">
        <img class="logo" src="/images/logo/logohf1.png">
    </div>
    <div class="col-lg-7">
        <div class="text-center pt-4 pb-2" style="color: white; font-family: Arial, sans-serif">
            <h2><b>SIGN-UP</b></h2>
        </div>
        @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
        @endif
        <div class="container pt-4" style="color: white;">
            <div class="row">
                <div class="col">
                    <form method="POST" action="{{ route('register.post') }}">
                        @csrf
                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <input placeholder="First Name" type="text" class="form-control @error('fname') is-invalid @enderror" id="fname" name="first_name" value="{{ old('first_name') }}" required>
                                @error('fname')
                                <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                            <div class="col-lg-6">
                                <input placeholder="Last Name" type="text" class="form-control @error('lname') is-invalid @enderror" id="lname" name="last_name" value="{{ old('last_name') }}" required>
                                @error('lname')
                                <p class="invalid-feedback">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        <div class="mb-3">
                            <input placeholder="Email Address" type="text" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                            <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <input placeholder="Mobile Number" type="tel" class="form-control @error('mobile_number') is-invalid @enderror" id="mobileNumber" name="contact_num" value="{{ old('contact_num') }}" required>
                            @error('mobile_number')
                            <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <input placeholder="Password" type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
                            @error('password')
                            <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <input placeholder="Confirm Password" type="password" class="form-control @error('confirm_password') is-invalid @enderror" id="confirmPassword" name="confirm_password" required>
                            @error('confirm_password')
                            <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="pt-3 my-3 text-center">
                            <button type="submit" class="btn btn-primary btn-rounded rounded-pill mb-3">Submit</button>
                            <p>Already have an account, Klasmeyt? <a href="{{ route('login.form') }}">Login here</a></p>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection