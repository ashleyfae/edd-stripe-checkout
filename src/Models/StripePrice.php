<?php
/**
 * StripePrice.php
 *
 * @package   edd-stripe-checkout
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   GPL2+
 */

namespace EDD\StripeCheckout\Models;

class StripePrice extends Model
{

    public int $id;
    public int $product_id;
    public ?int $price_id = null;
    public int $price;
    public string $stripe_price_id;
    public string $created_at;

    protected array $casts = [
        'id'              => 'int',
        'product_id'      => 'int',
        'price_id'        => 'int',
        'price'           => 'int',
        'stripe_price_id' => 'string',
        'created_at'      => 'string',
    ];

}
