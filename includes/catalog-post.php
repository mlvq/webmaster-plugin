<?php
/* PHP Security */
defined('ABSPATH') || exit;

// Register Custom Post Type
function catalog_post_type() {

	$labels = array(
		'name'                  => _x( 'Products', 'Post Type General Name', 'webmaster' ),
		'singular_name'         => _x( 'Product Type', 'Post Type Singular Name', 'webmaster' ),
		'menu_name'             => __( 'Catalog', 'webmaster' ),
		'name_admin_bar'        => __( 'Catalog Product', 'webmaster' ),
		'archives'              => __( 'Item Archives', 'webmaster' ),
		'attributes'            => __( 'Item Attributes', 'webmaster' ),
		'parent_item_colon'     => __( 'Parent Item:', 'webmaster' ),
		'all_items'             => __( 'Show All Entries', 'webmaster' ),
		'add_new_item'          => __( 'Add New Item', 'webmaster' ),
		'add_new'               => __( 'Add New Entry', 'webmaster' ),
		'new_item'              => __( 'New Item', 'webmaster' ),
		'edit_item'             => __( 'Edit Item', 'webmaster' ),
		'update_item'           => __( 'Update Item', 'webmaster' ),
		'view_item'             => __( 'View Item', 'webmaster' ),
		'view_items'            => __( 'View Items', 'webmaster' ),
		'search_items'          => __( 'Search Item', 'webmaster' ),
		'not_found'             => __( 'Not found', 'webmaster' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'webmaster' ),
		'featured_image'        => __( 'Featured Image', 'webmaster' ),
		'set_featured_image'    => __( 'Set featured image', 'webmaster' ),
		'remove_featured_image' => __( 'Remove featured image', 'webmaster' ),
		'use_featured_image'    => __( 'Use as featured image', 'webmaster' ),
		'insert_into_item'      => __( 'Insert into item', 'webmaster' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'webmaster' ),
		'items_list'            => __( 'Items list', 'webmaster' ),
		'items_list_navigation' => __( 'Items list navigation', 'webmaster' ),
		'filter_items_list'     => __( 'Filter items list', 'webmaster' ),
	);
	$args = array(
		'label'                 => __( 'Catalog Product type', 'webmaster' ),
		'description'           => __( 'Catalog Product type description', 'webmaster' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail', 'revisions' ),
		'taxonomies'            => array( 'brand' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 60,
		'menu_icon'             => 'dashicons-category',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => true,
		'publicly_queryable'    => false,
		'capability_type'       => 'page',
		'show_in_rest'          => false,
	);
	register_post_type( 'catalog_type', $args );
}
add_action( 'init', 'catalog_post_type', 0 );

// Register Custom Taxonomy
function custom_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Brands', 'Taxonomy General Name', 'webmaster' ),
		'singular_name'              => _x( 'Brand', 'Taxonomy Singular Name', 'webmaster' ),
		'menu_name'                  => __( 'Edit Brands', 'webmaster' ),
		'all_items'                  => __( 'All Items', 'webmaster' ),
		'parent_item'                => __( 'Parent Item', 'webmaster' ),
		'parent_item_colon'          => __( 'Parent Item:', 'webmaster' ),
		'new_item_name'              => __( 'New Item Name', 'webmaster' ),
		'add_new_item'               => __( 'Add New Item', 'webmaster' ),
		'edit_item'                  => __( 'Edit Item', 'webmaster' ),
		'update_item'                => __( 'Update Item', 'webmaster' ),
		'view_item'                  => __( 'View Item', 'webmaster' ),
		'separate_items_with_commas' => __( 'Separate items with commas', 'webmaster' ),
		'add_or_remove_items'        => __( 'Add or remove items', 'webmaster' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'webmaster' ),
		'popular_items'              => __( 'Popular Items', 'webmaster' ),
		'search_items'               => __( 'Search Items', 'webmaster' ),
		'not_found'                  => __( 'Not Found', 'webmaster' ),
		'no_terms'                   => __( 'No items', 'webmaster' ),
		'items_list'                 => __( 'Items list', 'webmaster' ),
		'items_list_navigation'      => __( 'Items list navigation', 'webmaster' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => false,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
		'show_in_rest'               => false,
	);
	register_taxonomy( 'brand', array( 'catalog_type' ), $args );

}
add_action( 'init', 'custom_taxonomy', 0 );
