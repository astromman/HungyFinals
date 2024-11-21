@extends('layouts.manager.managerMaster')

@section('content')
<div class="container-fluid pt-3">
    <div class="py-2">
        <h2>Create Concessionaire's Accounts</h2>
    </div>
    @if (session('error'))
    <div class="alert alert-danger" role="alert">
        {{ session('error') }}
    </div>
    @endif
    <div class="row pt-3 justify-content-center">
        <!-- Manager Form Card -->
        <div class="col-lg-3">
            <div class="card shadow rounded-4 mb-4">
                <div class="pt-3 text-center">
                    <h3>Enter Credentials</h3>
                </div>

                <div class="pt-4 d-flex justify-content-center align-items-center">
                    <div class="col-lg-10">
                        @if (session('success'))
                        <div class="alert alert-info" role="alert">
                            <strong>{{ session('success') }}</strong>
                        </div>
                        @endif
                        
                        @if(empty($userData))
                        <form method="POST" action="{{ route('post.concessionaires.account') }}">
                            @csrf

                            <!-- Username -->
                            <div class="mb-2">
                                <label for="username" class="form-label">Email</label>
                                <input name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" type="text" id="username">
                                @error('username')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Submit button -->
                            <div class="mb-3 text-center">
                                <button type="submit" class="btn btn-primary btn-rounded w-50 mb-3">Add</button>
                            </div>
                        </form>
                        @elseif($userData)
                        <form method="POST" action="{{ route('edit.cons.account', $userData->id) }}">
                            @csrf
                            <!-- Current Password Display -->
                            <div class="pb-3 mb-2">
                                <label for="current_password" class="form-label">Current Generated Password</label>
                                <input name="current_password" class="form-control" type="text" id="current_password" value="{{ $userData->default_pass }}" readonly>
                            </div>

                            <!-- Regenerate Password -->
                            <div class="pb-3 mb-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="regenerate_password" name="regenerate_password">
                                    <label class="form-check-label" for="regenerate_password">
                                        Regenerate Password
                                    </label>
                                </div>
                            </div>

                            <!-- Submit button -->
                            <div class="mb-4 row text-center">
                                <div class="col-lg-6">
                                    <button type="submit" class="btn btn-success btn-rounded mb-3 w-100">Save</button>
                                </div>
                                <div class="col-lg-6">
                                    <a href="{{ route('concessionaires.account') }}" class="btn btn-secondary btn-rounded mb-3 w-100">Cancel</a>
                                </div>
                            </div>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Managers Table -->
        <div class="col-lg-9">
            <div class="card shadow rounded-4">
                <div class="pt-3 text-center">
                    <h3>Concessionaires List</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead>
                                <tr class="text-center">
                                    <th class="text-start" scope="col">Email / Username</th>
                                    <th class="text-center" scope="col">Account Status</th>
                                    <th class="text-start" scope="col">Shop Name</th>
                                    <th scope="col">Shop Status</th>
                                    <th scope="col">Canteen</th>
                                    <th scope="col">Date Created</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($user as $concessionaire)
                                <tr class="text-center">
                                    <td class="text-start">{{ $concessionaire->shop_email }}</td>
                                    <td class="text-center">{{ $concessionaire->is_active ? 'Not Active' : 'Active' }}</td>
                                    <td class="text-start">{{ $concessionaire->shop_name }}</td>
                                    <td>{{ $concessionaire->status }}</td>
                                    <td>{{ $concessionaire->building_name }}</td>
                                    <td>{{ $concessionaire->created_at->format('M d Y, h:i A') }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ route('edit.button.cons.account', ['userId' => Crypt::encrypt($concessionaire->user_id)]) }}" class="btn btn-sm btn-warning me-2" title="Edit">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                            <form action="{{ route('delete.concessionaires.account', $concessionaire->id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this account?')">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="text-center">No records available.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

@endsection