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
    <form method="post" id="customerLogin" action="loginprocess.php">
        <img src="../Image/Logo.png" class="img-fluid rounded mx-auto d-block" height="50px" width="70px" alt="">
        <h2 class="fw-bolder text_center mt-3 ">LOGIN</h2>
        <div class="container border border-2 rounded color_white pb-4">

            <div class="login_container mt-4">
                <div class="Username">
                    <label>Username</label>
                    <div class="input-container">
                        <i class="icon fas fa-user"></i>
                        <input type="text" class="text_box" placeholder="Username" name="username">
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

                <label>
                    <input type="checkbox">
                    Remember Me
                </label>

                <!-- <label><u>Forgot Password?</u></label> -->
                <a href="" id="forgot_password">Forgot Password?</a>


            </div>
            <div class="error" id="error_customerLogin"></div>
            <div class="login_container mt-3">
                <button type="submit" class="btn btn-dark rounded-5 mb-4">Login</button>

                <button type="button" class="btn btn-dark rounded-5 mb-4">
                    <a href="register.php" class="remove">Register As Customer</a>
                </button>
                <button type="button" class="btn btn-dark rounded-5">
                    <a href="register.php" class="remove">Register As Trader</a>
                </button>

            </div>

        </div>
    </form>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <script src="../JS/main.js"></script>
</body>

</html>