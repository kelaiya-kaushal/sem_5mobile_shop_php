<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Order Confirmation - MobileShop</title>
</head>
<body>
<?php include('Navbar.php'); ?>

<!-- Order Confirmation -->
<div class="container my-5 text-center">
  <div class="alert alert-success py-5">
    <h2 class="mb-3">🎉 Thank You for Your Order!</h2>
    <p class="lead">Your order <strong>#ORD202507051234</strong> has been successfully placed.</p>
    <p class="mb-4">We’ve sent you an email with the order details and tracking information.</p>
    <a href="../user/dashboard/index.html" class="btn btn-primary">View Order</a>
    <a href="index.php" class="btn btn-outline-secondary ms-2">Return to Homepage</a>
  </div>

  <!-- Order Summary -->
  <div class="card border-0 shadow-sm mx-auto" style="max-width: 600px;">
    <div class="card-body">
      <h5 class="card-title mb-3">Order Summary</h5>
      <p class="d-flex justify-content-between mb-1"><span>Samsung S22</span><span>₹64,999</span></p>
      <p class="d-flex justify-content-between mb-1"><span>OnePlus 12 (x2)</span><span>₹1,19,998</span></p>
      <hr>
      <p class="d-flex justify-content-between mb-1"><strong>Total</strong><strong>₹1,84,997</strong></p>
      <p class="text-muted mb-0">Estimated Delivery: Between 8–11 July 2025</p>
    </div>
  </div>
</div>

<?php include('Footer.php'); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
