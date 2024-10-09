@extends('layouts.buyer.buyermaster')

@section('content')
<!-- Hero Section -->
<div class="hero">
    <h1>One more for good measure.</h1>
    <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam. Donec id elit non mi porta gravida at eget metus. Nullam id dolor id nibh ultricies vehicula ut id elit.</p>
    <!-- <button class="btn btn-primary">Browse gallery</button> -->
</div>

<!-- Features Section -->
<div class="container my-5">
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="feature-card text-center">
                <img src="https://via.placeholder.com/100" alt="Feature 1" class="img-fluid">
                <h2>Shawn</h2>
                <p>Developer</p>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="feature-card text-center">
                <img src="https://via.placeholder.com/100" alt="Feature 2" class="img-fluid">
                <h2>Yuri</h2>
                <p>Developer</p>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="feature-card text-center">
                <img src="https://via.placeholder.com/100" alt="Feature 3" class="img-fluid">
                <h2>Leoj</h2>
                <p>Developer</p>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="feature-card text-center">
                <img src="https://via.placeholder.com/100" alt="Feature 4" class="img-fluid">
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
        <div class="col-md-7">
            <h2 class="featurette-heading">Nourish Your Day with Every Order.</h2>
            <p> Transform your school meals with our convenient food ordering system. From hearty breakfasts to nutritious lunches, our menu offers a variety of delicious options to fuel your day, making school dining a breeze.</p>
        </div>
        <!-- 500x500 need sa picture -->
        <div class="col-md-5">
            <img src="images/.jpg" alt="Featurette image" class="img-fluid">
        </div>
    </div>
    <hr class="featurette-divider">
    <div class="row featurette">
        <div class="col-md-7 order-md-2">
            <h2 class="featurette-heading">Delicious Choices at Your Fingertips.</h2>
            <p>Experience the ease of our school canteen's food ordering system. With a wide range of tasty and wholesome dishes, we ensure that every meal is a delightful experience, catering to all your cravings and dietary needs.</p>
        </div>
        <div class="col-md-5 order-md-1">
            <img src="images/.jpg" alt="Featurette image" class="img-fluid">
        </div>
    </div>
    <hr class="featurette-divider">
    <div class="row featurette">
        <div class="col-md-7">
            <h2 class="featurette-heading">Eat Well, Learn Well.</h2>
            <p>Our school canteen's food ordering system brings a world of flavors to your daily routine. From balanced meals to tasty snacks, we provide a convenient way to enjoy fresh and healthy food, supporting your well-being and academic success.</p>
        </div>
        <div class="col-md-5">
            <img src="images/.jpg" alt="Featurette image" class="img-fluid">
        </div>
    </div>
    <hr class="featurette-divider">
</div>
@endsection