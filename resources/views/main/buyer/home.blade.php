<!-- <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="/resources/css/homedes.css" type="text/css">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">



  <title>Document</title>

</head> -->
<style>
  /* Import Google font - Poppins */
  @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');


  /*SECOND ROW STYLING */
  .wrapper {
    display: flex;
    max-width: 1450px;
    position: relative;
  }

  .wrapper i {
    top: 50%;
    height: 44px;
    width: 44px;
    color: #343F4F;
    cursor: pointer;
    font-size: 1.15rem;
    position: absolute;
    text-align: center;
    line-height: 44px;
    background: #fff;
    border-radius: 50%;
    transform: translateY(-50%);
    transition: transform 0.1s linear;
  }

  .wrapper i:active {
    transform: translateY(-50%) scale(0.9);
  }

  .wrapper i:hover {
    background: #f2f2f2;
  }

  .wrapper i:first-child {
    left: -22px;
    display: none;
  }

  .wrapper i:last-child {
    right: -22px;
  }

  .wrapper .carousel {
    font-size: 0px;
    cursor: pointer;
    overflow: hidden;
    white-space: nowrap;
    scroll-behavior: smooth;
    display: flex;
    /* Use flexbox for layout */
    /*flex-wrap: wrap;*/
    /* Allow cards to wrap to the next row */
    justify-content: center;
    /* Center cards horizontally */
  }

  .card {
    flex: 0 0 calc(100% / 6);
    text-align: center;
    padding: 10px;
    box-sizing: border-box;
  }

  .carousel {
    font-size: 0;
    cursor: pointer;
    overflow: hidden;
    white-space: nowrap;
    scroll-behavior: smooth;

  }

  .carousel.dragging {
    cursor: grab;
    scroll-behavior: auto;
  }

  .carousel.dragging img {
    pointer-events: none;
  }

  .carousel img {
    height: 240px;
    object-fit: cover;
    user-select: none;
    width: 100%;

  }

  .carousel img:first-child {
    margin-left: 0px;
  }

  @media screen and (max-width: 900px) {
    .carousel img {
      width: calc(100% / 2);
    }
  }

  @media screen and (max-width: 550px) {
    .carousel img {
      width: 100%;
    }
  }

  /*FIRST ROW STYLING */
  .first-row {
    background-color: #707070;
    margin-left: -24px;
    margin-right: -24px;
  }

  .search-area {
    padding: 5rem;
    margin-left: 24px;
  }

  .search-container {
    display: flex;
    align-items: center;
    /* Align items vertically */
    background-color: white;
    border-radius: 10px;
    padding: 8px;
    border-color: none;
  }

  .search-input {
    flex: 1;
    /* Allow input to grow and take up remaining space */
    padding: 8px;
    border: 1px solid #ccc;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    margin-right: 10px;
    /* Add spacing between input and button */
  }

  .search-button {
    padding: 8px 16px;
    background-color: #0B1E59;
    color: white;
    border: none;
    border-radius: 5px;
    cursor: pointer;
  }

  .search-button:hover {
    background-color: #0056b3;
  }

  /* Align icon and text in the paragraph */
  .icon-with-text {
    display: flex;
    align-items: center;
    margin-right: 10px;
    /* Add spacing between icon and text */
    color: #0B1E59;
    margin-top: 10px;
    margin-bottom: 10px;

  }

  .logo-img {
    padding-top: 20px;
    align-items: center;
  }
</style>
@extends ('layouts.buyer.master')

@section('content')
<div class="container-fluid">
  <div class="row row-cols-2 first-row">
    <div class="col-7">
      <div class="search-area">
        <h3>
          We provide a platform for your <br> cravings Klasmeyts
        </h3> <br><br>
        <div class="search-container">
          <input type="text" class="search-input" placeholder="Enter your cravings">

          <button class="search-button">Search Food</button>
        </div>
      </div>
    </div>

    <div class="col-5">
      <img src="/images/logo/logohf1.png" class="logo-img" alt="hello logo">
    </div>
  </div>
  <!--SECOND ROW-->
  <!--<div class="row second-row mt-5">
    <h5>Cravings Categories</h5>
    <div class="col d-flex justify-content-center">
        <div class="wrapper">
            <i id="left" class="fa-solid fa-angle-left"></i>
            <div id = "carousel" class="carousel">
                <div class="card border-0">
                    <img src="/images/jru.jpg" alt="img" draggable="false">
                    <p>Category Name 1</p>
                </div>
                <div class="card border-0">
                    <img src="/images/jru.jpg" alt="img" draggable="false">
                    <p>Category Name 2</p>
                </div>
                <div class="card border-0">
                    <img src="/images/jru.jpg" alt="img" draggable="false">
                    <p>Category Name 3</p>
                </div>
                <div class="card border-0">
                    <img src="/images/jru.jpg" alt="img" draggable="false">
                    <p>Category Name 3</p>
                </div>
                <div class="card border-0">
                    <img src="/images/jru.jpg" alt="img" draggable="false">
                    <p>Category Name 3</p>
                </div>
                <div class="card border-0">
                    <img src="/images/jru.jpg" alt="img" draggable="false">
                    <p>Category Name 3</p>
                </div>
                <div class="card border-0">
                    <img src="/images/jru.jpg" alt="img" draggable="false">
                    <p>Category Name 3</p>
                </div>
                <div class="card border-0">
                    <img src="/images/jru.jpg" alt="img" draggable="false">
                    <p>Category Name 3</p>
                </div>
                <div class="card border-0">
                    <img src="/images/jru.jpg" alt="img" draggable="false">
                    <p>Category Name 3</p>
                </div>
            </div>
            <i id="right" class="fa-solid fa-angle-right"></i>
        </div>
    </div>
