@extends('layouts.buyer.buyermaster')

@section('content')

@if(session('error'))
<div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="successModalLabel">
                    <i class="bi bi-exclamation-triangle-fill text-warning"></i> System
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ session('error') }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endif

<div class="container my-5 flex-grow-1">
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div>
                <p class="highlight-text">100% Masarap</p>
                <h1 class="custom-font">We provide a platform for your cravings</h1>
            </div>
            <div class="searchbox-wrap">
                <input type="text" placeholder="Search for something...">
                <button><span>Submit</span> </button>
            </div>
        </div>
        <div class="col-lg-6">
            <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="{{asset('images/bg/default_shop_image.png')}}" class="d-block w-100" alt="Image 1">
                    </div>
                    @foreach($products as $product)
                    <div class="carousel-item">
                        <img src="{{ asset('storage/products/' . $product->image) }}" class="d-block w-100" title="{{ $product->product_name }}" alt="{{ $product->product_name }}">
                    </div>
                    @endforeach
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </div>

    <div class="row mt-5">
        <h3>Canteens</h3>
        @foreach($canteens as $canteen)
        <div class="col-md-3 mb-4 ">
            <div class="card h-100 shadow" style="width: 100%;">
                <!-- Background Image Container -->
                @if(is_null($canteen->building_image))
                <div class="position-relative" style="height: 150px; overflow: hidden;">
                    <div class="position-absolute w-100 h-100"
                        style="background-image: url('{{ asset('images/bg/default_shop_image.png') }}'); 
                    background-size: cover; 
                    background-repeat: no-repeat; 
                    background-position: center;">
                    </div>
                    <!-- Gradient Overlay -->
                    <div class="position-absolute w-100 h-100"
                        style="background: linear-gradient(to bottom, rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3));">
                    </div>
                    <!-- Title and Icon -->
                    <div class="position-relative text-white p-3" style="z-index: 1;">
                        <div class="d-flex justify-content-center align-items-center">
                            <i class="fas fa-map-marker-alt me-2"></i>
                        </div>
                        <h5 class="card-title">{{ $canteen->building_name }}</h5>
                    </div>
                </div>
                @else
                <div class="position-relative" style="height: 150px; overflow: hidden;">
                    <div class="position-absolute w-100 h-100"
                        style="background-image: url('{{ asset('storage/canteen/' . $canteen->building_image) }}'); 
                    background-size: cover; 
                    background-repeat: no-repeat; 
                    background-position: center;">
                    </div>
                    <!-- Gradient Overlay -->
                    <div class="position-absolute w-100 h-100"
                        style="background: linear-gradient(to bottom, rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3));">
                    </div>
                    <!-- Title and Icon -->
                    <div class="position-relative text-white p-3" style="z-index: 1;">
                        <div class="d-flex justify-content-center align-items-center">
                            <i class="fas fa-map-marker-alt me-2"></i>
                        </div>
                        <h5 class="card-title">{{ $canteen->building_name }}</h5>
                    </div>
                </div>
                @endif

                <!-- Card Body -->
                <a href="{{ route('visit.canteen', ['id' => $canteen->id, 'building_name' => Str::slug($canteen->building_name)]) }}" class="text-dark stretched-link" style="text-decoration: none;">
                    <div class="card-body d-flex flex-column justify-content-between" style="height: 100px;">
                        <p class="card-text mb-1">Mon - Fri</p>
                        <small>{{ $canteen->building_description }}</small>
                    </div>
                </a>
            </div>
        </div>
        @endforeach


    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var successModal = new bootstrap.Modal(document.getElementById('successModal'));
        successModal.show();
    });
</script>
@endsection