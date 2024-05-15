<?php
include "connection/connection.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Register With Us</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

    <link rel="stylesheet" href="../CSS/styles.css" />

    <style type="">

        .error{
            color: red;
            font-style: italic;
        }

        #customer_message{
            margin-top: 20px;
        }


    </style>
</head>

<body>

    <?php
    session_start();
    $error_name = $error_email = $error_phone = $error_username = $error_passwd = $error_passwdConfirm = '';
    if (isset($_POST['registerBtn'])) {
        $name = $_POST['fullname'];
        $email = $_POST['email'];
        $phone = $_POST['phoneNum'];
        $username = $_POST['username'];
        $password = $_POST['upassword'];
        $password_confirm = $_POST['cpassword'];
        $role = "customer";
        $status = "Not Verified";
        $error = 0;

        // Session
    
        $_SESSION['name'] = $name;
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
        $_SESSION['phone'] = $phone;



        if (strlen($name) < 5) {
            $error_name = "Fullname should be atleast six characters";
            $error++;
        }

        if ($name == null) {
            $error_name = "Please enter your fullname first";
            $error++;
        }


        if (strlen($username) < 5) {
            $error_username = "Username should be atleast five characters";
            $error++;
        }


        if ($username == "") {
            $error_username = "Please enter your username";
            $error++;
        }


        if (!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email)) {
            $error_email = "Please enter a valid email, like yourname@abc.com";
            $error++;
        }

        if ($email == "") {
            $error_email = "Please enter your email";
            $error++;
        }

        if (!preg_match('/^[0-9]{10}+$/', $phone)) {
            $error_phone = "Please enter valid mobile number";
            $error++;
        }

        if ($phone == "") {
            $error_phone = "Please enter your mobile number";
            $error++;
        }


        if (!preg_match('@[A-Z]@', $password)) {
            $error_passwd = "Password must include an uppercase character";
            $error++;
        }

        if (!preg_match('@[a-z]@', $password)) {
            $error_passwd = "Password must include a lowercase character";
            $error++;
        }

        if (!preg_match('@[0-9]@', $password)) {
            $error_passwd = "Password must include a number";
            $error++;
        }

        if (!preg_match('@[^\w]@', $password)) {
            $error_passwd = "Password must include special character";
            $error++;
        }

        if (strlen($password) < 6) {
            $error_passwd = "Password must be greater than six characters";
            $error++;
        }

        if ($password == "") {
            $error_passwd = "Please enter password";
            $error++;
        }

        if ($password_confirm == "") {
            $error_passwdConfirm = "No password given";
            $error++;
        }

        if ($password != $password_confirm) {
            $error_passwdConfirm = "Password does not match";
            $error++;
        }

        $check_email = "";
        $Result_email = "";


        if ($error == 0) {
            $password = password_hash(
                $password,
                PASSWORD_DEFAULT
            );



            //$query = "INSERT INTO Register_Customer(Customer_Name, Customer_Email, Customer_Phone, Customer_Age, Customer_Gender, Customer_Username, Customer_Pass, Customer_Role) VALUES ('$name', '$email', '$phone', '$age', '$gender', '$username', '$password', '$role')";
    
            $query = "INSERT INTO customer(customer_id, customer_name, customer_email, customer_phone_number, customer_username, customer_password, role, status) VALUES (2 ,'$name', '$email', '$phone', '$username', '$password', '$role', '$status')";

            //mysqli_query($connect, $query);  N
    
            if ($result = oci_parse($conn, $query))
                ; {
                oci_execute($result);

                $success = "Registration successful";


                $_SESSION['passmessage'] = "Account Registration Successful, click to <a href='login.php'>verify</a>";

                $select_email = "SELECT * FROM customer where customer_email = '$email'";
                $email_result = oci_parse($conn, $select_email);
                oci_execute($email_result);
                //echo $select_email;
                //die();
    

                // if ($row = oci_fetch_assoc($email_result)) {
                //     $token = openssl_random_pseudo_bytes(16);
                //     $userID = $row['USER_ID'];
                //     $token = bin2hex($token);
    
                //     $token_query = "INSERT INTO PASSWORD_RESET VALUES ('$token', '$userID')";
                //     $token_result = oci_parse($conn, $token_query);
                //     oci_execute($token_result);
                //     header("Location: customer_verify_email.php?token=$token&id=$userID&email=$email");
                // }
    
                $_SESSION['name'] = "";
                $_SESSION['username'] = "";
                $_SESSION['email'] = "";
                $_SESSION['phone'] = "";
                session_destroy();
                // $_SESSION['passmessage'] = "Account Registration Successful";
                // header("Location: login.php");
    
                $target_url = "login.php";

                // Set refresh time to 1 second and target URL
                echo '<meta http-equiv="refresh" content="1;url=' . $target_url . '">';
            }
            //echo $query;
        }

    }


    ?>

    <img src="../Image/Logo.png" class="img-fluid rounded mx-auto d-block" height="50px" width="70px" alt="">
    <h2 class="fw-bolder text_center mt-3">REGISTER</h2>

    <div class="container border border-2 rounded color_white mt-5 registerContainer">
        <form method="post" id="registrationForm">
            <div class="login_container mt-4">

                <div class="input-container Fullname">
                    <i class="icon fas fa-user"></i>
                    <input type="text" class="text_box" placeholder="Full Name" name="fullname" value="<?php if (isset($_SESSION['name']))
                        echo $_SESSION['name']; ?>" />
                    <hr />
                    <?php if (isset($error_name))
                        // echo '<div class="error">' . $error_name . '</div>'; 
                        echo '<div>' . $error_name . '</div>'
                            ?>
                    </div>

                    <div class="input-container Username">
                        <i class="icon fas fa-user"></i>
                        <input type="text" class="text_box" placeholder="Username" name="username" value="<?php if (isset($_SESSION['username']))
                        echo $_SESSION['username']; ?>" />
                    <hr />
                    <?php if (isset($error_username))
                        echo '<div>' . $error_username . '</div>'; ?>

                </div>


                <div class="input-container Password">
                    <i class="icon fas fa-lock"></i>
                    <input type="password" class="text_box" placeholder="Password" name="upassword" />
                    <hr />
                    <?php if (isset($error_passwd))
                        echo '<div>' . $error_passwd . '</div>'; ?>
                </div>

                <div class="input-container ConfirmPassword">
                    <i class="icon fas fa-lock"></i>
                    <input type="password" class="text_box" placeholder="Confirm Password" name="cpassword" />
                    <hr />
                    <?php if (isset($error_passwdConfirm))
                        echo '<div>' . $error_passwdConfirm . '</div>'; ?>
                </div>

                <div class="input-container Email">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="text" class="text_box" placeholder="Email" name="email" value="<?php if (isset($_SESSION['email']))
                        echo $_SESSION['email']; ?>" />
                    <hr />
                    <?php if (isset($error_email))
                        echo '<div>' . $error_email . '</div>'; ?>
                </div>


                <div class="input-container PhoneNum">
                    <i class="fa-solid fa-phone"></i>
                    <input type="tel" class="text_box" placeholder="Phone Number" name="phoneNum" value="<?php if (isset($_SESSION['phone']))
                        echo $_SESSION['phone']; ?>" />
                    <hr />
                    <?php if (isset($error_phone))
                        echo '<div>' . $error_phone . '</div>'; ?>
                </div>

                <?php if (isset($success))
                    echo '<div>' . $success . '</div>';
                ?>

                <div class="login_container mt-3">
                    <button type="submit" class="btn btn-dark rounded-5 registered" name="registerBtn">
                        Register
                    </button>
                </div>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <!-- <script src="../JS/main.js"></script> -->
</body>

</html>