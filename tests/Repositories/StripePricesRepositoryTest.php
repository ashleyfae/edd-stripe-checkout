<?php
/**
 * StripePricesRepositoryTest.php
 *
 * @package   edd-stripe-checkout
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   GPL2+
 */

namespace EDD\StripeCheckout\Tests\Repositories;

use EDD\StripeCheckout\Database\Repositories\StripePricesRepository;
use EDD\StripeCheckout\Exceptions\ModelNotFoundException;
use EDD\StripeCheckout\Models\StripePrice;
use EDD\StripeCheckout\Tests\TestCase;
use function EDD\StripeCheckout\app;

/**
 * @coversDefaultClass \EDD\StripeCheckout\Database\Repositories\StripePricesRepository
 */
class StripePricesRepositoryTest extends TestCase
{
    protected StripePricesRepository $repository;

    public function set_up()
    {
        parent::set_up();

        $this->repository = app(StripePricesRepository::class);
    }

    /**
     * @covers \EDD\StripeCheckout\Database\Repositories\StripePricesRepository::getByProduct
     * @return void
     * @throws ModelNotFoundException
     */
    public function test_getting_price_that_doesnt_exist_throws_exception()
    {
        $this->expectException(ModelNotFoundException::class);

        $this->repository->getByProduct(1, 1, 100);
    }

    /**
     * @covers \EDD\StripeCheckout\Database\Repositories\StripePricesRepository::insert
     * @return void
     */
    public function test_inserting_price_returns_price_id()
    {
        $priceId = $this->repository->insert(1, 1, 100, 'stripe_123');

        $this->assertIsInt($priceId);
    }

    /**
     * @covers \EDD\StripeCheckout\Database\Repositories\StripePricesRepository::getByProduct
     * @return void
     * @throws ModelNotFoundException
     */
    public function test_getting_price_that_exists_returns_model()
    {
        $priceId = $this->repository->insert(5, 1, 100, 'stripe_123');
        $price   = $this->repository->getByProduct(5, 1, 100);

        $this->assertInstanceOf(StripePrice::class, $price);
        $this->assertSame($priceId, $price->id);
        $this->assertSame(5, $price->product_id);
        $this->assertSame(1, $price->price_id);
        $this->assertSame(100, $price->price);
        $this->assertSame('stripe_123', $price->stripe_price_id);
    }

}
