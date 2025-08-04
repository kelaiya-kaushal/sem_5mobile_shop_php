<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Mobile Shop - Home</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
  <style>
    body {
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f8f9fa;
    }

    .carousel-item {
      height: 500px;
    }
    .carousel-item img {
      width: 100%;
      height: 500px;
      object-fit: cover;
    }

    .carousel-caption {
      top: 50%;
      transform: translateY(-50%);
      bottom: auto;
      text-align: center;
    }
    .carousel-caption h1 {
      font-size: 3rem;
      font-weight: bold;
      text-shadow: 2px 2px 5px rgba(0,0,0,0.6);
    }
    .carousel-caption p {
      font-size: 1.2rem;
      font-weight: 500;
      max-width: 600px;
      margin: 10px auto 0;
      color: #fff;
      text-shadow: 1px 1px 3px rgba(0,0,0,0.5);
    }

    .product-card { border: 1px solid #ccc; border-radius: 15px; padding: 20px; background-color: #fff; display: flex; flex-direction: column; transition: 0.3s; }
    .product-card:hover { box-shadow: 0 4px 20px rgba(0,0,0,0.1); transform: scale(1.02); }
    .product-img { max-height: 180px; object-fit: contain; margin-bottom: 15px; }
    .price-tag { font-size: 1.2rem; color: #1cbce4ff; font-weight: bold; margin-top: auto; }
    .product-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 20px; margin-top: 30px; }

    .btn-view-details { background-color: #000000ff; color: white; border: 1px solid #000000ff; }
    .btn-view-details:hover { background-color: #0099cc; border-color: #0099cc; }
    .btn-buy-now { background-color: #000; color: white; border: 1px solid #000; }
    .btn-buy-now:hover { background-color: #333; border-color: #333; }
  </style>
</head>
<body>

<?php include 'Navbar.php'; ?>

<!-- Carousel without search bar -->
<div id="heroCarousel" class="carousel slide position-relative" data-bs-ride="carousel">

  <div class="carousel-indicators">
    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true"></button>
    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1"></button>
    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2"></button>
    <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="3"></button>
  </div>

  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="slider6.jpg" alt="Slide 1">
      <div class="carousel-caption">
        <h1>Discover the Latest Mobiles</h1>
        <p>Great Deals. Fast Delivery. Trusted Brands.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="image.png" alt="Slide 2">
      <div class="carousel-caption">
        <h1>Next-Gen Technology</h1>
        <p>Explore the future of mobile communication.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="Apple.jpg" alt="Slide 3">
      <div class="carousel-caption">
        <h1>Exclusive Online Offers</h1>
        <p>Shop with confidence and get the best prices.</p>
      </div>
    </div>
    <div class="carousel-item">
      <img src="slider2.jpg" alt="Slide 4">
      <div class="carousel-caption">
        <h1>Experience Luxury Devices</h1>
        <p>Unmatched quality and performance.</p>
      </div>
    </div>
  </div>

  <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
    <span class="carousel-control-prev-icon"></span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
    <span class="carousel-control-next-icon"></span>
  </button>
</div>

<?php
include 'connection.php';
// Fetch only the latest 12 products
$products = mysqli_query($conn, "SELECT * FROM product ORDER BY created_at DESC LIMIT 12");
?>

<div class="container mt-4">
  <h2 class="mb-4 text-center">Our Latest Products</h2>
  <div class="product-grid">
    <?php while ($row = mysqli_fetch_assoc($products)): ?>
      <div class="product-card">
        <img src="uploads/<?= htmlspecialchars($row['image_url']) ?>" class="w-100 product-img" alt="<?= htmlspecialchars($row['name']) ?>">
        <h5><?= htmlspecialchars($row['name']) ?></h5>
        <p class="price-tag">₹<?= number_format($row['price'], 2) ?></p>
        <p class="text-muted"><?= htmlspecialchars(substr($row['description'], 0, 50)) ?>...</p>
        <a href="productdetail.php?id=<?= htmlspecialchars($row['product_id']) ?>" class="btn btn-view-details w-100 mt-2">View Details</a>
        <a href="cart.php?id=<?= htmlspecialchars($row['product_id']) ?>" class="btn btn-buy-now w-100 mt-2">Buy Now</a>
      </div>
    <?php endwhile; ?>
  </div>
</div>

<?php include 'Footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
