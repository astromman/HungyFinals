<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Hungry Falcons</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css">
    <!--=============== CSS ===============-->
    <link rel="stylesheet" href="assets/css/styles.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script scr="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"></script>

    <!-- Bootstrap Bundle with Popper.js -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" class="href">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables CSS and JS -->
    <link href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

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

        h1 {
            font-weight: bold;
            font-size: 2.8rem;
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

        h4 {
            font-weight: 0.8rem;
        }

        h5 {
            font-size: 0.77rem;
        }

        small {
            font-size: 0.75rem;
        }

        .text-muted {
            color: var(--clr-info-dark);
        }

        .container-dash {
            width: 96%;
            gap: 1.8rem;
            grid-template-columns: 3fr 1fr;
            margin: 0 auto;
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
            /* box-shadow: var(--box-shadow); */
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
    @include('layouts.manager.sidebar')
</body>

</html>