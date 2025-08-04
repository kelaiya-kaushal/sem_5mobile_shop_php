<?php
include 'connection.php';

if (!isset($_GET['id'])) {
    echo "❌ No product ID.";
    exit;
}

$id = $_GET['id'];

// Get product data
$result = mysqli_query($conn, "SELECT * FROM product WHERE product_id = $id");
$product = mysqli_fetch_assoc($result);

// Get all mobile brands (categories)
$cats = mysqli_query($conn, "SELECT * FROM mobile_brand");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-5">

<div class="container">
    <h2>Edit Product</h2>
    <form action="update_product.php" method="POST" enctype="multipart/form-data" class="bg-white p-4 shadow-sm rounded">
        <input type="hidden" name="id" value="<?= $product['product_id'] ?>">

        <div class="mb-3">
            <label>Current Image:</label><br>
            <img src="uploads/<?= $product['image_url'] ?>" width="100"><br>
            <label>Change Image:</label>
            <input type="file" name="image" class="form-control mt-1">
        </div>

        <div class="mb-3">
            <label>Product Name</label>
            <input type="text" name="name" value="<?= $product['name'] ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Price</label>
            <input type="number" step="0.01" name="price" value="<?= $product['price'] ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Stock Quantity</label>
            <input type="number" name="stock" value="<?= $product['stock'] ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Mobile Brand</label>
            <select name="category" class="form-select">
                <?php while ($cat = mysqli_fetch_assoc($cats)): ?>
                    <option value="<?= $cat['category_id'] ?>" <?= $cat['category_id'] == $product['category_id'] ? 'selected' : '' ?>>
                        <?= $cat['category_name'] ?>
                    </option>
                <?php endwhile; ?>
            </select>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" required><?= $product['description'] ?></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Product</button>
        <a href="product.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

</body>
</html>
