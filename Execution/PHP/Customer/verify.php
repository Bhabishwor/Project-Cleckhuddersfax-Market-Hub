<?php

include "../connection/connection.php";

session_start();

if (isset($_GET['email']) && isset($_GET['v_code'])) {

    $email = $_GET['email'];
    $v_code = $_GET['v_code'];

    $query = "SELECT * FROM users WHERE user_email = :email AND verification_code = :verify";

    $bind_verify = oci_parse($conn, $query);

    oci_bind_by_name($bind_verify, ':email', $email);
    oci_bind_by_name($bind_verify, ':verify', $v_code);

    oci_execute($bind_verify);

    $row_user = oci_fetch_array($bind_verify, OCI_ASSOC);

    if ($row_user) {
        if ($row_user['USER_STATUS'] == "Not Verified") {
            $update_query = "UPDATE users SET user_status = 'Verified' WHERE user_email = :email";
            $bind_update = oci_parse($conn, $update_query);

            oci_bind_by_name($bind_update, ':email', $email);



            if (oci_execute($bind_update)) {
                $_SESSION['success_msg']="Email Verified Successfully";
                header("Location: ../login.php");
            } else {
                echo "
                <script>
                alert('Registration Failed');
                </script>
                ";
            }

        } else {
            echo "
            <script>
            alert('Email is already verified.');
            </script>
            ";
        }
    } else {
        echo "
        <script>
        alert('User with the email not found.');
        </script>
        ";
    }
}


?>