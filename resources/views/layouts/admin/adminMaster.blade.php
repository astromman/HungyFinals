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

    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">

    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Sharp:opsz,wght,FILL,GRAD@48,400,0,0" />
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> <!-- Ensure Chart.js is included -->

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
            width: 0px;
            /* 250px if want to open by default*/
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
            margin-left: 0px;
            /* 250px if want to change open by default */
            width: 100%;
            /* calc(100% - 250px) if want open by defaut */
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
            margin-left: 0px;
            /* Adjusted for closed sidebar 250px if want open by default */
            padding: 80px 20px 20px 20px;
            transition: margin-left 0.3s;
        }

        .container-dash {
            display: grid;
            width: 96%;
            gap: 1.8rem;
            grid-template-columns: 3fr 1fr;
            margin: 0 auto;
        }

        .hamburger {
            font-size: 20px;
            cursor: pointer;
            color: white;
            display: inline;
            /* change to none if want open by default */
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

        /* Custom styles for mobile responsiveness */
        .table-responsive {
            margin: 20px 0;
        }

        thead th {
            background-color: #007bff;
            color: white;
            text-align: center;
        }

        td {
            text-align: center;
        }

        /* Hide certain columns for smaller screens */
        @media (max-width: 768px) {
            .hidden-xs {
                display: none;
            }
        }

        /* Main content styles */
        main {
            margin-top: 1.4rem;
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

        main .insights .progress {
            position: relative;
            height: 68px;
            width: 68px;
            border-radius: 50px;
        }

        /* Charts Container */
        .charts {
            display: flex;
            justify-content: space-between;
            gap: 2rem;
            margin-top: 2rem;
        }

        .chart-container {
            background-color: var(--clr-white);
            border-radius: var(--card-border-radius);
            padding: var(--card-padding);
            box-shadow: var(--box-shadow);
            text-align: center;
            flex: 1;
            height: 400px;
            /* Fixed height for charts */
        }

        canvas {
            max-width: 100%;
            height: 100% !important;
            /* Ensure the canvas fills the container */
        }

        /* Recent Updates */
        .recent-update {
            background-color: var(--clr-white);
            border-radius: var(--card-border-radius);
            padding: var(--card-padding);
            box-shadow: var(--box-shadow);
            margin-top: 1.4rem;
        }

        .recent-update h2 {
            color: var(--clr-dark);
            margin-bottom: 1rem;
        }

        .recent-update ul {
            list-style: none;
            padding: 0;
        }

        .recent-update li {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 0;
            border-bottom: 1px solid var(--clr-light);
        }

        .recent-update li:last-child {
            border-bottom: none;
        }

        .recent-update .profile-photo img {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            margin-right: 1rem;
        }

        .recent-update .message {
            flex: 1;
            font-size: 0.9rem;
            color: var(--clr-dark-variant);
        }

        .recent-update .time {
            font-size: 0.8rem;
            color: var(--clr-info-dark);
        }

        /* Responsive Styles */
        @media screen and (max-width: 1200px) {
            .container {
                width: 94%;
                grid-template-columns: 1fr;
            }

            main .insights {
                grid-template-columns: repeat(1, 1fr);
            }

            .charts {
                flex-direction: column;
            }
        }

        @media screen and (max-width: 768px) {
            .container {
                width: 100%;
                grid-template-columns: 1fr;
            }

            .charts {
                flex-direction: column;
            }

            .chart-container {
                padding: 30px;
                height: auto;
                /* Adjust height */
            }

            canvas {
                max-height: 250px;
                /* Max height for better fit on mobile */
            }
        }

        /* Main content styles */
        main {
            margin-top: 1.4rem;
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

        /* Responsive Styles */
        @media screen and (max-width: 1200px) {
            .container {
                width: 94%;
                grid-template-columns: 1fr;
            }

            main .insights {
                grid-template-columns: repeat(1, 1fr);
            }
        }

        @media screen and (max-width: 768px) {
            .container {
                width: 100%;
                grid-template-columns: 1fr;
            }

            main .insights {
                padding: 40px;
            }

            main .recent_order {
                padding: 30px;
                margin: 0 auto;
            }
        }



        /* Charts Container */
        .charts {
            display: flex;
            justify-content: space-between;
            gap: 2rem;
            margin-top: 2rem;
        }

        .chart-container {
            background-color: var(--clr-white);
            border-radius: var(--card-border-radius);
            padding: var(--card-padding);
            box-shadow: var(--box-shadow);
            text-align: center;
            flex: 1;
            height: 400px;
            /* Fixed height for charts */
        }

        canvas {
            max-width: 100%;
            height: 100% !important;
            /* Ensure the canvas fills the container */
        }

        /* Recent Updates */
        .recent-update {
            background-color: var(--clr-white);
            border-radius: var(--card-border-radius);
            padding: var(--card-padding);
            box-shadow: var(--box-shadow);
            margin-top: 1.4rem;
        }

        .recent-update h2 {
            color: var(--clr-dark);
            margin-bottom: 1rem;
        }

        .recent-update ul {
            list-style: none;
            padding: 0;
        }

        .recent-update li {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 0;
            border-bottom: 1px solid var(--clr-light);
        }

        .recent-update li:last-child {
            border-bottom: none;
        }

        .recent-update .profile-photo img {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            margin-right: 1rem;
        }

        .recent-update .message {
            flex: 1;
            font-size: 0.9rem;
            color: var(--clr-dark-variant);
        }

        .recent-update .time {
            font-size: 0.8rem;
            color: var(--clr-info-dark);
        }

        /* Responsive Styles */
        @media screen and (max-width: 1200px) {
            .container {
                width: 94%;
                grid-template-columns: 1fr;
            }

            main .insights {
                grid-template-columns: repeat(1, 1fr);
            }

            .charts {
                flex-direction: column;
            }
        }

        @media screen and (max-width: 768px) {
            .container {
                width: 100%;
                grid-template-columns: 1fr;
            }

            .charts {
                flex-direction: column;
            }

            .chart-container {
                padding: 30px;
                height: auto;
                /* Adjust height */
            }

            canvas {
                max-height: 250px;
                /* Max height for better fit on mobile */
            }
        }
    </style>

</head>

<body>
    @include('layouts.admin.sidebar')
</body>

</html>