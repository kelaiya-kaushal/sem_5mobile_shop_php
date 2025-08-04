<?php
$conn = new mysqli("localhost", "root", "", "e_com1");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$error = "";
$success = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['product_name']);
    $desc = $_POST['product_description'];
    $price = floatval($_POST['product_price']);
    $qty = intval($_POST['stock_quantity']);
    $image_url = $_POST['image_path'];
    $brand_id = null;

    // Validation
    if ($qty <= 0) {
        $error = "Stock quantity must be greater than zero.";
    } else {
        // Check if product name already exists
        $checkName = $conn->prepare("SELECT product_id FROM product_master WHERE product_name = ?");
        $checkName->bind_param("s", $name);
        $checkName->execute();
        $nameResult = $checkName->get_result();

        if ($nameResult->num_rows > 0) {
            $error = "Product name already exists. Please choose a different name.";
        } else {
            // Handle brand
            if (!empty($_POST['brand_name'])) {
                $brand = trim($_POST['brand_name']);
                $check = $conn->prepare("SELECT brand_id FROM brand_master WHERE brand_name = ?");
                $check->bind_param("s", $brand);
                $check->execute();
                $result = $check->get_result();
                if ($result->num_rows > 0) {
                    $brand_id = $result->fetch_assoc()['brand_id'];
                } else {
                    $insert = $conn->prepare("INSERT INTO brand_master (brand_name) VALUES (?)");
                    $insert->bind_param("s", $brand);
                    $insert->execute();
                    $brand_id = $insert->insert_id;
                }
                $check->close();
            }

            // Insert product
            $stmt = $conn->prepare("INSERT INTO product_master (product_name, product_description, product_price, stock_quantity, brand_id, image_path) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssdiis", $name, $desc, $price, $qty, $brand_id, $image_url);
            if ($stmt->execute()) {
                header("Location: add_product.php?success=1");
                exit();
            } else {
                $error = "Error: " . $stmt->error;
            }
            $stmt->close();
        }
        $checkName->close();
    }
}

// If redirected with success
if (isset($_GET['success']) && $_GET['success'] == 1) {
    $success = "Product added successfully!";
}
?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Product Management</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="stylesheet" href="style.css">
 
</head>
<body>

  <div class="card">
    <div class="header-actions">
      <h2>Product Management</h2>
      <form method="GET" style="display: flex; align-items: center;">
        <input type="text" name="search" class="search-input" placeholder="Search products...">
        <a href="add_product.php" class="btn-add"><i class="fas fa-plus"></i> Add Product</a>
      </form>
    </div>

    <table>
      <thead>
        <tr>
          <th>Image</th>
          <th>Name</th>
          <th>Price (₹)</th>
          <th>Stock</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($products as $p): ?>
          <tr>
            <td><img src="<?= htmlspecialchars($p['image']) ?>" class="product-image" alt=""></td>
            <td><?= htmlspecialchars($p['name']) ?></td>
            <td><?= number_format($p['price'], 2) ?></td>
            <td><?= $p['stock'] ?></td>
            <td class="action-icons">
              <a href="edit_product.php?id=<?= $p['id'] ?>" class="edit" title="Edit"><i class="fas fa-edit"></i></a>
              <a href="delete_product.php?id=<?= $p['id'] ?>" class="delete" title="Delete" onclick="return confirm('Delete this product?')"><i class="fas fa-trash-alt"></i></a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

</body>
</html>

<!-- write a php logic to add product form database and fatch on user panel for add product .-->
<?php
