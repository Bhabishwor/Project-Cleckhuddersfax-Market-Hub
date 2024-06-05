<?php
session_start();
include "../connection/connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productId = $_POST['product_id'];
    $customerId = $_SESSION['id'];

    $query = "DELETE FROM cart WHERE PRODUCT_ID = :productId AND CUSTOMER_ID = :customerId";
    $stmt = oci_parse($conn, $query);
    oci_bind_by_name($stmt, ":productId", $productId);
    oci_bind_by_name($stmt, ":customerId", $customerId);
    oci_execute($stmt);

       // Delete the item from the session cart
    if (isset($_SESSION['cart'][$productId])) {
        unset($_SESSION['cart'][$productId]);
    }
}
?>