@extends('layouts.unverified.unverifiedMaster')

@section('content')
<div class="container pt-2">
    @if(!$applicationId)
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

            <!-- progress tracker here -->
            <div class="container con-pb py-3">
                <div class="main">
                    <ul class="progressbar">
                        <li>
                            <i class="icons awesome fa-solid fa-user"></i>
                            <div class="step first active">
                                <p>1</p>
                                <i class="awesome fa-solid fa-check"></i>
                            </div>
                            <p class="label">Upload Files</p>
                        </li>
                        <li>
                            <i class="icons awesome fa-solid fa-coins"></i>
                            <div class="step second">
                                <p>2</p>
                                <i class="awesome fa-solid fa-check"></i>
                            </div>
                            <p class="label">Processing</p>
                        </li>
                        <li>
                            <i class="icons awesome fa-solid fa-house"></i>
                            <div class="step third">
                                <p>3</p>
                                <i class="awesome fa-solid fa-check"></i>
                            </div>
                            <p class="label">Complete</p>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- form here -->
            <div class="col-10 container justify-content-center align-items-center">
                <form method="POST" action="{{ route('submit.application') }}" enctype="multipart/form-data">
                    @csrf
                    <!-- First row -->
                    <div class="mb-3">
                        <label class="form-label">Shop Name</label>
                        <input name="shop_name" class="form-control @error('shop_name') is-invalid @enderror" value="{{ old('shop_name') }}" type="text">
                        <small class="text-muted">Please insert your registered shop name. If you have changes, please contact your manager.</small>
                        @error('shop_name')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="row mb-2">
                        <div class="mb-3 col-lg-6">
                            <label class="form-label">Person in charge's email</label>
                            <input name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" type="text">
                            <small class="text-muted">This email is for the person in charge in handling online transaction.</small>
                            @error('email')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3 col-lg-6">
                            <label class="form-label">E-Wallet Number</label>
                            <input name="contact_num" class="form-control @error('contact_num') is-invalid @enderror" value="{{ old('contact_num') }}" type="text">
                            <small class="text-muted">Please insert your E-wallet number such as Gcash, Paypal, etc.</small>
                            @error('contact_num')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="mb-3 col-lg-6">
                            <label for="formFile" class="form-label">Mayor's Permit <span class="text-danger">*</span>(PDF, JPEG, PNG Only)</label>
                            <input name="mayors" class="form-control @error('mayors') is-invalid @enderror" type="file" id="formFile">
                            <small class="text-muted">If you are uploading file with more than 1 page, submit it into PDF format.</small>
                            @error('mayors')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3 col-lg-6">
                            <label for="formFile" class="form-label">BIR <span class="text-danger">*</span>(PDF, JPEG, PNG Only)</label>
                            <input name="bir" class="form-control @error('bir') is-invalid @enderror" type="file" id="formFile">
                            <small class="text-muted">If you are uploading file with more than 1 page, submit it into PDF format.</small>
                            @error('bir')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <!-- Second row -->
                    <div class="row mb-2">
                        <div class="mb-3 col-lg-6">
                            <label for="formFile" class="form-label">DTI <span class="text-danger">*</span>(PDF, JPEG, PNG Only)</label>
                            <input name="dti" class="form-control @error('dti') is-invalid @enderror" type="file" id="formFile">
                            <small class="text-muted">If you are uploading file with more than 1 page, submit it into PDF format.</small>
                            @error('dti')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="mb-3 col-lg-6">
                            <label for="formFile" class="form-label">Adamson Contract <span class="text-danger">*</span>(PDF, JPEG, PNG Only)</label>
                            <input name="contract" class="form-control @error('contract') is-invalid @enderror" type="file" id="formFile">
                            <small class="text-muted">If you are uploading file with more than 1 page, submit it into PDF format.</small>
                            @error('contract')
                            <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>


                    <!-- Submit button -->
                    <div class="pb-2 text-center">
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

            <!-- progress tracker here -->
            <div class="container con-pb pt-3">
                <div class="main">
                    <ul class="progressbar">
                        <li>
                            <i class="icons awesome fa-solid fa-user"></i>
                            <div class="step first active">
                                <p>1</p>
                                <i class="awesome fa-solid fa-check"></i>
                            </div>
                            <p class="label">Upload Files</p>
                        </li>
                        <li>
                            <i class="icons awesome fa-solid fa-coins"></i>
                            <div class="step second active">
                                <p class="numbertwo">2</p>
                                <i class="awesome fa-solid fa-check"></i>
                            </div>
                            <p class="label">Processing</p>
                        </li>
                        <li>
                            <i class="icons awesome fa-solid fa-house"></i>
                            <div class="step third">
                                <p>3</p>
                                <i class="awesome fa-solid fa-check"></i>
                            </div>
                            <p class="label">Complete</p>
                        </li>
                    </ul>
                </div>
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

            <!-- progress tracker here -->
            <div class="container con-pb py-3">
                <div class="main">
                    <ul class="progressbar">
                        <li>
                            <i class="icons awesome fa-solid fa-user"></i>
                            <div class="step first active">
                                <p>1</p>
                                <i class="awesome fa-solid fa-check"></i>
                            </div>
                            <p class="label">Upload Files</p>
                        </li>
                        <li>
                            <i class="icons awesome fa-solid fa-coins"></i>
                            <div class="step second">
                                <p>2</p>
                                <i class="awesome fa-solid fa-check"></i>
                            </div>
                            <p class="label">Processing</p>
                        </li>
                        <li>
                            <i class="icons awesome fa-solid fa-house"></i>
                            <div class="step third">
                                <p>3</p>
                                <i class="awesome fa-solid fa-check"></i>
                            </div>
                            <p class="label">Complete</p>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- form here -->
            <div class="col-lg-8 container justify-content-center align-items-center">
                <div class="alert alert-danger" role="alert">
                    <p>Your previous application has been rejected.</p>
                    <strong>Manager's Feedback:</strong>
                    <p class="mb-0">
                        Reason:
                        {{ $applicationId->feedback }}
                    </p>
                    <p class="mb-0">
                        Rejected Files:
                        {{ $applicationId->rejected_files}}
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