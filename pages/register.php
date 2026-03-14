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

<section style="max-width: 380px; margin: 2em auto; padding: 1.5em; text-align: center;">
  <h2 style="font-size: 2em; margin-bottom: 0.5em; background: linear-gradient(135deg, #ff7043, #facc15); -webkit-background-clip: text; background-clip: text; color: transparent;"><i class="fa-solid fa-user-plus"></i> Create Account</h2>
  
  <form method="post" action="register.php" style="text-align: left;">
    <div style="display: flex; gap: 1em; flex-wrap: wrap;">
        <label style="flex: 1; min-width: 120px;">First Name:
          <input type="text" name="first_name" placeholder="John" required>
        </label>

        <label style="flex: 1; min-width: 120px;">Last Name:
          <input type="text" name="last_name" placeholder="Doe" required>
        </label>
    </div>

    <label style="margin-top: 0.5em;">Email:
      <input type="email" name="email" placeholder="john@example.com" required>
    </label>

    <label style="margin-top: 0.5em;">Password:
      <input type="password" name="password" placeholder="••••••••" required>
    </label>

    <button type="submit" style="margin-top: 1.5em; width: 100%;"><i class="fa-solid fa-bolt"></i> Register</button>
  </form>
  
  <p style="margin-top: 2em; font-size: 0.9em; color: var(--text-muted);">Already have an account? <a href="login.php" style="color: var(--primary); text-decoration: none; font-weight: bold;">Login here</a></p>
</section>

<?php include '../includes/footer.php'; ?>
