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
            @page {
                size: A4;
                margin: 0;
            }

            body {
                margin: 0;
                padding: 0;
                width: 100%;
                height: 100%;
                background-image: url('<?php echo WGC_PLUGIN_URL . 'templates/bg.jpg'; ?>');
                background-size: cover;
                background-position: center;
                font-family: Arial, sans-serif;
                color: #000;
                position: relative;
            }

            .overlay {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background-color: rgba(255, 255, 255, 0.8); /* Transparent overlay for readability */
                display: flex;
                justify-content: center;
                align-items: center;
                padding: 40mm; /* Increased padding for more spacing */
            }

            .coupon-content {
                text-align: center;
                padding: 20mm;
                border: 2px solid #000;
                background-color: #fff;
                box-shadow: 0 4mm 6mm rgba(0, 0, 0, 0.1);
            }

            h1 {
                font-size: 36px;
                font-weight: bold;
                margin-bottom: 20px;
            }

            p {
                font-size: 20px;
                margin-bottom: 10px;
            }

            .coupon-code {
                font-size: 28px;
                font-weight: bold;
                margin: 30px 0; /* Added more space above and below the coupon code */
            }

            .expiry-date {
                font-size: 18px;
                margin-top: 20px;
            }

            .footer {
                margin-top: 40px;
                font-size: 16px;
            }
        </style>
    </head>
    <body>
        <div class="coupon-container">
            <h1><?php _e('Gift Coupon', 'woocommerce-gift-coupons'); ?></h1>
            <p><?php echo sprintf(__('Gift recipient: %s', 'woocommerce-gift-coupons'), $data['receiver_name']); ?></p>
            <p><?php echo sprintf(__('You have received a gift coupon: %s', 'woocommerce-gift-coupons'), $product_name); ?></p>
            <div class="coupon-code"><?php echo sprintf(__('Coupon code: %s', 'woocommerce-gift-coupons'), $data['code']); ?></div>
            <p class="expiry-date"><?php echo sprintf(__('Expires on: %s', 'woocommerce-gift-coupons'), $data['expiry_date']); ?></p>
            <div class="footer">
                <?php _e('Registration: www.kirviumetymas.lt / +37068878085', 'woocommerce-gift-coupons'); ?>
            </div>
        </div>
    </body>
</html>