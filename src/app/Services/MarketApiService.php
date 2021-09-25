<?php

namespace App\Services;

use App\Services\Contracts\MarketApiServiceContract;
use Illuminate\Auth\Access\AuthorizationException;

class MarketApiService extends BaseService implements MarketApiServiceContract
{
    /**
     * @throws AuthorizationException
     */
    public function getOrders(array $params = []): object
    {
        $result = $this->get('/orders', $params);
        $result->data = collect($result->data);
        return $result;
    }

    /**
     * @param int $orderId
     * @return object
     * @throws AuthorizationException
     */
    public function getOrder(int $orderId): object
    {
        return $this->get("/orders/{$orderId}");
    }

    /**
     * @throws AuthorizationException
     */
    public function updateOrderType(int $orderId, string $type = "approved"): object
    {
        return $this->post("/orders/{$orderId}", ['type' => $type]);
    }
}
