@extends('layouts.manager.managerMaster')

@section('content')
<div class="container-fluid px-5 pt-3">
    <div class="py-2 px-5">
        <h2>Concessionaire's Applications</h2>
    </div>
    @if (session('error'))
    <div class="alert alert-danger text-center" role="alert">
        {{ session('error') }}
    </div>
    @endif

    @if (session('success'))
    <div class="alert alert-info text-center" role="alert">
        {{ session('success') }}
    </div>
    @endif

    <div>
        <table class="table table-hover">
            <thead>
                <tr class="text-center">
                    <th scope="col">Shop Name</th>
                    <th scope="col">Status</th>
                    <th scope="col">Date Submitted</th>
                    <th scope="col">Documents</th>
                </tr>
            </thead>
            <tbody class="borderless">
                @forelse($application as $applicationData)
                <tr class="text-center">
                    <td>{{ $applicationData->shop_name }}</td>
                    <td>{{ $applicationData->application_status }}</td>
                    <td>{{ $applicationData->date_submitted }}</td>
                    <td>
                        <button type="button" class="btn btn-primary py-1 w-50 rounded-pill" onclick="toggleDocuments({{ $applicationData->id }})">
                            View
                        </button>
                    </td>
                </tr>
                <tr id="documents-{{ $applicationData->permit_id }}" class="documents-row" style="display:none;">
                    <td colspan="4">
                        <div class="row">
                            <div class="col-lg-3 px-2 text-center">
                                Mayor's Permit
                                <a href="{{ asset('storage/permits/' . $applicationData->mayors) }}" target="_blank">
                                    <embed src="{{ asset('storage/permits/' . $applicationData->mayors) }}" width="100%" height="400px" style="object-fit: contain;" />
                                </a>
                                <a href="{{ asset('storage/permits/' . $applicationData->mayors) }}" download class="btn btn-link">Download</a>
                            </div>
                            <div class="col-lg-3 px-2 text-center">
                                BIR
                                <a href="{{ asset('storage/permits/' . $applicationData->bir) }}" target="_blank">
                                    <embed src="{{ asset('storage/permits/' . $applicationData->bir) }}" width="100%" height="400px" style="object-fit: contain;" />
                                </a>
                                <a href="{{ asset('storage/permits/' . $applicationData->bir) }}" download class="btn btn-link">Download</a>
                            </div>
                            <div class="col-lg-3 px-2 text-center">
                                DTI
                                <a href="{{ asset('storage/permits/' . $applicationData->dti) }}" target="_blank">
                                    <embed src="{{ asset('storage/permits/' . $applicationData->dti) }}" width="100%" height="400px" style="object-fit: contain;" />
                                </a>
                                <a href="{{ asset('storage/permits/' . $applicationData->dti) }}" download class="btn btn-link">Download</a>
                            </div>
                            <div class="col-lg-3 px-2 text-center">
                                AdU Contract
                                <a href="{{ asset('storage/permits/' . $applicationData->contract) }}" target="_blank">
                                    <embed src="{{ asset('storage/permits/' . $applicationData->contract) }}" width="100%" height="400px" style="object-fit: contain;" />
                                </a>
                                <a href="{{ asset('storage/permits/' . $applicationData->contract) }}" download class="btn btn-link">Download</a>
                            </div>

                        </div>
                        <div class="text-center mt-3 pe-5">
                            <div class="d-flex justify-content-end align-items-end">
                                <div class='pe-1'>
                                    <button type="button" class="btn btn-danger w-100" data-bs-toggle="modal" data-bs-target="#feedbackModal" onclick="openFeedbackModal({{ $applicationData->id }})">Reject</button>
                                </div>

                                <form action="{{ route('approve.shops.application', $applicationData->permit_id) }}" method="POST" class="d-inline-block w-45">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn btn-success w-100">Approve</button>
                                </form>
                            </div>
                        </div>
                    </td>
                </tr>

                <!-- Feedback Modal -->
                <div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="feedbackModalLabel">Reject Application</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="rejectForm" action="{{ route('reject.shops.application', $applicationData->permit_id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <div class="mb-3">
                                        <label for="feedback" class="form-label">Reason for Rejection</label>
                                        <textarea class="form-control" id="feedback" name="feedback" rows="3" required></textarea>
                                    </div>

                                    <!-- Checkboxes for selecting which files need to be resubmitted -->
                                    <div class="mb-3">
                                        <p>Select the documents that need resubmission:</p>
                                        <div>
                                            <input type="checkbox" id="reject_mayors" name="rejected_files[]" value="mayor's">
                                            <label for="reject_mayors">Mayor's Permit</label>
                                        </div>
                                        <div>
                                            <input type="checkbox" id="reject_bir" name="rejected_files[]" value="bir">
                                            <label for="reject_bir">BIR</label>
                                        </div>
                                        <div>
                                            <input type="checkbox" id="reject_dti" name="rejected_files[]" value="dti">
                                            <label for="reject_dti">DTI</label>
                                        </div>
                                        <div>
                                            <input type="checkbox" id="reject_contract" name="rejected_files[]" value="AdU contract">
                                            <label for="reject_contract">AdU Contract</label>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-danger w-100">Submit</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                @empty
                <tr class="text-center">
                    <td colspan="4">No Applications Found</td>
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

    function openFeedbackModal(applicationId) {
        var rejectForm = document.getElementById('rejectForm');
        rejectForm.action = '{{ url("manager/applications/reject/") }}/' + applicationId;
        var feedbackModal = new bootstrap.Modal(document.getElementById('feedbackModal'), {});
        feedbackModal.show();
    }
</script>
@endsection