<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('landing.page') }}">HUNGRY FALCONS</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('landing.page') }}">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('shops.list') }}">Shops</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('about.us.page') }}">About Us</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        More
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="#">Order History</a></li>
                        <li><a class="dropdown-item" href="{{ route('my.favorites') }}">Favorites</a></li>
                    </ul>
                </li>
            </ul>
            <div class="d-flex align-items-center nav-icons">
                @php
                $userId = session()->get('loginId');
                $sumInCart = App\Models\Order::where('user_id', $userId)->where('at_cart', true)->count();
                @endphp
                <a class="nav-link position-relative" href="{{ route('shop.cart') }}">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        {{ $sumInCart }}
                    </span>
                </a>
                <a href="{{ route('my.profile') }}" class="nav-link">
                    <i class="fas fa-user"></i>
                </a>
                <a href="#" class="nav-link" data-bs-toggle="offcanvas" data-bs-target="#shoppingCartCanvas" aria-controls="shoppingCartCanvas">
                    <i class="fa fa-list" aria-hidden="true"></i>
                </a>
            </div>
        </div>
    </div>
</nav>
<!-- Include the Offcanvas -->
@include('layouts.buyer.cart-offcanvas')