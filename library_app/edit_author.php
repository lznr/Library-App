<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $author_id = $_POST['author_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];

    $stmt = $pdo->prepare('UPDATE authors SET first_name = ?, last_name = ? WHERE author_id = ?');
    $stmt->execute([$first_name, $last_name, $author_id]);

    header('Location: index.php');
    exit();
} else {
    $author_id = $_GET['author_id'];
    $stmt = $pdo->prepare('SELECT * FROM authors WHERE author_id = ?');
    $stmt->execute([$author_id]);
    $author = $stmt->fetch();
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Autor bearbeiten</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1>Autor bearbeiten</h1>
        <form action="edit_author.php" method="post">
            <input type="hidden" name="author_id" value="<?= htmlspecialchars($author['author_id']) ?>">
            <div class="form-group">
                <label for="first_name">Vorname:</label>
                <input type="text" id="first_name" name="first_name" class="form-control" value="<?= htmlspecialchars($author['first_name']) ?>">
            </div>
            <div class="form-group">
                <label for="last_name">Nachname:</label>
                <input type="text" id="last_name" name="last_name" class="form-control" value="<?= htmlspecialchars($author['last_name']) ?>">
            </div>
            <button type="submit" class="btn btn-primary">Speichern</button>
        </form>
    </div>
</body>
</html>
