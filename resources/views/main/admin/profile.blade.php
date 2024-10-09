@extends('layouts.admin.adminMaster')

@section('content')
<div class="container pt-5">
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
                <button type="button" class="edit-button" id="editButton" onclick="enableEditing()">Edit</button>
                <button type="button" class="save-button" id="saveButton" onclick="submitForm()" style="display:none;">Save</button>
                <button type="button" class="cancel-button" id="cancelButton" onclick="disableEditing()" style="display:none;">Cancel</button>
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
        </div>
    </div>
</div>

<script>
    function enableEditing() {
        // Enable all input fields
        var inputs = document.querySelectorAll('#profileForm input');
        inputs.forEach(function(input) {
            input.disabled = false;
        });

        // Change Edit button to Save and Cancel
        document.getElementById('editButton').style.display = 'none';
        document.getElementById('saveButton').style.display = 'inline-block';
        document.getElementById('cancelButton').style.display = 'inline-block';
    }

    function disableEditing() {
        // Disable all input fields
        var inputs = document.querySelectorAll('#profileForm input');
        inputs.forEach(function(input) {
            input.disabled = true;
        });

        // Revert buttons to only show Edit
        document.getElementById('editButton').style.display = 'inline-block';
        document.getElementById('saveButton').style.display = 'none';
        document.getElementById('cancelButton').style.display = 'none';
    }

    // Submit the form when the Save button is clicked
    function submitForm() {
        document.getElementById('profileForm').submit();
    }
</script>

<style>
    .form-control {
        border-color: #5479f7;
    }

    .card {
        border: 1px solid #5479f7;
    }

    /* .container {
        width: 600px;
        max-width: 600px;
        background-color: white;
        border-radius: 8px;
        padding: 20px;
        box-sizing: border-box;
    } */

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
    .save-button,
    .cancel-button {
        padding: 10px 20px;
        border: none;
        border-radius: 20px;
        cursor: pointer;
        font-size: 14px;
        width: 120px;
    }

    .cancel-button {
        background-color: #555;
        color: white;
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