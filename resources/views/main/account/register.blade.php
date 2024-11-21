<!DOCTYPE html>
<html>

<head>
    <title>Hungry FalCONs</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <script src="https://kit.fontawesome.com/a81368914c.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        * {
            padding: 0;
            margin: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            overflow: hidden;
        }

        .wave {
            position: fixed;
            bottom: 0;
            left: 0;
            height: 100%;
            z-index: -1;
        }

        .container {
            width: 100vw;
            height: 100vh;
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            grid-gap: 7rem;
            padding: 0 2rem;
            overflow-y: auto;
            /* Make the container scrollable */
        }

        .img {
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        .login-content {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            text-align: center;
            overflow-y: auto;
            /* Allow the login content to scroll */
            max-height: 100vh;
            /* Limit the height */
        }

        .img img {
            width: 500px;
        }

        form {
            width: 360px;
        }

        .login-content img {
            height: 100px;
        }

        .login-content h2 {
            margin: 15px 0;
            color: #333;
            text-transform: uppercase;
            font-size: 2.9rem;
        }

        .login-content .input-div {
            position: relative;
            display: grid;
            grid-template-columns: 7% 93%;
            margin: 25px 0;
            padding: 5px 0;
            border-bottom: 2px solid #d9d9d9;
        }

        .login-content .input-div.one {
            margin-top: 0;
        }

        .i {
            color: #d9d9d9;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .i i {
            transition: .3s;
        }

        .input-div>div {
            position: relative;
            height: 45px;
        }

        .input-div>div>h5 {
            position: absolute;
            left: 10px;
            top: 50%;
            transform: translateY(-50%);
            color: #999;
            font-size: 18px;
            transition: .3s;
        }

        .input-div:before,
        .input-div:after {
            content: '';
            position: absolute;
            bottom: -2px;
            width: 0%;
            height: 2px;
            background-color: #5DA9E2;
            transition: .4s;
        }

        .input-div:before {
            right: 50%;
        }

        .input-div:after {
            left: 50%;
        }

        .input-div.focus:before,
        .input-div.focus:after {
            width: 50%;
        }

        .input-div.focus>div>h5 {
            top: -5px;
            font-size: 15px;
        }

        .input-div.focus>.i>i {
            color: #5DA9E2;
        }

        .input-div>div>input {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            border: none;
            outline: none;
            background: none;
            padding: 0.5rem 0.7rem;
            font-size: 1.2rem;
            color: #555;
            font-family: 'poppins', sans-serif;
        }

        .input-div.pass {
            margin-bottom: 4px;
        }

        a {
            display: block;
            text-align: right;
            text-decoration: none;
            color: #999;
            font-size: 0.9rem;
            transition: .3s;
        }

        a:hover {
            color: #5DA9E2;
        }

        .btn {
            display: block;
            width: 100%;
            height: 50px;
            border-radius: 25px;
            outline: none;
            border: none;
            background-color: #5DA9E2;
            background-size: 200%;
            font-size: 1.2rem;
            color: #fff;
            font-family: 'Poppins', sans-serif;
            text-transform: uppercase;
            margin: 1rem 0;
            cursor: pointer;
            transition: .5s;
        }

        .btn:hover {
            background-position: right;
        }


        @media screen and (max-width: 1050px) {
            .container {
                grid-gap: 5rem;
            }
        }

        @media screen and (max-width: 1000px) {
            form {
                width: 290px;
            }

            .login-content h2 {
                font-size: 2.4rem;
                margin: 8px 0;
            }

            .img img {
                width: 400px;
            }
        }

        @media screen and (max-width: 900px) {
            .container {
                grid-template-columns: 1fr;
            }

            .img {
                display: none;
            }

            .wave {
                display: none;
            }

            .login-content {
                justify-content: center;
            }
        }


        /* Modal Styles */
        .modal {
            display: flex;
            align-items: center;
            justify-content: center;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 10;
            overflow-y: auto;
            /* Make modal scrollable */
        }

        .modal-content {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            width: 80%;
            max-width: 400px;
            overflow-y: auto;
            /* Allow the modal content to scroll */
            max-height: 90vh;
            /* Constrain the modal height */
        }

        .modal-content h3 {
            margin-bottom: 15px;
        }

        .modal-content p {
            margin-bottom: 20px;
            font-size: 1rem;
            color: #555;
        }

        .modal-content label {
            display: flex;
            align-items: center;
            font-size: 0.9rem;
        }

        .modal-content input[type="checkbox"] {
            margin-right: 10px;
        }

        .modal-content .modal-btn {
            margin-top: 15px;
            width: 100%;
            height: 40px;
            border: none;
            background-color: skyblue;
            color: white;
            font-size: 1rem;
            border-radius: 5px;
            cursor: pointer;
        }

        .validation-checklist {
            list-style: none;
            padding: 20px;
            margin-top: 15px;
            background-color: #dbd7e5;
            border-radius: 25px;


        }

        .validation-checklist li {
            display: flex;
            align-items: center;
            margin-bottom: 8px;
            color: #3d3b43;
        }

        .validation-checklist li.valid {
            color: blue;
        }

        .circle {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: #999;
            margin-right: 10px;
        }

        .circle.valid {
            background-color: blue;
        }

        .modal-content .modal-btn:disabled {
            background-color: #ccc;
        }

        /* Responsive styling for mobile */
        @media only screen and (max-width: 600px) {
            .container {
                align-items: flex-start;
                padding: 10px;
            }

            .login-content {
                width: 100%;
                max-width: 100%;
            }

            /* Make sure the input form scrolls if it overflows */
            .login-content form {
                overflow-y: auto;
                max-height: calc(100vh - 40px);
            }
        }

        /* Styling for inputs and buttons */
        .input-div,
        .links-container,
        .validation-checklist,
        .btn {
            margin-bottom: 15px;
        }

        .links-container {
            display: flex;
            justify-content: center;
            margin-top: 15px;
        }

        .links-container .left {
            text-align: center;
        }

        .links-container .right {
            text-align: right;
        }

        .validation-error {
            color: red;
            font-size: 0.9rem;
            margin-top: 5px;
        }

        /* Privacy checkbox styles */
        .privacy-checkbox {
            display: flex;
            align-items: center;
            font-size: 0.9rem;
            margin-bottom: 15px;
        }

        .privacy-checkbox input {
            margin-right: 10px;
        }
    </style>

</head>

<body>
    <img class="wave" src="images/bg/wave2.png">
    <div class="container">
        <div class="img">
        <img src="images/bg/login.svg">
        </div>
        <div class="login-content">
            <form action="{{ route('register.post') }}" method="POST" id="register-form-id">
                @csrf
                <h2 class="title">Sign-Up</h2>

                <!-- First Name -->
                <div class="input-div one">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="div">
                        <h5>First name</h5>
                        <input name="first_name" type="text" class="input" value="{{ old('first_name') }}">
                    </div>
                </div>
                @if($errors->has('first_name'))
                <div class="validation-error">{{ $errors->first('first_name') }}</div>
                @endif

                <!-- Last Name -->
                <div class="input-div pass">
                    <div class="i">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="div">
                        <h5>Last name</h5>
                        <input name="last_name" type="text" class="input" value="{{ old('last_name') }}">
                    </div>
                </div>
                @if($errors->has('last_name'))
                <div class="validation-error">{{ $errors->first('last_name') }}</div>
                @endif

                <!-- Email -->
                <div class="input-div pass">
                    <div class="i">
                        <i class="bi bi-envelope-fill"></i>
                    </div>
                    <div class="div">
                        <h5>AdU Mail</h5>
                        <input name="email" type="email" class="input" value="{{ old('email') }}">
                    </div>
                </div>
                @if($errors->has('email'))
                <div class="validation-error">{{ $errors->first('email') }}</div>
                @endif

                <!-- Contact Number -->
                <div class="input-div pass">
                    <div class="i">
                        <i class="bi bi-telephone-fill"></i>
                    </div>
                    <div class="div">
                        <h5>Mobile number</h5>
                        <input name="contact_num" type="number" class="input" value="{{ old('contact_num') }}">
                    </div>
                </div>
                @if($errors->has('contact_num'))
                <div class="validation-error">{{ $errors->first('contact_num') }}</div>
                @endif

                <!-- Password -->
                <div class="input-div pass">
                    <div class="i">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="div">
                        <h5>Password</h5>
                        <input id="password" name="password" type="password" class="input">
                    </div>
                </div>
                @if($errors->has('password'))
                <div class="validation-error">{{ $errors->first('password') }}</div>
                @endif

                <!-- Confirm Password -->
                <div class="input-div pass">
                    <div class="i">
                        <i class="fas fa-lock"></i>
                    </div>
                    <div class="div">
                        <h5>Confirm Password</h5>
                        <input name="confirm_password" type="password" class="input">
                    </div>
                </div>
                @if($errors->has('confirm_password'))
                <div class="validation-error">{{ $errors->first('confirm_password') }}</div>
                @endif

                <div class="links-container">
                    <a href="{{ route('login.form') }}" class="left">Already have an Account?</a>
                </div>

                <div class="div">
                    <ul class="validation-checklist" id="password-checklist">
                        <li id="length" class="invalid"><span class="circle"></span> At least 8 characters</li>
                        <li id="uppercase" class="invalid"><span class="circle"></span> One uppercase letter</li>
                        <li id="number" class="invalid"><span class="circle"></span> One number</li>
                        <li id="special" class="invalid"><span class="circle"></span> One special character</li>
                    </ul>
                </div>

                <div class="privacy-checkbox">
                    <input type="checkbox" id="privacyCheckbox" required>
                    I agree to the data privacy terms and conditions.
                </div>

                <!-- reCAPTCHA v3 Widget -->
                {!! NoCaptcha::displaySubmit('register-form-id', 'Register', ['class' => 'btn']) !!}

                <!-- reCAPTCHA error handling -->
                @if ($errors->has('g-recaptcha-response'))
                <small class="text-danger">{{ $errors->first('g-recaptcha-response') }}</small>
                @endif

                <!-- <input type="submit" class="btn" value="Register"> -->
            </form>
        </div>
    </div>

    {!! NoCaptcha::renderJs() !!}
</body>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const modal = document.getElementById("dataPrivacyModal");
        const privacyCheckbox = document.getElementById("privacyCheckbox");
        const acceptBtn = document.getElementById("acceptBtn");

        // Enable button only when checkbox is checked
        privacyCheckbox.addEventListener("change", function() {
            acceptBtn.disabled = !this.checked;
        });

        // Hide modal when Accept button is clicked
        acceptBtn.addEventListener("click", function() {
            if (privacyCheckbox.checked) {
                modal.style.display = "none";
            }
        });

        // Hide modal if form is valid
        const form = document.querySelector("form");
        form.addEventListener("submit", function(event) {
            if (form.checkValidity()) {
                modal.style.display = "none";
            }
        });
    });

    const inputs = document.querySelectorAll(".input");

    function addcl() {
        let parent = this.parentNode.parentNode;
        parent.classList.add("focus");
    }

    function remcl() {
        let parent = this.parentNode.parentNode;
        if (this.value == "") {
            parent.classList.remove("focus");
        }
    }

    inputs.forEach(input => {
        input.addEventListener("focus", addcl);
        input.addEventListener("blur", remcl);
    });
