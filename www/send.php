<?php
require_once 'QueueManager.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $q = new QueueManager();
    $data = [
        'name' => $_POST['name'] ?? 'Без названия',
        'timestamp' => date('H:i:s')
    ];
    
    $q->publish($data);
    
    // Перенаправляем обратно на главную через 0 секунд
    header("Location: index.php");
    exit;
}