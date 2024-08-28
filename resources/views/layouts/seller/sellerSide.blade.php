<div class="container-fluid">
    <div class="row">
        <!-- Sidebar Part -->
        <div class="sidebar col-lg-2 col-md-2 col-sm-2 col-xs-2 d-flex flex-column flex-shrink-0">
            <!--- Top part of sidebar --->
            <div class="container col-lg-12 col-md-12 col-sm-12 col-xs-12 pt-2 d-flex justify-content-center align-items-center text-center">
                <a href="{{route('dashboard')}}">
                    <img class="logo" src="/images/logo/logohf1.png">
                </a>
            </div>

            <!-- divider part -->
            <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10 ms-3">
                <hr style="border-color: white;">
            </div>

            <!-- sidebar contents part -->
            <div class="sidebar-contents col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <ul class="list-unstyled py-4">
                    <div>
                        <a href="{{ route('dashboard') }}">
                            <button class="btn btn-side btn-toggle rounded collapsed">
                                <i class="bi bi-side bi-clipboard-check"></i>
                                DASHBOARD
                            </button>
                        </a>
                    </div>
                    <div>
                        <button class="btn btn-side btn-toggle rounded collapsed" data-bs-toggle="collapse" data-bs-target="#shop-collapse">
                            <i class="bi bi-side bi-cart-check"></i>
                            SHOP
                        </button>
                        <li class="mb-2 ps-3">
                            <div class="collapse show ps-3" id="shop-collapse">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1">
                                    <li class="li-sub"><a href="{{ route('showShopPreview') }}" class="li-a">View Mode</a></li>
                                    <li class="li-sub"><a href="{{ route('showUpdateShopDetailsForm') }}" class="li-a">Shop Details</a></li>
                                </ul>
                            </div>
                        </li>
                    </div>
                    <div>
                        <button class="btn btn-side btn-toggle rounded collapsed" data-bs-toggle="collapse" data-bs-target="#product-collapse" aria-expanded="true">
                            <i class="bi bi-side bi-box2"></i>
                            PRODUCTS
                        </button>
                        <li class="mb-2 ps-3">
                            <div class="collapse show ps-3" id="product-collapse">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1">
                                    <li class="li-sub"><a href="{{ route('showMyProducts') }}" class="li-a">My Products</a></li>
                                    <li class="li-sub"><a href="{{ route('showAddProducts') }}" class="li-a">Add Products</a></li>
                                </ul>
                            </div>
                        </li>
                    </div>
                    <div>
                        <button class="btn btn-side btn-toggle rounded collapsed" data-bs-toggle="collapse" data-bs-target="#orders-collapse" aria-expanded="true">
                            <i class="bi bi-side bi-card-list"></i>
                            ORDERS
                        </button>
                        <li class="mb-2 ps-3">
                            <div class="collapse show ps-3" id="orders-collapse">
                                <ul class="btn-toggle-nav list-unstyled fw-normal pb-1">
                                    <li class="li-sub"><a href="{{ route('myorders') }}" class="li-a">My Orders</a></li>
                                    <li class="li-sub"><a href="{{ route('orderhistory') }}" class="li-a">Order History</a></li>
                                </ul>
                            </div>
                        </li>
                    </div>
                    <div>
                        <a href="{{ route('verified') }}">
                            <button class="btn btn-side btn-toggle rounded collapsed">
                                <i class="bi bi-side bi-check2-square"></i>
                                VERIFICATION
                            </button>
                        </a>

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
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">

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
                <div style="background-color: #D4DFE8; height: 150vh;">
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

    .logo {
        height: 100%;
        width: 100%;
        object-fit: contain;
        padding-top: 10px;
        padding-bottom: 10px;
    }

    .li-sub {
        padding-bottom: 5px;
        padding-top: 5px;
    }

    .li-a {
        color: white;
        font-size: 17px;
        padding-left: 25px;
        text-decoration: none;
    }

    .btn-side {
        color: white;
        font-size: 20px;
        font-weight: bold;
    }

    .bi-side {
        padding-left: 15px;
        padding-right: 5px;
    }


    /* CSS for verified page */
    .bi-check-circle-fill {
        font-size: 150px;
        color: #389BF2;
    }

    /* CSS for progressbar */
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

    /* labels below the circle */
    .progressbar li .label {
        font-family: sans-serif;
        letter-spacing: 1px;
        font-size: 14px;
        font-weight: bold;
        color: #0B1E59;
    }

    /* circles */
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

    /* Style the line between "1" and "2" */
    /* Color for the line between "1" and "2" */
    li:nth-child(2) .step::after {
        background-color: #0B1E59;
    }

    /* Style the number "2" */
    /* Color for the number "2" */
    li:nth-child(2) .numbertwo {
        color: white;
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

    /* color for the */
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

    /* add products image upload in modal css */
    .upload-box {
        position: relative;
        width: 470px;
        height: 150px;
        border: 2px solid #ccc;
        border-radius: 10px;
        overflow: hidden;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .upload-label {
        position: absolute;
        bottom: 10px;
        left: 0;
        right: 0;
        text-align: center;
        color: #333;
        font-size: 16px;
    }

    #image-upload {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }
</style>