<?php

include "../connection/connection.php";

$searchTerm = '';
$searchCategory = '';
$sortColumn = '';
$sortOrder = 'ASC';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['search'])) {
        $searchTerm = trim($_GET['search']);
    }
    if (isset($_GET['category'])) {
        $searchCategory = $_GET['category'];
    }
    if (isset($_GET['sort'])) {
        $sortColumn = $_GET['sort'];
    }
    if (isset($_GET['order'])) {
        $sortOrder = $_GET['order'];
    }
}

$product_query = "SELECT * FROM product WHERE 1=1";

if ($searchTerm != '') {
    $product_query .= " AND (PRODUCT_NAME LIKE :searchTerm)";
}

if ($searchCategory != '' && $searchCategory != 'all') {
    $product_query .= " AND PRODUCT_TYPE = :searchCategory";
}

if ($sortColumn != '') {
    $product_query .= " ORDER BY " . $sortColumn . " " . $sortOrder;
}

$selectProduct = oci_parse($conn, $product_query);

if ($searchTerm != '') {
    $wildcardSearchTerm = '%' . $searchTerm . '%';
    oci_bind_by_name($selectProduct, ":searchTerm", $wildcardSearchTerm);
}

if ($searchCategory != '' && $searchCategory != 'all') {
    oci_bind_by_name($selectProduct, ":searchCategory", $searchCategory);
}

oci_execute($selectProduct);

$products = [];
while ($row = oci_fetch_assoc($selectProduct)) {
    $products[] = $row;
}

// Update admin_verified status if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $productId = $_POST['product_id'];
    $newStatus = $_POST['new_status'];

    $update_query = "UPDATE product SET ADMIN_VERIFIED = :newStatus WHERE PRODUCT_ID = :productId";
    $updateStmt = oci_parse($conn, $update_query);

    oci_bind_by_name($updateStmt, ":newStatus", $newStatus);
    oci_bind_by_name($updateStmt, ":productId", $productId);

    oci_execute($updateStmt);

    // Refresh the page to reflect the changes
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

    <style>
        .trader_search {
            display: flex;
            align-items: center;
        }

        .search_bar {
            margin-left: 2rem;
        }

        .layout-container {
            display: flex;
        }

        .trader_details {
            flex: 1;
            padding: 1rem;
        }

        .product_image {
            width: 50px;
            height: 50px;
            object-fit: cover;
        }

        .table_container {
            overflow-x: auto;
        }

        .allergy-info {
            max-width: 200px; /* Adjust as needed */
            white-space: normal; /* Wrap text */
            word-wrap: break-word;
        }
    </style>
</head>

<body>
    <div class="layout-container">
        <?php include "admin_navigation_pane.php"; ?>
        <div class="trader_details">
            <div class="container trader_search mt-3 mb-3">
                <h3>Product</h3>
                <form class="d-flex search_bar" role="search" method="get" action="">
                    <input class="form-control me-2" type="search" placeholder="Search" name="search" value="<?php echo htmlspecialchars($searchTerm); ?>" aria-label="Search">
                    <select class="form-select me-2" name="category">
                        <option value="all" <?php echo $searchCategory == 'all' ? 'selected' : ''; ?>>All Categories</option>
                        <option value="butchers" <?php echo $searchCategory == 'butchers' ? 'selected' : ''; ?>>Butchers</option>
                        <option value="greengrocer" <?php echo $searchCategory == 'greengrocer' ? 'selected' : ''; ?>>Greengrocer</option>
                        <option value="delicatessen" <?php echo $searchCategory == 'delicatessen' ? 'selected' : ''; ?>>Delicatessen</option>
                        <option value="fishmonger" <?php echo $searchCategory == 'fishmonger' ? 'selected' : ''; ?>>Fishmonger</option>
                        <option value="bakery" <?php echo $searchCategory == 'bakery' ? 'selected' : ''; ?>>Bakery</option>
                    </select>
                    <select class="form-select me-2" name="sort">
                        <option value="" disabled selected>Sort by</option>
                        <option value="PRODUCT_PRICE" <?php echo $sortColumn == 'PRODUCT_PRICE' ? 'selected' : ''; ?>>Price</option>
                        <option value="STOCK" <?php echo $sortColumn == 'STOCK' ? 'selected' : ''; ?>>Stock</option>
                    </select>
                    <select class="form-select me-2" name="order">
                        <option value="ASC" <?php echo $sortOrder == 'ASC' ? 'selected' : ''; ?>>Ascending</option>
                        <option value="DESC" <?php echo $sortOrder == 'DESC' ? 'selected' : ''; ?>>Descending</option>
                    </select>
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
            <div class="table_container">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Product Image</th>
                            <th scope="col">Product Name</th>
                            <th scope="col">Admin Verified</th>
                            <th scope="col">Type</th>
                            <th scope="col">Price</th>
                            <th scope="col">Stock</th>
                            <th scope="col">Allergy Info</th>
                            <th scope="col">Enable</th>
                            <th scope="col">Disable</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($products as $product) {
                            echo "<tr>";
                            echo "<th scope='row'><i class='icon fas fa-box'></i></th>";
                            echo "<td><img src='" . htmlspecialchars($product['PRODUCT_IMAGE_PATH']) . "' alt='Product Image' class='product_image'></td>";
                            echo "<td>" . htmlspecialchars($product['PRODUCT_NAME']) . "</td>";
                            echo "<td>" . htmlspecialchars($product['ADMIN_VERIFIED']) . "</td>";
                            echo "<td>" . htmlspecialchars($product['PRODUCT_TYPE']) . "</td>";
                            echo "<td>" . htmlspecialchars($product['PRODUCT_PRICE']) . "</td>";
                            echo "<td>" . htmlspecialchars($product['STOCK']) . "</td>";
                            echo "<td class='allergy-info'>" . htmlspecialchars($product['ALLERGY_INFORMATION']) . "</td>";
                            echo "<td>
                                <form method='POST' action=''>
                                    <input type='hidden' name='product_id' value='" . htmlspecialchars($product['PRODUCT_ID']) . "'>
                                    <input type='hidden' name='new_status' value='Y'>
                                    <button type='submit' class='btn btn-success'>Enable</button>
                                </form>
                            </td>";
                            echo "<td>
                                <form method='POST' action=''>
                                    <input type='hidden' name='product_id' value='" . htmlspecialchars($product['PRODUCT_ID']) . "'>
                                    <input type='hidden' name='new_status' value='N'>
                                    <button type='submit' class='btn btn-danger'>Disable</button>
                                </form>
                            </td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>

</html>
