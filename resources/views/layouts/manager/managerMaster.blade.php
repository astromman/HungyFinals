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

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/luxon@3/build/global/luxon.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-luxon@1"></script>


    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        body {
            margin: 0;
            padding: 0;
            width: 100vw;
            height: 100vh;
            /* font-size: 0.7rem; */
            user-select: none;
            overflow-x: hidden;
            background: var(--clr-color-background);
            font-family: 'Poppins', sans-serif;
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
            width: 250px;
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

        :root {
            --clr-primary: #7380ec;
            --clr-danger: #ff7782;
            --clr-success: #41f1b6;
            --clr-white: #fff;
            --clr-info-dark: #7d8da1;
            --clr-info-light: #dce1eb;
            --clr-dark: #363949;
            --clr-warning: #ff4edc;
            --clr-light: rgba(132, 139, 200, 0.18);
            --clr-primary-variant: #111e88;
            --clr-dark-variant: #677483;
            --clr-color-background: #f6f6f9;

            --card-border-radius: 2rem;
            --border-radius-1: 0.4rem;
            --border-radius-2: 0.8rem;
            --border-radius-3: 1.2rem;

            --card-padding: 1.8rem;
            --padding-1: 1.2rem;
            --box-shadow: 0 2rem 3rem var(--clr-light);
        }

        /* dark theme */
        .dark-theme-variables {
            --clr-color-background: #181a1e;
            --clr-white: #202528;
            --clr-light: rgba(0, 0, 0, 0.4);
            --clr-dark: #edeffd;
            --clr-dark-variant: #677483;
            --box-shadow: 0 2rem 3rem var(--clr-light);
        }

        /* * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            border: 0;
            text-decoration: none;
            list-style: none;
            appearance: none;
        } */

        .container-dash {
            /* display: grid; */
            width: 96%;
            gap: 1.8rem;
            grid-template-columns: 3fr 1fr;
            margin: 0 auto;
        }

        a {
            color: var(--clr-dark);
        }

        a .alert .alert-primary {
            text-decoration: none;
        }

        h4 {
            font-weight: 0.8rem;
        }

        h5 {
            font-size: 0.77rem;
        }

        small {
            font-size: 0.75rem;
        }

        .profile-photo img {
            width: 2.8rem;
            height: 2.8rem;
            overflow: hidden;
            border-radius: 50%;
        }

        .text-muted {
            color: var(--clr-info-dark);
        }

        /* p {
            color: var(--clr-dark-variant);
        } */

        b {
            color: var(--clr-dark);
        }

        .primary {
            color: var(--clr-primary);
        }

        .success {
            color: var(--clr-success);
        }

        .danger {
            color: var(--clr-danger);
        }

        .warning {
            color: var(--clr-warning);
        }

        /* Main content styles */
        main {
            margin-top: 1.4rem;
            margin-bottom: 1.4rem;
            width: 100%;
        }

        main input {
            background-color: transparent;
            border: 0;
            outline: 0;
            color: var(--clr-dark);
        }

        main .date {
            display: inline-block;
            background: var(--clr-white);
            border-radius: var(--border-radius-1);
            margin-top: 1rem;
            padding: 0.5rem 1.6rem;
        }

        main .insights {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.6rem;
        }

        main .insights>div {
            background-color: var(--clr-white);
            padding: var(--card-padding);
            border-radius: var(--card-border-radius);
            margin-top: 1rem;
            box-shadow: var(--box-shadow);
            transition: all 0.3s ease;
        }

        main .insights>div:hover {
            box-shadow: none;
        }

        main .insights>div span {
            background: coral;
            padding: 0.5rem;
            border-radius: 50%;
            color: var(--clr-white);
            font-size: 2rem;
        }

        main .insights>div.expenses span {
            background: var(--clr-danger);
        }

        main .insights>div.income span {
            background: var(--clr-success);
        }

        main .insights>div .middle {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        main .insights>div .middle h1 {
            font-size: 1.6rem;
        }

        main h1 {
            color: var(--clr-dark);
        }

        main .insights h1 {
            color: var(--clr-dark);
        }

        main .insights h3 {
            color: var(--clr-dark);
        }

        main .insights p {
            color: var(--clr-dark);
        }

        main .insights h3 {
            color: var(--clr-dark);
        }

        main .insights .progress {
            position: relative;
            height: 68px;
            width: 68px;
            border-radius: 50px;
        }

        main .insights svg {
            height: 150px;
            width: 150px;
            position: absolute;
            top: 0;
        }

        main .insights svg circle {
            fill: none;
            stroke: var(--clr-primary);
            transform: rotate(270, 80, 80);
            stroke-width: 5;
        }

        main .insights .sales svg circle {
            stroke-dashoffset: 0;
            stroke-dasharray: 150;
        }

        main .insights .expenses svg circle {
            stroke-dashoffset: 10;
            stroke-dasharray: 150;
        }

        main .insights .income svg circle {
            stroke: var(--clr-success);
        }

        main .insights .progress .number {
            position: absolute;
            top: 5%;
            left: 5%;
            height: 100%;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Recent Orders */
        main .recent_order {
            margin-top: 2rem;
        }

        main .recent_order h2 {
            color: var(--clr-dark);
        }

        main .recent_order table {
            background: var(--clr-white);
            width: 100%;
            border-radius: var(--card-border-radius);
            padding: var(--card-padding);
            text-align: center;
            box-shadow: var(--box-shadow);
            transition: all 0.3s ease;
            color: var(--clr-dark);
        }

        main .recent_order table:hover {
            box-shadow: none;
        }

        main table tbody td {
            height: 3.8rem;
            border-bottom: 1px solid var(--clr-white);
            color: var(--clr-dark-variant);
        }

        main table tbody tr:last-child td {
            border: none;
        }

        main .recent_order a {
            text-align: center;
            display: block;
            margin: 1rem;
        }

        /* Right Sidebar */
        .right-sidebar {
            margin-top: 1.4rem;
            margin-bottom: 1.4rem;
        }

        .right-sidebar>div {
            background-color: var(--clr-white);
            padding: var(--card-padding);
            border-radius: var(--card-border-radius);
            box-shadow: var(--box-shadow);
            transition: all 0.3s ease;
        }

        .right-sidebar h2 {
            padding-bottom: 10px;
            padding-top: 20px;
        }

        /* recent updates */
        .recent-update ul {
            list-style-type: none;
            padding-left: 0;
        }

        .recent-update ul li {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .recent-update ul li img {
            width: 2.8rem;
            height: 2.8rem;
            border-radius: 50%;
            margin-right: 0.5rem;
        }

        .recent-update ul li span {
            margin-right: 0.5rem;
        }

        .recent-update ul li p {
            margin: 0;
            font-size: 15px;
        }

        /* sales analytics */
        .sales-analytics {
            margin-bottom: 13px;
        }

        .sales-analytics span {
            background: var(--clr-success);
            color: white;
            padding: 0.5rem;
            border-radius: 50%;
        }

        .sales-analytics ul li {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .sales-analytics p {
            font-size: 14px;
        }

        /* Charts Container */
        canvas {
            max-width: 100%;
            height: 100% !important;
            /* Ensure the canvas fills the container */
        }
        
        .charts {
            display: flex;
            justify-content: space-between;
            gap: 2rem;
            padding-bottom: 2rem;
        }

        .chart-container {
            background-color: var(--clr-white);
            border-radius: var(--card-border-radius);
            padding: var(--card-padding);
            text-align: center;
            flex: 1;
            height: 400px;
            /* Fixed height for charts */
        }

        .chart-container h3 {
            font-size: 1rem;
            font-weight: bold;
            padding-top: 0px;
        }

        .bi-patch-check-fill {
            color: #5479f7;
            font-size: 50px;
        }

        .bi-envelope-paper-fill {
            color: #5479f7;
            font-size: 50px;
        }

        .bi-shop {
            color: #5479f7;
            font-size: 50px;
        }

        
    </style>

</head>

<body>
    @include('layouts.manager.sidebar')
</body>

</html>