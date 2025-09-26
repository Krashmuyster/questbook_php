<?php
require_once 'config.php';

if ($_POST) {
    $name = trim($_POST['name']);
    $message = trim($_POST['message']);
    if($name && $message) {

    $stmt = $pdo ->prepare("INSERT INTO messages (name,message) VALUES(?, ?)");
    $stmt->execute([$name, $message]);

    header('Location: index.php');
    exit;
    } else{
        $error = "Пожалуйста, заполните все поля.";
    }
}


$stmt = $pdo -> query("SELECT * FROM messages ORDER BY created_at DESC");
$messages = $stmt -> fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body { font-family: Arial; margin: 40px; background: #f0f0f0; }
        .container { max-width: 600px; margin: auto; background: white; padding: 20px; border-radius: 8px; }
        .message { padding: 15px; border-bottom: 1px solid #eee; }
        .name { font-weight: bold; color: #333; }
        .date { font-size: 0.8em; color: #888; }
        input, textarea { width: 97%; padding: 8px; margin: 5px 0px 15px; }
        button { padding: 10px 20px; background: #007BFF; color: white; border: none; cursor: pointer; }
        button:hover { background: #0056b3; }
        .error { color: red; }
    </style>
<div class="container">
        <h1>Гостевая книга</h1>
        <form method="POST">
            <?php if (isset($error)): ?>
                <p class="error"><?= $error ?></p>
            <?php endif; ?>
            <input type="text" name="name" placeholder="Ваше имя" required>
            <textarea name="message" rows="4" placeholder="Ваше сообщение" required></textarea>
            <button type="submit">Отправить</button>
        </form>

        <hr>
        <h3>Сообщения (<?= count($messages) ?>):</h3>
        <?php if (empty($messages)): ?>
            <p>Пока нет сообщений. Будьте первым!</p>
        <?php else: ?>
            <?php foreach ($messages as $msg): ?>
                <div class="message">
                    <div class="name">👤 <?= htmlspecialchars($msg['name']) ?></div>
                    <div><?= htmlspecialchars($msg['message']) ?></div>
                    <div class="date"> <?= $msg['created_at'] ?></div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>