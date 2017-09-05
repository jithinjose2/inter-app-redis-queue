<?php

namespace App\Console\Commands;

use App\Services\RedisService;
use Illuminate\Console\Command;
use Illuminate\Queue\RedisQueue;

class SendSampleMessage extends Command
{
    protected $name = 'messenger:send';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'messenger:send';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send message';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $message = ['random' => rand(100,998)];
        $redisService = new RedisService("messenger");
        $redisService->push($message);
        $this->info("Pushed message : ".json_encode($message));
    }
}
