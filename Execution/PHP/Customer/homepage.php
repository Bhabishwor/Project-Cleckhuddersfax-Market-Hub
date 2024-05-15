<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Home | Cleckhuddersfax Market Hub</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        @import url('https://fonts.googleapis.com/css?family=Montserrat&display=swap');

        body {
            font-family: 'Montserrat', sans-serif;
        }
        
        .welcome-title {
            font-size: 35px;
            font-weight: bold;
            color: #3e4652;
            margin-top: 30px;
        }

        .welcome-text {
            font-size: 16px;
            font-weight: bold;
            color: #3e4652;
            margin-top: -20px;
        }

        .bg-category {
            background-image: url("../../Image/container2.png");
            background-size: cover; /* Cover the entire background */
            background-position: center; /* Center the background */
            background-repeat: no-repeat; /* Prevent the background from repeating */
        }
    </style>
</head>

<body>
    <?php include "header.php"; ?>
    
    <div class="container-fluid p-5">
        <div class="row">
            <div class="py-5 col-md-5">
                <p class="welcome-title">WELCOME TO CLECKHUDDERSFAX MARKET HUB</p>
                <p class="welcome-text">Discover quality products curated just for you.</p>
            </div>
                

            <div id="carouselHome" class="carousel slide col-md-7" data-bs-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-bs-target="#carouselHome" data-bs-slide-to="0" class="active"></li>
                    <li data-bs-target="#carouselHome" data-bs-slide-to="1"></li>
                    <li data-bs-target="#carouselHome" data-bs-slide-to="2"></li>
                </ol>
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img class="d-block w-100" src="../../Image/homepage_slides/homepage_slide1.png" alt="First slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="../../Image/homepage_slides/homepage_slide1.png" alt="Second slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="../../Image/homepage_slides/homepage_slide1.png" alt="Third slide">
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselHome" role="button" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                </a>
                <a class="carousel-control-next" href="#carouselHome" role="button" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                </a>
            </div>
        </div>
    </div>

    <!-- Menu container -->
    <div class="container bg-category px-5 my-3">
        <nav class="navbar navbar-expand-lg navbar-light">
            <ul class="navbar-nav w-100 d-flex flex-wrap justify-content-between">
                <!-- Menu Item 1 -->
                <li class="nav-item dropdown col-lg-auto col-md-6 col-sm-12 mb-2">
                    <a href="#" id="item1" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="../../Image/categories/meat.png" alt="Meat" height="150" width="150">
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="item1">
                        <li><a class="dropdown-item" href="#">Option 1</a></li>
                        <li><a class="dropdown-item" href="#">Option 2</a></li>
                        <li><a class="dropdown-item" href="#">Option 3</a></li>
                    </ul>
                </li>

                <!-- Menu Item 2 -->
                <li class="nav-item dropdown col-lg-auto col-md-6 col-sm-12 mb-2">
                    <a href="#" id="item2" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="../../Image/categories/fresh_produce.png" alt="Fresh Produce" height="150" width="150">
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="item2">
                        <li><a class="dropdown-item" href="#">Option 4</a></li>
                        <li><a class="dropdown-item" href="#">Option 5</a></li>
                        <li><a class="dropdown-item" href="#">Option 6</a></li>
                    </ul>
                </li>

                <!-- Menu Item 3 -->
                <li class="nav-item dropdown col-lg-auto col-md-6 col-sm-12 mb-2">
                    <a href="#" id="item3" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="../../Image/categories/deli_items.png" alt="Deli Items" height="150" width="150">
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="item3">
                        <li><a class="dropdown-item" href="#">Option 7</a></li>
                        <li><a class="dropdown-item" href="#">Option 8</a></li>
                        <li><a class="dropdown-item" href="#">Option 9</a></li>
                    </ul>
                </li>

                <!-- Menu Item 4 -->
                <li class="nav-item dropdown col-lg-auto col-md-6 col-sm-12 mb-2">
                    <a href="#" id="item3" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="../../Image/categories/seafood.png" alt="Seafood" height="150" width="150">
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="item3">
                        <li><a class="dropdown-item" href="#">Option 7</a></li>
                        <li><a class="dropdown-item" href="#">Option 8</a></li>
                        <li><a class="dropdown-item" href="#">Option 9</a></li>
                    </ul>
                </li>

                <!-- Menu Item 5 -->
                <li class="nav-item dropdown col-lg-auto col-md-6 col-sm-12 mb-2">
                    <a href="#" id="item3" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="../../Image/categories/bakery.png" alt="Bakery" height="150" width="150">
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="item3">
                        <li><a class="dropdown-item" href="#">Option 7</a></li>
                        <li><a class="dropdown-item" href="#">Option 8</a></li>
                        <li><a class="dropdown-item" href="#">Option 9</a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>
    
    <?php include "footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>