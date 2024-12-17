<?php include 'header.php'; ?>
<script src = "script.js"></script>
<section class="hero">
  <div class="slider">
    <div class="slide active" style="background-image: url('imgs/nader.jpg');">
      <div class="slide-content">
        <h2>العلم في الراس مش في الكراس</h2>
        <p></p>
      </div>
    </div>
    <div class="slide" style="background-image: url('imgs/lolo.jpg');">
      <div class="slide-content">
        <h2>اطلبوا العلم ولو في برلين</h2>
        <p></p>
      </div>
    </div>
    <div class="slide" style="background-image: url('imgs/maro.jpg');">
      <div class="slide-content">
        <h2>اللي بيطلب العلا بيسهر الليالي</h2>
        <p></p>
      </div>
    </div>
  </div>
  <div class="slider-controls">
    <span class="prev">&#10094;</span>
    <span class="next">&#10095;</span>
  </div>
</section>

<section class="content-section" data-animate="fade-in-up">
  <div class="container">
    <h2>Featured Categories</h2>
    <p>From timeless classics to cutting-edge Sci-Fi, find something you love:</p>
    <div class="category-grid">
      <div class="category-card" style="background-image:url('imgs/fiction.jpg');">
        <a href="books.php?category=Fiction">Fiction</a>
      </div>
      <div class="category-card" style="background-image:url('imgs/sci.jpg');">
        <a href="books.php?category=Sci-Fi">Sci-Fi</a>
      </div>
      <div class="category-card" style="background-image:url('imgs/mystery.jpg');">
        <a href="books.php?category=Mystery">Mystery</a>
      </div>
      <div class="category-card" style="background-image:url('imgs/non.jpg');">
        <a href="books.php?category=Non-Fiction">Non-Fiction</a>
      </div>
    </div>
  </div>
</section>
<?php include 'footer.php'; ?>

