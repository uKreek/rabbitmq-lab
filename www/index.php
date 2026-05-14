<?php
require_once 'QueueManager.php';
$q = new QueueManager();

// Логика статистики
$mainCount = $q->getStats($q->mainQueue);
$errorCount = $q->getStats($q->errorQueue);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lab 7: RabbitMQ</title>
</head>
<body>
    <h1>Управление задачами</h1>

    <!-- Форма для отправки сообщения -->
    <form action="send.php" method="POST" style="margin-bottom: 20px; padding: 15px; border: 1px solid #ddd;">
        <input type="text" name="name" placeholder="Введите название задачи" required>
        <button type="submit">Отправить в очередь 🚀</button>
    </form>

    <div style="background: #f4f4f4; padding: 10px;">
        <h3>📊 Статистика очередей</h3>
        <p>Основная очередь: <b><?= $mainCount ?></b> сообщений</p>
        <p>Очередь ошибок: <b style="color:red;"><?= $errorCount ?></b> сообщений</p>
    </div>

    <p><small>Обновите страницу, чтобы увидеть актуальную статистику.</small></p>
</body>
</html>