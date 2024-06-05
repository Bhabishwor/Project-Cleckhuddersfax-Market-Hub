<!doctype html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/styles.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders | Cleckhuddersfax Market Hub</title>
    <style>
        .body {
            background-color: #e3e3e3;
        }

        .btn-manager {
            float: right;
            margin: 1vw;
            /* Optional: adjust as needed for spacing */
        }

        .box {
            padding: 1vw;
            margin: 2vw;
            background-color: white;
        }

        .main-div {
            display: flex;
            font-size: 1vw;
        }

        .div1 {
            flex: 4;
            margin: 6vw;
            margin-right: 7vw;
        }

        .div2 {
            flex: 1;
            margin: 3vw;
            margin-right: 7vw;
            padding: 3vw;
            background-color: whitesmoke;
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .item-div {
            flex: 1;
            text-align: center;
        }

        .item-div img {
            max-width: 100%;
            height: auto;
        }

        .summary {
            margin-top: 3vw;
        }

        .div2 section {
            margin-bottom: 2vw;
        }

        .div2 div {
            margin-top: 3vw;
        }

        .paypal-button-container {
            margin-top: 2vw;
            display: none;
        }

        .quantity-container {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .quantity-btn {
            background-color: #f0f0f0;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 5px 10px;
            cursor: pointer;
            margin: 0 5px;
            font-size: 1.5vw;
        }

        .quantity-btn:hover {
            background-color: #e0e0e0;
        }

        .quantity-input {
            width: 50px;
            text-align: center;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 5px;
        }
    </style>
</head>

<body class="body">
    <?php
    include "header.php";
    include "../connection/connection.php";

    $customerId = $_SESSION['id'];
    $query = "SELECT * FROM confirm_order WHERE CUSTOMER_ID = :customerId";
    $stmt = oci_parse($conn, $query);
    oci_bind_by_name($stmt, ":customerId", $customerId);
    oci_execute($stmt);

    $orderItems = [];
    while ($row_cart = oci_fetch_assoc($stmt)) {
        $orderItems[] = $row_cart;
    }
    ?>

    <div class="main-div">
        <div class="div1">
            <div class="box">
                <?php if (empty($orderItems)): ?>
                    <h3 style="text-align: center;">No orders found</h3>
                <?php else: ?>
                    <section class="order-item">
                    <div class="item-div">
                            <b>Order</b>
                        </div>
                        <div class="item-div">
                            <b>Total Price</b>
                        </div>
                        <div class="item-div">
                            <b>Total Quantity</b>
                        </div>
                        <div class="item-div">
                            <b>Collection Date</b>
                        </div>
                        <div class="item-div">
                            <b>Collection Slot</b>
                        </div>
                        <div class="item-div">
                            <b>Order Details</b>
                        </div>
                    </section>
                    <hr>
                    <?php
                    $sn = 1;
                    foreach ($orderItems as $row_cart) {
                        $orderId = $row_cart['ORDER_ID'];
                        $totalPrice = $row_cart['TOTAL_PRICE'];
                        $totalQuantity = $row_cart['TOTAL_QUANTITY'];

                        $collection_slot_query = "SELECT * FROM collection_slot WHERE ORDER_ID = :orderId";
                        $select_collection_slot = oci_parse($conn, $collection_slot_query);
                        oci_bind_by_name($select_collection_slot, ":orderId", $orderId);
                        oci_execute($select_collection_slot);
                        $collection_slot = oci_fetch_assoc($select_collection_slot);
                        ?>
                        <section class="order-item">
                            <div class="item-div">
                                <?php echo htmlspecialchars($sn++); // Output and increment the serial number ?>
                            </div>
                            <div class="item-div">
                                $<?php echo number_format($totalPrice, 2); ?>
                            </div>
                            <div class="item-div">
                                <?php echo htmlspecialchars($totalQuantity); ?>
                            </div>
                            <div class="item-div">
                                <?php echo htmlspecialchars($collection_slot['COLLECTION_DATE']); ?>
                            </div>
                            <div class="item-div">
                                <?php echo htmlspecialchars($collection_slot['COLLECTION_TIME']); ?>
                            </div>
                            <div class="item-div">
                                <button class="open-window-btn btn btn-success"
                                    onclick="openNewWindow('<?php echo $orderId; ?>')">View</button>
                            </div>
                        </section>
                        <hr>
                    <?php } ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php include "footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function openNewWindow(orderId) {
            window.open('order_details.php?order_id=' + encodeURIComponent(orderId), '_blank', 'width=800,height=600');
        }
    </script>
</body>

</html>