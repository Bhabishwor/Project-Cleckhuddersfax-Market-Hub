<?php
include "../connection/connection.php";

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

        // Payment Table
        // $payment_query = "INSERT INTO payment (ORDER_ID, CUSTOMER_ID, PAYMENT_AMOUNT,PAYMENT_DATE)
        // VALUES(:orderID, :customerID, :paymentAmount, :paymentDate)";

        // $insert_payment = oci_parse($conn, $payment_query);

        // $dateTime = new DateTime();
        // $paymentDate = $dateTime->format('Y-m-d');

        // oci_bind_by_name($insert_payment,":orderID", $orderId);
        // oci_bind_by_name($insert_payment,":customerID", $customerId);
        // oci_bind_by_name($insert_payment,":paymentAmount", $totalPrice);
        // oci_bind_by_name($insert_payment,":paymentDate", $paymentDate);



        // Order Sequence

        $order_sequence_query = "SELECT confirm_order_seq.CURRVAL AS order_id FROM dual";
        $stmt_order_id = oci_parse($conn. $order_sequence_query);
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

                // Updating the stock
                $update_stock_query = "UPDATE product SET STOCK = :stock WHERE PRODUCT_ID = :productId";
                $update_stock = oci_parse($conn, $update_stock_query);

                oci_bind_by_name($update_stock_query, ":productID", $order_cart['PRODUCT_ID']);

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
    } else {
        // Rollback the transaction in case of any failure
        oci_rollback($conn);
        echo "Failed to insert order.";
    }
} else {
    echo "Payment not successful.";
}
?>