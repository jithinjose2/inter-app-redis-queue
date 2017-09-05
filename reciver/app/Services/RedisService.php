<?php
namespace App\Services;

use Predis\Client;
use Predis\Command\ListPopFirstBlocking;
use Predis\Command\ListPushTail;
use Queue;

class RedisService
{

    public function __construct($queueName)
    {
        $this->queueName = $queueName;
        $this->client = new Client(config('database.redis.default'));
    }

    public function push($message)
    {
        $command = new ListPushTail();
        $command->setRawArguments(['queues:' . $this->queueName, json_encode($message)]);
        $this->client->executeCommand($command);
    }

    public function pop($wait = 1)
    {
        $command = new ListPopFirstBlocking();
        $command->setRawArguments(['queues:' . $this->queueName, $wait]);
        $work = $this->client->executeCommand($command);
        if(!empty($work[1]) && $work = json_decode($work[1], true)) {
            return $work;
        }
        return false;
    }

}