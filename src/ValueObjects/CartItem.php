<?php
/**
 * CartItem.php
 *
 * @package   edd-stripe-checkout
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   GPL2+
 */

namespace EDD\StripeCheckout\ValueObjects;

use EDD\Currency\Currency;
use EDD\Currency\Money_Formatter;
use EDD\StripeCheckout\Helpers\MoneyFormatter;
use EDD\StripeCheckout\Traits\Serializable;

class CartItem
{
    use Serializable;

    public \EDD_Download $product;
    public int $product_id;
    public ?int $price_id = null;
    public int $quantity = 1;

    /**
     * License key, in the event we're renewing or upgrading one.
     *
     * @var string|null
     */
    public ?string $license_key = null;

    public bool $is_renewal = false;
    public bool $is_upgrade = false;
    public float $discount_amount = 0.00;

    /**
     * Creates a new instance of the class from EDD cart details.
     *
     * @see \EDD_Cart::get_contents_details()
     *
     * @param  array  $data
     *
     * @return static
     */
    public static function fromCartDetailsArray(array $data): static
    {
        if (empty($data['id'])) {
            throw new \InvalidArgumentException('Missing required id argument.');
        }

        $item              = new static;
        $item->product     = new \EDD_Download($data['id']);
        $item->product_id  = $item->product->ID;
        $item->quantity    = $data['quantity'] ?? 1;
        $item->price_id    = $data['item_number']['options']['price_id'] ?? null;
        $item->license_key = $data['item_number']['options']['license_key'] ?? null;
        $item->is_renewal  = $data['item_number']['options']['is_renewal'] ?? false;

        if ($item->is_upgrade || $item->is_renewal) {
            $item->discount_amount = (float) ($data['discount'] ?? 0.00);
        }

        return $item;
    }

    /**
     * Creates a new instance of the class from the array. Designed to be called from
     * data saved via `toArray()`.
     *
     * @param  array  $data
     *
     * @return static
     */
    public static function fromArray(array $data): static
    {
        if (empty($data['product_id'])) {
            throw new \InvalidArgumentException('Missing required product_id argument.');
        }

        $item          = new static;
        $item->product = new \EDD_Download($data['product_id']);

        $keys = ['product_id', 'price_id', 'quantity', 'license_key', 'is_renewal', 'is_upgrade', 'discount_amount'];
        foreach ($keys as $key) {
            if (array_key_exists($key, $data)) {
                $item->{$key} = $data;
            }
        }

        return $item;
    }

    public function toArray(): array
    {
        $properties = get_object_vars($this);
        unset($properties['product']);

        return $properties;
    }

    public function hasThumbnail(): bool
    {
        return current_theme_supports('post-thumbnails') && has_post_thumbnail($this->product->ID);
    }

    public function getThumbnail(array $size = [50, 50]): string
    {
        return get_the_post_thumbnail($this->product->ID, $size);
    }

    public function getName(): string
    {
        $name = $this->product->get_name();

        if ($this->product->has_variable_prices() && ! is_null($this->price_id)) {
            $name .= ' - '.edd_get_price_option_name($this->product->ID, $this->price_id);
        }

        return $name;
    }

    public function getUnitPrice(): float
    {
        $price = $this->product->has_variable_prices() && ! is_null($this->price_id)
            ? edd_get_price_option_amount($this->product->ID, $this->price_id)
            : $this->product->get_price();

        $formatter = new Money_Formatter(
            $price,
            new Currency(edd_get_currency())
        );

        return (float) $formatter->format_for_display()->amount;
    }

    public function getTotalPrice(): float
    {
        $formatter = new Money_Formatter(
            $this->getUnitPrice() - $this->discount_amount,
            new Currency(edd_get_currency())
        );

        return (float) $formatter
            ->format_for_display()
            ->amount;
    }

    public function getZeroDecimalTotal(): int
    {
        return (new MoneyFormatter($this->getTotalPrice(), edd_get_currency()))->toZeroDecimal();
    }

}
