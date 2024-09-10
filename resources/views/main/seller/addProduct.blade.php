@extends('layouts.seller.sellerMaster')

@section('content')
<!-- Add products button -->
<div class="container-fluid pt-3">
    <div class="py-2">
        <h2>Add Products</h2>
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
    <div class="row">
        <div class="d-flex justify-content-between align-items-start">
            <div class="col-lg-2 pt-1">
                <form id="categoryFilterForm" action="{{ route('my.products') }}" method="GET">
                    @csrf
                    <select class="form-select form-select-sm" name="category_id" onchange="document.getElementById('categoryFilterForm').submit();">
                        <!-- <option disabled selected>Category</option> -->
                        <option value="" {{ is_null($category_id) ? 'selected' : ''}}>All</option>
                        @foreach ($categories as $data)
                        <option value="{{ $data->id }}" {{ $category_id == $data->id ? 'selected' : '' }}>{{ $data->type_name }}</option>
                        @endforeach
                    </select>
                </form>
            </div>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addProductModal">
                <div class="row">
                    <div class="col-lg-2">
                        <i class="bi bi-plus-circle"></i>
                    </div>
                    <div class="col-lg-10">
                        Add New Product
                    </div>
                </div>
            </button>
        </div>
    </div>

    <hr>
    <div class="row px-5">
        @if(!$hasProducts)
        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i> <strong>No products available yet.</strong>
            <br>
            <i class="bi bi-info-circle"></i> <strong>Unable to add products yet. Please set your categories first.</strong> <a href="{{ route('add.category') }}">Add Categories here.</a>
        </div>
        @endif

        @if($hasProducts)
        @foreach($products as $displayProduct)
        <!--PRODUCT CARD PART--->
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="product-card h-100 position-relative border shadow-sm">
                @if(!$displayProduct->is_deleted)
                <div class="badge bg-success position-absolute">
                    {{ $displayProduct->status }}
                </div>
                @else
                <div class="badge bg-danger position-absolute">
                    {{ $displayProduct->status }}
                </div>
                @endif

                <div class="edit position-absolute">
                    <button class="btn editProductBtn" data-bs-toggle="modal" data-bs-target="#editProductModal"
                        data-id="{{ $displayProduct->id }}"
                        data-name="{{ $displayProduct->product_name }}"
                        data-description="{{ $displayProduct->product_description }}"
                        data-price="{{ $displayProduct->price }}"
                        data-category="{{ $displayProduct->category_id }}"
                        data-status="{{ $displayProduct->status }}"
                        data-image="{{ asset('storage/products/' . $displayProduct->image) }}">
                        <i class="bi bi-pencil-square"></i>
                    </button>
                </div>

                @if(is_null($displayProduct->image))
                <!-- Image Container -->
                <div class="product-tumb w-100" style="height: 200px;">
                    <img src="{{ asset('images/bg/default_shop_image.png') }}" alt="{{ $displayProduct->product_name }}" class="img-fluid w-100 h-100" style="object-fit: cover;">
                </div>
                @else
                <!-- Image Container -->
                <div class="product-tumb w-100" style="height: 200px;">
                    <img src="{{ asset('storage/products/' . $displayProduct->image) }}" alt="{{ $displayProduct->product_name }}" class="img-fluid w-100 h-100" style="object-fit: cover;">
                </div>
                @endif

                <div class="product-details p-3">
                    <span class="product-catagory d-block">{{ $displayProduct->category_name }}</span>
                    <h4 class="mt-2">{{ $displayProduct->product_name }}</h4>
                    <p>{{ $displayProduct->product_description }}</p>
                    <div class="product-bottom-details d-flex justify-content-between align-items-center">
                        <div class="product-price">₱{{ $displayProduct->price }}</div>
                        <div class="product-links">
                            <a href="javascript:void(0);" class="toggle-favorite"><i class="fa fa-heart"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @endif

    </div>
</div>

