<?php
session_start();
require 'db.php';

// Check if the user is logged in and is an admin
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$db = getDB();
$stmt = $db->prepare("SELECT role FROM users WHERE id = :id");
$stmt->bindParam(':id', $_SESSION['user_id']);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user || $user['role'] !== 'admin') {
    echo "Access denied.";
    exit();
}

// Delete user by ID
if (isset($_GET['id'])) {
    $userId = $_GET['id'];

    // Prevent deleting the admin user
    $deleteStmt = $db->prepare("DELETE FROM users WHERE id = :id AND role != 'admin'");
    $deleteStmt->bindParam(':id', $userId);

    if ($deleteStmt->execute()) {
        header("Location: admin.php");
        exit();
    } else {
        echo "Failed to delete user.";
    }
}
?>
