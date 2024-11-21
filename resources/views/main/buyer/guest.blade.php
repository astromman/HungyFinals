<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&display=swap" rel="stylesheet">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <title>Hungry FalCONs</title>

    <style>
        /* * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        } */

        body {
            font-family: 'Poppins', sans-serif;
            line-height: 1.6;
            background-color: white;
        }

        /* header {
            background-color: #ff6b35;
            color: white;
            padding: 20px 0;
            text-align: center;
        } */

        header h1 {
            font-size: 3rem;
        }

        /* Hero Section */
        .hero {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 50px;
            background-color: white;
            gap: 20px;
        }

        .hero-text {
            max-width: 40%;
            text-align: left;
        }

        .hero-text h2 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 2.5rem;
            line-height: 1.1;
            margin-bottom: 5px;
            color: #0077b6;
        }

        .hero-text p {
            font-size: 1.1rem;
            color: #555;
            margin: 20px 0;
            line-height: 1.8;
        }

        /* Updated Button Design */
        .hero-text button,
        .buttons button {
            padding: 10px 25px;
            background: #0077b6;
            border: none;
            color: white;
            font-size: 1.3rem;
            cursor: pointer;
            border-radius: 30px;
            transition: all 0.3s ease-in-out;
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
            text-transform: uppercase;
            margin-top: 20px;
        }

        .hero-text button:hover,
        .buttons button:hover {
            background: linear-gradient(45deg, #8DC3F2, #8DC3F2);
            box-shadow: 0px 7px 20px rgba(0, 0, 0, 0.3);
            transform: translateY(-3px);
        }

        .hero-image img {
            max-width: 100%;
            width: 400px;
            border-radius: 20px;
        }

        /* About Us Section */
        .about-us {
            padding: 50px 20px;
            background-color: white;
            text-align: center;
        }

        .about-us h2 {
            font-size: 2.5rem;
            font-family: 'Playfair Display', serif;
            color: #0077b6;
            margin-bottom: 20px;
        }

        .about-us p {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #555;
            max-width: 900px;
            margin: 0 auto;
        }

        /* Mission Section with Image and Text */
        .mission-section {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 60px 20px;
            background-color: #ffffff;
            text-align: left;
            max-width: 1200px;
            margin: 0 auto;
        }

        .mission-image img {
            max-width: 100%;
            width: 500px;
            border-radius: 10px;
        }

        .mission-text {
            max-width: 600px;
            margin-left: 50px;
        }

        .mission-text h2 {
            font-size: 2.5rem;
            font-family: 'Playfair Display', serif;
            color: #0077b6;
            margin-bottom: 20px;
        }

        .mission-text p {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #555;
        }

        /* Product Section */
        .product-section {
            padding: 50px 20px;
            background-color: white;
            text-align: center;
        }

        .product-section h2 {
            font-size: 2.5rem;
            color: #0077b6;
            margin-bottom: 20px;
        }

        .product-section p {
            font-size: 1.1rem;
            color: #555;
            margin-bottom: 30px;
            max-width: 900px;
            margin: 0 auto;
        }

        .products {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 20px;
        }

        .product-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 230px;
            padding: 20px;
            text-align: center;
        }

        .product-card img {
            width: 100%;
            height: auto;
            border-radius: 10px;
        }

        .product-card h3 {
            font-size: 1.2rem;
            color: #0077b6;
            margin: 10px 0;
        }

        .product-card p {
            font-size: 1rem;
            color: #555;
        }

        .product-card .price {
            color: #0077b6;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .product-card button {
            background-color: #0077b6;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .product-card button:hover {
            background-color: #005f99;
        }

        footer {
            background-color: #0B1E59;
            color: white;
            padding: 20px;
            text-align: center;
        }

        footer p {
            margin: 10px 0;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero {
                flex-direction: column;
                text-align: center;
                padding: 20px;
            }

            .hero-text {
                max-width: 100%;
                margin-bottom: 30px;
            }

            .hero-image img {
                width: 250px;
                /* Adjust for mobile */
            }

            .about-content {
                flex-direction: column;
                text-align: center;
            }

            .about-text {
                margin: 20px 0;
            }

            .mission-section {
                flex-direction: column;
                text-align: center;
            }

            .mission-text {
                margin-left: 0;
                margin-top: 30px;
            }
        }

        @media (max-width: 480px) {
            .hero-text h2 {
                font-size: 2rem;
            }

            .hero-text p {
                font-size: 1rem;
            }

            .hero-text button {
                font-size: 1rem;
                padding: 8px 16px;
            }
        }

        .navbar,
        .footer {
            background-color: #0B1E59;
        }

        .navbar-brand {
            margin-right: 0;
        }

        .navbar-brand,
        .nav-link,
        .footer h4,
        .footer p,
        .footer a {
            color: white;
        }

        .nav-icons {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .dropdown-menu {
            background-color: #8DC3F2;
        }

        .dropdown-menu .dropdown-item {
            color: white;
        }

        .dropdown-menu .dropdown-item:hover {
            background-color: #7AB9E1;
        }

        .dropdown-menu {
            padding: 10px;
            margin-top: 10px;
        }

        /* Canteen Card Image Styles */
        .canteen-image-container {
            position: relative;
            height: 180px;
            background-size: cover;
            background-position: center;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        /* Gradient Overlay */
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.2), rgba(0, 0, 0, 0.5));
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        /* Card Title Styles */
        .card-title {
            font-size: 1.25rem;
            color: #0077b6;
            font-weight: bold;
        }

        /* Card Text Styles */
        .card-text {
            font-size: 1rem;
            color: #555;
        }

        /* Canteen Cards Layout */
        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.2);
        }

        /* Canteen Card Body Alignment */
        .card-body {
            padding: 20px;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .canteen-image-container {
                height: 150px;
            }
        }

        @media (max-width: 480px) {
            .canteen-image-container {
                height: 120px;
            }

            .card-title {
                font-size: 1rem;
            }

            .card-text {
                font-size: 0.9rem;
            }
        }
    </style>
