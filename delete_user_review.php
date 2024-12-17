<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id'])) {
    // User not logged in
    header('Location: signin.php');
    exit;
}

if (!isset($_GET['id']) || !isset($_GET['book_id'])) {
    // Missing parameters
    header('Location: index.php');
    exit;
}

$review_id = (int)$_GET['id'];
$book_id = (int)$_GET['book_id'];

// Check ownership of the review
$stmt = $pdo->prepare("SELECT id FROM reviews WHERE id=? AND user_id=?");
$stmt->execute([$review_id, $_SESSION['user_id']]);
$review = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$review) {
    // Either the review does not exist or doesn't belong to this user
    header('Location: book.php?id=' . $book_id);
    exit;
}

// If we reach here, the review belongs to the user
$delete = $pdo->prepare("DELETE FROM reviews WHERE id=? AND user_id=?");
$delete->execute([$review_id, $_SESSION['user_id']]);

header('Location: book.php?id=' . $book_id);
exit;
