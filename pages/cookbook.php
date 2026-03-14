<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once '../includes/config.php';
include '../includes/header.php';
?>

<section style="max-width: 800px; padding: 3em 2em;">
    <h1><i class="fa-solid fa-users"></i> Community Cookbook</h1>
    <p>Welcome, <strong style="color: var(--primary);"><?= htmlspecialchars($_SESSION['first_name'] ?? 'User') ?></strong>! Share your favourite recipes below.</p>

    <!-- Submission Form Container -->
    <div style="background: rgba(255, 255, 255, 0.02); border: 1px solid var(--glass-border); padding: 2em; border-radius: var(--radius); margin-top: 2em;">
        <h2 style="font-size: 1.8em; margin-bottom: 1em; text-align: center;"><i class="fa-solid fa-pen-nib"></i> Submit a Recipe</h2>
        
        <form method="post" action="cookbook.php" style="gap: 1.2em;">
            <label>Recipe Title:
                <input type="text" name="recipe_title" placeholder="e.g., Spicy Thai Basil Chicken" required>
            </label>
            
            <div style="display: flex; gap: 1.5em; flex-wrap: wrap;">
                <label style="flex: 1; min-width: 150px;">Cuisine Type:
                    <select name="cuisine_type">
                        <option value="Asian">Asian</option>
                        <option value="European">European</option>
                        <option value="American">American</option>
                        <option value="Other">Other</option>
                    </select>
                </label>
                
                <label style="flex: 1; min-width: 150px;">Difficulty:
                    <select name="difficulty">
                        <option value="Easy">Easy</option>
                        <option value="Medium">Medium</option>
                        <option value="Hard">Hard</option>
                    </select>
                </label>
            </div>
            
            <label>Ingredients (one per line):
                <textarea name="ingredients" rows="4" placeholder="- 1 lb chicken&#10;- 2 cups basil&#10;- 1 chili" required></textarea>
            </label>

            <label>Instructions:
                <textarea name="instructions" rows="4" placeholder="1. Heat the pan...&#10;2. Add chicken..." required></textarea>
            </label>

            <button type="submit" style="margin-top: 1em; align-self: center;"><i class="fa-solid fa-cloud-arrow-up"></i> Share to Community</button>
        </form>
    </div>

</section>

<?php include '../includes/footer.php'; ?>
