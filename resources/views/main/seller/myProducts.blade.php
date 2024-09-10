@extends('layouts.seller.sellerMaster')

@section('content')
<div class="container-fluid pt-3"> <!-- Adding margin-top to create separation -->
    <div class="py-2">
        <h2>My Products</h2>
    </div>
    @if (session('success'))
    <div class="alert alert-primary" role="alert" onclick="location.reload();">
        {{ session('success') }}
    </div>
    @endif

    @if (session('error'))
    <div class="alert alert-danger" role="alert" onclick="location.reload();">
        {{ session('error') }}
    </div>
    @endif
    <table class="table table-hover">
        <thead>
            <tr>
                <th scope="col">Product name</th>
                <th scope="col">Description</th>
                <th class="text-center" scope="col">Sold</th>
                <th class="text-center" scope="col">Price</th>
                <th class="text-center" scope="col">Status</th>
                <th class="text-center" scope="col">Action</th>
            </tr>
        </thead>
        <tbody class="borderless">
            @forelse($products as $displayMyProduct)
            <tr class="text-justify">
                <td>{{ $displayMyProduct->product_name }}</td>
                <td>{{ $displayMyProduct->product_description }}</td>
                <td class="text-center">{{ $displayMyProduct->sold }}</td>
                <td class="text-center">{{ '₱ ' . $displayMyProduct->price }}</td>
                <td class="text-center">{{ $displayMyProduct->status }}</td>
                <td class="text-center">
                    <form action="{{ route('delete.products', $displayMyProduct->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-side py-1 w-100 rounded-pill" title="Delete" onclick="return confirm('Are you sure you want to delete this canteen?')">
                            <i class="bi bi-trash-fill" style="color: #050144;"></i>
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">No products yet.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection