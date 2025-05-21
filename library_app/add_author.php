<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];

    $stmt = $pdo->prepare("
        INSERT INTO authors (first_name, last_name) 
        VALUES (?, ?)
    ");
    $stmt->execute([$first_name, $last_name]);

    header('Location: index.php');
    exit();
}
?>
