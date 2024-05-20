<!DOCTYPE html>
<html lang="en">

<head>
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
    include "header.php";
    include "../connection/connection.php";

    $customerId = $_SESSION['id'];
    $query = "SELECT c.PRODUCT_ID, c.QUANTITY, c.PRICE, p.PRODUCT_IMAGE_PATH, p.PRODUCT_NAME
          FROM cart c
          JOIN product p ON c.PRODUCT_ID = p.PRODUCT_ID
          WHERE c.CUSTOMER_ID = :customerId";
    $stmt = oci_parse($conn, $query);
    oci_bind_by_name($stmt, ":customerId", $customerId);
    oci_execute($stmt);
    ?>

    <div class="main-div">
        <div class="div1">
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
                    <div class="item-div">
                        <b>Edit</b>
                    </div>
                    <div class="item-div">
                        <b>Delete</b>
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
                    echo '    <div class="item-div"><img src="' . htmlspecialchars($productImagePath) . '" alt="Order Item 1" width="70" height="70"></div>';
                    echo '    <div class="item-div">';
                    echo '        <b>' . htmlspecialchars($productName) . '</b>';
                    echo '    </div>';
                    echo '    <div class="item-div quantity-container">';
                    echo '        <button class="quantity-btn" onclick="decreaseQuantity(this)">-</button>';
                    echo '        <input type="text" class="quantity-input" value="' . htmlspecialchars($productQuantity) . '" readonly>';
                    echo '        <button class="quantity-btn" onclick="increaseQuantity(this)">+</button>';
                    echo '    </div>';
                    echo '    <div class="item-div">';
                    echo '        <b>$' . number_format($productPrice, 2) . '</b>';
                    echo '    </div>';
                    echo '    <div class="item-div">';
                    echo '        <a href="#" onclick="updateQuantity(' . $row_cart['PRODUCT_ID'] . ', this)"><img src="../../Image/buttons/edit.png" alt="Edit" width="80" height="80"></a>';
                    echo '    </div>';
                    echo '    <div class="item-div">';
                    echo '        <a href="#" onclick="deleteProduct(' . $row_cart['PRODUCT_ID'] . ', this)"><img src="../../Image/buttons/delete.png" alt="Delete" width="80" height="80"></a>';
                    echo '    </div>';
                    echo '</section>';
                    echo '<hr>';
                }
                ?>
                <a href="order_confirmation.php">
                    <button type="button" class="btn btn-success btn-manager mt-4">Confirm Order</button>
                </a>
            </div>
        </div>

    </div>
    <?php include "footer.php"; ?>
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
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert("Quantity updated successfully!");
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
                        alert("Product deleted successfully!");
                    }
                };
                xhr.send("product_id=" + productId);
            }
        }
    </script>
</body>

</html>