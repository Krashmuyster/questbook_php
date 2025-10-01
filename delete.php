<?php
// delete.php — обработчик удаления сообщения

require_once 'config.php';

// Проверяем, передан ли ID
if (empty($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Некорректный ID");
}

$id = (int)$_GET['id']; // Приводим к числу — защита от инъекций

// Подготавливаем запрос на удаление
$stmt = $pdo->prepare("DELETE FROM messages WHERE id = ?");
$stmt->execute([$id]);

// Перенаправляем обратно на главную
header('Location: index.php');
exit;
?>