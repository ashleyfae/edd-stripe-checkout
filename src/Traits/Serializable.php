<?php
/**
 * Serializable.php
 *
 * @package   edd-stripe-checkout
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   GPL2+
 */

namespace EDD\StripeCheckout\Traits;

trait Serializable
{

    public function toArray(): array
    {
        $data = [];

        /*
         * get_object_vars() returns non-public properties when used within the class
         * so we're using a ReflectionClass to get the public properties only.
         */
        $object = new \ReflectionClass($this);
        foreach ($object->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
            if ($property instanceof \ReflectionProperty) {
                $data[$property->name] = $this->{$property->name} ?? null;
            }
        }

        return $data;
    }

    public function toJson(): string
    {
        return json_encode($this->toArray());
    }


}
