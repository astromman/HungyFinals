@extends('layouts.manager.managerMaster')

@section('content')
<div class="container-fluid pt-3">
    <div class="text-center py-2 px-5">
        <h2>My Profile</h2>
    </div>
    <div class="row pt-3 justify-content-center">
        <div class="col-lg-5">
            <div class="card shadow-lg rounded-4 mb-4">
                <div class="pt-3 text-center">
                    <h3>Change Password</h3>
                </div>
                <div class="pt-3 d-flex justify-content-center align-items-center">
                    <div class="col-lg-11">
                        @if (session('success'))
                        <div class="alert alert-info" role="alert">
                            <strong>{{ session('success') }}</strong>
                        </div>
                        @endif

                        @if (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                        @endif
                        <form method="POST" action="{{ route('manager.update.password') }}">
                            @csrf
                            <div class="mb-3">
                                <input name="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror" id="current_password" placeholder="Current Password">
                                @error('current_password')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <input name="new_password" type="password" class="form-control @error('new_password') is-invalid @enderror" id="new_password" placeholder="New Password">
                                @error('new_password')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <input name="confirm_password" type="password" class="form-control @error('confirm_password') is-invalid @enderror" id="confirm_password" placeholder="Confirm New Password">
                                @error('confirm_password')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Submit button -->
                            <div class="mb-1 text-center">
                                <button type="submit" class="btn btn-success btn-rounded w-100 mb-3">Save</button>
                            </div>

                            <div class="alert alert-primary">
                                <p>
                                    Enter your current and new password then Click "Save" button to change password.
                                </p>
                                <strong>Hint:</strong>

                                <li>Password must be at least 8 characters long.</li>
                                <li>Password must contain at least one(1) uppercase letter, one(1) numerical character.</li>
                                <li>Must have atleast one(1) special character.</li>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection