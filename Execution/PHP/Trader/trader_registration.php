<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Community Harvest - Trader Registration</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
  <style>
    body {
      background-image: url('container.png');
      background-size: cover;
      background-repeat: no-repeat;
      background-position: center;
    }

    .container {
      background-color: rgba(255, 255, 255, 0.9); /* Add transparency */
      border-radius: 10px;
      box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
      padding: 15px; 
      margin: 50px auto;
      max-width: 600px;
    }

    .logo-container {
      text-align: center;
      margin-bottom: 20px; /* Increased margin for better spacing */
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
  <div class="container">
    <div class="row justify-content-center"> <!-- Center the content -->
      <div class="col-md-8"> <!-- Adjust column width for medium screens and above -->
        <div class="logo-container">
          <img src="logo.png" alt="Community Harvest Logo" class="logo">
        </div>
        <h1 class="text-center mb-4 green-heading">Trader Registration</h1>
        <p class="lead text-center">Welcome to Community Harvest. Please fill out the form below to register as a trader.</p>

        <form class="mt-4">
          <div class="mb-3">
            <label for="name" class="form-label">Full Company Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter your company's name.">
          </div>
          <div class="mb-3">
        <label for="business-description" class="form-label">Business Description</label>
        <textarea class="form-control" id="business-description" name="business-description" rows="3" placeholder="Please provide a brief description of your business"></textarea>
      </div>
      <div class="mb-3">
        <label for="experience" class="form-label">Previous Experience</label>
        <textarea class="form-control" id="experience" name="experience" rows="3" placeholder="Please describe your previous experience in the industry"></textarea>
      </div>
      <div class="mb-3">
        <label for="quality-measures" class="form-label">Quality Measures</label>
        <textarea class="form-control" id="quality-measures" name="quality-measures" rows="3" placeholder="What measures do you take to ensure the quality and freshness of your products?"></textarea>
      </div>
      <div class="mb-3">
        <label for="certifications" class="form-label">Certifications/Licenses</label>
        <textarea class="form-control" id="certifications" name="certifications" rows="3" placeholder="Do you hold any certifications or licenses related to your business or the products you sell?"></textarea>
      </div>
      


          
          <div class="text-center">
            <button type="submit" class="btn btn-lg btn-continue">Continue</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
