<?php
include "../connection/connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = isset($_POST['Product_Id']) ? intval($_POST['Product_Id']) : 0;
    $customer_id = 1; // Replace with actual customer ID from session or other source
    $rating = isset($_POST['Rating']) ? intval($_POST['Rating']) : 0;
    $review_description = isset($_POST['Review_Description']) ? trim($_POST['Review_Description']) : '';

    if ($product_id > 0 && $rating > 0 && !empty($review_description)) {
        // Insert the new review
        $sql = "INSERT INTO REVIEWS (CUSTOMER_ID, PRODUCT_ID, RATING, REVIEW_DATE, REVIEW_DESCRIPTION) 
                VALUES (:customer_id, :product_id, :rating, SYSDATE, :review_description)";
        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ':customer_id', $customer_id);
        oci_bind_by_name($stmt, ':product_id', $product_id);
        oci_bind_by_name($stmt, ':rating', $rating);
        oci_bind_by_name($stmt, ':review_description', $review_description);

        if (oci_execute($stmt)) {
            // On successful review submission, redirect to the product detail page
            header("Location: product_detail.php?id=$product_id");
                        exit; // Ensure that code stops execution after the redirect
        } else {
            $e = oci_error($stmt);
            echo "Error submitting review! " . htmlentities($e['message']);
        }
    } else {
        echo "All fields are required!";
    }
}

include "footer.php";
oci_close($conn);


?>