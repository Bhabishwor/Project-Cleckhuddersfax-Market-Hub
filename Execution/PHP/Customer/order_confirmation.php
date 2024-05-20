<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Confirm Order | Cleckhuddersfax Market Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../../CSS/main.css">
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
        }
        .div1 {
            flex: 4;
            margin: 6vw;
            margin-right: 7vw;
        }
        .payment {
            flex: 1;
            margin: 3vw;
            margin-right: 7vw;
            padding: 3vw;
            background-color: whitesmoke;
        }
        .order-item {
            display: flex;
            justify-content: space-between;
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
        .item-photo {
            flex: 15%;
        }
        .item-name {
            flex: 50%;
            align-self: center;
        }
        .item-price {
            flex: 10%;
            align-self: center;
        }
        .item-edit {
            flex: 25%;
        }
        .payment section {
            margin-bottom: 2vw;
        }
        .payment div {
            margin-top: 2vw;
        }
        @media (max-width: 1188px) {
            .main-content {
                flex-direction: column;
            }
            .order {
                margin: 6vw;
                margin-top: 3vw;
            }
            .payment {
                margin: 9vw;
                margin-top: 0;
            }
        }
        @media (max-width: 765px) {
            .order-item {
                flex-direction: column;
            }
            .img-fluid {
                width: auto;
                height: auto;
            }
            .item-edit {
                align-self: center;
            }
            .payment {
                margin: 12vw;
                margin-top: 0;
            }
        }
        .paypal-button-container {
            margin-top: 2vw;
            display: none;
        }
        .btn-manager {
            float: right;
            margin-top: 2vw;
        }
    </style>
</head>

<body class="body">
    <?php
    include "header.php";
    include "../connection/connection.php";

    // Get the customer ID from the session
    $customerId = $_SESSION['id'];

    // Prepare the query to fetch cart items
    $query = "SELECT c.PRODUCT_ID, c.QUANTITY, c.PRICE, p.PRODUCT_IMAGE_PATH, p.PRODUCT_NAME
              FROM cart c
              JOIN product p ON c.PRODUCT_ID = p.PRODUCT_ID
              WHERE c.CUSTOMER_ID = :customerId";
    $stmt = oci_parse($conn, $query);
    oci_bind_by_name($stmt, ":customerId", $customerId);
    oci_execute($stmt);
    ?>

    <div class="main-content">
        <div class="order">
            <div class="box">
                <section>
                    <span>Collection Slot:</span>
                    <span>Lorem Ipsum</span>
                </section>
                <section>
                    <span>Email the invoice to:</span>
                    <span><?php echo $_SESSION['email']; ?></span>
                </section>
            </div>
            <div class="box">
                <section class="order-item">
                    <div class="item-div">
                        <b>Product Image</b>
                    </div>
                    <div class="item-div">
                        <b>Product Name</b>
                    </div>
                    <div class="item-div">
                        <b>Quantity</b>
                    </div>
                    <div class="item-div">
                        <b>Price</b>
                    </div>
                </section>
                <hr>
                <?php
                $totalPrice = 0;
                while ($row_cart = oci_fetch_assoc($stmt)) {
                    $productImagePath = $row_cart['PRODUCT_IMAGE_PATH'];
                    $productName = $row_cart['PRODUCT_NAME'];
                    $productPrice = $row_cart['PRICE'];
                    $productQuantity = $row_cart['QUANTITY'];
                    $totalPrice += $productPrice * $productQuantity;

                    echo '<section class="order-item" data-product-id="' . $row_cart['PRODUCT_ID'] . '">';
                    echo '    <div class="item-div"><img src="' . htmlspecialchars($productImagePath) . '" alt="' . htmlspecialchars($productName) . '" width="70" height="70"></div>';
                    echo '    <div class="item-div">';
                    echo '        <b>' . htmlspecialchars($productName) . '</b>';
                    echo '    </div>';
                    echo '    <div class="item-div">';
                    echo '        <b>' . htmlspecialchars($productQuantity) . '</b>';
                    echo '    </div>';
                    echo '    <div class="item-div">';
                    echo '        <b>$' . number_format($productPrice, 2) . '</b>';
                    echo '    </div>';
                    echo '</section>';
                    echo '<hr>';
                }
                ?>
            </div>
        </div>
        <div class="payment">
            <section>
                <b>Payment method</b>
            </section>
            <section class="mb-3">
                <img src="../../Image/paypal.png" alt="Payment Option 1" width="170" height="45">
            </section>
            <hr>
            <section class="mt-3">
                <div>
                    <span>Total</span>
                    <span><?php echo '$' . $totalPrice; ?></span>
                </div>
            </section>
            <section>
                <button class="btn btn-outline-success" id="proceed-to-payment"><small>Proceed to payment</small></button>
            </section>
            <section id="paypal-button-container" class="paypal-button-container">
                <!-- PayPal SDK will render the buttons here -->
            </section>
        </div>
    </div>

    <?php include "footer.php"; ?>

    <!-- PayPal SDK script -->
    <script src="https://www.paypal.com/sdk/js?client-id=AdKCZSMp56mk6ROcx-_juaoQzgpJaCH_571hD1us2EnuxSL2dqWfrwd86qXVr3r2qGkagXoLDOjvwsei&currency=USD"></script>
    <script>
        let paypalRendered = false;

        document.getElementById('proceed-to-payment').addEventListener('click', function () {
            if (!paypalRendered) {
                document.getElementById('paypal-button-container').style.display = 'block';
                paypal.Buttons({
                    createOrder: function (data, actions) {
                        return actions.order.create({
                            purchase_units: [{
                                amount: {
                                    value: '<?php echo $totalPrice; ?>' // Total amount
                                }
                            }]
                        });
                    },
                    onApprove: function (data, actions) {
                        return actions.order.capture().then(function (details) {
                            alert('Transaction completed by ' + details.payer.name.given_name);
                            // Optionally, redirect the user to a success page
                        });
                    }
                }).render('#paypal-button-container');
                paypalRendered = true;
            }
        });
    </script>
</body>

</html>
