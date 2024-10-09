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
        <table class="table table-hover table-bordered">
            <thead>
                <tr class="text-center">
                    <th scope="col">Shop Name</th>
                    <th scope="col">Date Submitted</th>
                    <th scope="col">Details</th>
                </tr>
            </thead>
            <tbody class="borderless">
                @forelse($shopApplication as $applicationData => $application)
                <tr class="text-center align-middle">
                    <td>{{ $application->first()->shop_name }}</td>
                    <td>{{ $application->first()->date_submitted }}</td>
                    <td>
                        <!-- Button to toggle details view -->
                        <button type="button" class="btn btn-primary py-1 w-100 rounded-pill" onclick="toggleDetails({{ $application->first()->id }})">
                            View Details
                        </button>
                    </td>
                </tr>

                <!-- Hidden row for the detailed info -->
                <tr id="details-{{ $application->first()->id }}" class="details-row shadow-sm" style="display:none;">
                    <td colspan="3" class="p-0">
                        <div class="container p-3">
                            <!-- Table for Status, Feedback, Date Updated -->
                            <table class="table details-table w-100 text-center">
                                <thead>
                                    <tr class="text-center">
                                        <th>Status</th>
                                        <th>Rejected Files</th>
                                        <th>Feedback</th>
                                        <th>Date Updated</th>
                                        <th>Documents</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($application as $applicationData)
                                    <tr>
                                        <td class="{{ $applicationData->application_status == 'Approved' ? 'text-success' : ($applicationData->application_status == 'Rejected' ? 'text-danger' : '') }} fw-bold">
                                            {{ $applicationData->application_status }}
                                        </td>
                                        <td>{{ $applicationData->rejected_files }}</td>
                                        <td>{{ $applicationData->feedback }}</td>
                                        <td>{{ $applicationData->date_updated }}</td>
                                        <td>
                                            <!-- Button to trigger the modal -->
                                            <button type="button" class="btn btn-primary py-1 w-100 rounded-pill" data-bs-toggle="modal" data-bs-target="#documentsModal-{{ $applicationData->id }}">
                                                View Documents
                                            </button>
                                        </td>
                                    </tr>



                                    <!-- Modal for displaying documents -->
                                    <div class="modal fade" id="documentsModal-{{ $applicationData->id }}" tabindex="-1" aria-labelledby="documentsModalLabel-{{ $applicationData->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-xl">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="documentsModalLabel-{{ $applicationData->id }}">Documents for {{ $applicationData->shop_name }}</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="row text-center g-3"> <!-- Added gutter spacing here -->
                                                        <!-- Mayor's Permit -->
                                                        <div class="col">
                                                            <strong>Mayor's Permit</strong>
                                                            <a href="{{ asset('storage/permits/' . $applicationData->mayors) }}" target="_blank">
                                                                <embed src="{{ asset('storage/permits/' . $applicationData->mayors) }}" width="100%" height="400px" style="object-fit: contain;" />
                                                            </a>
                                                            <a href="{{ asset('storage/permits/' . $applicationData->mayors) }}" download class="btn btn-link">Download</a>
                                                        </div>

                                                        <!-- BIR -->
                                                        <div class="col">
                                                            <strong>BIR</strong>
                                                            <a href="{{ asset('storage/permits/' . $applicationData->bir) }}" target="_blank">
                                                                <embed src="{{ asset('storage/permits/' . $applicationData->bir) }}" width="100%" height="400px" style="object-fit: contain;" />
                                                            </a>
                                                            <a href="{{ asset('storage/permits/' . $applicationData->bir) }}" download class="btn btn-link">Download</a>
                                                        </div>

                                                        <!-- DTI -->
                                                        <div class="col">
                                                            <strong>DTI</strong>
                                                            <a href="{{ asset('storage/permits/' . $applicationData->dti) }}" target="_blank">
                                                                <embed src="{{ asset('storage/permits/' . $applicationData->dti) }}" width="100%" height="400px" style="object-fit: contain;" />
                                                            </a>
                                                            <a href="{{ asset('storage/permits/' . $applicationData->dti) }}" download class="btn btn-link">Download</a>
                                                        </div>

                                                        <!-- AdU Contract -->
                                                        <div class="col">
                                                            <strong>AdU Contract</strong>
                                                            <a href="{{ asset('storage/permits/' . $applicationData->contract) }}" target="_blank">
                                                                <embed src="{{ asset('storage/permits/' . $applicationData->contract) }}" width="100%" height="400px" style="object-fit: contain;" />
                                                            </a>
                                                            <a href="{{ asset('storage/permits/' . $applicationData->contract) }}" download class="btn btn-link">Download</a>
                                                        </div>

                                                        <!-- Sanitary Permit -->
                                                        <div class="col">
                                                            <strong>Sanitary Permit</strong>
                                                            <a href="{{ asset('storage/permits/' . $applicationData->sanitary) }}" target="_blank">
                                                                <embed src="{{ asset('storage/permits/' . $applicationData->sanitary) }}" width="100%" height="400px" style="object-fit: contain;" />
                                                            </a>
                                                            <a href="{{ asset('storage/permits/' . $applicationData->sanitary) }}" download class="btn btn-link">Download</a>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </td>
                </tr>

                @empty
                <tr class="text-center">
                    <td colspan="3">No Applications Found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>

<script>
    function toggleDetails(id) {
        var row = document.getElementById('details-' + id);
        if (row.style.display === "none" || row.style.display === "") {
            row.style.display = "table-row"; // Show the row with details
        } else {
            row.style.display = "none"; // Hide the row
        }
    }
</script>
@endsection