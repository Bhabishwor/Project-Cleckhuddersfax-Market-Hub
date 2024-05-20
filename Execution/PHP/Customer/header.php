<?php
session_start(); // Start the session at the beginning of the script
include "../connection/connection.php";
// Check if the 'name' session variable is set and display it
$name = isset($_SESSION['name']) ? $_SESSION['name'] : 'LOGIN';

$currentPage = basename($_SERVER['SCRIPT_FILENAME'], ".php");

if (!isset($_SESSION['cart'])) {
  $_SESSION['cart'] = [];

}

// $name = "";
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <link rel="stylesheet" href="../../CSS/header.css">

  <style>
    .button-icon-only {
      background: none;
      /* Remove background */
      border: none;
      /* Remove border */
      padding: 0;
      /* Remove padding */
      margin: 0 0.5rem;
    }

    .link-decoration {
      text-decoration: none;
    }

    .small-cart-badge {
      width: 16px;
      /* Adjust width and height as desired */
      height: 16px;
      font-size: 10px;
      /* Adjust font size as desired */
    }
  </style>
</head>

<body>
  <header>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark custom-navbar">
      <div class="container-fluid">
        <a class="navbar-brand logo" href="#">
          <img src="../../Image/Logo.png" alt="Logo" height="60" width="62">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo02"
          aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0 custom-nav-links">
            <li class="nav-item <?php echo ($currentPage == "homepage") ? 'active' : ''; ?>">
              <a class="nav-link" href="homepage.php">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Shop</a>
            </li>
            <li class="nav-item <?php echo ($currentPage == "about_us") ? 'active' : ''; ?>">
              <a class="nav-link roleBasedRedirect" href="about_us.php">About Us</a>
            </li>
            <li class="nav-item <?php echo ($currentPage == "contact_us") ? 'active' : ''; ?>">
              <a class="nav-link roleBasedRedirect" href="contact_us.php">Contact Us</a>
            </li>
          </ul>

          <div class="login_register">
            <div class="container-fluid search_bar">
              <form class="d-flex" role="search">
                <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success" type="submit">Search</button>
              </form>
            </div>

            <div class="dropdown">
              <!-- Dropdown toggle button -->
              <?php
              if ($name != "LOGIN") {
                echo "<button class='btn login button-icon-only dropdown-toggle' type='button' id='dropdownMenuButton'
                 data-bs-toggle='dropdown' aria-expanded='false'>
                <i class='fa-regular fa-user mx-1' style='color: white;'></i>";

                echo "<span class='user' style='color : white;'>" . $name . "</span>";

                echo "</button>";

                $cart = array();
                $query = "SELECT PRODUCT_ID, QUANTITY FROM CART WHERE CUSTOMER_ID = :customerId";
                $stmt = oci_parse($conn, $query);
                oci_bind_by_name($stmt, ":customerId", $_SESSION['id']);

                if (oci_execute($stmt)) {
                  while ($row = oci_fetch_assoc($stmt)) {

                    $cart[$row['PRODUCT_ID']] = $row['QUANTITY'];
                  }
                }

                $_SESSION['cart'] = $cart;
              } else {
                echo "<a class='link-decoration' href='../login.php'>";
                echo "<button class='login button-icon-only' type='button'>
               <i class='fa-regular fa-user mx-1' style='color: white;'></i>";
                echo "<span class='user' style='color : white;'>" . $name . "</span>";
                echo "</button>";
                echo "</a>";
              }
              ?>


              <!-- Dropdown menu -->
              <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                <li><a class="dropdown-item" href="user_profile.php">User Profile</a></li>
                <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
              </ul>
            </div>
              <button class="login button-icon-only position-relative" id="cartButton">
                <i class="fa-solid fa-cart-shopping" style="color: white;"></i>
                <span
                  class="position-absolute top-0 start-100 translate-middle bg-danger border border-light rounded-circle small-cart-badge">
                  <?php echo count($_SESSION['cart']); ?>
                </span>
              </button>



            <button class="login button-icon-only">
              <i class="fa-regular fa-heart" style="color: white;"></i>
            </button>
          </div>
        </div>
      </div>
    </nav>
  </header>

  <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>

  <script>
    const cartButton = document.getElementById('cartButton');
    cartButton.addEventListener('click', function () {
      window.location.href = 'cart.php';
    });
  </script>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
  </script>
</body>

</html>
