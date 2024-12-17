<?php include 'header.php'; 
if (!isset($_GET['id'])) {
  echo "<p class='error'>No book selected.</p>";
  include 'footer.php';
  exit;
}
$book_id = (int)$_GET['id'];

// Fetch book details
$stmt = $pdo->prepare("SELECT * FROM books WHERE id = ?");
$stmt->execute([$book_id]);
$book = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$book) {
  echo "<p class='error'>Book not found.</p>";
  include 'footer.php';
  exit;
}

// Fetch reviews
$revStmt = $pdo->prepare("SELECT r.id, r.rating, r.review_text, r.created_at, u.username, r.user_id
FROM reviews r 
JOIN users u ON r.user_id = u.id
WHERE r.book_id = ?
ORDER BY r.created_at DESC");
$revStmt->execute([$book_id]);
$reviews = $revStmt->fetchAll(PDO::FETCH_ASSOC);
?>
<section class="content-section">
  <div class="container">
    <h2><?php echo htmlspecialchars($book['title']); ?></h2>
    <img src="<?php echo htmlspecialchars($book['cover_image']); ?>" alt="Cover" class="cover-large">
    <p><strong>Author:</strong> <?php echo htmlspecialchars($book['author']); ?></p>
    <p><?php echo nl2br(htmlspecialchars($book['description'])); ?></p>
    <?php if (!empty($book['amazon_link'])): ?>
      <p><a href="<?php echo htmlspecialchars($book['amazon_link']); ?>" class="btn" target="_blank">Buy Now</a></p>
    <?php endif; ?>

    <h3>Reviews</h3>
    <?php if (empty($reviews)): ?>
      <p>No reviews yet. Be the first to review!</p>
    <?php else: ?>
      <ul class="review-list">
        <?php foreach ($reviews as $review): ?>
        <li>
          <strong><?php echo htmlspecialchars($review['username']); ?></strong>
          <span class="rating">Rating: <?php echo $review['rating']; ?>/5</span>
          <p><?php echo nl2br(htmlspecialchars($review['review_text'])); ?></p>
          <small><?php echo $review['created_at']; ?></small>
          <?php if (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $review['user_id']): ?>
            <a href="edit_review.php?id=<?php echo $review['id']; ?>&book_id=<?php echo $book_id; ?>" class="delete-link">Edit</a>
            <a href="delete_user_review.php?id=<?php echo $review['id']; ?>&book_id=<?php echo $book_id; ?>" class="delete-link">Delete</a>
          <?php endif; ?>
          <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin' && $_SESSION['user_id'] != $review['user_id']): ?>
            <a href="delete_review.php?id=<?php echo $review['id']; ?>&book_id=<?php echo $book_id; ?>" class="delete-link">Delete Review (Admin)</a>
          <?php endif; ?>
        </li>
        <?php endforeach; ?>
      </ul>
    <?php endif; ?>

    <?php if (isset($_SESSION['user_id'])): ?>
      <h3>Add a Review</h3>
      <form action="add_review.php" method="post">
        <input type="hidden" name="book_id" value="<?php echo $book_id; ?>">
        <label>Rating (1-5):</label>
        <input type="number" name="rating" min="1" max="5" required>
        <label>Your Review:</label>
        <textarea name="review_text" required></textarea>
        <button type="submit">Submit Review</button>
      </form>
    <?php else: ?>
      <p><a href="signin.php">Sign in</a> to leave a review.</p>
    <?php endif; ?>
  </div>
</section>
<?php include 'footer.php'; ?>
