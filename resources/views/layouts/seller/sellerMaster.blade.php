<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Hungry Falcons</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- Bootstrap Bundle with Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Sweet Alert -->
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.1/dist/sweetalert2.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.14.1/dist/sweetalert2.all.min.js"></script>

    <style>
        body {
            /* font-family: "Nunito", sans-serif; */
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
            /* font-size: 1.6rem; */
            font-weight: bold;
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

        /* dark theme */
        .dark-theme-variables {
            --clr-color-background: #181a1e;
            --clr-white: #202528;
            --clr-light: rgba(0, 0, 0, 0.4);
            --clr-dark: #edeffd;
            --clr-dark-variant: #677483;
            --box-shadow: 0 2rem 3rem var(--clr-light);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            border: 0;
            text-decoration: none;
            list-style: none;
            appearance: none;
        }

        .container-dash {
            width: 96%;
            gap: 1.8rem;
            /* grid-template-columns: 3fr 1fr; */
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
            margin-bottom: 1rem;
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

        .dashboard {
            padding: 10px 23px;
            text-decoration: none;
            color: white;
            font-size: 20px;
            display: block;
            transition: 0.3s;
            outline: none;
            border: none;
        }

        .sidebar .li-a {
            padding: 8px 23px;
            text-decoration: none;
            font-size: 16px;
            color: white;
            display: block;
            transition: 0.3s;
        }

        .sidebar a:hover {
            color: #5479f7;
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

        /* Product Card Styles */
        .product-card {
            width: 100%;
            max-width: 380px;
            position: relative;
            box-shadow: 0 2px 7px #dfdfdf;
            margin: 0px auto;
            background: #fafafa;
        }

        .product-links a,
        .btn-edit {
            position: relative;
            z-index: 10;
            /* Ensure buttons and links are not triggering the modal */
        }

        .card-link {
            display: block;
            text-decoration: none;
            color: inherit;
            position: relative;
        }

        .badge {
            position: absolute;
            left: 5px;
            top: 20px;
            text-transform: uppercase;
            font-size: 13px;
            font-weight: 700;
            color: #fff;
            padding: 3px 10px;
        }

        .edit {
            position: absolute;
            right: 0px;
            /* Align to the right side */
            top: 5px;
            font-size: 13px;
            font-weight: 700;
            color: #007bff;
            padding: 3px 10px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .edit button {
            color: #0B1E59;
            text-decoration: none;
            font-size: 13px;
            display: flex;
            align-items: center;
            outline: none;
            border: none;
        }

        .edit button:focus {
            outline: none;
            border: none;
        }

        .edit i {
            font-size: 25px;
            /* Match the icon size to the badge text */
        }

        .product-tumb {
            display: flex;
            align-items: center;
            justify-content: center;
            /* height: 300px; */
            /* padding: 50px; */
            background: #f0f0f0;
        }

        .product-tumb img {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover;
        }

        .product-details {
            padding: 30px;
        }

        .product-catagory {
            display: block;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            color: #8DC3F2;
            margin-bottom: 18px;
        }

        .product-details h4 {
            font-weight: 500;
            display: block;
            margin-bottom: 18px;
            text-transform: uppercase;
            color: #0B1E59;
            text-decoration: none;
            color: #8DC3F2;
            transition: 0.3s;
        }

        .product-details p {
            font-size: 15px;
            line-height: 22px;
            margin-bottom: 18px;
            color: #999;
        }

        .product-bottom-details {
            overflow: hidden;
            border-top: 1px solid #eee;
            padding-top: 20px;
        }

        .product-bottom-details div {
            float: left;
            width: 50%;
        }

        .product-price {
            font-size: 18px;
            color: #8DC3F2;
            font-weight: 600;
        }

        .product-price small {
            font-size: 80%;
            font-weight: 400;
            text-decoration: line-through;
            display: inline-block;
            margin-right: 5px;
        }

        .product-links {
            text-align: right;
        }

        .product-links a {
            display: inline-block;
            margin-left: 5px;
            color: #e1e1e1;
            transition: 0.3s;
            font-size: 17px;
        }

        .product-links a:hover {
            color: #8DC3F2;
        }

        .product-links .fa-heart {
            color: gray;
            cursor: pointer;
        }

        .product-links .fa-heart.active {
            color: lightblue;
        }

        .borderless tr,
        .borderless td {
            padding-top: 15px;
            padding-bottom: 15px;
            border: none;
        }

        .order-table-container {
            overflow-x: auto;
            background-color: #ffffff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .order-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
        }

        .order-table th,
        .order-table td {
            padding: 12px 15px;
            text-align: left;
        }

        .order-table th {
            background-color: #050144;
            color: #ffffff;
            font-weight: bold;
        }

        .order-row {
            background-color: #ffffff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .order-row:hover {
            background-color: #f1f1f1;
        }

        .details-row {
            display: none;
            background-color: #f9f9f9;
        }

        .details-table {
            width: 100%;
            border-collapse: collapse;
        }

        .details-table th,
        .details-table td {
            padding: 10px;
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        select {
            padding: 8px;
            border-radius: 5px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
            cursor: pointer;
            outline: none;
            transition: border-color 0.3s ease;
        }

        select:focus {
            border-color: #007bff;
        }

        .action-button {
            padding: 8px 12px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: white;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .action-button:hover {
            background-color: #0056b3;
        }

        /* Responsive Design */
        @media (max-width: 768px) {

            .order-table th,
            .order-table td {
                padding: 10px;
                font-size: 14px;
            }

            .order-table th,
            .order-table td {
                white-space: nowrap;
            }

            .order-row,
            .details-row {
                display: block;
            }

            .order-row,
            .details-row>td {
                display: block;
                width: 100%;
                box-sizing: border-box;
            }

            .order-row td {
                border-bottom: 1px solid #ddd;
            }

            .order-row td::before {
                content: attr(data-label);
                font-weight: bold;
                text-transform: uppercase;
                display: inline-block;
                margin-right: 10px;
                color: #333;
            }

            .details-row td {
                border-top: none;
                padding: 0;
            }

            .details-table th,
            .details-table td {
                padding: 8px 10px;
                font-size: 14px;
            }

            .order-table-container {
                border-radius: 0;
                box-shadow: none;
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

        .bi-check-circle-fill {
            color: #0B1E59;
            font-size: 170px;
        }

        .disabled-link {
            pointer-events: none;
            /* Disable the click */
            color: #6c757d;
            /* Gray out the link */
            cursor: default;
            /* Change the cursor to default */
            text-decoration: none;
            /* Remove the underline */
        }

        /* Charts Container */
        .charts {
            display: flex;
            justify-content: space-between;
            gap: 2rem;
            /* padding-top: 2rem; */
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

        canvas {
            max-width: 100%;
            height: 100% !important;
            /* Ensure the canvas fills the container */
        }

        .bi-hourglass-split {
            color: #0B1E59;
            font-size: 50px
        }

        .bi-check2-circle {
            color: #0B1E59;
            font-size: 50px
        }

        .bi-cash-stack {
            color: #0B1E59;
            font-size: 50px
        }

        /* Toastr Notification Styles */
        .toast {
            background-color: #8DC3F2 !important;
            /* Set the desired background color */
            opacity: 1 !important;
            /* Ensure full opacity */
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            /* Optional shadow for better visibility */
        }

        .toast-info {
            background-color: #8DC3F2 !important;
            /* Set the background for info type notifications */
            color: white !important;
            /* Ensure text color is set for contrast */
            opacity: 1 !important;
            /* Ensure no transparency */
        }

        .toast-info .toast-message {
            display: flex;
            align-items: center;
        }

        .toast-info .toast-message i {
            margin-right: 10px;
        }

        .toast-info .toast-message .notification-content {
            display: flex;
            flex-direction: row;
            align-items: center;
        }

        /* Ensure the entire Toastr container has no transparency */
        .toast:hover {
            opacity: 1 !important;
            /* Remove any hover transparency */
        }
    </style>

</head>

<body>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    @include('layouts.seller.sidebar')

    <!-- Main Content Area -->
    <div class="content-area">
        @yield('content')

        <!-- Toastr JavaScript -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

        <!-- Pusher -->
        <script src="https://js.pusher.com/8.2.0/pusher.min.js"></script>
        <!-- Script For notification -->
        <script>
            Pusher.logToConsole = true;

            // Initialize Pusher
            var pusher = new Pusher('32acbce4969b2fe50044', {
                cluster: 'mt1'
            });

            // Subscribe to the channel
            var channel = pusher.subscribe('notification');

            // Array to store the order references that have already triggered notifications
            var notifiedOrders = [];

            // Bind to the event
            channel.bind('new-order.notification', function(order) {

                // Display Toastr notification with icons and inline content
                if (order && !notifiedOrders.includes(order.order.order_reference)) {
                    // Add the order reference to the list of notified orders
                    notifiedOrders.push(order.order.order_reference);

                    // this will display the new row
                    // kaylangan kung anong itsura sa ui, ganun din sa script
                    // '<tr> </tr>' 
                    // id of table .prepend

                    toastr.info(
                        ' <div class="notification-content"> ' +
                        ' <i class="fas fa-user"></i> <span> ' + order.order.order_reference + ' </span> ' +
                        ' <i class="fas fa-book" style="margin-left: 20px;"></i> <span> </span> ' +
                        ' </div> ',
                        'New Order', {
                            closeButton: true,
                            progressBar: true,
                            timeOut: 0, // Set timeOut to 0 to make it persist until closed
                            extendedTimeOut: 0, // Ensure the notification stays open
                            positionClass: 'toast-top-right',
                            enableHtml: true,
                            toastClass: 'toast toast-info',
                            onclick: function() {
                                window.location.href = "{{ route('my.orders') }}"; // Redirect to my.orders route
                            }
                        }
                    );
                } else {
                    console.error('Invalid data received:', order);
                }
            });

            // Debugging line
            pusher.connection.bind('connected', function() {
                console.log('Pusher connected');
            });
        </script>

        <!-- Bootstrap Bundle with Popper.js -->
        <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->
    </div>

    <!-- Custom JS -->
    <!-- @vite(['resources/js/app.js']) -->

</body>


</html>