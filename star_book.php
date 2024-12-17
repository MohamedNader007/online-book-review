<?php
require_once 'config.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: signin.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $book_id = (int)$_POST['book_id'];
    $stmt = $pdo->prepare("INSERT IGNORE INTO starred_books (user_id, book_id) VALUES (?, ?)");
    $stmt->execute([$_SESSION['user_id'], $book_id]);
}
header('Location: books.php');
exit;
