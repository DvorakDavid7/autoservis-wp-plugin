<?php
/**
 * Plugin Name: Autoservis Uchytil Plugin
 * Description: this is a custom plugin for autoservis uchytil
 * Version: 0.0.1
 * Author: David Dvořák
*/
 
if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

require_once plugin_dir_path(__FILE__) . 'car-service-plugin.php';
require_once plugin_dir_path(__FILE__) . 'call-us/callus-widget.php';
require_once plugin_dir_path(__FILE__) . 'reservations/reservation.php';


$call_us_widget = new \Autoservice\CallusWidget;
$reservation = new \Autoservice\Reservation;
$car_service_plugin = new \Autoservice\CarServicePlugin($call_us_widget, $reservation);
$car_service_plugin->init();


// class Autoservice_Database {
//     private $wpdb;
//     private $table_name;
//     private $charset_collate;

//     public function __construct() {
//         global $wpdb;
//         $this->wpdb = $wpdb;
//         $this->table_name = $wpdb->prefix . 'reservations';
//         $this->charset_collate = $wpdb->get_charset_collate();
//     }

//     public function create_reservations_table() {
//         $sql = "CREATE TABLE IF NOT EXISTS {$this->table_name} (
//             id INT NOT NULL AUTO_INCREMENT,
//             first_name VARCHAR(50) NOT NULL,
//             last_name VARCHAR(50) NOT NULL,
//             email VARCHAR(100) NOT NULL,
//             phone VARCHAR(20),
//             reservation_date DATETIME,
//             service VARCHAR(100),
//             message TEXT,
//             created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
//             PRIMARY KEY (id)
//         ) {$this->charset_collate};";

//         require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
//         dbDelta($sql);
//     }

//     public function get_table_name() {
//         return $this->table_name;
//     }
// }

// // Initialize database on plugin activation
// register_activation_hook(__FILE__, function() {
//     $database = new Autoservice_Database();
//     $database->create_reservations_table();
// });

// function autoservice_handle_reservation_form_submission() {
//     global $wpdb;

//     if (!isset($_POST['reservation_nonce_field']) || !wp_verify_nonce($_POST['reservation_nonce_field'], 'reservation_nonce')) {
//         wp_die('My Security check failed.');
//     }

//     $errors = [];

//     // Sanitize and retrieve data
//     $first_name  = sanitize_text_field($_POST['first_name']);
//     $last_name   = sanitize_text_field($_POST['last_name']);
//     $email       = sanitize_email($_POST['email']);
//     $phone       = sanitize_text_field($_POST['phone']);
//     $date        = sanitize_text_field($_POST['date']);
//     $service     = sanitize_text_field($_POST['service']);
//     $message     = sanitize_textarea_field($_POST['message']);

//     // Validate fields
//     if (empty($first_name)) {
//         $errors['first_name'] = 'Jméno je povinné';
//     }

//     if (empty($last_name)) {
//         $errors['last_name'] = 'Příjmení je povinné';
//     }

//     if (!is_email($email)) {
//         $errors['email'] = 'Neplatná emailová adresa';
//     }

//     if (empty($phone)) {
//         $errors['phone'] = 'Telefonní číslo je povinné';
//     }

//     if (empty($date)) {
//         $errors['date'] = 'Datum rezervace je povinné';
//     }

//     if (empty($service)) {
//         $errors['service'] = 'Služba je povinná';
//     }

//     // If there are errors, redirect back with error data
//     if (!empty($errors)) {
//         $redirect_url = add_query_arg([
//             'errors' => urlencode(json_encode($errors)),
//             'data' => urlencode(json_encode($_POST))
//         ], wp_get_referer());

//         $redirect_url .= '#reservation';
//         wp_redirect($redirect_url);
//         exit;
//     }

//     $res = $wpdb->insert(
//         $wpdb->prefix . 'reservations',
//         [
//             'first_name' => $first_name,
//             'last_name'  => $last_name,
//             'email'      => $email,
//             'phone'      => $phone,
//             'reservation_date' => $date,
//             'service'    => $service,
//             'message'    => $message
//         ],
//         ['%s', '%s', '%s', '%s', '%s', '%s', '%s']
//     );

//     if ($res === false) {
//         wp_die('Error saving reservation');
//     }

//     wp_redirect(home_url('/?form_submitted=success'));

//     // Print the received data for now
//     // echo "<h2>Submitted Data:</h2>";
//     // echo "<p><strong>Jméno:</strong> $first_name</p>";
//     // echo "<p><strong>Příjmení:</strong> $last_name</p>";
//     // echo "<p><strong>Email:</strong> $email</p>";
//     // echo "<p><strong>Telefon:</strong> $phone</p>";
//     // echo "<p><strong>Datum rezervace:</strong> $date</p>";
//     // echo "<p><strong>Služba:</strong> $service</p>";
//     // echo "<p><strong>Poznámka:</strong> $message</p>";

//     exit;
// }

// function autoservice_my_contact_form_func() {
//     ob_start();
//     require_once plugin_dir_path(__FILE__) . 'registration-form.php';
//     return ob_get_clean();
// }


// function autoservice_add_reservations_menu() {
//     add_menu_page(
//         'Reservations',
//         'Reservations',
//         'manage_options',
//         'reservations',
//         'display_reservations'
//     );
// }

// function display_reservations() {
//     global $wpdb;
//     $reservations = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}reservations");

//     echo "<h1>Reservations</h1>";
//     echo "<table border='1' cellpadding='10'>";
//     echo "<tr><th>Name</th><th>Email</th><th>Phone</th><th>Date</th><th>Service</th><th>Message</th></tr>";

//     foreach ($reservations as $reservation) {
//         echo "<tr>
//             <td>{$reservation->first_name} {$reservation->last_name}</td>
//             <td>{$reservation->email}</td>
//             <td>{$reservation->phone}</td>
//             <td>{$reservation->reservation_date}</td>
//             <td>{$reservation->service}</td>
//             <td>{$reservation->message}</td>
//         </tr>";
//     }

//     echo "</table>";
// }

// // Include Callus Widget functionality
// require_once plugin_dir_path(__FILE__) . 'callus-widget.php';

// // Register Callus Widget shortcode
// add_shortcode('autoservice_callus', 'autoservice_callus_widget_func');

// // Add Callus Widget to admin menu
// function autoservice_add_callus_menu() {
//     add_submenu_page(
//         'reservations',
//         'Callus Widget Settings',
//         'Callus Widget',
//         'manage_options',
//         'autoservice-callus-settings',
//         'autoservice_callus_settings_page'
//     );
// }

// // Add initialization hooks for Callus Widget
// add_action('admin_init', 'autoservice_callus_register_settings');
// add_action('admin_menu', 'autoservice_add_callus_menu');
// add_action('wp_enqueue_scripts', 'autoservice_callus_enqueue_style');

// add_action('admin_menu', 'autoservice_add_reservations_menu');
// add_action('wp_enqueue_scripts', 'autoservice_my_plugin_enqueue_style');
// add_shortcode('contact_form', 'autoservice_my_contact_form_func');
