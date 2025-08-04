<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Search Results - MobileShop</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <style>
    /* 🧠 Custom Styles */
    body {
      background-color: #f0f4f8;
    }

    .product-card {
      background-color: #ffffff;
      border-radius: 16px;
      overflow: hidden;
      transition: all 0.3s ease;
      height: 100%;
      box-shadow: 0 0 10px rgba(0,0,0,0.05);
    }

    .product-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 15px 30px rgba(0,0,0,0.1);
    }

    .product-img-wrapper {
      width: 100%;
      height: 250px;
      background-color: #f9f9f9;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 10px;
    }

    .product-img {
      max-width: 100%;
      max-height: 100%;
      object-fit: contain;
    }

    .product-info {
      padding: 15px;
    }

    .product-info h5 {
      font-weight: 600;
      font-size: 1.1rem;
    }

    .product-info p {
      font-size: 0.95rem;
      color: #555;
    }

    .btn-buy {
      background-color: #000;
      color: #fff;
      border-radius: 8px;
      transition: 0.3s ease;
    }

    .btn-buy:hover {
      background-color: #444;
    }
  </style>
</head>
<body>
<?php include('Navbar.php'); ?>
<!-- Search Results -->
<div class="container my-5">
  <h4 class="mb-4">Search Results for: <em>"Samsung"</em></h4>

  <!-- Auto Suggestions -->
  <div class="mb-3">
    <p class="text-muted">Did you mean: <a href="#">Samsung Galaxy S25</a>, <a href="#">Samsung S23</a>?</p>
  </div>

  <div class="row g-4">
   
      <!-- 📱 Product Card 1 -->
      <div class="col-md-4 col-sm-6">
        <div class="product-card">
          <div class="product-img-wrapper">
            <img src="imeges/s25ultra.jpg" alt="Product 4" class="product-img">
          </div>
          <div class="product-info text-center">
            <h5>Samsung Galaxy S25 Ultra</h5>
            <p>₹1,24,999</p>
           <a href="productdetail.php"class="btn btn-buy w-100">Buy Now</a>
          </div>
        </div>
    </div>
   <!-- 📱 Product Card 2 -->
      <div class="col-md-4 col-sm-6">
        <div class="product-card">
          <div class="product-img-wrapper">
            <img src="https://fdn2.gsmarena.com/vv/pics/samsung/samsung-galaxy-s23-ultra-5g-1.jpg" alt="Product 1" class="product-img">
          </div>
          <div class="product-info text-center">
            <h5>Samsung Galaxy S21</h5>
            <p>₹66,999</p>
            <a href="productdetail.php" class="btn btn-buy w-100">Buy Now</a>
          </div>
        </div>
      </div>
  </div>
</div>
<?php include('Footer.php'); ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
