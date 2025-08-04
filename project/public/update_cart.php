<?php
session_start();
include 'connection.php'; // Include your database connection file

// --- IMPORTANT: Replace with a real user_id from a session or authentication system ---
$user_id = 1; // Dummy user ID

if (isset($_POST['cart_id']) && isset($_POST['quantity'])) {
    $cart_id = (int)$_POST['cart_id'];
    $quantity = (int)$_POST['quantity'];

    // Ensure quantity is at least 1
    if ($quantity < 1) {
        $quantity = 1;
    }

    // Update the quantity in the cart table
    // Add a check to ensure the cart_id belongs to the current user for security
    $update_sql = "UPDATE cart SET quantity = ? WHERE cart_id = ? AND user_id = ?";
    $stmt = mysqli_prepare($conn, $update_sql);
    mysqli_stmt_bind_param($stmt, "iii", $quantity, $cart_id, $user_id);

    if (mysqli_stmt_execute($stmt)) {
        // Success
        header("Location: cart.php"); // Redirect back to cart page
        exit();
    } else {
        // Error updating
        echo "Error updating cart item: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
} else {
    // If cart_id or quantity is not set, redirect back to cart or show an error
    header("Location: cart.php");
    exit();
}

mysqli_close($conn);
?>
