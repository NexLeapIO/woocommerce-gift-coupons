<?php

if (!defined('ABSPATH')) {
    exit;
}

class WGC_Coupon_Generator {
    private static $charset = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    public static function generate_unique_code($length = 8) {
        $charset_length = strlen(self::$charset);

        do {
            $code = '';
            for ($i = 0; $i < $length; $i++) {
                $code .= self::$charset[wp_rand(0, $charset_length - 1)];
            }
        } while (self::code_exists($code));

        return $code;
    }

    public static function code_exists($code) {
        global $wpdb;

        $table_name = $wpdb->prefix . 'wgc_coupons';

        $result = $wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM $table_name WHERE code = %s", $code));

        return $result > 0;
    }

    public static function save_coupon($data) {
        global $wpdb;

        $table_name = $wpdb->prefix . 'wgc_coupons';

        $wpdb->insert($table_name, $data);

        return $wpdb->insert_id;
    }

    public static function get_all_coupons() {
        global $wpdb;

        $table_name = $wpdb->prefix . 'wgc_coupons';

        $results = $wpdb->get_results("SELECT * FROM $table_name ORDER BY issue_date DESC");

        return $results;
    }

    public static function get_coupon_by_code($code) {
        global $wpdb;

        $table_name = $wpdb->prefix . 'wgc_coupons';

        $result = $wpdb->get_row($wpdb->prepare("SELECT * FROM $table_name WHERE code = %s", $code));

        return $result;
    }

    public static function update_coupon_status($id, $status) {
        global $wpdb;

        $table_name = $wpdb->prefix . 'wgc_coupons';

        $wpdb->update(
            $table_name,
            array('status' => $status),
            array('id' => $id),
            array('%s'),
            array('%d')
        );
    }

    public static function delete_coupon($id) {
        global $wpdb;

        $table_name = $wpdb->prefix . 'wgc_coupons';

        $wpdb->delete(
            $table_name,
            array('id' => $id),
            array('%d')
        );

        return $wpdb->rows_affected;
    }
}