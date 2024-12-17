<?php include 'header.php'; 
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit;
}
?>
<section class="content-section">
  <div class="container">
    <h2>Admin Dashboard</h2>
    <p>Welcome, Administrator. From here you can manage the content of the site:</p>
    <ul>
      <li><a href="books.php">Manage Books</a> (Delete unwanted reviews)</li>
      <li>Visit any book page to delete unwanted reviews</li>
    </ul>
  </div>
</section>
<?php include 'footer.php'; ?>
