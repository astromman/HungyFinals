@extends('layouts.admin.adminMaster')

@section('title')
Admin
@endsection

@section('contentNav')
<h3>Buyers Account</h3>
@endsection

@section('content')
<nav class="navbar navbar-expand px-3 border-bottom" style="background-color: white;">
    <button class="btn" id="sidebar-toggle" type="button">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="dropdown dropdown-right">

        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Action</a></li>
            <li><a class="dropdown-item" href="#">Another action</a></li>
            <li><a class="dropdown-item" href="#">Something else here</a></li>
        </ul>
    </div>
    <div class="collapse navbar-collapse">
        <div class="d-flex justify-content-end align-items-end">
            <button class="btn btndd btn-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                Branch
            </button>
        </div>
        <ul class="navbar-nav ms-auto mb-2 mb-lg-0 profile-menu">
            <li class="nav-item dropdown profile-dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <div class="profile-pic">
                        <img src="/images/jas.png" alt="Profile Picture">
                    </div>
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href=""><i class="fas fa-sliders-h fa-fw"></i> Account</a></li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-cog fa-fw"></i> Settings</a></li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li><a class="dropdown-item" href="#"><i class="fas fa-sign-out-alt fa-fw"></i> Log Out</a></li>
                </ul>
            </li>
        </ul>
    </div>
</nav>

@endsection