<?php
// add_product.php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name        = mysqli_real_escape_string($conn, $_POST['name']);
    $price       = mysqli_real_escape_string($conn, $_POST['price']);
    $stock       = mysqli_real_escape_string($conn, $_POST['stock']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $category_id = (int)mysqli_real_escape_string($conn, $_POST['category_id']);



    $image_name = $_FILES['image']['name'];
    $image_tmp  = $_FILES['image']['tmp_name'];
    $image_path = 'uploads/' . basename($image_name);

    if (move_uploaded_file($image_tmp, $image_path)) {
       $sql = "INSERT INTO product (category_id, name, description, price, stock, image_url)
        VALUES ('$category_id', '$name', '$description', '$price', '$stock', '$image_name')";


        if (mysqli_query($conn, $sql)) {
            header("Location: product.php?success=1");
            exit;
        } else {
            echo "Error inserting product: " . mysqli_error($conn);
        }
    } else {
        echo "Image upload failed.";
    }
} else {
    echo "Invalid request method.";
}
?>
 