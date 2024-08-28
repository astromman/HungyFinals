<div class="container py-5">
    <!-- Add justify-content-center if want to center -->
    <div class="row justify-content-center">
        <div class="container py-5">
            <div class="container col-lg-7 col-md-10 col-xl-7 px-3 py-4" style="background-color: rgba(11, 30, 89);"> <!-- add , 0.7 for opaciry -->
                <div class="row">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    body {
        position: relative;
        background-image: url("images/bg/sv-building.png");
        /* background-color: powderblue; */
        background-repeat: no-repeat;
        background-size: cover;
    }

    .logo {
        height: 100%;
        width: 100%;
        object-fit: contain;
        padding-top: 10px;
        padding-bottom: 10px;
    }

    .mb-3 input {
        font-size: 20px;
    }

    .btn-login {
        max-width: 320px; 
        width: 100%;
        height: 50px;
        font-size: large;
        background-color: #389BF2;
        color: white;
    }

    a {
        color: white;
    }
</style>