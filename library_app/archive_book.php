<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $book_id = $_POST['book_id'];
    $stmt = $pdo->prepare("
        UPDATE books 
        SET archived = 1 
        WHERE book_id = ?
    ");
    $stmt->execute([$book_id]);

    header('Location: index.php');
    exit();
}
?>
