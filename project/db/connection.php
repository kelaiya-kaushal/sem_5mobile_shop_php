<?php
    $host = 'localhost'; // Hostname only, port handled separately
    $db   = 'e_com1';
    $user = 'root';
    $pass = '';
    $charset = 'utf8mb4';

    $conn = new mysqli($host, $user, $pass, $db);
    if ($conn -> connect_error) {
        die("Connection failed: " . mysqli_connect_error());
    }
    else {
        echo "Database connection successful!"; // Optional: remove in production
    }
?>
