@extends('layouts.manager.managerMaster')

@section('content')
<div class="container-fluid px-5 pt-3">
    <div class="py-2 px-5">
        <h2>Applications History</h2>
    </div>
    @if (session('error'))
    <div class="alert alert-danger" role="alert">
        {{ session('error') }}
    </div>
    @endif
    <div>
        <table class="table table-hover">
            <thead>
                <tr class="text-center">
                    <th scope="col">Shop Name</th>
                    <th scope="col">Status</th>
                    <th scope="col">Feedback</th>
                    <th scope="col">Date Submitted</th>
                    <th scope="col">Date Updated</th>
                    <th scope="col">Documents</th>
                </tr>
            </thead>
            <tbody class="borderless">
                @forelse($application as $applicationData)
                <tr class="text-center">
                    <td>{{ $applicationData->shop_name }}</td>
                    <td>{{ $applicationData->application_status }}</td>
                    <td>{{ $applicationData->feedback }}</td>
                    <td>{{ $applicationData->date_submitted }}</td>
                    <td>{{ $applicationData->date_updated }}</td>
                    <td>
                        <button type="button" class="btn btn-primary py-1 w-100 rounded-pill" onclick="toggleDocuments({{ $applicationData->id }})">
                            View
                        </button>
                    </td>
                </tr>
                <tr id="documents-{{ $applicationData->id }}" class="documents-row" style="display:none;">
                    <td colspan="6">
                        <div class="row">
                            <div class="col-lg-3 px-2 text-center">
                                Mayor's Permit
                                <a href="{{ asset('storage/permits/'. $applicationData->mayors) }}" target="_blank">
                                    <embed src="{{ asset('storage/permits/'. $applicationData->mayors) }}" width="100%" height="400px" style="object-fit: contain;" />
                                </a>
                                <a href="{{ asset('storage/permits/'. $applicationData->mayors) }}" download class="btn btn-link">Download</a>
                            </div>
                            <div class="col-lg-3 px-2 text-center">
                                BIR
                                <a href="{{ asset('storage/permits/'. $applicationData->bir) }}" target="_blank">
                                    <embed src="{{ asset('storage/permits/'. $applicationData->bir) }}" width="100%" height="400px" style="object-fit: contain;" />
                                </a>
                                <a href="{{ asset('storage/permits/'. $applicationData->bir) }}" download class="btn btn-link">Download</a>
                            </div>
                            <div class="col-lg-3 px-2 text-center">
                                DTI
                                <a href="{{ asset('storage/permits/'. $applicationData->dti) }}" target="_blank">
                                    <embed src="{{ asset('storage/permits/'. $applicationData->dti) }}" width="100%" height="400px" style="object-fit: contain;" />
                                </a>
                                <a href="{{ asset('storage/permits/'. $applicationData->dti) }}" download class="btn btn-link">Download</a>
                            </div>
                            <div class="col-lg-3 px-2 text-center">
                                AdU Contract
                                <a href="{{ asset('storage/permits/'. $applicationData->contract) }}" target="_blank">
                                    <embed src="{{ asset('storage/permits/'. $applicationData->contract) }}" width="100%" height="400px" style="object-fit: contain;" />
                                </a>
                                <a href="{{ asset('storage/permits/'. $applicationData->contract) }}" download class="btn btn-link">Download</a>
                            </div>
                        </div>
                    </td>
                </tr>
                @empty
                <tr class="text-center">
                    <td colspan="6">No Applications Found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<script>
    function toggleDocuments(id) {
        var rows = document.querySelectorAll('.documents-row');
        rows.forEach(function(row) {
            if (row.id === 'documents-' + id) {
                if (row.style.display === "none") {
                    row.style.display = "table-row";
                    setTimeout(() => {
                        row.style.width = "100%";
                        row.style.marginLeft = "0";
                    }); // Delay to ensure the element is considered "displayed" before transitioning
                } else {
                    row.style.width = "0";
                    row.style.marginLeft = "100%";
                    setTimeout(() => row.style.display = "none");
                }
            } else {
                row.style.width = "0";
                row.style.marginLeft = "100%";
                setTimeout(() => row.style.display = "none");
            }
        });
    }
</script>
@endsection