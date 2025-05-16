<?php
require 'db.php';
session_start();
$threads = $pdo->query("SELECT threads.*, users.username FROM threads JOIN users ON threads.user_id = users.id ORDER BY created_at DESC")->fetchAll();
?>
<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <title>Forum</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Mitt forum</h1>
    <div class="container">
        <p><a href="create_thread.php">Skapa ny tråd</a> | <a href="logout.php">Logga ut</a> | <a href="register.php">registrera</a></p>
        <h1>Trådar:</h1>
        <?php foreach ($threads as $thread): ?>
            <div class="thread">
                <a href="thread.php?id=<?= $thread['id'] ?>">
                    <?= htmlspecialchars($thread['title']) ?>
                </a>
                av <?= htmlspecialchars($thread['username']) ?>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
