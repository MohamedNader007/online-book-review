<?php
require_once 'config.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: signin.php');
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $book_id = (int)$_POST['book_id'];
    $stmt = $pdo->prepare("DELETE FROM starred_books WHERE user_id=? AND book_id=?");
    $stmt->execute([$_SESSION['user_id'], $book_id]);
}
header('Location: books.php');
exit;
