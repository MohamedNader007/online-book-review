<?php
require_once 'config.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: signin.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $book_id = (int)$_POST['book_id'];
    $rating = (int)$_POST['rating'];
    $review_text = $_POST['review_text'] ?? '';
    if ($book_id && $rating && $review_text) {
        $stmt = $pdo->prepare("INSERT INTO reviews (user_id, book_id, rating, review_text) VALUES (?, ?, ?, ?)");
        $stmt->execute([$_SESSION['user_id'], $book_id, $rating, $review_text]);
    }
    header('Location: book.php?id=' . $book_id);
    exit;
}
