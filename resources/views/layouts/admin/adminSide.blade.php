<div class="container-fluid">
    <div class="row">
        <!-- Sidebar Part -->
        <div class="sidebar col-lg-2 d-flex flex-column flex-shrink-0">
            <!--- Top part of sidebar --->
            <div class="container col-lg-12 pt-2 d-flex justify-content-center align-items-center text-center">
                <a href="{{route('admin.dashboard')}}">
                    <img class="logo" src="/images/logo/logohf1.png">
                </a>
            </div>

            <!-- divider part -->
            <div class="col-lg-10 ms-3">
                <hr class="hr-side">
            </div>

            <!-- sidebar contents part -->
            <div class="sidebar-contents">
                <ul class="list-unstyled ps-0 pt-2">
                    <div>
                        <button class="btn btn1 btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#user-collapse" style="font-size: 17px">
                            <i class="bi bi-person-check-fill"></i>
                            Users Management
                        </button>
                        <li class="mb-2 ps-3">
                            <div class="collapse show ps-3" id="user-collapse">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1">
                                    <li class="li-sub"><a href="" class="li-a">Managers Accounts</a></li>
                                    <li class="li-sub"><a href="" class="li-a">Concessionaires Shop</a></li>
                                </ul>
                            </div>
                        </li>
                    </div>

                    <div>
                        <button class="btn btn1 btn-toggle rounded collapsed" data-bs-toggle="collapse" data-bs-target="#appli-collapse" style="font-size: 14px">
                            <i class="bi bi-envelope-paper-fill"></i>
                            Application Management
                        </button>
                        <li class="mb-2 ps-3">
                            <div class="collapse show ps-3" id="appli-collapse">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1">
                                    <li class="li-sub"><a href="" class="li-a">Application</a></li>
                                    <li class="li-sub"><a href="" class="li-a">Application History</a></li>
                                    <li class="li-sub"><a href="" class="li-a">Add Shop Account</a></li>
                                </ul>
                            </div>
                        </li>
                    </div>

                    <div>
                        <a href="{{ route('user.logout') }}">
                            <button class="btn btn1 btn-toggle rounded collapsed" aria-expanded="false" style="font-size: 20px">
                                <i class="bi bi-box-arrow-left"></i>
                                Sign-out
                            </button>
                        </a>
                    </div>
                </ul>
            </div>
        </div>

        <!--- the contents of the extendee files will go here --->
        <div class="col-lg-10">
            <!-- nav part -->
            <div class="row">
                <nav class="navbar">
                    <div class="contianer-fluid py-3 px-5">
                        @yield('contentNav')
                    </div>
                </nav>
            </div>

            <!-- content part -->
            <div class="row">
                <div class="content">
                    @yield('content')
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    body {
        font-family: 'Arial Narrow Bold', sans-serif;
        ;
    }

    .sidebar {
        background-color: #0B1E59;
    }

    .hr-side {
        border-color: white;
    }

    .navbar {
        height: 10vh;
    }

    .content {
        background-color: #D4DFE8;
        height: 90vh;
    }

    .logo {
        height: 100%;
        width: 100%;
        object-fit: contain;
        padding-top: 10px;
        padding-bottom: 10px;
    }

    /* css for the subpart of the buttons in sidebar */
    .li-sub {
        padding-bottom: 5px;
        padding-top: 5px;
    }

    .li-a {
        color: ghostwhite;
        font-size: 17px;
        padding-left: 15px;
        text-decoration: none;
    }

    /* for the button */
    .btn {
        color: ghostwhite;
        font-weight: bold;
        justify-content: center;
        align-items: center;
        font-weight: bold;
    }

    /* icons */
    .bi {
        padding-top: 10px;
        padding-right: 5px;
        font-size: 23px;
    }
</style>