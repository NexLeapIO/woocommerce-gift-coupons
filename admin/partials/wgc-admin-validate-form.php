<?php

if (!defined('ABSPATH')) {
    exit;
}

// Handle form submission.
if (isset($_POST['wgc_validate_coupon']) && check_admin_referer('wgc_validate_coupon_action', 'wgc_validate_coupon_nonce')) {
    $coupon_code = sanitize_text_field($_POST['wgc_coupon_code']);

    $coupon = WGC_Coupon_Generator::get_coupon_by_code($coupon_code);

    if ($coupon) {
        if ($coupon->status === 'Not Used') {
            // Update coupon status to 'Used'.
            WGC_Coupon_Generator::update_coupon_status($coupon->id, 'Used');

            echo '<div class="notice notice-success is-dismissible"><p>' . __('Coupon validated and marked as used.', 'woocommerce-gift-coupons') . '</p></div>';
        } else {
            echo '<div class="notice notice-warning is-dismissible"><p>' . __('Coupon has already been used.', 'woocommerce-gift-coupons') . '</p></div>';
        }
    } else {
        echo '<div class="notice notice-error is-dismissible"><p>' . __('Coupon not found.', 'woocommerce-gift-coupons') . '</p></div>';
    }
}

?>

<form method="post" action="">
    <?php wp_nonce_field('wgc_validate_coupon_action', 'wgc_validate_coupon_nonce'); ?>

    <table class="form-table">
        <tr valign="top">
            <th scrope="row"><label for="wgc_coupon_code"><?php _e('Coupon Code', 'woocommerce-gift-coupons'); ?></label></th>
            <td><input type="text" id="wgc_coupon_code" name="wgc_coupon_code" style="width: 400px;" required></td>
        </tr>
    </table>

    <?php submit_button(__('Validate Coupon', 'woocommerce-gift-coupons'), 'primary', 'wgc_validate_coupon'); ?>
</form>