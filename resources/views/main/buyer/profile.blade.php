@extends('layouts.buyer.buyermaster')

@section('content')
<div class="container pt-5 d-flex justify-content-center align-items-center">
    <div class="container-form pt-5">
        <h2>Welcome Klasmeyt, {{ $userProfile->username }}</h2>
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
        <form id="profileForm" method="POST" action="{{ route('buyer.update.profile') }}">
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
            <a href="{{ route('buyer.change.password') }}" class="change-password-button">Change Password</a>
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
@endsection