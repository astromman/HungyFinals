@extends('layouts.manager.managerMaster')

@section('content')
<div class="container-fluid pt-5">
    <div class="text-center py-2 px-5">
        <h2>My Profile</h2>
    </div>
    @if (session('error'))
    <div class="alert alert-danger" role="alert">
        {{ session('error') }}
    </div>
    @endif
    <div class="row pt-3 justify-content-center">
        <div class="col-lg-4">
            <div class="card shadow-lg rounded-4 mb-4">
                <div class="pt-3 text-center">
                    <h3>Edit Profile</h3>
                </div>
                <div class="pt-4 d-flex justify-content-center align-items-center">
                    <div class="col-lg-11">
                        @if (session('success'))
                        <div class="alert alert-info" role="alert">
                            <strong>{{ session('success') }}</strong>
                        </div>
                        @endif
                        <form method="POST" action="{{ route('manager.update.profile') }}">
                            @csrf
                            <!-- First and Last Name -->
                            <div class="row mb-2">
                                <div class="col-lg-6">
                                    <label for="first_name" class="form-label">First Name</label>
                                    <input name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('$first_name', $userProfile->first_name) }}" type="text" id="first_name">
                                    @error('first_name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-6">
                                    <label for="last_name" class="form-label">Last Name</label>
                                    <input name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name', $userProfile->last_name) }}" type="text" id="last_name">
                                    @error('last_name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Username -->
                            <div class="mb-2">
                                <label for="username" class="form-label">Username</label>
                                <input name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username', $userProfile->username) }}" type="text" id="username">
                                @error('username')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email address</label>
                                <input name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $userProfile->email) }}" type="email" id="email">
                                @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Submit button -->
                            <div class="mb-4 text-center">
                                <button type="submit" class="btn btn-success btn-rounded w-100 mb-3">Save</button>
                                <a href="{{ route('manager.change.password') }}" class="btn btn-primary w-100 mb-3">Change Password</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection