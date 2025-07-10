<?php
session_start();
require_once '../includes/config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if (!$email || !$password) {
        $error = 'Please enter both email and password.';
    } else {
        $stmt = $conn->prepare("SELECT id, first_name, password, failed_attempts, lockout_time FROM users WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->bind_result($id, $first_name, $hash, $failed_attempts, $lockout_time);
        if ($stmt->fetch()) {
            $now = new DateTime();
            $lockout = $lockout_time ? new DateTime($lockout_time) : null;

            if ($lockout && $now < $lockout->modify('+5 minutes')) {
                $error = 'Account locked due to too many failed attempts. Please try again later.';
            } elseif (password_verify($password, $hash)) {
                // Successful login
                $stmt->close();
                $stmt = $conn->prepare("UPDATE users SET failed_attempts = 0, lockout_time = NULL WHERE id = ?");
                $stmt->bind_param('i', $id);
                $stmt->execute();

                $_SESSION['user_id'] = $id;
                $_SESSION['first_name'] = $first_name;
                $_SESSION['email'] = $email;

                $success = 'Login successful! Redirecting...';
                header("refresh:2;url=cookbook.php");
            } else {
                // Failed attempt
                $failed_attempts++;
                $lockout_sql = '';
                if ($failed_attempts >= 3) {
                    $lockout_sql = ", lockout_time = NOW()";
                }

                $stmt->close();
                if ($lockout_sql) {
                    $stmt = $conn->prepare("UPDATE users SET failed_attempts = ? $lockout_sql WHERE id = ?");
                    $stmt->bind_param('ii', $failed_attempts, $id);
                } else {
                    $stmt = $conn->prepare("UPDATE users SET failed_attempts = ? WHERE id = ?");
                    $stmt->bind_param('ii', $failed_attempts, $id);
                }
                $stmt->execute();

                if ($failed_attempts >= 3) {
                    $error = 'Account locked due to too many failed attempts. Try again in 5 minutes.';
                } else {
                    $error = "Incorrect password. Attempts: $failed_attempts";
                }
            }
        } else {
            $error = 'No account found with that email.';
        }
    }
}
?>

<?php include '../includes/header.php'; ?>

<link rel="stylesheet" href="/assets/css/style.css">

<section style="max-width: 400px; margin: auto; padding: 2em;">
  <h2>Login</h2>

  <form method="post" action="login.php">
    <label>Email:<br>
      <input type="email" name="email" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
    </label><br><br>

    <label>Password:<br>
      <input type="password" name="password" required>
    </label>
    <?php if ($error): ?>
      <p id="error-msg" style="color: red; font-size: 0.85em; margin-top: 4px; margin-bottom: 15px;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <br>

    <button type="submit">Login</button>
  </form>

  <?php if ($success): ?>
    <p style="color: green; font-weight: bold; margin-top: 20px;"><?= htmlspecialchars($success) ?></p>
  <?php endif; ?>
</section>

<script>
  // If error message contains lockout warning, hide it after 5 minutes (300000 ms)
  window.addEventListener('DOMContentLoaded', () => {
    const errorMsg = document.getElementById('error-msg');
    if (errorMsg && errorMsg.textContent.includes('Account locked')) {
      setTimeout(() => {
        errorMsg.style.display = 'none';
      }, 300000); // 5 minutes in milliseconds
    }
  });
</script>

<?php include '../includes/footer.php'; ?>
