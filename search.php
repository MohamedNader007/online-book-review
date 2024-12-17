<?php include 'header.php'; 
$q = $_GET['q'] ?? '';
$results = [];
if ($q) {
    $stmt = $pdo->prepare("SELECT id, title, author, cover_image, category FROM books WHERE title LIKE ? OR author LIKE ?");
    $searchStr = "%$q%";
    $stmt->execute([$searchStr, $searchStr]);
    $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
<section class="content-section">
  <div class="container">
    <h2>Search Results</h2>
    <?php if ($q): ?>
      <p>Results for "<?php echo htmlspecialchars($q); ?>":</p>
    <?php endif; ?>
    <?php if (empty($results) && $q): ?>
      <p>No results found.</p>
    <?php elseif(empty($results) && !$q): ?>
      <p>Please enter a search term above.</p>
    <?php else: ?>
      <div class="book-grid">
        <?php foreach($results as $book): ?>
        <div class="book-card">
          <img src="<?php echo htmlspecialchars($book['cover_image']); ?>" alt="Cover" class="cover-thumb">
          <h3><?php echo htmlspecialchars($book['title']); ?></h3>
          <p><em><?php echo htmlspecialchars($book['author']); ?></em></p>
          <p class="category-tag"><?php echo htmlspecialchars($book['category']); ?></p>
          <a href="book.php?id=<?php echo $book['id']; ?>" class="btn">View Details</a>
        </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>
<?php include 'footer.php'; ?>
