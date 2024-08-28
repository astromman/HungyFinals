@extends('layouts.admin.adminMaster')

@section('content')
<div class="text-center" style="background-color: #D4DFE8;">
    @if (session('success'))
    <div class="alert alert-success" role="alert">
        {{ session('success') }}
    </div>
    @endif
</div>

@endsection