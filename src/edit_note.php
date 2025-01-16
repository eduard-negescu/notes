<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
require 'db.php';

$db = getDB();

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $stmt = $db->prepare("SELECT * FROM notes WHERE id = :id AND user_id = :user_id");
    $stmt->bindParam(':id', $_GET['id']);
    $stmt->bindParam(':user_id', $_SESSION['user_id']);
    $stmt->execute();
    $note = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$note) {
        header("Location: dashboard.php");
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $stmt = $db->prepare("UPDATE notes SET title = :title, content = :content, priority = :priority WHERE id = :id AND user_id = :user_id");
    $stmt->bindParam(':id', $_POST['id']);
    $stmt->bindParam(':user_id', $_SESSION['user_id']);
    $stmt->bindParam(':title', $_POST['title']);
    $stmt->bindParam(':content', $_POST['content']);
    $stmt->bindParam(':priority', $_POST['priority']);
    $stmt->execute();

    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="ro" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Note</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <div class="container">
        <h2 class="mt-5">Edit Note</h2>
        <form method="post" action="edit_note.php">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($note['id']); ?>">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($note['title']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea class="form-control" id="content" name="content" rows="5" required><?php echo htmlspecialchars($note['content']); ?></textarea>
            </div>
            <div>
                <select class="form-control" id="priority" name="priority" required>
                    <option value="1" <?php echo ($note['priority'] == 1) ? 'selected' : ''; ?>>1</option>
                    <option value="2" <?php echo ($note['priority'] == 2) ? 'selected' : ''; ?>>2</option>
                    <option value="3" <?php echo ($note['priority'] == 3) ? 'selected' : ''; ?>>3</option>
                    <option value="4" <?php echo ($note['priority'] == 4) ? 'selected' : ''; ?>>4</option>
                    <option value="5" <?php echo ($note['priority'] == 5) ? 'selected' : ''; ?>>5</option>
                </select>
            </div>
            <button type="submit" class="btn btn-success">Save Changes</button>
        </form>
    </div>
</body>
</html>