</script>

<script>
    // Password Validation Checks
    const password = document.getElementById("password");
    const checklistItems = {
        length: document.getElementById("length"),
        uppercase: document.getElementById("uppercase"),
        number: document.getElementById("number"),
        special: document.getElementById("special")
    };

    password.addEventListener("input", function() {
        const val = password.value;
        updateValidation(val.length >= 8, checklistItems.length);
        updateValidation(/[A-Z]/.test(val), checklistItems.uppercase);
        updateValidation(/[0-9]/.test(val), checklistItems.number);
        updateValidation(/[@$!%*?&]/.test(val), checklistItems.special);
    });

    function updateValidation(condition, element) {
        const circle = element.querySelector(".circle");
        if (condition) {
            element.classList.add("valid");
            element.classList.remove("invalid");
            circle.classList.add("valid");
        } else {
            element.classList.add("invalid");
            element.classList.remove("valid");
            circle.classList.remove("valid");
        }
    }

    // Privacy Modal Display and Agreement Check
    const privacyModal = document.getElementById("privacy-modal");

    function showModal(event) {
        if (!document.getElementById("agree").checked) {
            event.preventDefault();
            privacyModal.style.display = "flex";
        }
    }

    function closeModal() {
        if (document.getElementById("agree").checked) {
            privacyModal.style.display = "none";
        }
    }
</script>

</html>