@extends('layouts.seller.sellerMaster')

@section('content')
<div class="container-fluid pt-4">
    <!-- Title/heading -->
    <div class="ps-4 pb-3" style="font-family: Arial, sans-serif">
        <h2>Application Status</h2>
        <p>This will help to manage your time and observe your application.</p>
    </div>
    <div class="row justify-content-center">
        <!-- sub title inside the card/white-bg -->
        <div class="card col-lg-10 shadow-lg rounded-4">
            <div class="container pt-3">
                <h2>Congratulations!</h2>
            </div>

            <!-- progress tracker here -->
            <div class="container-fluid con-pb pt-3 px-3">

                @include('main.unverified.protobar')
            </div>

            <!-- message with logo -->
            <div class="container-fluid">
                <div class=" d-flex justify-content-center align-items-center">
                    <i class="bi bi-check-circle-fill"></i>
                </div>

                <div class="mb-3 text-center">
                    <h2>You are now fully verified!</h2>
                </div>

                <div>
                    <p class="text-center">
                        You now have access to your shop.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection