<nav class="navbar navbar-expand px-3 border-bottom" style="background-color: white;">
    <button class="btn" id="sidebar-toggle" type="button">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse">
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 profile-menu">
            <li class="nav-item dropdown profile-dropdown me-3 w-20">
                <button class="btn btndd btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Branch
                </button>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#">Action</a></li>
                    <li><a class="dropdown-item" href="#">Another action</a></li>
                    <li><a class="dropdown-item" href="#">Something else here</a></li>
                </ul>
            </li>
            <li class="nav-item dropdown profile-dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="profile-pic">
                        <img src="/images/jas.png" alt="Profile Picture">
                    </div>
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href=" route ('profile') "><i class="fa-solid fa-user fa-fw"></i> Jasper Villasper</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href=" route ('profile') "><i class="fas fa-sliders-h fa-fw"></i> My Profile</a></li>
                    <li><a class="dropdown-item" href=" route ('account') "><i class="fa-solid fa-gear fa-fw"></i> Manage Account</a></li>
                    <li><a class="dropdown-item" style="color: red;" href="#"><i class="fas fa-sign-out-alt fa-fw"></i> Log Out</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>

<style>
    .profile-menu {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .profile-pic img {
        width: 40px;
        height: 40px;
        border-radius: 50%;
    }

    .navbar .dropdown-menu-end {
        right: 0;
        left: auto;
    }

    .custom-margin {
        margin-right: 50px;
        /* Adjust as needed */
    }
</style>