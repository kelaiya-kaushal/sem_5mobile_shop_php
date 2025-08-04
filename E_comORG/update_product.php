<?php
include 'connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id          = $_POST['id'];
    $name        = $_POST['name'];
    $price       = $_POST['price'];
    $stock       = $_POST['stock'];
    $category_id = $_POST['category'];
    $description = $_POST['description'];

    // Optional image upload
    if (!empty($_FILES['image']['name'])) {
        $image_name = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];
        move_uploaded_file($tmp_name, "uploads/" . $image_name);

        $sql = "UPDATE product SET 
            name='$name',
            price='$price',
            stock='$stock',
            category_id='$category_id',
            description='$description',
            image_url='$image_name'
            WHERE product_id=$id";
    } else {
        $sql = "UPDATE product SET 
            name='$name',
            price='$price',
            stock='$stock',
            category_id='$category_id',
            description='$description'
            WHERE product_id=$id";
    }

    if (mysqli_query($conn, $sql)) {
        header("Location: product.php?updated=1");
        exit;
    } else {
        echo "❌ Error updating product: " . mysqli_error($conn);
    }
} else {
    echo "❌ Invalid request.";
}
?>
