<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $book_id = $_POST['book_id'];
    $title = $_POST['title'];
    $author_id = $_POST['author_id'];
    $category_id = $_POST['category_id'];
    $year_published = $_POST['year_published'];

    $stmt = $pdo->prepare("
        UPDATE books
        SET title = ?, author_id = ?, category_id = ?, year_published = ?
        WHERE book_id = ?
    ");
    $stmt->execute([$title, $author_id, $category_id, $year_published, $book_id]);

    header('Location: index.php');
    exit;
}

$book_id = $_GET['book_id'];
$bookStmt = $pdo->prepare("
    SELECT book_id, title, author_id, category_id, year_published
    FROM books
    WHERE book_id = ?
");
$bookStmt->execute([$book_id]);
$book = $bookStmt->fetch();

$authorsStmt = $pdo->query("
    SELECT author_id, CONCAT(first_name, ' ', last_name) AS author_name
    FROM authors
    WHERE archived = 0
");
$authors = $authorsStmt->fetchAll();

$categoriesStmt = $pdo->query("SELECT category_id, category_name FROM categories");
$categories = $categoriesStmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Buch bearbeiten</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h1 class="mt-4">Buch bearbeiten</h1>
        <form action="edit_book.php" method="post">
            <input type="hidden" name="book_id" value="<?= htmlspecialchars($book['book_id']) ?>">
            <div class="form-group">
                <label for="title">Titel:</label>
                <input type="text" id="title" name="title" class="form-control" value="<?= htmlspecialchars($book['title']) ?>">
            </div>
            <div class="form-group">
                <label for="author_id">Autor:</label>
                <select id="author_id" name="author_id" class="form-control">
                    <?php foreach ($authors as $author): ?>
                    <option value="<?= htmlspecialchars($author['author_id']) ?>" <?= $author['author_id'] == $book['author_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($author['author_name']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="category_id">Kategorie:</label>
                <select id="category_id" name="category_id" class="form-control">
                    <?php foreach ($categories as $category): ?>
                    <option value="<?= htmlspecialchars($category['category_id']) ?>" <?= $category['category_id'] == $book['category_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($category['category_name']) ?>
                    </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="year_published">Erscheinungsjahr:</label>
                <input type="text" id="year_published" name="year_published" class="form-control" value="<?= htmlspecialchars($book['year_published']) ?>">
            </div>
            <button type="submit" class="btn btn-primary">Speichern</button>
        </form>
    </div>
</body>
</html>
