<<<<<<< HEAD
<?php
include "../connection/connection.php";
session_start(); // Start the session

// Check if the 'name' and 'email' session variables are set and display them
$name = isset($_SESSION['name']) ? $_SESSION['name'] : ''; // Added this line to define $name
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
$traderId = isset($_SESSION['traderId']) ? $_SESSION['traderId'] : '';


if (!isset($_SESSION['email'])) {
    echo "Email not set in session.";
    exit();
}

$email = $_SESSION['email']; // Retrieve email from session

// Fetch traderId using the email
$sql = "SELECT TRADER_ID FROM TRADER WHERE TRADER_EMAIL = :email";
$stmt = oci_parse($conn, $sql);
oci_bind_by_name($stmt, ":email", $email);
oci_execute($stmt);

$row = oci_fetch_assoc($stmt);
if (!$row) {
    echo "Trader not found.";
    exit();
}

$traderId = $row['TRADER_ID'];

// Fetch products for the trader
$sql_products = "SELECT * FROM PRODUCT WHERE TRADER_ID = :traderId";
$stmt_products = oci_parse($conn, $sql_products);
oci_bind_by_name($stmt_products, ":traderId", $traderId);
oci_execute($stmt_products);
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin navigation pane</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome CSS -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <!-- Your custom CSS -->
  <link rel="stylesheet" href="traders_shop.css">
  <!-- jQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <!-- Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
  <style>
    /* Sidebar CSS */
    .sidebar {
      position: fixed;
      top: 0;
      left: 0;
      height: 100%;
      width: 250px;
      color: #fff;
      padding-top: 20px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      transition: transform 0.3s ease-in-out; /* Added transition effect */
      transform: translateX(0); /* Keep sidebar open by default */
      z-index: 999; /* Set higher z-index */
      background-image: url('../../Image/container.png');
      background-size: cover; /* Cover the entire sidebar */
      background-repeat: no-repeat; /* Do not repeat the image */
      font-size: 1.5em;
    }

    .sidebar-logo {
      text-align: center;
      margin-bottom: 30px; /* Increased margin-bottom */
    }

    .nav-link {
      padding: 10px;
      display: block;
      color: #fff;
      text-decoration: none;
    }

    .nav-link i {
      margin-right: 10px; /* Add margin between icon and text */
    }

    .nav-link:hover {
      background-color: #555;
    }

    .submenu {
      display: none;
    }

    .nav-item:hover .submenu {
      display: block;
    }

    .username-box {
      background-color: #fff;
      padding: 10px;
      border-radius: 5px;
      color: #000;
      font-size: 14px;
      width: 200px;
      text-align: center;
      cursor: pointer;
      margin: 0 auto 20px;
    }

    /* Hamburger Icon CSS */
    .hamburger {
      display: none; /* Hide hamburger icon by default */
    }

    @media (max-width: 768px) {
      .sidebar {
        width: 250px;
        transform: translateX(-250px); /* Initially hide sidebar on small screens */
      }

      .sidebar.open {
        transform: translateX(0); /* Show sidebar when open class is added */
      }

      .hamburger {
        display: block; /* Show hamburger icon on small screens */
        position: fixed;
        top: 10px;
        left: 10px;
        z-index: 1000; /* Ensure it's above other content */
        background-color: #fff; /* Button background color */
        border: none;
        padding: 10px;
        border-radius: 5px;
        cursor: pointer;
      }

      .hamburger:hover {
        background-color: #ccc;
      }

      .main-content {
        padding-left: 20px; /* Adjust padding to make space for hamburger icon */
      }
    }
  </style>
