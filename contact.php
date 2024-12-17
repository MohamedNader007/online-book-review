<?php include 'header.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'config.php';
    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';
    if ($name && $email && $message) {
        $stmt = $pdo->prepare("INSERT INTO messages (name, email, message) VALUES (?, ?, ?)");
        $stmt->execute([$name, $email, $message]);
        $success = "Your message has been sent. Thank you!";
    } else {
        $error = "Please fill in all fields.";
    }
}
?>
<section class="content-section">
    <div class="container">
        <h2>Contact Us</h2>
        <?php if(!empty($error)): ?><p class="error"><?php echo $error; ?></p><?php endif; ?>
        <?php if(!empty($success)): ?><p class="success"><?php echo $success; ?></p><?php endif; ?>
        <form action="" method="post" onsubmit="return validateContactForm();">
            <label>Name:</label>
            <input type="text" name="name" id="contactName" required>

            <label>Email:</label>
            <input type="email" name="email" id="contactEmail" required>

            <label>Message:</label>
            <textarea name="message" id="contactMessage" required></textarea>

            <button type="submit">Send Message</button>
        </form>
        <p>We value your feedback!</p>
    </div>
</section>
<?php include 'footer.php'; ?>
