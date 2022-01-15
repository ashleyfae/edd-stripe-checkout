<?php
/**
 * TableRegistry.php
 *
 * @package   edd-stripe-checkout
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   GPL2+
 */

namespace EDD\StripeCheckout\Database;

use EDD\StripeCheckout\Database\Tables\Table;
use function EDD\StripeCheckout\app;

class TableRegistry
{

    protected array $tables = [
        Tables\StripePricesTable::class,
        Tables\CheckoutSessionsTable::class,
    ];

    /**
     * @return Table[]
     */
    public function getTables(): array
    {
        return array_map(function (string $table) {
            return app($table);
        }, $this->tables);
    }

}
