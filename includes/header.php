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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/assets/css/style.css">
    <script src="/assets/js/cookie.js" defer></script>
</head>

<body>
    <nav>
    <a href="/index.php"><i class="fa-solid fa-house"></i> Home</a>
    <a href="/pages/about.php"><i class="fa-solid fa-circle-info"></i> About</a>

    <div class="desktop-only-links">
        <a href="/pages/recipes.php"><i class="fa-solid fa-utensils"></i> Recipes</a>
        <a href="/pages/cookbook.php"><i class="fa-solid fa-users"></i> Community</a>
        <a href="/pages/contact.php"><i class="fa-solid fa-envelope"></i> Contact</a>
        <a href="/pages/resource.php"><i class="fa-solid fa-book"></i> Resources</a>
        <?php if (!isset($_SESSION['user_id'])): ?>
            <a href="/pages/register.php"><i class="fa-solid fa-user-plus"></i> Register</a>
        <?php endif; ?>
    </div>

    <div class="mobile-dropdown-container">
        <button class="dropbtn" onclick="document.getElementById('mobileDrop').classList.toggle('show')">
            <i class="fa-solid fa-layer-group"></i> <span>Others</span>
        </button>
        <div class="dropdown-content" id="mobileDrop">
            <a href="/pages/recipes.php"><i class="fa-solid fa-utensils"></i> Recipes</a>
            <a href="/pages/cookbook.php"><i class="fa-solid fa-users"></i> Community</a>
            <a href="/pages/contact.php"><i class="fa-solid fa-envelope"></i> Contact</a>
            <a href="/pages/resource.php"><i class="fa-solid fa-book"></i> Resources</a>
            <?php if (!isset($_SESSION['user_id'])): ?>
                <a href="/pages/register.php"><i class="fa-solid fa-user-plus"></i> Register</a>
            <?php endif; ?>
        </div>
    </div>

    <?php if (isset($_SESSION['user_id'])): ?>
        <span style="color:#fff; padding: 0 10px; display:flex; align-items:center; gap:0.5em;"><i class="fa-solid fa-circle-user"></i> <?= htmlspecialchars($_SESSION['first_name']) ?></span>
        <a href="/pages/logout.php"><i class="fa-solid fa-right-from-bracket"></i> Logout</a>
    <?php else: ?>
        <a href="/pages/login.php"><i class="fa-solid fa-right-to-bracket"></i> Login</a>
    <?php endif; ?>
</nav>
