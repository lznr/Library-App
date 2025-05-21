<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $author_id = $_POST['author_id'];
    $stmt = $pdo->prepare("
        UPDATE authors 
        SET archived = 1 
        WHERE author_id = ?
    ");
    $stmt->execute([$author_id]);

    header('Location: index.php');
    exit();
}
?>
