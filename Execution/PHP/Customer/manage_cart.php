<?php
include "../connection/connection.php";
session_start();

$customerId = $_SESSION['id'];
// echo $customerId;

// Function to check if the product and customer exist
function checkExistence($conn, $productId, $customerId) {
    $productExists = false;
    $customerExists = false;

    // Check if product exists
    $product_query = "SELECT COUNT(*) AS NUM_PRODUCT FROM PRODUCT WHERE PRODUCT_ID = :productId";
    $productStmt = oci_parse($conn, $product_query);
    oci_bind_by_name($productStmt, ":productId", $productId);
    oci_execute($productStmt);
    if (oci_fetch_assoc($productStmt)['NUM_PRODUCT'] > 0) {
        $productExists = true;
    }

    // Check if customer exists
    $customer_query = "SELECT COUNT(*) AS NUM_CUSTOMER FROM USERS WHERE USER_ID = :customerId";
    $customerStmt = oci_parse($conn, $customer_query);
    oci_bind_by_name($customerStmt, ":customerId", $customerId);
    oci_execute($customerStmt);
    if (oci_fetch_assoc($customerStmt)['NUM_CUSTOMER'] > 0) {
        $customerExists = true;
    }

    return $productExists && $customerExists;
}

// Initialize or update the session cart from the database
function updateSessionCart($conn, $customerId) {
    $cart = array();
    $query = "SELECT PRODUCT_ID, QUANTITY FROM CART WHERE CUSTOMER_ID = :customerId";
    $stmt = oci_parse($conn, $query);
    oci_bind_by_name($stmt, ":customerId", $customerId);

    if (oci_execute($stmt)) {
        while ($row = oci_fetch_assoc($stmt)) {
            $cart[$row['PRODUCT_ID']] = $row['QUANTITY'];
        }
    } else {
        $e = oci_error($stmt);
        echo "Error executing query: " . htmlentities($e['message']);
    }

    $_SESSION['cart'] = $cart;
}

// Call the function to initialize/update the session cart
updateSessionCart($conn, $customerId);

if (isset($_GET['cartBtn'])) {
    $productName = $_GET['Product_Name'];
    $productPrice = $_GET['Product_Price'];
    $productId = $_GET['Product_Id'];
    $stock = $_GET['stock'];

    // Check if the product and customer exist
    if (checkExistence($conn, $productId, $customerId)) {
        // Check if the product already exists in the cart
        $count_query = "SELECT COUNT(*) AS NUM_PRODUCT FROM CART WHERE PRODUCT_ID = :productId AND CUSTOMER_ID = :customerId";
        $countStmt = oci_parse($conn, $count_query);
        oci_bind_by_name($countStmt, ":productId", $productId);
        oci_bind_by_name($countStmt, ":customerId", $customerId);

        oci_execute($countStmt);
        $num_product = oci_fetch_assoc($countStmt)['NUM_PRODUCT'];

        if ($num_product > 0) {
            // Product already in cart, update quantity
            $update_query = "UPDATE CART SET QUANTITY = QUANTITY + 1 WHERE PRODUCT_ID = :productId AND CUSTOMER_ID = :customerId";
            $updateStmt = oci_parse($conn, $update_query);
            oci_bind_by_name($updateStmt, ":productId", $productId);
            oci_bind_by_name($updateStmt, ":customerId", $customerId);

            if (oci_execute($updateStmt)) {
                updateSessionCart($conn, $customerId);
            } else {
                echo "Failed to update cart";
            }
        } else {
            // Product not in cart, insert new row
            $query = "INSERT INTO CART (PRODUCT_ID, CUSTOMER_ID, PRODUCT_NAME, PRICE, QUANTITY) 
                      VALUES (:productId, :customerId, :productName, :price, 1)";
            $insertStmt = oci_parse($conn, $query);
            oci_bind_by_name($insertStmt, ":productId", $productId);
            oci_bind_by_name($insertStmt, ":customerId", $customerId);
            oci_bind_by_name($insertStmt, ":productName", $productName);
            oci_bind_by_name($insertStmt, ":price", $productPrice);
            // oci_bind_by_name($insertStmt, ":quantity", 1);

            if (oci_execute($insertStmt)) {
                updateSessionCart($conn, $customerId);
            } else {
                echo "Failed to add to cart";
            }
        }

        // Redirect to the homepage
        header("Location: homepage.php");
        exit();
    } else {
        echo "Product or customer does not exist";
    }
}
?>
