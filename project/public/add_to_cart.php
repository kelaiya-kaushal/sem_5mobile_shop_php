<?php
session_start();
include 'connection.php'; // Include your database connection file

// --- IMPORTANT: Replace with a real user_id from a session or authentication system ---
// For demonstration, we use a dummy user_id. In a real application, this would come from
// a logged-in user's session, e.g., $_SESSION['user_id'].
$user_id = 1; // Dummy user ID

if (isset($_POST['product_id']) && isset($_POST['quantity'])) {
    $product_id = (int)$_POST['product_id'];
    $quantity = (int)$_POST['quantity'];

    // Ensure quantity is at least 1
    if ($quantity < 1) {
        $quantity = 1;
    }

    // Check if the product already exists in the user's cart
    $check_sql = "SELECT * FROM cart WHERE user_id = ? AND product_id = ?";
    $stmt = mysqli_prepare($conn, $check_sql);
    mysqli_stmt_bind_param($stmt, "ii", $user_id, $product_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        // Product exists, update the quantity
        $row = mysqli_fetch_assoc($result);
        $new_quantity = $row['quantity'] + $quantity;
        $update_sql = "UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?";
        $stmt_update = mysqli_prepare($conn, $update_sql);
        mysqli_stmt_bind_param($stmt_update, "iii", $new_quantity, $user_id, $product_id);
        if (mysqli_stmt_execute($stmt_update)) {
            // Success
            header("Location: cart.php"); // Redirect to cart page
            exit();
        } else {
            // Error updating
            echo "Error updating cart: " . mysqli_error($conn);
        }
    } else {
        // Product does not exist, insert new record
        $insert_sql = "INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)";
        $stmt_insert = mysqli_prepare($conn, $insert_sql);
        mysqli_stmt_bind_param($stmt_insert, "iii", $user_id, $product_id, $quantity);
        if (mysqli_stmt_execute($stmt_insert)) {
            // Success
            header("Location: cart.php"); // Redirect to cart page
            exit();
        } else {
            // Error inserting
            echo "Error adding to cart: " . mysqli_error($conn);
        }
    }
    mysqli_stmt_close($stmt);
    if (isset($stmt_update)) mysqli_stmt_close($stmt_update);
    if (isset($stmt_insert)) mysqli_stmt_close($stmt_insert);
} else {
    // If product_id or quantity is not set, redirect back to home or show an error
    header("Location: index.php");
    exit();
}

mysqli_close($conn);
?>
