<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin navigation pane</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome CSS -->
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
      transition: transform 0.3s ease-in-out; /* Added transition effect */
      transform: translateX(0); /* Keep sidebar open by default */
      z-index: 999; /* Set higher z-index */
      background-image: url('container.png');
      background-size: cover; /* Cover the entire sidebar */
      background-repeat: no-repeat; /* Do not repeat the image */
      font-size: 1.5em;

    }

    .sidebar-logo {
      text-align: center;
      margin-bottom: 30px; /* Increased margin-bottom */
    }

    .nav-link {
      padding: 10px;
      display: block;
      color: #fff;
      text-decoration: none;
    }

    .nav-link i {
      margin-right: 10px; /* Add margin between icon and text */
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
      display: none; /* Hide hamburger icon by default */
    }

    @media (max-width: 768px) {
      .sidebar {
        width: 250px;
        transform: translateX(-250px); /* Initially hide sidebar on small screens */
      }

      .sidebar.open {
        transform: translateX(0); /* Show sidebar when open class is added */
      }

      .hamburger {
        display: block; /* Show hamburger icon on small screens */
        position: fixed;
        top: 10px;
        left: 10px;
        z-index:1000; /* Ensure it's above other content */
        background-color: #fff; /* Button background color */
        border: none;
        padding: 10px;
        border-radius: 5px;
        cursor: pointer;
      }

      .hamburger:hover {
        background-color: #ccc;
      }

      .main-content {
        padding-left: 20px; /* Adjust padding to make space for hamburger icon */
      }
    }
  </style>
</head>
<body>
  <!-- Hamburger Icon -->
  <div class="hamburger d-lg-none" onclick="toggleSidebar()">
    &#9776; <!-- Hamburger icon -->
  </div>

  <div class="container-fluid">
    <div class="row">
      <!-- Sidebar -->
      <div class="col-lg-3 col-md-4">
        <div class="sidebar" id="sidebar">
          <div>
            <div class="sidebar-logo">
              <img src="logo.png" alt="Logo" style="width: 150px;">
            </div>
            <ul class="nav flex-column">
              <li class="nav-item">
                <a class="nav-link home" href="#"><i class="fas fa-home"></i> Home</a>
                <ul class="submenu">
                  <li><a class="nav-link" href="#"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                  <li><a class="nav-link" href="#"><i class="fas fa-chart-line"></i> Analytics</a></li>
                </ul>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#"><i class="fas fa-users"></i> Trader</a>
                <ul class="submenu">
                  <li><a class="nav-link" href="#"><i class="fas fa-info-circle"></i> Trader Information</a></li>
                </ul>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#"><i class="fas fa-sign-in-alt"></i> Authentication</a>
              </li>
            </ul>
          </div>
          <div class="username-box">
            <p>Username</p>
            <p>User@example.com</p>
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
