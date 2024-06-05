<?php
include "../connection/connection.php";

// Define the sanitize function
function sanitize($input) {
    return htmlspecialchars($input, ENT_QUOTES, 'UTF-8');
}

// Check if the customer is logged in
session_start();
if (!isset($_SESSION['email'])) {
    echo "Email not set in session.";
    exit();
}

$email = $_SESSION['email'];

// Fetch customer details from the database
$sql = "SELECT * FROM USERS WHERE USER_EMAIL = :email";
$stmt = oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':email', $email);
oci_execute($stmt);

if (!$stmt) {
    $error = oci_error($conn); // Get Oracle error
    echo "Oracle Error: " . $error['message'];
    exit();
}

$customer = oci_fetch_assoc($stmt);

// Update customer information
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize form inputs
    $customerName = sanitize($_POST['customerName']);
    $customerPhone = sanitize($_POST['customerPhone']);
    $customerAddress = sanitize($_POST['customerAddress']);

    // Update customer data
    $updateSql = "UPDATE USERS SET USER_NAME = :customerName, USER_PHONE_NUMBER = :customerPhone, USER_ADDRESS = :customerAddress WHERE USER_EMAIL = :email";
    $updateStmt = oci_parse($conn, $updateSql);
    oci_bind_by_name($updateStmt, ":customerName", $customerName);
    oci_bind_by_name($updateStmt, ":customerPhone", $customerPhone);
    oci_bind_by_name($updateStmt, ":customerAddress", $customerAddress);
    oci_bind_by_name($updateStmt, ":email", $email);

    if (oci_execute($updateStmt)) {
        echo "Profile updated successfully";
        header("Location: customer_profile.php");
    } else {
        $e = oci_error($updateStmt);
        echo "Error: " . $e['message'];
    }

    oci_free_statement($updateStmt);
}

oci_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Profile</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <style>
    /* Style for body with Background Image */
    .h1{
        font-size: 10em;
        color: white;
    }
    body {
        background-image: url('../../Image/container.png');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        height: 100vh; /* Set body height to full viewport height */
        margin: 0; /* Remove default margin */
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* Style for Edit Profile Form */
    #profileForm {
        width: 80%; /* Adjust width of the form */
        max-width: 400px; /* Set maximum width of the form */
        padding: 30px; /* Add padding to the form */
        background-color: rgba(255, 255, 255, 0.9); /* Set form background color to semi-transparent white */
        border-radius: 10px; /* Add border-radius for rounded corners */
        box-shadow: 0px 0px 20px 0px rgba(0,0,0,0.2); /* Add box shadow for depth */
    }

    #profileForm .mb-3 {
        margin-bottom: 20px;
    }

    #profileForm label {
        font-weight: bold;
    }

    /* Style for Update Profile Button */
    #updateProfileBtn {
        margin-top: 20px; /* Add margin to the bottom of the form */
    }
  </style>
</head>
<body>
  <!-- Edit Profile Form -->
  <div class="container" style="margin-left:50em;">
  <div class="h1">
    <h1>EDIT PROFILE</h1>
  </div>
    <?php if ($customer): ?>
    <form id="profileForm" method="post" action="">
      <div class="mb-3">
        <label for="customerName" class="form-label">Customer Name</label>
        <input type="text" class="form-control" id="customerName" name="customerName" value="<?php echo htmlspecialchars($customer['USER_NAME']); ?>" required>
      </div>
      <div class="mb-3">
        <label for="customerPhone" class="form-label">Phone Number</label>
        <input type="text" class="form-control" id="customerPhone" name="customerPhone" value="<?php echo htmlspecialchars($customer['USER_PHONE_NUMBER']); ?>" required>
      </div>
      <div class="mb-3">
        <label for="customerAddress" class="form-label">Address</label>
        <input type="text" class="form-control" id="customerAddress" name="customerAddress" value="<?php echo htmlspecialchars($customer['USER_ADDRESS']); ?>" required>
      </div>
      <button type="submit" class="btn btn-primary" id="updateProfileBtn">Update Profile</button>
    </form>
    <?php else: ?>
        <p>Customer not found.</p>
    <?php endif; ?>
  </div>
  
  <!-- Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
