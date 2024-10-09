<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/ae360af17e.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.8.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/MaterialDesign-Webfont/7.2.96/css/materialdesignicons.min.css" integrity="sha512-LX0YV/MWBEn2dwXCYgQHrpa9HJkwB+S+bnBpifSOTO1No27TqNMKYoAn6ff2FBh03THAzAiiCwQ+aPX+/Qt/Ow==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous"> -->

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/script.js') }}"></script>
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js'></script>

</head>

<body>
    <div class="wrapper">
        @include('test.sidebar')
        <div class="main">
            @include('test.header')
            <main class="content px-3 py-2" style="background-color: #F5F7FA;">
                @yield('content')
            </main>
        </div>
    </div>
</body>

</html>

<style>

    @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap');

    *,
    ::after,
    ::before {
        box-sizing: border-box;
    }

    body {
        font-family: 'Montserrat', sans-serif;
        font-size: 0.875rem;
        opacity: 1;
        overflow-y: scroll;
        margin: 0;
    }

    a {
        cursor: pointer;
        text-decoration: none;
        font-family: 'Montserrat', sans-serif;
    }

    li {
        list-style: none;
    }

    h4 {
        font-family: 'Montserrat', sans-serif;
        font-size: 1.275rem;
        color: var(--bs-emphasis-color);
    }

    /* Layout for admin dashboard skeleton */

    .wrapper {
        align-items: stretch;
        display: flex;
        width: 100%;
    }

    #sidebar {
        max-width: 264px;
        min-width: 264px;
        background: var(--bs-dark);
        transition: all 0.35s ease-in-out;
    }

    .main {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        min-width: 0;
        overflow: hidden;
        transition: all 0.35s ease-in-out;
        width: 100%;
        background: var(--bs-dark-bg-subtle);
    }

    /* Sidebar Elements Style */

    /* .sidebar-logo {
        padding: 1.15rem;
    } */

    .sidebar-logo a {
        color: #e9ecef;
        font-size: 23px;
        text-align: center;
        display: block;
        padding: 20px;
        color: white;
        text-decoration: none;
    }

    p {
        color: white;
        font-size: 10px;
        text-align: center;
    }

    .no-margin {
        margin: 0;
    }

    .sidebar-nav {
        list-style: none;
        margin-bottom: 0;
        padding-left: 0;
        margin-left: 0;
    }

    .sidebar-header {
        color: #e9ecef;
        font-size: .75rem;
        padding: 1.5rem 1.5rem .375rem;
    }

    a.sidebar-link {
        padding: .625rem 1.625rem;
        color: #e9ecef;
        position: relative;
        display: block;
        font-size: 0.875rem;
    }

    .sidebar-link[data-bs-toggle="collapse"]::after {
        border: solid;
        border-width: 0 .075rem .075rem 0;
        content: "";
        display: inline-block;
        padding: 2px;
        position: absolute;
        right: 1.5rem;
        top: 1.4rem;
        transform: rotate(-135deg);
        transition: all .2s ease-out;
    }

    .sidebar-link[data-bs-toggle="collapse"].collapsed::after {
        transform: rotate(45deg);
        transition: all .2s ease-out;
    }

    .avatar {
        height: 40px;
        width: 40px;
    }

    .navbar-expand .navbar-nav {
        margin-left: auto;
    }

    .content {
        flex: 1;
        max-width: 100vw;
        width: 100vw;
    }

    @media (min-width:768px) {
        .content {
            max-width: auto;
            width: auto;
        }
    }

    .card {
        box-shadow: 0 0 .875rem 0 rgba(34, 46, 60, .05);
        margin-bottom: 24px;
    }

    .illustration {
        background-color: var(--bs-primary-bg-subtle);
        color: var(--bs-emphasis-color);
    }

    .illustration-img {
        max-width: 150px;
        width: 100%;
    }

    /* Sidebar Toggle */

    #sidebar.collapsed {
        margin-left: -264px;
    }

    /* Footer and Nav */

    @media (max-width:767.98px) {

        .js-sidebar {
            margin-left: -264px;
        }

        #sidebar.collapsed {
            margin-left: 0;
        }

        .navbar,
        footer {
            width: 100vw;
        }
    }

    /* Theme Toggler */

    .theme-toggle {
        position: fixed;
        top: 50%;
        transform: translateY(-65%);
        text-align: center;
        z-index: 10;
        right: 0;
        left: auto;
        border: none;
        background-color: var(--bs-body-color);
    }

    html[data-bs-theme="dark"] .theme-toggle .fa-sun,
    html[data-bs-theme="light"] .theme-toggle .fa-moon {
        cursor: pointer;
        padding: 10px;
        display: block;
        font-size: 1.25rem;
        color: #FFF;
    }

    html[data-bs-theme="dark"] .theme-toggle .fa-moon {
        display: none;
    }

    html[data-bs-theme="light"] .theme-toggle .fa-sun {
        display: none;
    }

    .profile-pic {
        display: inline-block;
        vertical-align: middle;
        width: 50px;
        height: 50px;
        overflow: hidden;
        border-radius: 50%;
    }

    .profile-pic img {
        width: 100%;
        height: auto;
        object-fit: cover;
    }

    .profile-menu .dropdown-menu {
        right: 0;
        left: unset;
    }

    .profile-menu .fa-fw {
        margin-right: 10px;
    }

    .toggle-change::after {
        border-top: 0;
        border-bottom: 0.3em solid;
    }

    .form-control {
        background-color: white;
    }

    body {
        font-family: 'Montserrat', sans-serif;
    }

    i {
        font-weight: 100;
    }

    legend {
        margin-top: 20px;
        font-family: 'Montserrat', sans-serif;
        font-weight: 600;
    }

    .navbar-brand {
        font-family: 'Montserrat', sans-serif;
        font-weight: 600;
    }

    .form-control {
        background-color: white;
    }

    .btn-primary {
        background-color: #4D5BD4;
        border-color: #4D5BD4;
    }

    .btn-secondary {
        background-color: #F5F7FA;
        border-color: #707070;
        color: #707070;
    }

    .btn.btn-outline-success {
        color: #707070;
        border-color: #707070;
    }

    .btn.btn-outline-success:hover {
        background-color: #F5F7FA;
        border-color: #707070;
        color: #707070;
    }

    .img-small {
        max-width: 220px;
        max-height: 220px;
        margin-left: 50px;
    }

    .img-small1 {
        max-width: 220px;
        max-height: 220px;
    }

    .img-thumbnail1 {
        max-width: 220px;
        max-height: 220px;
    }

    .label-upload {
        margin-top: 5px;
        margin-left: 105px;
    }

    .img-thumbnail {
        max-width: 220px;
        max-height: 220px;
        margin-left: 50px;
    }

    .stretched-link {
        text-decoration: none;
        color: inherit;
    }

    .card-link {
        text-decoration: none;
        color: inherit;
    }

    .card {
        border: 1px solid #ccc;
        border-radius: 8px;
    }

    .card-img-right {
        width: 80%;
        border-top-right-radius: 8px;
        border-bottom-right-radius: 8px;
    }

    .card-body-center {
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;
    }
