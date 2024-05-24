<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Confirm Order | Cleckhuddersfax Market Hub</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../../CSS/main.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
                    <form action="payment.php" method="post" id="order-form">
                        <div>
                            <div class="slot-title">Choose a collection slot:</div>
                            <p class="collecttxt"> Collection Day:
                                <input type="text" id="datepicker" name="day" style="width:50%; height: 40px;" />
                            </p>
                        </div>
                        <div>
                            <label for="time" class="timetxt"> Collection Time: </label>
                            <select name="time" id="time" style="background-color: white; width:50%; height: 60px;">
                                <option value="10-13"> 10-13</option>
                                <option value="13-16"> 13-16</option>
                                <option value="16-19"> 16-19</option>
                            </select>
                        </div>

                        <p class="collecttxt">Selected Day: <span id="selectedDay"></span></p>
                        <p class="collecttxt">Selected Date: <span id="selectedDate"></span></p>
                </section>
                <input type="hidden" name="collection_date" id="collection_date_hidden" value="">
                <input type="hidden" name="collection_time" id="collection_time_hidden" value="">
                <?php
                echo "<input type='hidden' name='customerId' value='" . $customerId . "'>";
                ?>

                <span>Email the invoice to:</span>
                <span><?php echo $_SESSION['email']; ?></span>

            </div>
            <div class="box">
                <section class="order-item">
                    <div class="item-div"><b>Product Image</b></div>
                    <div class="item-div"><b>Product Name</b></div>
                    <div class="item-div"><b>Quantity</b></div>
                    <div class="item-div"><b>Price</b></div>
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
            <section><b>Payment method</b></section>
            <section class="mb-3"><img src="../../Image/paypal.png" alt="Payment Option 1" width="170" height="45">
            </section>
            <hr>
            <section class="mt-3">
                <div>
                    <span>Total</span>
                    <span><?php echo '$' . $totalPrice; ?></span>
                </div>
            </section>
            <section>
                <button type="submit" class="btn btn-outline-success" id="proceed-to-payment" name="proceed-to-payment">
                    <small>Proceed to payment</small>
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

    <script type="text/javascript">
        $(function () {
            var customDate = new Date("2024-05-23T14:00:00");
            var minDate = new Date(customDate);
            minDate.setDate(customDate.getDate() + 1);

            $("#datepicker").datepicker({
                minDate: minDate,
                beforeShowDay: function (date) {
                    var day = date.getDay();
                    var now = new Date(customDate);
                    var validDays = [3, 4, 5]; // Wednesday (3), Thursday (4), Friday (5)


                    if (date.getDate() === customDate.getDate() && date.getMonth() === customDate.getMonth() && date.getFullYear() === customDate.getFullYear()) {
                        return [false, ""];
                    }


                    if (validDays.indexOf(day) === -1) {
                        return [false, ""];
                    }

                    // Disabling logic based on customDate and current day
                    if (now.getDay() === 2) { // If today is Tuesday
                        if (now.getHours() >= 16 && day === 3) { // After 4 PM Tuesday, disable Wednesday
                            return [date.getTime() >= now.getTime() + 24 * 60 * 60 * 1000, ""];
                        }
                    } else if (now.getDay() === 3) { // If today is Wednesday
                        if (now.getHours() >= 16 && day === 4) { // After 4 PM Wednesday, disable Thursday
                            return [date.getTime() >= now.getTime() + 24 * 60 * 60 * 1000, ""];
                        }
                    } else if (now.getDay() === 4) { // If today is Thursday
                        if (now.getHours() >= 16 && day === 5) { // After 4 PM Thursday, disable Friday
                            return [date.getTime() >= now.getTime() + 24 * 60 * 60 * 1000, ""];
                        }
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
                    var timeOptions = '<option value="10-13"> 10-13</option><option value="13-16"> 13-16</option><option value="16-19"> 16-19</option>';
                    var todayDate = customDate;


                    if (selectedDate.toDateString() === minDate.toDateString()) {
                        if (todayDate.getDay() === 2 && currentTime >= 10) { // Tuesday
                            if (currentTime < 13) {
                                timeOptions = '<option value="13-16"> 13-16</option><option value="16-19"> 16-19</option>';
                            } else if (currentTime < 16) {
                                timeOptions = '<option value="16-19"> 16-19</option>';
                            } else {
                                timeOptions = '';
                            }
                        } else if (todayDate.getDay() === 3 && currentTime >= 10) { // Wednesday
                            if (currentTime < 13) {
                                timeOptions = '<option value="13-16"> 13-16</option><option value="16-19"> 16-19</option>';
                            } else if (currentTime < 16) {
                                timeOptions = '<option value="16-19"> 16-19</option>';
                            } else {
                                timeOptions = '';
                            }
                        } else if (todayDate.getDay() === 4 && currentTime >= 10) { // Thursday
                            if (currentTime < 13) {
                                timeOptions = '<option value="13-16"> 13-16</option><option value="16-19"> 16-19</option>';
                            } else if (currentTime < 16) {
                                timeOptions = '<option value="16-19"> 16-19</option>';
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
