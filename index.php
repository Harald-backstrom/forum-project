<?php
require 'db.php';
session_start();
$threads = $pdo->query("SELECT threads.*, users.username FROM threads JOIN users ON threads.user_id = users.id ORDER BY created_at DESC")->fetchAll();
?>
<a href="create_thread.php">Skapa ny tråd</a> | <a href="logout.php">Logga ut</a>
<h1>Trådar</h1>
<?php foreach ($threads as $thread): ?>
    <div>
        <a href="thread.php?id=<?= $thread['id'] ?>"> <?= htmlspecialchars($thread['title']) ?> </a>
        av <?= htmlspecialchars($thread['username']) ?>
    </div>
<?php endforeach; ?>