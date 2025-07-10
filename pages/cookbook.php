<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once '../includes/config.php';
include '../includes/header.php';
?>
<link rel="stylesheet" href="/assets/css/style.css">

<section style="padding: 2em; max-width: 700px; margin: auto;">
    <h1>Community Cookbook</h1>
    <p>Welcome, <?= htmlspecialchars($_SESSION['first_name'] ?? 'User') ?>! Share your favourite recipes below.</p>

    <!-- Add recipe submission form and display community recipes here -->

</section>

<?php include '../includes/footer.php'; ?>
