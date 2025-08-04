<?php
include 'connection.php';

// Get product id from URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch product details from product table
$product_result = mysqli_query($conn, "SELECT * FROM product WHERE product_id = $id");
$product = mysqli_fetch_assoc($product_result);

// Fetch brand name from mobile_brand using category_id (assuming product has category_id)
$brand_name = 'N/A';
if ($product && isset($product['category_id'])) {
    $cat_id = (int)$product['category_id'];
    $brand_result = mysqli_query($conn, "SELECT category_name FROM mobile_brand WHERE category_id = $cat_id");
    if ($brand_row = mysqli_fetch_assoc($brand_result)) {
        $brand_name = $brand_row['category_name'] ?? 'N/A';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title><?= htmlspecialchars($product['name'] ?? 'Product Not Found') ?></title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body { background: #f6f7fb; }
    .product-container {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    .product-image {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 400px; /* Set a fixed height for the image container */
        padding: 20px;
    }
    .product-image img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain; /* This will make sure the image scales properly */
        border-radius: 12px 0 0 12px;
    }
    .product-details {
        padding: 30px;
    }
    .product-title {
        font-size: 2rem;
        font-weight: 700;
        margin-bottom: 10px;
    }
    .brand {
        font-size: 1rem;
        color: #6c757d;
        margin-bottom: 15px;
    }
    .rating i {
        color: #ffc107;
    }
    .price {
        font-size: 1.8rem;
        color: #28a745;
        font-weight: 600;
        margin: 15px 0;
    }
    .description {
        margin-bottom: 20px;
        color: #444;
    }
    .btn-add {
        background: #ffc107;
        color: #000;
        font-weight: 600;
        border: none;
        padding: 10px 20px;
        margin-right: 10px;
        border-radius: 6px;
    }
    .btn-add:hover { background: #e0a800; }
    .btn-buy {
        background: #000;
        color: #fff;
        font-weight: 600;
        border: none;
        padding: 10px 20px;
        border-radius: 6px;
    }
    .btn-buy:hover { background: #333; }
</style>
</head>
<body>
<?php include 'Navbar.php'; // Include the header (assuming it exists) ?>

<div class="container my-5">
<?php if($product): ?>
    <div class="row product-container">
        <div class="col-md-6 product-image">
            <?php if($product['image_url']): ?>
                <img src="uploads/<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
            <?php else: ?>
                <div class="bg-light d-flex align-items-center justify-content-center" style="height:400px;">No image</div>
            <?php endif; ?>
        </div>
        <div class="col-md-6 product-details">
            <h1 class="product-title"><?= htmlspecialchars($product['name']) ?></h1>
            <div class="brand">Brand: <?= htmlspecialchars($brand_name) ?></div>
            <div class="rating mb-2">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="far fa-star"></i>
                <span>(203 reviews)</span>
            </div>
            <div class="price">₹<?= number_format($product['price'],2) ?></div>
            <div class="description"><?= nl2br(htmlspecialchars($product['description'])) ?></div>
            <div class="mb-2">Stock: <?= htmlspecialchars($product['stock']) ?></div>
            
            <!-- Add to Cart Form -->
            <form action="add_to_cart.php" method="post" style="display:inline-block;">
                <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['product_id']) ?>">
                <input type="hidden" name="quantity" value="1"> <!-- Default to adding 1 item -->
                <button type="submit" class="btn btn-add">Add to Cart</button>
            </form>
            
            <!-- Buy Now Button (can also be a form or link to cart/checkout) -->
            <a href="cart.php?id=<?= htmlspecialchars($product['product_id']) ?>&action=buy_now" class="btn btn-buy">Buy Now</a>
        </div>
    </div>
<?php else: ?>
    <div class="alert alert-warning">Product not found.</div>
<?php endif; ?>
</div>
<?php include 'Footer.php'; // Include the footer (assuming it exists) ?>

<!-- Font Awesome for stars -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
