<?php

if (!defined('ABSPATH')) {
    exit;
}

class WGC_Email_Handler {
    public static function send_coupon_email($data) {
        // Prepare email content.
        $to = $data['receiver_email'];
        $subject = __('You have received a gift coupon!', 'woocommerce-gift-coupons');
        $message = __('Please find your gift coupon attached to this email.', 'woocommerce-gift-coupons');

        // Generate PDF.
        $pdf_content = self::generate_pdf($data);

        // Create temporary file.
        $upload_dir = wp_upload_dir();
        $pdf_path = $upload_dir['basedir'] . '/coupon-' . $data['code'] . '.pdf';
        file_put_contents($pdf_path, $pdf_content);

        // Prepare headers.
        $headers = array('Content-Type: application/pdf; charset=UTF-8');

        // Prepare attachments.
        $attachments = array($pdf_path);

        // Send email.
        $email_sent = wp_mail($to, $subject, $message, $headers, $attachments);

        if ($email_sent) {
            WGC_Logger::log('Email sent successfully to ' . $to);
        } else {
            WGC_Logger::log('Failed to send email to ' . $to);

            // Send admin notification.
            wp_mail(get_option('admin_email'), 'Coupon email failed', 'Failed to coupon email to ' . $to);
        }

        // Delete temporary file.
        unlink($pdf_path);
    }

    private static function generate_pdf($data) {
        if (!class_exists('Mpdf\Mpdf')) {
            require_once WGC_PLUGIN_DIR . 'vendor/autoload.php';
        }

        // Prepare HTML content
        ob_start();
        include WGC_PLUGIN_DIR . 'templates/pdf-template.php';
        $html = ob_get_clean();

        // Generate PDF.
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->WriteHTML($html);
        return $mpdf->Output('', 'S');
    }
}