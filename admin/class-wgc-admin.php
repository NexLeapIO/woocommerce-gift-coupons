<?php

if (!defined('ABSPATH')) {
    exit;
}

class WGC_Admin {
    public function __construct() {
        // Add admin menu.
        add_action('admin_menu', array($this, 'add_admin_menu'));

        // Enqueue admin scripts and styles.
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
    }

    public function add_admin_menu() {
        add_menu_page(
            __('Gift Coupons', 'woocommerce-gift-coupons'),
            __('Gift Coupons', 'woocommerce-gift-coupons'),
            'manage_woocommerce',
            'wgc-gift-coupons',
            array($this, 'display_admin_dashboard'),
            'dashicons-tickets',
            56
        );
    }

    public function enqueue_admin_assets($hook) {
        if ($hook !== 'toplevel_page_wgc-gift-coupons') {
            return;
        }

        // Enqueue styles and scripts here if needed.
    }

    public function display_admin_dashboard() {
        // Include the dashboard template.
        include WGC_PLUGIN_DIR . 'admin/partials/wgc-admin-dashboard.php';
    }
}