<?php
require 'db.php';
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$_POST['username']]);
    $user = $stmt->fetch();

    if ($user && password_verify($_POST['password'], $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: index.php");
        exit;
    } else {
        $error = "Felaktiga inloggningsuppgifter.";
    }
}
?>
<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <title>Logga in</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Logga in</h1>
    <div class="container">
        <?php if ($error): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="post">
            <label>Användarnamn:</label>
            <input type="text" name="username" required><br>

            <label>Lösenord:</label>
            <input type="password" name="password" required><br>

            <button type="submit">Logga in</button>
        </form>
    </div>
</body>
</html>
