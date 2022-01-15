<?php
/**
 * CreateSessionFromCart.php
 *
 * @package   edd-stripe-checkout
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   GPL2+
 */

namespace EDD\StripeCheckout\Actions\Checkout;

use EDD\StripeCheckout\Actions\Products\GetOrCreatePrice;
use EDD\StripeCheckout\ValueObjects\CartItem;
use EDD\StripeCheckout\Exceptions;
use Stripe\Checkout\Session;
use Stripe\Customer;
use Stripe\StripeClient;
use Stripe\Exception;

class CreateSessionFromCart
{

    public function __construct(
        protected StripeClient $stripeClient,
        protected GetOrCreatePrice $priceManager,
        protected BuildCart $buildCart
    ) {

    }

    /**
     * @throws Exception\ApiErrorException|Exceptions\EmptyCartException
     */
    public function execute(): Session
    {
        return $this->stripeClient->checkout->sessions->create(
            $this->buildSessionFromItems()
        );
    }

    /**
     * @throws Exceptions\EmptyCartException|\Exception
     */
    public function buildSessionFromItems(): array
    {
        return [
            'mode'              => 'payment',
            'success_url'       => home_url(), // @todo
            'cancel_url'        => edd_get_checkout_uri(),
            'customer'          => $this->getOrCreateCustomerId(),
            'customer_update'   => [
                'address' => 'auto',
                'name'    => 'auto',
            ],
            'line_items'        => $this->makeLineItemsFromCart($this->buildCart->execute()),
            'tax_id_collection' => [
                'enabled' => edd_use_taxes(),
            ],
        ];
    }

    protected function getOrCreateCustomerId(): string
    {
        $customerId = edds_get_stripe_customer_id(get_current_user_id());

        if (! empty($customerId)) {
            return $customerId;
        }

        return $this->createCustomer(get_current_user_id())->id;
    }

    protected function createCustomer(int $userId): Customer
    {
        $customer = edd_get_customer_by('user_id', $userId);
        if (! $customer instanceof \EDD_Customer) {
            throw new \Exception('Failed to retrieve customer record for user #'.$userId.'.');
        }

        $customer = $this->stripeClient->customers->create([
            'email' => $customer->email,
            'name'  => trim($customer->name),
        ]);

        edd_update_customer_meta($customer->id, edd_stripe_get_customer_key(), sanitize_text_field($customer->id));

        return $customer;
    }

    /**
     * @param  CartItem[]  $cartItems
     *
     * @return array
     * @throws \Exception
     */
    public function makeLineItemsFromCart(array $cartItems): array
    {
        $items = [];
        foreach ($cartItems as $cartItem) {
            if (! $cartItem instanceof CartItem) {
                continue;
            }

            $items[] = array_filter([
                'price'               => $this->priceManager->getForCartItem($cartItem),
                'quantity'            => $cartItem->quantity,
                'dynamic_tax_rates'   => $this->getTaxRates(),
                'adjustable_quantity' => [
                    'enabled' => false,
                ]
            ]);
        }

        return $items;
    }

    public function getTaxRates(): array
    {
        return defined('EDD_STRIPE_CHECKOUT_TAX_RATES') && is_array(EDD_STRIPE_CHECKOUT_TAX_RATES)
            ? EDD_STRIPE_CHECKOUT_TAX_RATES
            : [];
    }

}
