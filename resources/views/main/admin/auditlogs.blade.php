@extends('layouts.admin.adminMaster')

@section('content')
<div class="container-fluid pt-3">
    <!-- Card to wrap the table -->
    <div class="card shadow rounded-4 mt-4">
        <div class="card-header text-center">
            <h2>Audit Logs</h2>
        </div>
        <div class="card-body">
            <!-- Make the table horizontally scrollable on mobile devices -->
            <div class="table-responsive">
                <table id="auditTrailTable" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Timestamp</th>
                            <th>User</th>
                            <th>Action Type</th>
                            <th>Action Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                        <tr>
                            <td>{{ date('M d, Y', strtotime($log->logs_created)) }}</td>
                            <td class="text-uppercase">{{ $log->username }}</td>
                            <td>{{ $log->action }}</td>
                            <td class="text-start">{{ $log->description }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">No audit trail found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection