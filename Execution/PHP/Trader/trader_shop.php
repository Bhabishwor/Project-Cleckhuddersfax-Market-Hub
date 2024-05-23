<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Trader Shop</title>
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
    /* Additional Custom Styles */
    .main-content {
      padding-left: 270px;
      /* Adjusted to accommodate the sidebar */
    }
  </style>
</head>

<body>
  <!-- Trader Navigation Pane -->
  <?php
  include "../connection/connection.php";
  include "trader_navigation_pane.php"; 

  
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


  <!-- Main Content -->
  <div class="main-content">
    <h1 class="product-heading" style="margin-top: 2em; margin-right: 5em; text-align: center;">
      <i class="fas fa-box-open"></i> YOUR PRODUCTS
    </h1>
    <!-- Add Product Button -->
    <div class="container-fluid" style="margin-left: 7em;">
      <div class="row">
        <div class="col-lg-9 col-md-8 text-center">
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



  <script>
    // Function to handle delete confirmation

    function confirmDelete(productId) {
      // Show the modal
      $('#deleteProductModal' + productId).modal('show');

      // When user confirms deletion
      $('#confirmDeleteBtn' + productId).click(function () {
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

</html>