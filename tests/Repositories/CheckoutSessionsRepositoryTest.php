<?php
/**
 * CheckoutSessionsRepositoryTest.php
 *
 * @package   edd-stripe-checkout
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   GPL2+
 */

namespace EDD\StripeCheckout\Tests\Repositories;

use EDD\StripeCheckout\Database\Repositories\CheckoutSessionsRepository;
use EDD\StripeCheckout\Models\CheckoutSession;
use EDD\StripeCheckout\Tests\TestCase;
use function EDD\StripeCheckout\app;

/**
 * @coversDefaultClass \EDD\StripeCheckout\Database\Repositories\CheckoutSessionsRepository
 */
class CheckoutSessionsRepositoryTest extends TestCase
{
    protected CheckoutSessionsRepository $repository;

    public function set_up()
    {
        parent::set_up();

        $this->repository = app(CheckoutSessionsRepository::class);
    }

    /**
     * @covers \EDD\StripeCheckout\Database\Repositories\CheckoutSessionsRepository::insert
     * @return void
     */
    public function test_inserting_session_returns_id()
    {
        $sessionId = $this->repository->insert(
            'stripe_session_123',
            []
        );

        $this->assertIsInt($sessionId);
    }

    /**
     * @covers \EDD\StripeCheckout\Database\Repositories\CheckoutSessionsRepository::getBySessionId
     * @return void
     */
    public function test_getting_session_by_session_id_returns_session()
    {
        $sessionId = $this->repository->insert(
            'stripe_session_123456',
            []
        );

        $session = $this->repository->getBySessionId('stripe_session_123456');

        $this->assertInstanceOf(CheckoutSession::class, $session);
        $this->assertSame($sessionId, $session->id);
        $this->assertNull($session->order_id);
        $this->assertSame('stripe_session_123456', $session->session_id);
    }

    public function test_updating_session_order_sets_order_id()
    {
        $this->repository->insert(
            'stripe_session_123456',
            []
        );

        $session = $this->repository->getBySessionId('stripe_session_123456');
        $this->assertNull($session->order_id);

        $this->repository->setOrderIdForSession($session->session_id, 123);

        $session = $this->repository->getBySessionId('stripe_session_123456');
        $this->assertSame(123, $session->order_id);
    }

}
