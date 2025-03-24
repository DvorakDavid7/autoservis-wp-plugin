<?php
/*
 * Plugin Name: Callus Widget
 */


 namespace Autoservice;

if (!defined('ABSPATH')) {
    exit; // Prevent direct access
}

class CallusWidget {
    const SHORTCODE_NAME = 'callus-widget';
    const DEFAULT_PHONE_NUMBER = '+420774034180';
    const MENU_SLUG = 'autoservis';

    public function __construct() {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_styles']);
        add_shortcode(self::SHORTCODE_NAME, [$this, 'render_callus_widget']);
        add_action('admin_init', [$this, 'register_settings']);
    }

    public function register_settings() {
        register_setting('callus_options_group', 'callus_phone_number');
    }

    public function enqueue_styles() {
        wp_enqueue_style('callus-widget-style', plugin_dir_url(__FILE__) . 'style.css');
    }

    public function render_callus_widget() {
        $phone = get_option('callus_phone_number', self::DEFAULT_PHONE_NUMBER);
        $this->render_template('callus-widget', ['phone' => $phone]);
    }

    public function render_callus_widget_settings() {
        $this->render_template('callus-widget-settings');
    }

    private function render_template($template, $data = []) {
        extract($data);
        include plugin_dir_path(__FILE__) . 'templates/' . $template . '.php';
    }
}