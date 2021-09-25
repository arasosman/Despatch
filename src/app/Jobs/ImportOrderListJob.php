<?php

namespace App\Jobs;

use App\Repositories\Contracts\OrderRepositoryContract;
use App\Repositories\Contracts\RequestQueueRepositoryContract;
use App\Services\Contracts\MarketApiServiceContract;
use App\Traits\OrderHelperTrait;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\RateLimiter;

class ImportOrderListJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    use OrderHelperTrait;

    private MarketApiServiceContract $marketService;

    private OrderRepositoryContract $orderRepository;

    private RequestQueueRepositoryContract $requestRepository;

    public function backoff()
    {
        return [1, 5, 10];
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->marketService = app(MarketApiServiceContract::class);
        $this->orderRepository = app(OrderRepositoryContract::class);
        $this->requestRepository = app(RequestQueueRepositoryContract::class);

        $orderDetailInfo = $this->requestRepository->findByType("order_detail");
        if ($orderDetailInfo) {
            return;
        }
        /**
         * kuruktan işlem al
         */
        $orderInfo = $this->requestRepository->findByType("order_list");

        while ($orderInfo) {
            /**
             * işlem limitine takılıyor muyum?
             */
            if (RateLimiter::remaining("market-api", 30) < 1) {
                dump("request Limit");
                break;
            }

            logger('OrderSyncCommand');
            $this->getOrderAndImportQueue(json_decode($orderInfo->value, true));

            $orderInfo->delete();
            $orderInfo = $this->requestRepository->findByType("order_list");
        }
        dump("order_detail queue finish");
    }
}
