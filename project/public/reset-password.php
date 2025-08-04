<?php
session_start();

// DATABASE CONNECTION
$host = "localhost";
$user = "root";
$pass = "";
$db = "mobile_shop";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  function clean($data) {
    return htmlspecialchars(trim($data));
  }

  $email = isset($_POST['email']) ? clean($_POST['email']) : '';
  $newpass = isset($_POST['newpass']) ? $_POST['newpass'] : '';

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $msg = "\u26A0 Invalid email format.";
  } elseif (strlen($newpass) < 8) {
    $msg = "\u26A0 Password must be at least 8 characters.";
  } else {
    $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows === 1) {
      $hashed = password_hash($newpass, PASSWORD_DEFAULT);
      $update = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
      $update->bind_param("ss", $hashed, $email);
      $update->execute();
      $msg = "\u2705 Password updated successfully!";
    } else {
      $msg = "\u26A0 Email not found.";
    }
  }
  echo "<script>alert('$msg'); window.location='index.php';</script>";
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reset Password</title>
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Montserrat', sans-serif; }
    body { background: #0f172a; display: flex; justify-content: center; align-items: center; height: 100vh; }
    .box { background: #fff; padding: 40px; border-radius: 15px; box-shadow: 0 0 15px rgba(0,0,0,0.3); width: 350px; }
    h2 { text-align: center; color: #333; margin-bottom: 20px; }
    input { width: 100%; padding: 10px; margin: 10px 0; border-radius: 8px; border: 2px solid #ccc; transition: 0.3s; }
    input:focus { border-color: #1e90ff; outline: none; background: #f0f8ff; }
    button { width: 100%; padding: 12px; background: #1e90ff; color: white; border: none; font-weight: bold; border-radius: 10px; margin-top: 15px; cursor: pointer; transition: 0.3s; }
    button:hover { background: #005aaf; transform: scale(1.03); }
    a { display: block; margin-top: 15px; text-align: center; color: #1e90ff; text-decoration: none; }
    a:hover { text-decoration: underline; }
  </style>
</head>
<body>
  <form class="box" method="POST" onsubmit="return validateReset()">
    <h2>Reset Password</h2>
    <input type="email" name="email" placeholder="Enter your email" required>
    <input type="password" name="newpass" placeholder="Enter new password" required>
    <button type="submit">Reset Password</button>
    <a href="index.php">Back to Login</a>
  </form>

  <script>
    function validateReset() {
      const email = document.querySelector('input[name="email"]').value.trim();
      const pass = document.querySelector('input[name="newpass"]').value.trim();
      const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;

      if (!emailPattern.test(email)) {
        alert("\u26A0 Invalid email format.");
        return false;
      }
      if (pass.length < 8) {
        alert("\u26A0 Password must be at least 8 characters.");
        return false;
      }
      return true;
    }
  </script>
</body>
</html>
