<?php

namespace App\Repositories\Contracts;

use App\Models\Order;

interface OrderRepositoryContract
{
    public function getLastOrder(): ?Order;

    public function insert(array $orderData);

    public function updateType(Order $order, string $type = "approved"): bool;
}
