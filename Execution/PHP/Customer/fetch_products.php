<?php
// Include the database connection
include "../connection/connection.php";

// Get the product type, sort order, and search term from the query parameters
$productType = isset($_GET['type']) ? $_GET['type'] : '';
$sortOrder = isset($_GET['sort']) ? $_GET['sort'] : 'default';
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Prepare the SQL statement to fetch products based on the product type, sort order, and search term
$sql = "SELECT * FROM PRODUCT WHERE 1=1";

if ($productType) {
    $sql .= " AND PRODUCT_TYPE = :product_type";
}

if ($searchTerm) {
    $sql .= " AND LOWER(PRODUCT_NAME) LIKE '%' || LOWER(:search_term) || '%'";
}

// Append sorting logic
switch ($sortOrder) {
    case 'price_asc':
        $sql .= " ORDER BY PRODUCT_PRICE ASC";
        break;
    case 'price_desc':
        $sql .= " ORDER BY PRODUCT_PRICE DESC";
        break;
    case 'name_asc':
        $sql .= " ORDER BY PRODUCT_NAME ASC";
        break;
    case 'name_desc':
        $sql .= " ORDER BY PRODUCT_NAME DESC";
        break;
    default:
        // Default sorting logic if any, or no sorting
        break;
}

$stmt_products = oci_parse($conn, $sql);

if ($productType) {
    oci_bind_by_name($stmt_products, ':product_type', $productType);
}

if ($searchTerm) {
    oci_bind_by_name($stmt_products, ':search_term', $searchTerm);
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