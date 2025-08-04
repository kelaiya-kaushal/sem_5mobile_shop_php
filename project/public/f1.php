<?php
session_start();

// DB connection
$host = "localhost";
$user = "root";
$pass = "";
$db = "e_com1";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$message = ''; // Changed from $alert to $message for clarity and custom display
$message_type = ''; // To store 'success' or 'danger' for Bootstrap alerts

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  function clean($data) {
    return htmlspecialchars(trim($data));
  }

  $action = $_POST['action'] ?? '';

  if ($action === "register") {
    $username = clean($_POST['username'] ?? '');
    $email = clean($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (strlen($username) < 3) {
      $message = "Username must be at least 3 characters.";
      $message_type = "danger";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $message = "Invalid email format.";
      $message_type = "danger";
    } elseif (strlen($password) < 8) {
      $message = "Password must be at least 8 characters.";
      $message_type = "danger";
    } else {
      $check = $conn->prepare("SELECT user_id FROM user_master WHERE email = ?");
      $check->bind_param("s", $email);
      $check->execute();
      $check->store_result();

      if ($check->num_rows > 0) {
        $message = "Email already exists. Try logging in.";
        $message_type = "danger";
      } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO user_master (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashed);
        if ($stmt->execute()) {
          $message = "Registration successful! You can now login.";
          $message_type = "success";
          // Redirect to login form or directly to index.php if auto-login is desired
          // For now, just show success message and let user toggle to login
        } else {
          $message = "Registration failed. Please try again.";
          $message_type = "danger";
        }
        $stmt->close();
      }
      $check->close();
    }
  }

  if ($action === "login") {
    $email = clean($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if (empty($email) || empty($password)) {
      $message = "Email and password are required.";
      $message_type = "danger";
    } else {
      $stmt = $conn->prepare("SELECT user_id, password FROM user_master WHERE email = ?");
      if (!$stmt) {
        $message = "SQL error: " . $conn->error;
        $message_type = "danger";
      } else {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
          $stmt->bind_result($user_id, $hashed);
          $stmt->fetch();
          if (password_verify($password, $hashed)) {
            $_SESSION['user_id'] = $user_id;
            $_SESSION['username'] = $email; // Storing email as username for display purposes
            $message = "Login successful! Welcome back.";
            $message_type = "success";
            header("Location: index.php"); // Redirect to index.php after successful login
            exit;
          } else {
            $message = "Incorrect password.";
            $message_type = "danger";
          }
        } else {
          $message = "Email not found.";
          $message_type = "danger";
        }
        $stmt->close();
      }
    }
  }
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login & Register</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <!-- Bootstrap CSS for alerts -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <style>
    * {margin: 0;padding: 0;box-sizing: border-box;font-family: 'Montserrat', sans-serif;}
    body {background: #0f172a;height: 100vh;display: flex;justify-content: center;align-items: center;}
    .container {position: relative;width: 750px;height: 470px;perspective: 1000px;display: flex;z-index: 1;}
    input[type="checkbox"] {display: none;}
    .welcome-box {width: 50%;background: linear-gradient(135deg, #1e90ff, #00bcd4);color: #fff;border-radius: 0 100% 100% 0 / 0 100% 100% 0;display: flex;flex-direction: column;justify-content: center;align-items: center;padding: 40px;text-align: center;animation: pulseShape 5s infinite ease-in-out;}
    @keyframes pulseShape {0%, 100% {border-radius: 0 100% 100% 0 / 0 100% 100% 0;}50% {border-radius: 0 80% 80% 0 / 0 90% 90% 0;}}
    .form-container {position: relative;width: 50%;height: 100%;background: white;border-top-right-radius: 20px;border-bottom-right-radius: 20px;box-shadow: 0 0 25px rgba(0,0,0,0.2);transition: transform 1s cubic-bezier(0.68, -0.55, 0.27, 1.55);transform-style: preserve-3d;}
    input[type="checkbox"]:checked ~ .form-container {transform: rotateY(180deg);}
    form {position: absolute;width: 100%;height: 100%;padding: 40px;backface-visibility: hidden;animation: fadeSlide 1.2s ease;}
    @keyframes fadeSlide {from {opacity: 0;transform: translateY(20px);}to {opacity: 1;transform: translateY(0);}}
    .login-form {transform: rotateY(0deg);}
    .register-form {transform: rotateY(180deg);}
    form h2 {text-align: center;margin-bottom: 20px;color: #333;}
    form input {width: 100%;padding: 12px;margin: 10px 0;border: 2px solid #ddd;border-radius: 10px;transition: 0.3s;}
    form input:focus {border-color: #1e90ff;outline: none;background: #f0f8ff;}
    form button {width: 100%;padding: 12px;border: none;background: #1e90ff;color: white;font-weight: bold;border-radius: 10px;margin-top: 15px;transition: 0.4s ease;cursor: pointer;}
    form button:hover {background: #005aaf;transform: scale(1.05);}
    form label {display: block;text-align: center;margin-top: 20px;color: #555;cursor: pointer;transition: color 0.3s;}
    form label:hover {color: #1e90ff;}
    @media (max-width: 768px) {.container {flex-direction: column;width: 90%;height: auto;}.welcome-box, .form-container {width: 100%;border-radius: 0;}.form-container {height: 500px;}}
  </style>
</head>
<body>
  <div class="container">
    <div class="welcome-box">
      <h2>Welcome Back!</h2>
      <p>Login or register to continue and enjoy awesome features!</p>
    </div>

    <input type="checkbox" id="toggle">
    <div class="form-container">
      <!-- Login Form -->
      <form class="login-form" method="POST" onsubmit="return validateLogin()">
        <h2>Login</h2>
        <input type="hidden" name="action" value="login">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required minlength="8">
        <button type="submit">Login</button>
        <label for="toggle">Don't have an account? Register</label>
      </form>

      <!-- Register Form -->
      <form class="register-form" method="POST" onsubmit="return validateRegister()">
        <h2>Register</h2>
        <input type="hidden" name="action" value="register">
        <input type="text" name="username" placeholder="Username" required minlength="3">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required minlength="8">
        <button type="submit">Register</button>
        <label for="toggle">Already have an account? Login</label>
      </form>
    </div>
  </div>

  <script>
    function validateLogin() {
      const e = document.querySelector('.login-form input[name="email"]').value.trim();
      const p = document.querySelector('.login-form input[name="password"]').value.trim();
      const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
      if (!emailPattern.test(e)) { alert("⚠ Invalid email format."); return false; }
      if (p.length < 8) { alert("⚠ Password must be at least 8 characters."); return false; }
      return true;
    }

    function validateRegister() {
      const u = document.querySelector('.register-form input[name="username"]').value.trim();
      const e = document.querySelector('.register-form input[name="email"]').value.trim();
      const p = document.querySelector('.register-form input[name="password"]').value.trim();
      const emailPattern = /^[^ ]+@[^ ]+\.[a-z]{2,3}$/;
      if (u.length < 3) { alert("⚠ Username must be at least 3 characters."); return false; }
      if (!emailPattern.test(e)) { alert("⚠ Invalid email format."); return false; }
      if (p.length < 8) { alert("⚠ Password must be at least 8 characters."); return false; }
      return true;
    }
  </script>

  <?php if (!empty($alert)) { echo "<script>$alert</script>"; } ?>
</body>
</html>
