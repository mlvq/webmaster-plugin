<?php 
/* PHP Security */
defined('ABSPATH') || exit;
/* Make the single-catalog_type.php in the theme folder, if it doesn't exist */
function create_catalog_type() {
    $filename = '/single-catalog_type.php';
    $stylesheetdir = get_stylesheet_directory();
    $filecontent = '
<?php get_header(); ?>

<?php if ( have_posts() ) : ?>

  <?php the_title(); ?>

  <?php the_content(); ?>

<?php endif; ?>

<?php get_footer(); ?>
';
if (!file_exists($stylesheetdir . $filename)) {
    if (get_option('catalog_type_create') !== false) {
      update_option('catalog_type_create', 'yes');
    }
    else {
      add_option('catalog_type_create', 'yes');
    }
}
if (file_exists($stylesheetdir . $filename)) {
  if (get_option('webmaster_settings_themeview')) {
    echo '<script>alert("single-catalog_type.php has been created in the theme folder!");</script>';
    update_option('catalog_type_create', 'yes');
    update_option('webmaster_settings_themeview', false);
  }
}
if ((is_admin() && get_option('catalog_type_create') == 'yes')) {
    $catalog_file = fopen($stylesheetdir . $filename, 'w');
    fwrite($catalog_file, $filecontent);
    fclose($catalog_file);
    update_option('catalog_type_create', 'completed');
    return get_option('catalog_type_create');
    }
    else {
    return get_option('catalog_type_create');
    }
}

add_action('admin_init', 'create_catalog_type');
