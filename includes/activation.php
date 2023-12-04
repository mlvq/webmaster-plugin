<?php
/* PHP Security */
defined('ABSPATH') || exit;

function activate_webmaster_tools() {
    add_option('activated_plugin', 'webmaster-plugin');
}

function deactivate_webmaster_tools() {
    delete_option('activated_plugin');
    add_action('admin_init','webmaster_unregister_post_type');
    add_action( 'admin_init', 'webmaster_delete_all_posts');
    flush_rewrite_rules();
}

function webmaster_load_plugin() {
    if (is_admin() && get_option('activated_plugin') == 'webmaster-plugin') {
        delete_option('activated_plugin');
        set_transient( 'fx-admin-notice-example', true, 5 );
        add_action( 'admin_notices', 'webmaster_display_notice');
    }
}

function webmaster_display_notice() {
    if(get_transient('fx-admin-notice-example')){
        $html = '<div class="notice is-dismissible updated">';
        $html .= '<p>';
        $html .= __( 'Webmaster Tools activated... For real!', 'webmaster' );
        $html .= '</p>';
        $html .= '</div><!-- /.updated -->';
        echo $html;
        delete_transient( 'fx-admin-notice-example' );
    }
}

function webmaster_delete_all_posts() {
    $catalogposts = get_pages( array( 'post_type' => 'catalog_type'));
    if (!empty($catalogposts)) {
        foreach ( $catalogposts as $catalogpost ) {
            wp_delete_post( $catalogpost->ID, true); // true: Delete, false: Trash
        } 
    }
}

function webmaster_unregister_post_type() {
    unregister_post_type('catalog_type');
}

add_action('admin_init', 'webmaster_load_plugin');
