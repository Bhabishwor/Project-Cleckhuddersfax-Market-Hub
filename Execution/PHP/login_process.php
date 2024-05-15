<?php
include "connection/connection.php";
echo "hello";
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $error = 0;

    echo $email;


    if ($error == 0) {
        // Prepared statement to prevent SQL injection
        $query = "SELECT * FROM users WHERE user_email = :email AND user_role = :role";
        $stmt = oci_parse($conn, $query);

        oci_bind_by_name($stmt, ':email', $email);
        oci_bind_by_name($stmt, ':role', $role);

        oci_execute($stmt);

        if ($row = oci_fetch_assoc($stmt)) {
            echo $row;

            if (password_verify($password, $row['USER_PASSWORD'])) {
                session_start();
                $_SESSION['email'] = $email; 
                $_SESSION['role'] = $row['ROLE'];
                $_SESSION['id'] = $row['USER_ID'];
                $_SESSION['name'] = $row['USER_NAME'];
                $_SESSION['passmessage'] = "Logged in Successfully";
                header("Location: Customer/homepage.php");
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