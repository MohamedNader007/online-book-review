<?php include 'header.php'; 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    if ($username && $password) {
        $stmt = $pdo->prepare("SELECT id, password_hash, role FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            header('Location: index.php');
            exit;
        } else {
            $error = "Invalid credentials.";
        }
    } else {
        $error = "Please fill in all fields.";
    }
}
?>
<section class="content-section">
    <div class="container">
        <h2>Sign In</h2>
        <?php if (!empty($error)): ?><p class="error"><?php echo $error; ?></p><?php endif; ?>
        <form action="" method="post">
            <label>Username:</label>
            <input type="text" name="username" required>

            <label>Password:</label>
            <input type="password" name="password" required>

            <button type="submit">Sign In</button>
        </form>
    </div>
</section>
<?php include 'footer.php'; ?>
