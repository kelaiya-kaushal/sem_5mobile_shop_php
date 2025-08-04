<?php
include 'connection.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Optional: delete image file too
    $img = mysqli_fetch_assoc(mysqli_query($conn, "SELECT image_url FROM product WHERE product_id = $id"));
    $image_path = "uploads/" . $img['image_url'];
    if (file_exists($image_path)) {
        unlink($image_path);
    }

    $sql = "DELETE FROM product WHERE product_id = $id";

    if (mysqli_query($conn, $sql)) {
        header("Location: product.php?deleted=1");
        exit;
    } else {
        echo "Error deleting product: " . mysqli_error($conn);
    }
} else {
    echo "Invalid ID.";
}
?>
