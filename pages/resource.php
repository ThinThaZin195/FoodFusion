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
<link rel="stylesheet" href="/assets/css/style.css">
<section style="padding: 2em; max-width: 700px; margin: auto;">
    <h1>Culinary Resources</h1>
    <ul>
        <?php foreach ($culinary_resources as $res): ?>
            <li>
                <?= htmlspecialchars($res['name']) ?> - 
                <a href="<?= htmlspecialchars($res['file']) ?>" download>Download</a>
            </li>
        <?php endforeach; ?>
    </ul>

    <h1>Educational Resources</h1>
    <ul>
        <?php foreach ($educational_resources as $res): ?>
            <li>
                <?= htmlspecialchars($res['name']) ?> - 
                <a href="<?= htmlspecialchars($res['file']) ?>" download>Download</a>
            </li>
        <?php endforeach; ?>
    </ul>
</section>

<?php include '../includes/footer.php'; ?>
