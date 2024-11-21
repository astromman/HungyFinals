@extends('layouts.admin.adminMaster')

@section('content')
<div class="pb-5">
    <div class="px-1">
        <h2>Create Manager's Accounts</h2>
    </div>
    @if (session('error'))
    <div class="alert alert-danger" role="alert">
        {{ session('error') }}
    </div>
    @endif
    <div class="row pt-3">
        <!-- Manager Form Card -->
        <div class="col-lg-4">
            <div class="card shadow-lg rounded-4 mb-4">
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
                        <form method="POST" action="{{ route('post.manager.account') }}">
                            @csrf
                            <!-- First and Last Name -->
                            <div class="row mb-2">
                                <div class="col-lg-6">
                                    <label for="first_name" class="form-label">First Name</label>
                                    <input name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}" type="text" id="first_name">
                                    @error('first_name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-6">
                                    <label for="last_name" class="form-label">Last Name</label>
                                    <input name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name') }}" type="text" id="last_name">
                                    @error('last_name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Username -->
                            <div class="mb-2">
                                <label for="username" class="form-label">Email / Username</label>
                                <input name="username" class="form-control @error('username') is-invalid @enderror" value="{{ old('username') }}" type="text" id="username">
                                @error('username')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Building Selection -->
                            <div class="pb-3 mb-2">
                                <label for="building_id" class="form-label">Canteen</label>
                                <select name="building_id" id="building_id" class="form-control @error('building_id') is-invalid @enderror">
                                    <option value="" selected disabled>Select a canteen</option>
                                    @foreach($buildings as $building)
                                    <option value="{{ $building->id }}">{{ $building->building_name }}</option>
                                    @endforeach
                                </select>
                                @error('building_id')
                                <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Submit button -->
                            <div class="mb-4 text-center">
                                <button type="submit" class="btn btn-primary btn-rounded w-50 mb-3">Add</button>
                            </div>
                        </form>
                        @elseif($userData)
                        <form method="POST" action="{{ route('edit.manager.account', $userData->id) }}">
                            @csrf
                            @method('PUT')
                            <!-- First and Last Name -->
                            <div class="row mb-2">
                                <div class="col-lg-6">
                                    <label for="first_name" class="form-label">First Name</label>
                                    <input name="first_name" class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name', $userData->first_name) }}" type="text" id="first_name">
                                    @error('first_name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-6">
                                    <label for="last_name" class="form-label">Last Name</label>
                                    <input name="last_name" class="form-control @error('last_name') is-invalid @enderror" value="{{ old('last_name', $userData->last_name) }}" type="text" id="last_name">
                                    @error('last_name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <!-- Building Selection -->
                            <div class="pb-3 mb-2">
                                <label for="building_id" class="form-label">Canteen</label>
                                <select name="building_id" id="building_id" class="form-control @error('building_id') is-invalid @enderror">
                                    <option value="" disabled>Select a building</option>
                                    @foreach($buildings as $building)
                                    <option value="{{ $building->id }}" {{ old('building_id', $userData->manager_building_id) == $building->id ? 'selected' : '' }}>
                                        {{ $building->building_name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('building_id')
                                <small class="invalid-feedback">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Submit button -->
                            <div class="mb-4 row text-center">
                                <div class="col-lg-6">
                                    <button type="submit" class="btn btn-success btn-rounded mb-3 w-100">Save</button>
                                </div>
                                <div class="col-lg-6">
                                    <a href="{{ route('manager.account') }}" class="btn btn-secondary btn-rounded mb-3 w-100">Cancel</a>
                                </div>
                            </div>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Managers Table -->
        <div class="col-lg-7 col-md-12">
            <div class="card shadow-lg rounded-4">
                <div class="pt-3 text-center">
                    <h3>Managers List</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr class="text-center">
                                    <th scope="col">Name</th>
                                    <th scope="col">Email / Username</th>
                                    <th scope="col">Canteen</th>
                                    <th scope="col">Date Created</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody class="borderless">
                                @forelse ($user as $manager)
                                <tr class="text-center">
                                    <td>{{ $manager->first_name . ' ' . $manager->last_name}}</td>
                                    <td>{{ $manager->username }}</td>
                                    <td>{{ $manager->building_name }}</td>
                                    <td>{{ $manager->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ route('edit.button.manager.account', $manager->user_id) }}" class="btn btn-sm me-1" title="Edit">
                                                <i class="bi bi-pencil-fill"></i>
                                            </a>
                                            <form action="{{ route('delete.manager', $manager->user_id) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm" title="Delete" onclick="return confirm('Are you sure you want to delete this manager?')">
                                                    <i class="bi bi-trash-fill"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr class="text-center">
                                    <td colspan="6">No managers found.</td>
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