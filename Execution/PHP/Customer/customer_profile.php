<?php
include "../connection/connection.php";
include "header.php";

// Check if the 'name', 'email', and 'customerId' session variables are set
$name = isset($_SESSION['name']) ? $_SESSION['name'] : '';
$email = isset($_SESSION['email']) ? $_SESSION['email'] : '';
$id = isset($_SESSION['id']) ? $_SESSION['id'] : '';

// Redirect if the customer is not logged in
if (!isset($_SESSION['email'])) {
    echo "Email not set in session.";
    exit();
}

// Fetch customer details from the database
$sql = "SELECT * FROM USERS WHERE USER_ID = :userId";
$stmt = oci_parse($conn, $sql);
oci_bind_by_name($stmt, ':userId', $id);
oci_execute($stmt);

if (!$stmt) {
    $error = oci_error($conn); // Get Oracle error
    echo "Oracle Error: " . $error['message'];
    exit();
}

$customer = oci_fetch_assoc($stmt);
?>

<!DOCTYPE html>
<html lang="en">

<head>


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome CSS -->
    <style>
        /* Updated Custom CSS for Profile Section */
        /* Global Styles */

        .container-fluid {
            padding-right: 15px;
            padding-left: 15px;
            margin-right: auto;
            margin-left: auto;
        }

        /* Profile Section */
        .profile-info {
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .profile-info h2 {
            color: green;
            font-size: 40px;
            margin-bottom: 30px;
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
        }

        .profile-info p {
            font-size: 18px;
            line-height: 1.6;
            margin-bottom: 10px;
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

        .profile-info .edit-profile {
            margin-top: 30px;
            text-align: right;
        }

        .profile-info .edit-profile a.btn {
            background-color: green;
            color: #fff;
            border: none;
            padding: 12px 24px;
            border-radius: 6px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            font-size: 18px;
            display: inline-block;
        }

        .editBtn {
            float: right;
        }
    </style>
</head>

<body>

    <!-- Main Content -->
    <div class="container-fluid" style="margin-bottom: 15rem;">
        <div class="profile-info" style="margin : 5rem 10rem">
            <h2><i class="fas fa-user-circle icon">&nbsp;</i>Welcome to Your Profile</h2>
            <?php if ($customer) : ?>
                <p><i class="fas fa-user icon"></i><strong>Name:</strong> <?php echo htmlspecialchars($customer['USER_NAME']); ?></p>
                <p><i class="fas fa-phone icon"></i><strong>Phone Number:</strong> <?php echo htmlspecialchars($customer['USER_PHONE_NUMBER']); ?></p>
                <p><i class="fas fa-envelope icon"></i><strong>Email:</strong> <?php echo htmlspecialchars($customer['USER_EMAIL']); ?></p>
                <p><i class="fas fa-map-marker-alt icon"></i><strong>Address:</strong> <?php echo htmlspecialchars($customer['USER_ADDRESS']); ?></p>
                <p><i class="fas fa-check-circle icon"></i><strong>Status:</strong> <?php echo htmlspecialchars($customer['USER_STATUS']); ?></p>
                <a href="edit_customer.php" class="editBtn mt-5">
                    <button class="btn btn-success"><i class="fas fa-edit"></i> Edit Profile</button></a>
            <?php else : ?>
                <p>Customer information not found.</p>
            <?php endif; ?>
        </div>
    </div>


    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
    
</body>
<?php include "footer.php"; ?>

</html>