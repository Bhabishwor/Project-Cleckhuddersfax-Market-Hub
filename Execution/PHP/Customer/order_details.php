<?php

include "../connection/connection.php";

$orderId = $_GET['order_id'];

$order_details_query = "SELECT * FROM ORDER_DETAILS WHERE ORDER_ID = :orderId";
$select_order_details = oci_parse($conn, $order_details_query);
oci_bind_by_name($select_order_details, ":orderId", $orderId);
oci_execute($select_order_details);

$orderDetailItems = [];
while ($row_cart = oci_fetch_assoc($select_order_details)) {
    $orderDetailItems[] = $row_cart;
}

?>

<!doctype html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/styles.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details | Cleckhuddersfax Market Hub</title>
    <style>
        .body {
            background-color: #e3e3e3;
        }

        .box {
            padding: 1vw;
            margin: 2vw;
            background-color: white;
        }

        .main-div {
            display: flex;
            font-size: 1.5vw;
        }

        .div1 {
            flex: 4;
            margin: 6vw;
            margin-right: 7vw;
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
    </style>
</head>

<body class="body">
    <div class="main-div">
        <div class="div1">
            <div class="box">
                <section class="order-item">
                    <div class="item-div">
                        <b>Product Image</b>
                    </div>
                    <div class="item-div">
                        <b>Product Name</b>
                    </div>
                    <div class="item-div">
                        <b>Product Type</b>
                    </div>
                    <div class="item-div">
                        <b>Price</b>
                    </div>
                    <div class="item-div">
                        <b>Quantity</b>
                    </div>
                </section>
                <hr>

                <?php foreach ($orderDetailItems as $order) : 
                    $orderDetail_Id = $order['ORDER_DETAILS_ID'];
                    $productId = $order['PRODUCT_ID'];
                    $price = $order['PRICE'];
                    $quantity = $order['QUANTITY'];

                    $product_query = "SELECT PRODUCT_NAME, PRODUCT_IMAGE_PATH, PRODUCT_TYPE FROM product WHERE PRODUCT_ID = :productId";
                    $select_product = oci_parse($conn, $product_query);
                    oci_bind_by_name($select_product, ":productId", $productId);
                    oci_execute($select_product);
                    $product = oci_fetch_assoc($select_product);
                ?>
                    <section class="order-item">
                        <div class="item-div">
                            <img src="<?php echo htmlspecialchars($product['PRODUCT_IMAGE_PATH']); ?>" alt="<?php echo htmlspecialchars($product['PRODUCT_NAME']); ?>" width="70" height="70">
                        </div>
                        <div class="item-div">
                            <?php echo htmlspecialchars($product['PRODUCT_NAME']); ?>
                        </div>
                        <div class="item-div">
                            <?php echo htmlspecialchars($product['PRODUCT_TYPE']); ?>
                        </div>
                        <div class="item-div">
                            $<?php echo number_format($price, 2); ?>
                        </div>
                        <div class="item-div">
                            <?php echo htmlspecialchars($quantity); ?>
                        </div>
                    </section>
                    <hr>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>

</html>
