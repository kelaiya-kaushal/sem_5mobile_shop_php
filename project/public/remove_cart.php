<?php
session_start();
include 'connection.php'; // Include your database connection file

// --- IMPORTANT: Replace with a real user_id from a session or authentication system ---
$user_id = 1; // Dummy user ID

if (isset($_POST['cart_id'])) {
    $cart_id = (int)$_POST['cart_id'];

    // Remove the item from the cart table
    // Add a check to ensure the cart_id belongs to the current user for security
    $delete_sql = "DELETE FROM cart WHERE cart_id = ? AND user_id = ?";
    $stmt = mysqli_prepare($conn, $delete_sql);
    mysqli_stmt_bind_param($stmt, "ii", $cart_id, $user_id);

    if (mysqli_stmt_execute($stmt)) {
        // Success
        header("Location: cart.php"); // Redirect back to cart page
        exit();
    } else {
        // Error deleting
        echo "Error removing cart item: " . mysqli_error($conn);
    }
    mysqli_stmt_close($stmt);
} else {
    // If cart_id is not set, redirect back to cart or show an error
    header("Location: cart.php");
    exit();
}

mysqli_close($conn);
?>
