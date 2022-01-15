<?php
/**
 * StripePricesRepository.php
 *
 * @package   edd-stripe-checkout
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   GPL2+
 */

namespace EDD\StripeCheckout\Database\Repositories;

use EDD\StripeCheckout\Database\Tables\StripePricesTable;
use EDD\StripeCheckout\Exceptions\ModelNotFoundException;
use EDD\StripeCheckout\Models\StripePrice;

class StripePricesRepository
{

    protected \wpdb $wpdb;

    public function __construct(protected StripePricesTable $table)
    {
        global $wpdb;

        $this->wpdb = $wpdb;
    }

    public function insert(int $product_id, ?int $price_id, int $price, string $stripe_price_id): int
    {
        $this->wpdb->insert(
            $this->table->tableName(),
            [
                'product_id'      => $product_id,
                'price_id'        => $price_id,
                'price'           => $price,
                'stripe_price_id' => $stripe_price_id
            ],
            [
                '%d',
                '%d',
                '%d',
                '%s',
            ]
        );

        return (int) $this->wpdb->insert_id;
    }

    /**
     * @throws ModelNotFoundException
     */
    public function getByProduct(int $product_id, ?int $price_id, int $price): StripePrice
    {
        $row = $this->wpdb->get_row($this->wpdb->prepare(
            "SELECT * FROM {$this->table->tableName()}
            WHERE product_id = %d
            AND price_id = %d
            AND price = %d",
            $product_id,
            $price_id,
            $price
        ), ARRAY_A);

        if (empty($row)) {
            throw new ModelNotFoundException();
        }

        return new StripePrice($row);
    }

}
