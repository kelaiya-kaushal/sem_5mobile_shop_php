<?php
include 'connection.php'; // Make sure this file exists and connects properly

// --- Fetch Brands ---
$brands = []; // Initialize an empty array for brands
$brands_query = mysqli_query($conn, "SELECT category_id, category_name FROM mobile_brand ORDER BY category_name");

if ($brands_query) {
    while ($b = mysqli_fetch_assoc($brands_query)) {
        $brands[] = $b;
    }
} else {
    // If there's an error fetching brands, display it
    echo "<p style='color: red;'>Error fetching brands: " . mysqli_error($conn) . "</p>";
}

// --- Initialize Filter Variables ---
$category_filter = null;
$min_price_filter = null;
$max_price_filter = null;
$sort_order = '';

// --- Process Filters from GET Request ---
if (isset($_GET['category']) && $_GET['category'] !== '') {
    $category_filter = (int)$_GET['category']; // Ensure it's an integer
}
if (isset($_GET['min']) && $_GET['min'] !== '') {
    $min_price_filter = (float)$_GET['min']; // Ensure it's a float
}
if (isset($_GET['max']) && $_GET['max'] !== '') {
    $max_price_filter = (float)$_GET['max']; // Ensure it's a float
}
if (isset($_GET['sort'])) {
    $sort_order = htmlspecialchars($_GET['sort']); // Sanitize sort input
}

// --- Build WHERE Clause for Product Query ---
$where_clauses = ["1=1"]; // Start with a true condition for easy AND concatenation

if ($category_filter !== null) {
    $where_clauses[] = "p.category_id = " . mysqli_real_escape_string($conn, $category_filter);
}
if ($min_price_filter !== null && $min_price_filter >= 0) {
    $where_clauses[] = "p.price >= " . mysqli_real_escape_string($conn, $min_price_filter);
}
if ($max_price_filter !== null && $max_price_filter >= 0) {
    $where_clauses[] = "p.price <= " . mysqli_real_escape_string($conn, $max_price_filter);
}

$where_sql = " WHERE " . implode(" AND ", $where_clauses);

// --- Build ORDER BY Clause for Product Query ---
$order_sql = " ORDER BY p.created_at DESC"; // Default sort
if ($sort_order === 'price_asc') {
    $order_sql = " ORDER BY p.price ASC";
} elseif ($sort_order === 'price_desc') {
    $order_sql = " ORDER BY p.price DESC";
}

// --- Fetch Products with Brand Name ---
$products = []; // Initialize an empty array for products
$product_query_string = "SELECT p.*, m.category_name 
                         FROM product p 
                         LEFT JOIN mobile_brand m ON p.category_id = m.category_id" 
                         . $where_sql . $order_sql;
$products_result = mysqli_query($conn, $product_query_string);

if ($products_result) {
    while ($p = mysqli_fetch_assoc($products_result)) {
        $products[] = $p;
    }
} else {
    // If there's an error fetching products, display it
    echo "<p style='color: red;'>Error fetching products: " . mysqli_error($conn) . "</p>";
}

mysqli_close($conn);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MobileShop - Shop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body { background: #f8fafc; }
        .filter-box {
            background-color: #fff;
            padding: 1.5rem;
            border-radius: 0.5rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }
        .product-grid-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }
        .product-card {
            background-color: #fff;
            border-radius: 0.5rem;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            height: 100%;
        }
        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }
        .product-card-img-container {
            height: 200px; /* Fixed height for image container */
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
            border-bottom: 1px solid #eee;
        }
        .product-card-img-top {
            max-height: 100%;
            max-width: 100%;
            object-fit: contain;
        }
        .card-body {
            display: flex;
            flex-direction: column;
        }
        .product-title {
            font-size: 1.2rem;
            font-weight: 600;
            color: #333;
        }
        .brand-name {
            font-size: 0.9rem;
            color: #777;
            margin-bottom: 0.5rem;
        }
        .product-price {
            font-size: 1.1rem;
            font-weight: 500;
            color: #000;
            margin-top: auto; /* Push to the bottom */
            margin-bottom: 1rem;
        }
        .btn-buy {  
            background-color: #000;
            color: #fff;
            border: none;
            width: 100%;
            font-weight: 500;
            transition: background-color 0.2s ease;
        }
        .btn-buy:hover {
            background-color: #333;
            color: #fff;
        }
    </style>
