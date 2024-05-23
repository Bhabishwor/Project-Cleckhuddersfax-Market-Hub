<?php
include "../connection/connection.php";


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

function sendMail($email, $v_code, $name)
{

    require ("PHPMailer/PHPMailer.php");
    require ("PHPMailer/SMTP.php");
    require ("PHPMailer/Exception.php");

    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth = true;                                   //Enable SMTP authentication
        $mail->Username = 'luciferdynamic598@gmail.com';                     //SMTP username
        $mail->Password = 'wgvf rsrm egmc ejqx';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('luciferdynamic598@gmail.com', 'Community Harvest');
        $mail->addAddress($email);     //Add a recipient


        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Email Verification From Community Harvest';
        $mail->Body = "<!DOCTYPE html>
        <html lang='en'>
        <head>
          <meta charset='UTF-8'>
          <meta name='viewport' content='width=device-width, initial-scale=1.0'>
          <title>Verify Your Email Address</title>
          <style>
            body {
              font-family: Arial, sans-serif;
              margin: 0;
              padding: 0;
              color: #333;
            }
        
            .container {
              padding: 20px;
              max-width: 600px;
              margin: 0 auto;
              border: 1px solid #ddd;
              border-radius: 4px;
            }
        
            .header {
              text-align: center;
              padding: 10px;
              background-color: #f0f0f0;
              border-bottom: 1px solid #ddd;
            }
        
            .content {
              padding: 20px;
            }
        
            .link {
              display: block;
              text-align: center;
              margin-top: 20px;
              font-weight: bold;
            }
        
            a {
              color: #333;
              text-decoration: none;
            }
        
            a:hover {
              text-decoration: underline;
            }
        
            .footer {
              text-align: center;
              padding: 10px;
              font-size: 12px;
              color: #aaa;
            }
          </style>
        </head>
        <body>
          <div class='container'>
            <div class='header'>
              <h2>Verify Your Email Address</h2>
            </div>
            <div class='content'>
              <p>Hi $name,</p>
              <p>Thank you Trader for signing up for our website! To activate your account, please click the link below:</p>
              <p><a href='http://localhost/CommunityHarvest/Execution/PHP/Customer/verify.php?email=$email&v_code=$v_code'>Verify your email address</a></p>
              <p>If you did not create an account with us, please ignore this email.</p>
            </div>
            <div class='footer'>
              <p>Sincerely,</p>
              <p>Community Harvest Team</p>
            </div>
          </div>
        </body>
        </html>";



        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Community Harvest - Trader Registration</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
  <style>
    body {
      background-image: url('../../Image/heritage/navigation_pane.png');
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
    }

    .container {
      background-color: rgba(255, 255, 255, 0.9);
      /* Add transparency */
      border-radius: 10px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
      padding: 15px;
      margin: 50px auto;
      max-width: 600px;
    }

    .logo-container {
      text-align: center;
      margin-bottom: 20px;
      /* Increased margin for better spacing */
    }

    .logo {
      max-width: 150px;
    }

    .green-heading {
      color: #28a745;
      font-weight: bold;
    }

    .btn-continue {
      background-color: #28a745;
      border-color: #28a745;
      transition: background-color 0.3s ease, border-color 0.3s ease;
    }

    .btn-continue:hover {
      background-color: #218838;
      border-color: #1e7e34;
    }
  </style>
</head>

<body>

<?php
  session_start();
  $error_name = $error_email = $error_phone = $error_username = $error_passwd = $error_passwdConfirm = $error_image = '';
  if (isset($_POST['register_trader'])) {
    $name = $_POST['shopName'];
    $email = $_POST['email'];
    $phone = $_POST['phoneNum'];
    $shop_type = $_POST['shop_type'];
    $address = $_POST['address'];
    $password = $_POST['upassword'];
    $password_confirm = $_POST['cpassword'];
    $role = "trader";
    $status = "Not Verified";
    $admin_verified = "N";
    $error = 0;

    // Session
    $_SESSION['name'] = $name;
    $_SESSION['address'] = $address;
    $_SESSION['email'] = $email;
    $_SESSION['phone'] = $phone;

    // Validation
    if (strlen($name) < 5) {
      $error_name = "Fullname should be at least six characters";
      $error++;
    }

    if (empty($name)) {
      $error_name = "Please enter your fullname first";
      $error++;
    }

    if (empty($email)) {
      $error_email = "Please enter your email";
      $error++;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $error_email = "Please enter a valid email, like yourname@abc.com";
      $error++;
    }

    if (empty($phone)) {
      $error_phone = "Please enter your mobile number";
      $error++;
    }

    if (!preg_match('/^[0-9]{10}+$/', $phone)) {
      $error_phone = "Please enter a valid mobile number";
      $error++;
    }

    if (!preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $email)) {
      $error_email = "Please enter a valid email, like yourname@abc.com";
      $error++;
  }

    if (empty($address)) {
      $error_phone = "Please enter your address";
      $error++;
    }

    if (empty($password)) {
      $error_passwd = "Please enter password";
      $error++;
    }

    if (empty($password_confirm)) {
      $error_passwdConfirm = "No password given";
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
      $error_passwd = "Password must include a special character";
      $error++;
    }

    if (strlen($password) < 6) {
      $error_passwd = "Password must be greater than six characters";
      $error++;
    }

    if ($password != $password_confirm) {
      $error_passwdConfirm = "Password does not match";
      $error++;
    }

    // File upload
    if (isset($_FILES['shop_image']) && $_FILES['shop_image']['error'] === UPLOAD_ERR_OK) {
      $targetDir = "../../Uploaded_Image/Trader/";
      $fileName = basename($_FILES["shop_image"]["name"]);
      $targetFilePath = $targetDir . $fileName;
      $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
      $allowedFileTypes = array("jpg", "jpeg", "png", "gif");

      $check = getimagesize($_FILES["shop_image"]["tmp_name"]);
      if ($check !== false) {
        $maxFileSize = 5 * 1024 * 1024; // 5 MB
        if ($_FILES["shop_image"]["size"] <= $maxFileSize) {
          if (in_array($fileType, $allowedFileTypes)) {
            if (!move_uploaded_file($_FILES["shop_image"]["tmp_name"], $targetFilePath)) {
              $error_image = 'Error moving the uploaded file.';
              $error++;
            }
          } else {
            $error_image = 'Invalid file format. Please choose a valid image file.';
            $error++;
          }
        } else {
          $error_image = 'File is too large. Please choose a smaller image.';
          $error++;
        }
      } else {
        $error_image = 'File is not an image. Please choose a valid image file.';
        $error++;
      }
    } else {
      $error_image = "Please upload your image";
      $error++;   
    }

    // Check for existing email
    $check_email = "SELECT COUNT(*) as email_count FROM users WHERE user_email = :email";
    $bind_email = oci_parse($conn, $check_email);
    oci_bind_by_name($bind_email, ':email', $email);
    oci_execute($bind_email);
    $result = oci_fetch_assoc($bind_email);

    if ($result["EMAIL_COUNT"] > 0) {
      $error_email = "Email already exists!";
      $error++;
    }

    // If no errors, insert into database
    if ($error == 0) {
      $password = password_hash($password, PASSWORD_DEFAULT);

      $verification_code = bin2hex(random_bytes(16));

      $query = "INSERT INTO users(user_name, user_address, user_email, user_phone_number, user_password, user_role, user_status, user_shop, user_shop_image, admin_verified, verification_code)
       VALUES (:name, :address, :email, :phone, :password, :role, :status, :shopType, :image, :admin_verify, :verify)";
      $bind_stmnt = oci_parse($conn, $query);

      oci_bind_by_name($bind_stmnt, ':name', $name);
      oci_bind_by_name($bind_stmnt, ':email', $email);
      oci_bind_by_name($bind_stmnt, ':address', $address);
      oci_bind_by_name($bind_stmnt, ':phone', $phone);
      oci_bind_by_name($bind_stmnt, ':password', $password);
      oci_bind_by_name($bind_stmnt, ':role', $role);
      oci_bind_by_name($bind_stmnt, ':status', $status);
      oci_bind_by_name($bind_stmnt, ':shopType', $shop_type);
      oci_bind_by_name($bind_stmnt, ':image', $targetFilePath);
      oci_bind_by_name($bind_stmnt, ':admin_verify', $admin_verified);
      oci_bind_by_name($bind_stmnt, ':verify', $verification_code);

      $result = oci_execute($bind_stmnt);

      if ($result && sendMail($email, $verification_code, $name)) {
        $success = "Registration Successful!";
        $_SESSION['name'] = "";
        $_SESSION['address'] = "";
        $_SESSION['email'] = "";
        $_SESSION['phone'] = "";
        session_destroy();

        $target_url = "../login.php";
        echo '<meta http-equiv="refresh" content="1;url=' . $target_url . '">';
      }else {
        echo "
        <script>
        alert('Registration Failed');
        windows.location.href='homepage.php';
        </script>
        ";
    }
    }
  }
  ?>

  <div class="container">
    <div class="row justify-content-center"> <!-- Center the content -->
      <div class="col-md-8"> <!-- Adjust column width for medium screens and above -->
        <div class="logo-container">
          <img src="../../Image/Logo.png" alt="Community Harvest Logo" class="logo">
        </div>
        <h1 class="text-center mb-4 green-heading">Trader Registration</h1>
        <p class="lead text-center">Welcome to Community Harvest. Please fill out the form below to register as a
          trader.</p>

        <form class="mt-4" method="post" enctype="multipart/form-data">

          <div class="mb-3">
            <label for="name" class="form-label">Shop Name</label>
            <input type="text" class="form-control" id="name" name="shopName" placeholder="Shop Name" value="<?php if (isset($_SESSION['name']))
              echo $_SESSION['name']; ?>" />
            <?php if (isset($error_name))
              echo '<div>' . $error_name . '</div>'
                ?>
            </div>

            <div class="mb-3">
              <label for="Email" class="form-label">Email</label>
              <input type="text" class="form-control" id="email" name="email" placeholder="Email" value="<?php if (isset($_SESSION['email']))
              echo $_SESSION['email']; ?>" />
            <?php if (isset($error_email))
              echo '<div>' . $error_email . '</div>';
            ?>
          </div>

          <div class="mb-3">
            <label for="Password" class="form-label">Password</label>
            <input type="password" class="form-control" id="upassword" name="upassword" placeholder="Password" />
            <?php if (isset($error_passwd))
              echo '<div>' . $error_passwd . '</div>'; ?>
          </div>

          <div class="mb-3">
            <label for="ConfirmPassword" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="cpassword" name="cpassword"
              placeholder="Confirm Password" />
            <?php if (isset($error_passwd))
              echo '<div>' . $error_passwd . '</div>';
            ?>
          </div>


          <div class="mb-3">
            <label for="Address" class="form-label">Address</label>
            <input type="text" class="form-control" id="address" name="address" placeholder="Address" value="<?php if (isset($_SESSION['address']))
              echo $_SESSION['address']; ?>" />
            <?php if (isset($error_address))
              echo '<div>' . $error_address . '</div>';
            ?>
          </div>

          <div class="mb-3">
            <label for="PhoneNum" class="form-label">Phone Number</label>
            <input type="text" class="form-control" id="phoneNum" name="phoneNum" placeholder="Phone Number" value="<?php if (isset($_SESSION['phone']))
              echo $_SESSION['phone']; ?>" />
            <?php if (isset($error_phone))
              echo '<div>' . $error_phone . '</div>'; ?>
          </div>

          <div class=" mb-3 form-group">
            <label for="shopTypeSelect">Choose a shop type:</label>
            <select class="form-control mt-2" id="shopTypeSelect" name="shop_type">
              <option value="butchers">Butcher</option>
              <option value="greengrocer">Greengrocer</option>
              <option value="fishmonger">Fishmonger</option>
              <option value="bakery">Bakery</option>
              <option value="delicatessen">Delicatessen</option>
            </select>
          </div>

          <div class="mb-3 form-group">
            <label class="formFile" for="fileChooser">Choose Shop Image</label>
            <input type="file" class="form-control mt-2" id="fileChooser" aria-describedby="fileHelp"
              name="shop_image" />
            <?php if (isset($error_image))
              echo '<div>' . $error_image . '</div>';
            ?>
          </div>

          <?php if (isset($success))
            echo '<div>' . $success . '</div>';
          ?>


          <div class="text-center">
            <button type="submit" class="btn btn-lg btn-continue" name="register_trader">Register</button>
          </div>

        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>