<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Confirm Order | Cleckhuddersfax Market Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-size: 1rem;
        }

        h5 {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .box {
            padding: 2rem;
            margin-bottom: 2rem;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .main-content {
            display: flex;
            flex-wrap: wrap;
            gap: 2rem;
            margin: 2rem;
        }

        .order {
            flex: 1 1 60%;
        }

        .payment {
            flex: 1 1 35%;
            background-color: #f8f9fa;
            padding: 2rem;
            border-radius: 8px;
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
        }

        .order-item div {
            flex: 1;
            text-align: center;
        }

        .order-item img {
            max-width: 100px;
            height: auto;
        }

        @media (max-width: 1188px) {
            .main-content {
                flex-direction: column;
            }

            .order {
                margin-bottom: 2rem;
            }
        }

        @media (max-width: 765px) {
            .order-item {
                flex-direction: column;
                align-items: flex-start;
            }

            .order-item img {
                margin-bottom: 1rem;
            }
        }

        .btn-manager {
            float: right;
            margin-top: 2vw;
        }
    </style>
</head>

<body>
    <?php include "header.php"; ?>
    <?php include "../connection/connection.php"; ?>

    <div class="container main-content">
        <div class="order">
            <div class="box">
                <section>
                <h3 class="mb-4">Collection Slot:</h3>
                    <form action="payment.php" method="post" id="order-form">
                        <div class="mb-3">
                            <label for="datepicker" class="form-label fw-bold">Collection Day:</label>
                            <input type="text" id="datepicker" name="day" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="time" class="form-label fw-bold">Collection Time:</label>
                            <select name="time" id="time" class="form-select">
                                <option value="10-13">10-13</option>
                                <option value="13-16">13-16</option>
                                <option value="16-19">16-19</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <p><b>Selected Day:</b> <span id="selectedDay"></span></p>
                            <p><b>Selected Date:</b> <span id="selectedDate"></span></p>
                        </div>
                        <input type="hidden" name="collection_date" id="collection_date_hidden" value="">
                        <input type="hidden" name="collection_time" id="collection_time_hidden" value="">
                        <?php
                        $customerId = $_SESSION['id'];
                        echo "<input type='hidden' name='customerId' value='" . $customerId . "'>";

                        ?>
                        <div class="mb-3">
                            <p><b>Email the invoice to:</b> <span><?php echo $_SESSION['email']; ?></span></p>
                        </div>
                </section>
                <div class="box">
                    <section class="order-item">
                        <div><b>Product Image</b></div>
                        <div><b>Product Name</b></div>
                        <div><b>Quantity</b></div>
                        <div><b>Price</b></div>
                    </section>
                    <hr>
                    <?php
                    $query = "SELECT c.PRODUCT_ID, c.QUANTITY, c.PRICE, p.PRODUCT_IMAGE_PATH, p.PRODUCT_NAME
                              FROM cart c
                              JOIN product p ON c.PRODUCT_ID = p.PRODUCT_ID
                              WHERE c.CUSTOMER_ID = :customerId";
                    $stmt = oci_parse($conn, $query);
                    oci_bind_by_name($stmt, ":customerId", $customerId);
                    oci_execute($stmt);

                    $totalPrice = 0;
                    while ($row_cart = oci_fetch_assoc($stmt)) {
                        $productImagePath = $row_cart['PRODUCT_IMAGE_PATH'];
                        $productName = $row_cart['PRODUCT_NAME'];
                        $productPrice = $row_cart['PRICE'];
                        $productQuantity = $row_cart['QUANTITY'];
                        $totalPrice += $productPrice * $productQuantity;

                        echo '<section class="order-item" data-product-id="' . $row_cart['PRODUCT_ID'] . '">';
                        echo '    <div><img src="' . htmlspecialchars($productImagePath) . '" alt="' . htmlspecialchars($productName) . '"></div>';
                        echo '    <div><b>' . htmlspecialchars($productName) . '</b></div>';
                        echo '    <div><b>' . htmlspecialchars($productQuantity) . '</b></div>';
                        echo '    <div><b>$' . number_format($productPrice, 2) . '</b></div>';
                        echo '</section>';
                        echo '<hr>';
                    }
                    ?>
                </div>
            </div>
        </div>
        <div class="payment">
            <section class="mb-4">
                <h5>Payment Method</h5>
                <img src="../../Image/paypal.png" alt="PayPal" width="170" height="45">
            </section>
            <hr>
            <section class="mt-3 mb-4">
                <div class="d-flex justify-content-between">
                    <span class="fw-bold">Total</span>
                    <span class="fw-bold"><?php echo '$' . number_format($totalPrice, 2); ?></span>
                </div>
            </section>
            <section>
                <button type="submit" class="btn btn-outline-success w-100" id="proceed-to-payment" name="proceed-to-payment">
                    Proceed to Payment
                </button>
                <?php
                echo "<input type='hidden' name='total_price' value='" . $totalPrice . "'>";
                echo "<input type='hidden' name='total_quantity' value='" . count($_SESSION['cart']) . "'>";
                ?>
                </form>
            </section>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script>
        $(function () {
            var customDate = new Date();  
            var minDate = new Date(customDate);
            minDate.setDate(customDate.getDate() + 1);

            $("#datepicker").datepicker({
                minDate: minDate,
                beforeShowDay: function (date) {
                    var  day= date.getDay();
                    var now = new Date(customDate);
                    var validDays = [3, 4, 5]; // Wednesday (3), Thursday (4), Friday (5)

                    if (date.getDate() === customDate.getDate() && date.getMonth() === customDate.getMonth() && date.getFullYear() === customDate.getFullYear()) {
                        return [false, ""];
                    }

                    if (validDays.indexOf(day) === -1) {
                        return [false, ""];
                    }

                    if (now.getDay() === 2 && now.getHours() >= 16 && day === 3 ||
                        now.getDay() === 3 && now.getHours() >= 16 && day === 4 ||
                        now.getDay() === 4 && now.getHours() >= 16 && day === 5) {
                        return [date.getTime() >= now.getTime() + 24 * 60 * 60 * 1000, ""];
                    }
                    return [true, ""];
                },
                onSelect: function (dateText, inst) {
                    var selectedDate = new Date(dateText);
                    var day = selectedDate.toLocaleDateString('en-US', { weekday: 'long' });
                    var date = selectedDate.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });

                    $("#selectedDay").text(day);
                    $("#selectedDate").text(date);
                    $("#collection_date_hidden").val(dateText);

                    var currentTime = customDate.getHours();
                    var timeOptions = '<option value="10-13">10-13</option><option value="13-16">13-16</option><option value="16-19">16-19</option>';
                    var todayDate = customDate;

                    if (selectedDate.toDateString() === minDate.toDateString()) {
                        if (todayDate.getDay() === 2 && currentTime >= 10) {
                            if (currentTime < 13) {
                                timeOptions = '<option value="13-16">13-16</option><option value="16-19">16-19</option>';
                            } else if (currentTime < 16) {
                                timeOptions = '<option value="16-19">16-19</option>';
                            } else {
                                timeOptions = '';
                            }
                        } else if (todayDate.getDay() === 3 && currentTime >= 10) {
                            if (currentTime < 13) {
                                timeOptions = '<option value="13-16">13-16</option><option value="16-19">16-19</option>';
                            } else if (currentTime < 16) {
                                timeOptions = '<option value="16-19">16-19</option>';
                            } else {
                                timeOptions = '';
                            }
                        } else if (todayDate.getDay() === 4 && currentTime >= 10) {
                            if (currentTime < 13) {
                                timeOptions = '<option value="13-16">13-16</option><option value="16-19">16-19</option>';
                            } else if (currentTime < 16) {
                                timeOptions = '<option value="16-19">16-19</option>';
                            } else {
                                timeOptions = '';
                            }
                        }
                    }
                    $("#time").html(timeOptions);
                }
            });

            $("#time").on("change", function () {
                $("#collection_time_hidden").val($(this).val());
            });

            $("#order-form").on("submit", function () {
                $("#collection_date_hidden").val($("#datepicker").val());
                $("#collection_time_hidden").val($("#time").val());
            });
        });
    </script>
    <?php include "footer.php"; ?>
</body>

</html>
