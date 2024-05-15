<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Grocery Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="admin_dashboard.css" rel="stylesheet">
</head>
<body>
  <?php include 'admin_navigation_pane.php'; ?>

  <!-- Main Content -->
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-3 col-md-4"></div>
      <div class="col-lg-9.5 col-md-8">
        <div class="home-and-search" style="margin-left:0.5px" >
          <a href="#" class="home"><b>HOME</b></a>
          <div class="input-group">
            <input type="text" class="form-control" placeholder="Search...">
            <button class="btn btn-primary" type="button">Search</button>
          </div>
        </div>
        <div class="analytics-container">
          <div class="row">
            <div class="col-lg-6 col-md-12">
              <div class="card mb-4">
                <img src="analytical_report_1.jpg" class="card-img-top" alt="Analytical Report 1">
                <div class="card-body">
                  <h5 class="card-title">Analytical Report 1</h5>
                  <p class="card-text">Description of Analytical Report 1.</p>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-12">
              <div class="card mb-4">
                <img src="analytical_report_2.jpg" class="card-img-top" alt="Analytical Report 2">
                <div class="card-body">
                  <h5 class="card-title">Analytical Report 2</h5>
                  <p class="card-text">Description of Analytical Report 2.</p>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-6 col-md-12">
              <div class="card mb-4">
                <img src="analytical_report_3.jpg" class="card-img-top" alt="Analytical Report 3">
                <div class="card-body">
                  <h5 class="card-title">Analytical Report 3</h5>
                  <p class="card-text">Description of Analytical Report 3.</p>
                </div>
              </div>
            </div>
            <div class="col-lg-6 col-md-12">
              <div class="card mb-4">
                <img src="analytical_report_4.jpg" class="card-img-top" alt="Analytical Report 4">
                <div class="card-body">
                  <h5 class="card-title">Analytical Report 4</h5>
                  <p class="card-text">Description of Analytical Report 4.</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
