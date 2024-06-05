<?php
include "../connection/connection.php";
session_start(); // Start the session

if (!isset($_SESSION['email'])) {
    echo "Email not set in session.";
    exit();
}

$email = $_SESSION['email']; // Retrieve email from session

// Fetch traderId and traderShop (product type) using the email
$sql = "SELECT USER_ID, USER_SHOP FROM users WHERE USER_EMAIL = :email";
$stmt = oci_parse($conn, $sql);
oci_bind_by_name($stmt, ":email", $email);
oci_execute($stmt);

$row = oci_fetch_assoc($stmt);
if (!$row) {
    echo "Trader not found.";
    exit();
}

$traderId = $row['USER_ID'];
$_SESSION['traderShop'] = $row['USER_SHOP']; // Store the trader shop (product type) in session

// Define the sanitize function
function sanitize($input) {
    return htmlspecialchars($input);
}

// Get product ID from URL
$product_id = isset($_GET['product_id']) ? sanitize($_GET['product_id']) : 0;

// Fetch product data
$product = null;
if ($product_id) {
    $sql = "SELECT * FROM PRODUCT WHERE PRODUCT_ID = :product_id";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ":product_id", $product_id);
    oci_execute($stmt);
    $product = oci_fetch_assoc($stmt);
    oci_free_statement($stmt);
}

