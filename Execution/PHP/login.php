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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

    <link rel="stylesheet" href="../CSS/styles.css">
</head>

<body>
    <form method="POST" id="customerLogin" action="login_process.php">
        <img src="../Image/Logo.png" class="img-fluid rounded mx-auto d-block" height="50px" width="70px" alt="">
        <h2 class="fw-bolder text_center mt-3 ">LOGIN</h2>
        <div class="container border border-2 rounded color_white pb-4">

            <div class="login_container mt-4">
                <div class="Username">
                    <label>Username</label>
                    <div class="input-container">
                        <i class="fa-solid fa-envelope"></i>
                        <input type="text" class="text_box" placeholder="Email" name="email">
                        <hr>
                    </div>
                </div>

                <div class="password">
                    <label>Password</label>
                    <div class="input-container">
                        <i class="icon fas fa-lock"></i>
                        <input type="password" class="text_box" placeholder="Password" name="password">
                        <hr>
                    </div>
                </div>

                <div class="user-type mt-2 mb-3">
                    <label for="userType" class="mb-2 fw-bolder">I am a:</label>
                    <select class="form-select" id="userType" name="role">
                        <option value="customer">Customer</option>
                        <option value="trader">Trader</option>
                    </select>
                </div>

                <label>
                    <input type="checkbox">
                    Remember Me
                </label>

                <!-- <label><u>Forgot Password?</u></label> -->
                <a href="" id="forgot_password">Forgot Password?</a>


            </div>

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
            <div class="login_container mt-3">
                <button type="submit" class="btn btn-dark rounded-5 mb-4">Login</button>

                <button type="button" class="btn btn-dark rounded-5 mb-4">
                    <a href="Customer/register_customer.php" class="remove">Register As Customer</a>
                </button>
                <button type="button" class="btn btn-dark rounded-5">
                    <a href="Trader/trader_registration.php" class="remove">Register As Trader</a>
                </button>

            </div>

        </div>
    </form>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>