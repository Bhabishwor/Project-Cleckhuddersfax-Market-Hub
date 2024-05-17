<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Us - Community Harvest</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
    integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <style>
    body {
      background-color: #f0f9f7;
      font-family: 'Open Sans', sans-serif;
      padding-top: 80px;
    }

    .container {
      max-width: 600px;
      padding: 40px;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      background-color: #fff;
      margin: 0 auto;
    }

    .contact-form h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #3c763d;
      font-size: 24px;
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

    .alert {
      margin-top: 15px;
    }
  </style>
</head>

<body>

  <div class="container contact-form">

    <body
      style="background-image: url('container.png'); background-size: cover; background-repeat: no-repeat; background-position: center;">
      <div class="container contact-form">
        <h2><i class="fas fa-question-circle"></i> Contact Us</h2>
        <form method="post" action="#">
          <div class="form-group">
            <label for="name">Full Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name">
          </div>
          <div class="form-group">
            <label for="email">Email Address</label>
            <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp"
              placeholder="Enter your email">
          </div>
        <div class="form-group">
            <label for="message">Your Message</label>
            <textarea class="form-control" id="message" name="message" rows="3"></textarea>
          </div>
          <button type="submit" class="btn btn-primary">Send</button>
        </form>
      </div>



      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p"
        crossorigin="anonymous"></script>
    </body>

</html>