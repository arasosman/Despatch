<?php

namespace Tests\Feature\Services;

use App\Services\Contracts\MarketApiServiceContract;
use App\Services\MarketApiService;
use Illuminate\Contracts\Container\BindingResolutionException;
use Tests\TestCase;
use Throwable;

class MarketApiTest extends TestCase
{
    private MarketApiServiceContract $service;

    /**
     * @throws BindingResolutionException
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->service = $this->app->make(MarketApiServiceContract::class);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetOrderList()
    {
        $data = $this->service->getOrders([]);
        $this->assertTrue($data->data->isNotEmpty());
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetOrderListVeryDistantDate()
    {

        $data = $this->service->getOrders(["date" => now()->addYear()->format("Y-m-d H:i:s")]);
        $this->assertTrue($data->data->isEmpty());
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetOrderListGivenInvalidId()
    {

        try {
            $this->service->getOrders(["id" => 554545985]);
        } catch (Throwable $exception) {
            $this->assertEquals(422, $exception->getCode());
        }
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetOrderDetail()
    {

        $data = $this->service->getOrder(55);

        $array = (array)$data;
        $this->assertArrayHasKey("id", $array);
        $this->assertArrayHasKey("shipping_method", $array);
        $this->assertArrayHasKey("billing_address_id", $array);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testGetOrderDetailDoesNotExistId()
    {
        try {
            $this->service->getOrder(888888888);
        } catch (Throwable $exception) {
            $this->assertEquals(404, $exception->getCode());
        }
    }

    public function testOrderTypeUpdate()
    {
        $result = $this->service->updateOrderType(555);
        $array = (array)$result;
        $this->assertArrayHasKey("id", $array);
        $this->assertArrayHasKey("shipping_method", $array);
        $this->assertArrayHasKey("billing_address_id", $array);
        $this->assertArrayHasKey("type", $array);

        $this->assertEquals('approved', $array['type']);
    }
}