</head>

<body>

    @include('layouts.buyer.guestnavbar')

    <section class="hero">
        <div class="mission-text">
            <h2>Welcome to Hungry FalCONs!</h2>
            <p>Hungry FalCONs is the official online food marketplace of Adamson University, designed to bring the campus canteen experience right to your fingertips! No more long queues, no more hassle—order your favorite meals online and pick them up at your convenience.</p>
            <div class="buttons">
                <button class="order-btn" onclick="window.location.href='{{ route('user.logout') }}'">Order Now</button>
            </div>
        </div>
        <div class="mission-image">
            <img src="{{ asset('images/bg/default_shop_image.png') }}" alt="Delicious food">
        </div>
    </section>

    <section class="about-us">
        <h2>Getting Started!</h2>
        <ul>
            <li>1. Register using your Adamson Email.</li>
            <li>1.2 Verify your account using the OTP sent in your AdU Mail.</li>
            <li>2. Browse through our website and find the canteen you desire.</li>
            <li>3. 
            </li>
        </ul>
    </section>

    <!-- Mission Section with Image and Text -->
    <section class="mission-section">
        <div class="mission-image">
            <img src="{{ asset('images/bg/default_shop_image.png') }}" alt="Mission Image">
        </div>
        <div class="mission-text">
            <h2>Our Mission and Vision</h2>
            <p>At Hungry FalCONs, we strive to be the leading food service platform at Adamson University, revolutionizing campus dining by offering fast, convenient, and reliable meal solutions. Our mission is to simplify food ordering by connecting students with their favorite canteen meals efficiently, delivering high-quality food and an exceptional experience that fits seamlessly into their busy schedules, ensuring satisfaction in every bite.</p>
        </div>
    </section>

    <section class="about-us">
        <h2>Canteens are One Click Away!</h2>
        <p>With Hungry FalCONs, our easy online food ordering system, you can skip the lines and enjoy fresh food quickly. Experience fast service, great meals, and convenience with every order! WE BRING THE CANTEENS CLOSER TO YOU!</p>

        <div class="container mt-4">
            <div class="row row-cols-1 row-cols-md-3 g-4">
                @foreach($canteens as $canteen)
                <div class="col">
                    <div class="card h-100 shadow-sm border-0">
                        <!-- Background Image Container -->
                        @if(is_null($canteen->building_image))
                        <div class="canteen-image-container" style="background-image: url('{{ asset('images/bg/default_shop_image.png') }}');">
                            <!-- Gradient Overlay -->
                            <div class="overlay"></div>
                        </div>
                        @else
                        <div class="canteen-image-container" style="background-image: url('{{ asset('storage/canteen/' . $canteen->building_image) }}');">
                            <!-- Gradient Overlay -->
                            <div class="overlay"></div>
                        </div>
                        @endif

                        <!-- Card Body -->
                        <div class="card-body d-flex flex-column justify-content-between">
                            <h5 class="card-title text-center text-dark">{{ $canteen->building_name }}</h5>
                            <p class="card-text text-center">Available Shops: {{ $canteen->shops->where('status', 'Verified')->count() }}</p>
                            <small class="text-muted text-center">{{ $canteen->building_description }}</small>
                        </div>

                        <!-- Button or Link to Canteen -->
                        <a href="{{ route('user.logout') }}" class="stretched-link"></a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <footer>
        <p>&copy; 2024 Hungry FalCONs. All rights reserved.</p>
    </footer>

</body>

</html>