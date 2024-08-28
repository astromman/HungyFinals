@extends('layouts.account.registerMaster')

@section('contentForm')
    <div class="text-center pt-4 pb-3" style="color: white;">
        <h2><b>Application Form for Seller</b></h2>
    </div>

    <div class="container px-5 py-3" style="color: white;">
        <form>
            <div class="mb-3">
                <label for="formFile" class="form-label">Mayor's Permit</label>
                <input class="form-control" type="file" id="formFile">
            </div>
            <div class="mb-3">
                <label for="formFile" class="form-label">BIR</label>
                <input class="form-control" type="file" id="formFile">
            </div>
            <div class="mb-3">
                <label for="formFile" class="form-label">DTI</label>
                <input class="form-control" type="file" id="formFile">
            </div>
            <div class="mb-3">
                <label for="formFile" class="form-label">Adamson Contract</label>
                <input class="form-control" type="file" id="formFile">
            </div>

            <div class="pt-3 my-3 text-center">
                <button type="submit" class="btn btn-primary btn-rounded rounded-pill mb-3">Submit</button>
                <p><a href="#">Go back</a></p>
            </div>

        </form>
    </div>

@endsection