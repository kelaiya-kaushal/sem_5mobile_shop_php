<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Management</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .card {
            border-radius: 1rem;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .table-responsive {
            border-radius: 0.5rem;
            overflow: hidden;
        }
        .table thead th {
            background-color: #e9ecef;
            border-bottom: 2px solid #dee2e6;
            font-weight: 600;
        }
        .table tbody td {
            vertical-align: middle;
        }
        .status-badge {
            font-weight: 600;
            padding: 0.4em 0.8em;
            border-radius: 50rem;
        }
        .status-delivered {
            background-color: #d4edda;
            color: #155724;
        }
        .status-shipped {
            background-color: #fff3cd;
            color: #856404;
        }
        .status-processing {
            background-color: #cce5ff;
            color: #004085;
        }
        .action-icon {
            font-size: 1.25rem;
            color: #007bff;
            margin: 0 0.25rem;
            cursor: pointer;
            transition: color 0.2s ease-in-out;
        }
        .action-icon:hover {
            color: #0056b3;
        }
        .close-button {
            background: none;
            border: none;
            font-size: 1.5rem;
            line-height: 1;
            color: #333;
            opacity: 0.5;
            transition: opacity 0.2s ease-in-out;
        }
        .close-button:hover {
            opacity: 1;
        }
    </style>
</head>
<body>

<?php
// PHP code to establish database connection and fetch data
include 'connection.php';
// Updated the query to use the column names from your database table
$orders = mysqli_query($conn, "SELECT order_id, user_id, total_amount, order_status, order_date FROM orders ORDER BY order_id DESC");
?>

<div class="container my-5">
    <div class="card p-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0">Order Management</h4>
            <button class="close-button" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <input type="text" class="form-control" placeholder="Search orders...">
            </div>
            <div class="col-md-6">
                <select class="form-select">
                    <option selected>All Statuses</option>
                    <option value="Delivered">Delivered</option>
                    <option value="Shipped">Shipped</option>
                    <option value="Processing">Processing</option>
                    <option value="Cancelled">Cancelled</option>
                </select>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th scope="col">Order ID</th>
                        <th scope="col">Customer</th>
                        <th scope="col">Status</th>
                        <th scope="col">Total</th>
                        <th scope="col">Date</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($orders)): ?>
                        <tr>
                            <td>#<?= $row['order_id'] ?></td>
                            <td><?= $row['user_id'] ?></td> <!-- Displaying user_id as a placeholder for Customer -->
                            <td>
                                <?php
                                $statusClass = '';
                                // Updated to use the 'order_status' column
                                switch ($row['order_status']) {
                                    case 'Delivered':
                                        $statusClass = 'status-delivered';
                                        break;
                                    case 'Shipped':
                                        $statusClass = 'status-shipped';
                                        break;
                                    case 'Processing':
                                        $statusClass = 'status-processing';
                                        break;
                                }
                                ?>
                                <span class="status-badge <?= $statusClass ?>"><?= $row['order_status'] ?></span>
                            </td>
                            <!-- Updated to use the 'total_amount' column -->
                            <td>₹<?= number_format($row['total_amount'], 2) ?></td>
                            <td><?= date('n/j/Y', strtotime($row['order_date'])) ?></td>
                            <td>
                                <i class="fa-solid fa-circle-info action-icon" title="View Details"></i>
                                <i class="fa-solid fa-arrows-rotate action-icon" title="Refresh Status"></i>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Bootstrap 5 JS with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
