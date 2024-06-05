<?php
include "../connection/connection.php";

session_start();

// require "invoice.php";

$payment = $_GET['success'];
$collectionDate = $_GET['collection_date'];
$collectionTime = $_GET['collection_time'];
$totalPrice = $_GET['total_price'];
$totalQuantity = $_GET['total_products'];
$customerId = $_GET['customer_id'];

if ($payment === 'true') {

    // Inserting data into confirm_order table
    $order_query = "INSERT INTO confirm_order (CUSTOMER_ID, TOTAL_PRICE, TOTAL_QUANTITY)
                    VALUES(:customerId, :totalPrice, :totalQuantity)";

    $insert_order_query = oci_parse($conn, $order_query);

    oci_bind_by_name($insert_order_query, ':customerId', $customerId);
    oci_bind_by_name($insert_order_query, ':totalPrice', $totalPrice);
    oci_bind_by_name($insert_order_query, ':totalQuantity', $totalQuantity);


    if (oci_execute($insert_order_query, OCI_DEFAULT)) {

        // Order Sequence

        $order_sequence_query = "SELECT confirm_order_seq.CURRVAL AS ORDER_ID FROM dual";
        $stmt_order_id = oci_parse($conn, $order_sequence_query);
        oci_execute($stmt_order_id);

        $row = oci_fetch_assoc($stmt_order_id);
        $orderId = $row['ORDER_ID'];





        // Retrieve product details from cart
        $cart_query = "SELECT PRODUCT_ID, PRICE, QUANTITY FROM cart WHERE CUSTOMER_ID = :customerId";
        $select_cart = oci_parse($conn, $cart_query);
        oci_bind_by_name($select_cart, ":customerId", $customerId);

        if (oci_execute($select_cart)) {
            while ($order_cart = oci_fetch_assoc($select_cart)) {
                // Insert product details into order_details
                $order_details_query = "INSERT INTO order_details (PRODUCT_ID, ORDER_ID, PRICE, QUANTITY)
                                        VALUES (:productID, :orderID, :price, :quantity)";
                $insert_order_details = oci_parse($conn, $order_details_query);

                oci_bind_by_name($insert_order_details, ":productID", $order_cart['PRODUCT_ID']);
                oci_bind_by_name($insert_order_details, ":orderID", $orderId);
                oci_bind_by_name($insert_order_details, ":price", $order_cart['PRICE']);
                oci_bind_by_name($insert_order_details, ":quantity", $order_cart['QUANTITY']);

                oci_execute($insert_order_details);

                // Selecting the stock
                $select_stock_query = "SELECT STOCK FROM product WHERE PRODUCT_ID = :productId";
                $select_stock = oci_parse($conn, $select_stock_query);
                oci_bind_by_name($select_stock, ":productId", $order_cart['PRODUCT_ID']);
                oci_execute($select_stock);
                $row = oci_fetch_assoc($select_stock);

                $remaining_stock = $row['STOCK'] - $order_cart['QUANTITY'];


                // Updating the stock
                $update_stock_query = "UPDATE product SET STOCK = :stock WHERE PRODUCT_ID = :productId";
                $update_stock = oci_parse($conn, $update_stock_query);
                oci_bind_by_name($update_stock, ":productID", $order_cart['PRODUCT_ID']);
                oci_bind_by_name($update_stock, ":stock", $remaining_stock);
                oci_execute($update_stock);


            }
        }

        // Insert data into collection_slot table
        $collection_slot_query = "INSERT INTO collection_slot (ORDER_ID, COLLECTION_DATE, COLLECTION_TIME)
                                  VALUES (:orderID, :collectionDate, :collectionTime)";
        $insert_collection_slot = oci_parse($conn, $collection_slot_query);

        oci_bind_by_name($insert_collection_slot, ":orderID", $orderId);
        oci_bind_by_name($insert_collection_slot, ":collectionDate", $collectionDate);
        oci_bind_by_name($insert_collection_slot, ":collectionTime", $collectionTime);

        oci_execute($insert_collection_slot);


        // Payment Table
        $payment_query = "INSERT INTO payment (ORDER_ID, USER_ID, PAYMENT_AMOUNT)
VALUES(:orderID, :customerID, :paymentAmount)";

        $insert_payment = oci_parse($conn, $payment_query);

        // Check if oci_parse was successful
        if (!$insert_payment) {
            $e = oci_error($conn);
            echo "Error parsing SQL: " . $e['message'];
            exit;
        }

        oci_bind_by_name($insert_payment, ":orderID", $orderId);
        oci_bind_by_name($insert_payment, ":customerID", $customerId);
        oci_bind_by_name($insert_payment, ":paymentAmount", $totalPrice);

        if (!oci_execute($insert_payment, OCI_NO_AUTO_COMMIT)) {
            $e = oci_error($insert_payment);
            echo "Error executing SQL: " . $e['message'];
            exit;
        }

        // Commit the transaction
        if (!oci_commit($conn)) {
            $e = oci_error($conn);
            echo "Error committing transaction: " . $e['message'];
            exit;
        }

        echo "Data successfully inserted.";


        // Delete the items in the cart of the particular customer
        $delete_cart_query = "DELETE FROM cart WHERE CUSTOMER_ID = :customerId";
        $delete_cart = oci_parse($conn, $delete_cart_query);
        oci_bind_by_name($delete_cart, ":customerId", $customerId);
        oci_execute($delete_cart);

        unset($_SESSION['cart']);



        $_SESSION['order_placed'] = true;



    } else {
        // Rollback the transaction in case of any failure
        oci_rollback($conn);
        echo "Failed to insert order.";
    }


    header("Location: homepage.php");
} else {
    echo "Payment not successful.";
}
?>