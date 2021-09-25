<?php

namespace App\Services\Contracts;

interface MarketApiServiceContract
{
    public function getOrders(array $params = []): object;

    public function getOrder(int $orderId): object;

    public function updateOrderType(int $orderId, string $type = "approved"): object;
}
