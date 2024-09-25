@extends('layouts.manager.managerMaster')

@section('content')
<div class="container-fluid pt-3">
    <div class="py-2 px-5">
        <h2>Audit Logs</h2>
    </div>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>User</th>
                <th>Action</th>
                <th>Date</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            <!-- Example data, you would dynamically populate this -->
            <tr>
                <td>Yoreeeee</td>
                <td>Login</td>
                <td>2023-08-01 12:34:56</td>
                <td>User logged in from IP 192.168.1.1</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection