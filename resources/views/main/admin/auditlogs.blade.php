@extends('layouts.admin.adminMaster')

@section('content')
<div class="py-4">
    <h2 class="mb-4">Audit Trail</h2>
    <div class="table-responsive">
        <table id="auditTrailTable" class="table table-bordered table-striped table-hover">
            <thead>
                <tr>
                    <th>Timestamp</th>
                    <th>User</th>
                    <th>Action Type</th>
                    <th class="hidden-xs">Action Details</th>
                    <th>Flag</th>
                    <!-- <th class="hidden-xs">Before</th>
                    <th class="hidden-xs">After</th> -->
                </tr>
            </thead>
            <tbody>
                <!-- Sample Data (Should be populated from backend) -->
                @forelse($logs as $log)
                <tr>
                    <td>{{ $log->logs_created }}</td>
                    <td class="text-uppercase">{{ $log->username }}</td>
                    <td>{{ $log->action }}</td>
                    <td class="hidden-xs text-start">{{ $log->description }}</td>
                    <td>Flag</td>
                    <!-- <td class="hidden-xs">Price: 50</td>
                    <td class="hidden-xs">Price: 45</td> -->
                </tr>
                @empty
                <tr>
                    <td colspan="6">No audit trail found.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection