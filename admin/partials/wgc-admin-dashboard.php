<?php

if (!defined('ABSPATH')) {
    exit;
}

// Fetch coupons data from the database.
$coupons = WGC_Coupon_Generator::get_all_coupons();

?>

<div class="wrap">
    <h1><?php _e('Gift Coupons', 'woocommerce-gift-coupons'); ?></h1>

    <!-- Coupon Issue Form -->
    <h2><?php _e('Issue a New Coupon', 'woocommerce-gift-coupons'); ?></h2>
    <?php include WGC_PLUGIN_DIR . 'admin/partials/wgc-admin-issue-form.php'; ?>

    <!-- Coupon Validation Form -->
    <h2><?php _e('Validate a Coupon', 'woocommerce-gift-coupons'); ?></h2>
    <?php include WGC_PLUGIN_DIR . 'admin/partials/wgc-admin-validate-form.php'; ?>

    <!-- Coupon Table -->
    <h2><?php _e('Issued Coupons', 'woocommerce-gift-coupons'); ?></h2>
    <?php include WGC_PLUGIN_DIR . 'admin/partials/wgc-admin-coupons-table.php'; ?>
</div>