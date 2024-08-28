@extends('layouts.buyer.buyerMaster')

@section('content')
<style>
    /* CSS to style the navbar links */
    .navbar-nav .nav-link {
        color: white; /* Default color for all links */
    }

    .navbar-nav .nav-link:hover {
        color: lightgray; /* Color when hovering over links */
    }

    /* Style for the active link */
    .navbar-nav .nav-link.active {
        font-weight: bold; /* Bold font weight for active link */
        color: #ffc107 !important; /* Yellow color for active link */
    }
</style>

@endsection