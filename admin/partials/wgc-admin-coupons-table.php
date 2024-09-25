<?php

if (!defined('ABSPATH')) {
    exit;
}

// Handle bulk actions
if (isset($_GET['action']) && isset($_GET['coupon_id'])) {
    $action = sanitize_text_field($_GET['action']);
    $coupon_id = intval($_GET['coupon_id']);

    if ($action === 'delete') {
        check_admin_referer('wgc_delete_coupon_' . $coupon_id);

        WGC_Coupon_Generator::delete_coupon($coupon_id);

        echo '<div class="notice notice-success is-dismissible"><p>' . __('Coupon deleted successfully.', 'woocommerce-gift-coupons') . '</p></div>';
    } elseif ($action === 'mark_used') {
        WGC_Coupon_Generator::update_coupon_status($coupon_id, 'Used');

        echo '<div class="notice notice-success is-dismissible"><p>' . __('Coupon marked as used.', 'woocommerce-gift-coupons') . '</p></div>';
    } elseif ($action === 'mark_not_used') {
        WGC_Coupon_Generator::update_coupon_status($coupon_id, 'Not Used');

        echo '<div class="notice notice-success is-dismissible"><p>' . __('Coupon marked as not used.', 'woocommerce-gift-coupons') . '</p></div>';
    }
}

// Fetch coupons data.
$coupons = WGC_Coupon_Generator::get_all_coupons();

?>

<table class="wp-list-table widefat fixed striped">
    <thead>
        <tr>
            <th><?php _e('Coupon Code', 'woocommerce-gift-coupons'); ?></th>
            <th><?php _e('Issue Date', 'woocommerce-gift-coupons'); ?></th>
            <th><?php _e('Expiry Date', 'woocommerce-gift-coupons'); ?></th>
            <th><?php _e('Status', 'woocommerce-gift-coupons'); ?></th>
            <th><?php _e('Actions', 'woocommerce-gift-coupons'); ?></th>
        </tr>
    </thead>
    <tbody>
        <?php if ($coupons) : ?>
            <?php foreach ($coupons as $coupon) : ?>
                <tr>
                    <td><?php echo esc_html($coupon->code); ?></td>
                    <td><?php echo date_i18n(get_option('date_format'), strtotime($coupon->issue_date)); ?></td>
                    <td><?php echo date_i18n(get_option('date_format'), strtotime($coupon->expiry_date)); ?></td>
                    <td><?php echo esc_html($coupon->status); ?></td>
                    <td>
                        <?php
                        $delete_url = wp_nonce_url(add_query_arg(array('action' => 'delete', 'coupon_id' => $coupon->id)), 'wgc_delete_coupon_' . $coupon->id);
                        $mark_used_url = add_query_arg(array('action' => 'mark_used', 'coupon_id' => $coupon->id));
                        $mark_not_used_url = add_query_arg(array('action' => 'mark_not_used', 'coupon_id' => $coupon->id));
                        ?>
                        <a href="<?php echo esc_url($delete_url); ?>" onclick="return confirm('<?php _e('Are you sure you want to delete this coupon?', 'woocommerce-gift-coupons'); ?>')"><?php _e('Delete', 'woocommerce-gift-coupons'); ?></a> |
                        <?php if ($coupon->status === 'Not Used') : ?>
                            <a href="<?php echo esc_url($mark_used_url); ?>"><?php _e('Mark as Used', 'woocommerce-gift-coupons'); ?></a>
                        <?php else : ?>
                            <a href="<?php echo esc_url($mark_not_used_url); ?>"><?php _e('Mark as Not Used', 'woocommerce-gift-coupons'); ?></a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="5"><?php _e('No coupons found.', 'woocommerce-gift-coupons'); ?></td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>