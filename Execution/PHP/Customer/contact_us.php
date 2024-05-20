<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <title>Contact Us | Community Harvest</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
  <link rel="stylesheet" href="../../CSS/main.css">

  <style>
    /* .container {
      max-width: 600px;
      padding: 40px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      background-color: #fff;
      margin: 0 auto;
    }

    .contact-form .form-group {
      margin-bottom: 25px;
    }

    .contact-form .form-group.required::after {
      content: " *";
      color: red;
      font-weight: bold;
      margin-left: 5px;
    }

    .contact-form .form-control {
      border-radius: 5px;
      border-color: #ccc;
      padding: 12px 18px;
      font-size: 16px;
    }

    .contact-form .form-control:focus {
      border-color: #3c763d;
    }

    .contact-font-awesome {
      font-size: 14px;
      margin-right: 5px;
      color: red;
    }

    .contact-form .btn-primary {
      background-color: #3c763d;
      border-color: #3c763d;
      transition: all 0.3s ease-in-out;
      padding: 12px 25px;
      font-size: 16px;
      font-weight: bold;
      border: none;
      border-radius: 5px;
    }

    .contact-form .btn-primary:hover {
      background-color: #2d542e;
      border-color: #2d542e;
    }
    */

    .alert {
      margin-top: 15px;
    }

    .container{
      width: 35rem !important;
      margin: auto;
    }

    div h2{
      color: #3c763d;
    }
  </style>
</head>

<body>
  <?php include "header.php"; ?>

  <div class="container border border-2 rounded bg-white my-5 p-5">
    <form method="post" action="#">
      <div class="p-3">
        <h2 class="text-center mb-5"><i class="fas fa-question-circle"></i> Contact Us</h2>

        <div class="form-group">
          <label for="name">Full Name</label>
          <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name">
          <hr>
        </div>
        
        <div class="form-group">
          <label for="email">Email Address</label>
          <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp"
            placeholder="Enter your email">
          <hr>
        </div>
          
        <div class="form-group">
          <label for="message">Your Message</label>
          <textarea class="form-control" id="message" name="message" rows="3" 
            placeholder="Enter your message"></textarea>
          <hr>
        </div>

        <button type="submit" class="btn btn-outline-success">Send</button>
      </div>
    </form>
  </div>

  <?php include "footer.php"; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
  </script>
</body>

</html>