<!-- Modal for editing the product -->
<div class="modal fade" id="editProductModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5">Edit Product</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload();"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('edit.products', ) }}" id="editProductForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- method('PUT') -->
                    <input type="hidden" name="id" id="editProductId">

                    <!-- Image part in the edit product modal -->
                    <div class="mb-3 upload-box position-relative" style="width: 100%; height: 200px; border: 2px dashed #ccc; border-radius: 10px; text-align: center; cursor: pointer;">
                        <!-- Hidden file input -->
                        <input type="file" name="image" id="editImageUpload" accept="image/*" onchange="previewEditImage()"
                            class="form-control position-absolute top-0 start-0 w-100 h-100 opacity-0 z-index-2"
                            style="cursor: pointer;">

                        <!-- Upload label -->
                        <label for="editImageUpload" class="upload-label position-absolute top-50 start-50 translate-middle text-muted" style="z-index: 1;">Click to Upload Image</label>

                        <!-- Image preview -->
                        <img id="editImagePreview" class="position-absolute top-0 start-0 w-100 h-100 object-fit-cover" style="display: none; z-index: 0;">
                    </div>

                    <!-- Product info -->
                    <div class="mb-3">
                        <input type="text" name="product_name" id="editProductName" class="mb-3 form-control">
                        <textarea name="description" id="editDescription" class="form-control" rows="3"></textarea>
                    </div>

                    <!-- Product details -->
                    <div class="d-flex mb-2">
                        <div class="me-1">
                            <input type="number" name="price" id="editPrice" class="form-control">
                        </div>

                        <div class="w-100">
                            <select name="category_id" id="editCategoryId" class="form-control">
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->type_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="py-2 form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="editStatus" name="status">
                        <label class="form-check-label" for="editStatus">Available</label>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="location.reload();">Cancel</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade @if($errors->any()) show @endif" id="addProductModal" tabindex="-1" @if($errors->any()) style="display:block;" @endif>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add New Product</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" onclick="location.reload();"></button>
            </div>

            <div class="modal-body">
                <form action="{{ route('add.products') }}" id="productForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <!-- Image Upload -->
                    <div class="mb-3 upload-box" style="position: relative; width: 100%; height: 200px; border: 2px dashed #ccc; border-radius: 10px; text-align: center; cursor: pointer; overflow: hidden;">
                        <input class="form-control @error('image') is-invalid @enderror" type="file" name="image" id="image-upload" accept="image/*" onchange="previewImage()" style="opacity: 0; width: 100%; height: 100%; position: absolute; top: 0; left: 0; cursor: pointer; z-index: 2;">
                        <label for="image-upload" class="upload-label" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); color: #aaa; font-size: 18px; pointer-events: none; z-index: 1;">Click to Upload Image</label>
                        <img id="image-preview" style="display: none; width: 100%; height: 100%; object-fit: cover; position: absolute; top: 0; left: 0; z-index: 1;">
                        @error('image')
                        <p class="invalid-feedback">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Product Info -->
                    <div class="mb-3">
                        <input type="text" name="product_name" class="mb-3 form-control @error('product_name') is-invalid @enderror" placeholder="Product Name" value="{{ old('product_name') }}">
                        @error('product_name')
                        <p class="invalid-feedback">{{ $message }}</p>
                        @enderror

                        <textarea name="description" class="form-control @error('description') is-invalid @enderror" id="exampleFormControlTextarea1" rows="3" placeholder="Description">{{ old('description') }}</textarea>
                        @error('description')
                        <p class="invalid-feedback">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Product Details -->
                    <div class="d-flex mb-3">
                        <div class="me-1">
                            <input type="number" name="price" class="form-control @error('price') is-invalid @enderror" placeholder="Price" value="{{ old('price') }}">
                            @error('price')
                            <p class="invalid-feedback">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="w-100">
                            <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror">
                                <option value="" selected disabled>Select a category</option>
                                @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->type_name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                            <small class="invalid-feedback">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="location.reload();">Cancel</button>
                        <button type="submit" class="btn" style="background-color: #020659; color: white;">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    function previewImage() {
        const input = document.getElementById('image-upload');
        const preview = document.getElementById('image-preview');
        const label = document.querySelector('.upload-label');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
                label.style.display = 'none';
            }

            reader.readAsDataURL(input.files[0]);
        } else {
            @if(!empty($displayProduct))
            preview.src = "{{ asset('storage/products/' . $displayProduct->image) }}";
            label.style.display = 'none';
            @endif
        }
    }

    // Handle edit button click and populate modal
    document.querySelectorAll('.editProductBtn').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-id');
            document.getElementById('editProductId').value = productId;

            const productName = this.getAttribute('data-name');
            const productDescription = this.getAttribute('data-description');
            const productPrice = this.getAttribute('data-price');
            const productCategory = this.getAttribute('data-category');
            const productStatus = this.getAttribute('data-status');
            const productImage = this.getAttribute('data-image');

            document.getElementById('editProductName').value = productName;
            document.getElementById('editDescription').value = productDescription;
            document.getElementById('editPrice').value = productPrice;
            document.getElementById('editCategoryId').value = productCategory;
            document.getElementById('editStatus').checked = productStatus === 'Available';

            // Populate the image preview with the current product image
            const preview = document.getElementById('editImagePreview');
            preview.src = productImage;
            preview.style.display = 'block';

            // Clear the file input to allow new image selection
            const input = document.getElementById('editImageUpload');
            input.value = '';
        });
    });

    // Image preview for edit modal
    function previewEditImage() {
        const input = document.getElementById('editImageUpload');
        const preview = document.getElementById('editImagePreview');
        const label = document.querySelector('.upload-label');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';

                label.style.display = 'none';
            };

            reader.readAsDataURL(input.files[0]);
        }
    }

    // Clear the image preview when the edit product modal is closed
    document.getElementById('editProductModal').addEventListener('hidden.bs.modal', function() {
        const preview = document.getElementById('editImagePreview');
        const label = document.querySelector('.upload-label');
        const input = document.getElementById('editImageUpload');

        input.value = '';
        preview.style.display = 'none';
        label.style.display = 'block';
    });
</script>

@endsection