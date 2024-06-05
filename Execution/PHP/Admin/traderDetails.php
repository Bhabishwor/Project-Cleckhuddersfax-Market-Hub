<?php

include "../connection/connection.php";

// Default query to select all verified traders
$trader_query = "SELECT * FROM users WHERE USER_ROLE = :userRole AND USER_STATUS = :userStatus";
$selectTrader = oci_parse($conn, $trader_query);

$userRole = 'trader';
$userStatus = 'Verified';

oci_bind_by_name($selectTrader, ":userRole", $userRole);
oci_bind_by_name($selectTrader, ":userStatus", $userStatus);

oci_execute($selectTrader);

$verified_traders = [];
while ($row = oci_fetch_assoc($selectTrader)) {
    $verified_traders[] = $row;
}

// Search functionality
$searchTerm = '';
$searchCategory = '';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && (isset($_GET['search']) || isset($_GET['category']))) {
    $searchTerm = trim($_GET['search']);
    $searchCategory = $_GET['category'];

    $searchQuery = "SELECT * FROM users WHERE USER_ROLE = :userRole AND USER_STATUS = :userStatus";

    if ($searchTerm != '') {
        $searchQuery .= " AND (USER_NAME LIKE :searchTerm OR USER_EMAIL LIKE :searchTerm)";
    }

    if ($searchCategory != '' && $searchCategory != 'all') {
        $searchQuery .= " AND USER_SHOP = :searchCategory";
    }

    $selectSearchTrader = oci_parse($conn, $searchQuery);

    oci_bind_by_name($selectSearchTrader, ":userRole", $userRole);
    oci_bind_by_name($selectSearchTrader, ":userStatus", $userStatus);

    if ($searchTerm != '') {
        $wildcardSearchTerm = '%' . $searchTerm . '%';  // Add wildcards here
        oci_bind_by_name($selectSearchTrader, ":searchTerm", $wildcardSearchTerm);
    }

    if ($searchCategory != '' && $searchCategory != 'all') {
        oci_bind_by_name($selectSearchTrader, ":searchCategory", $searchCategory);
    }

    oci_execute($selectSearchTrader);

    $verified_traders = [];
    while ($row = oci_fetch_assoc($selectSearchTrader)) {
        $verified_traders[] = $row;
    }
}

// Update admin_verified status if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['user_id'];
    $newStatus = $_POST['new_status'];

    $update_query = "UPDATE users SET ADMIN_VERIFIED = :newStatus WHERE USER_ID = :userId";
    $updateStmt = oci_parse($conn, $update_query);
    
    oci_bind_by_name($updateStmt, ":newStatus", $newStatus);
    oci_bind_by_name($updateStmt, ":userId", $userId);

    oci_execute($updateStmt);

    // Refresh the page to reflect the changes
    header("Location: ".$_SERVER['PHP_SELF']);
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trader Details</title>
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
    </style>
</head>

<body>
    <div class="layout-container">
        <?php include "admin_navigation_pane.php"; ?>
        <div class="trader_details">
            <div class="container trader_search mt-3 mb-3">
                <h3>Trader</h3>
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
                    <button class="btn btn-outline-success" type="submit">Search</button>
                </form>
            </div>
            <div class="table_container">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th scope="col"></th>
                            <th scope="col">Trader</th>
                            <th scope="col">Email</th>
                            <th scope="col">Admin Verified</th>
                            <th scope="col">Shop Type</th>
                            <th scope="col">Enable</th>
                            <th scope="col">Disable</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($verified_traders as $verified_trader) {
                            echo "<tr>";
                            echo "<th scope='row'><i class='icon fas fa-user'></i></th>";
                            echo "<td>" . htmlspecialchars($verified_trader['USER_NAME']) . "</td>";
                            echo "<td>" . htmlspecialchars($verified_trader['USER_EMAIL']) . "</td>";
                            echo "<td>" . htmlspecialchars($verified_trader['ADMIN_VERIFIED']) . "</td>";
                            echo "<td>" . htmlspecialchars($verified_trader['USER_SHOP']) . "</td>";
                            echo "<td>
                                <form method='POST' action=''>
                                    <input type='hidden' name='user_id' value='" . htmlspecialchars($verified_trader['USER_ID']) . "'>
                                    <input type='hidden' name='new_status' value='Y'>
                                    <button type='submit' class='btn btn-success'>Enable</button>
                                </form>
                            </td>";
                            echo "<td>
                                <form method='POST' action=''>
                                    <input type='hidden' name='user_id' value='" . htmlspecialchars($verified_trader['USER_ID']) . "'>
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
