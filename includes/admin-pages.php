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
}
    
function settings_page_cb() {
    $htmlcontent = "";
    $htmlcontent .= '<h2 class="wp-heading-inline">Settings</h2>';
    $htmlcontent .= '<div>';
    $htmlcontent .= '<p>';
    $htmlcontent .= __('No settings to adjust yet.');
    $htmlcontent .= '</p>';
    $htmlcontent .= '</div>';
    $htmlcontent .= '<div class="notice is-dismissible updated">';
    $htmlcontent .= '<p>';
    $htmlcontent .= __( 'Nothing to see here! Yet...', 'webmaster' );
    $htmlcontent .= '</p>';
    $htmlcontent .= '</div>';
    return $htmlcontent;
}
function default_page_cb() {
  $htmlcontent = "";
  $htmlcontent .= '<h2 class="wp-heading-inline">Welcome to Webmaster Tools plugin</h2>';
  $htmlcontent .= '<div class="content">';
  $htmlcontent .= '<p>';
  $htmlcontent .= __( 'This is the default page for editing settings in Webmaster Tools.', 'webmaster' );
  $htmlcontent .= '</p>';
  $htmlcontent .= '</div>';
  return $htmlcontent;
}
function woo_page_cb() {
  $htmlcontent = "";
  $htmlcontent .= '<h2 class="wp-heading-inline">WooCommerce</h2>';
  $htmlcontent .= '<div class="content">';
  $htmlcontent .= '<p>';
  $htmlcontent .= __( 'WooCommerce settings can be found here.', 'webmaster' );
  $htmlcontent .= '</p>';
  $htmlcontent .= '</div>';
  return $htmlcontent;
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
        <a href="edit.php?post_type=catalog_type&page=webmaster" class="nav-tab <?php if($tab===null):?>nav-tab-active<?php endif; ?>">Information</a>
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