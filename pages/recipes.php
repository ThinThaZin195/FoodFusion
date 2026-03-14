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

<section style="max-width: 1000px; padding: 3em 2em;">
    <h1><i class="fa-solid fa-utensils"></i> Recipe Collection</h1>
    <p>Discover our wide variety of premium recipes tailored to your taste.</p>

    <!-- Filter Bar -->
    <div style="background: rgba(255, 255, 255, 0.03); border: 1px solid var(--glass-border); padding: 1.5em; border-radius: var(--radius); margin-bottom: 2em;">
        <form method="get" style="flex-direction: row; flex-wrap: wrap; justify-content: center; align-items: flex-end; gap: 1.5em;">
            <label style="flex: 1; min-width: 150px;">Cuisine Type:
                <select name="cuisine">
                    <option value="">-- All --</option>
                    <option value="Asian" <?= $cuisine == "Asian" ? "selected" : "" ?>>Asian</option>
                    <option value="European" <?= $cuisine == "European" ? "selected" : "" ?>>European</option>
                    <option value="American" <?= $cuisine == "American" ? "selected" : "" ?>>American</option>
                </select>
            </label>

            <label style="flex: 1; min-width: 150px;">Dietary Preference:
                <select name="diet">
                    <option value="">-- All --</option>
                    <option value="Vegetarian" <?= $diet == "Vegetarian" ? "selected" : "" ?>>Vegetarian</option>
                    <option value="Vegan" <?= $diet == "Vegan" ? "selected" : "" ?>>Vegan</option>
                    <option value="Gluten-Free" <?= $diet == "Gluten-Free" ? "selected" : "" ?>>Gluten-Free</option>
                </select>
            </label>

            <label style="flex: 1; min-width: 150px;">Difficulty:
                <select name="difficulty">
                    <option value="">-- All --</option>
                    <option value="Easy" <?= $difficulty == "Easy" ? "selected" : "" ?>>Easy</option>
                    <option value="Medium" <?= $difficulty == "Medium" ? "selected" : "" ?>>Medium</option>
                    <option value="Hard" <?= $difficulty == "Hard" ? "selected" : "" ?>>Hard</option>
                </select>
            </label>

            <button type="submit" style="padding: 1em 2em; flex-shrink: 0;"><i class="fa-solid fa-filter"></i> Filter</button>
        </form>
    </div>

    <!-- Results Grid -->
    <?php if ($result->num_rows > 0): ?>
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5em;">
        <?php while ($row = $result->fetch_assoc()): ?>
            <article style="background: var(--card-bg); border: 1px solid var(--glass-border); border-radius: var(--radius); padding: 1.5em; transition: var(--transition); display: flex; flex-direction: column; gap: 0.8em; box-shadow: var(--glass-shadow);"
                     onmouseover="this.style.transform='translateY(-5px)'; this.style.borderColor='var(--primary)'" 
                     onmouseout="this.style.transform='translateY(0)'; this.style.borderColor='var(--glass-border)'">
                
                <h3 style="color: var(--primary); margin: 0; font-size: 1.4em;"><i class="fa-solid fa-bell-concierge"></i> <?= htmlspecialchars($row['title']) ?></h3>
                
                <div style="display: flex; flex-wrap: wrap; gap: 0.5em; margin-top: 0.5em;">
                    <span style="background: rgba(255,255,255,0.1); padding: 0.3em 0.8em; border-radius: 20px; font-size: 0.85em;"><i class="fa-solid fa-earth-americas"></i> <?= htmlspecialchars($row['cuisine_type']) ?></span>
                    <span style="background: rgba(255,255,255,0.1); padding: 0.3em 0.8em; border-radius: 20px; font-size: 0.85em;"><i class="fa-solid fa-seedling"></i> <?= htmlspecialchars($row['dietary_preference']) ?></span>
                </div>
                
                <div style="margin-top: auto; padding-top: 1em; border-top: 1px solid rgba(255,255,255,0.1); display: flex; justify-content: space-between; align-items: center; font-size: 0.9em; color: var(--text-muted);">
                    <span>Difficulty:</span>
                    <strong style="color: #fff;"><?= htmlspecialchars($row['difficulty']) ?></strong>
                </div>
            </article>
        <?php endwhile; ?>
        </div>
    <?php else: ?>
        <div style="text-align: center; padding: 3em; background: rgba(255,255,255,0.02); border-radius: var(--radius); border: 1px dashed var(--glass-border);">
            <i class="fa-solid fa-magnifying-glass" style="font-size: 3em; color: var(--text-muted); margin-bottom: 20px; display: block;"></i>
            <p style="font-size: 1.2em; color: var(--text-muted);">No recipes found matching your criteria. Try adjusting your filters!</p>
        </div>
    <?php endif; ?>
</section>

<?php include '../includes/footer.php'; ?>