// Update Product
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize form inputs
    $productName = sanitize($_POST['productName']);
    $productType = $_SESSION['traderShop']; // Use the trader's registered shop type
    $productPrice = sanitize($_POST['productPrice']);
    $stock = sanitize($_POST['stock']);
    $allergyInformation = sanitize($_POST['allergyInformation']);

    // Check if file is selected
    if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] === UPLOAD_ERR_OK) {
        $uploadDirectory = "../../Uploaded_Image/Product/";
        $fileName = uniqid() . '_' . basename($_FILES["productImage"]["name"]);
        $targetFilePath = $uploadDirectory . $fileName;
        $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
        $validExtensions = array("jpg", "jpeg", "png", "gif");
        if (in_array($imageFileType, $validExtensions)) {
            if (move_uploaded_file($_FILES["productImage"]["tmp_name"], $targetFilePath)) {
                // Update product data with image
                $updateSql = "UPDATE PRODUCT SET PRODUCT_NAME = :productName, PRODUCT_TYPE = :productType, PRODUCT_PRICE = :productPrice, STOCK = :stock, ALLERGY_INFORMATION = :allergyInformation, PRODUCT_IMAGE_PATH = :productImagePath WHERE PRODUCT_ID = :product_id";
                $updateStmt = oci_parse($conn, $updateSql);
                oci_bind_by_name($updateStmt, ":productName", $productName);
                oci_bind_by_name($updateStmt, ":productType", $productType);
                oci_bind_by_name($updateStmt, ":productPrice", $productPrice);
                oci_bind_by_name($updateStmt, ":stock", $stock);
                oci_bind_by_name($updateStmt, ":allergyInformation", $allergyInformation);
                oci_bind_by_name($updateStmt, ":productImagePath", $targetFilePath);
                oci_bind_by_name($updateStmt, ":product_id", $product_id);

                if (oci_execute($updateStmt)) {
                    oci_free_statement($updateStmt);
                    oci_close($conn);
                    echo "Product updated successfully";
                    header("Location: trader_shop.php");
                    exit();
                } else {
                    $e = oci_error($updateStmt);
                    echo "Error: " . $e['message'];
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "Invalid file type.";
        }
    } else {
        // Update product data without image
        $updateSql = "UPDATE PRODUCT SET PRODUCT_NAME = :productName, PRODUCT_TYPE = :productType, PRODUCT_PRICE = :productPrice, STOCK = :stock, ALLERGY_INFORMATION = :allergyInformation WHERE PRODUCT_ID = :product_id";
        $updateStmt = oci_parse($conn, $updateSql);
        oci_bind_by_name($updateStmt, ":productName", $productName);
        oci_bind_by_name($updateStmt, ":productType", $productType);
        oci_bind_by_name($updateStmt, ":productPrice", $productPrice);
        oci_bind_by_name($updateStmt, ":stock", $stock);
        oci_bind_by_name($updateStmt, ":allergyInformation", $allergyInformation);
        oci_bind_by_name($updateStmt, ":product_id", $product_id);

        if (oci_execute($updateStmt)) {
            oci_free_statement($updateStmt);
            oci_close($conn);
            echo "Product updated successfully";
            header("Location: trader_shop.php");
            exit();
        } else {
            $e = oci_error($updateStmt);
            echo "Error: " . $e['message'];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Product</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <style>
    /* Style for body with Background Image */
    body {
        background-image: url('../../Image/heritage/navigation_pane.png');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        height: 100vh; /* Set body height to full viewport height */
        margin: 10rem 0 0 10rem; /* Remove default margin */
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* Style for Edit Product Form */
    #productForm {
        width: 80%; /* Adjust width of the form */
        max-width: 400px; /* Set maximum width of the form */
        padding: 30px; /* Add padding to the form */
        background-color: rgba(255, 255, 255, 0.9); /* Set form background color to semi-transparent white */
        border-radius: 10px; /* Add border-radius for rounded corners */
        box-shadow: 0px 0px 20px 0px rgba(0,0,0,0.2); /* Add box shadow for depth */
    }

    #productForm .mb-3 {
        margin-bottom: 20px;
    }

    #productForm label {
        font-weight: bold;
    }

    /* Style for Edit Product Button */
    #updateProductBtn {
        margin-top: 20px; /* Add margin to the bottom of the form */
    }
  </style>
</head>
<body>
  <!-- Edit Product Form -->
  <div class="container" style="margin-left: 30em;">
    <h1>Edit Product</h1>
    <?php if ($product): ?>
    <form id="productForm" method="post" enctype="multipart/form-data" action="">
      <div class="mb-3">
        <label for="productName" class="form-label">Product Name</label>
        <input type="text" class="form-control" id="productName" name="productName" value="<?php echo $product['PRODUCT_NAME']; ?>" required>
      </div>
      <div class="mb-3">
        <label for="productType" class="form-label">Product Type</label>
        <input type="text" class="form-control" id="productType" name="productType" value="<?php echo $_SESSION['traderShop']; ?>" readonly>
      </div>
      <div class="mb-3">
        <label for="productPrice" class="form-label">Product Price</label>
        <input type="number" class="form-control" id="productPrice" name="productPrice" value="<?php echo $product['PRODUCT_PRICE']; ?>" step="0.01" required>
      </div>
      <div class="mb-3">
        <label for="stock" class="form-label">Stock</label>
        <input type="number" class="form-control" id="stock" name="stock" value="<?php echo $product['STOCK']; ?>" required>
      </div>
      <div class="mb-3">
    <label for="allergyInformation" class="form-label">Product Description/Allergy Information</label>
    <textarea class="form-control" id="allergyInformation" name="allergyInformation" rows="4"><?php echo $product['ALLERGY_INFORMATION']; ?></textarea>
</div>

      <div class="mb-3">
        <label for="productImage" class="form-label">Product Image</label>
        <?php if (!empty($product['PRODUCT_IMAGE_PATH'])): ?>
            <img src="<?php echo $product['PRODUCT_IMAGE_PATH']; ?>" alt="Product Image" class="img-fluid mb-3">
        <?php endif; ?>
        <input type="file" class="form-control" id="productImage" name="productImage" accept="image/*">
      </div>
      <button type="submit" class="btn btn-primary" id="updateProductBtn">Update Product</button>
    </form>
    <?php else: ?>
        <p>Product not found.</p>
    <?php endif; ?>
  </div>
  
  <!-- Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>