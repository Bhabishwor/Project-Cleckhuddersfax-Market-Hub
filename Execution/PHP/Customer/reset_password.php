<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Community Harvest - Reset Password</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
  <style>
    body {
      background-image: url('container.png');
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
    }

    .container {
      background-color: rgba(255, 255, 255, 0.9); /* Add transparency */
      border-radius: 10px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
      padding: 15px; 
      margin: 50px auto;
      max-width: 600px;
      margin-top: 10em;
    }

    .logo-container {
      text-align: center;
      margin-bottom: 20px; /* Increased margin for better spacing */
    }

    .logo {
      max-width: 150px;
    }

    .green-heading {
      color: #28a745;
      font-weight: bold;
    }

    .btn-update {
      background-color: #28a745;
      border-color: #28a745;
      transition: background-color 0.3s ease, border-color 0.3s ease;
      margin-bottom: 2em;
    }

    .btn-update:hover {
      background-color: #218838;
      border-color: #1e7e34;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="row justify-content-center"> <!-- Center the content -->
      <div class="col-md-8"> <!-- Adjust column width for medium screens and above -->
        <div class="logo-container">
          <img src="logo.png" alt="Community Harvest Logo" class="logo">
        </div>
        <h1 class="text-center mb-4 green-heading">Reset Password</h1>

        <form class="mt-4">
          <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username">
          </div>
          <div class="mb-3">
            <label for="current-password" class="form-label">Current Password</label>
            <input type="password" class="form-control" id="current-password" name="current-password" placeholder="Enter your current password">
          </div>
          <div class="mb-3">
            <label for="new-password" class="form-label">New Password</label>
            <input type="password" class="form-control" id="new-password" name="new-password" placeholder="Enter your new password">
          </div>
          <div class="mb-3">
            <label for="confirm-password" class="form-label">Confirm New Password</label>
            <input type="password" class="form-control" id="confirm-password" name="confirm-password" placeholder="Retype your new password">
          </div>

          <div class="text-center">
            <button type="submit" class="btn btn-lg btn-update">Update Password</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
