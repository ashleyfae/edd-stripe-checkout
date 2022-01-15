<?php
/**
 * AppServiceProvider.php
 *
 * @package   edd-stripe-checkout
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   GPL2+
 */

namespace EDD\StripeCheckout\ServiceProviders;

use EDD\StripeCheckout\Actions\Checkout\HandleStripeCheckout;
use EDD\StripeCheckout\Actions\Checkout\LogIn;
use EDD\StripeCheckout\Actions\HandlePreCheckout;
use EDD\StripeCheckout\Actions\RegisterGateway;
use EDD\StripeCheckout\Helpers\Errors\ErrorCollection;
use EDD\StripeCheckout\Helpers\Hooks;
use Stripe\StripeClient;
use function EDD\StripeCheckout\app;

class AppServiceProvider implements ServiceProvider
{

    public function register(): void
    {
        app()->singleton(StripeClient::class, function () {
            $secret_key = edd_get_option((edd_is_test_mode() ? 'test' : 'live').'_secret_key');

            return $secret_key ? new StripeClient($secret_key) : new StripeClient();
        });

        app()->singleton(ErrorCollection::class);
    }

    public function boot(): void
    {
        Hooks::addFilter('edd_payment_gateways', RegisterGateway::class);
        Hooks::addAction('template_redirect', HandlePreCheckout::class);

        // Checkout
        Hooks::addAction('edd_handle_stripe_checkout', HandleStripeCheckout::class, 'execute');
        Hooks::addAction('edd_stripe_checkout_login', LogIn::class);
    }
}
