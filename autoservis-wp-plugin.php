<?php
/**
 * Plugin Name: My Custom Plugin
 * Description: this is my custom plugin
 * Version: 0.0.1
 * Author: David Dvorak
*/
 
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

function autoservice_my_plugin_enqueue_style() {
    wp_enqueue_script('tailwindcss', 'https://unpkg.com/@tailwindcss/browser@4');
    wp_enqueue_script('flatpickr', 'https://cdn.jsdelivr.net/npm/flatpickr');
    wp_enqueue_script('flatpickr-local', 'https://npmcdn.com/flatpickr/dist/l10n/cs.js');
    wp_enqueue_script('autoservis-wp-plugin-script', plugin_dir_url(__FILE__) . 'script.js', ['flatpickr', 'flatpickr-local'], time(), true);
    wp_enqueue_style('my-plugin-style', plugin_dir_url(__FILE__) . 'style.css', [], time());
    wp_enqueue_style('flatpickr', 'https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css');
}

function autoservice_handle_reservation_form_submission() {
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

    // Validate fields
    if (empty($first_name)) {
        $errors['first_name'] = 'Jméno je povinné';
    }

    if (empty($last_name)) {
        $errors['last_name'] = 'Příjmení je povinné';
    }

    if (!is_email($email)) {
        $errors['email'] = 'Neplatná emailová adresa';
    }

    if (empty($phone)) {
        $errors['phone'] = 'Telefonní číslo je povinné';
    }

    if (empty($date)) {
        $errors['date'] = 'Datum rezervace je povinné';
    }

    if (empty($service)) {
        $errors['service'] = 'Služba je povinná';
    }

    // If there are errors, redirect back with error data
    if (!empty($errors)) {
        $redirect_url = add_query_arg([
            'errors' => urlencode(json_encode($errors)),
            'data' => urlencode(json_encode($_POST))
        ], wp_get_referer());

        $redirect_url .= '#reservation';
        wp_redirect($redirect_url);
        exit;
    }

    wp_redirect(home_url('/?form_submitted=success'));

    // Print the received data for now
    // echo "<h2>Submitted Data:</h2>";
    // echo "<p><strong>Jméno:</strong> $first_name</p>";
    // echo "<p><strong>Příjmení:</strong> $last_name</p>";
    // echo "<p><strong>Email:</strong> $email</p>";
    // echo "<p><strong>Telefon:</strong> $phone</p>";
    // echo "<p><strong>Datum rezervace:</strong> $date</p>";
    // echo "<p><strong>Služba:</strong> $service</p>";
    // echo "<p><strong>Poznámka:</strong> $message</p>";

    exit;
}

function autoservice_my_contact_form_func() {
    ob_start();
    require_once plugin_dir_path(__FILE__) . 'registration-form.php';
    return ob_get_clean();
}

add_action('admin_post_submit_reservation', 'autoservice_handle_reservation_form_submission');
add_action('admin_post_nopriv_submit_reservation', 'autoservice_handle_reservation_form_submission');
add_action('wp_enqueue_scripts', 'autoservice_my_plugin_enqueue_style');
add_shortcode('contact_form', 'autoservice_my_contact_form_func');
