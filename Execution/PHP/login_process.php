<?php
include "connection/connection.php";

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $error = 0;


    if ($email == "admin@communityharvest.com" && $password == "admin123") {
        header("Location: Admin/admin_dashboard.php");
    } elseif ($error == 0) {

        // Prepared statement to prevent SQL injection
        $query = "SELECT * FROM users WHERE user_email = :email AND user_role = :role";
        $stmt = oci_parse($conn, $query);

        oci_bind_by_name($stmt, ':email', $email);
        oci_bind_by_name($stmt, ':role', $role);

        oci_execute($stmt);

        if ($row = oci_fetch_assoc($stmt)) {

            $is_verified = $row['USER_STATUS'];
            $is_adminVerified = $row['ADMIN_VERIFIED'];

            if (md5($password) === $row['USER_PASSWORD']) {
                if ($is_verified == "Verified" && $is_adminVerified == "Y") {

                    $_SESSION['email'] = $row['USER_EMAIL'];
                    $_SESSION['role'] = $row['USER_ROLE'];
                    $_SESSION['id'] = $row['USER_ID'];
                    $_SESSION['name'] = $row['USER_NAME'];
                    $_SESSION['passmessage'] = "Logged in Successfully";

                    if ($_SESSION['role'] == "customer") {
                        header("Location: Customer/homepage.php");
                    }
                    if ($_SESSION['role'] == "trader") {
                        header("Location: Trader/trader_profile.php");
                    }
                } else {
                    $_SESSION['failmessage'] = "User is not Verified";
                    header("Location: login.php");
                }
            } else {
                $_SESSION['failmessage'] = "Authentication failed! Wrong Credentials entered";
                header("Location: login.php");
            }
        } else {
            $_SESSION['failmessage'] = "Authentication failed! Wrong Credentials entered";
            header("Location: login.php");
        }

        oci_free_statement($stmt); // Close the statement handle
    }
}

?>