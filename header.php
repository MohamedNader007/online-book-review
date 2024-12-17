<?php
session_start();
require_once 'config.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Online Book Reviews</title>
  <!-- Google Fonts & Font Awesome -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
  <script src="https://kit.fontawesome.com/YOUR_FA_CODE.js" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="style.css">
</head>
<body class="light-mode">
<script src = "script.js"></script>
<header>
  <div class="container">
    <h1><i class="fas fa-book"></i> Online Book Reviews</h1>
    <nav>
      <ul>
        <li><a href="index.php"><i class="fas fa-home"></i> Home</a></li>
        <li><a href="about.php"><i class="fas fa-info-circle"></i> About</a></li>
        <li><a href="tips.php"><i class="fas fa-lightbulb"></i> Tips</a></li>
        <li><a href="contact.php"><i class="fas fa-envelope"></i> Contact</a></li>
        <li><a href="books.php"><i class="fas fa-book"></i> Books</a></li>
        <?php if (isset($_SESSION['user_id'])): ?>
          <li><a href="profile.php"><i class="fas fa-user-circle"></i> Profile</a></li>
          <?php if ($_SESSION['role'] === 'admin'): ?>
            <li><a href="admin.php"><i class="fas fa-user-shield"></i> Admin</a></li>
          <?php endif; ?>
          <li><a href="delete_account.php"><i class="fas fa-user-slash"></i> Delete Account</a></li>
          <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
        <?php else: ?>
          <li><a href="signup.php"><i class="fas fa-user-plus"></i> Sign Up</a></li>
          <li><a href="signin.php"><i class="fas fa-sign-in-alt"></i> Sign In</a></li>
        <?php endif; ?>
      </ul>
    </nav>
    <!-- Search Form -->
    <form action="search.php" method="get" class="search-form">
      <input type="text" name="q" placeholder="Search by title or author..." required>
    </form>
    <div class="mode-toggle" onclick="toggleMode()">
      <i class="fas fa-adjust"></i> 
    </div>

  </div>
</header>
<main>

