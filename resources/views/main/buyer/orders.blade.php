<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
         .bi-check-circle-fill {
        font-size: 150px;
        color: #389BF2;
        padding-left: 35px;
    }

    .main {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        
    }

    .progressbar {
        display: flex;
    }

    /* for the circle position */
    .progressbar li {
        list-style: none;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        margin: 0 120px;
    }

    .progressbar li .icons {
        font-size: 25px;
        color: #1b761b;
        margin: 0 60px;
    }

    .progressbar li .label {
        font-family: sans-serif;
        letter-spacing: 1px;
        font-size: 14px;
        font-weight: bold;
        color: #0B1E59;
    }

    .progressbar li .step {
        height: 30px;
        width: 30px;
        border-radius: 50%;
        background-color: lightgray;
        margin: 16px 0 10px;
        display: grid;
        place-items: center;
        color: ghostwhite;
        position: relative;
    }

    /* for the line length */
    .step::after {
        content: "";
        position: absolute;
        width: 335px;
        height: 3px;
        background-color: lightgray;
        right: 30px;
    }

    /* Style the line between "1" and "2" */
    li:nth-child(2) .step::after {
        background-color: #0B1E59; /* Color for the line between "1" and "2" */
    }

    /* Style the number "2" */
    li:nth-child(2) .numbertwo {
        color: white; /* Color for the number "2" */
    }

    .first::after {
        width: 0;
        height: 0;
    }

    .progressbar li .step .awesome {
        display: none;
    }

    .progressbar li .step p {
        font-size: 18px;
    }

    .progressbar li .active {
        background-color: #0B1E59;
    }

    li .active::after {
        background-color: #0B1E59;
    }

    .progressbar li .active p {
        display: none;
    }

    .progressbar li .active .awesome {
        display: flex;
    }
    </style>
</head>
<body>
    
@extends('layouts.buyer.master')

@section('content')

<div class="container gy-4">
<div class="row">
    <div class="col-12">
        <h4>Track your orders Klasmeyt</h4>
        <small>this will help to manage your time and observe your order</small>
    </div>
</div>

<div class="row">
    <div class="col-4">
        <h4> We were processing your order klasmeyt</h4>
        <small>Thank you for being patient. We appreciate it.</small>
        <p style="font-style: bold">Pick-up Klasmeyt:</p style="font-style: bold">
        <small>Lebron James</small>
    </div>
</div>

<div class="row">
<div class="container py-3">
                    <div class="main">
                        <ul class="progressbar">
                            <li>
                                <i class="icons awesome fa-solid fa-user"></i>
                                <div class="step first active">
                                    <p>1</p>
                                    <i class="awesome fa-solid fa-check"></i>
                                </div>
                                <p class="label">Processing Order</p>
                            </li>
                            <li>
                                <i class="icons awesome fa-solid fa-coins"></i>
                                <div class="step second active">
                                    <p class="numbertwo">2</p>
                                    <i class="awesome fa-solid fa-check"></i>
                                </div>
                                <p class="label">Preparing Order</p>
                            </li>
                            <li>
                                <i class="icons awesome fa-solid fa-house"></i>
                                <div class="step third active">
                                    <p>3</p>
                                    <i class="awesome fa-solid fa-check"></i>
                                </div>
                                <p class="label">Ready for pick-up</p>
                            </li>
                        </ul>
                    </div>
                </div>
</div>

<div class="row p-2">
    <div class="col-2">
    <img src="/images/colet.jpg" class="img-fluid rounded thumbnail-image">

    </div>
    <div class="col-5">
    <h6>Wendy's - Chicken Pastil</h6>
    <p>Quantity: 3</p>
    </div>

    <div class="col-5">
        115.00 Pesos
    </div>
</div>

<div class="row p-2">
    <div class="col-2">
    <img src="/images/colet.jpg" class="img-fluid rounded thumbnail-image">

    </div>
    <div class="col-5">
    <h6>Wendy's - Chicken Pastil</h6>
    <p>Quantity: 3</p>
    </div>

    <div class="col-5">
        115.00 Pesos
    </div>
</div>

<div class="row">
    <div class="col-12 text-end">
        TOTAL AMOUNT: 600 PESOS
    </div>
</div>
</div>

@endsection
</body>
</html>