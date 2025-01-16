<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
require 'db.php';

$db = getDB();
$stmt = $db->prepare("SELECT * FROM notes WHERE user_id = :user_id");
$stmt->bindParam(':user_id', $_SESSION['user_id']);
$stmt->execute();
$notes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ro" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="icon" href="notes_app.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container">
        <div class="card" style="width: 18rem;">
            <img src="notes_app.png" class="card-img-top" alt="...">
            <div class="card-body">
                <h5 class="card-title">Notes App</h5>
                <p class="card-text">App to take notes</p>
            </div>
        </div>
        <h2 class="mt-5">Your notes</h2>
        <a href="add_note.php" class="btn btn-primary mb-3">Add note</a>
        <ul class="list-group">
        <?php foreach ($notes as $note): ?>
            <li class="list-group-item">
                <h5><?php echo htmlspecialchars($note['title']); ?></h5>
                    <p><?php echo htmlspecialchars($note['content']); ?></p>
                    <p><strong>Priority:</strong> <?php echo htmlspecialchars($note['priority']); ?></p> <!-- Display priority -->
                    <div class="d-flex gap-2">
                        <a href="edit_note.php?id=<?php echo $note['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                        <a href="delete_note.php?id=<?php echo $note['id']; ?>" class="btn btn-danger btn-sm" 
                           onclick="return confirm('Are you sure you want to delete this note?');">Delete</a>
                    </div>
            </li>
        <?php endforeach; ?>
    </div>
</body>
</html>