</head>
<body>
  <!-- Hamburger Icon -->
  <div class="hamburger d-lg-none" onclick="toggleSidebar()">
    &#9776; <!-- Hamburger icon -->
  </div>

  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar -->
      <div class="col-lg-3 col-md-4">
        <div class="sidebar" id="sidebar">
          <div>
            <div class="sidebar-logo">
              <img src="../../Image/logo.png" alt="Logo" style="width: 150px;">
            </div>
            <ul class="nav flex-column">
              <!-- Additional Links -->
              <li class="nav-item">
                <a class="nav-link" href="#"><i class="fas fa-user"></i> Profile</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#"><i class="fas fa-shopping-cart"></i> Order</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#"><i class="fas fa-store"></i> Shop</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#"><i class="fas fa-chart-bar"></i> Reports</a>
                <ul class="submenu">
                  <li><a class="nav-link" href="#"><i class="fas fa-calendar-day"></i> Daily</a></li>
                  <li><a class="nav-link" href="#"><i class="fas fa-calendar-week"></i> Weekly</a></li>
                  <li><a class="nav-link" href="#"><i class="fas fa-calendar-alt"></i> Monthly</a></li>
                </ul>
              </li>
            </ul>
          </div>
          <div class="username-box">
            <?php
            echo "<p>" . $name . "</p>";
            echo "<p>" . $email . "</p>";
            ?>
            <form action="../logout.php" method="post">
              <button class="btn btn-outline-success logoutBtn" type="submit">
                <i class="fa-solid fa-right-from-bracket"></i>
                Logout
              </button>
            </form>

          </div>
        </div>
      </div>
      <!-- Main Content -->
      <div class="col-lg-9 col-md-8">
        <h1 class="product-heading" style="margin-top: 2em; margin-right: 5em; text-align: center;">
          <!-- Combined inline styles -->
          <i class="fas fa-box-open"></i> YOUR PRODUCTS
        </h1>
        <!-- Add Product Button -->
        <div class="container-fluid" style="margin-left: 7em;">
          <div class="row">
            <div class="col-lg-9 col-md-8 text-center"> <!-- Added text-center class -->
              <button class="btn btn-primary mt-3 mb-3" onclick="location.href='add_product.php'">
                <i class="fas fa-plus-circle"></i> Add Product
              </button>
            </div>
          </div>
        </div>

        <div class="row" style="margin-right: 3em;">
    <?php
    // Display product data
    while ($row_product = oci_fetch_assoc($stmt_products)) {
        echo "<div class='col-md-4 mb-4'>";
        echo "<div class='card'>";
        echo "<div class='card-img-container'>";
        echo "<img src='" . $row_product['PRODUCT_IMAGE_PATH'] . "' class='card-img-top' alt='Product Image'>";
        echo "</div>";
        echo "<div class='card-body'>";
        echo "<h5 class='card-title'>" . $row_product['PRODUCT_NAME'] . "</h5>";
        echo "<div class='card-text'>";
        echo "<p><strong>Type:</strong> " . $row_product['PRODUCT_TYPE'] . "</p>";
        echo "<p><strong>Price:</strong> $" . number_format($row_product['PRODUCT_PRICE'], 2) . "</p>";
        echo "<p><strong>Stock:</strong> " . $row_product['STOCK'] . "</p>";
        echo "<p><strong>Allergy Information:</strong> " . $row_product['ALLERGY_INFORMATION'] . "</p>";
        echo "</div>"; // Closing card-text div
        // Buttons for each product
        echo "<div class='card-buttons mt-3 d-flex justify-content-between'>";
        echo "<a href='edit_product.php?product_id=" . $row_product['PRODUCT_ID'] . "' class='btn btn-primary btn-sm'>Edit</a>";
        echo "<button class='btn btn-danger btn-sm' onclick='confirmDelete(" . $row_product['PRODUCT_ID'] . ")'>Delete</button>";

        //echo "<button class='btn btn-danger btn-sm' data-toggle='modal' data-target='#deleteProductModal" . $row['PRODUCT_ID'] . "'>Delete</button>";
        echo "</div>";
        echo "</div>"; // Closing card-body div
        echo "</div>"; // Closing card div
        echo "</div>"; // Closing col-md-4 div

        // Delete Product Modal for each product
        echo "<div class='modal fade' id='deleteProductModal" . $row_product['PRODUCT_ID'] . "' tabindex='-1' role='dialog' aria-labelledby='deleteProductModalLabel" . $row_product['PRODUCT_ID'] . "' aria-hidden='true'>";
        echo "<div class='modal-dialog' role='document'>";
        echo "<div class='modal-content'>";
        echo "<div class='modal-header'>";
        echo "<h5 class='modal-title' id='deleteProductModalLabel" . $row_product['PRODUCT_ID'] . "'>Delete Product</h5>";
        echo "<button type='button' class='close' data-dismiss='modal' aria-label='Close'>";
        echo "<span aria-hidden='true'>&times;</span>";
        echo "</button>";
        echo "</div>";
        echo "<div class='modal-body'>";
        echo "Are you sure you want to delete this product?";
        echo "</div>";
        echo "<div class='modal-footer'>";
        echo "<button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>";
        echo "<a href='delete.php?product_id=" . $row_product['PRODUCT_ID'] . "' class='btn btn-danger'>Delete</a>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }
    ?>
</div>

      </div>
    </div>
  </div>

  <script>
    // Function to handle delete confirmation
    function confirmDelete(productId) {
      // Show the modal
      $('#deleteProductModal' + productId).modal('show');

      // When user confirms deletion
      $('#confirmDeleteBtn' + productId).click(function() {
        // Redirect to delete script
        window.location.href = 'delete.php?product_id=' + productId;
        // Redirect to traders_shop.php after deletion
        window.location.href = 'trader_shop.php';
      });
    }

    function toggleSidebar() {
      document.getElementById('sidebar').classList.toggle('open');
    }
  </script>
  <!-- Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
=======
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Shop</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="./css/styles.css">
</head>

<body>
  <div class="container py-5">
    <h5>Shop</h5>
    <div class="wrapper">
      <div class="row row1 mb-5">
        <div class="col-3 col1">
          <div class="box">
            <div class="img"><img src="./img/shop.png" alt="" width="100%" height="100px"></div>
            <div class="content">
              <div class="row">
                <div class="col-9">
                  <p class="ps-2">Shop Name</p>
                </div>
                <div class="col">
                  <div class="dropdown"><i class="bi bi-three-dots-vertical pe-1" data-bs-toggle="dropdown"
                      aria-expanded="false"></i>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="#">Action</a></li>
                      <li><a class="dropdown-item" href="#">Another action</a></li>
                      <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-3 col1">
          <div class="box">
            <div class="img"><img src="./img/shop.png" alt="" width="100%" height="100px"></div>
            <div class="content">
              <div class="row">
                <div class="col-9">
                  <p class="ps-2">Shop Name</p>
                </div>
                <div class="col">
                  <div class="dropdown"><i class="bi bi-three-dots-vertical pe-1" data-bs-toggle="dropdown"
                      aria-expanded="false"></i>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="#">Action</a></li>
                      <li><a class="dropdown-item" href="#">Another action</a></li>
                      <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-3 col1">
          <div class="box">
            <div class="img"><img src="./img/shop.png" alt="" width="100%" height="100px"></div>
            <div class="content">
              <div class="row">
                <div class="col-9">
                  <p class="ps-2">Shop Name</p>
                </div>
                <div class="col">
                  <div class="dropdown"><i class="bi bi-three-dots-vertical pe-1" data-bs-toggle="dropdown"
                      aria-expanded="false"></i>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="#">Action</a></li>
                      <li><a class="dropdown-item" href="#">Another action</a></li>
                      <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-3 col1">
          <div class="box">
            <div class="img"><img src="./img/shop.png" alt="" width="100%" height="100px"></div>
            <div class="content">
              <div class="row">
                <div class="col-9">
                  <p class="ps-2">Shop Name</p>
                </div>
                <div class="col">
                  <div class="dropdown"><i class="bi bi-three-dots-vertical pe-1" data-bs-toggle="dropdown"
                      aria-expanded="false"></i>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="#">Action</a></li>
                      <li><a class="dropdown-item" href="#">Another action</a></li>
                      <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="row row1 mb-5">
        <div class="col-3 col1">
          <div class="box">
            <div class="img"><img src="./img/shop.png" alt="" width="100%" height="100px"></div>
            <div class="content">
              <div class="row">
                <div class="col-9">
                  <p class="ps-2">Shop Name</p>
                </div>
                <div class="col">
                  <div class="dropdown"><i class="bi bi-three-dots-vertical pe-1" data-bs-toggle="dropdown"
                      aria-expanded="false"></i>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="#">Action</a></li>
                      <li><a class="dropdown-item" href="#">Another action</a></li>
                      <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-3 col1">
          <div class="box">
            <div class="img"><img src="./img/shop.png" alt="" width="100%" height="100px"></div>
            <div class="content">
              <div class="row">
                <div class="col-9">
                  <p class="ps-2">Shop Name</p>
                </div>
                <div class="col">
                  <div class="dropdown"><i class="bi bi-three-dots-vertical pe-1" data-bs-toggle="dropdown"
                      aria-expanded="false"></i>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="#">Action</a></li>
                      <li><a class="dropdown-item" href="#">Another action</a></li>
                      <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-3 col1">
          <div class="box">
            <div class="img"><img src="./img/shop.png" alt="" width="100%" height="100px"></div>
            <div class="content">
              <div class="row">
                <div class="col-9">
                  <p class="ps-2">Shop Name</p>
                </div>
                <div class="col">
                  <div class="dropdown"><i class="bi bi-three-dots-vertical pe-1" data-bs-toggle="dropdown"
                      aria-expanded="false"></i>
                    <ul class="dropdown-menu">
                      <li><a class="dropdown-item" href="#">Action</a></li>
                      <li><a class="dropdown-item" href="#">Another action</a></li>
                      <li><a class="dropdown-item" href="#">Something else here</a></li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-3 col1">
          <div class="box add">
            <h1>
              <a href="">
                <i class="bi bi-plus-lg"></i>
              </a>
            </h1>
          </div>
        </div>
      </div>
      


    </div>

  </div>


  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</body>

>>>>>>> 2aa11a6dba8d890de006e0342f4380fd5c2bf119
</html>