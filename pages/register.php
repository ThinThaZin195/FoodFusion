<?php
session_start();
require_once '../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first = trim($_POST['first_name'] ?? '');
    $last = trim($_POST['last_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($first && $last && $email && $password) {
        // Check if email already exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            echo "<script>alert('Email already registered.'); window.history.back();</script>";
            exit;
        } else {
            // Hash password
            $hashed = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO users (first_name, last_name, email, password) VALUES (?, ?, ?, ?)");
            $stmt->bind_param('ssss', $first, $last, $email, $hashed);
            if ($stmt->execute()) {
                echo "<script>
                        alert('Registration successful! You can now log in.');
                        window.location.href = 'login.php';
                      </script>";
                exit;
            } else {
                echo "<script>alert('Registration failed. Please try again.'); window.history.back();</script>";
                exit;
            }
        }
    } else {
        echo "<script>alert('Please fill in all fields.'); window.history.back();</script>";
        exit;
    }
}
?>

<?php include '../includes/header.php'; ?>

<link rel="stylesheet" href="/assets/css/style.css">

<section style="max-width: 400px; margin: auto; padding: 2em;">
  <h2>Register</h2>
  <form method="post" action="register.php">
    <label>First Name:<br>
      <input type="text" name="first_name" required>
    </label><br><br>

    <label>Last Name:<br>
      <input type="text" name="last_name" required>
    </label><br><br>

    <label>Email:<br>
      <input type="email" name="email" required>
    </label><br><br>

    <label>Password:<br>
      <input type="password" name="password" required>
    </label><br><br>

    <button type="submit">Register</button>
  </form>
</section>

<?php include '../includes/footer.php'; ?>
