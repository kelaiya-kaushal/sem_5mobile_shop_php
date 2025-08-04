<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer Snippet</title>
    <!-- Bootstrap 5 CSS CDN is required for the layout and classes -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom styles for the footer to match the navbar */
        .footer {
            background-color: #000; /* Dark background */
            color: #ccc; /* Light text color */
            padding: 1.5rem 0;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.5); /* Shadow for a lifted effect */
            margin-top: auto; /* Pushes the footer to the bottom of the page */
        }
        .footer-links .nav-link {
            color: #ccc;
            font-weight: 400;
            padding: 0.5rem 1rem;
            transition: color 0.3s ease-in-out, text-shadow 0.3s ease-in-out; /* Smooth transition for hover effect */
        }
        .footer-links .nav-link:hover {
            color: #fff;
            text-shadow: 0 0 8px #fff; /* Subtle glow on hover */
        }
        .footer-text {
            color: #999; /* Lighter text for the copyright notice */
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <!-- The footer section -->
    <footer class="footer">
        <div class="container text-center">
            <div class="d-flex justify-content-center flex-wrap footer-links">
                <a class="nav-link" href="#">Contact</a>
                <a class="nav-link" href="#">About Us</a>
                <a class="nav-link" href="#">Privacy Policy</a>
            </div>
            <div class="footer-text mt-3">
                &copy; 2024 MobileShop. All Rights Reserved.
            </div>
        </div>
    </footer>

    <!-- Bootstrap 5 JS is needed for some functionality but is optional for this simple snippet -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
