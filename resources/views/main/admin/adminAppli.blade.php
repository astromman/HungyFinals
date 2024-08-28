@extends('layouts.manager.mangerMaster')

@section('content')

<script>
    function changeStatus(status) {
        $("#statusInput").val(status);
        $("#statusForm").submit();
    }
</script>

<div class="container pt-4">
    <div>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th scope="col">Shop Name</th>
                    <th scope="col">Status</th>
                    <th scope="col">Date Submitted</th>
                    <th scope="col">Documents</th>
                </tr>
            </thead>
            <tbody>
                @foreach($displayApplications as $applicationData)
                <tr>
                    <td>{{ $applicationData->shop_name }}</td>
                    <td>{{ $applicationData->application_status }}</td>
                    <td>{{ $applicationData->date_created }}</td>
                    <td class="text-center">
                        <form class="file-form view-image" method="POST" data-action="{{ route('appl.details') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="ApplicationId" value="{{ $applicationData->id }}">
                            <button type="submit" class="btn btn-primary py-1 w-50 rounded-pill">
                                View
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <button type="button" id="btnModal" class="d-none btn btn-primary" data-bs-toggle="modal" data-bs-target="#viewForms">
        </button>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="viewForms" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Permits</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="color: white"></button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-4">
                        Mayor's Permit
                        <embed id="mayorPermit" src="" width="100%" height="600px">
                    </div>
                    <!-- <div>
                        <hr>
                    </div> -->
                    <div class="col-lg-4">
                        BIR
                        <embed id="birPermit" src="" width="100%" height="600px">
                    </div>
                    <!-- <div>
                        <hr>
                    </div> -->
                    <div class="col-lg-4">
                        DTI
                        <embed id="dtiPermit" src="" width="100%" height="600px">
                    </div>
                    <!-- <div>
                        <hr>
                    </div> -->
                    <div class="col-lg-4">
                        Adamson Contract
                        <embed id="admPermit" src="" width="100%" height="600px">
                    </div>
                </div>
            </div>

            <div class="modal-footer text-center">
                <form method="POST" action="{{ route('appl.status') }}" id="statusForm">
                    @csrf
                    <input type="hidden" name="status" id="statusInput">
                    <button type="button" class="btn" style="background-color: #020659; color: white;" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-reject update-status" onclick="changeStatus('Reject')" style="background-color: #020659; color: white;">Reject</button>
                    <button type="button" class="btn btn-approve update-status" onclick="changeStatus('Approve')" style="background-color: #020659; color: white;">Approve</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="module">
    var form = ".form";

    $(function() {
        getFilesLocation();
    });

    function getFilesLocation() {
        $(".view-image").on('submit', function(event) {
            event.preventDefault();
            var appId = $(this).find('#ApplicationId').val(); // Get the value
            // ... rest of your AJAX code utilizing appId
            var url = $(this).attr('data-action');
            $.ajax({
                url: url,
                method: 'POST',
                data: new FormData(this),
                dataType: 'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function(response) {
                    console.log(response);
                    var path = $(location).attr("origin") + "/storage/uploads/";
                    $("#mayorPermit").attr('src', path + response.mayors);
                    $("#birPermit").attr('src', path + response.bir);
                    $("#dtiPermit").attr('src', path + response.dti);
                    $("#admPermit").attr('src', path + response.adu_contract);

                    $("#btnModal").click();
                },
                error: function(response) {
                    console.log(response.responseJSON.message);
                }
            });
        });
    }
</script>
@endsection