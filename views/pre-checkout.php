<?php
/**
 * cart.php
 *
 * @package   edd-stripe-checkout
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   GPL2+
 *
 * @var \EDD\StripeCheckout\Helpers\ViewLoader $viewLoader
 * @var \EDD\StripeCheckout\ValueObjects\CartItem[] $cart
 * @var string $intent
 * @var \EDD\StripeCheckout\Helpers\Errors\ErrorCollection $errors
 */

use const EDD\StripeCheckout\EDD_STRIPE_CHECKOUT_FILE;

?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>">
    <title><?php esc_html_e('Cart', 'edd-stripe-checkout'); ?></title>

    <link
        rel="stylesheet"
        type="text/css"
        media="all"
        href="<?php echo esc_url(plugins_url('assets/dist/css/index.css', EDD_STRIPE_CHECKOUT_FILE)); ?>"
    >
</head>
<body>
<div id="app">
    <nav id="checkout-steps">
        <ul>
            <li class="step--previous">
                <a href="<?php echo esc_url(home_url()); ?>">
                    <?php esc_html_e('Shop', 'edd-stripe-checkout'); ?>
                </a>
            </li>

            <li class="step--current">
                <?php
                echo is_user_logged_in()
                    ? esc_html__('Review', 'edd-stripe-checkout')
                    : esc_html__('Register', 'edd-stripe-checkout');
                ?>
            </li>
            <li class="step--future">
                <?php esc_html_e('Pay', 'edd-stripe-checkout'); ?>
            </li>
        </ul>
    </nav>
    <main>
        <?php $viewLoader->load('cart.php', ['cart' => $cart]); ?>

        <?php if (is_user_logged_in()) : ?>
            <form method="POST">
                <input type="hidden" name="edd_action" value="handle_stripe_checkout">

                <div class="text-right mt-4">
                    <button type="submit" class="button button--primary">
                        <?php esc_html_e('Checkout', 'edd-stripe-checkout'); ?>
                    </button>
                </div>
            </form>

        <?php else : ?>
            <?php $viewLoader->load('login-register.php', ['intent' => $intent, 'errors' => $errors]); ?>
        <?php endif; ?>
    </main>
</div>

<script type="text/javascript" src="<?php echo esc_url(plugins_url('assets/dist/js/index.js',
    EDD_STRIPE_CHECKOUT_FILE)); ?>"></script>
</body>
</html>
