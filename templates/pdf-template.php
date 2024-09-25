<?php

if (!defined('ABSPATH')) {
    exit;
}

/*
Variables available:
- $data['code']
- $data['product_id']
- $data['receiver_name']
- $data['expiry_date']
*/

// Get product name.
$product = wc_get_product($data['product_id']);
$product_name = $product ? $product->get_name() : __('Unknown Product', 'woocommerce-gift-coupons');

?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
    <head>
        <meta charset="<?php bloginfo('charset'); ?>">
        <title><?php _e('Gift Coupon', 'woocommerce-gift-coupons'); ?></title>
        <style>
            /* Add your custom styles here. */
        </style>
    </head>
    <body>
        <h1><?php _e('Gift Coupon', 'woocommerce-gift-coupons'); ?></h1>
        <p><?php echo sprintf(__('Dear %s,', 'woocommerce-gift-coupons'), $data['receiver_name']); ?></p>
        <p><?php echo sprintf(__('You have received a gift coupon for %s.', 'woocommerce-gift-coupons'), $product_name); ?></p>
        <p><?php echo sprintf(__('Coupon Code: %s', 'woocommerce-gift-coupons'), $data['code']); ?></p>
        <p><?php echo sprintf(__('Expiry Date: %s', 'woocommerce-gift-coupons'), $data['expiry_date']); ?></p>
    </body>
</html>