<?php include 'includes/header.php'; ?>

<main class="homepage">

  <!-- Hero Section -->
  <section class="hero">
    <h1>Welcome to FoodFusion</h1>
    <p>Inspiring home cooking and bringing food lovers together from around the world.</p>
  </section>

  <!-- Featured Recipes -->
  <section class="featured-recipes">
    <h2>Featured Recipes</h2>
    <div class="recipe-feed">
      <article>
        <img src="assets/images/pad_thai.jpg" alt="Pad Thai">
        <h3>Classic Pad Thai</h3>
        <p>A balance of sweet, sour, and spice from Thailand.</p>
      </article>
      <article>
        <img src="assets/images/carbonara.jpg" alt="Carbonara">
        <h3>Spaghetti Carbonara</h3>
        <p>Rich and creamy with pancetta and parmesan.</p>
      </article>
      <article>
        <img src="assets/images/samosa.jpg" alt="Samosa">
        <h3>Indian Samosas</h3>
        <p>Crispy pastry stuffed with spicy potatoes and peas.</p>
      </article>
    </div>
  </section>

  <!-- Upcoming Events Carousel -->
  <section class="carousel">
    <h2>Upcoming Cooking Events</h2>
    <div class="carousel-track">
      <div class="carousel-item">🍲 Thai Cooking Class - July 15</div>
      <div class="carousel-item">🍝 Italian Pasta Workshop - July 22</div>
      <div class="carousel-item">🥟 Dumpling Masterclass - July 30</div>
    </div>
  </section>

  <!-- Join Us Button + Modal -->
  <?php include 'includes/join_modal.php'; ?>

</main>

<!-- Social Media & Cookie Consent -->
<?php include 'includes/footer.php'; ?>
