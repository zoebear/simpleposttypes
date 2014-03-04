<?php
/**
 * Plugin Name: Morten's Simple Post Types 
 * Description: A simple plugin to add custom post types and taxonomies to a WordPress site. This plugin was created to demonstrate these principles and the principles of using GitHub and is not for general use. Do not expect it to work.
 * Version: 0.0.1
 * Author: Morten Rand-Hendriksen
 * Author URI: http://mor10.com
 * License: GPL2
 */

add_action('init', 'mortens_simple_post_types');

function mortens_simple_post_types() {
    
    // Set all the label names for the new post type
	$labels = array(
		'name'               => _x( 'Drawings', 'post type general name', 'simpleposttypes' ),
		'singular_name'      => _x( 'Drawing', 'post type singular name', 'simpleposttypes' ),
		'menu_name'          => _x( 'Drawings', 'admin menu', 'simpleposttypes' ),
		'name_admin_bar'     => _x( 'Drawing', 'add new on admin bar', 'simpleposttypes' ),
		'add_new'            => _x( 'Add New', 'drawing', 'simpleposttypes' ),
		'add_new_item'       => __( 'Add New Drawing', 'simpleposttypes' ),
		'new_item'           => __( 'New Drawing', 'simpleposttypes' ),
		'edit_item'          => __( 'Edit Drawing', 'simpleposttypes' ),
		'view_item'          => __( 'View Drawing', 'simpleposttypes' ),
		'all_items'          => __( 'All Drawings', 'simpleposttypes' ),
		'search_items'       => __( 'Search Drawings', 'simpleposttypes' ),
		'parent_item_colon'  => __( 'Parent Drawings:', 'simpleposttypes' ),
		'not_found'          => __( 'No drawings found.', 'simpleposttypes' ),
		'not_found_in_trash' => __( 'No drawings found in Trash.', 'simpleposttypes' ),
	);

    // Define all the settings for the new post type
	$args = array(
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'drawing' ),
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => 5,
        'taxonomies'         => array('category', 'post_tag'),
		'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'comments' )
	);

	register_post_type( 'drawing', $args );
    
} // End function mortens_simple_post_types()

// hook into the init action and call create_drawing_taxonomies when it fires
add_action( 'init', 'create_drawing_taxonomies', 0 );

// create two taxonomies, genres and writers for the post type "drawing"
function create_drawing_taxonomies() {
	// Add new taxonomy, make it hierarchical (like categories)
	$labels = array(
		'name'              => _x( 'Media', 'taxonomy general name' ),
		'singular_name'     => _x( 'Media', 'taxonomy singular name' ),
		'search_items'      => __( 'Search Media' ),
		'all_items'         => __( 'All Media' ),
		'parent_item'       => __( 'Parent Media' ),
		'parent_item_colon' => __( 'Parent Media:' ),
		'edit_item'         => __( 'Edit Media' ),
		'update_item'       => __( 'Update Media' ),
		'add_new_item'      => __( 'Add New Media' ),
		'new_item_name'     => __( 'New Media Name' ),
		'menu_name'         => __( 'Media' ),
	);

	$args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'media' ),
	);

	register_taxonomy( 'media', array( 'drawing' ), $args );

	// Add new taxonomy, NOT hierarchical (like tags)
	$labels = array(
		'name'                       => _x( 'Colours', 'taxonomy general name' ),
		'singular_name'              => _x( 'Colour', 'taxonomy singular name' ),
		'search_items'               => __( 'Search Colours' ),
		'popular_items'              => __( 'Popular Colours' ),
		'all_items'                  => __( 'All Colours' ),
		'parent_item'                => null,
		'parent_item_colon'          => null,
		'edit_item'                  => __( 'Edit Colour' ),
		'update_item'                => __( 'Update Colour' ),
		'add_new_item'               => __( 'Add New Colour' ),
		'new_item_name'              => __( 'New Colour Name' ),
		'separate_items_with_commas' => __( 'Separate colours with commas' ),
		'add_or_remove_items'        => __( 'Add or remove colours' ),
		'choose_from_most_used'      => __( 'Choose from the most used colours' ),
		'not_found'                  => __( 'No colours found.' ),
		'menu_name'                  => __( 'Colours' ),
	);

	$args = array(
		'hierarchical'          => false,
		'labels'                => $labels,
		'show_ui'               => true,
		'show_admin_column'     => true,
		'update_count_callback' => '_update_post_term_count',
		'query_var'             => true,
		'rewrite'               => array( 'slug' => 'colour' ),
	);

	register_taxonomy( 'colour', 'drawing', $args );
}


// Flush rewrite rules
function my_rewrite_flush() {
    // First, we "add" the custom post type via the above written function.
    // Note: "add" is written with quotes, as CPTs don't get added to the DB,
    // They are only referenced in the post_type column with a post entry, 
    // when you add a post of this CPT.
    mortens_simple_post_types();
    create_drawing_taxonomies();

    // ATTENTION: This is *only* done during plugin activation hook in this example!
    // You should *NEVER EVER* do this on every page load!!
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'my_rewrite_flush' );

?>