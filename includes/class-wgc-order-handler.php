<?php

if (!defined('ABSPATH')) {
    exit;
}

class WGC_Order_Handler {
    public function __constructor() {
        add_action('woocommerce_order_status_completed', array($this, 'handle_order_completion'));
    }

    public function handle_order_completion($order_id) {
        $order = wc_get_order($order_id);

        $receiver_name = $order->get_customer_note();
        if (empty(trim($receiver_name))) {
            $receiver_name = $order->get_billing_first_name();
        }

        $receiver_email = $order->get_billing_email();

        foreach($order->get_items() as $item) {
            $product_id = $item->get_product_id();
            $quantity = $item->get_quantity();

            for ($i = 0; $i < $quantity; $i++) {
                $code = WGC_Coupon_Generator::generate_unique_code();

                $data = array(
                    'code' => $code,
                    'product_id' => $product_id,
                    'receiver_name' => $receiver_name,
                    'receiver_email' => $receiver_email,
                    'issue_date' => current_time('mysql'),
                    'expiry_date' => date('Y-m-d', strtotime('+6 months')),
                    'status' => 'Not Used'
                );

                WGC_Coupon_Generator::save_coupon($data);

                // Send email with PDF attachment.
                WGC_Email_Handler::send_coupon_email($data);
            }
        }
    }
}

// Initialize the order handler.
if (class_exists('Woocommerce')) {
    new WGC_Order_Handler();
}