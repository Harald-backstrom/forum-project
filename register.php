<?php
require 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Enkelt exempel på att undvika duplicate username (kan förbättras)
    $stmtCheck = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmtCheck->execute([$username]);
    if ($stmtCheck->fetch()) {
        $error = "Användarnamnet är redan taget.";
    } else {
        $stmt = $pdo->prepare("INSERT INTO users (username, password_hash) VALUES (?, ?)");
        $stmt->execute([$username, $password]);
        header("Location: login.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="sv">
<head>
    <meta charset="UTF-8">
    <title>Registrera</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Registrera nytt konto</h1>
    <div class="container">
        <?php if ($error): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form method="post">
            <label>Användarnamn:</label><br>
            <input type="text" name="username" required><br>

            <label>Lösenord:</label><br>
            <input type="password" name="password" required><br>

            <button type="submit">Registrera</button>
        </form>
    </div>
</body>
</html>
