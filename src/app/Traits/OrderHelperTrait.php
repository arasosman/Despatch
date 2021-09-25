<?php

namespace App\Traits;

use Illuminate\Support\Facades\RateLimiter;

trait OrderHelperTrait
{
    public function getOrderEndImportQueue($params)
    {
        RateLimiter::hit('market-api');

        $orderResult = $this->marketService->getOrders($params);
        $orders = $orderResult->data;
        $orderIds = $orders->pluck('id')->toArray();

        /**
         * Detaylar kuruktan çekilip sırayla import edilecek
         */
        foreach ($orderIds as $orderId) {
            $this->requestRepository->create([
                'type' => "order_detail",
                'value' => $orderId
            ]);
        }

        return $orderResult;
    }
}
