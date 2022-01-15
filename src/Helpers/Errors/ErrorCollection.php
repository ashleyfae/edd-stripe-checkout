<?php
/**
 * ErrorCollection.php
 *
 * @package   edd-stripe-checkout
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   GPL2+
 */

namespace EDD\StripeCheckout\Helpers\Errors;

class ErrorCollection
{

    protected array $errors = [];

    public function hasError(string $key): bool
    {
        return array_key_exists($key, $this->errors);
    }

    public function getError(string $key): ?string
    {
        return $this->errors[$key] ?? null;
    }

    public function setError(string $key, string $message): void
    {
        $this->errors[$key] = $message;
    }

    public function hasErrors(): bool
    {
        return ! empty($this->errors);
    }

}
