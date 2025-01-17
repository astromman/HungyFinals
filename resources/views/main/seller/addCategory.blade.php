@extends('layouts.seller.sellerMaster')

@section('content')
<div class="container-fluid pt-3">
    <div class="py-2">
        <h2>Custom Categories</h2>
    </div>
    <div class="row justify-content-center">
        <!-- Categories Form Card -->
        <div class="col-lg-4">
            <div class="card shadow-lg rounded-4 mb-4">
                <div class="pt-3 text-center">
                    <h3>Enter Category</h3>
                </div>

                <div class="pt-4 d-flex justify-content-center align-items-center">
                    <div class="col-lg-9">
                        @if(empty($categoryId))
                        <form method="POST" action="{{ route('add.category') }}">
                            @csrf
                            <div class="mb-3">
                                <label for="type_name" class="form-label">Category Name</label>
                                <input
                                    name="type_name"
                                    class="form-control @error('type_name') is-invalid @enderror"
                                    value="{{ old('type_name') }}"
                                    type="text"
                                    id="type_name"
                                    {{ $shopDetails->is_reopen ? 'disabled' : '' }}>
                                @error('type_name')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Submit button -->
                            <div class="mb-2 row text-center">
                                <div class="col-lg-12">
                                    <button type="submit" class="btn btn-primary btn-rounded mb-3 w-100" {{ $shopDetails->is_reopen ? 'disabled' : '' }}>Add</button>
                                </div>
                            </div>

                        </form>

                        @elseif($categoryId)
                        <form method="POST" action="{{ route('edit.category', $categoryId) }}">
                            @csrf
                            <div class="mb-3">
                                <label for="type_name" class="form-label">Category Name</label>
                                <input
                                    name="type_name"
                                    class="form-control @error('type_name') is-invalid @enderror"
                                    value="{{ $categoryId->type_name }}"
                                    type="text"
                                    id="type_name"
                                    {{ $shopDetails->is_reopen ? 'disabled' : '' }}>
                                @error('type_name')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Submit button -->
                            <div class="mb-4 row text-center">
                                <div class="col-lg-6">
                                    <button type="submit" class="btn btn-success btn-rounded mb-3 w-100" {{ $shopDetails->is_reopen ? 'disabled' : '' }}>Save</button>
                                </div>
                                <div class="col-lg-6">
                                    <a href="{{ route('product.categories') }}" class="btn btn-secondary btn-rounded mb-3 w-100">Cancel</a>
                                </div>
                            </div>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Categories Table -->
        <div class="col-lg-8">
            <div class="card shadow-lg rounded-4">
                <div class="pt-3 text-center">
                    <h3>My Categories</h3>
                </div>
                <div class="card-body">
                    <div class="table">
                        <table class="table table-hover">
                            <thead>
                                <tr class="text-center">
                                    <th>Name</th>
                                    <!-- <th>Date Created</th>
                                    <th>Date Updated</th> -->
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="borderless">
                                @forelse ($categories as $category)
                                <tr class="text-center">
                                    <td>{{ $category->type_name }}</td>
                                    <!-- <td>{{ $category->created_at }}</td>
                                    <td>{{ $category->updated_at }}</td> -->
                                    <td class="">
                                        <div class="d-flex justify-content-center align-items-center">
                                            <div class="col-6">
                                                <a
                                                    href="{{ route('edit.button.category', $category->id) }}"
                                                    class="btn btn-sm w-100 {{ $shopDetails->is_reopen ? 'disabled-link' : '' }}"
                                                    title="Edit"
                                                    onclick="{{ $shopDetails->is_reopen ? 'return false;' : '' }}">
                                                    <i class="bi bi-pencil-fill"></i>
                                                </a>
                                            </div>
                                            <div class="col-6">
                                                <form action="{{ route('delete.category', $category->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button
                                                        type="submit"
                                                        class="btn btn-sm w-100 border-0"
                                                        title="Delete"
                                                        onclick="return confirm('Are you sure you want to delete this category?')"
                                                        {{ $shopDetails->is_reopen ? 'disabled' : '' }}>
                                                        <i class="bi bi-trash-fill"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr class="text-center">
                                    <td colspan="4">No categories found.</td>
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

@if(session('categoryAdded'))
<script>
    Swal.fire({
        position: "center",
        icon: "success",
        title: "{{ session('categoryAdded') }}",
        showConfirmButton: false,
        timer: 1500
    });
</script>
@endif

@if(session('categoryDeleted'))
<script>
    Swal.fire({
        position: "center",
        icon: "success",
        title: "{{ session('categoryDeleted') }}",
        showConfirmButton: false,
        timer: 1500
    });
</script>
@endif

@if(session('error'))
<script>
    Swal.fire({
        icon: "error",
        title: "Oops...",
        text: "{{ session('error') }}",
    });
</script>
@endif
@endsection