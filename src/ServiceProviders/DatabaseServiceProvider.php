<?php
/**
 * DatabaseServiceProvider.php
 *
 * @package   edd-stripe-checkout
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   GPL2+
 */

namespace EDD\StripeCheckout\ServiceProviders;

use EDD\StripeCheckout\Database;
use function EDD\StripeCheckout\app;

class DatabaseServiceProvider implements ServiceProvider
{
    protected array $tables = [
        Database\Tables\StripePricesTable::class,
    ];

    public function register(): void
    {

    }

    public function boot(): void
    {
        foreach (app(Database\TableRegistry::class)->getTables() as $table) {
            /** @var \EDD\StripeCheckout\Database\Tables\Table $table */

            if ($table->needsUpdate()) {
                $table->createOrUpdateTable();
            }
        }
    }
}
