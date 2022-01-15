<?php
/**
 * ViewLoader.php
 *
 * @package   edd-stripe-checkout
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   GPL2+
 */

namespace EDD\StripeCheckout\Helpers;

use const EDD\StripeCheckout\EDD_STRIPE_CHECKOUT_FILE;

class ViewLoader
{

    public function load(string $view, array $data = []): void
    {
        if (! $this->viewExists($view)) {
            throw new \Exception("Invalid view {$view}");
        }

        extract($data);

        $viewLoader = $this;

        require $this->viewPath($view);
    }

    protected function viewExists(string $view): bool
    {
        return file_exists($this->viewPath($view));
    }

    protected function viewPath(string $view): string
    {
        return dirname(EDD_STRIPE_CHECKOUT_FILE).'/views/'.$view;
    }

}
