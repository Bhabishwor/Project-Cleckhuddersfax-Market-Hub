<?php
// Include the database connection
include "../connection/connection.php";

// Get the search term from the query parameters
$searchTerm = isset($_GET['search']) ? $_GET['search'] : '';

// Fetch all traders and their products, with optional search filtering
$sql = "SELECT T.*, P.*
        FROM USERS T 
        LEFT JOIN PRODUCT P ON T.USER_ID = P.USER_ID
        WHERE T.USER_ROLE = 'trader'";

if ($searchTerm) {
    $sql .= " AND LOWER(T.USER_NAME) LIKE '%' || LOWER(:search_term) || '%'";
}

$stmt = oci_parse($conn, $sql);

if ($searchTerm) {
    oci_bind_by_name($stmt, ':search_term', $searchTerm);
}

oci_execute($stmt);

// Initialize an array to hold trader data
$traders = [];

// Fetch and organize trader and product data
while ($row = oci_fetch_assoc($stmt)) {
    $trader_id = $row['USER_ID'];

    // If trader already exists in the array, push product data
    if (isset($traders[$trader_id])) {
        $traders[$trader_id]['products'][] = [
            'PRODUCT_ID' => $row['PRODUCT_ID'],
            'PRODUCT_NAME' => $row['PRODUCT_NAME'],
            'PRODUCT_PRICE' => $row['PRODUCT_PRICE'],
            'PRODUCT_IMAGE_PATH' => $row['PRODUCT_IMAGE_PATH']
        ];
    } else {
        // If trader does not exist in the array, create trader and push product data
        $traders[$trader_id] = [
            'TRADER_NAME' => $row['USER_NAME'],
            'TRADER_ADDRESS' => $row['USER_ADDRESS'],
            'TRADER_PHONE_NUMBER' => $row['USER_PHONE_NUMBER'],
            'TRADER_EMAIL' => $row['USER_EMAIL'],
            'TRADER_SHOP' => $row['USER_SHOP'],
            'TRADER_SHOP_IMAGE' => $row['USER_SHOP_IMAGE'],
            'products' => [
                [
                    'PRODUCT_ID' => $row['PRODUCT_ID'],
                    'PRODUCT_NAME' => $row['PRODUCT_NAME'],
                    'PRODUCT_PRICE' => $row['PRODUCT_PRICE'],
                    'PRODUCT_IMAGE_PATH' => $row['PRODUCT_IMAGE_PATH']
                ]
            ]
        ];
    }
}

// Close the connection
oci_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "header.php"; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 50px;
        }

        .trader-card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-bottom: 20px;
        }

        .trader-img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .trader-name {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .trader-info {
            color: #555;
        }

        .products {
            display: none; /* Initially hidden */
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            grid-gap: 20px;
        }

        .product-card {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .product-img {
            max-width: 100%;
            height: auto;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .product-name {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .product-price {
            color: #28a745;
            margin-bottom: 10px;
        }
    </style>
    <script>
        function toggleProducts(traderId) {
            var productsDiv = document.getElementById('products-' + traderId);
            if (productsDiv.style.display === 'none' || productsDiv.style.display === '') {
                productsDiv.style.display = 'grid';
            } else {
                productsDiv.style.display = 'none';
            }
        }
    </script>
</head>
<body>
<div class="container">
  
<form class="d-flex mb-4" action="shop.php" method="get">
        <input class="form-control me-2" type="search" name="search" placeholder="Search for traders" aria-label="Search" value="<?php echo htmlspecialchars($searchTerm); ?>">
        <button class="btn btn-outline-success" type="submit">Search</button>
        <a href="shop.php" class="btn btn-outline-success ms-2">All Traders</a> <!-- Added button -->
    </form>
    <?php foreach ($traders as $trader_id => $trader) : ?>
        <div class="trader-card">
            <div class="row">
                <div class="col-md-3">
                    <img src="<?php echo htmlspecialchars($trader['TRADER_SHOP_IMAGE']); ?>" alt="<?php echo htmlspecialchars($trader['TRADER_NAME']); ?>" class="trader-img">
                </div>
                <div class="col-md-9">
                    <h2 class="trader-name"><?php echo htmlspecialchars($trader['TRADER_NAME']); ?></h2>
                    <p class="trader-info"><strong>Address:</strong> <?php echo htmlspecialchars($trader['TRADER_ADDRESS']); ?></p>
                    <p class="trader-info"><strong>Contact:</strong> <?php echo htmlspecialchars($trader['TRADER_PHONE_NUMBER']); ?></p>
                    <p class="trader-info"><strong>Email:</strong> <?php echo htmlspecialchars($trader['TRADER_EMAIL']); ?></p>
                    <p class="trader-info"><strong>Shop Type:</strong> <?php echo htmlspecialchars($trader['TRADER_SHOP']); ?></p>
                    <button class="btn btn-primary btn-success" onclick="toggleProducts(<?php echo $trader_id; ?>)">Shop</button>
                </div>
            </div>
            <div id="products-<?php echo $trader_id; ?>" class="products">
                <?php foreach ($trader['products'] as $product) : ?>
                    <div class="product-card">
                        <img src="<?php echo htmlspecialchars($product['PRODUCT_IMAGE_PATH']); ?>" alt="<?php echo htmlspecialchars($product['PRODUCT_NAME']); ?>" class="product-img">
                        <div class="product-details">
                            <h3 class="product-name"><?php echo htmlspecialchars($product['PRODUCT_NAME']); ?></h3>
                            <p class="product-price">$<?php echo number_format($product['PRODUCT_PRICE'], 2); ?></p>
                            <form action="manage_cart.php" method="get">
                                <input type="hidden" name="Product_Id" value="<?php echo htmlspecialchars($product['PRODUCT_ID']); ?>">
                                <input type="hidden" name="Product_Name" value="<?php echo htmlspecialchars($product['PRODUCT_NAME']); ?>">
                                <input type="hidden" name="Product_Price" value="<?php echo htmlspecialchars($product['PRODUCT_PRICE']); ?>">
                                <button type="submit" class="btn btn-primary" name="cartBtn"><i class="fa-solid fa-cart-shopping" style="color: white;"></i></button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<?php include "footer.php"; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
