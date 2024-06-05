<?php
ob_start();
include "header.php";

if (!isset($_SESSION["name"])) {
    $_SESSION["loginError"] = "Please Login First";
    header("Location: homepage.php");
    exit(); // Ensure the script stops executing after the redirect
}

include "../connection/connection.php";

?>
<!doctype html>
<html lang="en">

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/styles.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart | Cleckhuddersfax Market Hub</title>
    <style>
        .body {
            background-color: #e3e3e3;
        }

        .btn-manager {
            float: right;
            margin: 1vw;
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
            font-size: 1.2vw;
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


    $customerId = $_SESSION['id'];
    $query = "SELECT c.PRODUCT_ID, c.QUANTITY, c.PRICE, p.PRODUCT_IMAGE_PATH, p.PRODUCT_NAME
              FROM cart c
              JOIN product p ON c.PRODUCT_ID = p.PRODUCT_ID
              WHERE c.CUSTOMER_ID = :customerId";
    $stmt = oci_parse($conn, $query);
    oci_bind_by_name($stmt, ":customerId", $customerId);
    oci_execute($stmt);

    $cartItems = [];
    while ($row_cart = oci_fetch_assoc($stmt)) {
        $cartItems[] = $row_cart;
    }
    ?>

    <div class="main-div">
        <div class="div1">
            <div class="box">
                <?php if (empty($cartItems)): ?>
                    <h3 style="text-align: center;">Your cart is empty</h3>
                <?php else: ?>
                    <section class="order-item">
                        <div class="item-div"><b>Product Image</b></div>
                        <div class="item-div"><b>Product Name</b></div>
                        <div class="item-div"><b>Quantity</b></div>
                        <div class="item-div"><b>Price</b></div>
                        <div class="item-div"><b>Edit</b></div>
                        <div class="item-div"><b>Delete</b></div>
                    </section>
                    <hr>
                    <?php
                    $totalPrice = 0;
                    foreach ($cartItems as $row_cart) {
                        $productImagePath = $row_cart['PRODUCT_IMAGE_PATH'];
                        $productName = $row_cart['PRODUCT_NAME'];
                        $productPrice = $row_cart['PRICE'];
                        $productQuantity = $row_cart['QUANTITY'];
                        $totalPrice += $productPrice * $productQuantity;
                        ?>
                        <section class="order-item" data-product-id="<?php echo $row_cart['PRODUCT_ID']; ?>">
                            <div class="item-div"><img src="<?php echo htmlspecialchars($productImagePath); ?>"
                                    alt="Order Item 1" width="70" height="70"></div>
                            <div class="item-div"><b><?php echo htmlspecialchars($productName); ?></b></div>
                            <div class="item-div quantity-container">
                                <button class="quantity-btn" onclick="decreaseQuantity(this)">-</button>
                                <input type="text" class="quantity-input"
                                    value="<?php echo htmlspecialchars($productQuantity); ?>" readonly>
                                <button class="quantity-btn" onclick="increaseQuantity(this)">+</button>
                            </div>
                            <div class="item-div"><b>$<?php echo number_format($productPrice, 2); ?></b></div>
                            <div class="item-div"><a href="#"
                                    onclick="updateQuantity(<?php echo $row_cart['PRODUCT_ID']; ?>, this)"><img
                                        src="../../Image/buttons/edit.png" alt="Edit" width="80" height="80"></a></div>
                            <div class="item-div"><a href="#"
                                    onclick="deleteProduct(<?php echo $row_cart['PRODUCT_ID']; ?>, this)"><img
                                        src="../../Image/buttons/delete.png" alt="Delete" width="80" height="80"></a></div>
                        </section>
                        <hr>
                    <?php } ?>
                    <a href="order_confirmation.php">
                        <button type="button" class="btn btn-success btn-manager mt-4">Confirm Order</button>
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <?php include "footer.php"; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    <script
        src="https://www.paypal.com/sdk/js?client-id=AdKCZSMp56mk6ROcx-_juaoQzgpJaCH_571hD1us2EnuxSL2dqWfrwd86qXVr3r2qGkagXoLDOjvwsei&currency=USD"></script>
    <script>
        function increaseQuantity(button) {
            var input = button.previousElementSibling;
            input.value = parseInt(input.value) + 1;
        }

        function decreaseQuantity(button) {
            var input = button.nextElementSibling;
            if (input.value > 1) {
                input.value = parseInt(input.value) - 1;
            }
        }

        function updateQuantity(productId, button) {
            var input = button.parentElement.previousElementSibling.previousElementSibling.querySelector('.quantity-input');
            var quantity = input.value;

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "update_cart.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function () {
                if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                // Success response
                var response = xhr.responseText;
                if (response === "success") {
                    alert("Quantity updated successfully!");
                } else if (response === "exceeds") {
                    alert("Quantity exceeds the stock value.");
                    window.location.reload();
                } else {
                    alert("An error occurred. Please try again later.");
                }
            } else {
                // Error response
                alert("An error occurred. Please try again later.");
            }
        }
            };
            xhr.send("product_id=" + productId + "&quantity=" + quantity);
        }

        function deleteProduct(productId, button) {
            if (confirm('Are you sure you want to delete this product from your cart?')) {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "delete_product.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function () {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        var section = button.closest('.order-item');
                        section.parentNode.removeChild(section);
                        window.location.reload(true);
                        alert("Product deleted successfully!");
                    }
                };
                xhr.send("product_id=" + productId);
            }
        }
    </script>
</body>

</html>