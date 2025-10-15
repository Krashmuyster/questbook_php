<!-- add.php -->
<?php
require_once 'config.php';
requireLogin(); // Только для авторизованных

if ($_POST) {
    $message = trim($_POST['message'] ?? '');

    if ($message) {
        $stmt = $pdo->prepare("INSERT INTO messages (user_id, message) VALUES (?, ?)");
        $stmt->execute([getCurrentUserId(), $message]);
    }

    header('Location: index.php');
    exit;
}
?>
