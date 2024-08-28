@extends('layouts.admin.adminMaster')

@section('title')
Concessionaires Shop
@endsection

@section('contentNav')
<h3>Concessionaires Shop</h3>
@endsection

@section('content')
<div class="container" style="background-color: #D4DFE8;">
    <!-- Main content -->
    <div class="container-fluid py-4 col-lg-5">
        <!-- Add your content here -->
        <form class="d-flex" role="search">
            <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
            <button class="btn btn-outline-success" type="submit">Search</button>
        </form>
    </div>

    <div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Shop Name</th>
                    <th scope="col">Username</th>
                    <th scope="col">Contact Number</th>
                    <th scope="col">Email</th>
                    <th scope="col">Status</th>
                    <th scope="col">Date Created</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($displayShops as $shopData)
                <tr>
                    <td>{{$shopData->shop_name}}</td>
                    <td>{{$shopData->username}}</td>
                    <td>{{$shopData->contact_num}}</td>
                    <td>{{$shopData->email}}</td>
                    <td>{{$shopData->type_name}}</td>
                    <td>{{$shopData->date_created}}</td>
                    <td>
                        <button>Action</button>
                    </td>
                </tr>
                @endforeach
            </tbody>

        </table>
    </div>
</div>

@endsection