</div>-->


  <!--     CATEGORIES ROW -->
  <h5>Canteen Shop</h5>
  <div class="row  row-cols-3 gy-5">

    <a href="#" style="text-decoration: none;">
      <div class="col">
        <div class="card" style="width: 20rem;">
          <img src="/images/jru.jpg" class="card-img-top" alt="...">
          <div class="card-body">
            <p class="card-text" style="text-align: left;">Burger Shop at CS Canteen</p>
            <p style="text-align: left;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#389BF2" class="bi bi-star-fill" viewBox="0 0 16 16">
                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
              </svg>
              Ratings: 4.1

            </p>

            <p style="text-align: left;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#389BF2" class="bi bi-clock-fill" viewBox="0 0 16 16">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z" />
              </svg>
              10 mins
            </p>


          </div>
        </div>
      </div>
    </a>


    <a href="#" style="text-decoration: none;">
      <div class="col">
        <div class="card" style="width: 20rem;">
          <img src="/images/jru.jpg" class="card-img-top" alt="...">
          <div class="card-body">
            <p class="card-text" style="text-align: left;">Burger Shop at CS Canteen</p>
            <p style="text-align: left;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#389BF2" class="bi bi-star-fill" viewBox="0 0 16 16">
                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
              </svg>
              Ratings: 4.1

            </p>

            <p style="text-align: left;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#389BF2" class="bi bi-clock-fill" viewBox="0 0 16 16">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z" />
              </svg>
              10 mins
            </p>


          </div>
        </div>
      </div>
    </a>


    <a href="#" style="text-decoration: none;">
      <div class="col">
        <div class="card" style="width: 20rem;">
          <img src="/images/jru.jpg" class="card-img-top" alt="...">
          <div class="card-body">
            <p class="card-text" style="text-align: left;">Burger Shop at CS Canteen</p>
            <p style="text-align: left;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#389BF2" class="bi bi-star-fill" viewBox="0 0 16 16">
                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
              </svg>
              Ratings: 4.1

            </p>

            <p style="text-align: left;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#389BF2" class="bi bi-clock-fill" viewBox="0 0 16 16">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z" />
              </svg>
              10 mins
            </p>


          </div>
        </div>
      </div>
    </a>


    <a href="#" style="text-decoration: none;">
      <div class="col">
        <div class="card" style="width: 20rem;">
          <img src="/images/jru.jpg" class="card-img-top" alt="...">
          <div class="card-body">
            <p class="card-text" style="text-align: left;">Burger Shop at CS Canteen</p>
            <p style="text-align: left;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#389BF2" class="bi bi-star-fill" viewBox="0 0 16 16">
                <path d="M3.612 15.443c-.386.198-.824-.149-.746-.592l.83-4.73L.173 6.765c-.329-.314-.158-.888.283-.95l4.898-.696L7.538.792c.197-.39.73-.39.927 0l2.184 4.327 4.898.696c.441.062.612.636.282.95l-3.522 3.356.83 4.73c.078.443-.36.79-.746.592L8 13.187l-4.389 2.256z" />
              </svg>
              Ratings: 4.1

            </p>

            <p style="text-align: left;"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="#389BF2" class="bi bi-clock-fill" viewBox="0 0 16 16">
                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0M8 3.5a.5.5 0 0 0-1 0V9a.5.5 0 0 0 .252.434l3.5 2a.5.5 0 0 0 .496-.868L8 8.71z" />
              </svg>
              10 mins
            </p>


          </div>
        </div>
      </div>
    </a>



  </div>
</div>
<script src="/resources/js/scriptu.js"></script>
@endsection