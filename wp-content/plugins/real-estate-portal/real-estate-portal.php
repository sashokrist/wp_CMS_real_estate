<?php
/**
 * Plugin Name: Real Estate Portal
 * Description: Custom post types for Properties, Renovation Services, News + front-end sections and detail templates.
 * Version: 1.0.0
 * Author: Your Name
 * Requires at least: 6.0
 * Requires PHP: 8.0
 */

if (!defined('ABSPATH')) {
    exit;
}

define('REP_PLUGIN_VERSION', '1.0.0');
define('REP_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('REP_PLUGIN_URL', plugin_dir_url(__FILE__));

require_once REP_PLUGIN_DIR . 'includes/cpt.php';
require_once REP_PLUGIN_DIR . 'includes/meta-boxes.php';
require_once REP_PLUGIN_DIR . 'includes/shortcodes.php';
require_once REP_PLUGIN_DIR . 'includes/templates.php';

add_action('plugins_loaded', function () {
    // Load text domain if needed in future
});

add_action('wp_enqueue_scripts', function () {
    wp_register_style('rep-style', REP_PLUGIN_URL . 'assets/css/style.css', [], REP_PLUGIN_VERSION);
    wp_register_script('rep-script', REP_PLUGIN_URL . 'assets/js/main.js', ['jquery'], REP_PLUGIN_VERSION, true);
});

add_action('admin_enqueue_scripts', function () {
    wp_enqueue_style('rep-style', REP_PLUGIN_URL . 'assets/css/style.css', [], REP_PLUGIN_VERSION);
});
