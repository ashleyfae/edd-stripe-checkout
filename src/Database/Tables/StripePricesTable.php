<?php
/**
 * StripePricesTable.php
 *
 * @package   edd-stripe-checkout
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   GPL2+
 */

namespace EDD\StripeCheckout\Database\Tables;

class StripePricesTable extends Table
{

    public function tableName(): string
    {
        return $this->wpdb->prefix.'edd_stripe_prices';
    }

    public function tableVersion(): string
    {
        return '0.1';
    }

    public function createSql(): string
    {
        return "
id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
product_id bigint(20) UNSIGNED NOT NULL,
price_id bigint(20) UNSIGNED DEFAULT NULL,
price bigint(20) UNSIGNED NOT NULL,
stripe_price_id varchar(255) NOT NULL,
created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (id),
UNIQUE KEY product_id_price_id_price (product_id, price_id, price)
        ";
    }
}
