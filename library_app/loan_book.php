<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $book_id = $_POST['book_id'];
    $member_id = $_POST['member_id'];
    $loan_date = date('Y-m-d'); // Setze das aktuelle Datum als Ausleihdatum

    $stmt = $pdo->prepare("INSERT INTO loans (book_id, member_id, loan_date) VALUES (?, ?, ?)");
    $stmt->execute([$book_id, $member_id, $loan_date]);

    header("Location: index.php");
    exit();
}
?>
