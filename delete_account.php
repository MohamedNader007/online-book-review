<?php include 'header.php'; 
if (!isset($_SESSION['user_id'])) {
    header('Location: signin.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = $_POST['password'] ?? '';
    if ($password) {
        $stmt = $pdo->prepare("SELECT password_hash FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password_hash'])) {
            // Optional reason
            $reason = $_POST['reason'] ?? '';
            // Delete user
            $del = $pdo->prepare("DELETE FROM users WHERE id = ?");
            $del->execute([$_SESSION['user_id']]);
            session_destroy();
            ?>
            <section class="content-section">
              <div class="container">
                <h2>Account Deleted</h2>
                <p>We are sad to see you go.</p>
                <?php if ($reason): ?>
                  <p>Reason provided: <?php echo htmlspecialchars($reason); ?></p>
                <?php endif; ?>
                <p>Goodbye!</p>
              </div>
            </section>
            <?php include 'footer.php'; 
            exit;
        } else {
            $error = "Wrong password.";
        }
    } else {
        $error = "Please enter your password.";
    }
}
?>
<section class="content-section">
  <div class="container">
    <h2>Delete Your Account</h2>
    <?php if(!empty($error)): ?><p class="error"><?php echo $error; ?></p><?php endif; ?>
    <p>We are sad to see you leaving us. Please verify your password to delete your account.</p>
    <form method="post">
      <label>Password:</label>
      <input type="password" name="password" required>
      <label>Why are you leaving? (optional)</label>
      <textarea name="reason"></textarea>
      <button type="submit">Delete Account</button>
    </form>
  </div>
</section>
<?php include 'footer.php'; ?>
