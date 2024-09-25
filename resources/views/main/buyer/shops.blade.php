@extends('layouts.buyer.buyermaster')

@section('content')
<div class="container my-5 flex-grow-1">
    <div class="row">
        <div class="mb-3">
            <div>
                <a href="{{ route('landing.page') }}">
                    <i class="fa fa-angle-left" style="font-size: large;"></i>
                </a>
            </div>

            <h1 class="custom-font pt-2">Available Shops</h1>
            <div class="col-lg-3 pt-1">
                <form id="categoryFilterForm" action="{{ route('shops.list') }}" method="GET">
                    @csrf
                    <select class="form-select form-select-sm" name="building_id" onchange="document.getElementById('categoryFilterForm').submit();">
                        <option value="" {{ is_null($building_id) ? 'selected' : '' }}>All</option>

                        @foreach ($buildings as $data)
                        <option value="{{ $data->id }}" {{ $building_id == $data->id ? 'selected' : '' }}>{{ $data->building_name }}</option>
                        @endforeach

                    </select>
                </form>
            </div>
        </div>

        <!-- Shop Card 1 -->
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
                </div>
                @endif

                @if($shop->is_reopen)
                <div class="badge bg-success">
                    {{ $shop->designated_canteen }}
                </div>
                <a href="{{ route('visit.shop', ['id' => $shop->id, 'shop_name' => Str::slug($shop->shop_name)]) }}" class="text-dark stretched-link" style="text-decoration: none;">
                    <div class="card-body d-flex flex-column justify-content-between" style="height: 100px;">
                        <h5 class=" card-title">{{ $shop->shop_name }}</h5>
                        <small class="card-text text-muted">Average Prep Time: {{ $shop->preparation_time . ' mins' }}</small>
                    </div>
                </a>
                @else <!-- unclickable -->
                <div class="badge bg-success">
                    {{ $shop->designated_canteen }}
                </div>
                <div class="card-body d-flex flex-column justify-content-between" style="height: 100px;">
                    <h5 class=" card-title">{{ $shop->shop_name }}</h5>
                    <p class="card-text text-danger">Closed</p>
                </div>
                @endif
            </div>
        </div>
        @empty
        <div class="py-5 d-flex justify-content-center align-items-center">
            <h5 class="card-title">No shops available.</h5>
        </div>
        @endforelse
    </div>
</div>
@endsection