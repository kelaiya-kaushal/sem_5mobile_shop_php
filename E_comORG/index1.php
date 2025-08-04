<?php include 'connection.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>All Products by Category</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h3 class="mb-4">Products (Category-wise)</h3>

  <?php
  // Fetch all categories
  $cat_result = $conn->query("SELECT category_id, category_name FROM mobile_brand ORDER BY category_name ASC");
  while ($cat = $cat_result->fetch_assoc()):
      $category_id = $cat['category_id'];
      $category_name = htmlspecialchars($cat['category_name']);

      echo "<h5 class='mt-4 mb-3 text-primary'>$category_name</h5>";

      // Fetch products for this category
      $stmt = $conn->prepare("SELECT * FROM product WHERE category_id = ?");
      $stmt->bind_param("i", $category_id);
      $stmt->execute();
      $products = $stmt->get_result();

      if ($products->num_rows > 0):
  ?>
      <div class="table-responsive">
        <table class="table table-bordered align-middle">
          <thead class="table-light">
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Description</th>
              <th>Price</th>
              <th>Stock</th>
              <th>Image</th>
              <th>Created At</th>
            </tr>
          </thead>
          <tbody>
          <?php while ($prod = $products->fetch_assoc()): ?>
            <tr>
              <td><?= $prod['product_id']; ?></td>
              <td><?= htmlspecialchars($prod['name']); ?></td>
              <td><?= htmlspecialchars($prod['description']); ?></td>
              <td>₹<?= $prod['price']; ?></td>
              <td><?= $prod['stock']; ?></td>
              <td><img src="<?= htmlspecialchars($prod['image_url']); ?>" width="50" height="50"></td>
              <td><?= $prod['created_at']; ?></td>
            </tr>
          <?php endwhile; ?>
          </tbody>
        </table>
      </div>
  <?php
      else:
          echo "<p class='text-muted'>No products found in this category.</p>";
      endif;

      $stmt->close();
  endwhile;
  ?>
</div>
</body>
</html>
