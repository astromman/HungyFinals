@extends('layouts.admin.adminMaster')

@section('content')
<div class="container-fluid pt-3">
    <div class="py-2">
        <h2>Buyer Accounts</h2>
    </div>
    <table id="buyerTable" class="table table-bordered table-striped table-hover">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Contact Number</th>
                <th>Registered At</th>
                <th>Updated At</th>
            </tr>
        </thead>
        <tbody>
            @forelse($user as $data)
            <tr>
                <td>{{ $data->first_name . ' ' . $data->last_name }}</td>
                <td>{{ $data->email }}</td>
                <td>{{ $data->contact_num }}</td>
                <td>{{ $data->created_at }}</td>
                <td>{{ $data->updated_at }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5">No data available in table</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection