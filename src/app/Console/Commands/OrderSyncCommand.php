<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Services\Contracts\MarketApiServiceContract;
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
        /** @var MarketApiServiceContract $orderService */
        $orderService = app()
            ->make(MarketApiServiceContract::class);

        /** @var Order|null $order */
        $order = Order::query()->latest()->first();

        $params = [];

        if ($order) {
            $params['id'] = $order->id;
        }

        $orderResult = $orderService->getOrders($params);

        return 0;
    }
}
