<?php include 'header.php'; 
$category = $_GET['category'] ?? '';
$sort = $_GET['sort'] ?? '';
$user_id = $_SESSION['user_id'] ?? 0;

// Base query
$query = "SELECT b.id, b.title, b.author, b.cover_image, b.category,
(SELECT AVG(rating) FROM reviews WHERE book_id=b.id) as avg_rating
FROM books b
LEFT JOIN starred_books sb ON (b.id=sb.book_id AND sb.user_id=?)";
$params = [$user_id];

if ($category) {
  $query .= " WHERE b.category = ?";
  $params[] = $category;
}

if ($sort === 'alphabetical') {
  $query .= " ORDER BY sb.id DESC, b.title ASC";
} elseif ($sort === 'most_rated') {
  $query .= " ORDER BY sb.id DESC, avg_rating DESC";
} elseif ($sort === 'least_rated') {
  $query .= " ORDER BY sb.id DESC, avg_rating ASC";
} else {
  $query .= " ORDER BY sb.id DESC, b.title ASC";
}

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Categories for dropdown
$catStmt = $pdo->query("SELECT DISTINCT category FROM books ORDER BY category");
$categories = $catStmt->fetchAll(PDO::FETCH_COLUMN);
?>
<section class="content-section" data-animate="fade-in-up">
  <div class="container">
    <h2>Books</h2>
    <form method="get" class="category-filter">
      <label for="category-select">Filter by Category:</label>
      <select name="category" id="category-select" onchange="this.form.submit()">
        <option value="">All</option>
        <?php foreach($categories as $cat): ?>
        <option value="<?php echo htmlspecialchars($cat); ?>" <?php if($cat === $category) echo 'selected'; ?>><?php echo htmlspecialchars($cat); ?></option>
        <?php endforeach; ?>
      </select>
      <label for="sort-select">Sort by:</label>
      <select name="sort" id="sort-select" onchange="this.form.submit()">
        <option value="">Default</option>
        <option value="alphabetical" <?php if($sort==='alphabetical') echo 'selected'; ?>>Alphabetical</option>
        <option value="most_rated" <?php if($sort==='most_rated') echo 'selected'; ?>>Most Rated</option>
        <option value="least_rated" <?php if($sort==='least_rated') echo 'selected'; ?>>Least Rated</option>
      </select>
    </form>

    <div class="book-grid">
      <?php foreach($books as $book): ?>
      <div class="book-card" data-animate="fade-in">
        <img src="<?php echo htmlspecialchars($book['cover_image']); ?>" alt="Cover" class="cover-thumb lazy-load">
        <h3><?php echo htmlspecialchars($book['title']); ?></h3>
        <p><em><?php echo htmlspecialchars($book['author']); ?></em></p>
        <p class="category-tag"><?php echo htmlspecialchars($book['category']); ?></p>
        <?php if (isset($_SESSION['user_id'])):
          $checkStar = $pdo->prepare("SELECT id FROM starred_books WHERE user_id=? AND book_id=?");
          $checkStar->execute([$_SESSION['user_id'], $book['id']]);
          $starred = $checkStar->rowCount() > 0; ?>
          <form action="<?php echo $starred ? 'unstar_book.php' : 'star_book.php'; ?>" method="post">
            <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
            <button type="submit" class="star-button"><?php echo $starred ? 'Unstar' : 'Star'; ?></button>
          </form>
        <?php endif; ?>
        <a href="book.php?id=<?php echo $book['id']; ?>" class="btn">View Details</a>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php include 'footer.php'; ?>
