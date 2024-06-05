<?php
include "../connection/connection.php";
session_start(); // Start the session at the beginning of the script

$email = $_SESSION['email'];

// Fetch trader details from the database
$sql = "SELECT * FROM users WHERE USER_EMAIL = :email";
$stmt = oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':email', $email);
oci_execute($stmt);

if (!$stmt) {
    $error = oci_error($conn); // Get Oracle error
    echo "Oracle Error: " . $error['message'];
    exit();
}

$trader = oci_fetch_assoc($stmt);

// Close the statement after fetching data
oci_free_statement($stmt);

// Update Trader Profile
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $traderName = htmlspecialchars($_POST['traderName']);
    $traderPhoneNumber = htmlspecialchars($_POST['traderPhoneNumber']);
    $traderAddress = htmlspecialchars($_POST['traderAddress']);
    $traderEmail = htmlspecialchars($_POST['traderEmail']);
    $traderShop = $trader['USER_SHOP']; // Use the trader's existing shop type from the database

    // Handle image upload
    $uploadDirectory = "../../Uploaded_Image/Trader/";
    $targetFileName = uniqid() . '_' . basename($_FILES["traderShopImage"]["name"]);
    $targetFilePath = $uploadDirectory . $targetFileName;
    $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
    $validExtensions = array("jpg", "jpeg", "png", "gif");

    $updateImage = false; // Flag to check if image needs to be updated

    // Check if image file is selected and valid
    if (!empty($_FILES["traderShopImage"]["tmp_name"]) && in_array($imageFileType, $validExtensions)) {
        // Move uploaded image to the upload directory
        if (move_uploaded_file($_FILES["traderShopImage"]["tmp_name"], $targetFilePath)) {
            $updateImage = true;
        } else {
            echo "Error uploading image";
        }
    } elseif (!empty($_FILES["traderShopImage"]["tmp_name"]) && !in_array($imageFileType, $validExtensions)) {
        echo "Invalid file type";
        exit();
    }

    // Update trader data in the database
    if ($updateImage) {
        $updateSql = "UPDATE USERS SET USER_NAME = :traderName, USER_PHONE_NUMBER = :traderPhoneNumber, USER_ADDRESS = :traderAddress, USER_EMAIL = :traderEmail, USER_SHOP = :traderShop, USER_SHOP_IMAGE = :traderShopImage WHERE USER_EMAIL = :email";
    } else {
        $updateSql = "UPDATE USERS SET USER_NAME = :traderName, USER_PHONE_NUMBER = :traderPhoneNumber, USER_ADDRESS = :traderAddress, USER_EMAIL = :traderEmail, USER_SHOP = :traderShop WHERE USER_EMAIL = :email";
    }

    $updateStmt = oci_parse($conn, $updateSql);
    oci_bind_by_name($updateStmt, ":traderName", $traderName);
    oci_bind_by_name($updateStmt, ":traderPhoneNumber", $traderPhoneNumber);
    oci_bind_by_name($updateStmt, ":traderAddress", $traderAddress);
    oci_bind_by_name($updateStmt, ":traderEmail", $traderEmail);
    oci_bind_by_name($updateStmt, ":traderShop", $traderShop);
    if ($updateImage) {
        oci_bind_by_name($updateStmt, ":traderShopImage", $targetFilePath);
    }
    oci_bind_by_name($updateStmt, ":email", $email);

    if (oci_execute($updateStmt)) {
        echo "Trader profile updated successfully";
        // Redirect to the trader profile page after successful update
        header("Location: trader_profile.php");
        exit();
    } else {
        echo "Error updating trader profile";
    }

    oci_free_statement($updateStmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Trader</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <style>
    /* Style for body with Background Image */
    body {
        background-image: url('../../Image/heritage/navigation_pane.png');
        background-size: cover;
        background-repeat: no-repeat;
        background-position: center;
        height: 100vh; /* Set body height to full viewport height */
        margin: 10rem 0 0 10rem; /* Remove default margin */
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* Style for Edit Trader Form */
    #traderForm {
        width: 80%; /* Adjust width of the form */
        max-width: 400px; /* Set maximum width of the form */
        padding: 30px; /* Add padding to the form */
        background-color: rgba(255, 255, 255, 0.9); /* Set form background color to semi-transparent white */
        border-radius: 10px; /* Add border-radius for rounded corners */
        box-shadow: 0px 0px 20px 0px rgba(0,0,0,0.2); /* Add box shadow for depth */
    }

    #traderForm .mb-3 {
        margin-bottom: 20px;
    }

    #traderForm label {
        font-weight: bold;
    }

    /* Style for Edit Trader Button */
    #updateTraderBtn {
        margin-top: 20px; /* Add margin to the bottom of the form */
    }
  </style>
</head>
<body>
  <!-- Edit Trader Form -->
  <div class="container mb-5">
    <h1>Edit Trader</h1>
    <?php if ($trader): ?>
    <form id="traderForm" method="post" enctype="multipart/form-data" action="">
      <!-- Input fields to edit trader details -->
      <div class="mb-3">
        <label for="traderName" class="form-label">Trader Name</label>
        <input type="text" class="form-control" id="traderName" name="traderName" value="<?php echo htmlspecialchars($trader['USER_NAME']); ?>" required>
      </div>
      <div class="mb-3">
        <label for="traderPhoneNumber" class="form-label">Trader Phone Number</label>
        <input type="number" class="form-control" id="traderPhoneNumber" name="traderPhoneNumber" value="<?php echo htmlspecialchars($trader['USER_PHONE_NUMBER']); ?>" required>
      </div>
      <div class="mb-3">
        <label for="traderAddress" class="form-label">Trader Address</label>
        <input type="text" class="form-control" id="traderAddress" name="traderAddress" value="<?php echo htmlspecialchars($trader['USER_ADDRESS']); ?>">
      </div>
      <div class="mb-3">
        <label for="traderEmail" class="form-label">Trader Email</label>
        <input type="email" class="form-control" id="traderEmail" name="traderEmail" value="<?php echo htmlspecialchars($trader['USER_EMAIL']); ?>" required>
      </div>

      <div class="mb-3">
        <label for="traderShop" class="form-label">Trader Shop</label>
        <input type="text" class="form-control" id="traderShop" name="traderShop" value="<?php echo htmlspecialchars($trader['USER_SHOP']); ?>" readonly>
      </div>

      <div class="mb-3">
        <label for="traderShopImage" class="form-label">Trader Shop Image</label>
        <?php if (!empty($trader['USER_SHOP_IMAGE'])): ?>
            <img src="<?php echo htmlspecialchars($trader['USER_SHOP_IMAGE']); ?>" alt="Trader Shop Image" class="img-fluid mb-3">
        <?php endif; ?>
        <input type="file" class="form-control" id="traderShopImage" name="traderShopImage" accept="image/*">
      </div>
      <button type="submit" class="btn btn-primary" id="updateTraderBtn">Update Trader</button>
    </form>
    <?php else: ?>
        <p>Trader not found.</p>
    <?php endif; ?>
  </div>

  <!-- Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>