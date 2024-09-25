<?php

if (!defined('ABSPATH')) {
    exit;
}

class WGC_Activator {
    public static function activate() {
        global $wpdb;

        $table_name = $wpdb->prefix . 'wgc_coupons';
        $charset_collate = $wpdb->get_charset_collate();

        $sql = "CREATE TABLE $table_name (
            id mediumint(9) NOT NULL AUTO_INCREMENT,
            code varchar(20) NOT NULL,
            product_id bigint(20) NOT NULL,
            receiver_name varchar(100) NOT NULL,
            receiver_email varchar(100) NOT NULL,
            issue_date datetime NOT NULL,
            expiry_date datetime NOT NULL,
            status varchar(20) NOT NULL DEFAULT 'Not Used',
            PRIMARY KEY  (id),
            UNIQUE KEY code (code)
        ) $charset_collate;";

        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
        dbDelta($sql);
    }
}