<?php
/**
 * CheckoutSession.php
 *
 * @package   edd-stripe-checkout
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   GPL2+
 */

namespace EDD\StripeCheckout\Models;

class CheckoutSession extends Model
{

    public int $id;
    public string $session_id;
    public ?int $order_id = null;
    public array $cart;
    public string $created_at;

    protected array $casts = [
        'id'         => 'int',
        'session_id' => 'string',
        'order_id'   => 'int',
        'cart'       => 'array',
        'created_at' => 'string',
    ];

}
