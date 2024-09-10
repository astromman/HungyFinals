<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Hungry Falcons</title>
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
  <style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins");

    * {
      box-sizing: border-box;
    }

    body {
      display: flex;
      background-color: #f6f5f7;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      font-family: "Poppins", sans-serif;
      overflow: hidden;
      height: 100vh;
    }

    h1 {
      font-weight: 700;
      letter-spacing: -1.5px;
      margin: 0;
    }

    h1.title {
      font-size: 45px;
      line-height: 45px;
      margin: 0;
      text-shadow: 0 0 10px rgba(16, 64, 74, 0.5);
    }

    p {
      font-size: 14px;
      font-weight: 100;
      line-height: 20px;
      letter-spacing: 0.5px;
      margin: 20px 0 30px;
      text-shadow: 0 0 10px rgba(16, 64, 74, 0.5);
    }

    span {
      font-size: 14px;
      margin-top: 25px;
    }

    a {
      color: #333;
      font-size: 14px;
      text-decoration: none;
      margin: 15px 0;
      transition: 0.3s ease-in-out;
    }

    a:hover {
      color: #757877;
    }

    .content {
      display: flex;
      width: 100%;
      height: 50px;
      align-items: center;
      justify-content: space-around;
    }

    .content .checkbox {
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .content input {
      accent-color: #333;
      width: 12px;
      height: 12px;
    }

    .content label {
      font-size: 14px;
      user-select: none;
      padding-left: 5px;
    }

    button {
      position: relative;
      width: 100%;
      border-radius: 20px;
      border: 1px solid #251a18;
      background-color: #0B1E59;
      color: #fff;
      font-family: Montserrat;
      font-size: 15px;
      font-weight: 700;
      margin: 10px;
      padding: 12px 80px;
      letter-spacing: 1px;
      text-transform: capitalize;
      transition: 0.3s ease-in-out;
    }

    button:hover {
      letter-spacing: 3px;
    }

    button:active {
      transform: scale(0.95);
    }

    button:focus {
      outline: none;
    }

    button.ghost {
      background-color: rgba(225, 225, 225, 0.2);
      border: 2px solid #fff;
      color: #fff;
    }

    button.ghost i {
      position: absolute;
      opacity: 0;
      transition: 0.3s ease-in-out;
    }

    button.ghost i.register {
      right: 70px;
    }

    button.ghost i.login {
      left: 70px;
    }

    button.ghost:hover i.register {
      right: 40px;
      opacity: 1;
    }

    button.ghost:hover i.login {
      left: 40px;
      opacity: 1;
    }

    form {
      background-color: #fff;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      padding: 0 50px;
      height: 100%;
      text-align: center;
    }

    input {
      background-color: #eee;
      border-radius: 10px;
      border: none;
      padding: 12px 15px;
      margin: 8px 0;
      width: 100%;
    }

    .container {
      background-color: #fff;
      border-radius: 25px;
      box-shadow: 0 14px 28px rgba(0, 0, 0, 0.25), 0 10px 10px rgba(0, 0, 0, 0.22);
      position: relative;
      overflow: hidden;
      width: 900px;
      max-width: 100%;
      min-height: 600px;
    }

    .form-container {
      position: absolute;
      top: 0;
      height: 100%;
      transition: all 0.6s ease-in-out;
    }

    .login-container {
      left: 0;
      width: 50%;
      z-index: 2;
    }

    .container.right-panel-active .login-container {
      transform: translateX(100%);
    }

    .register-container {
      left: 0;
      width: 50%;
      opacity: 0;
      z-index: 1;
    }

    .container.right-panel-active .register-container {
      transform: translateX(100%);
      opacity: 1;
      z-index: 5;
      animation: show 0.6s;
    }

    @keyframes show {

      0%,
      49.99% {
        opacity: 0;
        z-index: 1;
      }

      50%,
      100% {
        opacity: 1;
        z-index: 5;
      }
    }

    .overlay-container {
      position: absolute;
      top: 0;
      left: 50%;
      width: 50%;
      height: 100%;
      overflow: hidden;
      transition: transform 0.6s ease-in-out;
      z-index: 100;
    }

    .container.right-panel-active .overlay-container {
      transform: translate(-100%);
    }

    .overlay {
      background-color: #0B1E59;
      color: #fff;
      position: relative;
      left: -100%;
      height: 100%;
      width: 200%;
      transform: translateX(0);
      transition: transform 0.6s ease-in-out;
    }

    .container.right-panel-active .overlay {
      transform: translateX(50%);
    }

    .overlay-panel {
      position: absolute;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      padding: 0 40px;
      text-align: center;
      top: 0;
      height: 100%;
      width: 50%;
      transform: translateX(0);
      transition: transform 0.6s ease-in-out;
    }

    .overlay-left {
      transform: translateX(-20%);
    }

    .container.right-panel-active .overlay-left {
      transform: translateX(0);
    }

    .overlay-right {
      right: 0;
      transform: translateX(0);
    }

    .container.right-panel-active .overlay-right {
      transform: translateX(20%);
    }

    .social-container {
      margin: 10px 0;
      color: black;
    }

    .social-container a {
      border: 1px solid #ddd;
      border-radius: 50%;
      display: inline-flex;
      justify-content: center;
      align-items: center;
      margin: 0 5px;
      height: 40px;
      width: 40px;
    }

    footer {
      background-color: #222;
      color: #fff;
      font-size: 14px;
      bottom: 0;
      position: fixed;
      left: 0;
      right: 0;
      text-align: center;
      z-index: 999;
    }

    footer p {
      margin: 10px 0;
    }

    footer i {
      color: red;
    }

    footer a {
      color: #3c97bf;
      text-decoration: none;
    }

    @media only screen and (max-width: 768px) {
      .overlay {
        display: none;
      }

      .overlay-container {
        display: none;
      }

      .login-container,
      .register-container {
        width: 100%;
      }

      .container {
        width: 100%;
        min-height: 100vh;
        position: relative;
      }

      .mobile-buttons {
        position: absolute;
        bottom: 55px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        justify-content: center;
        width: 100%;
        gap: 10px;
        z-index: 10;
        /* Ensure buttons are above other elements */
      }

      .mobile-buttons button {
        border: 1px solid #251a18;
        background-color: #fff;
        color: #251a18;
        padding: 10px 20px;
        border-radius: 20px;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        /* Show pointer cursor */
      }

      .mobile-buttons button:hover {
        background-color: #251a18;
        color: #fff;
      }

      .mobile-buttons button:focus {
        outline: none;
      }

      .form-container {
        padding: 15px;
      }

      .form-container form {
        padding: 20px;
      }

      .social-container {
        justify-content: center;
      }

      .overlay-panel {
        display: none;
      }

      .overlay-container {
        display: none;
      }

      .container {
        border-radius: 0;
        box-shadow: none;
      }

      .container.right-panel-active .register-container,
      .container.right-panel-active .login-container {
        transform: none;
      }
    }

    .form-row {
      display: flex;
      gap: 20px;
      /* Add space between fields */
      /* margin-bottom: 15px; */
      /* Add some margin at the bottom of each row */
    }

    .form-row input {
      flex: 1;
    }
  </style>
</head>

<body>
  <div class="container" id="container" class="{{ $errors->hasAny(['first_name', 'last_name', 'email', 'contact_num', 'password', 'confirm_password']) ? 'right-panel-active' : '' }}">
    <div class="form-container register-container">
      <form method="POST" action="{{ route('register.post') }}">
        @csrf
        @if (session('error'))
        <div class="alert alert-danger" role="alert">
          {{ session('error') }}
        </div>
        @endif
        <h1>Register</h1>
        <div class="form-row">
          <div class="col-lg-6">
            <input name="first_name" type="text" placeholder="First Name" value="{{ old('first_name') }}">
            @error('first_name')
            <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>

          <div class="col-lg-6">
            <input name="last_name" type="text" placeholder="Last Name" value="{{ old('last_name') }}">
            @error('last_name')
            <small class="text-danger">{{ $message }}</small>
            @enderror
          </div>

        </div>

        <input name="email" type="email" placeholder="Email" value="{{ old('email') }}">
        @error('email')
        <small class="text-danger">{{ $message }}</small>
        @enderror

        <input name="contact_num" type="number" placeholder="Mobile Number" value="{{ old('contact_num') }}">
        @error('contact_num')
        <small class="text-danger">{{ $message }}</small>
        @enderror

        <input name="password" type="password" placeholder="Password">
        @error('password')
        <small class="text-danger">{{ $message }}</small>
        @enderror

        <input name="confirm_password" type="password" placeholder="Confirm Password">
        @error('confirm_password')
        <small class="text-danger">{{ $message }}</small>
        @enderror

        <button type="submit">Register</button>
        <span>or use your account</span>
        <div class="social-container">
          <a href="{{ route('google.redirect') }}" class="social"><i class="lni lni-google"></i></a>
        </div>
      </form>
    </div>

    <div class="form-container login-container">
      <form method="POST" action="{{ route('login.post') }}">
        @csrf
        @if (session('error'))
        <div class="alert alert-danger" role="alert">
          {{ session('error') }}
        </div>
        @endif
        <h1>Login</h1>

        <input name="username" type="text" class="form-control @error('error') is-invalid @enderror" placeholder="Username">
        @error('error')
        <small class="text-danger"> {{ $message }} </small>
        @enderror

        <input name="password" type="password" placeholder="Password">
        @error('error')
        <small class="text-danger"> {{ $message }} </small>
        @enderror

        <div class="content">
          <div class="checkbox">
            <input type="checkbox" name="checkbox" id="checkbox">
            <label>Remember me</label>
          </div>
          <div class="pass-link">
            <a href="{{ route('forgot.pass.form') }}">Forgot password?</a>
          </div>
        </div>
        <button type="submit">Login</button>
        <span>or use your account</span>
        <div class="social-container">
          <a href="{{ route('google.redirect') }}" class="social"><i class="lni lni-google"></i></a>
        </div>
      </form>
    </div>

    <div class="overlay-container">
      <div class="overlay">
        <div class="overlay-panel overlay-left">
          <!-- <img src="/images/logo/logohf1.png" class="title image-title"> -->
          <h1 class="title">Hungry Falcons</h1>
          <p>If you have an account, login here and start ordering now.</p>
          <button class="ghost" id="login">Login
            <i class="lni lni-arrow-left login"></i>
          </button>
        </div>
        <div class="overlay-panel overlay-right">
          <!-- <img src="/images/logo/logohf1.png" class="title image-title"> -->
          <h1 class="title">Hungry Falcons</h1>
          <p>Don't have an account yet, Klasmeyt? Click here.</p>
          <button class="ghost" id="register">Register
            <i class="lni lni-arrow-right register"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Mobile Buttons -->
    <div class="mobile-buttons">
      <button class="ghost" id="login-mobile">Login</button>
      <button class="ghost" id="register-mobile">Register</button>
    </div>

  </div>

  <script>
    const registerButton = document.getElementById("register");
    const loginButton = document.getElementById("login");
    const registerButtonMobile = document.getElementById("register-mobile");
    const loginButtonMobile = document.getElementById("login-mobile");
    const container = document.getElementById("container");

    registerButton.addEventListener("click", () => {
      container.classList.add("right-panel-active");
    });

    loginButton.addEventListener("click", () => {
      container.classList.remove("right-panel-active");
    });

    registerButtonMobile.addEventListener("click", () => {
      container.classList.add("right-panel-active");
    });

    loginButtonMobile.addEventListener("click", () => {
      container.classList.remove("right-panel-active");
    });

    // Check if there are validation errors on the registration form
    if ("{{ $errors->hasAny(['first_name', 'last_name', 'email', 'contact_num', 'password', 'confirm_password']) }}") {
      container.classList.add("right-panel-active");
    }
  </script>
</body>

</html>