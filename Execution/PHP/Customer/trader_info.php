<?php
// Include the database connection
include "../connection/connection.php";

// Get the trader ID from the URL
$trader_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch the trader details from the database
$sql_trader = "SELECT * FROM USERS WHERE USER_ID = :trader_id";
$stmt_trader = oci_parse($conn, $sql_trader);
oci_bind_by_name($stmt_trader, ':trader_id', $trader_id);
oci_execute($stmt_trader);
$trader = oci_fetch_assoc($stmt_trader);

if (!$trader) {
    echo "Trader not found!";
    exit;
}

// Fetch products by the trader
$sql_products = "SELECT * FROM PRODUCT WHERE USER_ID = :trader_id";
$stmt_products = oci_parse($conn, $sql_products);
oci_bind_by_name($stmt_products, ':trader_id', $trader_id);
oci_execute($stmt_products);
$products = [];
while ($row = oci_fetch_assoc($stmt_products)) {
    $products[] = $row;
}

// Free the statement identifiers and close the connection
oci_free_statement($stmt_trader);
oci_free_statement($stmt_products);
oci_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "header.php"; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($trader['TRADER_NAME']); ?> | Trader Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f8f9fa;
        }

        .trader-container {
            margin-top: 50px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .trader-img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            border: 1px solid #ddd;
            margin-bottom: 20px;
        }

        .trader-detail {
            padding: 20px;
        }

        .trader-title {
            font-size: 2.5rem;
            margin-bottom: 15px;
            color: #333;
        }

        .trader-info {
            margin-bottom: 20px;
            font-size: 1.1rem;
            color: #555;
        }

        .more-products {
            margin-top: 50px;
        }

        .more-products .product-card {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container trader-container" style="margin-bottom: 10em;">
        <div class="row">
            <div class="col-md-6">
                <img src="<?php echo htmlspecialchars($trader['USER_SHOP_IMAGE']); ?>" alt="<?php echo htmlspecialchars($trader['USER_NAME']); ?>" class="trader-img">
            </div>
            <div class="col-md-6 trader-detail">
                <h1 class="trader-title"><?php echo htmlspecialchars($trader['USER_NAME']); ?></h1>
                <p class="trader-info"><strong>Address:</strong> <?php echo htmlspecialchars($trader['USER_ADDRESS']); ?></p>
                <p class="trader-info"><strong>Contact:</strong> <?php echo htmlspecialchars($trader['USER_PHONE_NUMBER']); ?></p>
                <p class="trader-info"><strong>Email:</strong> <?php echo htmlspecialchars($trader['USER_EMAIL']); ?></p>
            </div>
        </div>

        <div class="more-products">
            <h3>Products from this trader</h3>
            <div class="row">
                <?php foreach ($products as $product) : ?>
                    <div class="col-md-4">
                        <div class="card product-card">
                            <img src="<?php echo htmlspecialchars($product['PRODUCT_IMAGE_PATH']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($product['PRODUCT_NAME']); ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($product['PRODUCT_NAME']); ?></h5>
                                <p class="card-text">$<?php echo number_format($product['PRODUCT_PRICE'], 2); ?></p>
                                <a href="cart.php?id=<?php echo htmlspecialchars($product['PRODUCT_ID']); ?>" class="btn btn-primary">Add to Cart </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
<?php include "footer.php"; ?>
</html>