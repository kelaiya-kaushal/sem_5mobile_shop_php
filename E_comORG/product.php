<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Product Management</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-light">
  <div class="container mt-5">
    <!-- Product Management Table -->
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h4 class="mb-0">Product Management</h4>
        <a href="#addModal" class="btn btn-primary" data-bs-toggle="modal">
          <i class="fas fa-plus"></i> Add Product
        </a>
      </div>
      <div class="card-body">
        <input type="text" class="form-control mb-3" placeholder="Search products...">
        <table class="table table-bordered text-center">
          <thead class="table-light">
            <tr>
              <th>Image</th>
              <th>Name</th>
              <th>Price</th>
              <th>Stock</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
        
            <!-- More rows here from PHP later -->
          <?php 
            include 'connection.php'; // make sure this connects successfully
          
            $categories = mysqli_query($conn, "SELECT * FROM mobile_brand");

            $result = mysqli_query($conn, "SELECT * FROM product");

            while ($row = mysqli_fetch_assoc($result)) {
            echo "
            <tr>
            <td><img src='uploads/{$row['image_url']}' width='40'></td>
            <td>{$row['name']}</td>
            <td>{$row['price']}</td>
            <td>{$row['stock']}</td>
            <td>
                <a href='edit_product.php?id={$row['product_id']}' class='text-primary me-2'><i class='fas fa-pen'></i></a>
                <a href='delete_product.php?id={$row['product_id']}' class='text-danger'><i class='fas fa-trash'></i></a>
            </td>
          </tr>";
}
?>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Add Product Modal -->
  <div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Add New Product</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="add_product.php" method="POST" enctype="multipart/form-data">
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Product Image</label>
              <input type="file" name="image" class="form-control" required>
            </div>
            <div class="row g-3">
              <div class="col-md-6">
                <label class="form-label">Product Name*</label>
                <input type="text" name="name" class="form-control" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Price*</label>
                <input type="number" name="price" class="form-control" required>
              </div>
              <div class="col-md-6">
                <label class="form-label">Stock Quantity*</label>
                <input type="number" name="stock" class="form-control" required>
              </div>
              <div class="mb-3">
                <label for="category" class="form-label">Select Category</label>
                  <select class="form-select" name="category_id" required>
                    <option value="">-- Choose Category --</option>
                      <?php while($cat = mysqli_fetch_assoc($categories)) { ?>
                    <option value="<?= $cat['category_id'] ?>"><?= $cat['category_name'] ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
            <div class="mt-3">
              <label class="form-label">Description</label>
              <textarea name="description" class="form-control" rows="3"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Add Product</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
