<?php

if (!defined('ABSPATH')) {
    exit;
}

// Handle form submission.
if (isset($_POST['wgc_issue_coupon']) && check_admin_referer('wgc_issue_coupon_action', 'wgc_issue_coupon_nonce')) {
    $products_ids = array_map('intval', $_POST['wgc_product_ids']);
    $receiver_name = sanitize_text_field($_POST['wgc_receiver_name']);
    $receiver_email = sanitize_email($_POST['wgc_receiver_email']);

    foreach ($products_ids as $product_id) {
        $code = WGC_Coupon_Generator::generate_unique_code();

        $data = array(
            'code' => $code,
            'product_id' => $product_id,
            'receiver_name' => $receiver_name,
            'receiver_email' => $receiver_email,
            'issue_date' => current_time('mysql'),
            'expiry_date' => date('Y-m-d H:i:s', strtotime('+6 months')),
            'status' => 'Not Used'
        );

        WGC_Coupon_Generator::save_coupon($data);

        // Send email with PDF attachment.
        WGC_Email_Handler::send_coupon_email($data);
    }

    echo '<div class="notice notice-success is-dismissible"><p>' . __('Coupon(s) issued successfully.', 'woocommerce-gift-coupons') . '</p></div>';
}

?>

<form method="post" action="">
    <?php wp_nonce_field('wgc_issue_coupon_action', 'wgc_issue_coupon_nonce'); ?>

    <table class="form-table">
        <tr valign="top">
            <th scope="row"><label for="wgc_product_ids"><?php _e('Select Product(s)', 'woocommerce-gift-coupons'); ?></label></th>
            <td>
                <select id="wgc_product_ids" name="wgc_product_ids[]" multiple style="width: 400px;">
                    <?php
                    $products = wc_get_products(array('status' => 'publish', 'limit' => -1));
                    foreach ($products as $product) {
                        echo '<option value="' . esc_attr($product->get_id()) . '">' . esc_html($product->get_name()) . '</option>';
                    }
                    ?>
                </select>
                <p class="description"><?php _e('Hold down the Ctrl (windows) or Command (Mac) button to select multiple products.', 'woocommerce-gift-coupons'); ?></p>
            </td>
        </tr>
        <tr valign="top">
            <th scope="row"><label for="wgc_receiver_name"><?php _e('Receiver Name', 'woocommerce-gift-coupons'); ?></label></th>
            <td><input type="text" id="wgc_receiver_name" name="wgc_receiver_name" style="width: 400px;" required></td>
        </tr>
        <tr valign="top">
            <th scope="row"><label for="wgc_receiver_email"><?php _e('Receiver Email', 'woocommerce-gift-coupons'); ?></label></th>
            <td><input type="email" id="wgc_receiver_email" name="wgc_receiver_email" style="width: 400px;" required></td>
        </tr>
    </table>

    <?php submit_button(__('Issue Coupon', 'woocommerce-gift-coupons'), 'primary', 'wgc_issue_coupon'); ?>
</form>