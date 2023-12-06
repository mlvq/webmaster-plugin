<?php
/* PHP Security */
defined('ABSPATH') || exit;
// Credits: 
// https://artisansweb.net/add-image-field-taxonomy-wordpress/
// https://en.bainternet.info/wordpress-taxonomies-extra-fields-the-easy-way/

function taxonomy_add_custom_field() {
    ?>
    <div class="form-field term-image-wrap">
        <label for="brand-image"><?php _e( 'Image' ); ?></label>
        <p><a href="#" class="aw_upload_image_button button button-secondary"><?php _e('Upload Image'); ?></a></p>
        <input type="text" name="brand_image" id="brand-image" value="" size="40" />
    </div>
    <?php
}
add_action( 'brand_add_form_fields', 'taxonomy_add_custom_field', 10, 2 );

function taxonomy_edit_custom_field($term) {
    $image = get_term_meta($term->term_id, 'brand_image', true);
    ?>
    <tr class="form-field term-image-wrap">
        <th scope="row"><label for="brand_image"><?php _e( 'Image' ); ?></label></th>
        <td>
            <div class="preview-image">
            <?php
            if (!empty($image)) {
                _e('<img class="img-fluid img-thumbnail" id="preview-image" src="');
                _e($image);
                _e('"/>');
            }
            else {
                _e ('<p>Select an image and update.</p>');
            }
            ?>
            </div>
            <input type="text" name="brand_image" id="brand-image" placeholder="You can use external URLs." value="<?php echo $image; ?>" size="40" />
            <p class="description" id="description-brand-image">Upload or select an image from the media gallery.</p>
            <input type="submit" name="select-image-button" class="aw_upload_image_button button button-secondary" value="Select image" />
        </td>
    </tr>

    <?php
}
add_action( 'brand_edit_form_fields', 'taxonomy_edit_custom_field', 10, 2 );

function save_taxonomy_custom_meta_field( $term_id ) {
    if ( isset( $_POST['brand_image'] ) ) {
        update_term_meta($term_id, 'brand_image', $_POST['brand_image']);
    }
}  
add_action( 'edited_brand', 'save_taxonomy_custom_meta_field', 10, 2 );  
add_action( 'create_brand', 'save_taxonomy_custom_meta_field', 10, 2 );

function aw_include_script() {
 
    if ( ! did_action( 'wp_enqueue_media' ) ) {
        wp_enqueue_media();
    }
 
    wp_enqueue_script( 'taxonomy-settings', plugin_dir_url(__DIR__) . 'assets/js/taxonomy-settings.js', array('jquery'), null, false );
    wp_enqueue_style( 'taxonomy-settings', plugin_dir_url(__DIR__) . 'assets/css/taxonomy-settings.css', array(), null, false );
}
add_action( 'admin_enqueue_scripts', 'aw_include_script' );