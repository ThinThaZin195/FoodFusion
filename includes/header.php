<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>FoodFusion</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/cookie.js" defer></script>
</head>

<body>
    <nav>
    <a href="/index.php">Home</a>
    <a href="/pages/about.php">About Us</a>
    <a href="/pages/recipes.php">Recipes</a>
    <a href="/pages/cookbook.php">Community</a>
    <a href="/pages/contact.php">Contact</a>
    <a href="/pages/resource.php">Resources</a>

    <?php if (isset($_SESSION['user_id'])): ?>
        <span style="color:#fff; padding: 0 10px;">Welcome, <?= htmlspecialchars($_SESSION['first_name']) ?></span>
        <a href="/pages/logout.php">Logout</a>
    <?php else: ?>
        <a href="/pages/login.php">Login</a>
        <a href="/pages/register.php">Register</a>
    <?php endif; ?>
</nav>
