<?php
include "../connection/connection.php";
session_start(); // Start the session at the beginning of the script

$email = $_SESSION['email'];

// Fetch trader details from the database
$sql = "SELECT * FROM TRADER WHERE TRADER_EMAIL = :email";
$stmt = oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':email', $email);
oci_execute($stmt);

if (!$stmt) {
    $error = oci_error($conn); // Get Oracle error
    echo "Oracle Error: " . $error['message'];
    exit();
}

$trader = oci_fetch_assoc($stmt);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Trader Profile</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<style>
/* Updated Custom CSS for Profile Section */

.profile-info {
    padding: 20px;
    background-color: #f8f9fa;
    border-radius: 8px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
}

.profile-info h2 {
    color: green;
    font-size: 36px;
    margin-bottom: 20px;
    border-bottom: 2px solid #ddd;
    padding-bottom: 10px;
}

.profile-info p {
    font-size: 18px;
    line-height: 1.6;
    margin-bottom: 10px;
    padding: 10px;
}

.profile-info p strong {
    font-weight: bold;
}

.profile-info p:last-child {
    margin-bottom: 0;
}

.profile-info p i {
    font-size: 24px;
    margin-right: 10px;
    color: green;
}

.profile-info img {
    display: block;
    max-width: 100%;
    height: auto;
    margin-top: 10px;
    border: 2px solid #007bff;
    border-radius: 8px;
}

.edit-profile {
    margin-top: 30px;
    text-align: right;
}

.edit-profile button {
    background-color: green;
    color: #fff;
    border: none;
    padding: 12px 24px;
    border-radius: 6px;
    cursor: pointer;
    transition: background-color 0.3s ease;
    font-size: 18px;
    display: inline-block;
    margin-right: 20px;
}

.edit-profile button:hover {
    background-color: green;
}
.profile-image img {
    width: 120px; /* Adjust the width as needed */
    height: 120px; /* Adjust the height as needed */
}

.profile-image {
    overflow: hidden;
    border-radius: 50%;
}

</style>
</head>
<body>
<div class="container-fluid" style="margin-top: 4em; margin: left 4em;">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-lg-3 col-md-4">
            <?php include 'trader_navigation_pane.php'; ?>
        </div>
        <!-- Main Content -->
        <div class="col-lg-9 col-md-8">
            <div class="profile-info">
                <div class="d-flex align-items-center mb-4">
                    <!-- Display trader shop image in a circular shape -->
                    <div class="profile-image me-4">
                        <img src="<?php echo htmlspecialchars($trader['TRADER_SHOP_IMAGE']); ?>" alt="Shop Image" class="img-fluid rounded-circle">
                    </div>
                    <!-- Trader information -->
                    <div>
                        <h2 class="mb-0">Trader Profile</h2>
                        <p class="mb-1"><i class="fas fa-user icon"></i><strong>Name:</strong> <?php echo htmlspecialchars($trader['TRADER_NAME']); ?></p>
                        <p class="mb-1"><i class="fas fa-envelope icon"></i><strong>Email:</strong> <?php echo htmlspecialchars($trader['TRADER_EMAIL']); ?></p>
                        <p class="mb-1"><i class="fas fa-phone icon"></i><strong>Phone Number:</strong> <?php echo htmlspecialchars($trader['TRADER_PHONE_NUMBER']); ?></p>
                        <p class="mb-1"><i class="fas fa-home icon"></i><strong>Address:</strong> <?php echo htmlspecialchars($trader['TRADER_ADDRESS']); ?></p>
                        <p class="mb-1"><i class="fas fa-store icon"></i><strong>Shop:</strong> <?php echo htmlspecialchars($trader['TRADER_SHOP']); ?></p>
                    </div>
                </div>
                <!-- Edit profile button -->
                <div class="edit-profile">
                    <a href="edit_trader.php?trader_id=<?php echo htmlspecialchars($trader['TRADER_ID']); ?>"><button class="btn btn-primary">Edit Profile</button></a>
                </div>
            </div>
        </div>
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
