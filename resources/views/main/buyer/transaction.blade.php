<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="	https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <title>Document</title>
</head>

<body>
@extends('layouts.buyer.master')

    @section('content')


    <div class="container pt-5">
        <div class="row">
            <div class="col-12">
                <h4>Order History</h4>
            </div>
            <div class="col-12">
                <p>Check the completed status of your recent orders</p>
            </div>
        </div>

        <div class="row mt-5 mb-5" style="border: 1px solid black; border-radius: 10px; gap:10px">
        <div class="row">
            <div class="col-3">
                <h6>Date placed</h6>
                <p>Jul 6, 2024</p>
            </div>

            <div class="col-9">
                <h6>Total amount</h6>
                <p>500.00</p>
            </div>
        </div>

        

            <div class="row">
                <div class="col-3">
                    <div class="col-md-7">
                        <img src="/images/colet.jpg" class="img-fluid rounded thumbnail-image">
                    </div>

                    <p>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                        </svg> <span style="font-weight: bold">Order in: 2:30PM</span>
                    </p>
                </div>
                <div class="col-8">
                    <p style="font-size: 24px"><span style="font-weight:bold">Wendy's</span> Tapsilog</p>
                    <p>Add-ons: Extra Rice, Extra Egg, Cheese</p>
                    <p>Quantity: 3</p>
                </div>

                <div class="col-1">
                    <p style="font-size: 20px; font-weight: bold">500.00</p>
                </div>
            </div>

            <div class="row">
                <div class="col-3">
                    <div class="col-md-7">
                        <img src="/images/colet.jpg" class="img-fluid rounded thumbnail-image">
                    </div>

                    <p>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
                        </svg> <span style="font-weight: bold">Order in: 2:30PM</span>
                    </p>
                </div>
                <div class="col-8">
                    <p style="font-size: 24px"><span style="font-weight:bold">Wendy's</span> Tapsilog</p>
                    <p>Add-ons: Extra Rice, Extra Egg, Cheese</p>
                    <p>Quantity: 3</p>
                </div>

                <div class="col-1">
                    <p style="font-size: 20px; font-weight: bold">500.00</p>
                </div>
            </div>
        </div>
    </div>
    </div>
    @endsection
</body>

</html>