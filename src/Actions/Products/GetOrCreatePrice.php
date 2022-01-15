<?php
/**
 * GetOrCreatePrice.php
 *
 * @package   edd-stripe-checkout
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   GPL2+
 */

namespace EDD\StripeCheckout\Actions\Products;

use EDD\StripeCheckout\Database\Repositories\StripePricesRepository;
use EDD\StripeCheckout\Exceptions\ModelNotFoundException;
use EDD\StripeCheckout\ValueObjects\CartItem;
use Stripe\Exception\ApiErrorException;
use Stripe\Price;
use Stripe\StripeClient;

class GetOrCreatePrice
{

    public function __construct(
        protected StripeClient $stripeClient,
        protected StripePricesRepository $pricesRepository
    ) {

    }

    public function getForCartItem(CartItem $cartItem): string
    {
        try {
            return $this->pricesRepository->getByProduct(
                $cartItem->product->ID,
                $cartItem->price_id,
                $cartItem->getZeroDecimalTotal()
            )->stripe_price_id;
        } catch (ModelNotFoundException $e) {
            return $this->createStripePrice(
                $cartItem->product->ID,
                $cartItem->price_id,
                $cartItem->getZeroDecimalTotal()
            )->id;
        }
    }

    public function createStripePrice(int $productId, ?int $priceId, int $price): Price
    {
        $stripePrice = $this->createPriceForProduct(
            $this->getOrCreateProduct($productId),
            $price
        );

        $this->pricesRepository->insert(
            $productId,
            $priceId,
            $price,
            sanitize_text_field($stripePrice->id)
        );

        return $stripePrice;
    }

    /**
     * @return string ID of the EDD product.
     * @throws ApiErrorException
     */
    public function getOrCreateProduct(int $productId): string
    {
        $stripeProductId = get_post_meta($productId, '_edd_stripe_product', true);

        if (! empty($stripeProductId)) {
            return $stripeProductId;
        }

        $product = new \EDD_Download($productId);
        if (! $product->ID) {
            throw new \Exception('Failed to retrieve product #'.$productId);
        }

        return $this->stripeClient->products->create([
            'name' => $product->get_name(),
        ])->id;
    }

    public function createPriceForProduct(string $productId, int $price): Price
    {
        return $this->stripeClient->prices->create([
            'currency'    => edd_get_currency(),
            'product'     => $productId,
            'unit_amount' => $price,
        ]);
    }

}
