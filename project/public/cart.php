<?php
session_start();
include 'connection.php'; // Assuming this file connects to your MySQL database
$user_id = 1;

// Handle "Buy Now" direct add if coming from productdetail.php
// This is a simple way to add one item and redirect to cart.
if (isset($_GET['action']) && $_GET['action'] == 'buy_now' && isset($_GET['id'])) {
    $product_id = (int)$_GET['id'];
    $quantity = 1; // Default quantity for buy now

    // Check if the product already exists in the user's cart
    $check_sql = "SELECT * FROM cart WHERE user_id = ? AND product_id = ?";
    $stmt = mysqli_prepare($conn, $check_sql);
    mysqli_stmt_bind_param($stmt, "ii", $user_id, $product_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        // Product exists, update the quantity (increment by 1)
        $row = mysqli_fetch_assoc($result);
        $new_quantity = $row['quantity'] + $quantity;
        $update_sql = "UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?";
        $stmt_update = mysqli_prepare($conn, $update_sql);
        mysqli_stmt_bind_param($stmt_update, "iii", $new_quantity, $user_id, $product_id);
        mysqli_stmt_execute($stmt_update);
        mysqli_stmt_close($stmt_update);
    } else {
        // Product does not exist, insert new record
        $insert_sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)";
        $stmt_insert = mysqli_prepare($conn, $insert_sql);
        mysqli_stmt_bind_param($stmt_insert, "iii", $user_id, $product_id, $quantity);
        mysqli_stmt_execute($stmt_insert);
        mysqli_stmt_close($stmt_insert);
    }
    mysqli_stmt_close($stmt);
    // Redirect to clean URL to prevent re-adding on refresh
    header("Location: cart.php");
    exit();
}


// Fetch cart items joined with product table
$sql = "SELECT c.cart_id, c.quantity, p.product_id, p.name, p.price, p.image_url, p.description
        FROM cart c
        JOIN product p ON c.product_id = p.product_id
        WHERE c.user_id = $user_id";
$result = mysqli_query($conn, $sql);

// Calculate total
$subtotal = 0;
$shipping = 0; // Assuming free shipping for now
$tax = 0;      // Assuming 0 tax for now
$cart_items = [];
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $cart_items[] = $row;
        $subtotal += $row['price'] * $row['quantity'];
    }
}
$total = $subtotal + $shipping + $tax;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Shopping Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .cart-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }
        .order-summary {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 12px;
            padding: 30px;
        }
        .cart-item {
            border-bottom: 1px solid #dee2e6;
            padding: 20px 0;
            display: flex;
            align-items: center;
        }
        .cart-item:last-child {
            border-bottom: none;
        }
        .product-img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 8px;
            margin-right: 20px;
        }
        .qty-input {
            width: 60px;
            text-align: center;
            border-radius: 6px;
        }
        .item-info h6 {
            font-weight: 600;
            margin: 0;
        }
        .item-info small {
            color: #6c757d;
        }
        .total-price {
            font-weight: 600;
        }
        .summary-title {
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .summary-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .summary-total {
            font-size: 1.5rem;
            font-weight: bold;
            border-top: 1px dashed #ced4da;
            padding-top: 15px;
            margin-top: 15px;
        }
        .coupon-section {
            border-top: 1px solid #dee2e6;
            padding-top: 20px;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<!-- This is a placeholder for your Navbar, as seen in the image -->
<?php  include 'Navbar.php'; ?>

<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">Your Shopping Cart</h2>
        </div>
    </div>
    <div class="row">
        <!-- Cart Items Section -->
        <div class="col-lg-8 mb-4">
            <div class="cart-container">
                <?php if (count($cart_items) > 0): ?>
                    <?php foreach ($cart_items as $row): ?>
                        <div class="cart-item">
                            <img src="uploads/<?= htmlspecialchars($row['image_url']) ?>" class="product-img" alt="<?= htmlspecialchars($row['name']) ?>">
                            <div class="flex-grow-1 item-info">
                                <h6><?= htmlspecialchars($row['name']) ?></h6>
                                <small class="text-muted">Color: Silver</small> <!-- Assuming color, you may need to add this to your DB -->
                            </div>
                            <div class="text-center" style="width: 15%;">
                                <p class="mb-0">₹<?= number_format($row['price'], 2) ?></p>
                            </div>
                            <div class="text-center" style="width: 15%;">
                                <form method="post" action="update_cart.php" class="d-flex align-items-center justify-content-center">
                                    <input type="hidden" name="cart_id" value="<?= $row['cart_id'] ?>">
                                    <input type="number" name="quantity" class="form-control qty-input me-2" value="<?= $row['quantity'] ?>" min="1">
                                    <button type="submit" class="btn btn-sm btn-outline-primary">Update</button>
                                </form>
                            </div>
                            <div class="text-end" style="width: 15%;">
                                <p class="mb-0 total-price">₹<?= number_format($row['price'] * $row['quantity'], 2) ?></p>
                            </div>
                            <div class="text-end" style="width: 10%;">
                                <form method="post" action="remove_cart.php">
                                    <input type="hidden" name="cart_id" value="<?= $row['cart_id'] ?>">
                                    <button type="submit" class="btn btn-sm btn-outline-danger">Remove</button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <div class="mt-4">
                        <a href="index.php" class="btn btn-outline-secondary">Continue Shopping</a>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning text-center" role="alert">
                        Your cart is empty.
                    </div>
                    <div class="mt-4 text-center">
                        <a href="index.php" class="btn btn-primary">Start Shopping</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Order Summary Section -->
        <div class="col-lg-4">
            <div class="order-summary">
                <h3 class="summary-title">Order Summary</h3>
                <div class="summary-item">
                    <span>Subtotal</span>
                    <span>₹<?= number_format($subtotal, 2) ?></span>
                </div>
                <div class="summary-item">
                    <span>Shipping</span>
                    <span>Free</span>
                </div>
                <div class="summary-item">
                    <span>Tax</span>
                    <span>₹<?= number_format($tax, 2) ?></span>
                </div>
                <div class="summary-total">
                    <span>Total</span>
                    <span>₹<?= number_format($total, 2) ?></span>
                </div>
                <div class="d-grid gap-2 mt-4">
                    <a href="#" class="btn btn-success btn-lg">Proceed to Checkout</a>
                </div>
                <div class="coupon-section">
                    <p class="fw-bold">Coupon Code</p>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" placeholder="Enter code" aria-label="Coupon code">
                        <button class="btn btn-secondary" type="button">Apply Coupon</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- This is a placeholder for your Footer -->
<?php  include 'Footer.php'; ?>

<!-- Bootstrap JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
