<?php
require_once 'config.php';
requireLogin();

$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) die("Некорректный ID");

$stmt = $pdo->prepare("SELECT m.*, u.username FROM messages m JOIN users u ON m.user_id = u.id WHERE m.id = ?");
$stmt->execute([$id]);
$message = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$message) die("Сообщение не найдено");

// Проверяем права
requireOwnerOrAdmin($message['user_id']);
// ... остальной код формы без изменений ...
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title> Редактировать сообщение</title>
    <link rel="stylesheet" href="style/style_edit.css">
</head>
<body>
    <div class="container">
        <h2>Редактировать сообщение</h2>

        <!-- Форма отправки на update.php -->
        <form action="update.php" method="POST">
            <!-- Скрытый ID — чтобы знать, какую запись обновлять -->
            <input type="hidden" name="id" value="<?= htmlspecialchars($message['id']) ?>">

            <label for="name">Имя:</label>
            <input type="text" id="name" name="name" value="<?= htmlspecialchars($message['username']) ?>" required>

            <label for="message">Сообщение:</label>
            <textarea id="message" name="message" rows="5" required><?= htmlspecialchars($message['message']) ?></textarea>

            <button type="submit" class="btn btn-save">Сохранить изменения</button>
            <a href="index.php" class="btn btn-cancel">Отмена</a>
        </form>
    </div>
</body>
</html>

