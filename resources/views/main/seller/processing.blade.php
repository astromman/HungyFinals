@extends('layouts.unverified.unverifiedMaster')

@section('content')
<div class="container pt-4">
    <!-- Title/heading -->
    <div class="ps-4 pb-3" style="font-family: Arial, sans-serif">
        <h2><b>Application Status </b></h2>
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
</div>
@endsection