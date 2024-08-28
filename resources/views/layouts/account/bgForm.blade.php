<div class="container py-5">
    <!-- To make the background centered horizontally -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- To make the background centered vertically -->
            <div class="container py-5 justify-content-center align-items-center">
                <!-- Background of the form add , 0.7 for opacity-->
                <div class="bg-form rounded" style="background-color: rgba(11, 30, 89);">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        position: relative;
        background-image: url("images/bg/cs-building.png");
        background-repeat: no-repeat;
        background-size: cover;
        font-family: arial, sans-serif;
    }

    .logo {
        height: 100%;
        width: 100%;
        object-fit: contain;    
    }

    .mb-3 input {
        font-size: 20px;
    }

    .btn {
        width: 320px;
        height: 50px;
        font-size: large;
    }

    a {
        color: white;
    }
</style>