<?php
/* PHP Security */
defined('ABSPATH') || exit;

/* Settings menu */
function load_submenu() {
    global $submenu;
    $menu_slug = "webmaster";
    add_submenu_page(
    'edit.php?post_type=catalog_type', //parent_slug
    'Webmaster Tools', // page_title
    'Settings', // menu_title
    'manage_options', // capability
    $menu_slug,
    'admin_page_html');
/*
* Create shortcuts in admin menu
*/
    // $submenu['edit.php?post_type=catalog_type'][] = array(
    //   'Edit Catalog View',
    //   'manage_options',
    //   catalog_editor_url()
    // );
}
function catalog_editor_url() {
    $my_theme_url = get_site_url() .'/wp-admin/theme-editor.php?file=single-catalog_type.php&theme=' . wp_get_theme()->get_stylesheet();
    return $my_theme_url;
}

function settings_page_cb() {
    _e ('<form method="POST" action="options.php">');
    settings_fields('edit.php?post_type=catalog_type&page=webmaster&tab=settings'); // pass slug name of page, also referred to in Settings API as option group name
    do_settings_sections('edit.php?post_type=catalog_type&page=webmaster&tab=settings');  // pass slug name of page
    submit_button(); // submit button
    _e ('</form>');
    return;
}

function default_page_cb() {
    $htmlcontent = "";
    $htmlcontent .= '<h2 class="wp-heading-inline">Welcome to Webmaster Tools plugin</h2>';
    $htmlcontent .= '<div class="content">';
    $htmlcontent .= '<p>';
    $htmlcontent .= __( 'This page is for ease of access, debugging and editing plugin settings.', 'webmaster' );
    $htmlcontent .= '<pre title="get_option(catalog_type_create)">' . get_option('catalog_type_create') . '</pre>';
    $htmlcontent .= '<pre title="get_option(webmaster_settings_name)">' . get_option('webmaster_settings_name') . '</pre>';
    $htmlcontent .= '<pre title="get_option(webmaster_settings_themeview)">' . get_option('webmaster_settings_themeview') . '</pre>';
    $htmlcontent .= '<pre title="single-catalog_type.php">Edit the catalog view in theme editor</pre>' . '<a href="' . catalog_editor_url() . '">single-catalog_type.php</a>';
    $htmlcontent .= '<pre title="wp_get_theme()->get_stylesheet()">' . wp_get_theme()->get_stylesheet() . '</pre>';
    $htmlcontent .= '<pre title="get_site_url()">' . get_site_url() . '</pre>';
    $htmlcontent .= '</p>';
    $htmlcontent .= '</div>';
    return $htmlcontent;
}
function woo_page_cb() {
    if (class_exists('woocommerce')) {
      _e ('<form method="POST" action="options.php">');
      settings_fields('edit.php?post_type=catalog_type&page=webmaster&tab=woocommerce');
      do_settings_sections('edit.php?post_type=catalog_type&page=webmaster&tab=woocommerce');
      submit_button();
      _e ('</form>');
      return;
    }
    else {
      return $woohtmlcontent = '<pre>WooCommerce is not active.</pre><br /><a href="plugins.php">Please enable WooCommerce under plugins.</a>';
    }
}

function admin_page_html() {
    // check user capabilities
    if ( ! current_user_can( 'manage_options' ) ) {
      return;
    }
  
    //Get the active tab from the $_GET param
    $default_tab = null;
    $tab = isset($_GET['tab']) ? $_GET['tab'] : $default_tab;
  
    ?>
    <!-- Our admin page content should all be inside .wrap -->
    <div class="wrap">
      <!-- Print the page title -->
      <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
      <!-- Here are our tabs -->
      <nav class="nav-tab-wrapper">
        <a href="edit.php?post_type=catalog_type&page=webmaster" class="nav-tab <?php if($tab===null):?>nav-tab-active<?php endif; ?>">Debug</a>
        <a href="edit.php?post_type=catalog_type&page=webmaster&tab=settings" class="nav-tab <?php if($tab==='settings'):?>nav-tab-active<?php endif; ?>">Settings</a>
        <a href="edit.php?post_type=catalog_type&page=webmaster&tab=woocommerce" class="nav-tab <?php if($tab==='woocommerce'):?>nav-tab-active<?php endif; ?>">WooCommerce</a>
      </nav>
  
      <div class="tab-content">
      <?php switch($tab) :
        case 'settings':
          _e (settings_page_cb()); //Put your HTML here
          break;
        case 'woocommerce':
          _e (woo_page_cb());
          break;
        default:
          _e (default_page_cb());
          break;
      endswitch; ?>
      </div>
    </div>
    <?php
}
/**
 * Settings tab, sections and options
 */
