<?php

namespace Tests\Feature\Repository;

use App\Repositories\Contracts\OrderRepositoryContract;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class OrderRepositoryTest extends TestCase
{
    use DatabaseMigrations;

    private OrderRepositoryContract $orderRepository;

    /**
     * @throws BindingResolutionException
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->orderRepository = $this->app->make(OrderRepositoryContract::class);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testInsertTest()
    {
        $order = json_decode('{"id":45,"payment_method":"GiftCard","shipping_method":"DHL","customer_id":13,"company_id":1,"type":"pending","billing_address_id":46,"shipping_address_id":13,"total":"56.07","created_at":"2021-05-06T10:00:24.000000Z","updated_at":"2021-05-06T10:00:24.000000Z","customer":{"id":13,"name":"KasandraKovacek","email":"lorena.okeefe@gmail.com","phone":null,"created_at":"2021-05-06T10:00:23.000000Z","updated_at":"2021-05-06T10:00:23.000000Z"},"billing_address":{"id":46,"name":"Dr.ScottyGoldner","phone":"678-712-2013","line_1":"48865MikePlain\nMacietown,SC85743-1935","line_2":"7752GradyMillsApt.263\nSouthGladyceport,ND12379","city":"Langworthfort","country":"Belarus","state":"Georgia","postcode":"14574","created_at":"2021-05-06T10:00:24.000000Z","updated_at":"2021-05-06T10:00:24.000000Z"},"shipping_address":{"id":13,"name":"DestinWildermanII","phone":"+18607092139","line_1":"3672BartonRowSuite489\nIvorybury,NY37147-4139","line_2":null,"city":"Wolffchester","country":"Montserrat","state":"Oklahoma","postcode":"28549-0286","created_at":"2021-05-06T10:00:23.000000Z","updated_at":"2021-05-06T10:00:23.000000Z"},"order_items":[{"id":259,"order_id":45,"product_id":20,"quantity":7,"subtotal":"13.23","created_at":"2021-05-06T10:00:24.000000Z","updated_at":"2021-05-06T10:00:24.000000Z","product":{"id":20,"title":"Kuhlman,DavisandBartonsaepequodanimi","description":null,"image":null,"sku":"567641583956038","price":"1.89","created_at":"2021-05-06T10:00:23.000000Z","updated_at":"2021-05-06T10:00:23.000000Z"}},{"id":260,"order_id":45,"product_id":29,"quantity":9,"subtotal":"35.55","created_at":"2021-05-06T10:00:24.000000Z","updated_at":"2021-05-06T10:00:24.000000Z","product":{"id":29,"title":"VolkmanLLCenimquisautem","description":null,"image":"https://via.placeholder.com/640x480.png/00bb99?text=distinctio","sku":"237454349807941","price":"3.95","created_at":"2021-05-06T10:00:23.000000Z","updated_at":"2021-05-06T10:00:23.000000Z"}},{"id":261,"order_id":45,"product_id":23,"quantity":1,"subtotal":"7.29","created_at":"2021-05-06T10:00:24.000000Z","updated_at":"2021-05-06T10:00:24.000000Z","product":{"id":23,"title":"Rice-Denesiksolutarationeinventore","description":"Quibusdamadquiaducimusquorepudiandae.Veritatisaliquamvelititaquesedaspernaturducimusautem.","image":"https://via.placeholder.com/640x480.png/00ee00?text=ratione","sku":"268718876461363","price":"7.29","created_at":"2021-05-06T10:00:23.000000Z","updated_at":"2021-05-06T10:00:23.000000Z"}}]}', true);

        $this->orderRepository->insert($order);

        $this->assertDatabaseHas('orders', [
            'id' => '45'
        ]);
        $this->assertDatabaseHas('addresses', [
            'id' => '46'
        ]);
        $this->assertDatabaseHas('products', [
            'id' => '20'
        ]);
    }
}
