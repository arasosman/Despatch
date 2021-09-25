<?php

namespace App\Console\Commands;

use App\Jobs\ImportOrderDetailJob;
use App\Jobs\ImportOrderListJob;
use Illuminate\Console\Command;

class RequestQueueWorkerCommand extends Command
{
    protected $signature = 'request_queue:work';


    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        /** Kuyruktaki detay isteklerini yapıp insert eder */
        ImportOrderDetailJob::dispatchSync();
        /** Liste isteklerinde pagination var ise onlarıda import etmek için */
        ImportOrderListJob::dispatchSync();
        return 0;
    }
}
