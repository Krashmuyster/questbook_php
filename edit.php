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