<?php
// Include the database connection
include "../connection/connection.php";

// Get the product ID from the URL
$product_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Initialize the product and trader variables
$product = [];
$trader = [];
$reviews = [];

if ($product_id > 0) {
    // Fetch the product details from the database
    $sql = "SELECT * FROM PRODUCT WHERE PRODUCT_ID = :product_id";
    $stmt_product = oci_parse($conn, $sql);
    oci_bind_by_name($stmt_product, ':product_id', $product_id);

    if (oci_execute($stmt_product)) {
        $product = oci_fetch_assoc($stmt_product);
    }

    if (!$product) {
        echo "Product not found!";
        exit;
    }

    // Fetch the trader details
    $sql_trader = "SELECT * FROM TRADER WHERE TRADER_ID = :trader_id";
    $stmt_trader = oci_parse($conn, $sql_trader);
    oci_bind_by_name($stmt_trader, ':trader_id', $product['TRADER_ID']);

    if (oci_execute($stmt_trader)) {
        $trader = oci_fetch_assoc($stmt_trader);
    }

    if (!$trader) {
        echo "Trader not found!";
        exit;
    }

    // Fetch the reviews for the product
    $sql_reviews = "SELECT R.*, C.CUSTOMER_NAME 
                    FROM REVIEWS R 
                    JOIN CUSTOMER C ON R.CUSTOMER_ID = C.CUSTOMER_ID 
                    WHERE R.PRODUCT_ID = :product_id 
                    ORDER BY R.REVIEW_DATE DESC";
    $stmt_reviews = oci_parse($conn, $sql_reviews);
    oci_bind_by_name($stmt_reviews, ':product_id', $product_id);
    oci_execute($stmt_reviews);

    while ($row = oci_fetch_assoc($stmt_reviews)) {
        $reviews[] = $row;
    }

    // Free the statement identifiers
    oci_free_statement($stmt_product);
    oci_free_statement($stmt_trader);
    oci_free_statement($stmt_reviews);
} else {
    echo "Invalid product ID!";
    exit;
}

