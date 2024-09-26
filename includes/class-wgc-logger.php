<?php

if (!defined('ABSPATH')) {
    exit;
}

class WGC_Logger {
    public static function log($message) {
        if (defined('WP_DEBUG') && WP_DEBUG) {
            error_log($message);
        }
    }
}