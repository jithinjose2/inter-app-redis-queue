<?php

namespace App\Console\Commands;

use App\Services\RedisService;
use Illuminate\Console\Command;
use Illuminate\Queue\RedisQueue;

class SendSampleMessage extends Command
{
    protected $name = 'messenger:recive';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'messenger:recive';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Recive messages';

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
        $redisService = new RedisService("messenger");
        while(true) {
            $message = $redisService->pop();
            if ($message!== false) {
                $this->info("Recived message " . json_encode($message));
            }
        }

    }
}