// Close the connection
oci_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "header.php"; ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($product['PRODUCT_NAME']); ?> | Product Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
    /* Global Styles */
    body {
        font-family: 'Montserrat', sans-serif;
        background-color: #f8f9fa;
    }

    /* Product Container */
    .product-container {
        margin-top: 50px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
    }

    /* Product Image */
    .product-img {
        max-width: 100%;
        height: auto;
        border-radius: 5px;
        border: 1px solid #ddd;
    }

    /* Product Detail Section */
    .product-detail {
        padding: 20px;
    }

    /* Product Title */
    .product-title {
        font-size: 2.5rem;
        margin-bottom: 15px;
        color: #333;
    }

    /* Product Price */
    .product-price {
        font-size: 2rem;
        color: #28a745;
        margin-bottom: 15px;
    }

    /* Product Description */
    .product-description {
        margin-bottom: 20px;
        font-size: 1.1rem;
        color: #555;
    }

    /* Primary Button */
    .btn-primary {
        background-color: #007bff;
        border: none;
    }

    /* Primary Button Hover */
    .btn-primary:hover {
        background-color: #0056b3;
    }

    /* Trader Info Section */
    .trader-info {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
    }

    /* Trader Image */
    .trader-img {
        max-width: 50px;
        height: auto;
        border-radius: 50%;
        margin-right: 15px;
    }

    /* More Products Section */
    .more-products {
        margin-top: 50px;
    }

    /* Product Card within More Products Section */
    .more-products .product-card {
        margin-bottom: 20px;
    }

    /* Reviews Container */
    .reviews-container {
        margin-top: 50px;
    }

    /* Review Section */
    .review {
        background-color: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-bottom: 20px;
        transition: box-shadow 0.3s ease;
    }

    /* Review Hover Effect */
    .review:hover {
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
    }

    /* Star Rating within Review */
    .review .star-rating {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }

    /* Star Icon in Star Rating */
    .review .star-rating label {
        font-size: 1.5rem;
        color: #f8ce0b;
        margin-right: 5px;
    }

    /* Customer Name in Review */
    .review .customer-name {
        font-size: 1.2rem;
        font-weight: bold;
        color: #333;
        margin-bottom: 5px;
    }

    /* Review Date */
    .review .review-date {
        font-size: 1rem;
        color: #666;
        margin-bottom: 5px;
    }

    /* Review Description */
    .review .review-description {
        font-size: 1.1rem;
        color: #555;
    }

    /* Star Rating (Generic) */
    .star-rating {
        color: #f8ce0b;
    }

    /* Star Rating Input */
    .star-rating input {
        display: none;
    }

    /* Star Rating Label */
    .star-rating label {
        font-size: 2rem;
        cursor: pointer;
        color: #ccc;
    }

    /* Star Rating Hover Effect */
    .star-rating label:hover,
    .star-rating label:hover ~ label {
        color: #ffdd00;
    }

    /* Checked Star Rating Label */
    .star-rating input:checked ~ label {
        color: #ffdd00; /* Keep this as yellow */
    }

    /* Checked Star Rating Label and Following Labels */
    .star-rating input:checked + label,
    .star-rating input:checked + label ~ label {
        color: #ffdd00;
    }

      /* Add Review Section */
    .add-review-section {
        margin-top: 30px;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        background-color: #f8f9fa;
    }

    /* Add Review Section Title */
    .add-review-section h3 {
        margin-bottom: 20px;
        color: #333;
        text-align: center;
        font-size: 10em;
    }

    /* Add Review Section Star Rating */
    .add-review-section .star-rating {
        margin-bottom: 20px;
        text-align: center;
    }

    /* Add Review Section Label */
    .add-review-section label {
        font-size: 1.2rem;
        margin-right: 10px;
        color: #333;
    }

    /* Add Review Section Textarea */
    .add-review-section textarea {
        resize: none;
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 1rem;
        color: #555;
    }

    /* Add Review Section Submit Button */
    .add-review-section .btn-primary {
        display: block;
        margin: 0 auto;
        background-color: #007bff;
        border: none;
        border-radius: 5px;
        padding: 10px 20px;
        color: green;
        font-size: 1.2rem;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .add-review-section .btn-primary:hover {
        background-color: #0056b3;
    }
</style>

</head>
<body>
    <div class="container product-container" style="margin-bottom: 10em;">
        <div class="row">
            <div class="col-md-6">
                <img src="<?php echo htmlspecialchars($product['PRODUCT_IMAGE_PATH']); ?>" alt="<?php echo htmlspecialchars($product['PRODUCT_NAME']); ?>" class="product-img">
            </div>
            <div class="col-md-6 product-detail">
                <h1 class="product-title"><?php echo htmlspecialchars($product['PRODUCT_NAME']); ?></h1>
                <p class="product-price">$<?php echo number_format($product['PRODUCT_PRICE'], 2); ?></p>
                <p class="product-description"><strong>Stock:</strong> <?php echo htmlspecialchars($product['STOCK']); ?></p>
                <p class="product-description"><strong>Allergy Information:</strong> <?php echo htmlspecialchars($product['ALLERGY_INFORMATION']); ?></p>
                <div class="trader-info">
                    <img src="<?php echo htmlspecialchars($trader['TRADER_SHOP_IMAGE']); ?>" alt="<?php echo htmlspecialchars($trader['TRADER_NAME']); ?>" class="trader-img">
                    <h5><a href="trader_details.php?id=<?php echo htmlspecialchars($trader['TRADER_ID']); ?>"><?php echo htmlspecialchars($trader['TRADER_NAME']); ?></a></h5>
                </div>
                <form method="post" action="cart.php">
                    <input type="hidden" name="Product_Id" value="<?php echo htmlspecialchars($product['PRODUCT_ID']); ?>">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-shopping-cart"></i> Add to Cart
                    </button>
                </form>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="reviews-container">
            <h3>Customer Reviews</h3>
            <?php if (count($reviews) > 0): ?>
                <?php foreach ($reviews as $review): ?>
                    <div class="review">
                        <div class="star-rating">
                            <?php for ($i = 0; $i < 5; $i++): ?>
                                <?php if ($i < $review['RATING']): ?>
                                    <i class="fas fa-star"></i>
                                <?php else: ?>
                                    <i class="far fa-star"></i>
                                <?php endif; ?>
                            <?php endfor; ?>
                        </div>
                        <div class="customer-name"><?php echo htmlspecialchars($review['CUSTOMER_NAME']); ?></div>
                        <div class="review-date"><?php echo date('F j, Y', strtotime($review['REVIEW_DATE'])); ?></div>
                        <div class="review-description"><?php echo htmlspecialchars($review['REVIEW_DESCRIPTION']); ?></div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No reviews yet. Be the first to review this product!</p>
            <?php endif; ?>
        </div>

        <!-- Add Review Section -->
        <h3>Add Your Review</h3>
        <form method="post" action="add_review.php">
            <input type="hidden" name="Product_Id" value="<?php echo htmlspecialchars($product['PRODUCT_ID']); ?>">
            <div class="mb-3 star-rating">
    <label for="rating" class="form-label">Rating</label>
    <div class="mb-3 star-rating">
        <input type="radio" id="star1" name="Rating" value="1">
        <label for="star1" title="1 star"><i class="far fa-star"></i></label>
        <input type="radio" id="star2" name="Rating" value="2">
        <label for="star2" title="2 stars"><i class="far fa-star"></i></label>
        <input type="radio" id="star3" name="Rating" value="3">
        <label for="star3" title="3 stars"><i class="far fa-star"></i></label>
        <input type="radio" id="star4" name="Rating" value="4">
        <label for="star4" title="4 stars"><i class="far fa-star"></i></label>
        <input type="radio" id="star5" name="Rating" value="5">
        <label for="star5" title="5 stars"><i class="far fa-star"></i></label>
    </div>
</div>


            <div class="mb-3">
                <label for="review_description" class="form-label">Review</label>
                <textarea id="review_description" name="Review_Description" class="form-control" rows="4" required></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit Review</button>
        </form>
    </div>

    <?php include "footer.php"; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
    const stars = document.querySelectorAll('.star-rating input');

    stars.forEach((star, index) => {
        star.addEventListener('click', () => {
            // Loop through all stars
            stars.forEach((s, i) => {
                // If the current star is less than or equal to the clicked star index, fill it
                if (i <= index) {
                    s.checked = true;
                    s.nextElementSibling.querySelector('i').classList.remove('far');
                    s.nextElementSibling.querySelector('i').classList.add('fas');
                } else {
                    // Otherwise, uncheck and empty it
                    s.checked = false;
                    s.nextElementSibling.querySelector('i').classList.remove('fas');
                    s.nextElementSibling.querySelector('i').classList.add('far');
                }
            });
        });
    });
</script>


</html>