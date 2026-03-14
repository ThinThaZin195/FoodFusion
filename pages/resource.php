<?php
include '../includes/header.php';

// Example resources - in real use, store these in DB or config
$culinary_resources = [
    ['name' => 'Recipe Card: Classic Pad Thai', 'file' => '../assets/resources/pad_thai.pdf'],
    ['name' => 'Tutorial Video: Basic Knife Skills', 'file' => '../assets/resources/knife_skills.mp4'],
    ['name' => 'Cooking Tips: Perfect Rice', 'file' => '../assets/resources/perfect_rice.pdf'],
];

$educational_resources = [
    ['name' => 'Renewable Energy Infographic', 'file' => '../assets/resources/renewable_energy_infographic.pdf'],
    ['name' => 'Sustainability Video', 'file' => '../assets/resources/sustainability.mp4'],
];
?>

<section style="max-width: 1200px; padding: 3em 2em; display: flex; flex-wrap: wrap; gap: 2em;">
    <div style="flex: 1; min-width: 300px;">
        <h1 style="margin-bottom: 1em; font-size: 2em;"><i class="fa-solid fa-book-bookmark"></i> Culinary Resources</h1>
        <ul style="margin-bottom: 3em;">
            <?php foreach ($culinary_resources as $res): ?>
                <li style="justify-content: space-between; flex-wrap: wrap; gap: 1em;">
                    <span><i class="fa-solid fa-file-pdf" style="color: var(--primary); margin-right: 10px;"></i> <?= htmlspecialchars($res['name']) ?></span> 
                    <a href="<?= htmlspecialchars($res['file']) ?>" download style="color: var(--secondary); text-decoration: none; font-weight: bold;"><i class="fa-solid fa-download"></i> Download</a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

    <div style="flex: 1; min-width: 300px;">
        <h1 style="margin-bottom: 1em; font-size: 2em;"><i class="fa-solid fa-graduation-cap"></i> Educational Resources</h1>
        <ul>
            <?php foreach ($educational_resources as $res): ?>
                <li style="justify-content: space-between; flex-wrap: wrap; gap: 1em;">
                    <span><i class="fa-solid fa-video" style="color: var(--primary); margin-right: 10px;"></i> <?= htmlspecialchars($res['name']) ?></span> 
                    <a href="<?= htmlspecialchars($res['file']) ?>" download style="color: var(--secondary); text-decoration: none; font-weight: bold;"><i class="fa-solid fa-download"></i> Download</a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>

<?php include '../includes/footer.php'; ?>
