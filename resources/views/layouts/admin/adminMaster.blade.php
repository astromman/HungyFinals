<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Hungry Falcons</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" class="href">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <style>
        body {
            font-family: "Nunito", sans-serif;
            background-color: #D4DFE8;
            margin: 0;
            padding: 0;
        }

        h2 {
            font-weight: bold;
        }

        .navbar-sidebar-container {
            display: flex;
        }

        .btn-side {
            padding: 10px 23px;
            text-decoration: none;
            color: white;
            font-size: 20px;
            display: block;
            transition: 0.3s;
            outline: none;
            border: none;
        }

        .btn-side:hover {
            color: #5479f7;
        }

        .btn-side:focus {
            outline: none;
            border: none;
        }

        .sidebar {
            height: 100vh;
            width: 0px; /* 250px if want to open by default*/
            position: fixed;
            top: 0;
            left: 0;
            background-color: #050144;
            overflow-x: hidden;
            transition: 0.3s;
            padding-top: 80px;
            z-index: 1;
        }

        .sidebar a {
            padding: 10px 15px;
            text-decoration: none;
            font-size: 20px;
            color: white;
            display: block;
            transition: 0.3s;
        }

        .sidebar a:hover {
            color: #f1f1f1;
        }

        .sidebar .closebtn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 36px;
            margin-left: 50px;
        }

        .navbar {
            margin-left: 0px; /* 250px if want to change open by default */
            width: 100%; /* calc(100% - 250px) if want open by defaut */
            background-color: #050144;
            padding: 10px 20px;
            z-index: 1000;
            position: fixed;
            top: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: margin-left 0.3s, width 0.3s;
        }

        .navbar .navbar-brand,
        .navbar .navbar-nav .nav-link {
            color: white;
        }

        .content-area {
            margin-left: 0px; /* Adjusted for closed sidebar 250px if want open by default */
            padding: 80px 20px 20px 20px;
            transition: margin-left 0.3s;
        }

        .hamburger {
            font-size: 20px;
            cursor: pointer;
            color: white;
            display: inline; /* change to none if want open by default */
            margin-right: 15px;
        }

        @media screen and (max-width: 768px) {
            .sidebar {
                width: 0;
            }

            .navbar {
                margin-left: 0;
                width: 100%;
            }

            .content-area {
                margin-left: 0;
            }

            .hamburger {
                display: inline;
            }
        }

        .form-control {
            border-color: #5479f7;
        }

        .card {
            border: 1px solid #5479f7;
        }

        .borderless tr,
        .borderless td {
            border: none;
        }
    </style>

</head>

<body>
    @include('layouts.admin.sidebar')
</body>

</html>