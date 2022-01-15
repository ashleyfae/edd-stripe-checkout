<?php
/**
 * RestRoute.php
 *
 * @package   edd-stripe-checkout
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   GPL2+
 */

namespace EDD\StripeCheckout\Api;

interface RestRoute
{

    const NAMESPACE = 'edd-stripe-checkout';

    /**
     * Register the route with WordPress using the `register_rest_route` function.
     *
     * @see register_rest_route()
     *
     * @since 1.0
     *
     * @return void
     */
    public function register(): void;

}
