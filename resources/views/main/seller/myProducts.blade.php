@extends('layouts.seller.sellerMaster')

@section('content')
<div class="container-fluid pt-3"> <!-- Adding margin-top to create separation -->
    <div class="py-2">
        <h2>Products Table</h2>
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
                <th scope="col">Category</th>
                <th class="text-center" scope="col">Sold</th>
                <th class="text-center" scope="col">Price</th>
                <th class="text-center" scope="col">Status</th>
                @if(!$shopDetails->is_reopen)
                <th class="text-center" scope="col">Action</th>
                @endif
            </tr>
        </thead>
        <tbody class="borderless">
            @forelse($products as $product)
            <tr class="text-justify">
                <td>
                    {{ $product->product_name }}
                </td>
                <td>
                    {{ $product->product_description }}
                </td>
                <td>
                    {{ $product->category_name }}
                </td>
                <td class="text-center">
                    {{ $product->sold }}
                </td>
                <td class="text-center">
                    {{ '₱ ' . $product->price }}
                </td>
                <td class="text-center">
                    {{ $product->status }}
                </td>
                @if(!$shopDetails->is_reopen)
                <td class="justify-content-center align-items-center">
                    <form action="{{ route('delete.products', $product->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <div class="d-flex justify-content-center align-items-center">
                            <button type="submit" class="btn btn-side rounded-pill" title="Delete" onclick="return confirm('Are you sure you want to delete this canteen?')">
                                <i class="bi bi-trash-fill" style="color: #050144;"></i>
                            </button>
                        </div>
                    </form>
                </td>
                @endif
            </tr>
            @empty
            <tr>
                <td colspan="7" class="text-center">No products yet.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection