<?php

namespace Autoservice;

class Reservation {
    const SHORTCODE_NAME = 'reservation-form';

    public function __construct() {
        add_shortcode(self::SHORTCODE_NAME, [$this, 'render_reservation_form']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);

        add_action('admin_post_submit_reservation', [$this, 'handle_reservation_submit']);
        add_action('admin_post_nopriv_submit_reservation', [$this, 'handle_reservation_submit']);
    }

    public function handle_reservation_submit() {
        if (!isset($_POST['reservation_nonce_field']) || !wp_verify_nonce($_POST['reservation_nonce_field'], 'reservation_nonce')) {
            wp_die('My Security check failed.');
        }

        $errors = [];

        // Sanitize and retrieve data
        $first_name  = sanitize_text_field($_POST['first_name']);
        $last_name   = sanitize_text_field($_POST['last_name']);
        $email       = sanitize_email($_POST['email']);
        $phone       = sanitize_text_field($_POST['phone']);
        $date        = sanitize_text_field($_POST['date']);
        $service     = sanitize_text_field($_POST['service']);
        $message     = sanitize_textarea_field($_POST['message']);


        // echo "<h2>Submitted Data:</h2>";
        // echo "<p><strong>Jméno:</strong> $first_name</p>";
        // echo "<p><strong>Příjmení:</strong> $last_name</p>";
        // echo "<p><strong>Email:</strong> $email</p>";
        // echo "<p><strong>Telefon:</strong> $phone</p>";
        // echo "<p><strong>Datum rezervace:</strong> $date</p>";
        // echo "<p><strong>Služba:</strong> $service</p>";
        // echo "<p><strong>Poznámka:</strong> $message</p>";

        // exit;
        wp_redirect(home_url('/?form_submitted=success'));
    }

    public function render_reservation_form() {
        include plugin_dir_path(__FILE__) . 'templates/form.php';
    }

    public function enqueue_scripts() {
        wp_enqueue_script('tailwindcss', 'https://unpkg.com/@tailwindcss/browser@4');
        wp_enqueue_script('flatpickr', 'https://cdn.jsdelivr.net/npm/flatpickr');
        wp_enqueue_script('flatpickr-local', 'https://npmcdn.com/flatpickr/dist/l10n/cs.js');
        wp_enqueue_script('autoservis-wp-plugin-script', plugin_dir_url(__FILE__) . 'script.js', ['flatpickr', 'flatpickr-local'], time(), true);
        wp_enqueue_style('my-plugin-style', plugin_dir_url(__FILE__) . 'style.css', [], time());
        wp_enqueue_style('flatpickr', 'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css');
    }
}