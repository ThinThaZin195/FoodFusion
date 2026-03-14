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
            } elseif (password_verify($password, (string)$hash)) {
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

<section style="max-width: 380px; margin: 2em auto; padding: 1.5em; text-align: center;">
  <h2 style="font-size: 2em; margin-bottom: 0.5em; background: linear-gradient(135deg, #ff7043, #facc15); -webkit-background-clip: text; background-clip: text; color: transparent;"><i class="fa-solid fa-right-to-bracket"></i> Welcome Back</h2>

  <form method="post" action="login.php" style="text-align: left;">
    <label>Email:
      <input type="email" name="email" placeholder="john@example.com" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
    </label>

    <label style="margin-top: 0.5em;">Password:
      <input type="password" name="password" placeholder="••••••••" required>
    </label>
    
    <?php if ($error): ?>
      <p id="error-msg" style="color: #ef4444; font-size: 0.9em; margin-top: 0.5em; display: flex; align-items: center; gap: 0.5em;"><i class="fa-solid fa-circle-exclamation"></i> <?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <button type="submit" style="margin-top: 1.5em; width: 100%;"><i class="fa-solid fa-arrow-right-to-bracket"></i> Login</button>
  </form>

  <?php if ($success): ?>
    <p style="color: #10b981; font-weight: 600; margin-top: 1.5em; display: flex; align-items: center; justify-content: center; gap: 0.5em;"><i class="fa-solid fa-circle-check"></i> <?= htmlspecialchars($success) ?></p>
  <?php endif; ?>
  
  <p style="margin-top: 2em; font-size: 0.9em; color: var(--text-muted);">Don't have an account? <a href="register.php" style="color: var(--primary); text-decoration: none; font-weight: bold;">Register here</a></p>
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
