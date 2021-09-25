<?php

namespace App\Console\Commands;

use App\Jobs\OrderSyncJob;
use Illuminate\Console\Command;

class OrderSyncCommand extends Command
{
    protected $signature = 'sync:orders';

    protected $description = 'Sync Orders from market api';


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        return 0;
    }
}
