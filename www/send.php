<?php
require_once 'QueueManager.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $q = new QueueManager();
    $data = [
        'name' => $_POST['name'] ?? 'Анонимная задача',
        'timestamp' => date('Y-m-d H:i:s')
    ];
    
    $q->publish($data);
    
    echo "✅ Сообщение '" . htmlspecialchars($data['name']) . "' отправлено!<br>";
    echo "<a href='index.php'>Назад к статистике</a>";
}