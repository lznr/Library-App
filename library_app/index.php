<?php
require 'db.php';

// Ausleihenbericht abrufen
$loansStmt = $pdo->query("
    SELECT 
        loans.loan_id, 
        books.title, 
        CONCAT(members.first_name, ' ', members.last_name) AS member_name, 
        loans.loan_date, 
        loans.return_date
    FROM 
        loans
    JOIN 
        books ON loans.book_id = books.book_id
    JOIN 
        members ON loans.member_id = members.member_id
");
$loans = $loansStmt->fetchAll();

// Bücherbericht abrufen
$booksStmt = $pdo->query("
    SELECT 
        books.book_id,
        books.title, 
        CONCAT(authors.first_name, ' ', authors.last_name) AS author_name, 
        categories.category_name, 
        books.year_published
    FROM 
        books
    JOIN 
        authors ON books.author_id = authors.author_id
    JOIN 
        categories ON books.category_id = categories.category_id
    WHERE books.archived = 0
");
$books = $booksStmt->fetchAll();

// Alle Mitglieder abrufen
$membersStmt = $pdo->query("
    SELECT 
        member_id,
        CONCAT(first_name, ' ', last_name) AS member_name
    FROM 
        members
    WHERE archived = 0
");
$members = $membersStmt->fetchAll();

// Alle Autoren abrufen
$authorsStmt = $pdo->query("
    SELECT 
        author_id,
        CONCAT(first_name, ' ', last_name) AS author_name
    FROM 
        authors
    WHERE archived = 0
");
$authors = $authorsStmt->fetchAll();

// Alle Kategorien abrufen
$categoriesStmt = $pdo->query("SELECT category_id, category_name FROM categories");
$categories = $categoriesStmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliothekssystem</title>
    <!-- Bootstrap CSS -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="styles.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <nav class="col-md-3 col-lg-2 d-md-block bg-dark sidebar">
                <div class="sidebar-sticky">
                    <h5 class="sidebar-heading text-white">Bibliothekssystem</h5>
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#" onclick="showSection('loans')">Leihbericht</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#" onclick="showSection('books')">Bücher</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#" onclick="showSection('authors')">Autoren</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#" onclick="showSection('members')">Mitglieder</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#" onclick="showSection('loan-book')">Buch ausleihen</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="#" onclick="showSection('return-book')">Buch zurückgeben</a>
                        </li>
                    </ul>
                </div>
            </nav>

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4 main-content">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2 text-white">Bibliothekssystem</h1>
                </div>

                <div id="loans" class="section card bg-dark text-white">
                    <div class="card-header">Historie</div>
                    <div class="card-body">
                        <table class="table table-dark table-striped">
                            <thead>
                                <tr>
                                    <th>Leih-ID</th>
                                    <th>Buchtitel</th>
                                    <th>Mitgliedsname</th>
                                    <th>Leihdatum</th>
                                    <th>Rückgabedatum</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($loans as $loan): ?>
                                <tr>
                                    <td><?= htmlspecialchars($loan['loan_id']) ?></td>
                                    <td><?= htmlspecialchars($loan['title']) ?></td>
                                    <td><?= htmlspecialchars($loan['member_name']) ?></td>
                                    <td><?= htmlspecialchars($loan['loan_date']) ?></td>
                                    <td><?= htmlspecialchars($loan['return_date']) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="books" class="section card bg-dark text-white">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Bücherbericht</span>
                        <button class="btn btn-primary btn-add" onclick="showSection('add-book')">Buch hinzufügen</button>
                    </div>
                    <div class="card-body">
                        <table class="table table-dark table-striped">
                            <thead>
                                <tr>
                                    <th>Buchtitel</th>
                                    <th>Autorenname</th>
                                    <th>Kategorie</th>
                                    <th>Erscheinungsjahr</th>
                                    <th>Aktionen</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($books as $book): ?>
                                <tr>
                                    <td><?= htmlspecialchars($book['title']) ?></td>
                                    <td><?= htmlspecialchars($book['author_name']) ?></td>
                                    <td><?= htmlspecialchars($book['category_name']) ?></td>
                                    <td><?= htmlspecialchars($book['year_published']) ?></td>
                                    <td>
                                        <form action="archive_book.php" method="post" style="display:inline;">
                                            <input type="hidden" name="book_id" value="<?= htmlspecialchars($book['book_id']) ?>">
                                            <button type="submit" class="btn btn-danger btn-sm">Archivieren</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="add-book" class="section card bg-dark text-white">
                    <div class="card-header">Buch hinzufügen</div>
                    <div class="card-body">
                        <form action="add_book.php" method="post" class="mb-4">
                            <div class="form-group">
                                <label for="title">Buchtitel:</label>
                                <input type="text" id="title" name="title" class="form-control bg-dark text-white">
                            </div>
                            <div class="form-group">
                                <label for="author_id">Autor:</label>
                                <select id="author_id" name="author_id" class="form-control bg-dark text-white">
                                    <?php foreach ($authors as $author): ?>
                                    <option value="<?= htmlspecialchars($author['author_id']) ?>"><?= htmlspecialchars($author['author_name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="category_id">Kategorie:</label>
                                <select id="category_id" name="category_id" class="form-control bg-dark text-white">
                                    <?php foreach ($categories as $category): ?>
                                    <option value="<?= htmlspecialchars($category['category_id']) ?>"><?= htmlspecialchars($category['category_name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="year_published">Erscheinungsjahr:</label>
                                <input type="text" id="year_published" name="year_published" class="form-control bg-dark text-white">
                            </div>
                            <button type="submit" class="btn btn-primary">Buch hinzufügen</button>
                        </form>
                    </div>
                </div>

                <div id="authors" class="section card bg-dark text-white">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Autoren</span>
                        <button class="btn btn-primary btn-add" onclick="showSection('add-author')">Autor hinzufügen</button>
                    </div>
                    <div class="card-body">
                        <table class="table table-dark table-striped">
                            <thead>
                                <tr>
                                    <th>Autorenname</th>
                                    <th>Aktionen</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($authors as $author): ?>
                                <tr>
                                    <td><?= htmlspecialchars($author['author_name']) ?></td>
                                    <td>
                                        <a href="edit_author.php?author_id=<?= htmlspecialchars($author['author_id']) ?>" class="btn btn-warning btn-sm">Bearbeiten</a>
                                        <form action="archive_author.php" method="post" style="display:inline;">
                                            <input type="hidden" name="author_id" value="<?= htmlspecialchars($author['author_id']) ?>">
                                            <button type="submit" class="btn btn-danger btn-sm">Archivieren</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="add-author" class="section card bg-dark text-white">
                    <div class="card-header">Autor hinzufügen</div>
                    <div class="card-body">
                        <form action="add_author.php" method="post" class="mb-4">
                            <div class="form-group">
                                <label for="first_name">Vorname:</label>
                                <input type="text" id="first_name" name="first_name" class="form-control bg-dark text-white">
                            </div>
                            <div class="form-group">
                                <label for="last_name">Nachname:</label>
                                <input type="text" id="last_name" name="last_name" class="form-control bg-dark text-white">
                            </div>
                            <button type="submit" class="btn btn-primary">Autor hinzufügen</button>
                        </form>
                    </div>
                </div>

                <div id="members" class="section card bg-dark text-white">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <span>Mitglieder</span>
                        <button class="btn btn-primary btn-add" onclick="showSection('add-member')">Mitglied hinzufügen</button>
                    </div>
                    <div class="card-body">
                        <table class="table table-dark table-striped">
                            <thead>
                                <tr>
                                    <th>Mitglieds-ID</th>
                                    <th>Mitgliedsname</th>
                                    <th>Aktionen</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($members as $member): ?>
                                <tr>
                                    <td><?= htmlspecialchars($member['member_id']) ?></td>
                                    <td><?= htmlspecialchars($member['member_name']) ?></td>
                                    <td>
                                        <a href="edit_member.php?member_id=<?= htmlspecialchars($member['member_id']) ?>" class="btn btn-warning btn-sm">Bearbeiten</a>
                                        <form action="archive_member.php" method="post" style="display:inline;">
                                            <input type="hidden" name="member_id" value="<?= htmlspecialchars($member['member_id']) ?>">
                                            <button type="submit" class="btn btn-danger btn-sm">Archivieren</button>
                                        </form>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div id="add-member" class="section card bg-dark text-white">
                    <div class="card-header">Mitglied hinzufügen</div>
                    <div class="card-body">
                        <form action="add_member.php" method="post" class="mb-4">
                            <div class="form-group">
                                <label for="first_name">Vorname:</label>
                                <input type="text" id="first_name" name="first_name" class="form-control bg-dark text-white">
                            </div>
                            <div class="form-group">
                                <label for="last_name">Nachname:</label>
                                <input type="text" id="last_name" name="last_name" class="form-control bg-dark text-white">
                            </div>
                            <button type="submit" class="btn btn-primary">Mitglied hinzufügen</button>
                        </form>
                    </div>
                </div>

                <div id="loan-book" class="section card bg-dark text-white">
                    <div class="card-header">Buch ausleihen</div>
                    <div class="card-body">
                        <form action="loan_book.php" method="post" class="mb-4">
                            <div class="form-group">
                                <label for="book_id">Buch:</label>
                                <select id="book_id" name="book_id" class="form-control bg-dark text-white">
                                    <?php foreach ($books as $book): ?>
                                    <option value="<?= htmlspecialchars($book['book_id']) ?>"><?= htmlspecialchars($book['title']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="member_id">Mitglied:</label>
                                <select id="member_id" name="member_id" class="form-control bg-dark text-white">
                                    <?php foreach ($members as $member): ?>
                                    <option value="<?= htmlspecialchars($member['member_id']) ?>"><?= htmlspecialchars($member['member_name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Buch ausleihen</button>
                        </form>
                    </div>
                </div>

                <div id="return-book" class="section card bg-dark text-white">
                    <div class="card-header">Buch zurückgeben</div>
                    <div class="card-body">
                        <form action="return_book.php" method="post" class="mb-4">
                            <div class="form-group">
                                <label for="loan_id">Leih-ID:</label>
                                <input type="text" id="loan_id" name="loan_id" class="form-control bg-dark text-white">
                            </div>
                            <button type="submit" class="btn btn-primary">Buch zurückgeben</button>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Bootstrap JS und Abhängigkeiten (jQuery und Popper.js) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        function showSection(sectionId) {
            document.querySelectorAll('.section').forEach(function(section) {
                section.style.display = 'none';
            });
            document.querySelectorAll('.nav-link').forEach(function(link) {
                link.classList.remove('active');
            });
            document.getElementById(sectionId).style.display = 'block';
            document.querySelector('[onclick="showSection(\'' + sectionId + '\')"]').classList.add('active');
        }
        document.addEventListener('DOMContentLoaded', function() {
            showSection('loans');
        });
    </script>
</body>
</html>
