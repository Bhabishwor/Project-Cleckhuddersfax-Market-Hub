<?php
// Include the database connection
include "../connection/connection.php";

// Get the product type from the query parameter
$productType = isset($_GET['type']) ? $_GET['type'] : '';

// Prepare the SQL statement to fetch products based on the product type
if ($productType) {
    $sql = "SELECT * FROM PRODUCT WHERE PRODUCT_TYPE = :product_type";
    $stmt_products = oci_parse($conn, $sql);
    oci_bind_by_name($stmt_products, ':product_type', $productType);
} else {
    $sql = "SELECT * FROM PRODUCT";
    $stmt_products = oci_parse($conn, $sql);
}
oci_execute($stmt_products);

// Generate the product cards
$output = '';
while ($row_product = oci_fetch_assoc($stmt_products)) {
    $image_path = $row_product['PRODUCT_IMAGE_PATH'];

    // If image URL is empty, use a placeholder image
    if (empty($image_path)) {
        $image_path = 'placeholder.jpg';
    }

    $output .= "<div class='col-md-4 mb-4'>";
    $output .= "<div class='card text-center'>";
    $output .= "<div class='card-img-container'>";
    $output .= "<a href='product_detail.php?id=" . htmlspecialchars($row_product['PRODUCT_ID']) . "'>";
    $output .= "<img src='" . htmlspecialchars($image_path) . "' class='card-img-top' alt='Product Image'>";
    $output .= "</a>";
    $output .= "</div>";
    $output .= "<div class='card-body'>";
    $output .= "<h5 class='card-title'>" . htmlspecialchars($row_product['PRODUCT_NAME']) . "</h5>";
    $output .= "<p class='card-text'>Price: $" . number_format($row_product['PRODUCT_PRICE'], 2) . "</p>";
    $output .= "<div class='d-flex justify-content-between'>";
    $output .= "<form method='get' action='manage_cart.php'>";
    $output .= "<button type='submit' class='btn btn-primary' name='cartBtn'><i class='fa-solid fa-cart-shopping' style='color: white;'></i></button>";
    $output .= "<input type='hidden' name='Product_Name' value='" . htmlspecialchars($row_product['PRODUCT_NAME']) . "'>";
    $output .= "<input type='hidden' name='Product_Price' value='" . htmlspecialchars($row_product['PRODUCT_PRICE']) . "'>";
    $output .= "<input type='hidden' name='Product_Id' value='" . htmlspecialchars($row_product['PRODUCT_ID']) . "'>";
    $output .= "<input type='hidden' name='stock' value='" . htmlspecialchars($row_product['STOCK']) . "'>";
    $output .= "</form>";
    $output .= "<button class='btn btn-outline-dark' data-toggle='tooltip' data-placement='top' title='Add to Wishlist'><i class='far fa-heart'></i></button>";
    $output .= "</div>"; 
    $output .= "</div>"; 
    $output .= "</div>"; 
    $output .= "</div>";
}    

echo $output;

// Free the statement identifier and close the connection
oci_free_statement($stmt_products);
oci_close($conn);
?>
