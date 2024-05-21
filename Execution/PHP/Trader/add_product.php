<?php
include "../connection/connection.php";
session_start(); // Start the session

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

// Add Product
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productName = htmlspecialchars($_POST['productName']);
    $productType = htmlspecialchars($_POST['productType']);
    $productPrice = htmlspecialchars($_POST['productPrice']);
    $stock = htmlspecialchars($_POST['stock']);
    $allergyInformation = htmlspecialchars($_POST['allergyInformation']);

    // Check if file is selected
    if (isset($_FILES['productImage']) && $_FILES['productImage']['error'] === UPLOAD_ERR_OK) {
        $uploadDirectory = "../../Uploaded_Image/Product/";
        $fileName = uniqid() . '_' . basename($_FILES["productImage"]["name"]);
        $targetFilePath = $uploadDirectory . $fileName;
        $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
        $validExtensions = array("jpg", "jpeg", "png", "gif");
        if (in_array($imageFileType, $validExtensions)) {
            if (move_uploaded_file($_FILES["productImage"]["tmp_name"], $targetFilePath)) {
                $insertSql = "INSERT INTO PRODUCT (PRODUCT_NAME, PRODUCT_TYPE, PRODUCT_PRICE, STOCK, ALLERGY_INFORMATION, PRODUCT_IMAGE_PATH, TRADER_ID) 
                              VALUES (:productName, :productType, :productPrice, :stock, :allergyInformation, :productImagePath, :traderId)";
                $insertStmt = oci_parse($conn, $insertSql);
                oci_bind_by_name($insertStmt, ":productName", $productName);
                oci_bind_by_name($insertStmt, ":productType", $productType);
                oci_bind_by_name($insertStmt, ":productPrice", $productPrice);
                oci_bind_by_name($insertStmt, ":stock", $stock);
                oci_bind_by_name($insertStmt, ":allergyInformation", $allergyInformation);
                oci_bind_by_name($insertStmt, ":productImagePath", $targetFilePath);
                oci_bind_by_name($insertStmt, ":traderId", $traderId);

                if (oci_execute($insertStmt)) {
                    oci_free_statement($insertStmt);
                    oci_close($conn);
                    header("Location: trader_shop.php");
                    exit();
                } else {
                    $e = oci_error($insertStmt);
                    echo "Error: " . $e['message'];
                }

                oci_free_statement($insertStmt);
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        } else {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        }
    } else {
        echo "Please select an image file.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-image: url('../../Image/container.png');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            height: 100vh;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        #productForm {
            width: 80%;
            max-width: 400px;
            padding: 30px;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 10px;
            box-shadow: 0px 0px 20px 0px rgba(0,0,0,0.2);
        }
        #productForm .mb-3 {
            margin-bottom: 20px;
        }
        #productForm label {
            font-weight: bold;
        }
        #addProductBtn {
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Add Product</h1>
        <form id="productForm" method="post" enctype="multipart/form-data" action="add_product.php">
            <div class="mb-3">
                <label for="productName" class="form-label">Product Name</label>
                <input type="text" class="form-control" id="productName" name="productName" required>
            </div>
            <div class="mb-3">
    <label for="productType" class="form-label">Product Type</label>
    <select class="form-select" id="productType" name="productType" required>
        <option value="Butcher">Butcher</option>
        <option value="Greengrocer">Greengrocer</option>
        <option value="Fishmonger">Fishmonger</option>
        <option value="Bakery">Bakery</option>
        <option value="Delicatessen">Delicatessen</option>
    </select>
</div>
            <div class="mb-3">
                <label for="productPrice" class="form-label">Product Price</label>
                <input type="number" class="form-control" id="productPrice" name="productPrice" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="stock" class="form-label">Stock</label>
                <input type="number" class="form-control" id="stock" name="stock" required>
            </div>
            <div class="mb-3">
                <label for="allergyInformation" class="form-label">Allergy Information</label>
                <input type="text" class="form-control" id="allergyInformation" name="allergyInformation">
            </div>
            <div class="mb-3">
                <label for="productImage" class="form-label">Product Image</label>
                <input type="file" class="form-control" id="productImage" name="productImage" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Product</button>
        </form>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>