<?php
/**
 * Hooks.php
 *
 * Taken from GiveWP.
 *
 * @package   edd-stripe-checkout
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   GPL2+
 */

namespace EDD\StripeCheckout\Helpers;

use function EDD\StripeCheckout\app;

class Hooks
{

    public static function addAction(
        string $tag,
        string $class,
        string $method = '__invoke',
        int $priority = 10,
        int $acceptedArgs = 1
    ) {
        if (! method_exists($class, $method)) {
            throw new \InvalidArgumentException("The method {$method} does not exist on {$class}");
        }

        add_action(
            $tag,
            static function () use ($tag, $class, $method) {
                call_user_func_array([app($class), $method], func_get_args());
            },
            $priority,
            $acceptedArgs
        );
    }

    public static function addFilter(
        string $tag,
        string $class,
        string $method = '__invoke',
        int $priority = 10,
        int $acceptedArgs = 1
    ) {
        if (! method_exists($class, $method)) {
            throw new \InvalidArgumentException("The method {$method} does not exist on {$class}");
        }

        add_filter(
            $tag,
            static function () use ($tag, $class, $method) {
                return call_user_func_array([app($class), $method], func_get_args());
            },
            $priority,
            $acceptedArgs
        );
    }


}
