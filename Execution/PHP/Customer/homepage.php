<?php
include "header.php";

if (isset($_SESSION["loginError"])) {
    echo "<script>alert('" . $_SESSION["loginError"] . "');</script>";
    unset($_SESSION["loginError"]);
}

if (isset($_SESSION["stockMsg"])) {
    echo "<script>alert('" . $_SESSION["stockMsg"] . "');</script>";
    unset($_SESSION["stockMsg"]);
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home | Cleckhuddersfax Market Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha384-KyZXEAg3QhqLMpG8r+Knujsl5/Drn5eB5u75e5K5/Y5q+vcIjP1U/YI4N6Y74K5a"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>


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
            background-image: url("../../Image/heritage/container2.png");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }


        /* Product Card */

        .card {
            border: 1px solid #ccc;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: box-shadow 0.3s ease;
            height: 100%;
        }

        .card:hover {
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        .card-img-container {
            height: 200px;
            /* Adjust the height of the image container */
            overflow: hidden;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
        }

        .card img {
            width: 100%;
            /* Make sure the image fills the container */
            height: 100%;
            /* Make sure the image fills the container */
            object-fit: cover;
            /* Ensure the image covers the container without distortion */
        }


        .card-body {
            padding: 15px;
            height: auto;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .card-title {
            font-size: 1.2rem;
            margin-bottom: 10px;
        }

        .card-text {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 5px;
        }

        .price {
            font-weight: bold;
            color: #333;
        }

        .average-rating {
            display: flex;
            align-items: center;
        }

        .average-rating i {
            color: gold;
            margin-right: 3px;
        }

        .button-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .button-container button {
            flex: 1;
            margin-right: 5px;
        }

        .button-container button:last-child {
            margin-right: 0;
        }

        /* Container styling */
        /* Container styling */
        .container.bg-category {
            background-color: #f8f9fa;
            /* Light grey background */
            border-radius: 5px;
            /* Rounded corners */
            padding: 1rem 2rem;
            /* Padding inside the container */
        }

        /* Row styling */
        .container.bg-category .row {
            margin-bottom: 1rem;
            /* Space below the row */
        }

        /* Form styling */
        #filter-form {
            display: flex;
            justify-content: end;
            align-items: center;
            gap: 0.5rem;
            /* Space between the label and the select box */
        }

        /* Label styling */
        #filter-form label {
            margin-right: 0.5rem;
            /* Space to the right of the label */
            font-weight: bold;
            /* Bold text */
            color: white;
            /* White color for the text */
            font-size: 1.25rem;
            /* Larger font size */
        }

        /* Select box styling */
        #filter-form .form-select {
            width: auto;
            /* Automatic width to fit the content */
            min-width: 150px;
            /* Minimum width for better appearance */
            padding: 0.375rem 0.75rem;
            /* Padding inside the select box */
            border-radius: 4px;
            /* Rounded corners */
            border: 1px solid #ced4da;
            /* Light border */
            font-size: 1.25rem;
            /* Larger font size */
            color: #495057;
            /* Dark grey text color */
            background-color: #fff;
            /* White background */
            background-clip: padding-box;
            /* Proper background clipping */
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
            /* Transition for smooth effects */
        }

        /* Hover and focus effects for the select box */
        #filter-form .form-select:hover,
        #filter-form .form-select:focus {
            border-color: #80bdff;
            /* Border color on hover and focus */
            outline: 0;
            /* Remove default outline */
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
            /* Box shadow on focus */
        }

        /* CSS for star rating */
        .star-rating {
            color: grey;
            /* Set the color of the stars to yellow */
        }

        .star-rating i {
            font-size: 16px;
            /* Adjust the size of the stars */
        }

        /* Adjust the color of the empty stars */
        .star-rating .fa-star-o {
            color: grey;
            /* Set the color of the empty stars to grey */
        }
    </style>
</head>


