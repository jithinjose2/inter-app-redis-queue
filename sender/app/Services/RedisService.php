<?php
namespace App\Services;

use Predis\Command\ListPopFirstBlocking;
use Queue;

class RedisService
{

    public function push($message, $queueName)
    {
        Queue::pushRaw($message, $queueName);
    }

    public function pop($queue)
    {
        $a = new ListPopFirstBlocking();
        $a->setRawArguments(['queues:' . $queue, 1]);
        $work = Queue::getRedis()->connection()->client()->executeCommand($a);
        if(!empty($work[1]) && $work = json_decode($work[1], true)) {
            if (!empty($work['connection_id']) && class_exists($work['handle'])) {
                return $work;
            }
        }
        return false;
    }

}