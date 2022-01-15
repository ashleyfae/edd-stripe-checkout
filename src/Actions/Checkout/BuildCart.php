<?php
/**
 * BuildCart.php
 *
 * @package   edd-stripe-checkout
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   GPL2+
 */

namespace EDD\StripeCheckout\Actions\Checkout;

use EDD\StripeCheckout\Exceptions\EmptyCartException;
use EDD\StripeCheckout\ValueObjects\CartItem;

class BuildCart
{

    protected \EDD_Cart $cart;

    public function __construct()
    {
        $this->cart = EDD()->cart;
    }

    /**
     * @return CartItem[]
     * @throws EmptyCartException
     */
    public function execute(): array
    {
        if ($this->cart->is_empty()) {
            throw new EmptyCartException();
        }

        $items = [];
        foreach ($this->cart->get_contents_details() as $key => $item) {
            try {
                $items[$key] = CartItem::fromCartDetailsArray($item);
            } catch (\InvalidArgumentException $e) {

            }
        }

        return $items;
    }

}
