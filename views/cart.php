<?php
/**
 * cart.php
 *
 * @package   edd-stripe-checkout
 * @copyright Copyright (c) 2022, Ashley Gibson
 * @license   GPL2+
 *
 * @var \EDD\StripeCheckout\ValueObjects\CartItem[] $cart
 */
?>
<h2><?php esc_html_e('Your cart', 'edd-stripe-checkout'); ?></h2>
<div id="cart">
    <?php foreach ($cart as $key => $item): ?>
        <div class="cart-item" data-id="<?php echo esc_attr($key); ?>">
            <div class="cart-item--name">
                <div><?php echo esc_html($item->getName()); ?></div>
                <?php if ($item->is_renewal) : ?>
                    <div class="cart-item--renewal">
                        <?php echo esc_html(sprintf(__('Renewing: %s', 'edd-stripe-checkout'), $item->license_key)); ?>
                    </div>
                <?php endif; ?>
                <div>
                    <button
                        type="button"
                        class="cart-item--remove"
                    ><?php esc_html_e('Remove', 'edd-stripe-checkout'); ?></button>
                </div>
            </div>

            <div class="cart-item--price">
                <?php
                if ($item->discount_amount > 0.00) {
                    ?>
                    <span class="cart-item--price-original">
                        <?php echo esc_html(edd_display_amount($item->getUnitPrice(), edd_get_currency())); ?>
                    </span>
                    <span class="cart-item--price-discounted">
                        <?php echo esc_html(edd_display_amount($item->getTotalPrice(), edd_get_currency())); ?>
                    </span>
                    <?php
                } else {
                    echo esc_html(edd_display_amount($item->getUnitPrice(), edd_get_currency()));
                }
                ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>
