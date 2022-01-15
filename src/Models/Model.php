<?php
/**
 * Model.php
 *
 * @package   edd-stripe-checkout
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   GPL2+
 */

namespace EDD\StripeCheckout\Models;

use EDD\StripeCheckout\Traits\CastsAttributes;

abstract class Model
{
    use CastsAttributes;

    protected array $casts = [
        'id' => 'int',
    ];

    public function __construct(array $row = [])
    {
        foreach ($row as $property => $value) {
            if (property_exists($this, $property)) {
                $this->{$property} = $this->castAttribute($property, $value);
            }
        }
    }

}
