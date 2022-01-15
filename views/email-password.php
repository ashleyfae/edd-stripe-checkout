<?php
/**
 * email-password.php
 *
 * @package   edd-stripe-checkout
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   GPL2+
 *
 * @var string $prefix
 * @var string $intent
 * @var \EDD\StripeCheckout\Helpers\Errors\ErrorCollection $errors
 */
?>
<div class="grid">
    <div class="field">
        <label for="<?php echo esc_attr($prefix); ?>-email">
            <?php esc_html_e('Email address:', 'edd-stripe-checkout'); ?>
        </label>
        <input
            type="email"
            id="<?php echo esc_attr($prefix); ?>-email"
            name="email"
            value="<?php echo esc_attr($_POST['email'] ?? ''); ?>"
            required
            <?php echo $intent === $prefix ? 'autofocus' : ''; ?>
        >

        <?php if ($errors->hasError($prefix.'_email')) : ?>
            <div class="error">
                <?php echo wp_kses_post($errors->getError($prefix.'_email')); ?>
            </div>
        <?php endif; ?>
    </div>

    <div class="field">
        <label for="<?php echo esc_attr($prefix); ?>-password">
            <?php esc_html_e('Password:', 'edd-stripe-checkout'); ?>
        </label>
        <input
            type="password"
            id="<?php echo esc_attr($prefix); ?>-password"
            name="password"
            required
        >
    </div>
</div>
