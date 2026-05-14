<?php
require_once 'QueueManager.php';
$q = new QueueManager();

$mainCount = $q->getStats($q->mainQueue);
$errorCount = $q->getStats($q->errorQueue);
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>RabbitMQ Lab Control Panel</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #c55580;
            color: #333;
            display: flex;
            justify-content: center;
            padding-top: 50px;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 500px;
        }
        h1 { font-size: 24px; margin-bottom: 20px; text-align: center; color: #781b3b; }
        
        .stats-container {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
        }
        .stat-card {
            flex: 1;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            border: 1px solid #e0e0e0;
        }
        .stat-card.main { background-color: #fbe2f4; border-color: #b091aa; }
        .stat-card.error { background-color: #ffcbcb; border-color: #bc8b8b; }
        
        .stat-value { display: block; font-size: 28px; font-weight: bold; margin-top: 5px; }
        .stat-label { font-size: 12px; text-transform: uppercase; color: #666; }

        form { display: flex; flex-direction: column; gap: 10px; }
        input[type="text"] {
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 6px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        input[type="text"]:focus { border-color: #41b094; outline: none; }
        
        button {
            background-color: #6cac9c;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            transition: background 0.3s;
        }
        button:hover { background-color: #a74f84; }
        
        .footer { margin-top: 20px; text-align: center; font-size: 12px; color: #888; }
    </style>
</head>
<body>
    <div class="container">
        <h1>RabbitMQ Manager</h1>

        <div class="stats-container">
            <div class="stat-card main">
                <span class="stat-label">В очереди</span>
                <span class="stat-value"><?= $mainCount ?></span>
            </div>
            <div class="stat-card error">
                <span class="stat-label">Ошибки</span>
                <span class="stat-value" style="color: #d93025;"><?= $errorCount ?></span>
            </div>
        </div>

        <form action="send.php" method="POST">
            <input type="text" name="name" placeholder="Название новой задачи..." required>
            <button type="submit">Добавить в очередь 🚀</button>
        </form>

        <div class="footer">
            Обновите страницу для актуальных данных
        </div>
    </div>
</body>
</html>