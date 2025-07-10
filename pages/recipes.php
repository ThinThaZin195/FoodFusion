<?php
require_once '../includes/config.php';
include '../includes/header.php';

// Initialize filter variables
$cuisine = $_GET['cuisine'] ?? '';
$diet = $_GET['diet'] ?? '';
$difficulty = $_GET['difficulty'] ?? '';

// Build dynamic query based on filters
$query = "SELECT * FROM recipes WHERE 1=1";
$params = [];
$types = "";

if ($cuisine) {
    $query .= " AND cuisine_type = ?";
    $params[] = $cuisine;
    $types .= "s";
}
if ($diet) {
    $query .= " AND dietary_preference = ?";
    $params[] = $diet;
    $types .= "s";
}
if ($difficulty) {
    $query .= " AND difficulty = ?";
    $params[] = $difficulty;
    $types .= "s";
}

$stmt = $conn->prepare($query);
if ($params) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
?>
<link rel="stylesheet" href="/assets/css/style.css">
<section style="padding: 2em;">
    <h1>Recipe Collection</h1>

    <form method="get" style="margin-bottom: 1em;">
        <label>Cuisine Type:
            <select name="cuisine">
                <option value="">-- All --</option>
                <option value="Asian" <?= $cuisine == "Asian" ? "selected" : "" ?>>Asian</option>
                <option value="European" <?= $cuisine == "European" ? "selected" : "" ?>>European</option>
                <option value="American" <?= $cuisine == "American" ? "selected" : "" ?>>American</option>
            </select>
        </label>

        <label>Dietary Preference:
            <select name="diet">
                <option value="">-- All --</option>
                <option value="Vegetarian" <?= $diet == "Vegetarian" ? "selected" : "" ?>>Vegetarian</option>
                <option value="Vegan" <?= $diet == "Vegan" ? "selected" : "" ?>>Vegan</option>
                <option value="Gluten-Free" <?= $diet == "Gluten-Free" ? "selected" : "" ?>>Gluten-Free</option>
            </select>
        </label>

        <label>Difficulty:
            <select name="difficulty">
                <option value="">-- All --</option>
                <option value="Easy" <?= $difficulty == "Easy" ? "selected" : "" ?>>Easy</option>
                <option value="Medium" <?= $difficulty == "Medium" ? "selected" : "" ?>>Medium</option>
                <option value="Hard" <?= $difficulty == "Hard" ? "selected" : "" ?>>Hard</option>
            </select>
        </label>

        <button type="submit">Filter</button>
    </form>

    <?php if ($result->num_rows > 0): ?>
        <ul>
        <?php while ($row = $result->fetch_assoc()): ?>
            <li>
                <strong><?= htmlspecialchars($row['title']) ?></strong>  
                (<?= htmlspecialchars($row['cuisine_type']) ?>,
                <?= htmlspecialchars($row['dietary_preference']) ?>,
                <?= htmlspecialchars($row['difficulty']) ?>)
            </li>
        <?php endwhile; ?>
        </ul>
    <?php else: ?>
        <p>No recipes found.</p>
    <?php endif; ?>
</section>

<?php include '../includes/footer.php'; ?>
