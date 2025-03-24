<?php

namespace Autoservice;

class CarServicePlugin {
    const MENU_SLUG = 'autoservis';

    public function __construct(
        private CallusWidget $callus_widget,
        private Reservation $reservation
    ) { }

    public function init() {
        add_action('admin_menu', [$this, 'add_menu_pages']);
    }

    public function add_menu_pages() {
        global $menu;
        
        // Add main menu if it doesn't exist
        $menu_exists = false;
        foreach ($menu as $item) {
            if (isset($item[2]) && $item[2] === self::MENU_SLUG) {
                $menu_exists = true;
                break;
            }
        }

        if (!$menu_exists) {
            add_menu_page(
                'Autoservis',
                'Autoservis',
                'manage_options',
                self::MENU_SLUG,
                [$this, 'render_main_page'],
                'dashicons-car',
                30
            );
        }

        // Add submenu for callus widget settings
        add_submenu_page(
            self::MENU_SLUG,
            'Callus Widget Settings',
            'Callus Widget',
            'manage_options',
            'autoservis-callus-settings',
            [$this->callus_widget, 'render_callus_widget_settings']
        );
    }

    public function render_main_page() {
        echo '<div class="wrap"><h1>Autoservis Settings</h1><p>Welcome to Autoservis settings. Use the submenu on the left to configure different components.</p></div>';
    }
}