<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

  <link rel="stylesheet" href="style.css">

  <title>Hungry FalCONs</title>

  <style>
    @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700;800&display=swap");

    * {
      padding: 0;
      margin: 0;
      box-sizing: border-box;
    }

    body,
    input {
      font-family: 'Poppins', sans-serif;
    }

    .container {
      position: relative;
      width: 100%;
      min-height: 100vh;
      background-color: #fff;
      overflow: hidden;
    }

    .container::before {
      content: '';
      position: absolute;
      width: 2000px;
      height: 2000px;
      border-radius: 50%;
      background-image: linear-gradient(-45deg, #0B1E59, #0B1E59);
      top: -10%;
      right: 48%;
      transform: translateY(-50%);
      z-index: 6;
      transition: 1.8s ease-in-out;
    }

    .forms-container {
      position: absolute;
      width: 100%;
      height: 100%;
      top: 0;
      left: 0;
    }

    .signin-signup {
      position: absolute;
      top: 50%;
      left: 75%;
      transform: translate(-50%, -50%);
      width: 50%;
      display: grid;
      grid-template-columns: 1fr;
      z-index: 5;
      transition: 1s 0.7s ease-in-out;
    }

    form {
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      padding: 0 5rem;
      overflow: hidden;
      grid-column: 1 / 2;
      grid-row: 1 / 2;
      transition: 0.2s 0.7s ease-in-out;
    }

    form.sign-in-form {
      z-index: 2;
    }

    form.sign-up-form {
      z-index: 1;
      opacity: 0;
    }

    .title {
      font-size: 2.2rem;
      color: #444;
      margin-bottom: 10px;
    }

    .input-field:not(.name-container .input-field) {
      max-width: 380px;
      width: 350px;
      height: 50px;
      margin-bottom: 10px;
      background-color: #f0f0f0;
      display: grid;
      grid-template-columns: 15% 85%;
      /* padding: 0.4rem; */
      border-radius: 15px;
      /* Makes the input field round */
    }

    .input-field i {
      text-align: center;
      line-height: 55px;
      color: #acacac;
      font-size: 1.1rem;
    }

    .input-field input {
      background: none;
      outline: none;
      border: none;
      line-height: 1;
      font-weight: 600;
      font-size: 1.1rem;
      color: #333;
    }

    .input-field input::placeholder {
      color: #aaa;
      font-weight: 500;
    }

    .btn {
      width: 150px;
      height: 49px;
      border: none;
      outline: none;
      border-radius: 49px;
      cursor: pointer;
      background-color: #0B1E59;
      color: #fff;
      text-transform: uppercase;
      font-weight: 600;
      margin: 10px 0;
      transition: 0.5s;
    }

    .btn:hover {
      background-color: #8dc3f2;
    }

    .social-text {
      padding: 0.7rem 0;
      font-size: 1rem;
    }

    .social-media {
      display: flex;
      justify-content: center;
    }

    .social-icon {
      height: 46px;
      width: 46px;
      border: 1px solid #333;
      margin: 0 0.45rem;
      display: flex;
      justify-content: center;
      align-items: center;
      text-decoration: none;
      color: #333;
      font-size: 1.1rem;
      border-radius: 50%;
      transition: 0.3s;
    }

    .social-icon:hover {
      color: #0077B6;
      border-color: #0077B6;
    }

    .image {
      width: 100%;
      transition: .9s .6s ease-in-out;

    }

    .panels-container {
      position: absolute;
      width: 100%;
      height: 100%;
      top: 0;
      left: 0;
      display: grid;
      grid-template-columns: repeat(2, 1fr);
    }

    .panel {
      display: flex;
      flex-direction: column;
      align-items: flex-end;
      justify-content: space-around;
      text-align: center;
      z-index: 7;
    }

    .left-panel {
      pointer-events: all;
      padding: 3rem 17% 2rem 12%;
    }

    .right-panel {
      pointer-events: none;
      padding: 3rem 12% 2rem 17%;
    }

    .panel .content {
      color: #fff;
      transition: .9s .6s ease-in-out;
    }

    .panel h3 {
      font-weight: 600;
      line-height: 1;
      font-size: 1.5rem;
    }

    .panel p {
      font-size: 0.95rem;
      padding: 0.7rem 0;
    }

    .btn.transparent {
      margin: 0;
      background: none;
      border: 2px solid #fff;
      width: 130px;
      height: 41px;
      font-weight: 600;
      font-size: 0.8rem;
    }

    .right-panel .content,
    .right-panel .image {
      transform: translateX(800px);
    }

    /* Animation css */

    .container.sign-up-mode:before {
      transform: translate(100%, -50%);
      right: 52%;
    }

    .container.sign-up-mode .left-panel .image,
    .container.sign-up-mode .left-panel .content {
      transform: translateX(-800px);
    }

    .container.sign-up-mode .right-panel .image,
    .container.sign-up-mode .right-panel .content {
      transform: translateX(0px);
    }

    .container.sign-up-mode .left-panel {
      pointer-events: none;
    }

    .container.sign-up-mode .right-panel {
      pointer-events: all;
    }

    .container.sign-up-mode .signin-signup {
      left: 25%;
    }

    .container.sign-up-mode form.sign-in-form {
      z-index: 1;
      opacity: 0;
    }

    .container.sign-up-mode form.sign-up-form {

      z-index: 2;
      opacity: 1;
    }

    /* Responsiveness */

    /* Adjusting the size of the panels and their content for smaller screens */
    @media (max-width: 870px) {
      .container {
        min-height: 800px;
        height: 100vh;
      }

      .signin-signup {
        width: 100%;
        top: 100%;
        transform: translate(-50%, -100%);
        transition: 1s 0.8s ease-in-out;
      }

      .signin-signup,
      .container.sign-up-mode .signin-signup {
        left: 50%;
        z-index: 1;
        /* Ensure form is above other elements */
      }

      .panels-container {
        grid-template-columns: 1fr;
        grid-template-rows: 1fr 2fr 1fr;
      }

      .panel {
        flex-direction: row;
        justify-content: center;
        align-items: center;
        padding: 2rem 6%;
        /* Reduced padding */
        grid-column: 1 / 2;
      }

      .right-panel {
        grid-row: 3 / 4;
      }

      .left-panel {
        grid-row: 1 / 2;
      }

      .image {
        width: 150px;
        /* Smaller image */
        transition: transform 0.9s ease-in-out;
        transition-delay: 0.6s;
      }

      .panel .content {
        padding-right: 10%;
        /* Reduced padding */
        transition: transform 0.9s ease-in-out;
        transition-delay: 0.8s;
      }

      .panel h3 {
        font-size: 1rem;
        /* Smaller heading */
      }

      .panel p {
        font-size: 0.8rem;
        /* Smaller paragraph */
        padding: 0.5rem 0;
      }

      .btn.transparent {
        width: 100px;
        height: 30px;
        font-size: 0.7rem;
      }

      .container:before {
        width: 1200px;
        /* Reduced circle size */
        height: 1200px;
        transform: translateX(-50%);
        left: 30%;
        bottom: 40%;
        right: initial;
        top: initial;
        transition: 2s ease-in-out;
      }


      .container.sign-up-mode:before {
        /* inadjust to 120% para bumaba circle sa sign up page */
        transform: translate(-50%, 110%);
        bottom: 32%;
        right: initial;
      }

      .container.sign-up-mode .left-panel .image,
      .container.sign-up-mode .left-panel .content {
        transform: translateY(-400px);
      }

      .container.sign-up-mode .right-panel .image,
      .container.sign-up-mode .right-panel .content {
        transform: translateY(0px);
      }

      .right-panel .image,
      .right-panel .content {
        transform: translateY(200px);
      }

      .container.sign-up-mode .signin-signup {
        top: 2%;
        transform: translate(-50%, 0);
      }
    }

    @media (max-width: 570px) {
      form {
        padding: 0 1.5rem;
      }

      .image {
        display: none;
        /* Hide the image for very small screens */
      }

      .panel .content {
        padding: 0.5rem 2rem;
      }

      /* para bumaba yung content ng sign in */
      .panel #sign-in-content {
        margin-top: 520px;
      }

      .container {
        padding: 0.5rem;
      }

      .panel {
        flex-direction: column;
        /* Stack content vertically */
        text-align: center;
      }

      .panel h3 {
        font-size: 0.9rem;
        /* Smaller heading */
      }

      .panel p {
        font-size: 0.75rem;
        /* Smaller paragraph */
      }

      .btn.transparent {
        width: 90px;
        /* Smaller button */
        height: 28px;
        font-size: 0.6rem;
      }

      .container:before {
        width: 1300px;
        /* Reduced circle size */
        height: 1000px;
        bottom: 72%;
        left: 50%;
      }

      .container.sign-up-mode:before {
        bottom: 28%;
        left: 50%;
      }

      .container.sign-up-mode .left-panel .image,
      .container.sign-up-mode .left-panel .content {
        transform: translateY(-150px);
      }

      .container.sign-up-mode .right-panel .image,
      .container.sign-up-mode .right-panel .content {
        transform: translateY(0px);
      }
    }

    .password-instructions-box {
      background-color: #f0f0f0;
      padding: 10px;
      border: 1px solid #ddd;
      border-radius: 8px;
      margin-bottom: 6px;
      max-width: 380px;
      width: 350px;
    }

    .password-instructions {
      font-size: 12px;
      color: #888;
      text-align: center;
      margin-bottom: 10px;
    }

    .password-requirements {
      list-style: none;
      padding: 0;
    }

    .password-requirements li {
      display: flex;
      align-items: center;
      font-size: 12px;
      margin-bottom: 3px;
      color: #555;
    }

    .requirement-circle {
      height: 15px;
      width: 15px;
      border-radius: 50%;
      border: 2px solid #ddd;
      margin-right: 10px;
      background-color: white;
      display: inline-block;
    }

    .requirement-circle.active {
      background-color: green;
      /* Circle turns green when the condition is met */
      border-color: green;
    }

    .name-container {
      display: flex;
      flex-direction: row;
      gap: 12px;
    }

    .name-container input {
      width: 172px;
    }

    .name-container .input-field {
      max-width: 380px;
      width: 170px;
      height: 50px;
      margin-bottom: 8px;
      background-color: #f0f0f0;
      display: grid;
      grid-template-columns: 15% 85%;
      border-radius: 15px;
      /* Makes the input field round */
    }

    /* Modal Styles */
    .modal {
      display: none;
      /* Hidden by default */
      position: fixed;
      z-index: 100;
      /* Sit on top */
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0, 0, 0, 0.4);
      /* Black w/ opacity */
      padding-top: 60px;
    }

    .modal-content {
      background-color: #fff;
      margin: 5% auto;
      padding: 30px;
      /* Increased padding */
      border-radius: 8px;
      /* Rounded corners */
      border: none;
      box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.2);
      /* Subtle shadow */
      width: 80%;
      max-width: 600px;
    }

    .modal h2 {
      font-size: 1.8rem;
      margin-bottom: 15px;
      font-weight: 700;
      color: #333;
    }

    .modal p {
      font-size: 1rem;
      color: #666;
      margin-bottom: 20px;
      line-height: 1.6;
    }

    label {
      font-size: 0.95rem;
      color: #444;
      display: flex;
      align-items: center;
    }

    input[type="checkbox"] {
      margin-right: 10px;
      transform: scale(1.2);
      /* Make the checkbox slightly larger */
    }

    .close {
      color: #aaa;
      float: right;
      font-size: 24px;
      font-weight: bold;
      cursor: pointer;
    }

    .close:hover,
    .close:focus {
      color: #000;
      text-decoration: none;
    }

    /* Button Styling */
    #agreeButton {
      width: 100%;
      padding: 12px 20px;
      border: none;
      border-radius: 5px;
      background-color: #0B1E59;
      color: #fff;
      font-size: 1rem;
      font-weight: 600;
      cursor: not-allowed;
      opacity: 0.5;
    }

    #agreeButton.enabled {
      cursor: pointer;
      opacity: 1;
    }

    #agreeButton:hover:enabled {
      background-color: #8dc3f2;
    }
  </style>
