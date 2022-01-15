<?php
/**
 * HandlePreCheckout.php
 *
 * @package   edd-stripe-checkout
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   GPL2+
 */

namespace EDD\StripeCheckout\Actions;

use EDD\StripeCheckout\Actions\Checkout\BuildCart;
use EDD\StripeCheckout\Helpers\Errors\ErrorCollection;
use EDD\StripeCheckout\Helpers\ViewLoader;

class HandlePreCheckout
{

    public function __construct(
        protected ViewLoader $viewLoader,
        protected BuildCart $buildCart,
        protected ErrorCollection $errorCollection
    ) {

    }

    public function __invoke()
    {
        if (! $this->shouldOverrideCheckout()) {
            return;
        }

        $this->viewLoader->load('pre-checkout.php', [
            'cart'   => $this->buildCart->execute(),
            'intent' => $this->getIntent(),
            'errors' => $this->errorCollection,
        ]);
        exit;
    }

    protected function shouldOverrideCheckout(): bool
    {
        global $post;

        if (! $post instanceof \WP_Post) {
            return false;
        }

        // Bail if Stripe Checkout gateway isn't enabled.
        if (! edd_is_gateway_active('stripe_checkout')) {
            return false;
        }

        // Return true if we're on the checkout page right now and have a cart.
        return edd_is_checkout() && ! EDD()->cart->is_empty();
    }

    protected function getIntent(): string
    {
        $intent = $_REQUEST['intent'] ?? 'register';

        return in_array($intent, ['login', 'register'], true)
            ? $intent
            : 'register';
    }

}
