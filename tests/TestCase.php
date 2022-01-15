<?php
/**
 * TestCase.php
 *
 * @package   edd-stripe-checkout
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   GPL2+
 */

namespace EDD\StripeCheckout\Tests;

abstract class TestCase extends \WP_UnitTestCase
{
    public function set_up()
    {
        wp_set_current_user(0);
    }

    public function tear_down()
    {
        /** @var \EDD\StripeCheckout\Database\TableRegistry $tableRegistry */
        $tableRegistry = \EDD\StripeCheckout\app(\EDD\StripeCheckout\Database\TableRegistry::class);
        foreach ($tableRegistry->getTables() as $table) {
            $table->truncate();
        }
    }
}
