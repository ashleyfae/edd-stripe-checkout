<?php
/**
 * Plugin.php
 *
 * @package   edd-stripe-checkout
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   GPL2+
 */

namespace EDD\StripeCheckout;

use Ashleyfae\LaravelContainer\Container;
use EDD\StripeCheckout\ServiceProviders;

/**
 * @method mixed make(string $abstract, array $parameters = [])
 * @method void singleton(string $abstract, \Closure|string|null $concrete = null)
 */
class Plugin
{
    private Container $container;

    private array $serviceProviders = [
        ServiceProviders\AppServiceProvider::class,
        ServiceProviders\DatabaseServiceProvider::class,
        ServiceProviders\ApiServiceProvider::class,
    ];

    private bool $serviceProvidersLoaded = false;

    public function __construct()
    {
        $this->container = new Container;
    }

    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->container, $name], $arguments);
    }

    public function boot(): void
    {
        $this->loadServiceProviders();
    }

    private function loadServiceProviders(): void
    {
        if ($this->serviceProvidersLoaded) {
            return;
        }

        $providers = [];
        foreach ($this->serviceProviders as $serviceProvider) {
            if (! in_array(ServiceProviders\ServiceProvider::class, class_implements($serviceProvider), true)) {
                throw new \InvalidArgumentException(sprintf(
                    'The %s class must implement the %s interface.',
                    $serviceProvider,
                    ServiceProviders\ServiceProvider::class
                ));
            }

            $serviceProvider = new $serviceProvider;
            $serviceProvider->register();
            $providers[] = $serviceProvider;
        }

        foreach ($providers as $serviceProvider) {
            $serviceProvider->boot();
        }

        $this->serviceProvidersLoaded = true;
    }

}
