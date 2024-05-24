<?php
// Include the database connection
include "../connection/connection.php";

// Get the product type, sort order, and search term from the query parameters
$productType = isset($_GET['type']) ? $_GET['type'] : '';
$sortOrder = isset($_GET['sort']) ? $_GET['sort'] : 'default';
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Prepare the SQL statement to fetch products based on the product type, sort order, and search term
$sql = "SELECT P.PRODUCT_ID, P.PRODUCT_NAME, P.PRODUCT_PRICE, P.PRODUCT_IMAGE_PATH, T.TRADER_NAME, AVG(R.RATING) AS AVG_RATING
        FROM PRODUCT P 
        JOIN TRADER T ON P.TRADER_ID = T.TRADER_ID 
        LEFT JOIN REVIEWS R ON P.PRODUCT_ID = R.PRODUCT_ID";

$sql .= " WHERE 1=1";

if ($productType) {
    $sql .= " AND P.PRODUCT_TYPE = :product_type";
}

if ($searchTerm) {
    $sql .= " AND (LOWER(P.PRODUCT_NAME) LIKE '%' || LOWER(:search_term) || '%' 
                   OR LOWER(T.TRADER_NAME) LIKE '%' || LOWER(:search_term) || '%')";
}

// Append grouping and sorting logic
$sql .= " GROUP BY P.PRODUCT_ID, P.PRODUCT_NAME, P.PRODUCT_PRICE, P.PRODUCT_IMAGE_PATH, T.TRADER_NAME";

switch ($sortOrder) {
    case 'price_asc':
        $sql .= " ORDER BY P.PRODUCT_PRICE ASC";
        break;
    case 'price_desc':
        $sql .= " ORDER BY P.PRODUCT_PRICE DESC";
        break;
    case 'name_asc':
        $sql .= " ORDER BY P.PRODUCT_NAME ASC";
        break;
    case 'name_desc':
        $sql .= " ORDER BY P.PRODUCT_NAME DESC";
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
    $output .= "<div class='col-md-4 mb-4'>";
    $output .= "<div class='card text-center'>";
    $output .= "<div class='card-img-container'>";
    $output .= "<a href='product_detail.php?id=" . htmlspecialchars($row_product['PRODUCT_ID']) . "'>";
    $output .= "<img src='" . htmlspecialchars($row_product['PRODUCT_IMAGE_PATH']) . "' class='card-img-top' alt='Product Image'>";
    $output .= "</a>";
    $output .= "</div>";
    $output .= "<div class='card-body' data-rating='" . htmlspecialchars($row_product['AVG_RATING']) . "'>";
    $output .= "<h5 class='card-title'>" . htmlspecialchars($row_product['PRODUCT_NAME']) . "</h5>";
    $output .= "<p class='card-text'>Trader: " . htmlspecialchars($row_product['TRADER_NAME']) . "</p>";
    $output .= "<p class='card-text'>Price: $" . number_format($row_product['PRODUCT_PRICE'], 2) . "</p>";
    $output .= "<p class='card-text'>Average Rating: ";
    $output .= "<span>";
    $output .= displayStars($row_product['AVG_RATING']);
    $output .= "</span>";
    $output .= "</p>";
    $output .= "<div class='d-flex justify-content-between'>";
    $output .= "<button type='submit' class='btn btn-primary' name='cartBtn'><i class='fa-solid fa-cart-shopping' style='color: white;'></i></button>";
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

// Function to display stars based on the rating
function displayStars($rating) {
    $starContainer = "<div class='star-rating'>";
    for ($i = 1; $i <= 5; $i++) {
        if ($i <= $rating) {
            $starContainer .= "<i class='fas fa-star' style='color: gold;'></i>";
        } else {
            $starContainer .= "<i class='far fa-star'></i>";
        }
    }
    $starContainer .= "</div>";
    return $starContainer;
}
?>