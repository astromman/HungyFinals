@extends('layouts.buyer.buyermaster')

@section('content')
<div class="container my-4 flex-grow-1">
    <div class="row">
        <div class="mb-2">
            <a href="{{ route('landing.page') }}">
                <i class="fa fa-angle-left" style="font-size: large;"></i>
            </a>
        </div>

        <div class="container-fluid position-relative" style="height: 350px; overflow: hidden;">
            <!-- Blurred Background Image -->
            @if(is_null($canteen->building_image))
            <div class="position-absolute w-100 h-100"
                style="background-image: url('{{ asset('images/bg/default_shop_image.png') }}'); 
                background-size: cover; 
                background-repeat: no-repeat; 
                background-position: center; 
                z-index: 0;">
            </div>
            @else
            <div class="position-absolute w-100 h-100"
                style="background-image: url('{{ asset('storage/canteen/' . $canteen->building_image) }}'); 
                background-size: cover; 
                background-repeat: no-repeat; 
                background-position: center; 
                z-index: 0;">
            </div>
            @endif

            <!-- Gradient Overlay -->
            <div class="position-absolute w-100 h-100"
                style="background: linear-gradient(to bottom, rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3)); 
                z-index: 1;">
            </div>

            <div class="position-absolute bottom-0 w-100 p-5" style="z-index: 1; color: white; text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);">
                <!-- <p class="highlight-text">100% Masarap</p> -->
                <h1 class="custom-font text-white">{{ $canteen->building_name }}</h1>
                <br>
                <p class="text-white">{{ $canteen->building_description }}</p>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <h4 class="highlight-text">Available Shops</h4>
        @forelse($shops as $shop)
        <div class="col-md-3 mb-4">
            <div class="card h-100 shadow" style="width: 100%;">
                <!-- Background Image Container -->
                @if($shop->shop_image == 'Not Available')
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
                    <!-- <div class="position-relative text-white p-3" style="z-index: 1;">
                        <div class="d-flex justify-content-center align-items-center">
                            <i class="fas fa-map-marker-alt me-2"></i>
                        </div>
                        <h5 class="card-title">{{ $shop->shop_name }}</h5>
                    </div> -->
                </div>
                @else
                <div class="position-relative" style="height: 150px; overflow: hidden;">
                    <div class="position-absolute w-100 h-100"
                        style="background-image: url('{{ asset('storage/shop/' . $shop->shop_image) }}'); 
                    background-size: cover; 
                    background-repeat: no-repeat; 
                    background-position: center;">
                    </div>
                    <!-- Gradient Overlay -->
                    <div class="position-absolute w-100 h-100"
                        style="background: linear-gradient(to bottom, rgba(0, 0, 0, 0.3), rgba(0, 0, 0, 0.3));">
                    </div>
                    <!-- Title and Icon -->
                    <!-- <div class="position-relative text-white p-3" style="z-index: 1;">
                        <div class="d-flex justify-content-center align-items-center">
                            <i class="fas fa-map-marker-alt me-2"></i>
                        </div>
                        <h5 class="card-title">{{ $shop->shop_name }}</h5>
                    </div> -->
                </div>
                @endif

                @if($shop->is_reopen)
                <a href="{{ route('visit.shop', ['id' => $shop->id, 'shop_name' => Str::slug($shop->shop_name)]) }}" class="text-dark stretched-link" style="text-decoration: none;">
                    <!-- <i class="fa-solid fa-store"></i> -->
                    <div class="card-body d-flex flex-column justify-content-between" style="height: 100px;">
                        <h5 class=" card-title">{{ $shop->shop_name }}</h5>
                        <p class="card-text">Mon - Fri</p>
                    </div>
                </a>
                @else
                <div class="card-body d-flex flex-column justify-content-between" style="height: 100px;">
                    <h5 class=" card-title">{{ $shop->shop_name }}</h5>
                    <p class="card-text">Closed</p>
                </div>
                @endif
            </div>
        </div>
        @empty
        <span>No shops yet in this canteen.</span>
        @endforelse
    </div>
</div>
@endsection