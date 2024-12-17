<?php
session_start();
require_once 'config.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    // Not logged in or not admin
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

// Check if the review exists
$stmt = $pdo->prepare("SELECT id FROM reviews WHERE id=?");
$stmt->execute([$review_id]);
if ($stmt->rowCount() === 0) {
    // Review does not exist
    header('Location: book.php?id=' . $book_id);
    exit;
}

// Delete the review
$del = $pdo->prepare("DELETE FROM reviews WHERE id = ?");
$del->execute([$review_id]);

header('Location: book.php?id=' . $book_id);
exit;
