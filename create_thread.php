<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("INSERT INTO threads (title, user_id) VALUES (?, ?)");
    $stmt->execute([$_POST['title'], $_SESSION['user_id']]);
    header("Location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <title>Skapa ny tråd</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
    <p><a href="index.php">&larr; Tillbaka till trådar</a></p>
        <h1>Skapa ny tråd</h1>
        <form method="post">
            <label>Ämne:</label><br>
            <input type="text" name="title" required><br><br>
            <button type="submit">Skapa tråd</button>
        </form>
    </div>
</body>
</html>
