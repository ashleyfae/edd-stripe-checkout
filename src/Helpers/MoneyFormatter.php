<?php
/**
 * MoneyFormatter.php
 *
 * @package   edd-stripe-checkout
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   GPL2+
 */

namespace EDD\StripeCheckout\Helpers;

use EDD\Currency\Currency;

class MoneyFormatter
{
    public Currency $currency;

    public function __construct(public float $amount, string $currencyCode)
    {
        $this->currency = new Currency($currencyCode);
    }

    public function toZeroDecimal(): int
    {
        if ($this->currency->number_decimals === 0) {
            return (int) $this->amount;
        } else {
            return (int) round($this->amount * 100);
        }
    }

}
