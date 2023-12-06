<?php
/**
* Plugin Name: Webmaster Tools
* Description: Tools for webmasters in a neat plugin format.
* Author: mlvq
* Author URI: https://github.com/mlvq/webmaster-plugin
* Version: 1.0.0
* Requires at least: 6.4
* Requires PHP: 7.4
* Text Domain: webmaster
*/

/* PHP Security */
defined('ABSPATH') || exit;

/** 
 * Requires/defines/includes
 */
//require_once plugin_dir_path( __FILE__ ) . 'includes/class-extension.php';
/**
 * Handle plugin activation and deactivation
 */
register_activation_hook( __FILE__, 'activate_webmaster_tools' );
register_deactivation_hook( __FILE__, 'deactivate_webmaster_tools' );
/* Main class */
if (!class_exists('WEBMASTER')) :
    class WEBMASTER {
        public function __construct() {
            require plugin_dir_path(__FILE__) . 'includes/activation.php';
            require plugin_dir_path(__FILE__) . 'includes/catalog-post.php';
            require plugin_dir_path(__FILE__) . 'includes/taxonomy-settings.php';
            require plugin_dir_path(__FILE__) . 'includes/admin-pages.php';
        }

        public function initialize() {
            add_action('wp_enqueue_scripts', array($this, 'load_assets'));
            add_action('admin_menu', 'load_submenu');
        }

        public function load_assets() {
            wp_enqueue_style(
                'webmaster',
                plugin_dir_url(__FILE__) . 'assets/css/webmaster-plugin.css',
                array(),
                1,
                'all'
            );

            wp_enqueue_script(
                'webmaster',
                plugin_dir_url(__FILE__) . 'assets/js/webmaster-plugin.js',
                array(),
                1,
                true
            );
        }
    }

    /**
     * Instantiate the class
     */
    function webmastertools() {
        global $webmastertools;

        // Instantiate only once.
        if (!isset($webmastertools)) {
            $webmastertools = new WEBMASTER();
            $webmastertools->initialize();
        }
        return $webmastertools;
    }

    /**
     * Initialize
     */

    webmastertools();
endif; // End of IF class WebmasterTools exists