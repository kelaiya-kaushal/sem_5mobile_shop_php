<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Animated Navbar</title>
    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .navbar {
            background-color: #000; /* Dark background as in the image */
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
            padding: 1rem 0; /* Add some vertical padding */
        }
        .navbar-brand {
            font-weight: 700; /* Bolder font for the brand name */
            font-size: 1.5rem;
            color: #fff !important; /* Ensure the brand name is white */
            display: flex;
            align-items: center;
        }
        .navbar-brand img {
            width: 30px; /* Small icon size */
            height: 30px;
            margin-right: 10px;
        }
        .navbar-nav .nav-link {
            color: #ccc; /* Default link color */
            font-weight: 400;
            padding: 0.5rem 1rem;
            position: relative; /* Needed for the animated pseudo-element */
            transition: color 0.3s ease-in-out, text-shadow 0.3s ease-in-out; /* Smooth transitions for color and text-shadow */
            border-radius: 5px; /* Rounded corners for the glow effect */
        }
        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: #fff; /* White color on hover/active */
            text-shadow: 0 0 8px #fff; /* Creates a subtle glow directly on the text */
        }

        .navbar-nav .nav-link.active {
            font-weight: 600; /* Make active link slightly bolder */
            color: #fff; /* Ensure it stays white */
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <!-- Brand/Logo with placeholder image -->
        <a class="navbar-brand" href="#">
            <img src="https://placehold.co/30x30/212529/fff?text=📱" alt="MobileShop Logo">
            MobileShop
        </a>
        <!-- Toggler for mobile view -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
       <!-- Navigation links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link " href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="list.php">Shop</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="cart.php">Cart</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="checkout.php">Checkout</a>
                </li> 
                <li class="nav-item">
                    <a class="nav-link " href="order-confirmation.php">Order Confirmation</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="result.php">Search Result</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
</body>
</html>
