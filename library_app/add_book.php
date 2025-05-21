<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $author_id = $_POST['author_id'];
    $category_id = $_POST['category_id'];
    $year_published = $_POST['year_published'];

    $stmt = $pdo->prepare("
        INSERT INTO books (title, author_id, category_id, year_published) 
        VALUES (?, ?, ?, ?)
    ");
    $stmt->execute([$title, $author_id, $category_id, $year_published]);

    header('Location: index.php');
    exit();
}
?>
