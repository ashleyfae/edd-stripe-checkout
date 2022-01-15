<?php
/**
 * ApiServiceProvider.php
 *
 * @package   edd-stripe-checkout
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   GPL2+
 */

namespace EDD\StripeCheckout\ServiceProviders;

use EDD\StripeCheckout\Api;
use function EDD\StripeCheckout\app;

class ApiServiceProvider implements ServiceProvider
{

    public function register(): void
    {

    }

    public function boot(): void
    {
        add_action('rest_api_init', function () {
            $routes = [
                Api\v1\Cart::class,
            ];

            foreach ($routes as $route) {
                app()->make($route)->register();
            }
        });
    }
}