</style>

<script>
    const sidebarToggle = document.querySelector("#sidebar-toggle");
    sidebarToggle.addEventListener("click", function() {
        document.querySelector("#sidebar").classList.toggle("collapsed");
    });

    document.addEventListener('DOMContentLoaded', function() {
        const sidebarLinks = document.querySelectorAll('.sidebar-link[data-bs-toggle="collapse"]');

        sidebarLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const target = document.querySelector(link.getAttribute('data-bs-target'));
                const expanded = link.getAttribute('aria-expanded') === 'true';

                if (expanded) {
                    link.setAttribute('aria-expanded', 'false');
                    link.classList.add('collapsed');
                    target.classList.remove('show');
                } else {
                    link.setAttribute('aria-expanded', 'true');
                    link.classList.remove('collapsed');
                    target.classList.add('show');
                }
            });
        });
    });

    // document.querySelector(".theme-toggle").addEventListener("click", () => {
    //     toggleLocalStorage();
    //     toggleRootClass();
    // });

    // function toggleRootClass() {
    //     const current = document.documentElement.getAttribute('data-bs-theme');
    //     const inverted = current == 'dark' ? 'light' : 'dark';
    //     document.documentElement.setAttribute('data-bs-theme', inverted);
    // }

    // function toggleLocalStorage() {
    //     if (isLight()) {
    //         localStorage.removeItem("light");
    //     } else {
    //         localStorage.setItem("light", "set");
    //     }
    // }

    // function isLight() {
    //     return localStorage.getItem("light");
    // }

    // if (isLight()) {
    //     toggleRootClass();
    // }
</script>