<?php
session_start();


if (!isset($_SESSION["name"])) {
    $_SESSION["loginError"] = "Please Login First";
    header("Location: homepage.php");
    exit(); // Ensure the script stops executing after the redirect
}

include "../connection/connection.php";

$customerId = $_SESSION['id'];

// Function to check if the product and customer exist
function checkExistence($conn, $productId, $customerId)
{
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
function updateSessionCart($conn, $customerId)
{
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
        // Check if the cart already has 20 items
        $cartCountQuery = "SELECT COUNT(*) AS TOTAL_ITEMS FROM CART WHERE CUSTOMER_ID = :customerId";
        $cartCountStmt = oci_parse($conn, $cartCountQuery);
        oci_bind_by_name($cartCountStmt, ":customerId", $customerId);
        oci_execute($cartCountStmt);
        $totalItems = oci_fetch_assoc($cartCountStmt)['TOTAL_ITEMS'];

        $stockCountQuery = "SELECT STOCK FROM product WHERE PRODUCT_ID = :productId";
        $stockCountStmt = oci_parse($conn, $stockCountQuery);
        oci_bind_by_name($stockCountStmt, ":productId", $productId);
        oci_execute($stockCountStmt);
        $totalStock = oci_fetch_assoc($stockCountStmt)['STOCK'];

        if ($totalStock == 0) {
            header("Location: homepage.php?alert=out_of_stock");
            exit();
        } elseif ($totalItems >= 20) {
            // Cart is full, redirect with alert
            header("Location: homepage.php?alert=cart_full");
            exit();
        } else {
            // Check if the product already exists in the cart
            $count_query = "SELECT COUNT(*) AS NUM_PRODUCT FROM CART WHERE PRODUCT_ID = :productId AND CUSTOMER_ID = :customerId";
            $countStmt = oci_parse($conn, $count_query);
            oci_bind_by_name($countStmt, ":productId", $productId);
            oci_bind_by_name($countStmt, ":customerId", $customerId);

            oci_execute($countStmt);
            $num_product = oci_fetch_assoc($countStmt)['NUM_PRODUCT'];

            if ($num_product > 0) {

                $stock_query = "SELECT STOCK FROM product WHERE PRODUCT_ID = :productId";
                $stock_stmt = oci_parse($conn, $stock_query);
                oci_bind_by_name($stock_stmt, ":productId", $productId);
                oci_execute($stock_stmt); // Fix: Execute $stock_stmt instead of $stmt

                // Fetch the stock value
                $stock_row = oci_fetch_assoc($stock_stmt);
                $stock = $stock_row['STOCK'];

                $quantity_query = "SELECT QUANTITY FROM cart WHERE PRODUCT_ID = :productId AND CUSTOMER_ID = :customerId";
                $quantity_stmt = oci_parse($conn, $quantity_query);
                oci_bind_by_name($quantity_stmt, ":productId", $productId);
                oci_bind_by_name($quantity_stmt, ":customerId", $customerId);
                oci_execute($quantity_stmt); // Fix: Execute $stock_stmt instead of $stmt

                // Fetch the stock value
                $quantity_row = oci_fetch_assoc($quantity_stmt);
                $quantity = $quantity_row['QUANTITY'];

                if ($quantity + 1 > $stock) {
                    // Redirect with query parameter indicating insufficient stock
                    $_SESSION['stockMsg'] = "Insufficient Stock";
                    header("Location: homepage.php");
                    exit(); // Stop further execution
                } else {
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

                if (oci_execute($insertStmt)) {
                    updateSessionCart($conn, $customerId);
                } else {
                    echo "Failed to add to cart";
                }
            }

            // Redirect to the homepage
            header("Location: homepage.php");
            exit();
        }
    } else {
        echo "Product or customer does not exist";
    }
}
?>