<body>


    <?php
    if (isset($_SESSION['order_placed']) && $_SESSION['order_placed']) {
        echo "<script>
                alert('Order Placed Successfully');
              </script>";


        // Unset the session variable
        unset($_SESSION['order_placed']);
    }
    ?>



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
                        <img class="d-block w-100" src="../../Image/homepage_slides/homepage_slide1.png"
                            alt="First slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="../../Image/homepage_slides/homepage_slide2.png"
                            alt="Second slide">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="../../Image/homepage_slides/homepage_slider3.png"
                            alt="Third slide">
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
                    <a href="#" id="item1" role="button" data-bs-toggle="dropdown" aria-expanded="false"
                        data-type="butchers">
                        <img src="../../Image/categories/meat.png" alt="Meat" height="150" width="150">
                    </a>
                </li>

                <!-- Menu Item 2 -->
                <li class="nav-item dropdown col-lg-auto col-md-6 col-sm-12 mb-2">
                    <a href="#" id="item2" role="button" data-bs-toggle="dropdown" aria-expanded="false"
                        data-type="greengrocer">
                        <img src="../../Image/categories/fresh_produce.png" alt="Greengrocer" height="150" width="150">
                    </a>
                </li>

                <!-- Menu Item 3 -->
                <li class="nav-item dropdown col-lg-auto col-md-6 col-sm-12 mb-2">
                    <a href="#" id="item3" role="button" data-bs-toggle="dropdown" aria-expanded="false"
                        data-type="delicatessen">
                        <img src="../../Image/categories/deli_items.png" alt="Delicatessen" height="150" width="150">
                    </a>
                </li>

                <!-- Menu Item 4 -->
                <li class="nav-item dropdown col-lg-auto col-md-6 col-sm-12 mb-2">
                    <a href="#" id="item4" role="button" data-bs-toggle="dropdown" aria-expanded="false"
                        data-type="fishmonger">
                        <img src="../../Image/categories/seafood.png" alt="Fishmonger" height="150" width="150">
                    </a>
                </li>

                <!-- Menu Item 5 -->
                <li class="nav-item dropdown col-lg-auto col-md-6 col-sm-12 mb-2">
                    <a href="#" id="item5" role="button" data-bs-toggle="dropdown" aria-expanded="false"
                        data-type="bakery">
                        <img src="../../Image/categories/bakery.png" alt="Bakery" height="150" width="150">
                    </a>
                </li>
            </ul>
        </nav>
    </div>
    <!-- Add this filter bar below the menu container -->
    <div class="container bg-category px-5 my-3">
        <div class="row">
            <div class="col-12">
                <form id="filter-form" class="d-flex justify-content-end">
                    <label for="sort" class="me-2 align-self-center">Sort by:</label>
                    <select id="sort" class="form-select w-auto">
                        <option value="default">Default</option>
                        <option value="price_asc">Price: Low to High</option>
                        <option value="price_desc">Price: High to Low</option>
                        <option value="name_asc">Name: A to Z</option>
                        <option value="name_desc">Name: Z to A</option>
                    </select>
                    <button id="all-products-btn" type="button" class="btn btn-secondary">All Products</button>
                </form>
            </div>
        </div>
    </div>


    <!-- Products Container -->
    <div class="container my-5">
        <div id="product-container" class="row row-cols-1 row-cols-md-3 g-4">
            <!-- Product cards will be loaded here -->
        </div>
    </div>


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Fetch all products initially
            fetchProducts('');

            // Get all menu items
            const menuItems = document.querySelectorAll('.nav-item a');

            // Add click event listener to each menu item
            menuItems.forEach(function (item) {
                item.addEventListener('click', function (e) {
                    e.preventDefault();
                    const productType = this.getAttribute('data-type');
                    fetchProducts(productType);

                    // Update active state of menu items
                    menuItems.forEach(function (menuItem) {
                        menuItem.classList.remove('active');
                    });
                    this.classList.add('active');
                });
            });

            // Add event listener for the "All Products" button
            const allProductsBtn = document.getElementById('all-products-btn');
            allProductsBtn.addEventListener('click', function () {
                fetchProducts('');

                // Update active state of menu items
                menuItems.forEach(function (menuItem) {
                    menuItem.classList.remove('active');
                });
            });

            // Add event listener for the filter dropdown
            const sortSelect = document.getElementById('sort');
            sortSelect.addEventListener('change', function () {
                const productType = document.querySelector('.nav-item a.active')?.getAttribute('data-type') || '';
                const sortOrder = sortSelect.value;
                fetchProducts(productType, sortOrder);
            });

            // Add event listener for the search form
            const searchForm = document.getElementById('search-form');
            searchForm.addEventListener('submit', function (e) {
                e.preventDefault();
                const searchQuery = document.getElementById('search-input').value;
                fetchProducts('', 'default', searchQuery);
            });



            // Function to fetch products based on the product type, sort order, and search query
            function fetchProducts(type = '', sort = 'default', search = '') {
                fetch(`fetch_products.php?type=${type}&sort=${sort}&search=${search}`)
                    .then(response => response.text())
                    .then(data => {
                        document.getElementById('product-container').innerHTML = data;
                    })
                    .catch(error => console.error('Error:', error));
            }


        });
    </script>

    <script>
        window.onload = function () {
            const urlParams = new URLSearchParams(window.location.search);
            if (urlParams.has('alert')) {
                if (urlParams.get('alert') === 'cart_full') {
                    alert('Your cart is full. You can only add up to 20 items.');
                    window.location.href = "http://localhost/CommunityHarvest/Execution/PHP/Customer/homepage.php";
                }
                else if (urlParams.get('alert') === 'out_of_stock') {
                    alert('Product Out of Stock');
                    window.location.href = "http://localhost/CommunityHarvest/Execution/PHP/Customer/homepage.php";
                }
            }

        }
    </script>

    <?php
    include "footer.php";
    ?>

</body>

</html>