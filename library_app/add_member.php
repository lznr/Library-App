<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];

    $stmt = $pdo->prepare("INSERT INTO members (first_name, last_name, join_date) VALUES (?, ?, CURDATE())");
    $stmt->execute([$first_name, $last_name]);

    header("Location: index.php");
    exit();
}
?>
