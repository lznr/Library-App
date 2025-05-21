<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $member_id = $_POST['member_id'];
    $stmt = $pdo->prepare("
        UPDATE members 
        SET archived = 1 
        WHERE member_id = ?
    ");
    $stmt->execute([$member_id]);

    header('Location: index.php');
    exit();
}
?>