</head>
<body>

<?php  include 'Navbar.php'; // Include the navigation bar (assuming it exists) ?>
<div class="container py-5">
    <div class="row">
        <div class="col-md-3">
            <div class="filter-box mb-4">  
                <h5 class="mb-3">Filter By</h5>
                <form method="GET" action="list.php">
                    <div class="mb-3">
                        <label for="category_select" class="form-label">Brand</label>
                        <select name="category" id="category_select" class="form-select">
                            <option value="">All</option>
                            <?php foreach($brands as $b): ?>
                                <option value="<?= htmlspecialchars($b['category_id']) ?>"
                                        <?= ($category_filter == $b['category_id']) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($b['category_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div> 

                    <div class="mb-3">
                        <label class="form-label">Price</label>
                        <div class="d-flex align-items-center mb-2">
                            <input type="number" name="min" id="min_price" class="form-control me-2"
                                    value="<?= htmlspecialchars($min_price_filter ?? '') ?>" placeholder="Min">
                            <span>-</span>
                            <input type="number" name="max" id="max_price" class="form-control ms-2"
                                    value="<?= htmlspecialchars($max_price_filter ?? '') ?>" placeholder="Max">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mt-3">Apply Filters</button>
                    <?php
                    // Show "Clear Filters" button if any filter is active
                    if ($category_filter !== null || $min_price_filter !== null || $max_price_filter !== null || $sort_order !== '') {
                        echo '<a href="list.php" class="btn btn-outline-secondary w-100 mt-2">Clear Filters</a>';
                    }
                    ?>
                </form>
            </div>
        </div>

        <div class="col-md-9">
            <div class="product-grid-header">
                <h5 class="mb-0">Showing Results (<?= count($products) ?>)</h5>
                <form method="GET" action="list.php" class="d-flex align-items-center">
                    <?php
                    // Preserve current filters when changing sort order
                    $current_get_params = $_GET;
                    unset($current_get_params['sort']); // Remove 'sort' so we can re-add it cleanly
                    foreach($current_get_params as $key => $value):
                    ?>
                        <input type="hidden" name="<?= htmlspecialchars($key) ?>" value="<?= htmlspecialchars($value) ?>">
                    <?php endforeach; ?>
                    <label for="sort_select" class="form-label me-2 mb-0">Sort by: </label>
                    <select name="sort" id="sort_select" class="form-select" onchange="this.form.submit()">
                        <option value="">Relevance</option>
                        <option value="price_asc" <?= ($sort_order === 'price_asc') ? 'selected' : '' ?>>Price: Low to High</option>
                        <option value="price_desc" <?= ($sort_order === 'price_desc') ? 'selected' : '' ?>>Price: High to Low</option>
                    </select>
                </form>
            </div>

            <div class="row g-4">
                <?php if (!empty($products)): ?>
                    <?php foreach($products as $p): ?>
                        <div class="col-12 col-sm-6 col-md-4 col-lg-4">
                            <div class="product-card h-100 text-center">
                                <div class="product-card-img-container">
                                    <?php if(isset($p['image_url']) && $p['image_url']): ?>
                                        <img src="uploads/<?= htmlspecialchars($p['image_url']) ?>" class="product-card-img-top" alt="<?= htmlspecialchars($p['name']) ?>">
                                    <?php else: ?>
                                        <img src="https://via.placeholder.com/200x200/CCCCCC/888888?text=No+Image" class="product-card-img-top" alt="No Image Available">
                                    <?php endif; ?>
                                </div>
                                <div class="card-body d-flex flex-column justify-content-between">
                                    <h5 class="product-title"><?= htmlspecialchars($p['name']) ?></h5>
                                    <p class="brand-name">Brand: <?= htmlspecialchars($p['category_name'] ?? 'N/A') ?></p>
                                    <p class="product-price">₹<?= number_format($p['price'], 2) ?></p>
                                    <a href="productdetail.php?id=<?= htmlspecialchars($p['product_id']) ?>" class="btn btn-buy mt-auto">Buy Now</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="alert alert-warning text-center" role="alert">
                            No products found matching your criteria.
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php  include 'Footer.php'; // Include the footer (assuming it exists) ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
