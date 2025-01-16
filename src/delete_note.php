<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
require 'db.php';

if (isset($_GET['id'])) {
    $db = getDB();
    $stmt = $db->prepare("DELETE FROM notes WHERE id = :id AND user_id = :user_id");
    $stmt->bindParam(':id', $_GET['id']);
    $stmt->bindParam(':user_id', $_SESSION['user_id']);
    $stmt->execute();
}

header("Location: dashboard.php");
exit();
?>
