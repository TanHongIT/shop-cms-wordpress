<div class="cart-area table-area pt-110 pb-95">

    <!-- Show product - cart -->
    <div class="container">
        <!-- Show message -->
        <?php do_action('woocommerce_before_cart'); ?>
        <?php if (!empty(WC()->cart->get_cart())) : ?>
            <form class="woocommerce-cart-form" action="<?php echo esc_url(wc_get_cart_url()); ?>" method="post">
                <?php do_action('woocommerce_before_cart_table'); ?>
                <div class="table-responsive">
                    <table class="table product-table text-center shop_table shop_table_responsive cart woocommerce-cart-form__contents" cellspacing="0">
                        <thead>
                            <tr>
                                <th class="table-remove"><?php esc_html_e('Remove', 'woocommerce'); ?></th>
                                <th class="table-image"><?php esc_html_e('Image', 'woocommerce'); ?></th>
                                <th class="table-p-name"><?php esc_html_e('Product', 'woocommerce'); ?></th>
                                <th class="table-p-price"><?php esc_html_e('Price', 'woocommerce'); ?></th>
                                <th class="table-p-qty"><?php esc_html_e('Quantity', 'woocommerce'); ?></th>
                                <th class="table-total"><?php esc_html_e('Subtotal', 'woocommerce'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php do_action('woocommerce_before_cart_contents'); ?>
                            <?php
                            foreach (WC()->cart->get_cart() as $cart_item_key => $cart_item) {
                                $_product   = apply_filters('woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key);
                                $product_id = apply_filters('woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key);

                                if ($_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters('woocommerce_cart_item_visible', true, $cart_item, $cart_item_key)) {
                                    $product_permalink = apply_filters('woocommerce_cart_item_permalink', $_product->is_visible() ? $_product->get_permalink($cart_item) : '', $cart_item, $cart_item_key);
                            ?>
                                    <tr class="woocommerce-cart-form__cart-item <?php echo esc_attr(apply_filters('woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key)); ?>">
                                        <td class="table-remove product-remove">
                                            <?php
                                            echo apply_filters( // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
                                                'woocommerce_cart_item_remove_link',
                                                sprintf(
                                                    '<a href="%s" class="remove" aria-label="%s" data-product_id="%s" data-product_sku="%s"><i class="fa fa-trash"></i></a>',
                                                    esc_url(wc_get_cart_remove_url($cart_item_key)),
                                                    esc_html__('Remove this item', 'woocommerce'),
                                                    esc_attr($product_id),
                                                    esc_attr($_product->get_sku())
                                                ),
                                                $cart_item_key
                                            );
                                            ?>
                                        </td>
                                        <td class="table-image product-thumbnail">
                                            <?php
                                            $thumbnail = apply_filters('woocommerce_cart_item_thumbnail', $_product->get_image(), $cart_item, $cart_item_key);

                                            if (!$product_permalink) {
                                                echo $thumbnail; // PHPCS: XSS ok.
                                            } else {
                                                printf('<a href="%s">%s</a>', esc_url($product_permalink), $thumbnail); // PHPCS: XSS ok.
                                            }
                                            ?>
                                        </td>
                                        <td class="table-p-name product-name" data-title="<?php esc_attr_e('Product', 'woocommerce'); ?>">
                                            <?php
                                            if (!$product_permalink) {
                                                echo wp_kses_post(apply_filters('woocommerce_cart_item_name', $_product->get_name(), $cart_item, $cart_item_key) . '&nbsp;');
                                            } else {
                                                echo wp_kses_post(apply_filters('woocommerce_cart_item_name', sprintf('<a href="%s">%s</a>', esc_url($product_permalink), $_product->get_name()), $cart_item, $cart_item_key));
                                            }

                                            do_action('woocommerce_after_cart_item_name', $cart_item, $cart_item_key);

                                            // Meta data.
                                            echo wc_get_formatted_cart_item_data($cart_item); // PHPCS: XSS ok.

                                            // Backorder notification.
                                            if ($_product->backorders_require_notification() && $_product->is_on_backorder($cart_item['quantity'])) {
                                                echo wp_kses_post(apply_filters('woocommerce_cart_item_backorder_notification', '<p class="backorder_notification">' . esc_html__('Available on backorder', 'woocommerce') . '</p>', $product_id));
                                            }
                                            ?>
                                        </td>
                                        <td class="table-p-price product-price" data-title="<?php esc_attr_e('Price', 'woocommerce'); ?>">
                                            <p><?php
                                                echo apply_filters('woocommerce_cart_item_price', WC()->cart->get_product_price($_product), $cart_item, $cart_item_key); // PHPCS: XSS ok. 
                                                ?>
                                            </p>
                                        </td>
                                        <td class="table-p-qty product-quantity" data-title="<?php esc_attr_e('Quantity', 'woocommerce'); ?>">
                                            <?php
                                            if ($_product->is_sold_individually()) {
                                                $product_quantity = sprintf('1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key);
                                            } else {
                                                $product_quantity = woocommerce_quantity_input(
                                                    array(
                                                        'input_name'   => "cart[{$cart_item_key}][qty]",
                                                        'input_value'  => $cart_item['quantity'],
                                                        'max_value'    => $_product->get_max_purchase_quantity(),
                                                        'min_value'    => '0',
                                                        'product_name' => $_product->get_name(),
                                                    ),
                                                    $_product,
                                                    false
                                                );
                                            }

                                            echo apply_filters('woocommerce_cart_item_quantity', $product_quantity, $cart_item_key, $cart_item); // PHPCS: XSS ok.
                                            ?>
                                        </td>
                                        <td class="table-total" data-title="<?php esc_attr_e('Subtotal', 'woocommerce'); ?>">
                                            <p><?php
                                                echo apply_filters('woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal($_product, $cart_item['quantity']), $cart_item, $cart_item_key); // PHPCS: XSS ok.
                                                ?></p>
                                        </td>
                                    </tr>
                            <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>

                <?php do_action('woocommerce_cart_contents'); ?>
                <div class="table-bottom-wrapper" class="actions">
                    <?php if (wc_coupons_enabled()) { ?>
                        <div class="table-coupon d-flex fix justify-content-start">
                            <input type="text" name="coupon_code" class="input-text" id="coupon_code" value="" placeholder="<?php esc_attr_e('Coupon code', 'woocommerce'); ?>">
                            <button class="button" type="submit" name="apply_coupon" value="<?php esc_attr_e('Apply coupon', 'woocommerce'); ?>"><?php esc_attr_e('Apply coupon', 'woocommerce'); ?></button>
                            <?php do_action('woocommerce_cart_coupon'); ?>
                        </div>
                    <?php } ?>

                    <div class="table-update d-flex justify-content-end">
                        <button type="submit" class="button" name="update_cart" value="<?php esc_attr_e('Update cart', 'woocommerce'); ?>"><?php esc_html_e('Update cart', 'woocommerce'); ?></button>
                    </div>

                    <?php do_action('woocommerce_cart_actions'); ?>

                    <?php wp_nonce_field('woocommerce-cart', 'woocommerce-cart-nonce'); ?>
                </div>
                <?php do_action('woocommerce_after_cart_contents'); ?>

                <?php do_action('woocommerce_after_cart_table'); ?>
            </form>
        <?php else : the_empty_cart_message();
        endif; ?>
    </div>

    <?php do_action('woocommerce_before_cart_collaterals'); ?>
    <!-- End product - cart -->

    <?php if (!empty(WC()->cart->get_cart())) : ?>
        <div class="container">
            <div class="table-total-wrapper d-flex justify-content-end pt-60">
                <div class="table-total-content">
                    <h2>Cart totals</h2>
                    <div class="table-total-amount">
                        <div class="single-total-content d-flex justify-content-between">
                            <span>Subtotal</span>
                            <span class="c-total-price"><?= WC()->cart->get_cart_subtotal() ?></span>
                        </div>
                        <!-- <div class="single-total-content d-flex justify-content-between">
                        <span>Shipping</span>
                        <span class="c-total-price"><span>Flat Rate:</span> $0.00</span>
                    </div>
                    <div class="single-total-content d-flex justify-content-end">
                        <a href="#">Calculate shipping</a>
                    </div> -->
                        <div class="single-total-content d-flex justify-content-between">
                            <span>Total</span>
                            <span class="c-total-price"><?= WC()->cart->get_cart_subtotal() ?></span>
                        </div>
                        <a href="<?= esc_url(wc_get_checkout_url()) ?>">Proceed to checkout</a>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php do_action('woocommerce_after_cart'); ?>
</div>