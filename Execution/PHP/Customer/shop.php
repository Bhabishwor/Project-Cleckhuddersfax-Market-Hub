
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Shop Name</title>
  <link rel="stylesheet" href="shop.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>
<body>
<?php include "header.php"; ?>
  <main>


  <div class="shop-info">
      <img src="../../Image/ShopImages/image10.jpeg" alt="Shop Image" class="shop-image">
      <div class="shop-details">
        <h1>Farm To Table</h1>
        <p>High Street, Cleckhuddersfax, Yorkshire</p>
      </div>
    </div>

    <section class="featured-products">
      <h2>FEATURED PRODUCTS</h2>
      <div class="container">
        <article class="product">
          <img src="../../Image/ShopImages/image2.jpeg" alt="Wild Himalayan Honey" class="productimg">
          <p class="product-name">Wild Himalayan Honey</p>
        </article>
        <article class="product">
          <img src="../../Image/ShopImages/image3.jpeg" alt="Feta Cheese" class="productimg">
          <p class="product-name">Feta Cheese</p>
        </article>
        <article class="product">
          <img src=".../../Image/ShopImages/image4.jpeg" alt="Honeycrisp Apples" class="productimg">
          <p class="product-name">Honeycrisp Apples</p>
        </article>
        <article class="product">
          <img src="../../Image/ShopImages/image6.jpeg" alt="Figs" class="productimg">
          <p class="product-name">Figs</p>
          </article>
          <article class="product">
            <img src=".../../Image/ShopImages/image11.jpeg" alt="Steak" class="productimg">
            <p class="product-name">Steak</p>
        </article>
        <article class="product">
            <img src=".../../Image/ShopImages/.jpeg" alt="Potatoes" class="productimg">
            <p class="product-name">Potatoes</p>
        </article>
        <article class="product">
            <img src="../../Image/ShopImages/image13.jpeg" alt="Lemons" class="productimg">
            <p class="product-name">Yellow Lemons</p>
        </article>

        </div>
    </section>

<section class="review-section">
      <h2>REVIEWS</h2>
      <div class="review-container"> <div class="review">
          <img src=".../../Image/ShopImages/image7.jpeg" alt="Phil Kay" class="customer-avatar">
          <div class="review-info">
            <p class="review-text">Highly recommend this natural seed butter!</p>
            <span class="review-rating">&#9733; &#9733; &#9733; &#9733; &#9734;</span>
          </div>
        
        </div>
    
        <div class="review">
          <img src="../../Image/ShopImages/image8.jpeg" alt="Aiden York" class="customer-avatar">
          <div class="review-info">
            <p class="review-text">Really impressed with the freshness of the produce.</p>
            <span class="review-rating">&#9733; &#9733; &#9733; &#9733; &#9733;</span>
          </div>
        
        </div>
    
        <div class="review">
          <img src="../../Image/ShopImages/image9.jpeg" alt="Steve John" class="customer-avatar">
          <div class="review-info">
          <p class="review-text">Loved the tangy Feta Cheese, pairs perfectly with meat!</p>
            <span class="review-rating">&#9733; &#9733; &#9733; &nbsp; &nbsp; &nbsp;</span>
          </div>
         
        </div>
      </div>
    </section>    
    
  </main>
  <?php include "footer.php"; ?>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</body>

</html>