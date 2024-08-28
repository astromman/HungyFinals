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

        .navbar-sidebar-container {
            display: flex;
        }

        .sidebar {
            height: 100vh;
            width: 250px;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #050144;
            overflow-x: hidden;
            transition: 0.3s;
            padding-top: 60px;
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
            margin-left: 250px;
            width: calc(100% - 250px);
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
            margin-left: 250px;
            padding: 80px 20px 20px 20px;
            transition: margin-left 0.3s;
        }

        .hamburger {
            font-size: 20px;
            cursor: pointer;
            color: white;
            display: none;
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

        .bi-clock-fill {
            font-size: 150px;
            color: #0B1E59;
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

        .form-control {
            border-color: #5479f7;
        }

        .card {
            border: 1px solid #5479f7;
        }
    </style>

</head>

<body>
    @include('layouts.unverified.sidebar')
</body>

</html>