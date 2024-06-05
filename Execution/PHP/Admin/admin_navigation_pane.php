<?php
$currentPage = basename($_SERVER['SCRIPT_FILENAME'], ".php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin navigation pane</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

  <style>
    /* Sidebar CSS */
    .sidebar {
      position: fixed;
      top: 0;
      left: 0;
      height: 100%;
      width: 250px;
      color: #fff;
      padding-top: 20px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      transition: transform 0.3s ease-in-out;
      transform: translateX(0);
      z-index: 999;
      background-image: url('../../Image/heritage/container1.png');
      background-size: cover;
      background-repeat: no-repeat;
      font-size: 1.5em;
    }

    .sidebar-logo {
      text-align: center;
      margin-bottom: 30px;
    }

    .nav-link {
      padding: 10px;
      display: block;
      color: #fff;
      text-decoration: none;
    }

    .nav-link i {
      margin-right: 10px;
    }

    .nav-link:hover {
      background-color: #555;
    }

    .submenu {
      display: none;
    }

    .nav-item:hover .submenu {
      display: block;
    }

    .username-box {
      background-color: #fff;
      padding: 10px;
      border-radius: 5px;
      color: #000;
      font-size: 14px;
      width: 200px;
      text-align: center;
      cursor: pointer;
      margin: 0 auto 20px;
    }

    /* Hamburger Icon CSS */
    .hamburger {
      display: none;
    }

    @media (max-width: 768px) {
      .sidebar {
        width: 250px;
        transform: translateX(-250px);
      }

      .sidebar.open {
        transform: translateX(0);
      }

      .hamburger {
        display: block;
        position: fixed;
        top: 10px;
        left: 10px;
        z-index: 1000;
        background-color: #fff;
        border: none;
        padding: 10px;
        border-radius: 5px;
        cursor: pointer;
      }

      .hamburger:hover {
        background-color: #ccc;
      }

      .main-content {
        padding-left: 20px;
      }
    }

    ul {
      list-style: none;
      padding: 0;
      margin: 0;
    }
  </style>
</head>

<body>
  <!-- Hamburger Icon -->
  <div class="hamburger d-lg-none" onclick="toggleSidebar()">
    &#9776; <!-- Hamburger icon -->
  </div>

  <div class="container w-25">
    <div class="row">
      <!-- Sidebar -->
      <div class="col-lg-3 col-md-4">
        <div class="sidebar" id="sidebar">
          <div>
            <div class="sidebar-logo">
              <img src="../../Image/logo.png" alt="Logo" style="width: 150px;">
            </div>
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link" href="http://127.0.0.1:8080/apex/f?p=101:LOGIN_DESKTOP:11239751698703:::::"><i class="fas fa-chart-line"></i> Dashboard</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="admin_dashboard.php"><i class="fas fa-chart-pie"></i> Analytics Report</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="traderDetails.php"><i class="fas fa-users"></i> Trader</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="customerDetails.php"><i class="fas fa-users"></i> Customer</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="productDetails.php"><i class="fas fa-box"></i> Product</a>
              </li>
            </ul>
          </div>
          <div class="username-box" style="width: auto;">
            <?php
            echo "<p>Admin</p>";
            echo "<p>admin@communityharvest.com</p>";
            ?>
            <form action="../logout.php" method="post">
              <button class="btn btn-outline-success logoutBtn" type="submit">
                <i class="fas fa-sign-out-alt"></i>
                Logout
              </button>
            </form>
          </div>
        </div>
      </div>
      <!-- Main Content -->
      <!--<div class="col-lg-9 col-md-8 main-content">
    <h1>Main Content Area</h1>
    </div>-->
    </div>
  </div>

  <!-- Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    function toggleSidebar() {
      document.getElementById('sidebar').classList.toggle('open');
    }
  </script>
</body>

</html>