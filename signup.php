<?php include 'header.php'; 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'config.php';
    $username = $_POST['username'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if ($username && $email && $password) {
        // Check if username or email already exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->execute([$username, $email]);
        if ($stmt->rowCount() > 0) {
            $error = "Username or email already taken.";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password_hash) VALUES (?, ?, ?)");
            $stmt->execute([$username, $email, $hash]);
            $success = "Registration successful! You can now <a href='signin.php'>Sign In</a>.";
        }
    } else {
        $error = "Please fill in all fields.";
    }
}
?>
<section class="content-section">
    <div class="container">
        <h2>Sign Up</h2>
        <?php if (!empty($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <?php if (!empty($success)): ?>
            <p class="success"><?php echo $success; ?></p>
        <?php else: ?>
        <form action="" method="post">
            <label>Username:</label>
            <input type="text" name="username" required>

            <label>Email:</label>
            <input type="email" name="email" required>

            <label>Password:</label>
            <input type="password" name="password" required>

            <button type="submit">Sign Up</button>
        </form>
        <?php endif; ?>
    </div>
</section>
<?php include 'footer.php'; ?>
