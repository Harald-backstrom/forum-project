<?php
require 'db.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    die("Du måste vara inloggad.");
}
$stmt = $pdo->prepare("INSERT INTO posts (thread_id, content, user_id) VALUES (?, ?, ?)");
$stmt->execute([$_POST['thread_id'], $_POST['content'], $_SESSION['user_id']]);
header("Location: thread.php?id=" . $_POST['thread_id']);
?>