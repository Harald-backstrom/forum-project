<?php
require 'db.php';
session_start();

$id = $_GET['id'] ?? null;
if (!$id) {
    header("Location: index.php");
    exit;
}

$thread = $pdo->prepare("SELECT threads.*, users.username FROM threads JOIN users ON threads.user_id = users.id WHERE threads.id = ?");
$thread->execute([$id]);
$thread = $thread->fetch();

if (!$thread) {
    echo "Tråden finns inte.";
    exit;
}

$posts = $pdo->prepare("SELECT posts.*, users.username FROM posts JOIN users ON posts.user_id = users.id WHERE thread_id = ? ORDER BY created_at ASC");
$posts->execute([$id]);
$posts = $posts->fetchAll();
?>
<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($thread['title']) ?></title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <p><a href="index.php">&larr; Tillbaka till trådar</a></p>

        <h2><?= htmlspecialchars($thread['title']) ?></h2>
        <p>Skapad av <?= htmlspecialchars($thread['username']) ?></p>
        <hr>

        <?php foreach ($posts as $post): ?>
            <div class="post">
                <p><strong><?= htmlspecialchars($post['username']) ?>:</strong></p>
                <p><?= nl2br(htmlspecialchars($post['content'])) ?></p>
            </div>
            <hr>
        <?php endforeach; ?>

        <?php if (isset($_SESSION['user_id'])): ?>
            <form method="post" action="post_reply.php">
                <input type="hidden" name="thread_id" value="<?= $id ?>">
                <textarea name="content" required placeholder="Skriv ditt svar här..."></textarea><br>
                <button type="submit">Svara</button>
            </form>
        <?php else: ?>
            <p><a href="login.php">Logga in</a> för att svara</p>
        <?php endif; ?>
    </div>
</body>
</html>
