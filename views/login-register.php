<?php
/**
 * login-register.php
 *
 * @package   edd-stripe-checkout
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   GPL2+
 *
 * @var \EDD\StripeCheckout\Helpers\ViewLoader $viewLoader
 * @var string $intent
 * @var \EDD\StripeCheckout\Helpers\Errors\ErrorCollection $errors
 */
?>
<div
    id="register-heading"
    class="login-register-heading<?php echo $intent === 'register' ? ' display-block' : ' display-none'; ?>"
>
    <h2><?php esc_html_e('Register', 'edd-stripe-checkout'); ?></h2>

    <button type="button" class="register-login-toggle" data-id="register">
        <?php esc_html_e('Already have an account?', 'edd-stripe-checkout'); ?>
    </button>
</div>

<div
    id="login-heading"
    class="login-register-heading<?php echo $intent === 'login' ? ' display-block' : ' display-none'; ?>"
>
    <h2><?php esc_html_e('Log in', 'edd-stripe-checkout'); ?></h2>

    <button type="button" class="register-login-toggle" data-id="login">
        <?php esc_html_e('Don\'t have an account?', 'edd-stripe-checkout'); ?>
    </button>
</div>

<form
    id="register"
    class="<?php echo $intent === 'register' ? 'display-block' : 'display-none'; ?>"
    method="POST"
>
    <?php $viewLoader->load('email-password.php', ['prefix' => 'register', 'intent' => $intent, 'errors' => $errors]); ?>

    <input type="hidden" name="edd_action" value="stripe_checkout_register">
    <input type="hidden" name="intent" value="register">

    <div class="text-right mt-4">
        <button type="submit" class="button button--primary">
            <?php esc_html_e('Register & Checkout', 'edd-stripe-checkout'); ?>
        </button>
    </div>
</form>

<form
    id="login"
    class="<?php echo $intent === 'login' ? 'display-block' : 'display-none'; ?>"
    method="POST"
>
    <?php $viewLoader->load('email-password.php', ['prefix' => 'login', 'intent' => $intent, 'errors' => $errors]); ?>

    <input type="hidden" name="edd_action" value="stripe_checkout_login">
    <input type="hidden" name="intent" value="login">

    <div class="text-right mt-4">
        <button type="submit" class="button button--primary">
            <?php esc_html_e('Log In & Checkout', 'edd-stripe-checkout'); ?>
        </button>
    </div>
</form>
