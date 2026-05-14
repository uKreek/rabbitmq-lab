<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class QueueManager {
    private $connection;
    private $channel;
    public $mainQueue = 'main_tasks';
    public $errorQueue = 'error_tasks';

    public function __construct() {
        // Подключаемся к контейнеру rabbitmq
        $this->connection = new AMQPStreamConnection('rabbitmq', 5672, 'guest', 'guest');
        $this->channel = $this->connection->channel();
        
        // Объявляем две очереди
        $this->channel->queue_declare($this->mainQueue, false, true, false, false);
        $this->channel->queue_declare($this->errorQueue, false, true, false, false);
    }

    public function publish($data, $queue = null) {
        $queue = $queue ?? $this->mainQueue;
        $msg = new AMQPMessage(json_encode($data), ['delivery_mode' => 2]);
        $this->channel->basic_publish($msg, '', $queue);
    }

    public function consume($queue, callable $callback) {
        $this->channel->basic_consume($queue, '', false, false, false, false, function($msg) use ($callback) {
            $data = json_decode($msg->body, true);
            try {
                $callback($data);
                $msg->ack(); // Подтверждаем успех
            } catch (Exception $e) {
                // Если ошибка — шлем во вторую очередь
                $this->publish(['data' => $data, 'error' => $e->getMessage()], $this->errorQueue);
                $msg->ack(); 
                echo "❌ Ошибка отправлена в {$this->errorQueue}\n";
            }
        });

        while($this->channel->is_consuming()) { $this->channel->wait(); }
    }

    // Для вывода статистики в index.php
    public function getStats($queue) {
        list($name, $msgCount, $consumerCount) = $this->channel->queue_declare($queue, false, true, false, false);
        return $msgCount;
    }
}