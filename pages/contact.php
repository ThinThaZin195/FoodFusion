
<?php
require_once '../includes/config.php';
include '../includes/header.php';


$message = "";
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $messageContent = trim($_POST['message'] ?? '');

    // Simple validation
    if (!$name) {
        $errors[] = "Name is required.";
    }
    if (!$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required.";
    }
    if (!$subject) {
        $errors[] = "Subject is required.";
    }
    if (!$messageContent) {
        $errors[] = "Message cannot be empty.";
    }

    if (empty($errors)) {
        // Save message in DB (you can create a messages table if desired)
        // Or send email - for now just display success message

        $message = "Thank you for contacting us, $name! We will get back to you soon.";
    }
}
?>

<section style="max-width: 700px; padding: 3em 2em; margin: 4em auto; background: var(--card-bg); backdrop-filter: blur(12px); border: 1px solid var(--glass-border); border-radius: var(--radius); box-shadow: var(--glass-shadow);">
    <h1 style="text-align: center; font-size: 2.5em; margin-bottom: 0.2em; background: linear-gradient(135deg, #ff7043, #facc15); -webkit-background-clip: text; background-clip: text; color: transparent;"><i class="fa-solid fa-envelope-open-text"></i> Contact Us</h1>
    <p style="text-align: center; color: var(--text-muted); margin-bottom: 2em;">We'd love to hear from you. Drop us a message below!</p>

    <?php if ($message): ?>
        <p style="color: #10b981; font-weight: 600; text-align: center; margin-bottom: 1em;"><i class="fa-solid fa-circle-check"></i> <?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <?php if ($errors): ?>
        <ul style="color: #ef4444; background: rgba(239, 68, 68, 0.1); border-left: 4px solid #ef4444; padding: 1em;">
            <?php foreach ($errors as $error): ?>
                <li style="background: none; border: none; padding: 0.2em; margin: 0; display: list-item; list-style-type: disc; margin-left: 1.5em;"><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="post" style="margin-top: 1.5em; display: flex; flex-direction: column; gap: 1.5em;">
        <div style="display: flex; gap: 1.5em; flex-wrap: wrap;">
            <label style="flex: 1; min-width: 200px;">Name:
                <input type="text" name="name" placeholder="John Doe" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>
            </label>

            <label style="flex: 1; min-width: 200px;">Email:
                <input type="email" name="email" placeholder="john@example.com" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
            </label>
        </div>

        <label>Subject:
            <input type="text" name="subject" placeholder="How can we help?" value="<?= htmlspecialchars($_POST['subject'] ?? '') ?>" required>
        </label>

        <label>Message:
            <textarea name="message" rows="5" placeholder="Write your message here..." required><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
        </label>

        <button type="submit" style="margin-top: 1em; width: 100%;"><i class="fa-solid fa-paper-plane"></i> Send Message</button>
    </form>
</section>

<?php include '../includes/footer.php'; ?>
