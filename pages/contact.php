
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
<link rel="stylesheet" href="/assets/css/style.css">
<section style="padding: 2em; max-width: 600px; margin: auto;">
    <h1>Contact Us</h1>

    <?php if ($message): ?>
        <p style="color: green;"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <?php if ($errors): ?>
        <ul style="color: red;">
            <?php foreach ($errors as $error): ?>
                <li><?= htmlspecialchars($error) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="post">
        <label>Name:<br>
            <input type="text" name="name" value="<?= htmlspecialchars($_POST['name'] ?? '') ?>" required>
        </label><br><br>

        <label>Email:<br>
            <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
        </label><br><br>

        <label>Subject:<br>
            <input type="text" name="subject" value="<?= htmlspecialchars($_POST['subject'] ?? '') ?>" required>
        </label><br><br>

        <label>Message:<br>
            <textarea name="message" rows="5" required><?= htmlspecialchars($_POST['message'] ?? '') ?></textarea>
        </label><br><br>

        <button type="submit">Send Message</button>
    </form>
</section>

<?php include '../includes/footer.php'; ?>