function webmaster_settings_init() {
 	// Add the section to settings
 	add_settings_section(
		'webmaster_settings_section',
		'Settings',
		'webmaster_setting_section_cb',
		'edit.php?post_type=catalog_type&page=webmaster&tab=settings'
	);

 	add_settings_field(
		'webmaster_settings_themeview',
		'Register with theme',
		'webmaster_settings_cb',
		'edit.php?post_type=catalog_type&page=webmaster&tab=settings',
		'webmaster_settings_section'
	);
 	
 	register_setting('edit.php?post_type=catalog_type&page=webmaster&tab=settings', 'webmaster_settings_themeview');
 }
 
 add_action('admin_init', 'webmaster_settings_init');

 function webmaster_setting_section_cb() {
 	echo '<p>Settings section. Read settings throughly before applying.</p>';
 }
 
 function webmaster_settings_cb() {
 	echo '<input name="webmaster_settings_themeview" id="webmaster_settings_themeview" title="Deletes any previous versions" type="checkbox" value="1" class="code" ' . checked( 1, get_option( 'webmaster_settings_themeview' ), false ) . ' /> <label title="Deletes any previous versions" for="webmaster_settings_themeview">Recreate single-catalog_type.php</label>';
 }

 /**
 * WooCommerce settings tab, sections and options
 */
function webmaster_settings_woo_init() {
  add_settings_section(
   'webmaster_settings_woo_section',
   'WooCommerce settings',
   'webmaster_settings_woo_section_cb',
   'edit.php?post_type=catalog_type&page=webmaster&tab=woocommerce'
 );

  add_settings_field(
   'webmaster_settings_hideuncat',
   'Hide uncategorized (default product category) from shop pages and widgets',
   'webmaster_settings_woo_cb',
   'edit.php?post_type=catalog_type&page=webmaster&tab=woocommerce',
   'webmaster_settings_woo_section'
 );
  add_settings_field(
    'webmaster_settings_hide_reviews',
    'Hide reviews from products',
    'webmaster_settings_woo_hide_cb',
    'edit.php?post_type=catalog_type&page=webmaster&tab=woocommerce',
    'webmaster_settings_woo_section'
  );
  add_settings_field(
    'webmaster_settings_show_oos_last',
    'Show out of stock products last',
    'webmaster_settings_woo_show_oos_last_cb',
    'edit.php?post_type=catalog_type&page=webmaster&tab=woocommerce',
    'webmaster_settings_woo_section'
  );
  add_settings_field(
    'webmaster_settings_404_display_featured',
    'Show featured products instead of 404 page',
    'webmaster_settings_woo_404_display_featured_cb',
    'edit.php?post_type=catalog_type&page=webmaster&tab=woocommerce',
    'webmaster_settings_woo_section'
  );
  add_settings_field(
    'webmaster_settings_disable_analytics',
    'Disable analytics in WooCommerce',
    'webmaster_settings_woo_disable_analytics_cb',
    'edit.php?post_type=catalog_type&page=webmaster&tab=woocommerce',
    'webmaster_settings_woo_section'
  );
  
  register_setting('edit.php?post_type=catalog_type&page=webmaster&tab=woocommerce', 'webmaster_settings_hideuncat');
  register_setting('edit.php?post_type=catalog_type&page=webmaster&tab=woocommerce', 'webmaster_settings_hide_reviews');
  register_setting('edit.php?post_type=catalog_type&page=webmaster&tab=woocommerce', 'webmaster_settings_show_oos_last');
  register_setting('edit.php?post_type=catalog_type&page=webmaster&tab=woocommerce', 'webmaster_settings_404_display_featured');
  register_setting('edit.php?post_type=catalog_type&page=webmaster&tab=woocommerce', 'webmaster_settings_disable_analytics');

}

add_action('admin_init', 'webmaster_settings_woo_init');

