<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        .card {

            background-color: #fff;
            border: none;
            border-radius: 10px;
            width: 190px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);

        }

        .image-container {

            position: relative;
        }

        .thumbnail-image {
            border-radius: 10px !important;
        }


        .discount {

            background-color: lightblue;
            padding-top: 1px;
            padding-bottom: 1px;
            padding-left: 4px;
            padding-right: 4px;
            font-size: 10px;
            border-radius: 6px;
            color: #fff;
        }

        .wishlist {

            height: 25px;
            width: 25px;
            background-color: #eee;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 50%;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }

        .first {

            position: absolute;
            width: 100%;
            padding: 9px;
        }


        .dress-name {
            font-size: 13px;
            font-weight: bold;
            width: 75%;
        }


        .new-price {
            font-size: 13px;
            font-weight: bold;
            color: red;

        }

        .old-price {
            font-size: 8px;
            font-weight: bold;
            color: grey;
        }
    </style>
</head>

<body>

    @extends('layouts.buyer.master')
    @section('content')

    <div class="container-fluid">
        <div class="row">
            <div class="mb-2">
                <div class="col-md-6 offset-md-6 text-end">
                    <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Search foods here">
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <div class="row">
                    <div class="col-auto">
                        <p>Shops</p>
                    </div>
                    <div class="col-auto">
                        Ms. Wendy's Special
                    </div>
                </div>
            </div>
            <div class="col">
                <h3>Ms. Wendy's Special</h3>
                <p>Contact: <span>8700-8700</span></p>
                <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="red" class="bi bi-clock" viewBox="0 0 16 16">
                        <path d="M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z" />
                        <path d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16m7-8A7 7 0 1 1 1 8a7 7 0 0 1 14 0" />
                    </svg> Mon - Friday 8:00 AM - 5:00 PM
                </p>
            </div>
        </div>

        <div class="row row-cols-3 mt-4 mb-4 gy-5 ">
            <!-- 1st CARD--->
            foreach($displayProducts as $ProductData)
            <div class="col-md-4">
                <button type="button" class="btn-btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModalScrollable">
                    <div class="card">
                        <div class="image-container p-1">
                            <div class="first">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="discount"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="white" class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                            <path d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10m0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6" />
                                        </svg> Pick Up</span>
                                    <span class="wishlist"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-heart" viewBox="0 0 16 16">
                                            <path d="m8 2.748-.717-.737C5.6.281 2.514.878 1.4 3.053c-.523 1.023-.641 2.5.314 4.385.92 1.815 2.834 3.989 6.286 6.357 3.452-2.368 5.365-4.542 6.286-6.357.955-1.886.838-3.362.314-4.385C13.486.878 10.4.28 8.717 2.01zM8 15C-7.333 4.868 3.279-3.04 7.824 1.143q.09.083.176.171a3 3 0 0 1 .176-.17C12.72-3.042 23.333 4.867 8 15" />
                                        </svg></span>
                                </div>
                            </div>
                            <!---PRODUCT IMAGE--->
                            <img src="" class="img-fluid rounded thumbnail-image">
                        </div>

                        <div class="product-detail-container p-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <!---PRODUCT NAME--->
                                <h5 class="dress-name"></h5>
                            </div>

                            <div class="d-flex flex-column">
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="lightblue" class="bi bi-tag-fill" viewBox="0 0 16 16">
                                        <path d="M2 1a1 1 0 0 0-1 1v4.586a1 1 0 0 0 .293.707l7 7a1 1 0 0 0 1.414 0l4.586-4.586a1 1 0 0 0 0-1.414l-7-7A1 1 0 0 0 6.586 1zm4 3.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0" />
                                    </svg>
                                    <!---PRODUCT PRICE--->
                                    <span class="price-number"></span>
                                </div>
                                <div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="lightblue" class="bi bi-star-fill" viewBox="0 0 16 16">
                                        <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                    </svg>
                                    <!---PRODUCT RATINGS--->
                                    {{-- <span class="rating-number"></span> --}}
                                </div>
                            </div>
                        </div>
                    </div>

                </button>
            </div>
            endforeach

        </div>
    </div>

    <!-- Scrollable modal -->
    <div class="modal fade" id="exampleModalScrollable" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <!--- FIRST ROW--->
                    <div class="image-container p-1">

                        <div class="first">

                            <div class="d-flex justify-content-between align-items-center">


                                <span class="wishlist"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x" viewBox="0 0 16 16">
                                        <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708" />
                                    </svg></span>


                            </div>
                        </div>

                        <img id="imageModal" src="" class="img-fluid rounded thumbnail-image">


                    </div>
                    <div class="row">
                        <div class="col-6 ml-1">
                            <h4>Tapsilog</h4>
                        </div>
                        <div class="col-6">
                            <div class=" d-flex justify-content-center mt-5">
                                <div class=" text-center mb-5">
                                    <div class="rating"> <input type="radio" name="rating" value="5" id="5"><label for="5">☆</label>
                                        <input type="radio" name="rating" value="4" id="4"><label for="4">☆</label>
                                        <input type="radio" name="rating" value="3" id="3"><label for="3">☆</label>
                                        <input type="radio" name="rating" value="2" id="2"><label for="2">☆</label>
                                        <input type="radio" name="rating" value="1" id="1"><label for="1">☆</label>
                                    </div>

                                    {{-- <div class="buttons  mt-0"> <button class="btn btn-info px-4 py-1 rating-submit ">Submit</button> </div> --}}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <p id="modalDescription"></p>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-auto">
                                    <p>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="lightblue" class="bi bi-tag-fill" viewBox="0 0 16 16">
                                            <path d="M2 1a1 1 0 0 0-1 1v4.586a1 1 0 0 0 .293.707l7 7a1 1 0 0 0 1.414 0l4.586-4.586a1 1 0 0 0 0-1.414l-7-7A1 1 0 0 0 6.586 1zm4 3.5a1.5 1.5 0 1 1-3 0 1.5 1.5 0 0 1 3 0" />
                                        </svg> 
                                    </p>
                                </div>
                                <div class="col-auto">
                                    <p>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="lightblue" class="bi bi-star-fill" viewBox="0 0 16 16">
                                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                        </svg> 4.1
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!---2ND ROW--->


                    <!--3RD ROW--->
                    <div class="row">
                        <div class="col-auto">
                            <h6>Comment</h6>
                            <p style="font-size: 12px">What's your opinion about the product klasmeyt?</p>
                        </div>
                        <div class="col-12">
                            <div class="mb-5">
                                <label for="exampleFormControlTextarea1" class="form-label"></label>
                                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                            </div>
                        </div>
                        <div class="col-12 text-end">
                            <button>
                                Send
                            </button>
                        </div>
                    </div>

                    <!---4TH ROW--->
                    <div class="row">
                        <div class="col-12">
                            <h6>Reviews ni klasmeyt</h6>
                        </div>
                        <div class="col-12" style="border-color: black; ">
                            <div class="row">
                                <div class="col-2">
                                    <img src="/images/colet.jpg" alt="Image description" class="img-thumbnail rounded-circle">
                                </div>
                                <div class="col-4">
                                    <p>Lebron James</p>
                                    <p><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                        </svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                        </svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                        </svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                        </svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-star-fill" viewBox="0 0 16 16">
                                            <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
                                        </svg>
                                    </p>
                                </div>

                                <div class="col-4">
                                    <p>This is amazing</p>
                                </div>

                                <div class="col-2">
                                    <p style="font-size: 11px">11/25/2024</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-dash-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M4.5 7.5a.5.5 0 0 0 0 1h7a.5.5 0 0 0 0-1z" />
                        </svg></button>
                    <p>1</p>

                    <button type="button">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3z" />
                        </svg>
                    </button>
                    <button type="button" class="btn btn-primary">Add to Cart</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        function openModal(name, description, image) {
            var path = $(location).attr("origin") + "/storage/uploads/products/";
            $("#modalTitle").text("").text(name);
            $("#imageModal").attr('src', path + image);
            $("#modaldescription").text("").text(description);
        }
    </script>
    @endsection
</body>

</html>