<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order History</title>
  <link rel="stylesheet" href="customer_order_history.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <?php include "header.php"; ?>
</head>

<body>



  <h1>Order History</h1>
  <div class="order-list">
    <div class="order">
      <div class="order-info">
        <p class="order-number">Order #12345</p>
        <p class="order-date">Date: 19/01/2024</p>
      </div>
      <div class="order-items">
        <div class="order-item">
          <div class="item-details">
            <img src="../../Image/HistoryImages/1image.jpeg" alt="Product Image 1">
            <div class="item-info">
              <p>Non-GMO Eggs</p>
              <p>Qty: 1</p>
              <p>$3</p>
              <span class="review-link"><a href="#">Leave a Review</a></span>
            </div>
          </div>
        </div>
        </div>
    </div>
    <div class="order">
      <div class="order-info">
        <p class="order-number">Order #12344</p>
        <p class="order-date">Date: 02/01/2024</p>
      </div>
      <div class.order-items">
        <div class="order-item">
          <div class="item-details">
            <img src="./../Image/HistoryImages/2image.jpeg" alt="Product Image 2">
            <div class="item-info">
              <p>Roma Tomatoes</p>
              <p>Qty: 2</p>
              <p>$4</p>
              <span class="review-link"><a href="#">Leave a Review</a></span>
            </div>
            
          </div>
        </div>
        </div>

        <div class.order-items">
            <div class="order-item">
              <div class="item-details">
                <img src="./../Image/HistoryImages/3image.jpeg" alt="Product Image 2">
                <div class="item-info">
                  <p>Plain Leafy Kale</p>
                  <p>Qty: 2</p>
                  <p>$4</p>
                  <span class="review-link"><a href="#">Leave a Review</a></span>
                </div>

    </div>
  </div>


  <?php include "footer.php"; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>



</body>
</html>