</head>

<body>
  <div class="container @if ($errors->has('first_name') || $errors->has('last_name') || $errors->has('email') || $errors->has('contact_num') || $errors->has('password') || $errors->has('confirm_password') || $errors->has('g-recaptcha-response')) sign-up-mode @endif">
    <div class="forms-container">
      <div class="signin-signup">
        <!-- Login Form -->
        <form action="{{ route('login.post') }}" method="POST" class="sign-in-form">
          @csrf
          @if (session('error'))
          <div class="alert alert-danger" role="alert">
            {{ session('error') }}
          </div>
          @endif
          <h2 class="title">Sign in</h2>
          <div class="input-field">
            <i class="fas fa-user"></i>
            <input name="username" type="text" placeholder="Username">
            @error('username')
            <p style="color: red; font-size: 9px; margin-top:5px">{{$message}}</p>
            @enderror
          </div>
          <div class="input-field">
            <i class="fas fa-lock"></i>
            <input name="password" type="password" placeholder="Password">
            @error('password')
            <p style="color: red; font-size: 9px; margin-top:5px">{{$message}}</p>
            @enderror
          </div>
          <input type="submit" value="Login" class="btn solid">

          <p class="social-text"> Or Sign in with Google</p>
          <div class="social-media">
            <a href="{{ route('google.redirect') }}" class="social-icon">
              <i class="fab fa-google"></i>
            </a>
          </div>
        </form>

        <!-- Signup Form -->
        <form action="{{ route('register.post') }}" method="POST" class="sign-up-form" id="register-form-id">
          @csrf
          <h2 class="title">Register</h2>

          <div class="row">
            <div class="flex">
              @error('first_name')
              <p style="color: red; font-size: 9px;">{{$message}}</p>
              @enderror
              <div class="input-field">
                <i class="fas fa-user"></i>
                <input name="first_name" type="text" placeholder="First Name" value="{{ old('first_name') }}">
              </div>
            </div>

            <div class="flex">
              @error('last_name')
              <p style="color: red; font-size: 9px;">{{$message}}</p>
              @enderror
              <div class="input-field">
                <i class="fas fa-user"></i>
                <input name="last_name" type="text" placeholder="Last Name" value="{{ old('last_name') }}">
              </div>
            </div>

            <div class="flex" style="flex-direction: column;">
              @error('email')
              <p style="color: red; font-size: 9px; margin-top:5px;">{{$message}}</p>
              @enderror
              <div class="input-field">
                <i class="fas fa-user"></i>
                <input name="email" type="text" placeholder="Email" value="{{ old('email') }}">
              </div>
            </div>

            <div class="flex" style="flex-direction: column;">
              @error('contact_num')
              <p style="color: red; font-size: 9px; margin-top:5px">{{$message}}</p>
              @enderror
              <div class="input-field">
                <i class="fas fa-user"></i>
                <input name="contact_num" type="text" placeholder="Mobile Number" value="{{ old('contact_num') }}">
              </div>
            </div>

            <div class="flex" style="flex-direction: column;">
              @error('password')
              <p style="color: red; font-size: 9px; margin-top:5px">{{$message}}</p>
              @enderror
              <div class="input-field">
                <i class="fas fa-envelope"></i>
                <input name="password" type="password" id="password" placeholder="Password">
              </div>
            </div>

            <div class="flex" style="flex-direction: column;">
              @error('confirm_password')
              <p style="color: red; font-size: 9px; margin-top:5px">{{$message}}</p>
              @enderror
              <div class="input-field">
                <i class="fas fa-lock"></i>
                <input name="confirm_password" type="password" id="password"
                  placeholder="Confirm Password">
              </div>
            </div>
          </div>

          <!-- Password Instruction Box -->
          <div class="password-instructions-box">
            <p class="password-instructions">Password must meet the following requirements:</p>
            <ul class="password-requirements">
              <li><span class="requirement-circle" id="capital-circle"></span> Have at least one capital
                letter</li>
              <li><span class="requirement-circle" id="length-circle"></span> Must be at least 8
                characters long</li>
              <li><span class="requirement-circle" id="number-circle"></span> Have at least one number
              </li>
              <li><span class="requirement-circle" id="special-circle"></span> Have at least one special
                character (!@#$%^&*)</li>
            </ul>
          </div>

          <!-- reCAPTCHA v3 Widget -->
          {!! NoCaptcha::displaySubmit('register-form-id', 'Sign up', ['class' => 'btn solid']) !!}

          <!-- reCAPTCHA error handling -->
          @if ($errors->has('g-recaptcha-response'))
          <small class="text-danger">{{ $errors->first('g-recaptcha-response') }}</small>
          @endif

          <!-- <input type="submit" value="Sign up" class="btn solid"> -->

          <p class="social-text"> Or Sign up with social platforms</p>
          <div class="social-media">
            <a href="{{ route('google.redirect') }}" class="social-icon">
              <i class="fab fa-google"></i>
            </a>
          </div>
        </form>
      </div>
    </div>

    <div class="panels-container">
      <div class="panel left-panel">
        <div class="content">
          <h3> Don't have an account yet, Klasmeyt?</h3>
          <p> Create one account now for exclusive benefits and features</p>
          <button class="btn transparent" id="sign-up-btn"> Sign up</button>
        </div>

        <img src="{{ asset('') }}" class="image" alt="">
      </div>
      <div class="panel right-panel">
        <div class="content" id="sign-in-content">
          <h3> Already have an account ?</h3>
          <p> Discover more deals with your existing account</p>
          <button class="btn transparent" id="sign-in-btn"> Sign in</button>
        </div>

        <img src="{{ asset('images/2.png') }}" class="image" alt="">
      </div>
    </div>
  </div>

  <!-- Terms of Service Modal -->
  <div id="termsModal" class="modal">
    <div class="modal-content">
      <span class="close">&times;</span>
      <h2>Terms of Agreement & Data Privacy</h2>
      <p>
        By signing up, you agree to our terms of service and privacy policy. We collect and use your personal
        data
        to provide services and improve our platform. Please review our privacy policy for detailed information
        on
        how we handle your data.
      </p>

      <!-- Checkbox to accept the terms -->
      <label for="agreeTerms">
        <input type="checkbox" id="agreeTerms"> I have read and agree to the terms of service and privacy policy
      </label>

      <!-- A submit button that will only enable once checkbox is clicked -->
      <button id="agreeButton" class="btn" disabled>Agree and Close</button>
    </div>
  </div>


  <script>
    // SLIDING
    const sign_in_btn = document.querySelector("#sign-in-btn");
    const sign_up_btn = document.querySelector("#sign-up-btn");
    const container = document.querySelector(".container");
    sign_up_btn.addEventListener('click', () => {
      container.classList.add("sign-up-mode");
    })
    sign_in_btn.addEventListener('click', () => {
      container.classList.remove("sign-up-mode");
    })

    // PASSWORD VALIDATION
    const passwordInput = document.getElementById('password');
    const capitalCircle = document.getElementById('capital-circle');
    const lengthCircle = document.getElementById('length-circle');
    const numberCircle = document.getElementById('number-circle');
    const specialCircle = document.getElementById('special-circle');

    passwordInput.addEventListener('input', function() {
      const password = passwordInput.value;

      // Check for capital letter
      const hasCapital = /[A-Z]/.test(password);
      if (hasCapital) {
        capitalCircle.classList.add('active');
      } else {
        capitalCircle.classList.remove('active');
      }

      // Check for length
      if (password.length >= 8) {
        lengthCircle.classList.add('active');
      } else {
        lengthCircle.classList.remove('active');
      }

      // Check for number
      const hasNumber = /\d/.test(password);
      if (hasNumber) {
        numberCircle.classList.add('active');
      } else {
        numberCircle.classList.remove('active');
      }

      // Check for special character
      const hasSpecial = /[!@#$%^&*]/.test(password);
      if (hasSpecial) {
        specialCircle.classList.add('active');
      } else {
        specialCircle.classList.remove('active');
      }
    });

    // Get modal, close button, and checkbox elements
    const modal = document.getElementById("termsModal");
    const signUpButton = document.getElementById("sign-up-btn");
    const span = document.getElementsByClassName("close")[0];
    const agreeCheckbox = document.getElementById("agreeTerms");
    const agreeButton = document.getElementById("agreeButton");

    // Open modal when "Sign Up" button is clicked
    signUpButton.addEventListener('click', (e) => {
      e.preventDefault(); // Prevent default form submission
      modal.style.display = "block";
    });

    // Disable the "Agree" button if checkbox is not checked
    // Enable the button when checkbox is checked
    agreeCheckbox.addEventListener('change', function() {
      if (agreeCheckbox.checked) {
        agreeButton.disabled = false; // Enable button
        agreeButton.classList.add("enabled");
      } else {
        agreeButton.disabled = true; // Disable button
        agreeButton.classList.remove("enabled");
      }
    });

    // Close modal when user clicks the "Agree and Close" button
    agreeButton.addEventListener('click', function() {
      if (agreeCheckbox.checked) {
        modal.style.display = "none"; // Only close modal if checkbox is checked
      }
    });

    // Close modal if user clicks the "x" (Close) button, but only if the checkbox is checked
    span.onclick = function() {
      if (agreeCheckbox.checked) {
        modal.style.display = "none"; // Only close if checkbox is checked
      }
    }

    // Close modal if user clicks outside the modal, but only if the checkbox is checked
    window.onclick = function(event) {
      if (event.target == modal && agreeCheckbox.checked) {
        modal.style.display = "none"; // Only close if checkbox is checked
      }
    }
  </script>

  {!! NoCaptcha::renderJs() !!}
</body>

</html>