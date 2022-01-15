<?php
/**
 * LogIn.php
 *
 * @package   edd-stripe-checkout
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   GPL2+
 */

namespace EDD\StripeCheckout\Actions\Checkout;

use EDD\StripeCheckout\Helpers\Errors\ErrorCollection;

class LogIn
{
    protected ?string $email = null;
    protected ?string $password = null;

    public function __construct(
        protected ErrorCollection $errorCollection,
        protected HandleStripeCheckout $handleStripeCheckout
    ) {

    }

    public function __invoke(array $data): void
    {
        $this->email    = $data['email'] ?? null;
        $this->password = $data['password'] ?? null;

        if ($this->isValidLogIn()) {
            $this->processLogIn();
        }
    }

    protected function isValidLogIn(): bool
    {
        if (empty($this->email)) {
            $this->errorCollection->setError(
                'login_email',
                __('Please enter an email address.', 'edd-stripe-checkout')
            );
        } elseif (! email_exists($this->email)) {
            $this->errorCollection->setError(
                'login_email',
                __('No account with this email address.', 'edd-stripe-checkout')
            );
        }

        if (empty($this->password)) {
            $this->errorCollection->setError(
                'login_password',
                __('Please enter a password.', 'edd-stripe-checkout')
            );
        }

        return ! $this->errorCollection->hasErrors();
    }

    protected function processLogIn()
    {
        $user = get_user_by_email($this->email);
        if (! $user instanceof \WP_User) {
            $this->errorCollection->setError(
                'login_email',
                __('No account with this email address.', 'edd-stripe-checkout')
            );

            return;
        }

        $result = wp_signon([
            'user_login'    => $user->user_login,
            'user_password' => $this->password,
            'remember'      => true,
        ]);

        if (is_wp_error($result)) {
            $this->errorCollection->setError(
                'login_email',
                $result->get_error_message()
            );
        } elseif ($result instanceof \WP_User) {
            wp_set_current_user($result->ID);

            $this->handleStripeCheckout->execute();
        }
    }

}
