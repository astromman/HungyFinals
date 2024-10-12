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
    <title>Hungry Falcons</title>

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
            background: linear-gradient(45deg, #ff924f, #ff6b35);
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
    </style>
</head>

<body>

    @include('layouts.buyer.guestnavbar')

    <section class="hero">
        <div class="mission-text">
            <h2>OUR BEST <br><span>HEALTHY FOOD</span></h2>
            <p>Hungry FalCONs is the official online food marketplace of Adamson University, designed to bring the campus canteen experience right to your fingertips! No more long queues, no more hassle—order your favorite meals online and pick them up at your convenience.</p>
            <div class="buttons">
                <button class="order-btn">Order Now</button>
            </div>
        </div>
        <div class="mission-image">
            <img src="{{ asset('images/WHY.png') }}" alt="Delicious food">
        </div>
    </section>

    <section class="about-us">
        <h2>Hungry Falcons</h2>
        <p>Welcome to Hungry Falcons! We strive to provide the best food service experience for Adamson University students, ensuring a convenient, fast, and quality meal ordering system. Founded in 2024, we aim to bring efficiency and satisfaction to every student on campus.</p>
    </section>

    <!-- Mission Section with Image and Text -->
    <section class="mission-section">
        <div class="mission-image">
            <img src="{{ asset('images/try4.png') }}" alt="Mission Image">
        </div>
        <div class="mission-text">
            <h2>Our Mission and Vision</h2>
            <p>At Hungry Falcons, we strive to be the leading food service platform at Adamson University, revolutionizing campus dining by offering fast, convenient, and reliable meal solutions. Our mission is to simplify food ordering by connecting students with their favorite canteen meals efficiently, delivering high-quality food and an exceptional experience that fits seamlessly into their busy schedules, ensuring satisfaction in every bite.</p>
        </div>
    </section>

    <!-- Product Section -->
    <section class="product-section">
    <h2>Our Products</h2>
    <p>From premium ingredients to mouth-watering dishes, we have a wide variety of meals to suit your taste. Take your pick from our collection of top sellers and start your day the right way!</p>
    <div class="products">
        @foreach($products->take(3) as $product) <!-- Limits to the first 3 products -->
        <div class="product-card">
            <img src="{{ asset('storage/products/' . $product->image) }}" alt="{{ $product->product_name }}">
            <h3>{{ $product->product_name }}</h3>
            <p>{{ $product->description }}</p>
            <p class="price">₱{{ $product->price }}</p>
            <button>Add to Cart</button>
        </div>
        @endforeach
    </div>
</section>

    <section class="about-us">
        <h2>Canteen Shops</h2>
        <p>Welcome to Hungry Falcons! We offer a variety of affordable, delicious meals to suit every taste. With our easy online ordering, you can skip the lines and enjoy fresh food quickly. Experience fast service, great meals, and convenience with every order!</p>
    </section>


    <footer>
        <p>&copy; 2024 Hungry Falcons. All rights reserved.</p>
    </footer>

</body>

</html>