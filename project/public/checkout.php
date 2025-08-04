<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Checkout - MobileShop</title>

<style>
   .product-card img {
      height: 200px;
      object-fit: cover;
    }
    .sidebar {
      border-right: 1px solid #dee2e6;
    }
   
</style>
</head>
<body style="display: flex; flex-direction: column; min-height: 100vh;">

<?php include('Navbar.php'); ?>

<!-- Checkout Form -->
<div class="container my-5">
  <h3 class="mb-4">Checkout</h3>
  <div class="row">
    <!-- Shipping Info -->
    <div class="col-md-7">
      <form>
        <h5>Shipping Address</h5>
        <div class="row g-3">
          <div class="col-md-6">
            <label for="firstName" class="form-label">First Name</label>
            <input type="text" class="form-control" id="firstName" required>
          </div>
          <div class="col-md-6">
            <label for="lastName" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="lastName" required>
          </div>
          <div class="col-12">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control" id="address" placeholder="1234 Main St" required>
          </div>
          <div class="col-md-6">
            <label for="phone" class="form-label">Phone Number</label>
            <input type="tel" class="form-control" id="phone" required>
          </div>
          <div class="col-md-6">
            <label for="email" class="form-label">Email (for receipt)</label>
            <input type="email" class="form-control" id="email">
          </div>
        </div>

        <hr class="my-4"/>

        <!-- Payment Section -->
        <h5>Payment Method</h5>
        <div class="form-check mb-2">
          <input class="form-check-input" type="radio" name="payment" id="creditCard" checked>
          <label class="form-check-label" for="creditCard">Credit/Debit Card</label>
        </div>
        <div class="form-check mb-2">
          <input class="form-check-input" type="radio" name="payment" id="paypal">
          <label class="form-check-label" for="paypal">PayPal</label>
        </div>
        <div class="form-check mb-4">
          <input class="form-check-input" type="radio" name="payment" id="cod">
          <label class="form-check-label" for="cod">Cash on Delivery</label>
        </div>

        <div class="text-end">
          <button type="submit" class="btn btn-success btn-lg">Place Order</button>
        </div>
      </form>
    </div>

    <!-- Order Summary -->
    <div class="col-md-5">
      <div class="card border-dark">
        <div class="card-body">
          <h5 class="card-title">Order Summary</h5>
          <hr>
          <p class="d-flex justify-content-between"><span>Samsung S22</span><span>₹64,999</span></p>
          <p class="d-flex justify-content-between"><span>OnePlus 12 (x2)</span><span>₹1,19,998</span></p>
          <hr>
          <p class="d-flex justify-content-between"><strong>Subtotal</strong><strong>₹1,84,997</strong></p>
          <p class="d-flex justify-content-between"><span>Shipping</span><span>Free</span></p>
          <p class="d-flex justify-content-between"><span>Tax</span><span>₹0</span></p>
          <hr>
          <h5 class="d-flex justify-content-between">Total <span>₹1,84,997</span></h5>
          <p class="mt-3 text-muted">Estimated Delivery: 3–5 business days</p>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include('Footer.php'); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