function webmaster_settings_woo_section_cb() {
  echo '<p>WooCommerce settings section.</p>';
}

function webmaster_settings_woo_cb() {
  echo '<input name="webmaster_settings_hideuncat" id="webmaster_settings_hideuncat" title="Hides default product category from shop pages and widgets" type="checkbox" value="1" class="code" ' . checked( 1, get_option( 'webmaster_settings_hideuncat' ), false ) . ' /> <label title="Hides default product category from shop pages and widgets" for="webmaster_settings_hideuncat">Enable</label>';
}
function webmaster_settings_woo_hide_cb() {
  echo '<input name="webmaster_settings_hide_reviews" id="webmaster_settings_hide_reviews" title="Hides reviews from products" type="checkbox" value="1" class="code" ' . checked( 1, get_option( 'webmaster_settings_hide_reviews' ), false ) . ' /> <label title="Hides reviews from products" for="webmaster_settings_hide_reviews">Enable</label>';
}
function webmaster_settings_woo_show_oos_last_cb() {
  echo '<input name="webmaster_settings_show_oos_last" id="webmaster_settings_show_oos_last" title="Show out of stock products last" type="checkbox" value="1" class="code" ' . checked( 1, get_option( 'webmaster_settings_show_oos_last' ), false ) . ' /> <label title="Show out of stock products last" for="webmaster_settings_show_oos_last">Enable</label>';
}
function webmaster_settings_woo_404_display_featured_cb() {
  echo '<input name="webmaster_settings_404_display_featured" id="webmaster_settings_404_display_featured" title="Show featured products instead of 404 page" type="checkbox" value="1" class="code" ' . checked( 1, get_option( 'webmaster_settings_404_display_featured' ), false ) . ' /> <label title="Show featured products instead of 404 page" for="webmaster_settings_404_display_featured">Enable</label>';
}
function webmaster_settings_woo_disable_analytics_cb() {
  echo '<input name="webmaster_settings_disable_analytics" id="webmaster_settings_disable_analytics" title="Disable analytics in WooCommerce" type="checkbox" value="1" class="code" ' . checked( 1, get_option( 'webmaster_settings_disable_analytics' ), false ) . ' /> <label title="Disable analytics in WooCommerce" for="webmaster_settings_disable_analytics">Enable</label>';
}
/* Handle options with filters and actions */
add_filter( 'woocommerce_product_subcategories_args', 'hide_uncategorized_cat_from_shop_page' );
add_filter( 'woocommerce_product_categories_widget_args', 'hide_uncategorized_cat_from_widget' );
add_filter( 'woocommerce_product_tabs', 'remove_review_tab', 98 );
add_action( 'woocommerce_product_query', 'out_of_stock_last', 999 );
add_action( 'woocommerce_no_products_found', 'featured_products_on_not_found', 20 );
add_filter( 'woocommerce_admin_disabled', settings_disable_analytics() );
/* Handle user-settings */
function hide_uncategorized_cat_from_shop_page( $args ) {
  if (get_option('webmaster_settings_hideuncat')) {
  $args['exclude'] = get_option( 'default_product_cat' );
  }
  return $args;
}
function hide_uncategorized_cat_from_widget( $args ) {
  if (get_option('webmaster_settings_hideuncat')) {
    $args['exclude'] = get_option( 'default_product_cat' );
  }
  return $args;
}
function remove_review_tab( $tabs ) {
  if (get_option('webmaster_settings_hide_reviews') && !is_user_logged_in()) {
    unset( $tabs['reviews'] );
  }
  return $tabs;
}
function out_of_stock_last( $query ) {
  if (get_option('webmaster_settings_show_oos_last')) {
    if ( is_admin() ) return;
    $query->set( 'meta_key', '_stock_status' );
    $query->set( 'orderby', array( 'meta_value' => 'ASC' ) );
  }
}
function featured_products_on_not_found() {
    if (get_option('webmaster_settings_404_display_featured')) {
    echo '<h4>' . __( 'Sorry! 404: Not Found!', 'webmaster-plugin' ) . '</h4>';
    echo do_shortcode( '[products limit="4" visibility="featured"]' );
  }
}
function settings_disable_analytics() {
  if (get_option('webmaster_settings_disable_analytics')) {
    return '__return_true';
  }
  return '__return_null';
}