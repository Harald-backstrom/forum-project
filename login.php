<?php
require 'db.php';
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$_POST['username']]);
    $user = $stmt->fetch();
    if ($user && password_verify($_POST['password'], $user['password_hash'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: index.php");
    } else {
        echo "Felaktiga inloggningsuppgifter.";
    }
}
?>
<form method="post">
    Användarnamn: <input name="username"><br>
    Lösenord: <input type="password" name="password"><br>
    <button>Logga in</button>
</form>

