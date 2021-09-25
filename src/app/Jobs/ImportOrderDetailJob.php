<?php

namespace App\Jobs;

use App\Repositories\Contracts\OrderRepositoryContract;
use App\Repositories\Contracts\RequestQueueRepositoryContract;
use App\Services\Contracts\MarketApiServiceContract;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\RateLimiter;

class ImportOrderDetailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    private MarketApiServiceContract $marketApi;

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
        $this->marketApi = app(MarketApiServiceContract::class);
        $this->orderRepository = app(OrderRepositoryContract::class);
        $this->requestRepository = app(RequestQueueRepositoryContract::class);

        /**
         * kuruktan işlem al
         */
        $orderInfo = $this->requestRepository->findByType("order_detail");

        while ($orderInfo) {
            /**
             * işlem limitine takılıyor muyum?
             */
            if (RateLimiter::remaining("market-api", 30) < 3) {
                dump("request Limit");
                break;
            }

            $this->insertOrder($orderInfo);

            $orderInfo->delete();
            $orderInfo = $this->requestRepository->findByType("order_detail");
        }
        dump("order_detail queue finish");
    }

    /**
     * @param $order
     */
    private function updateOrderType($order): void
    {
        if ($order) {
            RateLimiter::hit("market-api");
            $this->marketApi->updateOrderType($order->id);
            $this->orderRepository->updateType($order);
        }
    }

    /**
     * @param $orderInfo
     */
    private function insertOrder($orderInfo): void
    {
        RateLimiter::hit("market-api");
        $order = $this->marketApi->getOrder($orderInfo->value);
        $order = $this->orderRepository->insert(json_decode(json_encode($order), true));
        $this->updateOrderType($order);
    }
}
