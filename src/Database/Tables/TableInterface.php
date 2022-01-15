<?php
/**
 * TableInterface.php
 *
 * @package   edd-stripe-checkout
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   GPL2+
 */

namespace EDD\StripeCheckout\Database\Tables;

interface TableInterface
{

    public function tableName(): string;

    public function tableVersion(): string;

    public function createSql(): string;

}
