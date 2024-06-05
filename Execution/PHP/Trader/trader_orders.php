<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trader Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Font Awesome -->
    <style>
        /* Global Styles */
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
            /* Text color */
        }

        .container {
            margin-top: 50px;
        }

        /* Table Styles */
        .order-details-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #ccc;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            /* Add shadow */
        }

        .order-details-table th,
        .order-details-table td {
            border: 1px solid #ccc;
            padding: 12px;
            /* Increase padding */
            text-align: left;
        }

        .order-details-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .order-details-table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        /* Image Styles */
        .order-image {
            max-width: 80px;
            /* Adjust as needed */
            max-height: 80px;
            /* Adjust as needed */
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            /* Add shadow */
        }

        /* Additional Styles */
        .col-lg-9 {
            margin-left: 15em;
            /* Adjust margin as needed */
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>
    <?php
    include "../connection/connection.php";
    include "trader_navigation_pane.php";

    // Check if the 'name' and 'email' session variables are set and display them
    $name = isset($_SESSION['name']) ? $_SESSION['name'] : ''; // Added this line to define $name
    $email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
    $traderId = isset($_SESSION['id']) ? $_SESSION['id'] : '';

    if (!isset($_SESSION['email'])) {
        echo "Email not set in session.";
        exit();
    }

    $email = $_SESSION['email']; // Retrieve email from session
    
    // Fetch traderId using the email
    $sql = "SELECT USER_ID FROM users WHERE USER_EMAIL = :email AND USER_ROLE = :roleName";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ":email", $email);
    oci_bind_by_name($stmt, ":roleName", $_SESSION['role']);
    oci_execute($stmt);

    $row = oci_fetch_assoc($stmt);
    if (!$row) {
        echo "Trader not found.";
        exit();
    }

    $traderId = $row['USER_ID'];

    if (!empty($email) && !empty($traderId)) {
        // Proceed with fetching orders
        try {
            // Fetch orders for the trader based on the trader ID associated with the products in the order details
            $sql_orders = "
        SELECT od.ORDER_DETAILS_ID, od.PRODUCT_ID, od.ORDER_ID, od.PRICE, od.QUANTITY, p.PRODUCT_NAME, p.PRODUCT_IMAGE_PATH
        FROM ORDER_DETAILS od
        JOIN PRODUCT p ON od.PRODUCT_ID = p.PRODUCT_ID
        WHERE p.USER_ID = :trader_id
    ";

            $stmt_orders = oci_parse($conn, $sql_orders);
            oci_bind_by_name($stmt_orders, ":trader_id", $traderId);
            oci_execute($stmt_orders);

            // Fetch all rows from the result set
            oci_fetch_all($stmt_orders, $orders, null, null, OCI_FETCHSTATEMENT_BY_ROW);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
            exit();
        }
    } else {
        echo "Trader not logged in.";
        exit();
    }
    ?>

    <div class="container">
        <div class="row">
            <div class="col-lg-9 col-md-8 text-center" style="margin-left: 15em;">
                <h1><i class="fas fa-shopping-cart"></i> Order Details</h1> <!-- Icon with the heading -->
                <?php if (!empty($orders)): ?>
                    <table class="order-details-table">
                        <thead>
                            <tr>
                                <th>Order Details ID</th>
                                <th>Product ID</th>
                                <th>Order ID</th>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Image</th> <!-- New column for image -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($order['ORDER_DETAILS_ID']); ?></td>
                                    <td><?php echo htmlspecialchars($order['PRODUCT_ID']); ?></td>
                                    <td><?php echo htmlspecialchars($order['ORDER_ID']); ?></td>
                                    <td><?php echo htmlspecialchars($order['PRODUCT_NAME']); ?></td>
                                    <td><?php echo htmlspecialchars($order['PRICE']); ?></td>
                                    <td><?php echo htmlspecialchars($order['QUANTITY']); ?></td>
                                    <td>
                                        <?php
                                        $imagePath = htmlspecialchars($order['PRODUCT_IMAGE_PATH']);
                                        if (!empty($imagePath)) {
                                            echo '<img src="' . $imagePath . '" alt="Product Image" class="order-image">';
                                        } else {
                                            echo 'No Image';
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No orders found for this trader.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>