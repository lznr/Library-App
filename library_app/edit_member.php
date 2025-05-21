<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $member_id = $_POST['member_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];

    $stmt = $pdo->prepare("
        UPDATE members
        SET first_name = ?, last_name = ?
        WHERE member_id = ?
    ");
    $stmt->execute([$first_name, $last_name, $member_id]);

    header('Location: index.php');
    exit;
}

$member_id = $_GET['member_id'];
$memberStmt = $pdo->prepare("
    SELECT member_id, first_name, last_name
    FROM members
    WHERE member_id = ?
");
$memberStmt->execute([$member_id]);
$member = $memberStmt->fetch();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mitglied bearbeiten</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="mt-4">Mitglied bearbeiten</h1>
        <form action="edit_member.php" method="post">
            <input type="hidden" name="member_id" value="<?= htmlspecialchars($member['member_id']) ?>">
            <div class="form-group">
                <label for="first_name">Vorname:</label>
                <input type="text" id="first_name" name="first_name" class="form-control" value="<?= htmlspecialchars($member['first_name']) ?>">
            </div>
            <div class="form-group">
                <label for="last_name">Nachname:</label>
                <input type="text" id="last_name" name="last_name" class="form-control" value="<?= htmlspecialchars($member['last_name']) ?>">
            </div>
            <button type="submit" class="btn btn-primary">Speichern</button>
        </form>
    </div>
</body>
</html>
