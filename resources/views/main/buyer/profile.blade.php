@extends('layouts.buyer.buyermaster')

@section('content')

<div class="container pt-5 pb-5">

    <div class="row pt-2 pb-2" style="border-bottom: 1px solid gray">
        <div class="col-12">
            <h6>My profile &nbsp; <span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="lightblue" class="bi bi-info-circle" viewBox="0 0 16 16">
                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                        <path d="m8.93 6.588-2.29.287-.082.38.45.083c.294.07.352.176.288.469l-.738 3.468c-.194.897.105 1.319.808 1.319.545 0 1.178-.252 1.465-.598l.088-.416c-.2.176-.492.246-.686.246-.275 0-.375-.193-.304-.533zM9 4.5a1 1 0 1 1-2 0 1 1 0 0 1 2 0" />
                    </svg>
                </span></h6>
        </div>

        <div class="col-12">
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">First Name</label>
                <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="">
            </div>
        </div>

        <div class="col-12">
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Middle Name</label>
                <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="">
            </div>
        </div>

        <div class="col-12">
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Last Name</label>
                <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="">
            </div>
        </div>
    </div>

    <div class="row pt-2 pb-2" style="border-bottom: 1px solid gray">
        <div class="col-12">
            <h6>Email</h6>
        </div>

        <div class="col-12">
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Account</label>
                <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="">
            </div>
        </div>
    </div>

    <div class="row pt-2 pb-2">
        <div class="col-12">
            <h6>Password</h6>
        </div>

        <div class="col-12">
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Current Password</label>
                <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="">
            </div>
        </div>

        <div class="col-12">
            <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">New Password</label>
                <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="">
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="row d-flex justify-content-end">
                <div class="col-auto">
                    <button>Edit</button>
                </div>
                <div class="col-auto">
                    <button>Save</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection