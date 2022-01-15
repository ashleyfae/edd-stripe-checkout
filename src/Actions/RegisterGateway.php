<?php
/**
 * RegisterGateway.php
 *
 * Registers the payment gateway with EDD.
 *
 * @package   edd-stripe-checkout
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   GPL2+
 */

namespace EDD\StripeCheckout\Actions;

class RegisterGateway
{

    public function __invoke(array $gateways): array
    {
        $gateways['stripe_checkout'] = [
            'admin_label'    => 'Stripe Checkout',
            'checkout_label' => __('Credit Card', 'edd-stripe-checkout'),
            /*'supports'       => [
                'buy_now',
            ]*/
        ];

        return $gateways;
    }

}
