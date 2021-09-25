<?php

namespace App\Repositories;

use App\Models\Address;
use App\Models\Company;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Repositories\Contracts\OrderRepositoryContract;
use Illuminate\Support\Facades\DB;
use Throwable;

class OrderRepository implements OrderRepositoryContract
{
    public function getLastOrder(): ?Order
    {
        return Order::query()->latest()->first();
    }

    /**
     * @param array $orderData
     * @return mixed
     * @throws Throwable
     */
    public function insert(array $orderData)
    {
        if (Order::query()->find($orderData['id'])) {
            return null;
        }
        return DB::transaction(function () use ($orderData) {
            if (isset($orderData["customer"])) {
                Customer::firstOrCreate($orderData["customer"]);
            }
            Company::firstOrCreate(['id' => $orderData['company_id']]);

            if (isset($orderData["billing_address"])) {
                Address::firstOrCreate($orderData["billing_address"]);
            }
            if (isset($orderData["shipping_address"])) {
                Address::firstOrCreate($orderData["shipping_address"]);
            }

            $order = Order::query()->create($orderData);
            if (isset($orderData["order_items"])) {
                foreach ($orderData["order_items"] as $item) {
                    Product::firstOrCreate($item["product"]);
                    $order->orderItems()->create($item);
                }
            }

            return $order;
        });
    }

    public function updateType(Order $order, string $type = "approved"): bool
    {
        return $order->update(['type' => $type]);
    }
}
