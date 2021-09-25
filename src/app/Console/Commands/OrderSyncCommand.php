<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Repositories\Contracts\OrderRepositoryContract;
use App\Repositories\Contracts\RequestQueueRepositoryContract;
use App\Services\Contracts\MarketApiServiceContract;
use App\Traits\OrderHelperTrait;
use Illuminate\Console\Command;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Support\Facades\RateLimiter;

class OrderSyncCommand extends Command
{
    use OrderHelperTrait;

    protected $signature = 'sync:orders';

    protected $description = 'Sync Orders from market api';

    private RequestQueueRepositoryContract $requestRepository;

    private MarketApiServiceContract $marketService;

    /**
     * Execute the console command.
     *
     * @return int
     * @throws BindingResolutionException
     */
    public function handle(): int
    {
        $this->marketService = app()->make(MarketApiServiceContract::class);
        $this->requestRepository = app()->make(RequestQueueRepositoryContract::class);

        $orderRepository = app()->make(OrderRepositoryContract::class);
        /** @var Order $order */
        $order = $orderRepository->getLastOrder();

        $params = [];

        if ($order) {
            $params['id'] = $order->id;
            $params['date'] = $order->created_at->format('Y-m-d H:i:s');
        }

        if (RateLimiter::remaining('market-api', 30)) {
            logger('OrderSyncCommand');
            $orderResult = $this->getOrderEndImportQueue($params);

            /**
             * Diğer sayfalarıda kuyruğa atıyoruz
             */
            $this->orderListNextPagesAddQueue($orderResult->last_page, $params);
        }

        return 0;
    }

    /**
     * @param int $last_page
     * @param array $params
     */
    private function orderListNextPagesAddQueue(int $lastPage, array $params): void
    {
        if ($lastPage > 1) {
            foreach (range(2, $lastPage) as $page) {
                $this->requestRepository->create([
                    'type' => "order_list",
                    'value' => json_encode(array_merge($params, ['page' => $page]))
                ]);
            }
        }
    }
}
