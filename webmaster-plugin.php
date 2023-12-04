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
        }

        public function initialize() {
            add_action('wp_enqueue_scripts', array($this, 'load_assets'));
            add_action('admin_menu', array($this, 'load_submenu'));
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

        public function load_submenu() {
            global $submenu;
            $menu_slug = "webmaster";
            add_submenu_page(
            'edit.php?post_type=catalog_type', //parent_slug
            'Webmaster settings', // page_title
            'Settings', // menu_title
            'manage_options', // capability
            $menu_slug,
            array($this, 'webmaster_page_callback'));

            $submenu[$menu_slug][] = array('<div id="webmaster-submenu-1">Settings</div>', 'manage_options', '#');
            $submenu[$menu_slug][] = array('<div id="webmaster-submenu-2">Tutorial</div>', 'manage_options', 'https://wpsimplehacks.com/how-to-add-custom-admin-menu-items/'); 
        }
        function webmaster_page_callback() {
            $htmlcontent = '<div class="wrap">';
            $htmlcontent .= '<h1 class="wp-heading-inline">Settings</h1>';
            $htmlcontent .= '<div class="notice is-dismissible updated">';
            $htmlcontent .= '<p>';
            $htmlcontent .= __( 'Nothing to see here! Yet...', 'webmaster' );
            $htmlcontent .= '</p>';
            $htmlcontent .= '</div></div>';
            echo $htmlcontent;
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