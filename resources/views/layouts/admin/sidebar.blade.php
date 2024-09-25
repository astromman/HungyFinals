<!-- Navbar and Sidebar Container -->
<div class="navbar-sidebar-container">
    <!-- Sidebar -->
    <div id="sidebar" class="sidebar">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
        <a href="{{ route('admin.dashboard') }}"><i class="bi bi-easel"></i> Dashboard</a>
        <a href="{{ route('admin.audit.logs') }}"><i class="bi bi-card-list"></i> Audit Trail</a>
        <a href="{{ route('manage.building') }}"><i class="bi bi-pin-map-fill"></i> Canteen Control</a>
        <a href="{{ route('manager.account') }}"><i class="bi bi-person-circle"></i> Manager's Accounts</a>
        <a href="{{ route('buyers.account') }}"><i class="bi bi-person-circle"></i> Buyer's Accounts</a>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <span class="hamburger" onclick="openNav()">☰</span>
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">Hungry Falcons</a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @php
                    $userId = session()->get('loginId');
                    $user = App\Models\UserProfile::where('id', $userId)->first();
                    @endphp
                    <li class="px-3 nav-item d-flex align-items-center">
                        <div class="text-white" id="userDropdown" data-bs-toggle="dropdown">
                            {{ $user->first_name . ' ' . $user->last_name }}
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle" style="font-size: 30px; color: white;"></i>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="{{ route('admin.my.profile') }}">My Profile</a></li>
                                <li><a class="dropdown-item" href="{{ route('user.logout') }}">Logout</a></li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</div>

<!-- Main Content Area -->
<div class="content-area">
    @yield('content')
</div>

<script>
    function openNav() {
        document.getElementById("sidebar").style.width = "250px";
        document.querySelector(".content-area").style.marginLeft = "250px";
        document.querySelector(".hamburger").style.display = "none";
        document.querySelector(".navbar").style.marginLeft = "250px";
        document.querySelector(".navbar").style.width = "calc(100% - 250px)";
    }

    function closeNav() {
        document.getElementById("sidebar").style.width = "0";
        document.querySelector(".content-area").style.marginLeft = "0";
        document.querySelector(".hamburger").style.display = "inline";
        document.querySelector(".navbar").style.marginLeft = "0";
        document.querySelector(".navbar").style.width = "100%";
    }

    // Automatically close sidebar on small screens
    if (window.innerWidth <= 768) {
        closeNav();
    }

    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            document.getElementById("sidebar").style.width = "250px";
            document.querySelector(".content-area").style.marginLeft = "250px";
            document.querySelector(".navbar").style.marginLeft = "250px";
            document.querySelector(".navbar").style.width = "calc(100% - 250px)";
            document.querySelector(".hamburger").style.display = "none";
        } else {
            closeNav();
        }
    });
</script>