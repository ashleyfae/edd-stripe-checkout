<?php
/**
 * HandleStripeCheckout.php
 *
 * @package   edd-stripe-checkout
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   GPL2+
 */

namespace EDD\StripeCheckout\Actions\Checkout;

use EDD\StripeCheckout\Database\Repositories\CheckoutSessionsRepository;
use EDD\StripeCheckout\ValueObjects\CartItem;

class HandleStripeCheckout
{

    public function __construct(
        protected CreateSessionFromCart $createSession,
        protected BuildCart $buildCart,
        protected CheckoutSessionsRepository $checkoutSessionsRepository
    ) {

    }

    public function execute()
    {
        $this->validateCheckout();

        $stripeSession = $this->createSession->execute();

        $this->checkoutSessionsRepository->insert(
            $stripeSession->id,
            $this->buildCartForStorage(),
        );

        wp_redirect(
            esc_url_raw($stripeSession->url),
            303
        );
    }

    protected function validateCheckout(): void
    {
        try {
            if (! is_user_logged_in()) {
                throw new \Exception(__('You must be logged in to complete your purchase.', 'edd-stripe-checkout'));
            }
        } catch (\Exception $e) {
            // @todo can we do better?
            wp_die($e->getMessage());
        }
    }

    protected function buildCartForStorage(): array
    {
        return array_map(function (CartItem $cartItem) {
            return $cartItem->toArray();
        }, $this->buildCart->execute());
    }

}
