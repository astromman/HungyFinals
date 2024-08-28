<div class="container-fluid">
    <div class="row">
        <!-- Sidebar Part -->
        <div class="sidebar col-lg-2 d-flex flex-column flex-shrink-0" style="background-color: #0B1E59;">
            <!--- Top part of sidebar --->
            <div class="container col-lg-12 pt-2 d-flex justify-content-center align-items-center text-center">
                <img class="logo" src="/images/logo/logohf1.png">
            </div>

            <!-- divider part -->
            <div class="col-lg-10 ms-3">
                <hr style="border-color: white;">
            </div>

            <!-- sidebar contents part -->
            <div class="sidebar-contents">
                <ul class="list-unstyled ps-0 py-4">
                    <div>
                        <button class="btn btn-toggle rounded collapsed">
                            <i class="bi bi-side bi-check2-square"></i>
                            VERIFICATION
                        </button>
                    </div>
                    <div>
                        <a href="{{ route('logout') }}">
                            <button class="btn btn-side btn-toggle rounded collapsed" aria-expanded="false">
                                <i class="bi bi-side bi-box-arrow-left"></i>
                                LOGOUT
                            </button>
                        </a>
                    </div>
                </ul>
            </div>

        </div>

        <!-- the contents of the extendee files will go here -->
        <div class="col-lg-10">

            <!-- nav part -->
            <div class="row">
                <nav class="navbar" style="height: 10vh;">
                    <div class="contianer-fluid py-3 px-5">
                        @yield('contentNav')
                    </div>
                </nav>
            </div>

            <!-- content part -->
            <div class="row">
                <div style="background-color: #D4DFE8; height: 90vh">
                    @yield('content')
                </div>
            </div>

        </div>

    </div>

</div>

<style>
    body {
        font-family: 'Arial Narrow Bold', sans-serif;
    }

    .logo {
        height: 100%;
        width: 100%;
        object-fit: contain;
        padding-top: 10px;
        padding-bottom: 10px;
    }


    .btn {
        color: white;
        font-size: 20px;
        font-weight: bold;
    }

    .bi-clock-fill {
        font-size: 150px;
        color: #0B1E59;
    }

    .bi-side {
        padding-left: 15px;
        padding-right: 5px;
    }

    /* .form-control {
        font-size: 20px;
    } */

    .btn-primary {
        width: 320px;
        height: 50px;
        font-size: large;
    }

    /* progressbar css */
    .con-pb {
        padding-right: 2.5rem;
    }

    .main {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;

    }

    .progressbar {
        display: flex;
    }

    /* for the circle position */
    .progressbar li {
        list-style: none;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        margin: 0 120px;
    }

    .progressbar li .icons {
        font-size: 25px;
        color: #1b761b;
        margin: 0 60px;
    }

    .progressbar li .label {
        font-family: sans-serif;
        letter-spacing: 1px;
        font-size: 14px;
        font-weight: bold;
        color: #0B1E59;
    }

    .progressbar li .step {
        height: 30px;
        width: 30px;
        border-radius: 50%;
        background-color: lightgray;
        margin: 16px 0 10px;
        display: grid;
        place-items: center;
        color: ghostwhite;
        position: relative;
    }

    /* for the line length */
    .step::after {
        content: "";
        position: absolute;
        width: 335px;
        height: 3px;
        background-color: lightgray;
        right: 25px;
    }

    .first::after {
        width: 0;
        height: 0;
    }

    .progressbar li .step .awesome {
        display: none;
    }

    .progressbar li .step p {
        font-size: 18px;
    }

    .progressbar li .active {
        background-color: #0B1E59;
    }

    li .active::after {
        background-color: #0B1E59;
    }

    .progressbar li .active p {
        display: none;
    }

    .progressbar li .active .awesome {
        display: flex;
    }
</style>