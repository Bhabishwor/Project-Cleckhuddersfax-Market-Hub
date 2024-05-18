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
 
        /* Product Card */
        .card {
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Add box shadow for depth */
            transition: box-shadow 0.3s ease; /* Add transition effect for hover */
        }

        .card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2); /* Increase box shadow on hover */
        }

        .card-img-container {
            height: 300px; /* Set a larger fixed height for the image container */
            overflow: hidden; /* Hide any overflow from larger images */
        }

        .card img {
            width: 100%; /* Ensure the image fills its container */
            height: auto; /* Maintain aspect ratio */
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }

        .card-body {
            padding: 15px; /* Add padding inside the card body */
        }

        .card-title {
            font-size: 1.25rem;
            margin-bottom: 10px;
        }

        .card-text p {
            margin: 0; /* Remove default margin for paragraphs */
            overflow: hidden; /* Hide overflow content */
            text-overflow: ellipsis; /* Truncate text with an ellipsis */
            white-space: nowrap; /* Prevent wrapping */
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
                        <li><a class="dropdown-item" href="#">Option 8"></a></li>
                        <li><a class="dropdown-item" href="#">Option 9"></a></li>
                    </ul>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Products Container -->
    <div class="container my-5">
    <div class="row row-cols-1 row-cols-md-3 g-4">


    <?php
// Include the database connection
include "../connection/connection.php";

// Define the base URL for images
$base_url = "http://localhost/Team%20Project/Project-Cleckhuddersfax-Market-Hub/Execution/uploads/";

// Fetch products from the database
$sql = "SELECT PRODUCT_NAME, PRODUCT_PRICE, PRODUCT_IMAGE_PATH FROM PRODUCT";
$stmt_products = oci_parse($conn, $sql);
oci_execute($stmt_products);

// Loop through each product and display its image, name, and price
while ($row_product = oci_fetch_assoc($stmt_products)) {
    // Get the image path from the database
    $image_path = $row_product['PRODUCT_IMAGE_PATH'];
    
    // Create the full URL for the image
    $image_url = $base_url . urlencode(basename($image_path));

    // If image URL is empty, use a placeholder image
    if (empty($image_path)) {
        $image_url = $base_url . 'placeholder.jpg';
    }

    // Product card HTML
    echo "<div class='col-md-4 mb-4'>";
    echo "<div class='card'>";
    echo "<div class='card-img-container'>";
    echo "<img src='" . htmlspecialchars($image_url) . "' class='card-img-top' alt='Product Image'>";
    echo "</div>";
    echo "<div class='card-body'>";
    echo "<h5 class='card-title'>" . htmlspecialchars($row_product['PRODUCT_NAME']) . "</h5>";
    echo "<p class='card-text'>Price: $" . number_format($row_product['PRODUCT_PRICE'], 2) . "</p>";
    echo "</div>"; // Closing card-body div
    echo "</div>"; // Closing card div
    echo "</div>"; // Closing column div
}

// Free the statement identifier and close the connection
oci_free_statement($stmt_products);
oci_close($conn);
?>



        </div>
    </div>
    
    <?php include "footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        // Get all product cards
        const productCards = document.querySelectorAll('.card');

        // Add click event listener to each product card
        productCards.forEach(function(card) {
            card.addEventListener('click', function() {
                // Redirect user to order.php
                window.location.href = 'order.php';
            });
        });
    });
</script>

</body>
</html>
