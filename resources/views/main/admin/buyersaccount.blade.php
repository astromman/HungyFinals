@extends('layouts.admin.adminMaster')

@section('content')
<div class="container-fluid pt-5">
    <div class="row justify-content-center">
        <div class="col-lg-12">
            <!-- Box/Card Wrapper -->
            <div class="card shadow-lg rounded-4">
                <div class="card-header text-center">
                    <h3>Buyer Accounts</h3>
                </div>
                <div class="card-body">
                    <!-- Make the table horizontally scrollable on smaller screens -->
                    <div class="table-responsive">
                        <table id="buyerTable" class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Contact Number</th>
                                    <th>Registered At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($user as $data)
                                <tr>
                                    <td>{{ $data->first_name . ' ' . $data->last_name }}</td>
                                    <td>{{ $data->email }}</td>
                                    <td>{{ $data->contact_num }}</td>
                                    <td>{{ date('M d, Y', strtotime($data->created_at )) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">No data available in table</td>
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