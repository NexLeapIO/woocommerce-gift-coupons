<?php
/*
Plugin Name: WooCommerce Gift Coupons
Plugin URI: https://github.com/NexLeapIO/woocommerce-gift-coupons
Description: A plugin to generate and manage gift coupons in WooCommerce.
Version: 1.0.0
Author: NexLeap
Author URI: https://nexleap.cloud
Text Domain: woocommerce-gift-coupons
Domain Path: /languages
License: GPL2
*/

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants.
define('WGC_VERSION', '1.0.0');
define('WGC_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('WGC_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include the activator class.
if (file_exists(WGC_PLUGIN_DIR . 'includes/class-wgc-activator.php')) {
    require_once WGC_PLUGIN_DIR . 'includes/class-wgc-activator.php';
}

// Include the main plugin class.
if (file_exists(WGC_PLUGIN_DIR . 'includes/class-wgc-plugin.php')) {
    require_once WGC_PLUGIN_DIR . 'includes/class-wgc-plugin.php';
}

// Register the activation hook.
register_activation_hook(__FILE__, array('WGC_Activator', 'activate'));

// Initialize the plugin.
function wgc_initialize_plugin() {
    if (class_exists('WGC_Plugin')) {
        $plugin = new WGC_Plugin();
    }
}
add_action('plugins_loaded', 'wgc_initialize_plugin');



