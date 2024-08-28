@extends('layouts.seller.sellerMaster')

@section('content')
<div class="container-fluid pt-5">
    <div class="row justify-content-center">
        <div class="card col-lg-5 shadow-lg rounded-4">
            <div class="col py-3 text-center">
                <h3>Edit my Shop</h3>
            </div>

            <div class="d-flex justify-content-center align-items-center">
                <div class="col-lg-11">
                    @if (session('success'))
                    <div class="alert alert-info" role="alert">
                        <strong>{{ session('success') }}</strong>
                    </div>
                    @endif
                    <form method="POST" action="{{ route('shop.updated.details') }}" enctype="multipart/form-data">
                        @csrf
                        <!-- Inputs -->
                        <div class="mb-3">
                            <label class="form-label">Username</label>
                            <input name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username', $userProfile->username) }}" type="text">
                            @error('username')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Shop Name</label>
                            <input name="shop_name" class="form-control @error('shop_name') is-invalid @enderror" value="{{ old('first_name', $shopDetails->shop_name) }}" type="text">
                            @error('shop_name')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-lg-6 mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $userProfile->email) }}" type="email" id="email">
                                @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="col-lg-6 mb-3">
                                <label for="email" class="form-label">Contact Number</label>
                                <input name="contact_num" class="form-control @error('contact_num') is-invalid @enderror" value="{{ old('contact_num', $userProfile->contact_num) }}" type="text" id="email">
                                @error('contact_num')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col mb-3">
                            <label for="formFile" class="form-label">Shop Banner</label>
                            <input name="shop_image" class="form-control" type="file" id="formFile">
                        </div>

                        <div class="mb-3">
                            <label for="building_description" class="form-label">About Shop (optional)</label>
                            <textarea name="shop_bio" class="form-control @error('shop_bio') is-invalid @enderror" placeholder="Tell the customers about your shop" id="shop_bio" rows="4">{{ old('shop_bio') }}</textarea>
                            @error('shop_bio')
                            <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Submit button -->
                        <div class="mb-2">
                            <button type="submit" class="btn btn-success btn-rounded w-100 mb-3">Save</button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection