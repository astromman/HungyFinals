@extends('layouts.unverified.unverifiedMaster')

@section('content')
<div class="container pt-2">
    @if(!$applicationId)
    <!-- Title -->
    <div class="pb-1">
        <h2><b>Shop Verification</b></h2>
        <p>To use the system, please resubmit all the following permits needed.</p>
    </div>

    <div class="row justify-content-center">
        <!-- sub title inside the card/white-bg -->
        <div class="card col-lg-10 shadow rounded-4">
            <div class="container pt-3">
                <h2>Upload all the following files</h2>
            </div>

            <div class="px-lg-5 px-2 pt-3 mb-0">
                @include('main.unverified.protobar')
            </div>

            <!-- form here -->
            <div class="pt-0 col-10 container justify-content-center align-items-center">
                <form method="POST" action="{{ route('submit.application') }}" enctype="multipart/form-data">
                    @csrf
                    <!-- First row -->
                    <h4>Shop Details</h4>
                    <hr class="mt-0">
                    <div class="mb-2">
                        <label class="form-label">Shop Name <span class="text-danger">*</span></label>
                        <input name="shop_name" class="form-control @error('shop_name') is-invalid @enderror" value="{{ old('shop_name') }}" type="text">
                        <small class="text-muted">Please insert your registered shop name. If you have changes, please contact your manager.</small>
                        @error('shop_name')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="row d-flex align-items-center mb-3">
                        <div class="col-lg-6 col-12">
                            <label class="form-label">E-Wallet Number <span class="text-danger">*</span></label>
                            <input name="contact_num" class="form-control @error('contact_num') is-invalid @enderror" value="{{ old('contact_num') }}" type="text">
                            <small class="text-muted">Please insert your E-wallet number such as Gcash.</small>
                            @error('contact_num')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-lg-6 col-12">
                            <label for="formFile" class="form-label">Shop Payment QR <span class="text-danger">*</span>(Image Only)</label>
                            <input
                                name="qr_image"
                                class="form-control"
                                type="file"
                                id="formFile"
                                {{ $shopDetails->is_reopen ? 'disabled' : '' }}>
                            <small class="text-muted">Please insert your Payment QR here.</small>
                        </div>
                    </div>

                    <h4 class="mb-0">Documents</h4>
                    <small class="text-muted">Note: If you are uploading file with more than 1 page, submit it into PDF format. JPEG and PNG format are also allowed.</small>
                    <hr>
                    <div class="row">
                        <div class="mb-3 col-lg-4">
                            <label for="formFile" class="form-label">Mayor's Permit <span class="text-danger">*</span></label>
                            <input name="mayors" class="form-control @error('mayors') is-invalid @enderror" type="file" id="formFile">
                            @error('mayors')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3 col-lg-4">
                            <label for="formFile" class="form-label">BIR <span class="text-danger">*</span></label>
                            <input name="bir" class="form-control @error('bir') is-invalid @enderror" type="file" id="formFile">
                            @error('bir')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3 col-lg-4">
                            <label for="formFile" class="form-label">DTI <span class="text-danger">*</span></label>
                            <input name="dti" class="form-control @error('dti') is-invalid @enderror" type="file" id="formFile">
                            @error('dti')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <!-- Second row -->
                    <div class="row">
                        <div class="mb-3 col-lg-6">
                            <label for="formFile" class="form-label">Adamson Contract <span class="text-danger">*</span></label>
                            <input name="contract" class="form-control @error('contract') is-invalid @enderror" type="file" id="formFile">
                            @error('contract')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3 col-lg-6">
                            <label for="formFile" class="form-label">Sanitary Permit <span class="text-danger">*</span></label>
                            <input name="sanitary" class="form-control @error('sanitary') is-invalid @enderror" type="file" id="formFile">
                            @error('sanitary')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>


                    <!-- Submit button -->
                    <div class="py-2 text-center">
                        <button type="submit" class="btn btn-primary btn-rounded w-100 rounded-pill mb-3">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @elseif($applicationId->status == "Pending" && !$applicationId->is_rejected)
    <!-- Title/heading -->
    <div class="ps-5 pb-3">
        <h2><b>Application Status</b></h2>
        <p>This will help to manage your time and observe your application.</p>
    </div>

    <div class="row justify-content-center">
        <!-- sub title inside the card/white-bg -->
        <div class="card col-lg-10 shadow-lg rounded-4">
            <div class="container pt-3">
                <h2>Processing your Application</h2>
            </div>

            <div class="p-5">
                @include('main.unverified.protobar')
            </div>

            <!-- message with logo here -->
            <div class="container">
                <div class=" d-flex justify-content-center align-items-center">
                    <i class="bi bi-clock-fill"></i>
                </div>

                <div class="mb-3 text-center">
                    <h2>Thank you for applying at Hungry Falcons.</h2>
                </div>

                <div>
                    <p class="text-center">
                        Your application is currently being reviewed.
                        You will be notified by email if your application is approved.
                    </p>
                </div>

                <div>
                    <p class="text-center">
                        Kindly wait patiently.
                    </p>
                </div>
            </div>
        </div>
    </div>

    @elseif($applicationId->status == "Rejected" && $applicationId->is_rejected)
    <!-- Title -->
    <div class="ps-5 pb-3">
        <h2><b>Shop Verification</b></h2>
        <p>To use the system, please resubmit all the following permits needed.</p>
    </div>

    <div class="row justify-content-center">
        <!-- sub title inside the card/white-bg -->
        <div class="card col-lg-10 shadow-lg rounded-4">
            <div class="container pt-3">
                <h2>Upload all the following files</h2>
            </div>

            <div class="p-5">
                @include('main.unverified.protobar')
            </div>

            <!-- form here -->
            <div class="col-lg-8 container justify-content-center align-items-center">
                <div class="alert alert-danger" role="alert">
                    <p>Your previous application has been rejected.</p>
                    <strong>Manager's Feedback:</strong>
                    <p class="mb-0 text-capitalize">
                        Rejected Files:
                        {{ $applicationId->rejected_files }}
                    </p>
                    <p class="mb-0">
                        Reason:
                        {{ $applicationId->feedback }}
                    </p>
                </div>
                <form method="POST" action="{{ route('resubmit.application') }}" enctype="multipart/form-data">
                    @csrf

                    <!-- Display only the rejected fields based on what the manager has selected -->
                    @if(str_contains($applicationId->rejected_files, 'Mayor\'s Permit') || str_contains($applicationId->rejected_files, 'mayor\'s'))
                    <div class="mb-3">
                        <label for="mayors" class="form-label">Mayor's Permit (PDF, JPEG, PNG Only)</label>
                        <input name="mayors" class="form-control @error('mayors') is-invalid @enderror" type="file" id="mayors">
                        @error('mayors')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    @endif

                    @if(str_contains($applicationId->rejected_files, 'BIR') || str_contains($applicationId->rejected_files, 'bir'))
                    <div class="mb-3">
                        <label for="bir" class="form-label">BIR (PDF, JPEG, PNG Only)</label>
                        <input name="bir" class="form-control @error('bir') is-invalid @enderror" type="file" id="bir">
                        @error('bir')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    @endif

                    @if(str_contains($applicationId->rejected_files, 'DTI') || str_contains($applicationId->rejected_files, 'dti'))
                    <div class="mb-3">
                        <label for="dti" class="form-label">DTI (PDF, JPEG, PNG Only)</label>
                        <input name="dti" class="form-control @error('dti') is-invalid @enderror" type="file" id="dti">
                        @error('dti')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    @endif

                    @if(str_contains($applicationId->rejected_files, 'AdU Contract') || str_contains($applicationId->rejected_files, 'AdU contract'))
                    <div class="mb-3">
                        <label for="contract" class="form-label">AdU Contract (PDF, JPEG, PNG Only)</label>
                        <input name="contract" class="form-control @error('contract') is-invalid @enderror" type="file" id="contract">
                        @error('contract')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    @endif

                    @if(str_contains($applicationId->rejected_files, 'Sanitary Permit') || str_contains($applicationId->rejected_files, 'sanitary'))
                    <div class="mb-3">
                        <label for="sanitary" class="form-label">Sanitary Permit (PDF, JPEG, PNG Only)</label>
                        <input name="sanitary" class="form-control @error('sanitary') is-invalid @enderror" type="file" id="sanitary">
                        @error('sanitary')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                    @endif

                    <!-- Submit button -->
                    <div class="pb-2 text-center">
                        <button type="submit" class="btn btn-primary btn-rounded w-100 rounded-pill mb-3">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @endif
</div>

@endsection