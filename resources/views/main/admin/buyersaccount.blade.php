@extends('layouts.admin.adminMaster')

@section('content')
<div class="container-fluid pt-3">
    <div class="py-2">
        <h2>Buyer Accounts</h2>
    </div>
    <table id="buyerTable" class="table table-hover">
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

<!-- jQuery -->
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

<!-- Bootstrap JS -->
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script> -->

<!-- DataTables JS -->
<!-- <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script> -->

<script>
    $(document).ready(function() {
        $('#buyerTable').DataTable({
            "pageLength": 10,
            "order": [
                [3, "desc"]
            ] // Sort by 'Registered At' column
        });
    });
</script>
@endsection