<?php
/**
 * ServiceProvider.php
 *
 * @package   edd-stripe-checkout
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   GPL2+
 */

namespace EDD\StripeCheckout\ServiceProviders;

interface ServiceProvider
{

    /**
     * Registers the service provider within the application.
     *
     * @since 1.0
     *
     * @return void
     */

    public function register(): void;

    /**
     * Bootstraps the service after all the services have been registered.
     * All dependencies will be available at this point.
     *
     * @since 1.0
     *
     * @return void
     */

    public function boot(): void;

}
