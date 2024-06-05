<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  <style>
    .dashboard-card {
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
      padding: 20px;
      margin-bottom: 20px;
      transition: transform 0.3s ease;
    }

    .dashboard-card:hover {
      transform: translateY(-5px);
    }

    .dashboard-card .icon {
      font-size: 3rem;
      color: #ffffff;
    }

    .traders-card {
      background: #007bff;
      color: #ffffff;
    }

    .customers-card {
      background: #28a745;
      color: #ffffff;
    }

    .orders-card {
      background: #ffc107;
      color: #ffffff;
    }

    .products-card {
      background: #17a2b8;
      color: #ffffff;
    }

    .card-title {
      font-size: 1.5rem;
      margin-top: 10px;
    }

    .card-number {
      font-size: 2.5rem;
      font-weight: bold;
    }

    .layout-container {
      display: flex;
    }

    .admin_dashboard {
      flex: 1;
      padding: 1rem;
    }
  </style>
</head>

<body>
  <div class="layout-container">
    <?php
    include "../connection/connection.php";
    include "admin_navigation_pane.php";

    $trader = "trader";
    $customer = "customer";

    $user_query = "SELECT COUNT(*) AS NUM_USER FROM users WHERE USER_ROLE = :userRole";
    $product_query = "SELECT COUNT(*) AS NUM_PRODUCT FROM product";
    $order_query = "SELECT COUNT(*) AS NUM_ORDER FROM confirm_order";

    // Fetch traders count
    $get_trader = oci_parse($conn, $user_query);
    oci_bind_by_name($get_trader, ":userRole", $trader);
    oci_execute($get_trader);
    $row = oci_fetch_assoc($get_trader);
    $num_trader = $row['NUM_USER'];

    // Fetch customers count
    $get_customer = oci_parse($conn, $user_query);
    oci_bind_by_name($get_customer, ":userRole", $customer);
    oci_execute($get_customer);
    $row = oci_fetch_assoc($get_customer);
    $num_customer = $row['NUM_USER'];

    // Fetch products count
    $get_product = oci_parse($conn, $product_query);
    oci_execute($get_product);
    $row = oci_fetch_assoc($get_product);
    $num_product = $row['NUM_PRODUCT'];

    // Fetch orders count
    $get_order = oci_parse($conn, $order_query);
    oci_execute($get_order);
    $row = oci_fetch_assoc($get_order);
    $num_order = $row['NUM_ORDER'];

    oci_free_statement($get_trader);
    oci_free_statement($get_customer);
    oci_free_statement($get_product);
    oci_free_statement($get_order);
    oci_close($conn);
    ?>
    <div class="admin_dashboard">
      <div class="container my-5">
        <div class="row">
          <div class="col-md-3">
            <div class="dashboard-card traders-card text-center">
              <div class="icon"><i class="fa fa-users"></i></div>
              <div class="card-title">Traders</div>
              <div class="card-number"><?php echo $num_trader; ?></div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="dashboard-card customers-card text-center">
              <div class="icon"><i class="fa fa-user"></i></div>
              <div class="card-title">Customers</div>
              <div class="card-number"><?php echo $num_customer; ?></div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="dashboard-card orders-card text-center">
              <div class="icon"><i class="fa fa-shopping-cart"></i></div>
              <div class="card-title">Orders</div>
              <div class="card-number"><?php echo $num_order; ?></div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="dashboard-card products-card text-center">
              <div class="icon"><i class="fa fa-box"></i></div>
              <div class="card-title">Products</div>
              <div class="card-number"><?php echo $num_product; ?></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>
