<?php
/**
 * Plugin Name: Morten's Other Post Types 
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

// Flush rewrite rules
function my_rewrite_flush() {
    // First, we "add" the custom post type via the above written function.
    // Note: "add" is written with quotes, as CPTs don't get added to the DB,
    // They are only referenced in the post_type column with a post entry, 
    // when you add a post of this CPT.
    mortens_simple_post_types();

    // ATTENTION: This is *only* done during plugin activation hook in this example!
    // You should *NEVER EVER* do this on every page load!!
    flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'my_rewrite_flush' );

?>