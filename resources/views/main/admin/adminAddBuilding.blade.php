@extends('layouts.admin.adminMaster')

@section('content')
<div class="container-fluid pt-3">
    <div class="py-2 px-5">
        <h2>Add New Category</h2>
    </div>
    @if (session('error'))
    <div class="alert alert-danger" role="alert">
        {{ session('error') }}
    </div>
    @endif
    <div class="row pt-3 justify-content-center">
        <!-- Building Form Card -->
        <div class="col-lg-4">
            <div class="card shadow-lg rounded-4 mb-4">
                <div class="pt-3 text-center">
                    <h3>Enter Canteen Details</h3>
                </div>

                <div class="pt-4 d-flex justify-content-center align-items-center">
                    <div class="col-lg-9">
                        @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                        @endif

                        @if(empty($buildingData))
                        <form method="POST" action="{{ route('post.manage.building') }}" enctype="multipart/form-data">
                            @csrf
                            <!-- Building Name -->
                            <div class="mb-2">
                                <label for="building_name" class="form-label">Canteen Name</label>
                                <input name="building_name" class="form-control @error('building_name') is-invalid @enderror" value="{{ old('building_name') }}" type="text" id="building_name">
                                @error('building_name')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Building Image -->
                            <div class="mb-2">
                                <label for="images" class="form-label">Canteen Image</label>
                                <input name="building_image" type="file" class="form-control @error('building_image') is-invalid @enderror" value="{{ old('building_image') }}" id="inputGroupFile02">
                                @error('building_image')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Building Description -->
                            <div class="pb-3 mb-2">
                                <label for="building_description" class="form-label">Description</label>
                                <textarea name="building_description" class="form-control @error('building_description') is-invalid @enderror" placeholder="Whereabouts of this canteen." id="building_description" rows="4">{{ old('building_description') }}</textarea>
                                @error('building_description')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Submit button -->
                            <div class="mb-4 row text-center">
                                <div class="col-lg-12">
                                    <button type="submit" class="btn btn-primary btn-rounded mb-3 w-100">Add</button>
                                </div>
                            </div>
                        </form>
                        @elseif($buildingData)
                        <form method="POST" action="{{ route('edit.building', ['id' => $buildingData->id, 'building_name' => Str::slug($buildingData->building_name)]) }}" enctype="multipart/form-data">
                            @csrf
                            <!-- Building Name -->
                            <div class="mb-2">
                                <label for="building_name" class="form-label">Canteen Name</label>
                                <input name="building_name" class="form-control @error('building_name') is-invalid @enderror" value="{{ $buildingData->building_name }}" type="text" id="building_name">
                                @error('building_name')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Building Image -->
                            <div class="mb-2">
                                <label for="images" class="form-label">Canteen Image</label>
                                <input name="building_image" type="file" class="form-control @error('building_image') is-invalid @enderror" value="{{ $buildingData->building_image }}" id="inputGroupFile02">
                                @error('building_image')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Building Description -->
                            <div class="pb-3 mb-2">
                                <label for="building_description" class="form-label">Description</label>
                                <textarea name="building_description" class="form-control @error('building_description') is-invalid @enderror" placeholder="Whereabouts of this canteen." id="building_description" rows="4">{{ $buildingData->building_description }}</textarea>
                                @error('building_description')
                                <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Submit button -->
                            <div class="mb-4 row text-center">
                                <div class="col-lg-6">
                                    <button type="submit" class="btn btn-success btn-rounded mb-3 w-100">Save</button>
                                </div>
                                <div class="col-lg-6">
                                    <a href="{{ route('manage.building') }}" class="btn btn-secondary btn-rounded mb-3 w-100">Cancel</a>
                                </div>
                            </div>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Buildings Table -->
        <div class="col-lg-8">
            <div class="card shadow rounded-4">
                <div class="pt-3 text-center">
                    <h3>Canteen List</h3>
                </div>
                <div class="card-body">
                    <div class="table">
                        <table class="table table-hover">
                            <thead>
                                <tr class="text-center">
                                    <th>Name</th>
                                    <th>Image</th>
                                    <th>Description</th>
                                    <th>Date Created</th>
                                    <th>Date Updated</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody class="borderless">
                                @foreach ($buildings as $building)
                                <tr class="text-center">
                                    <td>{{ $building->building_name }}</td>
                                    <td>
                                        @if ($building->building_image == null)
                                        <img src="{{ asset('images/bg/default_shop_image.png') }}" alt="No Image" style="width: 70px; height: 70px">
                                        @else
                                        <img src="{{ asset('storage/canteen/' . $building->building_image) }}" alt="{{ $building->building_name }}" style="width: 70px; height: 70px">
                                        @endif
                                    </td>
                                    <td>{{ $building->building_description }}</td>
                                    <td>{{ $building->created_at }}</td>
                                    <td>{{ $building->updated_at }}</td>
                                    <td>
                                        <div class="row">
                                            <div class="col-lg-6 d-flex align-items-center">
                                                <a href="{{ route('edit.button.building', ['id' => $building->id, 'building_name' => Str::slug($building->building_name)]) }}" class="btn btn-sm btn-edit w-100" title="Edit">
                                                    <i class="bi bi-pencil-fill"></i>
                                                </a>
                                            </div>
                                            <div class="col-lg-6 d-flex align-items-center">
                                                <form action="{{ route('delete.building', $building->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm w-100" title="Delete" onclick="return confirm('Are you sure you want to delete this canteen?')">
                                                        <i class="bi bi-trash-fill"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection