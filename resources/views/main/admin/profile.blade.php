@extends('layouts.admin.adminMaster')

@section('content')
<div class="container-fluid pt-5">
    <div class="container pt-5">
        <h2>Welcome Admin, {{ $userProfile->username }}</h2>
        @if (session('error'))
        <div class="alert alert-danger" role="alert">
            {{ session('error') }}
        </div>
        @endif
        <hr class="divider">
        <div class="info-container">
            <div>
                <h3><strong style="color: grey;">Personal info</strong> <br><span style="font-size: small;">See your personal information on this page</span></h3>
            </div>
            <div class="button-group">
                <button type="button" class="edit-button" onclick="enableEditing()">Edit</button>
                <button type="submit" class="save-button" id="saveButton">Save</button>
            </div>
        </div>
        <hr class="divider">
        @if (session('success'))
        <div class="alert alert-info" role="alert">
            <strong>{{ session('success') }}</strong>
        </div>
        @endif
        <form id="profileForm" method="POST" action="{{ route('admin.update.profile') }}">
            @csrf
            <div class="form-group">
                <input name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name', $userProfile->first_name) }}" type="text" placeholder="First Name" disabled>
                @error('first_name')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <input name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name', $userProfile->last_name) }}" type="text" placeholder="Last Name" disabled>
                @error('last_name')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <input name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username', $userProfile->username) }}" type="text" placeholder="Username" disabled>
                @error('username')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <input name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $userProfile->email) }}" type="email" placeholder="Email" disabled>
                @error('email')
                <span class="invalid-feedback">{{ $message }}</span>
                @enderror
            </div>
        </form>
        <hr class="divider">
        <div class="change-password-container">
            <div class="change-password-text">
                <strong style="color: grey;">Change Password</strong> <br><span style="font-size: small;">Click this to change your password</span>
            </div>
            <a href="{{ route('admin.change.password') }}" class="change-password-button">Change Password</a>
            <!-- <button type="submit" class="change-password-button">Change Password</button> -->
        </div>
    </div>
</div>

<script>
    function enableEditing() {
        var inputs = document.querySelectorAll('#profileForm input');
        inputs.forEach(function(input) {
            input.disabled = false;
        });
        var editButton = document.querySelector('.edit-button');
        editButton.textContent = 'Cancel';
        editButton.setAttribute('type', 'submit');
        editButton.setAttribute('onclick', 'disableEditing()');
    }

    function disableEditing() {
        var inputs = document.querySelectorAll('#profileForm input');
        inputs.forEach(function(input) {
            input.disabled = true;
        });

        var editButton = document.querySelector('.edit-button');
        editButton.textContent = 'Edit';
        editButton.setAttribute('type', 'button');
        editButton.setAttribute('onclick', 'enableEditing()');
    }

    // Submit the form when the Save button is clicked
    document.getElementById('saveButton').addEventListener('click', function() {
        document.getElementById('profileForm').submit();
    });
</script>

<!-- <div class="container-fluid pt-5">
    <div class="text-center py-2">
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
                        <form method="POST" action="{{ route('admin.update.profile') }}">
                            @csrf
                            <div class="row mb-2">
                                <div class="col-lg-6">
                                    <label for="first_name" class="form-label">First Name</label>
                                    <input name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name', $userProfile->first_name) }}" type="text" id="first_name">
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

                            <div class="mb-4 text-center">
                                <button type="submit" class="btn btn-success btn-rounded w-100 mb-3">Save</button>
                                <a href="{{ route('admin.change.password') }}" class="btn btn-primary w-100 mb-3">Change Password</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> -->
<style>
    .form-control {
        border-color: #5479f7;
    }

    .card {
        border: 1px solid #5479f7;
    }

    .container {
        width: 600px;
        max-width: 600px;
        background-color: white;
        border-radius: 8px;
        padding: 20px;
        box-sizing: border-box;
    }

    h2 {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 10px;
        margin-top: -20px;
        font-size: 24px;
        color: #333;
    }

    .info-icon {
        font-size: 14px;
        color: #999;
        cursor: pointer;
        border: 1px solid #999;
        border-radius: 50%;
        padding: 2px 6px;
    }

    .divider {
        border: none;
        border-top: 1px solid #ccc;
        margin: 20px 0;
    }

    .info-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .info-text {
        font-size: 16px;
    }

    .form-group {
        margin-bottom: 20px;
    }

    .form-group input {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 20px;
        font-size: 16px;
        box-sizing: border-box;
        transition: border-color 0.3s, box-shadow 0.3s;
    }

    .form-group input:focus {
        border-color: #0040FF;
        outline: none;
        box-shadow: 0 0 8px rgba(0, 64, 255, 0.2);
    }

    .button-group {
        display: flex;
        gap: 10px;
    }

    .edit-button,
    .save-button {
        padding: 10px 20px;
        border: none;
        border-radius: 20px;
        cursor: pointer;
        font-size: 14px;
        width: 120px;
    }

    .edit-button {
        background-color: #555;
        color: white;
    }

    .save-button {
        background-color: #0040FF;
        color: white;
    }

    .change-password-container {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .change-password-text {
        flex: 1;
    }

    .change-password-button {
        padding: 10px 20px;
        border: none;
        border-radius: 20px;
        background-color: #0040FF;
        color: white;
        cursor: pointer;
        font-size: 14px;
        text-decoration: none;
    }

    @media (max-width: 600px) {
        .container {
            padding: 10px;
            margin: 0 10px;
        }

        .button-group {
            flex-direction: column;
            gap: 10px;
        }

        .edit-button,
        .save-button {
            width: 100%;
            margin-bottom: 10px;
        }

        .save-button:last-child {
            margin-bottom: 0;
        }

        .change-password-container {
            flex-direction: column;
            align-items: stretch;
        }

        .change-password-button {
            margin-top: 10px;
            width: 100%;
        }
    }
</style>
@endsection