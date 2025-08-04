<?php include 'connection.php'; ?>
<?php
$message = null;
// Insert new category if form submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['category_name'])) {
    $category_name = trim($_POST['category_name']);
    if (!empty($category_name)) {
        $stmt = $conn->prepare("INSERT INTO mobile_brand (category_name, created_at) VALUES (?, NOW())");
        if ($stmt) {
            $stmt->bind_param("s", $category_name);
            if ($stmt->execute()) {
                $message = "✅ Category added successfully!";
            } else {
                $message = "❗ Error adding category: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $message = "❗ Database error: " . $conn->error;
        }   
    } else { 
        $message = "❗ Category name cannot be empty!";
    } 
}

// Fetch all categories to display
$categories = [];   
$result = $conn->query("SELECT category_id, category_name, created_at FROM mobile_brand ORDER BY created_at DESC");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Add & View Categories</title> 
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
  <h3 class="mb-4">Add New Mobile Brand Category</h3>
     
  <?php if ($message): ?>
    <div class="alert alert-info"><?= htmlspecialchars($message); ?></div>
  <?php endif; ?>

  <form method="POST" class="mb-4">
    <div class="mb-3">
      <label class="form-label">Category Name</label>
      <input type="text" class="form-control" name="category_name" required>
    </div>
    <button type="submit" class="btn btn-primary">Add Category</button>
  </form>

  <h4 class="mb-3">All Categories</h4>
  <?php if (count($categories) > 0): ?>
    <div class="table-responsive">
      <table class="table table-bordered align-middle">
        <thead class="table-light">
          <tr>
            <th>ID</th>
            <th>Category Name</th>
            <th>Created At</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($categories as $cat): ?>
          <tr>
            <td><?= $cat['category_id']; ?></td>
            <td><?= htmlspecialchars($cat['category_name']); ?></td>
            <td><?= $cat['created_at']; ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <p class="text-muted">No categories found.</p>
  <?php endif; ?>
</div>
</body>
</html>
