<?php include 'header.php'; 
if (!isset($_SESSION['user_id'])) {
  header('Location: signin.php');
  exit;
}
$stmt = $pdo->prepare("SELECT username, email FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<section class="content-section">
  <div class="container">
    <h2>Your Profile</h2>
    <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
  </div>
</section>
<?php include 'footer.php'; ?>
