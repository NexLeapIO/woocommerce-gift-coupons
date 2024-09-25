<?php

if (!defined('ABSPATH')) {
    exit;
}

class WGC_Plugin {
    public function __constructor() {
        // Load dependencies.
        $this->load_dependencies();

        // Initialize admin functionalities.
        if (is_admin()) {
            $this->init_admin();
        }

        // Initialize public functionalities if needed.
        $this->init_public();
    }

    private function load_dependencies() {
        // Include admin class.
        require_once WGC_PLUGIN_DIR . 'admin/class-wgc-admin.php';

        // Include coupon generator class.
        require_once WGC_PLUGIN_DIR . 'includes/class-wgc-coupon-generator.php';

        // Include email handler class.
        require_once WGC_PLUGIN_DIR . 'includes/class-wgc-email-handler.php';
    
        // Include order handler class.
        require_once WGC_PLUGIN_DIR . 'includes/class-wgc-order-handler.php';
    }

    private function init_admin() {
        $admin = new WGC_Admin();
    }

    private function init_public() {
        // Initialize public-facing functionalities if needed.
    }
}