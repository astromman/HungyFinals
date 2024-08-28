@extends('layouts.account.loginMaster')

@section('content')
<!-- FORM PART -->
<div class="col-lg-6 col-md-12 px-4">
    <div class="mb-3 pt-3" style="color:white; font-family: arial, sans-serif;">
        <p style="margin-bottom: 5px; margin-top: -5px; font-weight: bold;">START NOW TO ORDER</p>
        <h1 style="margin-top: -10; font-size: 55px; font-weight: bold;">Log-in your account</h1>
    </div>
    <form method="POST" action="{{ route('login.post') }}">
        @csrf
        <div class="mb-2">
            <input name="username" type="text" placeholder="Username" class="form-control @error('error') is-invalid @enderror" id="email" style="font-size: 20px;">
            @error('error')
            <small class="invalid-feedback"> {{ $message }} </small>
            @enderror
        </div>

        <div class="pb-2">
            <input name="password" type="password" placeholder="Password" class="form-control" id="password" style="font-size: 20px;">
            @error('error')
            <small class="text-danger"> {{ $message }} <a href="" class="text-danger">Forgot Password?</a> </small>
            @enderror
        </div>

        <div class="mx-1 mb-3" style="font-size: 15px;">
            <div class="row">
                <div class="col-lg-6 px-2">
                    <input type="checkbox" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label pt-1" for="exampleCheck1" style="color:white;">Remember me</label>
                </div>
                <div class="col-lg-6 pt-1">
                    <a href="" style="float:right;">Forgot Password?</a>
                </div>
            </div>

        </div>

        <!-- BUTTON PARTS -->
        <div class="text-center">
            <div class="col-lg-12 pb-3 pt-3 d-flex justify-content-center" style="color: white;">
                <button type="submit" class="btn btn-login btn-rounded rounded-pill">Login</button>

            </div>
            <div class="col-lg-12">
                <p style="color: white;">Don't have an account yet, Klasmeyt? <a href="{{ route('register.form') }}">Sign-up here</a></p>
            </div>

            <!-- OR PART -->
            <div class="container">
                <div class="row justify-content-centers">
                    <div class="col-lg-5">
                        <hr style="border-color: white;">
                    </div>
                    <p class="col" style="color: white;">OR</p>
                    <div class="col-lg-5">
                        <hr style="border-color: white;">
                    </div>
                </div>
            </div>

            <!-- O-Auth -->
            <div class="mb-3">
                <a href="" class="btn btn-rounded rounded-pill" style="width: 320px; height: 50px; font-size: large; background-color: white;">
                    <div class="row">
                        <div class="col-2">
                            <img src="images/logo/google.png" alt="Google Logo" style="width: 100%; height: auto;">
                        </div>
                        <div class="col-10 pe-5">
                            Login with Google
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </form>
</div>

<!-- LOGO PART -->
<div class=" col-lg-6 col-md-12 px-4 d-flex justify-content-center align-items-center text-center">
    <img class="logo" src="/images/logo/logohf1.png">
</div>
@endsection