<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $loan_id = $_POST['loan_id'];
    $return_date = date('Y-m-d'); // Setze das aktuelle Datum als Rückgabedatum

    $stmt = $pdo->prepare("UPDATE loans SET return_date = ? WHERE loan_id = ?");
    $stmt->execute([$return_date, $loan_id]);

    header("Location: index.php");
    exit();
}
?>
