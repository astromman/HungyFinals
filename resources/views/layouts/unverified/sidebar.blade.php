<!-- Navbar and Sidebar Container -->
<div class="navbar-sidebar-container">
    <!-- Sidebar -->
    <div id="sidebar" class="sidebar">
        <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">×</a>
        <a href="{{ route('resubmission.form') }}"><i class="bi bi-easel"></i> Verifiaction</a>
        <a href="{{ route('unv.change.password') }}">Change Password</a>
        <a href="{{ route('user.logout') }}">Logout</a>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container-fluid">
            <span class="hamburger" onclick="openNav()">☰</span>
            <a class="navbar-brand" href="{{ route('resubmission.form') }}">Hungry Falcons</a>
            <div class="collapse navbar-collapse" id="navbarNav">

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