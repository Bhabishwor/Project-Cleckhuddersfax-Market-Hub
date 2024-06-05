<?php
session_start();
include "../connection/connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $customerId = $_SESSION['id'];

    $stock_query = "SELECT STOCK FROM product WHERE PRODUCT_ID = :productId";
    $stock_stmt = oci_parse($conn, $stock_query);
    oci_bind_by_name($stock_stmt, ":productId", $productId);
    oci_execute($stock_stmt); // Fix: Execute $stock_stmt instead of $stmt

    // Fetch the stock value
    $stock_row = oci_fetch_assoc($stock_stmt);
    $stock = $stock_row['STOCK'];

    // Check if quantity is more than the available stock
    if ($quantity > $stock) {
        echo "exceeds";
        exit; // Stop further execution
    }

    $query = "UPDATE cart SET QUANTITY = :quantity WHERE PRODUCT_ID = :productId AND CUSTOMER_ID = :customerId";
    $stmt = oci_parse($conn, $query);
    oci_bind_by_name($stmt, ":quantity", $quantity);
    oci_bind_by_name($stmt, ":productId", $productId);
    oci_bind_by_name($stmt, ":customerId", $customerId);
    oci_execute($stmt);
    echo "success";
}
?>
