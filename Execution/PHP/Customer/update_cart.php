<?php
session_start();
include "../connection/connection.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $customerId = $_SESSION['id'];

    $query = "UPDATE cart SET QUANTITY = :quantity WHERE PRODUCT_ID = :productId AND CUSTOMER_ID = :customerId";
    $stmt = oci_parse($conn, $query);
    oci_bind_by_name($stmt, ":quantity", $quantity);
    oci_bind_by_name($stmt, ":productId", $productId);
    oci_bind_by_name($stmt, ":customerId", $customerId);
    oci_execute($stmt);
}
?>
