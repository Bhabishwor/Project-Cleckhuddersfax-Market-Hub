<?php
include "../connection/connection.php";

// Sanitize the product ID
function sanitize($input) {
    return htmlspecialchars($input);
}

$product_id = isset($_GET['product_id']) ? sanitize($_GET['product_id']) : 0;

if ($product_id) {
    // Delete product query
    $sql = "DELETE FROM PRODUCT WHERE PRODUCT_ID = :product_id";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ":product_id", $product_id);

    if (oci_execute($stmt)) {
        echo "Product deleted successfully.";
        header("Location: trader_shop.php");
    } else {
        $e = oci_error($stmt);
        echo "Error: " . $e['message'];
    }

    oci_free_statement($stmt);
} else {
    echo "Invalid product ID.";
}

oci_close($conn);
?>