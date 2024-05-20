<?php
session_start();
// Get fail message from session (if set) and clear it to prevent reshowing
$errorMsg = (isset($_SESSION['failmessage'])) ? $_SESSION['failmessage'] : '';
unset($_SESSION['failmessage']);

$successMsg = (isset($_SESSION['success_msg'])) ? $_SESSION['success_msg'] : '';
unset($_SESSION['success_msg']);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Login | Cleckhuddersfax Market Hub</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <link rel="stylesheet" href="../CSS/form.css">
</head>

<body>
    <div class="py-4">
        <img src="../Image/Logo.png" class="img-fluid rounded mx-auto d-block" height="50px" width="70px" alt="Logo">

        <div class="container border border-2 rounded color_white mt-4 p-2">
            <form method="POST" id="customerLogin" action="login_process.php">
                <div class="login_container">
                    <h2 class="fw-bolder text_center">LOGIN</h2>

                    <div class="input-container Username">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="text" class="text_box" placeholder="Email" name="email">
                        <hr>
                    </div>

                    <div class="input-container password">
                        <i class="icon fas fa-lock"></i>
                        <input type="password" class="text_box" placeholder="Password" name="password">
                        <hr>
                    </div>

                    <div class="input-container user-type">
                        <i class="icon fas fa-user"></i>
                        <label for="userType">&nbsp;I am&nbsp;</label>
                        <select class="text_box" id="userType" name="role">
                            <option value="customer">Customer</option>
                            <option value="trader">Trader</option>
                        </select>
                        <hr>
                    </div>

                    <label class="mb-2">
                        <input type="checkbox">
                        Remember Me
                    </label>

                    <div id="error_customerLogin">
                        <?php
                        // Display the error message if it's set
                        if($successMsg){
                            echo "<div class='alert alert-success' role='alert'>" . $successMsg . "</div>"; 
                        }
                        if ($errorMsg) {
                            echo "<div class='alert alert-danger' role='alert'>" . $errorMsg . "</div>";
                        }
                        ?>
                    </div>

                    <div class="login_container mt-2 mb-0">
                        <button type="submit" class="btn btn-outline-success rounded-5 mb-2">Login</button>

                        <button type="button" class="btn btn-outline-success rounded-5 mb-2">
                            <a href="Customer/customer_register.php" class="remove">Register As Customer</a>
                        </button>
                        <button type="button" class="btn btn-outline-success rounded-5">
                            <a href="Trader/trader_registration.php" class="remove">Register As Trader</a>
                        </button>
                    </div>

                    <a href="../PHP/Customer/reset_password.php" id="forgot_password"><small>Forgot Password?</small></a>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" 
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>