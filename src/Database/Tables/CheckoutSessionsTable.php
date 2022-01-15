<?php
/**
 * CheckoutSessionsTable.php
 *
 * @package   edd-stripe-checkout
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   GPL2+
 */

namespace EDD\StripeCheckout\Database\Tables;

class CheckoutSessionsTable extends Table
{

    public function tableName(): string
    {
        return $this->wpdb->prefix.'edd_stripe_checkout_sessions';
    }

    public function tableVersion(): string
    {
        return '0.1';
    }

    public function createSql(): string
    {
        return "
id bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
session_id varchar(255) NOT NULL,
order_id bigint(20) UNSIGNED DEFAULT NULL,
cart longtext NOT NULL,
created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
PRIMARY KEY (id),
UNIQUE KEY session_id (session_id(191))
        ";
    }
}
