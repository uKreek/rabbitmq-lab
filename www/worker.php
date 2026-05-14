<?php
require_once 'QueueManager.php';
$q = new QueueManager();

echo "👷 Работяга запущен...\n";

$q->consume($q->mainQueue, function($data) {
    echo "📥 Обработка: " . $data['name'] . "\n";
    
    // Имитация случайной ошибки для штрафного задания
    if (rand(1, 3) === 1) {
        throw new Exception("Случайный сбой обработки!");
    }
    
    sleep(1);
    echo "✅ Успех\n";
});