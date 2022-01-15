<?php
/**
 * CastsAttributes.php
 *
 * @package   edd-stripe-checkout
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   GPL2+
 */

namespace EDD\StripeCheckout\Traits;

trait CastsAttributes
{

    /**
     * Casts a property to its designated type.
     *
     * @param  string  $propertyName
     * @param  mixed  $value
     *
     * @return bool|float|int|mixed|string|null
     */
    protected function castAttribute(string $propertyName, mixed $value): mixed
    {
        if (! array_key_exists($propertyName, $this->casts)) {
            return $value;
        }

        // Let null be null.
        if (is_null($value)) {
            return null;
        }

        return match ($this->casts[$propertyName]) {
            'array' => json_decode($value, true),
            'bool' => (bool) $value,
            'float' => (float) $value,
            'int' => (int) $value,
            'string' => (string) $value,
            default => $value,
        };
    }

}
