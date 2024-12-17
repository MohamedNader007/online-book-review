<?php
include 'header.php';
if (!isset($_SESSION['user_id'])) {
    header('Location: signin.php');
    exit;
}
require_once 'config.php';

if (!isset($_GET['id']) || !isset($_GET['book_id'])) {
    echo "<p class='error'>Missing parameters.</p>";
    include 'footer.php';
    exit;
}

$review_id = (int)$_GET['id'];
$book_id = (int)$_GET['book_id'];

// Check if this review belongs to the logged in user
$stmt = $pdo->prepare("SELECT * FROM reviews WHERE id=? AND user_id=?");
$stmt->execute([$review_id, $_SESSION['user_id']]);
$review = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$review) {
    echo "<p class='error'>Review not found or not yours.</p>";
    include 'footer.php';
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rating = (int)$_POST['rating'];
    $review_text = $_POST['review_text'] ?? '';
    if ($rating && $review_text) {
        $update = $pdo->prepare("UPDATE reviews SET rating=?, review_text=? WHERE id=? AND user_id=?");
        $update->execute([$rating, $review_text, $review_id, $_SESSION['user_id']]);
        header('Location: book.php?id=' . $book_id);
        exit;
    } else {
        $error = "Please fill in all fields.";
    }
}
?>
<section class="content-section">
    <div class="container">
        <h2>Edit Your Review</h2>
        <?php if(!empty($error)): ?><p class="error"><?php echo $error; ?></p><?php endif; ?>
        <form method="post">
            <label>Rating (1-5):</label>
            <input type="number" name="rating" min="1" max="5" value="<?php echo $review['rating']; ?>" required>
            <label>Your Review:</label>
            <textarea name="review_text" required><?php echo htmlspecialchars($review['review_text']); ?></textarea>
            <button type="submit">Save Changes</button>
        </form>
    </div>
</section>
<?php include 'footer.php'; ?>
