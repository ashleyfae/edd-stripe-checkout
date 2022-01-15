<?php
/**
 * Cart.php
 *
 * @package   edd-stripe-checkout
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   GPL2+
 */

namespace EDD\StripeCheckout\Api\v1;

use EDD\StripeCheckout\Api\RestRoute;

class Cart implements RestRoute
{
    protected \EDD_Cart $cart;

    public function __construct()
    {
        $this->cart = EDD()->cart;
    }

    public function register(): void
    {
        register_rest_route(
            self::NAMESPACE.'/v1',
            'cart/(?P<item_id>\d+)',
            [
                [
                    'methods'             => \WP_REST_Server::DELETABLE,
                    'callback'            => [$this, 'removeItem'],
                    'permission_callback' => '__return_true',
                    'args'                => [
                        'item_id' => [
                            'required'          => true,
                            'validate_callback' => function ($param, $request, $key) {
                                return array_key_exists($param, $this->cart->get_contents_details());
                            },
                            'sanitize_callback' => 'absint',
                        ]
                    ]
                ]
            ]
        );
    }

    public function removeItem(\WP_REST_Request $request): \WP_REST_Response
    {
        $this->cart->remove($request->get_param('item_id'));

        return new \WP_REST_Response([
            'cart' => $this->cart->get_contents(),
        ]);
    }
}
