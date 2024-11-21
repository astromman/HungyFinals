@extends('layouts.buyer.buyermaster')

@section('content')
<!-- Hero Section -->
<div class="hero" style="background-image: url('images/bg/sv-building.png'); background-size: cover; background-position: center; background-repeat: no-repeat; object-fit: cover;">
    <h1>Hungry FalCONs</h1>
    <p>Our system streamlines the process of ordering meals, making it faster and more convenient for students, faculty, and staff. Browse a wide variety of food options from your favorite canteens, customize your order, and enjoy seamless pickup or delivery services.</p>
    <!-- <button class="btn btn-primary">Browse gallery</button> -->
</div>

<!-- Features Section -->
<div class="container my-5">
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="feature-card text-center">
                <img src="images/logo/shawn.png" alt="Feature 1" class="img-fluid">
                <h2>Shawn</h2>
                <p>Developer</p>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="feature-card text-center">
                <img src="images/logo/yuri.jpg" alt="Feature 2" class="img-fluid">
                <h2>Yuri</h2>
                <p>Developer</p>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="feature-card text-center">
                <img src="images/logo/leoj.png" alt="Feature 3" class="img-fluid">
                <h2>Leoj</h2>
                <p>Developer</p>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="feature-card text-center">
                <img src="images/logo/lloyd.jpg" alt="Feature 4" class="img-fluid">
                <h2>Lloyd</h2>
                <p>Developer</p>
            </div>
        </div>
    </div>
</div>

<!-- Featurette Section -->
<div class="container">
    <hr class="featurette-divider">
    <div class="row featurette">
        <div class="col-12 text-center">
            <h2 class="featurette-heading">Nourish Your Day with Every Order.</h2>
            <p> Transform your school meals with our convenient food ordering system. From hearty breakfasts to nutritious lunches, our menu offers a variety of delicious options to fuel your day, making school dining a breeze.</p>
        </div>
    </div>
    <hr class="featurette-divider">
    <div class="row featurette">
        <div class="col-12 text-center order-md-2">
            <h2 class="featurette-heading">Delicious Choices at Your Fingertips.</h2>
            <p>Experience the ease of our school canteen's food ordering system. With a wide range of tasty and wholesome dishes, we ensure that every meal is a delightful experience, catering to all your cravings and dietary needs.</p>
        </div>
    </div>
    <hr class="featurette-divider">
    <div class="row featurette">
        <div class="col-12 text-center">
            <h2 class="featurette-heading">Eat Well, Learn Well.</h2>
            <p>Our school canteen's food ordering system brings a world of flavors to your daily routine. From balanced meals to tasty snacks, we provide a convenient way to enjoy fresh and healthy food, supporting your well-being and academic success.</p>
        </div>
    </div>
    <hr class="featurette-divider">
</div>
@endsection